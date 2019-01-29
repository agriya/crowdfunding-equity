<?php echo $this->Form->create('Comment', array('class' => 'form-horizontal'));?>
  <fieldset>
    <?php
      echo $this->Form->input('id');
      echo $this->Form->input('body');
      echo $this->Form->input('name');
      echo $this->Form->input('email');
      echo $this->Form->input('website');
      echo $this->Form->input('status', array('label' => __l('Published')));
    ?>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Save')); ?>
    <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'comments', 'action' => 'index'), array('class' => 'btn js-tooltip', 'title' => __l('Cancel'))); ?>
  </div>
<?php echo $this->Form->end(); ?>
