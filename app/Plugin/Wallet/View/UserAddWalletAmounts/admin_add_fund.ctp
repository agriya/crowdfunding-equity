<?php /* SVN: $Id: admin_add.ctp 6515 2010-06-02 10:45:44Z sreedevi_140ac10 $ */ ?>
<div class="userAddWalletAmounts admin-form">
	<?php echo $this->Form->create('UserAddWalletAmount', array('action' => 'add_fund', 'class' => 'form-horizontal'));?>
	<p class="alert alert-info"><?php echo sprintf(__l('Available wallet amount: %s'), $this->Html->siteCurrencyFormat($user['User']['available_wallet_amount'])); ?></p>
	<div class="gray-bg">
		<?php
			echo $this->Form->input('user_id', array('type' => 'hidden'));
			echo $this->Form->input('amount', array('label' => sprintf(__l('Amount (%s)'), Configure::read('site.currency'))));
			echo $this->Form->input('description', array('label' => __l('Description')));
		?>
		<div class="form-actions"><?php echo $this->Form->submit(__l('Add Fund'),array('class'=>'btn btn-info'));?> </div>
		<?php echo $this->Form->end();?>
	</div>
</div>