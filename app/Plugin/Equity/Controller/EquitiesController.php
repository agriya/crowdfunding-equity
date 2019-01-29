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
class EquitiesController extends AppController
{
    public $name = 'Equities';
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'Project.id',
        );
        parent::beforeFilter();
    }
    public function overview() 
    {
        $user_id = $this->Auth->user('id');
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'Project.created =' => date('Y-m-d', strtotime('now')) ,
                    )
                ) ,
                'week' => array(
                    'display' => __l('This Week') ,
                    'conditions' => array(
                        'Project.created =' => date('Y-m-d', strtotime('now -7 days')) ,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This Month') ,
                    'conditions' => array(
                        'Project.created =' => date('Y-m-d', strtotime('now -30 days')) ,
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Cleared') ,
                    'projectconditions' => array(
                        'Project.user_id' => $user_id,
                        'Equity.equity_project_status_id' => array(
                            ConstEquityProjectStatus::ProjectClosed,
                        )
                    ) ,
                    'alias' => 'Cleared',
                    'type' => 'cInt',
                    'isSub' => 'Project',
                    'class' => 'highlight-cleared'
                )
            );
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Pipeline') ,
                    'projectconditions' => array(
                        'Project.user_id' => $user_id,
                        'Equity.equity_project_status_id' => array(
                            ConstEquityProjectStatus::Pending,
                            ConstEquityProjectStatus::OpenForInvesting,
                            ConstEquityProjectStatus::OpenForIdea,
                        )
                    ) ,
                    'alias' => 'Pipeline',
                    'type' => 'cInt',
                    'isSub' => 'Projects',
                    'class' => 'highlight-pipeline'
                )
            );
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Lost') ,
                    'projectconditions' => array(
                        'Project.user_id' => $user_id,
                        'Equity.equity_project_status_id' => array(
                            ConstEquityProjectStatus::ProjectExpired,
                            ConstEquityProjectStatus::ProjectCanceled
                        )
                    ) ,
                    'alias' => 'Lost',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-lost'
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        if ($fields['alias'] == 'Cleared') {
                            $period['conditions'] = array_merge($period['conditions'], array(
                                'Transaction.transaction_type_id' => ConstTransactionTypes::ProjectBacked
                            ));
                        } elseif ($fields['alias'] == 'Pipeline') {
                            $period['conditions'] = array_merge($period['conditions'], array(
                                'Transaction.transaction_type_id' => ConstTransactionTypes::ProjectBacked
                            ));
                        } elseif ($fields['alias'] == 'PipelineReverse') {
                            $period['conditions'] = array_merge($period['conditions'], array(
                                'Transaction.transaction_type_id' => ConstTransactionTypes::Refunded
                            ));
                        } elseif ($fields['alias'] == 'Lost') {
                            $period['conditions'] = array_merge($period['conditions'], array(
                                'Transaction.transaction_type_id' => ConstTransactionTypes::Refunded
                            ));
                        }
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $projectConditions = array(
                            'Project.user_id' => $this->Auth->user('id')
                        );
                        if (!empty($fields['projectconditions'])) {
                            $projectConditions = $fields['projectconditions'];
                        }
                        $project_list = $this->Equity->Project->find('list', array(
                            'conditions' => $projectConditions,
                            'fields' => array(
                                'Project.id',
                            ) ,
                            'recursive' => 1
                        ));
                        $conditions['ProjectFund.project_id'] = $project_list;
                        $conditions['Transaction.class'] = 'ProjectFund';
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        $result = $this->Equity->Project->Transaction->find('first', array(
                            'fields' => array(
                                'SUM(Transaction.amount) as amount',
                            ) ,
                            'conditions' => $conditions,
                            'recursive' => 1
                        ));
                        $this->set($aliasName . $key, $result[0]['amount']);
                    }
                }
            }
        }
        $this->set(compact('periods', 'models'));
    }
    public function myprojects() 
    {
        $conditions['Project.project_type_id'] = ConstProjectTypes::Equity;
        $conditions['Project.user_id'] = $this->Auth->user('id');
        $order = array(
            'Project.project_end_date' => 'asc'
        );
        if (!$this->Auth->user('id')) {
            if ($this->RequestHandler->prefers('json')){
		$this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
	    }else{
		throw new NotFoundException(__l('Invalid request'));
	    }
        }
        if (!empty($this->request->params['named']['status'])) {
            if ($this->request->params['named']['status'] == 'pending') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::Pending;
            } elseif ($this->request->params['named']['status'] == 'idea') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForIdea;
            } elseif ($this->request->params['named']['status'] == 'cancelled') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::ProjectCanceled;
                unset($conditions['Project.project_end_date >= ']);
            } elseif ($this->request->params['named']['status'] == 'expired') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::ProjectExpired;
                unset($conditions['Project.project_end_date >= ']);
            } elseif ($this->request->params['named']['status'] == 'closed') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::ProjectClosed;
            } elseif ($this->request->params['named']['status'] == 'draft') {
                $conditions['Project.is_draft'] = 1;
            } elseif ($this->request->params['named']['status'] == 'open_for_funding') {
                $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForInvesting;
            } elseif ($this->request->params['named']['status'] == 'flexible') {
                $conditions['Project.payment_method_id'] = ConstPaymentMethod::KiA;
            } elseif ($this->request->params['named']['status'] == 'fixed') {
                $conditions['Project.payment_method_id'] = ConstPaymentMethod::AoN;
            }
        } 
	//Todo: Need to change for default status 
	/*else {
            $conditions['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForInvesting;
        }*/
        $heading = sprintf(__l('My %s') , Configure::read('project.alt_name_for_project_plural_caps'));
        $contain = array(
            'Project' => array(
                'ProjectType',
                'User' => array(
                    'UserAvatar'
                ) ,
                'Message' => array(
                    'conditions' => array(
                        'Message.is_activity' => 0,
                        'Message.is_sender' => 0
                    ) ,
                ) ,
                'Attachment',
                'Transaction',
            ) ,
            'EquityProjectStatus',
        );
        if (isPluginEnabled('Idea')) {
            $contain['Project']['ProjectRating'] = array(
                'conditions' => array(
                    'ProjectRating.user_id' => $this->Auth->user('id') ,
                )
            );
        }
        if (!isPluginEnabled('Idea')) {
            $conditions['Equity.equity_project_status_id !='] = ConstEquityProjectStatus::OpenForIdea;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => $order,
            'recursive' => 3,
            'limit' => 20,
        );
        $projects = $this->paginate();
        $this->set('projects', $projects);
        
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
	    $event_data['contain'] = $contain;
	    $event_data['conditions'] = $conditions;
	    $event_data['order'] = $order;
	    $event_data['limit'] = 20;
	    $event_data['model'] = "Equity";
	    $event_data = Cms::dispatchEvent('Controller.Lend.myprojects', $this, array(
		'data' => $event_data
	    ));
	}
        
        $equityStatuses = $this->Equity->EquityProjectStatus->find('list', array(
            'recursive' => -1
        ));
        $projectStatuses = array();
        foreach($equityStatuses as $key => $status) {
            $status_condition = array(
                'Equity.equity_project_status_id ' => $key,
                'Project.user_id' => $this->Auth->user('id')
            );
            if ($key != ConstEquityProjectStatus::ProjectCanceled) {
                $status_condition['Project.is_active'] = 1;
            }
            $project_status = $this->Equity->Project->find('count', array(
                'conditions' => $status_condition,
                'contain' => array(
                    'Equity'
                ) ,
                'recursive' => 0
            ));
            $projectStatuses[$key] = $project_status;
        }
        $this->set('system_drafted', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_draft = ' => 1,
                'Project.user_id' => $this->Auth->user('id') ,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('projectStatuses', $projectStatuses);
        $count = $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_active' => 1,
                'Project.user_id' => $this->Auth->user('id') ,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        $this->set('total_flexible_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.payment_method_id' => ConstPaymentMethod::KiA,
                'Project.project_type_id' => ConstProjectTypes::Equity,
                'Project.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        )));
        $this->set('total_fixed_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.payment_method_id' => ConstPaymentMethod::AoN,
                'Project.project_type_id' => ConstProjectTypes::Equity,
                'Project.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        )));
        $this->set('count', $count);
        if (!empty($this->request->params['named']['from'])) {
            $this->render('project_filter');
        }
        $countDetail = $this->Equity->Project->getAdminRejectApproveCount(ConstProjectTypes::Equity, ConstEquityProjectStatus::Pending, 'Equity', 'Equity.equity_project_status_id');
        $this->set('formFieldSteps', $countDetail['formFieldSteps']);
        $this->set('rejectedCount', $countDetail['rejectedCount']);
        $this->set('approvedCount', $countDetail['approvedCount']);
        $this->set('rejectedProjectIds', $countDetail['rejectedProjectIds']);
        $this->set('approvedProjectIds', $countDetail['approvedProjectIds']);
    }
    public function myfunds() 
    {
        $conditions = array();
        $this->loadModel("Projects.ProjectFund");
        $conditions['ProjectFund.project_type_id'] = ConstProjectTypes::Equity;
        $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
        if (isset($this->request->params['named']['status'])) {
            if ($this->request->params['named']['status'] == 'refunded') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Expired;
            } else if ($this->request->params['named']['status'] == 'paid') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Authorized;
            } else if ($this->request->params['named']['status'] == 'cancelled') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Canceled;
            }
        }
        $this->set('fund_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.user_id' => $this->Auth->user('id') ,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('refunded_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.user_id = ' => $this->Auth->user('id') ,
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Expired,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('paid_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.user_id = ' => $this->Auth->user('id') ,
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('cancelled_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.user_id = ' => $this->Auth->user('id') ,
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Canceled,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $contain = array(
            'User' => array(
                'UserAvatar'
            ) ,
            'Project' => array(
                'User' => array(
                    'fields' => array(
                        'User.username',
                        'User.id'
                    )
                ) ,
                'Equity' => array(
                    'EquityProjectStatus'
                ) ,
                'Attachment',
            ) ,
            'EquityFund'
        );
        $paging_array = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
            'order' => array(
                'ProjectFund.id' => 'desc'
            )
        );
        $limit = 20;
        if (!empty($limit)) {
            $paging_array['limit'] = $limit;
        }
        $this->paginate = $paging_array;
        $this->set('projectFunds', $this->paginate('ProjectFund'));
        $this->set('all_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.user_id' => $this->Auth->user('id') ,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            )
        )));
        $conditions['ProjectFund.is_given'] = 1;
        $conditions['ProjectFund.project_type_id'] = ConstProjectTypes::Equity;
        $this->set('given_count', $this->ProjectFund->find('count', array(
            'conditions' => $conditions
        )));
        if (!empty($this->request->params['named']['from'])) {
            $this->render('equity_filter');
        }
    }
    function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'project_category_id',
            'q'
        ));
        App::import('Model', 'Projects.FormFieldStep');
        $FormFieldStep = new FormFieldStep();
        $formFieldSteps = $FormFieldStep->find('list', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => ConstProjectTypes::Equity,
                'FormFieldStep.is_splash' => 1
            ) ,
            'fields' => array(
                'FormFieldStep.order',
                'FormFieldStep.name'
            ) ,
            'recursive' => -1
        ));
        $this->set('formFieldSteps', $formFieldSteps);
        if (!empty($this->request->data['Project']['q'])) {
            $this->request->params['named']['q'] = $this->request->data['Project']['q'];
        }
        $this->pageTitle = Configure::read('project.alt_name_for_equity_singular_caps') . ' ' . Configure::read('project.alt_name_for_project_plural_caps');
        $conditions = array();
        $conditions['Project.project_type_id'] = ConstProjectTypes::Equity;
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Project']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Project']['filter_id'])) {
            if ($this->request->data['Project']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Project.is_admin_suspended'] = 1;
                $this->pageTitle.= ' - ' . __l('Suspended');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Project.is_active'] = 1;
                $this->pageTitle.= ' - ' . __l('Active');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Project.is_active'] = 0;
                $this->pageTitle.= ' - ' . __l('Inactive');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Featured) {
                $conditions['Project.is_featured'] = 1;
                $this->pageTitle.= ' - ' . __l('Featured');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Project.is_system_flagged'] = 1;
                $this->pageTitle.= ' - ' . __l('System Flagged');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Project.is_user_flagged'] = 1;
                $this->pageTitle.= ' - ' . __l('User Flagged');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Drafted) {
                $conditions['Project.is_draft'] = 1;
                $this->pageTitle.= ' - ' . __l('Drafted');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Flexible) {
                $conditions['Project.payment_method_id'] = ConstPaymentMethod::KiA;
                $this->pageTitle.= ' - ' . __l('Flexible');
            } elseif ($this->request->data['Project']['filter_id'] == ConstMoreAction::Fixed) {
                $conditions['Project.payment_method_id'] = ConstPaymentMethod::AoN;
                $this->pageTitle.= ' - ' . __l('Fixed');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Project']['filter_id'];
        }
        if (!empty($this->request->data['Project']['project_status_id'])) {
            $this->request->params['named']['project_status_id'] = $this->request->data['Project']['project_status_id'];
            $conditions['Equity.equity_project_status_id'] = $this->request->data['Project']['project_status_id'];
        } elseif (!empty($this->request->params['named']['project_status_id'])) {
            $this->request->data['Project']['project_status_id'] = $this->request->params['named']['project_status_id'];
            $conditions['Equity.equity_project_status_id'] = $this->request->data['Project']['project_status_id'];
        } elseif (!empty($this->request->params['named']['transaction_type_id']) && $this->request->params['named']['transaction_type_id'] == ConstTransactionTypes::ListingFee) {
            $this->pageTitle.= ' - ' . __l('Listing Fee Paid');
            $this->request->data['Project']['transaction_type_id'] = $this->request->params['named']['transaction_type_id'];
            $foreigns = $this->Equity->Project->Transaction->find('list', array(
                'conditions' => array(
                    'Transaction.class' => 'Project',
                    'Transaction.transaction_type_id' => ConstTransactionTypes::ListingFee,
                    'Project.project_type_id' => ConstProjectTypes::Equity
                ) ,
                'fields' => array(
                    'Transaction.foreign_id'
                ) ,
                'recursive' => 0
            ));
            $conditions['Project.id'] = $foreigns;
        }
        if (!empty($this->request->data['Project']['project_status_id']) or !empty($this->request->data['Project']['project_status_id'])) {
            switch ($conditions['Equity.equity_project_status_id']) {
                case ConstEquityProjectStatus::Pending:
                    $this->pageTitle.= ' - ' . __l('Pending');
                    break;

                case ConstEquityProjectStatus::OpenForInvesting:
                    $this->pageTitle.= ' - ' . __l('Open for Investing');
                    break;

                case ConstEquityProjectStatus::OpenForIdea:
                    $this->pageTitle.= ' - ' . __l('Open for Voting');
                    break;

                case ConstEquityProjectStatus::ProjectClosed:
                    $this->pageTitle.= ' - ' . __l('Funding Closed');
                    break;

                case ConstEquityProjectStatus::ProjectExpired:
                    $this->pageTitle.= ' - ' . __l('Funding Expired');
                    break;

                case ConstEquityProjectStatus::ProjectCanceled:
                    $this->pageTitle.= ' - ' . __l('Canceled');
                    break;

                case ConstEquityProjectStatus::PendingAction:
                    $this->pageTitle.= ' - ' . __l('Pending Action to Admin');
                    break;

                default:
                    break;
            }
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            $this->request->data['Project']['q'] = $this->request->params['named']['q'];
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'listing_fee') {
            $conditions['Project.fee_amount !='] = '0.00';
        }
        if (!empty($this->request->params['named']['project_flag_category_id'])) {
            $project_flag = $this->Equity->Project->ProjectFlag->find('list', array(
                'conditions' => array(
                    'ProjectFlag.project_flag_category_id' => $this->request->params['named']['project_flag_category_id'],
                    'Project.project_type_id' => ConstProjectTypes::Equity
                ) ,
                'fields' => array(
                    'ProjectFlag.id',
                    'ProjectFlag.project_id'
                ) ,
                'recursive' => -1
            ));
            $conditions['Project.id'] = $project_flag;
        }
        if (!empty($this->request->params['named']['project_category_id'])) {
            $conditions['Equity.equity_project_category_id'] = $this->request->params['named']['project_category_id'];
            $equityProjectCategory = $this->Equity->EquityProjectCategory->find('first', array(
                'conditions' => array(
                    'EquityProjectCategory.id' => $this->request->params['named']['project_category_id']
                ) ,
                'fields' => array(
                    'EquityProjectCategory.id',
                    'EquityProjectCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($equityProjectCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->pageTitle.= ' - ' . $equityProjectCategory['EquityProjectCategory']['name'];
        } elseif (!empty($this->request->params['named']['user_id'])) {
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Project.user_id'] = $this->request->params['named']['user_id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        $contain = array(
            'User',
            'ProjectType',
            'Attachment',
            'Equity' => array(
                'EquityProjectStatus',
                'EquityProjectCategory'
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
        );
        if (!empty($this->request->data['Project']['project_status_id']) && $this->request->data['Project']['project_status_id'] == ConstEquityProjectStatus::PendingAction) {
            $conditions['Project.is_pending_action_to_admin'] = 1;
            unset($conditions['Equity.equity_project_status_id']);
            App::import('Model', 'Projects.FormFieldStep');
            $FormFieldStep = new FormFieldStep();
            $splashStep = $FormFieldStep->find('first', array(
                'conditions' => array(
                    'FormFieldStep.project_type_id' => ConstProjectTypes::Equity,
                    'FormFieldStep.is_splash' => 1
                ) ,
                'fields' => array(
                    'FormFieldStep.order'
                ) ,
                'recursive' => -1
            ));
            $this->set('splashStep', $splashStep['FormFieldStep']['order']);
        }
        if (!empty($this->request->params['named']['step'])) {
            $admin_pending_projects = $this->Equity->Project->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            $projectIds = array();
            foreach($admin_pending_projects as $admin_project) {
                if (max(array_keys(unserialize($admin_project['Project']['tracked_steps']))) == $this->request->params['named']['step']) {
                    $projectIds[] = $admin_project['Project']['id'];
                }
            }
            $conditions['Project.id'] = $projectIds;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => array(
                'Project.id' => 'desc'
            ) ,
            'recursive' => 3
        );
        /// Status Based on Count
        $this->set('opened_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForInvesting,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('idea_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForIdea,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('pending_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::Pending,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('canceled_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectCanceled,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('closed_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('open_for_idea', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForIdea,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('expired_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectExpired,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('paid_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.project_type_id' => ConstProjectTypes::Equity,
                'Project.is_paid' => 1
            ) ,
            'recursive' => 0
        )));
        // total openid users list
        $this->set('suspended', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_admin_suspended = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('user_flagged', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_user_flagged = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_system_flagged = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('system_drafted', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_draft = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('successful_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_successful = ' => 0,
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('failed_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_successful = ' => 1,
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('active_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_active' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_active' => 0,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('featured_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_featured' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('total_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('total_flexible_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.payment_method_id' => ConstPaymentMethod::KiA,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('total_fixed_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.payment_method_id' => ConstPaymentMethod::AoN,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('projects', $this->paginate('Project'));
        $filters = $this->Equity->Project->isFilterOptions;
        $moreActions = $this->Equity->Project->moreActions;
        if (empty($this->request->data['Project']['project_status_id']) || $this->request->data['Project']['project_status_id'] != ConstEquityProjectStatus::ProjectClosed) {
            unset($moreActions[ConstMoreAction::Successful]);
            unset($moreActions[ConstMoreAction::Failed]);
        }
        $projectStatuses = $this->Equity->EquityProjectStatus->find('list', array(
            'conditions' => array(
                'EquityProjectStatus.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('moreActions', $moreActions);
        $this->set('filters', $filters);
        $this->set('projectStatuses', $projectStatuses);
        if (!empty($this->request->data['Project']['project_status_id']) && $this->request->data['Project']['project_status_id'] == ConstEquityProjectStatus::PendingAction) {
            $this->set('step_count', $this->Equity->Project->getStepCount(ConstProjectTypes::Equity));
            $this->render('admin_index_pending');
        }
    }
    public function admin_equity_svg() 
    {
        $this->loadModel('Projects.FormFieldStep');
        $formFieldStep = $this->FormFieldStep->find('count', array(
            'conditions' => array(
                'FormFieldStep.is_splash' => 1,
                'FormFieldStep.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        $this->set('formFieldStep', $formFieldStep);
        /// Status Based on Count
        $this->set('opened_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForInvesting,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('pending_action_to_admin_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_pending_action_to_admin' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('idea_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForIdea,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('pending_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::Pending,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('canceled_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectCanceled,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('allow_overfunding', 0);
        $this->set('closed_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('open_for_idea', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::OpenForIdea,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('expired_project_count', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Equity.equity_project_status_id = ' => ConstEquityProjectStatus::ProjectExpired,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('paid_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.project_type_id' => ConstProjectTypes::Equity,
                'Project.is_paid' => 1
            ) ,
            'recursive' => 0
        )));
        // total openid users list
        $this->set('suspended', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_admin_suspended = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('user_flagged', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_user_flagged = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_system_flagged = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('system_drafted', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_draft = ' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->set('successful_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_successful = ' => 1,
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('failed_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.is_successful = ' => 0,
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('total_projects', $this->Equity->Project->find('count', array(
            'conditions' => array(
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        )));
        $this->layout = 'ajax';
    }
    public function admin_funds() 
    {
        $this->_redirectPOST2Named(array(
            'q'
        ));
        $this->loadModel('Projects.ProjectFund');
        $this->pageTitle = sprintf(__l('%s %s Funds') , Configure::read('project.alt_name_for_equity_singular_caps') , Configure::read('project.alt_name_for_project_singular_caps'));
        $conditions = array();
        $project_ids = $this->Equity->find('list', array(
            'conditions' => array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForInvesting
            ) ,
            'fields' => array(
                'Equity.project_id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['ProjectFund.project_id'] = $this->request->params['named']['project_id'];
        }
        if (isset($this->request->params['named']['status'])) {
            if ($this->request->params['named']['status'] == 'refunded') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Expired;
            } else if ($this->request->params['named']['status'] == 'paid') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::PaidToOwner;
            } else if ($this->request->params['named']['status'] == 'cancelled') {
                $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Canceled;
            }
        }
        $this->set('fund_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('refunded_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Expired,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('paid_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::PaidToOwner,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $this->set('cancelled_count', $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Canceled,
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => 0
        )));
        $conditions['ProjectFund.project_type_id'] = ConstProjectTypes::Equity;
        if (!empty($this->request->params['named']['project'])) {
            $conditions['ProjectFund.project_id'] = $this->request->params['named']['project'];
            $project_name = $this->ProjectFund->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= ' - ' . $project_name['Project']['name'];
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['ProjectFund.project_id'] = $this->request->params['named']['project_id'];
            $project_name = $this->ProjectFund->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= ' - ' . $project_name['Project']['name'];
        } elseif (!empty($this->request->params['named']['user_id'])) {
            $conditions['ProjectFund.user_id'] = $this->request->params['named']['user_id'];
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['Project.description LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['Project.short_description LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            $this->request->data['ProjectFund']['q'] = $this->request->params['named']['q'];
        }
        $contain = array(
            'Project' => array(
                'Equity' => array(
                    'EquityProjectStatus'
                )
            ) ,
            'User',
        );
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => array(
                'ProjectFund.id' => 'desc'
            ) ,
            'recursive' => 3
        );
        $this->set('projectFunds', $this->paginate('ProjectFund'));
        $total_equity_conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Authorized;
        $equity = $this->ProjectFund->find('first', array(
            'conditions' => $total_equity_conditions,
            'fields' => array(
                'SUM(ProjectFund.amount) as total_amount',
            ) ,
            'recursive' => -1
        ));
        $total_equity = ($equity[0]['total_amount']) ? $equity[0]['total_amount'] : 0;
        $total_paid_conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::PaidToOwner;
        $paid = $this->ProjectFund->find('first', array(
            'conditions' => $total_paid_conditions,
            'fields' => array(
                'SUM(ProjectFund.amount) as total_amount',
            ) ,
            'recursive' => -1
        ));
        $total_paid = ($paid[0]['total_amount']) ? $paid[0]['total_amount'] : 0;
        $total_refunded_conditions['ProjectFund.project_fund_status_id'] = array(
            ConstProjectFundStatus::Expired,
            ConstProjectFundStatus::Canceled
        );
        $refunded = $this->ProjectFund->find('first', array(
            'conditions' => $total_refunded_conditions,
            'fields' => array(
                'SUM(ProjectFund.amount) as total_amount',
            ) ,
            'recursive' => -1
        ));
        $total_refunded = ($refunded[0]['total_amount']) ? $refunded[0]['total_amount'] : 0;
        $this->set(compact('projectStatuses'));
        $this->set('total_equity', $total_equity);
        $this->set('total_paid', $total_paid);
        $this->set('total_refunded', $total_refunded);
        if (!empty($this->request->params['named']['project_id'])) {
            $this->set("project_id", $this->request->params['named']['project_id']);
        }
    }
    public function import_startups() 
    {
        App::uses('HttpSocket', 'Network/Http');
        $HttpSocket = new HttpSocket();
        if (!empty($this->request->data)) {
            foreach($this->request->data['Equity'] as $startup_id => $is_checked) {
                if ($is_checked['startup_id']) {
                    $startupIds[] = $startup_id;
                }
            }
            if (!empty($startupIds)) {
                foreach($startupIds as $key => $startup_id) {
                    $response = $HttpSocket->get('https://api.angel.co/1/startups/' . $startup_id);
                    if (!empty($response)) {
                        $startup = json_decode($response->body);
                        $data['Project']['angelist_startup_id'] = $startup->id;
                        $data['Project']['name'] = $startup->name;
                        $data['Project']['user_id'] = $this->Auth->user('id');
                        $data['Project']['description'] = $startup->product_desc;
                        $data['Project']['feed_url'] = $startup->blog_url;
                        $data['Project']['twitter_feed_url'] = $startup->twitter_url;
                        $data['Project']['project_end_date'] = date('Y-m-d', strtotime('+1 days'));
                        $this->Equity->Project->save($data);
                        $project_id = $this->Equity->Project->getLastInsertId();
                    }
                }
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'add',
                    'project_type' => 'equity',
                    $project_id
                ));
            } else {
                $this->Session->setFlash(__l('Please select atleast one startup to import and try again.') , 'default', null, 'error');
            }
        }
        $this->loadModel('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.angellist_user_id'
            ) ,
            'recursive' => -1
        ));
        $startups = $HttpSocket->get('https://api.angel.co/1/users/' . $user['User']['angellist_user_id'] . '/roles');
        $startup_ids = array();
        if (!empty($startups->body)) {
            $startups_arr = json_decode($startups->body);
            if (!empty($startups_arr->startup_roles)) {
                foreach($startups_arr->startup_roles as $startup) {
                    array_push($startup_ids, $startup->startup->id);
                }
                $existing_startup_ids = $this->Equity->Project->find('list', array(
                    'conditions' => array(
                        'Project.angelist_startup_id' => $startup_ids
                    ) ,
                    'fields' => array(
                        'Project.angelist_startup_id'
                    ) ,
                    'recursive' => -1
                ));
                $this->set('existing_startup_ids', $existing_startup_ids);
                $this->set('startups', $startups_arr->startup_roles);
            }
        }
    }
}
?>