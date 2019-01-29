<?php
require_once APP . 'Controller' . DS . 'ChartsController.php';
class EquityChartsController extends ChartsController
{
    public $name = 'EquityCharts';
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
                '#MODEL#.created =' => date('Y-m-d', strtotime('now')) ,
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
                    '#MODEL#.created >=' => _formatDate('Y-m-d', $start) ,
                    '#MODEL#.created <=' => _formatDate('Y-m-d', $end) ,
                )
            );
        }
        $start_last = $timestamp_end+24*3600;
        $this->lastWeeks[] = array(
            'display' => date('M d', $start_last) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => _formatDate('Y-m-d', $start_last) ,
                '#MODEL#.created <=' => date('Y-m-d')
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$i months", strtotime(date("F") . "1")));
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
    public function admin_chart_projects() 
    {
        $this->setAction('chart_projects');
    }
    public function chart_projects() 
    {
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('Equity.Equity');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //# projects stats
        $conditions = array();
        $not_conditions = array();
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $city_filter_id = $this->Session->read('city_filter_id');
            if (!empty($city_filter_id)) {
                $project_cities = $this->Equity->User->UserProfile->City->find('first', array(
                    'conditions' => array(
                        'City.id' => $city_filter_id
                    ) ,
                    'fields' => array(
                        'City.name'
                    ) ,
                    'contain' => array(
                        'Project' => array(
                            'fields' => array(
                                'Project.id'
                            ) ,
                        )
                    ) ,
                    'recursive' => 1
                ));
                foreach($project_cities['Equity'] as $project_city) {
                    $city_project_id[] = $project_city['id'];
                }
                $conditions['Equity.id'] = $city_project_id;
            }
        }
        $project_model_datas['Pending'] = array(
            'display' => __l('Pending') ,
            'conditions' => array_merge(array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::Pending
            ) , $conditions) ,
        );
        $project_model_datas['OpenForFunding'] = array(
            'display' => __l('Open for Investing') ,
            'conditions' => array_merge(array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForInvesting
            ) , $conditions) ,
        );
		if (isPluginEnabled('Idea')) {
			$project_model_datas['OpenForIdea'] = array(
				'display' => __l('Open for Idea') ,
				'conditions' => array_merge(array(
					'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForIdea
				) , $conditions) ,
			);
		}
        $project_model_datas['FundingClosed'] = array(
            'display' => __l('Project Closed') ,
            'conditions' => array_merge(array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectClosed
            ) , $conditions) ,
        );
        $project_model_datas['FundingExpired'] = array(
            'display' => __l('Project Expired') ,
            'conditions' => array_merge(array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectExpired
            ) , $conditions) ,
        );
        $project_model_datas['ProjectCancelled'] = array(
            'display' => sprintf(__l('%s Cancelled') , Configure::read('project.alt_name_for_project_singular_caps')) ,
            'conditions' => array_merge(array(
                'Equity.equity_project_status_id' => ConstEquityProjectStatus::ProjectCanceled
            ) , $conditions) ,
        );
        $project_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array(
                $conditions,
                $not_conditions
            )
        );
        if ($this->Auth->user('role_id') == ConstUserTypes::User) {
            $common_conditions['Project.user_id'] = $this->Auth->user('id');
        }
        $common_conditions = array();
        $chart_projects_data = $this->_setLineData($select_var, $project_model_datas, 'Equity.Equity', 'Equity', $common_conditions);
        $project_fund_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array(
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity
            )
        );
        $project_fund_model_datas['Invested'] = array(
            'display' => __l('Invested') ,
            'conditions' => array(
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity,
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized
            )
        );
        $project_fund_model_datas['Refunded'] = array(
            'display' => __l('Refunded') ,
            'conditions' => array(
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity,
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Expired,
                    ConstProjectFundStatus::Canceled,
                )
            )
        );
        $project_fund_model_datas['Paid'] = array(
            'display' => __l('Paid') ,
            'conditions' => array(
                'ProjectFund.project_type_id' => ConstProjectTypes::Equity,
                'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::PaidToOwner
            )
        );
        $chart_project_funds_data = $this->_setLineData($select_var, $project_fund_model_datas, 'Projects.ProjectFund', 'ProjectFund', $common_conditions);
        $this->set('chart_projects_data', $chart_projects_data);
        $this->set('chart_projects_periods', $project_model_datas);
        $this->set('chart_project_funds_data', $chart_project_funds_data);
        $this->set('chart_project_funds_periods', $project_fund_model_datas);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array() , $return_field = '') 
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
}
?>