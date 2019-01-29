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
class LendProjectStatusData {

	public $table = 'lend_project_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-10-14 13:42:28',
			'modified' => '2010-10-14 13:42:31',
			'name' => 'Pending',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'New ##PROJECT## posted by ##PROJECT_OWNER_NAME##'
		),
		array(
			'id' => '2',
			'created' => '2010-10-14 13:42:43',
			'modified' => '2011-03-21 02:47:54',
			'name' => 'Open for lending',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Open for lending'
		),
		array(
			'id' => '3',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Project Closed and paid to project owner',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Project closed'
		),
		array(
			'id' => '4',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Refunded due to expired',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Project expired'
		),
		array(
			'id' => '5',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Refunded due to canceled',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Project canceled'
		),
		array(
			'id' => '6',
			'created' => '2011-02-22 17:47:42',
			'modified' => '2011-02-22 17:47:44',
			'name' => 'Project Amount Repayment',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Project Amount Repayment'
		),
		array(
			'id' => '8',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2011-06-22 05:23:45',
			'name' => 'Open for voting',
			'lend_count' => '0',
			'is_active' => '1',
			'message' => 'Open for voting'
		),
	);

}
