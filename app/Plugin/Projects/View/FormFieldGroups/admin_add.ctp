<?php /* SVN: $Id: $ */ ?>
<div class="projectTypes form js-response-containter">
	<div class="modal-header">
        <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 id="js-modal-heading"><?php echo __l('Add New Group'); ?></h2>
    </div>
	<div class="clearfix main-section admin-form gray-bg">	
		<?php 
            $url = Router::url(array('controller'=>'project_types','action'=>'edit', $this->request->data['FormFieldGroup']['project_type_id']),true);
            echo $this->Form->create('FormFieldGroup', array('class' => 'form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
        ?>
        <fieldset class="admin-checkbox">
        <?php
            echo $this->Form->hidden('project_type_id');
            echo $this->Form->hidden('form_field_step_id');
            echo $this->Form->input('name');
            echo $this->Form->input('info');
			echo $this->Form->input('FormFieldGroup.is_deletable', array('type' => 'hidden', 'value' => 1));
			echo $this->Form->input('FormFieldGroup.is_editable', array('type' => 'checkbox', 'info' => __l('User can edit this group in \'Open for Funding\' status?')));
        ?>
        </fieldset>
        <div class="form-actions">
            <?php echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info'));?>
        </div>
        <?php echo $this->Form->end();?>
        </div>
    </div>