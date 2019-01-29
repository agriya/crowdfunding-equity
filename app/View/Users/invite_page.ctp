<?php echo $this->Form->create('Subscription', array('action' => 'check_invitation', 'class' => "text-left clearfix"));?>
<div>
  <div class="input text">
  <?php
    echo $this->Form->input('invite_hash',array('label'=>__l('Enter your invitation code'), 'class' => 'col-md-4'));
  ?>
  </div>
</div>
<div class="submit btn-align">
  <?php echo $this->Form->submit(__l('Sign Up')); ?>
</div>
<?php echo $this->Form->end();