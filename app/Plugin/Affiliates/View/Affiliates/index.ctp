<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="container user-dashboard">
<div class="clearfix">
  <div class="clearfix user-heading">
		<h3 class="col-xs-6 h2 text-uppercase list-group-item-text"><?php echo __l('Affiliate');?></h3>
		<div class="col-xs-6 h2 list-group-item-text">
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
  </div>
  <?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
</div>
<div class="main-section">
  <div class="affiliates index admin-form">
    <?php if ($logged_in_user['User']['is_affiliate_user']): ?>
	<?php if(isPluginEnabled('Withdrawals')) : ?>
      <div class="col-xs-12 gray-bg">
        <div class="pull-right">
          <?php echo $this->Html->link('<i class="fa fa-briefcase fa-fw"></i> '.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('class' => 'js-tooltip', 'escape' => false, 'title' => __l('Affiliate Cash Withdrawal Requests'))); ?>
        </div>
      </div>
	  <?php endif; ?>
	  <div class="col-xs-12 marg-btom-30">
		  <p><?php echo __l('Share your below unique link for referral purposes'); ?></p>
		  <input type="text" readonly="readonly" class="marg-btom-20" value="<?php echo Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true);?>" onclick="this.select()"/>
		  <p><?php echo __l('Share your below unique link by appending to end of site URL for referral'); ?></p>
		  <input type="text" readonly="readonly" value="<?php echo  '/r:'.$this->Auth->user('username');?>" onclick="this.select()"/>
		  <?php  echo $this->element('affiliate_stat', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		  <h3><?php echo __l('Commission History');?></h3>
		  <?php echo $this->element('paging_counter');?>
		  <table class="table table-striped table-bordered table-condensed table-hover">
			<tr>
			  <th><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
			  <th><?php echo sprintf(__l('User/%s'), Configure::read('project.alt_name_for_project_singular_caps'));?></th>
			  <th><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'));?></th>
			  <th><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'));?></th>
			  <th><?php echo $this->Paginator->sort('commission_amount', __l('Commission') . ' (' . Configure::read('site.currency') . ')');?></th>
			</tr>
			<?php
			  if (!empty($affiliates)):
				$i = 0;
				foreach ($affiliates as $affiliate):
				  $i++;
			?>
			<tr>
			  <td> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
			  <td>
				<?php if ($affiliate['Affiliate']['class'] == 'User' && !empty($affiliate['User']['username'])) { ?>
				  <?php echo $this->Html->link($this->Html->cText($affiliate['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['User']['username']), array('escape' => false));?>
				<?php } else if ($affiliate['Affiliate']['class'] == 'Project'){ ?>
				  <?php echo $this->Html->link($this->Html->cText($affiliate['Project']['name']), array('controller'=> 'projects', 'action' => 'view', $affiliate['Project']['slug']), array('escape' => false));?>
				  (<?php echo $this->Html->link($this->Html->cText($affiliate['Project']['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['Project']['User']['username'], 'admin' => false), array('escape' => false));?>)
				<?php } else { ?>
				  <?php echo $this->Html->link($this->Html->cText($affiliate['ProjectFund']['Project']['name']), array('controller'=> 'projects', 'action' => 'view', $affiliate['ProjectFund']['Project']['slug']), array('escape' => false));?>
				  (<?php echo $this->Html->link($this->Html->cText($affiliate['ProjectFund']['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['ProjectFund']['User']['username'], 'admin' => false), array('escape' => false));?>)
				<?php } ?>
			  </td>
			  <td><?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?></td>
			  <td>
				<?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']); ?>
				<?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
				  <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']);?>
				<?php endif; ?>
			  </td>
			  <td><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
			</tr>
			<?php
				endforeach;
			  else:
			?>
			<tr>
			  <td colspan="6">
				  <div class="text-center">
					<p><?php echo sprintf(__l('No %s available'), __l('Commission History'));?></p>
				  </div>
			  </td>
			</tr>
			<?php
			  endif;
			?>
		  </table>
		  <?php if (!empty($affiliates)) { ?>
			<div class="clearfix">
				<div class="pull-right">
				  <?php echo $this->element('paging_links'); ?>
				</div>
			</div>
		  <?php } ?>
		<?php else: ?>
		  <?php
			echo $this->element('pages-terms_and_policies', array('cache' => array('config' => 'sec'), 'Plugin' => false, 'slug' => $slug));
			if ($this->Auth->sessionValid()):
			  echo $this->element('affiliate_request-add', array('cache' => array('config' => 'sec'), 'Plugin' => 'Affiliates'));
			endif;
		  ?>
		<?php endif; ?>
	</div>
  </div>
</div>
</div>