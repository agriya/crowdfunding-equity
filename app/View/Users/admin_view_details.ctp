  <div class="modal-header">
    <div class="pull-left col-md-12">
      <h4><?php echo $this->Html->cText($user['User']['username']); ?></h4>
	</div>
  </div>
  <div class="modal-body">
	<ul class="list-unstyled clearfix">
	  <li class="col-md-6">
		<h5><?php echo __l('Profile Info'); ?></h5>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('First Name'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['first_name'])):
					echo $this->Html->cText($user['UserProfile']['first_name']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Last Name'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['last_name'])):
					echo $this->Html->cText($user['UserProfile']['last_name']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Date of Birth'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['dob'])):
					echo $this->Html->cText($user['UserProfile']['dob']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('City'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['City']['name'])):
					echo $this->Html->cText($user['UserProfile']['City']['name']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('State'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['State']['name'])):
					echo $this->Html->cText($user['UserProfile']['State']['name']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Country'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['Country']['name'])):
					echo $this->Html->cText($user['UserProfile']['Country']['name']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Zip Code'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['UserProfile']['zip_code'])):
					echo $this->Html->cText($user['UserProfile']['zip_code']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
	  </li>
	  <?php if (isPluginEnabled('JobsAct')):?>
	  <li class="col-md-6">
	    <h5><?php echo __l('JOBS Act Info'); ?></h5>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Net Worth').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['net_worth'])):
					echo $this->Html->cText($jobs['JobsActEntry']['net_worth']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Annual Income').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['annual_income_individual'])):
					echo $this->Html->cText($jobs['JobsActEntry']['annual_income_individual']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Annual Income with Spouse').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['annual_income_with_spouse'])):
					echo $this->Html->cText($jobs['JobsActEntry']['annual_income_with_spouse']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Total Asset').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['total_asset'])):
					echo $this->Html->cText($jobs['JobsActEntry']['total_asset']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Household Income').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['household_income'])):
					echo $this->Html->cText($jobs['JobsActEntry']['household_income']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Annual Expenses').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['annual_expenses'])):
					echo $this->Html->cText($jobs['JobsActEntry']['annual_expenses']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Liquid Networth').' ('.Configure::read('site.currency').')'; ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($jobs['JobsActEntry']['liquid_net_worth'])):
					echo $this->Html->cText($jobs['JobsActEntry']['liquid_net_worth']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
	  </li>
	  <?php endif;?>
	  <li class="col-md-6">
		<h5><?php echo __l('Project Info'); ?></h5>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Projects Posted'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['User']['project_count'])):
					echo $this->Html->cText($user['User']['project_count']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Flags Count'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['User']['project_flag_count'])):
					echo $this->Html->cText($user['User']['project_flag_count']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Followiners Count'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['User']['project_follower_count'])):
					echo $this->Html->cText($user['User']['project_follower_count']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Comments Count'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['User']['project_comment_count'])):
					echo $this->Html->cText($user['User']['project_comment_count']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Ratings Count'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php if(!empty($user['User']['project_rating_count'])):
					echo $this->Html->cText($user['User']['project_rating_count']);
				else:
					echo __l('N/A');
				endif;?>
			</div>
		</div>
	  </li>
	  <li class="col-md-6">
	    <h5><?php echo __l('Social Network Info'); ?></h5>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Connected Facebook'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php echo $this->Html->cText($user['User']['is_facebook_connected']?'Yes':'No'); ?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Connected twitter'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php echo $this->Html->cText($user['User']['is_twitter_connected']?'Yes':'No'); ?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Connected Google'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php echo $this->Html->cText($user['User']['is_google_connected']?'Yes':'No'); ?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Connected Yahoo'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php echo $this->Html->cText($user['User']['is_yahoo_connected']?'Yes':'No'); ?>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-md-6 text-left"><strong>
				<?php echo __l('Connected Linkedin'); ?>
			</strong></div>
			<div class="col-md-6">
				<?php echo $this->Html->cText($user['User']['is_linkedin_connected']?'Yes':'No'); ?>
			</div>
		</div>
	  </li>
	</ul>
  </div>
  <div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
</div>