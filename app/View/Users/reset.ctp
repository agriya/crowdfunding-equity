<div class="sign-up grid_15 prefix_5 clearfix">
<div class="l-curve-top">
      <div class="r-curve-top">
          <div class="top-bg"></div>
    </div>
    </div>
  <div class="shad-bg-lft clearfix">
      <div class="shad-bg-rgt">
      <div class="shad-bg clearfix">
    <div class="main-section">
<h2><?php echo __l('Reset Password'); ?></h2>
<?php
  echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash  ,'class' => 'normal clearfix'));
  echo $this->Form->input('user_id', array('type' => 'hidden'));
  echo $this->Form->input('hash', array('type' => 'hidden'));
  echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') ,'id' => 'password'));
  echo $this->Form->input('confirm_password', array('type' => 'password','label' => __l('Confirm Password'))); ?>
  <div class="form-actions clearfix"><?php echo $this->Form->submit(__l('Change Password')); ?></div>
  <?php echo $this->Form->end(); ?>
</div>
</div>
</div>
</div>
<div class="l-curve-bot">
       <div class="r-curve-bot">
           <div class="bot-bg"></div>
     </div>
    </div>
</div>