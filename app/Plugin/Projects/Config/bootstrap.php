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
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'weight' => 30,
    'children' => array(
        'User Activities' => array(
            'title' => __l('Site Activities') ,
            'url' => array(
                'controller' => 'messages',
                'action' => 'activities',
                'type' => 'list'
            ) ,
            'weight' => 10,
        ) ,
        'Project Comments' => array(
            'title' => sprintf(__l('%s Comments') , Configure::read('project.alt_name_for_project_singular_caps')) ,
            'url' => array(
                'controller' => 'messages',
                'action' => 'index',
                'type' => 'project_comments'
            ) ,
            'weight' => 79,
        ) ,
        'Project Views' => array(
            'title' => sprintf(__l('%s Views') , Configure::read('project.alt_name_for_project_singular_caps')) ,
            'url' => array(
                'controller' => 'project_views',
                'action' => 'index',
            ) ,
            'weight' => 80,
        ) ,
    ) ,
));
CmsHook::setExceptionUrl(array(
    'projects/index',
    'projects/autocomplete',
    'projects/view',
    'projects/discover',
    'projects/discover_donate',
    'projects/download',
    'projects/lst',
    'project_funds/index',
    'messages/index',
    'messages/activities',
    'projects/start',
    'projects/mediadownload',
));
$defaultModel = array(
    'Transaction' => array(
        'belongsTo' => array(
            'Project' => array(
                'className' => 'Projects.Project',
                'foreignKey' => 'foreign_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            ) ,
            'ProjectFund' => array(
                'className' => 'Projects.ProjectFund',
                'foreignKey' => 'foreign_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            )
        ) ,
    ) ,
    'User' => array(
        'hasMany' => array(
			'ProjectUpdates' => array(
				'className' => 'ProjectUpdates.Blog',
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
			'ProjectFeed' => array(
				'className' => 'ProjectUpdates.ProjectFeed',
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
            'Project' => array(
                'className' => 'Projects.Project',
                'foreignKey' => 'user_id',
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
            'ProjectFund' => array(
                'className' => 'Projects.ProjectFund',
                'foreignKey' => 'user_id',
                'dependent' => false,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
            'Message' => array(
                'className' => 'Projects.Message',
                'foreignKey' => 'user_id',
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
if (isPluginEnabled('ProjectFlags')) {
    $pluginModel = array(
        'ProjectFlag' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'project_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'counterCache' => true
                ) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
if (isPluginEnabled('Affiliates')) {
    $pluginModel = array(
        'Affiliate' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'foreign_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                ) ,
                'ProjectFund' => array(
                    'className' => 'Projects.ProjectFund',
                    'foreignKey' => 'foreign_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                ) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
if (isPluginEnabled('ProjectFollowers')) {
    $pluginModel = array(
        'ProjectFollower' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'project_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'counterCache' => true
                ) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
if (isPluginEnabled('ProjectRewards')) {
    $pluginModel = array(
        'ProjectReward' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'project_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                )
            ) ,
            'hasMany' => array(
                'ProjectFund' => array(
                    'className' => 'Projects.ProjectFund',
                    'foreignKey' => 'project_reward_id',
                    'dependent' => false,
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'limit' => '',
                    'offset' => '',
                    'exclusive' => '',
                    'finderQuery' => '',
                    'counterQuery' => ''
                )
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
if (isPluginEnabled('ProjectUpdates')) {
    $pluginModel = array(
        'Blog' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'project_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'counterCache' => true,
                    'counterScope' => array(
                        'Blog.is_admin_suspended' => '0'
                    ) ,
                ) ,
            ) ,
        ) ,
        'ProjectFeed' => array(
            'belongsTo' => array(
                'Project' => array(
                    'className' => 'Projects.Project',
                    'foreignKey' => 'project_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'counterCache' => true,
                )
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
CmsHook::bindModel($defaultModel);
$sitemap_conditions = array(
    'Project.is_admin_suspended' => 0
);
if (isPluginEnabled('Pledge')) {
    $sitemap_conditions = array_merge($sitemap_conditions, array(
        'Pledge.pledge_project_status_id' => array(
            2, //ConstPledgeProjectStatus::OpenForFunding,
            3, //ConstPledgeProjectStatus::FundingClosed,
            6, //ConstPledgeProjectStatus::GoalReached,
            8, //ConstPledgeProjectStatus::OpenForIdea
            
        )
    ));
}
if (isPluginEnabled('Donate')) {
    $sitemap_conditions = array_merge($sitemap_conditions, array(
        'Donate.donate_project_status_id' => array(
            2, //ConstDonateProjectStatus::OpenForDonating,
            3, //ConstDonateProjectStatus::FundingClosed,
            4, //ConstDonateProjectStatus::OpenForIdea
            
        )
    ));
}
if (isPluginEnabled('Lend')) {
    $sitemap_conditions = array_merge($sitemap_conditions, array(
        'Lend.lend_project_status_id' => array(
            2, //ConstLendProjectStatus::OpenForlending,
            3, //ConstLendProjectStatus::ProjectClosed,
            6, //ConstLendProjectStatus::ProjectAmountRepayment,
            8, //ConstLendProjectStatus::OpenForIdea
            
        )
    ));
}
if (isPluginEnabled('Equity')) {
    $sitemap_conditions = array_merge($sitemap_conditions, array(
        'Equity.equity_project_status_id' => array(
            2, //ConstEquityProjectStatus::OpenForInvesting,
            3, //ConstEquityProjectStatus::ProjectClosed,
            8, //ConstEquityProjectStatus::OpenForIdea
            
        )
    ));
}
CmsHook::setSitemapModel(array(
    'Project' => array(
        'conditions' => $sitemap_conditions,
        'recursive' => 0
    )
));
