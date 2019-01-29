<div class="container social-myconnect setting-drop-menu">
	<div class="clearfix user-heading">
		<h3 class="col-xs-6 h2 text-uppercase navbar-btn"><?php echo __l('Social'); ?></h3>
		<div class="col-xs-6 navbar-btn">
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
	<div class="thumbnail">
	  <?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id')); ?>
	  <div class="page-header clearfix">
		<div class="col-md-1 navbar-btn"><i class="fa fa-facebook-square fa-3x text-primary"></i></div>
		<?php if (!empty($user['User']['is_facebook_connected'])) { ?>
		  <?php
			$width = Configure::read('thumb_size.medium_thumb.width');
			$height = Configure::read('thumb_size.medium_thumb.height');
			$user_image = $this->Html->getFacebookAvatar($user['User']['facebook_user_id'], $height, $width);
		  ?>
		  <div class="col-md-7 well text-primary"><?php echo $user_image . ' ' . __l('You have already connected to Facebook.')?></div>
		  <?php if (empty($user['User']['is_facebook_register'])): ?>
			<div class="col-md-3 navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Facebook')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'facebook'), array('title' => sprintf(__l('Disconnect from %s'), __l('Facebook')) ,'class' => 'btn btn-primary form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <div class="col-md-7 well"><?php echo __l('Increase your reputation by showing Facebook friends count.'); ?></div>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'facebook',
			  'import' => 'facebook',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-3 navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Facebook')), $connect_url, array('title' => sprintf(__l('Connect with %s'),__l('Facebook')) , 'class' => 'js-connect js-no-pjax btn btn-primary form-control {"url":"'.$connect_url.'"}')); ?></div>
		<?php } ?>
	  </div>
	  <div class="page-header clearfix">
		<div class="col-md-1 navbar-btn"><i class="fa fa-twitter-square fa-3x text-info"></i></div>
		<?php if (!empty($user['User']['is_twitter_connected'])) { ?>
		  <?php
			$width = Configure::read('thumb_size.medium_thumb.width');
			$height = Configure::read('thumb_size.medium_thumb.height');
			$user_image = '';
			if (!empty($user['User']['twitter_avatar_url'])):
			  $user_image = $this->Html->image($user['User']['twitter_avatar_url'], array(
				'title' => $this->Html->cText($user['User']['username'], false) ,
				'width' => $width,
				'height' => $height
			  ));
			endif;
		  ?>
		  <div class="col-md-7 well text-info"><span><?php echo $user_image . ' ' . __l('You have already connected to Twitter.'); ?></span></div>
		  <?php if (empty($user['User']['is_twitter_register'])): ?>
			<div class="col-md-3 navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Twitter')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'twitter'), array('title' => sprintf(__l('Disconnect from %s'), __l('Twitter')),'class' => 'btn btn-info form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <div class="col-md-7 well text-info"><?php echo __l('Increase your reputation by showing Twitter followers count.')?></div>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'twitter',
			  'import' => 'twitter',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-3 navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Twitter')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Twitter')),'class' => 'js-connect js-no-pjax btn btn-info form-control {"url":"'.$connect_url.'"}')); ?></div>
		<?php } ?>
	  </div>
	  <div class="page-header clearfix">
		<div class="col-md-1 navbar-btn">
			<span class="fa-stack fa-lg">
				<i class="fa fa-square fa-stack-2x text-success"></i>
				<i class="fa fa-google fa-stack-1x fa-inverse"></i>
			</span>
		</div>
		<?php if (!empty($user['User']['is_google_connected'])) { ?>
						<?php
			$width = Configure::read('thumb_size.medium_thumb.width');
			$height = Configure::read('thumb_size.medium_thumb.height');
			$user_image = '';
			if (!empty($user['User']['google_avatar_url'])):
			  $user_image = $this->Html->image($user['User']['google_avatar_url'], array(
				'title' => $this->Html->cText($user['User']['username'], false) ,
				'width' => $width,
				'height' => $height
			  ));
			endif;
		  ?>
		  <div class="col-md-7 well text-success"><?php  echo $user_image . ' ' . __l('You have already connected to Gmail.')?></div>
		  <?php if (empty($user['User']['is_google_register'])): ?>
			<div class="col-md-3 navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Gmail')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'google'), array('title' => sprintf(__l('Disconnect from %s'), __l('Gmail')),'class' => 'btn btn-success form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <div class="col-md-7 well text-success"><?php echo __l('Increase your reputation by showing Google contacts count.')?></div>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'google',
			  'import' => 'google',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-3 navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Gmail')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Gmail')),'class' => 'js-connect js-no-pjax btn btn-success form-control {"url":"'.$connect_url.'"}'));
		  ?></div>
		<?php } ?>
	  </div>
	  <div class="page-header clearfix">
		<div class="col-md-1 text-46"><i class="fa fa-google-plus-square text-warning fa-3x"></i></div>
		<?php if (!empty($user['User']['is_googleplus_connected'])) { ?>
		  <div class="col-md-7 well text-warning"><?php echo __l('You have already connected to Google+.')?></div>
		  <?php if (empty($user['User']['is_googleplus_register'])): ?>
			<div class="col-md-3 navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Google+')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'googleplus'), array('title' => sprintf(__l('Disconnect from %s'), __l('Google+')),'class' => 'btn warning form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <div class="col-md-7 well text-warning"><?php echo __l('Increase your reputation by showing Google+ contacts count.')?></div>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'googleplus',
			  'import' => 'googleplus',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-3 navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Google+')), $connect_url, array('title' =>sprintf(__l('Connect with %s'), __l('Google+')),'class' => 'js-connect js-no-pjax btn btn-warning form-control {"url":"'.$connect_url.'"}'));
		  ?></div>
		<?php } ?>
	  </div>
	  <div class="page-header clearfix">
		<div class="col-md-1 text-46"><i class="fa fa-hacker-news text-danger fa-3x"></i></div>
		<?php if (!empty($user['User']['is_yahoo_connected'])) { ?>
		  <div class="col-md-7 well text-danger"><?php  echo __l('You have already connected to Yahoo!.')?></div>
		  <?php if (empty($user['User']['is_yahoo_register'])): ?>
			<div class="col-md-3 navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), 'Yahoo'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'yahoo'), array('title' => sprintf(__l('Disconnect from %s'), __l('Yahoo')),'class' => 'btn btn-danger form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'yahoo',
			  'import' => 'yahoo',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-7 well text-danger"><?php echo __l('Increase your reputation by showing Yahoo! contacts count.')?></div>
		  <div class="col-md-3 navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Yahoo!')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Yahoo!')), 'class' => 'js-connect js-no-pjax btn btn-danger form-control {"url":"'.$connect_url.'"}'));
		  ?></div>
		<?php } ?>
	  </div>
	  <div class="page-header no-bor clearfix text-info">
		<div class="col-md-1 text-46"><i class="fa fa-linkedin-square fa-3x"></i></div>
		<?php if (!empty($user['User']['is_linkedin_connected'])) { ?>
		<?php
			$width = Configure::read('thumb_size.medium_thumb.width');
			$height = Configure::read('thumb_size.medium_thumb.height');
			$user_image = '';
			if (!empty($user['User']['linkedin_avatar_url'])):
			  $user_image = $this->Html->image($user['User']['linkedin_avatar_url'], array(
				'title' => $this->Html->cText($user['User']['username'], false) ,
				'width' => $width,
				'height' => $height
			  ));
			endif;
		?>
		  <div class="col-md-7 well text-info"><?php  echo $user_image . ' ' . __l('You have already connected to LinkedIn.')?></div>
		  <?php if (empty($user['User']['is_linkedin_register'])): ?>
			<div class="col-md-3  navbar-btn">
			  <?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Linkedin')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'linkedin'), array('title' =>sprintf(__l('Disconnect from %s'), __l('Linkedin')),'class' => 'btn btn-info form-control js-confirm')); ?>
			</div>
		  <?php endif; ?>
		<?php } else { ?>
		  <div class="col-md-7 well text-info"><?php echo __l('Increase your reputation by showing LinkedIn connections count.')?></div>
		  <?php
			$connect_url = Router::url(array(
			  'controller' => 'social_marketings',
			  'action' => 'import_friends',
			  'type' =>'linkedin',
			  'import' => 'linkedin',
			  'from' => 'social'
			), true);
		  ?>
		  <div class="col-md-3  navbar-btn"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Linkedin')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Linkedin')) ,'class' => 'js-connect js-no-pjax btn btn-info form-control {"url":"'.$connect_url.'"}'));
		  ?></div>
		<?php } ?>
	  </div>
	</div>
</div>