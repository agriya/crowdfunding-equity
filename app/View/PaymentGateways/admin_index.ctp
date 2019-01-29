<?php /* SVN: $Id: admin_index.ctp 2741 2010-08-13 15:30:58Z boopathi_026ac09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="alert alert-info">
		<?php
		$pledgeContent ='.';
		if(isPluginEnabled('Pledge')){
		  $pledgeContent = sprintf(__l(" and PayPal suggests that we use Adaptive Payment API with primary receiver set to %s (not Site) for chargeback responsibility reasons. Violating these instructions may lead to account seizure from PayPal. So, we've used PayPal Adaptive preapproval and chained API. In this workflow, amount will be authorized (not captured) from %s once he %s. After the goal reached/tipping point, the %s amount will be charged/captured; site fee/commission will also be charged at this time from %s."), Configure::read('project.alt_name_for_pledge_project_owner_singular_caps'), Configure::read('project.alt_name_for_backer_singular_caps'), Configure::read('project.alt_name_for_pledge_plural_small'), Configure::read('project.alt_name_for_pledge_past_tense_small'), Configure::read('project.alt_name_for_pledge_project_owner_singular_caps'));
		}
		?>
		<p><?php echo sprintf(__l("As per the information we received from PayPal, websites should never aggregate money from users (i.e., have wallet option)%s"), $pledgeContent); ?></p>
		<?php  if(isPluginEnabled('Pledge')){ ?>
		<p><?php echo sprintf(__l("Caveat of this workflow: %s has an option in his PayPal account to cancel preapproval payments. If he does so, this software detects it through PayPal IPN and cancels the %s with 'Voided' status. But, this may give room for unstable %s. Also, if %s doesn't have enough balance in the final settlement (when site tries to charge on tipping point), it may fail."), Configure::read('project.alt_name_for_backer_singular_caps'), Configure::read('project.alt_name_for_pledge_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_backer_singular_caps')); ?></p>
        <?php } ?>
		<p><?php echo __l("<em>However</em>, we understand that some sites have Wallet option through special relationships with PayPal. But, we <em>seriously</em> warn you not to enable Wallet when using PayPal. In this software, Wallet option is provided as a provision to integrate other payment gateway solutions.");?></p>
		<div> <?php echo __l('--Agriya');?> </div>
    </div>
	<?php
		$wallet_enabled = '';
		foreach ($paymentGateways as $paymentGateway1):
		if ($paymentGateway1['PaymentGateway']['id'] == ConstPaymentGateways::Wallet):
		if ($paymentGateway1['PaymentGateway']['is_active'] == '1') {
		  $wallet_enabled = $paymentGateway1['PaymentGateway']['is_active'];
		}
		endif;
		endforeach;
	?>
	<div class="alert alert-info js-wallet hide">
		<?php echo __l('Site cannot work with "Wallet" option alone. This is added as a provision to integrate other payment gateway solutions.');?>
	</div>
    <div class="alert alert-info js-payment-all hide">
		<?php echo __l('Read the warning carefully and enable appropriate options for your website.');?>
    </div>
    <div class="clearfix">
		<div class="navbar-btn">
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead class="h5">
					<tr>    
						<th rowspan="3" class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th rowspan="3" class="text-center"><?php echo $this->Paginator->sort('display_name', __l('Display Name'));?></th>
						<th colspan="9" class="text-center"><?php echo __l('Settings');?></th>
					</tr>
					<tr>
					   <th rowspan="2" class="text-center"><?php echo __l('Active');?></th>
					   <th colspan="7" class="text-center"><?php echo __l('Where to use?');?></th>
					</tr>
					<tr>
					   <th class="text-center"><?php echo __l('Add to Wallet');?></th>
					   <th class="text-center"><?php echo Configure::read('project.alt_name_for_project_singular_caps');?></th>
					   <th class="text-center"><?php echo Configure::read('project.alt_name_for_pledge_singular_caps');?></th>
					   <th class="text-center"><?php echo Configure::read('project.alt_name_for_donate_singular_caps');?></th>
					   <th class="text-center"><?php echo Configure::read('project.alt_name_for_lend_singular_caps');?></th>
					   <th class="text-center"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></th>
					   <th class="text-center"><?php echo __l('Sign Up Fee');?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($paymentGateways)):
					foreach ($paymentGateways as $paymentGateway):
					$status_class = null;
					?>
					<tr>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu dl pull-left">
									<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action'=>'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'js-edit ','escape'=>false, 'title' => __l('Edit')));?></li>
									<?php echo $this->Layout->adminRowActions($paymentGateway['PaymentGateway']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($paymentGateway['PaymentGateway']['name']);?>
							<span class="info"><i class="fa fa-exclamation-circle fa-fw"></i>
							<?php echo $this->Html->cText($paymentGateway['PaymentGateway']['description']);?>
							</span>
						</td>
						<td class="text-center js-payment-status" id="payment-id<?php echo $this->Html->cInt($paymentGateway['PaymentGateway']['id'], false)?>" class="<?php echo ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 'js-active-gateways' : 'js-deactive-gateways'; ?>">
							<?php echo $this->Html->link(($paymentGateway['PaymentGateway']['is_active'] == 1) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Active, 'toggle' => ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
						</td>
						<?php
						unset($project_enabled);
						unset($pledge_enabled);
						unset($wallet_enabled);
						unset($donate_enabled);
						unset($signup_enabled);
						unset($lend_enabled);
						unset($equity_enabled);
						foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting):
						if ($paymentGatewaySetting['name'] == 'is_enable_for_project'):
						$project_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_pledge'):
						$pledge_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_donate'):
						$donate_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_lend'):
						$lend_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_equity'):
						$equity_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_add_to_wallet'):
						$wallet_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						if ($paymentGatewaySetting['name'] == 'is_enable_for_signup_fee'):
						$signup_enabled = $paymentGatewaySetting['test_mode_value'];
						endif;
						endforeach;
						?>
						<?php if (!isset($wallet_enabled)) { ?>
						<td class="text-center">-</td>
						<?php } else{ ?>
						<td class="text-center">
							<?php echo $this->Html->link(($wallet_enabled == 1) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Wallet, 'toggle' => ($wallet_enabled == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); ?>
						</td>
						<?php } ?>
						<td class="text-center">
							<?php echo $this->Html->link((!empty($project_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Project, 'toggle' => (!empty($project_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); ?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->link((!empty($pledge_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Pledge, 'toggle' => (!empty($pledge_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->link((!empty($donate_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Donate, 'toggle' => (!empty($donate_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>	
						</td>
						<td class="text-center">
							<?php if ($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
							-
							<?php else: ?>
							<?php echo $this->Html->link((!empty($lend_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Lend, 'toggle' => (!empty($lend_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<?php if ($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
							-
							<?php else: ?>
							<?php echo $this->Html->link((!empty($equity_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Equity, 'toggle' => (!empty($equity_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
						    <?php endif; ?>
						</td>
							<?php if($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
						<td class="text-center">
							<?php echo $this->Html->link((!empty($signup_enabled)) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstPaymentGateways::Signup, 'toggle' => (!empty($signup_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
						</td>
						<?php else: ?>
						<td class="text-center">
							<?php echo '-'; ?>
						</td>
						<?php endif; ?>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="9" class="text-center"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Payment Gateways'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="page-sec navbar-btn">
		<div class="col-xs-12 col-sm-6 pull-right">
			<?php if (!empty($paymentGateways)): ?>
			<?php echo $this->element('paging_links'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
