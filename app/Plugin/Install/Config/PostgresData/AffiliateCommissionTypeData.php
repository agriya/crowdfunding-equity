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
class AffiliateCommissionTypeData {

	public $table = 'affiliate_commission_types';

	public $records = array(
		array(
			'id' => '1',
			'name' => '%',
			'description' => 'Percentage'
		),
		array(
			'id' => '2',
			'name' => '$',
			'description' => 'Amount'
		),
	);

}
