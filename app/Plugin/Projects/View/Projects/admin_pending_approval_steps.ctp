<div class="modal-header">
<h2 id="js-modal-heading"><?php echo __l('Project - ') . $this->Html->cText($project['Project']['name']); ?></h2>
</div>
<div class="thumbnail approval-steps modal-body">
	<?php if(!empty($project['Project']['is_pending_action_to_admin'])) { ?>
	<div class="pull-right col-md-10 clearfix">
		<div class="pull-right col-md-4">
			<div class="btn-group dropdown">
			<a href="#" title="Actions" class="btn js-no-pjax btn btn-danger"><?php echo __l('Reject'); ?></a>
			<?php
				//modal for Reject
				echo $this->Html->link('<i class="fa fa-cog"> </i><span class="caret"></span>',array('controller' => 'projects', 'action' => 'update_tracked_step','reject' => 1, 'project_id' => $this->request->data['Project']['id'], 'project_type_id' => $project['Project']['project_type_id'], 'step' => $pending_step_arr[sizeof($pending_step_arr)-1]),array('data-href'=>"#dropdown-1",'data-target'=>"#", 'data-toggle'=>"dropdown", 'escape'=>false, 'class' => 'btn js-no-pjax btn btn-danger js-approve', 'title' => __l('Reject')));
			?>
			<div class="dropdown-menu js-pending-list space clearfix pull-right js-approve" id="dropdown-1">
				<div class="text-center">
					<?php echo $this->Html->image('ajax-follow-loader.gif', array('class'=>'js-loader')); ?>
				</div>
			</div>
			</div>
		</div>
		<div class="pull-right col-md-6">
			<div class="btn-group dropdown">
			<a href="#" title="Actions" class="btn js-no-pjax btn btn-primary"><?php echo __l('Approve'); ?></a>
			<?php //modal for Approve
				echo $this->Html->link('<i class="fa fa-cog"> </i><span class="caret"></span>',array('controller' => 'projects', 'action' => 'update_tracked_step', 'project_id' => $this->request->data['Project']['id'], 'project_type_id' => $project['Project']['project_type_id'], 'step' => $pending_step_arr[sizeof($pending_step_arr)-1]),array('data-href'=>"#dropdown-2", 'data-target'=>"#", 'data-toggle'=>"dropdown", 'escape'=>false, 'class' => 'js-no-pjax btn btn-primary js-approve', 'title' => __l('Approve')));
			?>
			<div class="dropdown-menu js-pending-list space clearfix pull-right js-approve" id="dropdown-2">
				<div class="text-center"><?php echo $this->Html->image('ajax-follow-loader.gif', array('class'=>'js-loader')); ?></div>
			</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(!empty($seisEntry)):?>
		<div class="admin-approval">
			<h4><?php echo __l('SEIS Detail'); ?></h4>
			<dl class="dl-horizontal gray-bg">
				<dt class="text-right"><strong><?php echo __l('Company Name'); ?></strong></dt>
					<dd class="text-left"><?php echo $this->Html->cText($seisEntry['SeisEntry']['company_name']); ?></dd>
				<dt class="text-right"><strong><?php echo __l('Number of Employee'); ?></strong></dt>
					<dd class="text-left"><?php echo $this->Html->cText($seisEntry['SeisEntry']['number_of_employees']); ?></dd>
				<dt class="text-right"><strong><?php echo __l('Year of Founding'); ?></strong></dt>
					<dd class="text-left"><?php echo $this->Html->cDateTimeHighlight($seisEntry['SeisEntry']['year_of_founding']); ?></dd>
				<dt class="text-right"><strong><?php echo __l('Total Asset ('.Configure::read('site.currency').")"); ?></strong></dt>
					<dd class="text-left"><?php echo $this->Html->cText($seisEntry['SeisEntry']['total_asset']); ?></dd>
			</dl>
		</div>
	<?php endif; ?>
	<?php
		$step = count($formFieldSteps);
		$tracked_steps_arr = unserialize($project['Project']['tracked_steps']);
		if(!empty($tracked_steps_arr)){
		ksort($tracked_steps_arr);
		}
		if(!isPluginEnabled('ProjectRewards'))	
			$step--;
	?>
	<?php foreach($formFieldSteps as $formFieldStep) { ?>
	<?php 
		if(!isPluginEnabled('ProjectRewards') && $formFieldStep['FormFieldStep']['name'] == 'Rewards')
			continue;
	?>
			<div class="clearfix">
				<div class="pull-left col-md-12">
					<h4 class="text-b"><?php echo 'Step ' . $step . ': ' . $this->Html->cText($formFieldStep['FormFieldStep']['name']); ?></h4>
					<?php if(!empty($tracked_steps_arr)){
						foreach($tracked_steps_arr as $key => $val): ?>
						<?php if($formFieldStep['FormFieldStep']['order'] == $key): ?>
							<?php if(!empty($val['submitted_on'])): ?>
								<div class="well">
									<?php $i = 0; ?>
									<?php foreach($val['submitted_on'] as $submitted_on): ?>
										<p class="no-mar"><span><?php echo __l('Submitted On: ') . $this->Html->cDateTimeHighlight($submitted_on); ?></span></p>
										<?php if (!empty($val['rejected_on'][$i])): ?>
											<p><span><?php echo __l('Rejected On: ') . $this->Html->cDateTimeHighlight($val['rejected_on'][$i]); ?></span>
											<?php if(!empty($val['information_to_user'][$i])): ?> 
												<i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo $this->Html->cHtml($val['information_to_user'][$i], false); ?>"></i>
											<?php endif; ?>
											<?php if(!empty($val['private_note'][$i])): ?>
												<i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo $this->Html->cHtml($val['private_note'][$i], false); ?>"></i>
											<?php endif; ?></p>
											<?php $i++; ?>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php if(!empty($val['updated_on'])): ?>
											<?php foreach($val['updated_on'] as $updated_on): ?>
												<p><span><?php echo __l('Updated On: ') . $this->Html->cDateTimeHighlight($updated_on); ?></span></p>
											<?php endforeach; ?>
										<?php endif; ?>
									<?php if (!empty($val['approved_on'])): ?>
										<p><span><?php echo __l('Approved On: ') . $this->Html->cDateTimeHighlight($val['approved_on']); ?></span>
										<?php if(!empty($val['private_note'][$i])): ?> 
											<i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo $this->Html->cHtml($val['private_note'][$i], false); ?>"></i>
										<?php endif; ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?> 
						<?php endif; ?>
					<?php endforeach; }?>
				</div>
				<?php $step--; ?>
			</div>
			<?php if(!empty($formFieldStep['FormFieldStep']['is_payment_step'])) {  ?>
				<div class="clearfix">
					<p class="col-xs-3"><strong><?php echo __l('Payment Status'); ?></strong></p>
					<p class="col-md-3">
						<?php if (!empty($project['Project']['is_paid'])) { ?>
							<?php echo __l('Done'); ?>
						<?php } else { ?>
							<?php echo'-'; ?>
						<?php } ?>
					</p>
				</div>
			<?php } else { ?>
				<ul class="clearfix list-inline no-rewards">
					<?php foreach($formFieldStep['FormFieldGroup'] as $formFieldGroup) {
							$is_reward_step = strstr($formFieldGroup['FormField'][0]['name'], 'ProjectReward');
							$class = 'col-sm-6';
							if($is_reward_step) {
								$reward_fields_count = (count($formFieldGroup['FormField']));
								$class = 'col-md-12';
							}
							$reward_row = 1;
							if($is_reward_step && empty($project['ProjectReward'])) {
								echo '<p class="col-xs-12"><span class="col-sm-6 ver-mspace">'.__l('No Rewards added.').'</span></p>';								
								continue;
							}
						?>
						<li class="<?php echo $class; ?>">
							<?php if(!empty($formFieldGroup['FormField'])) : ?>
								<h5 class="col-xs-12 text-b text-info h3"><?php echo $this->Html->cText($formFieldGroup['name']); ?></h5>
							<?php endif; ?>
							<?php $is_reward = false; ?>
							<?php foreach($formFieldGroup['FormField'] as $formField) { ?>
								<?php if (!empty($submissionFields[$formField['name']])): ?>
									<div class="clearfix">
										<p class="col-sm-5 text-right"><strong><?php echo str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label'])); ?></strong></p>
										<p class="col-sm-5" title="<?php echo $this->Html->cText($submissionFields[$formField['name']], false); ?>"><?php echo $this->Html->cText($submissionFields[$formField['name']]); ?></p>
									</div>
								<?php else: ?>
									<?php $field_arr = explode('.', $formField['name']); ?>
									<?php if((!empty($field_arr[1]) && $field_arr[1] == 'pledge_type_id')) { ?>
										<?php if(count($pledgeTypes) > 1) { ?>
											<div class="clearfix">
											<div class="col-sm-6 text-left" title="<?php echo str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label'], false)); ?>"><strong>
												<?php
													echo str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label']));
												?>
											</strong>
											</div>
                                            <?php
                                            		$pledge_type = '';
                                                	switch($project[$field_arr[0]]['pledge_type_id']) {
														case 1:
															$pledge_type = __l("Any");
															break;
														case 2:
															$pledge_type = __l("Minimum");
															break;
														case 3:
															$pledge_type = __l("Fixed");
															break;
														case 4:
															$pledge_type = __l("Multiple");
															break;
														case 5:
															$pledge_type = __l("Reward");
															break;
													}
												?>
											<div class="col-sm-5" title="<?php echo $pledge_type; ?>">
												<?php
													echo $pledge_type;
												?>
											</div>
											</div>
										<?php } ?>
									<?php } else if((!empty($field_arr[1]) && $field_arr[1] == 'min_amount_to_fund')) { ?>
										<?php if(count($pledgeTypes) > 1) { ?>
										<div class="clearfix">
                                        <?php
                                        		$pledge_amount_type = '';
                                                $pledge_amount_type = '';
                                                switch($project[$field_arr[0]]['pledge_type_id']) {
                                                    case 1:
                                                        $pledge_amount_type =  str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label']));
                                                         $pledge_amount_type_info =  str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label'], false));
                                                        break;
                                                    case 2:
                                                        $pledge_amount_type = $pledge_amount_type_info = __l('Minimum amount');
                                                        break;
                                                    case 3:
                                                        $pledge_amount_type = $pledge_amount_type_info = __l("Fixed amount");
                                                        break;
                                                    case 4:
                                                        $pledge_amount_type = $pledge_amount_type_info = __l("Denomination");
                                                        break;
                                                    case 5:
                                                        $pledge_amount_type = $pledge_amount_type_info = __l("Suggested amount");
                                                        break;
                                                }
                                            ?>
											<div class="col-sm-6 text-left" title="<?php echo $pledge_amount_type_info; ?>">
												<strong>
												<?php
													 echo $pledge_amount_type;
												?>
												</strong>
											</div>
											<div class="col-sm-5" title="<?php echo $this->Html->cText($project[$field_arr[0]][$field_arr[1]], false); ?>">
												<?php echo $this->Html->cText($project[$field_arr[0]][$field_arr[1]]); ?>
											</div>
										</div>
										<?php } ?>
									<?php } else {
										if($is_reward_step && $reward_row == 1 && !empty($project[$field_arr[0]])) {?>
									<div class="reward col-md-6">
									<h6><?php echo $this->Html->cText($formFieldGroup['name']) . ' ' . $reward_row; ?></h6>
									<?php
										}
									?>
									<div class="clearfix">
										<div class="col-sm-6 text-left" title="<?php
												echo str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label'], false));
											?>">
											<strong>
											<?php
												echo str_replace('##SITE_CURRENCY##', Configure::read('site.currency'), $this->Html->cText($formField['label']));
											?>
											</strong>
										</div>
                                        <?php
                                        		$info = '';
												if (!empty($field_arr[0]) && $field_arr[0] == 'ProjectReward' && !empty($project[$field_arr[0]])) {
													$is_reward = true;
													if (!empty($field_arr[2]) && $field_arr[2] == 'pledge_max_user_limit') {
														$info = isset($field_arr[1]) ? $project[$field_arr[0]][$field_arr[1]]['pledge_max_user_limit']:'-';
													} else if(!empty($field_arr[2]) && $field_arr[2] == 'is_having_additional_info') {
														$info = isset($field_arr[1]) ? (($project[$field_arr[0]][$field_arr[1]]['is_having_additional_info'])? 'Yes': 'No'):'-';
													} else if(!empty($field_arr[2]) && $field_arr[2] == 'is_shipping') {
														$info = isset($field_arr[1]) ? (($project[$field_arr[0]][$field_arr[1]]['is_shipping'])? 'Yes': 'No'):'-';
													} elseif(!empty($project[$field_arr[0]][$field_arr[1]][$field_arr[2]])) {
														$info = isset($field_arr[1]) ? $project[$field_arr[0]][$field_arr[1]][$field_arr[2]] : '-';
													} else {
														echo '-';
													}
													$reward_row++;
												} elseif(strstr($field_arr[0], 'Project')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'payment_method_id') {
														switch($project[$field_arr[0]]['payment_method_id']) {
															case 1:
																$info = __l("Fixed Funding");
																break;
															case 2:
																$info = __l("Flexible Funding");
																break;
														}
													} else if (!empty($field_arr[1]) && $field_arr[1] == 'country_id') {
														$info = $project['Country']['name'];
													} elseif (!empty($field_arr[1]) && !empty($project[$field_arr[0]][$field_arr[1]])) {
														$info = $project[$field_arr[0]][$field_arr[1]];
													} else {
														echo '-';
													}
												} elseif(!empty($field_arr[0]) && $field_arr[0] == 'City') {
													$info = $project['City']['name'];
												} elseif(!empty($field_arr[0]) && $field_arr[0] == 'State') {
													$info = $project['State']['name'];
												} elseif(!empty($field_arr[0]) && strstr($field_arr[0], 'Pledge')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'pledge_project_category_id') {
														$info = $project[$field_arr[0]]['PledgeProjectCategory']['name'];
													} elseif (!empty($field_arr[1]) && $field_arr[1] == 'is_allow_over_funding') {
														$info = ($project[$field_arr[0]]['is_allow_over_funding'])? "Yes": "No";
													} elseif(!empty($field_arr[1]) && $field_arr[1] == 'pledge_type_id') {
														if(count($pledgeTypes) > 1) {
															switch($project[$field_arr[0]]['pledge_type_id']) {
																case 1:
																	$info = __l("Any");
																	break;
																case 2:
																	$info = __l("Minimum");
																	break;
																case 3:
																	$info = __l("Fixed");
																	break;
																case 4:
																	$info = __l("Multiple");
																	break;
																case 5:
																	$info = __l("Reward");
																	break;
															}
														}
													} elseif (!empty($field_arr[1])) {
														$info = $project[$field_arr[0]][$field_arr[1]];
													} else {
														echo '-';
													}
												} elseif(!empty($field_arr[0]) && strstr($field_arr[0], 'Donate')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'donate_project_category_id') {
														$info = $project[$field_arr[0]]['DonateProjectCategory']['name'];
													} elseif (!empty($field_arr[1])) {
														$info = $project[$field_arr[0]][$field_arr[1]];
													} else {
														echo '-';
													}
												} elseif(!empty($field_arr[0]) && strstr($field_arr[0], 'Equity')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'equity_project_category_id') {
														$info = $project[$field_arr[0]]['EquityProjectCategory']['name'];
													} elseif (!empty($field_arr[1])) {
														$info = $project[$field_arr[0]][$field_arr[1]];
													} else {
														echo '-';
													}
												} elseif(strstr($field_arr[0], 'Lend')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'lend_project_category_id') {
														$info = $project[$field_arr[0]]['LendProjectCategory']['name'];
													} elseif (!empty($field_arr[1]) && $field_arr[1] == 'credit_score_id') {
														$info = $project[$field_arr[0]]['CreditScore']['name'];
													} elseif (!empty($field_arr[1]) && $field_arr[1] == 'loan_term_id' && isset($project[$field_arr[0]]['LoanTerm']['name'])) {
														$info = $project[$field_arr[0]]['LoanTerm']['name'];
													} elseif (!empty($field_arr[1]) && $field_arr[1] == 'repayment_schedule_id' && isset($project[$field_arr[0]]['RepaymentSchedule']['name'])) {
														$info = $project[$field_arr[0]]['RepaymentSchedule']['name'];
													} elseif (!empty($field_arr[1])) {
														$info = $project[$field_arr[0]][$field_arr[1]] . ' %';
													} else {
														echo '-';
													}
												} elseif(strstr($field_arr[0], 'Attachment')) {
													if (!empty($field_arr[1]) && $field_arr[1] == 'filename') {
														echo $this->Html->showImage('Project', $project[$field_arr[0]], array('dimension' => 'normal_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false)));
													}
												} else {
													$info = '-';
												}
											?>
										<div class="col-sm-6" <?php if(!strstr($field_arr[0], 'Attachment')) {?> title="<?php if($info != '-'){ echo $this->Html->cText($info, false); } ?>"<?php } ?>>
											<?php
                                            	if(!strstr($field_arr[0], 'Attachment') && !empty($field_arr[1]) && !$field_arr[1] == 'filename') {
                                                	echo $this->Html->cText($info);
                                                }else{
                                                	echo $this->Html->cText($info);
                                                }
                                            ?>
										</div>
									</div>
									<?php if($is_reward_step && $reward_row > $reward_fields_count && !empty($project[$field_arr[0]])) { $reward_row = 1; ?>
									</div>
									<?php } ?>
									<?php } ?>
								<?php endif; ?>
							<?php } ?>
							<?php if ($is_reward && (count($project['ProjectReward']) > 1)) { ?>
								<?php for ($k=1; $k<count($project['ProjectReward']); $k++) { ?>
									<div class="reward col-sm-6">
									<h6><?php echo __l('Reward') . ' ' . ($k+1); ?></h6>
									<?php foreach($formFieldGroup['FormField'] as $formField) { ?>
										<?php $field_arr = explode('.', $formField['name']); ?>
										<div class="clearfix">
											<div class="col-sm-6 text-left" title="<?php echo $this->Html->cText($formField['label'], false); ?>"><strong><?php echo $this->Html->cText($formField['label']); ?></strong></div>
                                            <?php
                                            		$project_reward = '';
													if ($field_arr[0] == "ProjectReward"):
														if ($field_arr[2] == 'pledge_max_user_limit') {
															$project_reward = $project[$field_arr[0]][$k]['pledge_max_user_limit'];
														} else if($field_arr[2] == 'is_having_additional_info') {
															$project_reward = ($project[$field_arr[0]][$k]['is_having_additional_info'])? 'Yes': 'No';
														} else if($field_arr[2] == 'is_shipping') {
															$project_reward = ($project[$field_arr[0]][$k]['is_shipping'])? 'Yes': 'No';
														} else {
															$project_reward = $project[$field_arr[0]][$k][$field_arr[2]];
														}
													endif;
												?>
											<div class="col-sm-6" <?php if(!empty($project_reward)){ ?>title="<?php echo $this->Html->cText($project_reward, false); ?>"<?php } ?>>
												<?php if(!empty($project_reward)){ echo $this->Html->cText($project_reward); } ?>
											</div>
										</div>
									<?php } ?>
									</div>
								<?php } ?>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
	<?php } ?>
</div>
<div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>