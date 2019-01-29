<?php /* SVN: $Id: $ */ ?>
<div class="projectFlagCategories admin-form">
	<?php echo $this->Form->create('ProjectFlagCategory', array('class' => 'form-horizontal'));?>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(sprintf(__l('%s Flag Categories'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'),array('title' => sprintf(__l('%s Flag Categories'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo sprintf(__l('Edit %s'), sprintf(__l('%s Flag Category'), Configure::read('project.alt_name_for_project_singular_caps')));?></li>
		</ul>
		<ul class="nav nav-tabs">
			<li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
			<li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o"></i><?php echo __l('Edit'); ?></a></li>
		</ul>
		<fieldset class="gray-bg admin-checkbox">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name',array('label'=>__l('Name')));
			echo $this->Form->input('is_active',array('label'=>__l('Active')));
		?>
		<div class="form-actions">
			<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info'));?>		
		</div>
		</fieldset>
	<?php echo $this->Form->end();?>
</div>