<?php
//var_dump($filters);
echo $this->Form->create('user', array('type' => 'GET', 'url' => array_merge(array('controller' => 'users', 'action' => 'index', 'admin' => true)), 'class' => "normal userinsightform"));?>
<div class="col-xs-12 col-sm-6 col-md-4 navbar-btn sel-con">
	<?php echo $this->Form->input('User.filters', array('empty' => __l('Please Select'), 'options'=>$filters,'class' => 'form-control','label' => false, 'value'=>(!empty($this->request->params['named']['filters'])?$this->request->params['named']['filters']:'')));?>
</div>
<div class="col-xs-12 col-sm-6 col-md-4 navbar-btn sel-con">
	<?php echo $this->Form->input('User.conditions', array('empty' => __l('Please Select'), 'options'=>array('>' => 'Greater Than', '>=' => 'Greater Than or Equal To', '<' => 'Less Than', '<=' => 'Less Than or Equal To', '=' => 'Equal To'), 'label' => false, 'class' => 'form-control', 'value'=>(!empty($this->request->params['named']['conditions'])?$this->request->params['named']['conditions']:'')));
	?>
</div>
<div class="col-xs-12 col-sm-6 col-md-2 navbar-btn sel-con">
	<?php 
	echo $this->Form->input('value',array('label' => false, 'size' => '6', 'class' => 'form-control','placeholder'=>__l('Enter Value'),'value'=>(!empty($this->request->params['named']['value'])?$this->request->params['named']['value']:'')));
	?>
</div>
<div class="col-sm-6 col-md-2 navbar-btn h3">
	<?php
	echo $this->Form->button(__l('Filter'), array('type' => 'submit','class' => 'btn btn-info text-center col-xs-12 col-lg-10 fltr  btn-efcts'));?>
</div>
<?php  echo $this->Form->end();
?>