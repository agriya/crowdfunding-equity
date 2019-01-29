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
class ProjectFollowerEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Controller.ProjectFollower.followerStatus' => array(
                'callable' => 'followerStatus'
            )
        );
    }
    public function followerStatus($event) 
    {
        $obj = $event->subject();
        $project_id = $event->data['project_id'];
        $follower = $obj->Project->ProjectFollower->find('first', array(
            'conditions' => array(
                'ProjectFollower.user_id' => $obj->Auth->user('id') ,
                'ProjectFollower.project_id' => $project_id
            ) ,
            'fields' => array(
                'ProjectFollower.id',
                'ProjectFollower.user_id',
                'ProjectFollower.project_id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($follower)) {
            $data['follow_text'] = __l('Unfollow');
            $data['follow_url'] = Router::url(array(
                'controller' => 'project_followers',
                'action' => 'unfollow',
                $follower['ProjectFollower']['id'],
                'ext' => 'json'
            ) , true);
        } else if (empty($follower) && $obj->Auth->user('id')) {
            $data['follow_text'] = __l('Follow');
            $data['follow_url'] = Router::url(array(
                'controller' => 'project_followers',
                'action' => 'add',
                $project_id,
                'ext' => 'json'
            ) , true);
        } else {
            $data['follow_text'] = __l('Follow');
            $data['follow_url'] = '';
        }
        $event->data['data'] = $data;
    }
}
?>