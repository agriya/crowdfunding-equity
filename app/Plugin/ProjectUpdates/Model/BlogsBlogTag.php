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
class BlogsBlogTag extends AppModel
{
    public $name = 'BlogsBlogTag';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Blog' => array(
            'className' => 'ProjectUpdates.Blog',
            'foreignKey' => 'blog_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'BlogTag' => array(
            'className' => 'ProjectUpdates.BlogTag',
            'foreignKey' => 'blog_tag_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'BlogComment'
        );
        $this->validate = array(
            'blog_id' => array(
                'rule' => 'numeric',
                'message' => __l('Must be in numeric')
            ) ,
            'blog_tag_id' => array(
                'rule' => 'numeric',
                'message' => __l('Must be in numeric')
            )
        );
    }
}
?>