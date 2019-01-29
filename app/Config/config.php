<?php
/**
 * CrowdFunding
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    CrowdFunding
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
/**
 * Custom configurations
 */
if (!defined('DEBUG')) {
    define('DEBUG', 0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', 'user_language');
    // salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
    // sub admin is available in site or not
    define('PERMANENT_CACHE_HAVE_SUB_ADMIN', false);
    // Enable support for HTML5 History/State API
    // By enabling this, users will not see full page load
    define('IS_ENABLE_HTML5_HISTORY_API', false);
    // Force hashbang based URL for all browsers
    // When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
// $config['site']['license_key'] = 'enter your license key';
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'download',
    'connect',
    'v',
	'confirmation'
);
$config['permanent_cache']['view_action'] = array(
	'projects',
	'users',
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['Project']['image'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['project']['file'] = array(
    'allowedMime' => '*',
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png',
        'doc',
        'pdf',
        'xls',
        'wmv',
        'txt',
        'flv'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['StretchType']=array(
     "Repeat" => 'bg-repeat',
     "Stretch" => 'bg-stretch',
     "AutoResize" => 'bg-stretch-autoresize'
);
$config['Subscription']['is_handle_aspect'] = 1;
$config['Project']['project_fee_payeer'] = 'Site';
$config['Project']['payment_gateway_flow_id'] = 'Buyer -> Project Owner -> Site';
$default_timezone = 'Europe/Berlin';
if (ini_get('date.timezone')) {
	$default_timezone = ini_get('date.timezone');
}
date_default_timezone_set($default_timezone);
/*
date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');
*/
if (class_exists('CmsHook') && method_exists('CmsHook', 'setExceptionUrl')) {
    CmsHook::setExceptionUrl(array(
        'nodes/home',
        'nodes/view',
        'nodes/term',
        'nodes/search',
        'nodes/how_it_works',
        'cities/index',
        'comments/index',
        'comments/add',
        'users/refer',
        'users/register',
        'users/login',
        'users/logout',
        'users/reset',
        'users/forgot_password',
        'users/openid',
        'users/oauth_callback',
        'users/activation',
        'users/resend_activation',
        'users/view',
	'users/validate_user',
        'users/show_captcha',
        'users/captcha_play',
        'users/oauth_facebook',
        'users/facepile',
        'users/show_header',
        'images/view',
        'contacts/view',
        'users/admin_login',
        'users/admin_logout',
        'devs/asset_css',
        'devs/asset_js',
	'devs/sitemap',
        'crons/main',
        'crons/daily',
        'crons/encode',
        'contacts/add',
        'contacts/show_captcha',
        'contacts/captcha_play',
        'payments/user_pay_now',
        'payments/get_gateways',
        'devs/yadis',
        'activities/index',
	'languages/change_language',
	'project_feeds/index',
	'high_performances/update_content',
	'subscriptions/confirmation',
	'users/facebook_auto_login',
	'high_performances/show_project_comments',
	'projects/show_admin_control_panel',
	'security_questions/index',
	'users/iphone_social_register',
	'project_followers/index',
	'projects/index',
	'payments/get_sudopay_gateways',
	'languages/index',
	'user_profiles/masterlist',
	'projects/project_pay_now',
	'projects/feature_list',
	'projects/feature_slide',
    ));
}
$config['site']['is_admin_settings_enabled'] = true;
if (!empty($_SERVER['HTTP_HOST']) && in_array($_SERVER['HTTP_HOST'], array('crowdfunding.servicepg.develag.com', 'crowdfundingpb.servicepg.develag.com', 'crowdfundingpl.servicepg.develag.com')) && !in_array($_SERVER['REMOTE_ADDR'], array('182.72.136.170'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demo_mode_update_not_allowed_pages'] = array(
		'users/admin_send_mail',
		'pages/admin_edit',
		'settings/admin_edit',
		'email_templates/admin_edit',
	);
	$config['site']['admin_demo_mode_not_allowed_actions'] = array(
		'admin_delete',
		'admin_update',
	);
}
