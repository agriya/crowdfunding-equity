<?php
  $width = 620;
  if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
    $parent = '#accordion-admin-dashboard';
    $width = 620;
  }
?>
<div class="js-cache-load-admin-charts-transaction col-xs-12 revenue">
	<div class="js-overview-transaction">
		<div class="accordion-group">
			<div class="accordion-heading " >
				<div class="no-bor clearfix box-head bootstro" data-bootstro-step="12" data-bootstro-content="<?php echo __l("User registration rate, Site revenue, Projects posted rate, Projects Fund rate in selected period. By default it shows only last 7 days details. To see the last 4 weeks, last 3 months, last 3 years details please select your desired period in the above setting icon. Also display the complete details of site revenue / project funded. By default it shows only last 7 days details. To see the last 7 days, last 4 weeks, last 3 months, last 3 years details please select the desired period in the above setting icon.");?>" data-bootstro-placement='bottom' data-bootstro-width="600px"  >
					<h5 class="no-mar">
						<span class="pull-left mspace">
						<?php echo $this->Html->image('transaction-revenue.png', array('alt' => sprintf(__l('[Image: %s]'), __l('transaction revenue')))); ?>
						<span class="h4 mspace"><?php echo __l('Revenue'); ?></span>
						</span>
						<div class="pull-right">															
							<div class="pull-left space">
								<div class="dropdown">
									<a class="dropdown-toggle js-no-pjax js-overview grayc" data-toggle="dropdown" href="#">
										<i class="fa fa-wrench"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastDays/";?>"><?php echo __l('Last 7 days'); ?></a> </li>
										<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>> <a class='js-link {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastWeeks/";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
										<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>> <a class='js-link {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastMonths/";?>"><?php echo __l('Last 3 months'); ?></a> </li>
										<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>> <a class='js-link {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_transactions/select_range_id:lastYears/";?>"><?php echo __l('Last 3 years'); ?></a> </li>
									</ul>
								</div>
							</div>
							<div class="pull-left">
								<a class="accordion-toggle js-toggle-icon js-no-pjax clearfix pull-right space" href="#overview" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
									<i class="fa fa-chevron-down grayc"></i>
								</a>
							</div>							
						</div>
					</h5>		
				</div>
				<div id="overview" class="accordion-body in collapse over-hide">
					<div class="accordion-inner" id="revenue">
						<?php
						  $div_class = "js-load-line-graph ";
						?>
						<div class="row">
							<section class="col-md-6 border-right">
								<div class="<?php echo $div_class;?> text-center {'chart_type':'LineChart', 'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
									<div id="transactions_line_chart" class="admin-dashboard-chart"></div>
									<div class="hide">
										<table id="transactions_line_data" class="table table-striped table-bordered table-condensed">
											<thead>
											  <tr>
												<th>Period</th>
												<?php foreach($chart_transactions_periods as $_period): ?>
												  <th><?php echo $this->Html->cText($_period['display'], false); ?></th>
												<?php endforeach; ?>
											  </tr>
											</thead>
											<tbody>
											  <?php foreach($chart_transactions_data as $display_name => $chart_data): ?>
												<tr>
												  <th><?php echo $this->Html->cText($display_name, false); ?></th>
												  <?php foreach($chart_data as $val): ?>
													<td><?php echo $this->Html->cText($val, false); ?></td>
												  <?php endforeach; ?>
												</tr>
											  <?php endforeach; ?>
											</tbody>
										 </table>
									</div>
								</div>
							</section>
							<hr class="visible-xs">
							<section class="col-md-6">
								<div class="<?php echo $div_class;?> text-center {'chart_width':'<?php echo $width; ?>', 'chart_type':'LineChart', 'data_container':'project_fund_line_data', 'chart_container':'project_fund_line_chart', 'chart_title':'<?php echo sprintf(__l('%s Funds'), Configure::read('project.alt_name_for_project_singular_caps')) ;?>', 'chart_y_title': '<?php echo __l('Projects Funded');?>'}">
								<div id="project_fund_line_chart"></div>
									<div class="hide">
										<table id="project_fund_line_data" class="table table-striped table-bordered table-condensed table-hover">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_project_funds_periods as $_period): ?>
													<th><?php echo $this->Html->cText($_period['display'], false); ?></th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_project_funds_data as $display_name => $chart_data): ?>
												<tr>
													<th><?php echo $this->Html->cText($display_name, false); ?></th>
													<?php foreach($chart_data as $val): ?>
													<td><?php echo $this->Html->cText($val, false); ?></td>
													<?php endforeach; ?>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
							<hr class="visible-xs">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>