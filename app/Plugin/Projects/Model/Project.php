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
class Project extends AppModel
{
    public $name = 'Project';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'name',
                'short_description',
                'description'
            )
        ) ,
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
                'Project.is_admin_suspended' => '0',
            ) ,
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ProjectType' => array(
            'className' => 'ProjectType',
            'foreignKey' => 'project_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    public $hasOne = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Attachment.class' => 'Project',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Submission' => array(
            'className' => 'Projects.Submission',
            'foreignKey' => 'project_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasMany = array(
        'ProjectView' => array(
            'className' => 'Projects.ProjectView',
            'foreignKey' => 'project_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ProjectFund' => array(
            'className' => 'Projects.ProjectFund',
            'foreignKey' => 'project_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Message' => array(
            'className' => 'Projects.Message',
            'foreignKey' => 'project_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'Project'
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ProjectFund',
            'Message',
            'Chart',
            'Pledge',
            'Donate',
            'Lend',
            'Equity',
            'ProjectFlag',
        );
        $this->validate = array(
            'needed_amount' => array(
				'rule5' => array(
					'rule' =>  'numeric',
					'allowEmpty' => false,
					'message' => __l('Amount should be in numeric')
				),
                'rule4' => array(
                    'rule' => array(
                        'validateInvestAmount',
                        'needed_amount',
                    ) ,
                    'message' => sprintf(__l('Entered amount is not multiple of  %s') , Configure::read('site.currency') . Configure::read('equity.amount_per_share'))
                ) ,
                'rule3' => array(
                    'rule' => array(
                        'minMaxAmount',
                        'needed_amount',
                    ) ,
                    'message' => sprintf(__l('The amount between %s to %s') , Configure::read('Project.minimum_amount') , Configure::read('Project.maximum_amount'))
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>=',
                        1
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ),
            'address1' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'short_description' => array(
                'rule2' => array(
                    'rule' => array(
                        'between',
                        Configure::read('Project.min_short_description_length') ,
                        Configure::read('Project.project_short_description_length') ,
                    ) ,
                    'allowEmpty' => false,
                    'message' => sprintf(__l('Short description between %s to %s characters') , Configure::read('Project.min_short_description_length') , Configure::read('Project.project_short_description_length'))
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'payment_method_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'project_end_date' => array(
                'rule3' => array(
                    'rule' => array(
                        'projectFundingEndDate',
                        'project_end_date',
                    ) ,
                    'message' => sprintf(__l('%s funding end date should not be greater than %s days from today') , Configure::read('project.alt_name_for_project_singular_caps') , Configure::read('maximum_project_expiry_day'))
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        date('Y-m-d') ,
                    ) ,
                    'message' => sprintf(__l('%s funding end date should  be greater than today') , Configure::read('project.alt_name_for_project_singular_caps'))
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'message' => __l('Enter valid date')
                )
            ) ,
            'expected_delivery_date' => array(
                'rule2' => array(
                    'rule' => array(
                        'fundingEndDate',
                        'project_end_date'
                    ) ,
                    'message' => __l('Expected delivery date should be future date')
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'message' => __l('Enter valid date')
                )
            ) ,
            'project_status_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'project_category_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'min_amount_to_fund' => array(
                'rule1' => array(
                    'rule' => '_checkRewardAmount',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and policies')
            ) ,
            'feed_url' => array(
                'rule' => array(
                    'url',
                    true
                ) ,
                'message' => __l('Must be a valid URL, starting with http://') ,
                'allowEmpty' => true
            ) ,
            'facebook_feed_url' => array(
                'rule' => array(
                    'url',
                    true
                ) ,
                'message' => __l('Must be a valid URL, starting with http://') ,
                'allowEmpty' => true
            )
        );
        $this->isFilterOptions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Flagged => __l('Flag')
        );
        $this->moreActions = array(
            ConstMoreAction::Successful => __l('Genuine') ,
            ConstMoreAction::Failed => __l('Not Genuine') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear Flag') ,
            ConstMoreAction::Featured => __l('Featured') ,
            ConstMoreAction::Notfeatured => __l('Not Featured') ,
            ConstMoreAction::Delete => __l('Delete')
        );
    }
    function projectFundingEndDate($fields, $field1)
    {
        if (!empty($this->data[$this->name][$field1])) {
            if (!empty($this->data[$this->name]['project_start_date'])) {
                $start_date = strtotime($this->data[$this->name]['project_start_date']);
            } else {
                $start_date = time();
            }
            if (strtotime($this->data[$this->name][$field1]) <= strtotime(date('Y-m-d') . ' + ' . Configure::read('maximum_project_expiry_day') . ' days')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function _checkRewardAmount()
    {
        if ($this->data[$this->name]['pledge_type_id'] != ConstPledgeTypes::Any) {
            if ($this->data[$this->name]['min_amount_to_fund'] < 1 && ($this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Minimum || $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Fixed || $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Multiple)) {
                $this->validationErrors['min_amount_to_fund'] = __l('Must be greater than zero');
                return true;
            } else if ($this->data[$this->name]['min_amount_to_fund'] > $this->data[$this->name]['needed_amount'] && ($this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Minimum || $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Fixed || $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Multiple)) {
                $this->validationErrors['min_amount_to_fund'] = __l('The amount should be less than needed amount');
                return true;
            } else if ((($this->data[$this->name]['needed_amount'] % $this->data[$this->name]['min_amount_to_fund']) != 0) && ($this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Multiple || $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Fixed) && !$this->data[$this->name]['is_allow_over_funding']) {
                $this->validationErrors['min_amount_to_fund'] = __l('Amount cannot be equally shared or else you should allow over funding.');
                return true;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    function minMaxAmount($field1, $field = null)
    {
        return ($this->data[$this->name][$field] >= Configure::read('Project.minimum_amount') && $this->data[$this->name][$field] <= Configure::read('Project.maximum_amount'));
    }
    function fundingEndDate($fields, $field1)
    {
        if (Date('Y') . '-' . Date('m') . '-' . Date('d') <= $this->data[$this->name][$field1]) {
            return true;
        }
    }
    function isValidDate($field1, $field = null)
    {
        return Date('Y') . '-' . Date('m') . '-' . Date('d') <= $this->data[$this->name][$field];
    }
    function _refund($project_id, $canceled = '')
    {
        $this->_executeOrRefund($project_id, 1);
        $this->updateAll(array(
            'Project.collected_percentage' => 0,
        ) , array(
            'Project.id' => $project_id
        ));
        if ($canceled) {
            $_data['ProjectFund.canceled_by_user_id'] = ConstPledgeCanceledBy::Owner;
            if ($_SESSION['Auth']['User']['Role']['id'] == ConstUserTypes::Admin) {
                $_data['ProjectFund.canceled_by_user_id'] = ConstPledgeCanceledBy::Admin;
            }
            $this->ProjectFund->updateAll($_data, array(
                'ProjectFund.project_id' => $project_id
            ));
        }
    }
    function _executepay($project_id)
    {
        $this->_executeOrRefund($project_id, 0);
    }
    function _executeOrRefund($project_id, $is_refund)
    {
        $project = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'ProjectFund' => array(
                    'conditions' => array(
                        'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized
                    ) ,
                    'fields' => array(
                        'ProjectFund.id',
                        'ProjectFund.amount',
                    )
                ) ,
                'ProjectType'
            ) ,
            'recursive' => 2
        ));
        if (!empty($project['ProjectFund'])) {
            foreach($project['ProjectFund'] as $projectFund) {
                if (!empty($is_refund)) {
                    $this->ProjectFund->updateStatus($projectFund['id'], ConstProjectFundStatus::Refunded);
                } else {
                    $this->ProjectFund->updateStatus($projectFund['id'], ConstProjectFundStatus::Captured);
                }
            }
        }
    }
    function rss_feed($url_array = null, $limit = null)
    {
        App::import('Vendor', 'simplepie');
        $feed = new SimplePie();
        if (!empty($limit)) {
            $feed->set_item_limit($limit);
        }
        $feed->set_feed_url($url_array);
        $feed->set_cache_location(CACHE . 'rss' . DS);
        $feed->set_cache_duration(300);
        $feed->set_timeout(30);
        $feed->set_favicon_handler(Cache::read('site_url_for_shell', 'long') . 'handler_image.php');
        //retrieve the feed
        $feed->init();
        $feed->handle_content_type();
        return $feed;
    }
    function _updateCityProjectCount()
    {
        $conditions = $contain = array();
        $conditions['Project.is_admin_suspended'] = 0;
        $conditions['Project.is_draft'] = 0;
        $conditions['Project.is_active'] = 1;
        $response = Cms::dispatchEvent('Controller.ProjectType.getConditions', $this, array(
            'page' => 'cron',
            'type' => 'city_count'
        ));
        if (!empty($response->data['conditions'])) {
            $conditions = array_merge($conditions, $response->data['conditions']);
        }
        $response = Cms::dispatchEvent('Controller.ProjectType.getContain', $this, array(
            'type' => 2
        ));
        $contain = array_merge($contain, $response->data['contain']);		
		$active_projects = array();
        $activeProjects = $this->find('all', array(
            'conditions' => $conditions,
            'contain' => $contain,
            'fields' => array(
                'Project.id',
            ) ,
            'recursive' => 2
        ));
		if(!empty($activeProjects)){
			foreach($activeProjects as $activeProject) {
				$active_projects[] = $activeProject['Project']['id'];
			}
		}		
        $city_conditions['Project.id'] = $active_projects;
        $cityProjects = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1,
            ) ,
            'contain' => array(
                'Project' => array(
                    'conditions' => $city_conditions,
					'fields' => array(
						'Project.id'
					)
                ) ,
            ) ,
            'recursive' => 1
        ));
        $this->City->updateAll(array(
            'City.project_count' => 0,
        ));
        foreach($cityProjects as $cityProject) {
            if (!empty($cityProject['Project'])) {
                $this->City->updateAll(array(
                    'City.project_count' => count($cityProject['Project']) ,
                ) , array(
                    'City.id' => $cityProject['City']['id']
                ));
            }
        }
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account)
    {
        $project = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $foreign_id
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0,
        ));
        $projectType = $this->ProjectType->find('first', array(
            'conditions' => array(
                'ProjectType.id' => $project['Project']['project_type_id']
            ) ,
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        if (isset($projectType['ProjectType']['listing_fee']) and $projectType['ProjectType']['listing_fee'] != 0 and !empty($projectType['ProjectType']['listing_fee_type'])) {
            if ($projectType['ProjectType']['listing_fee_type'] == ConstListingFeeType::amount) {
                $amount = $projectType['ProjectType']['listing_fee'];
            } else {
                $amount = $project['Project']['needed_amount']*($projectType['ProjectType']['listing_fee']/100);
            }
        } else {
            if (Configure::read('Project.project_listing_fee_type') == 'amount') {
                $amount = Configure::read('Project.listing_fee');
            } else {
                $amount = $project['Project']['needed_amount']*(Configure::read('Project.listing_fee') /100);
            }
        }
        $amount = round($amount);
        $return['amount'] = array(
            $amount
        );
        $return['fees_payer'] = 'buyer';
        if (Configure::read('Project.project_fee_payeer') == 'Site') {
            $return['fees_payer'] = 'merchant';
        }
        $return['action'] = 'Capture';
        $return['buyer_email'] = $project['User']['email'];
        $return['sudopay_gateway_id'] = $project['Project']['sudopay_gateway_id'];
        return $return;
    }
    function processPayment($project_id, $total_amount, $gateway_id)
    {
        $project = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'User',
                'ProjectType'
            ) ,
            'recursive' => 0,
        ));
        $_Data['Project']['id'] = $project['Project']['id'];
        $_Data['Project']['is_paid'] = 1;
        $_Data['Project']['fee_amount'] = $total_amount;
        $this->save($_Data);
		if($project['Project']['is_paid'] == 0){
			$payment_step = $this->getProjectPaymentStep($project['Project']['id']);
			$projectStatus = array();
			$response = Cms::dispatchEvent('Behavior.ProjectType.GetProjectStatus', $this, array(
				'projectStatus' => $projectStatus,
				'project' => $project,
				'type' => 'status'
			));
			$this->getAndUpdateTrackedSteps($project['Project']['id'], $payment_step, '', '', $response->data);
			$site_revenue = $project['User']['site_revenue']+$total_amount;
			$this->User->updateAll(array(
				'User.site_revenue' => $site_revenue
			) , array(
				'User.id' => $project['User']['id']
			));
			if ($this->User->Transaction->log($project['Project']['id'], 'Projects.Project', $gateway_id, ConstTransactionTypes::ListingFee)) {
				$this->_sendAlertOnProjectAdd($project, 'New Project');
			}
		}
    }
    function _sendAlertOnProjectAdd($project, $emailType)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email_template = $this->EmailTemplate->selectTemplate($emailType);
        $response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
            'data' => $project,
            'class' => 'categoryname'
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $project['User']['username'],
            '##PROJECT_NAME##' => $project['Project']['name'],
            '##AMOUNT##' => $project['Project']['needed_amount'],
            '##CATEGORY##' => $response->data['content'],
            '##PROJECT_URL##' => Router::url(array(
                'controller' => 'projects',
                'action' => 'view',
                $project['Project']['slug'],
                'admin' => false
            ) , true) ,
        );
        $this->_sendEmail($email_template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
    }
    function _sendAlertOnProjectStatus($project, $emailType, $projectFund = '', $to = '', $paypal_or_wallet = '')
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email_template = $this->EmailTemplate->selectTemplate($emailType);
        if (!empty($to) && $to == 'admin') {
            $username = 'admin';
        } else {
            $username = (!empty($to) && $to == 'buyer') ? $projectFund['User']['username'] : $project['User']['username'];
        }
        $amount = (!empty($projectFund['ProjectFund']['amount'])) ? $projectFund['ProjectFund']['amount'] : $project['ProjectFund']['amount'];
        $emailFindReplace = array(
            '##USERNAME##' => $username,
            '##PROJECT_NAME##' => $project['Project']['name'],
            '##PROJECT_LINK##' => Router::url(array(
                'controller' => 'projects',
                'action' => 'view',
                $project['Project']['slug'],
                'admin' => false
            ) , true) ,
            '##BUYER_USERNAME##' => !empty($_SESSION['Auth']['User']['username']) ? $_SESSION['Auth']['User']['username'] : '',
            '##AMOUNT##' => Configure::read('site.currency') . $amount,
            '##PAYPAL_OR_WALLET##' => $paypal_or_wallet,
        );
        if (!empty($to) && $to == 'admin') {
            $_to = Configure::read('EmailTemplate.admin_email');
        } else if (!empty($to) && $to == 'buyer') {
            $_to = $projectFund['User']['email'];
        } else {
            $_to = $project['User']['email'];
        }
        $this->_sendEmail($email_template, $emailFindReplace, $_to);
    }
    function updateProjectOnFund($projectFund, $project)
    {
        $_data = array();
      /*  $_data['Project.commission_amount'] = 'Project.commission_amount + ' . $projectFund['ProjectFund']['site_fee'];
        $_data['Project.collected_amount'] = 'Project.collected_amount + ' . $projectFund['ProjectFund']['amount'];
        $_data['Project.collected_percentage'] = '((Project.collected_amount +  ' . $projectFund['ProjectFund']['amount'] . ')/Project.needed_amount) * 100';*/
	
	    $_data['Project.commission_amount'] = $project['Project']['commission_amount'] + $projectFund['ProjectFund']['site_fee'];
        $_data['Project.collected_amount'] = $project['Project']['collected_amount'] + $projectFund['ProjectFund']['amount'];
        $_data['Project.collected_percentage'] = (($project['Project']['collected_amount'] + $projectFund['ProjectFund']['amount'])/$project['Project']['needed_amount']) * 100;
        $this->updateAll($_data, array(
            'Project.id' => $projectFund['ProjectFund']['project_id']
        ));
    }
    function updateProjectOnRefund($projectFund, $project)
    {
        $projectTypeName = ucwords($project['ProjectType']['name']);
        App::import('Model', $projectTypeName . '.' . $projectTypeName);
        $model = new $projectTypeName();
        $update = $model->deductFromCollectedAmount($project);
        if ($update) {
            $_data = array();
            $_data['Project.commission_amount'] = 'Project.commission_amount - ' . $projectFund['ProjectFund']['site_fee'];
            $_data['Project.collected_amount'] = 'Project.collected_amount - ' . $projectFund['ProjectFund']['amount'];
            $_data['Project.collected_percentage'] = '(Project.collected_amount/Project.needed_amount) * 100';
            $this->updateAll($_data, array(
                'Project.id' => $projectFund['ProjectFund']['project_id']
            ));
        }
        $_data = array();
        $_data['ProjectFund']['id'] = $projectFund['ProjectFund']['id'];
        $_data['ProjectFund']['project_fund_status_id'] = ConstProjectFundStatus::Expired;
        $this->ProjectFund->save($_data);
    }
    function _validateVideoUrl()
    {
        App::import('Helper', 'Projects.Embed');
        $this->Embed = new EmbedHelper();
        if (!(!empty($this->data['Project']['video_embed_url']) && $this->Embed->parseUrl($this->data['Project']['video_embed_url']))) {
            return false;
        }
        return true;
    }
    public function postOnSocialNetwork($project = null)
    {
        if (!empty($project)) {
            $url = Router::url(array(
                'controller' => 'projects',
                'action' => 'view',
                $project['Project']['slug'],
            ) , true);
            // Post on user facebook
            if (Configure::read('social_networking.post_project_on_user_facebook')) {
                if ($project['User']['is_facebook_register'] || $project['User']['is_facebook_connected']) {
                    $fb_message = $project['User']['username'] . ' ' . sprintf(__l('posted a new %s') , Configure::read('project.alt_name_for_project_singular_small')) . ' "' . $project['Project']['name'] . '" in' . ' ' . Configure::read('site.name');
                    $getFBReturn = $this->postOnFacebook($project, $fb_message, 0);
                }
            }
            // post on site facebook
            if (Configure::read('Project.post_project_on_facebook')) {
                $fb_message = $project['User']['username'] . ' ' . sprintf(__l('posted a new %s') , Configure::read('project.alt_name_for_project_singular_small')) . ' "' . $project['Project']['name'] . '" in' . ' ' . Configure::read('site.name');
                $getFBReturn = $this->postOnFacebook($project, $fb_message, 1);
            }
            App::import('Core', 'ComponentCollection');
            $collection = new ComponentCollection();
            App::import('Component', 'OauthConsumer');
            $this->OauthConsumer = new OauthConsumerComponent($collection);
            // post on user twitter
            if (Configure::read('social_networking.post_project_on_user_twitter')) {
                if (!empty($project['User']['twitter_access_token']) && !empty($project['User']['twitter_access_key'])) {
                    $message = $project['User']['username'] . ' ' . sprintf(__l('posted a new %s') , Configure::read('project.alt_name_for_project_singular_small')) . ' "' . $project['Project']['name'] . '" in' . ' ' . Configure::read('site.name');
                    $xml = $this->OauthConsumer->post('Twitter', $user['User']['twitter_access_token'], $user['User']['twitter_access_key'], 'https://twitter.com/statuses/update.xml', array(
                        'status' => $message
                    ));
                }
            }
            // post on site twitter
            if (Configure::read('Project.post_project_on_twitter')) {
                $message = 'via' . ' ' . '@' . Configure::read('twitter.username') . ': ' . $url . ' ' . $project['User']['username'] . ' ' . sprintf(__l('posted a new %s') , Configure::read('project.alt_name_for_project_singular_small')) . ' "' . $project['Project']['name'] . '"';
                $xml = $this->OauthConsumer->post('Twitter', Configure::read('twitter.site_user_access_token') , Configure::read('twitter.site_user_access_key') , 'https://twitter.com/statuses/update.xml', array(
                    'status' => $message
                ));
            }
        }
    }
    // Posting Project on Facebook
    public function postOnFacebook($project = null, $message = null, $admin = null)
    {
        if (!empty($project)) {
            $slug = $project['Project']['slug'];
            $image_options = array(
                'dimension' => 'normal_thumb',
                'class' => '',
                'alt' => $project['Project']['name'],
                'title' => $project['Project']['name'],
                'type' => 'jpg'
            );
            if ($admin) {
                $facebook_dest_user_id = Configure::read('facebook.page_id') ? Configure::read('facebook.page_id') : Configure::read('facebook.fb_user_id');
                $facebook_dest_access_token = Configure::read('facebook.fb_access_token');
            } else {
                if ((!empty($project['User']['fb_user_id'])) && (!empty($project['User']['fb_access_token']))) {
                    $facebook_dest_user_id = $project['User']['fb_user_id'];
                    $facebook_dest_access_token = $project['User']['fb_access_token'];
                }
            }
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.app_id') ,
                'secret' => Configure::read('facebook.fb_secrect_key') ,
                'cookie' => true
            ));
            if (empty($message)) {
                $message = $project['Project']['name'];
            }
            $image_url = Router::url('/', true) . getImageUrl('Project', $project['Attachment'], $image_options);
            $image_link = Router::url(array(
                'controller' => 'projects',
                'action' => 'view',
                'admin' => false,
                $slug
            ) , true);
            try {
                if ((!empty($facebook_dest_user_id)) && (!empty($facebook_dest_access_token))) {
                    $getPostCheck = $this->facebook->api('/' . $facebook_dest_user_id . '/feed', 'POST', array(
                        'access_token' => $facebook_dest_access_token,
                        'message' => $message,
                        'picture' => $image_url,
                        'icon' => $image_url,
                        'link' => $image_link,
                        'description' => $project['Project']['description']
                    ));
                }
            }
            catch(Exception $e) {
                return 2;
            }
        }
    }
    function getAndUpdateTrackedSteps($project_id = null, $step = '', $is_admin_approved = 0, $_data = array() , $project = array() , $approved = false)
    { 
        $tracked_steps = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'ProjectType',
                'User'
            ) ,
            'recursive' => 0
        ));
        $project_type = $tracked_steps['ProjectType']['name'];
        $old_tracked_steps_arr = array();
        $new_tracked_steps_arr = array();
        if (!empty($tracked_steps['Project']['tracked_steps'])) {
            $old_tracked_steps_arr = unserialize($tracked_steps['Project']['tracked_steps']);
            ksort($old_tracked_steps_arr);
        }
        App::import('Model', 'Projects.FormFieldStep');
        $FormFieldStep = new FormFieldStep();
		$splash = $FormFieldStep->find('count', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => $tracked_steps['Project']['project_type_id'],
                'FormFieldStep.order' => $step,
                'FormFieldStep.is_splash' => 1
            ) ,
            'recursive' => -1
        ));
		$splash_steps = $FormFieldStep->find('all', array(
			'conditions' => array(
				'FormFieldStep.project_type_id' => $tracked_steps['Project']['project_type_id'],
				'FormFieldStep.is_splash' => 1
			) ,
			'fields' => array(
				'FormFieldStep.id',
				'FormFieldStep.order',
				'FormFieldStep.name'
			) ,
			'recursive' => -1
		));
		$splash_step_count = count($splash_steps);
        if (!empty($splash_step_count)) {
            foreach($splash_steps as $splash_step) {
                if (isset($old_tracked_steps_arr[$splash_step['FormFieldStep']['order']]['private_note'])) {
                    $private_note_count = count($old_tracked_steps_arr[$splash_step['FormFieldStep']['order']]['private_note']);
                    if ($old_tracked_steps_arr[$splash_step['FormFieldStep']['order']]['is_admin_approved'] == 0) {
                        break;
                    }
                }
            }
        }
        if (empty($old_tracked_steps_arr[$step])) {
            Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'Project',
                    'action' => $project_type . 'Posted',
                    'label' => 'Step ' . $step,
                    'value' => '',
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
        }
        if (!empty($splash)) {
            if (!empty($old_tracked_steps_arr[$step])) {
                // Existing step
                if ($approved) {
                    $data['Project']['is_pending_action_to_admin'] = 0;
                }
                if ($approved && empty($is_admin_approved)) {
                    // Case: Admin rejected
                    $pending_steps_arr = $this->getAdminPendingSteps($project_id, $tracked_steps['Project']['tracked_steps']);
                    foreach($pending_steps_arr as $pending_step) {
                        if ($step == $pending_step) {
                            $old_tracked_steps_arr[$step]['is_admin_approved'] = 2;
                            $old_tracked_steps_arr[$step]['rejected_on'][] = date('Y-m-d H:i:s');
                            $old_tracked_steps_arr[$step]['private_note'][] = $_data['Project']['private_note'];
                            $old_tracked_steps_arr[$step]['information_to_user'][] = $_data['Project']['information_to_user'];
                        } else {
                            $old_tracked_steps_arr[$pending_step]['is_admin_approved'] = 2;
                        }
                    }
                    $this->postActivity($tracked_steps, ConstProjectActivities::ProjectRejected, $tracked_steps['Project']['id']);
                } elseif ($approved && !empty($is_admin_approved)) {
                    // Case: Admin approved
                    $pending_steps_arr = $this->getAdminPendingSteps($project_id, $tracked_steps['Project']['tracked_steps']);
                    foreach($pending_steps_arr as $pending_step) {
                        if ($step == $pending_step) {
                            $old_tracked_steps_arr[$step]['is_admin_approved'] = 1;
                            $old_tracked_steps_arr[$step]['private_note'][] = $_data['Project']['private_note'];
                            $old_tracked_steps_arr[$step]['approved_on'] = date('Y-m-d H:i:s');
                        } else {
                            $old_tracked_steps_arr[$pending_step]['is_admin_approved'] = 1;
                        }
                    }
                    $data['Project']['is_draft'] = 0;
                    $data['Project']['is_pending_action_to_admin'] = 0;
                    $this->getPendingSteps($project_id, $tracked_steps['Project']['project_type_id'], true);
                } elseif (!$approved) { 
                    if (!empty($project['is_pending_status']) && !empty($old_tracked_steps_arr[$step]['rejected_on'])) {
                        // Case: User resubmit after rejected
                        $old_tracked_steps_arr[$step]['submitted_on'][] = date('Y-m-d H:i:s');
                        $old_tracked_steps_arr[$step]['is_submitted'] = 1;
                        $old_tracked_steps_arr[$step]['is_admin_approved'] = 0;
                        $data['Project']['is_pending_action_to_admin'] = 1;
                    }
                }
            } else { 
                if (!empty($project['is_pending_status'])) { 
                    // Case: New record for splash step
                    $new_tracked_steps_arr[$step]['submitted_on'][] = date('Y-m-d H:i:s');
                    $new_tracked_steps_arr[$step]['is_submitted'] = 1;
                    $new_tracked_steps_arr[$step]['is_admin_approved'] = 0;
                    $data['Project']['is_pending_action_to_admin'] = 1;
                }
            }
        } else {
            // Case: New record for normal step
            if (!empty($project['is_pending_status'])) {
                $new_tracked_steps_arr = $old_tracked_steps_arr;
				if(!empty($new_tracked_steps_arr[$step]['is_admin_approved']) || isset($new_tracked_steps_arr[$step]['updated_on'])) {
	                $new_tracked_steps_arr[$step]['updated_on'][] = date('Y-m-d H:i:s');
				} else {
					$new_tracked_steps_arr[$step]['submitted_on'][] = date('Y-m-d H:i:s');
				}
            } else {
                if (!empty($old_tracked_steps_arr[$step]['submitted_on'])) {
                    $new_tracked_steps_arr[$step]['submitted_on'][] = $old_tracked_steps_arr[$step]['submitted_on'][0];
                }
                $new_tracked_steps_arr[$step]['updated_on'][] = date('Y-m-d H:i:s');
            }
            $new_tracked_steps_arr[$step]['is_submitted'] = 1;
            $new_tracked_steps_arr[$step]['is_admin_approved'] = ($splash_step_count) ? 0 : 1;
            $this->getPendingSteps($project_id, $tracked_steps['Project']['project_type_id'], false);
        }
        $merged_array = ($new_tracked_steps_arr + $old_tracked_steps_arr);
        $tracking_steps = serialize($merged_array); // merge the new and old steps and update
        $data['Project']['id'] = $project_id;
        $data['Project']['tracked_steps'] = $tracking_steps;
        $this->save($data);
        $this->getPendingSteps($project_id, $tracked_steps['Project']['project_type_id'], false);
    }
    function getAdminPendingSteps($project_id = null, $tracked_steps)
    {
		//get all submitted steps
        $pending_steps_arr = array();
        if (!empty($tracked_steps)) {
            $tracked_steps_arr = unserialize($tracked_steps);
			ksort($tracked_steps_arr);
            foreach($tracked_steps_arr as $key => $value) {
                if (!empty($value['is_submitted']) && (empty($value['is_admin_approved']) || $value['is_admin_approved'] == 2)) {
                    $pending_steps_arr[] = $key;
                }
            }
            return $pending_steps_arr;
        }
        return false;
    }

    function getPendingSteps($project_id = null, $project_type_id, $is_splash)
    {
        $tracked_steps = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'ProjectType',
                'User' => array(
                    'UserProfile'
                )
            ) ,
            'recursive' => 2
        ));
        App::import('Model', 'Projects.FormFieldStep');
        $FormFieldStep = new FormFieldStep();
        if (!empty($tracked_steps)) {
            $tracked_steps_arr = unserialize($tracked_steps['Project']['tracked_steps']);
            $approved_count = 0;
            if (!empty($tracked_steps_arr)) {
                ksort($tracked_steps_arr);
                foreach($tracked_steps_arr as $key => $value) {
                    if ($value['is_admin_approved'] == 1) {
                        $approved_count++;
                    }
                }
            }
            $formFieldSteps = $FormFieldStep->find('all', array(
                'conditions' => array(
                    'FormFieldStep.project_type_id' => $tracked_steps['Project']['project_type_id']
                ) ,
                'contain' => array(
                    'FormFieldGroup' => array(
                        'FormField'
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $is_having_payout_step = $is_having_payment_step = $is_having_reward_step = 0;
            foreach($formFieldSteps as $formFieldStep) {
                if (!empty($formFieldStep['FormFieldStep']['is_payment_step'])) {
                    $is_having_payment_step = $formFieldStep['FormFieldStep']['order'];
                }
                if (!empty($formFieldStep['FormFieldStep']['is_payout_step'])) {
                    $is_having_payout_step = $formFieldStep['FormFieldStep']['order'];
                  
                }
                foreach($formFieldStep['FormFieldGroup'] as $formFieldGroups) {
                    foreach($formFieldGroups['FormField'] as $formField) {
                        $_data = explode('.', $formField['name']);
                        if ($_data[0] == 'ProjectReward' && isPluginEnabled('ProjectRewards')) {
                            $is_having_reward_step = $formFieldStep['FormFieldStep']['order'];
                        }
                    }
                }
				$current_order = $formFieldStep['FormFieldStep']['order'];
            }
			if(empty($tracked_steps_arr[$current_order])) {
				$approved_count++;
			}

			if(Configure::read('Project.listing_fee') == 0 && empty($tracked_steps_arr[$is_having_payment_step])){
				$approved_count++;
			}else if (!empty($tracked_steps_arr[$is_having_payment_step]) && ( Configure::read('Project.listing_fee')  && $tracked_steps['Project']['is_paid'] != 1 )) {
                $approved_count--;
			}
			
            if (in_array($tracked_steps['Project']['project_type_id'], array(
                ConstProjectTypes::Donate,
            		ConstProjectTypes::Pledge
            )) &&  empty($tracked_steps_arr[$is_having_payout_step])) {
                $approved_count++;
            }

			if ($tracked_steps['Project']['project_type_id'] == ConstProjectTypes::Pledge && (empty($is_having_reward_step) ||  empty($tracked_steps_arr[$is_having_reward_step]))) {
                $approved_count++;
            }
            if ($approved_count == count($formFieldSteps)) {
                // move to open for funding or voting
                if (isPluginEnabled('Idea')) {
                    $type = 'vote';
                } else {
                    $type = 'open';
                }
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Project Created',
                        'label' => $_SESSION['Auth']['User']['username'],
                        'value' => $_SESSION['Auth']['User']['id'],
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $_SESSION['Auth']['User']['id'],
                        'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                    )
                ));
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'Project',
                        'action' => 'Created',
                        'label' => $tracked_steps['Project']['name'],
                        'value' => $project_id,
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $_SESSION['Auth']['User']['id'],
                        'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                    )
                ));
				  
                $data['project_id'] = $project_id;
                $response = Cms::dispatchEvent('Model.Project.openFunding', $this, array(
                    'data' => $data,
                    'type' => $type,
                ));
                return $response->data;
            }
        }
    }
    function getProjectPaymentStep($project_id)
    {
        $project = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'fields' => array(
                'Project.tracked_steps',
                'Project.project_type_id'
            ) ,
            'recursive' => -1
        ));
        App::import('Model', 'Projects.FormFieldStep');
        $FormFieldStep = new FormFieldStep();
        $payment_step = $FormFieldStep->find('first', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => $project['Project']['project_type_id'],
                'FormFieldStep.is_payment_step' => 1
            ) ,
            'recursive' => -1
        ));
        return $payment_step['FormFieldStep']['order'];
    }

    function validateInvestAmount($fields, $field1 = null)
    {
        if ($this->data['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            if (!empty($this->data[$this->name]['needed_amount']) && Configure::read('equity.amount_per_share')) {
                if ($this->data[$this->name]['needed_amount']%Configure::read('equity.amount_per_share') == 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    function getStepCount($project_type_id)
    {
        $tmp_projects = $this->find('list', array(
            'conditions' => array(
                'Project.project_type_id' => $project_type_id,
                'Project.is_pending_action_to_admin' => 1
            ) ,
            'fields' => array(
                'Project.id',
                'Project.tracked_steps',
            ) ,
            'recursive' => -1
        ));
        if (!empty($tmp_projects)) {
            foreach($tmp_projects as $tmp_id => $tmp_tracked_step) {
                $max_step = max(array_keys(unserialize($tmp_tracked_step)));
                if (!isset($step_count[$max_step])) {
                    $step_count[$max_step] = 1;
                } else {
                    $step_count[$max_step]++;
                }
            }
            return $step_count;
        }
    }
    function getAdminRejectApproveCount($projectTypeId, $projectStatus, $contain, $condition_field)
    {
		//Displayed the project by status
        App::import('Model', 'Projects.FormFieldStep');
        $FormFieldStep = new FormFieldStep();
        $formFieldSteps = $FormFieldStep->find('list', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => $projectTypeId,
                'FormFieldStep.is_splash' => 1
            ) ,
            'recursive' => -1
        ));
        $_data['formFieldSteps'] = $formFieldSteps;
        $rejectedCount = $approvedCount = 0;
        $rejectedProjectIds = $approvedProjectIds = array();
        if (!empty($formFieldSteps)) {
            $rejectedProjects = $this->find('all', array(
                'conditions' => array(
                    'Project.is_pending_action_to_admin' => 0,
                    'Project.project_type_id' => $projectTypeId,
                    'Project.user_id' => $_SESSION['Auth']['User']['id'],
                    $condition_field => $projectStatus
                ) ,
                'contain' => array(
                    $contain
                ) ,
                'recursive' => 0
            ));
            if (!empty($rejectedProjects)) {
                foreach($rejectedProjects as $rejectedProject) {
                    $tracked_steps_arr = unserialize($rejectedProject['Project']['tracked_steps']);
                    if (!empty($tracked_steps_arr)) {
                        ksort($tracked_steps_arr);
                        foreach($tracked_steps_arr as $key => $value) {
                            if ($value['is_admin_approved'] == 2) {
                                $rejectedCount++;
                                array_push($rejectedProjectIds, $rejectedProject['Project']['id']);
                                break;
                            }
                            if ($value['is_admin_approved'] == 1) {
                                $approvedCount++;
                                array_push($approvedProjectIds, $rejectedProject['Project']['id']);
                                break;
                            }
                        }
                    }
                }
            }
        }
        $_data['rejectedCount'] = $rejectedCount;
        $_data['approvedCount'] = $approvedCount;
        $_data['rejectedProjectIds'] = $rejectedProjectIds;
        $_data['approvedProjectIds'] = $approvedProjectIds;
        return $_data;
    }

	public function getFormFieldSteps($ProjectType, $UserId, $project_id, $page)
    {
		App::import('Model', 'Projects.FormFieldStep');
		$FormFieldStep = new FormFieldStep();
		$FormFieldSteps = $FormFieldStep->find('all', array(
			'conditions' => array('FormFieldStep.project_type_id' => $ProjectType['ProjectType']['id']),
			'contain' => array(
				'FormFieldGroup' => array(
					'conditions' => array() ,
					'FormField' => array(
						'conditions' => array(
							'FormField.is_active' => 1,
						) ,
						'order' => array(
							'FormField.order' => 'ASC'
						)
					) ,
					'order' => array(
						'FormFieldGroup.order' => 'ASC'
					)
				)
			) ,
			'order' => array(
				'FormFieldStep.order' => 'ASC'
			) ,
			'recursive' => 2
		));
		$project = $this->find('first', array(
			'conditions' => array(
				'Project.id' => $project_id
			) ,
			'recursive' => -1,
		));
		$projectStatus = array();
		$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
			'projectStatus' => $projectStatus,
			'project' => $project,
			'type' => 'status'
		));
		if(!empty($FormFieldSteps)) {
			$total_steps = count($FormFieldSteps);
			$total_groups_removed = 0;
			$total_fields_removed = 0;
			$temp_FormFieldSteps = $FormFieldSteps;
			$order = 1;
			foreach($temp_FormFieldSteps as $step_key => $FormFieldStep) { 
				if ($page == 'edit') {
					if (!empty($project['Project']['tracked_steps'])) {
						$tracked_steps_arr = unserialize($project['Project']['tracked_steps']);
						ksort($tracked_steps_arr);

						$last_step = max(array_keys(unserialize($project['Project']['tracked_steps'])));
						if (!empty($tracked_steps_arr[$last_step]['is_admin_approved']) && $response->data['projectStatus'][$project_id]['id'] != ConstEquityProjectStatus::Pending) { 
							if(!empty($FormFieldSteps[$step_key]['FormFieldStep']['is_splash'])) {
								unset($FormFieldSteps[$step_key]);
								continue;
							}
						}

						foreach($tracked_steps_arr as $key => $value) { 
							if (!empty($value['is_admin_approved']) && $value['is_admin_approved'] == 1 && (!empty($value['private_note']) || empty($value['private_note']))) { 
								if (!empty($FormFieldSteps[$key-1]['FormFieldStep']['is_splash'])) { 
									if ($FormFieldSteps[$key-1]['FormFieldStep']['order'] == $key) {
										unset($FormFieldSteps[$key-1]);
										continue;
									}
								}
								if(isset($FormFieldSteps[$key-1])) {
									if ($FormFieldSteps[$key-1]['FormFieldStep']['order'] == $key && empty($FormFieldSteps[$key-1]['FormFieldStep']['is_splash'])) { 
										if (empty($FormFieldSteps[$key-1]['FormFieldStep']['is_editable'])) {
											unset($FormFieldSteps[$key-1]);
											continue;
										}
									}
								}								
							}								
						}
					}					
				}
				if (empty($FormFieldStep['FormFieldStep']['is_splash']) && empty($FormFieldStep['FormFieldStep']['is_payment_step'])) {
					$total_groups_in_step = count($FormFieldStep['FormFieldGroup']);
					if ($total_groups_in_step == 0 && empty($FormFieldStep['FormFieldStep']['is_payout_step'])) {
						unset($FormFieldSteps[$step_key]);
						continue;
					}
					foreach($FormFieldStep['FormFieldGroup'] as $group_key => $FormFieldGroup) {
						$total_fields_in_group = count($FormFieldGroup['FormField']);
						$total_groups_removed = 0;
						if ($total_fields_in_group == 0) {
							unset($FormFieldSteps[$step_key]['FormFieldGroup'][$group_key]);
							$total_groups_removed++;
							continue;
						}
						if (($FormFieldGroup['name'] == 'Project Updates') && !isPluginEnabled('ProjectUpdates')) {
							unset($FormFieldSteps[$step_key]['FormFieldGroup'][$group_key]);
							$total_groups_removed++;
							continue;
						}
						foreach($FormFieldGroup['FormField'] as $field_key => $FormField) {
							$remove_field = 0;
							$_data = explode('.', $FormField['name']);
							if ($_data[0] == 'ProjectReward' && !isPluginEnabled('ProjectRewards')) {
								$remove_field = 1;
							}
							if (!empty($remove_field)) {
								unset($FormFieldSteps[$step_key]['FormFieldGroup'][$group_key]['FormField'][$field_key]);
								$total_fields_removed++;
							}
							if (!empty($total_fields_removed) && $total_fields_in_group == $total_fields_removed) {
								unset($FormFieldSteps[$step_key]['FormFieldGroup'][$group_key]);
								$total_groups_removed++;
								$total_fields_removed = 0;
							}
						}
					}
					if (!empty($total_groups_removed) && $total_groups_in_step == $total_groups_removed) {
						unset($FormFieldSteps[$step_key]);
						$total_groups_removed = 0;
					}
				} elseif (!empty($tmpProject['Project']['is_paid']) && !empty($FormFieldStep['FormFieldStep']['is_payment_step'])) {
					unset($FormFieldSteps[$step_key]);
				} else if (empty($FormFieldStep['FormFieldStep']['is_splash']) && !empty($FormFieldStep['FormFieldStep']['is_payment_step'])) {
					if (!Configure::read('Project.listing_fee') && ($ProjectType['ProjectType']['listing_fee'] == 0 || $ProjectType['ProjectType']['listing_fee'] == null)) {
						unset($FormFieldSteps[$step_key]);
					}
				}
				if (!empty($FormFieldStep['FormFieldStep']['is_payout_step'])) {
					if (isPluginEnabled('Sudopay')) {
						App::import('Model', 'Sudopay.Sudopay');
						$Sudopay = new Sudopay();
						$is_having_pending_gateways_connect = $Sudopay->isHavingPendingGatewayConnect($UserId);
						if (empty($is_having_pending_gateways_connect)) {
							unset($FormFieldSteps[$step_key]);
						}
					} else
					{
						unset($FormFieldSteps[$step_key]);
					}
				} 
				if (!empty($project_id)) {
					if (!empty($project['Project']['is_paid'])) {
						if (!empty($FormFieldStep['FormFieldStep']['is_payment_step'])) {
							 unset($FormFieldSteps[$step_key]);
						}
					}
				} 
			}
		} 
		$FormFieldSteps = array_values($FormFieldSteps); 
		return $FormFieldSteps;
	}
    public function getProjectNextStep($project, $page, $step_id)
    {
		$projects = $this->find('first', array(
            'conditions' => array(
                'Project.id' => $project['Project']['id']
            ) ,
            'contain' => array(
                'ProjectType',
                'User'
            ) ,
            'recursive' => 0
        ));
		$FormFieldSteps = $this->getFormFieldSteps($projects, $projects['User']['id'], $projects['Project']['id'], $page);
		if(isset($FormFieldSteps[$step_id])) {
			return true;
		} else {
			return false;
		}

	}

}
?>
