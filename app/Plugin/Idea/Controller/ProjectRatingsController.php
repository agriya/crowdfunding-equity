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
class ProjectRatingsController extends AppController
{
    public $name = 'ProjectRatings';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        ) ,
    );
    public function index() 
    {
        if (empty($this->request->params['named']['project_id'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $backer = $this->ProjectRating->Project->ProjectFund->find('count', array(
            'conditions' => array(
                'ProjectFund.project_fund_status_id' => array(
                    ConstProjectFundStatus::Authorized,
                    ConstProjectFundStatus::PaidToOwner,
                    ConstProjectFundStatus::Closed,
                    ConstProjectFundStatus::DefaultFund
                ) ,
                'ProjectFund.project_id' => $this->request->params['named']['project_id'],
                'ProjectFund.user_id' => $this->Auth->user('id') ,
            ) ,
            'recursive' => -1
        ));
        $this->pageTitle = sprintf(__l('%s Votings') , Configure::read('project.alt_name_for_project_singular_caps'));
        $this->ProjectRating->recursive = 1;
        $this->paginate = array(
            'conditions' => array(
                'ProjectRating.project_id' => $this->request->params['named']['project_id']
            ) ,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project' => array(
                    'fields' => array(
                        'Project.id',
                        'Project.name',
                        'Project.slug',
                        'Project.project_rating_count'
                    )
                )
            ) ,
            'order' => array(
                'ProjectRating.id' => 'desc'
            )
        );
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = array();
            Cms::dispatchEvent('Controller.ProjectRating.listing', $this, array(
                'data' => $event_data
            ));
        }
        $projectRatings = $this->paginate();
        $this->set('projectRatings', $projectRatings);
        if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'votes') {
            $this->autoRender = false;
            $this->render('votes');
        }
    }
    public function add($project_id = null, $rate = null) 
    {
        if (is_null($project_id) || is_null($rate)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $rate = ($rate <= 0) ? 0 : (($rate > 5) ? 5 : $rate);
        if (empty($rate)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $project = $this->ProjectRating->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id,
            ) ,
            'contain' => array(
                'User',
                'ProjectRating' => array(
                    'fields' => array(
                        'ProjectRating.user_id'
                    ) ,
                    'conditions' => array(
                        'ProjectRating.user_id' => $this->Auth->user('id')
                    )
                ) ,
            ) ,
            'recursive' => 2
        ));
        if (!empty($project)) {
            if ($project['Project']['user_id'] != $this->Auth->user('id')) {
                $projectStatus = array();
                $response = Cms::dispatchEvent('Controller.ProjectType.GetProjectStatus', $this, array(
                    'projectStatus' => $projectStatus,
                    'project' => $project,
                    'type' => 'status',
                ));
                if (empty($project['ProjectRating'])) {
                    if (!empty($response->data['is_allow_to_vote'])) {
                        $this->ProjectRating->create();
                        $this->request->data['ProjectRating']['user_id'] = $this->Auth->user('id');
                        $this->request->data['ProjectRating']['rating'] = $rate;
                        $this->request->data['ProjectRating']['project_id'] = $project_id;
                        $this->request->data['ProjectRating']['project_type_id'] = $project['Project']['project_type_id'];
                        $this->request->data['ProjectRating']['ip_id'] = $this->ProjectRating->toSaveIp();
                        $this->request->data['ProjectRating']['action'] = 'add';
                        if ($this->ProjectRating->save($this->request->data)) {
							$rating_data = array();
							$rating_data['Project']['total_ratings'] = $project['Project']['total_ratings'] + $rate;
							$rating_data['Project']['id'] = $project_id;
							$this->ProjectRating->Project->save($rating_data);
                            $this->ProjectRating->postActivity($project, ConstProjectActivities::ProjectRating, $this->ProjectRating->id);
                            Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                '_trackEvent' => array(
                                    'category' => 'User',
                                    'action' => 'Voted',
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
                                    'category' => 'ProjectRating',
                                    'action' => 'Voted',
                                    'label' => $project['Project']['id'],
                                    'value' => '',
                                ) ,
                                '_setCustomVar' => array(
                                    'pd' => $project['Project']['id'],
                                    'ud' => $this->Auth->user('id') ,
                                    'rud' => $this->Auth->user('referred_by_user_id') ,
                                )
                            ));
                            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                                Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                                    'data' => array(
                                        'status' => 0,
                                        'message' => sprintf(__l('%s has been added') , __l('Voting')),
                                    ) 
                                ));
                            } else {
                                if (!$this->RequestHandler->isAjax()) {
                                    $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Voting')) , 'default', null, 'success');
                                }
                            }
                        } else {
                            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                                Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                                    'data' => array(
                                        'status' => 1,
                                        'message' => 'Voting could not be added. Please, try again'
                                    ) 
                                ));
                            } else {
                                if (!$this->RequestHandler->isAjax()) {
                                    $this->Session->setFlash(sprintf(__l('Voting could not be added. Please, try again') , __l('Voting')) , 'default', null, 'error');
                                }
                            }
                        }
                    } else {
                        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                            Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                                'data' => array(
                                    'status' => 1,
                                    'message' => 'Invalid request'
                                ) 
                            ));
                        } else {
                            $this->Session->setFlash(__l('Invalid request') , 'default', null, 'error');
                        }
                    }
                } else {
                    if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                        Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                            'data' => array(
                                'status' => 1,
                                'message' => sprintf(__l('You have already voted this %s') , Configure::read('project.alt_name_for_project_singular_small'))
                            ) 
                        ));
                    } else {
                        $this->Session->setFlash(sprintf(__l('You have already voted this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'error');
                    }
                }
            } else {
                if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                    Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                        'data' => array(
                            'status' => 1,
                            'message' => sprintf(__l('You have already voted this %s') , Configure::read('project.alt_name_for_project_singular_small'))
                        ) 
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('You cannot vote your own %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'error');
                }
            }
            if ($this->RequestHandler->isAjax()) {
                $project = $this->ProjectRating->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $project_id
                    ) ,
                    'fields' => array(
                        'Project.id',
                        'Project.total_ratings',
                        'Project.project_rating_count',
                        'Project.actual_rating',
                    ) ,
                    'recursive' => -1
                ));
                $this->set('project', $project);
            } else {
                if (!$this->RequestHandler->prefers('json')) {
                    $this->redirect(array(
                        'controller' => 'projects',
                        'action' => 'view',
                        $project['Project']['slug']
                    ));
                }
            }
        } else {
            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                Cms::dispatchEvent('Controller.ProjectRating.add', $this, array(
                    'data' => array(
                        'status' => 1,
                        'message' => 'Invalid request'
                    ) 
                ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->set('rate', $rate);
        $this->pageTitle = sprintf(__l('Add %s') , sprintf(__l('%s Voting') , Configure::read('project.alt_name_for_project_singular_caps')));
    }
    public function admin_index() 
    {
        $this->_redirectPOST2Named(array(
            'q'
        ));
        $this->pageTitle = sprintf(__l('%s Votings') , Configure::read('project.alt_name_for_project_singular_caps'));
        $conditions = array();
        if (isset($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['project_id'] = $this->request->params['named']['project_id'];
            $project_name = $this->ProjectRating->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - %s - %s') , Configure::read('project.alt_name_for_project_singular_caps') , $project_name['Project']['name']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Project',
                'User',
            ) ,
            'order' => array(
                'ProjectRating.id' => 'desc'
            )
        );
        $this->ProjectRating->recursive = 0;
        $this->set('projectRatings', $this->paginate());
        $moreActions = $this->ProjectRating->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectRating->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Voting')) , 'default', null, 'success');
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