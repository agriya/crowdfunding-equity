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
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
        'Translation' => array(
            'title' => __l('Translations') ,
            'url' => '',
            'weight' => 1200,
        ) ,
        'Translations' => array(
            'title' => __l('Translations') ,
            'url' => array(
                'controller' => 'translations',
                'action' => 'index',
            ) ,
            'weight' => 1210,
        ) ,
        'Language' => array(
            'title' => __l('Languages') ,
            'url' => array(
                'admin' => true,
                'controller' => 'languages',
                'action' => 'index',
            ) ,
            'access' => array(
                'admin'
            ) ,
            'weight' => 1220,
        ) ,
    )
));
$lang_code = Configure::read('site.language');
if (!empty($_COOKIE['CakeCookie']['user_language'])) {
    $lang_code = $_COOKIE['CakeCookie']['user_language'];
}
Configure::write('lang_code', $lang_code);
$translations = Cache::read($lang_code . '_translations');
if (empty($translations) and $translations === false) {
    App::import('Model', 'Translation.Translation');
    $translationObj = new Translation();
    $translations = $translationObj->find('all', array(
        'conditions' => array(
            'Language.iso2' => $lang_code
        ) ,
        'fields' => array(
            'Translation.name',
            'Translation.lang_text',
        ) ,
        'recursive' => 0
    ));
    Cache::set(array(
        'duration' => '+100 days'
    ));
    Cache::write($lang_code . '_translations', $translations);
}
if (!empty($translations)) {
    foreach($translations as $translation) {
        $GLOBALS['_langs'][$lang_code][$translation['Translation']['name']] = $translation['Translation']['lang_text'];
    }
}
if ($lang_code != 'en') {
    $js_trans_array = array(
        'Are you sure you want to' => __l('Are you sure you want to') ,
        'Are you sure you want to do this action?' => __l('Are you sure you want to do this action?') ,
        'Invalid extension, Only csv, txt are allowed' => __l('Invalid extension, Only csv, txt are allowed') ,
        'No Date Set' => __l('No Date Set') ,
        'Select date' => __l('Select date') ,
        'No Time Set' => __l('No Time Set') ,
        'You will be redirected to different site where you can buy this project. Are you sure you want to move frome this site?' => sprintf(__l('You will be redirected to different site where you can buy this %s. Are you sure you want to move frome this site?') , Configure::read('project.alt_name_for_project_singular_small')) ,
        'Are you sure you want to trigger cron to update project status?' => sprintf(__l('Are you sure you want to trigger cron to update %s status?') , Configure::read('project.alt_name_for_project_singular_small')) ,
        'No Date Set' => __l('No Date Set') ,
        'Send message without a subject?' => __l('Send message without a subject?') ,
        'Are you sure you want to discard this message?' => __l('Are you sure you want to discard this message?') ,
        'Please select atleast one record!' => __l('Please select atleast one record!') ,
        'Minimum amount' => __l('Minimum amount') ,
        'Fixed amount' => __l('Fixed amount') ,
        'Denomination' => __l('Denomination') ,
        'Suggested amount' => __l('Suggested amount') ,
        'Suggested amount, amount should be in comma seperated' => __l('Suggested amount, amount should be in comma seperated') ,
        'Remove' => __l('Remove') ,
        'Given' => __l('Given') ,
        'Not Given' => __l('Not Given') ,
        'Done' => __l('Done') ,
        'Prev' => __l('Prev') ,
        'Next' => __l('Next') ,
        'Today' => __l('Today') ,
        'January' => __l('January') ,
        'February' => __l('February') ,
        'March' => __l('March') ,
        'April' => __l('April') ,
        'May' => __l('May') ,
        'June' => __l('June') ,
        'July' => __l('July') ,
        'August' => __l('August') ,
        'September' => __l('September') ,
        'October' => __l('October') ,
        'November' => __l('November') ,
        'December' => __l('December') ,
        'Jan' => __l('Jan') ,
        'Feb' => __l('Feb') ,
        'Mar' => __l('Mar') ,
        'Apr' => __l('Apr') ,
        'May' => __l('May') ,
        'Jun' => __l('Jun') ,
        'Jul' => __l('Jul') ,
        'Aug' => __l('Aug') ,
        'Sep' => __l('Sep') ,
        'Oct' => __l('Oct') ,
        'Nov' => __l('Nov') ,
        'Dec' => __l('Dec') ,
        'Sunday' => __l('Sunday') ,
        'Monday' => __l('Monday') ,
        'Tuesday' => __l('Tuesday') ,
        'Wednesday' => __l('Wednesday') ,
        'Thursday' => __l('Thursday') ,
        'Friday' => __l('Friday') ,
        'Saturday' => __l('Saturday') ,
        'Sun' => __l('Sun') ,
        'Mon' => __l('Mon') ,
        'Tue' => __l('Tue') ,
        'Wed' => __l('Wed') ,
        'Thu' => __l('Thu') ,
        'Fri' => __l('Fri') ,
        'Sat' => __l('Sat') ,
        'Su' => __l('Su') ,
        'Mo' => __l('Mo') ,
        'Tu' => __l('Tu') ,
        'We' => __l('We') ,
        'Th' => __l('Th') ,
        'Fr' => __l('Fr') ,
        'sa' => __l('sa') ,
        'Unfollow' => __l('Unfollow') ,
        'Following' => __l('Following') ,
        'Follow' => __l('Follow') ,
    );
    foreach($js_trans_array as $k => $v) {
        Configure::write('Js.cfg.lang.' . $k, $v);
    }
}
?>