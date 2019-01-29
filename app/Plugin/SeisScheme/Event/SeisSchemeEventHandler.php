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
class SeisSchemeEventHandler extends Object implements CakeEventListener
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
        );
    }
    public function onProjectStart($event) 
    {
        if (!empty($event->data['data']['named']['project_type']) && $event->data['data']['named']['project_type'] == 'equity' && empty($event->data['project_id'])) {
            $controller = $event->subject();
            $controller->redirect(array(
                'controller' => 'seis_entries',
                'action' => 'add'
            ));
        }
    }
    public function onProjectBeforeAddValidation($event) 
    {
        if ($event->data['data']['Project']['project_type_id'] == ConstProjectTypes::Equity) {
            $controller = $event->subject();
			$equity = $controller->Project->Equity->find('first', array(
				'conditions' => array(
					'Equity.project_id' => $event->data['data']['Project']['id'],
				) ,
				'recursive' => -1
			));
			$db = ConnectionManager::getDataSource('default');
			$projects = $db->query('SELECT SUM(Project.needed_amount) as total_amount_raised, Equity.is_seis_or_eis FROM projects as Project LEFT JOIN project_equity_fields as Equity ON Equity.project_id = Project.id WHERE Project.user_id = ' . $controller->Auth->user('id') . ' AND Project.project_type_id = ' . ConstProjectTypes::Equity . ' AND Project.created >= \'' . date('Y-m-d', strtotime('now -1 year')) . '\' GROUP BY Equity.is_seis_or_eis');
            // Requirement for entrepreneur:
            // If SEIS Venture: < 150,000 - can raise in 12 months
            // If EIS Venture: < 5,000,000 - can raise in 12 months
			// http://www.silverliningfilmdev.com/seed-enterprise-investment-schemes-seis/
			if (!empty($projects)) {
				foreach($projects as $project) {
					if (!empty($project[0]['is_seis_or_eis']) && $project[0]['is_seis_or_eis'] == ConstActs::SEIS && !empty($equity['Equity']['is_seis_or_eis']) && $equity['Equity']['is_seis_or_eis'] == ConstActs::SEIS) {
						if (($project[0]['total_amount_raised']+$controller->data['Project']['needed_amount']) > 150000) {
							$controller->Session->setFlash(__l('You cant raised this much amount') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'index',
								'project_type' => 'equity',
							));
						}
					} else if(!empty($project[0]['is_seis_or_eis']) && $project[0]['is_seis_or_eis'] == ConstActs::EIS && !empty($equity['Equity']['is_seis_or_eis']) && $equity['Equity']['is_seis_or_eis'] == ConstActs::EIS) {
						if (($project[0]['total_amount_raised']+$controller->data['Project']['needed_amount']) > 5000000) {
							$controller->Session->setFlash(__l('You cant raised this much amount') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'index',
								'project_type' => 'equity',
							));
						}
					}
				}
			}
        }
    }
    public function onBeforeProjectFundStart($event) 
    {
        $controller = $event->subject();
        $project = $controller->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $event->data['project_id'],
            ) ,
			'contain' => array(
				'Equity'
			) ,
            'recursive' => 0
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
			$db = ConnectionManager::getDataSource('default');
			$projectFunds = $db->query('SELECT SUM(ProjectFund.amount) as total_amount_invested, Equity.is_seis_or_eis FROM project_funds as ProjectFund LEFT JOIN project_equity_fields as Equity ON Equity.project_id = ProjectFund.project_id WHERE ProjectFund.user_id = ' . $controller->Auth->user('id') . ' AND ProjectFund.project_type_id = ' . ConstProjectTypes::Equity . ' AND ProjectFund.project_fund_status_id IN(' . ConstProjectFundStatus::Captured . ',' . ConstProjectFundStatus::PaidToOwner . ') AND ProjectFund.created >= \'' . date('Y-m-d', strtotime('now -1 year')) . '\' GROUP BY Equity.is_seis_or_eis');
            // Requirement for investors:
            // If SEIS Venture: 12 months - can invest < 100,000
            // If EIS Venture: 12 months - can invest < 1,000,000
			if (!empty($projectFunds)) {
				foreach($projectFunds as $projectFund) {
					if (!empty($project['Equity']['is_seis_or_eis']) && $project['Equity']['is_seis_or_eis'] == ConstActs::SEIS && !empty($projectFund[0]['is_seis_or_eis']) && $projectFund[0]['is_seis_or_eis'] == ConstActs::SEIS) {
						if (($projectFund[0]['total_amount_invested']) > 100000) {
							$controller->Session->setFlash(__l('You cant invest, because you have reached your limit') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'view',
								$project['Project']['slug']
							));
						}
					} else if(!empty($project['Equity']['is_seis_or_eis']) && $project['Equity']['is_seis_or_eis'] == ConstActs::EIS && !empty($projectFund[0]['is_seis_or_eis']) && $projectFund[0]['is_seis_or_eis'] == ConstActs::EIS) {
						if (($projectFund[0]['total_amount_invested']) > 1000000) {
							$controller->Session->setFlash(__l('You cant invest, because you have reached your limit') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'view',
								$project['Project']['slug']
							));
						}
					}
				}
			}
        }
    }
    public function onProjectFundBeforeAddValidation($event) 
    {
        $controller = $event->subject();
        $project = $controller->ProjectFund->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $event->data['data']['ProjectFund']['project_id'],
            ) ,
			'contain' => array(
				'Equity'
			) ,
            'recursive' => 0
        ));
        if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) {
			$db = ConnectionManager::getDataSource('default');
			$projectFunds = $db->query('SELECT SUM(ProjectFund.amount) as total_amount_invested, Equity.is_seis_or_eis FROM project_funds as ProjectFund LEFT JOIN project_equity_fields as Equity ON Equity.project_id = ProjectFund.project_id WHERE ProjectFund.user_id = ' . $controller->Auth->user('id') . ' AND ProjectFund.project_type_id = ' . ConstProjectTypes::Equity . ' AND ProjectFund.project_fund_status_id IN(' . ConstProjectFundStatus::Captured . ',' . ConstProjectFundStatus::PaidToOwner . ') AND ProjectFund.created >= \'' . date('Y-m-d', strtotime('now -1 year')) . '\' GROUP BY Equity.is_seis_or_eis');
            // Requirement for investors:
            // If SEIS Venture: 12 months - can invest < 100,000
            // If EIS Venture: 12 months - can invest < 1,000,000
			if (!empty($projectFunds)) {
				foreach($projectFunds as $projectFund) {
					if (!empty($project['Equity']['is_seis_or_eis']) && $project['Equity']['is_seis_or_eis'] == ConstActs::SEIS && !empty($projectFund[0]['is_seis_or_eis']) && $projectFund[0]['is_seis_or_eis'] == ConstActs::SEIS) {
						if (($projectFund[0]['total_amount_invested']+$controller->request->data['amount']) > 100000) {
							$controller->Session->setFlash(__l('You cant invest, because you have reached your limit') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'view',
								$project['Project']['slug']
							));
						}
					} else if(!empty($project['Equity']['is_seis_or_eis']) && $project['Equity']['is_seis_or_eis'] == ConstActs::EIS && !empty($projectFund[0]['is_seis_or_eis']) && $projectFund[0]['is_seis_or_eis'] == ConstActs::EIS) {
						if (($projectFund[0]['total_amount_invested']+$controller->request->data['amount']) > 1000000) {
							$controller->Session->setFlash(__l('You cant invest, because you have reached your limit') , 'default', null, 'error');
							$controller->redirect(array(
								'controller' => 'projects',
								'action' => 'view',
								$project['Project']['slug']
							));
						}
					}
				}
			}
        }
    }
}
?>