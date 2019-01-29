<p>
	<span class="btn btn-sm btn-success bdr-rad-7px open-fund-pad">
		<i class="fa fa-usd fa-fw font-size-15"></i>
	</span>  
	<span class="panel-title list-group-item-text list-group-item-heading clr-black vertical-center roboto-regular">
		<?php
			$projectStatus = array();
			$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
			'projectStatus' => $projectStatus,
			'project' => $project,
			'type'=> 'status'
			));
			$projectStatus = $response->data['projectStatus'];
			$status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
			'status_id' => $projectStatus[$project['Project']['id']]['id'],
			'project_type_id' => $project['Project']['project_type_id']
			));
			if($status_response->data['response']){
			$reason =  $status_response->data['response'];
			echo $this->Html->cText($reason);
			}
			else{
			echo __l('Draft');
			}
		?>
	</span> 
	<?php if ($project['Project']['payment_method_id'] == ConstPaymentMethod::KiA && Configure::read('Project.is_project_owner_select_funding_method')): ?>
	<span class="btn btn-sm btn-info bdr-rad-7px open-fund-pad">
		<i class="js-tooltip fa fa-question-circle fa-fw" title="<?php echo sprintf(__l('%s fund will be captured even if it does not reached the needed amount'), Configure::read('project.alt_name_for_project_singular_caps')); ?>"></i>
	</span>
	<span class="panel-title list-group-item-text list-group-item-heading clr-black vertical-center roboto-regular">	
		<?php echo __l('Flexible Funding'); ?>
	</span>
	<?php endif; ?>
</p>