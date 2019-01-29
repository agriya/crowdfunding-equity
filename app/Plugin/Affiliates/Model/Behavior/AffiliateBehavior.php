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
class AffiliateBehavior extends ModelBehavior
{
    function afterSave(Model $model, $created) 
    {
        if (isPluginEnabled('Affiliates')) {
            $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
            if (isset($affiliate_model)) {
                if ($model->alias == 'ProjectFund' || array_key_exists($model->alias, $affiliate_model)) {
                    if ($created) {
                        $this->__createAffiliate($model);
                    } else {
                        $this->__updateAffiliate($model);
                    }
                }
            }
        }
    }
    function __createAffiliate(&$model) 
    {
        App::import('Core', 'Cookie');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $cookie = new CookieComponent($collection);
        $referred_by_user_id = $cookie->read('referrer');
        $this->User = $this->__getparentClass('User');
        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        if ($model->name == 'User') {
            // referred count update
            if (!empty($referred_by_user_id)) {
                $this->User->updateAll(array(
                    'User.referred_by_user_count' => 'User.referred_by_user_count + 1'
                ) , array(
                    'User.id' => $referred_by_user_id
                ));
            }
            if ($this->__CheckAffiliateUSer($referred_by_user_id)) {
                $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['User']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => -1
                ));
                $affiliate_commision_amount = 0;
                if (!empty($affiliateType)) {
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = (Configure::read('User.signup_fee') *$affiliateType['AffiliateType']['commission']) /100;
                    } else {
                        $affiliate_commision_amount = $affiliateType['AffiliateType']['commission'];
                    }
                }
                if (!empty($affiliate_commision_amount)) {
                    $user = $model->find('first', array(
                        'conditions' => array(
                            'id' => $model->id
                        ) ,
                        'recursive' => -1
                    ));
                    $affiliate['Affiliate']['class'] = 'User';
                    $affiliate['Affiliate']['foreign_id'] = $model->id;
                    $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['User'];
                    $affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
                    if ($user['User']['is_active']) {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                    } else {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    }
                    $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                    $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    $this->__saveAffiliate($affiliate);
                }
            }
        } else if ($model->name == 'Project') {
            $this->Project = $this->__getparentClass('Projects.Project');
            $project = $this->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $model->id
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            if (!empty($project['User']['referred_by_user_id'])) {
                $referred_by_user_id = $project['User']['referred_by_user_id'];
            }
            if (!empty($referred_by_user_id) && $this->__CheckAffiliateUSer($referred_by_user_id)) {
                if (Configure::read('affiliate.commission_on_every_project_listing')) {
                    $is_allow_to_process = 1;
                } else {
                    $project = $this->Project->find('count', array(
                        'conditions' => array(
                            'Project.id <>' => $model->id,
                            'Project.user_id' => $project['Project']['user_id'],
                            'Project.referred_by_user_id' => $project['User']['referred_by_user_id'],
                        ) ,
                    ));
                    if ($project < 1) {
                        $is_allow_to_process = 1;
                    }
                }
                if (!empty($is_allow_to_process)) {
                    $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                    $affiliateType = $this->AffiliateType->find('first', array(
                        'conditions' => array(
                            'AffiliateType.id' => $affiliate_model['Project']
                        ) ,
                        'fields' => array(
                            'AffiliateType.id',
                            'AffiliateType.commission',
                            'AffiliateType.affiliate_commission_type_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $affiliate_commision_amount = $admin_commision_amount = 0;
                    if (!empty($affiliateType)) {
                        if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                            $affiliate_commision_amount = ($project['Project']['fee_amount']*$affiliateType['AffiliateType']['commission']) /100;
                        } else {
                            $affiliate_commision_amount = ($project['Project']['fee_amount']-$affiliateType['AffiliateType']['commission']);
                        }
                        $admin_commision_amount = $project['Project']['fee_amount']-$affiliate_commision_amount;
                    }
                    $data['Project']['id'] = $model->id;
                    $data['Project']['referred_by_user_id'] = $referred_by_user_id;
                    $data['Project']['admin_commission_amount'] = $admin_commision_amount;
                    $data['Project']['affiliate_commission_amount'] = $affiliate_commision_amount;
                    $this->Project->save($data['Project']);
                    // set affiliate data
                    $affiliate['Affiliate']['class'] = 'Project';
                    $affiliate['Affiliate']['foreign_id'] = $model->id;
                    $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['Project'];
                    $affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    $this->__saveAffiliate($affiliate);
                    $this->User->updateAll(array(
                        'User.referred_project_count' => 'User.referred_project_count + ' . '1'
                    ) , array(
                        'User.id' => $referred_by_user_id
                    ));
                }
            }
        } else if ($model->name == 'ProjectFund') {
            $is_allow_to_process = '';
            $this->ProjectFund = $this->__getparentClass('Projects.ProjectFund');
            $projectFund = $this->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $model->id
                ) ,
                'contain' => array(
                    'User',
                    'ProjectType',
                ) ,
                'recursive' => 0
            ));
            if (!empty($projectFund['User']['referred_by_user_id'])) {
                $referred_by_user_id = $projectFund['User']['referred_by_user_id'];
            }
            if (!empty($referred_by_user_id) && $this->__CheckAffiliateUSer($referred_by_user_id)) {
                if (isset($affiliate_model[$projectFund['ProjectType']['slug']]) && Configure::read('affiliate.commission_on_every_' . $affiliate_model[$projectFund['ProjectType']['slug']])) {
                    $is_allow_to_process = 1;
                } else {
                    $projectFundCount = $this->ProjectFund->find('count', array(
                        'conditions' => array(
                            'ProjectFund.id <>' => $model->id,
                            'ProjectFund.project_fund_status_id' => array(
                                ConstProjectFundStatus::Authorized,
                                ConstProjectFundStatus::PaidToOwner,
                                ConstProjectFundStatus::Closed,
                                ConstProjectFundStatus::DefaultFund
                            ) ,
                            'ProjectFund.user_id' => $projectFund['ProjectFund']['user_id'],
                            'ProjectFund.referred_by_user_id' => $projectFund['User']['referred_by_user_id'],
                            'ProjectFund.project_type_id' => $projectFund['ProjectFund']['project_type_id']
                        ) ,
                        'recursive' => -1
                    ));
                    if ($projectFundCount < 1) {
                        $is_allow_to_process = 1;
                    }
                }
                if (!empty($is_allow_to_process)) {
                    $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                    $affiliateType = $this->AffiliateType->find('first', array(
                        'conditions' => array(
                            'AffiliateType.id' => $affiliate_model[$projectFund['ProjectType']['name']]
                        ) ,
                        'fields' => array(
                            'AffiliateType.id',
                            'AffiliateType.commission',
                            'AffiliateType.affiliate_commission_type_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $affiliate_commision_amount = $admin_commision_amount = 0;
                    if (!empty($affiliateType)) {
                        if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                            $affiliate_commision_amount = ($projectFund['ProjectFund']['site_fee']*$affiliateType['AffiliateType']['commission']) /100;
                        } else {
                            $affiliate_commision_amount = ($projectFund['ProjectFund']['site_fee']-$affiliateType['AffiliateType']['commission']);
                        }
                        $admin_commision_amount = $projectFund['ProjectFund']['site_fee']-$affiliate_commision_amount;
                    }
                    $data['ProjectFund']['id'] = $model->id;
                    $data['ProjectFund']['referred_by_user_id'] = $referred_by_user_id;
                    $data['ProjectFund']['admin_commission_amount'] = $admin_commision_amount;
                    $data['ProjectFund']['affiliate_commission_amount'] = $affiliate_commision_amount;
                    $this->ProjectFund->save($data['ProjectFund']);
                    // set affiliate data
                    $affiliate['Affiliate']['class'] = 'ProjectFund';
                    $affiliate['Affiliate']['foreign_id'] = $model->id;
                    $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model[$projectFund['ProjectType']['name']];
                    $affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    $this->__saveAffiliate($affiliate);
                    $this->User->updateAll(array(
                        'User.affiliate_refer_purchase_count' => 'User.affiliate_refer_purchase_count + ' . '1'
                    ) , array(
                        'User.id' => $projectFund['ProjectFund']['user_id']
                    ));
                }
            }
        }
    }
    function __updateAffiliate(&$model) 
    {
        if ($model->name == 'ProjectFund' && !empty($model->id)) {
            $conditions['Affiliate.class'] = 'ProjectFund';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affiliate = $this->__findAffiliate($conditions);
            $projectFund = $model->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $model->id
                ) ,
                'recursive' => -1
            ));
            if (!empty($projectFund['ProjectFund']['referred_by_user_id']) && !empty($affiliate)) {
                if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::PaidToOwner) {
                    $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                    $this->__saveAffiliate($affiliate);
                } elseif ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Canceled || $projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Expired) {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Canceled;
                    $this->User = $this->__getparentClass('User');
                    $this->User->updateAll(array(
                        'User.total_commission_canceled_amount' => 'User.total_commission_canceled_amount + ' . $affiliate['Affiliate']['commission_amount']
                    ) , array(
                        'User.id' => $affiliate['Affiliate']['affliate_user_id']
                    ));
                    $this->__saveAffiliate($affiliate);
                }
            }
        } elseif ($model->name == 'User' && !empty($model->id)) {
            $conditions['Affiliate.class'] = 'User';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affiliate = $this->__findAffiliate($conditions);
            $user = $model->find('first', array(
                'conditions' => array(
                    'id' => $model->id
                ) ,
                'recursive' => -1
            ));
            if (!empty($user['User']['referred_by_user_id']) && !empty($affiliate)) {
                $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                if (!empty($user['User']['is_active'])) {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                } else {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                }
                $this->__saveAffiliate($affiliate);
            }
        } elseif ($model->name == 'Project' && !empty($model->id)) {
            $conditions['Affiliate.class'] = 'Project';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affiliate = $this->__findAffiliate($conditions);
            $project = $model->find('first', array(
                'conditions' => array(
                    'Project.id' => $model->id
                ) ,
                'contain' => array(
                    'Transaction'
                ) ,
                'recursive' => 2
            ));
            if (!empty($project['Project']['referred_by_user_id']) && !empty($affiliate)) {
                if (!empty($project['Transaction'][0]['id']) || ($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($project['Project']['needed_amount']))) {
                    if ($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($project['Project']['needed_amount'])) {
                        $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
                        $affiliateType = $this->AffiliateType->find('first', array(
                            'conditions' => array(
                                'AffiliateType.id' => $affiliate_model['Project']
                            ) ,
                            'fields' => array(
                                'AffiliateType.id',
                                'AffiliateType.commission',
                                'AffiliateType.affiliate_commission_type_id'
                            ) ,
                            'recursive' => -1
                        ));
                        $affiliate_commision_amount = $admin_commision_amount = 0;
                        if (!empty($affiliateType)) {
                            if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                                $affiliate_commision_amount = ($project['Project']['fee_amount']*$affiliateType['AffiliateType']['commission']) /100;
                            } else {
                                $affiliate_commision_amount = ($project['Project']['fee_amount']-$affiliateType['AffiliateType']['commission']);
                            }
                            $admin_commision_amount = $project['Project']['fee_amount']-$affiliate_commision_amount;
                        }
                        $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    }
                    $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                    $projectStatus = array();
                    $response = Cms::dispatchEvent('Behavior.ProjectType.GetProjectStatus', $model, array(
                        'projectStatus' => $projectStatus,
                        'project' => $project,
                        'type' => 'status'
                    ));
                    if (!empty($response->data['is_affiliate_status_pending'])) {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    } else {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                    }
                }
                $this->__saveAffiliate($affiliate);
            }
        }
    }
    function __saveAffiliate($data) 
    {
        $this->Affiliate = $this->__getparentClass('Affiliates.Affiliate');
        if (!isset($data['Affiliate']['id']) && !empty($data['Affiliate']['affliate_user_id'])) {
            $this->Affiliate->create();
            $this->Affiliate->AffiliateUser->updateAll(array(
                'AffiliateUser.total_commission_pending_amount' => 'AffiliateUser.total_commission_pending_amount + ' . $data['Affiliate']['commission_amount']
            ) , array(
                'AffiliateUser.id' => $data['Affiliate']['affliate_user_id']
            ));
        }
        if (!empty($data['Affiliate']['class']) || !empty($data['Affiliate']['foreign_id']) || !empty($data['Affiliate']['affiliate_status_id']) || !empty($data['Affiliate']['commission_amount']) || !empty($data['Affiliate']['commission_holding_start_date'])) {
            $this->Affiliate->save($data);
        }
    }
    function __findAffiliate($condition) 
    {
        $this->Affiliate = $this->__getparentClass('Affiliates.Affiliate');
        $affiliate = $this->Affiliate->find('first', array(
            'conditions' => $condition,
            'recursive' => -1
        ));
        return $affiliate;
    }
    function __CheckAffiliateUSer($refer_user_id) 
    {
        $this->User = $this->__getparentClass('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $refer_user_id
            ) ,
            'recursive' => -1
        ));
        if (!empty($user) && ($user['User']['is_affiliate_user'])) {
            return true;
        }
        return false;
    }
    function __getparentClass($parentClass) 
    {
        App::import('Model', $parentClass);
        $parentClassArr = explode('.', $parentClass);
        if (sizeof($parentClassArr) > 1) {
            $parentClass = $parentClassArr[1];
        }
        return new $parentClass();
    }
}
?>