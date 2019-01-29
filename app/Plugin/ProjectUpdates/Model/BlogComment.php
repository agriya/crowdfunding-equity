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
class BlogComment extends AppModel
{
    public $name = 'BlogComment';
    public $displayField = 'comment';
    public $actsAs = array(
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'comment'
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Blog' => array(
            'className' => 'ProjectUpdates.Blog',
            'foreignKey' => 'blog_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'BlogComment.is_admin_suspended' => '0'
            ) ,
        ) ,
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
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
            'Project',
            'User',
        );
        $this->validate = array(
            'blog_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
            ) ,
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
            ) ,
            'comment' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => '_isValidCaptcha',
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear Flag') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    public function beforeFind($query) 
    {
        $query['conditions'][$this->alias . '.project_type_id'] = $this->getProjectTypes();
        return $query;
    }
    public function afterDelete() 
    {
        $this->deleteActivity("BlogComment", $this->id);
    }
}
?>