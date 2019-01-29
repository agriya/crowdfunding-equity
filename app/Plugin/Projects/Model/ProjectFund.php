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
class ProjectFund extends AppModel
{
    public $name = 'ProjectFund';
    public $actsAs = array(
        'Aggregatable',
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
            'counterCache' => true,
            'counterScope' => array(
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Authorized,
                    ConstProjectFundStatus::PaidToOwner,
                    ConstProjectFundStatus::Closed,
                    ConstProjectFundStatus::DefaultFund
                ) ,
            )
        ) ,
        'Project' => array(
            'className' => 'Projects.Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false,
        ) ,
        'ProjectType' => array(
            'className' => 'Projects.ProjectType',
            'foreignKey' => 'project_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false,
        ) ,
    );
    public $hasMany = array(
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'ProjectFund'
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Project',
            'Pledge',
            'Donate',
            'Lend',
            'Equity',
            'User',
        );
        $this->validate = array(
            'amount' => array(
                'rule4' => array(
                    'rule' => '_checkForReward',
                    'allowEmpty' => false,
                    'message' => sprintf(__l('You cannot select this %s for the amount you entered.') , Configure::read('project.alt_name_for_reward_singular_small'))
                ) ,
                'rule3' => array(
                    'rule' => array(
                        'comparison',
                        '>=',
                        1
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule2' => array(
                    'rule' => '/^[-+]?\\b[0-9]*\\.?[0-9]+\\b$/',
                    'allowEmpty' => false,
                    'message' => __l('Enter only numeric value')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'zip_code' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'project_reward_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
                'rule2' => array(
                    'rule' => '_checkSoldOutReward',
                    'allowEmpty' => false,
                    'message' => sprintf(__l('The %s you selected is sold out. Please select some other %s.') , Configure::read('project.alt_name_for_reward_singular_small') , Configure::read('project.alt_name_for_reward_plural_small'))
                ) ,
            ) ,
        );
    }
    function _checkForReward()
    {
        if (!empty($this->data['ProjectFund']['project_reward_id'])) {
            $projectReward = $this->Project->ProjectReward->find('first', array(
                'conditions' => array(
                    'ProjectReward.id' => $this->data['ProjectFund']['project_reward_id']
                ) ,
                'fields' => array(
                    'ProjectReward.pledge_amount',
                    'ProjectReward.project_id',
                ) ,
                'recursive' => -1
            ));
        }
        if (!empty($projectReward) && ($this->data['ProjectFund']['project_id'] != $projectReward['ProjectReward']['project_id'] || $this->data['ProjectFund']['amount'] < $projectReward['ProjectReward']['pledge_amount'])) {
            return false;
        }
        return true;
    }
    function _checkSoldOutReward()
    {
        if (!empty($this->data['ProjectFund']['project_reward_id'])) {
            $projectReward = $this->Project->ProjectReward->find('first', array(
                'conditions' => array(
                    'ProjectReward.id' => $this->data['ProjectFund']['project_reward_id']
                ) ,
                'fields' => array(
                    'ProjectReward.project_fund_count',
                    'ProjectReward.pledge_max_user_limit'
                ) ,
                'recursive' => -1
            ));
            if ($projectReward['ProjectReward']['pledge_max_user_limit'] != 0) {
                if ($projectReward['ProjectReward']['project_fund_count'] >= $projectReward['ProjectReward']['pledge_max_user_limit']) {
                    return false;
                }
            }
        }
        return true;
    }
    function updateFundCount($projectFund)
    {
        if (!empty($projectFund['ProjectFund']['project_id'])) {
            $projectFundcount = $this->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.project_id' => $projectFund['ProjectFund']['project_id'],
                ) ,
                'recursive' => -1
            ));
            $projectFundcount = (empty($projectFundcount)) ? 0 : $projectFundcount;
            $updates['Project.project_fund_count'] = $projectFundcount;
            $this->Project->updateAll($updates, array(
                'Project.id' => $projectFund['ProjectFund']['project_id']
            ));
        }
        if (!empty($projectFund['ProjectFund']['user_id'])) {
            $uniqueProjectFundCount = $this->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.user_id' => $projectFund['ProjectFund']['user_id'],
                    'ProjectFund.is_anonymous' => array(
                        ConstAnonymous::None,
                        ConstAnonymous::FundedAmount,
                    )
                ) ,
                'group' => 'ProjectFund.project_id',
                'recursive' => -1
            ));
            $uniqueProjectFundCount = (empty($uniqueProjectFundCount)) ? 0 : $uniqueProjectFundCount;
            $userupdates['User.unique_project_fund_count'] = $uniqueProjectFundCount;
            $this->User->updateAll($userupdates, array(
                'User.id' => $projectFund['ProjectFund']['user_id']
            ));
        }
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account = null)
    {
        $ProjectFund = $this->find('first', array(
            'conditions' => array(
                'ProjectFund.id' => $foreign_id
            ) ,
            'contain' => array(
                'User',
                'Project' => array(
                    'User',
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if ($transaction_type == ConstPaymentType::PledgeCapture) {
            if (!empty($ProjectFund['ProjectFund']['site_fee'])) {
                $return['amount'] = array(
                    $ProjectFund['ProjectFund']['amount'],
                    $ProjectFund['ProjectFund']['site_fee'],
                );
            } else {
                $return['amount'] = array(
                    $ProjectFund['ProjectFund']['amount']
                );
            }
			$return['marketplace_fees_payer'] = 'buyer';
			if (Configure::read('Project.payment_gateway_fee_id') == 'Site') {
				$return['marketplace_fees_payer'] = 'merchant';
			}
            $return['buyer_email'] = $ProjectFund['User']['email'];
            $return['sudopay_receiver_account_id'] = $ProjectFund['Project']['User']['sudopay_receiver_account_id'];
            $return['sudopay_gateway_id'] = $ProjectFund['ProjectFund']['sudopay_gateway_id'];
        }
        return $return;
    }
    public function updateStatus($project_fund_id, $project_fund_status_id, $payment_gateway_id = null, $is_canceled_from_gateway = 0)
    {
        if (!empty($is_canceled_from_gateway)) {
            $_data = array();
            $_data['ProjectFund']['id'] = $project_fund_id;
            $_data['ProjectFund']['is_canceled_from_gateway'] = 1;
            $this->save($_data, false);
        }
        $projectFund = $this->find('first', array(
            'conditions' => array(
                'ProjectFund.id' => $project_fund_id
            ) ,
            'contain' => array(
                'User',
            ) ,
            'recursive' => 0
        ));
        $project = $this->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $projectFund['ProjectFund']['project_id']
            ) ,
            'contain' => array(
                'User',
                'ProjectType',
            ) ,
            'recursive' => 0
        ));
        $this->
        {
            'processStatus' . $project_fund_status_id}($projectFund, $payment_gateway_id, $project);
            $projectTypeName = ucwords($project['ProjectType']['name']);
            App::import('Model', $projectTypeName . '.' . $projectTypeName);
            $model = new $projectTypeName();
            $update = $model->deductFromCollectedAmount($project);
            if ($update) {
                $this->updateFundCount($projectFund);
                $this->updateProjectRewardCount($project['Project']['id']);
            }
        }
        // Backed //
        function processStatus1($projectFund, $payment_gateway_id, $project)
        {
            if (in_array($projectFund['ProjectFund']['project_fund_status_id'], array(
                ConstProjectFundStatus::ManualPending,
                ConstProjectFundStatus::PendingToPay
            ))) {
                $this->User->Transaction->log($projectFund['ProjectFund']['id'], 'Projects.ProjectFund', $payment_gateway_id, ConstTransactionTypes::ProjectBacked);
                if ($project['Project']['project_type_id'] == ConstProjectTypes::Donate) {
                    $is_paid = ConstProjectFundStatus::PaidToOwner;
					if ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
						App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
					    $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
						$connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
								'conditions' => array(
									'SudopayPaymentGatewaysUser.user_id' => $project['Project']['user_id'] ,
								) ,
								'fields' => array(
									'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
								) ,
								'recursive' => -1,
							));
						if (empty($connected_gateways) || (!empty($connected_gateways) && !in_array($projectFund['ProjectFund']['sudopay_gateway_id'], $connected_gateways))) {
							$this->Project->User->updateAll(array(
								'User.available_wallet_amount' => "'" . ($projectFund['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']) . "'"
							) , array(
								'User.id' => $projectFund['ProjectFund']['user_id']
							));
						}
					}
                } else {
                    $is_paid = ConstProjectFundStatus::Authorized;
                }
                $_data = array();
                $_data['ProjectFund']['id'] = $projectFund['ProjectFund']['id'];
                $_data['ProjectFund']['project_fund_status_id'] = $is_paid;
                $_data['ProjectFund']['coupon_code'] = $this->_uuid();
                $_data['ProjectFund']['unique_coupon_code'] = $this->_unum();
                $_data['ProjectFund']['payment_gateway_id'] = $payment_gateway_id;
                $this->save($_data, false);
                $_user_data = array();
                $_user_data['User']['id'] = $projectFund['ProjectFund']['user_id'];
                $_user_data['User']['is_idle'] = 0;
                $_user_data['User']['is_funded'] = 1;
                $this->User->save($_user_data);
                $this->postActivity($project, ConstProjectActivities::Fund, $projectFund['ProjectFund']['id']);
                $total_collected_amount = $project['User']['total_collected_amount']+$projectFund['ProjectFund']['amount'];
                $this->User->updateAll(array(
                    'User.total_collected_amount' => $total_collected_amount
                ) , array(
                    'User.id' => $project['Project']['user_id']
                ));
                $total_funded_amount = $projectFund['User']['total_funded_amount']+$projectFund['ProjectFund']['amount'];
                $site_revenue = $projectFund['User']['site_revenue']+$projectFund['ProjectFund']['site_fee'];
                $this->User->updateAll(array(
                    'User.total_funded_amount' => $total_funded_amount,
                    'User.site_revenue' => $site_revenue
                ) , array(
                    'User.id' => $projectFund['ProjectFund']['user_id']
                ));
                $this->Project->updateProjectOnFund($projectFund, $project);
                App::import('Model', $project['ProjectType']['name'] . '.' . $project['ProjectType']['name']);
                $this->$project['ProjectType']['name'] = new $project['ProjectType']['name']();
                $this->$project['ProjectType']['name']->updateProjectStatus($projectFund['ProjectFund']['id']);
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                    '_addTrans' => array(
                        'order_id' => 'ProjectFunding-' . $projectFund['ProjectFund']['id'],
                        'name' => $project['Project']['name'],
                        'total' => $projectFund['ProjectFund']['amount']-$projectFund['ProjectFund']['site_fee']
                    ) ,
                    '_addItem' => array(
                        'order_id' => 'ProjectFunding-' . $projectFund['ProjectFund']['id'],
                        'sku' => 'PF' . $projectFund['ProjectFund']['id'],
                        'name' => $project['Project']['name'],
                        'category' => $project['ProjectType']['name'],
                        'unit_price' => $projectFund['ProjectFund']['amount']-$projectFund['ProjectFund']['site_fee']
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'pfd' => $projectFund['ProjectFund']['id'],
                        'ud' => $projectFund['User']['id'],
                        'rud' => $projectFund['User']['referred_by_user_id'],
                    )
                ));
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                    '_addTrans' => array(
                        'order_id' => 'SiteCommision-' . $projectFund['ProjectFund']['id'],
                        'name' => $project['Project']['name'],
                        'total' => $projectFund['ProjectFund']['site_fee']
                    ) ,
                    '_addItem' => array(
                        'order_id' => 'SiteCommision-' . $projectFund['ProjectFund']['id'],
                        'sku' => 'PF' . $projectFund['ProjectFund']['id'],
                        'name' => $project['Project']['name'],
                        'category' => $project['ProjectType']['name'],
                        'unit_price' => $projectFund['ProjectFund']['site_fee']
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'pfd' => $projectFund['ProjectFund']['id'],
                        'ud' => $projectFund['User']['id'],
                        'rud' => $projectFund['User']['referred_by_user_id'],
                    )
                ));
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Funded',
                        'label' => $projectFund['User']['username'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'pfd' => $projectFund['ProjectFund']['id'],
                        'ud' => $projectFund['User']['id'],
                        'rud' => $projectFund['User']['referred_by_user_id'],
                    )
                ));
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'ProjectFund',
                        'action' => 'Fund',
                        'label' => 'Step 3',
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'pfd' => $projectFund['ProjectFund']['id'],
                        'ud' => $projectFund['User']['id'],
                        'rud' => $projectFund['User']['referred_by_user_id'],
                    )
                ));
                if (isPluginEnabled('ProjectFollowers')) {
                    if (in_array($projectFund['ProjectFund']['is_anonymous'], array(
                        ConstAnonymous::None,
                        ConstAnonymous::FundedAmount
                    ))) {
                        $projectFollower = $this->Project->ProjectFollower->find('first', array(
                            'conditions' => array(
                                'ProjectFollower.user_id' => $projectFund['User']['id'],
                                'ProjectFollower.project_id' => $project['Project']['id'],
                            ) ,
                            'recursive' => -1
                        ));
                        if (empty($projectFollower)) {
                            $this->Project->ProjectFollower->create();
                            $_data['ProjectFollower']['user_id'] = $projectFund['User']['id'];
                            $_data['ProjectFollower']['project_id'] = $project['Project']['id'];
                            $_data['ProjectFollower']['project_type_id'] = $project['Project']['project_type_id'];
                            $this->Project->ProjectFollower->save($_data);
                            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                '_trackEvent' => array(
                                    'category' => 'User',
                                    'action' => 'Followed',
                                    'label' => $projectFund['User']['username'],
                                    'value' => '',
                                ) ,
                                '_setCustomVar' => array(
                                    'ud' => $projectFund['User']['id'],
                                    'rud' => $projectFund['User']['referred_by_user_id'],
                                )
                            ));
                            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                '_trackEvent' => array(
                                    'category' => 'ProjectFollower',
                                    'action' => 'Followed',
                                    'label' => $project['Project']['id'],
                                    'value' => '',
                                ) ,
                                '_setCustomVar' => array(
                                    'pd' => $project['Project']['id'],
                                    'ud' => $projectFund['User']['id'],
                                    'rud' => $projectFund['User']['referred_by_user_id'],
                                )
                            ));
                        }
                    }
                }
            }
        }
        // Refunded //
        function processStatus2($projectFund, $payment_gateway_id, $project)
        {
            $return = array();
            if ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                App::import('Model', 'Sudopay.SudopayPaymentGateway');
                $this->SudopayPaymentGateway = new SudopayPaymentGateway();
                $sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
                    'conditions' => array(
                        'SudopayPaymentGateway.sudopay_gateway_id' => $projectFund['ProjectFund']['sudopay_gateway_id']
                    ) ,
                    'recursive' => -1
                ));
                App::import('Model', 'Sudopay.Sudopay');
                $this->Sudopay = new Sudopay();
                $s = $this->Sudopay->getSudoPayObject();
                if (!empty($sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported'])) {
                    $post['gateway_id'] = $projectFund['ProjectFund']['sudopay_gateway_id'];
                    $post['payment_id'] = $projectFund['ProjectFund']['sudopay_payment_id'];
                    $post['paykey'] = $projectFund['ProjectFund']['sudopay_pay_key'];
                    $response = $s->callMarketplaceVoid($post);
                    if (!empty($response->error->code)) {
                        $return['error'] = 1;
                        $return['error_message'] = $response->error->message;
                    }
                } else {
                    $this->Project->User->updateAll(array(
                        'User.available_wallet_amount' => "'" . ($projectFund['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']) . "'"
                    ) , array(
                        'User.id' => $projectFund['ProjectFund']['user_id']
                    ));
                }
            } elseif ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                if (isPluginEnabled('Wallet')) {
                    App::import('Model', 'Wallet.Wallet');
                    $this->Wallet = new Wallet();
                    $this->Wallet->CallCancelPreapproval($projectFund);
                }
                $return['error'] = 0;
                $this->Project->_sendAlertOnProjectStatus($project, 'Project Refund Notification', $projectFund, '', 'Wallet');
            }
            if (empty($return['error'])) {
                $this->Project->User->Transaction->log($projectFund['ProjectFund']['id'], 'Projects.ProjectFund', $projectFund['ProjectFund']['payment_gateway_id'], ConstTransactionTypes::Refunded);
                $this->Project->updateProjectOnRefund($projectFund, $project);
                if (Configure::read('Project.is_enable_cancel_pledge_activities')) {
                    $this->postActivity($project, ConstProjectActivities::FundCancel, $projectFund['ProjectFund']['id']);
                }
                $total_collected_amount = $project['User']['total_collected_amount']-$projectFund['ProjectFund']['amount'];
                $this->Project->User->updateAll(array(
                    'User.total_collected_amount' => $total_collected_amount,
                    'User.site_revenue' => $total_collected_amount
                ) , array(
                    'User.id' => $project['Project']['user_id']
                ));
                $total_funded_amount = $projectFund['User']['total_funded_amount']-$projectFund['ProjectFund']['amount'];
                $site_revenue = $projectFund['User']['site_revenue']-$projectFund['ProjectFund']['site_fee'];
                $this->Project->User->updateAll(array(
                    'User.total_funded_amount' => $total_funded_amount,
                    'User.site_revenue' => $site_revenue
                ) , array(
                    'User.id' => $projectFund['ProjectFund']['user_id']
                ));
				$collected_amount = $project['Project']['collected_amount']-$projectFund['ProjectFund']['amount'];
                $this->Project->updateAll(array(
                    'Project.collected_amount' => $collected_amount,
                ) , array(
                    'Project.id' => $project['Project']['id']
                ));
            }
            return $return;
        }
        // Captured //
        function processStatus3($projectFund, $payment_gateway_id, $project)
        {
            $return = array();
            if ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                App::import('Model', 'Sudopay.SudopayPaymentGateway');
                $this->SudopayPaymentGateway = new SudopayPaymentGateway();
                $sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
                    'conditions' => array(
                        'SudopayPaymentGateway.sudopay_gateway_id' => $projectFund['ProjectFund']['sudopay_gateway_id']
                    ) ,
                    'recursive' => -1
                ));
                App::import('Model', 'Sudopay.Sudopay');
                $this->Sudopay = new Sudopay();
                $s = $this->Sudopay->getSudoPayObject();
                if (!empty($sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported'])) {
                    $post['gateway_id'] = $projectFund['ProjectFund']['sudopay_gateway_id'];
                    $post['payment_id'] = $projectFund['ProjectFund']['sudopay_payment_id'];
                    $post['paykey'] = $projectFund['ProjectFund']['sudopay_pay_key'];
                    $response = $s->callMarketplaceAuthCapture($post);
                    if (!empty($response->error->code)) {
                        $return['error'] = 1;
                        $return['error_message'] = $response->error->message;
                    }
                } else {
                    $update_project_owner_balance = $project['User']['available_wallet_amount']+$projectFund['ProjectFund']['amount']-$projectFund['ProjectFund']['site_fee'];
					$wallet_data = array();
					$wallet_data['User']['available_wallet_amount'] =  $update_project_owner_balance;
					$wallet_data['User']['id'] = $projectFund['ProjectFund']['owner_user_id'];
					$this->Project->User->save($wallet_data);
                }
            } elseif ($projectFund['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                App::import('Model', 'Wallet.Wallet');
                $this->Wallet = new Wallet();
                $this->Wallet->processPayment($projectFund);
                $_projectFundData['ProjectFund']['id'] = $projectFund['ProjectFund']['id'];
                $_projectFundData['ProjectFund']['project_fund_status_id'] = ConstProjectFundStatus::PaidToOwner;
                $this->save($_projectFundData, false);
            }
            return true;
        }
        function updateProjectRewardCount($project_id = null)
        {
            if (!empty($project_id)) {
                $reward_count = $this->find('count', array(
                    'conditions' => array(
                        'ProjectFund.project_id' => $project_id,
                        'ProjectFund.project_reward_id != ' => 0,
                        'ProjectFund.project_fund_status_id' => array(
                            ConstProjectFundStatus::Authorized,
                            ConstProjectFundStatus::PaidToOwner,
                            ConstProjectFundStatus::Closed,
                            ConstProjectFundStatus::DefaultFund
                        )
                    ) ,
                    'recursive' => -1
                ));
                $this->Project->updateAll(array(
                    'Project.rewarded_count' => $reward_count
                ) , array(
                    'Project.id' => $project_id
                ));
                return $reward_count;
            }
        }
        function updateProjectRewardGivenCount($project_id = null)
        {
            if (!empty($project_id)) {
                $reward_given_count = $this->find('count', array(
                    'conditions' => array(
                        'ProjectFund.project_id' => $project_id,
                        'ProjectFund.project_reward_id != ' => 0,
                        'ProjectFund.is_given' => 1,
                        'ProjectFund.project_fund_status_id' => array(
                            ConstProjectFundStatus::Authorized,
                            ConstProjectFundStatus::PaidToOwner,
                            ConstProjectFundStatus::Closed,
                            ConstProjectFundStatus::DefaultFund
                        )
                    ) ,
                    'recursive' => -1
                ));
                $this->Project->updateAll(array(
                    'Project.reward_given_count' => $reward_given_count
                ) , array(
                    'Project.id' => $project_id
                ));
                return $reward_given_count;
            }
        }
    }
?>