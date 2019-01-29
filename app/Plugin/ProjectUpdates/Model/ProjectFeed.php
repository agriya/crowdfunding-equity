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
class ProjectFeed extends AppModel
{
    public $name = 'ProjectFeed';
    public $displayField = 'title';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Project',
            'User',
        );
        $this->validate = array(
            'project_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'favicon' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'sitename' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'title' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'link' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'date' => array(
                'rule' => 'date',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function rss_feed($project = null, $limit = null) 
    {
        App::import('Vendor', 'simplepie');
        $feed = new SimplePie();
        if (!empty($limit)) {
            $feed->set_item_limit($limit);
        }
        $feed->set_feed_url($project['Project']['feed_url']);
        $feed->set_cache_location(CACHE . 'rss' . DS);
        $feed->set_cache_duration(300);
        $feed->set_timeout(30);
        $feed->set_favicon_handler(Cache::read('site_url_for_shell', 'long') . 'handler_image.php');
        //retrieve the feed
        $feed->init();
        $feed->handle_content_type();
        foreach($feed->get_items() as $project_feed) {
            $projectFeeds = $project_feed->get_feed();
            $projectfeed = $this->find('first', array(
                'conditions' => array(
                    'ProjectFeed.project_id' => $project['Project']['id'],
                    'ProjectFeed.title' => $project_feed->get_title()
                ) ,
                'recursive' => -1
            ));
            if (empty($projectfeed)) {
                $data['ProjectFeed']['project_id'] = $project['Project']['id'];
                $data['ProjectFeed']['project_type_id'] = $project['Project']['project_type_id'];
                $date = $project_feed->get_date('Y-m-d H:i:s');
                $data['ProjectFeed']['date'] = !empty($date) ? $date : date('Y-m-d H:i:s');
                $data['ProjectFeed']['favicon'] = $projectFeeds->get_favicon();
                $data['ProjectFeed']['sitename'] = $projectFeeds->get_title();
                $data['ProjectFeed']['title'] = $project_feed->get_title();
                $data['ProjectFeed']['link'] = $project_feed->get_permalink();
                $data['ProjectFeed']['description'] = $project_feed->get_description();
                $this->create();
                $this->save($data, false);
            }
        }
    }
    public function beforeFind($query) 
    {
        $query['conditions'][$this->alias . '.project_type_id'] = $this->getProjectTypes();
        return $query;
    }
}
?>