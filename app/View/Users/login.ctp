<div class="container">
<div class="user-login-sec clearfix">
  <aside class="login-form">
	  <ul class="list-inline clearfix login-title">
		<li class="pull-left"><h2 class="navbar-btn"><?php echo __l('Login');?></h2> </li>
		<li class="pull-right"><i class="fa fa-key" aria-hidden="true"></i></li>
	  </ul>
  <?php echo $this->Form->create('User', array('action' => 'login','class' => 'form-horizontal center-block'));
  
	  echo $this->Form->input(Configure::read('user.using_to_login'),array('label'=>__l(ucfirst(Configure::read('user.using_to_login'))),'class' => 'form-control navbar-btn list-group-item-heading','placeholder' => __l(ucfirst(Configure::read('user.using_to_login')))));
	  echo $this->Form->input('passwd', array('label' => __l('Password'),'class' => 'form-control navbar-btn list-group-item-heading','placeholder' => __l('Password')));?>
	  <ul class="list-inline clearfix">
		<li class="pull-left float-none"> 
			<?php echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));?>
		</li>
		<li class="pull-right float-none"> 
			<p class="navbar-btn marg-btom-20">
			  <?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false),array('title' => __l('Forgot your password?'),'class' => 'text-info js-no-pjax')); ?>
			  <?php if (!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && empty($this->request->params['requested'])):  ?>  <?php echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Register'), 'class' => 'show text-info js-no-pjax'));?><?php endif; ?>
			  <?php
			  $f = (!empty($_GET['f'])) ? $_GET['f'] : ((!empty($this->request->data['User']['f'])) ? $this->request->data['User']['f'] : (($this->request->params['controller'] != 'users' && ($this->request->params['action'] != 'login' && $this->request->params['action'] != 'admin_login')) ? $this->request->url : ''));
			  if (!empty($f)):
				echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
			  endif;
			  ?>
		    </p>
		</li>
	  </ul>
  <div class="submit-form">
  <?php echo $this->Form->submit(__l('Login'), array('class' => 'form-control btn text-b')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
  
  </aside>
  <?php if(!Configure::read('site.maintenance_mode') && ((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect') || Configure::read('openid.is_enabled_openid_connect') || Configure::read('angellist.is_enabled_angellist_connect')))):?>
  <article class="social-block border-right text-center">
	<p class="text-center text-16"><?php echo __l('Or login with'); ?></p>
	<ul class="list-inline">
		<?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-facebook fa-fw')), '#', array('title' => __l('Facebook'), 'escape' => false,'class' => "btn btn-primary fb-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif; ?>
		  
		<?php if (Configure::read('twitter.is_enabled_twitter_connect')): ?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-twitter fa-fw')), '#', array('title' => __l('Twitter'), 'escape' => false, 'class' => "btn btn-info twitter-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
		 
		<?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-linkedin fa-fw')), '#', array('title' => __l('LinkedIn'), 'escape' => false, 'class' => "btn btn-info linkedin-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif; ?>
		  
		<?php if (Configure::read('yahoo.is_enabled_yahoo_connect')): ?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-yahoo fa-fw')), '#', array('title' => __l('Yahoo!'), 'escape' => false, 'class' => "btn btn-info yahoo-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
		  
		<?php if(Configure::read('google.is_enabled_google_connect')):?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-google fa-fw')), '#', array('title' => __l('Google'), 'escape' => false,'class' => "btn btn-success google-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
		  
		<?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-google-plus fa-fw')), '#', array('title' => __l('Google+'), 'escape' => false,'class' => "btn btn-danger gooplus-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
		  
		<?php if(Configure::read('openid.is_enabled_openid_connect')):?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-openid fa-fw')), '#', array('title' => __l('OpenID'), 'escape' => false,'class' => "btn btn-warning openid-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
		   
		<?php if(Configure::read('angellist.is_enabled_angellist_connect')):?>
			<li>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'angellist', 'admin' => false), true); ?>
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-angellist fa-fw')), '#', array('title' => __l('AngelList'), 'escape' => false,'class' => "btn btn-default angellist-btn js-connect js-no-pjax",'data-url' => $url)); ?>
			</li>
		<?php endif;?>
	</ul>
  </article>
  <?php endif;?>
</div>
</div>
<div id="fb-root"></div>