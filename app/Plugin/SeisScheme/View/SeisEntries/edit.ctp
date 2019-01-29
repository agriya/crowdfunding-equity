  <div class="equity">
    <?php echo $this->Form->create('SeisEntry', array('class' => 'form-horizontal')); ?>
		<div>
		<div class="img-thumbnail clearfix">
		<div class="pull-left">
      <?php 
	  echo $this->Form->input('id');
	  echo $this->Form->input('project_id',array('type' => 'hidden'));
      echo $this->Form->input('company_name');
	  echo $this->Form->input('number_of_employees',array('label' => __l('Number of Employees'))); ?>
	   <div class="input date-time clearfix">
          <div class="js-datetime">
          <div class="js-cake-date">
            <?php echo $this->Form->input('year_of_founding', array('label' => __l('Year Founded'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-200, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select') , 'info' => __l('The year your company was founded'))); ?>
          </div>
          </div>
       </div>
	   <?php echo $this->Form->input('total_asset',array('label' => __l('Total Asset ($)'))); ?>
	   </div>
	   </div>
	   </div>
	       <div class="clearfix">
      <div class="well form-actions">
        <div class="offset3">
	  <?php  echo $this->Form->submit(__l('Update'), array('class' => 'btn-primary')); ?>
	</div>
	</div>
    <?php echo $this->Form->end(); ?>
	</div>
  </div>