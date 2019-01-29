<?php if ($project['Equity']['equity_project_status_id'] != ConstEquityProjectStatus::OpenForIdea ){ ?>
<li class="navbar-btn txt-center-mbl">
	<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
		<span title="<?php echo $this->Html->cInt($project['Project']['project_fund_count'], false);?>" class="c">
			<?php echo $this->Html->cInt($project['Project']['project_fund_count']);?></span>
	</h3>
	<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
		<?php echo Configure::read('project.alt_name_for_investor_plural_caps');?>
	</p>
</li>
<?php } ?>
<?php if ($project['Equity']['equity_project_status_id'] != ConstEquityProjectStatus::OpenForIdea ){ ?>
<li class="navbar-btn txt-center-mbl">
	<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
		<?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($project['Project']['collected_amount'],false));?>
	</h3>
	<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
		<?php echo sprintf(__l('%s of'),Configure::read('project.alt_name_for_equity_singular_caps')) . ' '.$this->Html->siteCurrencyFormat($this->Html->cCurrency($project['Project']['needed_amount'],false)) . ' ' . __l('goal'); ?> 
	</p>
</li>
<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::ProjectClosed || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending){ ?>
	<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting){?>
<li class="navbar-btn txt-center-mbl">
		<?php if (!empty($project[0]['enddate']) && round($project[0]['enddate']) > 0) { ?>
			<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
				<span title="<?php echo $this->Html->cInt($project[0]['enddate'], false); ?>" class="c"><?php echo $this->Html->cInt($project[0]['enddate']); ?></span>
			</h3>
		<?php } else { ?>
			<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold js-countdown">
				<span title="<?php echo $project[0]['endhour']; ?>"><?php echo $project[0]['endhour']; ?></span>
			</h3>
		<?php } ?>
		<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
			<?php echo (round($project[0]['enddate']) > 0) ?__l('Days to go') : __l('Hours to go'); ?>
		</p>
</li>
	<?php } ?>
<?php } ?>
<li class="media">
	<div class="pull-left no-float">
		<?php
			/* Chart block */
			$collected_percentage = ($project['Project']['collected_percentage']) ? $project['Project']['collected_percentage'] : 0;
			$needed__percentage = 0;
			if($collected_percentage < 100){
			$needed__percentage = 100-$collected_percentage;
			}
			echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$collected_percentage.','.$needed__percentage.'&amp;chs=70x70&amp;chco=00AFEF|C1C1BA&amp;chf=bg,s,FF000000', array('title' => __l('Collected') . ': ' . $collected_percentage.'%'));
			/* Chart block ends*/
		?>
	</div>
	<div class="media-body navbar-btn no-float">
		<p class="h5 txt-center-mbl">
			<?php
			if (date('Y', strtotime($project['Project']['project_end_date'])) > date('Y') ) {
				$projectEndDate = strftime('%A %b %d %Y, %I:%M %p', strtotime($project['Project']['project_end_date']));
			} else {
				$projectEndDate = strftime('%A %b %d, %I:%M %p', strtotime($project['Project']['project_end_date']));
			}
			if (empty($project['Equity']['is_allow_over_funding'])):
				$project_end_date = $project['Equity']['project_fund_goal_reached_date'];
			else:
				$project_end_date = $project['Project']['project_end_date'];
			endif;
			if(!$project['Project']['is_admin_suspended']):
				if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting):
					if ($project['Project']['needed_amount'] != 0):
						if ($project['Project']['collected_amount'] >= $project['Project']['needed_amount'] && !empty($project['Equity']['is_allow_over_funding'])):
							echo sprintf(__l('GoalReached, but it allows for over funding and this %s will be closed on'), Configure::read('project.alt_name_for_project_singular_small')) . ' <span title="' . strftime(Configure::read('site.datetime.tooltip'), strtotime($project['Project']['project_end_date'])) . '">' . $projectEndDate . ' ' . date('T') . '</span>';
						else:
							if($project['Project']['payment_method_id'] == ConstPaymentMethod::KiA) :
								echo sprintf(__l('This %s received all of its funded amount by %s'), Configure::read('project.alt_name_for_project_singular_small'), '<span title="' . strftime(Configure::read('site.datetime.tooltip'), strtotime($project['Project']['project_end_date'])) . '">' . $projectEndDate . ' ' . date('T') . '</span>');
							else:
								echo sprintf(__l('This %s will only be funded if at least %s is investd by %s'), Configure::read('project.alt_name_for_project_singular_small'), $this->Html->siteCurrencyFormat($this->Html->cCurrency($project['Project']['needed_amount'], false)), '<span title="' . strftime(Configure::read('site.datetime.tooltip'), strtotime($project['Project']['project_end_date'])) . '">' . $projectEndDate . ' ' . date('T') . '</span>');
							endif;
						endif;
					endif;
				elseif($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::ProjectClosed):
					if($project['Project']['payment_method_id'] == ConstPaymentMethod::KiA) :
						echo sprintf(__l('This %s received all of its funded amount %s'), Configure::read('project.alt_name_for_project_singular_small'), $this->Time->timeAgoInWords($project_end_date));
					else :
						echo sprintf(__l('This %s successfully raised its funding goal %s'), Configure::read('project.alt_name_for_project_singular_small'), $this->Time->timeAgoInWords($project_end_date));
					endif;
				endif;
			endif;
			?>
		</p>
	</div>
</li>
<hr class="hr-2px-drk-gray marg-top-5 marg-btom-5">
<li class="media">
	<div class="pull-left no-float">
		<?php
		if(!empty($isEquityEnabled)) {
		$is_seis_or_eis = $this->Html->seisCheck($project['Project']['id']);
		}
		?>
		<?php if (!empty($is_seis_or_eis) && $is_seis_or_eis == 1){ ?>
			<span class="label label-info pull-right btn-primary"><?php echo __l('SEIS');?></span>
			<i class="js-tooltip fa fa-question-circle fa-fw" title="<?php echo ('As per UK, Investor can avail tax relief for projects with SEIS compliance.'); ?>"></i>
		<?php } else if (!empty($is_seis_or_eis) && $is_seis_or_eis == 2){ ?>
			<span class="label label-info btn-primary"><?php echo __l('EIS');?></span>
			<i class="js-tooltip fa fa-question-circle" title="<?php echo ('As per UK, Investor can avail tax relief for projects with SEIS compliance.'); ?>"></i>
		<?php }?>
	</div>
	<div class="media-body navbar-btn no-float">
		<?php echo sprintf(__l('Amount for per share is %s%s'), Configure::read('site.currency'), Configure::read('equity.amount_per_share'))?>
	</div>
</li>
<hr class="hr-2px-drk-gray marg-top-5 marg-btom-5">
<?php } ?>
<?php if (isPluginEnabled('Idea') && $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea) :?>
<li class="navbar-btn txt-center-mbl">
	<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
		<span class="js-idea-vote-count-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> vote-count-value">
			<?php echo $this->Html->cInt($project['Project']['total_ratings']); ?>
		</span> 
	</h3>
	<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
		<?php echo __l('Votes'); ?>
	</p>
</li>
<li class="navbar-btn txt-center-mbl">
	<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
		<span class="b-color js-idea-voters-count"><?php echo $this->Html->cInt($project['Project']['project_rating_count']);?></span>
	</h3>
	<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
		<?php echo __l('Voters'); ?>
	</p>
</li>
<li class="navbar-btn txt-center-mbl">
	<h3 class="h1 list-group-item-text list-group-item-heading font-size-54 roboto-bold">
		<span class="js-idea-rating-count">
			<?php
				if($project['Project']['project_rating_count']!=0)
				{
					$average_rating = $project['Project']['total_ratings']/$project['Project']['project_rating_count'];
					echo $this->Html->cFloat($average_rating);
				}
				else
				{
					echo $this->Html->cFloat(0);
				}
			?>
		</span> 
	</h3>
	<p class="panel-title list-group-item-text list-group-item-heading clr-gray roboto-regular">
		<?php echo __l('Average votes'); ?>
	</p>
</li>
<li class="navbar-btn txt-center-mbl">
	<p class="h5 txt-center-mbl">
		<?php echo __l('This idea will only be listed for funding only if at least enough voters support it. Admin will move top votes ideas to projects based on number of votes.');?> 
	</p>
</li>
<hr class="hr-2px-drk-gray marg-top-5 marg-btom-5">
<?php endif;?>
<?php if ($project['Equity']['equity_project_status_id'] != ConstEquityProjectStatus::OpenForIdea ){ ?>
<?php } ?>
<li class="navbar-btn media page-header">
	<div class="pull-right no-float">
		<div class="img-contain-110 img-circle center-block">
			<?php echo $this->Html->getUserAvatar($project['User'], 'user_thumb'); ?>
		</div>
	</div>
	<div class="media-body no-float">
		<h3 class="h4 txt-center-mbl list-group-item-text list-group-item-heading roboto-bold">
			<?php echo $this->Html->link($this->Html->cText($project['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $project['User']['username']), array('title' => $project['User']['username'], 'escape' => false));?> 
		</h3>
		<p class="h4 txt-center-mbl" itemscope itemtype="http://schema.org/interactionCount" itemprop="attendees">
			<span class="h5 clr-gray roboto-regular">
				<?php echo $project_count;?><?php echo __l(' Projects posted'); ?>
				<?php echo $this->Html->cInt($project['User']['unique_project_fund_count']);?><?php echo __l(' Projects funded'); ?>
				<?php if(isPluginEnabled('ProjectFollowers')):?>
				<?php echo __l('Following ');?><?php echo $project_following_count;?><?php echo __l(' project(s)'); ?>
				<?php endif; ?>
			</span>
		</p>
	</div>
	<hr class="hr-2px-drk-gray marg-top-30 marg-btom-5">
</li>
<?php /*if (isPluginEnabled('ProjectFollowers')) { ?>
<section class="clearfix">
<?php  echo $this->element('followers', array('project_id' => $project['Project']['id']), array('plugin' => 'ProjectFollowers')); ?>
</section>
<?php } ?>
<section class="clearfix"> <?php echo $this->element('project-activities', array('project_id' => $project['Project']['id'], 'project_type'=>$project['Project']['project_type_id'], 'cache' => array('config' => 'sec', 'key' => $project['Project']['id'])));?> </section>
<?php if (Configure::read('widget.project_script')) { ?>
<section class="clearfix">
<div class="text-center clearfix"> <?php echo Configure::read('widget.project_script'); ?> </div>
</section>
<?php }*/ ?>
