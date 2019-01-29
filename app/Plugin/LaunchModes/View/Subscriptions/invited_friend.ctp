<div class="clearfix">
<span class="col-md-5 invited clearfix">
<span  class="pull-left">
<span class="pull-left">
<?php
  echo $this->Html->getUserAvatar($this->request->data['User'], 'micro_thumb', false);
?>
</span>
<?php
	echo __l('Invitation code from')." ".$this->request->data['User']['username']." ".__l('is accepted'); 
?>
</span>
</span>
</div>
<div class="clearfix">
  <div class="clearfix">
    <div class="clearfix">
    <span class="pull-left"><strong><?php echo __l('Sign In using'); ?></strong></span>
    <ul class="list-unstyled row">
      <?php if (Configure::read('facebook.is_enabled_facebook_connect')){ ?>
        <li class="col-md-1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="fa fa-facebook-square facebookc"></i><span class="hide">Facebook</span>', '#', array('escape' => false,'class' =>
          "js-connect js-no-pjax"),'data-url' => $url ); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('twitter.is_enabled_twitter_connect')){ ?>
        <li class="col-md-1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="fa fa-twitter-square twitterc"></i><span class="hide">Twitter</span>', '#', array('escape' => false, 'class' => "js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('linkedin.is_enabled_linkedin_connect')){ ?>
        <li class="col-md-1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-linkedin-sign linkedc"></i><span class="hide">LinkedIn</span>', '#', array('escape' => false, 'class' => "js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')){ ?>
        <li class="col-md-1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-yahoo yahooc"></i><span class="hide">Yahoo!</span>', '#', array('escape' => false, 'class' => "js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('google.is_enabled_google_connect')) { ?>
        <li class="col-md-1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-google-sign googlec"></i><span class="hide">Google</span>', '#', array('escape' => false,'class' => "js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
						<?php if (Configure::read('googleplus.is_enabled_googleplus_connect')) { ?>
        <li class="col-md-1">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-google-plus-sign googleplusc"></i><span class="hide">Google+</span>', '#', array('title' => 'Google+', 'escape' => false,'class' => "js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('openid.is_enabled_openid_connect')) { ?>
        <li class="col-md-1 stack">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
          <?php echo $this->Html->link(__l('OpenID'), '#', array('escape' => false,'class' => "open-id show js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
						<?php if (Configure::read('angellist.is_enabled_angellist_connect')) { ?>
        <li class="col-md-1 angellist">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'angellist', 'admin' => false), true); ?>
									<?php echo $this->Html->link(__l('AngelList'), '#', array('title' => 'AngelList', 'escape' => false,'class' => "show js-connect js-no-pjax",'data-url' => $url)); ?>
        </li>
      <?php } ?>
     </ul>
    </div>
  </div>
  <span class="show"><?php echo __l("If you don't want to sign up with a social network,") . ' ' .$this->Html->link(__l('click here') . '.', array('controller' => 'users', 'action' => 'register'), array('title' => __l('Click here'))); ?></span>
</div>