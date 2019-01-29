<?php /* SVN: $Id: $ */ ?>
<div class="FormFieldGroups index js-response">
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(sprintf(__l('%s Form and Groups'), Configure::read('project.alt_name_for_project_singular_caps')), array('controller' => 'project_types','action' => 'index'),array('title' => sprintf(__l('%s Form and Groups'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo;</span></li>
    <li class="active"><?php echo __l('Form Field Groups');?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
    <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'project_types', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active"><a href="#add_form"><i class="fa fa-th-list"></i><?php echo __l('Form Field Groups List');?></a></li>
    <li><?php echo $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i>'.' '.__l('Add'),array('controller' => $this->request->params['controller'], 'action'=>'add', 'type_id' => $this->params['pass'][0]),array('escape'=>false,'title' => __l('Add')));?></li>
  </ul>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">

  <section class="clearfix">
     <div class="pull-left"><?php echo $this->element('paging_counter'); ?></div>
  </section>
<section class="clearfix">
<?php echo $this->Form->create('FormFieldGroup', array( 'url' => array('action' => 'sort'),'enctype' => 'multipart/form-data'));?>
 <section class="img-thumbnail">
  <div class="row">
    <ol class="list-unstyled clearfix">
      <?php
            $k=0;
        ?>
      <div class="js-sortable-group">
       <?php if (!empty($FormFieldGroups)):?>
       <?php foreach($FormFieldGroups as $FormFieldGroup) {?>
        <div class="hide">
              <?php echo $this->Form->hidden('FormFieldGroup.'. $k .'.id', array('value' => $FormFieldGroup['FormFieldGroup']['id']));
                    $k++;
                  ?>
        </div>


          <li class="active">
          <section class="text-left cur containter-fluid accordion-toggle" data-toggle="collapse" data-target="<?php echo '.'.$FormFieldGroup['FormFieldGroup']['id'];?>">
          <div class="row">
           <div class="col-md-1 dropdown text-center pull-left">
              <a href="#" title="Actions" data-toggle="dropdown" class="fa fa-cog dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
                <ul class="list-unstyled dropdown-menu text-left clearfix">
                <li>
                <?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array( 'action'=>'edit', $FormFieldGroup['FormFieldGroup']['id'], 'type_id' => $this->params['pass'][0]), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
               </li>
               <li>
               <?php if($FormFieldGroup['FormFieldGroup']['is_deletable']){
                 echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete'), array('action'=>'delete', $FormFieldGroup['FormFieldGroup']['id']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));
              }?>
              </li>
              <?php echo $this->Layout->adminRowActions($FormFieldGroup['FormFieldGroup']['id']);  ?>
              </ul>
              </div>
            <div class="col-md-10 text-left pull-left">
            <h5><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['name'], false).' ';?></h5>
            </div>

          </div>
          </section>
         </li>
        <?php }?>
        <?php else:?>
         <li>
        <div><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Form Field Groups'));?></div>
        </li>
     </ol>
<?php
endif;?>
        </div>
        </div>
        </section>
</section>
<section class="clearfix">
<?php
if (!empty($FormFieldGroups)) : ?>
   <div class="pull-right"><?php  echo $this->element('paging_links'); ?></div>
<?php endif; ?>

  <?php echo $this->Form->end();?>
</section>
</div>
</div>
</div>
