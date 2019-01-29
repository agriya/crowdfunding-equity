<div class="js_subscribe_invitation <?php if ($success_msg): ?>hide <?php endif; ?>">
<?php echo $this->Form->create('Subscription', array('controller' => 'subscription', 'action' => 'check_invitation', 'class' => "form-inline clearfix col-lg-6 col-md-8 col-sm-10 col-md-offset-3 col-sm-offset-2"));?>
  <?php
    echo $this->Form->input('invite_hash', array('label'=> false, 'placeholder' => __l('Enter your invitation code'), 'class' => 'form-control'));
  ?>
<div class="form-group">
  <?php echo $this->Form->submit(__l('Signup'), array('class' => 'btn btn-default')); ?>
</div>
<?php echo $this->Form->end();
?>
</div>
<div class="js_subscribe_email clearfix <?php if (!$success_msg): ?> hide <?php endif; ?>">
<?php if ($success_msg): ?>
    <?php
      echo $this->Form->create('Subscription', array('controller' => 'subscription', 'action' => 'add', 'class' => "form-inline clearfix js-ajax-form col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"));
      if(!empty($error_message)) {
        $label = __l('You may request for new invitation code below');
      } else {
        $label = __l('Request Invite');
      }
    ?>
    <?php echo $this->Form->input('email', array('label' => $label,'placeholder' => __l('Enter your email'),'class'=>'form-control')); ?>
    <div class="form-group">
		<?php echo $this->Form->submit(__l('Request Invite'), array('class'=>'btn btn-default')); ?>
	</div>
    <?php echo $this->Form->end(); ?>
  <?php else: ?>
    
	  <?php if($success_msg!='3') {?>
	  <?php if($success_msg!='2') {?>
		<p class="thanks"><?php echo __l('Thanks for your interest.'); ?></p>
		<p><?php echo __l("Please confirm your email address by checking your inbox");?></p>
	<?php	} else { ?>
		<p class="thanks"><?php echo __l('Email Verified successfully.' ); ?></p>
		<p><?php echo __l("Sorry, currently we're out of invitation code. We send invitation code in periodic basis.");?></p>
    <div><p><?php echo __l("You will receive email when it's ready for you.");?></p></div>
      <p class="thanks"><?php echo __l('Thanks for your interest.');?></p>
	<?php }?>
	<?php }?>

  <?php endif; ?>
 </div>