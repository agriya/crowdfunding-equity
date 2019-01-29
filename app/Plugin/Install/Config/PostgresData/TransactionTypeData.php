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
class TransactionTypeData {

	public $table = 'transaction_types';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-04-08 15:53:48',
			'modified' => '2012-05-14 07:10:04',
			'name' => 'Project Backed',
			'is_credit' => '',
			'is_credit_to_receiver' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'You ##FUNDED## for project ##PROJECT##',
			'message_for_admin' => '##BACKER## ##FUNDED## for project ##PROJECT##',
			'message_for_receiver' => '##BACKER## ##FUNDED## for your project ##PROJECT##',
			'transaction_variables' => '##PROJECT##, ##BACKER##, ##FUNDED##'
		),
		array(
			'id' => '2',
			'created' => '2010-04-08 15:53:48',
			'modified' => '2010-04-08 15:53:48',
			'name' => 'Project Fund Refunded',
			'is_credit' => '',
			'is_credit_to_receiver' => '1',
			'is_credit_to_admin' => '',
			'message' => '##BACKER## ##FUNDED## ##CANCELED## for your project ##PROJECT##',
			'message_for_admin' => '##BACKER## ##FUNDED## ##CANCELED## for project ##PROJECT##',
			'message_for_receiver' => 'Your ##FUNDED## ##CANCELED## for project ##PROJECT##',
			'transaction_variables' => '##PROJECT##, ##BACKER##, ##FUNDED##, ##CANCELED##'
		),
		array(
			'id' => '3',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Project Listing',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'You have added a new project ##PROJECT##',
			'message_for_admin' => '##PROJECT_OWNER## have added a new project ##PROJECT##',
			'message_for_receiver' => '',
			'transaction_variables' => '##PROJECT_OWNER##, ##PROJECT##'
		),
		array(
			'id' => '4',
			'created' => '2011-03-08 11:20:02',
			'modified' => '2011-03-08 11:20:04',
			'name' => 'User Membership',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Membership fee paid',
			'message_for_admin' => 'Membership fee paid by ##USER## ',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '5',
			'created' => '2010-03-04 10:17:05',
			'modified' => '2010-03-04 10:17:05',
			'name' => 'Amount added to wallet',
			'is_credit' => '1',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Amount added to wallet',
			'message_for_admin' => 'Amount added to ##USER## wallet',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '6',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Cash withdrawal request',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Cash withdrawal request made by you',
			'message_for_admin' => 'Cash withdrawal request made by ##USER##',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '7',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Cash withdrawal request approved',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Your cash withdrawal request approved by Administrator',
			'message_for_admin' => 'You (Administrator) have approved ##USER## cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '8',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Cash withdrawal request rejected',
			'is_credit' => '1',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Amount refunded for rejected cash withdrawal request',
			'message_for_admin' => 'Amount refunded to ##USER## for rejected cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '9',
			'created' => '2010-03-04 10:20:11',
			'modified' => '2010-03-04 10:20:14',
			'name' => 'Cash withdrawal request paid',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Cash withdraw request amount paid to you',
			'message_for_admin' => 'Cash withdraw request amount paid to ##USER##',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '10',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Cash withdrawal request failed',
			'is_credit' => '1',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Amount refunded for failed cash withdrawal request',
			'message_for_admin' => 'Amount refunded to ##USER## for failed cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '11',
			'created' => '2010-09-17 11:12:37',
			'modified' => '2010-09-17 11:12:42',
			'name' => 'Add fund to wallet',
			'is_credit' => '1',
			'is_credit_to_receiver' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'Administrator added fund to your wallet',
			'message_for_admin' => 'Added fund to ##USER## wallet',
			'message_for_receiver' => 'Administrator added fund to your wallet',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '12',
			'created' => '2010-09-17 11:13:20',
			'modified' => '2010-09-17 11:13:23',
			'name' => 'Deduct fund from wallet',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Administrator deducted fund from your wallet',
			'message_for_admin' => 'Deducted fund from ##USER## wallet',
			'message_for_receiver' => 'Administrator deducted fund from your wallet',
			'transaction_variables' => '##USER##'
		),
		array(
			'id' => '13',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Affiliate cash withdrawal request',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Affiliate cash withdrawal request made by you',
			'message_for_admin' => 'Affiliate cash withdrawal request made by ##AFFILIATE_USER##',
			'message_for_receiver' => '',
			'transaction_variables' => '##AFFILIATE_USER##'
		),
		array(
			'id' => '14',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Affiliate cash withdrawal request approved',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Your affiliate cash withdrawal request approved by Administrator',
			'message_for_admin' => 'You (Administrator) have approved ##AFFILIATE_USER## cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##AFFILIATE_USER##'
		),
		array(
			'id' => '15',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Affiliate cash withdrawal request rejected',
			'is_credit' => '1',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Amount refunded for rejected affiliate cash withdrawal request',
			'message_for_admin' => 'Amount refunded to ##AFFILIATE_USER## for rejected affiliate cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##AFFILIATE_USER##'
		),
		array(
			'id' => '16',
			'created' => '2010-03-04 10:20:11',
			'modified' => '2010-03-04 10:20:14',
			'name' => 'Affiliate cash withdrawal request paid',
			'is_credit' => '',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '',
			'message' => 'Affiliate cash withdraw request amount paid to you',
			'message_for_admin' => 'Affiliate cash withdraw request amount paid to ##AFFILIATE_USER##',
			'message_for_receiver' => '',
			'transaction_variables' => '##AFFILIATE_USER##'
		),
		array(
			'id' => '17',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Affiliate cash withdrawal request failed',
			'is_credit' => '1',
			'is_credit_to_receiver' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Amount refunded for failed affiliate cash withdrawal request',
			'message_for_admin' => 'Amount refunded to ##AFFILIATE_USER## for failed affiliate cash withdrawal request',
			'message_for_receiver' => '',
			'transaction_variables' => '##AFFILIATE_USER##'
		),
		array(
			'id' => '18',
			'created' => '2013-05-27 12:42:21',
			'modified' => '2013-05-27 12:42:24',
			'name' => 'Project Fund Repayment',
			'is_credit' => '',
			'is_credit_to_receiver' => '1',
			'is_credit_to_admin' => '',
			'message' => 'Repayment for your project ##PROJECT## sent.',
			'message_for_admin' => 'Repayment for project ##PROJECT##',
			'message_for_receiver' => 'Your ##FUNDED## repayment for project ##PROJECT## has been credited.',
			'transaction_variables' => '##PROJECT##, ##BACKER##, ##FUNDED##'
		),
	);

}
