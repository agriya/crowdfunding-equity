<div class="forget-password">
	<div class="container">
		<div class="forget-password-sec admin-form">
		  <div class="login-form">
			  <ul class="list-inline clearfix login-title">
				<li class="pull-left"><h2 class="navbar-btn"><?php echo __l('Forgot your password?');?></h2></li>
				<li class="pull-right"><i class="fa fa-question" aria-hidden="true"></i></li>
			  </ul>
			  <?php echo $this->Form->create('User', array('action' => 'forgot_password', 'class' => 'form-horizontal')); ?>
			  <div class="clearfix">
				<?php echo $this->Form->input('email', array('type' => 'text','placeholder' => 'Email'));?>
				<?php if (Configure::read('user.is_enable_forgot_password_captcha')): ?>
				<?php if (Configure::read('system.captcha_type') == 'Solve Media') { ?>
				  <div class="help">
				  <?php
					include_once VENDORS . DS . 'solvemedialib.php';  //include the Solve Media library
					echo solvemedia_get_html(Configure::read('captcha.challenge_key'));  //outputs the widget
				  ?>
				  </div>
				<?php } else { ?>
				<div class="clearfix">
				  <div class="input help js-captcha-container img-thumbnail span captcha-block clearfix">
				  <div class="pull-left">
				  <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
				  </div>
				  <div class="input-group pull-left">
				  <div class="text-center">
				  <?php echo $this->Html->link('<i class="fa fa-refresh"></i> <span class="hide">' . __l('Reload CAPTCHA') . '</span>', '#', array('escape' => false, 'class' => 'js-captcha-reload js-no-pjax captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
				  </div>
				  <div>
					<?php echo $this->Html->link(__l('Click to play'), Router::url('/',true)."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play')) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
				  </div>
				  </div>
				  </div>
				  </div>
				  <?php echo $this->Form->input('captcha', array('value' =>'' ,'label' => __l('Security Code'), 'placeholder' => __l('Security Code'))); ?>

				<?php } ?>
				<?php endif; ?>
				<div class="submit-form">
					<?php echo $this->Form->submit(__l('Send'), array('class' => 'form-control btn'));?>
				</div>
			  </div>
			  <?php echo $this->Form->end();?>
		  </div>
		  <div class="alert text-info">
		  <?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
		  </div>
		</div>
    </div>	
</div>