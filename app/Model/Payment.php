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
class Payment extends AppModel
{
    var $useTable = false;
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
    public function processUserSignupPayment($user_id, $payment_gateway_id = null) 
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $user_id,
            ) ,
            'recursive' => -1,
        ));
        if (empty($user['User']['is_paid'])) {
            $_data = array();
            $_data['User']['id'] = $user['User']['id'];
            $_data['User']['is_paid'] = 1;
            if (empty($user['User']['is_openid_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_angellist_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register'])) {
                if (empty($user['User']['is_active'])) {
                    $_data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                }
                if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                    $this->User->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
                }
            }
            $this->User->save($_data);
            $this->User->Transaction->log($user['User']['id'], 'User', $payment_gateway_id, ConstTransactionTypes::SignupFee);
            $this->User->updateAll(array(
                'User.site_revenue' => Configure::read('User.signup_fee')
            ) , array(
                'User.id' => $user['User']['id']
            ));
            return true;
        }
        return false;
    }
}
?>