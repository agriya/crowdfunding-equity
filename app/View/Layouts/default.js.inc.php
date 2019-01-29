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
$js_files = array(
    JS . 'libs/jquery.js',
    JS . 'libs/jquery.form.js',
    JS . 'libs/jquery.blockUI.js',
    JS . 'libs/jquery.metadata.js',
    JS . 'libs/jquery-ui-1.10.3.custom.js',
    JS . 'libs/jquery.cookie.js',
    JS . 'libs/jquery.simplyCountable.js',
    JS . 'libs/jquery.flash.js',
    JS . 'libs/jquery.autogeocomplete.js',
    JS . 'libs/jquery.countdown.js',
    JS . 'libs/jquery.slug.js',
    JS . 'libs/jquery.oauthpopup.js',
	JS . 'libs/bootstrap.min.js',
    JS . 'libs/bootstrap-datetimepicker.min.js',
    JS . 'libs/respond.min.js',
    JS . 'libs/excanvas.js',
	JS . 'libs/socialite.js',
	JS . 'libs/scrollspy.js',
    JS . 'libs/jquery.slimscroll.js',
	JS . 'libs/scroll-custume.js',
    JS . 'libs/jquery-list.js',
    JS . 'libs/jquery.easytabs.min.js',
	JS . 'libs/date.format.js',
    JS . 'libs/wysihtml5-0.3.0.js',
    JS . 'libs/bootstrap-wysihtml5-0.0.2.js',
    JS . 'libs/jquery.timeago.js',
    JS . 'libs/jquery.easy-pie-chart.min.js',
    JS . 'libs/jquery.fullBg.js',
    JS . 'libs/jquery.scrollTo.js',
    JS . 'libs/bootstro.js',
    JS . 'libs/jquery.pjax.js',
    JS . 'libs/jquery.sparkline.min.js',
	JS . 'libs/jquery.payment.js',	
    JS . 'common.js',
);
$js_files = Set::merge($js_files, Configure::read('site.default.js_files'));
