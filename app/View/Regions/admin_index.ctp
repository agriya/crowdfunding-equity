<section class="main-admn-usr-lst js-response">
	<div class="regions index">
		<div class="clearfix">
			<div class="navbar-btn">
				<ul class="list-unstyled clearfix">
					<li class="pull-left"> 
						<p><?php echo $this->element('paging_counter');?></p>
					</li>
					<li class="pull-right"> 
						<?php echo $this->Html->link(__l('Add Region'), array('controller' => 'regions', 'action' => 'add'), array('title' => __l('Add Region'))); ?>
					</li>
				</ul>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo __l('Actions'); ?></th>
							<th><div><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
							<th><div><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
						</tr>
					</thead>
					<tbody class="h6">
						<?php
						if (!empty($regions)):
						foreach ($regions AS $region) {
						?>
						<tr>
							<td>
								<div>
								<span>
								<span>&nbsp;
								</span>
								<span>
								<span>
								<?php echo __l('Action');?>
								</span>
								</span>
								</span>
								<div>
								<div>
								<ul class="clearfix">
								<li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'regions', 'action' => 'edit', $region['Region']['id']), array('title' => __l('Edit')));?>
								</li>
								<li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'regions', 'action' => 'delete', $region['Region']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?>
								</li>
								<?php echo $this->Layout->adminRowActions($region['Region']['id']);  ?>
								</ul>
								</div>
								<div></div>
								</div>
								</div>
							</td>
							<td><?php echo $this->Html->cText($region['Region']['title']);?></td>
							<td><?php echo $this->Html->cText($region['Region']['alias']);?></td>
						</tr>
						<?php
						}
						else:
						?>
						<tr>
							<td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Regions'));?></td>
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
</div>