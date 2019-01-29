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
class WithdrawalStatusData {

	public $table = 'withdrawal_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Pending',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '2',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Approved',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '3',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Rejected',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '5',
			'created' => '2010-04-15 14:20:17',
			'modified' => '2010-04-15 14:20:17',
			'name' => 'Success',
			'user_cash_withdrawal_count' => '0'
		),
	);

}
