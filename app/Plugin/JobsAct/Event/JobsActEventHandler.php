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
class JobsActEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Controller.Project.projectStart' => array(
                'callable' => 'onProjectStart',
            ) ,
            'Controller.Project.beforeAdd' => array(
                'callable' => 'onProjectBeforeAddValidation'
            ) ,
            'Controller.ProjectFund.beforeProjectFundStart' => array(
                'callable' => 'onBeforeProjectFundStart'
            ) ,
            'Controller.ProjectFund.beforeAdd' => array(
                'callable' => 'onProjectFundBeforeAddValidation'
            ) ,
            'View.UserProfile.additionalFields' => array(
                'callable' => 'onUserProfileEdit'
            ) ,
            'Controller.Users.redirectToJobAct' => array(
                'callable' => 'afterUserProfileEdit'
            ) ,
            'Controller.UserProfile.beforeUpdateValidation' => array(
                'callable' => 'beforeProfileUpdate'
            )
        );
    }
    public function onProjectStart($event) 
    {
        if (!empty($event->data['data']['named']['project_type']) && $event->data['data']['named']['project_type'] == 'equity') {
            $controller = $event->subject();
            $project = $controller->Project->find('all', array(
                'conditions' => array(
                    'Project.user_id' => $controller->Auth->user('id') ,
                    'Project.project_type_id' => ConstProjectTypes::Equity ,
                    'Project.created >=' => date('Y-m-d', strtotime('now -1 year'))
                ) ,
                'fields' => array(
                    'SUM(Project.needed_amount) as total_amount_raised',
                ) ,
                'recursive' => -1
            ));
            // Entrepreneur: 12 months - 1 million can able to raise (from other sites) (1,000,000)
            if (($project[0][0]['total_amount_raised']) > 1000000) {
                $controller->Session->setFlash(sprintf(__l('You cant add %s, , because you have already reached the maximum raised amount') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
                $controller->redirect(array(
                    'controller' => 'projects',
                    'action' => 'start'
                ));
            }
        }
    }
    public function onProjectBeforeAddValidation($event) 
    {
		if ($event->data['data']['Project']['project_type_id'] == ConstProjectTypes::Equity) {
			$controller = $event->subject();
            $project = $controller->Project->find('all', array(
                'conditions' => array(
                    'Project.user_id' => $controller->Auth->user('id') ,
                    'Project.project_type_id' => ConstProjectTypes::Equity ,
                    'Project.created >=' => date('Y-m-d', strtotime('now -1 year'))
                ) ,
                'fields' => array(
                    'SUM(Project.needed_amount) as total_amount_raised',
                ) ,
                'recursive' => -1
            ));
            // Entrepreneur: 12 months - 1 million can able to raise (from other sites) (1,000,000)
            if (($project[0][0]['total_amount_raised']+$controller->data['Project']['needed_amount']) > 1000000) {
                $controller->Session->setFlash(__l('You cant raised this much amount') , 'default', null, 'error');
				$controller->redirect(array(
					'controller' => 'projects',
					'action' => 'index',
					'project_type' => 'equity',
				));
            }
        }
    }
    function onBeforeProjectFundStart($event) 
    {
        $controller = $event->subject();
        $project = $controller->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $event->data['project_id'],
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            $controller->loadModel('JobsAct.JobsActEntry');
            $jobsActEntry = $controller->JobsActEntry->find('first', array(
                'conditions' => array(
                    'JobsActEntry.user_id' => $controller->Auth->user('id') ,
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            if (!empty($jobsActEntry)) {
                $projectFund = $controller->ProjectFund->find('all', array(
                    'conditions' => array(
                        'ProjectFund.user_id' => $controller->Auth->user('id') ,
                        'ProjectFund.project_type_id' => ConstProjectTypes::Equity ,
						'ProjectFund.project_fund_status_id' => array(
							ConstProjectFundStatus::Captured,
							ConstProjectFundStatus::PaidToOwner,
						) ,
                        'ProjectFund.created >=' => date('Y-m-d', strtotime('now -1 year'))
                    ) ,
                    'fields' => array(
                        'SUM(ProjectFund.amount) as total_amount_funded',
                    ) ,
                    'recursive' => -1
                ));
                // Investor:
                // 1. Net worth: < 100,000
                // Annual Income: < 100,000 => can invest < $2000 or 5% of net worth or 5% of annual income
                if (($jobsActEntry['JobsActEntry']['annual_income_individual'] < 1000000) && ($jobsActEntry['JobsActEntry']['net_worth'] < 1000000)) {
                    if (!(($projectFund[0][0]['total_amount_funded'] < 2000) || ($projectFund[0][0]['total_amount_funded'] < ($jobsActEntry['JobsActEntry']['net_worth']*(5/100))) || ($projectFund[0][0]['total_amount_funded'] < ($jobsActEntry['JobsActEntry']['annual_income_individual']*(5/100))))) {
                        $controller->Session->setFlash(__l('You cant invest, because you reached your limit') , 'default', null, 'error');
                        $controller->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug']
                        ));
                    }
                }
                // Investor:
                // 2. Net worth: > 100,000
                // Annual Income: > 100,000 => can invest < 10% of net worth or 10% of annual income
                // http://www.mofo.com/~/media/Files/PDFs/jumpstart/131115-JOBS-Act-Crowdfunding.pdf
                elseif (!(($jobsActEntry['JobsActEntry']['annual_income_individual'] > 1000000) && ($jobsActEntry['JobsActEntry']['net_worth'] > 1000000))) {
                    if (($projectFund[0][0]['total_amount_funded'] > 100000) || ($projectFund[0][0]['total_amount_funded'] > ($jobsActEntry['JobsActEntry']['net_worth']*(10/100))) || ($projectFund[0][0]['total_amount_funded'] > ($jobsActEntry['JobsActEntry']['annual_income_individual']*(10/100)))) {
                        $controller->Session->setFlash(__l('You cant invest, because you reached your limit') , 'default', null, 'error');
                        $controller->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug']
                        ));
                    }
                }
            } else {
                $controller->redirect(array(
                    'controller' => 'jobs_act_entries',
                    'action' => 'add',
                    'project_id' => $event->data['project_id']
                ));
            }
        }
    }
    function onProjectFundBeforeAddValidation($event) 
    {
        $controller = $event->subject();
        $project = $controller->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $event->data['data']['ProjectFund']['project_id'],
                'Project.project_type_id' => ConstProjectTypes::Equity
            ) ,
            'recursive' => -1
        ));
        $controller->loadModel('JobsAct.JobsActEntry');
        $jobsActEntry = $controller->JobsActEntry->find('first', array(
            'conditions' => array(
                'JobsActEntry.user_id' => $controller->Auth->user('id') ,
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (!empty($jobsActEntry)) {
            if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
                $projectFund = $controller->ProjectFund->find('all', array(
                    'conditions' => array(
                        'ProjectFund.user_id' => $controller->Auth->user('id') ,
                        'ProjectFund.project_type_id' => ConstProjectTypes::Equity ,
						'ProjectFund.project_fund_status_id' => array(
							ConstProjectFundStatus::Captured,
							ConstProjectFundStatus::PaidToOwner,
						) ,
                        'ProjectFund.created >=' => date('Y-m-d', strtotime('now -1 year'))
                    ) ,
                    'fields' => array(
                        'SUM(ProjectFund.amount) as total_amount_funded',
                    ) ,
                    'recursive' => -1
                ));
                // Investor:
                // 1. Net worth: < 100,000
                // Annual Income: < 100,000 => can invest < $2000 or 5% of net worth or 5% of annual income
                if (($jobsActEntry['JobsActEntry']['annual_income_individual'] < 1000000) && ($jobsActEntry['JobsActEntry']['net_worth'] < 1000000)) {
                    if (!empty($controller->request->data['amount']) && (!((($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < 2000) || (($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < ($jobsActEntry['JobsActEntry']['net_worth']*(5/100))) || (($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < ($jobsActEntry['JobsActEntry']['annual_income_individual']*(5/100)))))) {
                        $controller->Session->setFlash(__l('You cant invest, because you reached your limit') , 'default', null, 'error');
                    }
                }
                // Investor:
                // 2. Net worth: > 100,000
                // Annual Income: > 100,000 => can invest < 10% of net worth or 10% of annual income
                elseif (!(($jobsActEntry['JobsActEntry']['annual_income_individual'] > 100000) && ($jobsActEntry['JobsActEntry']['net_worth'] > 100000))) {
                    if ((($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < 100000) || (($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < ($jobsActEntry['JobsActEntry']['net_worth']*(10/100))) || (($projectFund[0][0]['total_amount_funded']+$controller->request->data['amount']) < ($jobsActEntry['JobsActEntry']['annual_income_individual']*(10/100)))) {
                        $controller->Session->setFlash(__l('You cant invest, because you reached your limit') , 'default', null, 'error');
                    }
                }
            }
        }
    }
    public function onUserProfileEdit($event) 
    {
        if (isPluginEnabled('JobsAct')) {
            $obj = $event->subject();
            App::import('Model', 'JobsAct.JobsActEntry');
            $this->JobsActEntry = new JobsActEntry();
            $jobs = $this->JobsActEntry->find('first', array(
                'conditions' => array(
                    'JobsActEntry.user_id' => $event->data['data']['User']['id']
                ) ,
                'recursive' => -1
            ));
            echo $obj->element('JobsAct.user_profile_entries', array(
                'jobs' => $jobs
            ));
        }
    }
    public function afterUserProfileEdit($event) 
    {
        App::import('Model', 'JobsAct.JobsActEntry');
        $this->JobsActEntry = new JobsActEntry();
        $jobs = $this->JobsActEntry->find('first', array(
            'conditions' => array(
                'JobsActEntry.user_id' => $event->data['data']['User']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($jobs)) {
            $event->data['data']['JobsActEntry']['id'] = $jobs['JobsActEntry']['id'];
        }
        $event->data['data']['JobsActEntry']['user_id'] = $event->data['data']['User']['id'];
        $this->JobsActEntry->save($event->data['data']['JobsActEntry'], false);
    }
    public function beforeProfileUpdate($event) 
    {
		if (isPluginEnabled('JobsAct')) {
			$controller = $event->subject();
			$controller->loadModel('JobsAct.JobsActEntry');
			$controller->JobsActEntry->set($event->data['data']);
			$controller->JobsActEntry->validates();
			$event->data['error'] = $controller->JobsActEntry->validationErrors;
		}
	}
}
?>