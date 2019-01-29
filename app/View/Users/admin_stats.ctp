<div class="col-xs-12 col-s-70 cl-m-78 admin-dashboard" id="dashboard-accordion">	
	<?php echo $this->element('admin-charts-stats'); ?>	
</div>
<div class="col-xs-12 col-s-30 cl-m-22">
	<div class="h3">
		<h5 class="text-capitalize list-group-item-text"><strong><?php echo __l('Timings'); ?></strong></h5>
		<ul class="list-unstyled navbar-btn list-group-item-heading">
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span><span class="h5 rgt-move"><?php echo __l('Current time: '); echo $this->Html->cDateTime(strftime(Configure::read('site.datetime.format'))); ?></span>
			</li>
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span><span class="h5 rgt-move"> <?php echo __l('Last login: '); echo $this->Html->cDateTime($this->Auth->user('last_logged_in_time'));?></span>
			</li>
		</ul>
	</div>
	<div class="bootstro" data-bootstro-step="14" data-bootstro-content="<?php echo __l("It list the actions that admin need to take. Action such as users/projects waiting for approval, cancel the project/ clear the project flag of flagged projects, withdraw request waiting for approval and also affiliate withdraw request.");?>" data-bootstro-placement='left' data-bootstro-title="Action to be taken">
		<div class="js-cache-load  js-cache-load-action-taken {'data_url':'admin/users/action_taken', 'data_load':'js-cache-load-action-taken'}">
			<?php echo $this->element('project-admin_action_taken'); ?>
		</div>
	</div>
	<div class="h3">
		<div class="js-cache-load js-cache-load-recent-users {'data_url':'admin/users/recent_users', 'data_load':'js-cache-load-recent-users'}">
			<?php echo $this->element('users-admin_recent_users'); ?>
		</div>
	</div>
	<div class="h3">
		<h5 class="text-capitalize list-group-item-text">
			<strong><?php echo $this->Html->cText(Configure::read('site.name'), false); ?></strong>
		</h5>
		<ul class="list-unstyled navbar-btn list-group-item-heading">
			<li>
				<span class="text-muted h5 rgt-move"><i class="fa-fw fa fa-chevron-right small"></i></span><span class="h5 rgt-move"><?php echo ' ' . __l('Version').' ' ?>  <?php echo Configure::read('site.version'); ?> </span>
			</li>
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span> <?php echo $this->Html->link(__l('Product Support'), 'http://customers.agriya.com/', array('class' => 'js-no-pjax h5 rgt-move', 'target' => '_blank', 'title' => __l('Product Support'))); ?> 
			</li>
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span> <?php echo $this->Html->link(__l('Product Manual'), 'http://dev1products.dev.agriya.com/doku.php?id=crowdfunding' ,array('class' => 'js-no-pjax h5 rgt-move', 'target' => '_blank','title' => __l('Product Manual'))); ?> 
			</li>
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span><?php echo $this->Html->link('Cssilize', 'http://www.cssilize.com/', array('class' => 'js-no-pjax h5 rgt-move', 'target' => '_blank', 'title' => 'Cssilize')); ?> <small><?php echo 'PSD to XHTML Conversion and ' . $this->Html->cText(Configure::read('site.name'), false) . ' theming'; ?></small> 
			</li>
			<li>
				<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
				<?php echo $this->Html->link('Agriya Blog', 'http://blogs.agriya.com/' ,array('class' => 'js-no-pjax h5 rgt-move', 'target' => '_blank','title' => 'Agriya Blog')); ?><small> <?php echo __l('Follow Agriya news');?></small> 
			</li>
			<li class="navbar-btn">
				<a href="#" class="btn btn-primary js-live-tour js-no-pjax navbar-btn"><?php echo __l('Live Tour'); ?></a> 
			</li>
		</ul>
	</div>
</div>
