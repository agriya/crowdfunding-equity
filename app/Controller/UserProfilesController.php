<?php
/**
 * CrowdFunding
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Crowdfunding
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $uses = array(
        'UserProfile',
        'Attachment',
        'EmailTemplate'
    );
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'admin' => array(
            'edit',
        )
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id',
            'UserProfile.country_id',
            'User.latitude',
            'User.longitude',
            'State.name',
            'City.name',
            'UserWebsite',
            's3_file_url'
        );
        
        if($this->RequestHandler->prefers('json'))
        {
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
    public function edit($user_id = null)
    {
        if ($this->RequestHandler->prefers('json') && $this->request->is('post')) {
            $this->request->data['City']['name'] = $this->request->data['city'];
            $this->request->data['State']['name'] = $this->request->data['state'];
            $this->request->data['UserProfile'] = $this->request->data;  
        }
        
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Profile'));
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            unset($this->UserProfile->validate['country_id']);
            unset($this->UserProfile->City->validate['name']);
            unset($this->UserProfile->State->validate['name']);
            unset($this->UserProfile->validate['gender_id']);
            unset($this->UserProfile->validate['dob']);
        }
        if (!empty($this->request->data['UserProfile'])) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile',
                    'UserAvatar',
                    'UserWebsite'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            // validating UserWebsite data
            $is_website_valid = true;
            if(!empty($this->request->data['UserWebsite'])) {
                $this->UserProfile->User->UserWebsite->deleteAll(array(
                    'UserWebsite.user_id' => $this->request->data['User']['id']
                ));
                foreach($this->request->data['UserWebsite'] as $key => $userWebsite) {
                    $data['UserWebsite']['website'] = $userWebsite['website'];
                    $this->UserProfile->User->UserWebsite->set($data);
                    if (!$this->UserProfile->User->UserWebsite->validates()) {
                        $UserWebsiteValidationError[$key] = $this->UserProfile->User->UserWebsite->validationErrors;
                        $is_website_valid = false;
                        $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('User Website')) , 'default', null, 'error');
                    }
                }
                $this->UserProfile->User->UserWebsite->validationErrors = array();
                if (!empty($UserWebsiteValidationError)) {
                    foreach($UserWebsiteValidationError as $key => $error) {
                        $this->UserProfile->User->UserWebsite->validationErrors[$key] = $error;
                    }
                }
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
			if (!empty($this->request->data['UserProfile']['address']) || !empty($this->request->data['UserProfile']['country_id']) || !empty($this->request->data['State']['name'])|| (!empty($this->request->data['City']['name']))) {
				$this->UserProfile->State->set($this->request->data);
				$this->UserProfile->City->set($this->request->data);
			}else {
				unset($this->UserProfile->City->validate['name']);
				unset($this->UserProfile->State->validate['name']);
				unset($this->UserProfile->validate['country_id']);
			}
			if (!empty($this->request->data['UserProfile']['country_id'])) {
                $this->request->data['UserProfile']['Country']['iso_alpha2'] = $this->request->data['UserProfile']['country_id'];
            }
            $ini_upload_error = 1;
            if ((!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1)) {
                $ini_upload_error = 0;
            }
			$response1 = Cms::dispatchEvent('Controller.UserProfile.beforeUpdateValidation', $this, array(
			 'data' => $this->request->data
			));
			$is_error_from_plugin = 1;
			if(!empty($response1->data['error'])) {
				$is_error_from_plugin = 0;
			}
            if ($this->UserProfile->User->validates() &$this->UserProfile->validates() &$this->UserProfile->User->UserAvatar->validates() &$this->UserProfile->City->validates() &$this->UserProfile->State->validates() & $is_error_from_plugin && $ini_upload_error && $is_website_valid) {
                if (!empty($this->request->data['UserProfile']['country_id'])) {
                    $this->request->data['UserProfile']['country_id'] = $this->UserProfile->Country->findCountryId($this->request->data['UserProfile']['country_id']);
                }
                $this->request->data['State']['country_id'] = $this->request->data['UserProfile']['country_id'];
                $state_id = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->UserProfile->State->findOrSaveAndGetIdWithArray($this->request->data['State']['name'], $this->request->data['State']);
                $this->request->data['UserProfile']['state_id'] = !empty($state_id) ? $state_id : 0;
                $this->request->data['City']['state_id'] = $this->request->data['UserProfile']['state_id'];
                $this->request->data['City']['country_id'] = $this->request->data['UserProfile']['country_id'];
                $city_id = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->UserProfile->City->findOrSaveAndGetIdWithArray($this->request->data['City']['name'], $this->request->data['City']);
                $this->request->data['UserProfile']['city_id'] = !empty($city_id) ? $city_id : 0;
				if ($this->UserProfile->save($this->request->data)) {
					if(!empty($this->request->data['UserProfile']['language_id'])){
						$language = $this->UserProfile->Language->find('first', array(
							'conditions' => array(
								'Language.is_active' => 1,
								'Language.id' => $this->request->data['UserProfile']['language_id'],
							)
						));
						@unlink(WWW_ROOT . 'index.html');
						$this->Cookie->write('user_language', $language['Language']['iso2'], false);
					}
                    $this->UserProfile->User->save($this->request->data);
                    Cms::dispatchEvent('Controller.Users.redirectToJobAct', $this, array(
                        'data' => $this->request->data
                    ));
                    $this->UserProfile->User->UserWebsite->deleteAll(array(
                        'UserWebsite.user_id' => $this->request->data['User']['id']
                    ));
                    if (!empty($this->request->data['UserWebsite'])) {
                        foreach($this->request->data['UserWebsite'] as $userWebsite) {
                            if (!empty($userWebsite['website'])) {
                                $data['UserWebsite']['user_id'] = $this->request->data['User']['id'];
                                $data['UserWebsite']['website'] = $userWebsite['website'];
                                $this->UserProfile->User->UserWebsite->create();
                                $this->UserProfile->User->UserWebsite->save($data);
                            }
                        }
                    }
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
                }
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    // Send mail to user to activate the account and send account details
                    $emailFindReplace = array(
                        '##USERNAME##' => $user['User']['username'],
					);
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate('Admin User Edit');
                    $this->UserProfile->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                }
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'UserProfile',
                        'action' => 'Updated',
                        'label' => $this->Auth->user('username') ,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $this->set('iphone_response', array("message" =>__l('User Profile has been updated') , "error" => 0));
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('User Profile')) , 'default', null, 'success');
                if (!$this->RequestHandler->prefers('json')) {
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit',
                        $this->request->data['User']['id']
                    ));
                }
            } else {
                if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->set('iphone_response', array("message" =>sprintf(__l('%s could not be updated. Please, try again.') , __l('User Profile')) , "error" => 1));
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('User Profile')) , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            } else {
                $user_id = $user_id ? $user_id : $this->Auth->user('id');
            }
            $user = $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar',
                    'UserWebsite' => array(
                        'fields' => array(
                            'UserWebsite.id',
                            'UserWebsite.website'
                        )
                    ) ,
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.iso_alpha2'
                            )
                        ) ,
                    )
                ) ,
                'recursive' => 2
            ));
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
                $this->request->data['UserProfile']['city'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
                $this->request->data['UserProfile']['state'] = $this->request->data['UserProfile']['State']['name'];
            }
            if (!empty($this->request->data['UserProfile']['Country']['iso_alpha2'])) {
                $this->request->data['UserProfile']['country_id'] = $this->request->data['UserProfile']['Country']['iso_alpha2'];
            }
			if(empty($this->request->data['UserProfile']['address'])){
				unset($this->UserProfile->City->validate['name']);
				unset($this->UserProfile->State->validate['name']);
				unset($this->UserProfile->validate['country_id']);
			}
			
            
        }
		if (isPluginEnabled('SecurityQuestions')) {
			$this->loadModel('SecurityQuestions.SecurityQuestion');
			$securityQuestions = $this->SecurityQuestion->find('list', array(
				'conditions' => array(
					'SecurityQuestion.is_active' => 1
				)
			));
			$this->set(compact('securityQuestions'));
		}        
        $this->set('user', $user);
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        //$genders = $this->UserProfile->genderOptions;
        $genders = $this->UserProfile->Gender->find('list');
        //$countries = $this->UserProfile->Country->find('list');
        $countries = $this->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $translantions = array();
        $translantions = $this->UserProfile->Language->Translation->find('all', array(
            'fields' => array(
                'DISTINCT Translation.language_id',
            ) ,
            'recursive' => -1,
        ));
        $translantion_id = array();
        foreach($translantions as $translantion) {
            $translantion_id[] = $translantion['Translation']['language_id'];
        }
        $languages = $this->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1,
                'Language.id' => $translantion_id,
            )
        ));
        $this->set(compact('genders', 'countries', 'languages'));
        
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.UserProfile.Edit', $this);
        }
    }
    public function profile_image($user_id = null)
    {
		if (!isPluginEnabled('SocialMarketing')) {
			throw new NotFoundException(__l('Invalid request'));
		}
        $this->pageTitle = sprintf(__l('%s Image') , __l('Profile'));
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || !empty($this->request->data['s3_file_url']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->User->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1 && empty($this->request->data['s3_file_url'])) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() && $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                $this->UserProfile->User->save($this->request->data['User']);
                if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                    $this->Attachment->create();
                    $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                    $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                    $this->Attachment->save($this->request->data['UserAvatar']);
                }
                $this->set('iphone_response', array("message" =>sprintf(__l('%s has been updated') , __l('Profile Image')) , "error" => 0));
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Profile Image')) , 'default', null, 'success');
                if (!$this->RequestHandler->prefers('json')) {
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'profile_image',
                        $this->request->data['User']['id']
                    ));
                }
            } else {
                if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->set('iphone_response', array("message" => sprintf(__l('%s could not be updated. Please, try again.'), __l('Profile Image')), "error" => 1));
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Profile Image')) , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            } else {
                $user_id = $user_id ? $user_id : $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.UserProfile.ProfileImage', $this, array());
        }
    }
    public function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
    public function masterlist()
    {
        $userEducations = $this->UserProfile->Education->find('list', array(
            'conditions' => array(
                    'Education.is_active' => 1
            ),
            'fields' => array(
                    'Education.education'
            ),
            'recursive' => -1,
        ));
        
        $userEmployments = $this->UserProfile->Employment->find('list', array(
            'conditions' => array(
                'Employment.is_active' => 1
            ),
            'fields' => array(
                'Employment.employment'
            ),
            'recursive' => -1,
        ));
        
        $userIncomeRanges = $this->UserProfile->IncomeRange->find('list', array(
            'conditions' => array(
                'IncomeRange.is_active' => 1
            ),
            'fields' => array(
                'IncomeRange.income'
             ),
            'recursive' => -1,
        ));
        
        $countries = $this->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            ),
            'recursive' => -1,
        ));
        
        $languages = $this->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            ),
            'recursive' => -1,
        ));
        
        $masterlist = array();
        foreach($userEducations as $k=>$val){
           $masterlist['Education']['id'][]=$k;
           $masterlist['Education']['value'][] =$val;
        }
        foreach($userEmployments as $k=>$val){
           $masterlist['EmploymentStatus']['id'][] =$k;
           $masterlist['EmploymentStatus']['value'][] =$val;
        }
        foreach($userIncomeRanges as $k=>$val){
           $masterlist['IncomeRange']['id'][] =$k;
           $masterlist['IncomeRange']['value'][] =$val;
        }
        foreach($countries as $k=>$val){
           $masterlist['Countries']['id'][] =$k;
           $masterlist['Countries']['value'][] =$val;
        }
        foreach($languages as $k=>$val){
           $masterlist['Languages']['id'][] =$k;
           $masterlist['Languages']['value'][] =$val;
        }
        
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.UserProfile.masterList', $this, array('master_list' => $masterlist));
        }
    }
}
?>