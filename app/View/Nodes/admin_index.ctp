<div class="main-admn-usr-lst js-response">
	<div class="alert alert-warning"><?php echo __l('Warning! Please edit with caution.'); ?></div>
	<div class="alert alert-info"><?php echo __l('Terminologies used in this CMS are synonymous with Drupal'); ?></div>
    <?php echo $this->element('admin/nodes_filter'); ?>
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?> &nbsp;
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').'&nbsp; <span class="badge"><i class="fa fa-plus"></i></span></button>', array('controller' => 'nodes', 'action' => 'add', 'page'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right"> 
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('Node' , array('url' => Router::url('/', true) . $this->request->url, 'class' => 'form-search')); ?>
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
		<?php echo $this->Form->create('Node', array('class'=>'js-shift-click js-no-pjax','url' => array('controller' => 'nodes','action' => 'update'))); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>          
						<th class="text-center col-sm-1"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('title', __l('Title'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('type', __l('Type'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('status', __l('Status'));?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($nodes)):
					$rows = array();
					foreach ($nodes AS $node) {
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Form->input('Node.' . $node['Node']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $node['Node']['id'], 'label' => '','class' => 'js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu pull-left">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'nodes', 'action' => 'edit', $node['Node']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('controller' => 'nodes', 'action' => 'delete', $node['Node']['id']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($node['Node']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->link($node['Node']['title'], array('controller' => 'nodes', 'action' => 'view', 'type' => $node['Node']['type'], 'slug' => $node['Node']['slug'], 'admin' => false), array('title' => $node['Node']['title']));?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($node['Node']['type'], false);?>
						</td>
						<td class="text-center">
							<?php
							$publish = ($node['Node']['status'] == 1) ? __l('Publish') : __l('Unpublish');
							echo $this->Html->link($this->Layout->status($node['Node']['status']) . ' ' . $publish, array('controller' => 'nodes', 'action' => 'update_status', $node['Node']['id'], 'status' => ($node['Node']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm js-no-pjax', 'title' => $publish, 'escape' => false));?>
						</td>
					</tr>
					<?php
					}
					else:
					?>
					<tr>
						<td colspan="5" class="text-center text-danger">
							<i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Nodes'));?>
						</td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
			<?php
				if (!empty($nodes)) {
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">	
					<ul class="list-inline">
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
			<?php
			}
			echo $this->Form->end();
			?>
		</div>
	</div>	
</div>
