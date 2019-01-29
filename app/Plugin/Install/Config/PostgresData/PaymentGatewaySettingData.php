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
class PaymentGatewaySettingData {

	public $table = 'payment_gateway_settings';

	public $records = array(
		array(
			'id' => '16',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_project',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for project listing'
		),
		array(
			'id' => '18',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_pledge',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for pledge'
		),
		array(
			'id' => '23',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_donate',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for donate'
		),
		array(
			'id' => '26',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_lend',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for lend'
		),
		array(
			'id' => '27',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_equity',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for equity'
		),
		array(
			'id' => '28',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'sudopay_merchant_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '29',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'sudopay_website_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '30',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'sudopay_secret_string',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '31',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'is_enable_for_add_to_wallet',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for wallet add.'
		),
		array(
			'id' => '32',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'is_enable_for_project',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for project listing'
		),
		array(
			'id' => '33',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'is_enable_for_pledge',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for pledge'
		),
		array(
			'id' => '34',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'is_enable_for_donate',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for donate'
		),
		array(
			'id' => '35',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '3',
			'name' => 'is_enable_for_signup_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for signup fee.'
		),
		array(
			'id' => '38',
			'created' => '2013-07-22 17:09:03',
			'modified' => '2013-07-22 17:09:05',
			'payment_gateway_id' => '3',
			'name' => 'sudopay_api_key',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '39',
			'created' => '2013-07-22 17:20:49',
			'modified' => '2013-07-22 17:20:51',
			'payment_gateway_id' => '3',
			'name' => 'is_payment_via_api',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option'
		),
		array(
			'id' => '40',
			'created' => '2013-07-26 21:44:57',
			'modified' => '2013-07-26 21:44:59',
			'payment_gateway_id' => '3',
			'name' => 'sudopay_subscription_plan',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => 'Enterprise',
			'live_mode_value' => 'Enterprise',
			'description' => 'Subscription plan name'
		),
	);

}
