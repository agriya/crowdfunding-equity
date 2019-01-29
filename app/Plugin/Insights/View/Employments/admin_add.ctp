<?php /* SVN: $Id: $ */ ?>
<div class="userEmployments admin-form">
	<?php echo $this->Form->create('Employment', array('class' => 'form-horizontal'));?>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Employments'), array('action' => 'index'),array('title' => __l('Employments')));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo __l('Add Employment');?></li>
		</ul>
		<ul class="nav nav-tabs">
			<li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
			<li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');
		  ?></a></li>
		</ul>
		<fieldset class="gray-bg admin-checkbox">
			<?php echo $this->Form->input('employment',array('label'=>__l('Employment'))); ?>
			<?php echo $this->Form->input('is_active', array('label' => __l('Active?')));?>
			<div class="form-actions"><?php echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info'));?></div>
		</fieldset>
  <?php echo $this->Form->end();?>
</div>