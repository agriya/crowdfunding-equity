<div class="h3">
	<h5 class="text-capitalize list-group-item-text">
		<strong><?php echo __l('Affiliate Requests');?></strong>
	</h5>
	<ul class="list-unstyled navbar-btn list-group-item-heading">
		<li>
			<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
			<?php echo $this->Html->link(__l('Pending') . ' (' . $waiting_for_approval. ')', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('class' => 'h5 rgt-move'));?>
		</li>
	</ul>
</div>
<div class="h3">
	<h5 class="text-capitalize list-group-item-text">
		<strong><?php echo __l('Affiliate Withdraw Requests');?></strong>
	</h5>
	<ul class="list-unstyled navbar-btn list-group-item-heading">
		<li>
			<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span><?php echo $this->Html->link(__l('Pending') . ' (' . $cash_withdrawal_waiting_for_approval. ')', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('class' => 'h5 rgt-move'));?>
		</li>
	</ul>
</div>