<div class="import-startups">
<div class="page-header no-bor">
   <span class="project-logo">
   <?php echo $this->Html->image('equity-s-icon.png', array('alt' => __l('[Image: Equity]'),'width' => 52, 'height' => 52)); ?> </span>
   <h2 class="text-center"><span class="or-hor"><?php echo __l('Start Project');?></span></h2>
</div>
  <div class="img-thumbnail"><h4 class="text-center"><?php echo 'AngelList Startup'; ?></h4>
<p class="text-center"><?php echo 'Before starting project, import your startup from AngelList.'; ?> </p>
</div>
  <div>
  <?php echo $this->Form->create('Equity', array('class' => 'form-vertical equity', 'action' => 'import_startups'));?>
  <div class="well">
  <div class="alert alert-warning clearfix"><?php echo sprintf(__l('Please choose with care, you can\'t import startup multiple times.'));?></div>
  <?php
  if(!empty($startups)){
	  $i = 0;
	foreach($startups as $startup) {
		$disabled ='';
		if(in_array($startup->startup->id, $existing_startup_ids)){
			$i++;
			$disabled = 'disabled';
		} ?>
		<div class="clearfix offset3">
<?php	echo $this->Form->input('Equity.'. $startup->startup->id .'.startup_id', array('type' => 'radio','id' => 'startup_' . $startup->startup->id, 'options' => array($startup->startup->id => $startup->startup->name), 'disabled' => $disabled, 'div' => 'input radio pull-left'));?>
<?php	if (!empty($disabled)) { ?>
		<span class="label label-success"><?php echo __l('Imported');?> </span>
	<?php
		}?>
</div>
<?php
	}
	?>
</div>
	<div class="well form-actions">
	<div class="offset6">
	<?php echo $this->Html->link(__l('Back'), array('controller' => 'seis_entries', 'action' => 'add', 'project_type' => 'equity', 'admin' => false), array('class'=>'js-tooltip btn','title' => __l('Back')));?>
	<span>
	<?php
		$btn_disable = '';
		if(count($startups) == $i){
			$btn_disable = 'disabled';
	}
	?>
	<?php  echo $this->Form->submit(__l('Import'), array('class' => 'btn-primary '.$btn_disable, 'disabled' => (count($startups) == $i)?true:false))?></span>
	</div>
	</div>
	<?php echo $this->Form->end(); ?>
	<?php } else {?>
	  <div class="img-thumbnail text-center">
        <p><?php echo sprintf(__l('No startups available'));?></p>
      </div>
	<?php } ?>
 </div>
</div>