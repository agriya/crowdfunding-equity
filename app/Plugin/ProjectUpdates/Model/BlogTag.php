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
class BlogTag extends AppModel
{
    public $name = 'BlogTag';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasAndBelongsToMany = array(
        'Blog' => array(
            'className' => 'ProjectUpdates.Blog',
            'joinTable' => 'blogs_blog_tags',
            'foreignKey' => 'blog_tag_id',
            'associationForeignKey' => 'blog_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'notempty'
            )
        );
    }
    function saveTagForBlog($arr_tag) 
    {
        $array_of_tag_ids = array();
        $split_tags = explode(',', $arr_tag);
        if (!empty($split_tags)) {
            foreach($split_tags as $tag) {
                $is_exist = $this->find('first', array(
                    'conditions' => array(
                        'BlogTag.name =' => trim($tag)
                    ) ,
                    'recursive' => -1
                ));
                if ($is_exist) {
                    $array_of_tag_ids[] = $is_exist['BlogTag']['id'];
                } else {
                    $this->create();
                    $this->data['BlogTag']['name'] = $tag;
                    $this->save();
                    $array_of_tag_ids[] = $this->getLastInsertID();
                }
            }
        }
        return $array_of_tag_ids;
    }
}
?>