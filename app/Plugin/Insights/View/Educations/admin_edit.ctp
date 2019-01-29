<?php /* SVN: $Id: $ */ ?>
<div class="userEducations admin-form">
  <?php echo $this->Form->create('Education', array('class' => 'form-horizontal'));?>
	  <ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Educations'), array('action' => 'index'),array('title' => __l('Educations')));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo __l('Edit Education');?></li>
	  </ul>
	  <ul class="nav nav-tabs">
			<li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
			<li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a></li>
	  </ul>
	  <fieldset class="gray-bg admin-checkbox">
		  <?php
				echo $this->Form->input('id');
				echo $this->Form->input('education',array('label'=>__l('Education')));
				echo $this->Form->input('is_active',array('label'=>__l('Active')));
		  ?>
		  <div class="form-actions">
				<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info'));?>
		  </div>
	  </fieldset>
  <?php echo $this->Form->end();?>
</div>
