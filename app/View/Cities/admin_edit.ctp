<?php /* SVN: $Id: admin_edit.ctp 1456 2010-04-28 08:53:26Z vinothraja_091at09 $ */ ?>
<div class="admin-form">
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link(__l('Cities'), array('action' => 'index'), array('title' => __l('Cities')));?>
			<span class="divider">&raquo</span>
		</li>
		<li class="active">
			<?php echo sprintf(__l('Edit %s'), __l('City'));?>
		</li>
	</ul>
	<ul class="nav nav-tabs">
		<li>
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'cities', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
		</li>
		<li class="active">
			<a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a>
		</li>
	</ul>
	<fieldset>
		<div class="panel-container gray-bg admin-checkbox">
			<div id="add_form" class="tab-pane fade in active">
				<?php
					echo $this->Form->create('City', array('class' => 'form-horizontal clearfix form-large-fields','action'=>'edit'));
					echo $this->Form->input('id');
					echo $this->Form->input('country_id', array('label' => __l('Country'), 'empty' => __l('Please Select')));
					echo $this->Form->autocomplete('State.name', array('id' => 'js-state-id', 'label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255')); 
					if (!empty($id_default_city)) {
					  echo $this->Form->input('name',array('label' => __l('Name'), 'readonly' => true, 'info' => __l('You can not change default city name.')));
					} else {
					  echo $this->Form->input('name',array('label' => __l('Name')));
					}
					echo $this->Form->input('latitude', array('label'=> __l('Latitude')));
					echo $this->Form->input('longitude', array('label'=> __l('Longitude')));
					echo $this->Form->input('timezone', array('label'=> __l('Timezone')));
					echo $this->Form->input('county', array('label'=> __l('County')));
					echo $this->Form->input('code', array('label'=> __l('Code')));
					if(Configure::read('site.city') != $this->request->data['City']['slug']):
					  echo $this->Form->input('is_approved', array('label' =>__l('Approved?')));
					endif;
				?>
				<div class="form-actions">
					<?php echo $this->Form->end(array('class'=>'btn btn-info'),__l('Update'));?>
				</div>				
			</div>
		</div>
    </fieldset>
</div>