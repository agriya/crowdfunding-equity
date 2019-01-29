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
class Equity extends AppModel
{
    public $name = 'Equity';
    var $useTable = 'project_equity_fields';
    public $displayField = 'id';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'EquityProjectCategory' => array(
            'className' => 'Equity.EquityProjectCategory',
            'foreignKey' => 'equity_project_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => '',
        ) ,
        'EquityProjectStatus' => array(
            'className' => 'Equity.EquityProjectStatus',
            'foreignKey' => 'equity_project_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => '',
        ) ,
        'Project' => array(
            'className' => 'Projects.Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Project'
        );
        $this->validate = array(
            'project_funding_end_date' => array(
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>=',
                        date('Y-m-d') ,
                    ) ,
                    'message' => sprintf(__l('%s funding end date should be greater than to today') , Configure::read('project.alt_name_for_project_singular_caps'))
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'message' => __l('Enter valid date')
                )
            ) ,
            'equity_project_category_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            )
        );
    }
    function minMaxAmount($field1, $field = null) 
    {
        return ($this->data[$this->name][$field] >= Configure::read('Project.minimum_amount') && $this->data[$this->name][$field] <= Configure::read('Project.maximum_amount'));
    }
    function updateProjectStatus($project_fund_id) 
    {
        $projectFund = $this->Project->ProjectFund->find('first', array(
            'conditions' => array(
                'ProjectFund.id' => $project_fund_id
            ) ,
            'contain' => array(
                'Project' => array(
                    'Equity',
                ) ,
            ) ,
            'recursive' => 2
        ));
        if ($projectFund['Project']['collected_amount'] == $projectFund['Project']['needed_amount']) {
            $this->updateStatus(ConstEquityProjectStatus::ProjectClosed, $projectFund['Project']['id']);
        }
    }
    function updateStatus($to_project_status_id, $project_id) 
    {
        $project = $this->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id,
            ) ,
            'contain' => array(
                'Equity',
                'User',
                'ProjectType',
                'Attachment',
            ) ,
            'recursive' => 0,
        ));
        $_data = array();
        $_data['Equity']['equity_project_status_id'] = $to_project_status_id;
        if ($to_project_status_id == ConstEquityProjectStatus::ProjectClosed) {
            $_data['Equity']['project_fund_goal_reached_date'] = date('Y-m-d H:i:s');
        }
        if ($to_project_status_id == ConstEquityProjectStatus::ProjectCanceled) {
            $_data['Project']['project_cancelled_date'] = date('Y-m-d H:i:s');
        }
        $_data['Equity']['id'] = $project['Equity']['id'];
        $this->save($_data);
        $tmp_project = $this->
        {
            'processStatus' . $to_project_status_id}($project);
            $_data = array();
            $_data['from_project_status_id'] = $project['Equity']['equity_project_status_id'];
            $_data['to_project_status_id'] = $to_project_status_id;
            $this->postActivity($project, ConstProjectActivities::StatusChange, $_data);
            //Expired or Canceled only hide in activities
            if ($to_project_status_id == 4 || $to_project_status_id == 5) {
                // update activities record hide from public
                $this->Project->Message->updateActivitiesHideFromPublic($project_id);
            }
        }
        function processStatus2($project) 
        {
            // Open For Investing //
            if (isPluginEnabled('SocialMarketing')) {
                App::import('Model', 'SocialMarketing.UserFollower');
                $this->UserFollower = new UserFollower();
                $this->UserFollower->send_follow_mail($_SESSION['Auth']['User']['id'], 'added', $project);
            }
            $data['Project']['project_start_date'] = date('Y-m-d');
            $data['Project']['id'] = $project['Project']['id'];
            $this->Project->save($data);
            $total_needed_amount = $project['User']['total_needed_amount']+$project['Project']['needed_amount'];
            $this->Project->updateAll(array(
                'User.total_needed_amount' => $total_needed_amount
            ) , array(
                'User.id' => $project['User']['id']
            ));
            $this->Project->postOnSocialNetwork($project);
            $data = array();
            $data['User']['id'] = $project['Project']['user_id'];
            $data['User']['is_idle'] = 0;
            $data['User']['is_project_posted'] = 1;
            $this->Project->User->save($data);
        }
        function processStatus3($project) 
        {
            // Funding Closed //
            // capture backed amount
            $this->Project->_executepay($project['Project']['id']);
        }
        function processStatus4($project) 
        {
            // Project Expired //
            // refund backed amount to backer
            $this->Project->_refund($project['Project']['id']);
        }
        function processStatus5($project) 
        {
            // Project Canceled //
            // refund backed amount to backer
            $data['Project']['project_cancelled_date'] = date('Y-m-d H:i:s');
            $data['Project']['id'] = $project['Project']['id'];
            $this->Project->save($data);
            $this->Project->_refund($project['Project']['id'], 1);
        }
        function processStatus6() 
        {
            // GoalReached //
            
        }
        function processStatus8($project) 
        {
            // Open For Idea //
            $data = array();
            $data['User']['id'] = $project['Project']['user_id'];
            $data['User']['is_idle'] = 0;
            $data['User']['is_project_posted'] = 1;
            $this->Project->User->save($data);
        }
		public function onProjectFundCancellation($data) 
		{
			$_data = array();
			App::import('Model', 'Equity.EquityFund');
			$this->EquityFund = new EquityFund();
			$equityFund = $this->EquityFund->find('first', array(
				'conditions' => array(
					'EquityFund.project_fund_id' => $data['ProjectFund']['id']
				) ,
				'recursive' => -1
			));
			$equity = $this->find('first', array(
				'conditions' => array(
					'Equity.project_id' => $data['ProjectFund']['project_id']
				) ,
				'recursive' => -1
			));
			$_data['id'] = $equity['Equity']['id'];
			$_data['shares_allocated'] = $equity['Equity']['shares_allocated']-$equityFund['EquityFund']['shares_allocated'];
			$this->save($_data);
		}
		public function deductFromCollectedAmount($project) 
		{
			$projectTypeName = ucwords($project['ProjectType']['name']);
			$equities = $this->find('all', array(
				'conditions' => array(
					'Equity.project_id' => $project['Project']['id'],
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
			if (in_array($projectDetails[$project['Project']['id']]['id'], array(
						ConstEquityProjectStatus::ProjectCanceled,
						ConstEquityProjectStatus::ProjectExpired
					))) {
				return false;
			} else {
				return true;
			}
			
		}
		public function getCategoryConditions($category = null, $is_slug = true)  
		{
			if(!empty($is_slug)) {
				App::import('Model', 'Equity.EquityProjectCategory');
				$this->EquityProjectCategory = new EquityProjectCategory();
				$category = $this->EquityProjectCategory->find('first', array(
					'conditions' => array(
						'EquityProjectCategory.slug' => $category
					) ,
					'recursive' => -1
				));
				$response['category_details'] = $category['EquityProjectCategory'];
				$response['conditions'] = array(
					'Equity.equity_project_category_id' => $category['EquityProjectCategory']['id']
				);
			} else {
				$response['conditions'] = array(
					'Equity.equity_project_category_id' => $category
				);
			}
			return $response;
		}
		public function onProjectCategories($is_slug = false)  
		{
			$fields = array(
				'EquityProjectCategory.slug',
				'EquityProjectCategory.name'
			);
			if(!$is_slug) {
				$fields = array(
					'EquityProjectCategory.id',
					'EquityProjectCategory.name'
				);
			}	
			$equityProjectCategory = $this->EquityProjectCategory->find('list', array(
				'conditions' => array(
					'EquityProjectCategory.is_approved' => 1
				) ,
				'fields' => $fields,
				'order' => array(
					'EquityProjectCategory.name' => 'ASC'
				) ,
			));
			$response['equityCategories'] = $equityProjectCategory;
			return $response;
		}
		public function isAllowToPublish($project_id) 
		{
			$project = $this->find('count', array(
				'conditions' => array(
					'Equity.project_id' => $project_id,
					'Equity.equity_project_status_id' => array(
						ConstEquityProjectStatus::OpenForIdea,
						ConstEquityProjectStatus::OpenForInvesting
					)
				)
			));
			$response['is_allow_to_publish'] = 1;
			return $response;
		}
		public function isAllowToProcessPayment($project_id) 
		{
			$project = $this->find('count', array(
				'conditions' => array(
					'Equity.project_id' => $project_id,
					'Equity.equity_project_status_id' => ConstEquityProjectStatus::Pending,
					'Project.is_paid' => 0,
				) ,
				'recursive' => 0
			));
			if (!empty($project)) {
				$response['is_allow_process_payment'] = 1;
				return $response;
			}
		}
		public function isAllowToViewProject($project, $funded_users, $followed_user) 
		{
			$response['is_allow_to_view_project'] = 1;
			if ((in_array($project['Equity']['equity_project_status_id'], array(
				ConstEquityProjectStatus::Pending,
				ConstEquityProjectStatus::ProjectExpired,
				ConstEquityProjectStatus::ProjectCanceled
			))) && (!$funded_users) && (!$followed_user) && (!$_SESSION['Auth']['User']['id'] || ($_SESSION['Auth']['User']['id'] && $_SESSION['Auth']['User']['id'] != $project['Project']['user_id'] && (!$funded_users) && $_SESSION['Auth']['User']['role_id'] != ConstUserTypes::Admin))) {
				$response['is_allow_to_view_project'] = 0;
			}
			return $response;
		}
		public function onProjectViewMessageDisplay($project) 
		{
			$equity = $this->find('first', array(
				'conditions' => array(
					'Equity.equity_project_status_id' => array(
						ConstEquityProjectStatus::OpenForIdea,
						ConstEquityProjectStatus::OpenForInvesting,
						ConstEquityProjectStatus::ProjectClosed
					) ,
					'Equity.project_id' => $project['Project']['id']
				) ,
				'fields' => array(
					'Equity.project_id'
				)
			));
			$response['is_comment_allow'] = 0;
			if (!empty($equity)) {
				$response['is_comment_allow'] = 1;
			}
			return $response;
		}
		public function getUserOpenProjectCount($user_id){
			$equity_count = $this->Project->find('count',array(
					'conditions' => array(
							'Equity.equity_project_status_id' => ConstEquityProjectStatus::OpenForInvesting,
							'Project.user_id' => $user_id,
					) ,
					'contain' => array(
							'Equity'
					) ,
					'recursive' => 0
			));
			return $equity_count;
		}
    }
?>