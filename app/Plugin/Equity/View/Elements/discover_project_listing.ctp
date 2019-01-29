<?php if(!empty($this->request->params['named']['project_type'])): 
$project_type = Inflector::camelize($this->request->params['named']['project_type']);
?>
<section class="bg-danger clearfix sec-1 bg-equity padd" itemtype="http://schema.org/Product" itemscope>
	<div class="container" itemprop="Name">
		<div class="text-center well-sm h3 clearfix">
			<?php echo $this->Html->image('crowdfunding-equity.png', array('alt' => sprintf(__l('[Image: %s]'), Configure::read('project.alt_name_for_pledge_singular_caps')), 'class' => 'navbar-btn')); ?>
			<?php //echo Configure::read('project.alt_name_for_pledge_singular_caps'); ?>
			<h4 class="lead fa-inverse col-lg-8 col-lg-offset-2 trun" title="<?php echo sprintf(__l("In %s %s, %s buy shares and %s amount is captured by end date/goal reached of the %s."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_investor_singular_small'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>"  itemprop="description">
				<?php echo sprintf(__l("In %s %s, %s buy shares and %s amount is captured by end date/goal reached of the %s."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_plural_small'), Configure::read('project.alt_name_for_investor_singular_small'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>
			</h4>
		</div>
	</div>
</section>
<section class="sec-2">
	<div class="container">
		<h4><?php echo __l('Our project categories:');?></h4>
        <ul class="list-inline navbar-btn">
					<li>
						<?php echo $this->Html->link(sprintf(__l('All')), array('controller'=>'projects','action'=>'index','project_type' => $project_type,'category' => 'All'), array('class'=>'js-no-pjax text-capitalize h5 list-group-item-text list-group-item-heading', 'title'=>sprintf(__l('All')))); ?>
					</li>
			<?php
				foreach($projectCategories[$project_type] as $slug => $category) {
			?>
					<li>
						<?php echo $this->Html->link(sprintf(__l('%s'), $category), array('controller'=>'projects','action'=>'index','project_type' => $project_type,'category' => $slug), array('class'=>'js-no-pjax text-capitalize h5 list-group-item-text list-group-item-heading', 'title'=>sprintf(__l('%s'), $category))); ?>
					</li>
			<?php
				}
			?>
		</ul>
	</div>
</section>
    <?php if (isPluginEnabled('Idea')): ?>
      <section class="sec-3">
		<div class="container">
        <?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'is_idea' => 1, 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
      </div>
		<hr>
	</section>
    <?php endif; ?>
	<div class="cf-lst-main index-usr-main">
    <section class="sec-4 main js-response">
		<div class="container">
      <?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'filter' => 'featured', 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
    </div>
		<hr>
	</section>
	</div>
	<div class="cf-lst-main index-usr-main">
    <section class="sec-3 main js-response">
		<div class="container">
      <?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'filter' => 'ending_soon', 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
    </div>
		<hr>
	</section>
	</div>
	<div class="cf-lst-main index-usr-main">
    <section class="sec-4 main js-response">
		<div class="container">
      <?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'filter' => 'almost_funded', 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
    </div>
		<hr>
	</section>
	</div>
	<div class="cf-lst-main index-usr-main">
    <section class="sec-3 main js-response">
		<div class="container">
      <?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'filter' => 'successful', 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
   </div>
		<hr>
	</section>
	</div>
	<?php else: ?>
	<div class="prdct-pge index-usr-main">
	<section class="sec-4 main js-response">
		<div class="container">
			<?php echo $this->element('discover_projects-index', array('project_type' => 'equity', 'filter' => 'browse', 'limit' => 4, 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))));?>
			<div class="text-center h1">
				<?php echo $this->Html->link('<i class="fa fa-angle-double-right fa-fw"></i><strong>' .__l('Browse All'). '</strong>', array('controller' => 'projects', 'action' => 'discover', 'project_type'=> 'equity' , 'admin' => false), array('class'=> 'btn btn-primary btn-lg btn-clr btn-efts','title' => __l('Browse All'), 'escape' => false));?>
			</div>
		</div>
	</section>
	<?php endif; ?>