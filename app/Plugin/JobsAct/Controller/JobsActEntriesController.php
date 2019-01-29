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
class JobsActEntriesController extends AppController
{
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Security->disabledFields = array(
            'JobsActEntry.project_id'
        );
    }
    public function add() 
    {
        $this->pageTitle = __l('JOBS Act - Questionaire');
        if (!empty($this->request->params['named']['project_id'])) {
            $project_id = $this->request->params['named']['project_id'];
        }
        $this->loadModel('Projects.Project');
        $project = $this->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id,
                'Project.is_admin_suspended' => 0,
                'Project.is_active' => 1,
            ) ,
            'contain' => array(
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
            ) ,
            'recursive' => 1
        ));
        $this->set('project', $project);
        if (!empty($this->request->data)) {
            if ($this->JobsActEntry->validates()) {
                $this->JobsActEntry->create();
                $this->request->data['JobsActEntry']['user_id'] = $this->Auth->user('id');
                $this->JobsActEntry->save($this->request->data);
                //Net worth: > 1,000,000
                //Annual Income: > 200,000 or > 300,000 (with spouse)
                //Total assets: > 5,000,000
                if ($this->request->data['JobsActEntry']['net_worth'] > 1000000 && ($this->request->data['JobsActEntry']['annual_income_individual'] > 200000 || $this->request->data['JobsActEntry']['annual_income_with_spouse'] > 300000)) {
                    $data['User']['user_id'] = $this->Auth->user('id');
                    $data['User']['is_accredited_investor'] = 1;
                    $this->User->save($data);
                }
                $this->redirect(array(
                    'controller' => 'project_funds',
                    'action' => 'add',
                    $this->request->data['JobsActEntry']['project_id']
                ));
            }
        }
    }
}
?>