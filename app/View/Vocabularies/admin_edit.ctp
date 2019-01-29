<div class="vocabularies admin-form">
  <?php echo $this->Form->create('Vocabulary', array('class' => 'form-horizontal', 'action' => 'edit'));?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'), array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Edit %s'), __l('Vocabulary'));?></li>
	</ul>
	<ul class="nav nav-tabs">
		<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
		</li>
		<li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a></li>
	</ul>
	<fieldset class="gray-bg admin-checkbox">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('title');
			echo $this->Form->input('alias');
			echo $this->Form->input('Type.Type');
		?>
		<div class="form-actions">
			<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info pull-left')); ?>
			<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class'=>'btn'));	?>
		</div>
	</fieldset>
  <?php echo $this->Form->end(); ?>
</div>