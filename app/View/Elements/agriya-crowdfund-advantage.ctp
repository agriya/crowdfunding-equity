<div id="advantage" class="<?php echo empty($this->request->url) ? 'show' : 'hide'; ?>">
	<section class="h1 crowdfund-sec">
		<div class="container" itemscope itemtype="http://schema.org/WPHeader">
			<div class="col-xs-12">
				<h3 class="h2 text-center list-group-item-text" itemprop="headline">
					<strong><?php  echo sprintf(__l('%s Advantage'), Configure::read('site.name'));?></strong>
				</h3>
				<div class="col-sm-6 h3 row">
				<?php echo $this->Html->image('crowdfunding-advantage.png', array('alt' => "[Image: Crowdfunding-advantage]", 'title'=>'Crowdfunding-advantage', 'class'=>'img-responsive h1')); ?>	                   	
                </div>
				<div class="col-sm-6 h3" itemscope itemtype="http://schema.org/Offer">
					<ul class="fa-ul h3">
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Made in ISO 9001-2008 certified and NASSCOM<sup>&reg;</sup> listed company');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo sprintf(__l('First and complete %s software'), Configure::read('site.name'));?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Has many revenue options (Signup fee, Project listing fee, Commission on pledge, Affiliate, Ads)');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Multilingual support');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('US\'s JOBS Act (Jumpstart Our Business Startups Act) compliant equity mod');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('UK\'s SEIS (Seed Enterprise Investment Scheme) compliant equity mod');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('With MVC and plugin based architecture');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Growth hacking plugin for improving user growth');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('High performance and cloud ready');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Mobile friendly');?>
						</li>
						<li class="h3" itemprop="addOn">
							<span class="navbar-btn small">
								<i class="fa fa-chevron-right fa-li text-muted navbar-btn"></i>
							</span> 
							<?php echo __l('Streamlined workflow and hence no maintenance headaches');?>
						</li>
						<li>
							<a itemprop="itemOffered" href="http://www.agriya.com/contact" target="_blank" class="btn btn-danger btn-lg" title="<?php echo __l('Contact Agriya');?>"><?php echo __l('Contact Agriya');?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<hr>
	</section>
	<section class="h1  crwd-sol-sec">
		<div class="container">
			<h3 class="h2">
				<span class="show"><strong>Agriya<sup>&reg;</sup> <?php echo __l('Solutions');?></strong></span>
			</h3>
			<p class="h3 navbar-btn"><?php echo __l('Incase if you don\'t know... for years, Agriya<sup>&reg;</sup> doesn\'t just sell products, but offers multiple solutions and services.');?> </p>
			<div class="col-xs-12 h3">
				<div class="col-sm-2  img-circle h1 col-xs-12">
					<a href="#" title="Micro-solutions" class="rot-crcl">
					<?php echo $this->Html->image('micro-solutions.png', array('alt' => "[Image: Micro-solutions]", 'title'=>'Micro-solutions', 'class'=>'img-circle center-block img-responsive h1')); ?>	  						
					</a>
				</div>
				<div class="col-sm-10 navbar-btn col-xs-12">
					<h3 class="h3"><strong><?php echo __l('Micro entrepreneur Solutions');?></strong></h3>
					<p><?php echo __l('Passionate micro entrepreneurs prefer mentors and startup accelerators. Sadly, an accelerator like Y Combinator has mere 3% acceptance rate. Agriya<sup>&reg;</sup> provides all related solutions and consultations.');?></p>
					<div class="row navbar-btn">
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Expert consultation');?></li>
								<li class="h4"><?php echo __l('Ideation');?></li>
								<li class="h4"><?php echo __l('Pivoting consultation');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('MVP');?></li>
								<li class="h4"><?php echo __l('Marketing strategy');?></li>
								<li class="h4"><span><?php echo __l('Hosting consultation');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Server management');?></li>
								<li class="h4"><?php echo __l('Leads to likeminded startupers');?></li>
								<li class="h4"><?php echo __l('PR (Public Relation)');?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="col-sm-2  img-circle h1 col-xs-12">
					<a href="#" title="Sme-solutions" class="rot-crcl">
					<?php echo $this->Html->image('sme-solutions.png', array('alt' => "[Image: sme-solutions]", 'title'=>'sme-solutions', 'class'=>'img-circle center-block img-responsive h1')); ?>						
					</a>
				</div>
				<div class="col-sm-10 h1 col-xs-12 text-cnter">
					<h3 class="h3"><strong><?php echo __l('SME Solutions');?></strong></h3>
					<div class="row navbar-btn">
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Search Engine Optimization (SEO)');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Social media marketing');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Server management');?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 h1">
				<div class="col-sm-2  img-circle h3 col-xs-12">
					<a href="#" title="Enterprise" class="rot-crcl">
						<?php echo $this->Html->image('enterprise.png', array('alt' => "[Image: Enterprise]", 'title'=>'Enterprise', 'class'=>'img-circle center-block img-responsive h1')); ?>
					</a>
				</div>
				<div class="col-sm-10 navbar-btn col-xs-12">
					<h3 class="h3"><strong><?php echo __l('Enterprise Solutions');?></strong></h3>
					<div class="row navbar-btn">
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Big data');?></li>
								<li class="h4"><?php echo __l('Machine Learning (ML)');?></li>
								<li class="h4"><?php echo __l('Artificial Intelligence (AI)');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Recommendation Engine');?></li>
								<li class="h4"><?php echo __l('Data Analytics');?></li>
								<li class="h4"><?php echo __l('Hadoop, Mahout');?></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<ul class="list-unstyled">
								<li class="h4"><?php echo __l('Business Process Outsourcing (BPO)');?></li>
								<li class="h4"><?php echo __l('Payment processing');?></li>
								<li class="h4"><?php echo __l('Financial solutions');?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
	</section>
<?php if (Configure::read('widget.footer_script')) { ?>
	<section class="h3">
		<div class="container">
			<div class="h4 well-sm footer-baner">
				<?php echo Configure::read('widget.footer_script'); ?>
			</div>
		</div>
	</section>
<?php } ?>
<!-- GET-STARTED SECTION: START -->
<?php 
	if (isPluginEnabled('Projects')): 
		$url = $this->Html->onProjectAddFormLoad();
		$link_text = sprintf(__l('Start %s'), Configure::read('project.alt_name_for_project_singular_caps'));
?>
<section class="h3 list-group-item-text get-start-block">
	<div class="bg-danger bg-primary">    
		<div class="container">
			<div class="well-lg clearfix navbar-btn list-group-item-heading">
				<div class="text-center">                   
					<h3 class="h1 list-group-item-text"><strong><?php echo __l('Get started today'); ?></strong></h3>
					<p class="h3 navbar-btn"><?php echo sprintf(__l('Discover new %s campaigns or start your own campaign to raise funds.'), Configure::read('site.name')); ?></p>
					<div class="col-xs-12">
						<ul class="list-inline navbar-btn">
							<li>
								<?php echo $this->Html->link('<span class="h4"><strong>'. __l('Explore Projects') .'</strong></span><span class="bdr-eft"></span>', array('controller' => 'projects', 'action' => 'discover', 'admin' => false), array('title' => __l('Explore Projects'), 'class' => 'btn btn-default btn-lg text-uppercase fa-inverse navbar-btn  btn-proj js-no-pjax', 'escape' => false));?>
							</li>
							<?php if (!empty($url)): ?>
							<li>
								<?php echo $this->Html->link('<span class="h4"><strong>'. __l('Start a Project') .'</strong></span><span class="bdr-eft"></span>', $url, array('title' => $link_text, 'class' => 'btn btn-default btn-lg text-uppercase fa-inverse navbar-btn btn-grey  btn-proj js-no-pjax', 'escape' => false));?>
							</li>
							<?php endif; ?>
						</ul>
					</div>
				</div> 
			</div>
		</div>       
	</div>
</section>
<?php endif; ?>
<!-- GET-STARTED SECTION: END -->
</div>
