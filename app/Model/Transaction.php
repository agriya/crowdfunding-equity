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
class Transaction extends AppModel
{
    public $name = 'Transaction';
    public $actsAs = array(
        'Polymorphic' => array(
            'classField' => 'class',
            'foreignKey' => 'foreign_id',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'TransactionType' => array(
            'className' => 'TransactionType',
            'foreignKey' => 'transaction_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'ForeignUser' => array(
            'className' => 'User',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'ReceiverUser' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
    function log($foreign_id = null, $class = '', $payment_gateway_id = null, $transaction_type_id = null) 
    {
        $model_class = explode('.', $class);
        if (!empty($model_class[1])) {
            $class = $model_class[1];
        }
        App::import('Model', $class);
        $obj = new $class();
        $data = $obj->find('first', array(
            'conditions' => array(
                $class . '.id' => $foreign_id
            ) ,
            'recursive' => -1
        ));
        $amount = 0;
        if ($transaction_type_id == ConstTransactionTypes::SignupFee) {
            $amount = Configure::read('User.signup_fee');
        } elseif ($transaction_type_id == ConstTransactionTypes::ListingFee) {
            $amount = $data[$class]['fee_amount'];
        } else {
            $amount = $data[$class]['amount'];
        }
        if (in_array($transaction_type_id, array(
            ConstTransactionTypes::AdminAddFundToWallet,
            ConstTransactionTypes::AdminDeductFundFromWallet
        ))) {
            $user_id = $_SESSION['Auth']['User']['id'];
        } elseif ($transaction_type_id == ConstTransactionTypes::SignupFee) {
            $user_id = $foreign_id;
        } elseif ($transaction_type_id == ConstTransactionTypes::Refunded) {
            $user_id = $data[$class]['owner_user_id'];
        } else {
            $user_id = $data[$class]['user_id'];
        }
        if (in_array($transaction_type_id, array(
            ConstTransactionTypes::SignupFee,
            ConstTransactionTypes::ListingFee
        ))) {
            $receiver_user_id = ConstUserIds::Admin;
        } elseif (in_array($transaction_type_id, array(
            ConstTransactionTypes::ProjectBacked,
            ConstTransactionTypes::ProjectRepayment
        ))) {
            $receiver_user_id = $data[$class]['owner_user_id'];
        } else {
            $receiver_user_id = $data[$class]['user_id'];
        }
        if ($transaction_type_id == ConstTransactionTypes::ProjectRepayment) {
            $foreign_id = $data['ProjectFundRepayment']['project_id'];
        }
        $_data = array();
        $_data['Transaction']['user_id'] = $user_id;
        $_data['Transaction']['receiver_user_id'] = $receiver_user_id;
        $_data['Transaction']['foreign_id'] = $foreign_id;
        $_data['Transaction']['class'] = $class;
        $_data['Transaction']['amount'] = $amount;
        $_data['Transaction']['payment_gateway_id'] = $payment_gateway_id;
        $_data['Transaction']['transaction_type_id'] = $transaction_type_id;
        if ($transaction_type_id == ConstTransactionTypes::ProjectBacked) {
            $_data['Transaction']['site_commission'] = $data[$class]['site_fee'];
        }
        if (in_array($transaction_type_id, array(
            ConstTransactionTypes::ProjectBacked,
            ConstTransactionTypes::Refunded,
            ConstTransactionTypes::ListingFee
        ))) {
            $_data['Transaction']['project_type_id'] = $data[$class]['project_type_id'];
        }
        if (in_array($transaction_type_id, array(
            ConstTransactionTypes::AdminAddFundToWallet,
            ConstTransactionTypes::AdminDeductFundFromWallet
        ))) {
            $_data['Transaction']['remarks'] = $data[$class]['description'];
        }
        if (in_array($transaction_type_id, array(
            ConstTransactionTypes::CashWithdrawalRequestApproved,
            ConstTransactionTypes::AffiliateCashWithdrawalRequestApproved
        ))) {
            $_data['Transaction']['remarks'] = $data[$class]['remark'];
        }
        $this->create();
        $this->save($_data);
        return $this->getLastInsertId();
    }
    public function beforeFind($query) 
    {
        $projectTypes = $this->getProjectTypes();
        $projectTypes[] = 0;
        $query['conditions'][$this->alias . '.project_type_id'] = $projectTypes;
        return $query;
    }
}
?>