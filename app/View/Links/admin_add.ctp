<div class="links form">
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Menus'), array('controller' => 'menus', 'action' => 'index'),array('title' => __l('Menus')));?><span class="divider">&raquo</span></li>
    <li><?php echo $this->Html->link(__l('Links'), array('action' => 'index'), array('title' => __l('Links')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo sprintf(__l('Add %s'), __l('Link'));?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
      <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Menus'), array('controller' => 'menus', 'action' => 'index'),array('title' =>  __l('Menus'), 'escape' => false));?>
    </li>
    <li>
      <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Links'), array('action' => 'index', $menuId),array('title' =>  __l('Links'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active">
      <a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');?></a>
    </li>
  </ul>
  <?php echo $this->Form->create('Link', array('class' => 'form-horizontal', 'url' => array('controller' => 'links', 'action' => 'add', $menuId)));?>
  <fieldset>
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#link-basic" class="js-no-pjax"><span><?php echo __l('Link'); ?></span></a></li>
      <li><a data-toggle="tab" href="#link-misc" class="js-no-pjax"><span><?php echo __l('Misc.'); ?></span></a></li>
      <?php echo $this->Layout->adminTabs(); ?>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div id="link-basic" class="tab-pane fade in active">
        <?php
          echo $this->Form->input('menu_id', array('value' => $menuId, 'empty' => __l('Please Select'), 'type' => 'hidden'));
          echo $this->Form->input('parent_id', array('label' => __l('Parent'), 'options' => $parentLinks, 'empty' => __l('Please Select')));
          echo $this->Form->input('title');
          echo $this->Form->input('link');
        ?>
        <div class="clearfix info">
          <?php echo $this->Html->link('<i class="fa fa-plus-circle"></i>'. __l(' Link to a Node'), Router::url(array('controller' => 'nodes', 'action' => 'index', 'links' => 1), true), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'','id'=>'', 'escape' => false, 'title' => __l('Link to a Node'))); ?>
        </div>
        <?php echo $this->Form->input('status', array('label' => __l('Publish?'))); ?>
      </div>
      <div id="link-misc" class="tab-pane fade">
        <?php
          echo $this->Form->input('class', array('class' => 'slug'));
          echo $this->Form->input('description', array('type' => 'text', 'label' => __l('Tooltip')));
          echo $this->Form->input('rel');
          echo $this->Form->input('target');
        ?>
      </div>
      <?php echo $this->Layout->adminTabs(); ?>
    </div>
    <div class="form-actions">
      <?php echo $this->Form->submit(__l('Save')); ?>
      <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $menuId), array('title' => __l('Cancel'), 'class' => 'btn', 'escape' => false)); ?>
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h2><?php echo __l('Link to a Node'); ?></h2>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
			<a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
			</div>
		</div>
	</div>
</div>