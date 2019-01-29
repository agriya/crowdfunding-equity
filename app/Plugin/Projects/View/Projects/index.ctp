<?php
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($projects)) {
    foreach ($projects as $project) {
        Configure::write('highperformance.pids', Set::merge(Configure::read('highperformance.pids'), $project['Project']['id']));
    }
}
$project_type_slug    = !empty($projectType['ProjectType']['slug']) ? $projectType['ProjectType']['slug'] : '';
$discover_heading     = !empty($discover_heading) ? $discover_heading : '';
$project_type_heading = Inflector::camelize($project_type_slug);
if (!empty($projects)) {
    $proj_cnt = count($projects);
}
$search_class = '';
if (!empty($proj_cnt) && ($proj_cnt == 1 || $proj_cnt == 2 || $proj_cnt == 3)) {
 $search_class .= ' col-xs-12 ';
}
?>
<?php if(!empty($this->request->params['named']) && !empty($this->request->params['named']['category']) && (Configure::read('site.launch_mode') != 'Pre-launch' && (Configure::read('site.launch_mode') != 'Private Beta'))){
	$bg_class = '';
	if($project_type_slug == 'pledge'){
		$bg_class = 'bg-info';
		$description = sprintf(__l("In %s %s, amount is captured by end date and may offer %s."), Configure::read('project.alt_name_for_pledge_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_reward_plural_small'));
	} else if($project_type_slug == 'donate'){
		$bg_class = 'bg-success';
		$description = sprintf(__l("In %s %s, transfer amount to project owner Immediately."), Configure::read('project.alt_name_for_donate_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_reward_plural_small'));
	} else if($project_type_slug == 'lend'){
		$bg_class = 'bg-warning';
		$description = sprintf(__l("In %s %s, amount is captured by end date and may offer %s."), Configure::read('project.alt_name_for_lend_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_reward_plural_small'));
	} else if($project_type_slug == 'equity'){
		$bg_class = 'bg-danger';
		$description = sprintf(__l("In %s %s, %s buy shares and %s amount is captured by end date/goal reached of the %s."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_investor_singular_small'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
		
	}
?>
	<section class="cf-lst-main">
		<section class="<?php echo $bg_class;?> clearfix sec-1 bg-<?php echo $project_type_slug;?> padd" itemtype="http://schema.org/Product" itemscope>
			<div class="container" itemprop="Name">
				<div class="text-center well-sm h3 clearfix">
					<?php echo $this->Html->image('crowdfunding-'.$project_type_slug.'.png', array('alt' => sprintf(__l('[Image: %s]'), $project_type_slug), 'class' => 'navbar-btn')); ?>
					<?php //echo Configure::read('project.alt_name_for_pledge_singular_caps'); ?>
					<h4 class="lead fa-inverse col-lg-8 col-lg-offset-2 trun" title="<?php echo $description; ?>" itemprop="description">
						<?php echo $description; ?>
					</h4>
				</div>
			</div>
		</section>
		<?php $proj_type_name = $project_type_slug.'Categories';
				$cat_name = $this->request->params['named']['category'];
		?>
		 <section class="sec-2">
			<div class="container">
				<h4><?php echo __l('Our project categories:');?></h4>
				<ul class="list-inline navbar-btn">
					<?php if($cat_name == 'All'){
								$active = 'active';
							} else {
								$active = '';
							}
					?>
						<li class="<?php echo $active; ?>">
							<?php echo $this->Html->link(sprintf(__l('All')), array('controller'=>'projects','action'=>'index','project_type' => $project_type_slug,'category' => 'All'), array('class'=>'js-no-pjax text-capitalize h5 list-group-item-text list-group-item-heading', 'title'=>sprintf(__l('All')))); ?>
						</li>
					<?php
						foreach($project_type_categories[$proj_type_name] as $slug => $category) {
							if($slug == $cat_name){
								$active = 'active';
							} else {
								$active = '';
							}
					?>
							<li class="<?php echo $active;?>">
								<?php echo $this->Html->link(sprintf(__l('%s'), $category), array('controller'=>'projects','action'=>'index','project_type' => $project_type_slug,'category' => $slug), array('class'=>'js-no-pjax text-capitalize h5 list-group-item-text list-group-item-heading', 'title'=>sprintf(__l('%s'), $category))); ?>
							</li>
					<?php
						}
					?>
				</ul>
			</div>
		</section>
	</section>
<?php } ?>
<div class="container">
	<div class="<?php echo $search_class; ?> tab-contain tabpanel-block js-response marg-top-20 clearfix">
<?php 
		if (!empty($proj_cnt) && $proj_cnt == 1) {  
?>
		<div class="navbar-btn cl-ofst-l clearfix">
		
<?php 
		} 
		if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
			echo $this->element('subscription-add', array(
				'cache' => array(
					'config' => 'sec'
				)
			), array(
				'plugin' => 'LaunchModes'
			));
		} else {
			if (!empty($this->request->params['named']['type']) && empty($this->request->params['named']['q']) && $this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'index' && ($this->request->params['named']['type'] == 'home' || (!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'home')) && (!isset($this->request->params['named']['is_idea']))) {
?>
				<h4 class="lead col-lg-12 hidden-xs 3">
					<strong><?php echo $heading; ?>
				</h4>
				<h4 class="h3 visible-xs text-center">
					<strong><?php echo $heading; ?>
				</h4>
<?php
			}
			$hide_box_cls = false;
			if (!empty($this->request->params['named']['type'])) {
				if ($this->request->params['named']['type'] == 'home' && $this->request->params['action'] == 'index') {
					$hide_box_cls = true;
					$disp_class   = '1';
				}
			}
			if (!empty($this->request->params['named']['name']) || !empty($this->request->params['named']['q']) || !empty($this->request->params['named']['city_slug']) || !empty($this->request->params['named']['category']) || (!empty($this->request->params['named']['filter']) && (empty($this->request->params['named']['view']) || (!empty($this->request->params['named']['view']) && ($this->request->params['named']['view'] != 'discover'))))) {
				if (!$ajax_view) {
?>
					<div class="clearfix">
<?php
				}
			}
			if (!empty($this->request->params['named']['city']) || !empty($this->request->params['named']['category']) || isset($this->request->params['named']['q'])) {
				if(!$ajax_view) {
?>
					<h4 class="lead hidden-xs 2 text-center">
						<strong><?php echo $this->html->cText($heading); ?></strong>
					</h4>
					<h4 class="h3 visible-xs text-center">
						<strong><?php echo $this->html->cText($heading); ?></strong>
					</h4>
<?php 
				} 
			}
			if ((!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'discover') || !empty($this->request->params['named']['filter'])) {
				if (!empty($this->request->params['named']['limit']) && $this->request->params['named']['limit'] == 4) {
					if (!empty($discover_heading)) {
?>
						<h4 class="lead col-lg-12 hidden-xs 4">
							<strong><?php echo __l($discover_heading); ?></strong>
						</h4>
						<h4 class="h3 visible-xs text-center">
							<strong><?php echo __l($discover_heading); ?></strong>
						</h4>
<?php
					} else {
?>
						<h4 class="lead col-lg-12 hidden-xs 4">
							<strong><?php echo __l($project_type_heading); ?></strong>
						</h4>
						<h4 class="h3 visible-xs text-center">
							<strong><?php echo __l($project_type_heading); ?></strong>
						</h4>
<?php
					}
				}
			}
?>
<?php
			$class_list = "";
			if (!empty($this->request->params['named']['cat']) && $this->request->params['named']['cat'] == 'myprojects') {
				$class_list = "my_projects";
			}
			$ideaClass = $vote_empty_class = '';
			if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'idea') {
				$ideaClass        = 'idea-list';
				$vote_empty_class = '';
				if (!empty($projects)) {
					echo '<span><strong>' . __l('Vote for this?  ') . '</strong></span>' . '<span>' . __l('or') . '</span>';
				}
				echo '<span>' . $this->Html->link('Create new idea', array(
					'controller' => 'projects',
					'action' => 'start',
					'admin' => false
				), array(
					'title' => 'Create new idea',
					'class' => 'js-tooltip btn btn-primary',
					'escape' => false
				)) . '</span>';
			}
			if (!empty($projects)) {
				$isEquityEnabled = 0;
				if (isPluginEnabled('Equity')) {
					$isEquityEnabled = 1;
				}
				$i = 0;
				$projectStatus  = array();
				$total_projects = count($projects);
				foreach ($projects as $project){
					$is_seis_or_eis = 0;
					if (!empty($isEquityEnabled)) {
						$is_seis_or_eis = $this->Html->seisCheck($project['Project']['id']);
					}
					$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
						'projectStatus' => $projectStatus,
						'project' => $project,
						'type' => 'status'
					));
					$is_allow_to_vote = ((isset($response->data['is_allow_to_vote'])) && (!empty($response->data['is_allow_to_vote']))) ? true : false;
					$projectStatus    = $response->data['projectStatus'];
					$project_type     = $project['ProjectType']['name'];
					$project_status   = $project[$project_type][$project['ProjectType']['slug'] . '_project_status_id'];
					if (!empty($project['Project']['project_end_date'])) {
						$time_strap = strtotime($project['Project']['project_end_date']) - strtotime(date('Y-m-d'));
						$days       = floor($time_strap / (60 * 60 * 24));
						if ($days > 0) {
							$project[0]['enddate'] = $days;
						} else {
							$project[0]['enddate'] = 0;
						}
					}
					$class = null;
					if ($i++ % 2 == 0) {
						$class = 'alpha';
					} else {
						$class = 'altrow alpha';
					}
?>
<?php
					if (!empty($proj_cnt) && $proj_cnt <= 1) {
						$dimension = 'project_big_thumb';
						$thumb     = 'medium_thumb';
?>
						<div class="col-sm-6 panel-contain js-response tabpanel-block-width">
<?php
					} else if (!empty($proj_cnt) && $proj_cnt == 2) {
						$dimension = 'project_medium_thumb';
						$thumb     = 'medium_thumb';
?>
						<div class="col-sm-6 col-md-4 panel-contain js-response">
<?php
					} else if (!empty($proj_cnt) && $proj_cnt >= 3) {
						$dimension = 'project_small_thumb';
						$thumb     = 'micro_thumb';
?>
						<div class="col-xs-12 col-sm-6 col-lg-3 panel-contain js-response follow-unfolllow">
<?php
					}
?>
<?php
					if ((isPluginEnabled($project_type)) && $is_allow_to_vote) {
?>
						<div class="thumbnail rhds panel clearfix">
<?php
						$img_class = 'img-resp';
						if (!empty($proj_cnt) && $proj_cnt <= 1) {
							$img_class = 'img-resp h5 list-group-item-heading center-block img-radius';
						}
						echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array(
							'dimension' => $dimension,
							'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)),
							'title' => $this->Html->cText($project['Project']['name'], false),
							'class' => $img_class
						), array(
							'aspect_ratio' => 1
						)), array(
							'controller' => 'projects',
							'action' => 'view',
							$project['Project']['slug'],
							'admin' => false
						), array(
							'escape' => false
						));
						if ($project['Project']['is_featured']) {
?>
							<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('Featured');?></span>
<?php
						}
						if (isPluginEnabled('Equity')) {
							if ($is_seis_or_eis == 1) {
?>
								<span class="btn btn-info btn-xs pull-right btn-eis"><?php echo __l('SEIS'); ?></span>
<?php
							} else if ($is_seis_or_eis == 2) {
?>
								<span class="btn btn-info btn-xs pull-right btn-eis"><?php echo __l('EIS'); ?></span>
<?php
							}
						}
?>
						<div class="col-xs-12">
<?php
							$response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
								'data' => $project,
								'class' => ' js-tooltip'
							));
							if (!empty($response->data['content'])) {
?>
								<p class="text-uppercase h6 text-danger"><?php echo $response->data['content']; ?></p>
<?php
							}
							if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
								<h4 class="navbar-btn list-group-item-text trunc-sgl roboto-bold">
<?php
							} else {
?>
								<h4 class="list-group-item-text trunc-sgl roboto-bold">
<?php
							}
							echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']), array('controller' => 'projects','action' => 'view',$project['Project']['slug'],'admin' => false), array('escape' => false,'class' => 'tab-a-clr','title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words'])));
							if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
								</h4>
<?php
							} else {
?>
								</h4>
<?php
							}
?>
							<p class="text-muted">
<?php
								echo __l('by');
								echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users','action' => 'view',$project['User']['username']), array('escape' => false,'title' => $this->Html->cText($project['User']['username'], false)));
?>
							</p>
							<p class="h5 trunc-sgl">
<?php
								if (!empty($proj_cnt) && ($proj_cnt <= 1 || $proj_cnt == 2)) {
?>
									<span>
<?php
								}
										echo $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'], false));
								if (!empty($proj_cnt) && ($proj_cnt <= 1 || $proj_cnt == 2)) {
?>
									</span>
<?php
								}
?>
							</p>
							<p class="h5 trunc-sgl">
<?php
								$location = array();
								$place    = '';
								if (!empty($project['City'])) {
									if (isset($project['City']['name']) && !empty($project['City']['name'])) {
										$location[] = $project['City']['name'];
									}
								}
								if (!empty($project['Country']['name'])) {
									$location[] = $project['Country']['name'];
								}
								$place = implode(', ', $location);
								if ($place) {
									echo $this->Html->link('<i class="fa fa-map-marker text-danger fa-fw"></i>' . $this->Html->cText($place, false), array('controller' => 'projects','action' => 'index','city' => $project['City']['slug'],'type' => 'home'), array('escape' => false));
								}
?>
							</p>
							<div class="row">
								<div class="col-xs-4">
									<h3 class="h3 navbar-btn list-group-item-text htruncate">
										<strong>
<?php
											$needed_amount = !empty($project['Project']['needed_amount']) ? $this->Html->siteCurrencyFormat($this->Html->cCurrency($project['Project']['needed_amount'], false)) : '';
											echo $needed_amount;
?>
										</strong>
									</h3>
									<p class="text-muted h6 list-group-item-heading"><?php	echo __l('Needed');	?></p>
								</div>
								<div class="col-xs-4">
									<h3 class="h3 navbar-btn list-group-item-text htruncate">
										<span title="<?php echo $this->Html->cInt($project['Project']['total_ratings'], false);	?>" class="js-idea-vote-count-<?php	echo $this->Html->cInt($project['Project']['id'], false);?> vote-count-value">
											<strong><?php echo $this->Html->cInt($project['Project']['total_ratings']);?></strong>
										</span>
									</h3>
									<p class="text-muted h6 list-group-item-heading"><?php	echo __l('Votes'); ?></p>
								</div>
							</div>
							<div class="col-xs-12 well well-sm user-block marg-top-20">
								<ul class="list-inline clearfix text-center1 list-group-item-text">
<?php
									$i = 1;
									$rating_count = !empty($project['ProjectRating']) ? count($project['ProjectRating']) : 0;
									$rated_users  = array();
									$extra        = $rating_count - 3;
									foreach ($project['ProjectRating'] as $projectrating) {
										array_push($rated_users, $projectrating['user_id']);
										if ($i <= 3) {
?>										
										<li>
											<div class="thumbnail list-group-item-text thumb-zoom">
<?php
											if (!empty($projectrating['user_id'])) {
												echo $this->Html->getUserAvatar($projectrating['User'], $thumb);
											} else {
												echo $this->Html->getUserAvatar(array(), $thumb, false, 'anonymous');
											}
?>
											</div>
										</li>
<?php
										}
										$i++;
									}
									if ($rating_count < 4) {
										if (empty($response->data['is_not_show_you_here'])) {
?>
										<li class="text-center thumbnail list-group-item-text pull-right1">
											<span class="show">
<?php
												if ($project['Project']['user_id'] == $this->Auth->user('id')) {
													echo __l('X');
												} else {
													echo __l('You');
												}
?>
											</span>
											<span class="show"><?php echo __l('Here'); ?></span>
										</li>
<?php
										}
									}
									if ($rating_count > 3) {
?>
										<li class="text-center thumbnail list-group-item-text pull-right1">
											<span class="show"><?php echo '+' . $extra;	?></span><span class="show"><?php echo ' ' . __l('More'); ?></span>
										</li>
<?php
									}
?>
								</ul>
							</div>
							<div class="panel-hover">
								<div class="panel-data">
									<div class="panel-cell">
										<div class="text-center">
											<div class="col-xs-12">
<?php
											if (isPluginEnabled('ProjectFollowers')) {
?>
<?php
												if (isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
													$projectfollower_id = '';
													if (!empty($project['ProjectFollower'][0]['id'])) {
														$projectfollower_id = $project['ProjectFollower'][0]['id'];
													}
?>
												<div class='alpf-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> hide'>
<?php
													echo $this->Html->link("<i class='fa fa-check'></i> " . __l('Following'), array('controller' => 'project_followers','action' => 'delete',$projectfollower_id), array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",'escape' => false, 'data-addtitle' => "Following", 'data-addlabel' => "Following", 'data-loadinglabel' => "Loading...", 'data-deletetitle' => "Follow", 'data-deletelabel' => "Follow", 'data-addclass' => "btn", 'data-removeclass' => "btn", 'title' => __l('Unfollow')));
?>
												</div>
												<div class='alpuf-<?php	echo $this->Html->cInt($project['Project']['id'], false); ?> hide'>
<?php
													echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers','action' => 'add',$project['Project']['id']), array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-no-pjax", 'data-addtitle' => "Follow", 'data-addlabel' => "Follow",'data-loadinglabel' => "Loading...",'data-deletetitle' => "Unfollow",'data-deletelabel' => "Unfollow",'data-addclass' => "btn",'data-removeclass' => "btn",'title' => __l('Follow')));
?>
												</div>
												<div class='blpuf-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> hide'>
<?php
													echo $this->Html->link(__l('Follow'), array('controller' => 'users','action' => 'login','?' => 'f=project/' . $project['Project']['slug'],'admin' => false), array('class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-no-pjax",'data-addtitle' => "Follow",'data-addlabel' => "Follow",'data-loadinglabel' => "Loading...",'data-deletetitle' => "Unfollow",'data-deletelabel' => "Unfollow",'data-addclass' => "btn",'data-removeclass' => "btn",'title' => __l('Follow')));
?>
												</div>
<?php
												} else {
													if (!empty($project['ProjectFollower'])) {
														echo $this->Html->link("<i class='fa fa-check'></i> " . __l('Following'), array(
															'controller' => 'project_followers',
															'action' => 'delete',
															$project['ProjectFollower'][0]['id']
														), array(
															'class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",
															'escape' => false,
															'data-addtitle' => "Following",
															'data-addlabel' => "Following",
															'data-loadinglabel' => "Loading...",
															'data-deletetitle' => "Follow",
															'data-deletelabel' => "Follow",
															'data-addclass' => "btn",
															'data-removeclass' => "btn",
															'title' => __l('Unfollow')
														));
													} else {
														if ($this->Auth->sessionValid()) {
															echo $this->Html->link(__l('Follow'), array(
																'controller' => 'project_followers',
																'action' => 'add',
																$project['Project']['id']
															), array(
																'class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-no-pjax",
																'data-addtitle' => "Follow",
																'data-addlabel' => "Follow",
																'data-loadinglabel' => "Loading...",
																'data-deletetitle' => "Unfollow",
																'data-deletelabel' => "Unfollow",
																'data-addclass' => "btn",
																'data-removeclass' => "btn",
																'title' => __l('Follow')
															));
														} else {
															echo $this->Html->link(__l('Follow'), array(
																'controller' => 'users',
																'action' => 'login',
																'?' => 'f=project/' . $project['Project']['slug'],
																'admin' => false
															), array(
																'class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip js-no-pjax",
																'data-addtitle' => "Follow",
																'data-addlabel' => "Follow",
																'data-loadinglabel' => "Loading...",
																'data-deletetitle' => "Unfollow",
																'data-deletelabel' => "Unfollow",
																'data-addclass' => "btn",
																'data-removeclass' => "btn",
																'title' => __l('Follow')
															));
														}
													}
												}
											}
?>
											</div>
<?php
											$rate_msg = "";
											if ($project['Project']['user_id'] == $this->Auth->user('id')) {
												$rate_msg = __l('Disabled. Reason: You can\'t rate your own project.');
											}
											if (in_array($this->Auth->user('id'), $rated_users)) {
												$rate_msg = __l('Disabled. Reason: You have already rated this project.');
											}
?>
											<div class="col-xs-12 dropdown">
<?php
												if ($project['Project']['user_id'] == $this->Auth->user('id')) {
?>
													<div class="text-center vote-container" id="vote-ratings-container-<?php echo $this->Html->cInt($project['Project']['id'], false);?>">
<?php
														if (isPluginEnabled('Idea')) {
?>
					<div class="js-idea-vote-display-<?php echo $this->Html->cInt($project['Project']['id'], false);?> starnew-rating js-idea-rating-display js-rating-display {'count':'js-idea-vote-count-<?php echo $this->Html->cInt($project['Project']['id'], false);?>'}">
<?php
																	$average_rating = ($rating_count != 0) ? $project['Project']['total_ratings'] / $rating_count : 0;
																	echo $this->element('_star-rating', array(
																		'project_id' => $project['Project']['id'],
																		'current_rating' => $average_rating,
																		'total_rating' => $project['Project']['total_ratings'],
																		'rating_count' => $project['Project']['project_rating_count'],
																		'canRate' => 0,
																		'is_view' => 0,
																		'project_type' => $project_type,
																		'rate_msg' => $rate_msg
																	));
?>
															</div>
<?php
														}
?>
													</div>
<?php
												} else {
													$canrate = (!in_array($this->Auth->user('id'), $rated_users)) ? 1 : 0;
?>
													<div class="text-center vote-container" id="vote-ratings-container-<?php echo $this->Html->cInt($project['Project']['id'], false); ?>">
<?php
														if (isPluginEnabled('Idea')) {
?>
															<div class="js-idea-vote-display-<?php echo $this->Html->cInt($project['Project']['id'], false);?> starnew-rating js-idea-rating-display js-rating-display {'count':'js-idea-vote-count-<?php echo $this->Html->cInt($project['Project']['id'], false);?>'}">
<?php
																$average_rating = ($rating_count != 0) ? $project['Project']['total_ratings'] / $rating_count : 0;
																echo $this->element('_star-rating', array(
																	'project_id' => $project['Project']['id'],
																	'current_rating' => $average_rating,
																	'total_rating' => $project['Project']['total_ratings'],
																	'rating_count' => $project['Project']['project_rating_count'],
																	'canRate' => $canrate,
																	'is_view' => 0,
																	'project_type' => $project_type,
																	'rate_msg' => $rate_msg
																));
?>
															</div>
<?php
														}
?>
													</div>
<?php
												}
?>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
<?php
            } else {
?>
				<div class="thumbnail rhds panel clearfix">
<?php 
				$img_class = 'img-resp';
                if (!empty($proj_cnt) && $proj_cnt <= 1) {
                    $img_class = 'img-resp h5 list-group-item-heading center-block img-radius';
                }
                echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array(
                    'dimension' => $dimension,
                    'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)),
                    'title' => $this->Html->cText($project['Project']['name'], false),
                    'class' => $img_class
                ), array(
                    'aspect_ratio' => 1
                )), array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug'],
                    'admin' => false
                ), array(
                    'escape' => false
                ));
                if ($project['Project']['is_featured']) {
?>
					<span class="btn-xs btn btn-success btn-ftur"><?php echo __l('Featured'); ?></span>
<?php
                }
                if (isPluginEnabled('Equity')) {
                    if ($is_seis_or_eis == 1) {
?>
						<span class="btn btn-info btn-xs pull-right btn-eis"><?php echo __l('SEIS'); ?></span>
<?php
                    } else if ($is_seis_or_eis == 2) {
?>
						<span class="btn btn-info btn-xs pull-right btn-eis"><?php echo __l('EIS'); ?></span>
<?php
                    }
                }
?>
					<div class="col-xs-12">
<?php
                $response = Cms::dispatchEvent('View.Project.displaycategory', $this, array('data' => $project, 'class' => ' js-tooltip'));
                if (!empty($response->data['content'])) {
?>
						<p class="text-uppercase h6 text-danger"><?php echo $response->data['content']; ?></p>
<?php
                }
?>
<?php
                if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
					<h4 class="navbar-btn list-group-item-text trunc-sgl roboto-bold">
<?php
                } else {
?>
					<h4 class="list-group-item-text trunc-sgl roboto-bold">
<?php
                }
?>
<?php
                echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']), array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug'],
                    'admin' => false
                ), array(
                    'escape' => false,
                    'class' => 'tab-a-clr',
                    'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words'])
                ));
                if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
					</h4>
<?php
                } else {
?>
					</h4>
<?php
                }
?>
				<p class="text-muted">
<?php 				echo __l('by'); 
					echo $this->Html->link($this->Html->cText($project['User']['username']), array(
						'controller' => 'users',
						'action' => 'view',
						$project['User']['username']
					), array(
						'escape' => false,
						'title' => $this->Html->cText($project['User']['username'], false)
					));
?>
				</p>
				<p class="h5 trunc-sgl">
<?php
                if (!empty($proj_cnt) && ($proj_cnt <= 1 || $proj_cnt == 2)) {
?>
					<span>
<?php
                }
					echo $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'], false));
                if (!empty($proj_cnt) && ($proj_cnt <= 1 || $proj_cnt == 2)) {
?>
					</span>
<?php
                }
?>
				</p>
				<p class="h5 trunc-sgl">
<?php
					$location = array();
					$place    = '';
					if (!empty($project['City'])) {
						if (isset($project['City']['name']) && !empty($project['City']['name'])) {
							$location[] = $project['City']['name'];
						}
					}
					if (!empty($project['Country']['name'])) {
						$location[] = $project['Country']['name'];
					}
					$place = implode(', ', $location);
					if ($place) {
						echo $this->Html->link('<i class="fa fa-map-marker text-danger fa-fw"></i>' . $this->Html->cText($place, false), array(
							'controller' => 'projects',
							'action' => 'index',
							'city' => $project['City']['slug']
						), array(
							'escape' => false
						));
					}
?>
				</p>
<?php
                if (isPluginEnabled($project['ProjectType']['name'])) {
                    echo $this->element('project_listing', array(
                        'project' => $project
                    ), array(
                        'plugin' => $project['ProjectType']['name']
                    ));
                }
                $fund_count = $project['Project']['project_fund_count'];
                $extra      = $fund_count - 3;
?>
				<div class="col-xs-12 well space user-block">
					<ul class="list-inline clearfix  list-group-item-text">
<?php
						$i = 1;
						foreach ($project['ProjectFund'] as $projectFund) {
							if ($i <= 3) {
?>
							<li>
								<div class="thumbnail list-group-item-text thumb-zoom">
<?php
									if (empty($projectFund['is_anonymous']) || $projectFund['user_id'] == $this->Auth->user('id') || (!empty($projectFund['is_anonymous']) && $projectFund['is_anonymous'] == ConstAnonymous::FundedAmount)) {
										if (!empty($projectFund['user_id'])) {
											echo $this->Html->getUserAvatar($projectFund['User'], $thumb);
										} else {
											echo $this->Html->getUserAvatar(array(), $thumb, false, 'anonymous');
										}
									} else {
										echo $this->Html->getUserAvatar(array(), $thumb, false, 'anonymous');
									}
?>
								</div>
							</li>
<?php
							}
							$i++;
						}
						if ($fund_count < 4) {
							if (empty($response->data['is_not_show_you_here'])) {
?>
							<li class="text-center thumbnail list-group-item-text">
								<span class="show">
<?php
									if ($project['Project']['user_id'] == $this->Auth->user('id')) {
										echo __l('X');
									} else {
										echo __l('You');
									}
?>
								</span>
								<span class="show"><?php echo __l('Here'); ?></span>
							</li>
<?php
							}
						}
						if ($fund_count > 3) {
?>
							<li class="text-center thumbnail list-group-item-text">
								<span class="show"><?php echo '+' . $extra; ?></span><span class="show"><?php echo ' ' . __l('More'); ?></span>
							</li>
<?php
						}
?>
					</ul>
				</div>
<?php
                if (!$project['Project']['is_admin_suspended']) {
?>
				<div class="panel-hover">
					<div class="panel-data">
						<div class="panel-cell">
							<div class="text-center">
								<div class="col-xs-12">

<?php
                    if (isPluginEnabled('ProjectFollowers')) {
                        $project_followers_id = '';
                        if (!empty($project['ProjectFollower'][0]['id'])) {
                            $project_followers_id = $project['ProjectFollower'][0]['id'];
                        }
?>
<?php
                        if (isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
?>
							<div class="alpf-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> hide">
<?php
								echo $this->Html->link("<i class='fa fa-check'></i> " . __l('Following'), array(
									'controller' => 'project_followers',
									'action' => 'delete',
									$project_followers_id
								), array(
									'class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",
									'escape' => false,
									'data-addtitle' => "Following",
									'data-addlabel' => "Following",
									'data-loadinglabel' => "Loading...",
									'data-deletetitle' => "Follow",
									'data-deletelabel' => "Follow",
									'data-addclass' => "btn",
									'data-removeclass' => "btn",
									'title' => __l('Unfollow')
								));
?>
							</div>
							<div class='alpuf-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> hide'>
<?php
								echo $this->Html->link(__l('Follow'), array(
									'controller' => 'project_followers',
									'action' => 'add',
									$project['Project']['id']
								), array(
									'class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip',
									'title' => __l('Follow')
								));
?>
							</div>
							<div class='blpuf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>
<?php
								echo $this->Html->link(__l('Follow'), array(
									'controller' => 'users',
									'action' => 'login',
									'?' => 'f=project/' . $project['Project']['slug'],
									'admin' => false
								), array(
									'class' => 'btn btn-default btn-lg text-uppercase navbar-btn  js-tooltip',
									'title' => __l('Follow')
								));
?>
							</div>
<?php
                        } else {
                            if (!empty($project['ProjectFollower'])) {
                                echo $this->Html->link("<i class='fa fa-check'></i> " . __l('Following'), array(
                                    'controller' => 'project_followers',
                                    'action' => 'delete',
                                    $project['ProjectFollower'][0]['id']
                                ), array(
                                    'class' => "btn btn-default btn-lg text-uppercase navbar-btn js-tooltip  js-unfollow",
                                    'escape' => false,
                                    'data-addtitle' => "Following",
                                    'data-addlabel' => "Following",
                                    'data-loadinglabel' => "Loading...",
                                    'data-deletetitle' => "Follow",
                                    'data-deletelabel' => "Follow",
                                    'data-addclass' => "btn",
                                    'data-removeclass' => "btn",
                                    'title' => __l('Unfollow')
                                ));
                            } else {
                                if ($this->Auth->sessionValid()) {
                                    echo $this->Html->link(__l('Follow'), array(
                                        'controller' => 'project_followers',
                                        'action' => 'add',
                                        $project['Project']['id']
                                    ), array(
                                        'class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip',
                                        'title' => __l('Follow')
                                    ));
                                } else {
                                    echo $this->Html->link(__l('Follow'), array(
                                        'controller' => 'users',
                                        'action' => 'login',
                                        '?' => 'f=project/' . $project['Project']['slug'],
                                        'admin' => false
                                    ), array(
                                        'class' => 'btn btn-default btn-lg text-uppercase navbar-btn js-tooltip',
                                        'title' => __l('Follow')
                                    ));
                                }
                            }
                        }
                    }
?>
					</div>
<?php
                    echo $this->element($project['ProjectType']['name'] . '.project_fund_link', array(
                        'project' => $project,
                        'projectStatus' => $projectStatus
                    ));
?>
					</div>
				</div>
			</div>
		</div>
<?php
                }
?>
	</div>
</div>

<?php
            }
            if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
				</div>
<?php
            } else if (!empty($proj_cnt) && $proj_cnt == 2) {
?>
				</div>
<?php
            } else if (!empty($proj_cnt) && $proj_cnt >= 3) {
?>
				</div>
<?php
            }
        }
        if (!empty($this->request->params['named']['limit']) && $total_projects < $this->request->params['named']['limit']) {
            if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
				<div class="col-sm-6 start-project-block tabpanel-block-width">
<?php
            } else if (!empty($proj_cnt) && $proj_cnt == 2) {
?>
				<div class="col-sm-6 col-md-4 start-project-block">
<?php
            } else if (!empty($proj_cnt) && $proj_cnt >= 3) {
?>
				<div class="col-xs-12 col-sm-6 col-md-3 start-project-block">
<?php
            }
?>
				<div class="thumbnail clearfix">
					<div class="text-center alert-info well-lg">
						<div class="well-sm h5"></div>
						<div class="well-lg h3">
							<a href="" title="Your-project">
								<?php echo $this->Html->image('your-project.png', array('alt' => __l('[Image: Your-project]'),'class' => 'h3'));?>
							</a>
							<h4 class="h3 1"><?php echo sprintf(__l('Your %s Here'), Configure::read('project.alt_name_for_project_singular_caps')); ?></h4>
<?php
				$url  = $this->Html->onProjectAddFormLoad();
				$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
				echo $this->Html->link($link_text, $url, array('title' => $link_text,'class' => 'js-tooltip btn btn-info btn-lg h3','escape' => false));
?>
						</div>
					</div>
				</div>
<?php
            if (!empty($proj_cnt) && $proj_cnt <= 1) {
?>
				</div>
<?php
            } else if (!empty($proj_cnt) && $proj_cnt == 2) {
?>
				</div>
<?php
            } else if (!empty($proj_cnt) && $proj_cnt >= 3) {
?>
				</div>
<?php
            }
        }
    } else {
        if (!empty($this->request->params['named']['q']) && !$ajax_view) {
?>
			<section class="clearfix">
				<ol class="list-unstyled alert alert-danger text-center">
					<li>
						<div class="clearfix">
							<p class="list-group-item-text"><i class="fa fa-exclamation-triangle"></i><?php echo sprintf(__l('Sorry, no results for "%s"'), $this->request->params['named']['q']); ?></p>
						</div>
					</li>
				</ol>
			</section>
<?php
        } elseif ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'userview') || !empty($this->request->params['named']['city'])) {
?>
			<section class="gray-bg clearfix">
				<ol class="list-unstyled">
					<li>
						<div class="thumbnail text-center list-group-item-text navbar-btn">
							<p><?php echo __l('No projects available');	?></p>
						</div>
					</li>
				</ol>
			</section>
<?php
        } else {
            if (isset($this->request->params['named']['category']) && !empty($this->request->params['named']['category'])) {
?>
				<section class="gray-bg clearfix">
					<ol class="list-unstyled">
						<li>
							<div class="thumbnail text-center list-group-item-text navbar-btn">
								<p><?php echo __l('No projects available');	?></p>
							</div>
						</li>
					</ol>
				</section>
<?php
            } else {
?>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="thumbnail rhds clearfix yur-prjt">
							<div class="text-center alert-info well-lg">
								<div class="well-lg h3"></div>
								<div class="well-lg h3">
									<a href="" title="Your-project"> <?php echo $this->Html->image('your-project.png', array( 'alt' => __l('[Image: Your-project]'), 'class' => 'h3'));?></a>
									<h4 class="h3 2"><?php echo sprintf(__l('Your %s Here'), Configure::read('project.alt_name_for_project_singular_caps'));
									?></h4>
									<?php
										$url       = $this->Html->onProjectAddFormLoad();
										if(!empty($project_type_slug)){
											$url = Router::url(array('controller' => 'projects', 'action' => 'add', 'project_type'=>$project_type_slug, 'admin' => false),true);
										}
										$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
										echo $this->Html->link($link_text, $url, array(
											'title' => $link_text,
											'class' => 'js-tooltip btn btn-info btn-lg h3',
											'escape' => false
										));
									?>
								</div>
								<div class="well-lg h3"></div>
							</div>
						</div>
					</div>
				</div>
<?php
            }
        }
    }
    if (!empty($this->request->params['named']['view']) && ($this->request->params['named']['view'] == 'home') && (empty($this->request->params['named']['is_idea']))) {
        if (isPluginEnabled('Pledge') && isPluginEnabled('Donate') && isPluginEnabled('Lend') && isPluginEnabled('Equity')) {
            echo '<p class="text-center ' . $projectType['ProjectType']['slug'] . '">';
        } else {
            echo '<p class="text-center ' . $projectType['ProjectType']['slug'] . '">';
        }
        if (!empty($projects)) {
            echo $this->Html->link(sprintf(__l('More %s %s'), Configure::read('project.alt_name_for_' . $projectType['ProjectType']['slug'] . '_singular_caps'), Configure::read('project.alt_name_for_project_plural_caps')), array(
                'controller' => 'projects',
                'action' => 'discover',
                'project_type' => $projectType['ProjectType']['slug'],
                'admin' => false
            ), array(
                'class' => 'btn btn-primary btn-lg js-tooltip',
                'title' => sprintf(__l('More %s %s'), Configure::read('project.alt_name_for_' . $projectType['ProjectType']['slug'] . '_singular_caps'), Configure::read('project.alt_name_for_project_plural_caps'))
            ));
        }
        echo '</p>';
    }
    $is_show_paging = 0;
    if (!empty($projects) && isset($this->request->params['named']['view']) && ($this->request->params['named']['view'] != 'home')) {
        $is_show_paging = 1;
    }
    if (!empty($projects) && (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'userview')) && (!empty($this->request->params['named']['cat']) && ($this->request->params['named']['cat'] == 'followingprojects' || $this->request->params['named']['cat'] == 'fundedprojects' || $this->request->params['named']['cat'] == 'myprojects' || $this->request->params['named']['cat'] == 'ideaproject'))) {
        $is_show_paging = 1;
    }
    if ($is_show_paging) {
        $pro_type = (!empty($projectType['ProjectType']['slug']) ? $projectType['ProjectType']['slug'] : '');
?>
		<div class="text-center col-xs-12">
			<div class="js-pagination js-no-pjax {'scroll':'js-<?php $pro_type . '-' . strtolower(Inflector::slug($discover_heading)); ?>-scroll'}">
			<?php
					echo $this->element('paging_links');
			?>
			</div>
		</div>
<?php
    }
	// todo: unwanted div closing issue. now i commended below code [need to check further issue]
    /*if ((!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'discover') || !empty($this->request->params['named']['filter'])) {
?>
		</div>
<?php
    }*/
}
if (!empty($proj_cnt) && $proj_cnt == 1) {
?>
</div>
<?php
}
?>
</div>
</div>
