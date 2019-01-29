<?php /* SVN: $Id: add.ctp 2832 2010-08-26 05:34:48Z sakthivel_135at10 $ */ 
if(empty($this->request->params['admin'])){
?>
<div class="container">
<?php } ?>
<div class="js-response project-add col-xs-12">
<?php
	if(!empty($this->request->params['named']['step'])) {
		$this->request->data['Project']['step'] = $this->request->params['named']['step'];
	}
?>
<?php if (!empty($rejected_info)) { ?>
	<div class="alert alert-error clearfix">
		<div><?php echo $rejected_info; ?></div>
	</div>
<?php } ?>
<?php
if(isset($_SESSION['post_action'])) {
		$page = $_SESSION['post_action'];
}
if(empty($this->request->data['Project']['form_field_step'])) { 
	$this->request->data['Project']['form_field_step']='0';
}
	if(!empty($FormFieldSteps)) {
		$total_span = 23.6;
		$current_step = $this->request->data['Project']['form_field_step'];
		$span_class = 'span'.floor($total_span/$total_form_field_steps);
		$step = 0;
		$form_class = "form-maximize";
		$is_payout_step = $FormFieldSteps[$current_step]['FormFieldStep']['is_payout_step'];
		$is_payment_step = $FormFieldSteps[$current_step]['FormFieldStep']['is_payment_step'];
		$is_splash = $FormFieldSteps[$current_step]['FormFieldStep']['is_splash'];
?>
	<div class="clearfix">
		<h3><?php echo $page_title;?></h3>
		<div class="text-center clearfix navbar-btn">
			<ul class="step-block list-inline navbar-btn clearfix <?php echo $projectType['ProjectType']['slug']; ?>">
				<?php 
					foreach($FormFieldSteps as $step_key => $FormFieldStep) {
						$FormFieldStep = $FormFieldStep['FormFieldStep'];
						$step++;
				?>
					<li class="<?php echo ($current_step == $step_key)?'active':''; ?>">
						<span class="badge <?php echo ($current_step == $step_key)?'badge-module':''; ?>"><?php echo $step; ?></span>
						<span class="show no-mar text-info text-16 top-space <?php echo ($current_step == $step_key)?'successc':''; ?>"><?php echo $this->Html->cText(__l($FormFieldStep['name']), false); ?></span>
					</li>
				<?php 
				if($current_step == $step_key && $FormFieldStep['name'] == "Payment"){
					$form_class= "";
				 }
				} ?>
			</ul>
		</div>
	</div>
<?php } ?>
<div class="projects js-responses admin-form new-admin-form <?php echo $form_class;?>">
	<?php if (!empty($this->request->params['admin'])) { ?>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(Configure::read('project.alt_name_for_project_plural_caps'), array('controller' => Inflector::pluralize($projectType['ProjectType']['slug']),'action' => 'index'),array('class'=>'text-danger','title' => Configure::read('project.alt_name_for_project_plural_caps')));?><span class="divider">&raquo;</span></li>
			<?php if($this->request->params['action'] == 'edit' || $_SESSION['post_action'] == 'edit'){ ?>
				<li class="active"><?php echo sprintf(__l('Edit %s'), Configure::read('project.alt_name_for_project_singular_caps'));?></li>
			<?php } else {?>
				<li class="active"><?php echo sprintf(__l('Add %s'), Configure::read('project.alt_name_for_project_singular_caps'));?></li>
			<?php } ?>
		</ul>
		<ul class="nav nav-tabs">  
			<li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => Inflector::pluralize($projectType['ProjectType']['slug']), 'action' => 'index'), array('title' =>  __l('List'), 'escape' => false));?></li>
			<?php if($this->request->params['action'] == 'edit' || $_SESSION['post_action'] == 'edit'){ ?>
				<li class="active"><a href="#"><i class="fa fa-pencil fa-fw"></i><?php echo __l('Edit'); ?></a></li>
			<?php } else {?>
				<li class="active"><a href="#"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php
		if (!empty($is_payment_step) && !empty($this->request->data['Project']['id'])) {
			echo $this->element('project_pay_now', array('project_type' => $projectType['ProjectType']['slug'], 'page' => 'add', 'cache' => array('config' => 'sec')), array('plugin' => 'Projects'));
		} 
	?>
	<div class="navbar-btn clearfix">
		<?php
			echo $this->Form->create('Project', array('url' => array('controller' => 'projects', 'action'=> $page, 'project_type' => $project_type_slug), 'class' => 'form-horizontal js-project-form edit-form clearfix','enctype' => 'multipart/form-data'));
			echo $this->Form->input('step', array('value' => '2', 'type' => 'hidden'));
			echo $this->Form->input('project_type_id',array('value' => $projectType['ProjectType']['id'], 'type' => 'hidden'));
			echo $this->Form->input('project_type_slug',array('value' => $projectType['ProjectType']['slug'], 'type' => 'hidden'));
			echo $this->Form->input('Project.latitude', array('id' => 'latitude', 'type' => 'hidden'));
			echo $this->Form->input('Project.longitude', array('id' => 'longitude', 'type' => 'hidden'));
			echo $this->Form->hidden('Project.form_field_step');
			if (!empty($this->request->data['Project']['id'])):
				echo $this->Form->hidden('Project.id');
			endif;
			if(!empty($this->request->data['Project']['step']) && $this->request->data['Project']['step'] == 1 && $projectType['ProjectType']['slug'] == 'equity'):
		?>
		<p class="row text-center"> <span><?php echo __l('Have your company listed in AngelList?'); ?></span>
			<?php
				if ($userProfile['User']['is_angellist_connected']) {
					echo $this->Html->link($this->Html->image('import-angellist.png', array('alt' => __l('Import from AngelList'))), array('controller' => 'equities', 'action' => 'import_startups'), array('escape' => false,'class' => "js-connect js-no-pjax" ));
				} else {
					$url = Router::url(array( 'controller' => 'social_marketings',
						'action' => 'import_friends',
						'type' =>'angellist',
						'import' => 'angellist',
						'from' => 'social',
						'admin' => false)
					, true);
					echo $this->Html->link($this->Html->image('import-angellist.png'), '#', array('title' => 'Facebook', 'escape' => false,'class' => "js-connect js-no-pjax",'data-url' => $url));
				}
			?>
			</p>
		<?php endif; ?>
		<fieldset class="admin-checkbox">
		<div class="clearfix">
			<?php foreach($FormFieldSteps as $step_key => $FormFieldStep) { ?>
				<?php
					if ($this->request->data['Project']['form_field_step'] != $step_key):
						continue;
					endif;
					$is_splash = 0;
					if (!empty($FormFieldStep['FormFieldStep']['is_splash'])) {
						$is_splash = 1;
				?>
					<div class="alert alert-success"><?php echo $this->Html->cHtml(__l($FormFieldStep['FormFieldStep']['additional_info'])); ?></div>
				<?php
						break;
					} else {
				?>			
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				echo $this->Form->input('Pledge.id', array('type' => 'hidden'));
			?>
			<?php if (!empty($FormFieldStep['FormFieldGroup'])) { ?>
				<?php foreach($FormFieldStep['FormFieldGroup'] as $temp_FormFieldGroup) { ?>
					<?php
						$FormFieldGroup['FormFieldGroup'] = $temp_FormFieldGroup;
						$FormFieldGroup['FormField'] = $temp_FormFieldGroup['FormField'];
					?>					
						<div class="navbar-btn">
							<h4 class="text-18"><?php echo $this->Html->cText(__l($FormFieldGroup['FormFieldGroup']['name']), false); ?></h4>
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
									<?php if (!empty($FormFieldGroup['FormFieldGroup']['info'])) { ?>
										<div class="alert alert-info clearfix">
											<?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['info'], false);?>
										</div>
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
											} elseif ($FormField['name'] == 'Project.payment_method_id') {
												$field_name_arr = explode('.', $FormField['name']);
												$field_name = str_replace('_id', '', $field_name_arr[1]);
												$singular = Inflector::camelize($field_name);
												$plural = Inflector::singularize($singular);
												$FormFieldGroup['FormField'][$key]['options'] = $paymentMethods;
												if (!empty($FormFieldGroup['FormField'][$key]['info'])) {
													if (!is_null($projectType['ProjectType']['commission_percentage'])) {
														$reached_fee = $projectType['ProjectType']['commission_percentage'];
													} else {
														$reached_fee = Configure::read('Project.fund_commission_percentage');
													}
													$infoFindReplace = array(
														'##REACHED_FEE_AMOUNT##' => $reached_fee,
													);
													$FormFieldGroup['FormField'][$key]['info'] = strtr($FormFieldGroup['FormField'][$key]['info'], $infoFindReplace);
												} else {
													$FormFieldGroup['FormField'][$key]['info'] = sprintf(__l('If you select Fixed Funding %s fund will be captured only if it reached the needed amount. If you select Flexible Funding %s fund will be captured even if it does not reached the needed amount'), Configure::read('project.alt_name_for_project_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
												}
												if (Configure::read('Project.is_project_owner_select_funding_method')) {
													$FormFieldGroup['FormField'][$key]['display'] = 1;
												} else {
													$FormFieldGroup['FormField'][$key]['display'] = 0;
												}
											}

											$pledge_flag = 2;
											if (count($pledgeTypes) > 1) {
												$info = implode(', ',$pledgeTypes);
												$pledge_type_val = array_keys($pledgeTypes, Configure::read('Project.is_pledge_default_type'));
												$selected_pledge_val = (!empty($this->request->data['Project']['pledge_type_id'])) ? $this->request->data['Project']['pledge_type_id'] : $pledge_type_val[0];
											} else {
												$pledge_flag = 0;
											}
											if ($FormField['name'] == 'Pledge.pledge_type_id' || $FormField['name'] == 'Donate.pledge_type_id') {
												if (!empty($pledge_flag)and $pledge_flag == 2) {
													$FormFieldGroup['FormField'][$key]['options'] = $pledgeTypes;
													$FormFieldGroup['FormField'][$key]['selected'] = $selected_pledge_val;
												} elseif(!empty($pledge_flag) and $pledge_flag == 1) {
													$FormFieldGroup['FormField'][$key]['type']='hidden';
													$FormFieldGroup['FormField'][$key]['default']=$selected_pledge_val;
												} else {
													$FormFieldGroup['FormField'][$key]['display'] = 0;
												}
											}
											if ($FormField['name'] == 'Pledge.pledge_project_category_id') {
												$FormFieldGroup['FormField'][$key]['options'] = $pledgeCategories;
											} elseif ($FormField['name'] == 'Donate.donate_project_category_id') {
												$FormFieldGroup['FormField'][$key]['options'] = $donateCategories;
											} elseif ($FormField['name'] == 'Lend.lend_project_category_id') {
												$FormFieldGroup['FormField'][$key]['options'] = $lendCategories;
											} elseif ($FormField['name'] == 'Equity.equity_project_category_id') {
												$FormFieldGroup['FormField'][$key]['options'] = $equityCategories;
											} elseif ($FormField['name'] == 'Project.country_id') {
												$FormFieldGroup['FormField'][$key]['options'] = $countries;
											} elseif (($FormField['name'] == 'Pledge.min_amount_to_fund' || $FormField['name'] == 'Donate.min_amount_to_fund') && $is_disable_pledge_type_amount) {
												unset($FormFieldGroup['FormField'][$key]);
											}
											if (!empty($project_media[$FormField['name']])) {
												$FormFieldGroup['FormField'][$key]['Attachment']=$project_media[$FormField['name']]['Attachment'];
											}
										}
										echo $this->Cakeform->insert($FormFieldGroup);
									?>
								</div>	
								<hr/>	
						<?php } ?>
					<?php }
						if (!empty($is_payout_step)) {
								echo $this->element('sudopay_user_accounts', array('project' => $this->request->data['Project']['id'], 'step' => $current_step, 'user' => $this->request->data['Project']['user_id'], 'from_action' => 'add', 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
						}
					?>				
			<?php } ?>
		<?php } ?>
		<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->request->data['Project']['form_field_step'] == $total_form_field_steps): ?>
			<div class="project-form-content admin-actions">
				<div class="navbar-btn">
					<legend><?php echo __l('Admin actions'); ?></legend>
					<div class="clearfix">
						<?php
							echo $this->Form->input('is_active',array('label'=>__l('Active')));
							echo $this->Form->input('is_featured',array('label'=>__l('Featured')));
						?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if(empty($is_payment_step) && empty($is_splash)) { ?>
			<div class="clearfix navbar-btn hor-space form-actions">				
				<div class="pull-left draft "><?php echo $this->Form->submit(__l('Draft'), array('class' => 'btn btn-danger', 'name' => 'data[Project][draft]', 'div' => false));?></div>
					<div class="pull-right no-pad">
						<?php if ($this->request->data['Project']['form_field_step'] != 0): ?>
							<div class="pull-left right-mspace"><?php echo $this->Html->link(__l('Back'), array('controller' => 'projects', 'action' => $page, 'project_type' => $project_type_slug, $this->request->data['Project']['id'], $this->request->data['Project']['form_field_step']-1), array('class' => 'btn btn-success')); ?></div>
						<?php endif; ?>
						<?php if ($this->request->data['Project']['form_field_step'] != ($total_form_field_steps-1)): ?>
							<div class="pull-left <?php echo $projectType['ProjectType']['slug']; ?> "><?php echo $this->Form->submit(__l('Next'), array('class' => 'btn btn-info pull-left', 'name' => 'data[Project][next]', 'div' => false)); ?>
							<?php if(!empty($is_payout_step)){ ?>
								<?php if(empty($connected_gateways) && isPluginEnabled('Wallet')){ ?>
									<div class="pull-right <?php echo $projectType['ProjectType']['slug']; ?> "><?php echo	$this->Form->submit(__l('Skip'), array('class' => 'btn btn-info pull-left', 'name' => 'data[Project][next]', 'div' => false)); ?>
									<i class='fa fa-info-circle sfont js-tooltip xltriggered top-space' title='<?php echo sprintf( __l('If you skip, %s will be saved in draft mode. You should update payout settings in your accounts page to enable it.'), Configure::read('project.alt_name_for_project_singular_caps'));?>'></i>
								<?php }?>
							<?php }?>
							</div>  
						<?php else: ?>
							<?php if($page == 'add'){ ?>
								<div class="pull-left <?php echo $projectType['ProjectType']['slug']; ?> "><?php echo $this->Form->submit(__l('Create'), array('class' => 'btn btn-info', 'name' => 'data[Project][publish]', 'div' => false));?></div>
							<?php } else { ?>
								<div class="pull-left <?php echo $projectType['ProjectType']['slug']; ?> "><?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-info', 'name' => 'data[Project][publish]', 'div' => false));?></div>
							<?php } ?>
						<?php endif; ?>
					</div> 
				</div>				
			</div>   
		<?php } ?>	
		<?php echo $this->Form->end();?>
	</div>
	</fieldset>
</div>
</div>
</div>
<?php
if(empty($this->request->params['admin'])){
?>
</div>
<?php } ?>
