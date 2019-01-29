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
class ProjectFeedsController extends AppController
{
    public $name = 'ProjectFeeds';
    public function index($project_id = null) 
    {
        $this->pageTitle = __l('Updates');
        $conditions = array();
        if ($project_id) {
            $conditions['ProjectFeed.project_id'] = $project_id;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'recursive' => -1,
        );
        $this->set('projectFeeds', $this->paginate());
    }
}
?>