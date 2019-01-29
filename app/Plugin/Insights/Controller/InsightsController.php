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
class InsightsController extends AppController
{
    public $name = 'Insights';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public function initChart() 
    {
        //# last days date settings
        $days = 6;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00') ,
				'#MODEL#.created <=' => date('Y-m-d 23:59:59')
            )
        );
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d', $timestamp_end+24*3600) ,
                '#MODEL#.created <=' => date('Y-m-d', strtotime('now'))
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-t', strtotime("-$i months")) ,
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-m-t', strtotime('now')) ,
            )
        );
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-31', strtotime("-$i years")) ,
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-01-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-12-31', strtotime('now')) ,
            )
        );
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    function admin_index() 
    {
        $this->pageTitle = __l('Insights');
    }
    public function admin_chart_transactions() 
    {
        $this->loadModel('Projects.ProjectFund');
        $this->initChart();
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $conditions = array();
        //Transaction block
        $transaction_model_datas = array();
        $transaction_model_datas['Revenue From Sign Up'] = array(
            'display' => __l('Revenue From Sign Up') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'fields' => array(
                'sum(Transaction.amount) as total_amount'
            ) ,
            'conditions' => array(
                'Transaction.class' => 'User',
                'Transaction.transaction_type_id' => ConstTransactionTypes::SignupFee
            ) ,
        );
        $transaction_model_datas['Revenue From Project'] = array(
            'display' => sprintf(__l('Revenue From %s') , Configure::read('project.alt_name_for_project_singular_caps')) . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'fields' => array(
                'sum(Transaction.amount) as total_amount'
            ) ,
            'conditions' => array(
                'Transaction.class' => 'Project',
                'Transaction.transaction_type_id' => ConstTransactionTypes::ListingFee
            ) ,
        );
        $transaction_model_datas['Funding'] = array(
            'display' => __l('Funding') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'fields' => array(
                'sum(Transaction.amount) as total_amount'
            ) ,
            'conditions' => array(
                'Transaction.class' => 'ProjectFund',
                'Transaction.transaction_type_id' => ConstTransactionTypes::ProjectBacked
            ) ,
        );
        $transaction_model_datas['Revenue From Commission'] = array(
            'display' => __l('Revenue From Commission') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'ProjectFund',
            'fields' => array(
                'sum(ProjectFund.site_fee) as total_amount'
            ) ,
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::PaidToOwner
            ) ,
        );
        if (isPluginEnabled('Wallet')) {
            $transaction_model_datas['Deposited'] = array(
                'display' => __l('Deposited') . ' (' . Configure::read('site.currency') . ')',
                'model' => 'Transaction',
                'fields' => array(
                    'sum(Transaction.amount) as total_amount'
                ) ,
                'conditions' => array(
                    'Transaction.class' => 'UserAddWalletAmount',
                    'Transaction.transaction_type_id' => ConstTransactionTypes::AmountAddedToWallet
                ) ,
            );
            if (isPluginEnabled('Withdrawals')) {
                $transaction_model_datas['Withdrawn'] = array(
                    'display' => __l('Withdrawn') . ' (' . Configure::read('site.currency') . ')',
                    'model' => 'Transaction',
                    'fields' => array(
                        'sum(Transaction.amount) as total_amount'
                    ) ,
                    'conditions' => array(
                        'Transaction.class' => 'UserCashWithdrawal',
                        'Transaction.transaction_type_id' => ConstTransactionTypes::CashWithdrawalRequestPaid
                    ) ,
                );
                $transaction_model_datas['Withdraw Requests'] = array(
                    'display' => __l('Withdraw Requests') . ' (' . Configure::read('site.currency') . ')',
                    'model' => 'Transaction',
                    'fields' => array(
                        'sum(Transaction.amount) as total_amount'
                    ) ,
                    'conditions' => array(
                        'Transaction.class' => 'UserCashWithdrawal',
                        'Transaction.transaction_type_id' => ConstTransactionTypes::CashWithdrawalRequest
                    ) ,
                );
            }
        }
        $chart_transactions_data = $this->_admin_chart_amounts($transaction_model_datas, $select_var);
        $this->set('selectRanges', $this->selectRanges);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $project_fund_model_datas = $common_conditions = array();
        $project_fund_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array(
                'ProjectFund.project_fund_status_id != ' => ConstProjectFundStatus::PendingToPay
            )
        );
        $project_fund_model_datas['Backed'] = array(
            'display' => __l('Backed') ,
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized
            )
        );
        $project_fund_model_datas['Refunded'] = array(
            'display' => __l('Refunded') ,
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Expired,
                    ConstProjectFundStatus::Canceled,
                )
            )
        );
        $project_fund_model_datas['Paid'] = array(
            'display' => __l('Paid') ,
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::PaidToOwner
            )
        );
        $chart_project_funds_data = $this->_setLineData($select_var, $project_fund_model_datas, 'Projects.ProjectFund', 'ProjectFund', $common_conditions);
        $this->set('chart_project_funds_data', $chart_project_funds_data);
        $this->set('chart_project_funds_periods', $project_fund_model_datas);
        // count queries
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_user_count = $this->ProjectFund->User->find('count', array(
            'conditions' => array(
                'User.role_id' => ConstUserTypes::User,
                'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        $this->set('total_user_count', $total_user_count);
        $total_revenue_arr = $this->ProjectFund->find('all', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::PaidToOwner,
                'ProjectFund.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'ProjectFund.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'fields' => array(
                'SUM(ProjectFund.site_fee) as site_fee'
            ) ,
            'recursive' => -1
        ));
        $total_revenue = $total_revenue_arr[0][0]['site_fee'];
        $this->set('total_revenue', $total_revenue);
        $total_project_count = $this->Project->find('count', array(
            'conditions' => array(
                'Project.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'Project.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        $this->set('total_project_count', $total_project_count);
        $total_project_fund_count = $this->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Authorized,
                    ConstProjectFundStatus::PaidToOwner,
                    ConstProjectFundStatus::Closed,
                    ConstProjectFundStatus::DefaultFund
                ) ,
                'ProjectFund.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'ProjectFund.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        $this->set('total_project_fund_count', $total_project_fund_count);
    }
    public function _admin_chart_amounts($model_datas, $select_var) 
    {
        $chart_model_data = array();
        $this->loadModel('Transaction');
        $this->loadModel('Projects.Project');
        $this->loadModel('Projects.ProjectFund');
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Project' && $model_data['display_field'] == 'RevenueCommission') {
                    $value_count = $this->Project->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Project.commision_amount_paid) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Project' && $model_data['display_field'] == 'ListingFee') {
                    $value_count = $this->Project->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Project.listing_fee) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'ProjectFund') {
                    $value_count = $this->ProjectFund->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(ProjectFund.site_fee) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_model_data[$val['display']][] = $value_count;
            }
        }
        return $chart_model_data;
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array()) 
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
            }
        }
        return $_data;
    }
    public function admin_chart_users() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('User');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_angellist_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['GooglePlus'] = array(
            'display' => __l('GooglePlus') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d 23:59:59');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                    'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_user_demographics() 
    {
        $this->loadModel('User');
        $select_var = 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $role_id = ConstUserTypes::User;
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
            ) ,
            'recursive' => -1
        ));
        $conditions = array(
            'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
            'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
            'User.role_id' => $role_id
        );
        $_pie_data = $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        $check_user = $this->User->UserProfile->find('count', array(
            'conditions' => $conditions,
            'recursive' => 1
        ));
        $total_users = $check_user;
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = $not_mentioned+$user_educations;
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.education_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = $not_mentioned+$user_relationships;
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.relationship_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = $not_mentioned+$user_employments;
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.employment_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = $not_mentioned+$user_income_ranges;
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.income_range_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.income_range_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = $not_mentioned+$genders;
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = $not_mentioned+$user_ages;
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
                } elseif ($age_key == 2) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
                } elseif ($age_key == 3) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
                } elseif ($age_key == 4) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
                } elseif ($age_key == 0) {
                    $new_conditions['OR']['UserProfile.dob'] = NULL;
                    $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        } else {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                if ($edu_key == 0) {
                    $chart_pie_education_data[$user_education] = 100;
                } else {
                    $chart_pie_education_data[$user_education] = 0;
                }
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                if ($rel_key == 0) {
                    $chart_pie_relationship_data[$user_relationship] = 100;
                } else {
                    $chart_pie_relationship_data[$user_relationship] = 0;
                }
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                if ($emp_key == 0) {
                    $chart_pie_employment_data[$user_employment] = 100;
                } else {
                    $chart_pie_employment_data[$user_employment] = 0;
                }
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                if ($inc_key == 0) {
                    $chart_pie_income_data[$user_income_range] = 100;
                } else {
                    $chart_pie_income_data[$user_income_range] = 0;
                }
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                if ($gen_key == 0) {
                    $chart_pie_gender_data[$gender] = 100;
                } else {
                    $chart_pie_gender_data[$gender] = 0;
                }
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                if ($age_key == 0) {
                    $chart_pie_age_data[$user_ages] = 100;
                } else {
                    $chart_pie_age_data[$user_ages] = 0;
                }
            }
        }
        $this->set('role_id', $role_id);
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    public function admin_chart_user_logins() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['Gmail'] = array(
            'display' => __l('Google+') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'UserLogin.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'UserLogin.created <=' => date('Y-m-d H:i:s', strtotime($endDate)) ,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                    'UserLogin.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_user_activities_insights() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['Gmail'] = array(
            'display' => __l('Google+') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // User Follow
        $model_datas = array();
        $model_datas['user-follow'] = array(
            'display' => __l('User Followers') ,
            'conditions' => array()
        );
        $_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFollower', 'UserFollower');
        // Project Comments
        $model_datas = array();
        $conditions['Message.is_activity'] = 0;
        $conditions['Message.is_sender'] = 1;
        $conditions['NOT'] = array(
            'Message.project_id' => 0
        );
        $model_datas['project_comments'] = array(
            'display' => __l('Project Comments') ,
            'conditions' => array()
        );
        $_project_comments_data = $this->_setLineData($select_var, $model_datas, 'Message', 'Message', $conditions);
        if (isPluginEnabled('ProjectUpdates')) {
			// Project Updates
			$model_datas = array();
			$this->loadModel('ProjectUpdates.Blog');
			$model_datas['project_updates'] = array(
				'display' => __l('Project Updates') ,
				'conditions' => array()
			);
			$_project_updates_data = $this->_setLineData($select_var, $model_datas, 'Blog', 'Blog');
			// Project Update comments
			$model_datas = array();
			$this->loadModel('ProjectUpdates.BlogComment');
			$model_datas['project_updates_comments'] = array(
				'display' => __l('Project Update Comments') ,
				'conditions' => array()
			);
			$_project_update_comments_data = $this->_setLineData($select_var, $model_datas, 'BlogComment', 'BlogComment');
		}
        // Project Rating
        $model_datas = array();
        $model_datas['project_rating'] = array(
            'display' => __l('Project Ratings') ,
            'conditions' => array()
        );
        $_project_rating_data = $this->_setLineData($select_var, $model_datas, 'ProjectRating', 'ProjectRating');
		if (isPluginEnabled('ProjectFollowers')) {
			// Project Followers
			$model_datas = array();
			$model_datas['project_follow'] = array(
				'display' => __l('Project Followers') ,
				'conditions' => array()
			);
			$_project_follower_data = $this->_setLineData($select_var, $model_datas, 'ProjectFollower', 'ProjectFollower');
		}
		if (isPluginEnabled('ProjectFlags')) {
		   // Project Flags
			$model_datas = array();
			$model_datas['project_flag'] = array(
				'display' => __l('Project Flags') ,
				'conditions' => array()
			);
			$_project_flag_data = $this->_setLineData($select_var, $model_datas, 'ProjectFlag', 'ProjectFlag');
		}
        $this->set('user_follow_data', $_user_follow_data);
        $this->set('project_comments_data', $_project_comments_data);
		if (isPluginEnabled('ProjectUpdates')) {
			$this->set('project_updates_data', $_project_updates_data);
			$this->set('project_update_comments_data', $_project_update_comments_data);
		}
        $this->set('project_rating_data', $_project_rating_data);
		if (isPluginEnabled('ProjectFollowers')) {
			$this->set('project_follower_data', $_project_follower_data);
		}
		if (isPluginEnabled('ProjectFlags')) {
			$this->set('project_flag_data', $_project_flag_data);
		}
    }
    public function admin_chart_price_points() 
    {
        $this->loadModel('Projects.Project');
        $pricePoints = array(
            array(
                'price_points' => '0 - 499.99',
                'range' => array(
                    0,
                    499.99
                )
            ) ,
            array(
                'price_points' => '500 - 999.99',
                'range' => array(
                    500,
                    999.99
                )
            ) ,
            array(
                'price_points' => '1000 - 2499.99',
                'range' => array(
                    1000,
                    2499.99
                )
            ) ,
            array(
                'price_points' => '2500 - 4999.99',
                'range' => array(
                    2500,
                    4999.99
                )
            ) ,
            array(
                'price_points' => '5000 - 7499.99',
                'range' => array(
                    5000,
                    7499.99
                )
            ) ,
            array(
                'price_points' => '7500 - 9999.99',
                'range' => array(
                    7500,
                    9999.99
                )
            ) ,
            array(
                'price_points' => '10000 - 14999.99',
                'range' => array(
                    10000,
                    14999.99
                )
            ) ,
            array(
                'price_points' => '15000 - 19999.99',
                'range' => array(
                    15000,
                    19999.99
                )
            ) ,
            array(
                'price_points' => '20000 - 24999.99',
                'range' => array(
                    20000,
                    24999.99
                )
            ) ,
            array(
                'price_points' => '25000 +',
                'range' => array(
                    25000
                )
            )
        );
        foreach($pricePoints as $key => $pricePoint) {
            $new_conditions = array();
            $new_conditions['Project.needed_amount >='] = $pricePoint['range'][0];
            if (isset($pricePoint['range'][1])) {
                $new_conditions['Project.needed_amount <='] = $pricePoint['range'][1];
            }
            $db = ConnectionManager::getDataSource('default');
            $sum_total_revenue_project = $this->Project->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(' . $db->name('Project.commission_amount') . ' + ' . $db->name('Project.fee_amount') . ') as revenue',
                ) ,
                'recursive' => -1
            ));
            if (!empty($sum_total_revenue_project)) {
                $pricePoints[$key]['revenue'] = is_null($sum_total_revenue_project[0][0]['revenue']) ? 0 : $sum_total_revenue_project[0][0]['revenue'];
            } else {
                $pricePoints[$key]['revenue'] = 0;
            }
            $pricePoints[$key]['projects_count'] = $this->Project->find('count', array(
                'conditions' => $new_conditions,
                'recursive' => -1
            ));
            $project_ids = $this->Project->find('list', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'Project.id'
                ) ,
                'recursive' => -1
            ));
            $funds = $this->Project->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_id' => $project_ids
                ) ,
                'recursive' => -1
            ));
            $pricePoints[$key]['funds'] = is_null($funds) ? 0 : $funds;
            $pricePoints[$key]['average_project_fund_count'] = !empty($pricePoints[$key]['projects_count']) ? ($pricePoints[$key]['funds']/$pricePoints[$key]['projects_count']) : 0;
            $pricePoints[$key]['average_revenue_project_amoumt'] = !empty($pricePoints[$key]['projects_count']) ? ($pricePoints[$key]['revenue']/$pricePoints[$key]['projects_count']) : 0;
        }
        $this->set('pricePoints', $pricePoints);
    }
    public function admin_chart_projects_stats() 
    {
        $this->loadModel('Projects.Project');
        $projects_stats = array();
        // needed _amount
        $min_project_needed_amount = $this->Project->find('all', array(
            'conditions' => array(
                'Project.needed_amount != ' => '0.00'
            ) ,
            'fields' => array(
                'MIN(Project.needed_amount) as min_project_needed_amount',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['needed_amount']['min'] = is_null($min_project_needed_amount[0][0]['min_project_needed_amount']) ? 0 : $min_project_needed_amount[0][0]['min_project_needed_amount'];
        $max_project_needed_amount = $this->Project->find('all', array(
            'fields' => array(
                'MAX(Project.needed_amount) as max_project_needed_amount',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['needed_amount']['max'] = is_null($max_project_needed_amount[0][0]['max_project_needed_amount']) ? 0 : $max_project_needed_amount[0][0]['max_project_needed_amount'];
        // collected amount
        $min_project_collected_amount = $this->Project->find('all', array(
            'conditions' => array(
                'Project.collected_amount != ' => '0.00'
            ) ,
            'fields' => array(
                'MIN(Project.collected_amount) as min_project_collected_amount',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['collected_amount']['min'] = is_null($min_project_collected_amount[0][0]['min_project_collected_amount']) ? 0 : $min_project_collected_amount[0][0]['min_project_collected_amount'];
        $max_project_collected_amount = $this->Project->find('all', array(
            'fields' => array(
                'MAX(Project.collected_amount) as max_project_collected_amount',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['collected_amount']['max'] = is_null($max_project_collected_amount[0][0]['max_project_collected_amount']) ? 0 : $max_project_collected_amount[0][0]['max_project_collected_amount'];
        // Site Commission
        $min_site_commision = $this->Project->find('all', array(
            'conditions' => array(
                'Project.commission_amount != ' => '0'
            ) ,
            'fields' => array(
                'MIN(Project.commission_amount) as min_site_commision',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['commission_amount']['min'] = is_null($min_site_commision[0][0]['min_site_commision']) ? 0 : $min_site_commision[0][0]['min_site_commision'];
        $max_site_commision = $this->Project->find('all', array(
            'fields' => array(
                'MAX(Project.commission_amount) as max_site_commision',
            ) ,
            'recursive' => -1
        ));
        $projects_stats['commission_amount']['max'] = is_null($max_site_commision[0][0]['max_site_commision']) ? 0 : $max_site_commision[0][0]['max_site_commision'];
        $this->set('projects_stats', $projects_stats);
    }
    public function chart_demographics() 
    {
        $this->loadModel('Projects.Project');
        $conditions = array();
        $conditions['Project.user_id'] = $this->Auth->user('id');
        $projects = $this->Project->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'Project.id',
            ) ,
            'recursive' => -1
        ));
        $fuded_users = $this->Project->ProjectFund->find('list', array(
            'conditions' => array(
                'ProjectFund.project_id' => $projects
            ) ,
            'fields' => array(
                'ProjectFund.id',
                'ProjectFund.user_id',
            ) ,
            'recursive' => -1
        ));
        $total_users = count($fuded_users);
        // demographics
        $conditions = array(
            'UserProfile.user_id' => $fuded_users
        );
        $this->_setDemographics($total_users, $conditions);
        $this->set('user_type_id', $this->Auth->user('role_id'));
    }
    public function chart_user_transactions() 
    {
        $this->initChart();
        $this->loadModel('Transaction');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Project Amount Received'] = array(
            'display' => __l('Amount Received') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::ProjectBacked,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
            'display' => __l('Deposited Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AmountAddedToWallet,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->_setProjectFunds($select_var);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $this->set('selectRanges', $this->selectRanges);
    }
    public function admin_project_detailed_stats($project_id) 
    {
        $this->setAction('project_detailed_stats', $project_id);
    }
    public function project_detailed_stats($project_id) 
    {
        $this->pageTitle = sprintf(__l('%s Stats') , Configure::read('project.alt_name_for_project_singular_caps'));
        $this->loadModel('Projects.Project');
        $conditions = array();
        $conditions['Project.id'] = $project_id;
        $project = $this->Project->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'ProjectFund' => array(
                    'order' => array(
                        'ProjectFund.created' => 'ASC'
                    ) ,
                )
            ) ,
            'recursive' => 1
        ));
        if (empty($project)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $project_funds = array();
        $project_stats = array();
        $project_stats['needed_amount'] = $project['Project']['needed_amount'];
        $project_stats['collected_amount'] = $project['Project']['collected_amount'];
        $project_stats['fund_count'] = $project['Project']['project_fund_count'];
        $project_stats['site_commission'] = $project['Project']['commission_amount'];
        $projectUserIds = array();
        if (!empty($project['ProjectFund'])) {
            $projectUserIds = array();
            foreach($project['ProjectFund'] as $projectFunds) {
                $projectUserIds[$projectFunds['id']] = $projectFunds['user_id'];
            }
        }
        $total_users = count($project['ProjectFund']);
        // demographics
        $conditions = array(
            'UserProfile.user_id' => array_unique($projectUserIds)
        );
        $this->pageTitle.= ' - ' . substr($project['Project']['name'], 0, 100);
        $this->pageTitle.= (strlen($project['Project']['name']) > 100) ? '...' : '';
        $this->_setDemographics($total_users, $conditions);
        $this->set('project', $project);
        $this->set('user_type_id', $this->Auth->user('role_id'));
        $this->set('project_stats', $project_stats);
    }
    protected function _setDemographics($total_users, $conditions = array()) 
    {
        $this->loadModel('User');
        $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        $check_user = $this->User->UserProfile->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $total_users = $check_user;
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = $not_mentioned+$user_educations;
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.education_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = $not_mentioned+$user_relationships;
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.relationship_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = $not_mentioned+$user_employments;
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.employment_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = $not_mentioned+$user_income_ranges;
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.income_range_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.income_range_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = $not_mentioned+$genders;
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = $not_mentioned+$user_ages;
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
                } elseif ($age_key == 2) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
                } elseif ($age_key == 3) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
                } elseif ($age_key == 4) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
                } elseif ($age_key == 0) {
                    $new_conditions['OR']['UserProfile.dob'] = NULL;
                    $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        } else {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                if ($edu_key == 0) {
                    $chart_pie_education_data[$user_education] = 100;
                } else {
                    $chart_pie_education_data[$user_education] = 0;
                }
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                if ($rel_key == 0) {
                    $chart_pie_relationship_data[$user_relationship] = 100;
                } else {
                    $chart_pie_relationship_data[$user_relationship] = 0;
                }
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                if ($emp_key == 0) {
                    $chart_pie_employment_data[$user_employment] = 100;
                } else {
                    $chart_pie_employment_data[$user_employment] = 0;
                }
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                if ($inc_key == 0) {
                    $chart_pie_income_data[$user_income_range] = 100;
                } else {
                    $chart_pie_income_data[$user_income_range] = 0;
                }
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                if ($gen_key == 0) {
                    $chart_pie_gender_data[$gender] = 100;
                } else {
                    $chart_pie_gender_data[$gender] = 0;
                }
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                if ($age_key == 0) {
                    $chart_pie_age_data[$user_ages] = 100;
                } else {
                    $chart_pie_age_data[$user_ages] = 0;
                }
            }
        }
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    protected function _setProjectFunds($select_var) 
    {
        $this->loadModel('Projects.Project');
        $common_conditions = array();
        $owner = $this->Project->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $project_id = $this->Project->find('list', array(
            'conditions' => array(
                'Project.user_id' => $owner['User']['id']
            ) ,
            'fields' => array(
                'Project.id'
            ) ,
            'recursive' => -1
        ));
        $common_conditions['ProjectFund.project_id'] = $project_id;
        $project_fund_model_datas['Funds'] = array(
            'display' => __l('Funds') ,
            'conditions' => array() ,
        );
        $chart_project_fund_data = $this->_setLineData($select_var, $project_fund_model_datas, array(
            'Projects.ProjectFund'
        ) , 'ProjectFund', $common_conditions);
        $this->set('chart_project_funds_data', $chart_project_fund_data);
    }
    public function admin_project_stats() 
    {
        $this->pageTitle = sprintf(__l('%s Snapshot') , Configure::read('project.alt_name_for_project_singular_caps'));
        $this->set('pageTitle', $this->pageTitle);
    }
    public function public_stats() 
    {
        $this->pageTitle = __l('Stats');
        $this->set('pageTitle', $this->pageTitle);
        $this->loadModel('Pledge.Pledge');
        $new_conditions['Pledge.pledge_project_status_id >='] = ConstPledgeProjectStatus::OpenForFunding;
        $this->set('launched_projects', $this->Pledge->find('count', array(
            'conditions' => $new_conditions,
        )));
        $this->set('launched_projects_amount', $this->Pledge->Project->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Project.collected_amount) as launched_projects_amount',
            )
        )));
        $new_conditions = array();
        $new_conditions['Pledge.pledge_project_status_id'] = ConstPledgeProjectStatus::FundingClosed;
        $new_conditions['Project.is_successful'] = 1;
        $this->set('successful_projects_amount', $this->Pledge->Project->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Project.collected_amount) as successful_projects_amount',
            )
        )));
        $this->set('successful_projects', $this->Pledge->Project->find('count', array(
            'conditions' => $new_conditions,
        )));
        $new_conditions = array();
        $new_conditions['Pledge.pledge_project_status_id'] = array(
            ConstPledgeProjectStatus::FundingExpired,
            ConstPledgeProjectStatus::ProjectCanceled
        );
        $new_conditions['Project.is_successful'] = 0;
        $this->set('unsuccessful_projects_amount', $this->Pledge->Project->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Project.collected_amount) as unsuccessful_projects_amount',
            )
        )));
        $this->set('unsuccessful_projects', $this->Pledge->Project->find('count', array(
            'conditions' => $new_conditions,
        )));
        $new_conditions = array();
        $new_conditions['Pledge.pledge_project_status_id'] = ConstPledgeProjectStatus::OpenForFunding;
        $this->set('live_projects', $this->Pledge->find('count', array(
            'conditions' => $new_conditions,
        )));
        $this->set('live_projects_amount', $this->Pledge->Project->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Project.collected_amount) as live_projects_amount',
            )
        )));
        //successful projects
        $pricePoints = array(
            array(
                'price_points' => '0 - 499.99',
                'range' => array(
                    0,
                    499.99
                )
            ) ,
            array(
                'price_points' => '500 - 999.99',
                'range' => array(
                    500,
                    999.99
                )
            ) ,
            array(
                'price_points' => '1000 - 2499.99',
                'range' => array(
                    1000,
                    2499.99
                )
            ) ,
            array(
                'price_points' => '2500 - 4999.99',
                'range' => array(
                    2500,
                    4999.99
                )
            ) ,
            array(
                'price_points' => '5000 - 7499.99',
                'range' => array(
                    5000,
                    7499.99
                )
            ) ,
            array(
                'price_points' => '7500 - 9999.99',
                'range' => array(
                    7500,
                    9999.99
                )
            ) ,
            array(
                'price_points' => '10000 - 14999.99',
                'range' => array(
                    10000,
                    14999.99
                )
            ) ,
            array(
                'price_points' => '15000 - 19999.99',
                'range' => array(
                    15000,
                    19999.99
                )
            ) ,
            array(
                'price_points' => '20000 - 24999.99',
                'range' => array(
                    20000,
                    24999.99
                )
            ) ,
            array(
                'price_points' => '25000+',
                'range' => array(
                    25000
                )
            )
        );
        foreach($pricePoints as $key => $pricePoint) {
            $new_conditions = array();
            $new_conditions['Project.collected_amount >='] = $pricePoint['range'][0];
            $new_conditions['Project.is_successful'] = 1;
            if (isset($pricePoint['range'][1])) {
                $new_conditions['Project.collected_amount <='] = $pricePoint['range'][1];
            }
            $sum_total_revenue_project = $this->Pledge->Project->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(Project.collected_amount) as collected_amount',
                ) ,
                'recursive' => -1
            ));
            if (!empty($sum_total_revenue_project)) {
                $pricePoints[$key]['collected_amount'] = is_null($sum_total_revenue_project[0][0]['collected_amount']) ? 0 : $sum_total_revenue_project[0][0]['collected_amount'];
            } else {
                $pricePoints[$key]['collected_amount'] = 0;
            }
        }
        $this->set('pricePoints', $pricePoints);
        //unsuccessful
        $percentage_range = array(
            array(
                'percentage_range' => '0',
                'range' => array(
                    0,
                    0
                )
            ) ,
            array(
                'percentage_range' => '1-20',
                'range' => array(
                    1,
                    20
                )
            ) ,
            array(
                'percentage_range' => '21-40',
                'range' => array(
                    21,
                    40
                )
            ) ,
            array(
                'percentage_range' => '41-60',
                'range' => array(
                    41,
                    60
                )
            ) ,
            array(
                'percentage_range' => '61-80',
                'range' => array(
                    61,
                    80
                )
            ) ,
            array(
                'percentage_range' => '81-100',
                'range' => array(
                    81,
                    100
                )
            )
        );
        foreach($percentage_range as $key => $precent) {
            $new_conditions = array();
            $new_conditions['Pledge.pledge_project_status_id'] = array(
                ConstPledgeProjectStatus::FundingExpired,
                ConstPledgeProjectStatus::ProjectCanceled
            );
            $new_conditions['Project.is_successful'] = 0;
            if ($key != 0) {
                $new_conditions['Project.collected_percentage >='] = $precent['range'][0];
                if (isset($pricePoint['range'][1])) {
                    $new_conditions['Project.collected_percentage <='] = $precent['range'][1];
                }
            } else {
                $new_conditions['Project.collected_percentage'] = $precent['range'][0];
            }
            $sum_total_revenue_project = $this->Pledge->Project->find('count', array(
                'conditions' => $new_conditions,
            ));
            if (!empty($sum_total_revenue_project)) {
                $percentage_range[$key]['project'] = $sum_total_revenue_project;
            } else {
                $percentage_range[$key]['project'] = 0;
            }
        }
        $this->set('percentage_range', $percentage_range);
    }
}
?>