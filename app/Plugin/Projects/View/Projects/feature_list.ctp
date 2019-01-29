<?php
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($projects)) {
	foreach ($projects as $project){
		Configure::write('highperformance.pids', Set::merge(Configure::read('highperformance.pids') , $project['Project']['id']));
	}
}
$project_type_slug = !empty($projectType['ProjectType']['slug']) ? $projectType['ProjectType']['slug'] : '';
?>
<?php
	if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
		echo $this->element('subscription-add', array('cache' => array('config' => 'sec')), array('plugin' => 'LaunchModes'));
	} else { 
		if (!empty($projects)): ?>
				<?php
					$isEquityEnabled = 1;
					$i = 0;
					$projectStatus = array();
					$total_projects = count($projects);
					foreach ($projects as $project):
						$is_seis_or_eis = 0;
						if(!empty($isEquityEnabled)) {
							$is_seis_or_eis = $this->Html->seisCheck($project['Project']['id']);
						}
						$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
							'projectStatus' => $projectStatus,
							'project' => $project,
							'type'=> 'status'
						));
						$is_allow_to_vote = ((isset($response->data['is_allow_to_vote'])) && (!empty($response->data['is_allow_to_vote'])))? true : false;
						$projectStatus = $response->data['projectStatus'];
						$project_type = $project['ProjectType']['name'];
						$project_status = $project[$project_type][$project['ProjectType']['slug'] .'_project_status_id'];
						if(!empty($project['Project']['project_end_date'])):
							$time_strap= strtotime($project['Project']['project_end_date']) -strtotime( date('Y-m-d'));
							$days = floor($time_strap /(60*60*24));
							if ($days > 0) {
								$project[0]['enddate'] = $days;
							} else {
								$project[0]['enddate'] =0;
							}
						endif;
						$class = null;
						if ($i++ % 2 == 0) {
							$class = 'alpha';
						} else {
							$class = 'altrow alpha';
						}
				?>
			<div class="col-sm-6 panel-contain js-response">	
				<?php
					if($is_allow_to_vote){
				?>
				<div class="panel clearfix <?php echo $project['ProjectType']['slug'];?>">
					<?php if ($is_seis_or_eis == 1){ ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('SEIS');?></span>
					<?php } else if ($is_seis_or_eis == 2){ ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('EIS');?></span>
					<?php } ?>
					<?php 
						echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false)),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false)); 
					?>
					<?php if ($project['Project']['is_featured']): ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('Featured');?></span>
					<?php endif;?>
					<div class="col-xs-12">
						<?php
						  $response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
							'data' => $project,
							'class'=> 'js-tooltip'
						  ));
						  if (!empty($response->data['content'])) {
						?>
						<p class="text-uppercase h6 text-danger"><?php echo $response->data['content'];?></p>
						<?php } ?>
						<h3 class="h3 navbar-btn list-group-item-text trunc-sgl">
							<strong>
							<?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'],false), $project['Project']['detected_suspicious_words']),array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false, 'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'],false), $project['Project']['detected_suspicious_words'])));?>
							</strong>
						</h3>
						<p class="text-muted">
							<?php echo __l('by')?> <?php echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users', 'action' => 'view', $project['User']['username']), array('escape' => false, 'title' => $this->Html->cText($project['User']['username'], false)));?>
						</p>
						<p class="navbar-btn  trunc-sgl"><?php echo $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'],false));?></p>
						<p class="navbar-btn"> <i class="fa fa-map-marker fa-fw text-danger"></i>
							<?php
							  $location = array();
							  $place = '';
							  if (!empty($project['City'])) :
								if (isset($project['City']['name']) && !empty($project['City']['name'])) {
								  $location[] = $project['City']['name'];
								}
							  endif;
							  if (!empty($project['Country']['name'])) :
								$location[] = $project['Country']['name'];
							  endif;
							  $place = implode(', ', $location);
							  if ($place) :
								echo $this->Html->link($this->Html->cText($place, false), array('controller' => 'projects', 'action' => 'index', 'city' => $project['City']['slug'], 'type' => 'home'), array('escape' => false));
							  endif;
							?>
						</p>
						<?php
							echo $this->element('project_listing',array('project' => $project), array('plugin' => $project['ProjectType']['name']));
							$fund_count = $project['Project']['project_fund_count'];
							$extra = $fund_count - 3;
						?>
						<div class="col-xs-12 well well-sm clearfix user-block">
							<ul class="list-inline text-center">
								<?php
								  $i = 1;
								  $rating_count = !empty($project['ProjectRating']) ? count($project['ProjectRating']) : 0;
								  $rated_users=array();
								  $extra = $rating_count - 3;
								  foreach($project['ProjectRating'] as $projectrating) {
									array_push($rated_users, $projectrating['user_id']);
									if ($i <= 3) {
								?>
								<li class="col-xs-3 col-md-2">
									<div class="thumbnail list-group-item-text thumb-zoom">
										  <?php
											if (!empty($projectrating['user_id'])) {
											  echo $this->Html->getUserAvatar($projectrating['User'], 'micro_thumb');
											} else {
											  echo $this->Html->getUserAvatar(array(), 'micro_thumb', false, 'anonymous');
											}
										  ?>
									</div>
								</li>
								<?php
									}
									$i++;
								  }
								  if ($rating_count < 4) {
								?>
								<?php if (empty($response->data['is_not_show_you_here'])) { ?>
								<li class="col-xs-3 col-md-2">
									<div class="h5 thumbnail no-rad list-group-item-text list-group-item-heading">
										<span class="show">
										<?php
											if($project['Project']['user_id'] == $this->Auth->user('id')){
												echo __l('X');
											} else {
												echo __l('You');
											}
										?>
										</span><?php echo __l('Here');?>
									</div>
								</li>
								<?php } ?>
								<?php
								  }
								  if ($rating_count > 3) {
								?>
								<li class="col-xs-3 col-md-2">
									<div class="h5 thumbnail no-rad text-center list-group-item-text list-group-item-heading">
										<span><?php echo '+' . $extra; ?></span> 
										<span class="show"><?php echo __l('More');?></span>
									</div>
								</li>
								<?php } ?>
							 </ul>
						</div>
						<div class="panel-hover">
					<div class="panel-data">
						<div class="panel-cell">
							<div class="text-center">
								<div class="col-xs-12">
									<?php if(isPluginEnabled('ProjectFollowers')) { ?>
									<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
										$projectfollower_id ='';
										if(!empty($project['ProjectFollower'][0]['id'])) { $projectfollower_id=$project['ProjectFollower'][0]['id'];}?>
										<div class='alpf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
												  <?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'project_followers', 'action' => 'delete', $projectfollower_id),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",'escape' => false,'data-addtitle'=>"Following", 'data-addlabel'=>"Following", 'data-loadinglabel'=>"Loading...", 'data-deletetitle'=>"Follow", 'data-deletelabel'=>"Follow", 'title'=>__l('Unfollow'))); ?>
										</div>
										<!--For reference, 'data-addclass'=>"btn", 'data-removeclass'=>"btn", class removed in all links-->
										<div class='alpuf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
													<?php echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers', 'action' => 'add', $project['Project']['id']),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-ajax-statchange",'data-addtitle'=>"Follow", 'data-addlabel'=>"Follow", 'data-loadinglabel' => "Loading...",  'data-deletetitle' => "Unfollow",  'data-deletelabel' => "Unfollow", 'title'=>__l('Follow')));  ?>
										</div>
										<div class='blpuf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
													 <?php echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-ajax-statchange", 'data-addtitle'=>"Follow", 'data-addlabel'=>"Follow", 'data-loadinglabel' => "Loading...",  'data-deletetitle' => "Unfollow",  'data-deletelabel' => "Unfollow", 'title'=>__l('Follow'))); ?>
										</div>
									<?php } else {?>
										<?php if (!empty($project['ProjectFollower'])): ?>
										  <?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'project_followers', 'action' => 'delete', $project['ProjectFollower'][0]['id']),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",'escape' => false,'data-addtitle'=>"Following", 'data-addlabel'=>"Following", 'data-loadinglabel'=>"Loading...", 'data-deletetitle'=>"Follow", 'data-deletelabel'=>"Follow", 'title'=>__l('Unfollow'))); ?>
										<?php else: ?>
										<?php
										if ($this->Auth->sessionValid()) {
										 echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers', 'action' => 'add', $project['Project']['id']),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-ajax-statchange", 'data-addtitle'=>"Follow", 'data-addlabel'=>"Follow", 'data-loadinglabel' => "Loading...",  'data-deletetitle' => "Unfollow",  'data-deletelabel' => "Unfollow", 'title'=>__l('Follow')));
										} else {
										  echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-ajax-statchange", 'data-addtitle'=>"Follow", 'data-addlabel'=>"Follow", 'data-loadinglabel' => "Loading...",  'data-deletetitle' => "Unfollow",  'data-deletelabel' => "Unfollow",  'title'=>__l('Follow')));
										}
										?>
										<?php endif; ?>
									<?php } ?>
									<?php } ?>
								</div>
								<?php
									echo $this->element($project['ProjectType']['name'].'.project_fund_link', array('project' => $project,'projectStatus' => $projectStatus));
								?>
					  <?php
					  $rate_msg = "";
						if($project['Project']['user_id'] == $this->Auth->user('id')){
							$rate_msg = __l('Disabled. Reason: You can\'t rate your own project.');
						}
						if(in_array($this->Auth->user('id'),$rated_users))
						{
							$rate_msg = __l('Disabled. Reason: You have already rated this project.');
						}
					  ?>
					  <div class="col-xs-12 dropdown">
						<?php if( $project['Project']['user_id'] == $this->Auth->user('id')): ?>
						  <div class="text-center vote-container" id="vote-ratings-container-<?php echo $this->Html->cInt($project['Project']['id'], false);?>">
							<?php if (isPluginEnabled('Idea')): ?>
							  <div class="js-idea-vote-display-<?php echo $this->Html->cInt($project['Project']['id'], false); ?>  js-idea-rating-display js-rating-display {'count':'js-idea-vote-count-<?php echo $this->Html->cInt($project['Project']['id'], false); ?>'}">
								<?php
								  $average_rating =($rating_count !=0)?$project['Project']['total_ratings']/ $rating_count:0;
								  echo $this->element('_star-rating', array('project_id' => $project['Project']['id'], 'current_rating' => $average_rating ,'total_rating' => $project['Project']['total_ratings'],'rating_count' => $project['Project']['project_rating_count'], 'canRate' =>0,'is_view'=>0, 'project_type' => $project_type, 'rate_msg' => $rate_msg));
								?>
							  </div>
							<?php endif; ?>
						  </div>
						<?php  else: ?>
						  <?php $canrate =(!in_array($this->Auth->user('id'),$rated_users)) ? 1 : 0; ?>
						  <div class="text-center vote-container" id="vote-ratings-container-<?php echo $this->Html->cInt($project['Project']['id'], false);?>">
							<?php if (isPluginEnabled('Idea')): ?>
							  <div class="js-idea-vote-display-<?php echo $this->Html->cInt($project['Project']['id'], false); ?>  js-idea-rating-display js-rating-display {'count':'js-idea-vote-count-<?php echo $this->Html->cInt($project['Project']['id'], false); ?>'}">
								<?php
								  $average_rating =($rating_count !=0)?$project['Project']['total_ratings']/ $rating_count:0;
								  echo $this->element('_star-rating', array('project_id' => $project['Project']['id'], 'current_rating' => $average_rating ,'total_rating' => $project['Project']['total_ratings'],'rating_count' => $project['Project']['project_rating_count'], 'canRate' =>$canrate,'is_view'=>0, 'project_type' => $project_type, 'rate_msg' => $rate_msg));
								?>
							  </div>
							<?php endif; ?>
						  </div>
						<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
					</div>
				</div>
		<?php } else { ?>
				<div class="panel clearfix <?php echo $project['ProjectType']['slug'];?>">
					<?php if ($is_seis_or_eis == 1){ ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('SEIS');?></span>
					<?php } else if ($is_seis_or_eis == 2){ ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('EIS');?></span>
					<?php } ?>
					<?php 
						echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false)),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false)); 
					?>
					<?php if ($project['Project']['is_featured']): ?>
						<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('Featured');?></span>
					<?php endif;?>
					<div class="col-xs-12">
						<?php
						  $response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
							'data' => $project,
							'class'=> 'js-tooltip'
						  ));
						  if (!empty($response->data['content'])) {
						?>
						<p class="text-uppercase h6 text-danger"><?php echo $response->data['content'];?></p>
						<?php } ?>
						<h3 class="h3 navbar-btn list-group-item-text trunc-sgl">
							<strong>
								<?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']),array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false, 'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words'])));?>
							</strong>
						</h3>
						<p class="text-muted">
							<?php echo __l('by')?> <?php echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users', 'action' => 'view', $project['User']['username']), array('escape' => false, 'title' => $this->Html->cText($project['User']['username'], false)));?>
						</p>
						<p class="navbar-btn trunc-sgl"><?php echo $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'],false));?></p>
						<p class="navbar-btn"> <i class="fa fa-map-marker fa-fw text-danger"></i>
							<?php
							  $location = array();
							  $place = '';
							  if (!empty($project['City'])) :
								if (isset($project['City']['name']) && !empty($project['City']['name'])) {
								  $location[] = $project['City']['name'];
								}
							  endif;
							  if (!empty($project['Country']['name'])) :
								$location[] = $project['Country']['name'];
							  endif;
							  $place = implode(', ', $location);
							  if ($place) :
								echo $this->Html->link($this->Html->cText($place, false), array('controller' => 'projects', 'action' => 'index', 'city'=>$project['City']['slug']), array('escape' => false));
							  endif;
							?>
						</p>
						<?php
							echo $this->element('project_listing',array('project' => $project), array('plugin' => $project['ProjectType']['name']));
							$fund_count = $project['Project']['project_fund_count'];
							$extra = $fund_count - 3;
						?>
						<div class="col-xs-12 well well-sm clearfix user-block">
							<ul class="list-inline text-center">
								<?php
									$i = 1;
									foreach($project['ProjectFund'] as $projectFund) {
									  if ($i <= 3) {
								?>
								<li class="col-xs-3 col-md-2">
									<div class="thumbnail list-group-item-text thumb-zoom">
										  <?php
											  if (empty($projectFund['is_anonymous']) || $projectFund['user_id'] == $this->Auth->user('id') || (!empty($projectFund['is_anonymous']) && $projectFund['is_anonymous'] == ConstAnonymous::FundedAmount)) {
												if (!empty($projectFund['user_id'])) {
												  echo $this->Html->getUserAvatar($projectFund['User'], 'micro_thumb');
												} else {
												  echo $this->Html->getUserAvatar(array(), 'micro_thumb', false, 'anonymous');
												}
											  } else {
												echo $this->Html->getUserAvatar(array(), 'micro_thumb', false, 'anonymous');
											  }
										  ?>
									</div>
								</li>
								<?php
									}
									$i++;
									}
									if ($fund_count < 4) {
								?>
								<?php if (empty($response->data['is_not_show_you_here'])) { ?>
								<li class="col-xs-3 col-md-2">
									<div class="h5 thumbnail no-rad list-group-item-text list-group-item-heading">
										<span class="show">
										<?php
											if($project['Project']['user_id'] == $this->Auth->user('id')){
												echo __l('X');
											} else {
												echo __l('You');
											}
										?>
										</span><?php echo __l('Here');?>
									</div>
								</li>
								<?php } ?>
								<?php
								  }
								  if ($fund_count > 3) {
								?>
								<li class="col-xs-3 col-md-2 h4 text-center list-group-item-text list-group-item-heading">
									<span><?php echo '+' . $extra; ?></span> 
									<span class="show"><?php echo __l('More');?></span>
								</li>
								<?php } ?>
							 </ul>
						</div>
						<?php if(!$project['Project']['is_admin_suspended']): ?>
						<div class="panel-hover">
							<div class="panel-data">
								<div class="panel-cell">
									<div class="text-center">
										<div class="col-xs-12">
											<div class="clearfix  dropdown">
												<?php if (isPluginEnabled('ProjectFollowers')) {
													$project_followers_id='';
													if(!empty($project['ProjectFollower'][0]['id'])) { $project_followers_id=$project['ProjectFollower'][0]['id'];}?>
													<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {?>
													<div class="alpf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide">
															   <?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'project_followers', 'action' => 'delete', $project_followers_id),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",'escape' => false,'data-addtitle'=>"Following", 'data-addlabel'=>"Following", 'data-loadinglabel'=>"Loading...", 'data-deletetitle'=>"Follow", 'data-deletelabel'=>"Follow", 'title'=>__l('Unfollow'))); ?>
													</div>
													<?php $redirect_url = Router::url(array(
														  'controller' => 'project_followers',
														  'action' => 'add',
														  $project['Project']['id']
														), true); ?>
													<div class='alpuf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
																<?php echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers', 'action' => 'add', $project['Project']['id']),array('class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip', 'title'=>__l('Follow')));  ?>
													</div>
													<div class='blpuf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
																 <?php echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false),array('class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip', 'title'=>__l('Follow'))); ?>
													</div>
												<?php } else {?>
													<?php if (!empty($project['ProjectFollower'])): ?>
													  <?php echo $this->Html->link("<i class='fa fa-check'></i> ". __l('Following'), array('controller' => 'project_followers', 'action' => 'delete', $project['ProjectFollower'][0]['id']),array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",'escape' => false,'data-addtitle'=>"Following", 'data-addlabel'=>"Following", 'data-loadinglabel'=>"Loading...", 'data-deletetitle'=>"Follow", 'data-deletelabel'=>"Follow", 'title'=>__l('Unfollow'))); ?>
													<?php else: ?>
													  <?php
														$redirect_url = Router::url(array(
														  'controller' => 'project_followers',
														  'action' => 'add',
														  $project['Project']['id']
														), true);
													  ?>
													  <?php
													  if ($this->Auth->sessionValid()) {
														echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers', 'action' => 'add', $project['Project']['id']),array('class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip', 'title'=>__l('Follow')));
														} else {
														echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $project['Project']['slug'], 'admin' => false),array('class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-ajax-statchange', 'title'=>__l('Follow')));
														}
														?>
													<?php endif; ?>

												<?php } } ?>
											</div>
										</div>
											<?php
												echo $this->element($project['ProjectType']['name'].'.project_fund_link', array('project' => $project,'projectStatus' => $projectStatus));
											?>
									</div>
								</div>
							</div>
						</div>
				<?php endif; ?>
					</div>
				</div>
					
		<?php } ?>
		</div>
<?php
	endforeach;
?>
<?php else: ?>
		  <div class="panel clearfix ">
				<section class="marg-top-20<?php echo (!empty($this->request->params['named']['is_idea'])) ? '' : '' ;?>">
				  <p class="text-center"><?php echo sprintf(__l('Your %s Here'),Configure::read('project.alt_name_for_project_singular_caps'))?></p>
				  <p class="text-center">
					<?php
					$url = $this->Html->onProjectAddFormLoad();
					$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
					?>
					<?php echo $this->Html->link($link_text, $url, array('title' => $link_text,'class' => 'js-tooltip', 'escape' => false));?>
				  </p>
				</section>
		  </div>
<?php
     endif;
?>
<?php } ?>
		
        