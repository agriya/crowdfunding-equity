<div class="types form admin-form">
  <?php echo $this->Form->create('Type', array('class' => 'form-horizontal'));?>
	<fieldset>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Types'), array('action' => 'index'), array('title' => __l('Types')));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo sprintf(__l('Add %s'), __l('Type'));?></li>
		</ul>
	    <ul class="nav nav-tabs">
			<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
			</li>
			<li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a></li>
		</ul>
		<ul class="nav nav-tabs top-space" id="myTab">
			<li class="active"><a data-toggle="tab" href="#type" class="js-no-pjax"><?php echo __l('Type'); ?></a></li>
			<li><a data-toggle="tab" href="#type-taxonomy" class="js-no-pjax"><?php echo __l('Taxonomy'); ?></a></li>
			<?php echo $this->Layout->adminTabs(); ?>
		</ul>
		<div class="tab-content gray-bg" id="myTabContent">
			<div id="type" class="tab-pane fade in active">
				<?php
				echo $this->Form->input('title',array('label' => __l('Title')));
				echo $this->Form->input('alias',array('label' => __l('Alias')));
				echo $this->Form->input('description',array('label' => __l('Description')));
				?>
			</div>
			<div id="type-taxonomy" class="tab-pane fade">
				<?php echo $this->Form->input('Vocabulary.Vocabulary',array('label' => __l('Vocabulary'))); ?>
			</div>
			<?php echo $this->Layout->adminTabs(); ?>
			<div class="clearfix form-actions">
				<?php echo $this->Form->submit(__l('Save'),array('class'=>'pull-left btn btn-info')); ?>
				<div class = "pull-left" >
					<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class' => 'btn')); ?>
				</div>
			</div>
		</div>		
	</fieldset>	
	<?php echo $this->Form->end(); ?>
</div>