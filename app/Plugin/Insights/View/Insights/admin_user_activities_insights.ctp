<div class="js-user-activities js-cache-load-admin-charts-user-activities col-xs-12 activities-projects">
	<div class="accordion-group">
		<?php
		   $chart_title = __l('User Login');
		  $chart_y_title = __l('Users');
		  $role_id = $this->request->data['Chart']['role_id'];
		  $collapse_class = 'in';
		  if ($this->request->params['isAjax']) {
			$collapse_class ="in";
		  }
		?>
		<div class="accordion-heading">
			<div class="no-bor clearfix box-head">
				<h5 class="no-mar">
					<span class="pull-left mspace">
					<?php echo $this->Html->image('activities.png', array('alt' => sprintf(__l('[Image: %s]'), __l('activities')))); ?>						
						<span class="h4 mspace"><?php echo __l('Activities')  ?></span>
					</span>
					<div class="pull-right">		
						<div class="pull-left space">
							<div class="dropdown">
								<a class="dropdown-toggle js-no-pjax js-overview" data-toggle="dropdown" href="#">
									<i class="fa fa-wrench grayc"></i>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
									<li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
								</ul>
							</div>
						</div>
						<div class="pull-left">
							<a class="accordion-toggle js-toggle-icon js-no-pjax clearfix pull-right space" href="#userfollower" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
							<i class="fa fa-chevron-down grayc"></i>
							</a>
						</div>		 
					</div>
				</h5>
			</div>
		</div>
    <div  id="userfollower" class="accordion-body collapse over-hide <?php echo $collapse_class;?>">
      <div class="accordion-inner marg-btom-30">
	   <?php
          $div_class = "js-load-line-graph ";
        ?>
        <div class="row" id="login">
          <section class="col-md-6 border-right">
            <div class="<?php echo $div_class;?> text-center {'chart_type':'LineChart', 'data_container':'user_login_line_data<?php echo $role_id; ?>', 'chart_container':'user_login_line_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_login_line_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                <table id="user_login_line_data<?php echo $role_id; ?>" class="table table-striped table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __l('Period'); ?></th>
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
            </div>
          </section>
		  <hr class="visible-xs">
		   <?php
		$chart_title = __l('User Followers');
      $chart_y_title = __l('Users');
          $div_class = "js-load-column-chart";
        ?>
          <section class="col-md-6">
		      <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'user_activities_chart_data', 'chart_container':'user_activities_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_activities_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="user_activities_chart_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($user_follow_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $this->Html->cText($key, false); ?></th>
						 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <hr class="visible-xs">
        </div>
       <?php  if (isPluginEnabled('ProjectUpdates') == 1) { ?>
			<div class="row" id="projectcomments">			  
			<?php $chart_title = __l('Project Comments');
			  $chart_y_title = __l('Project Comments');?>
			  <section class="col-md-6 ">
				  <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_comment_data', 'chart_container':'project_comment_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="project_comment_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="project_comment_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($project_comments_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $this->Html->cText($key, false); ?></th>
							 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </section>
			  <hr class="visible-xs">
			  <?php $chart_title = __l('Project Updates');
			  $chart_y_title = __l('Project Updates'); ?>
			 <section class="col-md-6">
				  <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_update_data', 'chart_container':'project_update_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="project_update_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="project_update_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($project_updates_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $this->Html->cText($key, false); ?></th>
							 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </section>
			  <hr class="visible-xs">
			</div>
		<?php } ?>
		<div class="row" id="projectfollowers">
		
        <?php  if (isPluginEnabled('ProjectUpdates') == 1) { ?> 
		<?php $chart_title = __l('Project Updates Comments');
		  $chart_y_title = __l('Project Updates Comments'); ?>
		  <section class="col-md-6 ">
		      <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_updates_comment_data', 'chart_container':'project_updates_comment_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="project_updates_comment_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="project_updates_comment_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($project_update_comments_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $this->Html->cText($key, false); ?></th>
						 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <hr class="visible-xs">
		  <?php } ?>
		  <?php if (isPluginEnabled('ProjectFollowers')) { ?>
         <?php $chart_title = __l('Project Followers');
		  $chart_y_title = __l('Project Followers'); ?>
          <section class="col-md-6">
		      <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_follower_data', 'chart_container':'project_follower_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="project_follower_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="project_follower_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($project_follower_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $this->Html->cText($key, false); ?></th>
						 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <hr class="visible-xs">
		  <?php } ?>
        </div>
		<div class="row" id="projectflag">		
		<?php $chart_title = __l('Project Rating');
		  $chart_y_title = __l('Project Rating'); ?>
		  <section class="col-md-6 ">
		      <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_rating_data', 'chart_container':'project_rating_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="project_rating_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="project_rating_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($project_rating_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $this->Html->cText($key, false); ?></th>
						 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <hr class="visible-xs">
		 <?php  if (isPluginEnabled('ProjectFlags')) { ?>
         <?php $chart_title = __l('Project Flags');
		  $chart_y_title = __l('Project Flags'); ?>
          <section class="col-md-6">
		      <div class="<?php echo $div_class;?> text-center { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'project_flag_data', 'chart_container':'project_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="project_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="project_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($project_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $this->Html->cText($key, false); ?></th>
						 <td><?php echo $this->Html->cText($_data[0], false); ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <hr class="visible-xs">
		  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
