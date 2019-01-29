<?php /* SVN: $Id: admin_index.ctp 69575 2011-10-25 05:50:05Z sakthivel_135at10 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">
		<div class="clearfix">
			<ul class="list-inline sec-1 navbar-btn">
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center pr-lnc-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Pending'). '</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Pending), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block ste-usr text-center">'.$this->Html->cInt($approved,false).'</span><span>' .__l('Approved'). '</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Approved), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($rejected,false).'</span><span>' .__l('Rejected'). '</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Rejected), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($success,false).'</span><span>' .__l('Success'). '</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Success), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($approved + $pending + $rejected + $success ,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'user_cash_withdrawals','action'=>'index'), array('class' => 'text-center', 'escape' => false));?>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
	<div class="alert alert-info">
	<?php echo __l('Following withdrawal request has been submitted to payment gateway API, These are waiting for IPN from the payment gateway API. Either it will move to Success or Failed'); ?>
	</div>
	<?php endif; ?>
	<div class="clearfix">
		<div class="navbar-btn">
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<?php echo $this->Form->create('UserCashWithdrawal' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?> 
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
						<th class="select text-center"><?php echo __l('Select'); ?></th>
						<?php endif;?>
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </th>
						<?php if(empty($this->request->params['named']['filter_id'])) { ?>
						<th><?php echo $this->Paginator->sort('WithdrawalStatus.name', __l('Status'));?></th>
						<?php } ?>
						<th class="text-center"><?php echo $this->Paginator->sort('UserCashWithdrawal.created', __l('Withdraw Requested Date'));?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($userCashWithdrawals)):
					foreach ($userCashWithdrawals as $userCashWithdrawal):
					?>
					<tr>
						<?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
						<td class="select text-center">
						<?php echo $this->Form->input('UserCashWithdrawal.'.$userCashWithdrawal['UserCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => '', 'class' => 'js-checkbox-list ' )); ?>
						</td>
						<?php endif;?>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>' . __l('Delete'), Router::url(array('action'=>'delete',$userCashWithdrawal['UserCashWithdrawal']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape' => false, 'title' => __l('Delete')));?></li>
									<?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
									<li><?php echo $this->Html->link('<i class="fa fa-hdd-o fa-fw"></i> ' . __l('Move to success'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'success'), array('escape' => false, 'title' => __l('Move to success')));?></li>
									<?php endif;?>
									<?php echo $this->Layout->adminRowActions($userCashWithdrawal['UserCashWithdrawal']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<ul class="list-inline tbl">	
								<li class="tbl-img">
									<?php echo $this->Html->showImage('UserAvatar', $userCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($userCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($userCashWithdrawal['User']['username'], false)));?>
								</li>
								<li class="tbl-cnt">
									<p>
										<?php echo $this->Html->link($this->Html->cText($userCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $userCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($userCashWithdrawal['User']['username'],false),'escape' => false));?>
									</p>
								</li>
							</ul>
							<?php
							if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending):
								foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
								if(!empty($moneyTransferAccount['is_default'])):
							?>
							<?php
								endif;
								endforeach;
							endif;
							?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?>
							<?php if(!empty($userCashWithdrawal['UserCashWithdrawal']['remark'])): ?>
							<span class="js-tooltip" title="<?php echo $this->Html->cText($userCashWithdrawal['UserCashWithdrawal']['remark'], false); ?>"><i class="fa fa-question-circle"></i></span>
							<?php endif; ?>
						</td>
						<?php if(empty($this->request->params['named']['filter_id'])) { ?>
						<td>
							<?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
						<?php } ?>
						<td class="text-center">
							<?php echo $this->Html->cDate($userCashWithdrawal['UserCashWithdrawal']['created']);?>
						</td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="8" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($userCashWithdrawals)) { ?>
		<?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'text-info js-select js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'text-info js-select js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
					</li>
					<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
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
		<?php } ?>
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</div>
