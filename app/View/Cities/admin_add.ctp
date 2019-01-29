<div class="admin-form">
<?php /* SVN: $Id: admin_add.ctp 1456 2010-04-28 08:53:26Z vinothraja_091at09 $ */ ?>
<?php echo $this->Form->create('City', array('class' => 'form-horizontal form-large-fields','action'=>'add'));?>
<fieldset class="admin-checkbox">
  <ul class="breadcrumb">
    <li>
      <?php echo $this->Html->link(__l('Cities'), array('action' => 'index'),array('title' => __l('Cities')));?><span class="divider">&raquo</span></li>
    <li class="active">
      <?php echo sprintf(__l('Add %s'), __l('City'));?>
    </li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
      <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'cities', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active">
      <a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a>
    </li>
  </ul>
   <div class="panel-container gray-bg"> 
    <div id="add_form" class="tab-pane fade in active">
      <?php
		echo $this->Form->input('country_id', array('label' => __l('Country'),'empty'=> __l('Please Select')));
		echo $this->Form->autocomplete('State.name', array('id' => 'js-state-id', 'label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255')); 
        echo $this->Form->input('name', array('label'=> __l('Name')));
        echo $this->Form->input('latitude', array('label'=> __l('Latitude')));
        echo $this->Form->input('longitude', array('label'=> __l('Longitude')));
        echo $this->Form->input('timezone', array('label'=> __l('Timezone')));
        echo $this->Form->input('county', array('label'=> __l('County')));
        echo $this->Form->input('code', array('label'=> __l('Code')));
        echo $this->Form->input('is_approved', array('label' =>__l('Approved?')));
      ?>
    </div>
	 <div class="form-actions">    
	<?php echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-info'));?>	
   </div>
   </div>
  
<?php echo $this->Form->end;?>
</fieldset>
</div>