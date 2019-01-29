<?php if (Configure::read('site.launch_mode') == 'Private Beta') { ?>
  <?php if (!$success_msg): ?>
    <?php
      echo $this->Form->create('Subscription', array('class' => "form-inline clearfix js-ajax-form"));
      if(!empty($error_message)) {
        $label = __l('You may request for new invitation code below');
      } else {
        $label = __l('Request Invite');
      }
    ?>

	<?php echo $this->Form->input('email', array('label' => $label,'placeholder' => __l('Enter your email'),'class'=>'form-control')); ?>
    <div class="form-group">
		<?php echo $this->Form->submit(__l('Request Invite'), array('class' => 'btn btn-default')); ?>
	</div>
    <?php echo $this->Form->end(); ?>
  <?php else: ?>
    <p><?php echo __l("Sorry, currently we're out of invitation code. We send invitation code in periodic basis.");?></p>
    <div><p><?php echo __l("You will receive email when it's ready for you.");?></p></div>
      <p class="thanks"><?php echo __l('Thanks for your interest.');?></p>
  <?php endif; ?>
<?php } else { ?>
  <?php if (!$success_msg): ?>
    <div class="clearfix">
		<p class="text-18"> <?php echo __l('* Want to be the first to know when site is ready?') ;?> </p>
		<?php echo $this->Form->create('Subscription', array('class' => 'form-inline clearfix col-lg-6 col-md-8 col-sm-10 col-md-offset-3 col-sm-offset-2')); ?>
		<?php if(!empty($error_message)): ?>     
		<?php endif; ?>
		<?php echo $this->Form->input('email', array('label' => false , 'placeholder' => __l('Enter your email'),'class'=>'form-control')); ?>
		<div class="form-group">
			<?php echo $this->Form->submit(__l('Notify Me'), array('class' => 'btn btn-default')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
    </div>
    <div class="text-center text-14"><?php echo __l('By submitting this email, I am authorizing site to send me emails until I unsubscribe.'); ?>
    <?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy-policy', 'admin' => false), array('title' => __l('Privacy Policy'), 'class'=>'js-no-pjax text-underline', 'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal'));?>
    </div>
				<div id="js-ajax-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header"></div>
							<div class="modal-body js-social-link-div clearfix text-left">
								<div class="text-center">
								<?php echo $this->Html->image('ajax-circle-loader.gif', array('alt' => __l('[Image:Loader]') ,'width' => 100, 'height' => 100, 'class' => 'js-loader')); ?></div>
							</div>
							<div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
						</div>
					</div>
				</div>
  <?php else: 
	if($success_msg!='2') {?>
		<p class="thanks"><?php echo __l('Thanks for your interest.'); ?></p>
		<p><?php echo __l("You will receive email when it's ready for you.");?></p>
	<?php	} else { ?>
		<p class="thanks"><?php echo __l('Email Verified successfully.' ); ?></p>
		<p><?php echo __l("Thanks for your interest. Our team will contact you soon.");?></p>
	<?php }?>
  <?php endif; ?>
<?php } ?>
