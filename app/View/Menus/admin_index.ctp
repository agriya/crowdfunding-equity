<div class="main-admn-usr-lst js-response">
	<div class="alert alert-warning">
		<i class="fa fa-warning fa-fw"></i> <?php echo __l('Warning! Please edit with caution.'); ?>
	</div>
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?> &nbsp;
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').'&nbsp; <span class="badge"><i class="fa fa-plus"></i></span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('title', __l('Title')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('link_count', __l('Link Count')); ?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($menus)):
					foreach ($menus AS $menu) {
					?>
					<tr>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu dl pull-left">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user fa-fw"></i>'.__l('View links'), array('controller' => 'links', 'action'=>'index', $menu['Menu']['id']), array('class' => 'js-no-pjax','escape'=>false, 'title' => __l('View links')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'menus', 'action'=>'edit', $menu['Menu']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('controller' => 'menus','action'=>'delete', $menu['Menu']['id']), array('class' => 'js-confirm delete ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($menu['Menu']['id']); ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->link($this->Html->cText($menu['Menu']['title'], false), array('controller' => 'links', 'action' => 'index', $menu['Menu']['id']), array('title' => $this->Html->cText($menu['Menu']['title'], false)));?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($menu['Menu']['alias'], false);?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cInt($menu['Menu']['link_count'], false);?>
						</td>
					</tr>
					<?php
					}
					else:
					?>
					<tr>
						<td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Menus'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
