<nav class="navbar navbar-default list-group-item-text">
	<div class="container-fluid">
		<div class="row top-header parnt-accord">
			<div class="menubar openmenu menucolor menubari visble-sm hidden-md hidden-lg pull-right" id="menubari" onClick="menuFunc()">
				<i class="fa fa-angle-double-left fa-2x" id="openmenud"></i>
			</div>
			<div class="header-sm-xs hedr">
				<div class="col-xs-12 col-md-3 pull-left navbar-btn">
					<span><i class="fa fa-clock-o fa-fw grayc" aria-hidden="true"></i></span><span class="h6 last-login"> <?php echo __l('Last login: '); echo $this->Html->cDateTime($this->Auth->user('last_logged_in_time'));?></span>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-4 pull-right">
					<ul class="list-inline col-xs-12 col-sm-12 col-md-12 lft-ul">
						<li>
							<?php echo $this->Html->link('<span class="h6">' . __l('Visit Website') . '</span>', Router::url('/',true), array('class' => 'btn btn-success js-no-pjax', 'escape'=>false, 'title' => __l('View Site'))); ?>
						</li>
							<?php 
							$class = 'hide';
							if((($this->request->params['controller']=='users')&&($this->request->params['action']=='admin_stats'))||(($this->request->params['controller']=='google_analytics')&&($this->request->params['action']=='admin_analytics_chart'))) { $class = ''; }?>
						<li class="js-live-tour-link <?php echo $class; ?>">
							<a href="#" class="bootstro-goto bootstro h6 rt-bdr js-no-pjax" data-bootstro-step="0" data-bootstro-title="<?php echo __l('Live Tour');?>"data-bootstro-content="<?php echo __l('Look out for a Live Tour link in the top of page for live demo of product');?>" data-bootstro-placement="bottom" escape="false"><?php echo __l('Live Tour');?></a>
						</li>
						<li>
							<?php if($this->request->params['controller'] == 'users' && $this->request->params['action']=='admin_stats') { ?>
							<?php  echo $this->Html->link(__l('Tools'), array('controller' => 'nodes', 'action' => 'tools', 'admin' => true),array('class' => 'bootstro h6 rt-bdr','data-bootstro-step'=>'11' ,'data-bootstro-title'=>'Tools' , 'data-bootstro-content'=>__l("For manually trigger the corn to update the project status, also to update daily status."), 'data-bootstro-placement'=>'bottom', 'escape'=>false));?>
							<?php } else { ?>
							<?php  echo $this->Html->link(__l('Tools'), array('controller' => 'nodes', 'action' => 'tools', 'admin' => true),array('class' => 'h6 rt-bdr','escape'=>false));?>
							<?php } ?>
						</li>
						<li> 
							<?php  echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true),array('class' => 'h6', 'escape'=>false, 'title' => __l('Diagnostics')));?> 
						</li>						
						<li class="rgt-li pull-right">
							<div class="dropdown pull-left logn"> 
								<a href="javascript:void(0);" title="<?php echo __l('Settings');?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-cog fa-2x hidden-xs hidden-sm visble-md visble-lg"></i>
								<span class="visble-sm hidden-md hidden-lg text-center h6 list-group-item-text list-group-item-heading"><?php echo __l('Login');?> </span>
								</a>
								<ul class="dropdown-menu dl pull-right">
									<li>
										<?php  echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id'), 'admin' => true), array('class' => 'h6', 'escape'=>false, 'title' => __l('My Account')));?> 
									</li>
									<li>
										<?php  echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password', 'admin' => true),array('class' => 'h6', 'escape'=>false, 'title' => __l('Change Password')));?>
									</li>
								</ul>
							</div>
							<div class="dropdown pull-left sgnup">
								<?php echo $this->Html->link(' <i class="fa fa-power-off fa-2x hidden-xs hidden-sm visble-md visble-lg"></i><span class="visble-sm hidden-md hidden-lg text-center h6">' .__l('Logout') .'</span>', array('controller' => 'users', 'action' => 'logout'), array('class' => 'h6 js-no-pjax', 'escape'=>false, 'title' => __l('Logout')));?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php echo $this->Layout->adminMenus(CmsNav::items());?>
	</div>
</nav>
<!--<hr class="hr-2px-gray no-mar">-->