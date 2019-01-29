<?php 
if ($this->request->params['action'] != 'show_header') { ?>
	<!--<div id="js-head-menu" class="hide">-->
	<div id="js-head-menu" class="mobile-scroll">
<?php } ?>
<div class="row">
	<div class="collapse navbar-collapse">
		<div class="col-sm-7 col-md-7 col-lg-6  col-lg-06 nav">
			<ul class="nav navbar-nav hidden-sm visble-lg">
				<?php if (isPluginEnabled('Projects')): ?>
				<?php $class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'discover' ||  (!empty($this->request->params['named']['project_type']) && $this->request->params['named']['project_type']!='donate' && $this->request->params['action'] == 'index' && ((!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'discover') || !empty($this->request->params['named']['filter']) || (!empty($this->request->params['named']['city']) && !isPluginEnabled('Idea')) || !empty($this->request->params['named']['category'])))) ? ' class="fund_support text-center h4 list-group-item-text active"' : ' class="fund_support text-center h4 list-group-item-text"'; ?>
				<li class="fund_support text-center h4 list-group-item-text active">
					<?php echo $this->Html->link('<span class="show">' . __l('Fund') . ' &amp; ' . __l('Support') . '</span>', array('controller' => 'projects', 'action' => 'discover', 'admin' => false), array('title' => __l('Fund') . ' &amp; ' . __l('Support'),'escape' => false));?>
				</li>
				<?php
				$url = $this->Html->onProjectAddFormLoad();
				$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
				?>
				<?php if (!empty($url)): ?>
				<?php $class = ($this->request->params['controller'] == 'projects' && ($this->request->params['action'] == 'start' || $this->request->params['action'] == 'add')) ? ' class="start-project text-center h4 list-group-item-text active"' : ' class="start-project text-center h4 list-group-item-text"'; ?>
				<li class="start-project text-center h4 list-group-item-text">
					<?php echo $this->Html->link('<span class="show">' .$link_text. '</span>', $url, array('title' => $link_text,'escape' => false));?>
				</li>
				<?php endif; ?>
				<?php endif; ?>
				<?php $class = ($this->request->params['controller'] == 'nodes' && $this->request->params['action'] == 'view' && $this->request->params['named']['slug'] == 'how-it-works' || $this->request->params['action'] == 'how_it_works') ? ' class="how_it_works text-center h4 list-group-item-text active"' : ' class="how_it_works text-center h4 list-group-item-text"'; ?>
				<li class="how_it_works text-center h4 list-group-item-text">
					<?php echo $this->Html->link('<span class="show">' . __l('How it Works') . '?</span>', array('controller' => 'nodes', 'action' => 'how_it_works', 'admin' => false), array('title' => __l('How it Works').'?','escape' => false));?>
				</li>
			</ul>
			<ul class="list-inline clearfix h4  text-center visble-sm hidden-lg">
				<?php if (isPluginEnabled('Projects')): ?>
				<?php $class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'discover' ||  (!empty($this->request->params['named']['project_type']) && $this->request->params['named']['project_type']!='donate' && $this->request->params['action'] == 'index' && ((!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'discover') || !empty($this->request->params['named']['filter']) || (!empty($this->request->params['named']['city']) && !isPluginEnabled('Idea')) || !empty($this->request->params['named']['category'])))) ? ' class="list-group-item-text visible-sm col-sm-4 h4 active"' : ' class="list-group-item-text visible-sm col-sm-4 h4"'; ?>
				<li <?php echo $class;?>>
					<?php echo $this->Html->link('<span class="show">' . __l('Fund') . ' &amp; ' . __l('Support') . '</span>', array('controller' => 'projects', 'action' => 'discover', 'admin' => false), array('title' => __l('Fund') . ' &amp; ' . __l('Support'), 'class' => 'h6', 'escape' => false));?>
				</li>
				<?php
					$url = $this->Html->onProjectAddFormLoad();
					$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
				?>
				<?php if (!empty($url)): ?>
				<?php $class = ($this->request->params['controller'] == 'projects' && ($this->request->params['action'] == 'start' || $this->request->params['action'] == 'add')) ? ' class="list-group-item-text visible-sm col-sm-4 h4 active"' : ' class="list-group-item-text visible-sm col-sm-4 h4"'; ?>
				<li <?php echo $class;?>>
					<?php echo $this->Html->link('<span class="show">' .$link_text. '</span>', $url, array('title' => $link_text,'class' => 'h6', 'escape' => false));?>
				</li>
				<?php endif; ?>
				<?php endif; ?>
				<?php $class = ($this->request->params['controller'] == 'nodes' && $this->request->params['action'] == 'view' && $this->request->params['named']['slug'] == 'how-it-works' || $this->request->params['action'] == 'how_it_works') ? ' class="list-group-item-text visible-sm col-sm-4 h4 active"' : ' class="list-group-item-text visible-sm col-sm-4 h4"'; ?>
				<li <?php echo $class;?>>
					<?php echo $this->Html->link('<span class="show">' . __l('How it Works') . '?</span>', array('controller' => 'nodes', 'action' => 'how_it_works', 'admin' => false), array('title' => __l('How it Works') .'?','class' => 'h6', 'escape' => false));?>
				</li>
			</ul>
		</div>
		<!-- form start -->
		<div class="col-sm-2 col-md-2 col-lg-3 col-sm-02 list-group-item-text nav-form">
			<div class="text-center search-icon">
				<a href="#" title="search-icon" class="btn btn-info visible-sm hidden">
					<i class="fa fa-search"></i>
				</a>
				<?php echo $this->Form->create('Project', array('inputDefaults' => array('label' => false,'div' => false), 'id' => 'ProjectSearchForm', 'url' => array('controller' => 'projects', 'action' => 'index','admin'=>false))); ?>
					<div class="h3 clearfix media">
						<span class="pull-left text-muted">
							<i class="fa fa-search navbar-btn text-muted"></i>
						</span>
						<span class="media-body nav">
						<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search Projects'), 'type' => 'search', 'class' => 'form-control')); ?>
						</span>
					</div>
					<div class="submit hide"><?php echo $this->Form->submit(); ?></div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		<!-- form end -->
		<div class="col-sm-3 col-md-3 col-lg-3 col-sm-03">
			<?php //if($this->Auth->sessionValid() && $this->request->params['action'] == 'show_header'): ?>
			<?php if($this->Auth->sessionValid()): ?>
			<ul class="list-inline h4 list-group-item-heading clearfix text-center row last-block">
			<?php $activiy_url = Router::url(array(
				'controller' => 'messages',
				'action' => 'activities',
				'type' => 'notification'
				), true); ?>
				<li class="col-sm-2 h5 list-group-item-text header-notification navbar-btn">
					 <div class="dropdown">
						<?php $notification = $this->Html->getUserNotification($this->Auth->user('id')); ?>
						<a href="<?php echo $activiy_url; ?>" class="dropdown-toggle text-muted js-notification js-no-pjax  {final_id:<?php echo $notification['final_id']; ?>}" data-final_id="<?php echo $notification['final_id'];?>" data-target="#" data-toggle="dropdown" data-hover="dropdown" >
							<sub class="badge navbar-right js-notification-count"><?php echo $notification['notificationCount'];?></sub><i class="fa fa-bell-o navbar-left fa-lg well-sm"></i>
						</a>
						<ul class="dropdown-menu js-notification-list dl pull-right clearfix">
							<li>
								<div class="text-center">
									<?php echo $this->Html->image('ajax-follow-loader.gif', array('alt' => __l('[Image: Loader]') ,'width' => 16, 'height' => 11)); ?>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="col-sm-2 h5 list-group-item-text navbar-btn">
					<?php echo $this->Html->link('<sub class="badge navbar-right badges">'.$this->Html->getUserUnReadMessages($this->Auth->user('id')) .'</sub><i class="fa fa-envelope-o navbar-left fa-lg well-sm"></i>', array('controller' => 'messages', 'action' => 'index', 'admin' => false), array('title' => __l('Inbox'), 'label' => false, 'escape' => false, 'class' => 'text-muted'));?>
				</li>
				<li class="dropdown h5 list-group-item-text navbar-btn user-header-img">
					<a class="dropdown-toggle js-no-pjax"  data-toggle="dropdown" href="#">
					<?php
					if (!empty($logged_in_user['User'])) {
					echo $this->Html->getUserAvatar($logged_in_user['User'], 'micro_thumb', 0, '', 'layout');
					}
					?>
					</a>
					<ul class="dropdown-menu text-left">
					<li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard'))); ?></li>
					<li><?php echo $this->Html->link(__l('Settings'), array('controller' => 'user_profiles', 'action' => 'edit', 'admin' => false), array('title' => __l('Settings')));?></li>
					<?php if(isPluginEnabled('SocialMarketing')):?>
					<li><?php echo $this->Html->link(__l('Find Friends'), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => 'facebook'), array('title' => __l('Find Friends'))); ?></li>
					<?php endif;?>
					<?php if(isPluginEnabled('LaunchModes') && Configure::read('site.launch_mode') == "Private Beta"):?>
					<li><?php echo $this->Html->link(__l('Invite Friends'), array('controller' => 'subscriptions', 'action' => 'invite_friends'), array('title' => __l('Invite Friends'))); ?></li>
					<?php endif;?>
					<li class="divider"></li>
					<li><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'js-no-pjax', 'title' => __l('Logout')));?></li>
					</ul>
				</li>
				<li class="dropdown search-en">
					<a href="#" class="btn btn-default btn-sm dropdown-toggle js-no-pjax" data-toggle="dropdown" title="<?php echo __l('Advanced Search');?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="hide"><?php echo __l('Settings');?></span> <span class="caret"></span></a>
					<ul class="list-unstyled dropdown-menu text-left clearfix">
						<li><?php echo $this->Html->link(__l('Browse All'), array('controller' => 'projects', 'action' => 'discover', 'admin'=>false), array('title' => __l('Browse All')));?></li>
						<li><?php echo $this->Html->link(__l('Cities'), array('controller' => 'cities', 'action' => 'index', 'admin' => false), array('title' => __l('Cities')));?></li>
					</ul>
				</li>
				<?php
				$languages = $this->Html->getLanguage();
				if (Configure::read('user.is_allow_user_to_switch_language') && !empty($languages) && count($languages)>1 ):
				?>
				<li class="h5 list-group-item-text en-es dropdown search-en">
						<a class="btn btn-default btn-sm dropdown-toggle js-no-pjax" data-toggle="dropdown" href="#"> <span><?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?><i class="caret"></i></span></a>
						<ul class="dropdown-menu text-left">
							<?php foreach($languages as $language_id => $language_name) { ?>
							<li><?php  echo $this->Html->link($language_name, '#', array('title' => $language_name, 'class'=>"js-lang-change" , 'data-lang_id' => $language_id));?></li>
							<?php } ?>
						</ul>
				</li>
				<?php
					endif;
				?>
			</ul>
			<?php else : ?>
			<ul class="list-inline h4 list-group-item-heading clearfix text-center row last-block-none hide" id="js-before-login-head-menu">
				<li class="h4">
				  <?php echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Register'), 'class' => 'btn btn-success text-uppercase btn-sm js-no-pjax'));?>
				</li>
				<li class="h4">
				  <?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login', 'admin' => false), array('title' => __l('Login'), 'class' => 'btn btn-default text-uppercase btn-grey btn-sm js-no-pjax'));?>
				</li>
				<li class="h4 dropdown tab-clr">
					<a href="#" class="btn btn-default btn-sm dropdown-toggle js-no-pjax" data-toggle="dropdown" title="<?php echo __l('Advanced Search');?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="hide"><?php echo __l('Settings');?></span> <span class="caret"></span></a>
					<ul class="list-unstyled dropdown-menu text-left clearfix">
						<li><?php echo $this->Html->link(__l('Browse All'), array('controller' => 'projects', 'action' => 'discover', 'admin'=>false), array('title' => __l('Browse All')));?></li>
						<li><?php echo $this->Html->link(__l('Cities'), array('controller' => 'cities', 'action' => 'index', 'admin' => false), array('title' => __l('Cities')));?></li>
					</ul>
				</li>
				<li class="h4 en-es dropdown">
					<?php
						$languages = $this->Html->getLanguage();
						//if (Configure::read('user.is_allow_user_to_switch_language') && !empty($languages) && count($languages)>1 ):
						?>
						<a class="btn btn-default btn-sm lang-flg dropdown-toggle js-no-pjax" data-toggle="dropdown" href="#"> <span><?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?><i class="caret"></i></span></a>
						<ul class="dropdown-menu text-left">
							<?php foreach($languages as $language_id => $language_name) { ?>
							<li><?php  echo $this->Html->link($language_name, '#', array('title' => $language_name, 'class'=>"js-lang-change" , 'data-lang_id' => $language_id));?></li>
							<?php } ?>
						</ul>
						<?php
						//endif;
					?>
				</li>
			</ul>
			<?php endif; ?>
		</div>
</div>
<?php
	if ($this->request->params['action'] != 'show_header') {
		$script_url = Router::url(array(
			'controller' => 'users',
			'action' => 'show_header',
			'ext' => 'js',
			'admin' => false
		) , true) . '?u=' . $this->Auth->user('id');
		$js_inline = "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $script_url . "\";";
		$js_inline .= "var s = document.getElementById('js-head-menu'); s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
?>
<script type="text/javascript">
//<![CDATA[
function getCookie (c_name) {var c_value = document.cookie;var c_start = c_value.indexOf(" " + c_name + "=");if (c_start == -1) {c_start = c_value.indexOf(c_name + "=");}if (c_start == -1) {c_value = null;} else {c_start = c_value.indexOf("=", c_start) + 1;var c_end = c_value.indexOf(";", c_start);if (c_end == -1) {c_end = c_value.length;}c_value = unescape(c_value.substring(c_start,c_end));}return c_value;}if (getCookie('_gz')) {<?php echo $this->Html->cText($js_inline, false); ?>} else {document.getElementById('js-head-menu').className = '';document.getElementById('js-before-login-head-menu').className = 'list-inline h4 list-group-item-heading clearfix text-center row last-block-none';}
//]]>
</script>
<?php
	}
?>
</div>
<?php if ($this->request->params['action'] != 'show_header') { ?>
</div>
<?php } ?>