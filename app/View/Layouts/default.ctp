<!DOCTYPE html>
<html lang="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtolower($_COOKIE['CakeCookie']['user_language']) : strtolower(Configure::read('site.language')); ?>">
	<head>
		<?php echo $this->Html->charset(), "\n";?>
		<title><?php echo $this->Html->cText(Configure::read('site.name'), false) . ' | ' . $this->Html->cText($title_for_layout, false); ?></title>
		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
		<![endif]-->
		<?php
		echo $this->Html->meta('icon'), "\n";
		?>
		<?php
		if (!empty($meta_for_layout['keywords'])):
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		endif;
		?>
		<?php
		if (!empty($meta_for_layout['description'])):
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		endif;
		?>
		<?php if (!empty($this->theme)) { ?>
			<link rel="apple-touch-icon" href="<?php echo Router::url('/') . 'theme/' . $this->theme; ?>/apple-touch-icon.png">
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/') . 'theme/' . $this->theme; ?>/apple-touch-icon-72x72.png" />
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/') . 'theme/' . $this->theme; ?>/apple-touch-icon-114x114.png" />
		<?php } else { ?>
			<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<![endif]--> 
		<link href="<?php echo Router::url(array('controller' => 'feeds', 'action' => 'index', 'ext' => 'rss', 'admin' => false), true);?>" type="application/rss+xml" rel="alternate" title="RSS Feeds"/>
		<!-- Latest compiled and minified CSS 
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">--> 
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
		<?php echo $this->fetch('seo_paging'); ?>
		<?php echo $this->Html->css('default.cache.'.Configure::read('site.version'), null, array('inline' => true)); ?>
		<?php
		$cms = $this->Layout->js();
		$js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
		$js_inline .= "document.documentElement.className = 'js';";
		$js_inline .= "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $this->Html->assetUrl('default.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
		$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
		echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
		// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false || strpos(env('HTTP_USER_AGENT'), 'LinkedInBot')===false):
			echo '<!--', "\n";
		endif;
		?>
		<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
		<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
		<?php if (!empty($meta_for_layout['title'])) { ?>
			<meta property="og:title" content="<?php echo $this->Html->cText($meta_for_layout['title'], false);?>"/>
		<?php }else if(!empty($meta_for_layout['project_name'])){ ?>
			<meta property="og:title" content="<?php echo $this->Html->cText($meta_for_layout['project_name'], false);?>"/>
		<?php } ?>
		<?php if(!empty($meta_for_layout['project_description'])) { ?>
			<meta property="og:description" content="<?php echo $this->Html->cHtml($meta_for_layout['project_description'], false);?>" />
		<?php } ?>
		<?php if (!empty($meta_for_layout['project_image'])) { ?>
			<meta property="og:image" content="<?php echo $this->Html->cText($meta_for_layout['project_image'], false);?>"/>
		<?php } else { ?>
		<?php if (!empty($this->theme)) { ?>
			<meta property="og:image" content="<?php echo Router::url('/', true) . 'theme/' . $this->theme . '/img/crowdfunding.png';?>"/>
		<?php } else { ?>
			<meta property="og:image" content="<?php echo Router::url('/', true) . 'img/crowdfunding.png';?>"/>
		<?php } ?>
		<?php } ?>
		<?php if(!empty($meta_for_layout['project_url'])) { ?>
			<meta property="og:url" content="<?php echo $this->Html->cText($meta_for_layout['project_url'], false);?>" />
		<?php }?>
			<meta property="og:site_name" content="<?php echo $this->Html->cText(Configure::read('site.name'), false); ?>"/>
		<?php if (Configure::read('facebook.fb_user_id')): ?>
			<meta property="fb:admins" content="<?php echo Configure::read('facebook.fb_user_id'); ?>"/>
		<?php endif; ?>
		<?php
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false || strpos(env('HTTP_USER_AGENT'), 'LinkedInBot')===false):
			echo '-->', "\n";
		endif;
		?>
		<?php
		echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
		$response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
		echo !empty($response->data['content']) ? $response->data['content'] : '';
		?>
		<?php echo $scripts_for_layout; ?>
		<?php
		if (env('HTTP_X_PJAX') != 'true') {
			echo $this->fetch('highperformance');
		}
		?>
		<!--[if IE]><?php echo $this->Javascript->link('libs/excanvas.js', true); ?><![endif]-->
	</head>
	<body itemscope itemtype="http://schema.org/WebPage">
		<div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
			<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
			<header id="header" class="header js-hp-header">
			<?php } else { ?>
			<header id="header" class="header hdr-bdr-btm">
			<?php } ?>
			<?php
			$affix_flag = 'show';
			if (($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'register') || ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'login')) {
			$affix_flag = 'hide';
			}
			?>
			<?php
			if (!$this->Auth->sessionValid()):
			?>
			<!--<div class="js-affix-header navbar-nav affix-content <?php /*echo $affix_flag; ?>" data-spy="affix" data-offset-top="60">
			<div>
			<div class="container clearfix">
			<div class="text-center">
			<span class="fund"><?php echo sprintf(__l('Fund &amp; Support Creative %s.'), Configure::read('project.alt_name_for_project_plural_caps'));?></span>
			<strong>
			<?php
			 echo $this->Html->link(__l('Sign Up'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Sign Up'), 'class' => 'btn btn-success mob-clr', 'data-placement'=>"bottom"));
			?>
			</strong>
			<span class="mob-clr"><?php echo __l('Need Fund? '); ?></span>
			<?php
			$url = $this->Html->onProjectAddFormLoad();
			 $link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
			?>
			<strong><?php echo $this->Html->link($link_text, $url, array('title' => $link_text,'class' => 'btn btn-primary mob-clr', 'escape' => false, 'data-placement'=>"bottom"));*/?></strong>
			</div>
			</div>
			</div>
			</div>-->
			<?php endif; ?>
			<?php
			$fixed_nav = '';
			if ($this->Auth->sessionValid()) {
			$fixed_nav = 'navbar-fixed-top';
			}
			?>
				<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				<div class="alab hide"> <?php //after login admin panel?>
					<div class="login-navbar container-fluid useradminpannel">
						<div class="text-center clearfix navbar-header col-xs-12">
							<div class="navbar-left">
								<h1 class="list-group-item-heading clearfix">
									<strong>
									<?php
									echo $this->Html->link(($this->Html->cText(Configure::read('site.name'), false).' '.'<span class="sfont"><small><strong> Admin</strong></small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'js-no-pjax navbar-brand float-none', 'title' => (Configure::read('site.name').' '.'Admin')));
									?>
									</strong>
								</h1>
							</div>
							<div class="navbar-right mob-clr admin-header-right-menu  navbar-btn">
								<ul class="list-inline navbar-btn">
									<li>
										<?php
										echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax', 'title' => __l('My Account')));
										?>
									</li>
									<li>
										<?php
										echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'js-no-pjax', 'title' => __l('Logout')));
										?>
									</li>
								</ul>
							</div>
							<div class="navbar-btn con-height clearfix">
								<span class="show text-center navbar-btn"><?php echo __l('You are logged in as Admin'); ?></span>
								<div class="alap hide"></div>
							</div>
							<!-- /.nav-collapse -->
						</div>
					</div>
				</div>
				<?php } else { ?>
				<?php if($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin) {?>
				<div class="useradminpannel  container-fluid login-navbar">
					<div class="text-center clearfix navbar-header col-xs-12">
					<div class="navbar-left">
						<h1 class="list-group-item-heading clearfix">
							<strong>
								<?php
								echo $this->Html->link(($this->Html->cText(Configure::read('site.name'), false).' '.'<span class="sfont"><small><strong> Admin</strong></small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'js-no-pjax navbar-brand float-none', 'title' => (Configure::read('site.name').' '.'Admin')));
								?>
							</strong>
						</h1>
						</div>
						<div class="navbar-right mob-clr admin-header-right-menu navbar-btn">
							<ul class="list-inline navbar-btn">
								<li>
									<?php
									echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax', 'title' => __l('My Account')));
									?>
								</li>
								<li>
									<?php
									echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));
									?>
								</li>
							</ul>
						</div>
						<div class="clearfix navbar-btn">
							<span class="show text-center navbar-btn"><?php echo __l('You are logged in as Admin'); ?></span>
							<div class="alap">
								<?php if ($this->request->params['controller']=='projects' && $this->request->params['action']=='view') {
								echo $this->element('admin_panel_project_view', array('controller' => 'projects', 'action' => 'index', 'project' =>$project)); ?>
								<?php } else if ($this->request->params['controller']=='users' && $this->request->params['action']=='view'){
								echo $this->element('admin_panel_user_view');
								}
								?>
							</div>
						</div>
						<!-- /.nav-collapse -->
					</div>
				</div>
				<!-- /navbar-inner -->
				<?php } ?>
				<?php } ?>
				<!-- /navbar-inner -->
				<nav class="navbar navbar-default list-group-item-text navbar-white">
					<div class="container">
						<div class="row">
							<div class="col-sm-2 col-md-2 col-lg-2 col-xs-8 h5 list-group-item-text col-lg-02">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse"> 
										<span class="sr-only">Toggle navigation</span> 
										<span class="icon-bar"></span> 
										<span class="icon-bar"></span> 
										<span class="icon-bar"></span> 
									</button>
									<?php
									if (empty($this->request->params['named']['project_type'])) {
									$this->request->params['named']['project_type'] = '';
									}
									?>
									<h1 class="list-group-item-heading list-group-item-text" itemscope itemtype="http://schema.org/Organization">
									<?php echo $this->Html->link($this->Html->image('crowdfunding.png', array('itemprop' => 'logo', 'class' => ' img-responsive')),  '/', array('title' => Configure::read('site.name'),'escape' => false, 'itemprop' => 'url'));?>
									</h1>
								</div>
							</div>
							<div class="col-xs-4 col-sm-10 col-md-10 col-lg-10 col-lg-010 nav">
								<!--<a data-target=".navbar-collapse" data-toggle="collapse" class="btn navbar-btn"> <i class="fa fa-th-list fa-fw icon-24"></i></a>-->
								<?php echo $this->element('header-menu'); ?>
							</div>
						</div>
					</div>
				</nav>
				 <!--<hr class="hr-2px-gray no-mar">-->
			</header>
			<section id="pjax-body">				
				<main id="main" class="main index-usr-main <?php if(!empty($search_class)) { echo $search_class;}?>">
					<?php echo $this->Layout->sessionFlash(); ?>
					<?php 
					if (env('HTTP_X_PJAX') == 'true') {
					echo $this->fetch('highperformance'); 
					}
					?>
					<section class="<?php echo $this->Html->getUniquePageId();?> clearfix">
						<?php echo $content_for_layout;?>
					</section>
					<?php echo $this->element('agriya-crowdfund-advantage'); ?>
				</main>
			</section>
			<footer id="footer" class="footer">
				<div class="navbar navbar-inverse list-group-item-text navbar-black">
					<div class="container navbar-btn">
						<div class="row">
							<div class="col-sm-7 h3 col-lg-6">
								<div class="col-sm-3 col-md-4 col-lg-4 col-lg-04  prnt">
									<div class="row">
										<h3 class="h4 text-capitalize resp-foo-head click-clps">
                                            	<strong class="fa-inverse"><?php echo __l('exploring'); ?></strong>
												<i class="fa fa-plus pull-right hidden"></i>
                                        </h3>
										<ul class="list-unstyled text-capitalize h3">
											<?php if (isPluginEnabled('Projects')): ?>
											<?php
											$url = $this->Html->onProjectAddFormLoad();
											?>
											<?php if (!empty($url)): ?>
											<li class="h5 clearfix">
												<?php echo $this->Html->link('<span class="show">' . __l('Start Your Projects') . '</span>', $url, array('title' => __l('Start Your Projects'),'class' => 'pull-left fa-inverse text-capitalize','escape' => false));?>
											</li>
											<?php endif; ?>
											<?php endif; ?>
											<?php 
											if(isPluginEnabled('Pledge')) {
											?>
												<li class="h5 clearfix">
													<?php echo $this->Html->link('<span class="show">' . __l(Configure::read('project.alt_name_for_pledge_singular_caps')) . '</span>', array('controller' => 'projects', 'action' => 'discover', 'project_type'=> 'pledge' , 'admin' => false), array('title' => __l('Pledge'),'class' => 'pull-left fa-inverse text-capitalize', 'escape' => false)); ?>
												</li>
											<?php
											}
											?>
											<?php 
											if(isPluginEnabled('Donate')) {
											?>
												<li class="h5 clearfix">
													<?php echo $this->Html->link('<span class="show">' . __l(Configure::read('project.alt_name_for_donate_singular_caps')) . '</span>', array('controller' => 'projects', 'action' => 'discover', 'project_type'=> 'donate' , 'admin' => false), array('title' => __l('Donate'),'class' => 'pull-left fa-inverse text-capitalize', 'escape' => false)); ?>
												</li>
											<?php
											}
											?>
											<?php 
											if(isPluginEnabled('Equity')) {
											?>
												<li class="h5 clearfix">
													<?php echo $this->Html->link('<span class="show">' . __l(Configure::read('project.alt_name_for_equity_singular_caps')) . '</span>', array('controller' => 'projects', 'action' => 'discover', 'project_type'=> 'equity' , 'admin' => false), array('title' => __l('Equity'),'class' => 'pull-left fa-inverse text-capitalize', 'escape' => false)); ?>
												</li>
											<?php
											}
											?>
											<?php 
											if(isPluginEnabled('Lend')) {
											?>
												<li class="h5 clearfix">
													<?php echo $this->Html->link('<span class="show">' . __l(Configure::read('project.alt_name_for_lend_singular_caps')) . '</span>', array('controller' => 'projects', 'action' => 'discover', 'project_type'=> 'lend' , 'admin' => false), array('title' => __l('Lend'),'class' => 'pull-left fa-inverse text-capitalize', 'escape' => false)); ?>
												</li>
											<?php
											}
											?>
										</ul>
										
										
									</div>
								</div>
								<div class="col-sm-6 col-md-5 col-lg-5 col-lg-04  prnt">
									<div class="row">
										<h3 class="h4 text-capitalize click-clps resp-foo-head">
                                        	<strong class="fa-inverse "><?php echo sprintf(__l('about %s'), Configure::read('site.name'));?></strong>
											<i class="fa fa-plus pull-right hidden"></i>
                                        </h3>
										<?php echo $this->Layout->menu('footer2'); ?>
									</div>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3 col-lg-04  prnt">
									<div class="row">
										<h3 class="h4 text-capitalize click-clps resp-foo-head">
											<strong class="fa-inverse"><?php echo __l('help'); ?></strong> 
											<i class="fa fa-plus pull-right hidden"></i>
                                        </h3>
										<?php echo $this->Layout->menu('footer3'); ?>
									</div>
								</div>
							</div>
							<div class="text-center col-lg-6 col-sm-5 navbar-btn col-md-06">
								<div class="navbar-btn row">
									<div class="navbar-btn clearfix">
										<ul class="list-inline navbar-btn">
											<?php
											if (Configure::read('facebook.site_facebook_url')):
											$facebook_url = Configure::read('facebook.site_facebook_url');
											?>
											<li>
												<a href="<?php echo $facebook_url; ?>" title="Facebook" class="text-primary small js-no-pjax show" target="_blank">
													<span class="fa-stack fa-2x">
													<i class="fa fa-circle  fa-stack-2x"></i>
													<small><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></small>
													</span>
												</a>
											</li>
											<?php
											endif;
											if(Configure::read('twitter.username')):
											$twitter_url = 'http://www.twitter.com/'.Configure::read('twitter.username');
											?>
											<li>
												<a href="<?php echo $twitter_url; ?>" title="Twitter" class="text-info small js-no-pjax show" target="_blank">
													<span class="fa-stack fa-2x">
													<i class="fa fa-circle  fa-stack-2x"></i>
													<small><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></small>
													</span>
												</a>
											</li>
											<?php
											endif;
											?>
											<li>
											<?php $rss_url = Router::url(array('controller' => 'feeds', 'action' => 'index', 'ext' => 'rss', 'admin' => false) , true); ?>
												<a href="<?php echo $rss_url; ?>" title="<?php echo __l('RSS feed'); ?>" class="text-danger small">
												<span class="fa-stack fa-2x">
												<i class="fa fa-circle  fa-stack-2x"></i>
												<small><i class="fa fa-rss-square fa-stack-1x fa-inverse"></i></small>
												</span>
												</a>
											</li>											
										</ul>
										<div class="navbar-btn col-xs-12">
											<p class="text-muted h6">&copy;<?php echo date('Y');?><strong><?php echo $this->Html->link($this->Html->cText(Configure::read('site.name'), false), '/', array('title' => Configure::read('site.name'), 'class' => 'text-muted h6', 'escape' => false)) .  '. ' . __l('All rights reserved') . '.';?></strong></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<?php echo $this->element('sql_dump'); ?>
		</div>
	</body>
</html>