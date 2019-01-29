<?php
/**
 * CrowdFunding
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    CrowdFunding
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstAttachment
{
    const UserAvatar = 1;
    const Project = 2;
	const Anonymous = 3;
	const Setting = 1;
	const Processing = 127;
}
class ConstViewType
{
    const NormalView = 1;
    const EmbedView = 2;
}
class ConstViewLayout
{
    const DetailedView = 'Detailed view';
    const CompactView = 'Compact view';
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
    const Approved = 6;
    const Disapproved = 7;
    const Featured = 8;
    const Notfeatured = 9;
    const Suspend = 10;
    const Twitter = 11;
    const Facebook = 12;
    const Flagged = 13;
    const Unflagged = 14;
    const Unsuspend = 15;
    const Normal = 38;
    const Gmail = 39;
    const Yahoo = 40;
    const Checked = 28;
    const Unchecked = 29;
    const Site = 30;
    const AffiliateUser = 37;
    const Publish = 40;
    const Unpublish = 41;
    const Promote = 42;
    const Unpromote = 43;
	const Drafted = 44;
	const Successful = 45;
	const Failed = 46;
	const Subscribed = 47;
	const Unsubscribed = 48;
	const UserFlagged = 49;
	const Invite = 50;
	const Prelaunch = 51;
	const PrivateBeta = 52;
	const PrelaunchSubscribed = 53;
	const PrivateBetaSubscribed = 54;
	const LinkedIn = 55;
	const Fixed = 56;
	const Flexible = 57;
	const PendingPayment = 58;
	const GooglePlus = 59;
	const AngelList = 60;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
class ConstMessageFolder
{
    const Inbox = 1;
    const SentMail = 2;
    const Drafts = 3;
    const Spam = 4;
    const Trash = 5;
    const Activities = 6;
}
class ConstPrivacySetting
{
    const EveryOne = 1;
    const Users = 2;
    const Friends = 3;
    const Nobody = 4;
}
class ConstPaymentGateways
{
    const Wallet = 2;
    const SudoPay = 3;
    // mass payment manual
    const ManualPay = 5;
    const Masspay = 6;
    const Testmode = 7;
    const Project = 8;
    const Pledge = 9;
    const Active = 10;
	const Donate = 11;
	const Signup = 12;
	const Lend = 13;
	const Equity = 14;
}
class ConstPaymentType
{
    const Pledge = 1;
    const ProjectListing = 2;
    const Wallet = 3;
    const Signup = 4;
    const PledgeCapture = 5;
}
class ConstTransactionTypes
{
    const ProjectBacked = 1;
    const Refunded = 2;
    const ListingFee = 3;
    const SignupFee = 4;
    const AmountAddedToWallet = 5;
    const CashWithdrawalRequest = 6;
    const CashWithdrawalRequestApproved = 7;
    const CashWithdrawalRequestRejected = 8;
    const CashWithdrawalRequestPaid = 9;
    const CashWithdrawalRequestFailed = 10;
    const AdminAddFundToWallet = 11;
    const AdminDeductFundFromWallet = 12;
    const AffiliateCashWithdrawalRequest = 13;
    const AffiliateCashWithdrawalRequestApproved = 14;
    const AffiliateCashWithdrawalRequestRejected = 15;
    const AffiliateCashWithdrawalRequestPaid = 16;
    const AffiliateCashWithdrawalRequestFailed = 17;
	const ProjectRepayment = 18;
}
class ConstProjectTypes
{
    const Pledge = 1;
	const Donate = 2;
	const Lend = 3;
	const Equity = 4;
}
class ConstPaymentGatewayFlow
{
    const BuyerSiteSeller = 'Buyer -> Site -> Project Owner';
    const BuyerSellerSite = 'Buyer -> Project Owner -> Site';
}
class ConstPaymentGatewayFee
{
    const Seller = 'Project Owner';
    const Site = 'Site';
    const SiteAndSeller = 'Site and Project Owner';
}
class ConstProjectUsers
{
    const Owner = 1;
    const Backer = 2;
    const Follower = 3;
}
class ConstProjectPaymentGatewayFee
{
    const Buyer = 'Project Owner';
    const Site = 'Site';
    const User = 'User';
}
class ConstSettingsSubCategory
{
    const Regional = 31;
    const DateAndTime = 33;
}
class ConstPaymentGatewaysName
{
    const SudoPay = 'ZazPay';
}
class constContentType
{
    const Page = 1;
}
class ConstPluginSettingCategories
{
    const Projects = 11;
    const Wallet = 82;
    const Withdrawals = 83;
    const Affiliates = 21;
    const ProjectRewards = 60;
    const Backers = 20;
    const ProjectOwner = 19;
    const Privacy = 72;
    const Regional = 31;
    const GoogleTranslations = 24;
	const JobActs = 12;
	const Developments = 28;
	const SocialMarketing = 85;
	const Insights = 103;
	const Pledge = 76;
	const Lend = 120;
	const Equity = 121;
	const WalletFee = 84;
	const Iphone = 112;
}
class ConstSiteState
{
    const Prelaunch = 1;
	const PrivateBeta = 2;
	const Launch = 3;
}
class ConstUserAvatarSource
{
    const Attachment = 1;
	const Facebook = 2;
	const Twitter = 3;
	const Google = 4;
	const Linkedin = 5;
	const GooglePlus = 6;
	const AngelList = 7;
}
class ConstPledgeCanceledBy
{
	const Admin = 1;
	const Owner = 2;
	const Backer = 3;
}
class ConstFilterOptions
{
	const Loggedin = 1;
	const NotLoggedin = 2;
	const Refferred = 3;
	const Followed = 4;
	const Voted = 5;
	const Commented = 6;
	const Funded = 7;
	const ProjectPosted = 8;
}