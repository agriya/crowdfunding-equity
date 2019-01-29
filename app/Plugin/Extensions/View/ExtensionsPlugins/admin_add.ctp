<div class="extensions-plugins">
   <?php
    echo $this->Form->create('Plugin', array(
      'class' => 'form-horizontal',
      'url' => array(
        'controller' => 'extensions_plugins',
        'action' => 'add',
      ),
      'type' => 'file',
    ));
  ?>
  <fieldset>
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Plugins'), array('action' => 'index'),array('title' => __l('Plugins')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo __l('Upload Plugin');?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
    <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'extensions_plugins', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a></li>
  </ul>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
  <?php
    echo $this->Form->input('Plugin.file', array('label' => __l('Upload'), 'type' => 'file',));
  ?>
  </div>
  </div>
  </fieldset>
  <div class="clearfix">
    <div class="pull-left">
    <?php echo $this->Form->submit(__l('Upload')); ?></div>
    <div class = "pull-left" >
        <?php
        echo $this->Html->link(__l('Cancel'), array(
          'action' => 'index',
        ), array(
          'class' => 'btn',
        ));
        ?>
    </div>
  </div>
     <?php echo $this->Form->end(); ?>
</div>