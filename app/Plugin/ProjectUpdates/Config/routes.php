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
CmsRouter::connect('/blogs/project/:project', array(
    'controller' => 'blogs',
    'action' => 'ProjectUpdates',
    'plugin' => 'Projects',
) , array(
    'project' => '[a-zA-Z0-9\-]+'
));
CmsRouter::connect('/blogs/tag/:tag', array(
    'controller' => 'blogs',
    'action' => 'index',
    'plugin' => 'ProjectUpdates',
) , array(
    'tag' => '[a-zA-Z0-9\-]+'
));
CmsRouter::connect('/blogs/category/:category', array(
    'controller' => 'blogs',
    'action' => 'index',
    'plugin' => 'ProjectUpdates',
) , array(
    'tag' => '[a-zA-Z0-9\-]+'
));
CmsRouter::connect('/blogs/user/:username', array(
    'controller' => 'blogs',
    'action' => 'index',
    'plugin' => 'ProjectUpdates',
) , array(
    'username' => '[a-zA-Z0-9\-]+'
));
CmsRouter::connect('/blogs/status/:status', array(
    'controller' => 'blogs',
    'action' => 'index',
    'plugin' => 'ProjectUpdates',
) , array(
    'tag' => '[a-zA-Z\-]+'
));
