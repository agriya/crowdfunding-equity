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
class ProjectUpdatesCronComponent extends Component
{
    public function main() 
    {
        App::import('Model', 'Project');
        $this->Project = new Project();
        $projects = $this->Project->find('all', array(
            'conditions' => array(
                'Project.feed_url !=' => Null
            ) ,
            'recursive' => -1
        ));
        foreach($projects as $project) {
            if (!empty($project['Project']['feed_url'])) {
                $this->Project->rss_feed($project);
            }
        }
    }
}
