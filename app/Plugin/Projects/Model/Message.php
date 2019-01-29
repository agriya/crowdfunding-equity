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
class Message extends AppModel
{
    public $name = 'Message';
    public $actsAs = array(
        'Polymorphic' => array(
            'classField' => 'class',
            'foreignKey' => 'foreign_id',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'OtherUser' => array(
            'className' => 'User',
            'foreignKey' => 'other_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ActivityUser' => array(
            'className' => 'User',
            'foreignKey' => 'activity_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ActivityMessage' => array(
            'className' => 'Message',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ProjectFund' => array(
            'className' => 'Projects.ProjectFund',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'MessageContent' => array(
            'className' => 'Projects.MessageContent',
            'foreignKey' => 'message_content_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Project' => array(
            'className' => 'Projects.Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Message.is_sender' => 0,
                'Message.is_activity' => 0,
                'MessageContent.is_admin_suspended' => 0
            )
        ) ,
    );
    public $hasOne = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Attachment.class' => 'Message',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ProjectFund',
            'Project',
			'HighPerformance',
        );
        $this->_permanentCacheAssociatedUsers = array(
            'other_user_id',
            'user_id',
        );
        $this->validate = array(
            'message_content_id' => array(
                'numeric'
            ) ,
            'message_folder_id' => array(
                'numeric'
            ) ,
            'is_sender' => array(
                'numeric'
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'message' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'project_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear Flag') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function sendNotifications($to_users, $subject, $message, $options = array())
    {
        //  to save message content
        $message_content['MessageContent']['id'] = '';
        $message_content['MessageContent']['subject'] = $subject;
        $message_content['MessageContent']['message'] = $message;
        $this->MessageContent->save($message_content);
        $message_id = $this->MessageContent->id;
        $size = strlen($subject) +strlen($message);
        $from = ConstUserIds::Admin;
        // To save in inbox //
        foreach($to_users as $to) {
            $is_saved = $this->saveMessage($to, $from, $message_id, ConstMessageFolder::Inbox, 0, 0, 0, $size, $options);
            // To save in sent iteams //
            $is_saved = $this->saveMessage($from, $to, $message_id, ConstMessageFolder::SentMail, 1, 1, 0, $size, $options);
        }
        return $message_id;
    }
    function saveMessage($user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $options = array())
    {
        $message['Message']['message_content_id'] = $message_id;
        $message['Message']['user_id'] = $user_id;
        $message['Message']['other_user_id'] = $other_user_id;
        $message['Message']['message_folder_id'] = $folder_id;
        $message['Message']['is_sender'] = $is_sender;
        $message['Message']['is_read'] = $is_read;
        $message['Message']['is_private'] = 1;
        $message['Message']['is_activity'] = 1;
        $message['Message']['parent_message_id'] = $parent_id;
        $message['Message']['size'] = $size;
        $message['Message']['project_id'] = (!empty($options['project_id'])) ? $options['project_id'] : 0;
        $message['Message']['project_fund_id'] = (!empty($options['project_fund_id'])) ? $options['project_fund_id'] : 0;
        $message['Message']['project_rating_id'] = (!empty($options['project_rating_id'])) ? $options['project_rating_id'] : 0;
        $message['Message']['class'] = $options['class'];
        $message['Message']['foreign_id'] = (!empty($options['foreign_id'])) ? $options['foreign_id'] : 0;
        $message['Message']['pledge_project_status_id'] = (!empty($options['pledge_project_status_id'])) ? $options['pledge_project_status_id'] : 0;
        $message['Message']['is_auto'] = (!empty($options['is_auto'])) ? $options['is_auto'] : 0;
        $this->create();
        $this->save($message);
        $id = $this->id;
        return $id;
    }
    public function beforeFind($query)
    {
        $projectTypes = $this->getProjectTypes();
        $projectTypes[] = 0;
        $query['conditions'][$this->alias . '.project_type_id'] = $projectTypes;
        return $query;
    }
    public function afterDelete()
    {
        $this->deleteActivity("Message", $this->id);
    }
    public function updateActivitiesHideFromPublic($project_id)
    {
        $this->updateAll(array(
            'Message.is_hide_from_public' => 1
        ) , array(
            'Message.project_id' => $project_id,
            'Message.is_activity' => 1
        ));
    }
}
?>