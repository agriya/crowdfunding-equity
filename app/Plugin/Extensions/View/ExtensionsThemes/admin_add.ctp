<div class="extensions-themes">
  <?php
    echo $this->Form->create('Theme', array(
      'url' => array(
        'controller' => 'extensions_themes',
        'action' => 'add',
      ),
      'type' => 'file',
    ));
  ?>
    <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Themes'), array('action' => 'index'),array('title' => __l('Themes')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo __l('Upload Theme');?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
    <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'extensions_themes', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');?></a></li>
  </ul>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">

  <?php
    echo $this->Form->input('Theme.file', array('label' => __l('Upload'), 'type' => 'file',));
  ?>
  </div>
  </div>
  <div class="clearfix">
  <div class="pull-left">
    <?php  echo $this->Form->submit(__l('Upload')); ?>
  </div>
  <div class="pull-left">
    <?php
      echo $this->Html->link(__l('Cancel'), array(
        'action' => 'index',
      ), array('class' => 'btn'));
    ?>
  </div>
  </div>
    <?php echo $this->Form->end();?>
</div>
