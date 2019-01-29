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
require_once 'constants.php';
CmsNav::add('Projects', array(
    'title' => 'Projects',
    'url' => array(
        'controller' => 'projects',
        'action' => 'index',
    ) ,
    'data-bootstro-step' => "4",
    'data-bootstro-content' => __l("To monitor the summary, price point statistics of site and also to manage all the projects posted in the site.") ,
    'weight' => 30,
    'icon-class' => 'file',
    'children' => array(
        'Equity Projects' => array(
            'title' => Configure::read('project.alt_name_for_equity_singular_caps') . ' ' . Configure::read('project.alt_name_for_project_plural_caps') ,
            'url' => array(
                'controller' => 'equities',
                'action' => 'index'
            ) ,
            'weight' => 60,
        ) ,
    ) ,
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
        'Equity Projects' => array(
            'title' => Configure::read('project.alt_name_for_equity_singular_caps') . ' ' . Configure::read('project.alt_name_for_project_plural_caps') ,
            'url' => '',
            'weight' => 700,
        ) ,
        'Equity Project Categories' => array(
            'title' => sprintf(__l('%s %s Categories') , Configure::read('project.alt_name_for_equity_singular_caps') , Configure::read('project.alt_name_for_project_singular_caps')) ,
            'url' => array(
                'controller' => 'equity_project_categories',
                'action' => 'index',
            ) ,
            'weight' => 710,
        ) ,
        'Equity Project Statuses' => array(
            'title' => sprintf(__l('%s %s Statuses') , Configure::read('project.alt_name_for_equity_singular_caps') , Configure::read('project.alt_name_for_project_singular_caps')) ,
            'url' => array(
                'controller' => 'equity_project_statuses',
                'action' => 'index',
            ) ,
            'weight' => 720,
        ) ,
    )
));
CmsNav::add('payments', array(
    'title' => __l('Payments') ,
    'weight' => 50,
    'children' => array(
        'Projects Funded' => array(
            'title' => __l('Projects Funded') ,
            'url' => '',
            'weight' => 300,
        ) ,
        'Equity Project Funds' => array(
            'title' => sprintf(__l('%s') , Configure::read('project.alt_name_for_equity_plural_caps')) ,
            'url' => array(
                'controller' => 'equities',
                'action' => 'funds',
            ) ,
            'weight' => 330,
        ) ,
    )
));
$defaultModel = array(
    'Project' => array(
        'hasOne' => array(
            'Equity' => array(
                'className' => 'Equity.Equity',
                'foreignKey' => 'project_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
        ) ,
    ) ,
    'ProjectFund' => array(
        'hasOne' => array(
            'EquityFund' => array(
                'className' => 'Equity.EquityFund',
                'foreignKey' => 'project_fund_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
			'Equity' => array(
                'className' => 'Equity.Equity',
                'foreignKey' => 'project_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
        ) ,
    ) ,
);
CmsHook::bindModel($defaultModel);
