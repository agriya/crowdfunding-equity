<div>
<?php 
	$tracked_steps_arr = unserialize($tracked_steps['Project']['tracked_steps']);
	foreach($form_field_steps as $formFieldStep):
		foreach($tracked_steps_arr as $key => $val):
			if($formFieldStep['FormFieldStep']['order'] == $key):
?>
	<div><strong><?php echo $this->Html->cText($formFieldStep['FormFieldStep']['name'], false); ?></strong></div>
	<?php if(!empty($val['submitted_on'])): ?>
		<?php $i = 0; ?>
		<?php foreach($val['submitted_on'] as $submitted_on): ?>
			<div><?php echo __l('Submitted On: ') . $this->Html->cDateTimeHighlight($submitted_on); ?></div>
			<?php if (!empty($val['rejected_on'][$i])): ?>
				<div><?php echo __l('Rejected On: ') . $this->Html->cDateTimeHighlight($val['rejected_on'][$i]); ?></div>
				<div><?php echo $this->Html->cText(__l('Information to User: ') . $val['information_to_user'][$i]);?></div>
				<div><?php echo $this->Html->cText(__l('Private Note: ') . $val['private_note'][$i]); ?></div>
				<?php $i++; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if (!empty($val['approved_on'])): ?>
			<div><?php echo $this->Html->cText(__l('Approved On: ') . $this->Html->cDateTimeHighlight($val['approved_on'])); ?></div>
			<div><?php echo $this->Html->cText(__l('Private Note: ') . $val['private_note'][$i]); ?></div>
		<?php endif; ?>
	<?php endif; ?>
<?php
			endif;
		endforeach;
	endforeach;
?>
</div>