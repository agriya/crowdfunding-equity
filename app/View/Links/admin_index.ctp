<div class="main-admn-usr-lst js-response">
	<div class="links index">
		<div class="clearfix">
			<div class="navbar-btn">
				<h3>
					<i class="fa fa-th-list fa-fw"></i> <?php echo __l('Links'); ?>
					<?php echo $this->Html->link('<button type="button" class="btn btn-danger"><i class="fa fa-th-list fa-fw"></i>'.__l('Menus').'</button>', array('controller' => 'menus', 'action' => 'index'),array('title' =>  __l('Menus'), 'escape' => false));?>
					<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add Link').'<i class="fa fa-plus-circle fa-fw"></i></button>', array('action' => 'add', $menu['Menu']['id']),array('title' =>  __l('Add'), 'escape' => false));?>
				</h3>
				<div class="alert alert-warning">
					<i class="fa fa-exclamation-triangle"></i> <?php echo __l('Warning! Please edit with caution.'); ?>
				</div>
			</div>
			<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links','action' => 'update'))); ?>
			<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="text-center col-sm-1"><?php echo __l('Select'); ?></th>
							<th class="text-center  table-action-width"><?php echo __l('Actions'); ?></th>
							<th><?php echo __l('Title'); ?></th>
							<th class="text-center"><?php echo __l('Publish?'); ?></th>
						</tr>
					</thead>
					<tbody class="h6">
						<?php
						if (!empty($linksTree)):
						foreach ($linksTree AS $linkId => $linkTitle) {
						?>
						<tr>
							<td class="text-center"><?php echo $this->Form->input('Link. ' . $linkId . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $linkId, 'label' => '','class' => 'js-checkbox-list')); ?></td>
							<td class="text-center">
								<div class="dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
									<ul class="dropdown-menu">
										<li>
										<?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'links', 'action'=>'moveup', $linkId), array('class' => 'js-confirm move-up', 'escape' => false, 'title' => __l('Move Up')));?>
										</li>
										<li>
										<?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'links', 'action'=>'movedown', $linkId), array('class' => 'js-confirm move-down', 'escape' => false, 'title' => __l('Move Down')));?>
										</li>
										<li>
										<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>'.__l('Edit'), array('controller' => 'links', 'action'=>'edit', $linkId), array('escape' => false, 'title' => __l('Edit')));?>
										</li>
										<li>
										<?php echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete'), array('controller' => 'links', 'action'=>'delete', $linkId), array('class' => 'js-confirm', 'escape' => false, 'title' => __l('Delete')));?>
										</li>
										<?php echo $this->Layout->adminRowActions($linkId); ?>
									</ul>
								</div>
							</td>
							<td><?php echo $this->Html->cText($linkTitle);?></td>
							<td class="col-md-1 text-center"><?php echo $this->Html->link($this->Layout->status($linksStatus[$linkId]), array('controller' => 'links', 'action' => 'update_status', $linkId, 'status' => ($linksStatus[$linkId] == 1) ? 'inactive': 'active', 'menu_id' => $menu['Menu']['id']), array('class' => '', 'title' => $this->Html->cText($linkTitle, false), 'escape' => false));?></td>
						</tr>
						<?php
						}
						else:
						?>
						<tr>
							<td colspan="4" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Links'));?></td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
			<div class="page-sec navbar-btn">
				<?php if (!empty($linksTree)) { ?>
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
										<?php echo $this->Form->submit('Submit'); ?>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php
					}
					echo $this->Form->end();
				?>
			</div>
		</div>		
	</div>
</div>