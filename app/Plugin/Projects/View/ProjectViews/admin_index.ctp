<?php /* SVN: $Id: admin_index.ctp 2857 2010-08-27 05:22:44Z sakthivel_135at10 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix userViews js-response pledge">		
		<div class="navbar-btn">
			<?php if (empty($this->request->params['named']['view_type'])) {?>
				<h3>
					<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>
				</h3>
			<?php } ?>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
				<ul class="list-unstyled clearfix">
					<li class="pull-left"> 
						<p class="navbar-btn"><?php echo $this->element('paging_counter'); ?></p>
					</li>
					<li class="pull-right"> 
						<div class="srch-adon"> 
							<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
								<?php echo $this->Form->create('ProjectView' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?> 
								<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control')); ?>
								<div class="hide"> <?php echo $this->Form->submit(__l('Search'));?> </div>
								<?php echo $this->Form->end(); ?> 
						</div>						
					</li>
				</ul>
			</div>	
			<?php endif; ?>				
			<?php echo $this->Form->create('ProjectView' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>			
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="h5">
						<tr>
							<?php if(empty($this->request->params['named']['view_type'])) : ?>
							<th class="select text-center col-sm-1"><?php echo __l('Select'); ?></th>
							<?php endif; ?>
							<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
							<?php if(empty($this->request->params['named']['view_type'])) : ?>
							<th class="text-left"><div><?php echo $this->Paginator->sort('Project.name', Configure::read('project.alt_name_for_project_singular_caps'));?></div></th>
							<?php endif; ?>
							<th><div><?php echo $this->Paginator->sort('User.username', __l('Viewed By'), array('class' => 'js-no-pjax js-filter'));?></div></th>
							<th class="text-center"><?php echo __l('View Type'); ?></th>
							<th class="text-center"><div><?php echo $this->Paginator->sort('Ip.ip', __l('IP'));?></div></th>
							<th class="text-center"><div><?php echo $this->Paginator->sort('created', __l('Viewed On'), array('class' => 'js-no-pjax js-filter'));?></div></th>
						</tr>
					</thead>
					<tbody class="h5">
						<?php
						$projectStatus = array();
						if (!empty($projectViews)):
							foreach ($projectViews as $projectView):
							$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
							'projectStatus' => $projectStatus,
							'project' => $projectView,
							));
							$projectStatus = $response->data['projectStatus'];
							?>
						<tr>
							<?php if(empty($this->request->params['named']['view_type'])) : ?>
								<td class="select text-center"><?php echo $this->Form->input('ProjectView.'.$projectView['ProjectView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$projectView['ProjectView']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?></td>
							<?php endif; ?>
							<td class="text-center">
								<div class="dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
									<ul class="dropdown-menu">
										<li> <?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action' => 'delete', $projectView['ProjectView']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm  ', 'escape'=>false,'title' => __l('Delete')));?> </li>
										<?php echo $this->Layout->adminRowActions($projectView['ProjectView']['id']);  ?>
									</ul>
								</div>
							</td>
							<?php if(empty($this->request->params['named']['view_type'])) : ?>
							<td class="text-left"><div class="clearfix htruncate"><i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$projectView['Project']['id']]['id'], false); ?>" title="<?php echo $this->Html->cText($projectStatus[$projectView['Project']['id']]['name'], false); ?>"></i> <span><?php echo $this->Html->link($this->Html->cText($projectView['Project']['name'],false), array('controller'=> 'projects', 'action'=>'view', $projectView['Project']['slug'], 'admin' => false), array('escape' => false,'class'=>'js-tooltip','title' => $this->Html->cText($projectView['Project']['name'],false)));?></span> </div></td>
							<?php endif; ?>
							<td class="text-left">
								<?php if(!empty($projectView['User']['username'])) { ?>
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($projectView['User'], 'micro_thumb',true, '', 'admin');?>
									</div>
									<div class="media-body">
										<p><?php echo $this->Html->getUserLink($projectView['User']); ?></p>
									</div>
								</div>
							</td>
							<?php } else {
								echo '<span class="pull-left">'.__l('Guest').'</span>';
							} ?>
							</td>
							<td class="text-center"><?php echo ($projectView['ProjectView']['project_view_type_id'] == ConstViewType::EmbedView)?__l('Embed'):__l('Normal');?> </td>
							<td class="text-center"><?php if(!empty($projectView['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($projectView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $projectView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$projectView['Ip']['ip'], 'escape' => false)); ?>
							<p class="list-group-item-text">
							<?php
							if(!empty($projectView['Ip']['Country'])):
							?>
							<span class="flags flag-<?php echo strtolower($projectView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($projectView['Ip']['Country']['name'], false); ?>"> <?php echo $this->Html->cText($projectView['Ip']['Country']['name'], false); ?> </span>
							<?php
							endif;
							if(!empty($projectView['Ip']['City'])):
							?>
							<span> <?php echo $this->Html->cText($projectView['Ip']['City']['name'], false); ?> </span>
							<?php endif; ?>
							</p>
							<?php else: ?>
							<?php echo __l('n/a'); ?>
							<?php endif; ?>
							</td>
							<td class="text-center"><?php echo $this->Html->cDateTimeHighlight($projectView['ProjectView']['created']);?></td>
						</tr>
						<?php
						endforeach;
						else:
						?>
						<tr>
							<td colspan="7"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s Views'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
			<div class="page-sec navbar-btn">
			<?php
			if (!empty($projectViews)) :
			?>
			<div class="row">
				<?php if(empty($this->request->params['named']['view_type'])) : ?>
				<div class="col-xs-12 col-sm-6 pull-left">
					<ul class="list-inline clearfix">
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
						</li>
						<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
							<div class="hide">
								<?php echo $this->Form->submit('Submit'); ?>
							</div>
						</div>
						</li>
					</ul>
				</div>
				<?php endif; ?>
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

