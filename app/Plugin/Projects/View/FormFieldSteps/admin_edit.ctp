<?php /* SVN: $Id: $ */ ?>
<div class="projectTypes form js-response-containter">
  <div class="modal-header">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2 id="js-modal-heading"><?php echo __l('Edit Step'); ?></h2>
  </div>
  <div class="clearfix main-section admin-form gray-bg">
  <?php
    $url = Router::url(array('controller'=>'project_types','action'=>'edit', $this->request->data['FormFieldStep']['project_type_id']),true);
    echo $this->Form->create('FormFieldStep', array('class' => 'form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
  ?>
  <fieldset class="admin-checkbox">
    <?php
      echo $this->Form->input('id');
      echo $this->Form->hidden('project_type_id');
      echo $this->Form->input('name');
      echo $this->Form->input('info');
	  echo $this->Form->input('FormFieldStep.is_splash', array('label' => __l('Is Confirmation'), 'type' => 'checkbox', 'class' => 'js-splash'));
	  $class = (!empty($this->request->data['FormFieldStep']['is_splash']))?'show':'hide';	
	?>
		<div class="required clearfix js-splash-info <?php echo $class; ?>">
        <label class="pull-left" for="BlogContent"><?php echo __l('Additional info');?></label>
        <div class="input textarea col-md-8">
          <?php echo $this->Form->input('FormFieldStep.additional_info', array('type' => 'textarea', 'class' => 'js-editor col-md-12', 'label' => false, 'div' => false)); ?>
        </div>
		</div>
	 <?php 
	 if(empty($payout_step_avail) || !empty($this->request->data['FormFieldStep']['is_payout_step'])) {
		echo $this->Form->input('FormFieldStep.is_payout_step', array('type' => 'checkbox' , 'class' => 'js-payout'));
	}

	 if(empty($payment_step_avail) || !empty($this->request->data['FormFieldStep']['is_payment_step'])) {
		echo $this->Form->input('FormFieldStep.is_payment_step', array('type' => 'checkbox'));
	}
		$class = (!empty($this->request->data['FormFieldStep']['is_splash']) || !empty($this->request->data['FormFieldStep']['is_payout_step']))?'hide':'show';
	?>
		<div class="js-editable-info <?php echo $class; ?>">
		<?php
			echo $this->Form->input('FormFieldStep.is_editable', array('type' => 'checkbox', 'info' => __l('User can edit this step in \'Open for Funding\' status?')));
		?>
		</div>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info'));?>
  </div>
  <?php echo $this->Form->end();?>
  </div>
</div>