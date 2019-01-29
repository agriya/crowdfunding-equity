<div class="col-xs-12 col-sm-6 col-md-3 start-projects">
	<div class="bg-light-gray">
		<div class="img-contain"><?php echo $this->Html->image('equity.png'); ?></div>
		<?php echo $this->Html->link(__l(Configure::read('project.alt_name_for_equity_singular_caps')). " " . __l(Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'projects', 'action' => 'add', 'project_type'=>'equity', 'admin' => false), array('title' => __l(Configure::read('project.alt_name_for_equity_singular_caps')). " " . __l(Configure::read('project.alt_name_for_project_singular_caps')),'class' => 'js-tooltip h3 clr-vio', 'escape' => false));?>
		<p class="navbar-btn"><?php echo __l('People book shares. Amount is captured by end date/goal reached. Entrepreneurs offer shares.'); ?></p>
	</div>
</div>