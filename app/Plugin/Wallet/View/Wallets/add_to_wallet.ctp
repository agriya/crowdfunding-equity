<?php /* SVN: $Id: $ */ ?>
<div class="container">
	<div class="add-amount-wallet  setting-drop-menu">
	  <?php echo $this->Form->create('Wallet', array('action' => 'add_to_wallet', 'id' => 'PaymentOrderForm', 'class' => 'form-horizontal js-submit-target')); ?>
		<div>
			<div class="clearfix user-heading">
				<h3 class="col-xs-8 col-sm-6 h2 text-uppercase navbar-btn"><?php echo sprintf(__l('Add %s'), __l('Amount to Wallet')); ?></h3>
				<div class="col-xs-4 col-sm-6 h2 navbar-btn">
					<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
				</div>
			</div>
			<?php
			  if (Configure::read('site.currency_symbol_place') == 'left'):
				$currecncy_place = 'between';
				$class ='input-group';
			  else:
				$currecncy_place = 'after';
				$class ='input-group';
			  endif;
			?>
			<div class="main-section new-admin-form admin-form gray-bg">
			  <?php
				if(isset($this->request->data['UserAddWalletAmount']['wallet']) && $this->request->data['UserAddWalletAmount']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
					echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
				} else {
			  ?>
			  <div class="alert alert-info">
				<span><?php echo __l('Your current available balance:').' '. $this->Html->siteCurrencyFormat($this->Html->cCurrency($user_info['User']['available_wallet_amount'],false));?></span>
			  </div>
			  <?php
				echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Auth->user('id')));
				if (!Configure::read('wallet.max_wallet_amount')):
				  $max_amount = 'No limit';
				else:
				  $max_amount = $this->Html->siteCurrencyFormat($this->Html->cCurrency(Configure::read('wallet.max_wallet_amount'),false));
				endif;
				$info = sprintf(__l('Minimum Amount: %s <br/> Maximum Amount: %s'), $this->Html->siteCurrencyFormat($this->Html->cCurrency(Configure::read('wallet.min_wallet_amount'),false)), $max_amount);
			  ?> 
				<?php echo $this->Form->input('UserAddWalletAmount.amount',array($currecncy_place => '<span class="currency input-group-addon">'.Configure::read('site.currency').'</span>','div'=>array('class'=> 'input text required '.$class), 'info' => $info, 'class' => 'form-control'));?>
			  <h3><?php echo __l('Payment Type'); ?></h3>
			  <?php echo $this->element('payment-get_gateways', array('model' => 'UserAddWalletAmount', 'type' => 'is_enable_for_add_to_wallet', 'is_enable_wallet' => 0, 'cache' => array('config' => 'sec'))); ?>
			</div>
		</div>
	  <?php echo $this->Form->end();?>
	  <?php } ?>
  </div>
</div>