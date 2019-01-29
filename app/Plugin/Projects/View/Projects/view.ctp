<?php /* SVN: $Id: view.ctp 2878 2010-08-27 11:07:18Z sakthivel_135at10 $ */ ?>
<?php Configure::write('highperformance.pids', $project['Project']['id']); ?>
<div class="cf-vw-bckr js-project-view" data-project-id="<?php echo $this->Html->cInt($project['Project']['id'], false); ?>">
<?php
	$class = "project-affix-nonregister";
	if ($this->Auth->sessionValid()) {
		if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
			$class = "project-affix-user";
		} else {
			$class = "project-affix-admin";
		}
	}
	$projectStatus = array();
	$projectStatus = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
	'projectStatus' => $projectStatus,
	'project' => $project,
	'type'=> 'status'
	));
	if (strlen($project['Project']['name']) > 40) {
		$class .= ' title-double-line';
	}
?>
	<section class="list-group-item-text list-group-item-heading bg-clor-gray" itemtype="http://schema.org/Person" itemscope>
		<div class="container">
			<?php //echo $this->Html->getUserAvatar($project['User'], 'normal_thumb', true,'','no-span'); ?>
			<h3 class="h2 text-center roboto-bold marg-top-50" itemprop="headline">
				<?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), array('escape' => false,'title'=>$this->Html->cText($project['Project']['name'], false), 'class' => 'clr-black'));?>
			</h3>
			<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				<div class="alppcp hide">
				<div class="dropdown pull-right project-owner-dd settings-dropdown">
					<a href="#" class="btn dropdown-toggle js-no-pjax js-tooltip tooltiper" data-toggle="dropdown" title = "<?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?>"><i class="fa fa-cog"></i><span class="hide"><?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?></span> <span class="caret"></span></a>
					<ul class="list-unstyled dropdown-menu text-left clearfix">
						<li>
						<h4 class="ver-space"><strong><?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?></strong></h4>
						</li>
						<?php if($project['Project']['is_draft'] || !empty($projectStatus->data['is_allow_to_edit_fund'])): ?>
						<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id']), array('class' => 'edit js-edit js-no-pjax', 'title' => __l('Edit'),'escape'=>false)); ?></li>
						<?php endif; ?>
						<?php if (isPluginEnabled('ProjectUpdates')) { ?>
						<li class="tab">
						<?php
						if(!empty($project['Project']['feed_url'])):
						echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Updates'), array('controller'=>'projects','action'=>'view',$project['Project']['slug'].'#updates'),array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Updates'), 'rel' => '#updates', 'escape' => false));
						else:
						echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Updates'), array('controller'=>'projects','action'=>'view', $project['Project']['slug'].'/#updates'),array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Updates'), 'rel' => '#updates', 'escape' => false));
						endif;
						?>
						</li>
						<li>
						<?php
						if (empty($project['Project']['feed_url'])):
						echo $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i>'.__l('Add Update'), array('controller' => 'blogs', 'action' => 'add', 'project_id' => $project['Project']['id']),array('class' => 'add js-no-pjax', 'data-target' => "#js-ajax", 'data-toggle' => "modal", 'escape'=>false,'title' => __l('Add Update')));
						endif;
						?>
						</li>
						<?php } ?>
						<?php if (!empty($project['Project']['facebook_feed_url']) || !empty($project['Project']['twitter_feed_url'])): ?>
						<li class="social-feeds tab"> <?php echo $this->Html->link('<i class="fa fa-tint fa-fw"></i>'.__l('Stream'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#social_feeds'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Stream'), 'rel' => 'address:/social_feeds', 'escape' => false)); ?> </li>
						<?php endif; ?>
						<?php if (isPluginEnabled('Idea') && (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote']))):?>
						<li class="tab"><?php echo $this->Html->link('<i class="fa fa-star-o fa-fw"></i>'.__l('Voters'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#voters'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Votings'), 'rel' => '#voters', 'escape' => false)); ?></li>
						<?php endif;?>
						<?php
						if (empty($projectStatus->data['is_allow_to_vote'])):
						?>
						<?php if ($project['Project']['project_type_id'] == ConstProjectTypes::Donate) { ?>
						<li class="tab"><?php echo $this->Html->link($this->Html->image('donate-icon.png', array('width' => 15, 'height' => 15)).' '.Configure::read('project.alt_name_for_donor_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_donor_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
						<?php } else if ($project['Project']['project_type_id'] == ConstProjectTypes::Lend) { ?>
						<li class="tab"><?php echo $this->Html->link($this->Html->image('lend-hand.png', array('width' => 15, 'height' => 15)).' '.Configure::read('project.alt_name_for_lender_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_lender_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
						<?php }else if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) { ?>
						<li class="tab"><?php echo $this->Html->link($this->Html->image('equity-hand.png', array('width' => 15, 'height' => 15)).' '. Configure::read('project.alt_name_for_investor_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_investor_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
						<?php } else { ?>
						<li class="tab"><?php echo $this->Html->link('<span class="right-mspace-xs">'.$this->Html->image('pledge-projects.png', array('width' => 13, 'height' => 13)).'</span>'.' '.Configure::read('project.alt_name_for_backer_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'panel-link js-no-pjax js-tab-show-onclick', 'title' =>  Configure::read('project.alt_name_for_backer_plural_caps'),'rel' => '#backers',  'escape' => false)); ?></li>
						<?php } ?>
						<?php
						endif;
						?>
						<?php if(isPluginEnabled('ProjectFollowers')): ?>
						<li class="tab"><?php echo $this->Html->link('<i class="fa fa-users fa-fw"></i>'.__l('Followers'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#followers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Followers'), 'rel' => '#followers', 'escape' => false)); ?></li>
						<?php endif; ?>
						<?php if (Configure::read('Project.is_allow_owner_project_cancel') and !empty($projectStatus->data['is_allow_to_cancel_project'])) : ?>
						<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Cancel'), array('controller' => 'projects', 'action' => 'cancel', $project['Project']['id']), array('class' => 'edit js-confirm cancel js-no-pjax', 'title' => __l('Cancel'), 'escape'=>false)); ?></li>
						<?php endif; ?>
						<?php  if (!empty($project['ProjectReward']) && !empty($projectStatus->data['is_allow_to_mange_reward'])): ?>
						<li><?php echo $this->Html->link('<i class="fa fa-gift fa-fw"></i>'. sprintf(__l('Manage %s'), Configure::read('project.alt_name_for_reward_plural_caps')), array('controller'=>'project_funds','action'=>'index', 'project_id'=>$project['Project']['id'],'type'=>'manage'), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax','id'=>'', 'escape' => false, 'title' => sprintf(__l('Manage %s'), Configure::read('project.alt_name_for_reward_plural_caps')))); ?></li>
						<?php endif; ?>
						<?php if (!empty($projectStatus->data['is_allow_to_share']) && isPluginEnabled('SocialMarketing')): ?>
						<li><?php	echo $this->Html->link('<i class="fa fa-share fa-fw"></i>'.__l('Share'), array('controller'=>'social_marketings','action'=>'publish', $project['Project']['id'],'type'=>'facebook', 'publish_action' => 'add'), array('class' => 'js-no-pjax', 'title' => __l('Share'),'escape'=>false)); ?></li>
						<?php endif; ?>
					</ul>
				</div>
				</div>
		<?php } else {
				if($project['Project']['user_id'] == $this->Auth->user('id')) :
		?>
					<div class="dropdown pull-right settings-dropdown project-owner-dd">
						<a href="#" class="btn dropdown-toggle js-no-pjax js-tooltip tooltiper" data-toggle="dropdown" title = "<?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?>">
							<i class="fa fa-cog"></i><span class="hide"><?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?></span> <span class="caret"></span>
						</a>
						<ul class="list-unstyled dropdown-menu text-left clearfix">
							<li>
							<h4 class="ver-space"><strong><?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?></strong></h4>
							</li>
							<?php if($project['Project']['is_draft'] || !empty($projectStatus->data['is_allow_to_edit_fund'])): ?>
							<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id']), array('class' => 'edit js-edit js-no-pjax', 'title' => __l('Edit'),'escape'=>false)); ?></li>
							<?php endif; ?>
							<?php if (isPluginEnabled('ProjectUpdates')) { ?>
							<li class="tab">
							<?php
							if(!empty($project['Project']['feed_url'])):
							echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Updates'), array('controller'=>'projects','action'=>'view',$project['Project']['slug'].'#updates'),array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Updates'), 'rel' => '#updates', 'escape' => false));
							else:
							echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Updates'), array('controller'=>'projects','action'=>'view', $project['Project']['slug'].'/#updates'),array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Updates'), 'rel' => '#updates', 'escape' => false));
							endif;
							?>
							</li>
							<li>
							<?php
							if (empty($project['Project']['feed_url'])):
							echo $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i>'.__l('Add Update'), array('controller' => 'blogs', 'action' => 'add', 'project_id' => $project['Project']['id']),array('class' => 'add js-no-pjax', 'data-target' => "#js-ajax", 'data-toggle' => "modal", 'escape'=>false,'title' => __l('Add Update')));
							endif;
							?>
							</li>
							<?php } ?>
							<?php if (!empty($project['Project']['facebook_feed_url']) || !empty($project['Project']['twitter_feed_url'])): ?>
							<li class="social-feeds tab"> <?php echo $this->Html->link('<i class="fa fa-tint fa-fw"></i>'.__l('Stream'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#social_feeds'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Stream'), 'rel' => 'address:/social_feeds', 'escape' => false)); ?> </li>
							<?php endif; ?>
							<?php if (isPluginEnabled('Idea') && (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote']))):?>
							<li class="tab"><?php echo $this->Html->link('<i class="fa fa-star-o fa-fw"></i>'.__l('Voters'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#voters'), array('class' => 'js-no-pjax panel-link', 'title' =>  __l('Votings'), 'rel' => '#voters', 'escape' => false)); ?></li>
							<?php endif;?>
							<?php
							if (empty($projectStatus->data['is_allow_to_vote'])):
							?>
							<?php if ($project['Project']['project_type_id'] == ConstProjectTypes::Donate) { ?>
							<li class="tab"><?php echo $this->Html->link($this->Html->image('donate-icon.png', array('width' => 15, 'height' => 15)).' '.Configure::read('project.alt_name_for_donor_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_donor_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
							<?php } else if ($project['Project']['project_type_id'] == ConstProjectTypes::Lend) { ?>
							<li class="tab"><?php echo $this->Html->link($this->Html->image('lend-hand.png', array('width' => 15, 'height' => 15)).' '.Configure::read('project.alt_name_for_lender_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_lender_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
							<?php }else if ($project['Project']['project_type_id'] == ConstProjectTypes::Equity) { ?>
							<li class="tab"><?php echo $this->Html->link($this->Html->image('equity-hand.png', array('width' => 15, 'height' => 15)).' '. Configure::read('project.alt_name_for_investor_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' => Configure::read('project.alt_name_for_investor_plural_caps'), 'rel' => '#backers', 'escape' => false)); ?></li>
							<?php } else { ?>
							<li class="tab"><?php echo $this->Html->link('<span class="right-mspace-xs">'.$this->Html->image('pledge-projects.png', array('width' => 13, 'height' => 13)).'</span>'.' '.Configure::read('project.alt_name_for_backer_plural_caps'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#backers'), array('class' => 'panel-link js-no-pjax js-tab-show-onclick', 'title' =>  Configure::read('project.alt_name_for_backer_plural_caps'),'rel' => '#backers',  'escape' => false)); ?></li>
							<?php } ?>
							<?php
							endif;
							?>
							<?php if(isPluginEnabled('ProjectFollowers')): ?>
							<li class="tab"><?php echo $this->Html->link('<i class="fa fa-users fa-fw"></i>'.__l('Followers'), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'].'#followers'), array('class' => 'js-no-pjax panel-link js-tab-show-onclick', 'title' =>  __l('Followers'), 'rel' => '#followers', 'escape' => false)); ?></li>
							<?php endif; ?>
							<?php if (Configure::read('Project.is_allow_owner_project_cancel') and !empty($projectStatus->data['is_allow_to_cancel_project'])) : ?>
							<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Cancel'), array('controller' => 'projects', 'action' => 'cancel', $project['Project']['id']), array('class' => 'edit js-confirm cancel js-no-pjax', 'title' => __l('Cancel'), 'escape'=>false)); ?></li>
							<?php endif; ?>
							<?php  if (!empty($project['ProjectReward']) && !empty($projectStatus->data['is_allow_to_mange_reward'])): ?>
							<li><?php echo $this->Html->link('<i class="fa fa-gift fa-fw"></i>'. sprintf(__l('Manage %s'), Configure::read('project.alt_name_for_reward_plural_caps')), array('controller'=>'project_funds','action'=>'index', 'project_id'=>$project['Project']['id'],'type'=>'manage'), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax','id'=>'', 'escape' => false, 'title' => sprintf(__l('Manage %s'), Configure::read('project.alt_name_for_reward_plural_caps')))); ?></li>
							<?php endif; ?>
							<?php if (!empty($projectStatus->data['is_allow_to_share']) && isPluginEnabled('SocialMarketing')): ?>
							<li><?php	echo $this->Html->link('<i class="fa fa-share fa-fw"></i>'.__l('Share'), array('controller'=>'social_marketings','action'=>'publish', $project['Project']['id'],'type'=>'facebook', 'publish_action' => 'add'), array('class' => 'js-no-pjax', 'title' => __l('Share'),'escape'=>false)); ?></li>
							<?php endif; ?>
						</ul>
					</div>
			<?php endif;
				} 
			?>
		<div class="marg-btom-20">
			<p class="panel-title text-center roboto-regular" itemprop="containedIn"> 
				<?php echo __l('A') . ' '; ?>
				<span class="roboto-bold">
					<?php
						$response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
						'data' => $project
						));
						if (!empty($response->data['content'])) {
							echo $response->data['content'];
						}
					?>
				</span>
				<?php echo sprintf(__l('%s in '), Configure::read('project.alt_name_for_project_singular_small')) . ' '; ?>
				<?php
				if (!empty($project['City']['name'])) {
					echo $this->Html->cText($project['City']['name'], false) . ', ';
				}
				if (!empty($project['Country']['name'])) {
					echo $this->Html->cText($project['Country']['name'], false);
				}
				?>
				<?php echo __l(' by '); ?>
				<span class="roboto-bold">
					<?php echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users', 'action' => 'view', $project['User']['username']), array('title' => $project['User']['username'], 'escape' => false));?>
				</span>
				<?php
				if ($project['User']['id'] !=  $this->Auth->user('id')) {
					if($this->Auth->user('id')) {
						echo $this->Html->link('<span class="text-info marg-left-10 "><i class="fa fa-envelope-o fa-fw"></i>'.__l(' Send message') . '</span>', array('controller' => 'projects', 'action' => 'view',$project['Project']['slug'] . '#comments'), array('class' => 'js-send-message js-no-pjax send-mesg js-tab-show-onclick', 'rel' => '#comments', 'escape' => false,'title'=>__l('send message')));
					} else {
						echo $this->Html->link('<span class="text-info marg-left-10 "><i class="fa fa-envelope-o fa-fw"></i>'.__l(' Send message') . '</span>', array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('escape' => false, 'class' => 'js-no-pjax send-mesg','title'=>__l('send message')));
					}
				}
				?>
			</p>
		</div>
		<?php
		$image_url = getImageUrl('Project',$project['Attachment'], array('full_url' => true, 'dimension' => 'big_thumb'));
		$project_url = Router::url(array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), true);
		$project_title = htmlentities($project['Project']['name'], ENT_QUOTES);
		$project_id = $project['Project']['id'];
		?>
		<div class="row navbar-btn">
			<div class="col-sm-7">
				<div class="navbar-btn">
					<?php if (!empty($project['Project']['video_embed_url'])): 
							if ($this->Embed->parseUrl($project['Project']['video_embed_url'])) {
							$params = $this->Embed->getObjectParams();
							$attr = $this->Embed->getObjectAttrib();
							?>
								<div class="video-player {'url':'<?php echo $this->Html->cText($params['movie'], false);?>','wmode':'transparent','pluginspage':'<?php echo $params['pluginspage'];?>','height':'<?php echo $attr['height'];?>','width':'<?php echo $attr['width'];?>'}">                       
								<div class="col-xs-12">
									<a href='#' class="js-play-video js-no-pjax"> 
										<span> <?php echo $this->Html->showImage('Project',$project['Attachment'],array('dimension' => 'very_big_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($project['Project']['name'], false)), 'class' => 'img-responsive center-block', 'title' => $this->Html->cText($project['Project']['name'], false))); ?> </span>
									</a>
									<div class="panel-hover">
										<div class="panel-data">
											<div class="panel-cell">
												<div class="text-center">
													<a href="#" title="<?php echo __l('Play');?>" class="js-tooltip js-play-video js-no-pjax"><i class="fa fa-play text-info fa-4x"></i> </a>
										 		</div>
										   </div>
									   </div>
								   </div>
							</div>	
						</div>
							<?php }else { 
							echo $this->Html->showImage('Project',$project['Attachment'],array('dimension' => 'very_big_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($project['Project']['name'], false)), 'class' => 'img-responsive center-block', 'title' => $this->Html->cText($project['Project']['name'], false))); 
							}
						else: 
							echo $this->Html->showImage('Project',$project['Attachment'],array('dimension' => 'very_big_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($project['Project']['name'], false)), 'class' => 'img-responsive center-block', 'title' => $this->Html->cText($project['Project']['name'], false))); ?>
					<?php endif; ?>
				</div>
				<ul class="list-inline navbar-btn">
					<li class="text-default navbar-btn h4 no-float txt-center-mbl">
						<p>
							<?php
							$response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
							'data' => $project
							));
							?>
							<i class="fa fa-tag fa-fw"></i>
							<?php echo $response->data['content'];?>
						</p>
					</li>
					<li class="text-default navbar-btn h4 no-float txt-center-mbl">
						<p>
							<i class="fa fa-map-marker fa-fw"></i>
							<?php
							if (!empty($project['City']['name'])) {
								$country_name = !empty($project['Country']['name'])?', '.$project['Country']['name']:'';
								echo $this->Html->link($this->Html->cText($project['City']['name'].$country_name, false) , array('controller' => 'projects', 'action' => 'index', 'city' => $project['City']['slug'], 'type' => 'home'), array('title' => $project['City']['name'], 'class' => 'panel-title clr-gray roboto-bold'));
							}
							?>
						</p>
					</li>
					<li class="pull-right navbar-btn no-float txt-center-mbl roboto-light">
						<p>
							<?php
								if(isPluginEnabled('ProjectFlags')){
								if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {?>
								<div class="aurp aurp-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide">
								<?php
									echo $this->Html->link('<i class="fa fa-flag fa-fw clr-gray"></i><span class="text-info">  ' . sprintf(__l('Report %s') . '</span>', Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_flags', 'action' => 'add', $project['Project']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax panel-title clr-gray roboto-light','id'=>'', 'escape' => false, 'title' => sprintf(__l('Report %s'), Configure::read('project.alt_name_for_project_singular_caps'))));
								?>
								</div>
								<div class="burp hide">
								<?php
								echo $this->Html->link('<i class="fa fa-flag fa-fw clr-gray"></i><span class="text-info"> '. sprintf(__l('Report %s') . '</span>', Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array( 'title' => sprintf(__l('Report %s'), Configure::read('project.alt_name_for_project_singular_caps')),  'escape'=>false, 'class' => 'report panel-title clr-gray roboto-light'));
								?>
								</div>
								<?php } else { ?>
								<?php
								if ($this->Auth->sessionValid()):
								if($project['Project']['user_id'] != $this->Auth->user('id')) :
								echo $this->Html->link('<i class="fa fa-flag fa-fw clr-gray"></i><span class="text-info">  ' . sprintf(__l('Report %s') . '</span>', Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_flags', 'action' => 'add', $project['Project']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax panel-title clr-gray roboto-light','id'=>'', 'escape' => false, 'title' => sprintf(__l('Report %s'), Configure::read('project.alt_name_for_project_singular_caps'))));
								endif;
								else :
								echo $this->Html->link('<i class="fa fa-flag fa-fw clr-gray"></i><span class="text-info"> '. sprintf(__l('Report %s') . '</span>', Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false), array( 'title' => sprintf(__l('Report %s'), Configure::read('project.alt_name_for_project_singular_caps')),  'escape'=>false, 'class' => 'report panel-title clr-gray roboto-light'));
								endif;
								?>
								<?php
								}
								}
							?>
						</p>
					</li>
				</ul>	
				<ul class="list-unstyled">
					<li class="navbar-btn list-group-item-text">
						<p class="h3 list-group-item-heading">
							<span class="panel-title roboto-light">
								<?php echo sprintf(__l('Share this %s with your friends'), Configure::read('project.alt_name_for_project_singular_small')); ?>
							</span>
						</p>
					</li>
					<li class="navbar-btn">	
						<ul class="list-inline embed-share">	
							<li class="no-float">
								<?php echo $this->Html->link('<i class="fa fa-code fa-fw vertical-center font-size-20"></i>'.__l(' Embed'), '#embed_frame', array('data-toggle' => 'modal', 'data-target' => '#embed_frame', 'escape' => false, 'class' => 'js-no-pjax btn btn-lg panel bdr-rad-0 btn-hover-blue txt-lft clr-gray roboto-bold panel-title', 'title' => __l('Embed Code')));?>
							</li>
							<li class="no-float marg-no-mbl">
								<?php 
								if(isset($share_url)){
									echo $this->Html->link('<i class="fa fa-share-alt fa-fw vertical-center font-size-20"></i>'.__l('Share'), $share_url, array('title'=>__l('Share'), 'escape' => false, 'class' => 'btn btn-lg panel bdr-rad-0 btn-hover-blue txt-lft clr-gray roboto-bold panel-title js-bootstrap-tooltip', 'target' => '_blank')); 
								}
								?>
							</li>
						</ul>
							<div class="modal" id="embed_frame">
								<div class="modal-dialog">
									<div class="modal-content clearfix">	
										<div class="modal-header show bg-clor-gray">
											<h2 class="text-25 no-mar"><?php echo __l('Embed Code'); ?></h2>
										</div>
										<div class="col-xs-12 marg-top-20 marg-btom-20">
											<?php
											if (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote'])):
											$height = '520';
											else:
											$height = '480';
											endif;
											$embed_url = Router::url(array('controller' => 'projects', 'action' => 'view', $project['Project']['slug'],  'widget') , true);
											$embed_code = '<iframe src="'.$embed_url.'" width="301" height="' . $height . '" frameborder = "0" scrolling="no"></iframe>';
											echo $this->Form->input('embed_url', array('class' =>'col-md-7 clipboard', 'id' => 'embed_url', 'readonly' => 'readonly', 'type' => 'textarea', 'label' => false, 'value' => $embed_code, 'readonly' => true));
											?>
										</div>
										<div class="modal-footer col-xs-12 bg-clor-gray"> 
											<a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> 
										</div>
									</div>
								</div>
							</div>
						<hr class="hr-2px-drk-gray marg-top-20 marg-btom-5">
					</li>
					<li class="navbar-btn marg-top-30">
						<?php
						if (isPluginEnabled($project['ProjectType']['name'])) {
							echo $this->element('get_project_status',array('project'=>$project),array('plugin'=> $project['ProjectType']['name']));
						}
						?>
					</li>
						<?php
							if(!empty($project['Submission']['SubmissionField'])) :
								$is_mediafile = $is_urls = $is_otherdetails = 0;
								foreach($project['Submission']['SubmissionField'] as $submissionField):
									if(!empty($submissionField['type']) and empty($submissionField['FormField']['depends_on'])):
										if (!empty($submissionField['type']) && $submissionField['type'] == 'file') {
											$is_mediafile=1;
										} elseif (!empty($submissionField['type']) && $submissionField['type'] == 'url') {
											$is_urls=1;
										} else {
											$is_otherdetails=1;
										}
									endif;
								endforeach;
						?>
						<?php if(!empty($is_urls)) { ?>
						<li class="navbar-btn">
							<div class="clearfix share-block">
								<div class="clearfix">
									<div class="clearfix">
										<h5 class="pull-left clearfix"><strong><?php echo sprintf(__l('This %s in other websites'), Configure::read('project.alt_name_for_project_singular_small')); ?></strong></h5>
									</div>
									<ul class="list-inline">
										<?php
											foreach($project['Submission']['SubmissionField'] as $submissionField):
												if (!empty($submissionField['type']) && $submissionField['FormField']['type'] == 'url'):
										?>
										<li class="navbar-btn"><a href="<?php echo $this->Html->cText($submissionField['response'], false); ?>" target="_blank" class="website label label-info" title="<?php echo $this->Html->cText($submissionField['FormField']['label'], false); ?>"><?php echo $this->Html->cText($submissionField['FormField']['label'], false); ?></a></li>
										<?php
												endif;
											endforeach;
										?>
									</ul>
								</div>
							</div>
						</li>
						<?php } ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="col-sm-5">
				<ul class="list-unstyled clearfix pro-view-ul">
					<?php
						if (isPluginEnabled($project['ProjectType']['name'])) {
							echo $this->element('project_fund_details',array('project'=>$project),array('plugin'=> $project['ProjectType']['name']));
						}
					?>
					<li class="navbar-btn row marg-no-mbl follow-drop-dwn">
						<?php
						if (isPluginEnabled($project['ProjectType']['name'])) {
							echo $this->element('project_follow_link', array('follower' => isset($follower)?$follower:"", 'project' => $project), array('plugin' => $project['ProjectType']['name']));
						}
						?>
					</li>
					<li class="navbar-btn">
						<?php
						if (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote'])) {
						$rated_users = array();
						$rating_count = 0;
						?>
						<?php if(isPluginEnabled('Idea')) { ?>
						<?php
						$i = 1;
						$rating_count = 0;
						if (!empty($project['ProjectRating'])):
						$rating_count = count($project['ProjectRating']);
						$extra = $rating_count - 5;
						foreach($project['ProjectRating'] as $projectrating) {
						array_push($rated_users, $projectrating['user_id']);
						}
						endif;
						  } else { 
						 } }
						?>
						<?php if(isPluginEnabled('Idea')) { ?>
						<?php if (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote'])) { ?>
						<?php
						$rate_msg = "";
						if($project['Project']['user_id'] == $this->Auth->user('id')){
						$rate_msg = __l('Disabled. Reason: You can\'t rate your own project.');
						}
						else if(in_array($this->Auth->user('id'),$rated_users))
						{
						$rate_msg = __l('Disabled. Reason: You have already rated this project.');
						}
						$canrate = (!empty($projectStatus->data['is_allow_to_vote']) && $this->Auth->sessionValid() && !in_array($this->Auth->user('id'),$rated_users) && $project['Project']['user_id'] != $this->Auth->user('id')) ? 1 : 0;
						$average_rating =($rating_count !=0)?$project['Project']['total_ratings']/ $rating_count:0;
							echo $this->element('_star-rating', array('project_id' => $project['Project']['id'], 'current_rating' => $average_rating ,'total_rating' => $project['Project']['total_ratings'],'rating_count' => $project['Project']['project_rating_count'], 'canRate' =>$canrate,'is_view'=>1, 'project_type' => $project['ProjectType']['slug'], 'rate_msg' => $rate_msg));
						?>
						<?php } } ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<hr class="hr-2px-drk-gray no-mar">
</section>	
<section>
	<div class="container">
		<div class="row no-mar-xs">
			<!--<div class="col-xs-12" id="ajax-tab-container-project">-->
			<div class="clearfix backer-menu">
				<ul class="list-inline nav navbar-nav nav-tabs tb-menu">
					<li class="active">
						<?php echo $this->Html->link(sprintf(__l('About the %s'), Configure::read('project.alt_name_for_project_singular_caps')), '#project-details',array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none no-margin txt-center-mbl', 'title'=>sprintf(__l('About the %s'), Configure::read('project.alt_name_for_project_singular_caps')), 'aria-controls' => 'About', 'role' => 'tab', 'data-toggle'=>'tab', 'rel' => 'address:/project_details')); ?>
					</li>
					<?php if (isPluginEnabled('ProjectUpdates')) { ?>
					<li>
						<?php
						if(!empty($project['Project']['feed_url'])):
							echo $this->Html->link(__l('Updates') . ' <sup class="badge badge-success clr-black">' . $this->Html->cInt($project['Project']['project_feed_count'], false). '</sup>', '#updates', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' =>  __l('Updates'), 'aria-controls' => 'Updates', 'role' => 'tab', 'data-toggle'=>'tab','escape' => false));
						else:
							echo $this->Html->link(__l('Updates') . '<sup class="badge badge-success clr-black">' . $this->Html->cInt($project['Project']['blog_count'], false).'</sup>',  '#updates', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' =>  __l('Updates'),'aria-controls' => 'Updates', 'role' => 'tab', 'data-toggle'=>'tab', 'escape' => false));
						endif;
						?>
					</li>
					<?php } ?>
					<?php if (!empty($project['Project']['facebook_feed_url']) || !empty($project['Project']['twitter_feed_url'])): ?>
					<li>
						<?php echo $this->Html->link(__l('Stream'), '#social_feeds', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' =>  __l('Stream'), 'aria-controls' => 'social_feeds', 'role' => 'tab', 'data-toggle'=>'tab', 'rel' => 'address:/social_feeds', 'escape' => false)); ?>
					</li>
					<?php endif; ?>		
					<?php if (isPluginEnabled('Idea') && (!empty($projectStatus->data['is_allow_to_vote']) || !empty($projectStatus->data['is_show_vote']))):?>
					<li>
						<?php echo $this->Html->link(__l('Voters').' <sup class="badge badge-danger clr-black">'.$this->Html->cInt($project['Project']['project_rating_count'], false).'</sup>' , '#voters', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' =>  __l('Votings'),'aria-controls' => 'Voters', 'role' => 'tab', 'data-toggle'=>'tab', 'escape' => false)); ?>
					</li>
					<?php endif;?>
					<?php
					if (empty($projectStatus->data['is_allow_to_vote'])):
					?>
					<li>
						<?php echo $this->Html->link(__l(Configure::read('project.alt_name_for_'.$project['ProjectType']['funder_slug'].'_plural_caps')) . ' <sup class="badge badge-warning clr-black">' . $this->Html->cInt($backer, false) . '</sup>', '#backers', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' => __l(Configure::read('project.alt_name_for_'.$project['ProjectType']['funder_slug'].'_plural_caps')),'aria-controls' => 'backers', 'role' => 'tab', 'data-toggle'=>'tab', 'escape' => false)); ?>
					</li>
					<?php
					endif;
					?>
					<?php if(isPluginEnabled('ProjectFollowers')): ?>
					<li>
						<?php echo $this->Html->link(__l('Followers') . '<sup class="badge badge-info clr-black">'.$this->Html->cInt($project['Project']['project_follower_count'], false).'</sup>', '#followers', array('class'=>'js-no-pjax panel-title marg-no-mbl bg-none txt-center-mbl', 'title' =>  __l('Followers'),'aria-controls' => 'followers', 'role' => 'tab', 'data-toggle'=>'tab','escape' => false)); ?>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>   	
	</div>
	<hr class="hr-2px-gray no-mar">
</section>
<section class="navbar-btn">
	<div class="container navbar-btn">
		<div class="row navbar-btn">
			<div class="col-sm-7 col-md-7">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="project-details">		
						
						<div class="" itemtype="http://schema.org/WPHeader" itemscope>
							<div class="navbar-btn">
								<?php if(!empty($project['Project']['description'])): ?>
								<h3 class="navbar-btn font-size-28 txt-center-mbl roboto-bold">
									<?php echo sprintf(__l('About %s'), Configure::read('project.alt_name_for_project_singular_caps'));?>
								</h3>
								<h4 class="h3 txt-center-mbl roboto-bold"><?php echo $this->Html->filterSuspiciousWords($this->Html->cHtml($project['Project']['short_description']), $project['Project']['detected_suspicious_words']);?></h4>
								<div class="h3">
									<p class="panel-title txt-center-mbl roboto-regular" itemprop="description">
										<?php echo $this->Html->filterSuspiciousWords($this->Html->cHtml($project['Project']['description']), $project['Project']['detected_suspicious_words']);?>
									</p>
								</div>
								<?php endif; ?>
							</div>
							<?php if(!empty($is_mediafile) && !empty($project['Submission']['SubmissionField'])): ?>
								<h3 class="navbar-btn h4 txt-center-mbl roboto-bold">
									<?php echo __l('Media and other files');?>
								</h3>
								<?php
								$project_view_class = '';
								if (count($project['Submission']['SubmissionField']) >1) {
									$project_view_class = 'project-view-list';
								}
								?>
								<div class="<?php echo $project_view_class; ?> clearfix">
								<?php 
									$j = 0; $class = ' class="altrow"';
									foreach($project['Submission']['SubmissionField'] as $submissionField):
										if(empty($submissionField['FormField']['depends_on'])):
											$field_type = explode('_',$submissionField['form_field']);
											$div_class= '';
											$div_even = $j % 2;
											if($div_even == 0) {
												$div_class = 'grid_11 ';
											} else {
												$div_class = 'grid_right grid_11';
											}
								?>
									<div class="<?php echo $div_class;?>">
										<div class="description-info">
											<?php if (!empty($submissionField['type']) && $submissionField['type'] == 'file') {?>
												<span>
													<?php 
														if(!empty($submissionField['SubmissionThumb']['mimetype']) && ($submissionField['SubmissionThumb']['mimetype'] == 'image/jpeg' || $submissionField['SubmissionThumb']['mimetype'] == 'image/png' || $submissionField['SubmissionThumb']['mimetype'] == 'image/jpg' || $submissionField['SubmissionThumb']['mimetype'] == 'image/gif')) {
															echo $this->Html->showImage('SubmissionThumb', $submissionField['SubmissionThumb'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'escape' => false));
														} elseif (preg_match('/(\\.wmv|\\.flv|\\.avi)$/', $submissionField['SubmissionThumb']['filename'] )) { ?>
															<i class="fa fa-video-camera"></i>
													<?php } else { ?>
															<i class="fa fa-file"></i>
													<?php }?>
												</span>
												<?php
												if(!empty($depends_on_fields[$submissionField['form_field']])) {
													$depends_array = $depends_on_fields[$submissionField['form_field']];
													foreach($depends_array  as $depends) {
														if($depends['type'] == 'text') {
												?>
															<span><?php echo $this->Html->link($this->Html->cText($depends['response'], false), array('controller' => 'projects', 'action' => 'mediadownload',$project['Project']['slug'],$submissionField['id'],$submissionField['SubmissionThumb']['id']), array('class' => 'download js-tooltip', 'escape' => false,'title'=>"Download - ".$submissionField['SubmissionThumb']['filename']));?></span>
												<?php
														}
													}
												} else {
												?>
													<span><?php echo $this->Html->link($this->Html->cText($submissionField['SubmissionThumb']['filename'], false), array('controller' => 'projects', 'action' => 'mediadownload',$project['Project']['slug'],$submissionField['id'],$submissionField['SubmissionThumb']['id']), array('class' => 'download js-tooltip', 'escape' => false,'title'=>"Download - ".$submissionField['SubmissionThumb']['filename']));?></span>
												<?php	}  ?>
												<div class="pull-right"> </div>											
											<?php } ?>
										</div>
									</div>
								<?php
											$j++;
										endif;
									endforeach;
								?>
								</div>
							<?php endif; ?>
							<?php if(!empty($is_otherdetails) && !empty($project['Submission']['SubmissionField'])): ?>
								<h3 class="navbar-btn h4 txt-center-mbl roboto-bold">
									<?php echo __l("Other Details");?>
								</h3>
								<?php
								$project_view_class = '';
								if (count($project['Submission']['SubmissionField']) >1) {
									$project_view_class = 'project-view-list';
								}
								?>
								<div class="<?php echo $project_view_class; ?> clearfix">
									<dl class="clearfix">
									<?php 
										$j = 0; $class = ' class="altrow"';
										foreach($project['Submission']['SubmissionField'] as $submissionField):
											if(empty($submissionField['FormField']['depends_on'])):
												$field_type = explode('_',$submissionField['form_field']);
												$div_class= '';
												$div_even = $j % 2;
												if($div_even == 0) {
													$div_class = 'grid_11 ';
												} else {
													$div_class = 'grid_right grid_11';
												}
												$_form_field = '';
												$_form_field_info = '';
												if (!empty($submissionField['type']) && $submissionField['type'] != 'file' && $submissionField['type'] != 'url'):
													$_form_field = (!empty($submissionFieldDisplay[$submissionField['form_field']])) ? $this->Html->cText(Inflector::humanize(str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $submissionFieldDisplay[$submissionField['form_field']]))) : '';
													$_form_field_info = (!empty($submissionFieldDisplay[$submissionField['form_field']])) ? $this->Html->cText(Inflector::humanize(str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $submissionFieldDisplay[$submissionField['form_field']])), false) : '';
												endif;
									?>
												<dt class="text-left" title="<?php echo $_form_field_info ;?>">
													<?php echo $_form_field;?>
												</dt>
												<dd class="description-info">
													<?php 
														if(!empty($submissionField['type']) && $submissionField['type'] != 'file' && $submissionField['type'] != 'url'){
															if (!empty($submissionField['type']) && $submissionField['type'] != 'thumbnail' && empty($submissionField['response'])) {
																echo __l('None specified');
															} else {
																if(!empty($submissionField['type']) && $submissionField['type'] == 'video') {
																	if ($this->Embed->parseUrl($submissionField['response'])) {
																		$this->Embed->setObjectAttrib('wmode','transparent');
																		$this->Embed->setObjectParam('wmode', 'transparent');
																		echo $this->Embed->getEmbedCode();
																	}
																} elseif(!empty($submissionField['type']) && $submissionField['type'] == 'thumbnail') {
																	if (empty($submissionField['ProjectCloneThumb'])){
																		echo __l('None specified');
																	} else {
																		$regex = '/(?<!href=["\'])http:\/\//';
																		$regex1 = '/(?<!href=["\'])https:\/\//';
																		$display_url = preg_replace($regex, '', $submissionField['response']);
																		$display_url = preg_replace($regex1, '', $display_url);
													?>
																		<div class="clone-block">
																			<?php echo $this->Html->link($this->Html->showImage('ProjectCloneThumb', $submissionField['ProjectCloneThumb'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false), 'escape' => false)), $submissionField['response'], array('target'=>'_blank','escape' => false)); ?>
																			<p><?php echo $this->Html->link($display_url,$submissionField['response'], array('target'=>'_blank','escape' => false));?></p>
																		</div>
													<?php
																	}
																} elseif (!empty($submissionField['type']) && $submissionField['type'] == 'date') {
																	$convert_date = explode("\n", $submissionField['response']);
																	if (count($convert_date) > 1):
																		$dateval = $convert_date[2].'-'.$convert_date[0].'-'.$convert_date[1];
																		echo $this->Html->cDate($dateval);
																	endif;
																} elseif (!empty($submissionField['type']) && $submissionField['type'] == 'datetime') {
																	$convert_date = explode("\n", $submissionField['response']);
																	if (count($convert_date) > 5):
																		$dateval = $convert_date[2].'-'.$convert_date[0].'-'.$convert_date[1].' '.$convert_date[3].':'.$convert_date[4].' '.$convert_date[5];
																		echo $this->Html->cDateTime($dateval);
																	endif;
																} elseif (!empty($submissionField['type']) && $submissionField['type'] == 'time') {
																	$convert_date = explode("\n", $submissionField['response']);
																	if (count($convert_date) > 1):
																		$dateval = $convert_date[0].':'.$convert_date[1].' '.$convert_date[2];
																		echo $this->Html->cTime($dateval);
																	endif;
																} elseif (!empty($submissionField['type']) && $submissionField['type'] == 'checkbox' || $submissionField['type'] == 'multiselect') {
																	$convert_val = explode("\n", $submissionField['response']);
																	$textval = implode("<br/>", $convert_val);
																	echo $this->Html->cHtml($textval);
																}  elseif (!empty($submissionField['type']) && $submissionField['type'] == 'slider') {
																	if (!empty($submissionFieldOption[$submissionField['form_field']])) {
																		$option_val = explode(',', $submissionFieldOption[$submissionField['form_field']]);
													?>
																		<div class="clearfix"> 
																			<span class="grid_left">
																				<?php echo trim($option_val[0]); ?>
																			</span>
																			<div class="ui-slider grid_left ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" role="application"> 
																				<span title="<?php echo $this->Html->cText($submissionField['response'], false); ?>%" style="left: <?php echo $submissionField['response'] - 5; ?>%;"></span> 
																				<span style="width: <?php echo $this->Html->cText($submissionField['response'], false); ?>%;" class="ui-slider-handle ui-state-default ui-corner-all" aria-valuetext="<?php echo $this->Html->cText($submissionField['response'], false); ?>" aria-valuenow="<?php echo $this->Html->cText($submissionField['response'], false); ?>" aria-valuemax="99" aria-valuemin="0" aria-labelledby="undefined" role="slider" tabindex="0"  style="" title="<?php echo $this->Html->cText($submissionField['response'], false); ?>%"></span>
																			</div>
																			<span class="grid_left"><?php echo trim($option_val[1]); ?></span>
																		</div>
													<?php
																	}
																} elseif(!empty($submissionField['type']) && $submissionField['type'] == 'url') {
																	$url_string = $submissionField['response'];
																	$find_string   = 'http';
																	$return = strpos($url_string, $find_string);
																	if ($return === false) {
													?>
																		<a href="http://<?php echo $this->Html->cText($submissionField['response'], false); ?>" target = "_blank" > <?php echo $this->Html->cText($submissionField['response'],false);?></a>
													<?php
																	} else {
																		echo $this->Html->link($submissionField['response'],$submissionField['response'], array('target'=>'_blank','escape' => false));
																	}
																} else {
																	echo $this->Html->cText($submissionField['response'], false);
																}
															}
														}
													?>
												</dd>
									<?php
												$j++;
											endif;
										endforeach;
									?>
									</dl>
							</div>
						<?php 
							endif; 
							if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  {  
						?>
								<div class="alpc {'pid':'<?php echo Configure::read('highperformance.pids'); ?>'}">
								</div>
						<?php } else {?>
							<?php  if(Configure::read('Project.is_fb_project_comment_enabled')){?>
								<div class="main-section" id="comments">
									<h3 class="navbar-btn h4 txt-center-mbl roboto-bold">
										<?php echo __l('Comments');?>
									</h3>
									<div id="js-comment-section">
										<?php
											$comment_code = Configure::read('Project.comment_code');
											echo strtr($comment_code,array(
											'##APPID##' => Configure::read('facebook.app_id'),
											'##URL##' =>Router::url(array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), true),
											));
										?>
									</div>
								</div>
							<?php } else { ?>
								<?php echo $this->element('Projects.message-discussions',array('project_id'=>$project['Project']['id'], 'cache' => array('config' => 'sec'))); ?>
									<div id="comments">
										<?php 
										if (!empty($is_comment_allow) && $this->Auth->user('id')) {
											echo $this->element('Projects.message-compose',array('user'=>$project['User']['username'],'project' => $project['Project'],'projecttype_slug' => $project['ProjectType']['slug'], 'funded_id' => !empty($this->request->params['named']['funded_id'])?$this->request->params['named']['funded_id']:'', 'cache' => array('config' => 'sec')));
										}
										?>
									</div>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
					<?php if (isPluginEnabled('ProjectUpdates')) { ?>
					<div id="updates" role="tabpanel" class="tab-pane fade update-tab">
						<?php 
							//request action added to load external link data in tab
							if(!empty($project['Project']['feed_url'])):
								 echo $this->requestAction(array('controller' => 'project_feeds', 'action' => 'index'), array('pass' => array('0' => $project['Project']['id']), 'return')); 
							else:
								 echo $this->requestAction(array('controller' => 'blogs', 'action' => 'index'), array('named' => array('project_id' => $project['Project']['id']), 'return')); 
							endif;
						?>
					</div>
					<?php } ?>
					
					<div id="<?php if (!empty($project['Project']['facebook_feed_url']) || Configure::read('Project.is_fb_project_comment_enabled')){ echo 'js-comment-activity-section'; } else { echo 'facebook-comments'; } ?>" data-fb_app_id="<?php echo Configure::read('facebook.app_id'); ?>" data-add_url="<?php echo Router::url(array('controller'=>'facebook_comments','action'=>'add'),true); ?>" data-delete_url="<?php echo Router::url(array('controller'=>'facebook_comments','action'=>'remove'),true); ?>/id:"></div>
					<?php if (!empty($project['Project']['facebook_feed_url']) || !empty($project['Project']['twitter_feed_url'])): ?>
					
					<div class="tab-pane fade" id="social_feeds" class="show">
						<h3>
							<?php echo __l('Stream');?>
						</h3>
						<?php if (!empty($project['Project']['facebook_feed_url'])): ?>
							<div class="facebook-block col-md-3 clearfix" id="js-activity-section">
								<fb:activity site="<?php echo $this->Html->cText($project['Project']['facebook_feed_url'], false); ?>" width="225" height="300" header="false" recommendations="false"></fb:activity>
								<div id="fb-root"></div>
							</div>
						<?php endif; ?>
						<?php if (!empty($project['Project']['twitter_feed_url'])): ?>
							<div class="col-md-3">
								<?php $feed_username = $project['Project']['twitter_feed_url']; ?>
								<div id="twtr-widget"></div>
								<!--<script src="//widgets.twimg.com/j/2/widget.js"></script>
								<script>
								new TWTR.Widget({ version: 2, type: 'profile', rpp: 4, interval: 6000, width: 250, height: 300, id: 'twtr-widget', theme: { shell: { background: '#8ec1da', color: '#ffffff'}, tweets: {background: '#ffffff', color: '#444444', links: '#1985b5'}}, features: { scrollbar: false, loop: false, live: false, hashtags: true, timestamp: true, avatars: false, behavior: 'all' }}).render().setUser('<?php //echo $this->Html->cText($feed_username, false); ?>').start(); </script>-->
								<script>
								$(function() {
									 $.getScript('http://widgets.twimg.com/j/2/widget.js', function () {
										new TWTR.Widget({ version: 2, type: 'profile', rpp: 4, interval: 6000, width: 250, height: 300, id: 'twtr-widget', theme: { shell: { background: '#8ec1da', color: '#ffffff'}, tweets: {background: '#ffffff', color: '#444444', links: '#1985b5'}}, features: { scrollbar: false, loop: false, live: false, hashtags: true, timestamp: true, avatars: false, behavior: 'all' }}).render().setUser('<?php echo $this->Html->cText($feed_username, false); ?>').start();
									 });
								}); 
								</script>
							</div>
						<?php endif; ?> &nbsp;
					</div>
					<?php endif; ?>
					<?php if (isPluginEnabled('Idea')):?>
					<div class="tab-pane fade" id="voters" class="show">
						<?php
							//request action added to load external link data in tab
							echo $this->requestAction(array('controller' => 'project_ratings', 'action' => 'index'), array('named' => array('project_id' => $project['Project']['id']), 'return')); 
						?>
					</div>
					<?php endif;?>
					<?php if (empty($projectStatus->data['is_allow_to_vote'])): ?>
					<div class="tab-pane fade" id="backers" class="show">
						<?php 
							//request action added to load external link data in tab
							echo $this->requestAction(array('controller' => 'project_funds', 'action' => 'index'), array('named' => array('project_id' => $project['Project']['id']), 'return')); 
						?>
					</div>
					<?php endif; ?>
					<?php  if (isPluginEnabled('ProjectFollowers')) { ?>
					<div class="tab-pane fade" id="followers" class="show">
						<?php
							//request action added to load external link data in tab
							echo $this->requestAction(array('controller' => 'project_followers', 'action' => 'index'), array('pass' => array('0' => $project['Project']['id']), 'return')); 
						?>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-5">
				<div class="col-md-10 recent-act">
					<?php echo $this->element('project-activities', array('project_id' => $project['Project']['id'], 'project_type'=>$project['Project']['project_type_id'], 'cache' => array('config' => 'sec', 'key' => $project['Project']['id'])));?> 
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
			<div class="modal-footer"><a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
		</div>
	</div>
</div>
<div class="modal fade" id="js-ajax">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body"></div>
			<div class="modal-footer"><a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
		</div>
	</div>
</div>
