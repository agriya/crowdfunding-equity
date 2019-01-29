<?php if ($request_handler == "ajax") { ?>
<div id="modal-header" class="hide">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo sprintf(__l('Add %s Update'), Configure::read('project.alt_name_for_project_singular_caps'));?></h3>
</div>
<?php } ?>
<div class="blogs form js-ajax-form-blog-container project-up-add marg-top-20 marg-btom-20">
  <?php if (empty($this->request->params['admin'])): ?>
  <?php if ($request_handler == "normal") { ?>
    <h2><?php echo $this->Html->cText($project['Project']['name'],false) . ' - ' . sprintf(__l('Add %s'), sprintf(__l('%s Update'), Configure::read('project.alt_name_for_project_singular_caps')));?></h2>
    <?php } ?>
  <?php endif; ?>
  <div>
    <?php echo $this->Form->create('Blog', array('class' => 'form-horizontal admin-form js-modal-form-blog-add {responsecontainer:"js-ajax-form-blog-container", refresh:"refresh" }')); ?>
      <?php if (!empty($this->request->params['admin'])): ?>
        <ul class="breadcrumb">
          <li><?php echo $this->Html->link(sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'), array('title' => sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
          <li class="active"><?php echo sprintf(__l('Add %s'), sprintf(__l('%s Update'), Configure::read('project.alt_name_for_project_singular_caps')));?></li>
        </ul>
        <ul class="nav nav-tabs">
          <li><?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'blogs', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
          <li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add');?></a></li>
        </ul>
      <?php endif; ?>
      <?php
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
      <?php echo $this->Form->input('tag', array('label'=> __l('Tags'),'info' => __l('Separate tags with commas'))); ?>
      <div class="form-actions no-bor submit <?php echo !empty($project['ProjectType']['slug']) ? $project['ProjectType']['slug'] : ''; ?>"><?php  echo $this->Form->submit(__l('Publish'), array('name' => 'data[Blog][publish]', 'class' => 'btn btn-info', 'div' => false)); ?> </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>

<div class="modal fade">
</div>