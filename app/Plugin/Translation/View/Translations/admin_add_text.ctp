<?php /* SVN: $Id: admin_add.ctp 196 2009-05-25 14:59:50Z siva_43ag07 $ */ ?>
<div class="translations admin-form">
	<div class="gray-bg">
	<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal', 'action' => 'add_text')); ?>
	<?php echo $this->Form->input('Translation.name', array('label' => __l('Original')));
		foreach ($languages as $lang_id => $lang_name) :
	?>
	<h4><?php echo $this->Html->cText($lang_name, false);?></h4>	
		<?php
			echo $this->Form->input('Translation.'.$lang_id.'.lang_text',array('label'=>__l('Lang Text')));
			endforeach;
		?>
		<div class="from-action">
			<?php
				echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info'));
			?>
		</div>
	</div>    
	<?php
		echo $this->Form->end();
	?>
 </div>
