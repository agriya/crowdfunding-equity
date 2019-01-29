<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">	
		<h3><i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?></a></h3>
		<ul class="list-unstyled clearfix">
			<li class="pull-left"> 
				<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
			</li>
			<li class="pull-right"> 
				<div class="form-group srch-adon">
					<?php echo $this->Form->create('ProjectFollower' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
					<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
					<?php echo $this->Form->input('q', array('label' => false,'placeholder' => __l('Search'), 'class' => 'form-control')); ?>
					<div class="hide">
					<?php echo $this->Form->submit(__l('Search'));?>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</li>
		</ul>			
		<?php echo $this->Form->create('ProjectFollower' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<?php if(empty($this->request->params['named']['view_type'])) :?>
							<th class="select text-center col-sm-1"><?php echo __l('Select'); ?></th>
						<?php endif; ?>
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center">
							<div><?php echo $this->Paginator->sort('Project.name', __l(Configure::read('project.alt_name_for_project_singular_caps')));?></div>
						</th>
						<th><div><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
					 </tr>
				</thead>
				<tbody class="h5">
					<?php
					$projectStatus = array();
					if (!empty($projectFollowers)):
						foreach ($projectFollowers as $projectFollower):
							$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
							'projectStatus' => $projectStatus,
							'project' => $projectFollower,
							));
							$projectStatus = $response->data['projectStatus'];
							?>
							<tr>
								<?php if(empty($this->request->params['named']['view_type'])) :?>
									<td class="select text-center">
										<?php echo $this->Form->input('ProjectFollower.'.$projectFollower['ProjectFollower']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$projectFollower['ProjectFollower']['id'], 'label' => '', 'class' =>' js-checkbox-list')); ?>
									</td>
								<?php endif; ?>
								<td class="text-center">
									<div class="dropdown">
										<a href="#" title="Actions" data-toggle="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
										<ul class="dropdown-menu">
											<li>
												<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $projectFollower['ProjectFollower']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
											</li>
											<?php echo $this->Layout->adminRowActions($projectFollower['ProjectFollower']['id']);  ?>
										</ul>
									</div>
								</td>
								<td class="text-center">
										<i class="fa fa-sign-blank project-status-<?php echo $projectStatus[$projectFollower['Project']['id']]['id']; ?>" title="<?php echo $this->Html->cText($projectStatus[$projectFollower['Project']['id']]['name'], false); ?>"></i> 
										<?php echo $this->Html->link($this->Html->cText($projectFollower['Project']['name']), array('controller'=> 'projects', 'action'=>'view', $projectFollower['Project']['slug'],'admin' => false), array('escape' => false,'title'=>$this->Html->cText($projectFollower['Project']['name'],false)));?>
								</td>
								<td class="text-left">
									<div class="media">
										<div class="pull-left">
											<?php echo $this->Html->getUserAvatar($projectFollower['User'], 'micro_thumb',true, '', 'admin');?>
										</div>
										<div class="media-body">
											<p>
											<?php echo $this->Html->getUserLink($projectFollower['User']); ?>
											</p>
										</div>
									</div>
								</td>
								<td class="text-center">
									<?php echo $this->Html->cDateTimeHighlight($projectFollower['ProjectFollower']['created']);?>
								</td>
							</tr>
					<?php
						endforeach;
					else:
					?>
					<tr>
						<td colspan="9" class="text-center text-dabger"><i class="fa fa-warning fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Followers'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>			
		<div class="page-sec navbar-btn">
			<?php
			if (!empty($projectFollowers)) : 
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">					
					<ul class="list-inline clearfix">
						<?php if(empty($this->request->params['named']['view_type'])) :?>
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
						</li>
						<li>
							<div class="admin-checkbox-button">
								<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
								<div class="hide">
									<?php echo $this->Form->submit('Submit');  ?>
								</div>
							</div>
						</li>
						<?php endif; ?>
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
