<div class="payment-gateways payment-type">
	<?php 
		$templates = array();
		$gateway_groups = array();
		$payment_gateways = array();
		$i = 1;
		foreach($gateway_types As $key => $gateway_type) {
			$gateway_groups[$key]['id'] = $key;
			$gateway_groups[$key]['name'] = $gateway_type;
			$gateway_groups[$key]['display_name'] = $gateway_type;
			if($key == ConstPaymentGateways::Wallet) {
				$gateway_groups[$key]['thumb_url'] = Router::url('/img/wallet-icon.png', true);
			}
			$payment_gateways[$key] = $gateway_groups[$key];
			$payment_gateways[$key]['group_id'] = $key;
			$payment_gateways[$key]['payment_id'] = $key;
			$i++;
		}
		if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])):
			if(!empty($connected_gateways ) ){
			$gateways_response = Cms::dispatchEvent('View.Payment.GetGatewayList', $this, array(
					'foreign_id' => $foreign_id,
					'payment_type_id' => $transaction_type,
					'connected_gateways' => $connected_gateways,
			));
		}else{
			$gateways_response = Cms::dispatchEvent('View.Payment.GetGatewayList', $this, array(
				'foreign_id' => $foreign_id,
				'payment_type_id' => $transaction_type
			));
		}
			$gatewayGroups = array();
			$groups = !empty($gateways_response->gatewayGroups) ? $gateways_response->gatewayGroups : '';	
			$gateways = !empty($gateways_response->gateways) ? $gateways_response->gateways : '';
			$gateways_count = count($gateway_ids);
			$increment_count = 0;
			if(!empty($gateways) && !empty($project_type)){
				$tmp_gateways = $gateways;
				foreach($gateways as $key => $gateway){
					if( (in_array("Marketplace-Auth",$gateway['supported_features'][0]['actions']) && (!in_array($gateway['id'], $gateway_ids))) || (!in_array("Marketplace-Auth",$gateway['supported_features'][0]['actions'])) ){
						unset($tmp_gateways[$key]);
					} 
				}
				$gateways = $tmp_gateways;
				if(!empty($gateways)) {
					foreach($groups as $key => $group) {
						$flag = false;
						foreach($gateways as $gateway) {
							if($gateway['group_id'] == $group['id']) {
								$flag = true;
							}
						}
						if(!$flag) {
							unset($groups[$key]);
						}
					}
				} else {
					foreach($groups as $key => $group) {
						unset($groups[$key]);
					}
				}
			}
			if ($response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
				unset($gateway_groups[ConstPaymentGateways::SudoPay]);
				if(!empty($groups)) {
					if(!empty($gatewaygroup_ids[0]) && !isPluginEnabled('Wallet')){
						foreach($groups As $group) {
						  	if(in_array($group['id'], $gatewaygroup_ids)){
						  		$gatewayGroups[$group['id']] = $group;
						  	}
						}
						$gateway_groups = $gatewayGroups + $gateway_groups;
					}else{
						foreach($groups As $group) {
							$gatewayGroups[$group['id']] = $group;
						}
						$gateway_groups = $gatewayGroups + $gateway_groups;
					}
					
				}
				$gateway_array = array();
				$payment_gateway_arrays = array();
				unset($payment_gateways[ConstPaymentGateways::SudoPay]);
				unset($gateway_types[ConstPaymentGateways::SudoPay]);
				if(!empty($gateways)) {
					foreach($gateways as $gateway) {						
						if(!empty($gateway_ids) && !isPluginEnabled('Wallet') && !empty($project_type)){
							if(in_array($gateway['id'], $gateway_ids)){
								$payment_gateway_arrays[$i]['id'] = $gateway['id'];
								$payment_gateway_arrays[$i]['payment_id'] = 'sp_' . $gateway['id'];
								$payment_gateway_arrays[$i]['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
								$payment_gateway_arrays[$i]['display_name'] = $gateway['display_name'];
								$payment_gateway_arrays[$i]['thumb_url'] = $gateway['thumb_url'];
								$payment_gateway_arrays[$i]['group_id'] = $gateway['group_id'];
								$templates['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
								$gateway_array['sp_' . $gateway['id']] = '<div class="pull-left"><img src="'. $gateway['thumb_url'] .'" alt="'.$gateway['display_name'].'"/><span class="show">'.$gateway['display_name'].'</span></div>'; //for image
								$gateway_instructions['sp_' . $gateway['id']] = (!empty($gateway['instruction_for_manual'])) ? urldecode($gateway['instruction_for_manual']): '';
								$gateway_form['sp_' . $gateway['id']] = (!empty($gateway['_form_fields']['_fields'])) ? array_keys((array)$gateway['_form_fields']['_fields']): '';
								$i++;
							}
						}
						else{
							if(in_array("Marketplace-Auth",$gateway['supported_features'][0]['actions']) && !empty($project_type)){
								if(in_array($gateway['id'], $gateway_ids)){
									$payment_gateway_arrays[$i]['id'] = $gateway['id'];
									$payment_gateway_arrays[$i]['payment_id'] = 'sp_' . $gateway['id'];
									$payment_gateway_arrays[$i]['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
									$payment_gateway_arrays[$i]['display_name'] = $gateway['display_name'];
									$payment_gateway_arrays[$i]['thumb_url'] = $gateway['thumb_url'];
									$payment_gateway_arrays[$i]['group_id'] = $gateway['group_id'];
									$templates['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
									$gateway_array['sp_' . $gateway['id']] = '<div class="pull-left"><img src="'. $gateway['thumb_url'] .'" alt="'.$gateway['display_name'].'"/><span class="show">'.$gateway['display_name'].'</span></div>'; //for image
									$gateway_instructions['sp_' . $gateway['id']] = (!empty($gateway['instruction_for_manual'])) ? urldecode($gateway['instruction_for_manual']): '';
									$gateway_form['sp_' . $gateway['id']] = (!empty($gateway['_form_fields']['_fields'])) ? array_keys((array)$gateway['_form_fields']['_fields']): '';
									$i++;
								}
							}
							else{
								$payment_gateway_arrays[$i]['id'] = $gateway['id'];
								$payment_gateway_arrays[$i]['payment_id'] = 'sp_' . $gateway['id'];
								$payment_gateway_arrays[$i]['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
								$payment_gateway_arrays[$i]['display_name'] = $gateway['display_name'];
								$payment_gateway_arrays[$i]['thumb_url'] = $gateway['thumb_url'];
								$payment_gateway_arrays[$i]['group_id'] = $gateway['group_id'];
								$templates['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
								$gateway_array['sp_' . $gateway['id']] = '<div class="pull-left"><img src="'. $gateway['thumb_url'] .'" alt="'.$gateway['display_name'].'"/><span class="show">'.$gateway['display_name'].'</span></div>'; //for image
								$gateway_instructions['sp_' . $gateway['id']] = (!empty($gateway['instruction_for_manual'])) ? urldecode($gateway['instruction_for_manual']): '';
								$gateway_form['sp_' . $gateway['id']] = (!empty($gateway['_form_fields']['_fields'])) ? array_keys((array)$gateway['_form_fields']['_fields']): '';
								$i++;
							}
						}
						
						
					}
					$gateway_types = $gateway_array + $gateway_types;
					$payment_gateways =  $payment_gateway_arrays + $payment_gateways;
				}
			}
		endif;
	?>
	<?php if(!empty($gateway_groups)) { 
		$default_gateway_id = '';
		foreach($payment_gateways As $key => $value) {
			$default_gateway_id = $value['payment_id'];
			break;
		}
		$selected_payment_gateway_id = (!empty($this->request->params['named']['return_data'][$model]['sudopay_gateway_id']) ? 'sp_' . $this->request->params['named']['return_data'][$model]['sudopay_gateway_id'] : $default_gateway_id);
	?>
	<div id="paymentgateways-tab-container">
		<ul class="nav nav-tabs ver-space">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<li><a href="#paymentGateway-<?php echo $this->Html->cInt($gateway_group['id'], false); ?>" class="js-no-pjax" data-toggle="tab"><div>
			<?php if(!empty($gateway_group['thumb_url'])){ ?>
			<img src="<?php echo $this->Html->cText($gateway_group['thumb_url'], false); ?>" alt="<?php echo $gateway_group['display_name']; ?>" />
			<?php } ?>
			<span class="show top-mspace text-center"><?php echo $this->Html->cText($gateway_group['display_name'], false); ?></span></div></a></li>
			<?php } ?>
		</ul>
		<div class="sep-left tab-round tab-content navbar-btn" id="myTabContent2">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<div class="tab-pane clearfix" id="paymentGateway-<?php echo $this->Html->cInt($gateway_group['id'], false); ?>">
				<?php 
				foreach($payment_gateways AS $payment_gateway) {
					$checked = '';
					if ($payment_gateway['payment_id'] == $selected_payment_gateway_id) {
						$checked = 'checked';
					}
					if($payment_gateway['group_id'] == $gateway_group['id']) {
						if ($payment_gateway['payment_id'] == ConstPaymentGateways::Wallet) {
							$option_value = '<div class="pull-left text-center">' . $this->Html->image('wallet-icon.png', array( 'alt' => __l('Wallet'))) . '<span class="show top-space">' . $payment_gateway['display_name'] . '</span></div>';							
						} else {
							if ($payment_gateway['group_id'] == 4922):
								$option_value = '<div class="pull-left"><span class="show">' . __l('Credit & Debit Cards') . '</span></div>';
							else:
								$option_value = '<div class="pull-left text-center">';
								$class='';
								if(!empty($gateway_group['thumb_url'])){
									$option_value .= '<img src="'. $payment_gateway['thumb_url'] .'" alt="'.$payment_gateway['display_name'].'"/>';
									$class = '';
								}
								$option_value .= '<span class="show top-space'.$class.'">'.$payment_gateway['display_name'].'</span></div>';
							endif;
						}
						$template = !empty($templates['sp_' . $payment_gateway['id']])?$templates['sp_' . $payment_gateway['id']]:'';
						$options = array($payment_gateway['payment_id'] => $option_value);
						if ($payment_gateway['group_id'] == 4922):
							echo '<div class="hide">';
								echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => false, 'options' => $options, 'data-sudopay_form_fields_tpl' => $template, 'class' => 'js-payment-type js-no-pjax pull-left', 'checked' => $checked));
							echo '</div>';
							echo '<div class="alert alert-info">' . __l(' Please enter your credit card details below.') . '</div>';
						else:
							echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => 'col-md-3 radio', 'options' => $options, 'data-sudopay_form_fields_tpl' => $template, 'class' => 'js-payment-type js-no-pjax pull-left', 'checked' => $checked));
						endif;
					}
				}
				?>	
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php
	if (!empty($gateway_instructions) && $response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
		foreach($gateway_instructions as $key => $instructions) {
			if(!empty($gateway_instructions[$key])) {
?>
<div class="js-instruction js-instruction_<?php echo $this->Html->cText($key, false); ?> alert alert-info hide">
	<?php echo nl2br($this->Html->cText($gateway_instructions[$key])); ?>
</div>
<?php
			}
		}
	}
?>
<?php if (!empty($gateways_response->form_fields_tpls)) { ?>
	<div class="js-form">
		<?php foreach($gateways_response->form_fields_tpls as $key => $value) { ?>
			<div class="js-gatway_form_tpl hide" id="form_tpl_<?php echo $this->Html->cText($key, false); ?>">
				<?php if($key == 'buyer'){ ?>
					<h3 class="well"><strong><?php echo __l('Payer Details'); ?></strong></h3>
				<?php } ?>
				<?php if($key == 'credit_card'){ ?>
					<h3 class="well"><strong><?php echo __l('Credit Card Details'); ?></strong><span>
					<?php echo $this->Html->link($this->Html->image('credit-detail.png', array('alt'=>'[Image: Credit Cards]')), '/',array('escape'=>false));?>
					</span></h3>
				<?php } ?>
				<div class="row clearfix">
				<?php
					foreach($value['_fields'] as $field_name => $required) {
						$return_data = !empty($this->request->params['named']['return_data']['Sudopay'][$field_name]) ? $this->request->params['named']['return_data']['Sudopay'][$field_name] : '';
						$field_options = array();
						$field_name = trim($field_name);
						$type = 'text';
						$options = array();
						$value = $return_data;
						$class="";
						$input_class= " input text";
						if ($field_name == 'buyer_country') {
							$type = 'select';
							$options = $countries;
							$value = (!empty($user_profile['Country']['iso_alpha2'])) ? $user_profile['Country']['iso_alpha2'] : $return_data;
							$class = " col-sm-4 col-xs-12";
						}
						if ($field_name == 'buyer_email') {
							$value = (!empty($user_profile['User']['email'])) ? $user_profile['User']['email'] : $return_data;
							$class = " col-sm-4 col-xs-12";
							$placeholder = __l("Enter Email");
						}
						if ($field_name == 'buyer_address') {
							$value = (!empty($user_profile['UserProfile']['address'])) ? $user_profile['UserProfile']['address'] : $return_data;
							$class = " col-sm-4 col-xs-12";
							$placeholder = __l("Enter Address");
						}
						if ($field_name == 'buyer_city') {
							$value = (!empty($user_profile['City']['name'])) ? $user_profile['City']['name'] : $return_data;
							$class = " col-sm-4 col-xs-12";
							$placeholder = __l("Enter City");
						}
						if ($field_name == 'buyer_state') {
							$value = (!empty($user_profile['State']['name'])) ? $user_profile['State']['name'] : $return_data;
							$class = " col-sm-4 col-xs-12";
							$placeholder = __l("Enter State");
						}
						if ($field_name == 'buyer_phone') {
							$class = " col-sm-4 col-xs-12";
							$placeholder = __l("Enter Phone Number");
						}
						if ($field_name == 'credit_card_number') {
							$class = " col-sm-3 col-xs-12";
						}
						if ($field_name == 'credit_card_name_on_card') {
							$class = " col-sm-3 col-xs-12";
							if($this->request->params['named']['type'] == 'is_enable_for_project'){
								$class = " col-sm-3 col-xs-12 ";
							}
						}
						if ($field_name == 'buyer_zip_code') {
							$value = (!empty($user_profile['UserProfile']['zip_code'])) ? $user_profile['UserProfile']['zip_code'] : $return_data;
							$placeholder = __l("Enter Zipcode");
						}
						if ($field_name == 'buyer_zip_code') {
							$class = " col-sm-4 col-xs-12";
						}
						if ($field_name == 'credit_card_code' || $field_name == 'credit_card_expire') {
							$class = " col-sm-3 col-xs-12";
						}
						if ($field_name == 'payment_note') { ?>
						<h3 class="well"><strong><?php echo __l('Payment Details'); ?></strong></h3>
							<?php $type = 'textarea';
							$placeholder = __l("Enter Note");
						}
						//$field_name = str_replace('buyer_','',$field_name);
						
						if ($field_name == 'payment_note') {
							$class = " col-md-4 col-xs-12 col-sm-6";
							$type = 'textarea';
						}
						// For label
						$search = array('buyer_','credit_card_');
						if($field_name == 'credit_card_number' || $field_name == 'credit_card_code'){
							$replace = array('','card_'); 
						}else{
							$replace = array('',''); 
						}
						$label = str_replace($search,$replace,$field_name);
						$before = $after = '';
						if (!empty($required)) {
							$cc_section = '';
							if ($field_name == 'credit_card_number') {
								$after .= '<div class="cc-type"></div><div class="cc-default"></div>';
								$cc_section = ' cc-section';
							}
							$before .= '<div class="required js-remove-error'. $cc_section . '">';
							$after .= '</div>';
						}
						$field_options = array(
							'id' => 'Sudopay' . Inflector::camelize($field_name),
							'legend' => false,
							'type' => $type,
							'class' => $class,
							'options' => $options,
							'value' => $value,
							'div' => $input_class.$class,
							'before' => $before,
							'after' => $after,
							'label' => __l(Inflector::humanize($label)),
							'placeholder' => $placeholder
						);
						if ($field_name == 'credit_card_number') {
							$field_options['autocomplete'] = 'off'; 
							$field_options['placeholder'] = '&#8226&#8226&#8226&#8226 &#8226&#8226&#8226&#8226 &#8226&#8226&#8226&#8226 &#8226&#8226&#8226&#8226';
							$field_options['escape'] = false;
						}
						if ($field_name == 'credit_card_code') {
							$field_options['autocomplete'] = 'off'; 
							$field_options['placeholder'] = 'CVC';
						}
						if ($field_name == 'credit_card_expire') {
							$field_options['placeholder'] = 'MM/YYYY';
						}
						if ($field_name == 'credit_card_name_on_card') {
							$field_options['placeholder'] = __l('Enter Name');
						}
						if ($field_name == 'buyer_country') {
							$field_options['empty'] = __l('Please Select');
							$field_options['div'] = "input select ".$class;
						}
						echo $this->Form->input('Sudopay.' . $field_name , $field_options);
					}
				?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<div class="submit-block form-payment-panel clearfix">
	<div class="submit">
		<div class= "js-wallet-connection hide">
			<p class="bot-sp sfont available-balance js-user-available-balance {'balance':'<?php echo $this->Html->cCurrency($logged_in_user['User']['available_wallet_amount'], false); ?>'}"><strong><?php echo __l('Your available balance:').' '. $this->Html->siteCurrencyFormat($this->Html->cCurrency($logged_in_user['User']['available_wallet_amount'], false));?></strong></p>
			<?php
				$disable_class = '';
				if(!empty($project_type) && $project_type == 'Lend'){
					$disable_class = "js-disable disabled";
				}
				echo $this->Form->submit(__l('Pay with Wallet'), array('name' => 'data['.$model.'][wallet]', 'class' => '{"balance":"' . $logged_in_user['User']['available_wallet_amount'] . '"}  btn-primary wallet-button ' . ' js-update-order-field js-no-pjax '.$disable_class.'', 'div' => false));
			?>
		</div>
		<div class= "js-normal-sudopay hide">
			<?php
				echo $this->Form->submit(__l('Pay Now'), array('name' => 'data['.$model.'][wallet]', 'div' => false, 'id' => 'sudopay_button'));
			?>
		</div>
	</div>   
</div>
</div>