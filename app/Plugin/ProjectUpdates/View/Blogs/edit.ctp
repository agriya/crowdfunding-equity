<?php if ($request_handler == "ajax") { ?>
<div id="modal-header" class="hide">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo sprintf(__l('Edit %s Update'), Configure::read('project.alt_name_for_project_singular_caps'));?></h3>
</div>
<?php } ?>
<div class="blogs form  js-ajax-form-blog-edit-container project-up-edit marg-top-20 marg-btom-20">
  <?php if (empty($this->request->params['admin'])): ?>
    <?php if ($request_handler == "normal") { ?>
      <h2><?php echo $this->Html->cText($project['Project']['name'],false) . ' - ' . sprintf(__l('Edit %s'), sprintf(__l('%s Update'), Configure::read('project.alt_name_for_project_singular_caps')));?></h2>
    <?php } ?>
  <?php endif; ?>
  <div>
    <?php if (!empty($this->request->params['admin'])): ?>
      <ul class="breadcrumb">
        <li><?php echo $this->Html->link(sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'), array('title' => sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
        <li class="active"><?php echo sprintf(__l('Edit %s'), sprintf(__l('%s Update'), Configure::read('project.alt_name_for_project_singular_caps')));?></li>
      </ul>
      <ul class="nav nav-tabs">
        <li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'blogs', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
        <li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a></li>
      </ul>
    <?php endif; ?>
     <?php echo $this->Form->create('Blog', array('class' => 'admin-form form-horizontal js-shift-click js-no-pjax js-modal-form {responsecontainer:"js-ajax-form-blog-edit-container", refresh:"refresh" }'));?>
      <?php
        echo $this->Form->input('id');
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) :
          echo $this->Form->input('project_id', array('label' => Configure::read('project.alt_name_for_project_singular_caps')));
        else :
          echo $this->Form->input('project_id', array('type' => 'hidden'));
        endif;
        echo $this->Form->input('title', array('label' => __l('Title')));
      ?>
      <div class="required clearfix">
        <label class="pull-left" for="BlogContent"><?php echo __l('Description');?></label>
        <div class="input textarea col-md-9 no-pad marg-btom-20">
          <?php echo $this->Form->input('content', array('class' => 'js-editor col-md-4 pull-left', 'label' => false, 'div' => false)); ?>
        </div>
      </div>
      <?php echo $this->Form->input('tag', array('label' => __l('Tags'), 'type' => 'text', 'info' => __l('Separate tags with commas'))); ?>
      <div class="form-actions submit no-bor <?php echo $project['ProjectType']['slug'];  ?>"><?php echo $this->Form->submit(__l('Update'), array('name' => 'data[Blog][publish]', 'class'=> 'btn btn-info', 'div' => false)); ?>
		<div class="btn btn-danger "><a class="js-no-pjax fa-inverse" data-dismiss="modal" aria-hidden="true"><?php echo __l('Cancel');  ?></a></div>
	  </div>
      
	 
	<?php echo $this->Form->end(); ?>
  </div>
</div>