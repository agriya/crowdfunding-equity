<div class="container">
<div class="user-register-sec admin-form">

<?php if (!empty($referredByUser)) { ?>
  <div class="col-xs-12">
    <div class="media clearfix marg-top-20">	
      <div class="pull-left marg-top-20">
        <?php echo $this->Html->getUserAvatar($referredByUser['User'], 'micro_thumb', 0); ?>
      </div>
      <h4 class="media-body invited pull-left marg-top-20">
        <?php echo sprintf(__l('%s has invited you to join %s'), $referredByUser['User']['username'], Configure::read('site.name')); ?>
      </h4>
    </div>
  </div>
<?php } ?>
<?php if( Configure::read('twitter.is_enabled_twitter_connect') OR Configure::read('facebook.is_enabled_facebook_connect') OR Configure::read('linkedin.is_enabled_linkedin_connect') OR Configure::read('yahoo.is_enabled_yahoo_connect') OR  Configure::read('google.is_enabled_google_connect') OR Configure::read('googleplus.is_enabled_googleplus_connect') OR Configure::read('openid.is_enabled_openid_connect') OR Configure::read('angellist.is_enabled_angellist_connect') ) {?>
    <?php } ?>
  <div class="login-form">	
	  <ul class="list-inline clearfix login-title">
		<li class="pull-left"><h2 class="navbar-btn"><?php echo __l('Register');?></h2></li>
		<li class="pull-right"><i class="fa fa-pencil" aria-hidden="true"></i></li>
	  </ul>
	  <?php echo $this->Form->create('User', array('action' => 'register', 'class' => 'form-horizontal')); ?>
	  <div class="clearfix">
	  <?php
	  if (!empty($this->request->data['User']['openid_url'])):
		echo $this->Form->input('openid_url', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_url']));
	  endif;
	  echo $this->Form->input('username',array('label' =>array( __l('Username')),'placeholder' => __l('User Name')));
	  if (empty($this->request->data['User']['identifier'])):
		 echo $this->Form->input('passwd', array('label' =>array( __l('Password')),'placeholder' => __l('Password')));
	  endif;
	  if (!empty($this->request->data['User']['identifier'])):
		echo $this->Form->input('identifier', array('type' => 'hidden'));
	  endif;
	  echo $this->Form->input('email',array('label' =>array( __l('Email')),'placeholder' => __l('Email')));
	  if (!empty($this->request->params['named']['refer_id'])):
		echo $this->Form->input('referred_by_user_id', array('type' => 'hidden', 'value' => $this->request->params['named']['refer_id']));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
	  endif;
	  if (!empty($this->request->data['User']['facebook_user_id'])):
		echo $this->Form->input('is_facebook_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_facebook_register']));
		echo $this->Form->input('is_facebook_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 2));
		echo $this->Form->input('facebook_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_user_id']));
		if (!empty($this->request->data['User']['facebook_access_token'])):
			echo $this->Form->input('facebook_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_access_token']));
		endif;
	  endif;
	  if (!empty($this->request->data['User']['twitter_user_id'])):
		echo $this->Form->input('twitter_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_user_id']));
		echo $this->Form->input('is_twitter_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_twitter_register']));
		echo $this->Form->input('is_twitter_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 3));
		if (!empty($this->request->data['User']['photoURL'])):
		  echo $this->Form->input('twitter_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
		endif;
		if (!empty($this->request->data['User']['twitter_access_token'])):
		  echo $this->Form->input('twitter_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_token']));
		endif;
		if (!empty($this->request->data['User']['twitter_access_key'])):
		  echo $this->Form->input('twitter_access_key', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_key']));
		endif;
	  endif;
	  if (!empty($this->request->data['User']['is_openid_register'])):
		echo $this->Form->input('is_openid_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_openid_register']));
		echo $this->Form->input('openid_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_user_id']));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
	  endif;
	  if (!empty($this->request->data['User']['is_google_register'])):
		echo $this->Form->input('is_google_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_google_register']));
		echo $this->Form->input('is_google_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 4));
		echo $this->Form->input('google_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['google_user_id']));
		echo $this->Form->input('google_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['google_access_token']));
		if (!empty($this->request->data['User']['photoURL'])):
		  echo $this->Form->input('google_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
		endif;
	  endif;
	  if (!empty($this->request->data['User']['is_googleplus_register'])):
		echo $this->Form->input('is_googleplus_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_googleplus_register']));
		echo $this->Form->input('is_googleplus_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 6));
		echo $this->Form->input('googleplus_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_user_id']));
		echo $this->Form->input('googleplus_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_access_token']));
		if (!empty($this->request->data['User']['photoURL'])):
		  echo $this->Form->input('googleplus_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
		endif;
	  endif;
	  if (!empty($this->request->data['User']['is_angellist_register'])):
		echo $this->Form->input('is_angellist_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_angellist_register']));
		echo $this->Form->input('is_angellist_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 7));
		echo $this->Form->input('angellist_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['angellist_user_id']));
		if (!empty($this->request->data['User']['photoURL'])):
		  echo $this->Form->input('angellist_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
		endif;
	  endif;
	  if (!empty($this->request->data['User']['is_yahoo_register'])):
		echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
		echo $this->Form->input('is_yahoo_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('yahoo_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['yahoo_user_id']));
	  endif;
	  if (!empty($this->request->data['User']['is_linkedin_register'])):
		echo $this->Form->input('is_linkedin_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_linkedin_register']));
		echo $this->Form->input('is_linkedin_connected', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 5));
		echo $this->Form->input('linkedin_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_user_id']));
		echo $this->Form->input('linkedin_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_access_token']));
		if (!empty($this->request->data['User']['photoURL'])):
		  echo $this->Form->input('linkedin_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
		endif;
	  endif;
	  echo $this->Form->input('country_iso_code', array('type' => 'hidden','id' => 'country_iso_code'));
	  echo $this->Form->input('State.name', array('type' => 'hidden'));
	  echo $this->Form->input('City.name', array('type' => 'hidden'));
	  echo $this->Form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
	  echo $this->Form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
	  if (!empty($this->request->data['User']['displayName'])):
		  echo $this->Form->input('display_name', array('type' => 'hidden', 'value' => $this->request->data['User']['displayName']));
	  endif;
	  if (!empty($this->request->data['User']['firstName']) || !empty($this->request->data['UserProfile']['firstName'])):
		  echo $this->Form->input('UserProfile.first_name', array('type' => 'text', 'value' => (!empty($this->request->data['User']['firstName'])) ? $this->request->data['User']['firstName'] : $this->request->data['UserProfile']['firstName']));
	  endif;
	  if (!empty($this->request->data['User']['lastName']) || !empty($this->request->data['UserProfile']['lastName'])):
		  echo $this->Form->input('UserProfile.last_name', array('type' => 'text', 'value' => (!empty($this->request->data['User']['lastName'])) ? $this->request->data['User']['lastName'] : $this->request->data['UserProfile']['lastName']));
	  endif;
	  if (!empty($this->request->data['User']['gender'])):
		  echo $this->Form->input('UserProfile.gender_id', array('type' => 'hidden', 'value' => ($this->request->data['User']['gender']=='male')? 1 : 2 ));
	  endif;
	  $response = Cms::dispatchEvent('View.User.additionalFields', $this, array(
		'data' => $this->request->data
	  ));
	  echo !empty($response->data['content'])?$response->data['content']:'';
	  if (empty($this->request->data['User']['identifier'])) {
		if (Configure::read('system.captcha_type') == 'Solve Media') {
	  ?>
	  <div class="clearfix">
	  <div class="captchas">
		<?php
		include_once VENDORS . DS . 'solvemedialib.php';  //include the Solve Media library
		echo solvemedia_get_html(Configure::read('captcha.challenge_key'));  //outputs the widget
		?>
	  </div>
	  </div>
	  <?php } else { ?>
	  <div class="clearfix">
		<div class="input clearfix help js-captcha-container img-thumbnail span captcha-block">
		<div class="pull-left">
		  <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
		</div>
		<div class="input-group pull-left ver-space">
		  <div class="text-center">
		  <?php echo $this->Html->link('<i class="fa fa-refresh"></i> <span class="hide">' . __l('Reload CAPTCHA') . '</span>', '#', array('escape' => false, 'class' => 'js-captcha-reload js-no-pjax captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
		  </div>
		  <div>
		  <div class="play-link">
			<?php echo $this->Html->link(__l('Click to play'), Router::url('/', true) . "flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'comments', 'action'=>'captcha_play')) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
		  </div>
		  </div>
		</div>
		</div>
	  </div>
	  <?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
	  <?php } ?>
	  <?php
	  if(isPluginEnabled('SecurityQuestions')) {
		 echo '<div class="navbar-btn">';
		echo $this->Form->input('security_question_id',array('label' =>array( __l('Security Question'))),array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
		echo '</div>';
		echo $this->Form->input('security_answer', array('label' =>array( __l('Answer')),'placeholder' => __l('Security Answer')));
	  } ?>
	 <div class="clearfix input checkbox js-register-terms required">
	  <?php echo $this->Form->input('is_agree_terms_conditions', array('div' => false, 'label' => sprintf(__l('I have read, understood & agree to the %s'), $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('title' => __l('Terms & Conditions'), 'class' => 'js-no-pjax', 'target' => '_blank', 'escape' => false))))); ?>
	 </div>
	  <?php } ?>
	  <div class="submit-form"> 
		<?php echo $this->Form->submit(__l('Register'),array('class' => 'btn form-control')); ?> 
		<div class="marg-top-20 text-center"><?php echo __l('Already have an account?');?> <?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login', 'admin'=>false), array('title' => __l('Login'),'class' => 'text-info marg-left-5'));?> </div>
	  </div>
	  </div>
	  <?php echo $this->Form->end(); ?>
</div>
<?php if(((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect') || Configure::read('openid.is_enabled_openid_connect') || Configure::read('angellist.is_enabled_angellist_connect')))) {
?>
<div class="clearfix social-block">
		<p class="text-center text-16"><?php echo __l('Or SignUp with'); ?></p>
      <ul class="list-inline text-center">
      <?php if (Configure::read('facebook.is_enabled_facebook_connect')){ ?>
        <li>
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-facebook"></i>', '#', array('title' => __l('Facebook'), 'escape' => false,'class' =>
        "btn btn-primary fb-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('twitter.is_enabled_twitter_connect')){ ?>
        <li>
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-twitter"></i>', '#', array('title' => __l('Twitter'), 'escape' => false, 'class' => "btn btn-info twitter-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('linkedin.is_enabled_linkedin_connect')){ ?>
        <li>
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-linkedin"></i>', '#', array('title' => __l('LinkedIn'), 'escape' => false, 'class' => "btn btn-info linkedin-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')){ ?>
        <li class="yahoo-icon">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-yahoo"></i>', '#', array('title' => __l('Yahoo!'), 'escape' => false, 'class' => "btn btn-info yahoo-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('google.is_enabled_google_connect')) { ?>
        <li class="google-sign">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-google"></i>', '#', array('title' => __l('Google'), 'escape' => false,'class' => "btn btn-success google-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
	  <?php if (Configure::read('googleplus.is_enabled_googleplus_connect')) { ?>
        <li>
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-google-plus"></i>', '#', array('title' => __l('Google+'), 'escape' => false,'class' => "btn btn-danger gooplus-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('openid.is_enabled_openid_connect')) { ?>
        <li>
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="fa fa-openid"></i>', '#', array('title' => __l('OpenID'), 'escape' => false,'class' => "btn btn-warning openid-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
	  <?php if (Configure::read('angellist.is_enabled_angellist_connect')) { ?>
        <li class="angellist">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'angellist', 'admin' => false), true); ?>
		<?php echo $this->Html->link('<i class="fa fa-angellist"></i>', '#', array('title' => __l('AngelList'), 'escape' => false,'class' => "btn btn-default angellist-btn js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
       </ul>
     </div>
<?php } ?>	 
</div>