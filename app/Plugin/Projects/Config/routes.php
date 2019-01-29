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
$controllers = Cache::read('controllers_list', 'default');
if ($controllers === false) {
    $controllers = App::objects('controller');
    foreach($controllers as &$value) {
        $value = Inflector::underscore($value);
    }
    foreach($controllers as $value) {
        $controllers[] = Inflector::singularize($value);
    }
    array_push($controllers, 'admin');
    $controllers = implode('|', $controllers);
    Cache::write('controllers_list', $controllers);
}
CmsRouter::connect('/feeds', array(
    'controller' => 'projects',
    'action' => 'index',
    'plugin' => 'Projects',
    'ext' => 'rss',
));
CmsRouter::connect('/', array(
    'controller' => 'projects',
    'action' => 'index',
    'type' => 'home',
    'project_type' => 'pledge',
    'plugin' => 'Projects',
));
CmsRouter::connect('/:project_type/browse', array(
    'controller' => 'projects',
    'action' => 'discover',
) , array(
    'project_type' => '(pledge|donate|lend|equity)'
));
CmsRouter::connect('/projects/browse', array(
    'controller' => 'projects',
    'action' => 'discover',
));
CmsRouter::connect('/:project_type/add/*', array(
    'controller' => 'projects',
    'action' => 'add',
) , array(
    'project_type' => '(pledge|donate|lend|equity)'
));
CmsRouter::connect('/:project_type/category/:category/:idea', array(
    'controller' => 'projects',
    'action' => 'index',
) , array(
    'category' => '[a-zA-Z0-9\-_]+',
    'project_type' => '(pledge|donate|lend|equity)'
));
CmsRouter::connect('/:project_type/category/:category', array(
    'controller' => 'projects',
    'action' => 'index',
) , array(
    'category' => '[^\/]*',
    'project_type' => '(pledge|donate|lend|equity)'
));
CmsRouter::connect('/:project_type/filter/:filter', array(
    'controller' => 'projects',
    'action' => 'index',
) , array(
    'filter' => '[a-zA-Z0-9\-_]+',
    'project_type' => '(pledge|donate|lend|equity)'
));
CmsRouter::connect('/:city/projects', array(
    'controller' => 'projects',
    'action' => 'index',
) , array(
    'city' => '(?!' . $controllers . ')[^\/]*'
));
CmsRouter::connect('/:city/projects', array(
    'controller' => 'projects',
    'action' => 'index',
    'type' => 'home',
) , array(
    'city' => '(?!' . $controllers . ')[^\/]*'
));
CmsRouter::connect('/projects/type/:type', array(
    'controller' => 'projects',
    'action' => 'index',
) , array(
    'type' => '[a-zA-Z0-9\-]+'
));
CmsRouter::connect('/project_funds/type/:type', array(
    'controller' => 'project_funds',
    'action' => 'index',
) , array(
    'type' => '[a-zA-Z0-9\-]+'
));
