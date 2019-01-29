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
class DonateProjectStatusData {

	public $table = 'donate_project_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-10-14 13:42:28',
			'modified' => '2010-10-14 13:42:31',
			'name' => 'Pending',
			'donate_count' => '0',
			'is_active' => '1',
			'message' => 'New ##PROJECT## posted by ##PROJECT_OWNER_NAME##'
		),
		array(
			'id' => '2',
			'created' => '2010-10-14 13:42:43',
			'modified' => '2011-03-21 02:47:54',
			'name' => 'Open for donating',
			'donate_count' => '0',
			'is_active' => '1',
			'message' => 'Open for donating'
		),
		array(
			'id' => '3',
			'created' => '2010-10-14 13:42:45',
			'modified' => '2010-10-14 13:42:45',
			'name' => 'Donation closed and paid to project owner',
			'donate_count' => '0',
			'is_active' => '1',
			'message' => 'Donation closed'
		),
		array(
			'id' => '4',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2011-06-22 05:23:45',
			'name' => 'Open for voting',
			'donate_count' => '0',
			'is_active' => '1',
			'message' => '##PROJECT## open for voting'
		),
		array(
			'id' => '5',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Project Expired',
			'donate_count' => '0',
			'is_active' => '1',
			'message' => 'Project Expired'
		),
	);

}
