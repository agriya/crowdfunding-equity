<div class="bg-success clearfix text-center start-project-baner">
	<h2 class="list-group-item-heading"><span class="or-hor text-b"><?php echo __l('Start Project');?></span></h2>
	<p><?php echo sprintf(__l('Discover new %s campaigns or start your own campaign to raise funds.'), Configure::read('site.name')); ?></p>
</div> 
<ul class="nav nav-tabs project-tab text-center">
	<?php 
	if(isPluginEnabled('Pledge')) {
	?>
		<?php if($project_type == 'pledge') { ?>
		<li class="active">
		<?php } else {?>
		<li>
		<?php } ?>
			<?php echo $this->Html->link($this->Html->image('start-pledge.png') . '<strong>'. __l(Configure::read('project.alt_name_for_pledge_singular_small')) .'</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'pledge'), array('class' => 'pledge-heading text-uppercase', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Donate')) {
	?>
		<?php if($project_type == 'donate') { ?>
		<li class="active">
		<?php } else {?>
		<li>
		<?php } ?>
			<?php echo $this->Html->link($this->Html->image('start-donate.png') . '<strong>'. __l(Configure::read('project.alt_name_for_donate_singular_small')) .'</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'donate'), array('class' => 'donate-heading text-uppercase', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Equity')) {
	?>
		<?php if($project_type == 'equity') { ?>
		<li class="active">
		<?php } else {?>
		<li>
		<?php } ?>
			<?php echo $this->Html->link($this->Html->image('start-equity.png') . '<strong>'. __l(Configure::read('project.alt_name_for_equity_singular_small')) .'</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'equity'), array('class' => 'equity-heading text-uppercase', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Lend')) {
	?>
		<?php if($project_type == 'lend') { ?>
		<li class="active">
		<?php } else {?>
		<li>
		<?php } ?>
			<?php echo $this->Html->link($this->Html->image('start-lend.png') . '<strong>'. __l(Configure::read('project.alt_name_for_lend_singular_small')) .'</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'lend'), array('class' => 'lend-heading text-uppercase', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
</ul>
<div class="container">
<?php if(!empty($_SESSION['lendDetails'])){ ?>
	<dl class="panel panel-body panel-info clearfix marg-top-30">
		<dt><strong><?php echo __l('Needed Amount').' ('.Configure::read('site.currency').')'; ?></strong></dt>
		<dd><?php echo $this->Html->cInt($_SESSION['lendDetails']['lend_needed_amount']); ?></dd>
		<dt><strong><?php echo __l('Terms'); ?></strong></dt>
		<dd><?php echo Configure::read('lend.default_terms') . ' months'; ?></dd>
		<dt><strong><?php echo __l('Interest Rate (%)'); ?></strong></dt>
		<dd><?php echo $this->Html->cFloat($_SESSION['lendDetails']['lend_interest_rate']); ?></dd>
		<dt><strong><?php echo __l('Monthly Repayment').' ('.Configure::read('site.currency').')'; ?></strong></dt>
		<dd><?php echo $this->Html->cCurrency($_SESSION['lendDetails']['lend_per_month']); ?></dd>
	</dl>
<?php } ?>
<div class="clearfix page-header no-bor">
		<?php if (isPluginEnabled('Idea')): ?>
			<h2 class="text-center roboto-bold"><?php echo __l('Get Started Project Flow');?></h2>
			<ul class="list-unstyled text-center clearfix roboto-bold project-post-idea">
				<li class="marg-btom-20">
					<?php echo $this->Html->image('start-project-steps.png', array('alt' => __l('[Image: Start Project Steps]'))); ?>
				</li>
				<li class="col-sm-4">
					<div>
						<?php echo $this->Html->image('post-idea.png', array('alt' => __l('[Image: Post Idea]'))); ?>
					</div>
					<h3 class="text-22 marg-top-20"><?php echo __l('Post Idea'); ?></h3>
				</li>
				<li class="col-sm-4">
					<div>
						<?php echo $this->Html->image('get-support.png', array('alt' => __l('[Image: Get Support]'))); ?>
					</div>
					<h3 class="text-22"><?php echo __l('Get Support'); ?></h3>
				</li>
				<li class="col-sm-4">
					<div>
						<?php echo $this->Html->image('take-fund.png', array('alt' => __l('[Image: Take Funds]'))); ?>
					</div>
					<h3 class="text-22"><?php echo __l('Take Funds'); ?></h3>
				</li>
			</ul>
		<?php else: ?>
			<ul class="list-inline">
				<li>
					<?php echo $this->Html->image('post-idea.png', array('alt' => __l('[Image: Post Project]'))); ?>
				</li>
				<li>
					<?php echo $this->Html->image('get-support.png', array('alt' => __l('[Image: Get Support]'))); ?>
				</li>
				<li>
					<?php echo $this->Html->image('take-fund.png', array('alt' => __l('[Image: Take Funds]'))); ?>
				</li>
			</ul>
			<ul class="list-inline">
				<li>
					<?php echo __('Post Project'); ?>
				</li>
				<li>
					<?php echo __('Get Support'); ?>
				</li>
				<li>
					<?php echo __('Take Funds'); ?>
				</li>
			</ul>
		<?php endif; ?>
</div>
<?php if (isPluginEnabled('Idea')): ?>
	<?php
	if($project_type == 'pledge'){
		$message = 'amount is captured by end date. May offer rewards';
	}elseif($project_type == 'donate'){
		$message = 'people immediately pay to you. Can\'t offer rewards';
	}elseif($project_type == 'equity'){
		$message = 'amount is captured by end date/goal reached. Entrepreneurs offer shares';
	}elseif($project_type == 'lend'){
		$message = 'amount is captured by end date/goal reached of the project. Borrowers offer interest';
	}
	?>
	<div class="alert alert-info clearfix"><?php echo sprintf(__l("Top voted ideas will be chosen for %s by admin. In %s %s, %s."), Configure::read(sprintf('project.alt_name_for_%s_present_continuous_small', $project_type)), $project_type, Configure::read('project.alt_name_for_project_plural_small'), $message); ?></div>
<?php endif; ?>
</div>
<?php if($project_type == 'equity' && isPluginEnabled('JobsAct')):?>
	<div class="container well">
		<h3> <?php echo __l('JOBS Act Implications');?></h3>
		<ol>
			<li><?php echo sprintf(__l('Companies can raise upto $1 million per year via %s.'), Configure::read('site.name'));?></li>
			<li><?php echo __l('Target offering amount and deadline to reach that amount.');?></li>
			<li><?php echo __l('Disclose shareholders with 20% or more of the company.');?></li>
			<li><?php echo __l('Increases the number of shareholders a company can have before having to register common stock with SEC and become a public company. Now, companies can have 500 unaccredited investors and 2,0000 shareholders');?></li>
		</ol>
	</div>
<?php endif; ?>
<?php 
	if(!empty($project_type) && isPluginEnabled(Inflector::camelize($project_type))) {
	?>
	<section class="gray-bg">
		<div class="container">
			<?php
				echo $this->element(Inflector::camelize($project_type).'.how_it_works');
			?>
		</div>
	</section>
<?php
	}
?>
<div> <?php echo $this->requestAction(array('controller' => 'nodes', 'action' => 'view', 'type' => 'page', 'slug' => 'project_guidelines'), array('return')); ?> </div>

