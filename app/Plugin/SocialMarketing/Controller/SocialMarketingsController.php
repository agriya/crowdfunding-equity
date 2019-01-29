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
class SocialMarketingsController extends AppController
{
    public $name = 'SocialMarketings';
    public $components = array(
        'RequestHandler'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'publish',
            'import_friends',
        ) ,
    );
    public function import_friends()
    {
        $this->pageTitle = __l('Find Friends');
        $this->loadModel('User');
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.fb_secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('twitter.consumer_key') ,
                        'secret' => Configure::read('twitter.consumer_secret')
                    ) ,
                ) ,
                'Google' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('google.consumer_key') ,
                        'secret' => Configure::read('google.consumer_secret')
                    ) ,
                ) ,
                'GooglePlus' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'AngelList' => array(
                    'enabled' => Configure::read('angellist.is_enabled_angellist_connect') ,
                    'keys' => array(
                        'id' => Configure::read('angellist.client_id') ,
                        'secret' => Configure::read('angellist.client_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Linkedin' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if ($this->request->params['named']['type'] == 'facebook') {
            $this->pageTitle.= ' - Facebook';
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $this->pageTitle.= ' - Twitter';
            $next_action = 'gmail';
            $this->User->updateAll(array(
                'User.is_skipped_fb' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'gmail') {
            $this->pageTitle.= ' - Gmail';
            $next_action = 'yahoo';
            $this->User->updateAll(array(
                'User.is_skipped_twitter' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'yahoo') {
            $this->pageTitle.= ' - Yahoo!';
            $this->User->updateAll(array(
                'User.is_skipped_google' => 1,
                'User.is_skipped_yahoo' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        }
        if (!empty($this->request->params['named']['import'])) {
            $options = array();
            if ($this->request->params['named']['import'] == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                if (!empty($this->request->params['named']['redirecting'])) {
                    $adapter = $hybridauth->authenticate(ucfirst($this->request->params['named']['import']) , $options);
                    $loggedin_contact = $social_profile = $adapter->getUserProfile();
                    $is_correct_user = $this->User->_checkConnection($social_profile, $this->request->params['named']['import']);
                    if ($is_correct_user) {
                        $this->User->updateSocialContact($social_profile, $this->request->params['named']['import']);
                        $social_contacts = $adapter->getUserContacts();
                        array_push($social_contacts);
                        $this->SocialMarketing->import_contacts($social_contacts, $this->request->params['named']['import']);
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'social') {
                            $this->Session->setFlash(sprintf(__l('You have connected %s successfully!') , $this->request->params['named']['import']) , 'default', null, 'success');
                        } elseif (empty($this->request->params['named']['from'])) {
                            $this->Session->setFlash(sprintf(__l('Your %s contact has been imported successfully!.') , $this->request->params['named']['import']) , 'default', null, 'success');
                        }
                        echo '<script>window.close();</script>';
                        exit;
                    } else {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $this->Session->setFlash(__l('This social network account already connected by other user.') , 'default', null, 'error');
                        echo '<script>window.close();</script>';
                        exit;
                    }
                } else {
                    $reditect = Router::url(array(
                        'controller' => 'social_marketings',
                        'action' => 'import_friends',
                        'type' => $this->request->params['named']['type'],
                        'import' => $this->request->params['named']['import'],
                        'redirecting' => $this->request->params['named']['import'],
                        'from' => !empty($this->request->params['named']['from']) ? $this->request->params['named']['from'] : '',
                    ) , true);
                    $this->layout = 'redirection';
                    $this->set('redirect_url', $reditect);
                    $this->set('authorize_name', ucfirst($this->request->params['named']['import']));
                    $this->render('authorize');
                }
            }
            catch(Exception $e) {
                $error = "";
                switch ($e->getCode()) {
                    case 6:
                        $error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        break;

                    case 7:
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $error = __l("User not connected to the provider.");
                        break;

                    default:
                        $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection");
                        break;
                }
                $this->Session->setFlash($error, 'default', null, 'error');
                echo '<script>window.close();</script>';
                exit;
            }
        }
        $this->set(compact('next_action'));
    }
    public function publish($id = null)
    {
        $this->loadModel('Projects.Project');
        $this->loadModel('User');
        if (empty($id) || empty($this->request->params['named']['type']) || empty($this->request->params['named']['publish_action'])) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
        if ($this->request->params['named']['publish_action'] == 'add') {
            $condition['Project.id'] = $id;
            $project = $this->Project->find('first', array(
                'conditions' => $condition,
                'contain' => array(
                    'ProjectType',
                    'Attachment',
                    'User',
                ) ,
                'recursive' => 0
            ));
            if(!empty($project['Project']['is_draft'])){
            	$this->Session->setFlash(sprintf(__l('You cannot share this %s.'), Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'error');
            	$this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
           		 ));
            }
            $project['Project']['information'] = $project['Project']['name'];
            $page_title = $this->Auth->user('username') . ' ' . __l('posted') . ' ';
        } elseif ($this->request->params['named']['publish_action'] == 'fund') {
            $condition['ProjectFund.id'] = $id;
            $projectFund = $this->Project->ProjectFund->find('first', array(
                'conditions' => $condition,
                'contain' => array(
                    'Project' => array(
                        'ProjectType',
                        'Attachment',
                    ) ,
                    'User',
                ) ,
                'recursive' => 2
            ));
            $project_type = Configure::read('project.alt_name_for_' . $projectFund['Project']['ProjectType']['slug'] . '_past_tense_small');
            $user_name = $projectFund['User']['username'];
            if (in_array($projectFund['ProjectFund']['is_anonymous'], array(
                ConstAnonymous::Username,
                ConstAnonymous::Both
            ))) {
                $user_name = __l('Anonymous');
            }
            if ($projectFund['User']['id'] == $this->Auth->user('id')) {
                $user_name = $this->Auth->user('username');
            }
            $page_title = $user_name . ' ' . $project_type . ' ';
            $project['Project'] = $projectFund['Project'];
            $project['ProjectType'] = $projectFund['Project']['ProjectType'];
            $project['Project']['information'] = $page_title . ' ' . $project['Project']['name'];
            $project['Attachment'] = $projectFund['Project']['Attachment'];
        } elseif ($this->request->params['named']['publish_action'] == 'follow') {
            $condition['ProjectFollower.id'] = $id;
            $projectFollower = $this->Project->ProjectFollower->find('first', array(
                'conditions' => $condition,
                'contain' => array(
                    'Project' => array(
                        'Attachment',
                        'ProjectType'
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $projectFollower['ProjectFollower']['user_id']
                ) ,
                'fields' => array(
                    'User.username',
                ) ,
                'recursive' => -1
            ));
            $project['Project'] = $projectFollower['Project'];
            $project['ProjectType'] = $projectFollower['Project']['ProjectType'];
            $project['Attachment'] = $projectFollower['Project']['Attachment'];
            $page_title = $user['User']['username'] . ' ' . __l('followed') . ' ';
            $project['Project']['information'] = $page_title . ' ' . $project['Project']['name'];
        }
		$projectTypeName = ucwords($project['ProjectType']['name']);
		App::import('Model', $projectTypeName.'.'.$projectTypeName);
		$model = new $projectTypeName();
	    $response = $model->isAllowToPublish($project['Project']['id']);
        if (empty($response['is_allow_to_publish'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $image_options = array(
            'dimension' => 'big_thumb',
            'class' => '',
            'alt' => $project['Project']['name'],
            'title' => $project['Project']['name'],
            'type' => 'png',
            'full_url' => true
        );
        $project_image = getImageUrl('Project', $project['Attachment'], $image_options);
        $project_url = Router::url(array(
            'controller' => 'projects',
            'action' => 'view',
            $project['Project']['slug'],
        ) , true);
        if ($this->request->params['named']['type'] == 'facebook') {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $next_action = 'others';
        } elseif ($this->request->params['named']['type'] == 'others') {
            $next_action = 'promote';
        }
        $this->pageTitle = $page_title . $project['Project']['name'] . ' - ' . __l('Share');
        $this->set(compact('project_image', 'project_url', 'project', 'next_action', 'id'));
    }
    public function publish_success($current_page, $id, $action)
    {
        $this->set(compact('current_page', 'id', 'action'));
        $this->layout = 'ajax';
    }
    public function myconnections($social_type = null)
    {
        $this->pageTitle = __l('Social');
        if (!empty($social_type)) {
            $this->loadModel('User');
            $__data = array();
            $_data['User']['id'] = $this->Auth->user('id');
            $_data['User']['is_' . $social_type . '_connected'] = 0;
            $_data['User']['user_avatar_source_id'] = 0;
            $this->User->save($_data);
            $this->Session->setFlash(sprintf(__l('You have disconnected from %s') , $social_type) , 'default', null, 'success');
			$this->redirect(array(
				'controller' => 'social_marketings',
				'action' => 'myconnections',
			));
        }
    }
    public function promote_retailmenot($id)
    {
        $this->loadModel('ProjectRewards.ProjectReward');
        $reward = $this->ProjectReward->find('first', array(
            'conditions' => array(
                'ProjectReward.id' => $id
            ) ,
            'recursive' => -1
        ));
        $this->set('reward', $reward);
    }
}
?>