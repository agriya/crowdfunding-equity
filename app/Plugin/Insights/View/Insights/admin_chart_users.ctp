<div class="js-user-register js-cache-load-admin-charts-users col-xs-12 registration-user">
	<div class="accordion-group">
		<?php
		  $chart_title = __l('User Registration');
		  $chart_y_title = __l('Users');
		  $page_title = __l('User');
		  $role_id = $this->request->data['Chart']['role_id'];
		  $icon_class = "fa fa-chevron-down";
		  $collapse_class = "in";
		  if ($this->request->params['isAjax']) {
			$icon_class = "fa fa-chevron-up";
			$collapse_class ="in";
		  }
		?>
		<div class="accordion-heading">
			<div class="no-bor clearfix box-head">
				<h5 class="no-mar">
					<span class="pull-left mspace">
					<?php echo $this->Html->image('registration-user.png', array('alt' => sprintf(__l('[Image: %s]'), __l('Registration user')))); ?>
					<span class="h4 mspace"><?php echo __l('Registration') . ' - ' . $page_title; ?></span>
					</span>
					<div class="pull-right">		  			
						<div class="pull-left space">
							<div class="dropdown">
								<a class="dropdown-toggle js-no-pjax js-overview" data-toggle="dropdown" href="#">
									<i class="fa fa-wrench grayc"></i>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-register"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_users/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-register"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_users/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-register"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_users/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-register"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_users/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
								</ul>
							</div>
						</div>
						<div class="pull-left">
							<a class="accordion-toggle js-toggle-icon js-no-pjax clearfix pull-right space grayc" href="#registration" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
							<i class="fa fa-chevron-down"></i>
							</a>
						</div>		  
					</div>
				</h5>
			</div>
		</div>
		<div id="registration" class="accordion-body collapse over-hide <?php echo $collapse_class;?>">
		  <div class="accordion-inner">
			<?php
			  $div_class = "js-load-line-graph ";
			?>
			<div class="row">
			  <section class="col-md-6 border-right">
				<div class="text-center <?php echo $div_class;?> {'chart_type':'LineChart', 'data_container':'user_line_data<?php echo $role_id; ?>', 'chart_container':'user_line_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div id="user_line_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
				  <div class="hide">
				  <table id="user_line_data<?php echo $role_id; ?>" class="table table-striped table-bordered table-condensed">
					<thead>
					  <tr>
						<th>Period</th>
						<?php foreach($chart_periods as $_period): ?>
						  <th><?php echo $this->Html->cText($_period['display'], false); ?></th>
						<?php endforeach; ?>
					  </tr>
					</thead>
					<tbody>
					  <?php foreach($chart_data as $display_name => $chart_data): ?>
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
			  <?php if(!empty($chart_pie_data)): ?>
				<?php
				  $div_class = "js-load-pie-chart ";
				?>
				<section class="col-md-6">
				  <div class="<?php echo $div_class;?> text-center chart-half-section {'chart_type':'PieChart', 'data_container':'user_pie_data<?php echo $role_id; ?>', 'chart_container':'user_pie_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
					<div id="user_pie_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					  <div class="hide">
						<table id="user_pie_data<?php echo $role_id; ?>" class="list">
						  <tbody>
							<?php foreach($chart_pie_data as $display_name => $val): ?>
							  <tr>
								<th><?php echo $this->Html->cText($display_name, false); ?></th>
								<td><?php echo $this->Html->cText($val, false); ?></td>
							  </tr>
							<?php endforeach; ?>
						  </tbody>
						</table>
					  </div>
				  </div>
				</section>
				<hr class="visible-xs">
			  <?php endif; ?>
			</div>
			<?php  if (isPluginEnabled('Insights')) {?>
			  <?php echo $this->element('xstats_user_demographics', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')), 'chart_y_title' => $chart_y_title), array('plugin' => 'Insights')); ?>
			<?php }?>
		  </div>
		</div>
	</div>
</div>