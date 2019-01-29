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
class BlogCommentsController extends AppController
{
    public $name = 'BlogComments';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'view',
            'add',
        ) ,
    );
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'BlogComment.display'
        );
        if (!isPluginEnabled('ProjectUpdates')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!Configure::read('suspicious_detector.is_enabled') && !Configure::read('Project.auto_suspend_update_comment_on_system_flag')) {
            $this->Blog->Behaviors->detach('SuspiciousWordsDetector');
        }
        parent::beforeFilter();
    }
    public function index($blog_id = null, $span_val = null) 
    {
        if (!isset($span_val)) {
            $span_val = 3;
        }
        $this->pageTitle = __l('Update Comments');
        $blog = $this->BlogComment->Blog->find('first', array(
            'conditions' => array(
                'Blog.id' => $blog_id
            ) ,
            'contain' => array(
                'Project' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username'
                        )
                    )
                )
            ) ,
            'recursive' => 2
        ));
        if (empty($blog)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $conditions['BlogComment.blog_id'] = $blog_id;
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['BlogComment.is_admin_suspended <>'] = 1;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'Blog' => array(
                    'fields' => array(
                        'Blog.title',
                        'Blog.slug',
                        'Blog.project_id'
                    )
                )
            ) ,
            'order' => array(
                'BlogComment.id' => 'DESC'
            ) ,
            'limit' => 10
        );
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = array();
            Cms::dispatchEvent('Controller.BlogComment.listing', $this, array(
                'data' => $event_data
            ));
        }
        $this->BlogComment->recursive = 0;
        $this->set('blogComments', $this->paginate());
        $this->set('blog', $blog);
        $this->set('span_val', $span_val);
    }
    public function add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Update Comment'));
        $blog = array();
        $blogId = !empty($this->request->data['BlogComment']['blog_id']) ? $this->request->data['BlogComment']['blog_id'] : $this->request->params['named']['blog_id'];
        $blog = $this->BlogComment->Blog->find('first', array(
            'conditions' => array(
                'Blog.id' => $blogId
            ) ,
            'contain' => array(
                'Project' => array(
                    'User',
                    'ProjectType'
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $this->set('blog', $blog);
        if (!empty($this->request->data)) {
            $this->request->data['BlogComment']['user_id'] = $this->Auth->user('id');
            $this->request->data['BlogComment']['project_id'] = $blog['Blog']['project_id'];
            $this->request->data['BlogComment']['project_type_id'] = $blog['Project']['project_type_id'];
            $this->request->data['BlogComment']['ip_id'] = $this->BlogComment->toSaveIp();
            $this->BlogComment->create();
            if ($this->BlogComment->save($this->request->data)) {
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'UpdateCommented',
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
                        'category' => 'ProjectUpdateComment',
                        'action' => 'UpdateCommented',
                        'label' => $blog['Project']['id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $blog['Project']['id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $blogComment = $this->BlogComment->find('first', array(
                    'conditions' => array(
                        'BlogComment.id' => $this->BlogComment->id
                    ) ,
                    'recursive' => -1
                ));
                if ($blogComment['BlogComment']['is_admin_suspended']) {
                    if (!$this->RequestHandler->isAjax()) {
                        $this->Session->setFlash(sprintf(__l('%s update Comment has been suspended due to containing suspicious words.') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
                        if (!empty($this->request->data['BlogComment']['redirect_url'])) {
                            $this->redirect($this->request->data['BlogComment']['redirect_url']);
                        } else {
                            $this->redirect(array(
                                'controller' => 'projects',
                                'action' => 'view',
                                $blog['Project']['slug'] . '#updates'
                            ));
                        }
                    } else {
                        $this->setAction('view', $this->BlogComment->id, 'view_ajax', ($this->request->data['BlogComment']['display'] == "update") ? 3 : 2);
                    }
                } else {
                    $this->BlogComment->postActivity($blog, ConstProjectActivities::ProjectUpdateComment, $this->BlogComment->id);
                    if (!$this->RequestHandler->isAjax()) {
                        $this->Session->setFlash(sprintf(__l('%s has been added') , sprintf(__l('%s Update Comment') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                        if (!empty($this->request->data['BlogComment']['redirect_url'])) {
                            $this->redirect($this->request->data['BlogComment']['redirect_url']);
                        } else {
                            $this->redirect(array(
                                'controller' => 'projects',
                                'action' => 'view',
                                $blog['Project']['slug'] . '#updates'
                            ));
                        }
                    } else {
                        $this->setAction('view', $this->BlogComment->id, 'view_ajax', ($this->request->data['BlogComment']['display'] == "update") ? 3 : 2);
                    }
                    $this->set('blogComment', $blogComment);
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , sprintf(__l('%s Update Comment') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['blog_id'])) {
            $this->request->data['BlogComment']['blog_id'] = $this->request->params['named']['blog_id'];
        }
        if (!empty($this->request->params['named']['display'])) {
            $this->request->data['BlogComment']['display'] = $this->request->params['named']['display'];
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->set('request_handler', "ajax");
        } else {
            $this->set('request_handler', "normal");
        }
    }
    public function view($id = null, $view_name = 'view', $span_val = 2) 
    {
        $this->pageTitle = __l('Update Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $blogComment = $this->BlogComment->find('first', array(
            'conditions' => array(
                'BlogComment.id = ' => $id,
            ) ,
            'contain' => array(
                'User' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename'
                        )
                    ) ,
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'Blog' => array(
                    'Project' => array(
                        'fields' => array(
                            'Project.user_id',
                        )
                    ) ,
                    'fields' => array(
                        'Blog.title',
                        'Blog.slug',
                        'Blog.project_id',
                        'Blog.id'
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        if (empty($blogComment)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('span_val', $span_val);
        $this->pageTitle.= ' - ' . $blogComment['BlogComment']['id'];
        $this->set('blogComment', $blogComment);
        if ($view_name == 'view') {
            $this->autoRender = false;
        } else {
            $this->render($view_name);
        }
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $blog = $this->BlogComment->find('first', array(
            'conditions' => array(
                'BlogComment.id' => $id
            ) ,
            'fields' => array(
                'Blog.slug'
            ) ,
            'recursive' => 0
        ));
        if (empty($blog)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BlogComment->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Update Comment') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'view',
                    $blog['Blog']['slug']
                ));
            } else {
                echo 'success';
                $this->autoRender = false;
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
        $this->pageTitle = sprintf(__l('%s Update Comments') , Configure::read('project.alt_name_for_project_singular_caps'));
        $conditions = array();
        if (!empty($this->request->params['named']['blog']) || !empty($this->request->params['named']['blog'])) {
            $blog = $this->{$this->modelClass}->Blog->find('first', array(
                'conditions' => array(
                    'Blog.id' => $this->request->params['named']['blog']
                ) ,
                'fields' => array(
                    'Blog.id',
                    'Blog.title',
                    'Blog.slug'
                ) ,
                'recursive' => -1
            ));
            if (empty($blog)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Blog.id'] = $blog['Blog']['id'];
            $this->pageTitle.= sprintf(__l(' - %s Update - %s') , Configure::read('project.alt_name_for_project_singular_caps') , $blog['Blog']['title']);
        }
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['BlogComment']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['BlogComment']['filter_id'])) {
            if ($this->request->data['BlogComment']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['BlogComment.is_admin_suspended'] = 1;
                $this->pageTitle.= ' - ' . __l('Suspend');
            } elseif ($this->request->data['BlogComment']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['BlogComment.is_system_flagged'] = 1;
                $this->pageTitle.= ' - ' . __l('Flagged');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['BlogComment']['filter_id'];
        }
        if (!empty($this->request->params['named']['username'])) {
            $conditions['User.username'] = $user['User']['username'];
            $this->pageTitle.= sprintf(__l(' - User - %s') , $user['User']['username']);
        }
        if (!empty($this->request->params['named']['q'])) {
            $this->request->data['BlogComment']['q'] = $this->request->params['named']['q'];
            $blog_ids = array();
            $projects = $this->BlogComment->Blog->Project->find('all', array(
                'conditions' => array(
                    'Project.name like ' => '%' . $this->request->data['BlogComment']['q'] . '%',
                    'Project.is_active ' => 1
                ) ,
                'contain' => array(
                    'Blog' => array(
                        'fields' => array(
                            'Blog.id'
                        )
                    )
                ) ,
                'fields' => array(
                    'Project.id'
                ) ,
                'recursive' => 1
            ));
            if (!empty($projects)) {
                foreach($projects as $project) {
                    foreach($project['Blog'] as $blog) {
                        $blog_ids[] = $blog['id'];
                    }
                }
            }
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            $conditions['OR'] = array(
                'BlogComment.comment LIKE' => '%' . $this->request->data['BlogComment']['q'] . '%',
                'Blog.title LIKE' => '%' . $this->request->data['BlogComment']['q'] . '%',
                'Blog.slug LIKE' => '%' . $this->request->data['BlogComment']['q'] . '%',
                'BlogComment.blog_id ' => $blog_ids,
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
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
                'Blog' => array(
                    'Project',
                    'fields' => array(
                        'Blog.title',
                        'Blog.slug',
                        'Blog.user_id',
                        'Blog.project_id'
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'BlogComment.id' => 'DESC'
            ) ,
            'recursive' => 2
        );
        $this->set('suspended', $this->BlogComment->find('count', array(
            'conditions' => array(
                'BlogComment.is_admin_suspended = ' => 1,
            )
        )));
        $this->set('system_flagged', $this->BlogComment->find('count', array(
            'conditions' => array(
                'BlogComment.is_system_flagged = ' => 1,
            )
        )));
        $this->set('total', $this->BlogComment->find('count'));
        $moreActions = $this->BlogComment->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('blogComments', $this->paginate());
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BlogComment->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s Update Comment') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
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