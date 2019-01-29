<div class="projectTypes form js-response-containter">
  <div class="modal-header">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2 id="js-modal-heading"><?php echo __l('Add New Field'); ?></h2>
  </div>
  <div class="clearfix main-section admin-form gray-bg">		
		<?php
		  $url = Router::url(array('controller'=>'project_types','action'=>'edit', $this->request->data['FormField']['project_type_id']),true);
		  echo $this->Html->scriptBlock('base = "' . $this->base. '";');
		  echo $this->Form->create('FormField' ,array('class' => 'form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
		  echo $this->Form->hidden('project_type_id');
		  echo $this->Form->hidden('form_field_group_id');
		  echo $this->Form->input('label');
		  echo $this->Form->input('display_text');
		  echo $this->Form->input('type', array('class' => 'js-field-type'));
		?>
		<div class="js-options-show hide">
		  <?php echo $this->Form->input('options', array('type' => 'text', 'info' => __l('Comma separated. To include comma, escape it with \ (e.g., Option with \,)'))); ?>
		</div>
		<fieldset class=" admin-checkbox">
			<?php
			  echo $this->Form->input('info');
			  echo $this->Form->input('is_active', array('label' => __l('Active?')));
			  echo $this->Form->input('required');
			  echo $this->Form->input('FormField.is_editable', array('type' => 'checkbox', 'info' => __l('User can edit this field in \'Open for Funding\' status?')));
			?>
			<div class="clearfix">
			  <?php echo $this->Form->submit('Submit',array('class'=>'btn btn-info')); ?>
			</div>
		</fieldset>
    <?php echo $this->Form->end(); ?>
  </div>
</div>