<div class="container gray-bg social-marketings">
<div class="page-header"><h2><?php echo $this->pageTitle; ?></h2></div>
<ul class="list-unstyled clearfix">
  <li class="col-sm-10 clearfix no-pad">
    <div class="col-xs-6 col-sm-2 navbar-btn">
		<span class="label label-primary share-follow space-xs show <?php echo ($this->request->params['named']['type'] == 'facebook')? 'label' : ''; ?>"><?php echo __l('Facebook'); ?></span>
	</div>
    <div class="col-xs-6 col-sm-2 navbar-btn">
		<span class="label label-info share-follow space-xs show <?php echo ($this->request->params['named']['type'] == 'twitter') ? 'label-info' : ''; ?>"><?php echo __l('Twitter'); ?></span>
	</div>
    <div class="col-xs-6 col-sm-2 navbar-btn">
		<span class="label label-danger share-follow space-xs show <?php echo ($this->request->params['named']['type'] == 'gmail')? 'label-info' : ''; ?>"><?php echo __l('Gmail'); ?></span>
	</div>
    <div class="col-xs-6 col-sm-2 navbar-btn">
		<span class="label label-success share-follow space-xs show <?php echo ($this->request->params['named']['type'] == 'yahoo')? 'label-info' : ''; ?>"><?php echo __l('Yahoo!'); ?></span>
	</div>
  </li>
  <?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id'));?>
  <li class="col-sm-12 navbar-btn">
    <div class="tab-content" id="myTabContent">
      <?php if ($this->request->params['named']['type'] == 'facebook') { ?>
        <div id="facebook" class="facebook loader fade in active" data-fb_app_id="<?php echo Configure::read('facebook.app_id') ?>">
          <?php
            if (!empty($user['User']['facebook_access_token'])) {
              $replace_content = array(
                '##SITE_NAME##' => Configure::read('site.name'),
                '##REFERRAL_URL##' => Router::url('/', true). 'r:'.$this->Auth->user('username')
              );
              $share_content = strtr(Configure::read('invite.facebook'), $replace_content);
              $feed_url = 'https://www.facebook.com/dialog/apprequests?app_id=' . Configure::read('facebook.app_id') . '&display=iframe&access_token=' . $user['User']['facebook_access_token'] . '&show_error=true&link=' . Router::url('/', true) . '&message=' . $share_content. '&data=' . $this->Auth->user('id') . '&redirect_uri=' . Router::url('/', true) . 'social_marketings/publish_success/invite';
          ?>
			  <div id="js-fb-login-check" class="hide">
              <div class="col-md-8">
                <iframe src="<?php echo $feed_url; ?>" height="500" width="500"  frameborder="0" scrolling="no"></iframe>
              </div>
              <div class="col-md-3">
                <?php echo $this->element('follow-friends', array('type' => 'facebook', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
              </div>
			  </div>
          <?php
            }
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => 'facebook',
                'import' => 'facebook',
              ), true);
          ?>
		  <div id="js-fb-invite-friends-btn" class="hide">
          <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Facebook because you haven't connected with Facebook. Click the button below to connect.")?></div>
          <div class="text-center">
			<?php echo $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-facebook fa-fw js-connect js-no-pjax {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'facebook'), array('class'=>'btn btn-primary','title' => __l('Find Friends From Facebook'),'escape' => false)); ?></div></div>
		 </div>
      <?php } elseif ($this->request->params['named']['type'] == 'twitter') { ?>
        <div id="twitter" class="twitter">
          <?php if (!empty($user['User']['is_twitter_connected'])) { ?>
            <?php
				$replace_content = array(
				"##SITE_NAME##"=> Configure::read('site.name'),
				"##REFERRAL_URL##"=> Router::url('/', true). 'r:'.$this->Auth->user('username')
				);
				$default_content = strtr(Configure::read('invite.twitter'), $replace_content);
			?>
			<div class="col-md-8">&nbsp;
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Router::url('/', true); ?>" data-text="<?php echo $default_content;?>" data-size="large">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
            <div class="col-md-3">
              <?php echo $this->element('follow-friends', array('type' => 'twitter', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
            </div>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => 'twitter',
                'import' => 'twitter',
              ), true);
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Twitter because you haven't connected with Twitter. Click the button below to connect.")?></div>
            <div class="text-center"><?php echo $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-twitter fa-fw js-connect js-no-pjax {"url":"' . $connect_url . '"}')).$this->Html->tag('span','Find Friends From Twitter', array('class'=>'')), $connect_url, array('class'=>'btn btn-info','title' => __l('Find Friends From Twitter'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } elseif ($this->request->params['named']['type'] == 'gmail') { ?>
        <div id="gmail" class="gmail">
          <?php if (!empty($user['User']['is_google_connected'])) { ?>
            <?php  echo $this->element('contacts-index', array('type' => 'gmail')); ?>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => $this->request->params['named']['type'],
                'import' => 'google',
              ), true);
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Gmail because you haven't connected with Gmail. Click the button below to connect.")?></div>
            <div class="text-center">
			<?php echo $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-envelope fa-fw js-connect js-no-pjax {"url":"'.$connect_url.'"}')).$this->Html->tag('span','Find Friends From Gmail', array('class'=>'')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'google'), array('class'=>'btn btn-danger','title' => __l('Find Friends From Gmail'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } elseif ($this->request->params['named']['type'] == 'yahoo') { ?>
        <div id="yahoo" class="yahoo">
          <?php if (!empty($user['User']['is_yahoo_connected'])) { ?>
             <?php  echo $this->element('contacts-index', array('type' => 'yahoo')); ?>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => $this->request->params['named']['type'],
                'import' => 'yahoo',
              ), true);
              $connect_url.= '?r=' . $this->request->url;
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Yahoo! because you haven't connected with Yahoo. Click the button below to connect.")?></div>
            <div class="text-center">
			 <?php echo $this->Html->link($this->Html->tag('i','', array('class'=>'fa fa-yahoo fa-fw js-connect js-no-pjax {"url":"'.$connect_url.'"}')).$this->Html->tag('span','Find Friends From Yahoo', array('class'=>'')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'yahoo'), array('class'=>'btn btn-success','title' => __l('Find Friends From Yahoo'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </li>
  <li class="form-actions navbar-btn clearfix ver-space">
    <?php
      if ($this->request->params['named']['type'] == 'yahoo') {
        echo $this->Html->link(__l('Done'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Done'), 'class' => 'btn btn-info btn-xs pull-right js-tooltip'));
      } else {
        echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'social_marketings', 'action' => 'import_friends',  'type' => $next_action), array('title' => 'Skip', 'class' => 'btn btn-info btn-xs pull-right show float-none js-tooltip'));
      }
    ?>
  </li>
 </ul>
</div>
<div id="fb-root"></div>