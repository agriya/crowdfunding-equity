<div class="h3">
	<h5 class="text-capitalize list-group-item-text">
		<strong><?php echo sprintf(__l('Flagged %s %s'), Configure::read('project.alt_name_for_equity_singular_caps'), Configure::read('project.alt_name_for_project_plural_caps'));?></strong>
	</h5>
	<ul class="list-unstyled navbar-btn list-group-item-heading">
		<li>
			<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
			<?php echo $this->Html->link(__l('System Flagged') . ' (' . $equity_system_flagged_count. ')', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('class' => 'h5 rgt-move'));?>
		</li>
		<?php if (isPluginEnabled('ProjectFlags')) { ?>
		<li>
			<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
			<?php echo $this->Html->link(__l('User Flagged') . ' (' . $equity_user_flagged_count. ')', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::UserFlagged), array('class' => 'h5 rgt-move'));?> 
		</li>
		<?php } ?>
	</ul>
</div>