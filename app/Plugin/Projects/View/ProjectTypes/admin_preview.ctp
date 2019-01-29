<div class="project-preview new-admin-form admin-form col-xs-12 <?php echo $projectType['ProjectType']['slug'];?>">
<ul class="breadcrumb">
  <li><?php echo $this->Html->link(sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'), array('class'=>'text-danger','title' => sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->cText($projectType['ProjectType']['name']);?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo __l('Preview');?></li>
</ul>
<ul class="nav nav-tabs">
  <li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Form Fields'), array('controller' => 'project_types', 'action' => 'edit', $projectType['ProjectType']['id'],'type'=>'form_fields'),array('title' =>  __l('Form Fields'), 'escape' => false));?></li>
  <li><?php echo $this->Html->link('<i class="fa fa-briefcase fa-fw"></i>'.__l('Pricing'), array('controller' => 'project_types', 'action' => 'admin_pricing', $projectType['ProjectType']['id']),array('title' =>  __l('Pricing'), 'escape' => false));?></li>
  <li class="active"><a href="#preview"><i class="fa fa-eye fa-fw"></i><?php echo __l('Preview');?></a></li>
</ul>
<?php
  if(!empty($FormFieldSteps)) {
    $total_span = 23.6;
    $current_step = $this->request->data['Form']['form_field_step'];
    $span_class = 'span' . floor($total_span/$total_form_field_steps);
    $step = 0;
?>
<div class="navbar-btn">
  <div class="text-center">
    <ul class="list-inline clearfix navbar-btn step-block marg-top-30">
    <?php
      foreach($FormFieldSteps as $FormFieldStep) {
        $FormFieldStep = $FormFieldStep['FormFieldStep'];
        $step++;
        $link_class = ($current_step == $step)?'successc':'';
    ?>
      <li class="<?php echo ($current_step == $step)?'active':''; ?>">
        <span class="badge <?php echo ($current_step == $step)?'badge-module':''; ?>"><?php echo $step; ?></span>
        <span class="show text-16 text-info top-space <?php echo $link_class;  ?>">
          <?php echo $this->Html->link($FormFieldStep['name'], array('controller' => 'project_types', 'action' => 'preview', $projectType['ProjectType']['id'], $FormFieldStep['order']), array('class' => 'text-info')); ?>		
		</span>
      </li>
    <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>
<div id="preview" class="ProjectType form">
  <div class="clearfix">
  <?php
    echo $this->Form->create('ProjectType', array('url' => array('controller' => 'project_types', 'action'=> 'preview', $projectType['ProjectType']['id'], $this->request->data['Form']['form_field_step']+1), 'class' => 'form-horizontal clearfix','enctype' => 'multipart/form-data'));
    foreach($FormFieldSteps as $FormFieldStep) {
  ?>
  <?php
      if ($this->request->data['Form']['form_field_step'] != $FormFieldStep['FormFieldStep']['order']):
        continue;
      endif;
  ?>
  <?php
      foreach($FormFieldStep['FormFieldGroup'] as $key => $temp_FormFieldGroup) {
        if(isset($FormFieldGroup['FormField'][0]['name'])) {
            $_data = explode('.', $FormFieldGroup['FormField'][0]['name']);
            if ($_data[0] == 'ProjectReward' && !isPluginEnabled('ProjectRewards')) {
              unset($FormFieldGroups[$key]);
            }
          }
        }
        echo $this->Form->input('user_id', array('type' => 'hidden'));
        echo $this->Form->input('Pledge.id', array('type' => 'hidden'));
      ?>
  <?php if ($FormFieldStep['FormFieldGroup']) { ?>
  <?php foreach($FormFieldStep['FormFieldGroup'] as $temp_FormFieldGroup) { ?>
  <?php
    $FormFieldGroup['FormFieldGroup'] = $temp_FormFieldGroup;
    $FormFieldGroup['FormField'] = $temp_FormFieldGroup['FormField'];
  ?>
  <fieldset>
    <div class="admin-checkbox">
    <h4 class="text-b"><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['name'], false); ?></h4>
    <?php if (!empty($FormFieldGroup['FormFieldGroup']['info'])) { ?>
    <div class="alert alert-info clearfix"> <?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['info'], false);?> </div>
    <?php } ?>
    <?php
                foreach($FormFieldGroup['FormField'] as $key => $FormField) {
                  $FormFieldGroup['FormField'][$key]['display'] = 1;
                  $FormFieldGroup['FormField'][$key]['is_reward'] = 0;
                  $_data = explode('.', $FormField['name']);
                  if ($_data[0] == 'ProjectReward') {
                    $FormFieldGroup['FormField'][$key]['is_reward'] = 1;
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
                  }
                  if ($FormField['name'] == 'Project.payment_method_id') {
                    $field_name_arr = explode('.', $FormField['name']);
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
                  if (count($pledgeTypes) > 1) {
                    $info = implode(', ',$pledgeTypes);
                    $pledge_type_val = array_keys($pledgeTypes, Configure::read('Project.is_pledge_default_type'));
                    $selected_pledge_val = (!empty($this->request->data['Project']['pledge_type_id'])) ? $this->request->data['Project']['pledge_type_id'] : $pledge_type_val[0];
                  } else {
                    $pledge_flag = 0;
                  }
                  if ($FormField['name'] == 'Pledge.pledge_type_id' || $FormField['name'] == 'Donate.pledge_type_id') {
                    if (!empty($pledge_flag)) {
                      $FormFieldGroup['FormField'][$key]['options'] = $pledgeTypes;
                      $FormFieldGroup['FormField'][$key]['selected'] = $selected_pledge_val;
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
                  if ($FormField['name'] == 'Project.country_id') {
                    $FormFieldGroup['FormField'][$key]['options'] = $countries;
                  }
                }
                echo $this->Cakeform->insert($FormFieldGroup);
              ?>
    </div>
  </fieldset>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  <hr/>
  <div class="hor-space navbar-btn form-actions ">
    <div class="clearfix">   
	  <?php if ($this->request->data['Form']['form_field_step'] != 1): ?>
        <div class="pull-left"><?php echo $this->Html->link(__l('Back'), array('controller' => 'project_types', 'action' => 'preview', $projectType['ProjectType']['id'], $this->request->data['Form']['form_field_step']-1), array('class' => 'btn btn-success')); ?></div>
      <?php endif; ?>	
      <?php if ($this->request->data['Form']['form_field_step'] != $total_form_field_steps): ?>
        <div class="pull-right <?php echo  $projectType['ProjectType']['slug']; ?>"><?php echo $this->Html->link(__l('Next'), array('controller' => 'project_types', 'action' => 'preview', $projectType['ProjectType']['id'], $this->request->data['Form']['form_field_step']+1), array('class' => 'btn btn-info')); ?></div>
      <?php endif; ?>
	  
	  
    </div>
  </div>
  <?php echo $this->Form->end();?> </div>
</div>
