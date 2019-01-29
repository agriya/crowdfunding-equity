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
class User extends AppModel
{
    public $name = 'User';
    public $displayField = 'username';
    public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'LastLoginIp' => array(
            'className' => 'Ip',
            'foreignKey' => 'last_login_ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'UserOpenid' => array(
            'className' => 'UserOpenid',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserLogin' => array(
            'className' => 'UserLogin',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PersistentLogin' => array(
            'className' => 'PersistentLogin',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserView' => array(
            'className' => 'UserView',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserWebsite' => array(
            'className' => 'UserWebsite',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CkSession' => array(
            'className' => 'CkSession',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
    );
    public $hasOne = array(
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserAvatar' => array(
            'className' => 'UserAvatar',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'UserAvatar.class' => 'UserAvatar',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Chart',
            'UserProfile',
            'SocialMarketing',
            'Transaction',
            'Wallet',
            'AffiliateRequest',
			'ProjectFund'
        );
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
            'username' => array(
                'rule6' => array(
                    'rule' => array(
                        'maxLength',
                        30
                    ) ,
                    'message' => __l('Must be between of 4 to 30 characters')
                ) ,
                'rule5' => array(
                    'rule' => array(
                        'minLength',
                        4
                    ) ,
                    'message' => __l('Must be at least 4 characters')
                ) ,
                'rule4' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __l('Must be a valid character')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Username already exists')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[a-zA-Z]/'
                    ) ,
                    'message' => __l('Must be start with an alphabets')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'email' => array(
                'rule3' => array(
                    'rule' => 'isUnique',
                    'on' => 'create',
                    'message' => __l('Email address already exists')
                ) ,
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'passwd' => array(
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'old_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkOldPassword',
                        'old_password'
                    ) ,
                    'message' => __l('Your old password is incorrect, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_isPasswordSame',
                        'passwd',
                        'confirm_password'
                    ) ,
                    'message' => __l('New and confirm password field must match, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => '_isValidCaptcha',
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and conditions')
            ) ,
            'message' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'send_to' => array(
                'rule1' => array(
                    'rule' => '_checkMultipleEmail',
                    'message' => __l('Must be a valid email') ,
                    'allowEmpty' => true
                )
            ) ,
            'amount' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'remarks' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'security_question_id' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'security_answer' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'filters' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'conditions' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'value' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
        );
        // filter options in admin index
        $this->isFilterOptions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::OpenID => __l('OpenID') ,
            ConstMoreAction::Facebook => __l('Facebook') ,
            ConstMoreAction::Twitter => __l('Twitter')
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::Export => __l('Export')
        );
        $this->bulkMailOptions = array(
            1 => __l('All Users') ,
            2 => __l('Inactive Users') ,
            3 => __l('Active Users')
        );
        $this->filterOptions = array(
            ConstFilterOptions::Loggedin => __l('Loggedin Users') ,
            ConstFilterOptions::Refferred => __l('Refferred Users') ,
            ConstFilterOptions::Followed => __l('Followed Users') ,
            ConstFilterOptions::Voted => __l('Voted Users') ,
            ConstFilterOptions::Commented => __l('Commented Users') ,
            ConstFilterOptions::Funded => __l('Funded Amount Value') ,
            ConstFilterOptions::ProjectPosted => __l('Project Posted Amount Value')
        );
    }
    // check the new and confirm password
    function _isPasswordSame($field1 = array() , $field2 = null, $field3 = null) 
    {
        if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
            return true;
        }
        return false;
    }
    // check the old password field with database
    function _checkOldPassword($field1 = array() , $field2 = null) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ) ,
            'recursive' => -1
        ));
        if (crypt($this->data[$this->name][$field2], $user['User']['password']) == $user['User']['password']) {
            return true;
        }
        return false;
    }
    // hash for forgot password mail
    function getResetPasswordHash($user_id = null) 
    {
        return md5($user_id . '-' . date('Y-m-d') . Configure::read('Security.salt'));
    }
    // check the forgot password hash
    function isValidResetPasswordHash($user_id = null, $hash = null, $requested_date = null) 
    {
        return (md5($user_id . '-' . $requested_date . Configure::read('Security.salt')) == $hash);
    }
    // hash for activate mail
    function getActivateHash($user_id = null) 
    {
        return md5($user_id . '-' . Configure::read('Security.salt'));
    }
    // check the activate mail
    function isValidActivateHash($user_id = null, $hash = null) 
    {
        return (md5($user_id . '-' . Configure::read('Security.salt')) == $hash);
    }
    function _checkMultipleEmail() 
    {
        $multipleEmails = explode(',', $this->data['User']['send_to']);
        foreach($multipleEmails as $key => $singleEmail) {
            $email = trim($singleEmail);
            if (!empty($email) && !Validation::email(trim($email))) {
                return false;
            }
        }
        return true;
    }
    function _checkamount($amount) 
    {
        if (!empty($amount) && !is_numeric($amount)) {
            $this->validationErrors['amount'] = __l('Amount should be numeric');
        }
        if (empty($amount)) {
            $this->validationErrors['amount'] = __l('Required');
        }
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            $this->validationErrors['amount'] = __l('Amount should be greater than minimum amount') . ' (' . Configure::read('site.currency') . Configure::read('wallet.min_wallet_amount') . ')';
        }
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            $this->validationErrors['amount'] = sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('site.currency') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency') , Configure::read('wallet.max_wallet_amount'));
        }
        return false;
    }
    function getUserIdHash($user_ids = null) 
    {
        return md5($user_ids . Configure::read('Security.salt'));
    }
    function isValidUserIdHash($user_ids = null, $hash = null) 
    {
        return (md5($user_ids . Configure::read('Security.salt')) == $hash);
    }
    // hash for resend activate mail
    function getResendActivateHash($user_id = null) 
    {
        return md5(Configure::read('Security.salt') . '-' . $user_id);
    }
    // check the resend activate hash
    function isValidResendActivateHash($user_id = null, $hash = null) 
    {
        return (md5(Configure::read('Security.salt') . '-' . $user_id) == $hash);
    }
    function _checkUserBalance($user_id = null) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.available_wallet_amount',
                'User.blocked_amount',
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount']) {
            return $user['User']['available_wallet_amount'];
        }
        return false;
    }
    function checkUsernameAvailable($username) 
    {
        $user = $this->find('count', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'recursive' => -1
        ));
        if (!empty($user)) {
            return false;
        }
        return $username;
    }
    function _sendActivationMail($user_email, $user_id, $hash) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user_id,
                $hash
            ) , true) ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Activation Request');
        $this->_sendEmail($template, $emailFindReplace, $user_email);
        return true;
    }
    function _sendWelcomeMail($user_id, $user_email, $username) 
    {
        $emailFindReplace = array(
            '##USERNAME##' => $username,
            '##CONTACT_MAIL##' => Configure::read('EmailTemplate.admin_email') ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Welcome Email');
        $this->_sendEmail($template, $emailFindReplace, $user_email);
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $foreign_id
            ) ,
            'recursive' => -1
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        $return['amount'] = array(
            Configure::read('User.signup_fee')
        );
		$return['fees_payer'] = 'buyer';
        if (Configure::read('User.signup_fee_payeer') == 'Site') {
            $return['fees_payer'] = 'merchant';
        }
        $return['action'] = 'Capture';
        $return['buyer_email'] = $user['User']['email'];
        $return['sudopay_gateway_id'] = $user['User']['sudopay_gateway_id'];
        return $return;
    }
    // hash for activate mail
    function getInviteHash() 
    {
        return md5(strtotime('Now') . '-' . Configure::read('Security.salt'));
    }
    public function updateSocialContact($social_profile, $social_type) 
    {
        $identifier = $social_profile->identifier;
        $_data['User']['id'] = $_SESSION['Auth']['User']['id'];
        $session_data = $_SESSION['HA::STORE'];
        $stored_access_token = $session_data['hauth_session.' . $social_type . '.token.access_token'];
        $temp_access_token = explode(":", $stored_access_token);
        $temp_access_token = str_replace('"', '', $temp_access_token);
        $temp_access_token = str_replace(';', '', $temp_access_token);
        $access_token = $temp_access_token[2];
        if ($social_type == 'facebook') {
            $_data['User']['is_facebook_connected'] = 1;
            $_data['User']['facebook_access_token'] = $access_token;
            $_data['User']['facebook_user_id'] = $identifier;
        } elseif ($social_type == 'twitter') {
            $_data['User']['is_twitter_connected'] = 1;
            $_data['User']['twitter_access_token'] = $access_token;
            $_data['User']['twitter_user_id'] = $identifier;
            $_data['User']['twitter_avatar_url'] = $social_profile->photoURL;
        } elseif ($social_type == 'google') {
            $_data['User']['is_google_connected'] = 1;
            $_data['User']['google_user_id'] = $identifier;
        } elseif ($social_type == 'googleplus') {
            $_data['User']['is_googleplus_connected'] = 1;
            $_data['User']['googleplus_user_id'] = $identifier;
        } elseif ($social_type == 'angellist') {
            $_data['User']['is_angellist_connected'] = 1;
            $_data['User']['angellist_user_id'] = $identifier;
        } elseif ($social_type == 'yahoo') {
            $_data['User']['is_yahoo_connected'] = 1;
            $_data['User']['yahoo_user_id'] = $identifier;
        } elseif ($social_type == 'linkedin') {
            $_data['User']['is_linkedin_connected'] = 1;
            $_data['User']['linkedin_access_token'] = $access_token;
            $_data['User']['linkedin_user_id'] = $identifier;
			$_data['User']['linkedin_avatar_url'] = $social_profile->photoURL;
        }
        $this->save($_data);
    }
    public function _checkConnection($social_profile, $social_type) 
    {
        $identifier = $social_profile->identifier;
        $conditions = array();
        $conditions['User.' . $social_type . '_user_id'] = $identifier;
        $conditions['OR'] = array(
            'User.is_' . $social_type . '_register' => 1,
            'User.is_' . $social_type . '_connected' => 1
        );
        $user = $this->find('first', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        if (empty($user)) {
            return true;
        } else {
            if ($user['User']['id'] == $_SESSION['Auth']['User']['id']) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>