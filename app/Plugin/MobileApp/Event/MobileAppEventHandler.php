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
class MobileAppEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Controller.Project.handleApp' => array(
                'callable' => '_handleApp',
            ) ,
            'Controller.Project.listing' => array(
                'callable' => 'onProjecListing',
            ) ,
            'Controller.Donate.myprojects' => array(
                'callable' => 'onMyProjectListing',
            ) ,
            'Controller.Pledge.myprojects' => array(
                'callable' => 'onMyProjectListing',
            ) ,
            'Controller.Lend.myprojects' => array(
                'callable' => 'onMyProjectListing',
            ) ,
            'Controller.Equity.myprojects' => array(
                'callable' => 'onMyProjectListing',
            ) ,
            'Controller.Project.view' => array(
                'callable' => 'onProjectView',
            ) ,
            'Controller.ProjectFollowers.follow' => array(
                'callable' => 'onProjectFollow',
            ) ,
            'Controller.ProjectFollowers.unfollow' => array(
                'callable' => 'onProjectUnfollow',
            ) ,
            'Controller.Project.follow_listing' => array(
                'callable' => 'onfollowerListing',
            ) ,
            'Controller.Blog.listing' => array(
                'callable' => 'onBlogListing',
            ) ,
            'Controller.BlogComment.listing' => array(
                'callable' => 'onBlogCommentListing',
            ) ,
            'Controller.User.validate_user' => array(
                'callable' => 'validate_user',
            ) ,
            'Controller.ProjectFund.listing' => array(
                'callable' => 'onProjectFundsListing'
            ) ,
            'Controller.ProjectFund.RewardsList' => array(
                'callable' => 'onProjectFundRewardsList'
            ) ,
            'Controller.ProjectRating.listing' => array(
                'callable' => 'onProjectRatingListing'
            ) ,
            'Controller.ProjectComment.listing' => array(
                'callable' => 'onProjectCommentListing',
            ) ,
            'Controller.User.ForgetPassword' => array(
                'callable' => 'onUserForgetPassword',
            ),
            'Controller.User.socialLogin' => array(
                'callable' => 'onSocialLogin',
            ),
            'Controller.SecurityQuestion.Index' => array(
                'callable' => 'onSecurityQuestionIndex',
            ),
            'Controller.User.Register' => array(
                'callable' => 'onUserRegister',
            ),
            'Controller.ProjectRating.add' => array(
                'callable' => 'onProjectRatingAdd',
            ),
            'Controller.Payment.get_sudopay_gateways' => array(
               'callable' => 'onSudopayGateways',
            ),
            'Controller.Wallet.Add' => array(
               'callable' => 'onWalletAdd',
            ),
            'Controller.ProjectFund.Add' => array(
               'callable' => 'onProjectFundAdd',
            ),
            'Controller.Language.Index' => array(
                'callable' => 'onLanguageIndex',
	    ),
            'Controller.UserProfile.masterList' => array(
                'callable' => 'onMasterList',
            ),
            'Controller.UserProfile.Edit' => array(
                'callable' => 'onUserProfileEdit',
            ),
            'Controller.Message.Index' => array(
                'callable' => 'onMessageIndex',
            ),
            'Controller.Project.Add' => array(
            	'callable' => 'onProjectAdd',
            ),
            'Controller.ProjectPayNow.Add' => array(
                'callable' => 'onProjectPayNowAdd',
            ),
            'Controller.SeisEntry.Add' => array(
                'callable' => 'onEquityProjectSeisEntryAdd',
            ),
            'Controller.Lend.CheckRate' => array(
                'callable' => 'onCheckLendRate',
            ) ,
            'Controller.Payments.MembershipPayNow' => array(
                'callable' => 'onPaymentsMembershipPayNow',
             ),
        );
    }
    public function _handleApp($event) 
    {
        $controller = $event->subject();
        App::uses('User', 'Model');
        $this->User = new User();
        if ((!empty($_POST['data']) || (!empty($_GET['data']))) && in_array($controller->request->params['action'], array('validate_user'))) {
            if (!empty($_GET['data'])) {
                $_POST['data'] = $_GET['data'];
            }
            if (!empty($_POST['data'])) {
                foreach($_POST['data'] as $controller => $values) {
                    $controller->request->data[Inflector::camelize(Inflector::singularize($controller)) ] = $values;
                }
            }
        }
        if (!empty($_GET['username']) && $controller->request->params['action'] != 'validate_user') {
            $controller->request->data['User'][Configure::read('user.using_to_login') ] = trim($_GET['username']);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.mobile_app_hash' => $_GET['passwd']
                ) ,
                'fields' => array(
                    'User.password'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                $controller->set('iphone_response', array(
                    'status' => 1,
                    'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
                ));
            } else {
                $controller->request->data['User']['password'] = $user['User']['password'];
                if (!$controller->Auth->login()) {
                    $controller->set('iphone_response', array(
                        'status' => 1,
                        'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
                    ));
                } 
               
                if ($controller->Auth->user('id') && !empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
                    $this->update_iphone_user($_GET['latitude'], $_GET['longtitude'], $controller->Auth->user('id'));
                }
            }
        }
    }
    
    public function onUserRegister($event)
    {
            $obj = $event->subject();
            $obj->view = 'Json';
            $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? array() : $obj->viewVars['iphone_response']);
    }
        
    function update_iphone_user($latitude, $longitude, $user_id) 
    {
        App::uses('User', 'Model');
        $this->User = new User();
        $this->User->updateAll(array(
            'User.iphone_latitude' => $latitude,
            'User.iphone_longitude' => $longitude,
            'User.iphone_last_access' => "'" . date("Y-m-d H:i:s") . "'"
        ) , array(
            'User.id' => $user_id
        ));
    }
    public function onProjecListing($event) 
    {
        $obj = $event->subject();
        $conditions = $event->data['data']['conditions'];
        $order = $event->data['data']['order'];
        $limit = $event->data['data']['limit'];
        $type = '';
        $fund_tab_name = '';
        $contain = array(
            'Attachment',
            'User' => array(
                'fields' => array(
                    'User.username',
                    'User.id'
                ),
                'UserAvatar'
            ) ,
        );
        if (!empty($event->data['data']['contain'])) {
            $contain = array_merge($contain, $event->data['data']['contain']);
        }
        $obj->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'fields' => array(
                'Project.id',
                'Project.name',
                'Project.project_end_date',
                'Project.collected_amount',
                'Project.collected_percentage',
                'Project.slug',
                'Project.needed_amount',
                'Project.project_type_id',
                'Project.user_id',
                'Project.address',
                'Project.description',
            ) ,
            'order' => $order,
            'recursive' => 2,
            'limit' => $limit,
        );
        $iphone_project_index = $obj->paginate();
        $total_projects = $obj->Project->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        if(!empty($obj->request->params['named']['project_type'])) {
            if($obj->request->params['named']['project_type'] == 'pledge') {
                $type = 'pledge';
                $fund_tab_name = 'Backers';
            } else if($obj->request->params['named']['project_type'] == 'donate') {
                $type = 'donate';
                $fund_tab_name = 'Donors';
            } else if($obj->request->params['named']['project_type'] == 'lend') {
                $type = 'lend';
                $fund_tab_name = 'Lenders';
            } else if($obj->request->params['named']['project_type'] == 'equity') {
                $type = 'equity';
                $fund_tab_name = 'Investors';
            }
        }
        for ($end = 0; $end < count($iphone_project_index); $end++) {
            $image_options = array(
                'dimension' => 'very_big_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $user_avatar_image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $user_avatar_image_url = getImageUrl('UserAvatar', $iphone_project_index[$end]['User']['UserAvatar'], $user_avatar_image_options);
            $image_url = getImageUrl('Project', $iphone_project_index[$end]['Attachment'], $image_options);
            $big_image_options = array(
                'dimension' => 'very_big_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $big_thumb_image_url = getImageUrl('Project', $iphone_project_index[$end]['Attachment'], $big_image_options);
            $this->saveiPhoneAppThumb($iphone_project_index[$end]['Attachment']);
            
            if (strtotime($iphone_project_index[$end]['Project']['project_end_date']) < strtotime(date('Y-m-d'))) {
                $date = date('d', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $month = date('F', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $year = date('y', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $days_to_go = $month . " " . $year;
                $text = __l('Funded');
            } elseif (strtotime($iphone_project_index[$end]['Project']['project_end_date']) == strtotime(date('Y-m-d'))) {
                $days_to_go = floor((strtotime(date('Y-m-d h:i:s')) -strtotime($iphone_project_index[$end]['Project']['project_end_date'])) /3600);
                $text = __l('Hours to go');
            } else {
                $days_to_go = (strtotime($iphone_project_index[$end]['Project']['project_end_date']) -strtotime(date('Y-m-d'))) /(60*60*24);
                $text = __l('Days to go');
            }
            $project_descrption = sprintf(__l('A %s in by %s') , Configure::read('project.alt_name_for_project_singular_caps') , $iphone_project_index[$end]['User']['username']);
            $backer = $obj->Project->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.project_id' => $iphone_project_index[$end]['Project']['id'],
                ) ,
                'recursive' => -1
            ));
            $project_updates = $iphone_project_index[$end]['Blog'];
            $updates = array();
            $update_comments = array();
            for ($n = 0; $n < count($project_updates); $n++) {
                $date = date('d', strtotime($project_updates[$n]['created']));
                $month = date('F', strtotime($project_updates[$n]['created']));
                $update_created = $month . " " . $date;
                $updates[$n]['Update_title'] = $project_updates[$n]['title'];
                $updates[$n]['Update_slug'] = $project_updates[$n]['slug'];
                $updates[$n]['Update_description'] = $project_updates[$n]['content'];
                $updates[$n]['Update_created'] = $update_created;
                $updates[$n]['Update_username'] = $project_updates[$n]['User']['username'];
                $updates[$n]['Update_user_image'] = getImageUrl('UserAvatar', $project_updates[$n]['User']['UserAvatar'], $image_options);
                $project_update_comments = $project_updates[$n]['BlogComment'];
                for ($j = 0; $j < count($project_update_comments); $j++) {
                    $date = date('d', strtotime($project_update_comments[$j]['created']));
                    $month = date('F', strtotime($project_update_comments[$j]['created']));
                    $update_comment_created = $month . " " . $date;
                    $update_comments[$j]['BlogComment_comment'] = $project_update_comments[$j]['comment'];
                    $update_comments[$j]['BlogComment_created'] = $update_comment_created;
                    $update_comments[$j]['BlogComment_username'] = $project_update_comments[$j]['User']['username'];
                    $update_comments[$j]['Blogcomment_user_image'] = getImageUrl('UserAvatar', $project_update_comments[$j]['User']['UserAvatar'], $image_options);
                }
                $updates[$n]['UpdateComments'] = $update_comments;
            }
            $ProjectTypeStatus = Cms::dispatchEvent('Controller.ProjectType.getProjectTypeStatus', $obj, array(
                'project' => $iphone_project_index[$end]
            ));
            $iphone_project_indexs[$end]['Project_id'] = $iphone_project_index[$end]['Project']['id'];
            $iphone_project_indexs[$end]['Project_name'] = $iphone_project_index[$end]['Project']['name'];
            $iphone_project_indexs[$end]['Project_slug'] = $iphone_project_index[$end]['Project']['slug'];
            $iphone_project_indexs[$end]['Project_user_id'] = $iphone_project_index[$end]['Project']['user_id'];
            $iphone_project_indexs[$end]['Project_address'] = $iphone_project_index[$end]['Project']['address'];
            if (!empty($iphone_project_index[$end]['Project']['needed_amount'])) {
                $iphone_project_indexs[$end]['Funding_amount'] = $iphone_project_index[$end]['Project']['needed_amount'];
            }
            $iphone_project_indexs[$end]['Funded'] = ($iphone_project_index[$end]['Project']['collected_percentage'] != "") ? $iphone_project_index[$end]['Project']['collected_percentage'] : 0.00;
            $iphone_project_indexs[$end]['Progress_bar_percentage'] = ($iphone_project_index[$end]['Project']['collected_percentage'] != "") ? $iphone_project_index[$end]['Project']['collected_percentage'] : 0.00;
            $iphone_project_indexs[$end]['Project_image_url'] = $image_url;
            $iphone_project_indexs[$end]['Days_to_go'] = $days_to_go;
            $iphone_project_indexs[$end]['Days_to_go_text'] = $text;
            $iphone_project_indexs[$end]['Project_description'] = str_replace('&nbsp;', ' ', (strip_tags($iphone_project_index[$end]['Project']['description'])));
            $iphone_project_indexs[$end]['Backers'] = $backer;
            $iphone_project_indexs[$end]['Backers_text'] = Configure::read('project.alt_name_for_backer_plural_caps');;
            $iphone_project_indexs[$end]['Project_big_thumb_image_url'] = $big_thumb_image_url;
            $iphone_project_indexs[$end]['Project_username'] = $iphone_project_index[$end]['User']['username'];
            $iphone_project_indexs[$end]['Property_user_avatar'] = $user_avatar_image_url;
            $iphone_project_indexs[$end]['Property_type'] = $type;
            $iphone_project_indexs[$end]['Property_fund_tab_name'] = $fund_tab_name;
            $iphone_project_indexs[$end] = array_merge($iphone_project_indexs[$end], $ProjectTypeStatus->data['data']);
            $iphone_project_indexs[$end]['Currency_symbol'] = Configure::read('site.currency');
            $follower = Cms::dispatchEvent('Controller.ProjectFollower.followerStatus', $obj, array(
                'data' => array(
                    'follow_text' => __l('Follow') ,
                    'follow_url' => ''
                ) ,
                'project_id' => $iphone_project_index[$end]['Project']['id']
            ));
            $iphone_project_indexs[$end] = array_merge($iphone_project_indexs[$end], $follower->data['data']);
            $percentage = 0;
            if ($iphone_project_index[$end]['Project']['collected_amount'] > 0) {
                $percentage = floatval($iphone_project_index[$end]['Project']['needed_amount']) /floatval($iphone_project_index[$end]['Project']['collected_amount']);
            }
            if ($percentage != 0) {
                $current_percentage = number_format($iphone_project_index[$end]['Project']['collected_percentage'], 2);
                $total_percentage = number_format(100-$current_percentage);
            } else {
                $current_percentage = 0;
                $total_percentage = 100;
            }
            $google_pie_chart_url = "http://chart.googleapis.com/chart?cht=p&amp;chd=t:" . floatval($current_percentage) . "," . floatval($total_percentage) . "&amp;chs=58x58&amp;chco=00AFEF|C1C1BA&amp;chf=bg,s,FF000000";
            $iphone_project_indexs[$end]['Project_pie_chart_url'] = $google_pie_chart_url;
            $iphone_project_indexs[$end]['Updates'] = $updates;
        }
        
        $response = array(
                '_metadata' => array(
                                'total_projects' => $total_projects,
                                'total_page' => ceil($total_projects/20),
                                'current_page' => !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1
                        ),
                'project_list' => $iphone_project_indexs
        );
        $obj->view = 'Json';
	$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    public function onMyProjectListing($event)
    {
        $obj = $event->subject();
        $conditions = $event->data['data']['conditions'];
        $order = $event->data['data']['order'];
        $limit = $event->data['data']['limit'];
        $model = $event->data['data']['model'];
        $contain = array(
            'Attachment',
            'User' => array(
                'fields' => array(
                    'User.username',
                    'User.id'
                ),
                'UserAvatar'
            ) ,
        );
        if (!empty($event->data['data']['contain'])) {
            $contain = array_merge($contain, $event->data['data']['contain']);
        }
        $obj->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'fields' => array(
                'Project.id',
                'Project.name',
                'Project.project_end_date',
                'Project.collected_amount',
                'Project.collected_percentage',
                'Project.slug',
                'Project.needed_amount',
                'Project.project_type_id',
                'Project.user_id',
                'Project.address',
                'Project.description',
            ) ,
            'order' => $order,
            'recursive' => 2,
            'limit' => $limit,
        );
        $iphone_project_index = $obj->paginate();
        $total_projects = $obj->$model->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        if(!empty($obj->request->params['controller'])) {
            if($obj->request->params['controller'] == 'pledges') {
                $fund_tab_name = 'Backers';
            } else if($obj->request->params['controller'] == 'donates') {
                $fund_tab_name = 'Donors';
            } else if($obj->request->params['controller'] == 'lends') {
                $fund_tab_name = 'Lenders';
            } else if($obj->request->params['controller'] == 'equities') {
                $fund_tab_name = 'Investors';
            }
        }
        
        for ($end = 0; $end < count($iphone_project_index); $end++) {
            $image_options = array(
                'dimension' => 'very_big_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $user_avatar_image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $user_avatar_image_url = getImageUrl('UserAvatar', $iphone_project_index[$end]['Project']['User']['UserAvatar'], $user_avatar_image_options);
            $image_url = getImageUrl('Project', $iphone_project_index[$end]['Project']['Attachment'], $image_options);
            $big_image_options = array(
                'dimension' => 'very_big_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $big_thumb_image_url = getImageUrl('Project', $iphone_project_index[$end]['Project']['Attachment'], $big_image_options);
            $this->saveiPhoneAppThumb($iphone_project_index[$end]['Project']['Attachment']);
            if (strtotime($iphone_project_index[$end]['Project']['project_end_date']) < strtotime(date('Y-m-d'))) {
                $date = date('d', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $month = date('F', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $year = date('y', strtotime($iphone_project_index[$end]['Project']['project_end_date']));
                $days_to_go = $month . " " . $year;
                $text = __l('Funded');
            } elseif (strtotime($iphone_project_index[$end]['Project']['project_end_date']) == strtotime(date('Y-m-d'))) {
                $days_to_go = floor((strtotime(date('Y-m-d h:i:s')) -strtotime($iphone_project_index[$end]['Project']['project_end_date'])) /3600);
                $text = __l('Hours to go');
            } else {
                $days_to_go = (strtotime($iphone_project_index[$end]['Project']['project_end_date']) -strtotime(date('Y-m-d'))) /(60*60*24);
                $text = __l('Days to go');
            }
            $project_descrption = sprintf(__l('A %s in by %s') , Configure::read('project.alt_name_for_project_singular_caps') , $iphone_project_index[$end]['Project']['User']['username']);
            $backer = $obj->$model->Project->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.project_id' => $iphone_project_index[$end]['Project']['id'],
                ) ,
                'recursive' => -1
            ));
            $project_updates = $iphone_project_index[$end]['Blog'];
            $updates = array();
            $update_comments = array();
            for ($n = 0; $n < count($project_updates); $n++) {
                $date = date('d', strtotime($project_updates[$n]['created']));
                $month = date('F', strtotime($project_updates[$n]['created']));
                $update_created = $month . " " . $date;
                $updates[$n]['Update_title'] = $project_updates[$n]['title'];
                $updates[$n]['Update_slug'] = $project_updates[$n]['slug'];
                $updates[$n]['Update_description'] = $project_updates[$n]['content'];
                $updates[$n]['Update_created'] = $update_created;
                $updates[$n]['Update_username'] = $project_updates[$n]['User']['username'];
                $updates[$n]['Update_user_image'] = getImageUrl('UserAvatar', $project_updates[$n]['User']['UserAvatar'], $image_options);
                $project_update_comments = $project_updates[$n]['BlogComment'];
                for ($j = 0; $j < count($project_update_comments); $j++) {
                    $date = date('d', strtotime($project_update_comments[$j]['created']));
                    $month = date('F', strtotime($project_update_comments[$j]['created']));
                    $update_comment_created = $month . " " . $date;
                    $update_comments[$j]['BlogComment_comment'] = $project_update_comments[$j]['comment'];
                    $update_comments[$j]['BlogComment_created'] = $update_comment_created;
                    $update_comments[$j]['BlogComment_username'] = $project_update_comments[$j]['User']['username'];
                    $update_comments[$j]['Blogcomment_user_image'] = getImageUrl('UserAvatar', $project_update_comments[$j]['User']['UserAvatar'], $image_options);
                }
                $updates[$n]['UpdateComments'] = $update_comments;
            }
            $ProjectTypeStatus = Cms::dispatchEvent('Controller.ProjectType.getProjectTypeStatus', $obj, array(
                'project' => $iphone_project_index[$end]
            ));
            $iphone_project_indexs[$end]['Project_id'] = $iphone_project_index[$end]['Project']['id'];
            $iphone_project_indexs[$end]['Project_name'] = $iphone_project_index[$end]['Project']['name'];
            $iphone_project_indexs[$end]['Project_slug'] = $iphone_project_index[$end]['Project']['slug'];
            $iphone_project_indexs[$end]['Project_user_id'] = $iphone_project_index[$end]['Project']['user_id'];
            $iphone_project_indexs[$end]['Project_address'] = $iphone_project_index[$end]['Project']['address'];
            if (!empty($iphone_project_index[$end]['Project']['needed_amount'])) {
                $iphone_project_indexs[$end]['Funding_amount'] = $iphone_project_index[$end]['Project']['needed_amount'];
            }
            $iphone_project_indexs[$end]['Funded'] = ($iphone_project_index[$end]['Project']['collected_percentage'] != "") ? $iphone_project_index[$end]['Project']['collected_percentage'] : 0.00;
            $iphone_project_indexs[$end]['Progress_bar_percentage'] = ($iphone_project_index[$end]['Project']['collected_percentage'] != "") ? $iphone_project_index[$end]['Project']['collected_percentage'] : 0.00;
            $iphone_project_indexs[$end]['Project_image_url'] = $image_url;
            $iphone_project_indexs[$end]['Days_to_go'] = $days_to_go;
            $iphone_project_indexs[$end]['Days_to_go_text'] = $text;
            $iphone_project_indexs[$end]['Project_description'] = str_replace('&nbsp;', ' ', (strip_tags($iphone_project_index[$end]['Project']['description'])));
            $iphone_project_indexs[$end]['Backers'] = $backer;
            $iphone_project_indexs[$end]['Backers_text'] = Configure::read('project.alt_name_for_backer_plural_caps');
            $iphone_project_indexs[$end]['Project_big_thumb_image_url'] = $big_thumb_image_url;
            $iphone_project_indexs[$end]['Project_username'] = $iphone_project_index[$end]['Project']['User']['username'];
            $iphone_project_indexs[$end]['Property_user_avatar'] = $user_avatar_image_url;
            $iphone_project_indexs[$end]['Property_fund_tab_name'] = $fund_tab_name;
            $iphone_project_indexs[$end] = array_merge($iphone_project_indexs[$end], $ProjectTypeStatus->data['data']);
            $iphone_project_indexs[$end]['Currency_symbol'] = Configure::read('site.currency');
            $percentage = 0;
            if ($iphone_project_index[$end]['Project']['collected_amount'] > 0) {
                $percentage = floatval($iphone_project_index[$end]['Project']['needed_amount']) /floatval($iphone_project_index[$end]['Project']['collected_amount']);
            }
            if ($percentage != 0) {
                $current_percentage = number_format($iphone_project_index[$end]['Project']['collected_percentage'], 2);
                $total_percentage = number_format(100-$current_percentage);
            } else {
                $current_percentage = 0;
                $total_percentage = 100;
            }
            $google_pie_chart_url = "http://chart.googleapis.com/chart?cht=p&amp;chd=t:" . floatval($current_percentage) . "," . floatval($total_percentage) . "&amp;chs=58x58&amp;chco=00AFEF|C1C1BA&amp;chf=bg,s,FF000000";
            $iphone_project_indexs[$end]['Project_pie_chart_url'] = $google_pie_chart_url;
            $iphone_project_indexs[$end]['Updates'] = $updates;
        }

        $response = array(
                '_metadata' => array(
                                'total_projects' => $total_projects,
                                'total_page' => ceil($total_projects/20),
                                'current_page' => !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1
                        ),
                'project_list' => $iphone_project_indexs
        );
        $obj->view = 'Json';
	$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    public function onProjectView($event) 
    {
        $obj = $event->subject();
        $project = $event->data['data']['project'];
        $backer = $event->data['data']['backer'];
        $image_options = array(
            'dimension' => 'iphone_big_thumb',
            'class' => '',
            'alt' => 'alt',
            'title' => 'title',
            'type' => 'jpg',
            'full_url' => true
        );
        $this->saveiPhoneAppThumb($project['Attachment']);
        $image_url = getImageUrl('Project', $project['Attachment'], $image_options);
        if (strtotime($project['Project']['project_end_date']) < strtotime(date('Y-m-d'))) {
            $month = date('F', strtotime($project['Project']['project_end_date']));
            $year = date('y', strtotime($project['Project']['project_end_date']));
            $days_to_go = $month . " " . $year;
            $text = __l('Funded');
        } else {
            $days_to_go = (strtotime($project['Project']['project_end_date']) -strtotime(date('Y-m-d'))) /(60*60*24);
            $text = __l('Days to go');
        }
        $iphone_project_view['Project_id'] = $project['Project']['id'];
        $iphone_project_view['Project_name'] = $project['Project']['name'];
        $iphone_project_view['Project_username'] = $project['User']['username'];
        $iphone_project_view['Backers'] = $backer;
        $iphone_project_view['Project_image_url'] = $image_url;
        $iphone_project_view['Days_to_go'] = $days_to_go;
        $iphone_project_view['Days to go text'] = $text;
        $iphone_project_view['Funding_amount'] = $project['Project']['collected_amount'];
        $iphone_project_view['Circle_graph_percentage'] = $project['Project']['collected_percentage'];
        $iphone_project_view['Needed_amount'] = $project['Project']['needed_amount'];
        $obj->view = 'Json';
        $obj->set('json', $iphone_project_view);
    }
    public function onProjectFollow($event) 
    {
        $obj = $event->subject();
        $response = $event->data['data'];
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onProjectUnfollow($event) 
    {
        $obj = $event->subject();
        $response = $event->data['data'];
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onfollowerListing($event) 
    {
        $obj = $event->subject();
        $iphone_project_followers = $obj->paginate();
        $total_projectfollowers_count = $obj->ProjectFollower->find('count', array(
            'conditions' => $obj->paginate['conditions'],
            'recursive' => 0
        ));
        $iphone_project_follower = array();
        for ($i = 0; $i < count($iphone_project_followers); $i++) {
            $month = date('F', strtotime($iphone_project_followers[$i]['ProjectFollower']['created']));
            $year = date('Y', strtotime($iphone_project_followers[$i]['ProjectFollower']['created']));
            $date = date('d', strtotime($iphone_project_followers[$i]['ProjectFollower']['created']));
            $created = $month . " " . $date;
            $image_options = array(
                'dimension' => 'iphone_big_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $this->saveiPhoneAppThumb($iphone_project_followers[$i]['User']['UserAvatar'], 'UserAvatar');
            if (!empty($iphone_project_followers[$i]['User']['UserAvatar'])) {
                $image_url = getImageUrl('UserAvatar', $iphone_project_followers[$i]['User']['UserAvatar'], $image_options);
            } else {
                $iphone_project_followers[$i]['User']['UserAvatar']['id'] = constant(sprintf('%s::%s', 'ConstAttachment', 'UserAvatar'));
                $image_url = getImageUrl('UserAvatar', $iphone_project_followers[$i]['User']['UserAvatar'], $image_options);
            }
            $iphone_project_follower[$i]['id'] = $iphone_project_followers[$i]['ProjectFollower']['id'];
            $iphone_project_follower[$i]['Follower_username'] = $iphone_project_followers[$i]['User']['username'];
            $iphone_project_follower[$i]['Follower_user_image'] = $image_url;
            $iphone_project_follower[$i]['Follower_created'] = $created;
        }

        $no_of_pages = ceil($total_projectfollowers_count/$obj->paginate['limit']);
        $current_page = !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1;
        
        $response = array(
            'followers_list' => (empty($obj->viewVars['iphone_response'])) ? $iphone_project_follower : $obj->viewVars['iphone_response'],
            '_meta_data' => (empty($obj->viewVars['iphone_response'])) ? array('total_pages' => $no_of_pages, 'current_page' => $current_page) : array()
        );
        
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onBlogListing($event) 
    {
        $obj = $event->subject();
        $iphone_project_updates = $obj->paginate();
        $total_projectupdates_count = $obj->Blog->find('count', array(
            'conditions' => $obj->paginate['conditions'],
            'recursive' => 0
        ));
        $iphone_project_update = array();
        for ($i = 0; $i < count($iphone_project_updates); $i++) {
            $date = date('d', strtotime($iphone_project_updates[$i]['Blog']['created']));
            $month = date('F', strtotime($iphone_project_updates[$i]['Blog']['created']));
            $created = $month . " " . $date;
            $image_options = array(
                'dimension' => 'iphone_small_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $this->saveiPhoneAppThumb($iphone_project_updates[$i]['Project']['User']['UserAvatar'], 'UserAvatar');
            if (!empty($iphone_project_updates[$i]['Project']['User']['UserAvatar'])) {
                $image_url = getImageUrl('UserAvatar', $iphone_project_updates[$i]['Project']['User']['UserAvatar'], $image_options);
            } else {
                $iphone_project_updates[$i]['Project']['User']['UserAvatar']['id'] = constant(sprintf('%s::%s', 'ConstAttachment', 'UserAvatar'));
                $image_url = getImageUrl('UserAvatar', $iphone_project_updates[$i]['Project']['User']['UserAvatar'], $image_options);
            }
            $update_comments = array();
            $iphone_project_update_comments = $iphone_project_updates[$i]['BlogComment'];
            for ($j = 0; $j < count($iphone_project_update_comments); $j++) {
                $date = date('d', strtotime($iphone_project_update_comments[$j]['created']));
                $month = date('F', strtotime($iphone_project_update_comments[$j]['created']));
                $comment_created = $month . " " . $date;
                $update_comments[$j]['BlogComment_comment'] = $iphone_project_update_comments[$j]['comment'];
                $update_comments[$j]['BlogComment_created'] = $comment_created;
                $update_comments[$j]['BlogComment_username'] = $iphone_project_update_comments[$j]['User']['username'];
                $update_comments[$j]['Blogcomment_user_image'] = getImageUrl('UserAvatar', $iphone_project_update_comments[$j]['User']['UserAvatar'], $image_options);
            }
            $iphone_project_update[$i]['Update_id'] = $iphone_project_updates[$i]['Blog']['id'];
            $iphone_project_update[$i]['Update_title'] = $iphone_project_updates[$i]['Blog']['title'];
            $iphone_project_update[$i]['Update_description'] = $iphone_project_updates[$i]['Blog']['content'];
            $iphone_project_update[$i]['Update_slug'] = $iphone_project_updates[$i]['Blog']['slug'];
            $iphone_project_update[$i]['Comment_count'] = $iphone_project_updates[$i]['Blog']['blog_comment_count'];
            $iphone_project_update[$i]['Update_created'] = $created;
            $iphone_project_update[$i]['Update_username'] = $iphone_project_updates[$i]['Project']['User']['username'];
            $iphone_project_update[$i]['Update_user_image'] = $image_url;
            $iphone_project_update[$i]['UpdateComments'] = $update_comments;
        }
        
        $no_of_pages = ceil($total_projectupdates_count/$obj->paginate['limit']);
        $current_page = !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1;
        
        $response = array(
            'project_updates' => (empty($obj->viewVars['iphone_response'])) ? $iphone_project_update : $obj->viewVars['iphone_response'],
            '_meta_data' => (empty($obj->viewVars['iphone_response'])) ? array('total_pages' => $no_of_pages, 'current_page' => $current_page) : array()
        );
        
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onBlogCommentListing($event) 
    {
        $obj = $event->subject();
        $iphone_blog_comments = $obj->paginate();
        $iphone_blog_comment = array();
        for ($i = 0; $i < count($iphone_blog_comments); $i++) {
            $image_options = array(
                'dimension' => 'iphone_small_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $this->saveiPhoneAppThumb($iphone_blog_comments[$i]['User']['UserAvatar'], 'UserAvatar');
            $image_url = getImageUrl('UserAvatar', $iphone_blog_comments[$i]['User']['UserAvatar'], $image_options);
            $date = date('d', strtotime($iphone_blog_comments[$i]['BlogComment']['created']));
            $month = date('F', strtotime($iphone_blog_comments[$i]['BlogComment']['created']));
            $comment_created = $month . " " . $date;
            $iphone_blog_comment[$i]['BlogComment_id'] = $iphone_blog_comments[$i]['BlogComment']['id'];
            $iphone_blog_comment[$i]['BlogComment_blog_id'] = $iphone_blog_comments[$i]['BlogComment']['blog_id'];
            $iphone_blog_comment[$i]['BlogComment_created'] = $comment_created;
            $iphone_blog_comment[$i]['BlogComment_comment'] = $iphone_blog_comments[$i]['BlogComment']['comment'];
            $iphone_blog_comment[$i]['Blog_title'] = $iphone_blog_comments[$i]['Blog']['title'];
            $iphone_blog_comment[$i]['Blog_slug'] = $iphone_blog_comments[$i]['Blog']['slug'];
            $iphone_blog_comment[$i]['Blog_title'] = $iphone_blog_comments[$i]['Blog']['title'];
            $iphone_blog_comment[$i]['Blog_project_id'] = $iphone_blog_comments[$i]['Blog']['project_id'];
            $iphone_blog_comment[$i]['User_username'] = $iphone_blog_comments[$i]['User']['username'];
            $iphone_blog_comment[$i]['User_id'] = $iphone_blog_comments[$i]['User']['id'];
            $iphone_blog_comment[$i]['Blogcomment_user_image'] = $image_url;
        }
        $obj->view = 'Json';
        $obj->set('json', $iphone_blog_comment);
    }
    public function validate_user($event) 
    {
        $obj = $event->subject();
        if ((Configure::read('user.using_to_login') == 'email') && isset($obj->request->data['User']['username'])) {
            $obj->request->data['User']['email'] = $obj->request->data['User']['username'];
            unset($obj->request->data['User']['username']);
        }
        
        $obj->request->data['User'][Configure::read('user.using_to_login') ] = trim($obj->request->data['User'][Configure::read('user.using_to_login') ]);
        
        if (!empty($obj->request->data['User'][Configure::read('user.using_to_login') ])) {
            $user = $obj->User->find('first', array(
                'conditions' => array(
                    'User.username' => $obj->request->data['User'][Configure::read('user.using_to_login') ]
                ) ,
                'recursive' => 1
            ));
            $obj->request->data['User']['password'] = crypt($obj->request->data['User']['passwd'], $user['User']['password']);
        }
        
        if ($obj->Auth->login()) {
            $mobile_app_hash = md5($obj->_unum() . $obj->request->data['User'][Configure::read('user.using_to_login') ] . $obj->request->data['User']['password'] . Configure::read('Security.salt'));
            $obj->User->updateAll(array(
                'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
                'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
            ) , array(
                'User.id' => $obj->Auth->user('id')
            ));
            if (!empty($obj->request->data['User']['devicetoken'])) {
                $obj->User->ApnsDevice->findOrSave_apns_device($obj->Auth->user('id') , $obj->request->data['User']);
            }
            if (!empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
                $this->update_iphone_user($_GET['latitude'], $_GET['longtitude'], $obj->Auth->user('id'));
            }
            
            $this->saveiPhoneAppThumb($user['UserAvatar'], 'User');
            $image_options = array(
                                   'dimension' => 'small_big_thumb',
                                   'class' => '',
                                   'alt' => $user['User']['username'],
                                   'title' => $user['User']['username'],
                                   'type' => 'jpg'
                                   );
            $iphone_big_thumb = getImageUrl('User', $user['UserAvatar'], $image_options);
            $user['User']['iphone_big_thumb'] = $iphone_big_thumb;
            $image_options = array(
                                   'dimension' => 'small_big_thumb',
                                   'class' => '',
                                   'alt' => $user['User']['username'],
                                   'title' => $user['User']['username'],
                                   'type' => 'jpg'
                                   );
            $iphone_small_thumb = getImageUrl('User', $user['UserAvatar'], $image_options);
            $obj->request->data['User']['iphone_small_thumb'] = $iphone_small_thumb;
            $resonse = array(
                'error' => 0,
                'message' => __l('Success') ,
 		'iphone_big_thumb' => $obj->request->data['User']['iphone_small_thumb']  ,
                'hash_token' => $mobile_app_hash,
                'username' => ucwords($obj->request->data['User'][Configure::read('user.using_to_login')]),
 		'user_id' => $obj->Auth->user('id'),
            );
        } else {
            $resonse = array(
                'error' => 1,
                'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
            );
        }
        if ($obj->RequestHandler->prefers('json')) {
            $obj->view = 'Json';
            $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $resonse : $obj->viewVars['iphone_response']);
        }
    }
    
    public function onSocialLogin($event){
        $obj = $event->subject();
        //todo: swagger api issue
        if(!isset($event->data['data']['User'])){
                $obj->request->data['User'] = $event->data['data'];
        }
        if ((Configure::read('user.using_to_login') == 'email') && isset($obj->request->data['User']['username'])) {
            $obj->request->data['User']['email'] = $obj->request->data['User']['username'];
            unset($obj->request->data['User']['username']);
        }
        $obj->request->data['User'][Configure::read('user.using_to_login')] = trim($obj->request->data['User'][Configure::read('user.using_to_login')]);
            if (!empty($obj->request->data['User'][Configure::read('user.using_to_login')])) {
                    $user = $obj->User->find('first', array(
                                                'conditions' => array(
                                                                      'User.username' => $obj->request->data['User'][Configure::read('user.using_to_login')]
                                                                      ) ,
                                                'recursive' => -1
                                                ));
            $obj->request->data['User']['password'] = $obj->request->data['User']['password'];
            }
        if ($obj->Auth->login()) {
            $mobile_app_hash = md5($obj->_unum() . $obj->request->data['User'][Configure::read('user.using_to_login') ] . $obj->request->data['User']['password'] . Configure::read('Security.salt'));
            $obj->User->updateAll(array(
                                        'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
                                        'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
                                    ) , array(
                                        'User.id' => $obj->Auth->user('id')
                                    ));
            
            if (!empty($obj->request->data['User']['devicetoken'])) {
               // Todo: Need to save devicetoken by using findOrSave_apns_device
            }
            if (!empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
               // Todo: Need to save latitude and longitue by using update_iphone_user
            }
            $response = array(
                             'error' => 0,
                             'message' => __l('Success') ,
			    'user_id' => $obj->Auth->user('id'),
                             'hash_token' => $mobile_app_hash,
                             'username' => $obj->request->data['User'][Configure::read('user.using_to_login') ]
                             );
        } else {
            $response = array(
                             'error' => 1,
                             'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
                             );
        }
        $obj->view = 'Json';
	$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    
    public function onUserForgetPassword($event)
    {
        $obj = $event->subject();
        $message = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $message : $obj->viewVars['iphone_response']);
    }
    
    public function onSecurityQuestionIndex($event)
    {
        $obj = $event->subject();
        $security_question = $obj->SecurityQuestion->find('all', array(
                'conditions' => $obj->paginate['conditions'],
                'order' => array(
               'SecurityQuestion.name' => 'ASC',
               ) ,
               'recursive' => -1
        ));
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? array('question_list' => $security_question) : $obj->viewVars['iphone_response']);
    }
    
    public function onProjectFundsListing($event) 
    {
        $obj = $event->subject();
        $iphone_project_backers = $obj->paginate();
        $total_projectfunds_count = $obj->ProjectFund->find('count', array(
            'conditions' => $obj->paginate['conditions'],
            'recursive' => 0
        ));
        $iphone_project_backer = array();
        for ($i = 0; $i < count($iphone_project_backers); $i++) {
            $month = date('F', strtotime($iphone_project_backers[$i]['ProjectFund']['created']));
            $year = date('Y', strtotime($iphone_project_backers[$i]['ProjectFund']['created']));
            $date = date('d', strtotime($iphone_project_backers[$i]['ProjectFund']['created']));
            $created = $month . " " . $date . " " . $year;
            $other_count = $iphone_project_backers[$i]['User']['unique_project_fund_count']-1;
            $image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            if (empty($iphone_project_backers[$i]['ProjectFund']['is_anonymous']) || $iphone_project_backers[$i]['User']['id'] == $obj->Auth->user('id') || (!empty($iphone_project_backers[$i]['ProjectFund']['is_anonymous']) && $iphone_project_backers[$i]['ProjectFund']['is_anonymous'] == ConstAnonymous::FundedAmount)) {
                $backer_name = $iphone_project_backers[$i]['User']['username'];
                if (!empty($iphone_project_backers[$i]['User']['UserAvatar'])) {
                    $image_url = getImageUrl('UserAvatar', $iphone_project_backers[$i]['User']['UserAvatar'], $image_options);
                } else {
                    $iphone_project_backers[$i]['User']['UserAvatar']['id'] = constant(sprintf('%s::%s', 'ConstAttachment', 'UserAvatar'));
                    $image_url = getImageUrl('UserAvatar', $iphone_project_backers[$i]['User']['UserAvatar'], $image_options);
                }
            } else {
                $backer_name = __l('Anonymous');
                $iphone_project_backers[$i]['User']['UserAvatar']['id'] = constant(sprintf('%s::%s', 'ConstAttachment', 'Anonymous'));
                $image_url = getImageUrl('UserAvatar', $iphone_project_backers[$i]['User']['UserAvatar'], $image_options);
            }
            if (empty($iphone_project_backers[$i]['ProjectFund']['is_anonymous']) || $iphone_project_backers[$i]['User']['id'] == $obj->Auth->user('id') || (!empty($iphone_project_backers[$i]['ProjectFund']['is_anonymous']) && $iphone_project_backers[$i]['ProjectFund']['is_anonymous'] == ConstAnonymous::Username)) {
                $backer_amount = $iphone_project_backers[$i]['ProjectFund']['amount'];
            } else {
                $backer_amount = '';
            }
            $this->saveiPhoneAppThumb($iphone_project_backers[$i]['User']['UserAvatar'], 'UserAvatar');
            $iphone_project_backer[$i]['id'] = $iphone_project_backers[$i]['ProjectFund']['id'];
            $iphone_project_backer[$i]['Backer_username'] = $backer_name;
            $iphone_project_backer[$i]['Backer_amount'] = $backer_amount;
            $iphone_project_backer[$i]['Backer_user_image'] = $image_url;
            $iphone_project_backer[$i]['Backer_created'] = $created;
            if (!empty($iphone_project_backers[$i]['ProjectReward']['reward'])) {
                $iphone_project_backer[$i]['Backer_reward'] = $iphone_project_backers[$i]['ProjectReward']['reward'];
            } else {
                $iphone_project_backer[$i]['Backer_reward'] = __l('No reward');
            }
            $iphone_project_backer[$i]['Other_projects'] = $other_count;
        }
        $obj->view = 'Json';
        
        $no_of_pages = ceil($total_projectfunds_count/5);
        $current_page = !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1;
        
        $response = array(
            'project_funds_list' => (empty($obj->viewVars['iphone_response'])) ? $iphone_project_backer : $obj->viewVars['iphone_response'],
            '_meta_data' => (empty($obj->viewVars['iphone_response'])) ? array('total_pages' => $no_of_pages, 'current_page' => $current_page) : array()
        );
        
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onProjectRatingListing($event) 
    {
        $obj = $event->subject();
        $iphone_project_voters = $obj->paginate();
        for ($i = 0; $i < count($iphone_project_voters); $i++) {
            $month = date('F', strtotime($iphone_project_voters[$i]['ProjectRating']['created']));
            $year = date('Y', strtotime($iphone_project_voters[$i]['ProjectRating']['created']));
            $date = date('d', strtotime($iphone_project_voters[$i]['ProjectRating']['created']));
            $created = $month . " " . $date;
            $image_options = array(
                'dimension' => 'iphone_small_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            $this->saveiPhoneAppThumb($iphone_project_voters[$i]['User']['UserAvatar'], 'UserAvatar');
            $image_url = getImageUrl('UserAvatar', $iphone_project_voters[$i]['User']['UserAvatar'], $image_options);
            $iphone_project_voter[$i]['Voters username'] = $iphone_project_voters[$i]['User']['username'];
            $iphone_project_voter[$i]['Voters user image'] = $image_url;
            $iphone_project_voter[$i]['Vote created'] = $created;
            $iphone_project_voter[$i]['Vote count'] = $iphone_project_voters[$i]['ProjectRating']['rating'];
        }
        $obj->view = 'Json';
        $obj->set('json', $iphone_project_voter);
    }
    public function onProjectRatingAdd($event)
    {
        $obj = $event->subject();
        $response = $event->data['data'];
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onProjectCommentListing($event) 
    {
        $obj = $event->subject();
        $iphone_project_comments = $obj->paginate();
        $iphone_project_comment = array();
        for ($i = 0; $i < count($iphone_project_comments); $i++) {
            $image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => 'alt',
                'title' => 'title',
                'type' => 'jpg',
                'full_url' => true
            );
            if (!empty($iphone_project_comments[$i]['OtherUser']['UserAvatar'])) {
                $image_url = getImageUrl('UserAvatar', $iphone_project_comments[$i]['OtherUser']['UserAvatar'], $image_options);
            } else {
                $iphone_project_comments[$i]['OtherUser']['UserAvatar']['id'] = constant(sprintf('%s::%s', 'ConstAttachment', 'UserAvatar'));
                $image_url = getImageUrl('UserAvatar', $iphone_project_comments[$i]['OtherUser']['UserAvatar'], $image_options);
            }
            if ($iphone_project_comments[$i]['Message']['is_private'] && (!$obj->Auth->user('id') || ($obj->Auth->user('id') != $iphone_project_comments[$i]['Message']['user_id'] && $obj->Auth->user('id') != $iphone_project_comments[$i]['Message']['other_user_id']))) {
                $message_content = '[' . __l('Private Message') . ']';
            } else {
                $message_content = $iphone_project_comments[$i]['MessageContent']['message'];
            }
            $this->saveiPhoneAppThumb($iphone_project_comments[$i]['OtherUser']['UserAvatar'], 'UserAvatar');
            $date = date('d', strtotime($iphone_project_comments[$i]['Message']['created']));
            $month = date('F', strtotime($iphone_project_comments[$i]['Message']['created']));
            $comment_created = $month . " " . $date;
            $iphone_project_comment[$i]['Comment_created'] = $comment_created;
            $iphone_project_comment[$i]['Comment'] = $message_content;
            $iphone_project_comment[$i]['Blogcomment_title'] = $iphone_project_comments[$i]['Project']['name'];
            $iphone_project_comment[$i]['Comment_username'] = $iphone_project_comments[$i]['OtherUser']['username'];
            $iphone_project_comment[$i]['Comment_user_image'] = $image_url;
        }
       
        $response = array(
            'project_comments_list' => (empty($obj->viewVars['iphone_response'])) ? $iphone_project_comment : $obj->viewVars['iphone_response'],
        );
        
        $obj->view = 'Json';
        $obj->set('json', $response);
    }
    public function onWalletAdd($event)
    {
        $obj = $event->subject();
        $data = array();
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $data : $obj->viewVars['iphone_response']);
    }
    public function onSudopayGateways($event)
    {		
            $obj = $event->subject();
            $response = array();
            $response = $obj->request->data;
            $obj->view = 'Json';
            $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
     }
    public function onProjectFundAdd($event)
    {
        $obj = $event->subject();
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? array() : $obj->viewVars['iphone_response']);
    }
    public function onProjectFundRewardsList($event)
    {
        $obj = $event->subject();
        $rewards = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $rewards : $obj->viewVars['iphone_response']);
    }
    public function onMasterList($event)
    {
        $obj = $event->subject();
        $message = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $message : $obj->viewVars['iphone_response']);
    }	

    public function onLanguageIndex($event)
    {
        $obj = $event->subject();
        $states = $obj->Language->find('all', array(
            'conditions' => $obj->paginate['conditions'],
            'order' => array(
                    'Language.name' => 'ASC',
            ) ,
            'recursive' => -1
        ));
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? array('language_list'=>$states) : $obj->viewVars['iphone_response']);
    }
    public function onUserProfileEdit($event)
    {		
        $obj = $event->subject();
        $users = $obj->request->data;
        $i = 0;
        if(!empty($obj->viewVars['iphone_response'])){
            $res = $obj->viewVars['iphone_response'];
            $res['user'] = $users;
        }
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $users : $res);
    }
    public function onMessageIndex($event)
    {
        $obj = $event->subject();
        $total_counts = $obj->Message->find('count', array(
                                                      'conditions' => $obj->paginate['conditions'],
                                                      'recursive' => 0
                                                      ));
        $data = $obj->paginate();
        $userAvatar['userAvatar'] = $obj->viewVars['userAvatar'];
        //user avatar.
        $i=0;
        while($i < count($userAvatar['userAvatar']))
           {
			
            $data[$i]['Message']['property_user_status'] = $data[$i]['PropertyUserStatus']['name'];
            
            $originalDate =  $data[$i]['Message']['created']; 
            $newDate = date("jS M Y", strtotime($originalDate));
            $data[$i]['Message']['created'] = $newDate;	
	    
            $this->saveiPhoneAppThumb($userAvatar['userAvatar'][$i], 'User');
            $image_options = array(
                            'dimension' => 'small_big_thumb',
                            'class' => '',
                            'alt' => $userAvatar['userAvatar'][$i],
                            'title' => $userAvatar['userAvatar'][$i],
                            'type' => 'jpg'
                        );
            $iphone_big_thumb = getImageUrl('User', $userAvatar['userAvatar'][$i], $image_options);
            $data[$i]['OtherUser']['big_thumb'] = $iphone_big_thumb;
            $image_options = array(
                       'dimension' => 'iphone_small_thumb',
                       'class' => '',
                       'alt' => $userAvatar['userAvatar'][$i],
                       'title' => $userAvatar['userAvatar'][$i],
                       'type' => 'jpg'
                    );
            $iphone_small_thumb = getImageUrl('User', $userAvatar['userAvatar'][$i], $image_options);
            $data[$i]['OtherUser']['small_thumb'] = $iphone_small_thumb;
            $i++;
        }
		
		
        $no_of_pages = ceil($total_counts/20);
        $current_page = !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1;
        $response = array(
                         'message_list' => (empty($obj->viewVars['iphone_response'])) ? $data : $obj->viewVars['iphone_response'],
                         '_meta_data' => (empty($obj->viewVars['iphone_response'])) ? array('total_pages' => $no_of_pages, 'current_page' => $current_page) : array()
                    );
        $obj->view = 'Json';
	$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    public function onProjectAdd($event)
    {
     	$obj = $event->subject();
     	$project = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $project : $obj->viewVars['iphone_response']);
    }
    public function onProjectPayNowAdd($event)
    {
        $obj = $event->subject();
        $data = array();
        if($obj->request->is('get')){
            $data['projects'] = $obj->request->data;
        }		
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $data : $obj->viewVars['iphone_response']);
    }
    public function onEquityProjectSeisEntryAdd($event)
    {
        $obj = $event->subject();
     	$seis_entry = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $seis_entry : $obj->viewVars['iphone_response']);
    }
    public function onCheckLendRate($event)
    {
        $obj = $event->subject();
     	$check_rate = $event->data;
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $check_rate : $obj->viewVars['iphone_response']);
    }
    public function onPaymentsMembershipPayNow($event)
    {
        $obj = $event->subject();
        $obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? array() : $obj->viewVars['iphone_response']);
    }
    public function saveiPhoneAppThumb($attachments, $model = 'Project') 
    {
        $options[] = array(
            'dimension' => 'iphone_big_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
            'full_url' => true
        );
        $options[] = array(
            'dimension' => 'iphone_small_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
            'full_url' => true
        );
        $attachment = $attachments;
        foreach($options as $option) {
            if (!empty($attachment['id'])) {
                $destination = APP . 'webroot' . DS . 'img' . DS . $option['dimension'] . DS . $model . DS . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $option['type'] . $option['dimension'] . Configure::read('site.name')) . '.' . $option['type'];
                if (!file_exists($destination) && !empty($attachment['id'])) {
                    $url = getImageUrl($model, $attachment, $option);
                    getimagesize($url);
                }
            }
        }
    }
}
?>