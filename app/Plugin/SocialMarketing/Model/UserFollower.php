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
class UserFollower extends AppModel
{
    public $name = 'UserFollower';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'FollowUser' => array(
            'className' => 'User',
            'foreignKey' => 'followed_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'User',
        );
        $this->_permanentCacheAssociatedUsers = array(
            'followed_user_id',
            'user_id',
        );
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
    function send_follow_mail($user_id, $action, $project) 
    {
        $users = $this->find('all', array(
            'conditions' => array(
                'UserFollower.followed_user_id' => $user_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
                'FollowUser' => array(
                    'fields' => array(
                        'FollowUser.id',
                        'FollowUser.username',
                    )
                ) ,
            ) ,
            'recursive' => 0
        ));
        if (!empty($users)) {
            foreach($users as $user) {
                $emailFindReplace = array(
                    '##USER##' => $user['User']['username'],
                    '##FOLLOWED_USER##' => $user['FollowUser']['username'],
                    '##PROJECT_NAME##' => $project['Project']['name'],
                    '##PROJECT##' => Router::url(array(
                        'controller' => 'projects',
                        'action' => 'view',
                        $project['Project']['slug'],
                        'admin' => false
                    ) , true) ,
                    '##ACTION##' => $action
                );
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                $email_template = $this->EmailTemplate->selectTemplate('Follow Email');
                $this->_sendEmail($email_template, $emailFindReplace, $user['User']['email']);
            }
        }
    }
}
?>