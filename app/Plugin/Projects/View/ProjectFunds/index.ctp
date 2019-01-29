<?php /* SVN: $Id: index.ctp 2879 2010-08-27 11:08:48Z sakthivel_135at10 $ */ ?>
<?php
$bakerordonor = Configure::read('project.alt_name_for_'.$project['ProjectType']['funder_slug'].'_singular_caps');
$bakersordonors = Configure::read('project.alt_name_for_'.$project['ProjectType']['funder_slug'].'_plural_caps');
?>
<div class="js-response js-manage-rewards-container">
	<div class="main-section content">
		<h3 class="navbar-btn roboto-bold font-size-28 ver-mspace"><?php echo $bakersordonors;?></h3>
		<?php if (!empty($is_show_reward_filter) && ($project['Project']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin)): ?>
			<div class="clearfix">
				<ul class="filter-list-block list-unstyled">
					<li class="pull-left text-center"><?php echo $this->Html->link('<span class="show"><span><strong>'.$this->Html->cInt($all_count,false).'</strong></span></span><span class="label label-warning">' .__l('All'). '</span>', array('controller'=>'project_funds','action'=>'index','project_id' => $this->request->params['named']['project_id'],'filter'=>'all'), array('class' => "pull-left js-manage-rewards js-no-pjax { container:'.js-manage-rewards-container'}", 'escape' => false));?></li>
					<li class="pull-left text-center"><?php echo $this->Html->link('<span class="show"><span><strong>'.$this->Html->cInt($given_count,false).'</strong></span></span><span class="label label-success">' .__l('Given'). '</span>', array('controller'=>'project_funds','action'=>'index','project_id' => $this->request->params['named']['project_id'],'filter'=>'given'), array('class' => "pull-left js-manage-rewards js-no-pjax { container:'.js-manage-rewards-container'}", 'escape' => false));?></li>
					<li class="pull-left text-center"><?php echo $this->Html->link('<span class="show"><span><strong>'.$this->Html->cInt($not_given_count,false).'</strong></span></span><span class="label label-danger">' .__l('Not Given'). '</span>', array('controller'=>'project_funds','action'=>'index','project_id' => $this->request->params['named']['project_id'],'filter'=>'not_given'), array('class' => "pull-left js-manage-rewards js-no-pjax { container:'.js-manage-rewards-container'}", 'escape' => false));?></li>
				</ul>
			</div>
		<?php endif; ?>
		<ul class="list-unstyled cf-backer clearfix">
			<?php
			if (!empty($projectFunds)):
			$i = 0;
			$projectStatus = array();
			foreach ($projectFunds as $projectFund):
			$class = null;
			if ($i++ % 2 == 0) {
			$class = ' altrow';
			}
			?>
			<li class="border-bottom col-xs-12 <?php echo $class ?>">
				<?php if (empty($projectFund['ProjectFund']['is_anonymous']) || $projectFund['User']['id'] == $this->Auth->user('id') || (!empty($projectFund['ProjectFund']['is_anonymous']) && $projectFund['ProjectFund']['is_anonymous'] == ConstAnonymous::FundedAmount)) { ?>
					<?php if(!empty($projectFund['User']['id'])) { ?>
					<div class="clearfix display-tbl navbar-btn no-float pull-left">
						<div class="img-contain-110 img-circle center-block">
							<?php echo $this->Html->getUserAvatar($projectFund['User'],'user_thumb', true, '', '', '',(isset($this->request->params['named']['modal']) && $this->request->params['named']['modal'] == "modal")?$this->request->params['named']['modal']:'');?>
						</div>
					</div>
					<?php } else { ?>
					<div class="display-tbl navbar-btn no-float">
						<div class="img-contain-110 img-circle center-block js-tooltip show">
							<?php echo $this->Html->getUserAvatar(array(), 'user_thumb', false, 'anonymous'); ?>
						</div>
					</div>
					<?php } ?>
				<?php } else { ?>
					<div class="pull-left display-tbl navbar-btn no-float">
						<div class="img-contain-110 img-circle center-block js-tooltip show">
							<?php echo $this->Html->getUserAvatar(array(), 'user_thumb', false, 'anonymous');?>
						</div>
					</div>
				<?php } ?>
				<div class="col-xs-5 col-md-5 h3 no-float">
					<h3 class="panel-title txt-center-mbl h-center-blk">
						<?php
							if (empty($projectFund['ProjectFund']['is_anonymous']) || $projectFund['User']['id'] == $this->Auth->user('id') || (!empty($projectFund['ProjectFund']['is_anonymous']) && $projectFund['ProjectFund']['is_anonymous'] == ConstAnonymous::FundedAmount)) {
								echo $this->Html->link($this->Html->cText($projectFund['User']['username']), array('controller'=> 'users', 'action' => 'view', $projectFund['User']['username']), array('escape' => false));
							} else {
								echo '<span class="c roboto-bold">'.__l('Anonymous').'</span>';
							}
						?>
						<?php
						$time_format = date('Y-m-d\TH:i:sP', strtotime($projectFund['ProjectFund']['created']));
						?>
						<i class="fa fa-clock-o"></i>
						<span class="h5 list-group-item-text list-group-item-heading js-timestamp" title="<?php echo $time_format;?>"> 
							<?php echo $this->Html->cDateTimeHighlight($projectFund['ProjectFund']['created'], false); ?>
						</span>
					</h3>
					<?php if (empty($projectFund['ProjectFund']['is_anonymous'])) : ?>
						<p class="h5">
							<?php if (!empty($projectFund['User']['unique_project_fund_count']) && $projectFund['User']['unique_project_fund_count'] > 1): ?>
								<?php $other_count = $projectFund['User']['unique_project_fund_count'] - 1; ?>
								<span class="h5 list-group-item-text list-group-item-heading txt-center-mbl h-center-blk roboto-regular"><?php echo __l('Funded'). ' ';  ?><span class="roboto-bold"><?php echo $this->Html->link($this->Html->cInt($other_count, false), array('controller' => 'users', 'action' => 'view', $projectFund['User']['username'], '#project_funded'), array('class' => 'backers-icon', 'title' => $this->Html->cInt($other_count, false))); ?></span><?php echo ' ' . sprintf(__l('other %s.'), Configure::read('project.alt_name_for_project_plural_small')); ?></span>
							<?php endif; ?>
						</p>
					<?php endif; ?>
					<?php if (!empty($projectFund['ProjectReward']['reward']) && !empty($projectFund['ProjectReward']['is_shipping']) && isPluginEnabled('Pledge')) { ?>
						<?php if ($this->Auth->user('id') == $projectFund['Project']['user_id'] || $this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
						<div class="clearfix">
							<h4 class="txt-center-mbl h-center-blk roboto-bold"><?php echo __l('Shipping Address'); ?></h4>
							<?php
							$location = array();
							$place = '';
							if (!empty($projectFund['PledgeFund']['shipping_address'])) :
							$location[] = $projectFund['PledgeFund']['shipping_address'];
							endif;
							if (!empty($projectFund['PledgeFund']['City'])) :
							$location[] = $this->Html->cText($projectFund['PledgeFund']['City']['name'], false);
							endif;
							if (!empty($projectFund['PledgeFund']['Country']['name'])) :
							$location[] = $projectFund['PledgeFund']['Country']['name'];
							endif;
							$place = implode(', ', $location);
							if ($place):
							if (!empty($projectFund['PledgeFund']['Country']['iso_alpha2'])):
							?>
							<span class="flags flag-<?php echo strtolower($projectFund['PledgeFund']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($projectFund['PledgeFund']['Country']['name'], false); ?>"><?php echo $this->Html->cText($projectFund['PledgeFund']['Country']['name'], false); ?></span>
							<?php
							endif;
							?>
							<span class="font-size-15"><?php echo $place; ?> </span>
							<?php
							endif;
							?>
						</div>
						<?php } ?>
					<?php } ?>
					<span class="text-center">
					<?php if (isPluginEnabled('ProjectRewards') && $projectFund['ProjectFund']['project_type_id'] == ConstProjectTypes::Pledge && $project['Project']['project_reward_count'] > 0) { ?>
						<?php echo !empty($projectFund['ProjectReward']['reward'])  ? $this->Html->cText($projectFund['ProjectReward']['reward']) : sprintf(__l('No %s chosen'), Configure::read('project.alt_name_for_reward_singular_small')); ?>
					<?php } ?>
					</span>
				</div>				
				<?php if(!empty($projectFund['PledgeFund']['additional_info'])) {  ?>
					<div class="clearfix"> 
						<?php if(!empty($projectFund['ProjectReward']['additional_info_label'])) {  ?>
							<span><strong><?php echo $this->Html->cText($projectFund['ProjectReward']['additional_info_label'], false); ?></strong></span>
						<?php } ?>
						<?php echo $this->Html->cText($projectFund['PledgeFund']['additional_info'], false); ?> 
					</div>
				<?php } ?>
		<?php
		if (empty($projectStatus[$projectFund['Project']['id']])) {
		$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
		'projectStatus' => $projectStatus,
		'project' => $projectFund,
		'type' => 'status'
		));
		$projectStatus = $response->data['projectStatus'];
		}
		?>
		<div class="navbar-btn pull-right no-float btn-vert-alfn list-group-item-heading">
			<?php if ($project['Project']['user_id'] == $this->Auth->user('id') || ($projectFund['ProjectFund']['user_id'] == $this->Auth->user('id')) || (Configure::read('Project.is_show_backers_amount_for_guest_users')) || (Configure::read('Project.is_show_other_backers_amount_for_backers') && $backer) || $this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
				<?php if (empty($projectFund['ProjectFund']['is_anonymous']) || $projectFund['User']['id'] == $this->Auth->user('id') || (!empty($projectFund['ProjectFund']['is_anonymous']) && $projectFund['ProjectFund']['is_anonymous'] == ConstAnonymous::Username)) { ?>
					<span class="btn btn-sm btn-info show navbar-btn h-center-blk"><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($projectFund['ProjectFund']['amount'],false));?></span>
				<?php } ?>
			<?php endif; ?>
			<?php if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Authorized && (($projectFund['ProjectFund']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_funder')) || ($projectFund['Project']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_owner')) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) && (strtotime('+'.Configure::read('Project.minimum_days_before_fund_cancel').' days') < strtotime($projectFund['Project']['project_end_date'].'23:59:59')) && !empty($response->data['is_allow_to_cancel_pledge'])): ?>            
			<?php
				if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Canceled) :
					echo '<span class="pull-right label label-primary pro-status-5">';
					echo __l('Refunded');
				else:
					echo '<span class="pull-right">';
					echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_pledge_singular_caps')), array('controller'=> 'project_funds', 'action' => 'edit_fund', 'project_fund' => $projectFund['ProjectFund']['id'], 'type' => 'cancel'), array('escape' => false, 'class' => 'js-confirm btn btn-danger', 'title' => sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_pledge_singular_caps'))));
				endif;
			?>
			</span>
			<?php endif; ?>
			<?php if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Authorized && (($projectFund['ProjectFund']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_funder')) || ($projectFund['Project']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_owner')) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) && (strtotime('+'.Configure::read('Project.minimum_days_before_fund_cancel').' days') < strtotime($projectFund['Project']['project_end_date'].'23:59:59')) && !empty($response->data['is_allow_to_cancel_lend'])): ?>            
				<?php
					if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Canceled) :
						echo '<span class="pull-right label label-primary pro-status-5">';
						echo __l('Refunded');
					else:
						echo '<span class="pull-right">';
						echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_lend_singular_caps')), array('controller'=> 'project_funds', 'action' => 'edit_fund', 'project_fund' => $projectFund['ProjectFund']['id'], 'type' => 'cancel'), array('escape' => false, 'class' => 'js-confirm btn btn-primary', 'title' => sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_lend_singular_caps'))));
					endif;
				?>
			</span>
			<?php endif; ?>
			<?php if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Authorized && (($projectFund['ProjectFund']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_funder')) || ($projectFund['Project']['user_id'] == $this->Auth->user('id') && Configure::read('Project.is_allow_fund_cancel_by_owner')) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) && (strtotime('+'.Configure::read('Project.minimum_days_before_fund_cancel').' days') < strtotime($projectFund['Project']['project_end_date'].'23:59:59')) && !empty($response->data['is_allow_to_cancel_equity'])): ?>            
			<?php
				if ($projectFund['ProjectFund']['project_fund_status_id'] == ConstProjectFundStatus::Canceled) :
					echo '<span class="pull-right label pro-status-5">';
					echo __l('Refunded');
				else:
					echo '<span class="pull-right">';
					echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_equity_singular_caps')), array('controller'=> 'project_funds', 'action' => 'edit_fund', 'project_fund' => $projectFund['ProjectFund']['id'], 'type' => 'cancel'), array('escape' => false, 'class' => 'js-confirm', 'title' => sprintf(__l('Cancel %s'), Configure::read('project.alt_name_for_invest_singular_caps'))));
				endif;
			?>
			</span>
			<?php endif; ?>			
			<?php if ($projectFund['Project']['user_id'] == $this->Auth->user('id') && in_array($projectFund['ProjectFund']['is_anonymous'], array(ConstAnonymous::None, ConstAnonymous::FundedAmount))): ?>
				<span class="pull-right ver-space"><?php echo $this->Html->link(' '.'<i class="fa fa-envelope fa-fw"></i>'.' '.sprintf(__l('Contact %s'), $bakerordonor), array('controller' => 'projects', 'action' => 'view', $projectFund['Project']['slug'] .'/funded_id:'.$projectFund['ProjectFund']['id'].'#comments'), array('class' => 'cboxelement msg js-no-pjax js-scrollto-target {\'targetid\':\'#comments\'}', 'escape' => false,'title'=>sprintf(__l('Contact %s'),$bakerordonor))); ?></span>
			<?php endif; ?>
			<?php if ($projectFund['ProjectFund']['user_id'] == $this->Auth->user('id') && !empty($projectFund['ProjectFund']['project_reward_id']) && !empty($response->data['is_allow_to_print_voucher'])): ?>
				<span class="pull-right"><?php echo $this->Html->link(' '.'<i class="fa fa-print fa-fw"></i>'.' '.__l('Print voucher'), array('controller' => 'project_funds', 'action' => 'view', $projectFund['ProjectFund']['id'],'type'=>'print'), array('escape' => false,'target'=>'_blank','title'=>__l('Print voucher'))); ?></span>
			<?php endif; ?>
			<?php if ($projectFund['Project']['user_id'] == $this->Auth->user('id') && !empty($projectFund['ProjectFund']['project_reward_id']) && !empty($response->data['is_allow_to_change_given'])): ?>
				<span class="js-given-response js-no-pjax pull-right">
				<?php if (empty($projectFund['ProjectFund']['is_given'])): ?>
					<?php echo $this->Html->link('<i class="fa fa-thumbs-up fa-fw"></i> ' . __l('Given'), array('controller' => 'project_funds', 'action' => 'reward_update', $projectFund['ProjectFund']['id']), array('class'=>'js-given js-no-pjax {"title":"'.__l('Given').'"}','escape' => false,'title'=>__l('Given'))); ?>
				<?php else: ?>
					<?php echo $this->Html->link('<i class="fa fa-thumbs-down fa-fw"></i> ' . __l('Not Given'), array('controller' => 'project_funds', 'action' => 'reward_update', $projectFund['ProjectFund']['id']), array('class'=>'js-given js-no-pjax {"title":"'.__l('Not given').'"}','escape' => false,'title'=>__l('Not Given'))); ?>
				<?php endif; ?>
				</span>
			<?php endif; ?>
		</div></li>
		<?php
		endforeach;
		else:
		?>
		<li>
			<div class="text-center">
				<p class="navbar-btn hor-space"><?php echo sprintf(__l('No %s available'), $bakersordonors);?></p>
			</div>
		</li>
		<?php
		endif;
		?>
	</ul>
	<?php if (!empty($projectFunds)) { ?>
		<div  class="pull-right js-pagination js-no-pjax"> <?php echo $this->element('paging_links'); ?> </div>
	<?php } ?>
	<?php if (empty($this->request->params['named']['filter'])): ?>
	</div>
</div>
<?php endif; ?>