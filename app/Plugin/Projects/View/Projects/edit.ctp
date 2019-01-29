<?php /* SVN: $Id: add.ctp 2832 2010-08-26 05:34:48Z sakthivel_135at10 $ */ ?>
<?php if (empty($this->request->params['admin'])) { ?>
	<div class="page-header no-bor">
		<span class="project-logo"><?php echo $this->Html->image($projectType['ProjectType']['slug'].'-s-icon.png'); ?></span>
		<h2 class="text-center"><span class="or-hor"><?php echo __l('Start Project');?></span></h2>
	</div>
<?php } ?>
<?php if (!empty($this->request->params['admin'])) { ?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(Configure::read('project.alt_name_for_project_plural_caps'), array('controller' => Inflector::pluralize($project['ProjectType']['slug']),'action' => 'index'),array('title' => Configure::read('project.alt_name_for_project_plural_caps')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Edit %s'), Configure::read('project.alt_name_for_project_singular_caps'));?></li>
	</ul>
	<ul class="nav nav-tabs">
		<li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'pledges', 'action' => 'index'),array('title' =>  __l('Add'), 'escape' => false));?></li>
		<li class="active"><a href="#"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a></li>
	</ul>
<?php } ?>
<?php if (!empty($rejected_info)) { ?>
	<div class="alert alert-error clearfix">
		<div><?php echo $rejected_info; ?></div>
	</div>
<?php } ?>
<?php
	if (!empty($FormFieldSteps)) {
		$total_span = 23.6;
		$current_step = $this->request->data['Project']['form_field_step'];
		$span_class = 'span' . floor($total_span/$total_form_field_steps);
		if ($projectType['ProjectType']['id'] == ConstProjectTypes::Equity && isPluginEnabled('SeisScheme') && $this->Auth->user('role_id') == ConstUserTypes::Admin) {
			if($current_step == 1 && empty($this->request->params['named']['seis'])) {
				$current_step = 0;
			}
			$span_class = 'span' . floor($total_span/($total_form_field_steps+1));
		}
		$step = 0;
		$form_class = "form-maximize";
?>
	<div class="clearfix <?php echo $projectType['ProjectType']['slug']; ?>">
		<div class="img-thumbnail text-center clearfix">
			<div class="row step-block row show-grid text-center">
				<?php if ($projectType['ProjectType']['id'] == ConstProjectTypes::Equity && isPluginEnabled('SeisScheme') && $this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
					<span class="text-center <?php echo $span_class; ?>">
						<span class="badge <?php echo ($current_step == 0)?'badge-module':''; ?>">0</span>
						<span class="show <?php echo ($current_step == 0)?'successc':''; ?>"><strong><?php echo $this->Html->link(__l('SEIS'), array('controller' => 'projects', 'action' => 'edit', $this->request->data['Project']['id'], 0), array('class' => 'successc')); ?></strong></span>
					</span>
				<?php } ?>
				<?php foreach($FormFieldSteps as $FormFieldStep) { ?>
					<?php
						$FormFieldStep = $FormFieldStep['FormFieldStep'];
						$step++;
						$link_class = ($current_step == $FormFieldStep['order'])?'successc':'';
					?>
					<span class="text-center <?php echo $span_class; ?>">
						<span class="badge <?php echo ($current_step == $FormFieldStep['order'])?'badge-module':''; ?>"><?php echo $step; ?></span>
						<span class="show <?php echo $link_class;  ?>"><strong>
							<?php
								if(!empty($this->request->data['Project']['is_restrict_steps'])) {
									 echo $this->Html->cText($FormFieldStep['name'], false);
								} else {
									echo $this->Html->link($FormFieldStep['name'], array('controller' => 'projects', 'action' => 'edit', $this->request->data['Project']['id'], $FormFieldStep['order']), array('class' => $link_class));
								}
							?>
						</strong></span>
					</span>
    <?php 
								if($current_step == $FormFieldStep['order'] && $FormFieldStep['name'] == "Payment"){
									$form_class= "";
								 }
								}
							?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($projectType['ProjectType']['id'] == ConstProjectTypes::Equity && isPluginEnabled('SeisScheme') && empty($current_step) && $this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
	<?php echo $this->element('seis_edit', array('cache' => array('config' => 'sec')), array('plugin' => 'SeisScheme')); ?>
<?php } else { ?>
	<?php
		
		if (!empty($is_payment_step) && !empty($this->request->data['Project']['id'])) {
			echo $this->element('project_pay_now', array('project_type' => $projectType['ProjectType']['slug'], 'page' => 'edit', 'cache' => array('config' => 'sec')), array('plugin' => 'Projects'));
		} 
	?>
	<div class="<?php echo $projectType['ProjectType']['slug']; ?>">
		<?php
			echo $this->Form->create('Project', array('url' => array('controller' => 'projects', 'action'=> 'edit', $this->request->data['Project']['id']), 'class' => 'form-horizontal js-project-form clearfix', 'enctype' => 'multipart/form-data'));
			echo $this->Form->input('project_type_id', array('type' => 'hidden', 'label' => __l('Private')));
			echo $this->Form->input('project_type_slug', array('type' => 'hidden'));
			echo $this->Form->input('submission_id', array('type' => 'hidden'));
			echo $this->Form->input('Project.latitude', array('id' => 'latitude', 'type' => 'hidden'));
			echo $this->Form->input('Project.longitude', array('id' => 'longitude', 'type' => 'hidden'));
			echo $this->Form->hidden('Project.form_field_step');
			if (!empty($this->request->data['Project']['id'])){
				echo $this->Form->hidden('Project.id');
			} else {
				echo $this->Form->input('id', array('type' => 'hidden'));
			}
		?>
		<div class="clearfix <?php echo $form_class;?> edit-form">
			<?php foreach($FormFieldSteps as $FormFieldStep) { ?>
				<?php
					if ($this->request->data['Project']['form_field_step'] != $FormFieldStep['FormFieldStep']['order']):
						continue;
					endif;
					$is_splash = 0;
					if (!empty($FormFieldStep['FormFieldStep']['is_splash'])) {
						$is_splash = 1;
				?>
				<div class="alert alert-success">
					<?php echo $this->Html->cHtml(__l($FormFieldStep['FormFieldStep']['additional_info'])); ?>
				</div>
				<?php
						break;
					} else {
				?>
			<div>
			<?php if (!empty($FormFieldStep['FormFieldGroup'])) { ?>
				<?php foreach($FormFieldStep['FormFieldGroup'] as $temp_FormFieldGroup) { ?>
					<?php
						$FormFieldGroup['FormFieldGroup'] = $temp_FormFieldGroup;
						$FormFieldGroup['FormField'] = $temp_FormFieldGroup['FormField'];
					?>
					<div>
						<div class="img-thumbnail">
							<h4><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['name'], false); ?></h4>
							<?php if (!empty($FormFieldGroup['FormFieldGroup']['info'])) { ?>
								<div class="alert alert-info clearfix"><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['info'], false);?></div>
							<?php } ?>
							<?php if($FormFieldGroup['FormFieldGroup']['id'] == 'Media Files') { ?>
								<?php if (!empty($project_media)) { ?>
									<dl class="attachment-list">
										<dt></dt>
										<dd>
											<?php
												$project_media = array();
												foreach($project_media as $key => $media) {
													if (!empty($media['filename'])) {
														echo $this->Html->cText($media['filename']).'<p class="delete-block">'.$this->Html->link(__l('delete'), array('action' => 'delete_attachment', $this->request->data['Project']['id'],$this->request->data['Project']['project_type_id'],$media['id'],$media['foreign_id'],'admin'=>false) , array('class'=>'js-confirm delete','escape' => false))."</p>";
													}
												}
											?>
										</dd>
									</dl>
								<?php } ?>
							<?php } ?>
							<?php
								foreach($FormFieldGroup['FormField'] as $key => $FormField) {
									if ($FormField['type'] == 'multiselect') {
										$FormFieldGroup['FormField'][$key]['type'] = 'select';
										$FormFieldGroup['FormField'][$key]['multiple'] = 'multiple';
									}
									$FormFieldGroup['FormField'][$key]['display'] = 1;
									$FormFieldGroup['FormField'][$key]['is_reward'] = 0;
									$_data = explode('.', $FormField['name']);
									if ($_data[0] == 'ProjectReward') {
										$FormFieldGroup['FormField'][$key]['is_reward'] = 1;
										if ($_data[2] == 'reward') {
											$FormFieldGroup['FormField'][$key]['reward'] = 1;
										}
										if ($_data[2] == 'is_shipping') {
											$FormFieldGroup['FormField'][$key]['is_shipping'] = 1;
										}
										if ($_data[2] == 'estimated_delivery_date') {
											$FormFieldGroup['FormField'][$key]['estimated_delivery_date'] = 1;
										}
										if ($_data[2] == 'is_having_additional_info') {
											$FormFieldGroup['FormField'][$key]['is_having_additional_info'] = 1;
										}
										if ($_data[2] == 'additional_info_label') {
											$FormFieldGroup['FormField'][$key]['additional_info_label'] = 1;
										}
										$FormFieldGroup['FormField'][$key]['is_reward_end'] = 1;
										if(isset($reward_end_key)) {
											$FormFieldGroup['FormField'][$reward_end_key]['is_reward_end'] = 0;
										}
										$reward_end_key = $key;
									}
									if ($FormField['name'] == 'Lend.credit_score_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $creditScores;
									} elseif ($FormField['name'] == 'Lend.loan_term_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $loanTerms;
									} elseif ($FormField['name'] == 'Lend.repayment_schedule_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $repaymentSchedules;
									}
									if(!empty($projectTypeFormFields['FormField'][$key]['options'])) {
										$FormFieldGroup['FormField'][$key]['options'] = $projectTypeFormFields['FormField'][$key]['options'];
									}
									if($FormField['name'] == 'Project.payment_method_id') {
										$field_name_arr = explode('.',$FormField['name']);
										$field_name = str_replace('_id', '', $field_name_arr[1]);
										$singular = Inflector::camelize($field_name);
										$plural = Inflector::singularize($singular);
										$FormFieldGroup['FormField'][$key]['options'] = $paymentMethods;
										$FormFieldGroup['FormField'][$key]['info'] = sprintf(__l('If you select Fixed Funding %s fund will be captured only if it reached the needed amount. If you select Flexible Funding %s fund will be captured even if it does not reached the needed amount'), Configure::read('project.alt_name_for_project_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
										if (Configure::read('Project.is_project_owner_select_funding_method')) {
											$FormFieldGroup['FormField'][$key]['display'] = 1;
										} else {
											$FormFieldGroup['FormField'][$key]['display'] = 0;
										}
									}
									$pledge_flag = 1;
									if (empty($this->request->data['ProjectReward'])) {
										if (count($pledgeTypes) > 1) {
											$info = implode(', ',$pledgeTypes);
											$pledge_type_val = array_keys($pledgeTypes, Configure::read('Project.is_pledge_default_type'));
											$selected_pledge_val = (!empty($this->request->data['Project']['pledge_type_id'])) ? $this->request->data['Project']['pledge_type_id'] : $pledge_type_val[0];
										} else {
											$pledge_flag = 0;
										}
									} else {
										if (count($pledgeTypes) == 1) {
											$pledge_flag = 0;
										}
									}
									if ($FormField['name'] == 'Pledge.pledge_type_id' || $FormField['name'] == 'Donate.pledge_type_id') {
										if (!empty($pledge_flag)) {
											$FormFieldGroup['FormField'][$key]['options'] = $pledgeTypes;
											$FormFieldGroup['FormField'][$key]['attributes_arr']['class'] = "js-pledge-type";
										} else {
											$FormFieldGroup['FormField'][$key]['display'] = 0;
										}
									}
									if ($FormField['name'] == 'Pledge.pledge_project_category_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $pledgeCategories;
									}
									if ($FormField['name'] == 'Donate.donate_project_category_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $donateCategories;
									}
									if ($FormField['name'] == 'Lend.lend_project_category_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $lendCategories;
									}
									if ($FormField['name'] == 'Equity.equity_project_category_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $equityCategories;
									}
									if (($FormField['name'] == 'Pledge.min_amount_to_fund' || $FormField['name'] == 'Donate.min_amount_to_fund') && $is_disable_pledge_type_amount) {
										if (empty($pledge_flag)) {
											$FormFieldGroup['FormField'][$key]['display'] = 0;
										}
									}
									if ($FormField['name'] == 'Project.country_id') {
										$FormFieldGroup['FormField'][$key]['options'] = $countries;
									}
									if (!empty($project_media[$FormField['name']])) {
										$FormFieldGroup['FormField'][$key]['Attachment']=$project_media[$FormField['name']]['Attachment'];
									}
								}
								echo $this->Cakeform->insert($FormFieldGroup);
							?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<?php  if (!empty($is_payout_step)) {
						if(!empty($_SESSION['response_for_connect'])) {
							?>
							 <div class="alert alert-success">
							  <?php echo __l('Gateway connected successfully. Waiting for notification from payment gateway. Will refresh the page in 60 seconds...'); ?>
							 </div>
							 <?php $redirect_url=Router::url('/',true).$this->request->url;?>
							 <meta http-equiv="refresh"  content="60;url=<?php echo $redirect_url; ?>" />

							<?php }
						echo $this->element('sudopay_user_accounts', array('project' => $this->request->data['Project']['id'], 'step' => $current_form_step, 'user' => $project['User']['id'], 'from_action' => 'edit', 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
						}
					?>
		</div>
	<?php } } ?>
</div>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->request->data['Project']['form_field_step'] == $total_form_field_steps): ?>
	<div class="project-form-content admin-actions">
		<div class="img-thumbnail">
			<legend><?php echo __l('Admin actions'); ?></legend>
			<div class="clearfix">
				<?php
					echo $this->Form->input('is_active', array('label' => __l('Active')));
					echo $this->Form->input('is_featured', array('label' => __l('Featured')));
				?>
			</div>
		</div>
	</div>
<?php endif;?>
<?php if(empty($is_payment_step) && empty($is_splash)) { ?>
	<div class="well ">
		<div class="row">
			<?php if(!empty($this->request->data['Project']['is_draft'])): ?>
				<div class="pull-left draft"><div class="submit"><?php echo $this->Form->submit(__l('Draft'), array('name' => 'data[Project][draft]', 'div' => false, 'class' => 'btn btn-primary'));?></div></div>
			<?php endif; ?>
			<div class="row offset6">
			<?php if ($this->request->data['Project']['form_field_step'] != 1): ?>
				<div class="pull-left"><?php echo $this->Html->link(__l('Back'), array('controller' => 'projects', 'action' => 'edit', $this->request->data['Project']['id'], $this->request->data['Project']['form_field_step']-1), array('class' => 'btn')); ?></div>
			<?php endif; ?>
			<?php if ($this->request->data['Project']['form_field_step'] != $total_form_field_steps): ?>
				<div class="pull-left"><div class="submit <?php echo  $projectType['ProjectType']['slug']; ?>"><?php echo $this->Form->submit(__l('Next'), array('name' => 'data[Project][next]', 'div' => false, 'class' => 'btn btn-primary' )); ?></div></div>
			<?php elseif(empty($this->request->data['Project']['is_draft'])): ?>
				<div class="pull-left"><div class="submit <?php echo  $projectType['ProjectType']['slug']; ?>"><?php echo $this->Form->submit(__l('Update'), array('name' => 'data[Project][publish]', 'div' => false, 'class' => 'btn btn-primary'));?></div></div>
			<?php else: ?>
				<div class="pull-left"><div class="submit <?php echo  $projectType['ProjectType']['slug']; ?>"><?php echo $this->Form->submit(__l('Create'), array('name' => 'data[Project][publish]', 'div' => false, 'class' => 'btn btn-primary'));?></div></div>
			<?php endif; ?>
			<div class="pull-left">
				<?php
					if ($this->Auth->user('role_id') == ConstUserTypes::Admin):
						echo $this->Html->link(__l('Cancel'), array('controller' => 'projects', 'action' => 'index', 'project_type' => $projectType['ProjectType']['slug']), array('title' => __l('Cancel'), 'class' => 'btn js-tooltip'));
					else:
						echo $this->Html->link(__l('Cancel'), array('controller' => 'projects', 'action' => 'myprojects'), array('title' => __l('Cancel'), 'class' => 'btn js-tooltip', 'escape' => false));
					endif;
				?>
			</div>
			</div>
		</div>
	</div>
<?php } ?>
	<?php echo $this->Form->end();?>
 </div>
<?php } ?>