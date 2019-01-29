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
class Wallet extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
    public function processPayToProject($user_id, $total_amount, $project_id) 
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount'] < ($total_amount)) {
            return false;
        } else {
            App::import('Model', 'Projects.Project');
            $this->Project = new Project();
            $return['error'] = 0;
            $buyer_info = $user;
            // Updating buyer balance //
            $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-$total_amount;
            $this->Project->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
            ) , array(
                'User.id' => $user_id
            ));
            $project = $this->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $project_id
                ) ,
                'contain' => array(
                    'ProjectType'
                ) ,
                'recursive' => 0
            ));
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                '_addTrans' => array(
                    'order_id' => 'ProjectListing-' . $project['Project']['id'],
                    'name' => $project['Project']['name'],
                    'total' => $project['Project']['fee_amount']
                ) ,
                '_addItem' => array(
                    'order_id' => 'ProjectListing-' . $project['Project']['id'],
                    'sku' => 'P' . $project['Project']['id'],
                    'name' => $project['Project']['name'],
                    'category' => $project['ProjectType']['name'],
                    'unit_price' => $project['Project']['fee_amount']
                ) ,
                '_setCustomVar' => array(
                    'pd' => $project['Project']['id'],
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
            $this->Project->processPayment($project_id, $total_amount, ConstPaymentGateways::Wallet);
        }
        return true;
    }
    public function processAddtoWallet($user_add_wallet_amount_id, $payment_gateway_id = null) 
    {
        App::import('Model', 'User');
        $this->User = new User();
        $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id' => $user_add_wallet_amount_id,
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            $this->User->Transaction->log($userAddWalletAmount['UserAddWalletAmount']['id'], 'Wallet.UserAddWalletAmount', $payment_gateway_id, ConstTransactionTypes::AmountAddedToWallet);
            $_Data['UserAddWalletAmount']['id'] = $user_add_wallet_amount_id;
            $_Data['UserAddWalletAmount']['is_success'] = 1;
            $this->User->UserAddWalletAmount->save($_Data);
            $User['id'] = $userAddWalletAmount['UserAddWalletAmount']['user_id'];
            $User['available_wallet_amount'] = $userAddWalletAmount['User']['available_wallet_amount']+$userAddWalletAmount['UserAddWalletAmount']['amount'];
            $this->User->save($User);
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                '_addTrans' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'total' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_addItem' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'sku' => 'W' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'category' => $userAddWalletAmount['User']['username'],
                    'unit_price' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
            return true;
        } elseif (!empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            return true;
        }
        return false;
    }
    public function processOrder($user_id, $data = array()) 
    {
        App::import('Model', 'Projects.Project');
        $this->Project = new Project();
        $user = $this->Project->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount'] < ($data['amount'])) {
            return false;
        } else {
            $order_id = $data['item_id'];
            $projectFund = $this->Project->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $order_id
                ) ,
                'contain' => array(
                    'User',
                    'Project' => array(
                        'User',
                        'ProjectType'
                    ) ,
                ) ,
                'recursive' => 2
            ));
            if ($projectFund['Project']['project_type_id'] == ConstProjectTypes::Donate) {
                $update_project_owner_balance = $projectFund['Project']['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']-$projectFund['ProjectFund']['site_fee'];
                $this->Project->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . $update_project_owner_balance . "'",
                ) , array(
                    'User.id' => $projectFund['ProjectFund']['owner_user_id']
                ));
                $update_backer_balance = $projectFund['User']['available_wallet_amount']-$projectFund['ProjectFund']['amount'];
                $this->Project->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . $update_backer_balance . "'",
                ) , array(
                    'User.id' => $projectFund['ProjectFund']['user_id']
                ));
            } else {
                $blocked_user_balance = $projectFund['User']['blocked_amount']+$projectFund['ProjectFund']['amount'];
                $available_user_balance = $projectFund['User']['available_wallet_amount']-$projectFund['ProjectFund']['amount'];
                $this->Project->User->updateAll(array(
                    'User.blocked_amount' => "'" . $blocked_user_balance . "'",
                    'User.available_wallet_amount' => "'" . $available_user_balance . "'"
                ) , array(
                    'User.id' => $projectFund['ProjectFund']['user_id']
                ));
            }
            $this->Project->ProjectFund->updateStatus($order_id, ConstProjectFundStatus::Backed, ConstPaymentGateways::Wallet);
            return true;
        }
    }
    function processPayment($projectFund) 
    {
        App::import('Model', 'Projects.Project');
        $this->Project = new Project();
        $update_user_balance = $projectFund['User']['blocked_amount']-$projectFund['ProjectFund']['amount'];
        //update funder user
        if ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
            $this->Project->User->updateAll(array(
                'User.blocked_amount' => "'" . $update_user_balance . "'",
            ) , array(
                'User.id' => $projectFund['ProjectFund']['user_id']
            ));
        }
        $user_info = $this->Project->User->find('first', array(
            'conditions' => array(
                'User.id' => $projectFund['ProjectFund']['owner_user_id']
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        $update_project_owner_balance = $user_info['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']-$projectFund['ProjectFund']['site_fee'];
        //update project owner
		$wallet_data = array();
		$wallet_data['User']['available_wallet_amount'] =  $update_project_owner_balance;
		$wallet_data['User']['id'] = $projectFund['ProjectFund']['owner_user_id'];
		$this->Project->User->save($wallet_data);
       
    }
    function CallCancelPreapproval($projectFund) 
    {
        App::import('Model', 'Projects.Project');
        $this->Project = new Project();
        $this->Project->User->updateAll(array(
            'User.blocked_amount' => "'" . ($projectFund['User']['blocked_amount']-$projectFund['ProjectFund']['amount']) . "'",
            'User.available_wallet_amount' => "'" . ($projectFund['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']) . "'",
        ) , array(
            'User.id' => $projectFund['ProjectFund']['user_id']
        ));
    }
}
?>