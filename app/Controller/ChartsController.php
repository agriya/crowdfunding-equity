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
class ChartsController extends AppController
{
    public $name = 'Charts';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public $lastDaysPrev;
    public $lastWeeksPrev;
    public $lastMonthsPrev;
    public $lastYearsPrev;
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
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("now")) ,
                '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("now"))
            )
        );
        $days = 13;
        for ($i = $days; $i >= 7; $i--) {
            $this->lastDaysPrev[] = array(
                'display' => date('M d, Y', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
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
        $weeks = 7;
        for ($i = $weeks; $i > 3; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeksPrev[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end)
                )
            );
        }
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
        $months = 5;
        for ($i = $months; $i > 2; $i--) {
            $this->lastMonthsPrev[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-' . date('t', strtotime("-$i months")) , strtotime("-$i months"))
                )
            );
        }
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
        $years = 5;
        for ($i = $years; $i > 2; $i--) {
            $this->lastYearsPrev[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-' . date('t', strtotime("-$i years")) , strtotime("-$i years")) ,
                )
            );
        }
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    public function admin_chart_stats() 
    {
    }
    public function admin_chart_metrics() 
    {
        $this->pageTitle = __l('Metrics');
    }
    public function admin_user_engagement() 
    {
		$total_users = $this->User->find('count', array(
            'recursive' => -1
        ));
        $idle_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_idle' => 1
            ) ,
            'recursive' => -1
        ));
        $funded_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_funded' => 1
            ) ,
            'recursive' => -1
        ));
        $posted_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_project_posted' => 1
            ) ,
            'recursive' => -1
        ));
        $engaged_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_engaged' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('total_users', $total_users);
        $this->set('idle_users', $idle_users);
        $this->set('funded_users', $funded_users);
        $this->set('posted_users', $posted_users);
        $this->set('engaged_users', $engaged_users);
    }
    public function admin_user_activities() 
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
        $_total_user_reg = $_total_user_login = $_total_user_follow = $_total_projects = $_total_project_fund = $_total_project_comment = $_total_project_update = $_total_project_update_comments = $_total_project_ratings = $_total_project_follower = $_total_project_flag = $_transaction_data = $_total_transaction_data = 0;
        $_total_user_reg_prev = $_total_user_login_prev = $_total_user_follow_prev = $_total_projects_prev = $_total_project_fund_prev = $_total_project_comment_prev = $_total_project_update_prev = $_total_project_update_comments_prev = $_total_project_ratings_prev = $_total_project_follower_prev = $_total_project_flag_prev = $_transaction_data_prev = $_total_transaction_data_prev = $_total_rev_transaction_data = $_total_rev_transaction_data_prev = $total_revenue = $rev_per = 0;
        $prev_select_var = $select_var . 'Prev';
        // User Registeration
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $model_datas['user_reg'] = array(
            'display' => __l('User Regsiteration') ,
            'conditions' => array()
        );
        $_user_reg_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $_user_reg_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'User', 'User', $common_conditions);
        $sparklin_data = array();
        foreach($_user_reg_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_reg+= $chart_data['0'];
        endforeach;
        $_user_reg_data = implode(',', $sparklin_data);
        foreach($_user_reg_data_prev as $display_name => $chart_data):
            $_total_user_reg_prev+= $chart_data['0'];
        endforeach;
        // User Login
        $model_datas['user_login'] = array(
            'display' => __l('User Login') ,
            'conditions' => array()
        );
        $_user_log_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin');
        $_user_log_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserLogin', 'UserLogin');
        $sparklin_data = array();
        foreach($_user_log_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_login+= $chart_data['0'];
        endforeach;
        $_user_log_data = implode(',', $sparklin_data);
        foreach($_user_log_data_prev as $display_name => $chart_data):
            $_total_user_login_prev+= $chart_data['0'];
        endforeach;
        // User Follow
        if (isPluginEnabled('SocialMarketing')) {
            $model_datas['user-follow'] = array(
                'display' => __l('User Followers') ,
                'conditions' => array()
            );
            $_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFollower', 'UserFollower');
            $_user_follow_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserFollower', 'UserFollower');
            $sparklin_data = array();
            foreach($_user_follow_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_user_follow+= $chart_data['0'];
            endforeach;
            $_user_follow_data = implode(',', $sparklin_data);
            foreach($_user_follow_data_prev as $display_name => $chart_data):
                $_total_user_follow_prev+= $chart_data['0'];
            endforeach;
            $this->set('user_follow_data', $_user_follow_data);
            $this->set('total_user_follow', $_total_user_follow);
            if (!empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = round((($_total_user_follow-$_total_user_follow_prev) *100) /$_total_user_follow_prev);
            } else if (empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = 100;
            } else {
                $user_follow_data_per = 0;
            }
            $this->set('user_follow_data_per', $user_follow_data_per);
        }
        // Projects
        if (isPluginEnabled('Projects')) {
            $model_datas['projects'] = array(
                'display' => __l('Projects') ,
                'conditions' => array()
            );
            $_projects_data = $this->_setLineData($select_var, $model_datas, 'Project', 'Project');
            $_projects_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Project', 'Project');
            $sparklin_data = array();
            foreach($_projects_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_projects+= $chart_data['0'];
            endforeach;
            $_projects_data = implode(',', $sparklin_data);
            foreach($_projects_data_prev as $display_name => $chart_data):
                $_total_projects_prev+= $chart_data['0'];
            endforeach;
            $this->set('projects_data', $_projects_data);
            $this->set('total_projects', $_total_projects);
            if (!empty($_total_projects_prev) && !empty($_total_projects)) {
                $projects_data_per = round((($_total_projects-$_total_projects_prev) *100) /$_total_projects_prev);
            } else if (empty($_total_projects_prev) && !empty($_total_projects)) {
                $projects_data_per = 100;
            } else {
                $projects_data_per = 0;
            }
            $this->set('projects_data_per', $projects_data_per);
        }
        // Project Funded
        if (isPluginEnabled('Projects')) {
            $model_datas['project_fund'] = array(
                'display' => __l('Project Funded') ,
                'conditions' => array()
            );
            $_project_fund_data = $this->_setLineData($select_var, $model_datas, 'ProjectFund', 'ProjectFund');
            $_project_fund_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'ProjectFund', 'ProjectFund');
            $sparklin_data = array();
            foreach($_project_fund_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_fund+= $chart_data['0'];
            endforeach;
            $_project_fund_data = implode(',', $sparklin_data);
            foreach($_project_fund_data_prev as $display_name => $chart_data):
                $_total_project_fund_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_fund_data', $_project_fund_data);
            $this->set('total_project_fund', $_total_project_fund);
            if (!empty($_total_project_fund_prev) && !empty($_total_project_fund)) {
                $project_fund_data_per = round((($_total_project_fund-$_total_project_fund_prev) *100) /$_total_project_fund_prev);
            } else if (empty($_total_project_fund_prev) && !empty($_total_project_fund)) {
                $project_fund_data_per = 100;
            } else {
                $project_fund_data_per = 0;
            }
            $this->set('project_fund_data_per', $project_fund_data_per);
        }
        // Project Comments
        if (isPluginEnabled('Projects')) {
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
            $_project_comments_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Message', 'Message', $conditions);
            $sparklin_data = array();
            foreach($_project_comments_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_comment+= $chart_data['0'];
            endforeach;
            $_project_comments_data = implode(',', $sparklin_data);
            foreach($_project_comments_data_prev as $display_name => $chart_data):
                $_total_project_comment_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_comments_data', $_project_comments_data);
            $this->set('total_project_comment', $_total_project_comment);
            if (!empty($_total_project_comment_prev) && !empty($_total_project_comment)) {
                $project_comments_data_per = round((($_total_project_comment-$_total_project_comment_prev) *100) /$_total_project_comment_prev);
            } else if (empty($_total_project_comment_prev) && !empty($_total_project_comment)) {
                $project_comments_data_per = 100;
            } else {
                $project_comments_data_per = 0;
            }
            $this->set('project_comments_data_per', $project_comments_data_per);
        }
        // Project Updates
        if (isPluginEnabled('ProjectUpdates')) {
            $this->loadModel('ProjectUpdates.Blog');
            $model_datas['project_updates'] = array(
                'display' => __l('Project Updates') ,
                'conditions' => array()
            );
            $_project_updates_data = $this->_setLineData($select_var, $model_datas, 'Blog', 'Blog');
            $_project_updates_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Blog', 'Blog');
            $sparklin_data = array();
            foreach($_project_updates_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_update+= $chart_data['0'];
            endforeach;
            $_project_updates_data = implode(',', $sparklin_data);
            foreach($_project_updates_data_prev as $display_name => $chart_data):
                $_total_project_update_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_updates_data', $_project_updates_data);
            $this->set('total_project_update', $_total_project_update);
            if (!empty($_total_project_update_prev) && !empty($_total_project_update)) {
                $project_updates_data_per = round((($_total_project_update-$_total_project_update_prev) *100) /$_total_project_update_prev);
            } else if (empty($_total_project_update_prev) && !empty($_total_project_update)) {
                $project_updates_data_per = 100;
            } else {
                $project_updates_data_per = 0;
            }
            $this->set('project_updates_data_per', $project_updates_data_per);
        }
        // Project Update comments
        if (isPluginEnabled('ProjectUpdates')) {
            $this->loadModel('ProjectUpdates.BlogComment');
            $model_datas['project_updates_comments'] = array(
                'display' => __l('Project Update Comments') ,
                'conditions' => array()
            );
            $_project_update_comments_data = $this->_setLineData($select_var, $model_datas, 'BlogComment', 'BlogComment');
            $_project_update_comments_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'BlogComment', 'BlogComment');
            $sparklin_data = array();
            foreach($_project_update_comments_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_update_comments+= $chart_data['0'];
            endforeach;
            $_project_update_comments_data = implode(',', $sparklin_data);
            foreach($_project_update_comments_data_prev as $display_name => $chart_data):
                $_total_project_update_comments_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_update_comments_data', $_project_update_comments_data);
            $this->set('total_project_update_comments', $_total_project_update_comments);
            if (!empty($_total_project_update_comments_prev) && !empty($_total_project_update_comments)) {
                $project_update_comments_data_per = round((($_total_project_update_comments-$_total_project_update_comments_prev) *100) /$_total_project_update_comments_prev);
            } else if (empty($_total_project_update_comments_prev) && !empty($_total_project_update_comments)) {
                $project_update_comments_data_per = 100;
            } else {
                $project_update_comments_data_per = 0;
            }
            $this->set('project_update_comments_data_per', $project_update_comments_data_per);
        }
        // Project Rating
        if (isPluginEnabled('Idea')) {
            $model_datas['project_rating'] = array(
                'display' => __l('Project Ratings') ,
                'conditions' => array()
            );
            $_project_rating_data = $this->_setLineData($select_var, $model_datas, 'ProjectRating', 'ProjectRating');
            $_project_rating_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'ProjectRating', 'ProjectRating');
            $sparklin_data = array();
            foreach($_project_rating_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_ratings+= $chart_data['0'];
            endforeach;
            $_project_rating_data = implode(',', $sparklin_data);
            foreach($_project_rating_data_prev as $display_name => $chart_data):
                $_total_project_ratings_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_rating_data', $_project_rating_data);
            $this->set('total_project_ratings', $_total_project_ratings);
            if (!empty($_total_project_ratings_prev) && !empty($_total_project_ratings)) {
                $project_rating_data_per = round((($_total_project_ratings-$_total_project_ratings_prev) *100) /$_total_project_ratings_prev);
            } else if (empty($_total_project_ratings_prev) && !empty($_total_project_ratings)) {
                $project_rating_data_per = 100;
            } else {
                $project_rating_data_per = 0;
            }
            $this->set('project_rating_data_per', $project_rating_data_per);
        }
        // Project Followers
        if (isPluginEnabled('ProjectFollowers')) {
            $model_datas['project_follow'] = array(
                'display' => __l('Project Followers') ,
                'conditions' => array()
            );
            $_project_follower_data = $this->_setLineData($select_var, $model_datas, 'ProjectFollower', 'ProjectFollower');
            $_project_follower_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'ProjectFollower', 'ProjectFollower');
            $sparklin_data = array();
            foreach($_project_follower_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_follower+= $chart_data['0'];
            endforeach;
            $_project_follower_data = implode(',', $sparklin_data);
            foreach($_project_follower_data_prev as $display_name => $chart_data):
                $_total_project_follower_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_follower_data', $_project_follower_data);
            $this->set('total_project_follower', $_total_project_follower);
            if (!empty($_total_project_follower_prev) && !empty($_total_project_follower)) {
                $project_follower_data_per = round((($_total_project_follower-$_total_project_follower_prev) *100) /$_total_project_follower_prev);
            } else if (empty($_total_project_follower_prev) && !empty($_total_project_follower)) {
                $project_follower_data_per = 100;
            } else {
                $project_follower_data_per = 0;
            }
            $this->set('project_follower_data_per', $project_follower_data_per);
        }
        // Project Flags
        if (isPluginEnabled('ProjectFlags')) {
            $model_datas['project_flag'] = array(
                'display' => __l('Project Flags') ,
                'conditions' => array()
            );
            $_project_flag_data = $this->_setLineData($select_var, $model_datas, 'ProjectFlag', 'ProjectFlag');
            $_project_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'ProjectFlag', 'ProjectFlag');
            $sparklin_data = array();
            foreach($_project_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_project_flag+= $chart_data['0'];
            endforeach;
            $_project_flag_data = implode(',', $sparklin_data);
            foreach($_project_flag_data_prev as $display_name => $chart_data):
                $_total_project_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('project_flag_data', $_project_flag_data);
            $this->set('total_project_flag', $_total_project_flag);
            if (!empty($_total_project_flag_prev) && !empty($_total_project_flag)) {
                $project_flag_data_per = round((($_total_project_flag-$_total_project_flag_prev) *100) /$_total_project_flag_prev);
            } else if (empty($_total_project_flag_prev) && !empty($_total_project_flag)) {
                $project_flag_data_per = 100;
            } else {
                $project_flag_data_per = 0;
            }
            $this->set('project_flag_data_per', $project_flag_data_per);
        }
        // Revenue
        $sparklin_data = array();
        $conditions = array();
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::ListingFee;
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::SignupFee;
        $model_datas['transaction'] = array(
            'display' => __l('Transaction') ,
            'conditions' => array()
        );
        $_transaction_data = $this->_setLineData($select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $return_field = 'amount';
        $common_conditions = array();
        $model_datas['ProjectFund'] = array(
            'display' => __l('ProjectFund') ,
            'conditions' => array()
        );
        $_rev_transaction_data = $this->_setLineData($select_var, $model_datas, 'ProjectFund', 'ProjectFund', $common_conditions, $return_field);
        $_rev_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'ProjectFund', 'ProjectFund', $common_conditions, $return_field);
        foreach($_rev_transaction_data as $display_name => $chart_data):
            $sparklin_data[$display_name] = $chart_data['0']['0']['total_amount']+$_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_transaction_data+= $_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_rev_transaction_data+= $chart_data['0']['0']['total_amount'];
        endforeach;
        foreach($_transaction_data_prev as $display_name => $chart_data):
            $_total_transaction_data_prev+= $chart_data['0']['0']['total_amount'];
            $_total_rev_transaction_data_prev+= $_rev_transaction_data_prev[$display_name]['0']['0']['total_amount'];
        endforeach;
        $revenue = implode(',', $sparklin_data);
        $total_revenue = $_total_transaction_data+$_total_rev_transaction_data;
        $total_revenue_prev = $_total_transaction_data_prev+$_total_rev_transaction_data_prev;
        $this->set('user_reg_data', $_user_reg_data);
        $this->set('total_user_reg', $_total_user_reg);
        if (!empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = round((($_total_user_reg-$_total_user_reg_prev) *100) /$_total_user_reg_prev);
        } else if (empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = 100;
        } else {
            $user_reg_data_per = 0;
        }
        $this->set('user_reg_data_per', $user_reg_data_per);
        $this->set('user_log_data', $_user_log_data);
        $this->set('total_user_login', $_total_user_login);
        if (!empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = round((($_total_user_login-$_total_user_login_prev) *100) /$_total_user_login_prev);
        } else if (empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = 100;
        } else {
            $user_log_data_per = 0;
        }
        $this->set('user_log_data_per', $user_log_data_per);
        $this->set('revenue', $revenue);
        $this->set('total_revenue', $total_revenue);
        if (!empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = round((($total_revenue-$total_revenue_prev) *100) /$total_revenue_prev);
        } else if (empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = 100;
        } else {
            $rev_per = 0;
        }
        $this->set('rev_per', $rev_per);
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
                if ($modelClass == 'Transaction') {
                    $_data[$val['display']] = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => 0
                    ));
                } else if (($modelClass == 'ProjectFund') && (!empty($return_field))) {
                    $_data[$val['display']] = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(ProjectFund.site_fee) as total_amount'
                        ) ,
                        'recursive' => 0
                    ));
                } else {
                    $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
            }
        }
        return $_data;
    }
}
?>