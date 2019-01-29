<?php /* SVN: $Id: view.ctp 2888 2010-08-30 10:12:30Z boopathi_026ac09 $ */ ?>
<?php Configure::write('highperformance.uids', $user['User']['id']); ?>
<section id="user-main" class="clearfix container js-user-view" data-user-id="<?php echo $this->Html->cInt($user['User']['id'], false); ?>">
	<div class="user-view user-view-uniqe">
		<div class="clearfix dashboard-view">
			<div class="media col-sm-12 col-md-4 col-lg-5">
				<div class="pull-left">
					<?php echo $this->Html->getUserAvatar($user['User'], 'normal_thumb'); ?>
				</div>
				<div class="media-body">
					<h4>
						<?php
						echo $this->Html->link($this->Html->cText($user['User']['username']), array('controller' => 'users', 'action' => 'view',  $user['User']['username'], 'admin' => false), array('class' => 'span text-info', 'escape' => false, 'title' => $this->Html->cText($user['User']['username'], false)));
						?>
					</h4>
					<?php if (!empty($user['User']['created'])): ?>
					  <p><?php echo '<span><strong>' . __l('Joined') . ':</strong></span> ' . $this->Html->cDateTimeHighlight($user['User']['created']); ?></p>
					<?php endif; ?>
					<?php
					  $location = array();
					  $place = '';
					  if(!empty($user['UserProfile']['first_name']) || !empty($user['UserProfile']['last_name'])){
					  echo '<p><span>' .$this->Html->cText($user['UserProfile']['first_name'], false) .' '. $this->Html->cText($user['UserProfile']['last_name'], false) . '</span></p>';
					  }
					  if (!empty($user['UserProfile']['City']['name'])) :
					  $location[] = $this->Html->cText($user['UserProfile']['City']['name'], false);
					  endif;
					  if (!empty($user['UserProfile']['Country']['name'])) :
					  $location[] = $this->Html->cText($user['UserProfile']['Country']['name'], false);
					  endif;
					  $place = implode(', ', $location);
					?>
					<?php if ($place): ?>
					  <p><span><?php if(!empty($user['UserProfile']['Country']['iso_alpha2'])): ?><span class="flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['UserProfile']['Country']['name'],false); ?>"><?php echo $this->Html->cText($user['UserProfile']['Country']['name'],false); ?></span><?php echo  ' ' . $place; ?><?php endif; ?></span></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<ul class="col-sm-12 clearfix list-inline text-center users-dashboard-ul gray-bg">				
				<li>
					<div><strong class="text-success"><?php echo $this->Html->cInt($project_count, false); ?></strong></div>
					<div><?php echo sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
				</li>
				<?php if (isPluginEnabled('Idea')): ?>
				<li>
					<div><strong class="text-warning"><?php echo $this->Html->cInt($idea_count, false); ?></strong></div>
					<div><?php echo __l('Ideas Posted'); ?></div>
				</li>
				<?php endif; ?>
				<li>
					<div><strong class="text-warning"><?php echo $this->Html->cInt($user['User']['unique_project_fund_count'], false); ?></strong></div>
					<div><?php echo sprintf(__l('%s Funded'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
				</li>
				<li>
					<div><strong class="text-danger"><?php echo $this->Html->cInt($project_following_count, false); ?></strong></div>
					<div><?php echo sprintf(__l('Following %s'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
				</li>
		</ul>
		<div class="col-sm-12">
		<div class="well-lg clearfix thumbnail social-blocks">
					<ul class="list-inline clearfix social-message-block">
						<?php   if (isPluginEnabled('SocialMarketing')) {?>
						<?php if($user['User']['is_facebook_connected']):?>
						<li>
							<span class="btn btn-primary btn-sm"><i class="fa fa-facebook fa-fw"></i></span>
							<span>Facebook </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['fb_friends_count']).' '.__l('Friends');?></strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-primary btn-sm"><i class="fa fa-facebook fa-fw"></i></span>
							<span>Facebook </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
						</li>
						<?php endif;?>
						<?php if($user['User']['is_twitter_connected']):?>
						<li>
							<span class="btn btn-info btn-sm"><i class="fa fa-twitter fa-fw"></i></span>
							<span>Twitter </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['twitter_followers_count']).' '.__l('Followers');?> </strong></div>
						</li>
						<?php else:?>
					   <li>
						   <span class="btn btn-info btn-sm"><i class="fa fa-twitter fa-fw"></i></span>
						   <span>Twitter </span>
						   <div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
					   </li>
						<?php endif;?>
						<?php if($user['User']['is_linkedin_connected']):?>
						<li>
							<span class="btn btn-info btn-sm"><i class="fa fa-linkedin fa-fw"></i></span>
							<span>Linkedin </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['linkedin_contacts_count']).' '.__l('Connections');?> </strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-info btn-sm"><i class="fa fa-linkedin fa-fw"></i></span>
							<span>Linkedin </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
						</li>
						<?php endif;?>
						<?php if($user['User']['is_google_connected']):?>
						<li>
							<span class="btn btn-warning btn-sm"></i><i class="fa fa-google fa-fw"></i></span>
							<span>Google </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['google_contacts_count']);?> <?php echo __l("Contacts");?></strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-warning btn-sm"><i class="fa fa-google fa-fw"></i></span>
							<span>Google </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
						</li>
						<?php endif;?>
						<?php if($user['User']['is_googleplus_connected']):?>
						<li>
							<span class="btn btn-danger btn-sm"><i class="fa fa-google-plus fa-fw"></i></span>
							<span>Google+ </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['googleplus_contacts_count']);?> <?php echo __l("Contacts");?></strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-danger btn-sm"><i class="fa fa-google-plus fa-fw"></i></span>
							<span>Google </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
						</li>
						<?php endif;?>
						<?php if($user['User']['is_yahoo_connected']):?>
						<li>
							<span class="btn btn-success btn-sm"><i class="fa fa-yahoo fa-fw"></i></span>
							<span>Yahoo! </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo $this->Html->cInt($user['User']['yahoo_contacts_count']);?> <?php echo __l("Contacts");?></strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-success btn-sm"><i class="fa fa-yahoo fa-fw"></i></span>
							<span>Yahoo! </span>
							<div class="text-center"><strong class="text-danger h6"> <?php echo __l("(Not connected)");?></strong></div>
						</li>
						<?php endif;?>
						<?php }?>
						<?php if(!empty($user['User']['email'])):?>
						<li>
							<span class="btn btn-danger btn-sm"><i class="fa fa-envelope fa-fw"></i></span>
							<span><?php echo __l('Email');?> </span>
							<div class="text-center"><strong class="text-danger h6">( <?php echo __l('hidden');?> )</strong></div>
						</li>
						<?php else:?>
						<li>
							<span class="btn btn-danger btn-sm"><i class="fa fa-envelope fa-fw"></i></span>
							<span><?php echo __l('Email');?> </span>
							<div class="text-center"><strong>( <?php echo __l('hidden');?> )</strong></div>
						</li>
						<?php endif;?>
					</ul>  
			<div class="text-center follow-send">
			<?php if(isPluginEnabled('SocialMarketing')){
				if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {?>
					<div class="alu-f-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide right-mspace"><?php //after login user follow ?>
						<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'user_followers', 'action' => 'add',$user['User']['username']), array('class' => 'btn btn-info btn-sm js-add-remove-followers js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
					</div>
					<div class="alou-f-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"> <?php //after login own user follow ?>
						<span class="btn btn-default btn-sm disabled js-tooltip js-no-pjax" title="<?php echo __l('Disabled. Reason: You can\'t follow your own profile.'); ?>">
						<?php  echo __l('Follow'); ?>
						</span>
					</div>
					<div class="blu-f-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"> <?php //before login  user follow ?>
						<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('class' => 'btn btn-info btn-sm js-add-remove-followers js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
					</div>
					<?php
							$userfollower_id ='';
								if(!empty($user['UserFollower'][0]['id'])) { $userfollower_id=$user['UserFollower'][0]['id'];} ?>
					<div class="alu-uf-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"> <?php //after login  user unfollow ?>
						<?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'user_followers', 'action' => 'delete', $userfollower_id),array('class'=>"btn btn-sm btn-default js-add-remove-followers js-tooltip js-unfollow js-no-pjax",'escape' => false, 'title'=>__l('Unfollow'))); ?>
					</div>
			<?php } else {

				 if(empty($user['UserFollower'])){
				  if($this->Auth->user('id')): ?>
					<?php if($user['User']['username'] == $this->Auth->user('username')): ?>
							<span class="btn btn-info btn-sm navbar-btn disabled js-tooltip js-no-pjax" title="<?php echo __l('Disabled. Reason: You can\'t follow your own profile.'); ?>">
							<?php  echo __l('Follow'); ?>
							</span>
					<?php else: ?>
						<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'user_followers', 'action' => 'add',$user['User']['username']), array('class' => 'btn btn-info mspace btn-sm js-add-remove-followers js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('class' => 'btn btn-info btn-sm js-add-remove-followers js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
				  <?php endif; ?>
				  <?php }else{ ?>
			<?php if($user['User']['username'] == $this->Auth->user('username')): ?>
			<span class="btn btn-info btn-sm">
			<?php  echo __l('Unfollow'); ?>
			</span>
			<?php endif; ?>
				  <?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'user_followers', 'action' => 'delete', $user['UserFollower'][0]['id']),array('class'=>"btn btn-sm btn-info js-add-remove-followers js-tooltip js-unfollow js-no-pjax",'escape' => false, 'title'=>__l('Unfollow')));
					}
				 }
			}
			  ?>
		  <?php
		  if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {?>
					<div class="alu-sm-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"><?php //after login user follow ?>
						 <?php echo $this->Html->link(__l('Send Message'), array('controller' => 'messages', 'action' => 'compose', 'type'=> 'contact','to' => $user['User']['username']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'btn btn-success btn-sm js-colorbox js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Send Message'))); ?>
					</div>
					<div class="alou-sm-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"> <?php //after login own user follow ?>
						<span class="btn btn-success btn-sm disabled js-tooltip js-no-pjax" title="<?php echo __l('Disabled. Reason: You can\'t send message to you.'); ?>">
						<?php  echo __l('Send Message'); ?>
						</span>
					</div>
					<div class="blu-sm-<?php echo $this->Html->cInt($user['User']['id'], false);?> pull-left hide"> <?php //before login  user follow ?>
						<?php echo $this->Html->link(__l('Send Message'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('escape' => false,'class' => 'btn btn-sm btn-success js-tooltip js-no-pjax ver-mspace', 'title'=>__l('Send Message')));?>
					</div>
		  <?php } else {
			  if($this->Auth->user('id')): ?>
				  <?php if($user['User']['username'] == $this->Auth->user('username')): ?>
						<span class="btn btn-success btn-sm disabled js-tooltip" title="<?php echo __l('Disabled. Reason: You can\'t send message to you.'); ?>">
						<?php  echo __l('Send Message'); ?>
						</span>
					<?php else: ?>
						 <?php echo $this->Html->link(__l('Send Message'), array('controller' => 'messages', 'action' => 'compose', 'type'=> 'contact','to' => $user['User']['username']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'btn btn-sm btn-success js-colorbox mspace js-tooltip js-no-pjax', 'escape' => false,'title'=>__l('Send Message')));
					endif;
			  else:
				echo $this->Html->link(__l('Send Message'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('escape' => false,'class' => 'btn btn-sm btn-success js-tooltip js-no-pjax', 'title'=>__l('Send Message')));
			  endif;
		  }
		  ?>
		  </div>   
		</div>
		</div>
		<section class="clearfix user-view-projects marg-top-30">
			<div id="ajax-tab-container-user" class="tab-container js-user-tabs">
			<ul class="col-lg-9 list-inline clearfix tab-buttons text-center">
			  <li>
			  <?php echo $this->Html->link('<span class="show"><i class="fa fa fa-check-square-o"> </i></span>'.__l('Activities'), array('controller' => 'messages', 'action' => 'activities', 'user_id' => $user['User']['id'], 'display' => 'user_view'),array('class' => 'js-no-pjax', 'title' =>  __l('Activities'), 'data-target' => '#activity', 'escape' => false));?>					
			  </li>
			  <li><?php echo $this->Html->link('<span class="show"><i class="fa fa-credit-card"> </i></span>'.sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps')) . ' (' . $this->Html->cInt($project_count, false). ')', array('controller' => 'projects', 'action' => 'index', 'type' => 'userview', 'cat' => 'myprojects', 'user' => $user['User']['id'], 'limit' => 8),array('class' => 'js-no-pjax', 'title'=>sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps')),'data-target'=>'#project_posted','escape' => false)); ?></li>
			  <?php if (isPluginEnabled('Idea')): ?>
			  <li><?php echo $this->Html->link('<span class="show"><i class="fa fa-usd"> </i></span>'.__l('Ideas Posted') . ' (' .$this->Html->cInt($idea_count, false). ')', array('controller' => 'projects', 'action' => 'index', 'type' => 'userview', 'cat' => 'ideaproject', 'user' => $user['User']['id'], 'limit' => 8),array('class' => 'js-no-pjax', 'title'=>__l('Ideas Posted'),'data-target'=>'#ideas_posted','escape' => false)); ?></li>
			  <?php endif; ?>
			  <li><?php echo $this->Html->link('<span class="show"><i class="fa fa-arrows-h"> </i></span>'.sprintf(__l('%s Funded'), Configure::read('project.alt_name_for_project_plural_caps')). ' (' .$this->Html->cInt($user['User']['unique_project_fund_count'], false). ')', array('controller' => 'projects', 'action' => 'index', 'type' => 'userview', 'cat' => 'fundedprojects', 'user' => $user['User']['id'], 'limit' => 8), array('class' => 'js-no-pjax', 'title' => sprintf(__l('%s Funded'), Configure::read('project.alt_name_for_project_plural_caps')), 'data-target'=>'#project_funded','escape' => false)); ?> </li>
			  <?php  if(isPluginEnabled('ProjectFollowers')): ?>
			  <li><?php echo $this->Html->link('<span class="show"><i class="fa fa-check-circle-o"> </i></span>'.sprintf(__l('Following %s'), Configure::read('project.alt_name_for_project_plural_caps')) . ' (' .$this->Html->cInt($project_following_count, false). ')', array('controller' => 'projects', 'action' => 'index', 'type' => 'userview', 'cat' => 'followingprojects', 'user' => $user['User']['id'], 'limit' => 8), array('class' => 'js-no-pjax', 'title' => sprintf(__l('Following %s'), Configure::read('project.alt_name_for_project_plural_caps')),'data-target'=>'#following_projects','escape' => false)); ?></li>
			  <?php endif; ?>
			</ul>
			<div class="panel-container">
			  <div id="activity" class="tab-pane fade in active">
					 </div>
					 <div id="project_posted" class="tab-pane fade in active">
					 </div>
					 <?php if (isPluginEnabled('Idea')): ?>
					 <div id="ideas_posted" class="tab-pane fade in active">
					 </div>
					 <?php endif;?>
					 <div id="project_funded" class="tab-pane fade in active">
					 </div>
					 <?php if(isPluginEnabled('ProjectFollowers')): ?>
					 <div id="following_projects" class="tab-pane fade in active">
					 </div>
					 <?php endif;?>
					 <?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
					<div id="user_logins" class="tab-pane fade in active">
					 </div>
			   <?php endif;?>
			</div>
			</div>
		</section>
	<hr/>
  </div>
</section>
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h2><?php echo __l('Compose'); ?></h2>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
			<a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
			</div>
		</div>
	</div>
</div>
<?php if (Configure::read('widget.user_script')) { ?>
      <div class="text-center clearfix navbar-btn footer-baner">
      <?php echo Configure::read('widget.user_script'); ?>
      </div>
    <?php } ?>