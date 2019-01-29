<?php
class EquityEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'View.Project.displaycategory' => array(
                'callable' => 'onCategorydisplay'
            ) ,
            'View.ProjectType.GetProjectStatus' => array(
                'callable' => 'onMessageInbox'
            ) ,
            'Controller.ProjectType.GetProjectStatus' => array(
                'callable' => 'onMessageInbox'
            ) ,
            'Behavior.ProjectType.GetProjectStatus' => array(
                'callable' => 'onMessageInbox',
            ) ,
            'View.Project.onCategoryListing' => array(
                'callable' => 'onCategoryListingRender',
            ) ,
            'View.Project.projectStatusValue' => array(
                'callable' => 'getProjectStatusValue'
            ) ,
            'Model.Project.beforeAdd' => array(
                'callable' => 'onProjectValidation',
            ) ,
            'Controller.Projects.afterAdd' => array(
                'callable' => 'onProjectAdd',
            ) ,
            'Controller.Projects.afterEdit' => array(
                'callable' => 'onProjectEdit',
            ) ,
            'Controller.ProjectFunds.beforeAdd' => array(
                'callable' => 'isAllowAddFund',
            ) ,
            'Controller.ProjectFunds.beforeValidation' => array(
                'callable' => 'onProjectFundValidation',
            ) ,
            'Controller.ProjectFunds.afterAdd' => array(
                'callable' => 'onProjectFundAdd',
            ) ,
            'Controller.Project.openFunding' => array(
                'callable' => 'onOpenFunding',
            ) ,
            'Model.Project.openFunding' => array(
                'callable' => 'onOpenFunding',
            ) ,
            'Controller.ProjectType.projectIds' => array(
                'callable' => 'onMessageDisplay',
            ) ,
            'Controller.ProjectType.ClosedProjectIds' => array(
                'callable' => 'getClosedProjectIds',
            ) ,
            'Controller.ProjectType.getConditions' => array(
                'callable' => 'getConditions',
            ) ,
            'Controller.ProjectType.getContain' => array(
                'callable' => 'getContain',
            ) ,
            'Controller.ProjectType.getProjectTypeStatus' => array(
                'callable' => 'getProjectTypeStatus',
            ) ,
            'View.Project.howitworks' => array(
                'callable' => 'howitworks',
                'priority' => 3
            ) ,
            'View.AdminDasboard.onActionToBeTaken' => array(
                'callable' => 'onActionToBeTakenRender'
            ) ,
            'Controller.FeatureProject.getConditions' => array(
                'callable' => 'getFeatureProjectList'
            ) ,
        );
    }
    /**
     * onCategoryListing
     *
     * @param CakeEvent $event
     * @return void
     */
    public function onCategoryListingRender($event) 
    {
        $content = '';
        if (!empty($event->data['data']['project_type']) && $event->data['data']['project_type'] == 'equity') {
            $view = $event->subject();
            App::import('Model', 'Equity.EquityProjectCategory');
            $this->EquityProjectCategory = new EquityProjectCategory();
            $projectCategories = $this->EquityProjectCategory->find('all', array(
                'fields' => array(
                    'EquityProjectCategory.name',
                    'EquityProjectCategory.slug'
                ) ,
                'limit' => 10,
                'order' => 'EquityProjectCategory.name asc'
            ));
            if (!empty($projectCategories)) {
                $content = '<h4>' . __l('Filter by Category') . '</h4>
        	     <ul class="nav navbar-nav nav-tabs nav-stacked">';
                foreach($projectCategories as $project_category) {
                    $class = (!empty($event->data['data']['category']) && $event->data['data']['category'] == $project_category['EquityProjectCategory']['slug']) ? ' class="active"' : null;
                    $content.= '<li' . $class . '>' . $view->Html->link($project_category['EquityProjectCategory']['name'], array(
                        'controller' => 'projects',
                        'action' => 'index',
                        'category' => $project_category['EquityProjectCategory']['slug'],
                        'project_type' => 'equity',
                    ) , array(
                        'title' => $project_category['EquityProjectCategory']['name']
                    )) . '</li>';
                }
                $content.= '</ul>';
            }
        }
        $event->data['content'] = $content;
    }
    public function onProjectValidation($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        $error = array();
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            App::import('Model', 'Equity.Equity');
            $this->Equity = new Equity();
            $this->Equity->set($data);
            if (!$this->Equity->validates()) {
                $error = $this->Equity->validationErrors;
            }
        }
        $event->data['error']['Equity'] = $error;
    }
    public function onProjectAdd($event) 
    {
        $controller = $event->subject();
        $data = $event->data['data'];
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            $equity = $controller->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $data['Project']['id']
                ) ,
                'contain' => array(
                    'Equity.id',
                    'Equity.equity_project_status_id'
                ) ,
                'recursive' => 0
            ));
            if (!empty($equity) && !empty($equity['Equity']['id'])) {
                $data['Equity']['id'] = $equity['Equity']['id'];
            }
            if (empty($equity['Equity']['equity_project_status_id'])) {
                if (!$data['Project']['is_draft']) {
                    $data['Equity']['equity_project_status_id'] = ConstEquityProjectStatus::Pending;
                } else {
                    $data['Equity']['equity_project_status_id'] = 0;
                }
            }
            $data['Equity']['project_id'] = $data['Project']['id'];
            $data['Equity']['user_id'] = $controller->Auth->user('id');
            if (Configure::read('equity.amount_per_share')) {
                $data['Equity']['total_shares'] = $data['Project']['needed_amount']/Configure::read('equity.amount_per_share');
            }
            $controller->Project->Equity->save($data);
        }
    }
    public function onProjectEdit($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            App::import('Model', 'Equity.Equity');
            $this->Equity = new Equity();
            $equity_data = $this->Equity->find('first', array(
                'conditions' => array(
                    'Equity.project_id' => $data['Project']['id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($data['Project']['publish']) && empty($equity_data['Equity']['equity_project_status_id'])) {
                $data['Equity']['equity_project_status_id'] = ConstEquityProjectStatus::Pending;
            }
            $data['Equity']['id'] = $equity_data['Equity']['id'];
            $this->Equity->save($data);
        }
    }
    public function isAllowAddFund($event) 
    {
        $project = $event->data['data'];
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            App::import('Model', 'Equity.Equity');
            $this->Equity = new Equity();
            $equity_data = $this->Equity->find('first', array(
                'conditions' => array(
                    'Equity.project_id' => $project['Project']['id']
                ) ,
                'recursive' => -1
            ));
            if (strtotime(date('Y-m-d 23:59:59', strtotime($project['Project']['project_end_date']))) > time() && $project['Project']['needed_amount'] <= $project['Project']['collected_amount']) {
                $event->data['error'] = sprintf(__l('%s has been not allowed overfunding') , Configure::read('project.alt_name_for_project_singular_caps'));
            } else {
                $event->data['equity'] = $equity_data;
            }
        }
    }
    public function onProjectFundValidation($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        $project_id = $data['ProjectFund']['project_id'];
        $project = $obj->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'Equity'
            ) ,
            'fields' => array(
                'Project.id',
                'Project.project_type_id',
                'Equity.total_shares',
                'Equity.shares_allocated',
            ) ,
            'recursive' => 0
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity && !empty($data['ProjectFund']['amount'])) {
            $current_shares = ($data['ProjectFund']['amount']/Configure::read('equity.amount_per_share'));
            $user_total_fund = $obj->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.user_id' => $obj->Auth->user('id') ,
                    'ProjectFund.project_id' => $obj->data['ProjectFund']['project_id'],
                    'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized,
                    'ProjectFund.project_type_id' => ConstProjectTypes::Equity,
                ) ,
            ));
            $total_shares_allocated = $obj->ProjectFund->find('all', array(
                'conditions' => array(
                    'ProjectFund.user_id' => $obj->Auth->user('id') ,
                    'ProjectFund.project_id' => $data['ProjectFund']['project_id'],
                    'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized,
                ) ,
                'contain' => array(
                    'EquityFund'
                ) ,
                'fields' => array(
                    'SUM(EquityFund.shares_allocated) as total_shares_allocated',
                ) ,
                'recursive' => 0
            ));
            $total_shares = $total_shares_allocated[0][0]['total_shares_allocated']+$current_shares;
            $project_remaining_shares = $project['Equity']['total_shares']-$project['Equity']['shares_allocated'];
            if ($data['ProjectFund']['amount']%Configure::read('equity.amount_per_share') != 0) {
                $event->data['error']['amount'] = sprintf(__l('You can\'t invest, because given amount should be multiples of %s') , Configure::read('equity.amount_per_share'));
                return false;
            } elseif ($current_shares < Configure::read('equity.min_share_purchase_per_user')) {
                $event->data['error']['amount'] = sprintf(__l('You can\'t invest, because you should invest minimum %s share.') , Configure::read('equity.min_share_purchase_per_user'));;
                return false;
            } elseif ($current_shares > Configure::read('equity.max_share_purchase_per_user')) {
                $event->data['error']['amount'] = sprintf(__l('You can\'t invest, because you can invest maximum %s share only') , Configure::read('equity.max_share_purchase_per_user'));
                return false;
            } elseif ($total_shares > Configure::read('equity.max_share_purchase_per_user')) {
                $event->data['error']['amount'] = sprintf(__l('You can\'t invest, because you can invest maximum %s share only. You already purchased %s share.') , Configure::read('equity.max_share_purchase_per_user') , $total_shares);
                return false;
            } elseif ($current_shares > $project_remaining_shares) {
                $event->data['error']['amount'] = sprintf(__l('You can\'t invest, because you can invest %s share only.') , $project_remaining_shares);
                return false;
            } else {
                return true;
            }
        }
    }
    public function onProjectFundAdd($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        $_data = array();
        $project_id = $data['ProjectFund']['project_id'];
        App::import('Model', 'Equity.Equity');
        $this->Equity = new Equity();
        $project = $this->Equity->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'recursive' => -1
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            App::import('Model', 'Equity.EquityFund');
            $this->EquityFund = new EquityFund();
            $_data['project_fund_id'] = $data['ProjectFund']['id'];
            $_data['shares_allocated'] = ($data['ProjectFund']['amount']/Configure::read('equity.amount_per_share'));
            $project_id = $data['ProjectFund']['project_id'];
            if (!empty($_data)) {
                if ($this->EquityFund->save($_data)) {
                    $project = $obj->ProjectFund->Project->find('first', array(
                        'conditions' => array(
                            'Project.id' => $project_id
                        ) ,
                        'contain' => array(
                            'Equity'
                        ) ,
                        'fields' => array(
                            'Project.id',
                            'Project.project_type_id',
                            'Equity.id',
                            'Equity.total_shares',
                            'Equity.shares_allocated',
                        ) ,
                        'recursive' => 0
                    ));
                    $_Project['id'] = $project['Equity']['id'];
                    $_Project['project_id'] = $project_id;
                    $_Project['shares_allocated'] = $project['Equity']['shares_allocated']+$_data['shares_allocated'];
                    App::import('Model', 'Equity.Equity');
                    $this->Equity = new Equity();
                    $this->Equity->save($_Project);
                }
            }
        }
    }
    public function onOpenFunding($event) 
    {
        $controller = $event->subject();
        if (is_object($controller->Project)) {
            $obj = $controller->Project;
        } else {
            $obj = $controller;
        }
        $event_data = $event->data['data'];
        $type = $event->data['type'];
        $project = $obj->find('first', array(
            'conditions' => array(
                'Project.id' => $event_data['project_id']
            ) ,
            'contain' => array(
                'Equity'
            ) ,
            'recursive' => 0
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            if (isPluginEnabled('Idea') && ($type == 'approve' || $type == 'vote')) {
                if ($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending || empty($project['Equity']['equity_project_status_id'])) {
                    $obj->Equity->updateStatus(ConstEquityProjectStatus::OpenForIdea, $event_data['project_id']);
                    $event->data['message'] = __l('Idea has been opened for voting');
                } else {
                    $event->data['error_message'] = __l('Idea has been already opened for voting');
                }
            } else {
                if ($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea || empty($project['Equity']['equity_project_status_id'])) {
                    $obj->Equity->updateStatus(ConstEquityProjectStatus::OpenForInvesting, $event_data['project_id']);
                    $event->data['message'] = sprintf(__l('%s has been opened for %s') , Configure::read('project.alt_name_for_project_singular_caps') , Configure::read('project.alt_name_for_investor_present_continuous'));
                } else {
                    $event->data['error_message'] = sprintf(__l('%s has been already opened for %s') , Configure::read('project.alt_name_for_project_singular_caps') , Configure::read('project.alt_name_for_investor_present_continuous'));
                }
            }
        }
    }
    public function onCategorydisplay($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        $class = '';
		if(isset($event->data['class'])){
			$class = $event->data['class'];
		}
        $extra_arr = array();
        if (!empty($event->data['target'])) {
            $extra_arr['target'] = '_blank';
        }
        $return = '';
        if ($data['ProjectType']['id'] == ConstProjectTypes::Equity) {
            App::import('Model', 'Equity.Equity');
            $Equity = new Equity;
            $equity = $Equity->find('first', array(
                'conditions' => array(
                    'Equity.project_id' => $data['Project']['id']
                ) ,
                'contain' => array(
                    'EquityProjectCategory'
                ) ,
                'recursive' => 0
            ));
            if (!empty($equity['EquityProjectCategory'])) {
                if ($class == 'categoryname') {
                    $return = $equity['EquityProjectCategory']['name'];
                } else {
                    if ($equity['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea) {
                        $return.= $obj->Html->link($equity['EquityProjectCategory']['name'], array(
                            'controller' => 'projects',
                            'action' => 'index',
                            'category' => $equity['EquityProjectCategory']['slug'],
                            'project_type' => 'equity',
                            'idea' => 'idea'
                        ) , array_merge(array(
                            'title' => $equity['EquityProjectCategory']['name'],
                            'class' => 'text-danger' .$class
                        ) , $extra_arr));
                    } else {
                        $return.= $obj->Html->link($equity['EquityProjectCategory']['name'], array(
                            'controller' => 'projects',
                            'action' => 'index',
                            'category' => $equity['EquityProjectCategory']['slug'],
                            'project_type' => 'equity',
                        ) , array_merge(array(
                            'title' => $equity['EquityProjectCategory']['name'],
                            'class' => 'text-danger' .$class
                        ) , $extra_arr));
                    }
                }
            }
            $event->data['content'] = $return;
        }
    }
    public function onMessageDisplay($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        App::import('Model', 'Equity.Equity');
        $Equity = new Equity;
        $projectIds = $Equity->find('list', array(
            'conditions' => array(
                'Equity.equity_project_status_id' => array(
                    ConstEquityProjectStatus::OpenForInvesting
                ) ,
                'Equity.user_id' => $obj->Auth->user('id') ,
            ) ,
            'fields' => array(
                'Equity.project_id'
            )
        ));
        $projectIds = array_unique(array_merge($projectIds, $data));
        $event->data['ids'] = $projectIds;
        $event->data['projectStatus'] = $this->__getProjectStatus($projectIds);
    }
    public function __getProjectStatus($projectIds) 
    {
        App::import('Model', 'Equity.Equity');
        $Equity = new Equity;
        $equities = $Equity->find('all', array(
            'conditions' => array(
                'Equity.project_id' => $projectIds,
            ) ,
            'contain' => array(
                'EquityProjectStatus'
            ) ,
            'recursive' => 0
        ));
        $projectDetails = array();
        foreach($equities as $key => $equity) {
            $projectDetails[$equity['Equity']['project_id']] = $equity['EquityProjectStatus'];
        }
        return $projectDetails;
    }
    public function getProjectStatusValue($event) 
    {
        $projectStatusIds = $event->data['status_id'];
        $projectTypeId = $event->data['project_type_id'];
        if ($projectTypeId == ConstProjectTypes::Equity) {
            $equityProjectStatus = array(
                ConstEquityProjectStatus::Pending => __l('Pending') ,
                ConstEquityProjectStatus::OpenForInvesting => __l('Open for Investing') ,
                ConstEquityProjectStatus::ProjectClosed => __l('Project Closed') ,
                ConstEquityProjectStatus::ProjectExpired => sprintf(__l('%s Expired') , Configure::read('project.alt_name_for_project_singular_caps')) ,
                ConstEquityProjectStatus::ProjectCanceled => sprintf(__l('%s Canceled') , Configure::read('project.alt_name_for_project_singular_caps')) ,
                ConstEquityProjectStatus::OpenForIdea => __l('Open for voting')
            );
            if (array_key_exists($projectStatusIds, $equityProjectStatus)) {
                $event->data['response'] = $equityProjectStatus[$projectStatusIds];
            } else {
                $event->data['response'] = 0;
            }
        }
    }
    public function onMessageInbox($event) 
    {
        $obj = $event->subject();
        $projectStatus = $event->data['projectStatus'];
        $project = $event->data['project'];
        if (!empty($project['Project']['project_type_id']) && $project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            $projectStatusNew = $this->__getProjectStatus($project['Project']['id']);
            if (!empty($event->data['type']) && $event->data['type'] == 'status') {
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::ProjectClosed
                ))) {
                    $event->data['is_allow_to_print_voucher'] = 1;
                    $event->data['is_allow_to_change_given'] = 1;
                } elseif (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForInvesting
                ))) {
                    $event->data['is_allow_to_cancel_equity'] = 1;
                } elseif (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForIdea
                ))) {
                    $event->data['is_allow_to_vote'] = 1;
                    $event->data['is_allow_to_move_for_funding'] = 1;
                } elseif (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::Pending
                ))) {
                    $event->data['is_allow_to_move_for_voting'] = 1;
                    $event->data['is_allow_to_move_for_funding'] = 1;
                    if (isPluginEnabled('Idea')) {
                        $event->data['is_show_vote'] = 1;
                    }
                }
                if (!in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::ProjectClosed
                ))) {
                    $event->data['is_allow_to_change_status'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForInvesting,
                    ConstEquityProjectStatus::Pending
                ))) {
                    $event->data['is_allow_to_cancel_project'] = 1;
                }
                if (!in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::ProjectCanceled,
                    ConstEquityProjectStatus::ProjectExpired
                ))) {
                    $event->data['is_allow_to_follow'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::Pending,
                    ConstEquityProjectStatus::ProjectCanceled
                ))) {
                    $event->data['is_affiliate_status_pending'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::ProjectClosed
                ))) {
                    $event->data['is_not_show_you_here'] = 1;
                }
                if (!in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::Pending,
                    ConstEquityProjectStatus::OpenForIdea
                ))) {
                    $event->data['is_show_project_funding_tab'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForInvesting
                ))) {
                    $event->data['is_allow_to_fund'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForIdea,
                    ConstEquityProjectStatus::OpenForInvesting
                ))) {
                    $event->data['is_allow_to_share'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::Pending
                ))) {
                    $event->data['is_allow_to_pay_listing_fee'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    0,
                    ConstEquityProjectStatus::Pending,
                    ConstEquityProjectStatus::OpenForIdea
                )) || (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::OpenForInvesting
                )) && Configure::read('Project.is_allow_project_owner_to_edit_project_in_open_status'))) {
                    $event->data['is_allow_to_edit_fund'] = 1;
                }
                if (in_array($projectStatusNew[$project['Project']['id']]['id'], array(
                    ConstEquityProjectStatus::Pending
                ))) {
                    $event->data['is_pending_status'] = 1;
                }
            }
            if (empty($projectStatus)) {
                $event->data['projectStatus'] = $projectStatusNew;
            } else {
                $event->data['projectStatus'] = $projectStatusNew+$projectStatus;
            }
        }
    }
    public function getClosedProjectIds($event) 
    {
        $obj = $event->subject();
        $project_ids = $event->data['project_ids'];
        $status_id = ConstEquityProjectStatus::ProjectClosed;
        $conditions = array();
        $conditions['Equity.project_id'] = $project_ids;
        $conditions['Equity.equity_project_status_id'] = $status_id;
        $tmp_project_ids = $this->__getProjectIds($conditions);
        $conditions = array();
        $conditions['Equity.user_id'] = $obj->Auth->user('id');
        $conditions['Equity.equity_project_status_id'] = $status_id;
        $tmp1_project_ids = $this->__getProjectIds($conditions);
        $event->data['project_ids'] = array_unique(array_merge($tmp_project_ids, $tmp1_project_ids));
    }
    public function __getProjectIds($conditions) 
    {
        App::import('Model', 'Equity.Equity');
        $equity = new Equity();
        $projectIds = $equity->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'Equity.project_id'
            )
        ));
        return $projectIds;
    }
    public function getConditions($event) 
    {
        if (!empty($event->data['data'])) {
            $data = $event->data['data'];
        }
        if (!empty($event->data['type'])) {
            $type = $event->data['type'];
        }
        if (!empty($event->data['page'])) {
            $page = $event->data['page'];
        }
        if (!empty($data) && $data['ProjectType']['id'] == ConstProjectTypes::Equity) {
            if ($type == 'idea') {
                $event->data['conditions'] = array(
                    'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForIdea
                );
            } elseif ($type == 'open') {
                $event->data['conditions']['OR'][]['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForInvesting;
            } elseif ($type == 'search') {
                $event->data['conditioNs']['OR'][]['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForIdea;
                $event->data['conditioNs']['OR'][]['Equity.equity_project_status_id'] = ConstEquityProjectStatus::OpenForInvesting;
            } elseif ($type == 'closed') {
                $event->data['conditions'] = array(
                    'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed
                );
            } elseif ($type == 'notclosed') {
                $event->data['conditions'] = array(
                    'Equity.equity_project_status_id != ' => ConstEquityProjectStatus::ProjectClosed
                );
            }
        } elseif (!empty($page)) {
            if ($type == 'idea') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForIdea
                );
            } elseif ($type == 'myprojects') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id NOT' => array(
                        ConstEquityProjectStatus::Pending,
                        ConstEquityProjectStatus::OpenForIdea,
                        ConstEquityProjectStatus::ProjectCanceled,
                        ConstEquityProjectStatus::ProjectExpired
                    )
                );
            } elseif ($type == 'search') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id NOT' => array(
                        ConstEquityProjectStatus::Pending,
                    )
                );
            } elseif ($type == 'open') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForInvesting
                    )
                );
            } elseif ($type == 'project_count') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForInvesting,
                        ConstEquityProjectStatus::ProjectClosed
                    )
                );
            } elseif ($type == 'all_project_count') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id NOT' => array(
                        ConstEquityProjectStatus::OpenForIdea
                    )
                );
            } elseif ($type == 'idea_count') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForIdea
                    )
                );
            } elseif ($type == 'count') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForInvesting,
                        ConstEquityProjectStatus::ProjectClosed,
                        ConstEquityProjectStatus::OpenForIdea
                    )
                );
            } elseif ($type == 'city_count') {
                $event->data['conditions']['OR'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForInvesting
                    )
                );
            } elseif ($type == 'iphone') {
                $event->data['conditions']['AND'][] = array(
                    'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::OpenForInvesting
                    )
                );
            }
        }
    }
    public function getContain($event) 
    {
        $obj = $event->subject();
        switch ($event->data['type']) {
            case 1:
                $event->data['contain']['Equity'] = array(
                    'EquityProjectCategory',
                    'EquityProjectStatus',
                );
                break;

            case 2:
                $event->data['contain']['Equity'] = array(
                    'fields' => array(
                        'id'
                    )
                );
                break;
        }
    }
    public function getProjectTypeStatus($event) 
    {
        $obj = $event->subject();
        $project = $event->data['project'];
        if (!empty($project['Equity'])) {
            $data = array();
            $data['Project_funding_text'] = __l('Funding amount');
            $data['Project_funded_text'] = Configure::read('project.alt_name_for_equity_past_tense_small');
            $data['Project_fund_button_lable'] = Configure::read('project.alt_name_for_equity_singular_caps');
            $data['Project_status_name'] = $project['Equity']['EquityProjectStatus']['name'];
            if (($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting)) {
                if (($obj->Auth->user('id') != $project['Project']['user_id']) || Configure::read('Project.is_allow_owner_fund_own_project')) {
                    $data['Project_fund_button_status'] = true;
                    $data['Project_fund_button_url'] = Router::url(array(
                        'controller' => 'project_funds',
                        'action' => 'add',
                        $project['Project']['id']
                    ) , true);
                } else {
                    $data['Project_fund_button_status'] = false;
                    $data['Project_fund_button_url'] = '';
                }
            } else {
                $data['Project_fund_button_status'] = false;
            }
            if ((strtotime($project['Project']['project_end_date']) < strtotime(date('Y-m-d'))) && ($project['Project']['needed_amount'] != $project['Project']['collected_amount'])) {
                $data['Project_status'] = -1;
            } else if ($project['Project']['needed_amount'] == $project['Project']['collected_amount']) {
                $data['Project_status'] = 1;
            } else {
                $data['Project_status'] = 0;
            }
            $data['Invested'] = $project['Project']['collected_amount'];
            $data['Category_name'] = $project['EquityProjectCategory']['name'];
            $event->data['data'] = $data;
        }
    }
    public function howitworks($event) 
    {
        $view = $event->subject();
        App::import('Model', 'PaymentGatewaySetting');
        $this->PaymentGatewaySetting = new PaymentGatewaySetting();
        $arrInvestWallet = $this->PaymentGatewaySetting->find('first', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::Wallet,
                'PaymentGatewaySetting.name' => 'is_enable_for_equity'
            ) ,
            'recursive' => 0
        ));
        if ($arrInvestWallet['PaymentGateway']['is_test_mode']) {
            $data['is_equity_wallet_enabled'] = $arrInvestWallet['PaymentGatewaySetting']['test_mode_value'];
        } else {
            $data['is_equity_wallet_enabled'] = $arrInvestWallet['PaymentGatewaySetting']['live_mode_value'];
        }
        echo $view->element('Equity.how_it_works', $data);
    }
    public function onActionToBeTakenRender($event) 
    {
        $view = $event->subject();
        App::import('Model', 'User');
        $user = new User();
        App::import('Model', 'Equity.Equity');
        $equity = new Equity();
        $data['equity_pending_for_approval_count'] = $equity->Project->find('count', array(
            'conditions' => array(
                'Project.project_type_id' => ConstProjectTypes::Equity,
                'Project.is_pending_action_to_admin = ' => 1
            ) ,
            'recursive' => -1
        ));
        $data['equity_user_flagged_count'] = $user->Project->find('count', array(
            'conditions' => array(
                'Project.is_user_flagged' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        $data['equity_system_flagged_count'] = $user->Project->find('count', array(
            'conditions' => array(
                'Project.is_system_flagged' => 1,
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        $event->data['content']['PendingProject'].= $view->element('Equity.admin_action_taken_pending', $data);
        $event->data['content']['FlaggedProjects'].= $view->element('Equity.admin_action_taken', $data);
    }
    public function getFeatureProjectList($event) 
    {
        $controller = $event->subject();
		$conditions = array();
		$conditions['Project.is_active'] = 1;
		$conditions['Project.is_draft'] = 0;
		$conditions['Project.is_admin_suspended'] = '0';
		$conditions['Project.project_end_date >= '] = date('Y-m-d');
		$conditions['Project.project_type_id'] = ConstProjectTypes::Equity;
		
		$conditions['NOT'] = array( 'Equity.equity_project_status_id' => array(
                        ConstEquityProjectStatus::Pending,
						ConstEquityProjectStatus::ProjectExpired,
						ConstEquityProjectStatus::ProjectCanceled
                    ));
					
		$contain = array(
			'Attachment',
			'Equity'
		);
		$order = array(
			'Project.is_featured' => 'desc',
			'Project.id' => 'desc'
		);            
		$equity = $controller->Project->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain,
			'recursive' => 3,
			'order' => $order,
			'limit' => 4
		));
		$event->data['content']['Equity'] = $equity;
    }
}
?>