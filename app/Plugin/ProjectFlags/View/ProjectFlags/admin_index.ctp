<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
		<?php if(empty($this->request->params['named']['view_type'])) : ?>
		<h3>
			<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
		</h3>
		<?php endif; ?>
		<ul class="list-unstyled clearfix">
			<li class="pull-left"> 
				<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
			</li>
		</ul>		
		<?php echo $this->Form->create('ProjectFlag' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="select text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Action');?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'js-no-pjax js-filter'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('Project.name', __l(Configure::read('project.alt_name_for_project_singular_caps')), array('class' => 'js-no-pjax js-filter'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('ProjectFlagCategory.name', __l('Flag Category'), array('class' => 'js-no-pjax js-filter'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('message', __l('Message'), array('class' => 'js-no-pjax js-filter'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'), array('class' => 'js-no-pjax js-filter'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
						$projectStatus = array();
						if (!empty($projectFlags)):
						foreach ($projectFlags as $projectFlag):
						$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
						'projectStatus' => $projectStatus,
						'project' => $projectFlag,
						));
						$projectStatus = $response->data['projectStatus'];
					?>
					<?php if(!empty($projectFlag['Project']['id'])){ ?>  
						<tr>
							<td class="select text-center">
								<?php echo $this->Form->input('ProjectFlag.'.$projectFlag['ProjectFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$projectFlag['ProjectFlag']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?>
							</td>
							<td class="text-center">
								<div class=" dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
									<ul class="dropdown-menu">
										<li>
											<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $projectFlag['ProjectFlag']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
										</li>
										<?php echo $this->Layout->adminRowActions($projectFlag['ProjectFlag']['id']);  ?>
									</ul>
								</div>  
							</td>
							<td class="text-left">
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($projectFlag['User'], 'micro_thumb',true, '', 'admin');?>
									</div>
									<div class="media-body">
										<p>
										<?php echo $this->Html->getUserLink($projectFlag['User']); ?>
										</p>
									</div>
								</div>
							</td>
							<td class="text-left">
								<div class="clearfix htruncate">
								<i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$projectFlag['Project']['id']]['id'], false); ?>" title="<?php echo $this->Html->cText($projectStatus[$projectFlag['Project']['id']]['name'], false); ?>"></i> 
								<?php echo $this->Html->link($this->Html->cText($projectFlag['Project']['name']), array('controller'=> 'projects', 'action'=>'view', $projectFlag['Project']['slug'], 'admin' => false),array('escape' => false,'title'=>$this->Html->cText($projectFlag['Project']['name'],false)));?>
								</div>
							</td>
							<td class="text-center">
								<?php echo $this->Html->cText($projectFlag['ProjectFlagCategory']['name']); ?>
							</td>
							<td class="text-center">
								<div class="js-tooltip" title="<?php echo $this->Html->cText($projectFlag['ProjectFlag']['message'], false);?>">
									<?php echo $this->Html->cText($projectFlag['ProjectFlag']['message']);?>
								</div>
							</td>
							<td class="text-center">
								<?php if(!empty($projectFlag['Ip']['ip'])): ?>
									<?php echo  $this->Html->link($projectFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $projectFlag['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$this->Html->cText($projectFlag['Ip']['ip'],false), 'escape' => false)); ?>
									<p>
										<?php if(!empty($projectFlag['Ip']['Country'])): ?>
										<span class="flags flag-<?php echo strtolower($projectFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($projectFlag['Ip']['Country']['name'], false); ?>"><?php echo $this->Html->cText($projectFlag['Ip']['Country']['name'], false); ?></span>
										<?php endif; ?>
										<?php if(!empty($projectFlag['Ip']['City'])): ?>
										<span><?php echo $this->Html->cText($projectFlag['Ip']['City']['name'], false); ?></span>
										<?php endif; ?>
									</p>
								<?php else: ?>
									<?php echo __l('n/a'); ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php } ?>
						<?php
						endforeach;
						else:
						?>
							<tr>
							<td colspan="7" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s Flags'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
							</tr>
						<?php
						endif;
						?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn col-xs-12">
			<?php if (!empty($projectFlag)) { ?>
			<div class="row">			
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
			<?php } ?>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
	
</div>
