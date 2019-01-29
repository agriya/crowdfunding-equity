<div class="main-admn-usr-lst js-response">
	<div class="alert alert-warning">
		<i class="fa fa-exclamation-triangle"></i> <?php echo __l('Warning! Please edit with caution.'); ?>
	</div>
	<div class="clearfix">		
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i><?php echo __l('List'); ?>
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp; <span class="badge"><i class="fa fa-plus"></i> </span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
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
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('title', __l('Title')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($vocabularies)):
					foreach ($vocabularies AS $vocabulary) {
					?>
					<tr>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user fa-fw"></i> '.__l('View Terms'), array('controller' => 'terms', 'action' => 'index', $vocabulary['Vocabulary']['id']), array('class' => '','escape'=>false, 'title' => __l('View Terms')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-arrow-up"></i>'.__l('Move Up'), array('controller' => 'vocabularies', 'action' => 'moveup', $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Move Up')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-arrow-down"></i>'.__l('Move Down'), array('controller' => 'vocabularies', 'action' => 'movedown', $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Move Down')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array( 'action'=>'edit', $vocabulary['Vocabulary']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('action'=>'delete',$vocabulary['Vocabulary']['id']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($vocabulary['Vocabulary']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center"><?php echo $this->Html->cText($vocabulary['Vocabulary']['title']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($vocabulary['Vocabulary']['alias']);?></td>
					</tr>
					<?php
					}
					else:
					?>
					<tr>
						<td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Vocabularies'));?></td>
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
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
	</div>
</div>