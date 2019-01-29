<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="pull-right">
		<?php echo $this->Html->link('<i class="fa fa-certificate fa-fw"></i> '.__l('Affiliate  Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('escape'=>false, 'title' => __l('Affiliate  Requests')));?>
		<?php if(isPluginEnabled('Withdrawals')) : ?>
		<?php echo $this->Html->link('<i class="fa fa-briefcase fa-fw"></i> '.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('escape'=>false, 'title' => __l('Affiliate Cash Withdrawal Requests')));?>
		<?php endif; ?>
		<?php echo $this->Html->link('<i class="fa fa-cog fa-fw"></i> '.__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 21), array('escape'=>false, 'title' => __l('Settings')));?>
	</div>
	<?php echo $this->element('admin_affiliate_stat', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')), 'plugin' => 'Affiliates')); ?>
	<h2><?php echo __l('Commission History');?></h2>
	<div class="row bg-primary">		
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Pending'). '</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Pending), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($canceled,false).'</span><span>' .__l('Canceled'). '</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Canceled), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($pipeline,false).'</span><span>' .__l('Pipeline'). '</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::PipeLine), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($completed,false).'</span><span>' .__l('Completed'). '</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Completed), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($all,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'affiliates','action'=>'index'), array('class' => 'text-center', 'escape' => false));?>
				</div>
			</li>
		</ul>		
	</div>
	<div class="clearfix">		
		<div class="navbar-btn">
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>			
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center"><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('AffiliateUser.username', __l('Affiliate User'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('commission_amount', __l('Commission').' ('.Configure::read('site.currency').')');?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($affiliates)):
					foreach ($affiliates as $affiliate):
					?>
					<tr>
						<td class="text-center"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
						<td class="text-left"><?php echo $this->Html->link($this->Html->cText($affiliate['AffiliateUser']['username']), array('controller'=> 'users', 'action'=>'view', $affiliate['AffiliateUser']['username'], 'admin' => false), array('escape' => false));?></td>

						<td class="text-left"> <?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?> </td>

						<td class="text-left">
						<span>
						<?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
						<?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
						<?php echo '['.__l('Since').': '.$this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']). ']';?>
						<?php endif; ?>
						</span>
						</td>
						<td class="text-left"><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="11" class="text-center"><i class="fa fa-exclamation-triangle fa-fw"></i><?php echo sprintf(__l('No %s available'), __l('Commission History'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="page-sec navbar-btn">
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php
				if (!empty($affiliates)) {
				echo $this->element('paging_links');
				}
				?>
			</div>
		</div>
	</div>
</div>