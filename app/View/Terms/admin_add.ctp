<div class="terms admin-form">
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
		<li><?php echo $this->Html->link(__l('Terms'), array('action' => 'index', $vocabularyId),array('title' => __l('Terms')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Add %s'), __l('Term'));?></li>
	</ul>
	<ul class="nav nav-tabs">
		<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' =>  __l('Vocabularies'), 'escape' => false));?>
		</li>
		<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list  fa-fw"></i>'.__l('Vocabulary'), array('action' => 'index', $vocabularyId),array('title' =>  __l('Vocabulary'),'data-target'=>'#list_form', 'escape' => false));?>
		</li>
		<li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');?></a></li>
	</ul>
	<?php echo $this->Form->create('Term', array('class'=>'form-horizontal','url' => array('controller' => 'terms', 'action' => 'add', $vocabulary['Vocabulary']['id']))); ?>
	<fieldset>
		<div class="gray-bg admin-checkbox">
			<?php
				echo $this->Form->input('Taxonomy.parent_id', array('label' => __l('Taxonomy'),'options' => $parentTree, 'empty' => __l("Please Select")));
				echo $this->Form->input('title',array('label' => __l('Title')));
				echo $this->Form->input('slug',array('label' => __l('Slug')));
			?>
			<div class="form-actions">
				<?php echo $this->Form->submit(__l('Save'),array('class'=>'btn btn-info pull-left')); ?>
				<div class="cancel-block">
					<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $vocabularyId), array('class'=>'btn btn-link')); ?>
				</div>
			</div>
		</div>
	</fieldset>	
	<?php echo $this->Form->end(); ?>
</div>