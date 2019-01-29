<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner col-md-2 hor-middle-img accordion-heading no-bor clearfix box-head admin-panel-menu">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn btn-primary btm-sm js-show-panel accordion-toggle js-toggle-icon js-no-pjax clearfix"><i class="fa fa-user fa-fw"></i> <?php echo __l('Admin Panel'); ?><i class="fa fa-sort-desc fa-fw"></i></a>
			</div>
			<div class="accordion-body no-bor collapse navbar-btn" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block">
					<ul class="nav nav-tabs tabs tabs-span clearfix">
						<li class="tab"><?php echo $this->Html->link(__l('Actions'), '#admin-actions',array('class' => 'js-no-pjax', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Views'), Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_views', 'action' => 'index', 'project_id' => $project['Project']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target' => '#admin-project-views', 'escape' => false)); ?></li>
						<?php if (isPluginEnabled('Idea')) :?>
							<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Votings'), Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_ratings', 'action' => 'index', 'project_id' => $project['Project']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target' => '#admin-project-ratings', 'escape' => false)); ?></li>
						<?php endif; ?>
							<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Funding'), Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => Inflector::Pluralize($project['ProjectType']['slug']), 'action' => 'funds', 'project_id' => $project['Project']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target' => '#admin-project-funds', 'escape' => false)); ?></li>
						<?php if(isPluginEnabled('ProjectFlags')) :?>
							<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('%s Flags'), Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_flags', 'action' => 'index', 'project_id' => $project['Project']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target' => '#admin-project-flags', 'escape' => false)); ?></li>
						<?php endif; ?>
					</ul>
					<article class="panel-container clearfix">
						<div class="col-md-12 tab-pane fade in active clearfix" id="admin-actions" class="show">
							<ul class="list-unstyled clearfix">
								<?php if (!empty($projectStatus->data['is_allow_to_move_for_voting']) && isPluginEnabled('Idea')): ?>
									<li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-arrows"></i> '.__l('Move for voting'), array('controller'=>'projects','action'=>'admin_open_funding', $project['Project']['id'],'type'=>'vote','admin'=>true), array('class' => 'btn js-no-pjax',  'escape'=>false,'title' => __l('Move for voting')));?></li>
								<?php elseif (!empty($projectStatus->data['is_allow_to_move_for_funding'])): ?>
									<li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-hdd-o fa-fw"></i> '.__l('Move for funding'), array('controller'=>'projects','action'=>'admin_open_funding', $project['Project']['id'],'admin'=>true), array('class' => 'btn js-no-pjax',  'escape'=>false,'title' => __l('Move for funding')));?></li>
								<?php endif; ?>
								<li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i> '.__l('Edit'), array('controller'=>'projects','action' => 'edit', $project['Project']['id'],'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Edit')));?></li>
								<?php if(isPluginEnabled('Insights')):?>
								<li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-tasks"></i> '.__l('Stats'), array('controller'=>'insights','action' => 'project_detailed_stats', $project['Project']['id'],'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Stats')));?></li>
								<?php endif;?>
								<li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-times"></i> '.__l('Delete'), array('controller'=>'projects','action' => 'delete', $project['Project']['id'],'admin'=>true, 'redirect_to' => Inflector::Pluralize($project['ProjectType']['slug'])), array('class' => 'btn js-no-pjax js-confirm', 'escape'=>false,'title' => __l('Delete')));?></li>
								<?php if($project['Project']['is_system_flagged']):?>
                                    <li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-times-circle-o"></i> '.__l('Clear Flag'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'unflag', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Clear Flag')));?></li>
								<?php else: ?>
									<?php if (!empty($projectStatus->data['is_allow_to_change_status'])):?>
                                        <li class="pull-left text-center"><?php echo $this->Html->link('<i class="fa fa-flag"></i> '.__l('Flag'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'flag', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Flag')));?></li>
									<?php endif; ?>
								<?php endif;?>
								<?php if($project['Project']['is_admin_suspended']):?>
                                    <li class="pull-left text-center"> <?php echo $this->Html->link('<i class="fa fa-repeat"></i> '.__l('Unsuspend'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'unsuspend', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Unsuspend')));?></li>
								<?php else: ?>
									<?php if (!empty($projectStatus->data['is_allow_to_change_status'])):?>
                                        <li class="pull-left text-center "> <?php  echo $this->Html->link('<i class="fa fa-power-off"></i> '.__l('Suspend'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'suspend', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Suspend')));?></li>
									<?php endif;?>
								<?php endif; ?>
								<?php if($project['Project']['is_featured']):?>
                                    <li class="pull-left text-center "><?php echo $this->Html->link('<i class="fa fa-crosshairs"></i> '.__l('Not Featured'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'notfeatured', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Not Featured')));?></li>
								<?php else: ?>
									<?php if (!empty($projectStatus->data['is_allow_to_change_status'])):?>
                                        <li class="pull-left text-center "><?php echo $this->Html->link('<i class="fa fa-map-marker"></i> '.__l('Featured'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'featured', 'project_type' => $project['ProjectType']['slug'], 'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Featured')));?></li>
									<?php endif;?>
								<?php endif; ?>
								<?php if (!empty($projectStatus->data['is_allow_to_cancel_project'])):?>
									<li class="pull-left text-center "><?php echo $this->Html->link('<i class="fa fa-times-sign"></i> '.__l('Cancel'), array('controller'=>'projects','action'=>'admin_cancel', $project['Project']['id'],'admin'=>true), array('class' => 'btn js-no-pjax','escape'=>false, 'title' => __l('Cancel')));?></li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="tab-pane fade in active col-md-12" id="admin-project-comments" class="show"></div>
						<div class="tab-pane fade in active col-md-12" id="admin-project-views" class="show"></div>
						<div class="tab-pane fade in active col-md-12" id="admin-project-ratings" class="show"></div>
						<div class="tab-pane fade in active col-md-12" id="admin-project-funds" class="show"></div>
						<div class="tab-pane fade in active col-md-12" id="admin-project-flags" class="show"></div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>