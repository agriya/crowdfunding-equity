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
class ProjectFlagsController extends AppController
{
    public $name = 'ProjectFlags';
    public $permanentCacheAction = array(
        'user' => array(
            'add',
        ) ,
    );
    public function beforeFilter() 
    {
        if (!isPluginEnabled('ProjectFlags')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    public function add($project_id = null) 
    {
        $this->pageTitle = sprintf(__l('Add %s') , sprintf(__l('%s Flag') , Configure::read('project.alt_name_for_project_singular_caps')));
        if (!empty($this->request->data)) {
            $this->ProjectFlag->create();
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->request->data['ProjectFlag']['user_id'] = $this->Auth->user('id');
            }
            $project = $this->ProjectFlag->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->data['Project']['id'],
                ) ,
                'recursive' => -1
            ));
            $this->request->data['ProjectFlag']['project_id'] = $this->request->data['Project']['id'];
            $this->request->data['ProjectFlag']['project_type_id'] = $project['Project']['project_type_id'];
            $this->request->data['ProjectFlag']['ip_id'] = $this->ProjectFlag->toSaveIp();
            if ($this->ProjectFlag->save($this->request->data)) {
                $data['Project']['id'] = $this->request->data['ProjectFlag']['project_id'];
                $data['Project']['is_user_flagged'] = 1;
                $this->ProjectFlag->Project->save($data);
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Flagged',
                        'label' => $this->Auth->user('username') ,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'ProjectFlag',
                        'action' => 'Flagged',
                        'label' => $project['Project']['id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $project['Project']['id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $this->Session->setFlash(sprintf(__l('%s has been added') , sprintf(__l('%s Flag') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    echo "success";
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'projects',
                        'action' => 'view',
                        $project['Project']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->request->data = $this->ProjectFlag->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $this->request->data['Project']['id'],
                    ) ,
                    'recursive' => 1
                ));
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , sprintf(__l('%s Flag') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ProjectFlag->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $project_id,
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $projectFlagCategories = $this->ProjectFlag->ProjectFlagCategory->find('list', array(
            'conditions' => array(
                'ProjectFlagCategory.is_active' => 1
            )
        ));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->ProjectFlag->User->find('list', array(
                'conditions' => array(
                    'User.is_active' => 1,
                    'User.is_email_confirmed' => 1
                ) ,
                'recursive' => -1
            ));
            $this->set(compact('users'));
        }
        $projects = $this->ProjectFlag->Project->find('list');
        $this->set(compact('users', 'projects', 'projectFlagCategories'));
    }
    public function admin_index() 
    {
        $this->pageTitle = sprintf(__l('%s Flags') , Configure::read('project.alt_name_for_project_singular_caps'));
        $this->ProjectFlag->recursive = 0;
        $conditions = array();
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['ProjectFlag.project_id'] = $this->request->params['named']['project_id'];
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['ProjectFlag.user_id'] = $this->request->params['named']['user_id'];
        }
        // condition for elememt in user view page
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'user_view') {
            if (!empty($this->request->params['named']['project_id'])) {
                $conditions['ProjectFlag.project_id'] = $this->request->params['named']['project_id'];
            }
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['ProjectFlag.project_id'] = $this->request->params['named']['project_id'];
            $project_name = $this->ProjectFlag->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= ' - ' . $project_name['Project']['name'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Project',
                'User' => array(
                    'UserAvatar'
                ) ,
                'ProjectFlagCategory' => array(
                    'fields' => array(
                        'ProjectFlagCategory.name'
                    )
                ) ,
                'Ip' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude',
                        'Ip.host'
                    )
                ) ,
            ) ,
            'order' => array(
                'ProjectFlag.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $this->set('projectFlags', $this->paginate());
        $moreActions = $this->ProjectFlag->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFlag->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Flag') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
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