<div class="SeisAct form add-project">
<div class="bg-success clearfix text-center start-project-baner">
	<h2 class="list-group-item-heading"><span class="or-hor text-b"><?php echo __l('Start Project');?></span></h2>
	<p>Discover new crowdfunding campaigns or start your own campaign to raise funds.</p>
</div>
<ul class="nav nav-tabs project-tab text-center">
	<?php 
	if(isPluginEnabled('Pledge')) {
	?>
		<li>
			<?php echo $this->Html->link($this->Html->image('start-pledge.png') . '<strong>PLEDGE</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'pledge'), array('class' => 'pledge-heading', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Donate')) {
	?>
		<li>
			<?php echo $this->Html->link($this->Html->image('start-donate.png') . '<strong>DONATE</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'donate'), array('class' => 'donate-heading', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Equity')) {
	?>
		<li class="active">
			<?php echo $this->Html->link($this->Html->image('start-equity.png') . '<strong>EQUITY</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'equity'), array('class' => 'equity-heading', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
	<?php 
	if(isPluginEnabled('Lend')) {
	?>
		<li>
			<?php echo $this->Html->link($this->Html->image('start-lend.png') . '<strong>LEND</strong>', array('controller' =>'projects', 'action' => 'add', 'project_type'=>'lend'), array('class' => 'lend-heading', 'escape' => false)); ?>
		</li>
	<?php
	}
	?>
</ul>
	<div class="container">
		<h4 class="text-center h2 marg-top-30 roboto-bold"><?php echo __l('Seed Enterprise Investment Scheme (SEIS) Compliance'); ?></h4>
		<p class="text-center marg-btom-30 roboto-light h3"><?php echo __l('Before starting project, check your compliance whether you are eligible or not under UK SEIS/EIS scheme.'); ?></p>
	</div>
</div>
  <div class="equity">
    <?php echo $this->Form->create('SeisEntry', array('class' => 'form-horizontal admin-form')); ?>
		<div class="start-equity">
			<div class="container clearfix">
				<div class="equity-form">
					<div class="clearfix">
					  <div class="alert alert-warning clearfix"><?php echo __l('Please enter with care, you can\'t update these details later. This is one-time-process.'); ?></div>
					  <?php
					  echo $this->Form->input('company_name',array('label' => __l('Company Name'),'placeholder'=>"Enter the Company name"));
					  echo $this->Form->input('number_of_employees',array('label' => __l('Number of Employees'),'placeholder'=>"Enter the number")); ?>
					   <div class="input date-time clearfix">
						  <div class="js-datetime required">
						  <div class="js-cake-date">
							<?php echo $this->Form->input('year_of_founding', array('label' => __l('Year Founded'), 'type' => 'date', 'orderYear' => 'asc', 'maxYear' => date('Y'), 'minYear' => date('Y') - 200, 'div' => false, 'empty' => __l('Please Select') , 'info' => __l('The year your company was founded'),'placeholder'=>"No Date Set")); ?>
						  </div>
						  </div>
					   </div>
					   <?php echo $this->Form->input('total_asset',array('label' => __l('Total Asset ($)'),'placeholder'=>"Enter amount")); ?>
					   <div class="form-actions input">
							<div>
								<?php  echo $this->Form->submit(__l('Submit'), array('class' => 'btn')); ?>
							</div>
					   </div>
				   </div>
			   </div>
			   <div class="well clearfix">
					<h5 class="h3 roboto-bold"><?php echo __l('SEIS Advantage'); ?></h5>
					<p><?php echo __l('As per UK, Investor can avail tax relief for projects with SEIS compliance. This will attract more investors.'); ?></p>
					<p><a href="http://www.seis.co.uk/" target="_blank" class="text-warning"><?php echo __l('Read more....'); ?></a></p>
			   </div>
		   </div>
	   </div>
	   <div class="clearfix">
			<?php echo $this->Form->end(); ?>
	  </div>
  </div>