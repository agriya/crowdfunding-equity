<div class="main-admn-usr-lst js-response">
	<div class="terms index">
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'), array('title' => __l('Vocabularies')));?><span class="divider">&raquo;</span></li>
			<li class="active"><?php echo __l('Terms');?></li>
		</ul>
		<ul class="nav nav-tabs">
			<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' =>  __l('Vocabularies'), 'escape' => false));?>
			</li>
			<li class="active"><a href="#"><i class="fa fa-th-list fa-fw"></i><?php echo __l('Vocabulary'); ?></a></li>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i>'.__l('Add'), array('action' => 'add', $vocabulary['Vocabulary']['id']),array('title' =>  __l('Add'), 'escape' => false));?>
			</li>
		</ul>
		<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> <?php echo __l('Warning! Please edit with caution.'); ?></div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center"><?php echo __l('Actions'); ?></th>
						<th><?php echo __l('Title'); ?></th>
						<th><?php echo __l('Slug'); ?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($termsTree)):
					foreach ($termsTree AS $id => $title) {
					?>
					<tr>
						<td class="col-md-1 text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" class="fa fa-cog dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
								<ul class="list-unstyled dropdown-menu text-left clearfix">
									<li><?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'terms', 'action' => 'moveup', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Move Up'),'escape' => false));?></li>
									<li><?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'terms', 'action' => 'movedown', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Move Down'),'escape' => false));?></li>
									<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'terms', 'action' => 'edit', $id, $vocabulary['Vocabulary']['id']), array('title' => __l('Edit'), 'escape' => false));?></li>
									<li><?php echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete'), array('controller' => 'terms', 'action' => 'delete', $id, $vocabulary['Vocabulary']['id']), array('class' => 'js-confirm', 'title' => __l('Delete'),'escape' => false));?></li>
									<?php echo $this->Layout->adminRowActions($id);  ?>
								</ul>
							</div>
						</td>
						<td><?php echo $this->Html->cText($title);?></td>
						<td><?php echo $this->Html->cText($terms[$id]['slug']);?></td>
					</tr>
					<?php
					}
					else:
					?>
					<tr>
						<td colspan="3" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Terms'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
