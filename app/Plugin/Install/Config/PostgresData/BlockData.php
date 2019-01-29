<?php
/**
 *
 * @package		Crowdfunding
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-07-25
 *
 */
class BlockData {

	public $table = 'blocks';

	public $records = array(
		array(
			'id' => '1',
			'region_id' => '2',
			'title' => 'Pledge - Projects Stats',
			'alias' => 'pledge_project_stats',
			'body' => 'admin stats page',
			'show_title' => '',
			'class' => '',
			'status' => '1',
			'weight' => '10',
			'element' => 'Pledge.chart_project_stats',
			'visibility_roles' => '',
			'visibility_paths' => '',
			'visibility_php' => '',
			'params' => '',
			'modified' => '2012-08-13 17:35:55',
			'created' => '2012-08-13 17:35:58',
			'plugin_name' => 'Pledge'
		),
		array(
			'id' => '2',
			'region_id' => '2',
			'title' => 'Donate - Projects Stats',
			'alias' => 'donate_project_stats',
			'body' => 'admin stats page',
			'show_title' => '',
			'class' => '',
			'status' => '1',
			'weight' => '20',
			'element' => 'Donate.chart_project_stats',
			'visibility_roles' => '',
			'visibility_paths' => '',
			'visibility_php' => '',
			'params' => '',
			'modified' => '2012-08-13 17:35:55',
			'created' => '2012-08-13 17:35:58',
			'plugin_name' => 'Donate'
		),
		array(
			'id' => '3',
			'region_id' => '2',
			'title' => 'Lend - Projects Stats',
			'alias' => 'lend_project_stats',
			'body' => 'admin stats page',
			'show_title' => '',
			'class' => '',
			'status' => '1',
			'weight' => '30',
			'element' => 'Lend.chart_project_stats',
			'visibility_roles' => '',
			'visibility_paths' => '',
			'visibility_php' => '',
			'params' => '',
			'modified' => '2013-03-19 14:01:44',
			'created' => '2013-03-19 14:01:47',
			'plugin_name' => 'Lend'
		),
		array(
			'id' => '4',
			'region_id' => '2',
			'title' => 'Equity - Projects Stats',
			'alias' => 'equity_project_stats',
			'body' => 'admin stats page',
			'show_title' => '',
			'class' => '',
			'status' => '1',
			'weight' => '40',
			'element' => 'Equity.chart_project_stats',
			'visibility_roles' => '',
			'visibility_paths' => '',
			'visibility_php' => '',
			'params' => '',
			'modified' => '2013-03-19 14:01:44',
			'created' => '2013-03-19 14:01:47',
			'plugin_name' => 'Equity'
		),
	);

}
