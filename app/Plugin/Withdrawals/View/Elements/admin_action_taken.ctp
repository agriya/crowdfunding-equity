<?php if (isPluginEnabled('Wallet')) { ?>
<div class="h3">
	<h5 class="text-capitalize list-group-item-text">
		<strong><?php echo __l('User Withdraw Requests');?></strong>
	</h5>
	<ul class="list-unstyled navbar-btn list-group-item-heading">
		<li>
			<span class="text-muted">
				<i class="fa-fw fa fa-chevron-right small"></i>
			</span>
			<?php echo $this->Html->link(__l('Pending') . ' (' . $pending_withdraw_count. ')', array('controller'=> 'user_cash_withdrawals', 'action' => 'index', 'filter_id' =>ConstWithdrawalStatus::Pending), array('class' => 'h5 rgt-move'));?>
		</li>
	</ul>
</div>
<?php } ?>