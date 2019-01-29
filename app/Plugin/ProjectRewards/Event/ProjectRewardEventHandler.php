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
class ProjectRewardEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Model.Project.beforeAdd' => array(
                'callable' => 'onProjectValidation',
            ) ,
            'Controller.Projects.afterAdd' => array(
                'callable' => 'onProjectAdd',
            ) ,
            'Controller.Projects.afterEdit' => array(
                'callable' => 'onProjectEdit',
            ) ,
        );
    }
    public function onProjectValidation($event) 
    {
        $controller = $event->subject();
        $data = $event->data['data'];
        $projectRewardValidationError = array();
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Pledge) {
            if (!empty($data['ProjectReward'])) {
                if (!empty($data['Project']['id'])) {
                    $project = $controller->Project->find('first', array(
                        'conditions' => array(
                            'Project.id' => $data['Project']['id']
                        ) ,
                        'contain' => array(
                            'Pledge'
                        ) ,
                        'recursive' => 0
                    ));
                }
                foreach($data['ProjectReward'] as $key => $projectReward) {
                    if (!empty($projectReward)) {
                        if(!empty($data['key'])) {
                            $data['ProjectReward']['max_amount'] = $data['Project']['needed_amount'];
                            $data['ProjectReward']['min_amount'] = !empty($data['Pledge']['min_amount_to_fund']) ? $data['Pledge']['min_amount_to_fund'] : '0';
                            $data['ProjectReward']['pledge_type_id'] = !empty($data['Pledge']['pledge_type_id']) ? $data['Pledge']['pledge_type_id'] : ConstPledgeTypes::Any;
                            $data['ProjectReward']['is_allow_over_funding'] = !empty($data['Project']['is_allow_over_funding']) ? $data['Project']['is_allow_over_funding'] : 0;
                            $data['ProjectReward']['pledge_amount'] = $projectReward['pledge_amount'];
                            $data['ProjectReward']['reward'] = $projectReward['reward'];
                            $data['ProjectReward']['pledge_max_user_limit'] = $projectReward['pledge_max_user_limit'];
                            $data['ProjectReward']['estimated_delivery_date'] = !empty($projectReward['estimated_delivery_date'])?$projectReward['estimated_delivery_date']:'';
                            $data['ProjectReward']['is_shipping'] = !empty($projectReward['is_shipping'])?$projectReward['is_shipping']:'';
                            $data['ProjectReward']['is_having_additional_info'] = !empty($projectReward['is_having_additional_info'])?$projectReward['is_having_additional_info']:'';
                            $data['ProjectReward']['additional_info_label'] = !empty($projectReward['additional_info_label'])?$projectReward['additional_info_label']:'';
                        } else {
                            $data['ProjectReward']['max_amount'] = $project['Project']['needed_amount'];
                            $data['ProjectReward']['min_amount'] = !empty($project['Pledge']['min_amount_to_fund']) ? $project['Pledge']['min_amount_to_fund'] : '0';
                            $data['ProjectReward']['pledge_type_id'] = !empty($project['Pledge']['pledge_type_id']) ? $project['Pledge']['pledge_type_id'] : ConstPledgeTypes::Any;
                            $data['ProjectReward']['is_allow_over_funding'] = !empty($project['Pledge']['is_allow_over_funding']) ? $project['Pledge']['is_allow_over_funding'] : 0;
                            $data['ProjectReward']['pledge_amount'] = $projectReward['pledge_amount'];
                            $data['ProjectReward']['reward'] = $projectReward['reward'];
                            $data['ProjectReward']['pledge_max_user_limit'] = $projectReward['pledge_max_user_limit'];
                            $data['ProjectReward']['estimated_delivery_date'] = !empty($projectReward['estimated_delivery_date'])?$projectReward['estimated_delivery_date']:'';
                            $data['ProjectReward']['is_shipping'] = !empty($projectReward['is_shipping'])?$projectReward['is_shipping']:'';
                            $data['ProjectReward']['is_having_additional_info'] = !empty($projectReward['is_having_additional_info'])?$projectReward['is_having_additional_info']:'';
                            $data['ProjectReward']['additional_info_label'] = !empty($projectReward['additional_info_label'])?$projectReward['additional_info_label']:'';
                        }
                        $controller->Project->ProjectReward->set($data);
                        if (!$controller->Project->ProjectReward->validates()) {
                            $projectRewardValidationError[$key] = $controller->Project->ProjectReward->validationErrors;
                            $is_reward_valid = false;
                        }
                    }
                }
                $event->data['error']['ProjectReward'] = $projectRewardValidationError;
            }
        }
    }
    public function onProjectAdd($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Pledge) {
            App::import('Model', 'ProjectRewards.ProjectReward');
            $this->ProjectReward = new ProjectReward();
            if (!empty($data['ProjectReward'])) {
				$id = array();
                foreach($data['ProjectReward'] as $projectReward) {
                    if ($projectReward['pledge_amount']) {
                        $data_reward['ProjectReward']['max_amount'] = $data['Project']['needed_amount'];
                        $data_reward['ProjectReward']['min_amount'] = !empty($data['Pledge']['min_amount_to_fund']) ? $data['Pledge']['min_amount_to_fund'] : '0';
                        $data_reward['ProjectReward']['pledge_type_id'] = !empty($data['Pledge']['pledge_type_id']) ? $data['Pledge']['pledge_type_id'] : ConstPledgeTypes::Any;
                        $data_reward['ProjectReward']['is_allow_over_funding'] = !empty($data['Pledge']['is_allow_over_funding']) ? $data['Pledge']['is_allow_over_funding'] : 0;
                        $data_reward['ProjectReward']['project_id'] = $data['Project']['id'];
                        $data_reward['ProjectReward']['pledge_amount'] = $projectReward['pledge_amount'];
                        $data_reward['ProjectReward']['reward'] = $projectReward['reward'];
                        $data_reward['ProjectReward']['pledge_max_user_limit'] = $projectReward['pledge_max_user_limit'];
                        $data_reward['ProjectReward']['estimated_delivery_date'] = !empty($projectReward['estimated_delivery_date'])?$projectReward['estimated_delivery_date']:'';
                        $data_reward['ProjectReward']['is_shipping'] = !empty($projectReward['is_shipping'])?$projectReward['is_shipping']:'';
                        $data_reward['ProjectReward']['is_having_additional_info'] = !empty($projectReward['is_having_additional_info'])?$projectReward['is_having_additional_info']:'';
                        $data_reward['ProjectReward']['additional_info_label'] = !empty($projectReward['additional_info_label'])?$projectReward['additional_info_label']:'';
						if(!empty($projectReward['id'])){
							$data_reward['ProjectReward']['id'] = $projectReward['id'];						
                        } else {							
							if(isset($projectReward['id'])){								
								unset($projectReward['id']);
								unset($data_reward['ProjectReward']['id']);								
							}
							$this->ProjectReward->create();								
						}						
						$result = $this->ProjectReward->save($data_reward);
						$id[] = $result['ProjectReward']['id'];						
                    }
                }			
				$this->ProjectReward->deleteAll(array('NOT' => array('ProjectReward.id' => $id),'ProjectReward.project_id'=>$data['Project']['id']));				
            }
        }
    }
    public function onProjectEdit($event) 
    {
        $obj = $event->subject();
        $data = $event->data['data'];
        if ($data['Project']['project_type_id'] == ConstProjectTypes::Pledge) {
            App::import('Model', 'ProjectRewards.ProjectReward');
            $this->ProjectReward = new ProjectReward();
            if (!empty($data['ProjectReward'])) {
				$id = array();
                foreach($data['ProjectReward'] as $projectReward) {					
                    if ($projectReward['pledge_amount']) {
                        $data_reward['ProjectReward']['max_amount'] = $data['Project']['needed_amount'];
                        $data_reward['ProjectReward']['min_amount'] = !empty($data['Pledge']['min_amount_to_fund']) ? $data['Pledge']['min_amount_to_fund'] : '0';
                        $data_reward['ProjectReward']['pledge_type_id'] = !empty($data['Pledge']['pledge_type_id']) ? $data['Pledge']['pledge_type_id'] : ConstPledgeTypes::Any;
                        $data_reward['ProjectReward']['is_allow_over_funding'] = !empty($data['Pledge']['is_allow_over_funding']) ? $data['Pledge']['is_allow_over_funding'] : 0;
                        $data_reward['ProjectReward']['project_id'] = $data['Project']['id'];
                        $data_reward['ProjectReward']['pledge_amount'] = $projectReward['pledge_amount'];
                        $data_reward['ProjectReward']['reward'] = $projectReward['reward'];
                        $data_reward['ProjectReward']['pledge_max_user_limit'] = $projectReward['pledge_max_user_limit'];
                        $data_reward['ProjectReward']['estimated_delivery_date'] = $projectReward['estimated_delivery_date'];
                        $data_reward['ProjectReward']['is_shipping'] = $projectReward['is_shipping'];
                        $data_reward['ProjectReward']['is_having_additional_info'] = $projectReward['is_having_additional_info'];
                        $data_reward['ProjectReward']['additional_info_label'] = $projectReward['additional_info_label'];
                        $data_reward['ProjectReward']['id'] = !empty($projectReward['id']) ? $projectReward['id'] : '';
                        $result = $this->ProjectReward->save($data_reward);
						$id[] = $result['ProjectReward']['id'];							
                    }
                }
				
						$this->ProjectReward->deleteAll(array('NOT' => array('ProjectReward.id' => $id),'ProjectReward.project_id'=>$data['Project']['id']));
				
            }
        }
    }
}
?>