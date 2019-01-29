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
class UsersController extends AppController
{
    public $name = 'Users';
    public $components = array(
        'Email',
        'PersistentLogin',
    );
    public $helpers = array(
        'Csv'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'show_header',
            'dashboard',
            'change_password',
        ) ,
        'is_view_count_update' => true
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'City.id',
            'City.name',
            'State.id',
            'State.name',
            'User.send_to_user_id',
            'UserProfile.country_id',
            'UserProfile.state_id',
            'UserProfile.city_id',
            'User.referred_by_user_id',
            'User.latitude',
            'User.longitude',
            'User.adaptive_connect',
            'User.payment_type',
            'User.is_agree_terms_conditions',
            'User.country_iso_code',
            'User.adaptive_normal',
            'User.payment_gateway_id',
            'adcopy_response',
            'adcopy_challenge',
            'User.invite_hash',
            'email'
        );
        if($this->RequestHandler->prefers('json') && ($this->request->params['action'] == 'validate_user' || $this->request->params['action'] == 'register' || $this->request->params['action'] == 'iphone_social_register' || $this->request->params['action'] == 'forgot_password')) {
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
    public function show_header()
    {
        $this->disableCache();
    }
    public function dashboard()
    {
        $this->pageTitle = __l('Dashboard');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id') ,
            ) ,
            'contain' => array(
                'UserProfile' => array(
                    'City',
                    'Country'
                ) ,
            ) ,
            'recursive' => 2
        ));
        $this->set('user', $user);
    }
    public function view($username = null)
    {
        $this->pageTitle = __l('User');
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contain = array(
            'UserProfile' => array(
                'City',
                'State',
                'Country'
            ) ,
            'UserAvatar',
            'UserWebsite'
        );
        if (isPluginEnabled('SocialMarketing')) {
            $contain['UserFollower'] = array(
                'conditions' => array(
                    'UserFollower.user_id' => $this->Auth->user('id') ,
                )
            );
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'contain' => $contain,
            'recursive' => 2
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $count_conditions = array();
        $count_conditions = array(
            'Project.user_id' => $user['User']['id'],
            'Project.is_admin_suspended !=' => 1,
            'Project.is_active' => 1,
            'Project.is_draft' => 0,
        );
        $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
            'type' => 'project_count',
            'page' => 'userview'
        ));
        if (!empty($response->data['conditions'])) {
            $conditions = array_merge($count_conditions, $response->data['conditions']);
        }
        $project_count = $this->User->Project->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        $this->set('project_count', $project_count);
        $conditions = array();
        $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
            'type' => 'idea_count',
            'page' => 'userview'
        ));
        if (!empty($response->data['conditions'])) {
            $conditions = array_merge($count_conditions, $response->data['conditions']);
        }
        $idea_count = $this->User->Project->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        $this->set('idea_count', $idea_count);
        $count_conditions = array();
        $count_conditions = array(
            'Project.is_admin_suspended !=' => 1,
            'Project.is_active' => 1,
            'Project.is_draft' => 0,
        );
        if (isPluginEnabled('ProjectFollowers')) {
            $projectIds = $this->User->Project->ProjectFollower->find('list', array(
                'conditions' => array(
                    'ProjectFollower.user_id' => $user['User']['id']
                ) ,
                'fields' => array(
                    'ProjectFollower.project_id',
                    'ProjectFollower.project_id'
                ) ,
                'recursive' => -1
            ));
            $count_conditions['Project.id'] = $projectIds;
            $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
                'type' => 'count',
                'page' => 'userview'
            ));
            if (!empty($response->data['conditions'])) {
                $conditions = array_merge($count_conditions, $response->data['conditions']);
            }
            $project_following_count = $this->User->Project->find('count', array(
                'conditions' => $conditions,
                'recursive' => 0
            ));
            $this->set('project_following_count', $project_following_count);
        }
        $this->User->UserView->create();
        $this->request->data['UserView']['user_id'] = $user['User']['id'];
        $this->request->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
        $this->request->data['UserView']['ip_id'] = $this->User->UserView->toSaveIp();
        $this->User->UserView->save($this->request->data);
        $this->pageTitle.= ' - ' . $username;
        $this->set('user', $user);
    }
    public function admin_view($username = null)
    {
        $this->setAction('view', $username);
    }
    public function register()
    {
        ///Mobile Request
        if ($this->RequestHandler->prefers('json') && ($this->request->is('post'))) {
            
            if(empty($this->request->data['User'])) {
                $this->request->data['User'] = $this->request->data;
            }
            if($this->request->data['register_type'] == "Facebook")
            {
                unset($this->request->data['security_question_id']);
                unset($this->request->data['security_answer']);
                unset($this->request->data['twitter_user_id']);
                unset($this->request->data['is_twitter_connected']);
                unset($this->request->data['twitter_avatar_url']);
                unset($this->request->data['twitter_access_token']);
                unset($this->request->data['passwd']);
                
            }
            if($this->request->data['register_type'] == "Twitter")
            {
                unset($this->request->data['security_question_id']);
                unset($this->request->data['security_answer']);
                unset($this->request->data['facebook_user_id']);
                unset($this->request->data['is_facebook_connected']);
                unset($this->request->data['is_facebook_register']);
                unset($this->request->data['facebook_access_token']);
                unset($this->request->data['passwd']);
            }
            $this->request->data['User'] = $this->request->data;
            $this->request->data['User']['is_skipped_fb'] = 1;
            $this->request->data['User']['is_skipped_twitter']= 1;
            $this->request->data['User']['is_skipped_google']= 1;
            $this->request->data['User']['is_skipped_yahoo']= 1;
        }
        ///end
        $this->pageTitle = __l('Register');
        $socialuser = $this->Session->read('socialuser');
        $is_register = 1;
        if (isPluginEnabled('LaunchModes')) {
            $this->loadModel('LaunchModes.Subscription');
        }
        if ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'social') && (!Configure::read('twitter.is_enabled_twitter_connect') && !Configure::read('facebook.is_enabled_facebook_connect') && !Configure::read('linkedin.is_enabled_linkedin_connect') && !Configure::read('yahoo.is_enabled_yahoo_connect') && !Configure::read('google.is_enabled_google_connect') && !Configure::read('googleplus.is_enabled_googleplus_connect') && !Configure::read('openid.is_enabled_openid_connect') && !Configure::read('angellist.is_enabled_angellist_connect'))) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
            ));
        }
        if (Configure::read('site.launch_mode') == "Private Beta" && !empty($this->request->data) || !empty($_SESSION['invite_hash'])) {
            if (!empty($_SESSION['invite_hash'])) {
            } elseif (isset($this->request->data['User']['invite_hash']) && !empty($this->request->data['User']['invite_hash'])) {
                $is_valid = $this->Subscription->find('count', array(
                    'conditions' => array(
                        'Subscription.invite_hash' => $this->request->data['User']['invite_hash']
                    )
                ));
                if ($is_valid) {
                    $this->set('iphone_response', array("message" =>__l('You have submitted invitation code sucessfully.') , "error" => 0));
                    $this->Session->setFlash(sprintf(__l('You have submitted invitation code successfully, Welcome to %s') , Configure::read('site.name')) , 'default', null, 'success');
                    unset($this->request->data['User']);
                }
            }
        } elseif (Configure::read('site.launch_mode') == "Private Beta") {
            if (empty($socialuser)) {
                $this->redirect(Router::url('/', true));
                $is_register = 0;
            }
        }
        if ($is_register) {
            if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                $referredByUser = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $referred_by_user_id
                    ) ,
                    'contain' => array(
                        'UserAvatar',
                        'UserProfile'
                    ) ,
                    'recursive' => 2
                ));
                $this->set('referredByUser', $referredByUser);
            }
            if (!$this->RequestHandler->prefers('json') && !($this->request->is('post')))
            {
                $captcha_flag = 1;
            }
            $third_party_flag = 1;
			$captcha_flag = 1;
            $socialuser = $this->Session->read('socialuser');
            if (!empty($socialuser) && empty($this->request->data)) {
                $this->Session->delete('socialuser');
                $this->request->data['User'] = $socialuser;
                $captcha_flag = 0;
                if (isPluginEnabled('JobActs')) {
                    $third_party_flag = 0;
                }
            }
            if (!empty($this->request->data['User']['identifier'])) {
                $captcha_flag = 0;
            }
            if (!empty($this->request->data)) {
                if (!empty($this->request->data['City']['name'])) {
                    $this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->User->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name']);
                }
                if (!empty($this->request->data['State']['name'])) {
                    $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->User->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name']);
                }
                if (!empty($this->request->data['User']['country_iso_code'])) {
                    $this->request->data['UserProfile']['country_id'] = $this->User->UserProfile->Country->findCountryIdFromIso2($this->request->data['User']['country_iso_code']);
                    if (empty($this->request->data['UserProfile']['country_id'])) {
                        unset($this->request->data['UserProfile']['country_id']);
                    }
                }
                $captcha_error = 0;
                if (!empty($captcha_flag)) {
                    if (Configure::read('system.captcha_type') == "Solve Media") {
                        if (!$this->User->_isValidCaptchaSolveMedia()) {
                            $captcha_error = 1;
                        }
                    }
                }
                if (empty($captcha_error)) {
                    $this->User->UserProfile->set($this->request->data);
                    $this->User->set($this->request->data);
                    
                    if ($this->User->validates() &$this->User->UserProfile->validates() && !empty($third_party_flag)) {
                        $this->User->create();
                        if (!isset($this->request->data['User']['passwd']) && !isset($this->request->data['User']['twitter_user_id'])) {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['email'] . Configure::read('Security.salt'));
                            //For open id register no need for email confirm, this will override is_email_verification_for_register setting
                            $this->request->data['User']['is_agree_terms_conditions'] = 1;
                            $this->request->data['User']['is_email_confirmed'] = 1;
                        } elseif (!empty($this->request->data['User']['twitter_user_id'])) { // Twitter modified registration: password  -> twitter user id and salt //
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['twitter_user_id'] . Configure::read('Security.salt'));
                            $this->request->data['User']['is_email_confirmed'] = 1;
                        } else {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
                            $this->request->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
                        }
                        if (!Configure::read('User.signup_fee')) {
                            $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                        }
                        $this->request->data['User']['role_id'] = ConstUserTypes::User;
                        if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                            $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                        }
                        $this->request->data['User']['ip_id'] = $this->User->toSaveIp();
						if (isPluginEnabled('LaunchModes')) {
							if (Configure::read('site.launch_mode') == 'Private Beta' && isset($_SESSION['invite_hash'])) {
								$Subscription = $this->Subscription->find('first', array(
									'fields' => array(
										'Subscription.id',
										'Subscription.site_state_id'
									) ,
									'conditions' => array(
										'Subscription.invite_hash' => $_SESSION['invite_hash']
									)
								));
								$this->request->data['User']['is_sent_private_beta_mail'] = 1;
								if (!empty($Subscription)) {
									$this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];
								} else {
									$this->request->data['User']['site_state_id'] = ConstSiteState::PrivateBeta;
								}
							} else {
								$Subscription = $this->Subscription->find('first', array(
									'fields' => array(
										'Subscription.id',
										'Subscription.site_state_id'
									) ,
									'conditions' => array(
										'Subscription.email' => $this->request->data['User']['email']
									)
								));
								if (!empty($Subscription)) {
									$this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];;
								} else {
									$this->request->data['User']['site_state_id'] = ConstSiteState::Launch;
								}
							}
						}
                        if ($this->User->save($this->request->data, false)) {
                            if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                                $referredUser = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $referred_by_user_id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                                $this->_referer_follow($this->User->id, $referred_by_user_id, $this->request->data['User']['username']);
                                $this->_referer_follow($referred_by_user_id, $this->User->id, $referredUser['User']['username']);
                            }
                            if (!empty($Subscription)) {
                                $this->request->data['Subscription']['user_id'] = $this->User->id;
                                $this->request->data['Subscription']['id'] = $Subscription['Subscription']['id'];
                                $this->Subscription->save($this->request->data);
                            }
                            unset($_SESSION['invite_hash']);
                            $this->request->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                            $this->User->UserProfile->create();
                            $this->User->UserProfile->save($this->request->data['UserProfile'], false);
                            $_data['UserProfile'] = $this->request->data['UserProfile'];
                            $_data['UserProfile']['id'] = $this->User->UserProfile->getLastInsertId();
                            // send to admin mail if is_admin_mail_after_register is true
                            if (Configure::read('user.is_admin_mail_after_register')) {
                                $emailFindReplace = array(
                                    '##USERNAME##' => $this->request->data['User']['username'],
                                    '##USEREMAIL##' => $this->request->data['User']['email'],
                                    '##SIGNUPIP##' => $this->RequestHandler->getClientIP() ,
                                );
                                App::import('Model', 'EmailTemplate');
                                $this->EmailTemplate = new EmailTemplate();
                                $template = $this->EmailTemplate->selectTemplate('New User Join');
                                $this->User->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
                            }
                            if (!empty($this->request->data['User']['openid_url'])) {
                                $this->request->data['UserOpenid']['openid'] = $this->request->data['User']['openid_url'];
                                $this->request->data['UserOpenid']['user_id'] = $this->User->id;
                                $this->User->UserOpenid->create();
                                $this->User->UserOpenid->save($this->request->data);
                            }
                            
                            if (Configure::read('User.signup_fee')) {
                                $is_third_party_register = 0;
                                $message = '';
                                if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_googleplus_register']) || !empty($this->request->data['User']['is_angellist_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_twitter_register'])) {
                                    $is_third_party_register = 1;
                                    // send welcome mail to user if is_welcome_mail_after_register is true
                                    if (Configure::read('user.is_welcome_mail_after_register')) {
                                        $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                    }
                                } else {
                                    $is_third_party_register = 0;
                                    if (Configure::read('user.is_email_verification_for_register')) {
                                        $this->User->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                    }
                                }
                                if (Configure::read('user.is_email_verification_for_register')) {
                                    $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                                }
                                if (Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $message = __l('You have successfully registered with our site you can login after email verification and administrator approval, but you can able to access all features after paying sign up fee.');
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification and administrator approval, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_admin_activate_after_register')) {
                                    $message = __l('You have successfully registered with our site. You can login in site after administrator approval, but you can able to access all features after paying sign up fee.');
                                    $this->Session->setFlash(__l(' You have successfully registered with our site. You can login in site after administrator approval, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $message = __l('You have successfully registered with our site you can login after email verification, but you can able to access all features after paying signup fee.');
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                } else {
                                    $message = __l('You have successfully registered with our site you can login now, but you can able to access all features after paying sign up fee.');
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login now, but you can able to access all features after paying sign up fee.') , 'default', null, 'success');
                                }
                                if (!$this->RequestHandler->prefers('json')) {
                                    $this->redirect(array(
                                        'controller' => 'payments',
                                        'action' => 'user_pay_now',
                                        $this->User->id,
                                        $this->User->getActivateHash($this->User->id)
                                    ));
                                } else {
				    if(empty($is_third_party_register)) {
                                        $total_amount = Configure::read('user.signup_fee');
                                        $total_amount = round($total_amount, 2);
                                        $this->set('iphone_response', array(
                                                                            "message" => $message,
                                                                            "membership_pay" => "YES",
                                                                            "signup_fee" => $total_amount,
                                                                            "membership_pay_user_id" => $this->User->id,
                                                                            "activate_hash" => $this->User->getActivateHash($this->User->id),
                                                                            "error" => 2
                                                                        ));
                                    }
                                }
                            } else {
                                $user = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $this->User->id
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (!empty($this->request->data['User']['is_linkedin_register'])) {
                                    $label = 'LinkedIn';
                                } else if (!empty($this->request->data['User']['is_facebook_register'])) {
                                    $label = 'Facebook';
                                } else if (!empty($this->request->data['User']['is_twitter_register'])) {
                                    $label = 'Twitter';
                                } else if (!empty($this->request->data['User']['is_yahoo_register'])) {
                                    $label = 'Yahoo!';
                                } else if (!empty($this->request->data['User']['is_google_register'])) {
                                    $label = 'Gmail';
                                } else if (!empty($this->request->data['User']['is_googleplus_register'])) {
                                    $label = 'GooglePlus';
                                } else if (!empty($this->request->data['User']['is_angellist_register'])) {
                                    $label = 'AngelList';
                                } else {
                                    $label = 'Direct';
                                }
                                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                    '_trackEvent' => array(
                                        'category' => 'User',
                                        'action' => 'Registered',
                                        'label' => $label,
                                        'value' => '',
                                    ) ,
                                    '_setCustomVar' => array(
                                        'ud' => $user['User']['id'],
                                        'rud' => $user['User']['referred_by_user_id'],
                                    )
                                ));
                                if (!empty($user['User']['referred_by_user_id'])) {
                                    $referredUser = $this->User->find('first', array(
                                        'conditions' => array(
                                            'User.id' => $user['User']['referred_by_user_id']
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                        '_trackEvent' => array(
                                            'category' => 'User',
                                            'action' => 'Referred',
                                            'label' => $referredUser['User']['username'],
                                            'value' => '',
                                        ) ,
                                        '_setCustomVar' => array(
                                            'ud' => $user['User']['id'],
                                            'rud' => $user['User']['referred_by_user_id'],
                                        )
                                    ));
                                }
                            }
                            if (Configure::read('user.is_admin_activate_after_register'))
                            {
                                
                                $this->set('iphone_response', array("message" =>__l('You have successfully registered with our site. After administrator approval you can login to site.') , "error" => 1));
                                
                                $this->Session->setFlash(__l('You have successfully registered with our site. After administrator approval you can login to site.') , 'default', null, 'success');
                            } else {
                                
                                 $this->set('iphone_response', array("message" =>__l('You have successfully registered with our site. After administrator approval you can login to site.') , "error" => 1));
                                
                                $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                            }
                            if (!empty($this->request->data['User']['openid_user_id']) || !empty($this->request->data['User']['linkedin_user_id']) || !empty($this->request->data['User']['google_user_id']) || !empty($this->request->data['User']['googleplus_user_id']) || !empty($this->request->data['User']['angellist_user_id']) || !empty($this->request->data['User']['facebook_user_id']) || !empty($this->request->data['User']['twitter_user_id']) || !empty($this->request->data['User']['yahoo_user_id'])) {
                                // send welcome mail to user if is_welcome_mail_after_register is true
                                if (Configure::read('user.is_welcome_mail_after_register')) {
                                    $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                }
                                if ($this->Auth->login()) {
                                    if ($this->RequestHandler->prefers('json')) {
                                        $mobile_app_hash = md5($this->_unum() . $this->request->data['User'][Configure::read('user.using_to_login') ] . $this->request->data['User']['password'] . Configure::read('Security.salt'));
                                        $image_options = array(
                                                               'dimension' => 'iphone_big_thumb',
                                                               'class' => '',
                                                               'alt' => $this->Auth->user('username'),
                                                               'title' => $this->Auth->user('username'),
                                                               'type' => 'jpg'
                                                               );
                                        $iphone_big_thumb = getImageUrl('UserAvatar', $this->request->data['UserAvatar'], $image_options);
                                        $user['User']['iphone_big_thumb'] = $iphone_big_thumb;
								
		   				            $this->User->updateAll(array(
		   				                'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
		   				                'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
		   				            ) , array(
		   				                'User.id' => $this->Auth->user('id')
		   				            ));
                                        
                                        $this->set('iphone_response', array(
                                            "message" => __l('You have successfully registered with our site.'),
                                            "error" => 0,
                                            "username" => $this->request->data['User']['username'],
                                            "hash_token" => $mobile_app_hash,
                                            'user_id' => $this->Auth->user('id'),
                                            'iphone_big_thumb' => $iphone_big_thumb,
                                        ));
                                    }
                                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                }
                            } else {
                                //For openid register no need to send the activation mail, so this code placed in the else
                                if (Configure::read('user.is_email_verification_for_register')) {
                                    $this->set('iphone_response', array("message" =>__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , "error" => 1));
                                    $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                    $this->User->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                }
                                if ($this->RequestHandler->prefers('json')) {
                                    if (Configure::read('User.signup_fee')) {
                                        $this->set('iphone_response', array(
                                                                            "message" => $message,
                                                                            "membership_pay" => "YES",
                                                                            "signup_fee" => Configure::read('User.signup_fee'),
                                                                            "membership_pay_user_id" => $this->User->id,
                                                                            "activate_hash" => $this->User->getActivateHash($this->User->id),
                                                                            "error" => 2
                                                                        ));
                                    } else {
                                        if (Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register')) {
                                            $message = __l('You have successfully registered with our site you can login after email verification and administrator approval. Your activation mail has been sent to your mail inbox');
                                        } else if (Configure::read('user.is_email_verification_for_register')) {
                                            $message = __l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.');
                                        } else if (Configure::read('user.is_admin_activate_after_register')) {
                                            $message = __l('You have successfully registered with our site. After administrator approval you can login to site.');
                                        }
                                        $this->set('iphone_response', array(
                                                                            "message" => $message,
                                                                            "error" => 2,
                                                                            "membership_pay" => "NO"
                                        ));
                                    }
                                }
                            }
                            if (!$this->Auth->user('id')) {
                                // send welcome mail to user if is_welcome_mail_after_register is true
                                if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                                    $this->User->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                }
                                if (!Configure::read('user.is_email_verification_for_register') and Configure::read('user.is_auto_login_after_register')) {
                                    $mobile_app_hash = md5($this->_unum() . $this->request->data['User'][Configure::read('user.using_to_login') ] . $this->request->data['User']['password'] . Configure::read('Security.salt'));
                                    
                                    $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                                    if ($this->Auth->login()) {
                                        
                                        $image_options = array(
                                                               'dimension' => 'iphone_big_thumb',
                                                               'class' => '',
                                                               'alt' => $this->Auth->user('username'),
                                                               'title' => $this->Auth->user('username'),
                                                               'type' => 'jpg'
                                                               );
									if(!empty($this->request->data['UserAvatar'])){
                                        $iphone_big_thumb = getImageUrl('UserAvatar', $this->request->data['UserAvatar'], $image_options);
                                        $user['User']['iphone_big_thumb'] = $iphone_big_thumb;
									}
									
		   				            $this->User->updateAll(array(
		   				                'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
		   				                'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
		   				            ) , array(
		   				                'User.id' => $this->Auth->user('id')
		   				            ));
                                    if(!empty($iphone_big_thumb)){ 
                                        $this->set('iphone_response', array(
                                            "message" => __l('You have successfully registered with our site.'),
                                            "error" => 0,
                                            "username" => $this->request->data['User']['username'],
                                            "hash_token" => $mobile_app_hash,
                                            'user_id' => $this->Auth->user('id'),
                                            'iphone_big_thumb' => $iphone_big_thumb,
                                        ));
                                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
									}
								}
                                }
                            } 
                            if (!$this->RequestHandler->prefers('json'))
                            {
                                if ($this->Auth->user('id')) {
                                    $this->redirect(array(
                                        'controller' => 'projects',
                                        'action' => 'index',
                                        'type' => 'home'
                                    ));
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'login'
                                    ));
                                }
                            }
                        }
                    } else {
                        if (!empty($this->request->data['User']['provider'])) {
                            if (!empty($this->request->data['User']['is_google_register'])) {
                                $flash_verfy = 'Gmail';
                            } elseif (!empty($this->request->data['User']['is_googleplus_register'])) {
                                $flash_verfy = 'GooglePlus';
                            } elseif (!empty($this->request->data['User']['is_angellist_register'])) {
                                $flash_verfy = 'AngelList';
                            } elseif (!empty($this->request->data['User']['is_yahoo_register'])) {
                                $flash_verfy = 'Yahoo!';
                            } else {
                                $flash_verfy = $this->request->data['User']['provider'];
                            }
                            $this->set('iphone_response', array(
                                        "message" => __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.'),
                                        "error" => 0
                                    ));
                            $this->Session->setFlash($flash_verfy . ' ' . __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'success');
                        } else {
                            $this->set('iphone_response', array(
                                        "message" => __l('Your registration process is not completed. Please, try again.'),
                                        "error" => 3
                                    ));
                            $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                        }
                    }
                } else {
                    $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
                }
            }
            unset($this->request->data['User']['passwd']);
            // When already logged user trying to access the registration page we are redirecting to site home page
            if ($this->Auth->user() && !$this->RequestHandler->prefers('json')) {
                $this->redirect(Router::url('/', true));
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
        }
        if (!$is_register && empty($socialuser) && !$this->RequestHandler->prefers('json')) {
            $this->layout = 'subscription';
            $this->render('invite_page');
        }
        $this->request->data['User']['passwd'] = '';
        
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $response = Cms::dispatchEvent('Controller.User.Register', $this, array());
        }
    }
    public function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getResendActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->request->data['User']['id'] = $user_id;
            $this->request->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            if (!Configure::read('user.signup_fee') && empty($user['User']['is_active'])) {
                $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            }
            $this->User->save($this->request->data);
            // active is false means redirect to home page with message
            if (!$user['User']['is_active']) {
                // user is active but auto login is false then the user will redirect to login page with message
                $this->Session->setFlash(sprintf(__l('You have successfully activated your account. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
                if ((Configure::read('user.signup_fee') && $user['User']['is_paid'] == 0) || !Configure::read('user.is_admin_activate_after_register')) {
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after pay the membership fee.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'user_pay_now',
                        $user['User']['id'],
                        $this->User->getActivateHash($user['User']['id'])
                    ));
                } else {
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('You have successfully activated your account. Now you can login.') , 'default', null, 'success');
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->User->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->request->data['User']['email'] = $user['User']['email'];
                $this->request->data['User']['username'] = $user['User']['username'];
                $this->request->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login()) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit'
                    ));
                }
            }
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin || $this->User->isValidResendActivateHash($user_id, $hash)) {
            $hash = $this->User->getResendActivateHash($user_id);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'recursive' => -1
            ));
            if ($this->User->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
            }
        } else {
            $this->Session->setFlash(__l('Invalid resend activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function _sendMembershipMail($user_id, $hash)
    {
        //send membership mail to users
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##MEMBERSHIP_URL##' => Router::url(array(
                'controller' => 'payments',
                'action' => 'user_pay_now',
                $this->User->id,
                $hash,
                'admin' => false,
            ) , true) ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Membership Fee');
        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
    }
    public function login()
    {
        $socialuser = $this->Session->read('socialuser');
        if (!empty($socialuser)) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
                'admin' => false,
            ));
        }
        $this->pageTitle = __l('Login');
        if ($this->Auth->user()) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
                'admin' => false,
            ));
        }
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => Configure::read('facebook.is_enabled_facebook_connect') ,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.fb_secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => Configure::read('twitter.is_enabled_twitter_connect') ,
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
                    'enabled' => Configure::read('googleplus.is_enabled_googleplus_connect') ,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => Configure::read('yahoo.is_enabled_yahoo_connect') ,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Openid' => array(
                    'enabled' => Configure::read('openid.is_enabled_openid_connect') ,
                ) ,
                'Linkedin' => array(
                    'enabled' => Configure::read('linkedin.is_enabled_linkedin_connect') ,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
                'AngelList' => array(
                    'enabled' => Configure::read('angellist.is_enabled_angellist_connect') ,
                    'keys' => array(
                        'id' => Configure::read('angellist.client_id') ,
                        'secret' => Configure::read('angellist.client_secret')
                    ) ,
                    'scope' => 'email'
                ) ,
            )
        );
        if (!empty($this->request->params['named']['type'])) {
            $options = array();
            $social_type = $this->request->params['named']['type'];
            if ($social_type == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                if (!empty($this->request->params['named']['redirecting'])) {
                    $adapter = $hybridauth->authenticate(ucfirst($social_type) , $options);
                    $loggedin_contact = $social_profile = $adapter->getUserProfile();
                    $social_profile = (array)$social_profile;
                    $social_profile['username'] = $social_profile['displayName'];
                    if ($social_type != 'openid') {
                        $session_data = $this->Session->read('HA::STORE');
                        $stored_access_token = $session_data['hauth_session.' . $social_type . '.token.access_token'];
                        $temp_access_token = explode(":", $stored_access_token);
                        $temp_access_token = str_replace('"', "", $temp_access_token);
                        $temp_access_token = str_replace(';', "", $temp_access_token);
                        $access_token = $temp_access_token[2];
                    }
                    $social_profile['provider'] = ucfirst($social_type);
                    $social_profile['is_' . $social_type . '_register'] = 1;
                    $social_profile[$social_type . '_user_id'] = $social_profile['identifier'];
                    if ($social_type != 'openid') {
                        $social_profile[$social_type . '_access_token'] = $access_token;
                    }
                    $condition['User.' . $social_type . '_user_id'] = $social_profile['identifier'];
                    if ($social_type != 'openid') {
                        $condition['OR'] = array(
                            'User.is_' . $social_type . '_register' => 1,
                            'User.is_' . $social_type . '_connected' => 1
                        );
                    } else {
                        $condition['User.is_' . $social_type . '_register'] = 1;
                    }
                    $user = $this->User->find('first', array(
                        'conditions' => $condition,
                        'recursive' => -1
                    ));
                    $is_social = 0;
                    if (!empty($user)) {
                        $this->request->data['User']['username'] = $user['User']['username'];
                        $this->request->data['User']['password'] = $user['User']['password'];
                        $is_social = 1;
                    } else {
                        if (Configure::read('site.launch_mode') == 'Pre-launch' || (Configure::read('site.launch_mode') == 'Private Beta' && empty($_SESSION['invite_hash']))) {
                            if (Configure::read('site.launch_mode') == 'Pre-launch') {
                                $this->Session->setFlash(__l('Sorry!!. Cannot register into the site in pre-launch mode') , 'default', null, 'error');
                            } else {
                                $this->Session->setFlash(__l('Sorry!!. Cannot register into the site without invitation') , 'default', null, 'error');
                            }
                            $this->Session->delete('HA::CONFIG');
                            $this->Session->delete('HA::STORE');
                            $this->Session->delete('socialuser');
                            echo '<script>window.close();</script>';
                            exit;
                        }
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $this->Session->write('socialuser', $social_profile);
                        echo '<script>window.close();</script>';
                        exit;
                    }
                } else {
                    $reditect = Router::url(array(
                        'controller' => 'users',
                        'action' => 'login',
                        'type' => $social_type,
                        'redirecting' => $social_type
                    ) , true);;
                    $this->layout = 'redirection';
                    $this->pageTitle.= ' - ' . ucfirst($social_type);
                    $this->set('redirect_url', $reditect);
                    $this->set('authorize_name', ucfirst($social_type));
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
        if (!empty($this->request->data)) {
            $this->request->data['User'][Configure::read('user.using_to_login') ] = !empty($this->request->data['User'][Configure::read('user.using_to_login') ]) ? trim($this->request->data['User'][Configure::read('user.using_to_login') ]) : '';
            //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
            unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if (empty($social_type)) {
                    if (!empty($this->request->data['User'][Configure::read('user.using_to_login') ])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.' . Configure::read('user.using_to_login') => $this->request->data['User'][Configure::read('user.using_to_login') ]
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['User']['password'] = crypt($this->request->data['User']['passwd'], $user['User']['password']);
                    }
                }
                if ($this->Auth->login()) {
                    if (!empty($social_type) && $social_type == 'twitter' && !empty($social_profile['photoURL'])) {
                        $_data = array();
                        $_data['User']['id'] = $user['User']['id'];
                        $_data['User']['twitter_avatar_url'] = $social_profile['photoURL'];
                        $this->User->save($_data);
                    }else if (!empty($social_type) && $social_type == 'twitter' && !empty($social_profile['photoURL'])) {
                        $_data = array();
                        $_data['User']['id'] = $user['User']['id'];
                        $_data['User']['linkedin_avatar_url'] = $social_profile['photoURL'];
                        $this->User->save($_data);
                    }
                    if (isPluginEnabled('SocialMarketing') && !empty($social_type) && $social_type != 'openid' && $social_type != 'angellist') {
                        $this->loadModel('SocialMarketing.SocialMarketing');
                        $social_contacts = $adapter->getUserContacts();
                        array_push($social_contacts, $loggedin_contact);
                        $this->SocialMarketing->import_contacts($social_contacts, $social_type);
                    }
                    if (!empty($social_type)) {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                    }
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    if ($this->Auth->user()) {
                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                            '_trackEvent' => array(
                                'category' => 'User',
                                'action' => 'Loggedin',
                                'label' => $this->Auth->user('username') ,
                                'value' => '',
                            ) ,
                            '_setCustomVar' => array(
                                'ud' => $this->Auth->user('id') ,
                                'rud' => $this->Auth->user('referred_by_user_id') ,
                            )
                        ));
                        if (!empty($this->request->data['User']['is_remember'])) {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.id' => $this->Auth->user('id')
                                ) ,
                                'recursive' => -1
                            ));
                            $this->PersistentLogin->_persistent_login_create_cookie($user, $this->request->data);
                        }
                        if (!empty($is_social)) {
                            if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
                                $this->redirect(Router::url('/'), true);
                            } else {
                                echo '<script>window.close();</script>';
                                exit;
                            }
                        }
                        if ($this->layoutPath != 'touch') {
                            if (!empty($this->request->data['User']['f'])) {
                                $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
                            } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'stats',
                                    'admin' => true
                                ));
                            } else {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'dashboard',
                                    'admin' => false,
                                ));
                            }
                        } else {
                            $this->redirect(array(
                                'controller' => 'projects',
                                'action' => 'index',
                                'admin' => true
                            ));
                        }
                    }
                } else {
                    if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
                        $this->Session->setFlash(sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login')) , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                    }
                    if (!empty($is_social)) {
                        if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
                            $this->redirect(Router::url(array(
                                    'controller' => 'users',
                                    'action' => 'login'
                            )));
                        } else {
                            echo '<script>window.close();</script>';
                            exit;
                        }
                    }
                }
            }
        }
        $this->request->data['User']['passwd'] = '';
    }
    // <-- For iPhone App code
    public function validate_user()
    {
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Auth->logout();
        Cms::dispatchEvent('Controller.User.validate_user', $this, array(
            'data' => $this->request->data
        ));
    }
    
    public function iphone_social_register()
    {
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Auth->logout();
        
        if ($this->RequestHandler->prefers('json') && ($this->request->is('post'))) {
            $this->request->data['Social'] = $this->request->data;
        }
        $social_profile = $this->request->data['Social'];
        $social_type    = $this->request->data['Social']['provider'];
        $is_existing    = 0;
        if (empty($social_type)) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array(
                                                    "message" => __l('Unable to login request'),
                                                    "status" => 1,
                                                    "flag" => 1
                                                    ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            if((strtolower($social_type) == "facebook") || (strtolower($social_type) == "twitter")){
                $condition['User.' . $social_type . '_user_id'] = $social_profile['identifier'];
                if ($social_type != 'openid') {
                    $condition['OR'] = array(
                                             'User.is_' . $social_type . '_register' => 1,
                                             'User.is_' . $social_type . '_connected' => 1
                                             );
                } else {
                    $condition['User.is_' . $social_type . '_register'] = 1;
                }
                $user = $this->User->find('first', array(
                                                         'conditions' => $condition,
                                                         'recursive' => -1
                                                         ));
                if (!empty($user)) {
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user['User']['password'];
                    $is_existing                             = 1;
                } else {
                    $this->Session->write('socialuser', $social_profile);
                    $this->set('iphone_response', array("message" =>__l('Verification is completed. But you have to fill the form fields to complete our registration process.') , "status" => 1, "flag" => 0));
                }
            }else{
                $this->set('iphone_response', array("message" =>__l('Not able to process the given provider ') , "status" => 1, "flag" => 1));
            }
        }
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $data = array();
            if ($is_existing) {
                $data = $this->request->data['User'];
            }
            Cms::dispatchEvent('Controller.User.socialLogin', $this, array(
                                                                           'data' => $data
                                                                           ));
        }
    }
    
    public function logout()
    {
        if ($this->Auth->user('facebook_user_id')) {
            // Quick fix for facebook redirect loop issue.
            $this->Session->delete('fbuser');
            $this->Session->write('is_fab_session_cleared', 1);
        }
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Session->delete('socialuser');
        $this->Auth->logout();
        $this->Cookie->delete('User');
        $this->Cookie->delete('user_language');
        $cookie_name = $this->PersistentLogin->_persistent_login_get_cookie_name();
        $cookie_val = $this->Cookie->read($cookie_name);
        if (!empty($cookie_val)) {
            list($uid, $series, $token) = explode(':', $cookie_val);
            $this->User->PersistentLogin->deleteAll(array(
                'PersistentLogin.user_id' => $uid,
                'PersistentLogin.series' => $series
            ));
        }
        if (!empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'login'
        ));
    }
    public function forgot_password()
    {
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array(
                    "message" => __l('login user unable to request'),
                    "error" => 1
                ));
            } else {
                $this->redirect(Router::url('/', true));
            }
        }
        // todo: json api related code
        if ($this->RequestHandler->prefers('json')) {
            if (isset($this->request->data['email'])) {
                $this->request->data['User']['email'] = $this->request->data['email'];
            }
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            $captcha_error = 0;
            if (!$this->RequestHandler->isAjax()) {
                if (Configure::read('user.is_enable_forgot_password_captcha') && Configure::read('system.captcha_type') == "Solve Media") {
                    if (!$this->User->_isValidCaptchaSolveMedia()) {
                        $captcha_error = 1;
                    }
                }
            }
            if (empty($captcha_error)) {
                if ($this->User->validates()) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $this->request->data['User']['email'],
                            'User.is_active' => 1
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($user['User']['email'])) {
                        if (!empty($user['User']['is_openid_register']) || !empty($user['User']['is_yahoo_register']) || !empty($user['User']['is_google_register']) || !empty($user['User']['is_googleplus_register']) || !empty($user['User']['is_angellist_register']) || !empty($user['User']['is_facebook_register']) || !empty($user['User']['is_twitter_register'])) {
                            if (!empty($user['User']['is_yahoo_register'])) {
                                $site = __l('Yahoo!');
                            } elseif (!empty($user['User']['is_google_register'])) {
                                $site = __l('Gmail');
                            } elseif (!empty($user['User']['is_googleplus_register'])) {
                                $site = __l('GooglePlus');
                            } elseif (!empty($user['User']['is_angellist_register'])) {
                                $site = __l('AngelList');
                            } elseif (!empty($user['User']['is_openid_register'])) {
                                $site = __l('OpenID');
                            } elseif (!empty($user['User']['is_facebook_register'])) {
                                $site = __l('Facebook');
                            } elseif (!empty($user['User']['is_twitter_register'])) {
                                $site = __l('Twitter');
                            }
                            $emailFindReplace = array(
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                                '##OTHER_SITE##' => $site,
                                '##USERNAME##' => $user['User']['username'],
                            );
                            $email_template = "Failed Social User";
                            if ($this->RequestHandler->prefers('json')) {
                            $this->set('iphone_response', array(
                                "message" => __l('Failed Social User'),
                                "error" => 1
                            ));
                        }
                        } else {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.email' => $user['User']['email']
                                ) ,
                                'recursive' => -1
                            ));
                            $reset_token = $this->User->getResetPasswordHash($user['User']['id']);
                            $this->User->updateAll(array(
                                'User.pwd_reset_token' => '\'' . $reset_token . '\'',
                                'User.pwd_reset_requested_date' => '\'' . date("Y-m-d H:i:s", time()) . '\'',
                            ) , array(
                                'User.id' => $user['User']['id']
                            ));
                            $emailFindReplace = array(
                                '##USERNAME##' => $user['User']['username'],
                                '##FIRST_NAME##' => (isset($user['User']['first_name'])) ? $user['User']['first_name'] : '',
                                '##LAST_NAME##' => (isset($user['User']['last_name'])) ? $user['User']['last_name'] : '',
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                                '##RESET_URL##' => Router::url(array(
                                    'controller' => 'users',
                                    'action' => 'reset',
                                    $user['User']['id'],
                                    $reset_token
                                ) , true)
                            );
                            $email_template = 'Forgot Password';
                        }
                    } else {
                        $email_template = 'Failed Forgot Password';
                        $emailFindReplace = array(
                            '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                            '##user_email##' => $this->request->data['User']['email']
                        );
                        if ($this->RequestHandler->prefers('json')) {
                            $this->set('iphone_response', array(
                                "message" => sprintf(__l('There is no user registered with the email') . ' ' . '%s' . ' ' . __l('or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.'), $this->request->data['User']['email']),
                                "error" => 1
                            ));
                        }
                    }
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate($email_template);
                    $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                    $this->Session->setFlash(__l('We have sent an email to ' . $this->request->data['User']['email'] . ' with further instructions.') , 'default', null, 'success');
                    if ($this->RequestHandler->prefers('json')) {
                        $this->set('iphone_response', array(
                            "message" => __l('We have sent an email to ' . $this->request->data['User']['email'] . ' with further instructions.'),
                            "error" => 0
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                }
            } else {
                if ($this->RequestHandler->prefers('json')) {
                    $this->set('iphone_response', array(
                        "message" => __l('Please enter valid Captcha.'),
                        "error" => 1
                    ));
                } else {
                    $this->Session->setFlash(__l('Please enter valid Captcha.'), 'default', null, 'error');
                }
            }
        }
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.User.ForgetPassword', $this, array());
        }
    }
    public function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_active' => 1,
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'date(User.pwd_reset_requested_date) as request_date',
                'User.security_question_id',
                'User.security_answer',
                'User.pwd_reset_requested_date',
                'User.pwd_reset_token',
                'User.email',
            ) ,
            'recursive' => -1
        ));
        $expected_date_diff = strtotime('now') -strtotime($user['User']['pwd_reset_requested_date']);
        if (empty($user) || empty($user['User']['pwd_reset_token']) || ($expected_date_diff < 0)) {
            $this->Session->setFlash(__l('Invalid request'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        if (isPluginEnabled('SecurityQuestions')) {
            $security_questions = $this->User->SecurityQuestion->find('first', array(
                'conditions' => array(
                    'SecurityQuestion.id' => $user['User']['security_question_id']
                )
            ));
        }
        $this->set('user_id', $user_id);
        $this->set('hash', $hash);
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['security_answer']) && isPluginEnabled('SecurityQuestions')) {
                if (strcmp($this->request->data['User']['security_answer'], $user['User']['security_answer'])) {
                    $this->Session->setFlash(__l('Sorry incorrect answer. Please try again') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'reset',
                        $user_id,
                        $hash
                    ));
                }
				else{
					$this->Session->setFlash(__l('Entered security answer is correct. Now You can reset your password.') , 'default', null, 'success');
				}
            } else {
                if ($this->User->isValidResetPasswordHash($this->request->data['User']['user_id'], $this->request->data['User']['hash'], $user[0]['request_date'])) {
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->User->updateAll(array(
                            'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                            'User.pwd_reset_token' => '\'' . '' . '\'',
                        ) , array(
                            'User.id' => $this->request->data['User']['user_id']
                        ));
                        $emailFindReplace = array(
                            '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                            '##USERNAME##' => $user['User']['username']
                        );
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        $template = $this->EmailTemplate->selectTemplate('Password Changed');
                        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                        $this->Session->setFlash(__l('Your password has been changed successfully, Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                    $this->request->data['User']['passwd'] = '';
                    $this->request->data['User']['confirm_password'] = '';
                } else {
                    $this->Session->setFlash(__l('Invalid change password request'));
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
            }
        } else {
            if (is_null($user_id) or is_null($hash)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash, $user[0]['request_date'])) {
                $this->Session->setFlash(__l('Invalid request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->request->data['User']['user_id'] = $user_id;
            $this->request->data['User']['hash'] = $hash;
            if (isPluginEnabled('SecurityQuestions') && !empty($user['User']['security_question_id']) && !empty($user['User']['security_answer'])) {
                $this->set('security_questions', $security_questions);
                $this->render('check_security_question');
            }
        }
    }
    public function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if ($this->User->updateAll(array(
                    'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                ) , array(
                    'User.id' => $this->request->data['User']['user_id']
                ))) {
                    if ($this->Auth->user('role_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                        $this->Auth->logout();
                        $this->Session->setFlash(__l('Your password has been changed successfully. Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->request->data['User']['user_id']
                            ) ,
                            'fields' => array(
                                'User.username',
                                'User.email'
                            ) ,
                            'recursive' => -1
                        ));
                        $emailFindReplace = array(
                            '##PASSWORD##' => $this->request->data['User']['passwd'],
                            '##USERNAME##' => $user['User']['username'],
                        );
                        // Send e-mail to users
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        $template = $this->EmailTemplate->selectTemplate('Admin Change Password');
                        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                    }
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                        $this->Session->setFlash(__l('Password has been changed successfully') , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Your password has been changed successfully') , 'default', null, 'success');
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
            }
            unset($this->request->data['User']['old_password']);
            unset($this->request->data['User']['passwd']);
            unset($this->request->data['User']['confirm_password']);
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->redirect(array(
                    'action' => 'index',
                    'admin' => true
                ));
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        $conditions = array(
            'User.is_twitter_register' => 0,
            'User.is_facebook_register' => 0,
            'User.is_openid_register' => 0,
            'User.is_yahoo_register' => 0,
            'User.is_google_register' => 0,
            'User.is_googleplus_register' => 0,
            'User.is_angellist_register' => 0,
			'User.is_linkedin_register' => 0
        );
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->User->find('list', array(
                'conditions' => $conditions,
            ));
            $this->set(compact('users'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['User.id'] = $this->Auth->user('id');
            $user = $this->User->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->request->data['User']['user_id'] = (!empty($this->request->data['User']['user_id'])) ? $this->request->data['User']['user_id'] : $user_id;
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'role_id',
            'filter_id',
            'main_filter_id',
            'q',
            'filters',
            'conditions',
            'value'
        ));
        $this->pageTitle = __l('Users');
        // total approved users list
        $this->set('pending', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('approved', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('openid', $this->User->find('count', array(
            'conditions' => array(
                'User.is_openid_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('facebook', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('twitter', $this->User->find('count', array(
            'conditions' => array(
                'User.is_twitter_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('linkedin', $this->User->find('count', array(
            'conditions' => array(
                'User.is_linkedin_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('gmail', $this->User->find('count', array(
            'conditions' => array(
                'User.is_google_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('googleplus', $this->User->find('count', array(
            'conditions' => array(
                'User.is_googleplus_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('angellist', $this->User->find('count', array(
            'conditions' => array(
                'User.is_angellist_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('yahoo', $this->User->find('count', array(
            'conditions' => array(
                'User.is_yahoo_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('site_users', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register =' => 0,
                'User.is_twitter_register =' => 0,
                'User.is_openid_register =' => 0,
                'User.is_yahoo_register =' => 0,
                'User.is_google_register =' => 0,
                'User.is_googleplus_register =' => 0,
                'User.is_angellist_register =' => 0,
                'User.is_linkedin_register' => 0,
                'User.role_id !=' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
        $this->set('admin_count', $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
        $this->set('affiliate_user_count', $this->User->find('count', array(
            'conditions' => array(
                'User.is_affiliate_user' => 1,
            ) ,
            'recursive' => -1
        )));
        // total users list
        $this->set('total_users_count', $this->User->find('count', array(
            'recursive' => -1
        )));
        // For enagement metrics//
        $total_users = $this->User->find('count', array(
            'recursive' => -1
        ));
        $idle_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_idle' => 1
            ) ,
            'recursive' => -1
        ));
        $funded_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_funded' => 1
            ) ,
            'recursive' => -1
        ));
        $posted_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_project_posted' => 1
            ) ,
            'recursive' => -1
        ));
        $engaged_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_engaged' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('total_users', $total_users);
        $this->set('idle_users', $idle_users);
        $this->set('funded_users', $funded_users);
        $this->set('posted_users', $posted_users);
        $this->set('engaged_users', $engaged_users);
        // engagment metircs data ends here
        //user insight//
        $userinsight_filters = $this->User->filterOptions;
        $this->set('userinsight_filters', $userinsight_filters);
        //ends here user insight
        if (isPluginEnabled('LaunchModes')) {
            $this->loadModel('LaunchModes.Subscription');
            // total pre-launch users list
            $this->set('prelaunch_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.site_state_id' => ConstSiteState::Prelaunch
                ) ,
                'recursive' => -1
            )));
            // total privatebeta users list
            $this->set('privatebeta_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.site_state_id' => ConstSiteState::PrivateBeta
                ) ,
                'recursive' => -1
            )));
            // total pre-launch subscribed users list
            $this->set('prelaunch_subscribed', $this->Subscription->find('count', array(
                'conditions' => array(
                    'Subscription.site_state_id = ' => ConstSiteState::Prelaunch
                )
            )));
            // total privatebeta subscribed users list
            $this->set('privatebeta_subscribed', $this->Subscription->find('count', array(
                'conditions' => array(
                    'Subscription.site_state_id = ' => ConstSiteState::PrivateBeta
                )
            )));
        }
        $conditions = array();
        if (!empty($this->request->params['named']['filters'])) {
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Loggedin) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.user_login_count ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.user_login_count >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Refferred) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.referred_by_user_count ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.referred_by_user_count >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Followed) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.project_follower_count ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.project_follower_count >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Voted) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.project_rating_count ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.project_rating_count >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Commented) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.project_comment_count ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.project_comment_count >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::Funded) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.total_funded_amount ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.total_funded_amount >'] = 0;
                }
            }
            if ($this->request->params['named']['filters'] == ConstFilterOptions::ProjectPosted) {
                if (!empty($this->request->params['named']['conditions']) && (!empty($this->request->params['named']['value']) || $this->request->params['named']['value'] == 0)) {
                    $conditions['User.total_needed_amount ' . $this->request->params['named']['conditions']] = $this->request->params['named']['value'];
                } else {
                    $conditions['User.total_needed_amount >'] = 0;
                }
            }
        } else {
            // check the filer passed through named parameter
            if (isset($this->request->params['named']['filter_id'])) {
                $this->request->data['User']['filter_id'] = $this->request->params['named']['filter_id'];
            }
            if (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
                $conditions['User.role_id'] = ConstUserTypes::Admin;
                $this->pageTitle.= ' - ' . __l('Admin') . ' ';
            }
            if (!empty($this->request->data['User']['filter_id'])) {
                if ($this->request->data['User']['filter_id'] == ConstMoreAction::OpenID) {
                    $conditions['User.is_openid_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through OpenID');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Gmail) {
                    $conditions['User.is_google_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through Gmail');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::GooglePlus) {
                    $conditions['User.is_googleplus_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through GooglePlus');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::AngelList) {
                    $conditions['User.is_angellist_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through AngelList');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Yahoo) {
                    $conditions['User.is_yahoo_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through Yahoo!');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Active) {
                    $conditions['User.is_active'] = 1;
                    $this->pageTitle.= ' - ' . __l('Active');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Site) {
                    $conditions['User.is_yahoo_register'] = 0;
                    $conditions['User.is_google_register'] = 0;
                    $conditions['User.is_googleplus_register'] = 0;
                    $conditions['User.is_angellist_register'] = 0;
                    $conditions['User.is_openid_register'] = 0;
                    $conditions['User.is_facebook_register'] = 0;
                    $conditions['User.is_twitter_register'] = 0;
                    $conditions['User.is_linkedin_register'] = 0;
                    $conditions['User.role_id !='] = ConstUserTypes::Admin;
                    $this->pageTitle.= ' - ' . __l('Site');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Inactive) {
                    $conditions['User.is_active'] = 0;
                    $this->pageTitle.= ' - ' . __l('Inactive');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Twitter) {
                    $conditions['User.is_twitter_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through Twitter');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Facebook) {
                    $conditions['User.is_facebook_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through Facebook');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::AngelList) {
                    $conditions['User.is_angellist_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through AngelList');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::LinkedIn) {
                    $conditions['User.is_linkedin_register'] = 1;
                    $this->pageTitle.= ' - ' . __l('Registered through LinkedIn');
                } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::AffiliateUser) {
                    $conditions['User.is_affiliate_user'] = 1;
                    $this->pageTitle.= ' - ' . __l('Affiliate Users');
                } else if (isPluginEnabled('LaunchModes') && $this->request->data['User']['filter_id'] == ConstMoreAction::Prelaunch) {
                    $conditions['User.site_state_id'] = ConstSiteState::Prelaunch;
                    $this->pageTitle.= ' - ' . __l('Pre-launch Users');
                } else if (isPluginEnabled('LaunchModes') && $this->request->data['User']['filter_id'] == ConstMoreAction::PrivateBeta) {
                    $conditions['User.site_state_id'] = ConstSiteState::PrivateBeta;
                    $this->pageTitle.= ' - ' . __l('Private Beta Users');
                }
                $this->request->params['named']['filter_id'] = $this->request->data['User']['filter_id'];
            }
            if (!empty($this->request->params['named']['q'])) {
                $conditions['AND']['OR'][]['User.email LIKE'] = '%' . $this->request->params['named']['q'] . '%';
                $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
                $this->request->data['User']['q'] = $this->request->params['named']['q'];
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            }
            if (!empty($this->request->params['named']['role_id'])) {
                $this->request->data['User']['role_id'] = $this->request->params['named']['role_id'];
                $conditions['User.role_id'] = $this->request->data['User']['role_id'];
            }
            if (!empty($this->request->query['user_id']) || !empty($this->request->query['username'])) {
                if (!empty($this->request->query['user_id'])) {
                    $conditions['AND']['OR'][]['User.id LIKE'] = '%' . $this->request->query['user_id'] . '%';
                } else {
                    $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->query['username'] . '%';
                }
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->query['username']);
            }
        }
        if ($this->RequestHandler->ext == 'csv') {
            Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['User']['q'])) {
                $this->set('q', $this->request->data['User']['q']);
            }
        } else {
            $this->User->recursive = 0;
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'Role',
                    'UserProfile' => array(
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        )
                    ) ,
                    'Transaction' => array(
                        'fields' => array(
                            'Transaction.amount',
                        ) ,
                        'conditions' => array(
                            'Transaction.transaction_type_id' => 4
                        )
                    ) ,
                    'UserAvatar',
                    'LastLoginIp' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'fields' => array(
                            'LastLoginIp.ip',
                            'LastLoginIp.latitude',
                            'LastLoginIp.longitude',
                            'LastLoginIp.host'
                        )
                    ) ,
                    'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host'
                        )
                    ) ,
                ) ,
                'limit' => 15,
                'order' => array(
                    'User.id' => 'desc'
                ) ,
            );
            $this->set('users', $this->paginate());
            $filters = $this->User->isFilterOptions;
            $moreActions = $this->User->moreActions;
            $userTypes = $this->User->Role->find('list', array(
                'recursive' => -1
            ));
            $this->set('filters', $filters);
            $this->set('moreActions', $moreActions);
            $this->set('userTypes', $userTypes);
        }
        unset($this->User->validate['username']);
    }
    public function admin_add()
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('User/Admin'));
        if (!empty($this->request->data)) {
            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
            $this->request->data['User']['is_email_confirmed'] = 1;
            $this->request->data['User']['is_active'] = 1;
            $this->request->data['User']['ip_id'] = $this->User->toSaveIp();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                if (!empty($this->request->data['UserProfile'])) {
                    $this->User->UserProfile->create();
                    $this->request->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                    $this->User->UserProfile->save($this->request->data['UserProfile']);
                }
                // Send mail to user to activate the account and send account details
                $emailFindReplace = array(
                    '##USERNAME##' => $this->request->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
                    '##PASSWORD##' => $this->request->data['User']['passwd'],
                );
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                $template = $this->EmailTemplate->selectTemplate('Admin User Add');
                $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('User')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->request->data['User']['passwd']);
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('User')) , 'default', null, 'error');
            }
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
        if (!isset($this->request->data['User']['role_id'])) {
            $this->request->data['User']['role_id'] = ConstUserTypes::User;
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('User')) , 'default', null, 'success');
            if (!empty($this->request->query['r'])) {
                $this->redirect(Router::url('/', true) . $this->request->query['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update()
    {
        $r = '';
        if (!empty($this->request->data['User'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['User'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $userIds[] = $user_id;
                }
            }
            if ($actionid && !empty($userIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->User->updateAll(array(
                        'User.is_active' => 0
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked users has been inactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->User->updateAll(array(
                        'User.is_active' => 1
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked users has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Delete');
                    }
                    $this->User->deleteAll(array(
                        'User.id' => $userIds
                    ));
                    $this->Session->setFlash(__l('Checked users has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Export) {
                    $user_ids = implode(',', $userIds);
                    $hash = $this->User->getUserIdHash($user_ids);
                    $_SESSION['user_export'][$hash] = $userIds;
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'export',
                        'ext' => 'csv',
                        $hash,
                        'admin' => true
                    ));
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function _sendAdminActionMail($user_id, $email_template)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.username',
                'User.email'
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate($email_template);
        if (!empty($user['User']['email'])) {
            $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
        }
    }
    public function admin_stats()
    {
        $this->pageTitle = __l('Snapshot');
    }
    public function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    public function admin_send_mail()
    {
        $this->pageTitle = __l('Email to users');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $conditions = $emails = array();
                $notSendCount = $sendCount = 0;
                if (!empty($this->request->data['User']['send_to'])) {
                    $sendTo = explode(',', $this->request->data['User']['send_to']);
                    foreach($sendTo as $email) {
                        $email = trim($email);
                        if (!empty($email)) {
                            if ($this->User->find('count', array(
                                'conditions' => array(
                                    'User.email' => $email
                                )
                            ))) {
                                $emails[] = $email;
                                $sendCount++;
                            } else {
                                $notSendCount++;
                            }
                        }
                    }
                }
                if (!empty($this->request->data['User']['bulk_mail_option_id'])) {
                    if ($this->request->data['User']['bulk_mail_option_id'] == 2) {
                        $conditions['User.is_active'] = 0;
                    }
                    if ($this->request->data['User']['bulk_mail_option_id'] == 3) {
                        $conditions['User.is_active'] = 1;
                    }
                    $users = $this->User->find('all', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($users)) {
                        $sendCount++;
                        foreach($users as $user) {
                            $emails[] = $user['User']['email'];
                        }
                    }
                }
                if (!empty($emails)) {
                    App::uses('CakeEmail', 'Network/Email');
                    $this->Email = new CakeEmail();
                    $content['text'] = $this->request->data['User']['message'] . "\n\nThanks \n" . Configure::read('site.name') . "\n" . Router::url('/', true);
					if (isPluginEnabled('HighPerformance') && Configure::read('mail.is_smtp_enabled')) {
						$this->Email->config('smtp');
					}
                    foreach($emails as $email) {
                        if (!empty($email)) {
                            $this->Email->from(Configure::read('EmailTemplate.no_reply_email'));
                            $this->Email->to(trim($email));
                            $this->Email->subject($this->request->data['User']['subject']);
                            $this->Email->emailFormat('text');
                            $this->Email->send($content);
                        }
                    }
                }
                if ($sendCount && !$notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully') , 'default', null, 'success');
                } elseif ($sendCount && $notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully. Some emails are not sent') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('No email send') , 'default', null, 'error');
                }
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'admin_send_mail',
                    'admin' => true
                ));
            } else {
                $this->Session->setFlash(__l('Mail could not be sent. Please, try again') , 'default', null, 'error');
            }
        }
        $bulkMailOptions = $this->User->bulkMailOptions;
        $this->set(compact('bulkMailOptions'));
    }
    public function admin_login()
    {
        $this->setAction('login');
    }
    public function admin_logout()
    {
        $this->setAction('logout');
    }
    public function facepile()
    {
        $conditions = array(
            'OR' => array(
                array(
                    'User.is_facebook_connected' => 1
                ) ,
                array(
                    'User.is_facebook_register' => 1
                )
            ) ,
            'User.is_active' => 1,
        );
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserAvatar'
            ) ,
            'order' => array(
                'User.created' => 'desc'
            ) ,
            'limit' => 12,
            'recursive' => 0
        ));
        $this->set('users', $users);
        $totalUserCount = $this->User->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $this->set('totalUserCount', $totalUserCount);
    }
    public function refer()
    {
        $referred_by_user_id = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($this->request->params['named']['r_value'])) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r_value']
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register',
                    'type' => 'social'
                ));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername) && (empty($referred_by_user_id) || (!empty($referred_by_user_id) && (!empty($user_refername)) && ($referred_by_user_id != $user_refername['User']['id'])))) {
            $this->Cookie->delete('referrer');
            $this->Cookie->write('referrer', $user_refername['User']['id'], false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register',
            'type' => 'social'
        ));
    }
    public function admin_diagnostics()
    {
        $this->pageTitle = __l('Diagnostics');
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_export($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'Ip'
            ) ,
            'fields' => array(
                'User.username',
                'User.email',
                'User.is_email_confirmed',
                'User.user_openid_count',
                'User.created',
                'User.total_amount_withdrawn',
                'User.unique_project_fund_count',
                'User.project_count',
                'User.user_login_count',
                'User.available_wallet_amount',
                'Ip.ip'
            ) ,
            'recursive' => 0
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $key => $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'Email Confirmed' => ($user['User']['is_email_confirmed']) ? __l("Yes") : __l("No") ,
                    'Login count' => $user['User']['user_login_count'],
                    'Sign Up IP' => $user['Ip']['ip'],
                    'Created on' => $user['User']['created'],
                    'Total Withdraw Amount' => $user['User']['total_amount_withdrawn'],
                );
                if (isPluginEnabled('Projects')) {
                    $project = array(
                        sprintf(__l('%s Count') , Configure::read('project.alt_name_for_project_singular_caps')) => $user['User']['project_count'],
                        sprintf(__l('%s Fund Count') , Configure::read('project.alt_name_for_project_singular_caps')) => $user['User']['unique_project_fund_count'],
                    );
                    $data[$key]['User'] = array_merge($data[$key]['User'], $project);
                }
                if (isPluginEnabled('Wallet')) {
                    $wallet = array(
                        __l('Available Balance') => $user['User']['available_wallet_amount']
                    );
                    $data[$key]['User'] = array_merge($data[$key]['User'], $wallet);
                }
            }
        }
        $this->set('data', $data);
    }
    public function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    public function admin_action_taken()
    {
        $this->set('pending_approval_users', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 0
            ) ,
            'recursive' => -1
        )));
    }
    public function admin_recent_users()
    {
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.role_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        $this->set(compact('recentUsers'));
    }
    public function admin_online_users()
    {
        $onlineUsers = $this->User->CkSession->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'DISTINCT CkSession.user_id',
                'User.username',
                'User.role_id',
                'User.id',
            ) ,
            'recursive' => 0,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        $this->set(compact('onlineUsers'));
    }
    public function update_email_notification()
    {
        $user_details = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $this->Auth->user('id') ,
            ) ,
            'recursive' => -1
        ));
        $is_send_activities_mail = $user_details['User']['is_send_activities_mail'];
        if (isset($this->request->params['named']['notify'])) {
            $notify = $this->request->params['named']['notify'];
            $user_data['User']['id'] = $this->Auth->user('id');
            if ($notify == 0) {
                $is_send_activities_mail = $user_data['User']['is_send_activities_mail'] = 1;
            } else {
                $is_send_activities_mail = $user_data['User']['is_send_activities_mail'] = 0;
            }
            $this->User->save($user_data);
        }
		if($user_details['User']['is_send_activities_mail'] == 0) {
			$this->request->data['User']['is_send_activities_mail'] = 1;
		} else {
			$this->request->data['User']['is_send_activities_mail'] = 0;
		}
        $this->set(compact('is_send_activities_mail'));
    }
    public function _referer_follow($user_id, $followed_user_id, $username)
    {
        $this->User->UserFollower->create();
        $this->request->data['UserFollower']['user_id'] = $user_id;
        $this->request->data['UserFollower']['followed_user_id'] = $followed_user_id;
        $this->request->data['UserFollower']['action'] = 'add';
        $this->User->UserFollower->save($this->request->data);
        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'UserFollower',
                'action' => 'Followed',
                'label' => $username,
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'ud' => $user_id,
            )
        ));
    }
    public function follow_friends()
    {
        $conditions = array();
        $type = $this->request->params['named']['type'];
        $social_conditions['SocialContact.user_id'] = $this->Auth->user('id');
        if ($type == 'facebook') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::facebook;
        } elseif ($type == 'twitter') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::twitter;
        }
        $this->loadModel('SocialMarketing.SocialContact');
        $this->loadModel('SocialMarketing.UserFollower');
        $socialContacts = $this->SocialContact->find('all', array(
            'conditions' => $social_conditions,
            'recursive' => 0
        ));
        if (!empty($socialContacts)) {
            if ($type == 'facebook') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['facebook_user_id'];
                }
                $conditions['User.facebook_user_id'] = $contacts;
            } else if ($type == 'twitter') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['twitter_user_id'];
                }
                $conditions['User.twitter_user_id'] = $contacts;
            } else if ($type == 'gmail' || $type == 'yahoo' || $type == 'linkedin') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['email'];
                }
                $conditions['User.email'] = $contacts;
            }
            $userFollowers = $this->UserFollower->find('all', array(
                'conditions' => array(
                    'UserFollower.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (!empty($userFollowers)) {
                foreach($userFollowers as $userFollower) {
                    $userFollowerIds[] = $userFollower['UserFollower']['followed_user_id'];
                }
                $userFollowerIds[] = $this->Auth->user('id');
                $conditions['User.id NOT'] = $userFollowerIds;
            }
            if ($this->Auth->user('is_facebook_register')) {
                $conditions['User.id NOT'] = $this->Auth->user('id');
            }
            $this->paginate = array(
                'conditions' => $conditions,
                'limit' => 15,
                'order' => array(
                    'User.id' => 'desc'
                ) ,
                'recursive' => -1
            );
            $this->set('followFriends', $this->paginate());
        }
    }
    public function admin_view_details()
    {
        $user_id = $this->request->params['named']['id'];
        $contain = array(
            'UserProfile' => array(
                'City',
                'State',
                'Country'
            )
        );
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'contain' => $contain,
            'recursive' => 2
        ));
		if (isPluginEnabled('JobsAct')) {
			$this->loadModel('JobsAct.JobsActEntry');
			$jobs = $this->JobsActEntry->find('first', array(
				'conditions' => array(
					'JobsActEntry.user_id' => $user_id
				) ,
				'recursive' => -1
			));
			$this->set('jobs', $jobs);
		}
        $this->set('user', $user);
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'user') {
            App::import('Model', 'User');
            $this->User = new User();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => -1
            ));
            $this->set('user', $user);
        }
        $this->layout = 'ajax';
    }
}
?>