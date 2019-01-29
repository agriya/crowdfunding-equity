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
class BlogTagsController extends AppController
{
    public $name = 'BlogTags';
    public function index() 
    {
        $this->pageTitle = __l('Update Tags');
        $blogTag = $this->BlogTag->find('all', array(
            'recursive' => 1,
            'contain' => array(
                'Blog' => array(
                    'fields' => array(
                        'id'
                    )
                )
            )
        ));
        $tag_arr = array();
        foreach($blogTag as $blogTag) {
            $tag_arr[$blogTag['BlogTag']['slug']] = count($blogTag['Blog']);
            $tag_name_arr[$blogTag['BlogTag']['slug']] = $blogTag['BlogTag']['name'];
        }
        $this->set('tag_arr', $tag_arr);
        $this->set('tag_name_arr', $tag_name_arr);
    }
}
?>