<div class="user-engage js-cache-load-admin-user-activities clearfix">
	<?php $i=0; ?>
	<ul class="list-unstyled row">
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('User Registration'); ?>"><?php echo __l('User Registration'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($user_reg_data_per>0) {?> text-success <?php } else if($user_reg_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($user_reg_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $user_reg_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#a47ae2'}"><?php echo $user_reg_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_user_reg, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#registration','admin'=>true),array('escape'=> false,  'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl ">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('User Logins'); ?>"><?php echo __l('User Logins'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($user_log_data_per>0) {?> text-success <?php } else if($user_log_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($user_log_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $user_log_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#4986e7'}"><?php echo $user_log_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_user_login, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php if (isPluginEnabled('SocialMarketing')) {?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('User Followers'); ?>"><?php echo __l('User Followers'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($user_follow_data_per>0) {?> text-success <?php } else if($user_follow_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($user_follow_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $user_follow_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#f691b2'}"><?php echo $user_follow_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_user_follow, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('Projects')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Projects'); ?>"><?php echo __l('Projects'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($projects_data_per>0) {?> text-success <?php } else if($projects_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($projects_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $projects_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#cd74e6'}"><?php echo $projects_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_projects, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#pledges','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('Projects')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Funded'); ?>"><?php echo __l('Project Funded'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_fund_data_per>0) {?> text-success <?php } else if($project_fund_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_fund_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_fund_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#ff7537'}"><?php echo $project_fund_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_fund, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#pledges','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('Projects')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Comments'); ?>"><?php echo __l('Project Comments'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_comments_data_per>0) {?> text-success <?php } else if($project_comments_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_comments_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_comments_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#d06b64'}"><?php echo $project_comments_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_comment, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectcomments','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('ProjectUpdates')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Updates'); ?>"><?php echo __l('Project Updates'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_updates_data_per>0) {?> text-success <?php } else if($project_updates_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_updates_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_updates_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#42d692'}"><?php echo $project_updates_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_update, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectcomments','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('ProjectUpdates')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Update Comments'); ?>"><?php echo __l('Project Update Comments'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_update_comments_data_per>0) {?> text-success <?php } else if($project_update_comments_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_update_comments_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_update_comments_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#16a765'}"><?php echo $project_update_comments_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_update_comments, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectfollowers','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('Idea')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Ratings'); ?>"><?php echo __l('Project Ratings'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_rating_data_per>0) {?> text-success <?php } else if($project_rating_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_rating_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_rating_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#ac725e'}"><?php echo $project_rating_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_ratings, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectflag','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('ProjectFollowers')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Followers'); ?>"><?php echo __l('Project Followers'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_follower_data_per>0) {?> text-success <?php } else if($project_follower_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_follower_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_follower_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#9fe1e7'}"><?php echo $project_follower_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_follower, false);?> 
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectfollowers','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<?php if (isPluginEnabled('ProjectFlags')) { ?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Project Flags'); ?>"><?php echo __l('Project Flags'); ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($project_flag_data_per>0) {?> text-success <?php } else if($project_flag_data_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($project_flag_data_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $project_flag_data_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $project_flag_data;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_project_flag, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#projectflag','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
		<li class="col-sm-6 col-md-6 col-lg-4">
			<div class="thumbnail clearfix">
				<div class="col-xs-12">
					<div class="pull-left trunc-sgl">
						<h4 class="h3 text-capitalize navbar-btn js-tooltip" title="<?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?>"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?></h4>
					</div>
					<div class="pull-right">
						<div class="navbar-btn">
							<div class="lead <?php if ($rev_per>0) {?> text-success <?php } else if($rev_per == 0) { ?> text-muted <?php } else { ?> text-danger <?php } ?> navbar-btn js-tooltip">
								<i class="<?php if ($rev_per>0) {?> fa fa-caret-up fa-fw <?php } else {?> fa fa-caret-down fa-fw <?php } ?> "></i><?php echo $rev_per;?>%
							</div>
						</div>
					</div>
				</div> 
				 <div class="col-xs-12">
					<div class="pull-left">
					   <ul class="list-inline">
							<li>
								<div class="col-md-4" class="hide invisible">
									<span class="js-sparkline-chart {'colour':'#ffad46'}"><?php echo $revenue;?></span>
								</div>
							</li>
							<li>
								<div class="h2 text-danger navbar-btn js-tooltip">
									<?php echo $this->Html->cInt($total_revenue, false);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="pull-right navbar-btn">
						<?php if (isPluginEnabled('Insights')): ?>
							<div class="pull-right ">
								<?php echo $this->Html->link($this->Html->image('right-arrow.png', array('class' => 'img-responsive','title' => 'right-arrow',	'alt' => '[Image: right-arrow]')), array('controller' => 'insights','action' => 'index','#revenue','admin'=>true),array('escape'=> false, 'class' => 'h2 text-muted rgt-move rgt-arw'));?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>
