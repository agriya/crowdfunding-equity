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
class ProjectUpdateEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents() 
    {
        return array(
            'Controller.ProjectType.getContain' => array(
                'callable' => 'getContain',
            ) ,
            'View.AdminDasboard.onActionToBeTaken' => array(
                'callable' => 'onActionToBeTakenRender'
            )
        );
    }
    public function getContain($event) 
    {
        $obj = $event->subject();
        $event->data['contain']['Blog'] = array(
            'User' => array(
                'UserAvatar',
                'fields' => array(
                    'User.username',
                    'User.id'
                )
            ) ,
            'BlogComment' => array(
                'conditions' => array(
                    'Blog.is_admin_suspended' => 0,
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.username',
                        'User.id'
                    )
                ) ,
                'conditions' => array(
                    'BlogComment.is_admin_suspended' => 0,
                ) ,
                'fields' => array(
                    'BlogComment.id',
                    'BlogComment.created',
                    'BlogComment.comment',
                    'BlogComment.user_id',
                )
            ) ,
            'fields' => array(
                'Blog.id',
                'Blog.title',
                'Blog.slug',
                'Blog.content',
                'Blog.created',
            ) ,
        );
    }
    public function onActionToBeTakenRender($event) 
    {
        $view = $event->subject();
        App::import('Model', 'Projects.Project');
        $Project = new Project();
        $data['system_flagged_blog_count'] = $Project->Blog->find('count', array(
            'conditions' => array(
                'Blog.is_system_flagged = ' => 1,
            )
        ));
        $data['system_flagged_blog_comment_count'] = $Project->Blog->BlogComment->find('count', array(
            'conditions' => array(
                'BlogComment.is_system_flagged = ' => 1,
            )
        ));
        $event->data['content']['SystemFlagged'].= $view->element('ProjectUpdates.admin_action_taken', $data);
    }
}
?>