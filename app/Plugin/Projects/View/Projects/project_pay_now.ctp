<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="navbar-btn">
	<?php
	if(isset($this->request->data['Project']['wallet']) && $this->request->data['Project']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
		echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
	} else {
	?>
  <?php echo $this->Form->create('Project', array('action' =>'project_pay_now', 'class' => 'js-submit-target clearfix form-horizontal')); ?>
  <?php echo $this->Form->input('Project.id'); ?>
  <?php echo $this->Form->input('Project.step_id', array('type' => 'hidden')); ?>
  <?php echo $this->Form->input('Project.page', array('type' => 'hidden')); ?> 
    <div class="alert alert-info">
      <span><?php echo __l('Listing Fee') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($total_amount,false));?></span>
    </div>
    <legend><h3><?php echo __l('Payment Type'); ?></h3></legend>
    <?php echo $this->element('payment-get_gateways', array('model' => 'Project', 'type' => 'is_enable_for_project', 'foreign_id' => $this->request->data['Project']['id'], 'transaction_type' => ConstPaymentType::ProjectListing, 'is_enable_wallet' => 1, 'project_type'=>'','cache' => array('config' => 'sec')));?> 
  <?php echo $this->Form->end();?>
  <?php } ?>
</div>