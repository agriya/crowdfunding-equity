<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">
		<ul class="list-inline sec-1 navbar-btn">
			<li>	
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($waiting_for_approval,false).'</span><span>' .__l('Pending'). '</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($approved,false).'</span><span>' .__l('Approved'). '</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Accepted), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($rejected,false).'</span><span>' .__l('Disapproved'). '</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Rejected), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($all,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'affiliate_requests','action'=>'index'), array('class' => 'text-center','escape' => false));?>
			</li>
		</ul>
	</div>
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?> &nbsp;
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').'&nbsp; <span class="badge"><i class="fa fa-plus"></i></span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right"> 
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('AffiliateRequest' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
						<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
						<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control')); ?>
						<div class="hide">
						<?php echo $this->Form->submit(__l('Search'));?>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</li>
			</ul>
		</div>
		<?php echo $this->Form->create('AffiliateRequest' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="select text-center"><?php echo __l('Select');?></th>
						<th class="text-center"><?php echo __l('Actions');?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('site_name', __l('Site'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('site_url', __l('Site URL'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('site_category_id', __l('Site Category'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('why_do_you_want_affiliate', __l('Why Do You Want An Affiliate?'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('is_web_site_marketing', __l('Website Marketing?'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('is_search_engine_marketing', __l('Search Engine Marketing?'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('is_email_marketing', __l('Email Marketing?'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('special_promotional_method', __l('Promotional Method'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('is_approved', __l('Approved?'));?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($affiliateRequests)):
					$i=0;
					foreach ($affiliateRequests as $affiliateRequest):
					if($affiliateRequest['AffiliateRequest']['is_approved']):
					$status_class = 'js-checkbox-active';
					$disabled = '';
					else:
					$status_class = 'js-checkbox-inactive';
					$disabled = 'class="disabled"';
					endif;
					?>
					<tr <?php echo $disabled;?>>
						<td class="select text-center"><?php echo $this->Form->input('AffiliateRequest.'.$affiliateRequest['AffiliateRequest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateRequest['AffiliateRequest']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action'=>'edit', $affiliateRequest['AffiliateRequest']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $affiliateRequest['AffiliateRequest']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($affiliateRequest['AffiliateRequest']['id']);  ?>
								</ul>
							</div>
						</td>
						<td>
							<ul class="list-inline tbl">
								<li class="tbl-img">
									<?php echo $this->Html->getUserAvatar($affiliateRequest['User'], 'micro_thumb',true, '', 'admin');?>
								</li>
								<li class="tbl-cnt">
									<p>
										<?php echo $this->Html->getUserLink($affiliateRequest['User']);?>
									</p>
								</li>
							</ul>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_name']);?></td>
						<td class="text-left">
						<?php echo $this->Html->link($affiliateRequest['AffiliateRequest']['site_url'], $affiliateRequest['AffiliateRequest']['site_url'], array('target' => '_blank'));?>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($affiliateRequest['SiteCategory']['name']);?></td>
						<td class="text-left"><div class="js-tooltip" title="<?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate'], false);?>"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate'], false);?></div></td>

						<td class="text-center"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_web_site_marketing']);?></td>
						<td class="text-center"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_search_engine_marketing']);?></td>
						<td class="text-center"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_email_marketing']);?></td>
						<td class="text-left"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['special_promotional_method'],false);?></td>
						<td class="text-center">
						<span>
						<?php if($affiliateRequest['AffiliateRequest']['is_approved'] == 0){
						echo __l('Waiting for Approval');
						} else if($affiliateRequest['AffiliateRequest']['is_approved'] == 1){
						echo __l('Approved');
						} else if($affiliateRequest['AffiliateRequest']['is_approved'] == 2){
						echo __l('Disapproved');
						}
						?>
						</span>
						</td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="16"><i class="fa fa-exclamation-triangle"></i> <?php echo __l('No Affiliate Requests available');?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php
		if (!empty($affiliateRequests)) :
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline clearfix">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Disapprove'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Disapprove'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Approve'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Approve'))); ?>
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
		<?php
		endif;
		echo $this->Form->end();
		?>
	</div>
	</div>
</div>
