 <div class="container social-register">
 <h2><?php echo __l('Register'); ?></h2>
 <article class="bg-light-gray social-block text-center clearfix">
<?php if (!empty($referredByUser)) { ?>
  <div class="clearfix page-header">
    <div class="clearfix">
      <div class="pull-left">
        <?php echo $this->Html->getUserAvatar($referredByUser['User'], 'micro_thumb', 0); ?>
      </div>
      <h4 class="col-md-7 invited pull-left">
        <?php echo sprintf(__l('%s has invited you to join %s'), $referredByUser['User']['username'], Configure::read('site.name')); ?>
      </h4>
    </div>
  </div>
<?php } ?>
  <div class="page-header list-group-item-heading">
  <h4><?php echo __l('Quick Sign Up');?></h4>
  </div>
  <div class="row">
  <div class="col-sm-12 col-md-8 social-block-contain">
  <div class="row">
    <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
    <div class="col-xs-12 col-sm-5">
      <?php if (isPluginEnabled('SocialMarketing')) { ?>
      <span class="js-facepile-loader loader"></span>
      <span id="js-facepile-section" class="{'fb_app_id':'<?php echo Configure::read('facebook.app_id'); ?>'} sfont"></span>
      <?php } ?>
      &nbsp;
    </div>
    <div class="col-xs-12 col-sm-7 col-md-4">
      <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
      <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-facebook fa-fw')).$this->Html->tag('span', 'Login with facebook'), '#', array('escape' => false,'class' => "btn btn-primary fb-btn js-connect js-no-pjax",'data-url' => $url)); ?>
    </div>
    <?php endif; ?>
  </div>	
  <?php if (Configure::read('twitter.is_enabled_twitter_connect')): ?>
    <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
      <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
    <?php endif; ?>
  <div>
      <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
      <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-twitter fa-fw')).$this->Html->tag('span', 'Login with Twitter'), '#', array('escape' => false, 'class' => "btn btn-info twitter-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif;?>
  <?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect'))): ?>
	  <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
	<?php endif;?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-linkedin fa-fw')).$this->Html->tag('span', 'Login with Linked in'), '#', array('escape' => false, 'class' => "btn btn-info linkedin-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif;?>
  <?php if(Configure::read('yahoo.is_enabled_yahoo_connect')):?>
  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect'))): ?>
  <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
    <?php endif; ?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-yahoo fa-fw')).$this->Html->tag('span', 'Login with Yahoo'), '#', array('escape' => false, 'class' => "btn btn-info yahoo-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif;?>
  <?php if(Configure::read('google.is_enabled_google_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect'))): ?>
      <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
    <?php endif;?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-google fa-fw')).$this->Html->tag('span', 'Login with Google'), '#', array('escape' => false,'class' => "btn btn-success google-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif;?>
  <?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect'))): ?>
      <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
    <?php endif;?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-google-plus fa-fw')).$this->Html->tag('span', 'Login with Google Plus'), '#', array('escape' => false,'class' => "btn btn-danger gooplus-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif;?>
  <?php if(Configure::read('openid.is_enabled_openid_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect'))): ?>
      <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
    <?php endif;?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-openid fa-fw')).$this->Html->tag('span', 'Login with Open Id'), '#', array('escape' => false,'class' => "btn btn-warning openid-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif; ?>
    <?php if(Configure::read('angellist.is_enabled_angellist_connect')):?>
      <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect') || Configure::read('openid.is_enabled_openid_connect'))): ?>
        <h4><span><strong><?php echo __l('Or');?></strong></span></h4>
      <?php endif;?>
  <div>
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-angellist fa-fw')).$this->Html->tag('span', 'Login with Angel list'), '#', array('escape' => false,'class' => "btn btn-default angellist-btn js-connect js-no-pjax",'data-url' => $url)); ?>
  </div>
  <?php endif; ?>
  <div>
  <p><span class="show"><?php echo __l('Sign up with a social network to follow your friends ') ?></span> <span class="show"><?php echo __l('By signing up you agree to the  '); ?><?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('class' => 'text-info js-no-pjax', 'target' => '_blank', 'title' => __l('Terms & Conditions'), 'escape' => false)); ?></span><span class="show"><?php echo __l("If you don't want to sign up with a social network,") . ' ' .$this->Html->link(__l('click here'), array('controller' => 'users', 'action' => 'register'), array('title' => __l('Click here'), 'class' => 'text-info js-no-pjax')) . '.'; ?></span></p>
  <p><?php echo __l('Already have an account?') . ' ' . $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'), 'class' => 'text-info')); ?></p>
  </div>
  </div>
  </div>
</article>
</div>
<div id="fb-root"></div>