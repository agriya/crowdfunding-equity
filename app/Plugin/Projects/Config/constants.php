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
class ConstPaymentMethod
{
    const AoN = 1;
    const KiA = 2;
}
class ConstAnonymous
{
    const None = 0;
    const Username = 1;
    const FundedAmount = 2;
    const Both = 3;
}
class ConstProjectActivities
{
    const Fund = 1;
    const ProjectComment = 2;
    const ProjectUpdate = 3;
    const ProjectUpdateComment = 4;
    const ProjectFollower = 5;
    const ProjectRating = 6;
    const StatusChange = 7;
    const FundCancel = 8;
    const RepaymentNotification = 9;
    const LateRepaymentNotification = 10;
    const AmountRepayment = 11;
    const ProjectRejected = 12;
}
class ConstListingFeeType
{
    const amount = 1;
    const percentage = 2;
}
class ConstProjectFundStatus
{
    const Backed = 1;
    const Refunded = 2;
    const Captured = 3;
    const PendingToPay = 4;
    const Authorized = 5;
    const PaidToOwner = 6;
    const Canceled = 7;
    const Expired = 8;
    const PaymentFailed = 9;
    const Collection = 10;
    const Closed = 11;
    const DefaultFund = 12;
    const ManualPending = 13;
}
class ConstPledgeTypes
{
    const Any = 1;
    const Minimum = 2;
    const Fixed = 3;
    const Multiple = 4;
    const Reward = 5;
}
?>