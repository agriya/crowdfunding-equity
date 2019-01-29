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
class ProjectFlagCategoriesController extends AppController
{
    public $name = 'ProjectFlagCategories';
    public function beforeFilter() 
    {
        if (!isPluginEnabled('ProjectFlags')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    public function admin_index() 
    {
        $this->pageTitle = sprintf(__l('%s Flag Categories') , Configure::read('project.alt_name_for_project_singular_caps'));
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $conditions[$this->modelClass . '.is_active'] = 1;
                $this->pageTitle.= ' - ' . __l('Active');
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $conditions[$this->modelClass . '.is_active'] = 0;
                $this->pageTitle.= ' - ' . __l('Inactive');
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'ProjectFlagCategory.id',
                'ProjectFlagCategory.name',
                'ProjectFlagCategory.project_flag_count',
                'ProjectFlagCategory.is_active'
            ) ,
            'order' => array(
                'ProjectFlagCategory.id' => 'desc'
            )
        );
        $this->ProjectFlagCategory->recursive = 0;
        $this->set('projectFlagCategories', $this->paginate());
        $filters = $this->ProjectFlagCategory->isFilterOptions;
        $moreActions = $this->ProjectFlagCategory->moreActions;
        $this->set('filters', $filters);
        $this->set('moreActions', $moreActions);
        $this->set('pending', $this->ProjectFlagCategory->find('count', array(
            'conditions' => array(
                'ProjectFlagCategory.is_active' => 0
            )
        )));
        $this->set('approved', $this->ProjectFlagCategory->find('count', array(
            'conditions' => array(
                'ProjectFlagCategory.is_active' => 1
            )
        )));
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps')));
        if (!empty($this->request->data)) {
            $this->ProjectFlagCategory->create();
            if ($this->ProjectFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps')));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ProjectFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ProjectFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ProjectFlagCategory']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFlagCategory->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Flag Category') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
            if (!empty($this->request->query['r'])) {
                $this->redirect(Router::url('/', true) . $this->request->query['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>