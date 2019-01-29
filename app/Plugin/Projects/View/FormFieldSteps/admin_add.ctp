<?php /* SVN: $Id: $ */ ?>
<div class="projectTypes form js-response-containter">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2 id="js-modal-heading"><?php echo __l('Add New Step'); ?></h2>
  </div>
  <div class="clearfix main-section admin-form gray-bg">
      <?php
        $url = Router::url(array('controller'=>'project_types','action'=>'edit', $this->request->data['FormFieldStep']['project_type_id']),true);
        echo $this->Form->create('FormFieldStep', array('class' => 'form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
      ?>
      <fieldset class="admin-checkbox">
      <?php
        echo $this->Form->hidden('project_type_id');
        echo $this->Form->input('name');
        echo $this->Form->input('info');
        echo $this->Form->input('FormFieldStep.is_deletable', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('FormFieldStep.is_splash', array('label' => __l('Is Confirmation'), 'type' => 'checkbox', 'class' => 'js-splash js-no-pjax')); ?>
		<div class="required clearfix js-splash-info js-no-pjax-info hide">
        <label class="pull-left" for="BlogContent"><?php echo __l('Additional info');?></label>
        <div class="input textarea col-md-8">
          <?php echo $this->Form->input('FormFieldStep.additional_info', array('type' => 'textarea', 'class' => 'js-editor col-md-12', 'label' => false, 'div' => false)); ?>
        </div>
		</div>
	 <?php 
	    if(empty($payment_step_avail)){
			echo $this->Form->input('FormFieldStep.is_payment_step', array('type' => 'checkbox', 'info' => __l('If you enable payment step, you have to set pricing details. Otherwise it will take global listing fee.')));
		} 

		if(empty($payout_step_avail)){
			echo $this->Form->input('FormFieldStep.is_payout_step', array('type' => 'checkbox' , 'class' => 'js-payout'));
		} 

	  ?>
		<div class="js-editable-info">
		<?php echo $this->Form->input('FormFieldStep.is_editable', array('type' => 'checkbox', 'info' => __l('User can edit this step in \'Open for Funding\' status?'))); ?>
		</div>
      </fieldset>
      <div class="form-actions">
        <?php echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info'));?>
      </div>
      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>