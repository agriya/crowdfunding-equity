<div class="container-fluid user-dashboard">
  <div class="clearfix">
	<div class="clearfix user-heading">
		<h3 class="col-xs-8 col-sm-6 h2 text-uppercase list-group-item-text"><?php echo __l('Dashboard'); ?></h3>
		<div class="col-xs-4 col-sm-6 h2 list-group-item-text">
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
  <?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
  <?php echo $this->element('dashboard-activities', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
</div>