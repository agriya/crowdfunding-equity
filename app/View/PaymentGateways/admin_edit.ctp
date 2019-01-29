<?php /* SVN: $Id: admin_edit.ctp 2895 2010-09-02 10:58:05Z sakthivel_135at10 $ */ ?>
<div class="paymentGateways admin-form">
	<?php echo $this->Form->create('PaymentGateway',array('class' => 'form-horizontal payment-form marg-btom-30'));?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('Payment Gateways'), array('action' => 'index'), array('title' => __l('Payment Gateways')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Edit %s'), __l('Payment Gateway'));?></li>  
	</ul>
	<ul class="nav nav-tabs">
		<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
		</li>
		<li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit');?></a></li>
	</ul>
	<div>
		<?php
			if(!empty($SudoPayGatewaySettings['sudopay_merchant_id']) && $id == ConstPaymentGateways::SudoPay) {
				echo $this->element('sudopay-info', array('cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
			}		
		?>
	</div>
	<fieldset class="col-sm-offset-1 admin-checkbox">
		<?php
			echo $this->Form->input('id');
			if ($this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet && $this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay):
			  echo $this->Form->input('is_test_mode', array('label' => __l('Test Mode?'), 'help' => __l('On disabling this, live account will used instead of sandbox payment details. (Disable this, When site is in production stage)')));
			endif;
			foreach($paymentGatewaySettings as $paymentGatewaySetting) {
			  $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
			  if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_project'):
			  $options['label'] = sprintf(__l('Enable for %s listing'), Configure::read('project.alt_name_for_project_singular_small'));
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_pledge'):
			  $options['label'] = sprintf(__l('Enable for %s'),Configure::read('project.alt_name_for_pledge_singular_small'));
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_donate'):
			  $options['label'] = sprintf(__l('Enable for %s'),Configure::read('project.alt_name_for_donate_singular_small'));
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_lend'):
			  $options['label'] = sprintf(__l('Enable for %s'),Configure::read('project.alt_name_for_lend_singular_small'));
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_equity'):
			  $options['label'] = sprintf(__l('Enable for %s'),Configure::read('project.alt_name_for_equity_singular_small'));
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
			  $options['label'] = __l('Enable for add to wallet');
			  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee'):
			  $options['label'] = __l('Enable for sign up fee');
			  endif;
			  $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
			  $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
			  if($options['type'] == 'checkbox' && !empty($options['value'])):
			  $options['checked'] = 'checked';
			  else:
			  $options['checked'] = '';
			  endif;
			  if($options['type'] == 'select'):
			  $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
			  $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
			  if(!empty($selectOptions)):
				foreach($selectOptions as $key => $value):
				if(!empty($value)):
				  $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
				endif;
				endforeach;
			  endif;
			  $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
			  endif;
			  if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
			  $options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
			  else:
			  $options['help'] = '';
			  endif;
			  if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_test_mode' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_project' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_pledge'|| $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_donate' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_lend' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_equity'):
			  echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
			  endif;
			}
			if ($paymentGatewaySettings && $this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) {
		?>
		<?php
			$j = $i = $z = $n = $x= 0;
			foreach($paymentGatewaySettings as $paymentGatewaySetting) {
			  $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
			  $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
			  $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
			  if($options['type'] == 'checkbox' && $options['value']):
			  $options['checked'] = 'checked';
			  endif;
			  if($options['type'] == 'select'):
					$selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
					$paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
					if(!empty($selectOptions)):
					  foreach($selectOptions as $key => $value):
						if(!empty($value)):
						  $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
						endif;
					  endforeach;
					endif;
					$options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
				  endif;
			  $options['label'] = false;
			  if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
			  $options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
			  else:
			  $options['help'] = '';
			  endif;
		?>
		</fieldset>
		<?php if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key'): ?>
		<?php if($x == 0):?>
        <fieldset>
			<h3 class="text-b"><?php echo __l('ZazPay API Details'); ?></h3>
			<div class="clearfix">
			<label class="col-sm-2"></label>
			<h5  class="col-sm-4"><?php echo __l('Live Mode Credential'); ?></h5>
			<h5  class="col-sm-4"><?php echo __l('Test Mode Credential'); ?></h5>
			</div>
        </fieldset>		
		<?php endif;?>		
		<div class="clearfix">
          <label class="col-sm-2">
			<?php
				if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id') {
					echo __l('Merchant ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id') {
					echo __l('Website ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string') {
					echo __l('Secret Key in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key') {
					echo __l('API Key in ZazPay');
				}
			?>
		  </label>
          <div class="col-sm-4 mob-no-pad">
          
          <?php
            $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
            echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
          ?>
          </div>
          <div class="col-sm-4 mob-no-pad">
          
	         <?php
            	$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
            	echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
         	 ?>
          </div>
        </div>		
	  <?php if($x == 2):?>       
      <?php endif;?>
      <?php $x++;?>
	  <?php endif; ?>
  <?php
      }
  }
  ?>
  <div class="ver-space clearfix">
  <?php echo $this->Form->end(array('class' => 'btn btn-info ver-mspace',__l('Update')));?>
  </div> 
</div>