<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($published_blogs,false).'</span><span>' .__l('Published'). '</span>', array('controller'=>'blogs','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false, 'title' => __l('Published')));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($suspended,false).'</span><span>' .__l('Suspended'). '</span>', array('controller'=>'blogs','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false, 'title' => __l('Suspended')));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($system_flagged,false).'</span><span>' .__l('Flagged'). '</span>', array('controller'=>'blogs','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false, 'title' => __l('Flagged')));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center agl-usr">'.$this->Html->cInt($published_blogs + $suspended + $system_flagged,false).'</span><span>' .__l('Total'). '</span>', array('controller'=>'blogs','action'=>'index'), array('escape' => false, 'title' => __l('Total')));?>
				</div>
			</li>
		</ul>
	</div>
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>&nbsp;
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').'&nbsp; <span class="badge"><i class="fa fa-plus"></i></span></button>', array('controller' => 'blogs', 'action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right">
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('Blog' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
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
		<?php
		  echo $this->Form->create('Blog' , array('class' => 'js-shift-click js-no-pjax','action' => 'update'));
		  echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
		?>
	
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center"><?php echo __l('Actions'); ?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('Project.name', __l(Configure::read('project.alt_name_for_project_singular_caps')));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('title', __l('Update'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('User.username', __l('Author'));?></th>
						<?php if(isPluginEnabled('ProjectUpdates')) : ?>
						<th class="text-center"><?php echo $this->Paginator->sort('blog_comment_count', __l('Comments'));?></th>
						<?php endif; ?>
						<th class="text-center"><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					$projectStatus = array();
					if (!empty($blogs)):
					foreach ($blogs as $blog):
					  $response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
						'projectStatus' => $projectStatus,
						'project' => $blog,
					  ));
					  $projectStatus = $response->data['projectStatus'];
					  if($blog['Blog']['is_published']):
						$status_class = 'js-checkbox-active';
					  else:
						$status_class = 'js-checkbox-inactive';
					  endif;
					  if($blog['Blog']['is_admin_suspended']):
						$status_class.= ' js-checkbox-suspended';
					  else:
						$status_class.= ' js-checkbox-unsuspended';
					  endif;
					  if($blog['Blog']['is_system_flagged']):
						$status_class.= ' js-checkbox-flagged';
					  else:
						$status_class.= ' js-checkbox-unflagged';
					  endif;
					?>
					<?php if(!empty($blog['Project']['id'])){ ?>
						<tr>
							<td class="text-center">
								<?php echo $this->Form->input('Blog.'.$blog['Blog']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$blog['Blog']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
							</td>
							<td class="text-center">
								<div class="dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
									<ul class="dropdown-menu">
										<li>
											<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action'=>'edit', $blog['Blog']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $blog['Blog']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
										</li>
										<li>
											<?php if($blog['Blog']['is_system_flagged']): ?>
											<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Clear Flag'), array('action' => 'admin_update_status', $blog['Blog']['id'], 'status' => 'unflag'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Clear Flag')));
											else:
											echo $this->Html->link('<i class="fa fa-flag fa-fw"></i>'.__l('Flag'), array('action' => 'admin_update_status', $blog['Blog']['id'], 'status' => 'flag'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Flag')));
											endif;?>
										</li>
										<li>
											<?php if($blog['Blog']['is_admin_suspended']):
											echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Unsuspend'), array('action' => 'admin_update_status', $blog['Blog']['id'], 'status' => 'unsuspend'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Unsuspend')));
											else:
											echo $this->Html->link('<i class="fa fa-undo fa-fw"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $blog['Blog']['id'], 'status' => 'suspend'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Suspend')));
											endif;?>
										</li>
										<?php echo $this->Layout->adminRowActions($blog['Blog']['id']);  ?>
									</ul>
								</div>
							</td>
							<td class="text-left">
								<i class="fa fa-sign-blank fa-fw" title="<?php echo $this->Html->cText($projectStatus[$blog['Project']['id']]['name'], false); ?>"></i> <span><?php echo $this->Html->link($this->Html->cText($blog['Project']['name'],false), array('controller' => 'projects', 'action' => 'view', $blog['Project']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($blog['Project']['name'],false)));?></span>
							</td>
							<td class="text-left">
								<div class="clearfix">
									<span>
									<?php echo $this->Html->link($this->Html->cText($blog['Blog']['title']), array('controller' => 'blogs', 'action' => 'view', $blog['Blog']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($blog['Blog']['title'],false)));?>
									</span>
									<?php if(!empty($blog['Blog']['is_admin_suspended']) || !empty($blog['Blog']['is_system_flagged']) || !empty($blog['Blog']['project_flag_count']) || !empty($blog['Blog']['is_published'])): ?>
										<ul class="filter-list-block list-unstyled row">
									<?php endif; ?>
										<?php
										if($blog['Blog']['is_admin_suspended']):
										echo '<li class="pull-left text-center"><span class="label label-danger">'.__l('Admin Suspended').'</span></li>';
										endif;
										if($blog['Blog']['is_system_flagged']):
										echo '<li class="pull-left text-center"><span class="label label-warning">'.__l('System Flagged').'</span></li>';
										endif;
										if(!empty($blog['Blog']['project_flag_count'])) :
										echo '<li class="pull-left text-center"><span class="label label-info">'.__l('User Flagged').'</span></li>';
										endif;
										if($blog['Blog']['is_published']) :
										echo '<li class="pull-left text-center"><span class="label label-success">'.__l('Published').'</span></li>';
										endif;
										?>
									<?php if(!empty($blog['Blog']['is_admin_suspended']) || !empty($blog['Blog']['is_system_flagged']) || !empty($blog['Blog']['project_flag_count']) || !empty($blog['Blog']['is_published'])): ?>
										</ul>
									<?php endif; ?>
								</div>
							</td>
							<td class="text-left">
								<ul class="list-inline tbl">
									<li class="tbl-img">
										<?php echo $this->Html->getUserAvatar($blog['User'], 'micro_thumb',true, '', 'admin');?>
									</li>
									<li class="tbl-cnt">
										<p>
											<?php echo $this->Html->getUserLink($blog['User']); ?>
										</p>
									</li>
								</ul>
							</td>
							<?php if(isPluginEnabled('ProjectUpdates')) : ?>
							<td class="text-center">
								<?php echo $this->Html->link($this->Html->cInt($blog['Blog']['blog_comment_count']), array('controller' => 'blog_comments', 'action' => 'index', 'blog' => $blog['Blog']['id']), array('escape' => false));?>
							</td>
							<?php endif; ?>
							<td class="text-center">
								<?php echo $this->Html->cDateTimeHighlight($blog['Blog']['modified']);?>
							</td>
						</tr>
					<?php } ?>
					<?php
					endforeach;
					else:
					?>
						<tr>
							<td colspan="9" class="text-center"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Updates'));?></td>
						</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php
			if (!empty($blogs)):
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'text-info js-select js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'text-info js-select js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'text-info js-select js-no-pjax {"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"}', 'title' => __l('Suspended'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'text-info js-select js-no-pjax {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"}', 'title' => __l('Flagged'))); ?>
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

