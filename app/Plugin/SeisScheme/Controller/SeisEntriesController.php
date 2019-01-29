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
class SeisEntriesController extends AppController
{
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Security->disabledFields = array();
	if($this->RequestHandler->prefers('json') && $this->request->params['action'] == 'add') {
            $this->Security->validatePost = false;
        }
    }
    public function add() 
    {
        $this->pageTitle = __l('SEIS Scheme - Questionaire');
	if ($this->RequestHandler->prefers('json') && ($this->request->is('post')))
	{
	    $this->request->data['SeisEntry'] = $this->request->data;
	}
        if (!empty($this->request->data)) {
            $this->SeisEntry->set($this->request->data);
            if ($this->SeisEntry->validates()) {
                // @todo project update
                $data['Project']['user_id'] = $this->Auth->user('id');
                $data['Project']['project_end_date'] = date('Y-m-d', strtotime('+1 days'));
                $this->loadModel('Project.Project');
                $this->Project->save($data);
                $this->SeisEntry->create();
                $this->request->data['SeisEntry']['user_id'] = $this->Auth->user('id');
                $this->request->data['SeisEntry']['project_id'] = $this->Project->id;
                // years in trading
                $curr_date = explode("-", date('y-m-d'));
                $total_years = $curr_date[0]-$this->request->data['SeisEntry']['year_of_founding']['year'];
                if ($total_years < 2 && $this->request->data['SeisEntry']['number_of_employees'] < 25 && $this->request->data['SeisEntry']['total_asset'] < 200000) {
                    /*	SEIS Rule :
                    Requirement for entrepreneur to get HMRC certificate:
                    < 2 years in trading
                    < 25 employees
                    < 200,000 asset */
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = ConstActs::SEIS;
                } else if ($this->request->data['SeisEntry']['number_of_employees'] < 250 && $this->request->data['SeisEntry']['total_asset'] < 7000000) {
                    /*  EIS Rule:
                    Requirement for entrepreneur:
                    < 250 employee
                    < 7,000,000 asset */
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = ConstActs::EIS;
                } else {
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = 0;
                }
                $this->SeisEntry->save($this->request->data);
                $this->loadModel('Equity.Equity');
                $data['Equity']['project_id'] = $this->Project->id;
                $data['Equity']['is_seis_or_eis'] = $this->request->data['SeisEntry']['is_seis_or_eis'];
                $this->Equity->save($data);
		if (!$this->RequestHandler->prefers('json')) {
		    if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
			    $this->redirect(array(
				    'controller' => 'projects',
				    'action' => 'add',
				    $this->Project->id,
				    'project_type' => 'equity'
			    ));
		    } else {
			    $this->redirect(array(
				    'controller' => 'equity',
				    'action' => 'add',
				    $this->Project->id
			    ));
		    }
		} else {
		    $this->set('iphone_response', array("message" =>__l('Company added successfully.') , "error" => 0, "project_id" => $this->Project->id));   
		}
            } else {
		if ($this->RequestHandler->prefers('json')) {
                    $this->set('iphone_response', array("message" =>__l('Company not added.') , "error" => 1));
                }
	    }
	    
	    if ($this->RequestHandler->prefers('json')) {
	        $response = Cms::dispatchEvent('Controller.SeisEntry.Add', $this, array('data' => $this->request->data));
	    }
        }
    }
	public function admin_add()
	{
		$this->setAction('add');
	}
	public function admin_edit($id)
	{
		$this->setAction('edit', $id);
	}
    public function edit($id) 
    {
        $this->pageTitle = __l('SEIS Scheme - Questionaire');
        if (!empty($this->request->data)) {
            $this->SeisEntry->set($this->request->data);
            if ($this->SeisEntry->validates()) {
                // @todo project update
                $data['Project']['id'] = $this->request->data['SeisEntry']['project_id'];
                $this->loadModel('Project.Project');
                $this->Project->save($data);
                $this->request->data['SeisEntry']['user_id'] = $this->Auth->user('id');
                $this->request->data['SeisEntry']['project_id'] = $this->Project->id;
                // years in trading
                $curr_date = explode("-", date('y-m-d'));
                $total_years = $curr_date[0]-$this->request->data['SeisEntry']['year_of_founding']['year'];
                if ($total_years < 2 && $this->request->data['SeisEntry']['number_of_employees'] < 25 && $this->request->data['SeisEntry']['total_asset'] < 200000) {
                    /*	SEIS Rule :
                    Requirement for entrepreneur to get HMRC certificate:
                    < 2 years in trading
                    < 25 employees
                    < 2,00,000 asset */
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = ConstActs::SEIS;
                } else if ($this->request->data['SeisEntry']['number_of_employees'] < 250 && $this->request->data['SeisEntry']['total_asset'] < 7000000) {
                    /*  EIS Rule:
                    Requirement for entrepreneur:
                    < 250 employee
                    < 5,000,000 - can raise in 12 months
                    < 7,000,000 asset 			*/
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = ConstActs::EIS;
                } else {
                    $this->request->data['SeisEntry']['is_seis_or_eis'] = 0;
                }
                $this->SeisEntry->save($this->request->data);
                $this->redirect(array(
					'controller' => 'projects',
					'action' => 'edit',
					$this->Project->id,
					'seis' => 1
				));
            }
        } else {
            $this->request->data = $this->SeisEntry->find('first', array(
                'conditions' => array(
                    'SeisEntry.project_id' => $id
                )
            ));
        }
    }
}
?>