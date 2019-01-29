<div class="menus form admin-form">
  <?php echo $this->Form->create('Menu', array('url' => array('controller' => 'menus', 'action' => 'edit', 'admin' => true),'class' => 'form-horizontal')); ?>
  <fieldset>
    <ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Menus'), array('action' => 'index'), array('title' => __l('Menus')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Menu'));?></li>
    </ul>
    <ul class="nav nav-tabs">
      <li>
        <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'menus', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
      </li>
      <li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit');?></a></li>
    </ul>
    <div class="panel-container">
      <div id="add_form" class="tab-pane fade in active gray-bg clearfix">
        <div id="menu-basic" class="clearfix">
          <?php
            echo $this->Form->input('id');
            echo $this->Form->input('title');
            echo $this->Form->input('alias');
          ?>
        </div>
        <div class="form-actions">
          <div class = "pull-left" >
            <?php echo $this->Form->submit(__l('Update') , array('class'=>'btn btn-info')); ?>
          </div>
          <div class = "pull-left" >
            <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'menus', 'action' => 'index'), array('title' => __l('Cancel'), 'class' => 'btn', 'escape' => false)); ?>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>