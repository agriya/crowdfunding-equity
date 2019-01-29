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
$css_files = array(
    CSS . 'bootstrap.less',
	CSS . 'bootstrap-wysihtml5-0.0.2.css',
    CSS . 'bootstrap-datetimepicker.min.css',
    CSS . 'flag.css',
    //CSS . 'slickmap.css',
	CSS . 'bootstro.css',
);
$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>