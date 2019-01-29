<?php
  if ($this->request->params['isAjax']) {
    $js_skip_btn = 'js-skip-btn js-no-pjax';
    $class = 'js-social-load social_marketings-publish';
    $span_class = '';
  } else {
    $js_skip_btn = '';
    $class = 'container gray-bg js-social-load social_marketings-publish';
    $span_class = 'col-md-2';
  }
?>
<div class="<?php echo $class; ?>">
    <div class="clearfix"><h3 class="well"><?php echo $this->Html->cText($this->pageTitle, false); ?></h3></div>
    <?php if ($this->request->params['named']['type'] != 'import') { ?>

      <div class="row <?php echo $project['ProjectType']['slug']; ?>">
        <div class="col-sm-10">
          <div class="col-sm-2"><span class="label label-primary share-follow <?php echo ($this->request->params['named']['type'] == 'facebook')? 'badge-module' : ''; ?>"><?php echo __l('Facebook'); ?></span></div>
          <div class="col-sm-2"><span class="label label-info share-follow <?php echo ($this->request->params['named']['type'] == 'twitter')? 'badge-module' : ''; ?>"><?php echo __l('Twitter'); ?></span></div>
          <div class="col-sm-2"><span class="label label-danger share-follow <?php echo ($this->request->params['named']['type'] == 'others')? 'badge-module' : ''; ?>"><?php echo __l('Others'); ?></span></div>
        </div>
      </div>
    <?php } ?>
    <div class="clearfix marg-top-30">
      <div class="<?php echo ($this->request->params['named']['type'] != 'others') ? 'col-md-6' : ''; ?>">
        <div class="hide"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Throbber]') ,'width' => 25, 'height' => 25)); ?><img width="220" height="165" src="<?php echo $this->Html->cText($project_image, false); ?>"/></div>
        <?php if ($this->request->params['named']['type'] == 'facebook') { ?>
          <?php
            $redirect_url = Router::url(array(
              'controller' => 'social_marketings',
              'action' => 'publish',
              $id,
              'type' => $next_action,
              'publish_action' => $this->request->params['named']['publish_action']
            ), true);
            $connect_url = Router::url(array(
              'controller' => 'social_marketings',
              'action' => 'import_friends',
              'type' => 'facebook',
              'import' => 'facebook',
              'from' => 'publish',
            ), true);
            $fb_connect = false;
            if (!empty($logged_in_user['User']['is_facebook_connected']) || !empty($logged_in_user['User']['is_facebook_register'])) {
              $fb_connect = true;
            }
			if(!empty($project['Project']['short_description'])){
				$description = $project['Project']['short_description'];
			} else {
				$description = $project['Project']['description'];
			}
          ?>
          <div class="loader" id="js-loader" data-fb_connect="<?php echo $fb_connect; ?>" data-fb_app_id="<?php echo Configure::read('facebook.app_id'); ?>" data-project_url="<?php echo $project_url; ?>" data-project_image="<?php echo $project_image; ?>" data-project_name="<?php echo urlencode($this->Html->cText($project['Project']['name'], false)); ?>" data-caption="<?php echo urlencode($this->Html->cText($project['Project']['information'], false)); ?>" data-description="<?php echo urlencode($this->Html->cText($description, false)); ?>" data-redirect_url="<?php echo $redirect_url; ?>" data-type="iframe">
            <!-- data-type="popup" -> set that popup to load share other than loaded to iframe -->
            <span id="js-FB-Share-description" class="hide"><?php echo $this->Html->cText($description, false); ?></span>
            <span id="js-FB-Share-title"  class="hide"><?php echo $this->Html->cText($project['Project']['name'], false); ?></span>
			<span id="js-FB-Share-caption"  class="hide"><?php echo $this->Html->cText($project['Project']['information'], false); ?></span>
            <div id="js-FB-Share-iframe" class="hide"></div>
			<div id="fb-root"></div>
            <div id="js-FB-Share-beforelogin" class="hide">
              <div>
                <p class="clearfix"><?php echo $this->Html->link($this->Html->image('facebooklogin.png', array('alt' => __l('Connect with Facebook'))), $connect_url, array('title' => __l('Connect with Facebook'),'class' => "pull-left js-tooltip js-connect js-no-pjax {url:'".$connect_url."'}", 'escape' => false)); ?></p>
                <p> <?php echo __l("Please login to share in facebook");?> </p>
              </div>
              <p id="msg"></p>
            </div>
          </div>
        <?php } else if($this->request->params['named']['type'] == 'twitter') { ?>
        <?php
			$replace_content = array(
			'##PROJECT_NAME##' => $this->Html->cText($project['Project']['name'], false)
			);
			$default_content = strtr(Configure::read('share.twitter'), $replace_content);
		?>
		<div id="js-twitter">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $project_url; ?>" data-text="<?php echo $default_content;?>" data-count="none" data-size="large">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
        <?php } else if($this->request->params['named']['type'] == 'others') { ?>
          <div class="clearfix"id="js-others">
            <ul class="list-inline col-md-10 other-social clearfix">
              <li class="col-md-3">
					<div>
						<a href="https://www.linkedin.com/cws/share?url=<?php echo $project_url;?>" class="twitter-share-button" target="_blank media">
							<div class="pull-left right-mspace btn btn-info"><i class="fa fa-linkedin fa-lg"></i></div>
							<div class="media-body"><?php echo sprintf(__l('Share about this %s on LinkedIn'), Configure::read('project.alt_name_for_project_singular_small'));?></div>
						</a>
					</div>
				</li>
				<li class="col-md-3">
					<div>
						<a href="https://plus.google.com/share?url=<?php echo $project_url;?>" onclick="javascript:window.open(this.href,  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="media">
						<div class="pull-left right-mspace btn btn-primary"><i class="fa fa-google-plus fa-lg"></i></div>
						<div class="media-body"><?php echo sprintf(__l('Share about this %s on '), Configure::read('project.alt_name_for_project_singular_small')) .'Google+'; ?></div>
						</a>
					</div>
				</li>
				<li class="col-md-3">
					<div>
						<a href="http://pinterest.com/pin/create/button/?url=<?php echo $project_url;?>&media=<?php if(!empty( $project_image)) echo $this->Html->cText($project_image, false) ; ?>&description=<?php echo $this->Html->cText($project['Project']['information'], false); ?>" target="_blank" class="media">
						<div class="pull-left right-mspace btn btn-danger"><i class="fa fa-pinterest fa-lg"></i></div>
						<div class="media-body"><?php echo sprintf(__l('Share about this %s on Pinterest'), Configure::read('project.alt_name_for_project_singular_small'));?></div>
						</a>
					</div>
				</li>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
	<div class="clearfix">
    <div class="clearfix form-actions text-right col-md-10 js-skip-show hide">
      <?php
        if ($this->request->params['named']['type'] == 'others') {
          echo $this->Html->link('Done', array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), array('title' => 'Done','class' => 'pull-right js-no-pjax js-tooltip btn btn-info'));
        } else {
          echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'social_marketings', 'action' => 'publish', !empty($id) ? $id : '', 'type' => $next_action, 'publish_action' => $this->request->params['named']['publish_action']), array('title' => __l('Skip'), 'class' => 'pull-right js-tooltip ' . $js_skip_btn));
        }
      ?>
    </div>
	</div>
</div>