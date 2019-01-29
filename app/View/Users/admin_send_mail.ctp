<div class="clearfix admin-form gray-bg">
  <?php
    echo $this->Form->create('User', array('action' => 'send_mail', 'class' => 'form-horizontal clearfix'));?>
    <fieldset>
    <?php echo $this->Form->input('bulk_mail_option_id', array('empty' => __l('Select'),'label'=>__l('Bulk Mail Option')));
      echo $this->Form->autocomplete('send_to', array('id' => 'message-to', 'acFieldKey' => 'User.send_to_user_id',
                  'acFields' => array('User.email'),
                  'acSearchFieldNames' => array('User.email'),
                      'maxlength' => '100', 'acMultiple' => true, 'label'=>__l('Send To')
                       ));
        echo $this->Form->input('subject',array('label' => __l('Subject')));
      echo $this->Form->input('message', array('type' => 'textarea', 'label' => __l('Message'))); ?>
      </fieldset>
    <div class="form-actions">
    <?php echo $this->Form->submit(__l('Send'), array('class'=>'btn btn-info')); ?>
    </div>
      <?php echo $this->Form->end(); ?>
</div>