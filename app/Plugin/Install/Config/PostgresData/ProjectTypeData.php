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
class ProjectTypeData {

	public $table = 'project_types';

	public $records = array(
		array(
			'id' => '1',
			'name' => 'Pledge',
			'slug' => 'pledge',
			'description' => '',
			'project_count' => '0',
			'form_field_count' => '45',
			'form_field_step_count' => '7',
			'form_field_group_count' => '11',
			'project_fund_count' => '0',
			'project_fund_amount' => '0',
			'site_revenue' => '0',
			'commission_percentage' => '',
			'commission_percentage_not_reached_need_amount' => '',
			'listing_fee' => '',
			'listing_fee_type' => '',
			'is_active' => '1',
			'funder_slug' => 'backer'
		),
		array(
			'id' => '2',
			'name' => 'Donate',
			'slug' => 'donate',
			'description' => '',
			'project_count' => '0',
			'form_field_count' => '34',
			'form_field_step_count' => '4',
			'form_field_group_count' => '10',
			'project_fund_count' => '0',
			'project_fund_amount' => '0',
			'site_revenue' => '0',
			'commission_percentage' => '',
			'commission_percentage_not_reached_need_amount' => '',
			'listing_fee' => '',
			'listing_fee_type' => '',
			'is_active' => '1',
			'funder_slug' => 'donor'
		),
		array(
			'id' => '3',
			'name' => 'Lend',
			'slug' => 'lend',
			'description' => '',
			'project_count' => '0',
			'form_field_count' => '43',
			'form_field_step_count' => '5',
			'form_field_group_count' => '11',
			'project_fund_count' => '0',
			'project_fund_amount' => '0',
			'site_revenue' => '0',
			'commission_percentage' => '',
			'commission_percentage_not_reached_need_amount' => '',
			'listing_fee' => '',
			'listing_fee_type' => '',
			'is_active' => '1',
			'funder_slug' => 'lender'
		),
		array(
			'id' => '4',
			'name' => 'Equity',
			'slug' => 'equity',
			'description' => '',
			'project_count' => '0',
			'form_field_count' => '34',
			'form_field_step_count' => '5',
			'form_field_group_count' => '10',
			'project_fund_count' => '0',
			'project_fund_amount' => '0',
			'site_revenue' => '0',
			'commission_percentage' => '',
			'commission_percentage_not_reached_need_amount' => '',
			'listing_fee' => '',
			'listing_fee_type' => '',
			'is_active' => '1',
			'funder_slug' => 'investor'
		),
	);

}
