<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
			<div class="navbar-btn">
				<h3>
					<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>
				</h3>	
				<ul class="list-unstyled clearfix">
					<li class="pull-left"> 
						<p><?php echo $this->element('paging_counter');?></p>
					</li>
				</ul>
			</div>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('equity_count', __l(Configure::read('project.alt_name_for_project_plural_caps')));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($projectStatuses)):
					foreach ($projectStatuses as $projectStatus):
					$project_count = !empty($projectStatus['Equity'])?count($projectStatus['Equity']):'0';
					?>
					<tr>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
										<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array( 'action'=>'edit', $projectStatus['EquityProjectStatus']['id']), array('class' => ' ','escape'=>false, 'title' => __l('Edit')));?>
									</li>
										<?php echo $this->Layout->adminRowActions($projectStatus['EquityProjectStatus']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($projectStatus['EquityProjectStatus']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->link($this->Html->cInt($projectStatus['EquityProjectStatus']['equity_count']), array('controller' => 'equities', 'action' => 'index', 'project_status_id' => $projectStatus['EquityProjectStatus']['id']), array('escape' => false));?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="7"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s %s Statuses'), Configure::read('project.alt_name_for_equity_singular_caps'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>		
	<div class="page-sec navbar-btn">
		<div class="row">
			<?php
			if (!empty($projectStatuses)) : ?>
				<div class="col-xs-12 col-sm-6 pull-right">
					<?php echo $this->element('paging_links'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
