<div class="main-admn-usr-lst js-response">
	<div class="alert alert-warning">
		<i class="fa fa-exclamation-triangle"></i>
		<?php echo __l('Warning! Please edit with caution.'); ?>
	</div>
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-fw fa-th-list"></i> <?php echo __l('List');?>
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
						<th class="text-center"><?php echo $this->Paginator->sort('title', __l('Title')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Region.title', __l('Region')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('status', __l('Status')); ?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($blocks)):
					foreach ($blocks AS $block) {
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Html->cText(__l($block['Block']['title']));?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText(__l($block['Region']['title']), false);?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->link($this->Layout->status($block['Block']['status']), array('controller' => 'blocks', 'action' => 'update_status', $block['Block']['id'], 'status' => ($block['Block']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm js-no-pjax', 'title' => __l($block['Block']['title']), 'escape' => false));?>
						</td>
					</tr>
					<?php }
					else: ?>
					<tr>
						<td colspan="5" class="text-center text-danger">
						<i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Blocks'));?>
						</td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>