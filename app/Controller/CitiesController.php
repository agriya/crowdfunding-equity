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
class CitiesController extends AppController
{
    public $name = 'Cities';
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        )
    );
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'State.id',
        );
        parent::beforeFilter();
    }
    public function index() 
    {
        $this->pageTitle = __l('Cities');
        $condition = array(
            'Project.is_active' => 1,
            'Project.is_admin_suspended' => 0,
            'Project.project_end_date >= ' => date('Y-m-d')
        );
        $cities = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'fields' => array(
                'City.id',
                'City.name',
                'City.slug',
                'City.project_count',
            ) ,
            'contain' => array(
                'Project' => array(
                    'fields' => array(
                        'Project.id'
                    ) ,
                    'conditions' => $condition
                )
            ) ,
            'order' => array(
                'City.project_count' => 'desc'
            ) ,
            'recursive' => 1
        ));
        $this->set('cities', $cities);
        $status_condition['Project.is_active'] = 1;
        $project_status = $this->City->Project->find('count', array(
            'conditions' => $status_condition
        ));
        $this->set('project_status', $project_status);
        unset($this->City->validate['name']);
    }
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        $this->disableCache();
        $this->pageTitle = __l('Cities');
        $conditions = array();
        $this->City->validate = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $this->pageTitle.= ' - ' . __l('Approved');
                $conditions[$this->modelClass . '.is_approved'] = 1;
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $this->pageTitle.= ' - ' . __l('Disapproved');
                $conditions[$this->modelClass . '.is_approved'] = 0;
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['City.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['State.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['Country.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $conditions['City.name !='] = '';
        $this->City->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'City.id',
                'City.name',
                'City.latitude',
                'City.longitude',
                'City.timezone',
                'City.county',
                'City.code',
                'City.is_approved',
                'State.name',
                'Country.name',
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'limit' => 15
        );
        if (!empty($this->request->data['City']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['City']['q']
            ));
        }
        $this->set('cities', $this->paginate());
        $this->set('pending', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved = ' => 0
            )
        )));
        $this->set('approved', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved = ' => 1
            )
        )));
        $filters = $this->City->isFilterOptions;
        $moreActions = $this->City->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('filters', $filters);
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('City'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $defaultCity = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => Configure::read('site.city')
            ) ,
            'fields' => array(
                'City.id'
            ) ,
            'recursive' => -1
        ));
        unset($this->City->validate['state_id']);
        if (!empty($defaultCity) && $id == $defaultCity['City']['id']) {
            $this->set('id_default_city', true);
        }
        if (!empty($this->request->data)) {
            $this->request->data['City']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->City->State->findOrSaveAndGetId($this->request->data['State']['name']);
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('City')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('City')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->City->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['City']['name'];
        $countries = $this->City->Country->find('list');
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved' => 1
            )
        ));
        $this->set(compact('countries', 'states'));
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('City'));
        unset($this->City->validate['state_id']);
        if (!empty($this->request->data)) {
            $this->request->data['City']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->City->State->findOrSaveAndGetId($this->request->data['State']['name']);
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('City')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('City')) , 'default', null, 'error');
            }
        }
        $countries = $this->City->Country->find('list');
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'order' => array(
                'State.name'
            )
        ));
        $this->set(compact('countries', 'states'));
    }
    // To change approve/disapprove status by admin
    public function admin_update_status($id = null, $status = null) 
    {
        if (is_null($id) || is_null($status)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->request->data['City']['id'] = $id;
        if ($status == 'disapprove') {
            $this->request->data['City']['is_approved'] = 0;
            $this->Session->setFlash(__l('Selected record has been disapproved') , 'default', null, 'success');
        }
        if ($status == 'approve') {
            $this->request->data['City']['is_approved'] = 1;
            $this->Session->setFlash(__l('Selected record has been approved') , 'default', null, 'success');
        }
        $this->City->save($this->request->data);
        if (!empty($this->request->query['r'])) {
            $this->redirect(Router::url('/', true) . $this->request->query['r']);
        } else {
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->City->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('City')) , 'default', null, 'success');
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
    public function check_city($city_name = null) 
    {
        $this->autoRender = false;
        if (!empty($this->request->params['named']['city_name'])) {
            $get_city = $this->City->find('first', array(
                'conditions' => array(
                    'City.name' => $this->request->params['named']['city_name'],
                    'City.is_approved' => 1,
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_city)) {
                echo $get_city['City']['slug'];
            }
        }
        exit;
    }
    public function admin_change_city() 
    {
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['City']['city_id'])) {
                $this->Session->write('city_filter_id', $this->request->data['City']['city_id']);
            } else {
                $this->Session->delete('city_filter_id');
            }
            $this->redirect(Router::url('/', true) . $this->request->data['City']['r']);
        }
    }
    public function admin_searcher() 
    {
        $this->Searcher->searchAction($this->RequestHandler->isAjax());
    }
}
?>