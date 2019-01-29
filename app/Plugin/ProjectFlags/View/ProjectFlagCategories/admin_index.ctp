<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">		
		<ul class="list-inline sec-1 navbar-btn">
			<li>	
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($approved,false).'</span><span>' .__l('Active'). '</span>', array('controller'=>'project_flag_categories','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Inactive'). '</span>', array('controller'=>'project_flag_categories','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
			</li>
			<li>
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($pending + $approved,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'project_flag_categories','action'=>'index'), array('class' => 'text-center','escape' => false));?>
			</li>
		</ul>		
	</div>
	<div class="clearfix">		
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp; <span class="badge"><i class="fa fa-plus"></i></span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<?php echo $this->element('paging_counter');?>
				</li>
			</ul>
		</div>		
		<?php
		echo $this->Form->create('ProjectFlagCategory' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax'));
		echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
		?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>      
						<th class="text-center col-sm-1"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('project_flag_count', sprintf(__l('%s Flags'), Configure::read('project.alt_name_for_project_singular_caps')));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($projectFlagCategories)):
					foreach ($projectFlagCategories as $projectFlagCategory):
					if($projectFlagCategory['ProjectFlagCategory']['is_active']):
					$status_class = 'js-checkbox-active';
					$disabled = '';
					else:
					$status_class = 'js-checkbox-inactive';
					$disabled = 'class="disabled"';
					endif;
					?>
					<tr <?php echo $disabled; ?>>
						<td  class="text-center"><?php echo $this->Form->input('ProjectFlagCategory.'.$projectFlagCategory['ProjectFlagCategory']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$projectFlagCategory['ProjectFlagCategory']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?></td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array( 'action'=>'edit', $projectFlagCategory['ProjectFlagCategory']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?></li>
									<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$projectFlagCategory['ProjectFlagCategory']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?></li>
									<?php echo $this->Layout->adminRowActions($projectFlagCategory['ProjectFlagCategory']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($projectFlagCategory['ProjectFlagCategory']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->cInt($projectFlagCategory['ProjectFlagCategory']['project_flag_count']); ?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="8" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s Flag Categories'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php
		if (!empty($projectFlagCategories)) : ?>
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
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Active'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Inactive'))); ?>
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
				<?php  echo $this->element('paging_links'); ?>
			</div>
		</div>
		<?php endif;
			echo $this->Form->end(); ?>
	</div>
	</div>		
</div>