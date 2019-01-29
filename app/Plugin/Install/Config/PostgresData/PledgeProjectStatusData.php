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
class PledgeProjectStatusData {

	public $table = 'pledge_project_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-10-14 13:42:28',
			'modified' => '2010-10-14 13:42:31',
			'name' => 'Pending',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'New ##PROJECT## posted by ##PROJECT_OWNER_NAME##'
		),
		array(
			'id' => '2',
			'created' => '2010-10-14 13:42:43',
			'modified' => '2011-03-21 02:47:54',
			'name' => 'Open for funding',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Open for pledging'
		),
		array(
			'id' => '3',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Funding closed and paid to project owner',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Funding closed'
		),
		array(
			'id' => '4',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Refunded due to expired',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Project expired'
		),
		array(
			'id' => '5',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Refunded due to cancelled',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Project canceled'
		),
		array(
			'id' => '6',
			'created' => '2011-02-22 17:47:42',
			'modified' => '2011-02-22 17:47:44',
			'name' => 'Goal reached',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Goal reached'
		),
		array(
			'id' => '8',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2011-06-22 05:23:45',
			'name' => 'Open for voting',
			'pledge_count' => '0',
			'is_active' => '1',
			'message' => 'Open for voting'
		),
	);

}
