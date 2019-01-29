<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead class="h5">
			<tr>
				<th class="text-center" rowspan="2"><?php echo __l('Price Point');?></th>
				<th class="text-center" colspan="3"><?php echo __l('Total');?></th>
				<th class="text-center" colspan="4"><?php echo __l('Average');?></th>
			</tr>
			<tr>
				<th class="text-center"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')';?></th>
				<th class="text-center"><?php echo '# ' . Configure::read('project.alt_name_for_project_plural_caps');?></th>
				<th class="text-center"><?php echo sprintf(__l('# %s Funds'), Configure::read('project.alt_name_for_project_singular_caps'));?></th>
				<th class="text-center"><?php echo sprintf(__l('%s Funds'), Configure::read('project.alt_name_for_project_singular_caps')) . '/' . Configure::read('project.alt_name_for_project_plural_caps');?></th>
				<th class="text-center"><?php echo __l('Revenue'). '/' . Configure::read('project.alt_name_for_project_plural_caps') . ' (' . Configure::read('site.currency') . ')';?></th>
			</tr>
		</thead>
		<tbody class="h5">
			<?php
			if (!empty($pricePoints)):
			foreach ($pricePoints as $pricePoint):
			?>
			<tr>
				<td class="text-center"><?php echo $this->Html->cText($pricePoint['price_points']);?></td>
				<td class="text-center"><?php echo $this->Html->cCurrency($pricePoint['revenue']);?></td>
				<td class="text-center"><?php echo $this->Html->cInt($pricePoint['projects_count']);?></td>
				<td class="text-center"><?php echo $this->Html->cInt($pricePoint['funds']);?></td>
				<td class="text-center"><?php echo $this->Html->cFloat($pricePoint['average_project_fund_count']);?></td>
				<td class="text-center"><?php echo $this->Html->cFloat($pricePoint['average_revenue_project_amoumt']);?></td>
			</tr>
			<?php
			endforeach;
			else:
			?>
			<tr>
				<td colspan="11"><i class="fa fa-exclamation-triangle"></i><?php echo sprintf(__l('No %s available'), __l('Stats'));?></td>
			</tr>
			<?php
			endif;
			?>
		</tbody>
	</table>
</div>	
<div class="clearfix">
	<div class="js-load-column-chart chart-half-section {'data_container':'total_revenue_column_data', 'chart_container':'total_revenue_column_chart', 'chart_title':'<?php echo __l('Total Revenue by Price Point') ;?>', 'chart_y_title': '<?php echo __l('Total Revenue');?>'}">
		<div class="col-md-6 clearfix">
			<div id="total_revenue_column_chart"></div>
			<div class="hide">
				<table id="total_revenue_column_data" class="list">
					<tbody>
					<?php foreach($pricePoints as $pricePoint): ?>
					<tr>
						<th><?php echo $pricePoint['price_points']; ?></th>
						<td><?php echo $this->Html->cCurrency($pricePoint['revenue'], false); ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="js-load-column-chart chart-half-section {'data_container':'total_fund_column_data', 'chart_container':'total_fund_column_chart', 'chart_title':'<?php echo sprintf(__l('Total %s Funds by Price Point'), Configure::read('project.alt_name_for_project_singular_caps'));?>', 'chart_y_title': '<?php echo __l('Total Funds');?>'}">
		<div class="col-md-6 clearfix">
			<div id="total_fund_column_chart"></div>
			<div class="hide">
				<table id="total_fund_column_data" class="list">
					<tbody>
					<?php foreach($pricePoints as $pricePoint): ?>
					<tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $this->Html->cInt($pricePoint['funds'], false); ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="clearfix">
	<div class="js-load-column-chart chart-half-section {'data_container':'total_avg_revenue_column_data', 'chart_container':'total_avg_revenue_column_chart', 'chart_title':'<?php echo sprintf(__l('Avg Revenue per %s by Price Point'), Configure::read('project.alt_name_for_project_singular_caps')); ?>', 'chart_y_title': '<?php echo sprintf(__l('Avg Revenue per %s'), Configure::read('project.alt_name_for_project_singular_caps')); ?>'}">
		<div class="col-md-6 clearfix">
			<div id="total_avg_revenue_column_chart" class="project-price-point-chart"></div>
				<div class="hide">
					<table id="total_avg_revenue_column_data" class="list">
					<tbody>
					<?php foreach($pricePoints as $pricePoint): ?>
					<tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $this->Html->cFloat($pricePoint['average_revenue_project_amoumt'], false); ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
		</div>
	</div>
	<div class="js-load-column-chart chart-half-section {'data_container':'total_avg_funds_column_data', 'chart_container':'total_avg_funds_column_chart', 'chart_title':'<?php echo sprintf(__l('Avg Projects Funded per %s by Price Point'), Configure::read('project.alt_name_for_project_singular_caps')); ?>', 'chart_y_title': '<?php echo sprintf(__l('Avg %s Fund per %s'), Configure::read('project.alt_name_for_project_singular_caps'), Configure::read('project.alt_name_for_project_singular_caps'));?>'}">
		<div class="col-md-6 clearfix">
			<div id="total_avg_funds_column_chart"></div>
			<div class="hide">
				<table id="total_avg_funds_column_data" class="list">
					<tbody>
					<?php foreach($pricePoints as $pricePoint): ?>
					<tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $this->Html->cFloat($pricePoint['average_project_fund_count'], false); ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>