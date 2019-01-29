<?php /* SVN: $Id: admin_index.ctp 2873 2010-08-27 10:43:10Z sakthivel_135at10 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
		<?php if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'admin_view') { ?>
		<h3><i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?></a></h3>
		<?php } ?>
		<ul class="list-unstyled clearfix">
			<li class="pull-left"> 
				<p><?php echo $this->element('paging_counter');?></p>
			</li>
			<li class="pull-right"> 
				<div class="form-group srch-adon">
					<?php if(empty($this->request->params['named']['view_type'])) : ?>
						<?php echo $this->Form->create('ProjectRating' ,array('url' => array('controller' => 'project_ratings','action' => 'index')), array('type' => 'get', 'class' => 'form-search')); ?>
						<span class="form-control-feedback" id="basic-addon1"  aria-hidden="true"><i class="fa fa-search text-default"></i></span>
						<?php
						if (!empty($this->request->params['named']['q'])) {
							echo $this->Form->input('q', array('label' => false, 'value' => sprintf(__l('%s'), $this->request->params['named']['q']), 'class' => 'form-control'));
						} else {
							echo $this->Form->input('q', array('label' => false, 'placeholder' => __l('Search'), 'class' => 'form-control'));
						}
						?>
						<div class="hide">
							<?php echo $this->Form->submit(__l('Search'));?>
						</div>
						<?php echo $this->Form->end(); ?>
						<?php endif; ?>
				</div>
			</li>
		</ul>			
		<?php echo $this->Form->create('ProjectRating' , array('class' => 'clearfix','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<?php if(empty($this->request->params['named']['view_type'])) :?>
							<th class="select text-center col-sm-1"><?php echo __l('Select'); ?></th>
						<?php endif; ?>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<?php if(empty($this->request->params['named']['view_type'])) : ?>
						  <th><div><?php echo $this->Paginator->sort('Project.name', Configure::read('project.alt_name_for_project_singular_caps'), array('class' => 'js-no-pjax js-filter'));?></div></th>
						<?php endif; ?>
						<th class="text-left "><div><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'js-no-pjax js-filter'));?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('rating', __l('Voting'), array('class' => 'js-no-pjax js-filter'));?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('created', __l('Voted on'), array('class' => 'js-no-pjax js-filter'));?></div></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					$projectStatus = array();
					if (!empty($projectRatings)):
						foreach ($projectRatings as $projectRating):
							$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
								'projectStatus' => $projectStatus,
								'project' => $projectRating,
							));
							$projectStatus = $response->data['projectStatus'];
					?>
					<?php if(!empty($projectRating['Project']['id'])){ ?> 
					<tr> 
						<?php if(empty($this->request->params['named']['view_type'])) :?>
						<td class="select text-center"><?php echo $this->Form->input('ProjectRating.'.$projectRating['ProjectRating']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$projectRating['ProjectRating']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?></td>
						<?php endif; ?>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
										<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $projectRating['ProjectRating']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
								</ul>
							<?php echo $this->Layout->adminRowActions($projectRating['ProjectRating']['id']); ?>
							</div>
						</td>
						<?php if(empty($this->request->params['named']['view_type']) && !empty($projectRating['Project'])) : ?>
						<td class="text-left"> 
							<div class="clearfix htruncate"><i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$projectRating['Project']['id']]['id'], false); ?>" title="<?php echo $projectStatus[$projectRating['Project']['id']]['name']; ?>"></i> <?php echo $this->Html->link($this->Html->cText($projectRating['Project']['name']), array('controller'=> 'projects', 'action'=>'view', $projectRating['Project']['slug'],'admin' => false), array('escape' => false,'title'=>$this->Html->cText($projectRating['Project']['name'],false)));?></div>
						</td>
						<?php endif; ?>
						<td class="text-left">
							<div class="media">
								<div class="pull-left">
									<?php echo $this->Html->getUserAvatar($projectRating['User'], 'micro_thumb',true, '', 'admin');?>
								</div>
								<div class="media-body">
									<p><?php echo $this->Html->getUserLink($projectRating['User']); ?></p>
								</div>	
							</div>
						</td>
						<td class="text-center"><?php echo $this->Html->link($this->Html->cInt($projectRating['ProjectRating']['rating']), array('controller' => 'projects', 'action' => 'view', $projectRating['Project']['slug'], '#voters','admin' => false), array('escape' => false));?></td>
						<td class="text-center"><?php echo $this->Html->cDateTimeHighlight($projectRating['ProjectRating']['created']);?></td>
					</tr>
					<?php } ?> 
					<?php 
						endforeach;
					else:
					?>
					<tr>
						<td colspan="7"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s Votings'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
					</tr>
					<?php
						endif;
					?>
				</tbody>
			</table>				
		</div>
		<div class="page-sec navbar-btn">
		<?php
			if (!empty($projectRatings)) : 
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