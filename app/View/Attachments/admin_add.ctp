<div class="attachments form">
  <?php echo $this->Form->create('Node', array('url' => array('controller' => 'attachments', 'action' => 'add'), 'type' => 'file')); ?>
  <fieldset>
    <?php echo $this->Form->input('Node.file', array('label' => __l('Upload'), 'type' => 'file')); ?>
  </fieldset>
  <div class="form-actions">
  <?php echo $this->Form->submit(__l('Save')); ?>
  <div>
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index')); ?>
  </div>
  </div>
</div>