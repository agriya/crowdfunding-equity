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
class ProjectFollowersController extends AppController
{
    public $name = 'ProjectFollowers';
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        ) ,
    );
    public function index($project_id = null) 
    {
        $project = $this->ProjectFollower->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'recursive' => -1
        ));
        $this->set('project', $project);
        $conditions['ProjectFollower.project_id'] = $project_id;
        $limit = 20;
        $this->pageTitle = sprintf(__l('%s Followers') , Configure::read('project.alt_name_for_project_singular_caps'));
        if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'followers') {
            if ($this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
                if (Configure::read('site.friend_ids')) {
                    $conditions['NOT']['ProjectFollower.user_id'] = Configure::read('site.friend_ids');
                }
            }
            $limit = 5;
        }
        $this->ProjectFollower->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project' => array(
                    'fields' => array(
                        'Project.id',
                        'Project.slug',
                        'Project.user_id',
                        'Project.project_follower_count',
                    )
                )
            ) ,
            'limit' => $limit,
            'order' => array(
                'ProjectFollower.id' => 'desc'
            )
        );
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            Cms::dispatchEvent('Controller.Project.follow_listing', $this);
        } else {
            $total_follow = $this->ProjectFollower->find('count', array(
                'conditions' => $conditions
            ));
            $this->set('total_follow', $total_follow);
            $this->set('projectFollowers', $this->paginate());
            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'followers') {
                if ($this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
                    unset($conditions['NOT']);
                    if (!Configure::read('site.friend_ids')) {
                        $conditions['ProjectFollower.user_id'] = 0;
                    } else {
                        $conditions['ProjectFollower.user_id'] = array_values(Configure::read('site.friend_ids'));
                    }
                    $projectFollowerFriends = $this->ProjectFollower->find('all', array(
                        'conditions' => $conditions,
                        'contain' => array(
                            'User' => array(
                                'UserAvatar'
                            ) ,
                            'Project' => array(
                                'fields' => array(
                                    'Project.id',
                                    'Project.user_id',
                                    'Project.project_follower_count',
                                )
                            )
                        ) ,
                        'recursive' => 2,
                        'limit' => $limit
                    ));
                    $this->set('projectFollowerFriends', $projectFollowerFriends);
                } else {
                    $projectFollowerFriends = array();
                    $this->set('projectFollowerFriends', $projectFollowerFriends);
                }
                $this->autoRender = false;
                $this->render('followers_list');
            }
        }
    }
    public function add($project_id = null) 
    {
        if (is_null($project_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $project = $this->ProjectFollower->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $project_id
            ) ,
            'contain' => array(
                'User',
                'ProjectFollower' => array(
                    'fields' => array(
                        'ProjectFollower.user_id',
                        'ProjectFollower.id'
                    ) ,
                    'conditions' => array(
                        'ProjectFollower.user_id' => $this->Auth->user('id')
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($project)) {
            if (empty($project['ProjectFollower'])) {
                $this->ProjectFollower->create();
                $this->request->data['ProjectFollower']['user_id'] = $this->Auth->user('id');
                $this->request->data['ProjectFollower']['project_id'] = $project_id;
                $this->request->data['ProjectFollower']['project_type_id'] = $project['Project']['project_type_id'];
                $this->request->data['ProjectFollower']['action'] = 'add';
                if ($this->ProjectFollower->save($this->request->data)) {
                    $this->ProjectFollower->postActivity($project, ConstProjectActivities::ProjectFollower, $this->ProjectFollower->id);
                    $unfollow_url = Router::url(array(
                        'controller' => 'project_followers',
                        'action' => 'delete',
                        $this->ProjectFollower->id
                    ));
                    $response = array(
                        'message' => sprintf(__l('You are successfully following this %s') , Configure::read('project.alt_name_for_project_singular_small')) ,
                        'url' => $unfollow_url,
                        'class' => 'Unfollow'
                    );
                    $follower_id = $this->ProjectFollower->id;
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'Followed',
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
                            'category' => 'ProjectFollower',
                            'action' => 'Followed',
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
                        $event_data['follow_url'] = Router::url(array(
                            'controller' => 'project_followers',
                            'action' => 'unfollow',
                            $follower_id,
                            'ext' => 'json'
                        ) , true);
                        $event_data['follow_text'] = __l('Unfollow');
                        $event_data['follow_status'] = true;
                        $event_data['follow_message'] = sprintf(__l('You are successfully following this %s') , Configure::read('project.alt_name_for_project_singular_small'));
                        Cms::dispatchEvent('Controller.ProjectFollowers.unfollow', $this, array(
                            'data' => $event_data
                        ));
                    } elseif ($this->RequestHandler->isAjax()) {
                        $unfollow_url = Router::url(array(
                            'controller' => 'project_followers',
                            'action' => 'delete',
                            $follower_id
                        ));
						if (isPluginEnabled('SocialMarketing')) {
							$social_url = Router::url(array(
								'controller' => 'social_marketings',
								'action' => 'publish',
								$follower_id,
								'type' => 'facebook',
								'publish_action' => 'follow',
								'admin' => false
							) , true);
						}
                        echo __l('Unfollow') . '|' . $unfollow_url . '|' . $social_url;
                        exit;
                    } else {
                        $this->Session->setFlash(sprintf(__l('You are successfully following this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'success');
						 if (isPluginEnabled('SocialMarketing')) {
							$this->redirect(array(
								'controller' => 'social_marketings',
								'action' => 'publish',
								$follower_id,
								'type' => 'facebook',
								'publish_action' => 'follow',
								'admin' => false
							));
						 }
						$this->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug'],
                            'admin' => false
                        ));
                    }
                } else {
                    if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                        $event_data['follow_url'] = Router::url(array(
                            'controller' => 'project_followers',
                            'action' => 'add',
                            $project['Project']['id'],
                            'ext' => 'json'
                        ) , true);
                        $event_data['follow_text'] = __l('Follow');
                        $event_data['follow_status'] = false;
                        $event_data['follow_message'] = sprintf(__l('%s could not be added as follower. Please, try again') , Configure::read('project.alt_name_for_project_singular_caps'));
                        Cms::dispatchEvent('Controller.ProjectFollowers.follow', $this, array(
                            'data' => $event_data
                        ));
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be added as follower. Please, try again') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
                        $response = array(
                            'message' => sprintf(__l('%s could not be added as follower') , Configure::read('project.alt_name_for_project_singular_caps')) ,
                            'url' => 'project_followers/add/' . $project_id,
                            'class' => 'Follow'
                        );
                        $this->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug'],
                            'admin' => false
                        ));
                    }
                }
            } else {
                if ($this->RequestHandler->isAjax()) {
                    $follower_id = $this->ProjectFollower->id;
                    $this->set('followers_id', $follower_id);
                    $this->render('followers');
                } elseif ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                    $event_data['follow_url'] = Router::url(array(
                        'controller' => 'project_followers',
                        'action' => 'unfollow',
                        $project['ProjectFollower'][0]['id'],
                        'ext' => 'json'
                    ) , true);
                    $event_data['follow_text'] = __l('Unfollow');
                    $event_data['follow_status'] = false;
                    $event_data['follow_message'] = sprintf(__l('You have already following this %s') , Configure::read('project.alt_name_for_project_singular_small'));
                    Cms::dispatchEvent('Controller.ProjectFollowers.unfollow', $this, array(
                        'data' => $event_data
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('You have already following this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'error');
                    $unfollow_url = Router::url(array(
                        'controller' => 'project_followers',
                        'action' => 'delete',
                        $project['ProjectFollower'][0]['id']
                    ));
                    $response = array(
                        'message' => sprintf(__l('You have already following this %s') , Configure::read('project.alt_name_for_project_singular_small')) ,
                        'url' => $unfollow_url,
                        'class' => 'Unfollow'
                    );
                    $this->redirect(array(
                        'controller' => 'projects',
                        'action' => 'view',
                        $project['Project']['slug'],
                        'admin' => false
                    ));
                }
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectFollower = $this->ProjectFollower->find('first', array(
            'conditions' => array(
                'ProjectFollower.id' => $id
            ) ,
            'fields' => array(
                'Project.slug',
                'Project.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($projectFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFollower->delete($id)) {
            $this->Session->setFlash(sprintf(__l(' You have unfollowed this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'success');
            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                $event_data['follow_url'] = Router::url(array(
                    'controller' => 'project_followers',
                    'action' => 'add',
                    $projectFollower['Project']['id'],
                    'ext' => 'json'
                ) , true);
                $event_data['follow_text'] = __l('Follow');
                $event_data['follow_status'] = true;
                $event_data['follow_message'] = sprintf(__l('You have unfollowed this %s') , Configure::read('project.alt_name_for_project_singular_small'));
                Cms::dispatchEvent('Controller.ProjectFollowers.follow', $this, array(
                    'data' => $event_data
                ));
            } elseif ($this->RequestHandler->isAjax()) {
                $ajax_url = Router::url(array(
                    'controller' => 'project_followers',
                    'action' => 'add',
                    $id,
                ));
                echo "add" . '|' . $ajax_url;
                exit;
            } else {
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $projectFollower['Project']['slug']
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function unfollow($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectFollower = $this->ProjectFollower->find('first', array(
            'conditions' => array(
                'ProjectFollower.id' => $id
            ) ,
            'fields' => array(
                'Project.slug',
                'Project.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($projectFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFollower->delete($id)) {
            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                $event_data['follow_url'] = Router::url(array(
                    'controller' => 'project_followers',
                    'action' => 'add',
                    $projectFollower['Project']['id'],
                    'ext' => 'json'
                ) , true);
                $event_data['follow_text'] = __l('Follow');
                $event_data['follow_status'] = true;
                $event_data['follow_message'] = sprintf(__l('You have unfollowed this %s') , Configure::read('project.alt_name_for_project_singular_small'));
                Cms::dispatchEvent('Controller.ProjectFollowers.follow', $this, array(
                    'data' => $event_data
                ));
            } elseif ($this->RequestHandler->isAjax()) {
                $this->Session->setFlash(sprintf(__l(' You have unfollowed this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'success');
                $ajax_url = Router::url(array(
                    'controller' => 'project_followers',
                    'action' => 'add',
                    $id,
                ));
                echo "add" . '|' . $ajax_url;
                exit;
            } else {
                $this->Session->setFlash(sprintf(__l(' You have unfollowed this %s') , Configure::read('project.alt_name_for_project_singular_small')) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $projectFollower['Project']['slug']
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = sprintf(__l('%s Followers') , Configure::read('project.alt_name_for_project_singular_caps'));
        $conditions = '';
        $this->ProjectFollower->recursive = 0;
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->request->data['ProjectFollower']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['ProjectFollower.user_id'] = $this->request->params['named']['user_id'];
            $project_name = $this->ProjectFollower->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id'],
                ) ,
                'fields' => array(
                    'User.username',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - User - %s') , $project_name['User']['username']);
        }
        if (isset($this->request->params['named']['project_id'])) {
            $conditions['ProjectFollower.project_id'] = $this->request->params['named']['project_id'];
            $project_name = $this->ProjectFollower->Project->find('first', array(
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
            ) ,
            'order' => array(
                'ProjectFollower.id' => 'desc'
            )
        );
        $this->set('projectFollowers', $this->paginate());
        $moreActions = $this->ProjectFollower->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectFollower = $this->ProjectFollower->find('first', array(
            'conditions' => array(
                'ProjectFollower.id' => $id
            ) ,
            'fields' => array(
                'Project.slug',
                'Project.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($projectFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectFollower->delete($id)) {
            $this->Session->setFlash(sprintf(__l(' %s deleted') , sprintf(__l('%s Follower') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
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