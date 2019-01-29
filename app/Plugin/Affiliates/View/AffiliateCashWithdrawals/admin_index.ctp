<?php /* SVN: $Id: admin_index.ctp 2077 2010-04-20 10:42:36Z josephine_065at09 $ */ ?>
<div class="main-admn-usr-lst js-response js-admin-index-autosubmit-over-block">
	<div class="bg-primary row">
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Pending'). '</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Pending), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($rejected,false).'</span><span>' .__l('Rejected'). '</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Rejected), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($success,false).'</span><span>' .__l('Success'). '</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Success), array('escape' => false));?>
			</li>    
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($approved + $pending + $rejected + $success,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index'), array('escape' => false));?>
			</li>
		</ul>
	</div>
	<div class="clearfix">
		<div class="navbar-btn clearfix">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
			</h3>
			<?php if($this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved): ?>
			<div class="alert alert-info"><?php echo __l('Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed'); ?></div>
			<?php endif; ?>
			<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 4):?>
			<div class="alert alert-info"><?php echo __l('Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.');?></div>
			<?php endif;?>
			<ul class="list-unstyled clearfix pull-left">
				<li class="pull-left">
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
			<ul class="list-inline pull-right">
				<li><?php echo __l('Transfer Account: '); ?></li>
				<?php $class = ( !isset($this->request->params['named']['account_id']) || $this->request->params['named']['account_id'] == 'all' ) ? 'active' : null; ?>
				<li "<?php echo $class ?>"><div><?php echo $this->Html->link(__l('All'), array('action' => 'index', 'filter_id' => $this->request->params['named']['filter_id'], 'account_id' => 'all'), array('title' => __l('All')));?></div></li>
			</ul>
		</div>		
		<?php echo $this->Form->create('AffiliateCashWithdrawal' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>   
						<?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
						<th class="select text-center"><?php echo __l('Select'); ?></th>
						<?php endif; ?>
						<?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
						<th class="text-center"><?php echo __l('Action'); ?></th>
						<?php endif;?>
						<th class="text-center"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created', __l('Requested On'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
						<th class="text-right"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </th>
						<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
						<th class="text-center"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.modified', __l('Paid on'));?></th>
						<?php } ?>
						<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
						<th class="text-center"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.name', __l('Status'));?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($affiliateCashWithdrawals)):
					foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
					?>
					<tr>
						<?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
						<td class="select text-center">
							<?php echo $this->Form->input('AffiliateCashWithdrawal.'.$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => '', 'class' => 'js-checkbox-list ' )); ?>
						</td>
						<?php endif; ?>
						<?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
										<?php echo $this->Html->link('<i class="fa fa-hdd-o fa-fw"></i>'.__l('Move to success'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'success'), array('escape'=>false,'title' => __l('Move to success')));?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Move to failed'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'failed'), array('escape'=>false, 'title' => __l('Move to failed')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($affiliateCashWithdrawal['AffiliateCashWithdrawal']['id']);  ?>
								</ul>
							</div>
						</td>
						<?php endif;?>
						<td class="text-center">
							<?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['created']);  ?> 
						</td>
						<td>
							<ul class="list-inline tbl">
								<li class="tbl-img">
									<?php echo $this->Html->showImage('UserAvatar', $affiliateCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)));?>
								</li>
								<li class="tbl-cnt">
									<p>
										<?php echo $this->Html->link($this->Html->cText($affiliateCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($affiliateCashWithdrawal['User']['username'],false),'escape' => false));?>
										<?php
										foreach($affiliateCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
										if(!empty($moneyTransferAccount['PaymentGateway'])):
										?>
										<span class="label label-info label-project-status-2 paypal"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['display_name']);?></span>
										<?php
										endif;
										endforeach;
										?>
									</p>
								</li>
							</ul>
						</td>
						<td class="text-right">
							<?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?>
						</td>
						<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
						<td class="text-center">  
							<?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['modified']);  ?> 
						</td>
						<?php } ?>
						<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
						<td class="text-center">
							<?php
							if($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
							echo __l('Pending');
							elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
							echo __l('Approved');
							elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
							echo __l('Rejected');
							elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
							echo __l('Success');
							else:
							echo $this->Html->cText($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
							endif;
							?>
						</td>
						<?php } ?>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="8" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Affiliate Cash Withdrawals'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($affiliateCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending))):?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline clearfix">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
					</li>
					<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
							<div class="hide">
							<?php echo $this->Form->submit('Submit');  ?>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</div>