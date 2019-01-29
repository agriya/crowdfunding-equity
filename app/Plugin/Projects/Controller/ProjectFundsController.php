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
class ProjectFundsController extends AppController
{
    public $name = 'ProjectFunds';
    public $permanentCacheAction = array(
        'user' => array(
            'data',
            'add',
            'edit_fund',
            'view',
        ) ,
    );
    public function beforeFilter()
    {
        $this->Security->validatePost = false;
        parent::beforeFilter();
    }
    public function data()
    {
        $conditions = array();
        $project_funds = $this->ProjectFund->find('all', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Authorized,
                    ConstProjectFundStatus::PaidToOwner,
                    ConstProjectFundStatus::Closed,
                    ConstProjectFundStatus::DefaultFund
                ) ,
                'Project.slug' => $this->request->params['named']['project']
            ) ,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'Project',
            ) ,
            'recursive' => 1,
        ));
        $data = array();
        $i = 0;
        $user_default_image = $this->ProjectFund->Project->Attachment->find('all', array(
            'conditions' => array(
                'foreign_id' => 0,
                'class' => array(
                    'UserAvatar'
                ) ,
            ) ,
        ));
        foreach($project_funds as $project_fund) {
            if (!empty($project_fund['ProjectFund']['latitude']) && $project_fund['ProjectFund']['longitude']) {
                $image_options = array(
                    'dimension' => 'micro_thumb',
                    'class' => '',
                    'alt' => $project_fund['User']['username'],
                    'title' => $project_fund['User']['username'],
                    'type' => 'jpg'
                );
                if (empty($project_fund['User']['UserAvatar'])) {
                    $project_fund['User']['UserAvatar'] = $user_default_image[0]['Attachment'];
                }
                $user_url = Router::url(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $project_fund['User']['username']
                ) , true);
                $data[$i]['latitude'] = $project_fund['ProjectFund']['latitude'];
                $data[$i]['longitude'] = $project_fund['ProjectFund']['longitude'];
                $data[$i]['url'] = '<img src="' . Router::url('/', true) . getImageUrl('UserAvatar', $project_fund['User']['UserAvatar'], $image_options) . '" alt="'.$project_fund['User']['username'].'" /> <a href="' . $user_url . '"> ' . $project_fund['User']['username'] . '</a> ' . __l('has ' . Configure::read('project.project.alt_name_for_backer_past_tense')) . ' ' . Configure::read('site.currency') . $project_fund['ProjectFund']['amount'];
                $i++;
            }
        }
        $data['Count'] = count($data);
        $this->view = 'Json';
        $this->set('json', $data);
    }
    public function reward_update($id)
    {
        $projectFund = $this->ProjectFund->find('first', array(
            'conditions' => array(
                'ProjectFund.id' => $id
            ) ,
            'contain' => array(
                'Project'
            ) ,
            'recursive' => 0
        ));
        if (empty($projectFund) || ($projectFund['Project']['user_id'] != $this->Auth->user('id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->request->data['ProjectFund']['id'] = $id;
        $this->request->data['ProjectFund']['user_id'] = $projectFund['ProjectFund']['user_id'];
        $this->request->data['ProjectFund']['project_id'] = $projectFund['ProjectFund']['project_id'];
        $this->request->data['ProjectFund']['is_given'] = $projectFund['ProjectFund']['is_given'] ? '0' : '1';
        $this->request->data['ProjectFund']['reward_given_date'] = date('Y-m-d H:i:s');
        $this->ProjectFund->save($this->request->data, false);
        $this->ProjectFund->updateProjectRewardGivenCount($projectFund['ProjectFund']['project_id']);
        $this->autoRender = false;
        echo $this->request->data['ProjectFund']['is_given'];
        exit;
    }
    public function index()
    {
        if (empty($this->request->params['named']['project_id']) && (empty($this->request->params['named']['type']) || $this->request->params['named']['type'] != 'mydonations')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $backer = $this->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.project_id' => $this->request->params['named']['project_id'],
                    'ProjectFund.user_id' => $this->Auth->user('id') ,
                ) ,
                'recursive' => -1
            ));
            $this->set('backer', $backer);
            $project = $this->ProjectFund->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id']
                ) ,
                'contain' => array(
                    'ProjectType' => array(
                        'fields' => array(
                            'ProjectType.id',
                            'ProjectType.name',
                            'ProjectType.slug',
                            'ProjectType.funder_slug'
                        )
                    )
                ) ,
                'fields' => array(
                    'Project.project_type_id',
                    'Project.user_id',
                ) ,
                'recursive' => 0
            ));
        }
        $conditions = array();
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations' && empty($this->request->params['named']['status'])) {
            $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
            $conditions['ProjectFund.project_fund_status_id != '] = ConstProjectFundStatus::PendingToPay;
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations' && $this->request->params['named']['status'] == Configure::read('project.project.alt_name_for_backer_past_tense')) {
            $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
            $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::Authorized;
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations' && $this->request->params['named']['type'] == 'mydonations' && $this->request->params['named']['status'] == 'refunded') {
            $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
            $conditions['ProjectFund.project_fund_status_id'] = array(
                ConstProjectFundStatus::Expired,
                ConstProjectFundStatus::Canceled
            );
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations' && $this->request->params['named']['status'] == 'paid') {
            $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
            $conditions['ProjectFund.project_fund_status_id'] = ConstProjectFundStatus::PaidToOwner;
        } else {
            $conditions['ProjectFund.project_id'] = $this->request->params['named']['project_id'];
            $conditions['ProjectFund.project_fund_status_id'] = array(
                ConstProjectFundStatus::Authorized,
                ConstProjectFundStatus::PaidToOwner,
                ConstProjectFundStatus::Closed,
                ConstProjectFundStatus::DefaultFund
            );
        }
        if (!empty($this->request->params['named']['filter'])) {
            switch ($this->request->params['named']['filter']) {
                case 'given':
                    $conditions['ProjectFund.is_given'] = 1;
                    break;

                case 'not_given':
                    $conditions['ProjectFund.project_reward_id !='] = 0;
                    $conditions['ProjectFund.is_given'] = 0;
                    break;
            }
        }
        $backer = 0;
        $limit = 5;
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations') {
            $limit = 10;
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'mydonations') {
            $this->set('fund_count', $this->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.user_id' => $this->Auth->user('id') ,
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                )
            )));
            /// Status Based on Count
            $this->set('backed_count', $this->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.user_id' => $this->Auth->user('id') ,
                    'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized
                ) ,
                'recursive' => 0
            )));
            $this->set('refunded_count', $this->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.user_id = ' => $this->Auth->user('id') ,
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Expired,
                        ConstProjectFundStatus::Canceled
                    )
                ) ,
                'recursive' => 0
            )));
            $this->set('paid_count', $this->ProjectFund->find('count', array(
                'conditions' => array(
                    'ProjectFund.project_fund_status_id' => array(
                        ConstProjectFundStatus::Authorized,
                        ConstProjectFundStatus::PaidToOwner,
                        ConstProjectFundStatus::Closed,
                        ConstProjectFundStatus::DefaultFund
                    ) ,
                    'ProjectFund.user_id = ' => $this->Auth->user('id') ,
                ) ,
                'recursive' => 0
            )));
        }
        $this->pageTitle = sprintf(__l('%s Funds') , Configure::read('project.alt_name_for_project_singular_caps'));
        $contain = array(
            'User' => array(
                'UserAvatar'
            ) ,
            'Project' => array(
                'User',
                'ProjectType',
            )
        );
        if (isPluginEnabled('ProjectRewards') && !empty($this->request->params['named']['project_id'])) {
            $this->set('is_show_reward_filter', $this->ProjectFund->ProjectReward->find('count', array(
                'conditions' => array(
                    'ProjectReward.project_id' => $this->request->params['named']['project_id']
                ) ,
                'recursive' => -1
            )));
        }
        if (isPluginEnabled('Pledge') && ((!empty($this->request->params['named']['project_type']) && $this->request->params['named']['project_type'] == 'Pledge') || (!empty($project) && $project['Project']['project_type_id'] == ConstProjectTypes::Pledge))) {
            $contain['PledgeFund'] = array(
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                    )
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.id',
                        'State.name',
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.name',
                        'Country.iso_alpha2'
                    )
                )
            );
            if (isPluginEnabled('ProjectRewards')) {
                $contain['ProjectReward'] = array(
                    'fields' => array(
                        'ProjectReward.reward',
                        'ProjectReward.is_shipping',
                        'ProjectReward.additional_info_label',
                    )
                );
            }
        }
        if (!empty($this->request->params['named']['backer_view']) && ($this->request->params['named']['backer_view'] == 'compact') && $this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
            if (Configure::read('site.friend_ids')) {
                $conditions['NOT']['ProjectFund.user_id'] = Configure::read('site.friend_ids');
            }
        }
        if (!empty($this->request->params['named']['reward_id'])) {
            $conditions['ProjectFund.project_reward_id'] = $this->request->params['named']['reward_id'];
        }
        $paging_array = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
            'order' => array(
                'ProjectFund.id' => 'desc'
            )
        );
        $total_backe = $this->ProjectFund->find('count', array(
            'conditions' => $conditions
        ));
        $this->set('total_backe', $total_backe);
        if (!empty($limit)) {
            $paging_array['limit'] = $limit;
        }
        $this->paginate = $paging_array;
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = array();
            Cms::dispatchEvent('Controller.ProjectFund.listing', $this, array(
                'data' => $event_data
            ));
        }
        $this->set('projectFunds', $this->paginate());
        if ($this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
            unset($conditions['NOT']);
            if (!Configure::read('site.friend_ids')) {
                $conditions['ProjectFund.user_id'] = 0;
            } else {
                $conditions['ProjectFund.user_id'] = array_values(Configure::read('site.friend_ids'));
            }
            $projectFundFriends = $this->ProjectFund->find('all', array(
                'conditions' => $conditions,
                'contain' => $contain,
                'recursive' => 2,
                'order' => array(
                    'ProjectFund.id' => 'desc'
                ) ,
                'limit' => $limit
            ));
            if (!empty($limit)) {
                $paging_array['limit'] = $limit;
            }
            $this->set('projectFundFriends', $projectFundFriends);
        } else {
            $projectFundFriends = array();
            $this->set('projectFundFriends', $projectFundFriends);
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $project = $this->ProjectFund->Project->find('first', array(
                'conditions' => array(
                    'Project.id = ' => $this->request->params['named']['project_id']
                ) ,
                'contain' => array(
                    'ProjectType' => array(
                        'fields' => array(
                            'ProjectType.id',
                            'ProjectType.name',
                            'ProjectType.slug',
                            'ProjectType.funder_slug'
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            $this->set('project', $project);
        }
        unset($conditions['ProjectFund.is_given']);
        unset($conditions['ProjectFund.user_id']);
        unset($conditions['ProjectFund.project_reward_id !=']);
        $this->set('all_count', $this->ProjectFund->find('count', array(
            'conditions' => $conditions
        )));
        $conditions['ProjectFund.is_given'] = 1;
        $this->set('given_count', $this->ProjectFund->find('count', array(
            'conditions' => $conditions
        )));
        $conditions['ProjectFund.is_given'] = 0;
        $conditions['ProjectFund.project_reward_id !='] = 0;
        $this->set('not_given_count', $this->ProjectFund->find('count', array(
            'conditions' => $conditions
        )));
        $this->set($conditions);
        
        if (!$this->RequestHandler->prefers('json')) {
            if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'mydonations') {
                $this->autoRender = false;
                $this->render('mydonations');
            }
            if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'backers') {
                $this->autoRender = false;
                $this->set('project_type', !empty($project_type) ? $project_type : '');
                $this->render('backers');
            }
        }
    }
    public function add($project_id = null)
    {
		if(empty($this->request->data['ProjectFund'])){
		   Cms::dispatchEvent('Controller.ProjectFund.beforeProjectFundStart', $this, array(
				'project_id' => $project_id
			));
		}
        if (is_null($project_id) && empty($this->request->data['ProjectFund'])) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
            } else {
                throw new NotFoundException(__l('Invalid request'));   
            }
        }
        if (!empty($this->request->data['ProjectFund']['project_id'])) {
            $project_id = $this->request->data['ProjectFund']['project_id'];
        }
        if ($this->RequestHandler->prefers('json')) {
            if (!empty($this->request->data)) {
                $this->request->data['Sudopay'] = $this->request->data;
            }
        }
        if (!empty($this->request->data)) {
            $this->request->data['ProjectFund']['sudopay_gateway_id'] = 0;
            if($this->RequestHandler->prefers('json')) {
                $this->request->data['ProjectFund']['amount'] = $this->request->data['amount'];
                $this->request->data['ProjectFund']['project_id'] = $project_id;
                $this->request->data['ProjectFund']['project_reward'] = !empty($this->request->data['project_reward']) ? $this->request->data['project_reward'] : "";
                $this->request->data['ProjectFund']['project_reward_id'] = !empty($this->request->data['project_reward']) ? $this->request->data['project_reward'] : 0;
                $this->request->data['ProjectFund']['is_anonymous'] = $this->request->data['is_anonymous'];
                $this->request->data['ProjectFund']['payment_gateway_id'] = $this->request->data['payment_gateway_id'];
            }
            if ($this->request->data['ProjectFund']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['ProjectFund']['payment_gateway_id'], 'sp_') >= 0) {
                $this->request->data['ProjectFund']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['ProjectFund']['payment_gateway_id']);
                $this->request->data['ProjectFund']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
            }
        }
        $contain = array(
            'Attachment',
            'User',
            'ProjectType',
            'Country' => array(
                'fields' => array(
                    'Country.name',
                    'Country.iso_alpha2'
                )
            ) ,
            'City' => array(
                'fields' => array(
                    'City.name',
                    'City.slug'
                )
            )
        );
        if (isPluginEnabled('ProjectRewards')) {
            $contain['ProjectReward'] = array(
                'order' => array(
                    'ProjectReward.pledge_amount' => 'asc'
                )
            );
        }
        $project = $this->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id,
                'Project.is_admin_suspended' => 0,
                'Project.is_active' => 1,
            ) ,
            'contain' => $contain,
            'recursive' => 1
        ));
        if (empty($project)) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if ($project['Project']['user_id'] == $this->Auth->user('id') and !Configure::read('Project.is_allow_owner_fund_own_project')) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" =>sprintf(__l('You cannot fund your own %s') , Configure::read('project.alt_name_for_project_singular_small')) , "error" => 1));
            } else {
                $this->Session->setFlash(sprintf(__l('You cannot fund your own %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug']
                ));
            }
        }
        $projects_count = $this->ProjectFund->Project->find('count', array(
            'conditions' => array(
                'Project.user_id' => $this->Auth->User('id')
            ) ,
            'recursive' => -1
        ));
        if ($projects_count and $project['Project']['user_id'] != $this->Auth->user('id') and !Configure::read('Project.is_allow_owners_to_fund_other_projects')) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" =>sprintf(__l('You cannot fund %s') , Configure::read('project.alt_name_for_project_plural_small')), "error" => 1));
            } else {
                $this->Session->setFlash(sprintf(__l('You cannot fund %s') , Configure::read('project.alt_name_for_project_plural_small')) , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug']
                ));
            }
        }
        if (strtotime(date('Y-m-d 23:59:59', strtotime($project['Project']['project_end_date']))) <= time()) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" =>sprintf(__l('%s has been closed') , Configure::read('project.alt_name_for_project_singular_caps')) , "error" => 1));
            } else {
                $this->Session->setFlash(sprintf(__l('%s has been closed') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug']
            ));
            }
        }
        $response = Cms::dispatchEvent('Controller.ProjectFunds.beforeAdd', $this, array(
            'data' => $project
        ));
        Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'ProjectFund',
                'action' => 'Fund',
                'label' => 'Step 1',
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'pd' => $project['Project']['id'],
                'ud' => $this->Auth->user('id') ,
                'rud' => $this->Auth->user('referred_by_user_id') ,
            )
        ));
        if (!empty($response->data['error'])) {
            if ($this->RequestHandler->prefers('json')) {
                $this->set('iphone_response', array("message" => $response->data['error'] , "error" => 1));
            } else {
                $this->Session->setFlash($response->data['error'], 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug']
                ));
            }
        }
        $this->pageTitle = $project['Project']['name'] . ' - ' . Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_singular_caps');
        if (!empty($this->request->data)) {
            $this->ProjectFund->create();
            if (!empty($this->request->data['ProjectFund']['project_reward_id']) && $this->request->data['ProjectFund']['project_reward_id'] == '-1') {
                $this->request->data['ProjectFund']['project_reward_id'] = 0;
                unset($this->ProjectFund->validate['address']);
                unset($this->ProjectFund->validate['zip_code']);
            }
            if (!empty($this->request->data['ProjectFund']['project_reward_id']) && $this->request->data['ProjectFund']['project_reward_id'] == '0') {
                unset($this->ProjectFund->validate['address']);
                unset($this->ProjectFund->validate['zip_code']);
            }
            if (!empty($this->request->data['ProjectFund']['project_reward_id']) && empty($project['ProjectReward']['is_shipping'])) {
                unset($this->ProjectFund->validate['address']);
                unset($this->ProjectFund->validate['zip_code']);
            }
            $this->ProjectFund->set($this->request->data);
            $this->request->data['ProjectFund']['user_id'] = $this->Auth->user('id');
            $fund_commission_percentage = (is_null($project['ProjectType']['commission_percentage'])) ? Configure::read('Project.fund_commission_percentage') : $project['ProjectType']['commission_percentage'];
            $this->request->data['ProjectFund']['site_fee'] = round($this->request->data['ProjectFund']['amount']*($fund_commission_percentage/100) , 2);
            $this->request->data['ProjectFund']['is_delayed_chained_payment'] = 0;
            if($this->RequestHandler->prefers('json')) {
                $this->request->data['ProjectFund']['project_id'] = $project['Project']['id'];
            }
            $response1 = Cms::dispatchEvent('Controller.ProjectFunds.beforeValidation', $this, array(
                'data' => $this->request->data
            ));
            
            if ($this->ProjectFund->validates() && empty($response1->data['error'])) {
                $this->request->data['ProjectFund']['project_type_id'] = $project['Project']['project_type_id'];
                $this->request->data['ProjectFund']['owner_user_id'] = $project['Project']['user_id'];
                Cms::dispatchEvent('Controller.ProjectFund.beforeAdd', $this, array(
                    'data' => $this->request->data
                ));
                $this->ProjectFund->save($this->request->data);
                $project_fund_id = $this->request->data['ProjectFund']['item_id'] = $this->ProjectFund->id;
                $this->request->data['ProjectFund']['id'] = $this->ProjectFund->id;
                $response = Cms::dispatchEvent('Controller.ProjectFunds.afterAdd', $this, array(
                    'data' => $this->request->data
                ));
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'ProjectFund',
                        'action' => 'Fund',
                        'label' => 'Step 2',
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'pfd' => $project_fund_id,
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $projectFund = $this->ProjectFund->find('first', array(
                    'conditions' => array(
                        'ProjectFund.id' => $this->ProjectFund->id
                    ) ,
                    'contain' => array(
                        'Project',
                        'ProjectType',
                    ) ,
                    'recursive' => 0
                ));
                if ($this->request->data['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::Wallet and isPluginEnabled('Wallet')) {
                    $this->loadModel('Wallet.Wallet');
                    $return = $this->Wallet->processOrder($this->Auth->user('id') , $this->request->data['ProjectFund']);
                    if (!$return) {
                        if ($this->RequestHandler->prefers('json')) {
                            $this->set('iphone_response', array("message" => __l('Your wallet has insufficient money') , "error" => 1));
                        } else {
                            $this->Session->setFlash(__l('Your wallet has insufficient money') , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'project_funds',
                                'action' => 'add',
                                $project_id,
                                'payment_gateway_id' => ConstPaymentGateways::Wallet,
                            ));
                        }
                    }
                    $this->Session->setFlash(sprintf(__l('You have %s successfully') , Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_past_tense_small')) , 'default', null, 'success');
                    if ($this->RequestHandler->prefers('json')) {
                        $this->set('iphone_response', array("message" => sprintf(__l('You have %s successfully') , Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_past_tense_small')), "error" => 0));
                    } else {
                        if (isPluginEnabled('SocialMarketing')) {
                            $share = 1;
                            $projectStatus = array();
                            $response = Cms::dispatchEvent('Controller.ProjectType.GetProjectStatus', $this, array(
                                'projectStatus' => $projectStatus,
                                'project' => $projectFund,
                                'type' => 'status'
                            ));
                            if (empty($response->data['is_allow_to_share'])) {
                                $share = 0;
                            }
                            
                            if (!empty($share)) {
                                $this->redirect(array(
                                    'controller' => 'social_marketings',
                                    'action' => 'publish',
                                    $this->ProjectFund->id,
                                    'type' => 'facebook',
                                    'publish_action' => 'fund',
                                    'admin' => false
                                ));
                            }
                        }
                        $this->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $projectFund['Project']['slug']
                        ));
                    }
                } else if ($this->request->data['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                    $this->loadModel('Sudopay.Sudopay');
                    $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                    $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                    if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                        $sudopay_data = $this->Sudopay->getSudoPayPostData($project_fund_id, ConstPaymentType::PledgeCapture);
                        $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                        $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                        $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                        $sudopay_data['action'] = 'marketplace-auth';
                        if ($project['Project']['project_type_id'] == ConstProjectTypes::Donate) {
                            $sudopay_data['action'] = 'marketplace-capture';
                        }
                        $this->set('sudopay_data', $sudopay_data);
                    } else {
                        $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
                        
                        if ($this->RequestHandler->prefers('json')) 
                        {  
                            $call_back_url = $this->Sudopay->processPayment($project_fund_id, ConstPaymentType::PledgeCapture,  $this->request->data['Sudopay'],'json');
                        }else{
                            $call_back_url = $this->Sudopay->processPayment($project_fund_id, ConstPaymentType::PledgeCapture, $this->request->data['Sudopay']);
                        }
                        if(!is_array($call_back_url)){
                            $this->set('iphone_response', array("message" => $call_back_url, "error" => 0));
                        }else{
                            $return = $call_back_url;
                        }
                        
                        $redirect = 0;
			if (!empty($return['pending'])) {
                            if ($this->RequestHandler->prefers('json')) {
                                $this->set('iphone_response', array("message" => __l('Your payment is in pending.'), "error" => 0));
                            }
                            $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                            $redirect = 1;
                        } elseif (!empty($return['success'])) {
                            $this->ProjectFund->updateStatus($projectFund['ProjectFund']['id'], ConstProjectFundStatus::Backed, ConstPaymentGateways::SudoPay);
                            if ($this->RequestHandler->prefers('json')) {
                                $this->set('iphone_response', array("message" => sprintf(__l('You have successfully %s') , Configure::read('project.alt_name_for_' . $projectFund['ProjectType']['slug'] . '_singular_caps')), "error" => 0));
                            }
                            $this->Session->setFlash(sprintf(__l('You have successfully %s') , Configure::read('project.alt_name_for_' . $projectFund['ProjectType']['slug'] . '_singular_caps')) , 'default', null, 'success');
                            $redirect = 1;
                        } elseif (!empty($return['error'])) {
                            if ($this->RequestHandler->prefers('json')) {
                                $this->set('iphone_response', array("message" => $return['error_message'] . '. ' . __l('Your payment could not be completed.'), "error" => 1));
                            }
                            $this->Session->setFlash($return['error_message'] . '. ' . __l('Your payment could not be completed.') , 'default', null, 'error');
                        }
                        if (!$this->RequestHandler->prefers('json')) {
                            if (!empty($redirect)) {
                                                            if (isPluginEnabled('SocialMarketing')) {
                                                                    $share = 1;
                                                                            $projectStatus = array();
                                                                            $response = Cms::dispatchEvent('Controller.ProjectType.GetProjectStatus', $this, array(
                                                                                    'projectStatus' => $projectStatus,
                                                                                    'project' => $projectFund,
                                                                                    'type' => 'status'
                                                                            ));
                                                                            if (empty($response->data['is_allow_to_share'])) {
                                                                                    $share = 0;
                                                                            }
                                                                    if (!empty($share)) {
                                                                            $this->redirect(array(
                                                                                    'controller' => 'social_marketings',
                                                                                    'action' => 'publish',
                                                                                    $this->ProjectFund->id,
                                                                                    'type' => 'facebook',
                                                                                    'publish_action' => 'fund',
                                                                                    'admin' => false
                                                                            ));
                                                                    }
                                                            }
                                $this->redirect(array(
                                    'controller' => 'projects',
                                    'action' => 'view',
                                    $project['Project']['slug'],
                                ));
                            }
                        }
                    }
                }
            } else {
                if (!empty($this->ProjectFund->validationErrors['project_reward_id'])) {
                    $this->ProjectFund->validationErrors['project_reward'] = $this->ProjectFund->validationErrors['project_reward_id'];
                    unset($this->ProjectFund->validationErrors['project_reward_id']);
                    unset($this->request->data['ProjectFund']['project_reward']);
                }
                if (empty($this->ProjectFund->validationErrors['amount']) and !empty($response->data['error']['amount'])) {
                    $this->ProjectFund->validationErrors['amount'] = $response->data['error']['amount'];
                }
                if (empty($this->ProjectFund->validationErrors['amount']) and !empty($response1->data['error']['amount'])) {
                    $this->ProjectFund->validationErrors['amount'] = $response1->data['error']['amount'];
                }
                if (!empty($response->data['error']['address'])) {
                    $this->ProjectFund->validationErrors['address'] = $response->data['error']['address'];
                }
                if (!empty($response->data['error']['zip_code'])) {
                    $this->ProjectFund->validationErrors['zip_code'] = $response->data['zip_code'];
                }

                if ($this->RequestHandler->prefers('json')) {
                    $this->set('iphone_response', array("message" => !empty($response1->data['error']['amount']) ? $response1->data['error']['amount'] : __l('Problem in funding.'), "error" => 1));
                }
		$this->request->data['Sudopay']['credit_card_number'] = '';
	        $this->request->data['Sudopay']['credit_card_expire'] = '';
	        $this->request->data['Sudopay']['credit_card_name_on_card'] = '';
	        $this->request->data['Sudopay']['credit_card_code'] =  '';
	        $this->request->data['Sudopay']['payment_note'] = '';
                $this->Session->setFlash(!empty($response1->data['error']['amount']) ? $response1->data['error']['amount'] : __l('Problem in funding.') , 'default', null, 'error');
            }
        }
        $this->request->data['ProjectFund']['project_id'] = $project_id;
        if (!empty($this->request->params['named']['project_reward_id'])) {
            $this->request->data['ProjectFund']['project_reward'] = $this->request->params['named']['project_reward_id'];
            $this->request->data['ProjectFund']['project_reward_id'] = $this->request->params['named']['project_reward_id'];
            $project_reward = $this->ProjectFund->ProjectReward->find('first', array(
                'conditions' => array(
                    'ProjectReward.id' => $this->request->params['named']['project_reward_id']
                ) ,
                'fields' => array(
                    'ProjectReward.pledge_amount'
                ) ,
                'recursive' => -1
            ));
            if (!empty($project_reward)) {
                $this->request->data['ProjectFund']['amount'] = $project_reward['ProjectReward']['pledge_amount'];
            }
        }
        if (!empty($response->data['pledge']) && $response->data['pledge']['Pledge']['pledge_type_id'] == ConstPledgeTypes::Fixed) {
            $this->request->data['ProjectFund']['amount'] = $response->data['pledge']['Pledge']['min_amount_to_fund'];
        }
        $radio_options = array(
            ConstAnonymous::None => __l('Visible') ,
            ConstAnonymous::Username => __l('Show your amount, but hide the name') ,
            ConstAnonymous::FundedAmount => __l('Show your name, but hide the amount') ,
            ConstAnonymous::Both => __l('Anonymous')
        );
        $countries = $this->ProjectFund->Project->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            )
        ));
        $this->set(compact('project', 'radio_options', 'countries'));
        $this->set('response_data', $response->data);
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.ProjectFund.Add', $this, array());
        }
    }
    public function fetch_project_rewards($project_id = null)
    {
        App::import('Model', 'Projects.ProjectReward');
        $this->ProjectReward = new ProjectReward();
        $projectRewards = $this->ProjectReward->find('all', array(
            'conditions' => array(
                'ProjectReward.project_id' => $project_id
            ) ,
            'recursive' => -1
        ));
        $event_data = array();
        foreach($projectRewards as $projectReward){
           $event_data['ProjectReward']['id'][] = $projectReward['ProjectReward']['id'];
           $event_data['ProjectReward']['pledge_amount'][] = '$'.$projectReward['ProjectReward']['pledge_amount'];
        }
        if ($this->RequestHandler->prefers('json')) {
            Cms::dispatchEvent('Controller.ProjectFund.RewardsList', $this, array('data' => $event_data));
        }
    }
    public function edit_fund()
    {
        if (empty($this->request->params['named']['type']) or empty($this->request->params['named']['project_fund'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->request->data['ProjectFund']['id'] = $this->request->params['named']['project_fund'];
        if ($this->request->params['named']['type'] == 'cancel') {
            $this->request->data['ProjectFund']['project_fund_status_id'] = ConstProjectFundStatus::Canceled;
        }
        $this->loadModel('Payment');
        $projectFund = $this->ProjectFund->find('first', array(
            'conditions' => array(
                'ProjectFund.id' => $this->request->params['named']['project_fund']
            ) ,
            'contain' => array(
                'Project',
                'User',
                'ProjectType'
            ) ,
            'recursive' => 0
        ));
        if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Expired || $projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Canceled) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->request->data['ProjectFund']['canceled_by_user_id'] = ConstPledgeCanceledBy::Admin;
        } elseif ($projectFund['Project']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['ProjectFund']['canceled_by_user_id'] = ConstPledgeCanceledBy::Owner;
        } else {
            $this->request->data['ProjectFund']['canceled_by_user_id'] = ConstPledgeCanceledBy::Backer;
        }
        $this->request->data['ProjectFund']['project_id'] = $projectFund['ProjectFund']['project_id'];
        $this->request->data['ProjectFund']['user_id'] = $projectFund['ProjectFund']['user_id'];
        $return = $this->ProjectFund->updateStatus($this->request->data['ProjectFund']['id'], ConstProjectFundStatus::Refunded);
        if (isPluginEnabled('Equity')) {
            App::import('Model', 'Equity.EquityFund');
            $this->Equity = new Equity();
            $this->Equity->onProjectFundCancellation($this->request->data);
        }
        if (empty($return['error'])) {
            $this->ProjectFund->save($this->request->data, false);
            $this->Session->setFlash(sprintf(__l('%s Fund has been canceled') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('%s Fund could not be canceled. Please, try again.') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
        }
        if (!empty($this->request->params['named']['return_page'])) {
            if ($this->request->params['named']['return_page'] == 'admin') {
                $this->redirect(array(
                    'controller' => Inflector::pluralize($projectFund['ProjectType']['slug']) ,
                    'action' => 'funds',
                    'admin' => true,
                ));
            } else {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'dashboard',
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'projects',
                'action' => 'view',
                $projectFund['Project']['slug'] . '#backers'
            ));
        }
    }
    public function admin_index()
    {
        if (empty($this->request->params['named']['project_type'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectType = $this->ProjectFund->Project->ProjectType->find('first', array(
            'conditions' => array(
                'ProjectType.slug' => $this->request->params['named']['project_type']
            ) ,
            'recursive' => -1
        ));
        $this->set('projectType', $projectType);
        $this->pageTitle = sprintf(__l('%s %s Funds') , $projectType['ProjectType']['name'], Configure::read('project.alt_name_for_project_singular_caps'));
        if (!empty($this->request->params['named']['type'])) {
            $this->set('type', $this->request->params['named']['type']);
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $this->set('project_id', $this->request->params['named']['project_id']);
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFund->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Fund') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function view($id = null)
    {
        $this->pageTitle = sprintf(__l('%s Voucher') , Configure::read('project.alt_name_for_reward_singular_caps'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions['ProjectFund.id'] = $id;
        $conditions['ProjectFund.project_fund_status_id'] = array(
            ConstProjectFundStatus::Authorized,
            ConstProjectFundStatus::PaidToOwner,
            ConstProjectFundStatus::Closed,
            ConstProjectFundStatus::DefaultFund
        );
        $contain = array(
            'Project' => array(
                'ProjectType',
                'User'
            ) ,
            'User' => array(
                'UserAvatar'
            ) ,
        );
        if (isPluginEnabled('ProjectRewards')) {
            $contain['ProjectReward'] = array();
        }
        $projectFund = $this->ProjectFund->find('first', array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 2
        ));
        if (empty($projectFund) || ($projectFund['Project']['User']['id'] != $this->Auth->user('id') && $projectFund['ProjectFund']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (empty($projectFund['ProjectFund']['project_reward_id'])) {
            $this->Session->setFlash(sprintf(__l('No %s selected') , Configure::read('project.alt_name_for_reward_plural_small')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'projects',
                'action' => 'view',
                $projectFund['Project']['slug']
            ));
        }
        $projectStatus = array();
        $response = Cms::dispatchEvent('Controller.ProjectType.GetProjectStatus', $this, array(
            'projectStatus' => $projectStatus,
            'project' => $projectFund,
            'type' => 'status'
        ));
        if (empty($response->data['is_allow_to_print_voucher'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('projectFund', $projectFund);
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print') {
            $this->layout = 'print';
        }
    }
    public function check_qr()
    {
        if (!empty($this->request->data)) {
            $coupon_code = $this->request->data['ProjectFund']['coupon_code'];
            $unique_coupon_code = $this->request->data['ProjectFund']['unique_coupon_code'];
        } else {
            $fund_id = $this->request->params['pass'][0];
            $projectFund_detail = $this->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $fund_id
                ) ,
                'contain' => array(
                    'Project',
                    'User',
                ) ,
                'recursive' => 1
            ));
            $coupon_code = $projectFund_detail['ProjectFund']['coupon_code'];
            $unique_coupon_code = $this->request->params['pass'][1];
        }
        if (is_null($coupon_code) || is_null($unique_coupon_code)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Voucher');
        $conditions['ProjectFund.coupon_code'] = $coupon_code;
        $conditions['ProjectFund.unique_coupon_code'] = $unique_coupon_code;
        $projectFund = $this->ProjectFund->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'Project',
                'User',
            ) ,
            'recursive' => 1
        ));
        if (empty($projectFund)) {
            $this->Session->setFlash(__l('Invalid voucher code') , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::User && $this->Auth->user('id') != $projectFund['ProjectFund']['user_id'] && $this->Auth->user('id') != $projectFund['Project']['user_id']) {
            $this->Session->setFlash(__l('You don\'t have rights to view this page') , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
        if ($projectFund['ProjectFund']['is_given'] == 1) {
            $this->Session->setFlash(sprintf(__l('%s was given already') , Configure::read('project.alt_name_for_reward_singular_caps')) , 'default', null, 'error');
        }
        if (!empty($this->request->data)) {
            $project_fund_data['ProjectFund']['is_given'] = 1;
            $project_fund_data['ProjectFund']['id'] = $projectFund['ProjectFund']['id'];
            $project_fund_data['ProjectFund']['user_id'] = $projectFund['ProjectFund']['user_id'];
            $project_fund_data['ProjectFund']['project_id'] = $projectFund['ProjectFund']['project_id'];
            $project_fund_data['ProjectFund']['reward_given_date'] = date('Y-m-d H:i:s');
            if ($this->ProjectFund->save($project_fund_data)) {
                $projectFund['ProjectFund']['is_given'] = 1;
                $this->Session->setFlash(sprintf(__l('%s was marked as given successfully') , Configure::read('project.alt_name_for_reward_singular_caps')) , 'default', null, 'success');
            }
        }
        $this->request->data['ProjectFund']['id'] = $projectFund['ProjectFund']['id'];
        $this->request->data['ProjectFund']['coupon_code'] = $coupon_code;
        $this->request->data['ProjectFund']['unique_coupon_code'] = $unique_coupon_code;
        $this->set('projectFund', $projectFund);
    }
    public function order($id)
    {
        $this->pageTitle = __l('Order');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contain = array(
            'Project' => array(
                'Attachment',
                'User',
            ) ,
            'User' => array(
                'UserAvatar'
            ) ,
        );
        if (isPluginEnabled('ProjectRewards')) {
            $contain['ProjectReward'] = array();
        }
        $itemDetail = $this->ProjectFund->find('first', array(
            'conditions' => array(
                'ProjectFund.id = ' => $id
            ) ,
            'contain' => $contain,
            'recursive' => 2,
        ));
        $this->pageTitle.= ' - ' . $itemDetail['Project']['name'];
        if (empty($itemDetail) || (!empty($itemDetail) && $itemDetail['ProjectFund']['user_id'] != $this->Auth->user('id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $gateway_fee = 0; // gateway fee is now not collected from user
        $total_amount = round($itemDetail['ProjectFund']['amount']+$gateway_fee, 2);
        $this->set('total_amount', $total_amount);
        $this->set('itemDetail', $itemDetail);
        $this->request->data['ProjectFund']['item_id'] = $id;
    }
    public function process_order()
    {
        $this->autoRender = false;
        if (empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            $contain = array(
                'Project'
            );
            if (isPluginEnabled('ProjectRewards')) {
                $contain['ProjectReward'] = array();
            }
            $projectfund = $this->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $this->request->data['ProjectFund']['item_id']
                ) ,
                'contain' => $contain,
                'recursive' => 1
            ));
            if ($this->request->data['ProjectFund']['payment_gateway_id'] == ConstPaymentGateways::Wallet and isPluginEnabled('Wallet')) {
                $this->loadModel('Wallet.Wallet');
                $return = $this->Wallet->processOrder($this->Auth->user('id') , $this->request->data['ProjectFund']);
                if (!$return) {
                    $this->Session->setFlash(__l('Your wallet has insufficient money') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'project_funds',
                        'action' => 'order',
                        $projectfund['ProjectFund']['id'],
                        'payment_gateway_id' => ConstPaymentGateways::Wallet,
                    ));
                }
                $this->Session->setFlash(__l('Your payment is successful.') , 'default', null, 'success');
                $project = $this->ProjectFund->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $projectfund['ProjectFund']['project_id']
                    ) ,
                    'fields' => array(
                        'Project.slug',
                    ) ,
                    'recursive' => -1
                ));
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug']
                ));
            }
        }
    }
}
?>