<?php /* SVN: $Id: $ */ ?>

<div>
  <ul class="breadcrumb">
  <li><?php echo $this->Html->link(sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'), array('title' => sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->cText($projectType['ProjectType']['name']);?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo __l('Pricing');?></li>
  </ul>
  <ul class="nav nav-tabs">
  <li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Form Fields'), array('controller' => 'project_types', 'action' => 'edit', $projectType['ProjectType']['id'],'type'=>'form_fields'),array('title' =>  __l('Form Fields'), 'escape' => false));?></li>
  <li class="active"><a href="#pricing"><i class="fa fa-briefcase fa-fw"></i><?php echo __l('Pricing');?></a></li>
  <li><?php echo $this->Html->link('<i class="fa fa-eye fa-fw"></i>'.__l('Preview'), array('controller' => 'project_types', 'action' => 'admin_preview', $projectType['ProjectType']['id']),array('title' =>  __l('Preview'), 'escape' => false));?></li>
  </ul>
  <div class="alert alert-info navbar-btn"><?php echo sprintf(__l('Manage listing fee and funding commision details for this %s type. You can override the details here and this will be final.'), Configure::read('project.alt_name_for_project_singular_small')); ?></div>
  <div id="pricing" class="ProjectType form admin-form"> <?php echo $this->Form->create('ProjectType', array('class' => 'form-horizontal'));?>
  <div class="clearfix">
    <div class="pull-right"><?php echo $this->Html->link('<i class="fa fa-cogs"></i> '.__l('Global Settings'), array('controller' => 'settings', 'action' => 'edit', 18), array('title' =>  __l('Global Settings'), 'escape' => false)); ?></div>
  </div>
  <fieldset>
  <?php echo $this->Form->input('id'); ?>
  <legend>
  <h3><?php echo sprintf(__l('%s Fund'), Configure::read('project.alt_name_for_project_singular_caps')); ?></h3>
  </legend>
  <?php
        echo $this->Form->input('commission_percentage', array('label' => __l('Commission Percentage'), 'after' => ' %', 'info'=>__l("Commission collected if goal reached in both Flexible and Fixed Funding")));
      ?>
  <legend>
  <h3><?php echo Configure::read('project.alt_name_for_project_singular_caps'); ?></h3>
  </legend>
  <?php
        echo $this->Form->input('listing_fee', array('id' => 'Setting198Name', 'label' => __l('Listing Fee'), 'after' => '<span id="js-listing-fee-type">' . ((empty($this->request->data['ProjectType']['listing_fee_type']) || $this->request->data['ProjectType']['listing_fee_type'] == 1) ? ' ' . Configure::read('site.currency') : ' %') . '</span>', 'info'=>__l('Listing fee for projects in the site and you can set by percentage / amount. You have to create payment step in needed project type.')));
        echo $this->Form->input('listing_fee_type', array('label' => __l('Listing Fee Type'), 'class' => 'js-fee-display {"currency":"' . Configure::read('site.currency') . '"}'));
      ?>
  </fieldset>
  <div class="form-actions navbar-btn <?php echo  $projectType['ProjectType']['slug']; ?>"> <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-info'));?> </div>
  <?php echo $this->Form->end();?> </div>
</div>
