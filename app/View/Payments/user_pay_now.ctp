<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div><h2><?php echo $this->pageTitle;?></h2></div>
<div class="thumbnail">
  <?php
	if(isset($this->request->data['User']['wallet']) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
		echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
	} else {
  ?>
  <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'user_pay_now', $this->request->params['pass'][0],$this->request->params['pass'][1]), 'id' => 'PaymentProcessOrderFormNormal', 'class' => 'form-horizontal clearfix')); ?>
  <?php echo $this->Form->input('User.id'); ?>
  <div>
  <div class="alert alert-info">
    <span><?php echo __l('Sign Up Fee').' '. $this->Html->siteCurrencyFormat($this->Html->cCurrency($total_amount,false));?></span>
  </div>
  <legend><h3><?php echo __l('Payment Type'); ?></h3></legend>
  <?php  echo $this->element('payment-get_gateways', array('model' => 'User', 'type' => 'is_enable_for_signup_fee', 'foreign_id' => $this->request->data['User']['id'], 'transaction_type' => ConstPaymentType::Signup, 'is_enable_wallet' => 0, 'cache' => array('config' => 'sec')));?>
  </div>
  <?php echo $this->Form->end();?>
  <?php } ?>
</div>