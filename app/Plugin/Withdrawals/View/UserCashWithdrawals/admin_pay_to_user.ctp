<?php /* SVN: $Id: admin_index.ctp 69757 2011-10-29 12:35:25Z josephine_065at09 $ */ ?>
<?php
  if(!empty($this->request->params['isAjax'])):
    echo $this->element('flash_message');
  endif;
?>
<div class="userCashWithdrawals index js-response admin-form">
  <?php echo $this->Form->create('UserCashWithdrawal' , array('action' => 'pay_to_user')); ?>
  <div class="table-responsive">
	  <table class="table table-striped table-bordered table-condensed table-hover">
		<tr>
		  <th><?php echo __l('User');?></th>
		  <th class="text-right"> <?php echo __l('Amount').' ('.Configure::read('site.currency').')';?></th>
		  <th class="text-left"><?php echo __l('Gateway');?></th>
		  <th class="text-left"><?php echo __l('Money Transfer Accounts');?></th>
		  <th class="text-right"><?php echo __l('Paid Amount').' ('.Configure::read('site.currency').')';?> </th>
		</tr>
		<?php
		  $i = 0;
		  if (!empty($userCashWithdrawals)):
			foreach ($userCashWithdrawals as $userCashWithdrawal):
			  $i++;
		?>
		<tr>
		  <td class="text-left">
			<div>
			  <?php
				foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
				  if(!empty($moneyTransferAccount['PaymentGateway'])):
			  ?>
				<span class="label label-project-status-2 paypal"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['display_name']);?></span>
			  <?php
				  endif;
				endforeach;
			  ?>
			  <?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.id', array('type' => 'hidden', 'value' => $userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => false)); ?>
			  <?php echo $this->Html->getUserLink($userCashWithdrawal['User']);?>
			</div>
		  </td>
		  <td class="text-right"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
		  <td class="text-left"><?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.gateways',array('type' => 'select', 'options' => $userCashWithdrawal['paymentways'], 'label' => false, 'class' => "js-payment-gateway_select {container:'js-info-".($i-1)."-container'}")); ?>
			<div class="<?php echo "js-info-".($i-1)."-container"; ?>">
			  <?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.info',array('type' => 'textarea', 'label' => false, 'info' => 'Info for Paid')); ?>
			</div>
		  </td>
		  <td>
		  <dl>
		  <?php $i=0;
		  foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):?>
		 <?php if(!empty($moneyTransferAccount['is_default'])):?>
		 <dt><?php echo __l('Primary Account:'); ?></dt>
		 <dd><?php echo nl2br($this->Html->cText($moneyTransferAccount['account'])); ?></dd>
		 <?php endif; endforeach; ?>
		<?php foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount): ?>
		<?php
			if (!empty($moneyTransferAccount['is_default'])):
				continue;
			endif;
		?>
		<?php if ($i == 0): ?>
		 <dt><?php echo __l('Other Accounts:'); ?></dt>
		 <?php endif; ?>
		 <dd><?php echo nl2br($this->Html->cText($moneyTransferAccount['account'])); ?></dd>
		  <?php
		  $i++;
		  endforeach; ?>
		  </dl>
		  </td>
		  <td class="text-right"><?php echo $this->Html->cCurrency($userCashWithdrawal['User']['total_amount_withdrawn']); ?></td>
		</tr>
		<?php
			endforeach;
		  else:
		?>
		<tr>
		  <td colspan="8"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?></td>
		</tr>
		<?php
		  endif;
		?>
	  </table>
 </div>
  <?php echo $this->Form->submit(__l('Proceed'),array('class'=>'btn btn-info')); ?>
  <?php echo $this->Form->end(); ?>
</div>