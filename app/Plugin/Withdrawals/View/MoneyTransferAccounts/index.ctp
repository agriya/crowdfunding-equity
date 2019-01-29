<div class="container">
	<div class="social-myconnect setting-drop-menu">
		<div class="clearfix user-heading">
			<h3 class="col-xs-8 col-sm-6 h2 text-uppercase navbar-btn"><?php echo __l('Money Transfer Accounts'); ?></h3>
			<div class="col-xs-4 col-sm-6 h2 navbar-btn">
				<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
			</div>
		</div>
		<div class="main-section admin-form">
		  <?php echo $this->element('money_transfer_accounts-add'); ?>
		  <div class="moneyTransferAccounts clearfix index">
			<section class="clearfix">
			  <div class="pull-left">
				<?php echo $this->element('paging_counter');?>
			  </div>
			</section>
			<section>
			  <table class="table table-striped table-bordered table-condensed table-hover">
				<tr>
				  <th class="text-center"><?php echo __l('Action');?></th>
				  <th class="text-left"><?php echo __l('Account');?></th>
				  <th class="text-center"><?php echo $this->Paginator->sort('is_default', __l('Primary'));?></th>
				</tr>
				<?php
				  if (!empty($moneyTransferAccounts)):
					$i = 0;
					foreach ($moneyTransferAccounts as $moneyTransferAccount):
					  $class = null;
					  if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					  }
				?>
				<tr <?php echo $class;?>>
				  <td class="col-md-1 text-center">
					<div class="dropdown">
					  <a href="#" title="Actions" data-toggle="dropdown" class="fa fa-cog dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
					  <ul class="list-unstyled dropdown-menu text-left clearfix">
						<li><?php echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete'), array('controller' => 'money_transfer_accounts', 'action' => 'delete', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'js-confirm delete ', 'escape'=>false,'title' => __l('Delete')));?></li>
						<?php if(!$moneyTransferAccount['MoneyTransferAccount']['is_default']):?>
						  <li><?php echo $this->Html->link(__l('Make as primary'), array('controller' => 'money_transfer_accounts', 'action' => 'update_status', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'widthdraw', 'title' => 'Make as primary')); ?></li>
						<?php endif;?>
					  </ul>
					</div>
				  </td>
				  <td class="text-left"><?php echo nl2br($this->Html->cText($moneyTransferAccount['MoneyTransferAccount']['account']));?></td>
				  <td class="text-center"><?php echo $this->Html->cBool($moneyTransferAccount['MoneyTransferAccount']['is_default']);?></td>
				</tr>
				<?php
					endforeach;
				  else:
				?>
				<tr>
				  <td colspan="4">
				   <div class="text-center">
					<p>
					<?php echo sprintf(__l('No %s available'), __l('Money Transfer Accounts'));?>
				   </p>
				  </div>
				 </td>
				</tr>
				<?php
				  endif;
				?>
			  </table>
			</section>
			<section class="clearfix">
			  <?php if (!empty($moneyTransferAccounts)):?>
				<div class="pull-right">
				  <?php echo $this->element('paging_links'); ?>
				</div>
			  <?php endif;?>
			</section>
		  </div>
		</div>
	</div>
</div>