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
App::uses('Controller', 'Controller');
class AppController extends Controller
{
    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Security',
        'Auth',
        'Acl.AclFilter',
        'XAjax',
        'RequestHandler',
        'Cookie',
        'Cms',
    );
    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Javascript',
        'Session',
        'Text',
        'Js',
        'Time',
        'Layout',
        'Auth',
    );
    /**
     * Models
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Block',
        'Link',
        'Setting',
        'Node',
    );
    /**
     * Pagination
     */
    public $paginate = array(
        'limit' => 10,
    );
    /**
     * Cache pagination results
     *
     * @var boolean
     * @access public
     */
    public $usePaginationCache = true;
    /**
     * View
     *
     * @var string
     * @access public
     */
    public $viewClass = 'Theme';
    /**
     * Theme
     *
     * @var string
     * @access public
     */
    public $theme;
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct($request = null, $response = null)
    {
        // We created objects for all used components here, for reducing $this size.
        // This is avoid looping component collection
        // But still we are use some components in $components variable. Those are should be in component collection
        App::uses('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Security');
        $this->Security = new SecurityComponent($collection);
        App::import('Component', 'Auth');
        $this->Auth = new AuthComponent($collection);
        App::import('Component', 'Session');
        $this->Session = new SessionComponent($collection);
        Cms::applyHookProperties('Hook.controller_properties', $this);
        parent::__construct($request, $response);
        /*if (!defined('STDIN') && $_SERVER['HTTP_HOST'] != 'localhost' && strstr($_SERVER['HTTP_HOST'], '.dev1.agriya.com') != '.dev1.agriya.com' && strstr($_SERVER['HTTP_HOST'], '.servicepg.develag.com') != '.servicepg.develag.com' && strstr($_SERVER['HTTP_HOST'], '.cssilize.com') != '.cssilize.com') {
            if (!defined('LICENSE_HASH')) {
                die('Sorry invalid license');
            }
        }*/
        if ($this->name == 'CakeError') {
            $this->_set(Router::getPaths());
            $this->request->params = Router::getParams();
            $this->constructClasses();
            $this->startupProcess();
        }
    }
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        parent::beforeRender();
    }
    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        if ($this->Auth->user('id')) {
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
        }
        if (!$this->Auth->user('id') && !empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        if ($this->Auth->user('id') && empty($_COOKIE['_gz'])) {
            $hashed_val = md5($this->Auth->user('id') . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $this->Auth->user('id') . '|' . $hashed_val;
            setcookie('_gz', $form_cookie, time() +60*60*24, '/');
        }
        $is_redirect_to_social_marketing = 1;
        if (Configure::read('User.signup_fee') && $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $fee_urls = array(
                'users/login',
                'users/logout',
                'payments/user_pay_now',
                'payments/get_gateways',
                'sudopays/process_ipn',
                'sudopays/success_payment',
                'sudopays/cancel_payment',
                'messages/activities',
                'users/show_header',
                'nodes/view',
            );
            if ((!in_array($cur_page, $fee_urls) && empty($user['User']['is_paid'])) && !$this->RequestHandler->prefers('json')) {
                if (!$this->RequestHandler->prefers('json')) {
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'user_pay_now',
                        $this->Auth->user('id') ,
                        $this->User->getActivateHash($this->Auth->user('id'))
                    ));
                }
            }
            if (empty($user['User']['is_paid'])) {
                $is_redirect_to_social_marketing = 0;
            }
        }
		if($this->RequestHandler->prefers('json')) {
           $is_redirect_to_social_marketing = 0;
        }
        if (isPluginEnabled('SocialMarketing') && empty($this->request->params['requested']) && !empty($is_redirect_to_social_marketing)) {
            $skip_urls = array(
                'users/login',
                'users/logout',
                'devs/asset_js',
                'devs/asset_css',
                'social_marketings/import_friends',
                'social_contacts/index',
                'social_contacts/update',
                'users/follow_friends',
                'user_followers/add_multiple',
                'messages/activities',
                'users/show_header',
                'social_marketings/publish_success',
            );
            if ($this->Auth->user('id') && !in_array($cur_page, $skip_urls) && !empty($user) && (!$user['User']['is_skipped_fb'] || !$user['User']['is_skipped_twitter'] || !$user['User']['is_skipped_google'] || !$user['User']['is_skipped_yahoo'])) {
                if (!$user['User']['is_skipped_fb']) {
                    $type = 'facebook';
                } elseif (!$user['User']['is_skipped_twitter']) {
                    $type = 'twitter';
                } elseif (!$user['User']['is_skipped_google']) {
                    $type = 'gmail';
                } elseif (!$user['User']['is_skipped_yahoo']) {
                    $type = 'yahoo';
                } elseif (!$user['User']['is_skipped_linkedin']) {
                    $type = 'linkedin';
                }
                if (!$this->RequestHandler->prefers('json'))
                {
                    $this->redirect(array(
                        'controller' => 'social_marketings',
                        'action' => 'import_friends',
                        'type' => $type,
                        'admin' => false
                    ));
                }
            }
        }
        if (isPluginEnabled('LaunchModes')) {
            $pre_launch_exception_array = array(
                'subscriptions/add',
                'subscriptions/check_invitation',
                'subscriptions/confirmation',
                'users/logout',
                'users/facepile',
                'nodes/view',
                'projects/index',
                'pages/view',
                'images/view',
                'devs/asset_js',
                'devs/asset_css',
                'devs/robots',
                'devs/sitemap',
                'users/show_captcha',
                'users/captcha_play',
                'payments/user_pay_now',
                'payments/get_gateways',
                'users/show_header',
            );
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Pre-launch' && !in_array($cur_page, $pre_launch_exception_array)) {
                    if (empty($this->request->params['prefix'])) {
						$this->redirect("/");
                    }
                }
            }
            $private_beta_exception_array = array_merge($pre_launch_exception_array, array(
                'users/login',
                'users/logout',
                'users/register',
                'users/admin_login',
                'users/show_header',
                'users/forgot_password',
                'users/activation',
                'users/reset',
                'payments/user_pay_now',
                'payments/_processPayment',
                'payments/success_payment',
                'payments/cancel_payment',
                'payments/get_gateways',
            ));
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Private Beta' && !in_array($cur_page, $private_beta_exception_array) && !$this->Auth->user('id')) {
                    if (empty($this->request->params['prefix'])) {
						$this->redirect("/");
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                }
            }
        }
        // Coding done to disallow demo user to change the admin settings
        if ($this->request->params['action'] != 'flashupload') {
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if ($this->Auth->user('id') && !Configure::read('site.is_admin_settings_enabled') && (in_array($this->request->params['action'], Configure::read('site.admin_demo_mode_not_allowed_actions')) || (!empty($this->request->data) && in_array($cur_page, Configure::read('site.admin_demo_mode_update_not_allowed_pages'))))) {
                $this->Session->setFlash(__l('Sorry. We have disabled this action in demo mode') , 'default', null, 'error');
                if (in_array($this->request->params['controller'], array(
                    'settings',
                    'email_templates'
                ))) {
                    unset($this->request->data);
                } else {
                    $this->redirect(array(
                        'controller' => $this->request->params['controller'],
                        'action' => 'index'
                    ));
                }
            }
        }
        // check ip is banned or not. redirect it to 403 if ip is banned
        $this->loadModel('BannedIp');
        $bannedIp = $this->BannedIp->_checkIsIpBanned($this->RequestHandler->getClientIP());
        if (empty($bannedIp)) {
            $bannedIp = $this->BannedIp->_checkRefererBlocked(env('HTTP_REFERER'));
        }
        if (!empty($bannedIp)) {
            if (!empty($bannedIp['BannedIp']['redirect'])) {
                header('location: ' . $bannedIp['BannedIp']['redirect']);
            } else {
                throw new ForbiddenException(__l('Invalid request'));
            }
        }
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
        $maintenance_exception_array = array(
            'devs/asset_js',
            'devs/asset_css',
            'devs/robots',
            'devs/sitemap',
            'users/show_header',
        );
        if (Configure::read('site.maintenance_mode') && $this->Auth->user('role_id') != ConstUserTypes::Admin && empty($this->request->params['prefix']) && !in_array($cur_page, $maintenance_exception_array)) {
            throw new MaintenanceModeException(__l('Maintenance Mode'));
        }
        if (Configure::read('site.is_ssl_enabled')) {
            $secure_array = array(
                'users/login',
                'users/admin_login',
                'users/register',
                'users/add_to_wallet',
                'payments/project_pay_now',
                'payments/user_pay_now',
                'payments/order',
                'projects/project_pay_now',
            );
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if (in_array($cur_page, $secure_array)) {
                $this->Security->blackHoleCallback = 'forceSSL';
                $this->Security->requireSecure($this->request->params['action']);
            } else if (env('HTTPS') && !$this->RequestHandler->isAjax()) {
                $this->_unforceSSL();
            }
        }
        // Writing site name in cache, required for getting sitename retrieving in cron
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , 'long');
        }
        // referral link that update cookies
        $this->_affiliate_referral();
        if (!empty($_GET['key']) && isPluginEnabled('MobileApp')) {
            Cms::dispatchEvent('Controller.Project.handleApp', $this);
        }
        $this->AclFilter->_checkAuth();
        //Fix to upload the file through the flash multiple uploader
        if ((isset($_SERVER['HTTP_USER_AGENT']) and ((strtolower($_SERVER['HTTP_USER_AGENT']) == 'shockwave flash') or (strpos(strtolower($_SERVER['HTTP_USER_AGENT']) , 'adobe flash player') !== false))) and isset($this->request->params['pass'][0]) and ($this->request->action == 'flashupload')) {
            $this->Session->id($this->request->params['pass'][0]);
        }
        if (Configure::read('site.theme')) {
            $this->theme = Configure::read('site.theme');
        }
        if (isset($this->request->params['locale'])) {
            Configure::write('Config.language', $this->request->params['locale']);
        }
        $this->layout = 'default';
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin && (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (Configure::read('site.maintenance_mode') && !$this->Auth->user('role_id')) {
            $this->layout = 'maintenance';
        }
        if ($this->Auth->user('id')) {
            App::import('Model', 'User');
            $user_model_obj = new User();
            $user = $user_model_obj->find('first', array(
                'conditions' => array(
                    'User.id =' => $this->Auth->user('id') ,
                ) ,
                'contain' => array(
                    'UserAvatar',
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $this->set('logged_in_user', $user);
            $count_conditions = array();
            $count_conditions = array(
                'Project.user_id' => $user['User']['id'],
                'Project.is_admin_suspended !=' => 1,
                'Project.is_active' => 1,
            );
            $conditions = array();
            $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
                'type' => 'project_count',
                'page' => 'userview'
            ));
            $countContain = array();
            if (isPluginEnabled('Pledge')) {
                $countContain['Pledge'] = array();
            }
            if (isPluginEnabled('Donate')) {
                $countContain['Donate'] = array();
            }
            if (isPluginEnabled('Equity')) {
                $countContain['Equity'] = array();
            }
            if (isPluginEnabled('Lend')) {
                $countContain['Lend'] = array();
            }
            if (!empty($response->data['conditions'])) {
                $conditions = array_merge($count_conditions, $response->data['conditions']);
            }
            $project_count = $user_model_obj->Project->find('count', array(
                'conditions' => $conditions,
                'contain' => $countContain,
                'recursive' => 0
            ));
            $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
                'type' => 'all_project_count',
                'page' => 'userview'
            ));
            if (!empty($response->data['conditions'])) {
                $conditions = array_merge($count_conditions, $response->data['conditions']);
            }
            $all_project_count = $user_model_obj->Project->find('count', array(
                'conditions' => $conditions,
                'contain' => $countContain,
                'recursive' => 0
            ));
            $this->set('project_count', $project_count);
            $this->set('all_project_count', $all_project_count);
            $conditions = array();
            $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
                'type' => 'idea_count',
                'contain' => $countContain,
                'page' => 'userview'
            ));
            if (!empty($response->data['conditions'])) {
                $conditions = array_merge($count_conditions, $response->data['conditions']);
            }
            $idea_count = $user_model_obj->Project->find('count', array(
                'conditions' => $conditions,
                'recursive' => 0
            ));
            $this->set('idea_count', $idea_count);
            $count_conditions = array();
            $count_conditions = array(
                'Project.is_admin_suspended !=' => 1,
                'Project.is_active' => 1,
            );
            if (isPluginEnabled('ProjectFollowers')) {
                $projectIds = $user_model_obj->Project->ProjectFollower->find('list', array(
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
            }
            $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
                'type' => 'count',
                'page' => 'userview'
            ));
            if (!empty($response->data['conditions'])) {
                $conditions = array_merge($count_conditions, $response->data['conditions']);
            }
            $project_following_count = $user_model_obj->Project->find('count', array(
                'conditions' => $conditions,
                'contain' => $countContain,
                'recursive' => 0
            ));
            $this->set('project_following_count', $project_following_count);
        }
        // to check wallet disable/enable
        App::import('Model', 'PaymentGateway');
        $payment_gateway = new PaymentGateway();
        $this->is_wallet_enabled = $payment_gateway->find('count', array(
            'conditions' => array(
                'PaymentGateway.id =' => ConstPaymentGateways::Wallet,
                'PaymentGateway.is_active =' => 1,
            ) ,
            'recursive' => -1
        ));
        $this->set('is_wallet_enabled', $this->is_wallet_enabled);
    }
    function _unum()
    {
        $acceptedChars = '0123456789';
        $max = strlen($acceptedChars) -1;
        $unique_code = '';
        for ($i = 0; $i < 8; $i++) {
            $unique_code.= $acceptedChars{mt_rand(0, $max) };
        }
        return $unique_code;
    }
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->query[$param_name])) { // querystring
                    $query_strings[$param_name] = $this->request->query[$param_name];
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    function _redirectPOST2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        $model = Inflector::classify($this->request->params['controller']);
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->data[$model][$param_name])) { // querystring
                    $query_strings[$param_name] = strip_tags($this->request->data[$model][$param_name]);
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            if ($this->{$this->modelClass}->Behaviors->attached('SuspiciousWordsDetector')) {
                $this->{$this->modelClass}->Behaviors->detach('SuspiciousWordsDetector');
            }
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Inactive:
                        $field_name = 'is_active';
                        $successMessage = __l('Checked records has been inactivated');
                        if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                            $field_name = 'is_approved';
                        }
                        if ($this->modelClass == 'Blog') {
                            $field_name = 'is_published';
                        }
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'User') {
                            foreach($ids as $key => $user_id) {
                                $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                            }
                            $successMessage = __l('Checked users has been inactivated');
                        }
                        $this->Session->setFlash($successMessage, 'default', null, 'success');
                        break;

                    case ConstMoreAction::Active:
                        $field_name = 'is_active';
                        $successMessage = __l('Checked records has been activated');
                        if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                            $field_name = 'is_approved';
                        }
                        if ($this->modelClass == 'Blog') {
                            $field_name = 'is_published';
                        }
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'User') {
                            foreach($ids as $key => $user_id) {
                                $this->_sendAdminActionMail($user_id, 'Admin User Active');
                            }
                            $successMessage = __l('Checked users has been activated');
                        }
                        $this->Session->setFlash($successMessage, 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        $successMessage = __l('Checked records has been deleted');
                        if ($this->modelClass == 'Message') {
                            foreach($ids as $id) {
                                $this->Message->MessageContent->delete($id, true);
                            }
                        } else {
                            $this->{$this->modelClass}->deleteAll(array(
                                $this->modelClass . '.id' => $ids
                            ));
                        }
                        if ($this->modelClass == 'User') {
                            foreach($ids as $key => $user_id) {
                                $this->_sendAdminActionMail($user_id, 'Admin User Delete');
                            }
                            $successMessage = __l('Checked users has been deleted');
                        }
                        $this->Session->setFlash($successMessage, 'default', null, 'success');
                        break;

                    case ConstMoreAction::Suspend:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.is_admin_suspended' => 1
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
                        } else {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_admin_suspended' => 1
                            ) , array(
                                $this->modelClass . '.id' => $ids
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been suspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsuspend:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.is_admin_suspended' => 0
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
                        } else {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_admin_suspended' => 0
                            ) , array(
                                $this->modelClass . '.id' => $ids
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been unsuspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Flagged:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.is_system_flagged' => 1
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
                        } else {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_system_flagged' => 1
                            ) , array(
                                $this->modelClass . '.id' => $ids
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been flagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unflagged:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.is_system_flagged' => 0
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
                        } else {
                            $this->{$this->modelClass}->updateAll(array(
                                $this->modelClass . '.is_system_flagged' => 0
                            ) , array(
                                $this->modelClass . '.id' => $ids
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been unflagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Disapproved:
                        $field_name = 'is_approved';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been disapproved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Approved:
                        $field_name = 'is_approved';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Subscribed:
                        $field_name = 'is_subscribed';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been subscribed') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsubscribed:
                        $field_name = 'is_subscribed';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unsubscribed') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unpublish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unpublished') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Publish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been published') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unpromote:
                        $field_name = 'promote';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been promoted') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Promote:
                        $field_name = 'promote';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been depromoted') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Export:
                        $user_ids = implode(',', $ids);
                        $hash = $this->User->getUserIdHash($user_ids);
                        $_SESSION['user_export'][$hash] = $ids;
                        $this->Session->setFlash(__l('Checked records has been exported') , 'default', null, 'success');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'export',
                            'ext' => 'csv',
                            $hash,
                            'admin' => true
                        ) , true);
                        break;
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function admin_update_status($id = null, $action = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) {
            $field_name = 'is_active';
            if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                $field_name = 'is_approved';
            } elseif ($this->request->params['controller'] == 'blocks' || $this->request->params['controller'] == 'nodes' || $this->request->params['controller'] == 'links') {
                $field_name = 'status';
            } elseif ($this->request->params['controller'] == 'Project') {
                $field_name = 'is_system_flagged';
            } elseif ($this->request->params['controller'] == 'blogs') {
                $field_name = 'is_published';
            }
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 1;
            $this->{$this->modelClass}->save($_data);
            if ($this->modelClass == 'User') {
                $this->_sendAdminActionMail($id, 'Admin User Active');
            }
            $this->Session->setFlash(__l('Selected record has been activated') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'deactivate')) {
            $field_name = 'is_system_flagged';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 0;
            $this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been unflagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'userflag-deactivate')) {
            $field_name = 'is_user_flagged';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 0;
            $this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been unflagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'approved')) {
            $field_name = 'is_approved';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 1;
            $this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been approved') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'inactive')) {
            $field_name = 'is_active';
            if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                $field_name = 'is_approved';
            } elseif ($this->request->params['controller'] == 'blocks' || $this->request->params['controller'] == 'nodes' || $this->request->params['controller'] == 'links') {
                $field_name = 'status';
            }
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 0;
            $this->{$this->modelClass}->save($_data);
            if ($this->modelClass == 'User') {
                $this->_sendAdminActionMail($id, 'Admin User Deactivate');
            }
            $this->Session->setFlash(__l('Selected record has been inactivated') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'disapproved')) {
            $field_name = 'is_approved';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 0;
            $this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been disapproved') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'flag')) {
            if ($this->modelClass == 'Message') {
                $data = array();
                $data['MessageContent']['is_system_flagged'] = 1;
                $data['MessageContent']['id'] = $id;
                $this->Message->MessageContent->save($data);
            } else {
                $field_name = 'is_system_flagged';
                $_data = array();
                $_data[$this->modelClass]['id'] = $id;
                $_data[$this->modelClass][$field_name] = 1;
                $this->{$this->modelClass}->save($_data);
            }
            $this->Session->setFlash(__l('Selected record has been flagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unflag')) {
            if ($this->modelClass == 'Message') {
                $data = array();
                $data['MessageContent']['is_system_flagged'] = 0;
                $data['MessageContent']['id'] = $id;
                $this->Message->MessageContent->save($data);
            } else {
                $field_name = 'is_system_flagged';
                $_data = array();
                $_data[$this->modelClass]['id'] = $id;
                $_data[$this->modelClass][$field_name] = 0;
                $this->{$this->modelClass}->save($_data);
            }
            $this->Session->setFlash(__l('Selected record has been unflagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'suspend')) {
            if ($this->modelClass == 'Message') {
                $data = array();
                $data['MessageContent']['is_admin_suspended'] = 1;
                $data['MessageContent']['id'] = $id;
                $this->Message->MessageContent->save($data);
            } elseif ($this->modelClass == 'Project') {
                // refund amount
                $field_name = 'is_admin_suspended';
                $_data = array();
                $_data[$this->modelClass]['id'] = $id;
                $_data[$this->modelClass][$field_name] = 1;
                $this->{$this->modelClass}->save($_data);
            } else {
                $field_name = 'is_admin_suspended';
                $_data = array();
                $_data[$this->modelClass]['id'] = $id;
                $_data[$this->modelClass][$field_name] = 1;
                $this->{$this->modelClass}->save($_data);
            }
            $this->Session->setFlash(__l('Selected record has been suspended') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unsuspend')) {
            if ($this->modelClass == 'Message') {
                $data = array();
                $data['MessageContent']['is_admin_suspended'] = 0;
                $data['MessageContent']['id'] = $id;
                $this->Message->MessageContent->save($data);
            } else {
                $field_name = 'is_admin_suspended';
                $_data = array();
                $_data[$this->modelClass]['id'] = $id;
                $_data[$this->modelClass][$field_name] = 0;
                $this->{$this->modelClass}->save($_data);
            }
            $this->Session->setFlash(__l('Selected record has been unsuspended') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'featured')) {
            $field_name = 'is_featured';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 1;
            $this->{$this->modelClass}->save($_data);
            @unlink(APP . 'webroot' . DS . 'index.html');
            $this->Session->setFlash(__l('Selected record has been marked as featured') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'notfeatured')) {
            $field_name = 'is_featured';
            $_data = array();
            $_data[$this->modelClass]['id'] = $id;
            $_data[$this->modelClass][$field_name] = 0;
            $this->{$this->modelClass}->save($_data);
            @unlink(APP . 'webroot' . DS . 'index.html');
            $this->Session->setFlash(__l('Selected record has been marked as not featured') , 'default', null, 'success');
        }
        if (!empty($this->request->query['r'])) {
            $this->redirect(Router::url('/', true) . $this->request->query['r']);
        } else {
            if ($this->request->params['controller'] == 'links' && $this->request->params['action'] == 'admin_update_status') {
                $this->redirect(array(
                    'controller' => $this->request->controller,
                    'action' => 'index',
                    $this->request->params['named']['menu_id']
                ));
            } elseif ($this->request->params['controller'] == 'projects' && !empty($this->request->params['named']['project_type'])) {
                $this->redirect(array(
                    'controller' => Inflector::pluralize($this->request->params['named']['project_type']) ,
                    'action' => 'index'
                ));
            } else {
                $this->redirect(array(
                    'controller' => $this->request->controller,
                    'action' => 'index',
                ));
            }
        }
    }
    public function isAutoSuspendEnabled($model)
    {
        if (Configure::read('suspicious_detector.is_enabled') && Configure::read('suspicious_detector.auto_suspend_' . $model . '_on_system_flag')) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show_captcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    public function captcha_play($session_var = null)
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        $img->session_var = $session_var;
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
        $this->autoRender = false;
    }
    public function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_active'])) {
            $conditions['is_active'] = '1';
        }
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    function forceSSL()
    {
        if (!env('HTTPS')) {
            $this->redirect('https://' . env('SERVER_NAME') . $this->here);
        }
    }
    function _unforceSSL()
    {
        if (empty($this->request->params['requested'])) {
            $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
        }
    }
    function _affiliate_referral()
    {
        if (!empty($this->request->params['named']['r'])) {
            $this->loadModel('User');
            $referrer = array();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r'],
                    'User.is_affiliate_user' => 1
                ) ,
                'fields' => array(
                    'User.username',
                    'User.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                // not check for particular url or page, so that set in refer_id in common, future apply for specific url
                $referrer['refer_id'] = $user['User']['id'];
                if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'jobs') {
                    if (!empty($this->request->params['named']['category'])) {
                        $referrer['refer_id'] = $user['User']['id'];
                        $referrer['type'] = 'category';
                        $referrer['slug'] = $this->request->params['named']['category'];
                    } else if (!empty($this->request->params['action']) && $this->request->params['action'] == 'view') {
                        $referrer['refer_id'] = $user['User']['id'];
                        $referrer['type'] = 'view';
                        $referrer['slug'] = $this->request->params['pass']['0'];
                    }
                } else if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'users') {
                    $referrer['refer_id'] = $user['User']['id'];
                    $referrer['type'] = 'user';
                    $referrer['slug'] = '';
                }
                $this->Cookie->delete('referrer');
                $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
                $_SESSION['refer_id'] = $user['User']['id'];
                $r_value = $this->request->params['named']['r'];
                unset($this->request->params['named']['r']);
                $params = '';
                foreach($this->request->params['pass'] as $value) {
                    $params.= $value . '/';
                }
                foreach($this->request->params['named'] as $key => $value) {
                    $params.= $key . ':' . $value . '/';
                }
                $this->redirect(array(
                    'controller' => $this->request->params['controller'],
                    'action' => $this->request->params['action'],
                    'r_value' => $r_value,
                    $params
                ));
            }
        }
    }
}
