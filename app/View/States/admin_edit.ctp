<?php /* SVN: $Id: $ */ ?>
<div class="states admin-form">
	<?php echo $this->Form->create('State',  array('class' => 'form-horizontal','action'=>'edit'));?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('States'), array('action' => 'index'), array('title' => __l('States')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Edit %s'), __l('State'));?></li>
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
			echo $this->Form->input('country_id',array('empty' => __l('Please Select')));
			echo $this->Form->input('name', array('label' => __l('Name')));
			echo $this->Form->input('is_approved', array('label' => __l('Approved?')));
		?>
		<div class="form-actions">
			<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info'));?>
		</div>
	</fieldset>
	<?php echo $this->Form->end();?>
</div>