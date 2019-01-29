<div class="vocabularies admin-form">
	<?php echo $this->Form->create('Vocabulary', array('class' => 'form-horizontal'));?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'), array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Add %s'), __l('Vocabulary'));?></li>
	</ul>
	<ul class="nav nav-tabs">
		<li>
		<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
		</li>
		<li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a></li>
	</ul>
	<div class="gray-bg">
		<?php
		echo $this->Form->input('title',array('label' => __l('Title')));
		echo $this->Form->input('alias',array('label' => __l('Alias')));
		echo $this->Form->input('Type.Type',array('label' => __l('Type')));
		?>
		<div class="form-actions">
			<?php echo $this->Form->submit(__l('Save'),array('class'=>'pull-left btn btn-info')); ?>
			<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class'=>'btn')); ?>
		</div>
	</div>		
	<?php echo $this->Form->end(); ?>
</div>