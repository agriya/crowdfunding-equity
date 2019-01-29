<?php /* SVN: $Id: index.ctp 69483 2011-10-22 12:41:35Z sakthivel_135at10 $ */ ?>
<div class="clearfix container">
	<div class="setting-drop-menu">
	  <div class="clearfix user-heading">
			<h3 class="col-xs-8 col-sm-6 h2 text-uppercase navbar-btn"><?php echo __l('Withdraw Fund Request'); ?></h3>
			<div class="col-xs-4 col-sm-6 h2 navbar-btn">
				<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
			</div>
	  </div>
	  <div class="main-section marg-top-20">
		<div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
		  <?php if(!empty($moneyTransferAccounts)) : ?>
			<div class="clearfix">
			  <span class="pull-right">
				<?php
				  echo $this->Html->link('<i class="fa fa-briefcase"></i>' . __l(' Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('class' => 'pay', 'escape'=>false, 'title' => __l('Money Transfer Accounts')));
				?>
			  </span>
			</div>
			<?php echo $this->element('withdrawals-add'); ?>
		  <?php else: ?>
			<div class="alert alert-info">
				<span><?php echo __l('Your money transfer account is empty, so'); ?> </span>
				<?php echo $this->Html->link(__l('click here'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('class'=>'text-danger','title' => __l('Money Transfer Accounts'))); ?>
				<span><?php echo __l('to update money transfer account.'); ?></span>
			</div>
		  <?php endif;?>
		  <section class="clearfix">
			<div class="pull-left">
			  <?php echo $this->element('paging_counter');?>
			</div>
		  </section>
		  <section>
			<table class="table table-striped table-bordered table-condensed table-hover">
			  <tr>
				<th class="text-center"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('UserCashWithdrawal.created', __l('Requested On'));?></div></th>
				<th class="text-right"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount').' ('.Configure::read('site.currency').')');?></div></th>
				<th class="text-left"><div class="js-filter js-no-pjax"><?php echo $this->Paginator->sort('WithdrawalStatus.name', __l('Status'));?></div></th>
			  </tr>
			  <?php
				if (!empty($userCashWithdrawals)):
				  $i = 0;
				  foreach ($userCashWithdrawals as $userCashWithdrawal):
					$class = null;
					if ($i++ % 2 == 0) {
					  $class = ' class="altrow"';
					}
			  ?>
			  <tr<?php echo $class;?>>
				<td class="text-center"><?php echo $this->Html->cDateTime($userCashWithdrawal['UserCashWithdrawal']['created']);?></td>
				<td class="text-right"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
				<td class="text-left"><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
			  </tr>
			  <?php
				  endforeach;
				else:
			  ?>
			  <tr>
				<td colspan="3">
				 <div class="text-center">
				  <p>
				   <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?>
				 </p>
				</div>
				</td>
			  </tr>
			  <?php
				endif;
			  ?>
			</table>
		  </section>
		  <section class="clearfix">
			<?php if (!empty($userCashWithdrawals)):?>
			  <div class="pull-right js-pagination js-no-pjax">
				<?php echo $this->element('paging_links'); ?>
			  </div>
			<?php endif;?>
		  </section>
		</div>
	  </div>
  </div>
</div>