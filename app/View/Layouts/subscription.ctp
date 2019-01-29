<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <?php echo $this->Html->charset(), "\n";?>
    <title><?php echo $this->Html->cText(Configure::read('site.name'), false) . ' | ' . $this->Html->cText($title_for_layout, false); ?></title>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
    <![endif]-->
    <?php
      echo $this->Html->meta('icon'), "\n";
      if (!empty($meta_for_layout['keywords'])):
        echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
      endif;
      if (!empty($meta_for_layout['description'])):
        echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
      endif;
    ?>
    <link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]--> 
    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
    <?php
      echo $this->Html->css('maintenance.cache.'.Configure::read('site.version'), null, array('inline' => true));
	  $cms = $this->Layout->js();
	  $js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
	  $js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
      echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
      echo $this->Javascript->link('default.cache.'.Configure::read('site.version'), array('inline' => true));
      // For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
      if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
        echo '<!--', "\n";
      endif;
    ?>
    <meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="og:app_id" />
    <meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="fb:app_id" />
    <meta property="og:image" content="<?php echo Router::url('/', true) . 'img/crowdfunding.png';?>"/>
    <?php
      if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
        echo '-->', "\n";
      endif;
    ?>
    <?php
      echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
      $response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this, array(
      'data' => $this->request->data
      ));
      echo !empty($response->data['content'])?$response->data['content']:'';
      echo $scripts_for_layout;
    ?>
  </head>
  <body class="private-beta">
    <div id="<?php echo $this->Html->getUniquePageId();?>" class="content js-responses">
      <?php
        $bg_image = $this->Html->getBgImage();
		if(!empty($bg_image)) {
			$original_image = $this->Html->url(getImageUrl('Setting', $bg_image['Attachment'], array('dimension' => 'original')));
			$big_thumb_image = $this->Html->url(getImageUrl('Setting', $bg_image['Attachment'], array('dimension' => 'big_thumb')));
			$prelaunch_stretch_type = Configure::read('StretchType.'.Configure::read('pre_launch.bg_image_stretch_type'));
		  ?>
		  <div id="<?php echo $this->Html->cText($prelaunch_stretch_type, false);?>" style="background:url('<?php echo $original_image; ?>') repeat left top;">
			<img id="bg-image" alt="[Image: Site Background]" title="Site Background" src="<?php echo $big_thumb_image; ?>" class="{highResImage:'<?php echo $original_image; ?>'}" />
		  </div>
	  <?php } ?>
      <div class="beta-block">
        <div class="text-center thumb-alpha private-beta-block">
			<?php echo $this->Html->link($this->Html->image('logo.png', array('alt' => Configure::read('site.name'))),  Router::url('/', true) ,array('title' => Configure::read('site.name'),'escape' => false, 'class'=>"logo"));?>
			
			<?php if (Configure::read('site.launch_mode') == 'Pre-launch'): ?>
            <h1 class="text-uppercase"><?php echo __l('Launching soon!');?></h1>
			<h3><?php echo __l('Stay tuned, we are launching very soon...') ;?></h3>
            <p><?php echo Configure::read('site.pre_launch_content'); ?></p>
            <?php elseif(Configure::read('site.launch_mode') == 'Private Beta'):?>
			<h1 class="text-uppercase"><?php echo __l("We're in private beta");?></h1>
			<h3><?php echo __l('Our beta version, send your detail soon...') ;?></h3>
            <p><?php echo Configure::read('site.private_beta_content'); ?></p>
            
          <?php else:?>
            <h3 class="were"><?php echo __l('Subscribe');?></h3>
          <?php endif;?>
		  <?php
		  	$id = '';
			if (CakeSession::check('Message.error')) {
				$id = 'id="errorMessage"';
			}
		  ?>
		  <p <?php echo $id; ?>>
		  <?php
			if (CakeSession::check('Message.error')) {
				$flash = CakeSession::read('Message.error');
				$message = $flash['message'];
				echo $this->Html->cText($message, false);
				CakeSession::delete('Message.error');
				setcookie('_flash',  '', time() - 3600, '/');
			}
		  ?>
		  </p>
          <?php
            echo $content_for_layout;
            $image_url = APP . 'webroot' . DS . 'img' .DS .  'crowdfunding.png';
            $project_url = Router::url('/', true);
            $project_title = Configure::read('site.name');
            if(Configure::read('site.launch_mode') == 'Private Beta'):
          ?>
              
              <ul class="list-inline follow-block text-center follow js-share">
				<li class="roboto-light"><?php echo __l("Like and follow us to get priority access");?></li>
                <li><a href="http://twitter.com/share" class="socialite twitter-share" data-text="<?php echo $this->Html->cText($project_title, false); ?>" data-url="<?php echo $project_url; ?>" data-count="none" data-via="<?php echo Configure::read('twitter.username'); ?>" rel="nofollow" target="_blank"><span class="vhidden"><?php  echo $this->Html->image('social-twitter.png'); ?></span></a></li>
                <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $project_url; ?>&amp;t=<?php echo $this->Html->cText($project_title, false); ?>" class="socialite facebook-like" data-href="<?php echo $project_url; ?>" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"><span class="vhidden"><?php  echo $this->Html->image('social-fb.png'); ?></span></a></li>
              </ul>
          <?php
             else:
          ?>
              <div class="clearfix marg-btom-30 marg-top-30">
                <div class="text-center navbar-btn marg-btom-20 text-14"><?php echo __l("Help us out. Spread the world!");?></div>
                <ul class="list-inline text-center follow-block follow js-share">
                  <li><a href="http://twitter.com/share" class="socialite twitter-share" data-text="<?php echo $this->Html->cText($project_title, false); ?>" data-url="<?php echo $project_url; ?>" data-count="none" data-via="<?php echo Configure::read('twitter.username'); ?>" rel="nofollow" target="_blank"><span class="vhidden"><?php  echo $this->Html->image('social-twitter.png'); ?></span></a></li>
                  <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $project_url; ?>&amp;t=<?php echo $this->Html->cText($project_title, false); ?>" class="socialite facebook-like" data-href="<?php echo $project_url; ?>" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"><span class="vhidden"><?php  echo $this->Html->image('social-fb.png'); ?></span></a></li>
                </ul>
              </div>
          <?php endif; ?>
          <?php
            if (!$this->Auth->sessionValid()and Configure::read('site.launch_mode')== 'Private Beta'):?>
              <div class="btn-block text-center">
                  <?php if(($this->request->params['controller'] == 'users' and $this->request->params['action'] == 'register') || (Configure::read('site.launch_mode')== 'Private Beta'and $this->request->params['action'] != 'add')){
                  ?>
				  <?php echo $this->Html->link(__l('Request Invite'), '#', array('title' => __l('Request Invite'), 'class' => 'js-no-pjax js-request_invite btn btn-warning'));
                    };?>
                  <?php echo $this->Html->link(__l('Beta users login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'), 'class' => 'btn btn-default')); ?>
              </div>
          <?php endif;?>
			<div id="agriya" class="clearfix roboto-light footer-block">
				<p>&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'class' => 'site-name',  'escape' => false)) .  '. ' . 'All rights reserved' . '.';?></p>
				<p class="powered clearfix"><?php echo $this->Html->link('Powered by ' . Configure::read('site.name'), Router::Url('/',true), array('title' => 'Powered by ' . Configure::read('site.name'), 'class' => 'powered', 'escape' => false)); ?><span class="made-in">, <?php echo  'made in';?></span> <a class="company" title="Agriya Web Development" target="_blank" href="http://www.agriya.com/"><?php echo 'Agriya Web Development'; ?></a> <span><?php echo Configure::read('site.version');?></span></p>
				<p id="cssilize"><a href="http://www.cssilize.com/" title="CSSilized by CSSilize, PSD to XHTML Conversion" target="_blank"><?php echo 'CSSilized by CSSilize, PSD to XHTML Conversion'; ?></a></p>
			</div>
        </div>
      </div>
     
    </div>
  </body>
</html>