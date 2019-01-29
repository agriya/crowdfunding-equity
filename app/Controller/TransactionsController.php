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
class TransactionsController extends AppController
{
    public $name = 'Transactions';
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        )
    );
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'Transaction.user_id',
            'Transaction.project_id',
        );
        parent::beforeFilter();
    }
    public function index() 
    {
        $this->pageTitle = __l('Transactions');
        $blocked_conditions['UserCashWithdrawal.user_id'] = $conditions['OR']['Transaction.receiver_user_id'] = $conditions['OR']['Transaction.user_id'] = $this->Auth->user('id');
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            list($this->request->data['Transaction']['from_date']['year'], $this->request->data['Transaction']['from_date']['month'], $this->request->data['Transaction']['from_date']['day']) = explode('-', $this->request->params['named']['from_date']);
            list($this->request->data['Transaction']['to_date']['year'], $this->request->data['Transaction']['to_date']['month'], $this->request->data['Transaction']['to_date']['day']) = explode('-', $this->request->params['named']['to_date']);
        }
        if (!empty($this->request->data['Transaction']['from_date']) && !empty($this->request->data['Transaction']['to_date'])) {
            $from = $this->request->data['Transaction']['from_date'];
            $to = $this->request->data['Transaction']['to_date'];
            $from_date = mktime(0, 0, 0, $from['month'], $from['day'], $from['year']);
            $to_date = mktime(0, 0, 0, $to['month'], $to['day'], $to['year']);
            if ($from_date <= $to_date) {
                $blocked_conditions['UserCashWithdrawal.created >='] = $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
                $blocked_conditions['UserCashWithdrawal.created <='] = $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
                $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'];
                $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-01-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-12-31");
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-m-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-m-t");
            $this->pageTitle.= __l(' - in this month');
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Project' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username'
                        )
                    ) ,
                    'ProjectType' => array(
                        'fields' => array(
                            'ProjectType.id',
                            'ProjectType.name',
                            'ProjectType.slug',
                            'ProjectType.funder_slug'
                        )
                    ) ,
                    'fields' => array(
                        'Project.id',
                        'Project.user_id',
                        'Project.name',
                        'Project.slug',
                        'Project.project_type_id',
                    )
                ) ,
                'ProjectFund' => array(
                    'Project' => array(
                        'fields' => array(
                            'Project.id',
                            'Project.user_id',
                            'Project.name',
                            'Project.slug',
                            'Project.project_type_id',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.role_id'
                            )
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.role_id'
                        )
                    ) ,
                    'fields' => array(
                        'ProjectFund.id',
                        'ProjectFund.user_id',
                        'ProjectFund.project_id',
                        'ProjectFund.site_fee',
                        'ProjectFund.is_anonymous',
                        'ProjectFund.amount',
                        'ProjectFund.project_fund_status_id',
                        'ProjectFund.canceled_by_user_id'
                    )
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.role_id'
                    )
                ) ,
                'ForeignUser' => array(
                    'fields' => array(
                        'ForeignUser.id',
                        'ForeignUser.username',
                        'ForeignUser.role_id',
                    )
                ) ,
                'TransactionType'
            ) ,
            'order' => array(
                'Transaction.id' => 'desc'
            ) ,
            'recursive' => 3
        );
        $transactions = $this->paginate();
        $this->set('transactions', $transactions);
        $credit_conditions['OR'][] = array(
            'Transaction.user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit' => 1
        );
        $credit_conditions['OR'][] = array(
            'Transaction.receiver_user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit_to_receiver' => 1
        );
        $debit_conditions['OR'][] = array(
            'Transaction.user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit' => 0
        );
        $credit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                $credit_conditions
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $credit1 = !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0;
        $debit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                $debit_conditions
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $debit1 = !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0;
        $debit2 = $credit2 = 0;
        if (isPluginEnabled('Withdrawals')) {
            $withdrawalTransactions = $this->Transaction->find('all', array(
                'conditions' => array(
                    $conditions,
                    'Transaction.transaction_type_id' => array(
                        ConstTransactionTypes::CashWithdrawalRequest,
                        ConstTransactionTypes::CashWithdrawalRequestApproved,
                        ConstTransactionTypes::CashWithdrawalRequestRejected,
                        ConstTransactionTypes::CashWithdrawalRequestPaid,
                        ConstTransactionTypes::CashWithdrawalRequestFailed,
                    )
                ) ,
                'fields' => array(
                    'DISTINCT(Transaction.foreign_id)'
                ) ,
                'recursive' => 0
            ));
            if (!empty($withdrawalTransactions)) {
                $userCashWithdrawalIds = array();
                foreach($withdrawalTransactions as $withdrawalTransaction) {
                    $userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
                }
                $this->loadModel('Withdrawals.UserCashWithdrawal');
                $userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
                    'conditions' => array(
                        'UserCashWithdrawal.id' => $userCashWithdrawalIds
                    ) ,
                    'fields' => array(
                        'UserCashWithdrawal.amount',
                        'UserCashWithdrawal.withdrawal_status_id',
                    ) ,
                    'recursive' => -1
                ));
                foreach($userCashWithdrawals as $userCashWithdrawal) {
                    if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(
                        ConstWithdrawalStatus::Rejected
                    ))) {
                        $credit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    } else {
                        $debit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    }
                }
            }
        }
        $this->set('total_credit_amount', $credit1+$credit2);
        $this->set('total_debit_amount', $debit1+$debit2);
        $from = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'order' => array(
                'Transaction.created asc'
            ) ,
            'recursive' => 0
        ));
        $to = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'order' => array(
                'Transaction.created desc'
            ) ,
            'recursive' => 0
        ));
        $this->set('duration_from', $from['Transaction']['created']);
        $this->set('duration_to', $to['Transaction']['created']);
        if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')) {
            $blocked_amount = $this->Transaction->User->UserCashWithdrawal->find('first', array(
                'conditions' => $blocked_conditions,
                'fields' => array(
                    'SUM(UserCashWithdrawal.amount) as total_amount'
                ) ,
                'group' => array(
                    'UserCashWithdrawal.user_id'
                ) ,
                'recursive' => 0
            ));
            $this->set('blocked_amount', !empty($blocked_amount[0]['total_amount']) ? $blocked_amount[0]['total_amount'] : 0);
        }
        $filter = array(
            'all' => __l('All') ,
            'day' => __l('Today') ,
            'week' => __l('This Week') ,
            'month' => __l('This Month') ,
            'custom' => __l('Custom') ,
        );
        if ($this->RequestHandler->isAjax()) {
            $this->set('isAjax', true);
        } else {
            $this->set('isAjax', false);
        }
        $this->set('filter', $filter);
        if (empty($this->request->data['Transaction']['from_date'])) {
            $this->request->data['Transaction']['from_date'] = date('Y-m-d', strtotime('-90 days'));
        }
        if (empty($this->request->data['Transaction']['to_date'])) {
            $this->request->data['Transaction']['to_date'] = date('Y-m-d');
        }
    }
    public function admin_index() 
    {
        $this->Transaction->User->validate = array();
        $this->Transaction->Project->validate = array();
        $conditions = array();
        $this->pageTitle = __l('Transactions');
        if (empty($this->request->data['Transaction']['user_id']) && !empty($this->request->data['Transaction']['username'])) {
            $users = $this->Transaction->User->find('list', array(
                'conditions' => array(
                    'User.username LIKE' => '%' . $this->request->data['Transaction']['username'] . '%',
                ) ,
                'fields' => array(
                    'User.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($users)) {
                $this->request->params['named']['user_id'] = array_values($users);
            }
        }
        if (!empty($this->request->data['Transaction']['user_id'])) {
            $this->request->params['named']['user_id'] = $this->request->data['Transaction']['user_id'];
        }
        if (empty($this->request->data['Project']['id']) and !empty($this->request->data['Project']['name'])) {
            $projects = $this->Transaction->Project->find('list', array(
                'conditions' => array(
                    'Project.name LIKE' => '%' . $this->request->data['Project']['name'] . '%',
                ) ,
                'fields' => array(
                    'Project.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($projects)) {
                $this->request->params['named']['project_id'] = array_values($projects);
            }
        }
        if (!empty($this->request->data['Transaction']['project_id'])) {
            $this->request->params['named']['project_id'] = $this->request->data['Transaction']['project_id'];
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['OR']['Transaction.user_id'] = $conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
            $credit_conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
            $credit_conditions['OR']['Transaction.user_id'] = $this->request->params['named']['user_id'];
            $debit_conditions['OR']['Transaction.user_id'] = $this->request->params['named']['user_id'];
            $debit_conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['Transaction.foreign_id'] = $this->request->params['named']['project_id'];
        }
        $this->set('credit_type', 'is_credit');
        $is_credit = 'is_credit';
        if (empty($this->request->params['named']['filter']) && empty($this->request->params['named']['user_id']) && empty($this->request->params['named']['project_id']) && empty($this->request->params['named']['from_date']) && empty($this->request->params['named']['to_date'])) {
            $is_credit = 'is_credit_to_admin';
            $this->set('credit_type', 'is_credit_to_admin');
            $conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
			$conditions['OR'][]['Transaction.receiver_user_id'] = ConstUserIds::Admin;
            $credit_conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
			$credit_conditions['OR'][]['Transaction.receiver_user_id'] = ConstUserIds::Admin;
            $debit_conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
        }
        $credit_conditions['TransactionType.' . $is_credit] = 1;
        $debit_conditions['TransactionType.' . $is_credit] = 0;
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            list($this->request->data['Transaction']['from_date']['year'], $this->request->data['Transaction']['from_date']['month'], $this->request->data['Transaction']['from_date']['day']) = explode('-', $this->request->params['named']['from_date']);
            list($this->request->data['Transaction']['to_date']['year'], $this->request->data['Transaction']['to_date']['month'], $this->request->data['Transaction']['to_date']['day']) = explode('-', $this->request->params['named']['to_date']);
        }
        if (!empty($this->request->data['Transaction']['from_date']['year']) || !empty($this->request->data['Transaction']['to_date']['year'])) {
            $from = $this->request->data['Transaction']['from_date'];
            $to = $this->request->data['Transaction']['to_date'];
            $from_date = mktime(0, 0, 0, $from['month'], $from['day'], $from['year']);
            $to_date = mktime(0, 0, 0, $to['month'], $to['day'], $to['year']);
            if ($from_date <= $to_date) {
                if (!empty($this->request->data['Transaction']['from_date']['year'])) {
                    $conditions['Transaction.created >='] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
                    if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
                        $credit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                        $credit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
                        $debit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                        $debit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
                    }
                } else {
                }
                if (!empty($this->request->data['Transaction']['to_date']['year'])) {
                    $conditions['Transaction.created <='] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
                    if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
                        $credit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                        $credit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
                        $debit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                        $debit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
                    }
                } else {
                }
                $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'];
                $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Project' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username'
                        )
                    ) ,
                    'ProjectType' => array(
                        'fields' => array(
                            'ProjectType.id',
                            'ProjectType.name',
                            'ProjectType.slug',
                            'ProjectType.funder_slug'
                        )
                    ) ,
                    'fields' => array(
                        'Project.id',
                        'Project.user_id',
                        'Project.name',
                        'Project.slug',
                        'Project.project_type_id',
                    )
                ) ,
                'ProjectFund' => array(
                    'Project' => array(
                        'fields' => array(
                            'Project.id',
                            'Project.user_id',
                            'Project.name',
                            'Project.slug',
                            'Project.project_type_id',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.role_id'
                            )
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.role_id'
                        )
                    ) ,
                    'fields' => array(
                        'ProjectFund.id',
                        'ProjectFund.user_id',
                        'ProjectFund.project_id',
                        'ProjectFund.site_fee',
                        'ProjectFund.is_anonymous',
                        'ProjectFund.amount',
                        'ProjectFund.project_fund_status_id',
                        'ProjectFund.canceled_by_user_id'
                    )
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.role_id'
                    )
                ) ,
                'ForeignUser' => array(
                    'fields' => array(
                        'ForeignUser.id',
                        'ForeignUser.username',
                        'ForeignUser.role_id',
                    )
                ) ,
                'TransactionType'
            ) ,
            'order' => array(
                'Transaction.id' => 'desc'
            ) ,
            'recursive' => 3
        );
        $this->set('transactions', $this->paginate());
        $projects = array();
        $projects = $this->Transaction->Project->find('list', array(
            'conditions' => array(
                'Project.is_active' => 1
            ) ,
            'fields' => array(
                'Project.id',
                'Project.name',
            ) ,
            'recursive' => -1,
        ));
        $this->set('projects', $projects);
        $credit = $this->Transaction->find('first', array(
            'conditions' => $credit_conditions,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
		
        $credit1 = !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0;
        $debit = $this->Transaction->find('first', array(
            'conditions' => $debit_conditions,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $debit1 = !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0;
        $debit2 = $credit2 = 0;
        if (isPluginEnabled('Withdrawals')) {
            $withdrawalTransactions = $this->Transaction->find('all', array(
                'conditions' => array(
                    $conditions,
                    'Transaction.transaction_type_id' => array(
                        ConstTransactionTypes::CashWithdrawalRequest,
                        ConstTransactionTypes::CashWithdrawalRequestApproved,
                        ConstTransactionTypes::CashWithdrawalRequestRejected,
                        ConstTransactionTypes::CashWithdrawalRequestPaid,
                        ConstTransactionTypes::CashWithdrawalRequestFailed,
                    )
                ) ,
                'fields' => array(
                    'DISTINCT(Transaction.foreign_id)'
                ) ,
                'recursive' => 0
            ));
            if (!empty($withdrawalTransactions)) {
                $userCashWithdrawalIds = array();
                foreach($withdrawalTransactions as $withdrawalTransaction) {
                    if (!empty($withdrawalTransaction['Transaction']['foreign_id'])) {
                        $userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
                    }
                }
                $this->loadModel('Withdrawals.UserCashWithdrawal');
                $userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
                    'conditions' => array(
                        'UserCashWithdrawal.id' => $userCashWithdrawalIds
                    ) ,
                    'fields' => array(
                        'UserCashWithdrawal.amount',
                        'UserCashWithdrawal.withdrawal_status_id',
                    ) ,
                    'recursive' => -1
                ));
                foreach($userCashWithdrawals as $userCashWithdrawal) {
                    if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(
                        ConstWithdrawalStatus::Rejected
                    ))) {
                        $credit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    } else {
                        $debit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    }
                }
            }
        }
        $this->set('total_credit_amount', $credit1+$credit2);
        $this->set('total_debit_amount', $debit1+$debit2);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Transaction->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Transaction')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>