<?php
	$redirect_url = Router::url(array(
		'controller' => 'project_followers',
		'action' => 'add',
		$project['Project']['id']
	), true);
	$projectStatus = array();
	$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
		'projectStatus' => $projectStatus,
		'project' => $project,
		'type'=> 'status'
	));
	$arrow_class = 'arrow-middle';
	if (!empty($response->data['is_allow_to_vote']) || !empty($response->data['is_show_vote'])) {
		$arrow_class = 'arrow-right';
	}
?>
<div class="col-xs-6 col-sm-12 col-md-6 navbar-btn no-float dropdown">
  <?php
		if (isPluginEnabled('ProjectFollowers')) {
			 if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {?>
							<div class="alpuf-<?php echo $project['Project']['id'];?>   hide">
								<?php echo $this->Html->link('<span class="lead roboto-bold">'. __l('Following') .'</span>', array('controller' => 'project_followers', 'action' => 'delete', $follower['ProjectFollower']['id']),array('class'=>"btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-add-remove-followers js-no-pjax js-tooltip js-unfollow",'escape' => false, 'title'=>__l('Unfollow')));  ?>
							</div>
							<div class="alpuf-sm-<?php echo $this->Html->cInt($project['Project']['id'], false);?>   hide">
								<a id="js-follow-id" class="btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip js-follow js-no-pjax {'project_id':'<?php echo $this->Html->cInt($project['Project']['id'], false);?>'}" data-target="#" data-toggle="dropdown" title="<?php echo __l('Follow');?>" href="#"><span class="lead roboto-bold"><?php echo __l('Follow');?></span></a>
								<div class="dropdown-menu <?php echo $arrow_class; ?> js-social-link-div clearfix">
									<div class="text-center">
									<?php echo $this->Html->image('ajax-follow-loader.gif', array('alt' => __l('[Image:Loader]') ,'width' => 16, 'height' => 11, 'class' => 'js-loader')); ?></div>
								</div>
							</div>

							<div class='alpf-<?php echo $this->Html->cInt($project['Project']['id'], false);?>   hide'>
								<a class="btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip" title="<?php echo __l('Follow');?>" href="<?php echo $redirect_url; ?>"><span class="lead roboto-bold"><?php echo __l('Follow');?></span></a>
							</div>
							<div class='blpuf-<?php echo $project['Project']['id'];?>   hide'>
									<?php echo $this->Html->link('<span class="lead roboto-bold">' .__l('Follow') . '</span>', array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array('class' => 'btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip', 'title' => __l('Follow'),'escape' => false));	?>
							</div>
			<?php } else {
			if ($this->Auth->sessionValid()):
				if (!empty($follower)):
					echo $this->Html->link('<span class="lead roboto-bold">'. __l('Following') . '</span>', array('controller' => 'project_followers', 'action' => 'delete', $follower['ProjectFollower']['id']),array('class'=>"btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-add-remove-followers js-no-pjax js-tooltip js-unfollow",'escape' => false, 'title'=>__l('Unfollow')));
				else:
					if (in_array($project['Equity']['equity_project_status_id'], array(ConstEquityProjectStatus::OpenForIdea, ConstEquityProjectStatus::OpenForInvesting, ConstEquityProjectStatus::ProjectClosed, ConstEquityProjectStatus::Pending))):
				?>
						<?php if (isPluginEnabled('SocialMarketing')): ?>
							<a id="js-follow-id" class="btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip js-follow js-no-pjax {'project_id':'<?php echo $this->Html->cInt($project['Project']['id'], false);?>'}" data-target="#" data-toggle="dropdown" title="<?php echo __l('Follow');?>" href="#"><span class="lead roboto-bold"><?php echo __l('Follow');?></span></a>
							<div class="dropdown-menu <?php echo $arrow_class; ?> js-social-link-div clearfix">
								<div class="text-center">
								<?php echo $this->Html->image('ajax-follow-loader.gif', array('alt' => __l('[Image:Loader]') ,'width' => 16, 'height' => 11, 'class' => 'js-loader')); ?></div>
							</div>
						<?php else: ?>
							<a class="btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip" title="<?php echo __l('Follow');?>" href="<?php echo $redirect_url; ?>"><span class="lead roboto-bold"><?php echo __l('Follow');?></span></a>
						<?php endif; ?>
			  <?php
					else:
					?>
					<span class="btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip" title="<?php echo __l('Follow');?>"><span class="lead roboto-bold"><?php echo __l('Follow');?></span></span>
			  <?php	endif;
				endif;
			else:
				if (in_array($project['Equity']['equity_project_status_id'], array(ConstEquityProjectStatus::OpenForIdea, ConstEquityProjectStatus::OpenForInvesting, ConstEquityProjectStatus::ProjectClosed))):
					echo $this->Html->link('<span class="lead roboto-bold">' .__l('Follow') . '</span>', array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array('class' => 'btn btn-lg col-xs-12 col-sm-12 col-md-12 label-default clr-gray no-float js-tooltip', 'title' => __l('Follow'),'escape' => false));
				endif;
			endif;?>
		<?php
		} }
	?>
</div>
	<?php
	if (empty($response->data['is_allow_to_vote']) && empty($response->data['is_show_vote'])) {

	 if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  {
		$status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
									  'status_id' => $project['Equity']['equity_project_status_id'],
									  'project_type_id' => $project['Project']['project_type_id']
									));
		if($status_response->data['response']){
			$reason =  $status_response->data['response'];
		}
		else{
			echo '';
		} if($project['Project']['is_admin_suspended']){
					$reason = __l("Admin Suspended");
		}
		?>
		<div class="col-xs-6 col-sm-12 col-md-6 navbar-btn no-float dropdown equity">
			<?php
				if ($project['Project']['user_id'] != $this->Auth->user('id') || Configure::read('Project.is_allow_owner_fund_own_project')) { 
					$fund_class = 'alf-'.$this->Html->cInt($project['Project']['id'], false);
					if(Configure::read('Project.is_allow_owner_fund_own_project') && $project['Project']['user_id'] == $this->Auth->user('id')){
						$fund_class = 'alof-'.$this->Html->cInt($project['Project']['id'], false);
					}
			?>
				<div class='<?php echo $fund_class;?> hide'> <?php //after login project fund?>
					<?php echo $this->Html->link('<span class="lead roboto-bold">' .Configure::read('project.alt_name_for_equity_singular_caps') . '</span>', array('controller' => 'project_funds', 'action' => 'add', $project['Project']['id']), array('title' => Configure::read('project.alt_name_for_equity_singular_caps'),'class'=>'btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float js-no-pjax js-tooltip', 'escape' => false)); ?>
				</div>
			<?php } else { ?>
				<div class='alof-<?php echo $project['Project']['id'];?> hide'>  <?php //after login project owner fund?>
				<span class="disabled btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float  js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: You can\'t %s your own %s.'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>"><span class="lead roboto-bold"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span></span>
			</div>
			<?php } ?>
			<div class='blf-<?php echo $project['Project']['id'];?> hide'> <?php //before login project fund?>
				<?php echo $this->Html->link('<span class="lead roboto-bold">' .Configure::read('project.alt_name_for_equity_singular_caps') . '</span>', array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array('class' => 'btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float js-no-pjax js-tooltip', 'title' => Configure::read('project.alt_name_for_equity_singular_caps'),'escape' => false)); ?>
			</div>
			<div class='ablfc-<?php echo $project['Project']['id'];?> hide'> <?php //after or before login project fund closed?>
			<span class="disabled btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float  js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: %s.'), $reason); ?>"><span class="lead roboto-bold"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span></span>
			</div>

		</div>
	<?php } else {?>
		<div class="col-xs-6 col-sm-12 col-md-6 navbar-btn no-float dropdown equity">
		<?php
		if (in_array($project['Equity']['equity_project_status_id'], array(ConstEquityProjectStatus::OpenForInvesting)) && !$project['Project']['is_admin_suspended']):
			if ($this->Auth->sessionValid()) {
				if ($project['Project']['user_id'] != $this->Auth->user('id') || Configure::read('Project.is_allow_owner_fund_own_project')) {
					echo $this->Html->link('<span class="lead roboto-bold">' .Configure::read('project.alt_name_for_equity_singular_caps') . '</span>', array('controller' => 'project_funds', 'action' => 'add', $project['Project']['id']), array('title' => Configure::read('project.alt_name_for_equity_singular_caps'),'class'=>'btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float js-no-pjax js-tooltip', 'escape' => false));
				} else {
				?>
				<span class="disabled btn btn-primary col-md-1 tooltiper  js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: You can\'t %s your own %s.'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>"><span class="lead roboto-bold"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span></span>
				<?php
				}
			} else {
				echo $this->Html->link('<span class="lead roboto-bold">' .Configure::read('project.alt_name_for_equity_singular_caps') . '</span>', array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array('class' => 'btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float js-tooltip', 'title' => Configure::read('project.alt_name_for_equity_singular_caps'),'escape' => false));
			}
		else:
		$status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
									  'status_id' => $project['Equity']['equity_project_status_id'],
									  'project_type_id' => $project['Project']['project_type_id']
									));
		if($status_response->data['response']){
			$reason =  $status_response->data['response'];
		}
		else{
			echo '';
		} if($project['Project']['is_admin_suspended']){
					$reason = __l("Admin Suspended");
		}
		?>
  <span class="disabled btn btn-lg btn-info col-xs-12 col-sm-12 col-md-12 no-float tooltiper  js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: %s.'), $reason); ?>"><span class="lead roboto-bold"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span></span>
  <?php
		endif;
	?>
		</div>
	<?php
		}	}
	?>
