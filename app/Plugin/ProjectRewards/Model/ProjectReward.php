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
class ProjectReward extends AppModel
{
    public $name = 'ProjectReward';
    public $belongsTo = array(
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Project'
        );
        $this->validate = array(
            'pledge_amount' => array(
                'rule5' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                    'message' => __l('Enter valid amount')
                ) ,
                'rule4' => array(
                    'rule' => '_rewardAmountCheck',
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                ) ,
                'rule3' => array(
                    'rule' => '_rewardAmount',
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                    'message' => __l('Must be less than needed amount')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>=',
                        1
                    ) ,
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'reward' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => (Configure::read('Project.is_project_reward_optional')) ? true : false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'pledge_max_user_limit' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid limit in numbers')
                ) ,
                'rule1' => array(
                    'rule' => '_checkUserCount',
                    'allowEmpty' => true,
                    'message' => __l('This limit can not be entered  ')
                ) ,
            ) ,
            'estimated_delivery_date' => array(
                'rule2' => array(
                    'rule' => '_checkEndDate',
                    'allowEmpty' => true,
                    'message' => sprintf(__l('Must be greater than %s end date.') , Configure::read('project.alt_name_for_project_singular_small'))
                ) ,
                'rule1' => array(
                    'rule' => 'date',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid date')
                ) ,
            ) ,
            'is_having_additional_info' => array(
                'rule1' => array(
                    'rule' => '_checkAdditinalInfoLabel',
                    'allowEmpty' => true,
                    'message' => __l('Must be enter the additional information label')
                ) ,
            )
        );
    }
    public function _checkEndDate() 
    {
        if (!empty($this->data[$this->name]['is_shipping']) && !empty($this->data[$this->name]['estimated_delivery_date']) && !empty($this->data[$this->name]['pledge_amount'])) {
            if (!empty($this->data['Project']['project_end_date'])) {
                $project_end_date = explode('-', $this->data['Project']['project_end_date']);
                $end_date = strtotime($project_end_date[2] . '-' . $project_end_date[1] . '-' . $project_end_date[0]);
            } else {
                $end_date = time();
            }
            $estimated_dat = strtotime($this->data[$this->name]['estimated_delivery_date']);
            if ($estimated_dat > $end_date) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    public function _checkAdditinalInfoLabel() 
    {
        if (!empty($this->data[$this->name]['is_having_additional_info'])) {
            if (empty($this->data[$this->name]['additional_info_label'])) {
                $this->validationErrors['additional_info_label'] = __l('Required');
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    public function _checkUserCount() 
    {
        if ($this->data[$this->name]['pledge_amount']*$this->data[$this->name]['pledge_max_user_limit'] > $this->data[$this->name]['max_amount'] && !$this->data[$this->name]['is_allow_over_funding']) {
            return false;
        } else {
            return true;
        }
    }
    public function _rewardAmountCheck() 
    {
        if ($this->data[$this->name]['pledge_amount'] != $this->data[$this->name]['min_amount'] && $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Fixed) {
            $this->validationErrors['pledge_amount'] = __l('Amount should be equal to fixed amount');
            return true;
        } else if ($this->data[$this->name]['pledge_amount'] < $this->data[$this->name]['min_amount'] && $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Minimum) {
            $this->validationErrors['pledge_amount'] = __l('Amount should not be less then minimum amount');
            return true;
        } else if ($this->data[$this->name]['pledge_amount'] < $this->data[$this->name]['min_amount'] && $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Multiple) {
            $this->validationErrors['pledge_amount'] = __l('Amount should not be less then denomination amount');
            return true;
        } else if (is_numeric($this->data[$this->name]['pledge_amount']) && $this->data[$this->name]['max_amount']%$this->data[$this->name]['pledge_amount'] != 0 && $this->data[$this->name]['pledge_type_id'] == ConstPledgeTypes::Multiple && !$this->data[$this->name]['is_allow_over_funding']) {
            $this->validationErrors['pledge_amount'] = __l('Amount cannot be equally shared or else you should allow over funding.');
            return true;
        } else {
            return true;
        }
    }
    public function _rewardAmount() 
    {
        if ($this->data[$this->name]['pledge_amount'] >= $this->data[$this->name]['max_amount']) {
            return false;
        } else {
            return true;
        }
    }
    public function _rewardNotEmpty() 
    {
        if (!empty($this->data[$this->name]['pledge_amount']) && empty($this->data[$this->name]['reward']) && empty($this->validationErrors['reward'])) {
            $this->validationErrors['reward'] = __l('Required');
            return true;
        } else {
            return true;
        }
    }
    public function _pledgeNotEmpty() 
    {
        if (empty($this->data[$this->name]['pledge_amount']) && empty($this->validationErrors['pledge_amount'])) {
            $this->validationErrors['pledge_amount'] = __l('Required');
            return false;
        } else {
            return true;
        }
    }
}
?>