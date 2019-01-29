<div class="menus admin-form">
	<?php echo $this->Form->create('Menu', array('url' => array('controller' => 'menus', 'action' => 'add','admin' => true),'class' => 'form-horizontal')); ?>
	<fieldset>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Menus'), array('action' => 'index'), array('title' => __l('Menus')));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo sprintf(__l('Add %s'), __l('Menu'));?></li>
		</ul>
		<ul class="nav nav-tabs">
			<li>
				<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'menus', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
			</li>
			<li class="active"><a href="#add_form"><i class="fa fa-plus-circle"></i><?php echo __l('Add');?></a></li>
		</ul>
		<div class="panel-container gray-bg clearfix">
			<div id="add_form" class="tab-pane fade in active">
				<div id="menu-basic">
					<?php
						echo $this->Form->input('title',array('label' => __l('Title')));
						echo $this->Form->input('alias',array('label' => __l('Alias')));
					?>
				</div>
				<div class="form-actions">
					<div class = "pull-left left-mspace">
						<?php echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info')); ?>
					</div>
					<div class = "pull-left left-mspace" >
						<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'menus', 'action' => 'index'), array('title' => __l('Cancel'),'class' => 'btn btn-danger', 'escape' => false)); ?>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
  <?php echo $this->Form->end(); ?>
</div>