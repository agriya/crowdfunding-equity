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
class MessagesController extends AppController
{
    public $name = 'Messages';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'compose',
            'settings',
            'index',
            'inbox',
            'sentmail',
            'all',
            'starred',
            'v',
            'left_sidebar',
            'home_sidebar',
            'activities'
        ) ,
        'admin' => array(
            'update_status'
        )
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!Configure::read('suspicious_detector.is_enabled') && !Configure::read('Project.auto_suspend_message_on_system_flag')) {
            $this->Message->Behaviors->detach('SuspiciousWordsDetector');
        }
        $this->Security->disabledFields = array(
            'Message.filter_id',
            'Message.user_id',
            'Message.username',
            'Message.other_username',
            'Project.name',
            'Message.other_user_id',
            'Project.id',
            'User.id'
        );
    }
    public function index($folder_type = 'inbox', $is_starred = 0)
    {
        $this->_redirectGET2Named(array(
            'project_filter_id',
        ));
        if (!empty($this->request->params['named']['folder_type']) && isset($this->request->params['named']['is_starred'])) {
            $folder_type = $this->request->params['named']['folder_type'];
            $is_starred = $this->request->params['named']['is_starred'];
        } else {
            $this->request->params['named']['folder_type'] = $folder_type;
            $this->request->params['named']['is_starred'] = $is_starred;
        }
        if (empty($this->request->params['named']['project_id']) and !($this->Auth->user('id'))) {
            $this->Session->setFlash(__l('Authorization Required'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $condition = array();
        if ($folder_type == 'inbox') {
            $this->pageTitle = __l('Messages - Inbox');
            $condition['Message.is_sender'] = 0;
            if (empty($this->request->params['named']['project_id'])) {
                $condition['Message.parent_message_id'] = 0;
                $condition['OR'] = array(
                    array(
                        'Message.user_id' => $this->Auth->user('id') ,
                        'Message.message_folder_id' => ConstMessageFolder::Inbox
                    ) ,
                    array(
                        'Message.is_child_replied' => 1,
                        'Message.other_user_id' => $this->Auth->user('id')
                    )
                );
            }
        } elseif ($folder_type == 'sent') {
            $this->pageTitle = __l('Messages - Sent Mail');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::SentMail
            );
        } elseif ($folder_type == 'starred') {
            $this->pageTitle = __l('Messages - Starred');
            $condition['Message.user_id'] = $this->Auth->user('id');
        } elseif ($folder_type == 'all') {
            $this->pageTitle = __l('Messages - All');
            $condition['Message.user_id'] = $this->Auth->user('id');
        } else {
            $condition['Message.other_user_id'] = $this->Auth->User('id');
        }
        if (isset($this->request->params['named']['project_filter_id'])) {
            $condition['Message.project_id'] = $this->request->params['named']['project_filter_id'];
            $this->request->data['Message']['project_filter_id'] = $this->request->params['named']['project_filter_id'];
        }
        $condition['Message.is_deleted'] = 0;
        if (!empty($folder_type) && $folder_type != 'all') {
            $condition['Message.is_archived'] = 0;
        }
        if ($is_starred) {
            $condition['Message.is_starred'] = 1;
        }
        $condition['MessageContent.is_admin_suspended'] = 0;
        $order = array(
            'Message.freshness_ts' => 'DESC'
        );
        if (isset($this->request->params['named']['project_id']) && empty($this->request->params['named']['type']) || (!empty($this->request->params['named']['project_id']))) {
            $condition['MessageContent.is_admin_suspended'] = 0;
            $condition['Message.project_id'] = $this->request->params['named']['project_id'];
            $condition['Message.is_sender'] = 0;
            $project = $this->Message->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id']
                ) ,
                'contain' => array(
                    'ProjectFund' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username',
                                'User.id',
                            )
                        ) ,
                        'fields' => array(
                            'ProjectFund.user_id',
                        )
                    ) ,
                    'User',
                ) ,
                'recursive' => 2
            ));
            $this->set('project', $project);
            $condition['Message.is_activity'] = 0;
            if (!empty($this->request->params['named']['project.user_id'])) {
                $condition['Message']['project.user_id'] = $this->request->params['named']['project.user_id'];
            }
            if (!empty($this->request->params['named']['filter'])) {
                if ($this->request->params['named']['filter'] == "ascending") {
                    $order = array(
                        'Message.root' => 'asc',
                        'Message.materialized_path' => 'asc'
                    );
                }
                if ($this->request->params['named']['filter'] == "descending") {
                    $order = array(
                        'Message.root' => 'DESC',
                        'Message.materialized_path' => 'asc'
                    );
                }
                if ($this->request->params['named']['filter'] == "freshness") {
                    $order = array(
                        'Message.freshness_ts' => 'DESC',
                        'Message.materialized_path' => 'asc'
                    );
                }
            } else {
                $order = array(
                    'Message.root' => 'asc',
                    'Message.materialized_path' => 'asc'
                );
            }
        } else {
            $condition['Message.parent_message_id'] = 0;
        }
        if (!empty($this->request->params['named']['message_id'])) {
            $tmpMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $this->params['named']['message_id']
                ) ,
                'recursive' => -1
            ));
            unset($condition);
            // tmp fix
            if ($tmpMessage['Message']['message_folder_id'] == ConstMessageFolder::SentMail) {
                $tmpMessageNew = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.message_folder_id' => ConstMessageFolder::Inbox,
                        'Message.message_content_id' => $tmpMessage['Message']['message_content_id'],
                    ) ,
                    'recursive' => -1
                ));
                $condition['Message.materialized_path LIKE '] = $tmpMessageNew['Message']['materialized_path'] . '-%';
            } else {
                $condition['Message.materialized_path LIKE '] = $tmpMessage['Message']['materialized_path'] . '-%';
            }
            $condition['OR'] = array(
                array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::Inbox
                ) ,
                array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::SentMail
                )
            );
            $order = array(
                'Message.root' => 'asc',
                'Message.materialized_path' => 'asc'
            );
        }
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'activities') {
                $condition['Message.is_activity'] = 1;
            }
            if ($this->request->params['named']['type'] == 'closed') {
                $project_funds = $this->Message->Project->ProjectFund->find('list', array(
                    'conditions' => array(
                        'ProjectFund.user_id' => $this->Auth->user('id') ,
                    ) ,
                    'fields' => array(
                        'ProjectFund.project_id'
                    )
                ));
                $response = Cms::dispatchEvent('Controller.ProjectType.ClosedProjectIds', $this, array(
                    'project_ids' => $project_funds
                ));
                $project_ids = $response->data['project_ids'];
                $condition['Message.project_id'] = $project_ids;
            }
        }
        if (!empty($this->request->params['named']['type']) && !empty($this->request->params['named']['project_id'])) {
            $condition['Message.project_id'] = $this->request->params['named']['project_id'];
            // @todo event
            $project_filter = $this->Message->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id']
                ) ,
                'recursive' => -1
            ));
            $this->set('project_filter', $project_filter);
        }
        if ($folder_type == 'sent') {
            unset($condition['Message.parent_message_id']);
        }
        $this->paginate = array(
            'conditions' => $condition,
            'recursive' => 2,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'OtherUser' => array(
                    'UserAvatar'
                ) ,
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'Project',
                'ProjectFund'
            ) ,
            'order' => $order
        );
        
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = array();
            if(!empty($this->request->params['named']['project_id'])) {
                Cms::dispatchEvent('Controller.ProjectComment.listing', $this, array(
                    'data' => $event_data
                ));
            }
        }
        $project_conditions = array();
        $project_conditions['or']['Project.user_id'] = $this->Auth->user('id');
        $project_funds = $this->Message->Project->ProjectFund->find('list', array(
            'conditions' => array(
                'ProjectFund.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'ProjectFund.project_id'
            )
        ));
        if (!empty($project_funds)) {
            $project_conditions['or']['Project.id'] = $project_funds;
        }
        $projects = $this->Message->Project->find('all', array(
            'conditions' => $project_conditions,
            'contain' => array(
                'User',
                'ProjectFund' => array(
                    'conditions' => array(
                        'or' => array(
                            'ProjectFund.user_id' => $this->Auth->user('id') ,
                        )
                    ) ,
                    'fields' => array(
                        'ProjectFund.user_id',
                        'ProjectFund.id'
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                )
            ) ,
            'recursive' => 3
        ));
        $project_list = array();
        foreach($projects as $project) {
            if ($project['Project']['user_id'] == $this->Auth->user('id')) {
                if (!empty($project['ProjectFund'][0]['User']['username'])) {
                    $project_list[$project['Project']['id']] = $project['Project']['name'] . ' (' . $project['ProjectFund'][0]['User']['username'] . ')';
                } else {
                    $project_list[$project['Project']['id']] = $project['Project']['name'];
                }
            } else {
                $project_list[$project['Project']['id']] = $project['Project']['name'] . ' (' . $project['User']['username'] . ')';
            }
        }
        $conditions = array();
        $conditions['ProjectFund.user_id'] = $this->Auth->user('id');
        if (!isPluginEnabled('Pledge')) {
            $conditions['NOT']['AND'][]['ProjectFund.project_type_id'] = ConstProjectTypes::Pledge;
        }
        if (!isPluginEnabled('Lend')) {
            $conditions['NOT']['AND'][]['ProjectFund.project_type_id'] = ConstProjectTypes::Lend;
        }
        if (!isPluginEnabled('Donate')) {
            $conditions['NOT']['AND'][]['ProjectFund.project_type_id'] = ConstProjectTypes::Donate;
        }
        if (!isPluginEnabled('Equity')) {
            $conditions['NOT']['AND'][]['ProjectFund.project_type_id'] = ConstProjectTypes::Equity;
        }
        $ProjectPledgedIds = $this->Message->Project->ProjectFund->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'ProjectFund.project_id'
            ) ,
            'recursive' => -1
        ));
        $response = Cms::dispatchEvent('Controller.ProjectType.projectIds', $this, array(
            'data' => $ProjectPledgedIds
        ));
        $projectStatus = $response->data['projectStatus'];
        $ProjectIds = $response->data['ids'];
        $project_own = $this->Message->Project->find('all', array(
            'conditions' => array(
                'Project.id' => $ProjectIds
            ) ,
            'contain' => array(
                'User',
                'ProjectFund' => array(
                    'User'
                )
            ) ,
            'recursive' => 2
        ));
        $activities_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender ' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_activity' => 1,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.is_admin_suspended' => 0
            ) ,
            'recursive' => 0
        ));
        $this->set('activities_count', $activities_count);
        $projects = $project_list;
        $statClassArray = Configure::read('projectstatus.class');
        $this->set('statClassArray', $statClassArray);
        $this->set('projects', $projects);
        $this->set('messages', $this->paginate());
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('project_own', $project_own);
        $this->set('projectStatus', $projectStatus);
        if (isset($this->request->params['named']['project_id']) && empty($this->request->params['named']['type'])) {
            $this->pageTitle = __l('Message Board') . ' - ' . $project['Project']['name'];
            $this->render('message_board');
        }
        if ($this->RequestHandler->isAjax() and !empty($this->request->params['named']['message_id'])) {
            $this->render('view_child_ajax');
        }
        
        //Other User Avatar
        $userAvatar = array();
  	$messages = $this->paginate();
     	if ($this->RequestHandler->prefers('json')) 
     	{
            $i = 0;
            while($i < count($messages))
            {

            $user_id = $messages[$i]['Message']['other_user_id'];
                App::import('Model', 'User');
                $modelObj = new User();
                $user_details = $modelObj->find('first', array(
                    'conditions' => array(
                       'User.id' => $user_id,
                    ) ,
                    'contain' => array(
                       'UserAvatar',
                              'User.id'
                    ) ,
                    'recursive' => 0
                ));
                $userAvatar[] = $user_details['UserAvatar'];
                $i++;
            }	
     	}
        $this->set('userAvatar', $userAvatar);
        
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            if(empty($this->request->params['named']['project_id'])) {
                $response = Cms::dispatchEvent('Controller.Message.Index', $this, array());
            }
        }
    }
    public function inbox()
    {
        $this->setAction('index', 'inbox');
    }
    public function sentmail()
    {
        $this->setAction('index', 'sent');
    }
    public function all()
    {
        $this->setAction('index', 'all');
    }
    public function starred($folder_type = 'starred')
    {
        $this->setAction('index', $folder_type, 1);
        $this->pageTitle = __l('Messages - Starred');
    }
    public function v($id = null, $folder_type = 'inbox', $is_starred = 0)
    {
        $this->pageTitle = __l('Message');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $id,
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'User' => array(
                    'UserAvatar'
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.email',
                        'OtherUser.username'
                    )
                ) ,
                'Project'
            ) ,
            'recursive' => 2,
        ));
        if (empty($message)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin && $message['Message']['user_id'] != $this->Auth->user('id') && $message['Message']['other_user_id'] != $this->Auth->user('id')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin && !empty($message['MessageContent']['is_admin_suspended'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $all_parents = array();
        if (!empty($message['Message']['parent_message_id'])) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $message['Message']['parent_message_id']
                ) ,
                'recursive' => 0
            ));
            $all_parents = $this->_findParent($parent_message['Message']['id']);
        }
        if ($message['Message']['is_read'] == 0 && $message['Message']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['Message']['is_read'] = 1;
            $this->request->data['Message']['id'] = $message['Message']['id'];
            $this->Message->save($this->request->data);
        }
        //Its for display details -> Who got this message
        $select_to_details = $this->Message->find('all', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message['Message']['message_content_id'],
            ) ,
            'recursive' => 0,
            'contain' => array(
                'User.email',
                'User.username',
                'User.id'
            )
        ));
        if (!empty($select_to_details)) {
            $receiverNames = array();
            $show_detail_to = array();
            foreach($select_to_details as $select_to_detail) {
                if ($select_to_detail['Message']['is_sender'] == 0) {
                    if ($this->Auth->User('id') != $select_to_detail['User']['id']) {
                        array_push($receiverNames, $select_to_detail['User']['username']);
                    }
                    array_push($show_detail_to, $select_to_detail['User']['username']);
                }
            }
            $show_detail_to = implode(', ', $show_detail_to);
            $receiverNames = implode(', ', $receiverNames);
            $this->set('show_detail_to', $show_detail_to);
            $this->set('receiverNames', $receiverNames);
        }
        if (!empty($message['MessageContent']['subject'])) {
            $this->pageTitle.= ' - ' . $message['MessageContent']['subject'];
        }
        $this->set('message', $message);
        $this->set('all_parents', $all_parents);
        $this->set('user_name', $this->Auth->user('username'));
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('user_id', $this->Auth->user('id'));
        // Set the folder type link
        $back_link_msg = ($folder_type == 'all') ? __l('All mails') : $folder_type;
        $this->set('back_link_msg', $back_link_msg);
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Message->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Message')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function left_sidebar()
    {
        $this->set('folder_type', !empty($this->request->params['named']['folder_type']) ? $this->request->params['named']['folder_type'] : '');
        $this->set('is_starred', !empty($this->request->params['named']['is_starred']) ? $this->request->params['named']['is_starred'] : '');
        $this->set('compose', !empty($this->request->params['named']['compose']) ? $this->request->params['named']['compose'] : '');
        $id = $this->Auth->user('id');
        $this->set('inbox', $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => 0,
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.is_admin_suspended ' => 0,
            ) ,
            'recursive' => 0
        )));
        $this->set('stared', $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'Message.is_starred' => 1,
                'MessageContent.is_admin_suspended ' => 0,
            ) ,
            'recursive' => 0
        )));
    }
    public function compose($id = null, $action = null)
    {
        if (empty($this->request->params['named']) && empty($this->request->data['Message'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Messages - Compose');
        if (!empty($id)) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $id
                ) ,
                'contain' => array(
                    'MessageContent' => array(
                        'Attachment'
                    ) ,
                    'OtherUser'
                ) ,
                'recursive' => 2
            ));
            $all_parents = $this->_findParent($id);
            $this->set('parent_message', $parent_message);
            $this->set('id', $id);
            $this->set('action', $action);
        }
        if (!empty($this->request->data)) {
            $is_error = false;
            $path = '';
            $depth = 0;
            if (!empty($this->request->data['Message']['parent_message_id'])) {
                $message_path = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.id' => $this->request->data['Message']['parent_message_id']
                    ) ,
                    'fields' => array(
                        'Message.path',
                        'Message.depth'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($message_path['Message']['path'])) {
                    $path = $message_path['Message']['path'] . '.P' . $this->request->data['Message']['parent_message_id'];
                } else {
                    $path = 'P' . $this->request->data['Message']['parent_message_id'];
                }
                $depth = $message_path['Message']['depth']+1;
            }
            $project = '';
            if (!empty($this->request->data['Message']['project_id'])) {
                $project = $this->Message->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $this->request->data['Message']['project_id']
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'UserAvatar'
                        ) ,
                        'ProjectFund' => array(
                            'User' => array(
                                'fields' => array(
                                    'User.username'
                                )
                            ) ,
                        )
                    ) ,
                    'recursive' => 2
                ));
            }
            $attachment_validate = 1;
            if (!empty($this->request->data['Attachment']['filename'])) {
                $filename = $this->request->data['Attachment']['filename'];
                if (!empty($filename['name'])) {
                    if ($project['Project']['user_id'] != $this->Auth->user('id')) {
                        $this->Message->MessageContent->Attachment->Behaviors->attach('ImageUpload', Configure::read('projectuser.file'));
                        if ($filename['type'] != 'image/jpeg' && $filename['type'] != 'image/pjpeg' && $filename['type'] != 'image/jpg' && $filename['type'] != 'image/gif' && $filename['type'] != 'image/png') {
                            $this->Message->MessageContent->validationErrors = array();
                            $this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('File format not supported');
                            $attachment_validate = 0;
                        }
                    }
                }
            }
            if (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {
                if (empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('Please select the file');
                    $attachment_validate = 0;
                }
            }
            $this->Message->set($this->request->data);
            if ($this->Message->validates() && !empty($attachment_validate)) {
                // To take the admin privacy settings
                $is_saved = 0;
                if (!intval(Configure::read('messages.is_allow_send_messsage'))) {
                    $this->Session->setFlash(__l('Message send is temporarily stopped. Please try again later.') , 'default', null, 'error');
                    $this->redirect(array(
                        'action' => 'inbox'
                    ));
                }
                if (!empty($this->request->data['Message']['subject'])) {
                    $size = strlen($this->request->data['Message']['message']) +strlen($this->request->data['Message']['subject']);
                } else {
                    $size = strlen($this->request->data['Message']['message']);
                }
                $to_users = array();
                if (!empty($this->request->data['Message']['to'])) {
                    $project_fund = explode(':', $this->request->data['Message']['to']);
                    if (count($project_fund) > 1) {
                        $this->request->data['Message']['to'] = $project_fund[0];
                    }
                    $to_users = explode(',', $this->request->data['Message']['to']);
                }
                $userList = array();
                if (!empty($to_users)) {
                    foreach($to_users as $user_to) {
                        // To find the user id of the user
                        $user = $this->Message->User->find('first', array(
                            'conditions' => array(
                                'User.username' => trim($user_to)
                            ) ,
                            'recursive' => -1
                        ));
                        if (!empty($user)) {
                            $userList[$user['User']['id']] = $user_to;
                        }
                    }
                }
                if ($this->request->data['Message']['to'] == 0) {
                    $to_users[] = 'all';
                    $user[] = 'all';
                }
                if (!empty($to_users) && !empty($user)) {
                    //  to save message content
                    if (!empty($this->request->data['Message']['subject'])) {
                        $message_content['MessageContent']['subject'] = $this->request->data['Message']['subject'];
                    }
                    $message_content['MessageContent']['message'] = $this->request->data['Message']['message'];
                    if (!empty($this->request->data['Message']['message_content_id'])) {
                        $message_content['MessageContent']['id'] = $this->request->data['Message']['message_content_id'];
                        $this->Message->MessageContent->save($message_content);
                        $message_id = $this->request->data['Message']['message_content_id'];
                    } else {
                        $this->Message->MessageContent->create();
                        $this->Message->MessageContent->save($message_content);
                        $message_id = $this->Message->MessageContent->id;
                    }
                    if (!empty($this->request->data['Attachment'])) {
                        $filename = array();
                        $filename = $this->request->data['Attachment']['filename'];
                        if (!empty($filename['name'])) {
                            $attachment['Attachment']['filename'] = $filename;
                            $attachment['Attachment']['class'] = 'MessageContent';
                            $attachment['Attachment']['description'] = 'message';
                            $attachment['Attachment']['foreign_id'] = $message_id;
                            $this->Message->MessageContent->Attachment->set($attachment);
                            $this->Message->MessageContent->Attachment->create();
                            $this->Message->MessageContent->Attachment->save($attachment);
                            $size+= $filename['size'];
                        }
                    }
                    foreach($to_users as $user_to) {
                        // To find the user id of the user
                        $user = $this->Message->User->find('first', array(
                            'conditions' => array(
                                'User.username' => trim($user_to)
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.email',
                                'User.username',
                            ) ,
                            'recursive' => -1
                        ));
                        if (empty($user) and $user_to == 0) {
                            $user['User']['id'] = $user_to;
                        }
                        if ($user_to == 'all') {
                            $user['User']['id'] = 0;
                        }
                        if (!empty($user)) {
                            $is_send_message = true;
                            // to check for allowed message sizes
                            if ($is_send_message) {
                                if (!empty($this->request->data['Message']['parent_message_id'])) {
                                    $parent_id = $this->request->data['Message']['parent_message_id'];
                                } else {
                                    $parent_id = 0;
                                }
                                $folder_id = ConstMessageFolder::Inbox;
                                $project_id = !empty($this->request->data['Message']['project_id']) ? $this->request->data['Message']['project_id'] : 0;
                                if (isset($this->request->data['Message']['is_private'])) {
                                    if (!empty($project) && $project['Project']['user_id'] == $this->Auth->user('id') && !empty($this->request->data['Message']['to'])) {
                                        $is_private = 1;
                                    } else {
                                        $is_private = $this->request->data['Message']['is_private'];
                                    }
                                } else {
                                    if ($user['User']['id'] == 0) {
                                        $is_private = 0;
                                    } else {
                                        $is_private = 1;
                                    }
                                }
                                // To save in inbox //
                                $msg = $is_saved = $this->_saveMessage($depth, $path, $user['User']['id'], $this->Auth->user('id') , $message_id, $folder_id, 0, 0, $parent_id, $size, $project_id, $is_private);
                                if (!empty($this->request->data['Message']['root'])) {
                                    $msg_data['id'] = $this->request->data['Message']['root'];
                                    $msg_data['is_read'] = 0;
                                    $this->Message->save($msg_data);
                                }
                                // To save in sent iteams //
                                $is_saved = $this->_saveMessage($depth, $path, $this->Auth->user('id') , $user['User']['id'], $message_id, ConstMessageFolder::SentMail, 1, 1, $parent_id, $size, $project_id, $is_private);
                                if (empty($is_private) && !empty($project_id)) {
                                    $project = $this->Message->Project->find('first', array(
                                        'conditions' => array(
                                            'Project.id' => $project_id
                                        ) ,
                                        'contain' => array(
                                            'User'
                                        ) ,
                                        'recursive' => 0
                                    ));
                                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                        '_trackEvent' => array(
                                            'category' => 'User',
                                            'action' => 'ProjectCommented',
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
                                            'category' => 'ProjectComment',
                                            'action' => 'ProjectCommented',
                                            'label' => $project['Project']['id'],
                                            'value' => '',
                                        ) ,
                                        '_setCustomVar' => array(
                                            'pd' => $project['Project']['id'],
                                            'ud' => $this->Auth->user('id') ,
                                            'rud' => $this->Auth->user('referred_by_user_id') ,
                                        )
                                    ));
                                    $this->Message->postActivity($project, ConstProjectActivities::ProjectComment, $is_saved);
                                }
                                // To send email when post comments
                                $messageContent = $this->Message->MessageContent->find('first', array(
                                    'conditions' => array(
                                        'MessageContent.id' => $message_id,
                                    ) ,
                                ));
                                if ($this->RequestHandler->isAjax() and !empty($this->request->data['Message']['quickreply'])) {
                                    $this->redirect(array(
                                        'controller' => 'messages',
                                        'action' => 'view_ajax',
                                        $msg,
                                        'type' => 'message_board'
                                    ));
                                } else {
                                    if (!empty($messageContent['MessageContent']['is_admin_suspended'])) {
                                        $flash_message = !empty($this->request->data['Message']['project_id']) ? sprintf(__l('%s comment') , Configure::read('project.alt_name_for_project_singular_caps')) : __l('Message');
                                        $this->Session->setFlash(sprintf(__l('%s has been suspended due to containing suspicious words') , $flash_message) , 'default', null, 'error');
                                    } else {
                                        $flash_message = !empty($this->request->data['Message']['project_id']) ? __l('Comment has been posted successfully') : __l('Message has been sent successfully');
                                        $this->Session->setFlash($flash_message, 'default', null, 'success');
                                    }
                                    if ($this->request->data['Message']['message_type'] == 'inbox') {
                                        $this->redirect(array(
                                            'controller' => 'messages',
                                            'action' => 'index',
                                        ));
                                    } else {
                                        if (isset($this->request->data['Message']['redirect_url'])) {
                                            $this->redirect($this->request->data['Message']['redirect_url']);
                                        } else {
                                            $this->redirect(array(
                                                'controller' => 'projects',
                                                'action' => 'view',
                                                $project['Project']['slug'],
                                            ));
                                        }
                                    }
                                }
                            } else {
                                $this->Session->setFlash(__l('Problem in sending message. You can send message only to your friends network') , 'default', null, 'error');
                            }
                        }
                    }
                } else {
                    $is_error = true;
                    if (!empty($this->request->data['Message']['to'])) {
                        $this->Session->setFlash(sprintf(__l('Please specify coreect recipient')) , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash(sprintf(__l('Please specify atleast one recipient')) , 'default', null, 'error');
                    }
                    if (empty($this->request->data)) {
                        $this->redirect(array(
                            'action' => 'compose'
                        ));
                    }
                }
                if (!$is_error) {
                    if (!empty($this->request->data['Message']['project_id'])) {
                        $this->redirect(array(
                            'controller' => 'messages',
                            'action' => 'index',
                            'project_id' => $this->request->data['Message']['project_id']
                        ));
                    }
                    $this->redirect(array(
                        'action' => 'inbox'
                    ));
                }
            } else {
                if (!empty($this->request->data) && !empty($this->request->data['Message']['message_type']) && !empty($this->request->data['Message']['project_id'])) {
                    $this->request->params['named']['project_id'] = $this->request->data['Message']['project_id'];
                }
                $this->Session->setFlash(__l('Problem in sending message.') , 'default', null, 'error');
            }
        }
        if (!empty($parent_message)) {
            if (!empty($action)) {
                if (!empty($this->request->params['named']['reply_type'])) {
                    $this->pageTitle = __l('Messages - Reply');
                }
                $this->request->data['Message']['message'] = $parent_message['MessageContent']['message'];
                $this->request->data['Message']['message_reply'] = $parent_message['MessageContent']['message'];
                if (empty($parent_message['Message']['is_private'])) {
                    $this->request->data['Message']['to'] = 0;
                } else {
                    $this->request->data['Message']['to'] = $parent_message['OtherUser']['username'];
                }
                $this->request->data['Message']['parent_message_id'] = $parent_message['Message']['id'];
                $this->request->data['Message']['is_private'] = $parent_message['Message']['is_private'];
                switch ($action) {
                    case 'reply':
                        $this->request->data['Message']['subject'] = __l('Re:') . $parent_message['MessageContent']['subject'];
                        $this->set('all_parents', $all_parents);
                        $this->request->data['Message']['project_id'] = $parent_message['Message']['project_id'];
                        $this->request->data['Message']['type'] = 'reply';
                        break;

                    case 'forword':
                        $this->request->data['Message']['subject'] = __l('Fwd:') . $parent_message['MessageContent']['subject'];
                        $this->request->data['Message']['to'] = '';
                        break;
                }
            }
        }
        $user_settings = $this->Message->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'UserProfile.message_page_size',
                'UserProfile.message_signature'
            ) ,
            'recursive' => -1
        ));
        if (!empty($user_settings['UserProfile']['message_signature'])) {
            if (!empty($this->request->data['Message']['message'])) {
                $this->request->data['Message']['message'].= $user_settings['UserProfile']['message_signature'];
            } else {
                $this->request->data['Message']['message'] = $user_settings['UserProfile']['message_signature'];
            }
        }
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->Message->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['user']
                ) ,
                'fields' => array(
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (!isset($this->request->data['Message']['to'])) {
                $this->request->data['Message']['to'] = $user['User']['username'];
            }
        }
        if (!empty($this->request->params['named']['message_type'])) {
            $this->request->data['Message']['message_type'] = $this->request->params['named']['message_type'];
        } else {
            $this->request->data['Message']['message_type'] = 'message_board';
        }
        if (!empty($this->request->params['named']['m_path'])) {
            $this->request->data['Message']['m_path'] = $this->request->params['named']['m_path'];
        } else {
            $this->request->data['Message']['m_path'] = '';
        }
        if (!empty($this->request->params['named']['root'])) {
            $this->request->data['Message']['root'] = $this->request->params['named']['root'];
        } else {
            $this->request->data['Message']['root'] = 0;
        }
        if (!empty($this->request->params['named']['to'])) {
            $this->request->data['Message']['to'] = $this->request->params['named']['to'];
        }
        if ($this->RequestHandler->isAjax()) {
            $this->set('ajax_view', 1);
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'contact')) {
            $this->render('message_compose');
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $project = $this->Message->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                    'Project.user_id',
                    'Project.id',
                    'Project.slug',
                ) ,
                'contain' => array(
                    'ProjectType' => array(
                        'fields' => array(
                            'ProjectType.id',
                            'ProjectType.funder_slug',
                        ) ,
                    ) ,
                    'ProjectFund' => array(
                        'conditions' => array(
                            'ProjectFund.project_fund_status_id' => array(
                                ConstProjectFundStatus::Authorized,
                                ConstProjectFundStatus::PaidToOwner,
                                ConstProjectFundStatus::Closed,
                                ConstProjectFundStatus::DefaultFund
                            )
                        ) ,
                        'User' => array(
                            'UserAvatar'
                        ) ,
                    )
                ) ,
                'recursive' => 2
            ));
            $this->set('project', $project);
            $this->request->data['Message']['project_id'] = $this->request->params['named']['project_id'];
            if ($project['Project']['user_id'] == $this->Auth->user('id')) {
                $entries = array();
                foreach($project['ProjectFund'] as $project_fund) {
                    if (in_array($project_fund['is_anonymous'], array(
                        ConstAnonymous::None,
                        ConstAnonymous::FundedAmount
                    ))) {
                        if (!empty($project_fund['User']['username'])) {
                            $user_entries = $project_fund['User']['username'] . ":" . $project_fund['id'];
                            $entries[$user_entries] = $project_fund['User']['username'] . ' (#' . $project_fund['id'] . ')';
                        }
                    }
                }
                $select_array = array();
                if (!empty($entries)) {
                    $select_array = array(
                        __l('Public') => array(
                            '0' => __l('Post to all')
                        ) ,
                        sprintf(__l('Private to %s') , Configure::read(sprintf(('project.alt_name_for_%s_plural_small') , $project['ProjectType']['funder_slug']))) => array(
                            $entries
                        )
                    );
                } else {
                    $select_array = array(
                        __l('Public') => array(
                            '0' => __l('Post to all')
                        ) ,
                    );
                }
                $this->set('select_array', $select_array);
                if (!empty($this->request->params['named']['funded_id'])) {
                    $fundedUser = $this->Message->Project->ProjectFund->find('first', array(
                        'conditions' => array(
                            'ProjectFund.id' => $this->request->params['named']['funded_id'],
                        ) ,
                        'contain' => array(
                            'User'
                        ) ,
                        'recursive' => 0
                    ));
                    $this->request->data['Message']['to'] = $fundedUser['User']['username'] . ':' . $this->request->params['named']['funded_id'];
                    $this->set('fundedUser', $fundedUser);
                }
            }
        }
        if (empty($this->request->params['named']['reply_type'])) {
            $conditions = array();
            $conditions['User.role_id <>'] = ConstUserTypes::Admin;
            $conditions['User.id <>'] = $this->Auth->user('id');
            if (!empty($project) && !empty($project['ProjectFund'][0]['user_id'])) {
                $conditions['User.id'] = $project['ProjectFund'][0]['user_id'];
            }
            $users = $this->Message->User->find('list', array(
                'conditions' => $conditions
            ));
            $new_users = array();
            foreach($users as $user) {
                $new_users[$user] = $user;
            };
            $users = $new_users;
            $to_options = array(
                __l('Public') => array(
                    'Public' => __l('Post to all') ,
                ) ,
                __l('Selecte a') . ' ' . Configure::read('site.name') => $users
            );
            $this->set('to_options', $to_options);
            $projectids = $this->Message->Project->ProjectFund->find('list', array(
                'conditions' => array(
                    'ProjectFund.user_id' => $this->Auth->user('id') ,
                ) ,
                'fields' => array(
                    'ProjectFund.project_id'
                )
            ));
            $project_list_conditions['OR']['Project.id'] = $projectids;
            $project_list_conditions['OR']['Project.user_id'] = $this->Auth->user('id');
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                unset($project_list_conditions);
                $project_list_conditions = array();
            }
            $projects = $this->Message->Project->find('all', array(
                'conditions' => $project_list_conditions,
                'contain' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                    'ProjectFund' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username',
                                'User.id',
                            )
                        )
                    )
                ) ,
                'recursive' => 3,
            ));
            $project_list = array();
            foreach($projects as $project) {
                if ($project['Project']['user_id'] == $this->Auth->user('id')) {
                    if (!empty($project['ProjectFund'][0]['User']['username'])) {
                        $project_list[$project['Project']['id']] = $project['Project']['name'] . ' - ' . $project['ProjectFund'][0]['User']['username'];
                    } else {
                        $project_list[$project['Project']['id']] = $project['Project']['name'];
                    }
                } else {
                    $project_list[$project['Project']['id']] = $project['Project']['name'] . ' - ' . $project['User']['username'];
                }
            }
            $this->set('projects', $project_list);
            $this->request->data['Message']['message'] = '';
        }
        $this->request->data['Message']['message'] = '';
    }
    public function _sendAlertOnNewMessage($email, $username, $message, $message_id, $user_id)
    {
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'fields' => array(
                'Message.id',
            ) ,
            'recursive' => -1
        ));
        $email_replace = array(
            '##OTHERUSERNAME##' => $username,
            '##USERNAME##' => $this->Auth->user('username') ,
            '##MESSAGE_LINK##' => Router::url(array(
                'controller' => 'messages',
                'action' => 'v',
                $get_message_hash['Message']['id'],
            ) , true) ,
            '##MESSAGE##' => $message
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email_template = $this->EmailTemplate->selectTemplate('New Message');
        $this->Message->_sendEmail($email_template, $email_replace, $email);
    }
    public function _sendMail($to, $subject, $body, $format = 'text')
    {
        $from = Configure::read('site.no_reply_email');
        $subject = $subject;
        $this->Email->from = $from;
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->sendAs = $format;
        return $this->Email->send($body);
    }
    public function _saveMessage($depth = 0, $path = null, $user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $project_id = null, $is_private = 1)
    {
        $message['Message']['depth'] = $depth;
        $message['Message']['path'] = $path;
        $message['Message']['message_content_id'] = $message_id;
        $message['Message']['user_id'] = $user_id;
        $message['Message']['other_user_id'] = $other_user_id;
        $message['Message']['message_folder_id'] = $folder_id;
        $message['Message']['is_private'] = $is_private;
        $message['Message']['is_sender'] = $is_sender;
        $message['Message']['is_read'] = $is_read;
        $message['Message']['parent_message_id'] = $parent_id;
        $message['Message']['size'] = $size;
        $message['Message']['project_id'] = $project_id;
        if (!empty($this->request->data['Message']['project_id'])) {
            $project = $this->Message->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->data['Message']['project_id']
                ) ,
                'recursive' => -1
            ));
            $message['Message']['project_type_id'] = $project['Project']['project_type_id'];
            $message['Message']['project_id'] = $this->request->data['Message']['project_id'];
        }
        $this->Message->create();
        $this->Message->save($message);
        $id = $this->Message->id;
        $message['Message']['id'] = $id;
        $id_converted = base_convert($id, 10, 36);
        $materialized_path = sprintf("%08s", $id_converted);
        if (empty($this->request->data['Message']['m_path'])) {
            $message['Message']['materialized_path'] = $materialized_path;
        } else {
            $message['Message']['materialized_path'] = $this->request->data['Message']['m_path'] . '-' . $materialized_path;
        }
        if (empty($this->request->data['Message']['root'])) {
            $message['Message']['root'] = $id;
        } else {
            $message['Message']['root'] = $this->request->data['Message']['root'];
        }
        $RootMessage = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id' => $message['Message']['root'],
            ) ,
            'contain' => array(
                'Project'
            ) ,
            'recursive' => 1
        ));
        if (!empty($RootMessage)) {
            $message['Project']['user_id'] = $RootMessage['Project']['user_id'];
        }
        $this->Message->save($message);
        $this->Message->updateAll(array(
            'Message.freshness_ts' => '\'' . date('Y-m-d h:i:s') . '\''
        ) , array(
            'Message.root' => $message['Message']['root']
        ));
        $this->Message->updateAll(array(
            'Message.is_read' => 0
        ) , array(
            'Message.id' => $message['Message']['root'],
            'Message.other_user_id !=' => $this->Auth->User('id')
        ));
        if (!empty($this->request->data['Message']['root'])) {
            $this->Message->updateAll(array(
                'Message.is_child_replied' => 1
            ) , array(
                'Message.id' => $this->request->data['Message']['root']
            ));
        }
        return $id;
    }
    public function star($message_id, $is_star = 0)
    {
        $message['Message']['id'] = $message_id;
        $message['Message']['is_starred'] = $is_star;
        if ($this->Message->save($message)) {
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        }
        $this->set('is_starred_class', ($is_star) ? 'fa fa-star' : 'fa fa-star-o');
        $this->set('message', $message);
    }
    public function _findParent($id = null)
    {
        $all_parents = array();
        for ($i = 0;; $i++) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $id
                ) ,
                'recursive' => -1
            ));
            array_unshift($all_parents, $parent_message);
            if ($parent_message['Message']['parent_message_id'] != 0) {
                $parent_message_data = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.id' => $parent_message['Message']['parent_message_id']
                    ) ,
                    'recursive' => -1
                ));
                $id = $parent_message_data['Message']['id'];
            } else {
                break;
            }
        }
        return $all_parents;
    }
    public function admin_index()
    {
		// -- TODO -- activity messages are not showing. need to fix it
        $this->pageTitle = __l('Messages');
        $conditions['Message.is_sender'] = 1;
        if (!empty($this->request->data['Message']['username']) || !empty($this->request->params['named']['from'])) {
            $this->request->data['Message']['username'] = !empty($this->request->data['Message']['username']) ? $this->request->data['Message']['username'] : $this->request->params['named']['from'];
            $conditions['User.username'] = $this->request->data['Message']['username'];
            $this->request->params['named']['from'] = $this->request->data['Message']['username'];
        }
        if (!empty($this->request->data['Message']['other_username']) || !empty($this->request->params['named']['to'])) {
            $this->request->data['Message']['other_username'] = !empty($this->request->data['Message']['other_username']) ? $this->request->data['Message']['other_username'] : $this->request->params['named']['to'];
            $conditions['OtherUser.username'] = $this->request->data['Message']['other_username'];
            $this->request->params['named']['to'] = $this->request->data['Message']['other_username'];
        }
        if (!empty($this->request->data['Project']['name']) || !empty($this->request->params['named']['project'])) {
            $project = $this->Message->Project->find('first', array(
                'conditions' => array(
                    'or' => array(
                        'Project.name like ' => !empty($this->request->data['Project']['name']) ? '%' . $this->request->data['Project']['name'] . '%' : '',
                        'Project.id' => !empty($this->request->params['named']['project']) ? $this->request->params['named']['project'] : '',
                    )
                ) ,
                'fields' => array(
                    'Project.id',
                    'Project.name',
                ) ,
                'recursive' => -1
            ));
            $conditions['Message.project_id'] = $project['Project']['id'];
            $this->request->data['Project']['name'] = $project['Project']['name'];
            $this->request->params['named']['project'] = $project['Project']['id'];
        }
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Message']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Message']['filter_id'])) {
            if ($this->request->data['Message']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['MessageContent.is_admin_suspended'] = 1;
                $this->pageTitle.= ' - ' . __l('Suspend');
            } elseif ($this->request->data['Message']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['MessageContent.is_system_flagged'] = 1;
                $this->pageTitle.= ' - ' . __l('Flagged');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Message']['filter_id'];
        }
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'project_comments') {
            $this->pageTitle = sprintf(__l('%s Comments') , Configure::read('project.alt_name_for_project_singular_caps'));
            $conditions['Message.is_activity'] = 0;
            $conditions['NOT'] = array(
                'Message.project_id' => 0
            );
            $this->set('suspended', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_admin_suspended = ' => 1,
                    'Message.is_sender' => 1,
                    'Message.is_activity' => 0,
                    'NOT' => array(
                        'Message.project_id' => 0
                    )
                ) ,
                'recursive' => 0
            )));
            $this->set('system_flagged', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_system_flagged = ' => 1,
                    'Message.is_sender' => 1,
                    'Message.is_activity' => 0,
                    'NOT' => array(
                        'Message.project_id' => 0
                    )
                ) ,
                'recursive' => 0
            )));
            $this->set('all', $this->Message->find('count', array(
                'conditions' => array(
                    'Message.is_sender' => 1,
                    'Message.is_activity' => 0,
                    'NOT' => array(
                        'Message.project_id' => 0
                    )
                ) ,
                'recursive' => 0
            )));
        } else {
            //$conditions['Message.project_id'] = 0;
            $this->set('suspended', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_admin_suspended = ' => 1,
                    'Message.is_sender' => 1,
                   // 'Message.project_id' => 0
                ) ,
                'recursive' => 0
            )));
            $this->set('system_flagged', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_system_flagged = ' => 1,
                    'Message.is_sender' => 1,
                    //'Message.project_id' => 0
                ) ,
                'recursive' => 0
            )));
            $this->set('all', $this->Message->find('count', array(
                'conditions' => array(
                    'Message.is_sender' => 1,
                   // 'Message.project_id' => 0
                ) ,
                'recursive' => 0
            )));
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'MessageContent',
                'OtherUser',
                'Project',
            ) ,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->Message->Project->validate = array();
        $this->Message->User->validate = array();
        $moreActions = $this->Message->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('messages', $this->paginate());
    }
    public function activities()
    {
        $this->pageTitle = __l('Activities');
        $conditions = array();
        if (!empty($this->request->params['named']['user_id'])) {
            $user_id = $this->request->params['named']['user_id'];
            $conditions['Message.is_anonymous_fund'] = array(
                ConstAnonymous::None,
                ConstAnonymous::FundedAmount,
            );
            $conditions['Message.is_hide_from_public'] = 0;
        } else {
            $user_id = $this->Auth->user('id');
        }
        $this->set('user', $this->Message->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        )));
        if (empty($this->request->params['prefix'])) {
            $conditions['Project.is_active'] = 1;
            $conditions['Project.is_draft'] = 0;
            if (empty($this->request->params['named']['project_id'])) {
                $conditions['Project.is_admin_suspended'] = '0';
            }
            if ($this->Auth->user('id') && !empty($this->request->params['named']['project_id']) && $this->request->params['plugin'] == 'projects') {
                $project = $this->Message->Project->find('first', array(
                    'conditions' => array(
                        'Project.id' => $this->request->params['named']['project_id']
                    ) ,
                    'fields' => array(
                        'Project.user_id'
                    ) ,
                    'recursive' => 0
                ));
                if ($project['Project']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    unset($conditions['Project.is_draft']);
                } else {
                    $conditions['Message.is_hide_rejected_activity'] = 0;
                }
            } else {
                $conditions['Message.is_hide_rejected_activity'] = 0;
            }
        }
        $conditions['Message.is_activity'] = 1;
        $conditions['MessageContent.is_admin_suspended'] = 0;
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['Message.project_id'] = $this->request->params['named']['project_id'];
        }
        $contain = array(
            'MessageContent' => array(
                'fields' => array(
                    'MessageContent.subject',
                    'MessageContent.message'
                ) ,
                'Attachment'
            ) ,
            'ActivityMessage' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message',
                        'MessageContent.is_admin_suspended'
                    ) ,
                    'Attachment'
                )
            ) ,
            'Project' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                    )
                ) ,
                'Attachment',
                'ProjectFund' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                    'limit' => 5
                ) ,
                'ProjectType' => array(
                    'fields' => array(
                        'ProjectType.id',
                        'ProjectType.name',
                        'ProjectType.slug',
                        'ProjectType.funder_slug',
                    ) ,
                ) ,
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
                ) ,
                'fields' => array(
                    'Project.id',
                    'Project.name',
                    'Project.slug',
                    'Project.collected_percentage',
                    'Project.collected_amount',
                    'Project.needed_amount',
                    'Project.project_end_date',
                    'Project.project_type_id',
                    'Project.total_ratings',
                    'Project.project_rating_count'
                ) ,
            ) ,
            'ProjectFund' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'User' => array(
                'UserAvatar'
            ) ,
            'OtherUser' => array(
                'UserAvatar'
            ) ,
            'ActivityUser' => array(
                'UserAvatar'
            ) ,
        );
        if (isPluginEnabled('ProjectUpdates')) {
            $contain = array_merge($contain, array(
                'Blog' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                    'fields' => array(
                        'Blog.id',
                        'Blog.title',
                        'Blog.content',
                        'Blog.slug',
                    ) ,
                ) ,
                'BlogComment' => array(
                    'Blog' => array(
                        'fields' => array(
                            'Blog.id',
                            'Blog.title',
                            'Blog.content',
                            'Blog.slug',
                        ) ,
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                )
            ));
        }
        if (isPluginEnabled('ProjectFollowers')) {
            $contain = array_merge($contain, array(
                'ProjectFollower' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                )
            ));
        }
        if (isPluginEnabled('Idea')) {
            $contain = array_merge($contain, array(
                'ProjectRating' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        )
                    ) ,
                )
            ));
        }
        if (isPluginEnabled('ProjectFollowers') && empty($this->request->params['prefix'])) {
            App::import('Model', 'ProjectFollowers.ProjectFollower');
            $this->ProjectFollower = new ProjectFollower();
            $projectFollowers = $this->ProjectFollower->find('list', array(
                'conditions' => array(
                    'ProjectFollower.user_id' => $user_id
                ) ,
                'fields' => array(
                    'ProjectFollower.project_id'
                ) ,
                'recursive' => -1,
            ));
            if (empty($this->request->params['named']['project_id'])) {
                if (count($projectFollowers)) {
                    $conditions['OR']['Message.project_id'] = array_values($projectFollowers);
                } else {
                    $conditions['OR']['Message.project_id'] = 0;
                }
            }
            if ($this->Auth->user('id')) {
                $projectFollowers = $this->ProjectFollower->find('list', array(
                    'conditions' => array(
                        'ProjectFollower.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'ProjectFollower.project_id'
                    ) ,
                    'recursive' => -1,
                ));
                $tmpProjectFollowers = array_values($projectFollowers);
                $this->set('projectFollowers', $tmpProjectFollowers);
                $this->set('projectFollowerIds', array_flip($projectFollowers));
            }
        }
        if (isPluginEnabled('SocialMarketing') && empty($this->request->params['prefix']) && empty($this->request->params['named']['project_id'])) {
            $this->loadModel('SocialMarketing.UserFollower');
            if (empty($this->request->params['named']['user_id'])) {
                $userFollowers = $this->UserFollower->find('list', array(
                    'conditions' => array(
                        'UserFollower.user_id' => $user_id
                    ) ,
                    'fields' => array(
                        'UserFollower.followed_user_id'
                    ) ,
                    'recursive' => -1,
                ));
                $conditions['OR']['Message.user_id'] = array_values($userFollowers);
            }
            if ($this->Auth->user('id')) {
                $userFollowers = $this->UserFollower->find('list', array(
                    'conditions' => array(
                        'UserFollower.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'UserFollower.followed_user_id'
                    ) ,
                    'recursive' => -1,
                ));
                $tmpUserFollowers = array_values($userFollowers);
                $this->set('userFollowers', $tmpUserFollowers);
                $this->set('userFollowerIds', array_flip($userFollowers));
            }
        }
        $limit = 20;
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'notification' || $this->request->params['named']['type'] == 'compact')) {
            $limit = 3;
        }
		if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'user')) {
            $limit = 18;
        }
        $final_id = $this->Message->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Message.id'
            ) ,
            'recursive' => 0,
            'limit' => 1,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        ));
        $this->set('final_id', $final_id);
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 4,
            'limit' => $limit,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        );
        $this->set('messages', $this->paginate());
        if (!empty($this->request->params['named']['project_id'])) {
            $this->render('activities_compact');
        }
        if (isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'notification')) {
            $this->render('activities_notification');
        }
        if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
            $this->render('admin_activities_compact');
        }
        if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'list')) {
            $this->render('admin_activities');
        }
    }
    public function admin_activities()
    {
        $this->setAction('activities');
    }
    public function view_ajax($id)
    {
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $id,
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.id',
                        'OtherUser.email',
                        'OtherUser.username'
                    )
                ) ,
                'Project' => array(
                    'fields' => array(
                        'Project.name',
                        'Project.slug',
                        'Project.id',
                        'Project.user_id',
                    ) ,
                )
            ) ,
            'recursive' => 2,
        ));
        $this->set('message', $message);
    }
    public function update_message_read($message_id = null)
    {
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $message_id,
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.project_id'
            ) ,
            'recursive' => -1,
        ));
        if (!empty($message) and $message['Message']['is_read'] == 0 && $message['Message']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['Message']['is_read'] = 1;
            $this->request->data['Message']['id'] = $message['Message']['id'];
            $this->Message->save($this->request->data);
        }
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.is_system_flagged' => 0
            ) ,
            'recursive' => 0
        ));
        $unread_count = !empty($unread_count) ? ' (' . $unread_count . ')' : '';
        $unread_count = __l('Inbox') . $unread_count;
        echo $unread_count;
        exit;
    }
    public function clear_notifications()
    {
        $this->loadModel('User');
        $data['User']['activity_message_id'] = $this->request->params['named']['final_id'];
        $data['User']['id'] = $this->Auth->user('id');
        $this->User->save($data);
        $this->Session->setFlash(__l('Notifications cleared successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'dashboard'
        ));
    }
}
?>