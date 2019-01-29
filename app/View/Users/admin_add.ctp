<div class="admin-form">
<?php /* SVN: $Id: admin_add.ctp 1456 2010-04-28 08:53:26Z vinothraja_091at09 $ */ ?>
<?php echo $this->Form->create('User', array('class' => 'form-horizontal form-large-fields'));?>
<fieldset>
  <ul class="breadcrumb">
  <li><?php echo $this->Html->link(__l('Users'), array('action' => 'index'), array('title' => __l('Users')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo __l('Add User');?></li>
  </ul>
  <ul class="nav nav-tabs">
  <li>
  <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'users', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
  </li>
  <li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');?></a></li>
  </ul>
  <div class="panel-container top-space gray-bg">
  <div id="add_form" class="tab-pane fade in active">
  <?php
  echo $this->Form->input('role_id', array('label' => __l('Role')));
  echo $this->Form->input('email', array('label' => __l('Email')));
  echo $this->Form->input('username', array('label' => __l('Username')));
  echo $this->Form->input('passwd', array('label' => __l('Password')));
  ?>
  </div>
  <div id="list_form" class="tab-pane fade in active">
  </div>  
  <div class="form-actions">
  <?php echo $this->Form->submit(__l('Add'), array('class'=>'btn btn-info'));?>	  
</div>
</div>
</fieldset>
 <?php echo $this->Form->end();?>
</div>