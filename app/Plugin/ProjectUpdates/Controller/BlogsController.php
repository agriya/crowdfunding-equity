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
class BlogsController extends AppController
{
    public $name = 'Blogs';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'view',
            'add',
            'edit',
        ) ,
    );
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'Blog.publish',
            'Blog.draft',
            '_wysihtml5_mode',
        );
        if (!Configure::read('suspicious_detector.is_enabled') && !Configure::read('Project.auto_suspend_update_on_system_flag')) {
            $this->Blog->Behaviors->detach('SuspiciousWordsDetector');
        }
        parent::beforeFilter();
    }
    public function index() 
    {
        $this->pageTitle = sprintf(__l('%s Updates') , Configure::read('project.alt_name_for_project_singular_caps'));
        //Redirect Get to namedparams
        $this->_redirectGET2Named(array(
            'q',
            'project_id'
        ));
        if (isset($this->request->params['named']['project_id'])) {
            $this->request->data['Blog']['project_id'] = $this->request->params['named']['project_id'];
        }
        if (empty($this->request->params['named']['project_id']) && empty($this->request->params['named']['project']) && (empty($this->request->params['named']['tag'])) && (!isset($this->request->params['named']['q']))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            if ($this->Auth->user('id')) {
                $conditions['OR']['Blog.user_id'] = $this->Auth->user('id');
                $conditions['OR']['Blog.is_admin_suspended'] = '0';
            } else {
                $conditions['Blog.is_admin_suspended'] = '0';
            }
        }
        if (!empty($this->request->params['named']['tag'])) {
            $blogTag = $this->Blog->BlogTag->find('first', array(
                'conditions' => array(
                    'BlogTag.slug' => $this->request->params['named']['tag']
                ) ,
                'fields' => array(
                    'BlogTag.name',
                    'BlogTag.slug'
                ) ,
                'contain' => array(
                    'Blog' => array(
                        'fields' => array(
                            'Blog.id'
                        )
                    )
                ) ,
                'recursive' => 1
            ));
            if (empty($blogTag)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $ids = array();
            if (!empty($blogTag)) {
                foreach($blogTag['Blog'] as $blog) {
                    $ids[] = $blog['id'];
                }
            }
            $conditions['Blog.id'] = $ids;
        }
        if (!empty($this->request->params['named']['project_id']) || !empty($this->request->params['named']['project'])) {
            $projectconditions = array();
            if (!empty($this->request->params['named']['project'])) {
                $projectconditions['Project.slug'] = $this->request->params['named']['project'];
            } else {
                $projectconditions['Project.id'] = $this->request->params['named']['project_id'];
            }
            $project_owner = $this->Blog->Project->find('first', array(
                'conditions' => $projectconditions,
                'fields' => array(
                    'Project.user_id',
                    'Project.name',
                    'Project.slug',
                    'Project.id',
                ) ,
                'recursive' => -1
            ));
            if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                $project = $this->Blog->Project->find('first', array(
                    'conditions' => $projectconditions,
                    'recursive' => 3
                ));
                $backer = $this->Blog->Project->ProjectFund->find('count', array(
                    'conditions' => array(
                        'ProjectFund.project_fund_status_id' => array(
                            ConstProjectFundStatus::Authorized,
                            ConstProjectFundStatus::PaidToOwner,
                            ConstProjectFundStatus::Closed,
                            ConstProjectFundStatus::DefaultFund
                        ) ,
                        'ProjectFund.project_id' => $project['Project']['id']
                    ) ,
                    'recursive' => -1
                ));
                $event_data['project'] = $project;
                $event_data['backer'] = $backer;
                Cms::dispatchEvent('Controller.Project.view', $this, array(
                    'data' => $event_data
                ));
            }
            $conditions['Blog.project_id'] = $project_owner['Project']['id'];
            $this->request->params['named']['project_id'] = $project_owner['Project']['id'];
            $this->set('project_id', $project_owner['Project']['id']);
            $this->pageTitle = $project_owner['Project']['name'] . ' - ' . __l('updates');
            $this->set('project_owner', $project_owner['Project']['user_id']);
            $this->set('project_slug', $project_owner['Project']['slug']);
        }
        if (!empty($this->request->params['named']['q'])) {
            $this->request->data['Blog']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(' - Search - %s', $this->request->params['named']['q']);
        }
        $conditions['Blog.is_published'] = 1;
        if (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'drafted') {
            $conditions['Blog.is_published'] = 0;
            $this->pageTitle = __l('Drafted Updates');
        }
        if (!empty($this->request->params['named']['username'])) {
            $this->pageTitle.= sprintf(' - User - %s', $this->request->params['named']['username']);
            $conditions['User.username'] = $this->request->params['named']['username'];
        }
        if (!empty($this->request->params['named']['tag'])) {
            $blogTag = $this->Blog->BlogTag->find('first', array(
                'conditions' => array(
                    'BlogTag.slug' => $this->request->params['named']['tag']
                ) ,
                'fields' => array(
                    'BlogTag.name',
                    'BlogTag.slug'
                ) ,
                'contain' => array(
                    'Blog' => array(
                        'fields' => array(
                            'Blog.id'
                        )
                    )
                ) ,
                'recursive' => 1
            ));
            if (empty($blogTag)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->pageTitle.= sprintf(__l(' - Tag - %s') , $blogTag['BlogTag']['name']);
            $ids = array();
            foreach($blogTag['Blog'] as $blog) {
                $ids[] = $blog['id'];
            }
            $conditions['Blog.id'] = $ids;
        }
        $this->Blog->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                ) ,
                'BlogTag' => array(
                    'fields' => array(
                        'BlogTag.name',
                        'BlogTag.slug'
                    )
                ) ,
                'BlogComment' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                    'fields' => array(
                        'BlogComment.id',
                        'BlogComment.created',
                        'BlogComment.comment',
                        'BlogComment.user_id',
                    ) ,
                    'conditions' => array(
                        'BlogComment.is_admin_suspended !=' => 1,
                        'BlogComment.is_system_flagged !=' => 1,
                    ) ,
                )
            ) ,
            'order' => array(
                'Blog.id' => 'desc'
            ) ,
        );
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = array();
            Cms::dispatchEvent('Controller.Blog.listing', $this, array(
                'data' => $event_data
            ));
        }
        if (!empty($this->request->data['Blog']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['Blog']['q']
            ));
        }
        $this->set('blogs', $this->paginate());
    }
    public function view($slug = null) 
    {
        $this->pageTitle = __l('Update');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $blog = $this->Blog->find('first', array(
            'conditions' => array(
                'Blog.slug = ' => $slug
            ) ,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                    'Attachment',
                ) ,
                'BlogTag' => array(
                    'fields' => array(
                        'BlogTag.name',
                        'BlogTag.slug',
                        'BlogTag.id'
                    )
                )
            ) ,
            'recursive' => 3
        ));
        if (empty($blog)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->Blog->BlogView->create();
        $this->request->data['BlogView']['user_id'] = $this->Auth->user('id');
        $this->request->data['BlogView']['blog_id'] = $blog['Blog']['id'];
        $this->request->data['BlogView']['ip_id'] = $this->Blog->BlogView->toSaveIp();
        $this->Blog->BlogView->save($this->request->data);
        $this->pageTitle.= ' - ' . $blog['Blog']['title'];
        $this->request->data['BlogComment']['blog_id'] = $blog['Blog']['id'];
        $this->set(compact('blog'));
    }
    public function add($project_id = null) 
    {
        $this->pageTitle = sprintf(__l('Add %s') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps')));
        if (!empty($this->request->data)) {
            $this->request->data['Blog']['is_published'] = (isset($this->request->data['Blog']['draft'])) ? 0 : 1;
            $this->Blog->create();
            $this->Blog->set($this->request->data);
            if ($this->Blog->validates()) {
                $project = $this->Blog->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $this->request->data['Blog']['project_id']
                    ) ,
                    'contain' => array(
                        'User'
                    ) ,
                    'recursive' => 0
                ));
                $this->request->data['Blog']['project_type_id'] = $project['Project']['project_type_id'];
                $this->request->data['Blog']['user_id'] = $this->Auth->user('id');
                if ($this->Blog->save($this->request->data)) {
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'UpdatePosted',
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
                            'category' => 'ProjectUpdate',
                            'action' => 'UpdatePosted',
                            'label' => $project['Project']['id'],
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'pd' => $project['Project']['id'],
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    $blog = $this->Blog->find('first', array(
                        'conditions' => array(
                            'Blog.id' => $this->Blog->id
                        ) ,
                        'recursive' => -1
                    ));
                    if ($blog['Blog']['is_admin_suspended']) {
                        $this->Session->setFlash(__l('Update has been suspended due to containing suspicious words') , 'default', null, 'error');
                    } else if ($this->request->data['Blog']['is_published']) {
                        $this->Blog->postActivity($project, ConstProjectActivities::ProjectUpdate, $this->Blog->id);
                        $this->Session->setFlash(sprintf(__l('%s update has been published') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s update has been drafted') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'success');
                    }
                    if (!empty($this->request->params['admin'])) {
                        $this->redirect(array(
                            'controller' => 'blogs',
                            'action' => 'index',
                            'admin' => 'true',
                        ));
                    } elseif (!$this->RequestHandler->isAjax()) {
                        $this->redirect(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug'] . '#updates'
                        ));
                    } else {
                        $url = Router::url(array(
                            'controller' => 'projects',
                            'action' => 'view',
                            $project['Project']['slug']
                        ) , true);
                        echo "redirect*" . $url;
                        $this->autoRender = false;
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['project_id']) || !empty($this->request->data['Blog']['project_id'])) {
            $this->request->data['Blog']['project_id'] = !empty($this->request->params['named']['project_id']) ? $this->request->params['named']['project_id'] : $this->request->data['Blog']['project_id'];
            $project = $this->Blog->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->data['Blog']['project_id']
                ) ,
                'contain' => array(
                    'Attachment',
                    'ProjectType'
                ) ,
                'recursive' => 0
            ));
            $this->set('project', $project);
        }
        if ((!empty($project['Project']['user_id']) && $project['Project']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') == ConstUserTypes::User)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $projects = $this->Blog->Project->find('list');
            $this->set(compact('projects'));
        }
        if ($this->RequestHandler->isAjax()) {
            $this->set('request_handler', "ajax");
        } else {
            $this->set('request_handler', "normal");
        }
    }
    public function edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps')));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->request->data['Blog']['is_published'] = (isset($this->request->data['Blog']['draft'])) ? 0 : 1;
            $this->Blog->set($this->request->data);
            $tmpBlog = $this->Blog->find('first', array(
                'conditions' => array(
                    'Blog.id' => $this->request->data['Blog']['id']
                ) ,
                'recursive' => -1
            ));
            if ($this->Blog->validates()) {
                if ($this->Blog->save($this->request->data)) {
                    $project = $this->Blog->Project->find('first', array(
                        'conditions' => array(
                            'Project.id' => $tmpBlog['Blog']['project_id']
                        ) ,
                        'contain' => array(
                            'User'
                        ) ,
                        'recursive' => 0
                    ));
                    if (empty($tmpBlog['Blog']['is_published']) && !empty($this->request->data['Blog']['is_published'])) {
                        $this->Blog->postActivity($project, ConstProjectActivities::ProjectUpdate, $this->Blog->id);
                    }
                    $this->Session->setFlash(sprintf(__l('%s has been updated') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                    if (!empty($this->request->params['admin'])) {
                        $this->redirect(array(
                            'controller' => 'blogs',
                            'action' => 'index',
                            'admin' => 'true',
                        ));
                    } else {
                        if (!$this->RequestHandler->isAjax()) {
                            $this->redirect(array(
                                'controller' => 'projects',
                                'action' => 'view',
                                $project['Project']['slug'] . '#updates'
                            ));
                        } else {
                            $url = Router::url(array(
                                'controller' => 'projects',
                                'action' => 'view',
                                $project['Project']['slug'] . '#updates'
                            ) , true);
                            echo "redirect*" . $url;
                            $this->autoRender = false;
                        }
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        } else {
            $conditions = array(
                'Blog.id' => $id
            );
            $this->request->data = $this->Blog->find('first', array(
                'fields' => array(
                    'Blog.title',
                    'Blog.slug',
                    'Blog.content',
                    'Blog.project_id',
                    'Blog.is_published'
                ) ,
                'conditions' => $conditions,
                'contain' => array(
                    'BlogTag' => array(
                        'fields' => array(
                            'BlogTag.name'
                        )
                    )
                ) ,
                'recursive' => 1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (!empty($this->request->data['BlogTag'])) {
                $this->request->data['Blog']['tag'] = $this->Blog->formatTags($this->request->data['BlogTag']);
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Blog']['title'];
        $project = $this->Blog->Project->find('first', array(
            'conditions' => array(
                'Project.id' => $this->request->data['Blog']['project_id']
            ) ,
            'contain' => array(
                'Attachment',
                'ProjectType'
            ) ,
            'recursive' => 0
        ));
        $this->set('project', $project);
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $projects = $this->Blog->Project->find('list');
            $this->set(compact('projects'));
        }
        if ($this->RequestHandler->isAjax()) {
            $this->set('request_handler', "ajax");
        } else {
            $this->set('request_handler', "normal");
        }
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $blog = $this->Blog->find('first', array(
            'conditions' => array(
                'Blog.id' => $id,
            ) ,
			'recursive' => 0
        ));
        if ($this->Blog->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'projects',
                'action' => 'view',
                $blog['Project']['slug'],
                'admin' => false
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index($status = null) 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['project_id'])) {
            $project_name = $this->Blog->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle = sprintf(__l('%s Updates - %s') , Configure::read('project.alt_name_for_project_singular_caps') , $project_name['Project']['name']);
            $conditions['Blog.project_id'] = $this->request->params['named']['project_id'];
        } else {
            $this->pageTitle = sprintf(__l('%s Updates') , Configure::read('project.alt_name_for_project_singular_caps'));
        }
        if (!empty($this->request->params['named']['category'])) {
            $blogCategory = $this->{$this->modelClass}->BlogCategory->find('first', array(
                'conditions' => array(
                    'BlogCategory.id' => $this->request->params['named']['category']
                ) ,
                'fields' => array(
                    'BlogCategory.id',
                    'BlogCategory.title',
                ) ,
                'recursive' => -1
            ));
            if (empty($blogCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['BlogCategory.id'] = $blogCategory['BlogCategory']['id'];
            $this->pageTitle.= ' - ' . $blogCategory['BlogCategory']['title'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['Blog']['q'] = $this->request->params['named']['q'];
            $conditions['AND']['OR']['Blog.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR']['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR']['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Blog']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Blog']['filter_id'])) {
            if ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Blog.is_published'] = 1;
                $this->pageTitle.= ' - ' . __l('Published');
            } else if ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Blog.is_published'] = 0;
                $this->pageTitle.= ' - ' . __l('Draft');
            } else if ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Blog.is_admin_suspended'] = 1;
                $this->pageTitle.= ' - ' . __l('Suspended');
            } elseif ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Blog.is_active'] = 1;
                $conditions['Blog.is_admin_suspended'] = 0;
                $this->pageTitle.= ' - ' . __l('Active');
            } elseif ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Blog.is_active'] = 0;
                $this->pageTitle.= ' - ' . __l('Inactive');
            } elseif ($this->request->data['Blog']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Blog.is_system_flagged'] = 1;
                $this->pageTitle.= ' - ' . __l('Flagged');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Blog']['filter_id'];
        }
        $this->Blog->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project',
                'BlogTag' => array(
                    'fields' => array(
                        'BlogTag.name',
                        'BlogTag.slug'
                    )
                )
            ) ,
            'order' => array(
                'Blog.id' => 'desc'
            ) ,
        );
        if (!empty($this->request->data['Blog']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['Blog']['q']
            ));
        }
        $this->set('blogs', $this->paginate());
        // To get published and drafted blogs count
        $published_blogs = $this->Blog->find('count', array(
            'conditions' => array(
                'Blog.is_published' => 1
            )
        ));
        $drafted_blogs = $this->Blog->find('count', array(
            'conditions' => array(
                'Blog.is_published' => 0
            )
        ));
        $this->set('suspended', $this->Blog->find('count', array(
            'conditions' => array(
                'Blog.is_admin_suspended = ' => 1,
            )
        )));
        $this->set('system_flagged', $this->Blog->find('count', array(
            'conditions' => array(
                'Blog.is_system_flagged = ' => 1,
            )
        )));
        $this->set('published_blogs', $published_blogs);
        $this->set('drafted_blogs', $drafted_blogs);
        $moreActions = $this->Blog->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_view($slug = null) 
    {
        $this->setAction('view', $slug);
    }
    public function admin_add() 
    {
        $this->setAction('add');
    }
    public function admin_edit($id = null) 
    {
        $this->setAction('edit', $id);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Blog->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Update') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
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
