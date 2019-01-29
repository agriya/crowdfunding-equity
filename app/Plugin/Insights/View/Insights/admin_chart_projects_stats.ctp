<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead class="h5">
			<tr>
				<th class="text-center" colspan="2"></th>
				<th class="text-center"><?php echo __l('Min');?></th>
				<th class="text-center"><?php echo __l('Max');?></th>
			</tr>
		</thead>
		<tbody class="h5">
			<tr>
				<td class="text-center" rowspan="3"><?php echo __l('Offered');?></td>
				<td class="text-center"><?php echo __l('Needed Amount').' ('.Configure::read('site.currency').')';?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['needed_amount']['min']);?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['needed_amount']['max']);?></td>
			</tr>
			<tr>
				<td class="text-center"><?php echo __l('Collected Amount').' ('.Configure::read('site.currency').')';?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['collected_amount']['min']);?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['collected_amount']['max']);?></td>
			</tr>
			<tr>
				<td class="text-center"><?php echo __l('Site Commission').' ('.Configure::read('site.currency').')';?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['commission_amount']['min']);?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($projects_stats['commission_amount']['max']);?></td>
			</tr>
		</tbody>
	</table>
</div>	