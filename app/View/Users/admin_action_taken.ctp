<div class="clearfix">
	<h3 class="pull-left"><i class="fa-fw fa fa-chevron-right small"></i><?php echo __l('Actions to Be Taken'); ?></h3>
</div>
<?php if(configure::read('user.is_admin_activate_after_register')) :?>
<div class="h3">
	<h5 class="text-capitalize list-group-item-text"><strong><?php echo __l('Users');?></strong></h5>
	<ul class="list-unstyled navbar-btn list-group-item-heading">
		<li>
			<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
			<?php echo $this->Html->link(' ' . __l('Pending Approval Users') . ' (' . $pending_approval_users. ')', array('controller'=> 'users', 'action' => 'index', 'type' => 'user_messages' , 'filter_id' =>ConstMoreAction::Inactive), array('class' => 'h5 rgt-move'));?>
		</li>
	</ul>
</div>
<?php endif; ?>
<?php 
$content = array(
'PendingProject' => '',
'FlaggedProjects' => '',
'SystemFlagged' => '',
'UserWithdrawRequests' => '',
'AffiliateWithdrawRequests' => '',
'LendLatePayment' => '',
);
$response = Cms::dispatchEvent('View.AdminDasboard.onActionToBeTaken', $this, array(
'content' => $content
));	
if(!empty($response->data['content']['PendingProject'])) {
?>
	<div class="h3"> 
		<h5 class="text-capitalize list-group-item-text">
			<strong><?php echo __l(Configure::read('project.alt_name_for_project_plural_caps'));?></strong>
		</h5>
		<ul class="list-unstyled navbar-btn list-group-item-heading">
			<?php echo $response->data['content']['PendingProject']; ?>
		</ul>
	</div>
	<div class="h3"> 
		<h5 class="text-capitalize list-group-item-text"><strong><?php echo __l('Pending Payments');?></strong></h5>
		<ul class="list-unstyled navbar-btn list-group-item-heading">
			<?php echo $response->data['content']['LendLatePayment']; ?>
		</ul>
	</div>
<?php
}
echo $response->data['content']['FlaggedProjects'];
?>
<?php
if(!empty($response->data['content']['SystemFlagged'])) {
?>
	<div class="h3"> 
		<h5 class="text-capitalize list-group-item-text">
			<strong><?php echo __l('System Flagged ');?></strong>
		</h5>
		<ul class="list-unstyled navbar-btn list-group-item-heading">
			<?php echo $response->data['content']['SystemFlagged']; ?>
		</ul>
	</div>
<?php } ?>
<?php 
echo $response->data['content']['UserWithdrawRequests'];
echo $response->data['content']['AffiliateWithdrawRequests'];
?>
