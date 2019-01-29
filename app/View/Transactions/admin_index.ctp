<?php /* SVN: $Id: admin_index.ctp 2754 2010-08-16 06:18:32Z boopathi_026ac09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="transactions index js-response js-responses">
		<div class="bg-primary row">
			<ul class="list-inline sec-1 navbar-btn">
				<li>					
					<?php echo $this->Html->link('<span class="label label-warning space-xs">' .__l('Admin'). '</span>', array('controller' => 'transactions', 'action'=>'index'), array('class' => 'pull-left', 'escape' => false));?>				
				</li>
				<li>					
					<?php echo $this->Html->link('<span class="label label-danger space-xs">' .__l('All'). '</span>', array('controller' => 'transactions', 'action' => 'index', 'filter' => 'all'), array('class' => 'pull-left', 'escape' => false));?>					
				</li>
				<li class="col-xs-12 marg-top-20 no-pad"> 
					<?php echo $this->Form->create('Transaction' , array('class' => 'form-search clearfix transaction-form-width center-block', 'action' => 'admin_index')); ?>
					<div class="pull-left ver-space navbar-btn col-md-3 col-sm-6 col-xs-12 m-top">
						<?php
						$username = '';
						$user_placeholder = __l('User');
						if (!empty($this->request->named['username'])) {
						$username = $this->request->named['username'];
						$user_placeholder = $this->request->named['username'];
						}
						?>
						<div class="mapblock-info">
							<?php echo $this->Form->autocomplete('Transaction.username', array('label' => false, 'placeholder' => $user_placeholder, 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'search-query mob-clr col-md-12 form-control')); ?>
							<div class="autocompleteblock"></div>
						</div>
					</div>
					<div class="pull-left ver-space navbar-btn col-md-3 col-sm-6 col-xs-12 start-date-width m-top">
						<?php
						$project_id = '';
						if (!empty($this->request->named['project_id'])) {
						$project_id = $this->request->named['project_id'];
						}
						$project_placeholder = __l(Configure::read('project.alt_name_for_project_singular_caps'));
						if (!empty($this->request->named['name'])) {
						$project_placeholder = $this->request->named['name'];
						}
						?>
						<div class="mapblock-info">
							<?php echo $this->Form->autocomplete('Project.name', array('label' => false, 'placeholder' => $project_placeholder, 'acFieldKey' => 'Transaction.project_id', 'acFields' => array('Project.name'), 'acSearchFieldNames' => array('Project.name'), 'maxlength' => '255', 'class' =>'search-query col-md-12 form-control')); ?>
							<div class="autocompleteblock"></div>
						</div>
					</div>
					<div class="pull-left ver-space navbar-btn col-md-3 col-sm-6 col-xs-12 start-date-width">
						<div class="input date-time clearfix pull-left">
							<div class="js-datetime">
								<div class="js-cake-date">
									<?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
								</div>
							</div>
						</div>
					</div>					
					<div class="pull-left ver-space navbar-btn col-md-3 col-sm-6 col-xs-12 start-date-width">
						<div class="input date-time pull-left clearfix">
							<div class="js-datetime">
								<div class="js-cake-date">
									<?php echo $this->Form->input('to_date', array('label' => __l('To'),  'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="pull-left ver-space navbar-btn col-md-1 col-sm-4 col-xs-12 m-top">
						<?php echo $this->Form->submit(__l('Filter'), array('class' =>'navbar-btn btn btn-info text-center fltr form-control btn-efcts
					'));?>
					</div>
					<?php echo $this->Form->end(); ?>
				</li>
			</ul>
		</div>
		<div class="clearfix">
			<div class="navbar-btn">
				<h3>
					<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>
				</h3>
				<ul class="list-unstyled clearfix">
					<li class="pull-left"> 
						<p><?php echo $this->element('paging_counter');?></p>
					</li>					
				</ul>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="h5">
						<tr>
							<th class="text-center js-filter js-no-pjax"><div><?php echo $this->Paginator->sort('created', __l('Created'));?></div> </th>
							<th class="text-left js-filter js-no-pjax"><div><?php echo $this->Paginator->sort('user_id', __l('User'));?></div></th>
							<th class="text-center"><div><?php echo __l('Message'); ?></div></th>
							<th class="text-center js-filter js-no-pjax"><div class="credit round-3"><?php echo $this->Paginator->sort('amount', __l('Credit')).' ('.Configure::read('site.currency').')';?></div></th>
							<th class="text-center js-filter js-no-pjax"><div class="debit round-3"><?php echo $this->Paginator->sort('amount', __l('Debit')).' ('.Configure::read('site.currency').')';?></div></th>
						</tr>
					</thead>
					<tbody class="h5">
						<?php
						if (!empty($transactions)):
						foreach ($transactions as $transaction):
						?>
						<tr>
						<td class="text-center"><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']); ?></td>
						<td>
							<div class="media">
								<div class="pull-left">
									<?php echo $this->Html->getUserAvatar($transaction['User'], 'micro_thumb',true, '', 'admin');?>
								</div>
								<div class="media-body">
									<p><?php echo $this->Html->getUserLink($transaction['User']); ?></p>
								</div>
							</div>
						</td>
						<td class="text-center">
						<?php
						if (in_array($transaction['Transaction']['transaction_type_id'], array(ConstTransactionTypes::AdminAddFundToWallet, ConstTransactionTypes::AdminDeductFundFromWallet))):
						echo $this->Html->cText($transaction['Transaction']['remarks']);
						else:
						echo $this->Html->transactionDescription($transaction);
						endif;
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::CashWithdrawalRequestPaid) {
						if ($transaction['Transaction']['payment_gateway_id'] == ConstPaymentGateways::ManualPay) {
						echo ' through Manual';
						}
						} elseif (($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked || $transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) && $transaction['Transaction']['user_id'] != ConstUserIds::Admin && empty($this->request->params['named']['filter'])) {
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked) {
						echo ' (' . __l('Funded Amount') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($transaction['ProjectFund']['amount'], false)) . ')';
						}
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) {
						echo ' (' . __l('Canceled Amount') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($transaction['ProjectFund']['amount'], false)) . ')';
						}
						} elseif (($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked || $transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) && $transaction['Transaction']['user_id'] != ConstUserIds::Admin) {
						echo ' (' . __l('Site Fee') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($transaction['ProjectFund']['site_fee'], false)) . ')';
						}  else {
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked) {
						echo ' (' . __l('Funded Amount') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($transaction['ProjectFund']['amount'], false)) . ')';
						}
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) {
						echo ' (' . __l('Canceled Amount') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($transaction['ProjectFund']['amount'], false)) . ')';
						}
						}
						if ($transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) {
						if ($transaction['ProjectFund']['canceled_by_user_id'] == ConstPledgeCanceledBy::Admin) {
						echo ' (' . __l('Canceled by Admin').')';
						}else if ($transaction['ProjectFund']['canceled_by_user_id'] == ConstPledgeCanceledBy::Owner) {
						echo ' (' . sprintf(__l('Canceled by %s Owner'), Configure::read('project.alt_name_for_project_singular_caps')).')';
						} else {
						echo ' (' . sprintf(__l('Canceled by %s'), Configure::read('project.alt_name_for_'.$transaction['ProjectFund']['Project']['ProjectType']['funder_slug'].'_singular_caps')).')';
						}
						}
						?>
						</td>
						<td class="text-center">
						<?php
						if (!empty($transaction['TransactionType'][$credit_type])) {
						echo $this->Html->cCurrency($transaction['Transaction']['amount']);
						} else {
						echo '--';
						}
						?>
						</td>
						<td class="text-center">
						<?php
						if (!empty($transaction['TransactionType'][$credit_type])) {
						echo '--';
						} else {
						echo $this->Html->cCurrency($transaction['Transaction']['amount']);
						}
						?>
						</td>
						</tr>
						<?php endforeach; ?>
						<tr class="total-block">
						<td class="text-left" colspan="3"><span><?php echo __l('Total');?></span></td>
						<td class="text-left credit-total"><?php echo $this->Html->cCurrency($total_credit_amount);?></td>
						<td class="text-left debit-total"><?php echo $this->Html->cCurrency($total_debit_amount);?></td>
						</tr>
						<?php else: ?>
						<tr>
						<td colspan="11" class="text-danger text-center"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Transactions'));?></td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="page-sec navbar-btn">
			<?php if (!empty($transactions)) : ?>
				<?php echo $this->element('paging_links'); ?>
			<?php endif; ?>
		</div>
	</div>
</section>