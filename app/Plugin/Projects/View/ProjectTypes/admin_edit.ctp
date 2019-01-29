<div class="project-type">
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps')), array('action' => 'index'), array('title' => sprintf(__l('%s Types'), Configure::read('project.alt_name_for_project_singular_caps'))));?><span class="divider">&raquo</span></li>
    <li><?php echo $this->Html->cText($projectType['ProjectType']['name']);?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo __l('Form Fields');?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#add_form"><i class="fa fa-th-list fa-fw"></i><?php echo __l('Form Fields');?></a></li>
    <li><?php echo $this->Html->link('<i class="fa fa-briefcase fa-fw"></i>'.__l('Pricing'), array('controller' => 'project_types', 'action' => 'admin_pricing', $this->request->data['ProjectType']['id']),array('title' =>  __l('Pricing'), 'escape' => false));?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-eye fa-fw"></i>'.__l('Preview'), array('controller' => 'project_types', 'action' => 'admin_preview', $this->request->data['ProjectType']['id']),array('title' =>  __l('Preview'), 'escape' => false));?></li>
  </ul>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
      <div>
        <p class="alert alert-warning navbar-btn"><?php echo sprintf(__l('Warning! please edit with caution. Changes in the form fields affect the existing %s also.'), Configure::read('project.alt_name_for_project_singular_small'));?></p>
        <p class="alert alert-info"><?php echo sprintf(__l('Label is the text that appears in the form for Project. Display Text is the text that appears in project view page. e.g., If Label is "Explain About Your Project", Display will be "About Project" or so.'));?></p>
      </div>
      <div class="text-right hor-space"><?php echo $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i>' . ' ' . __l('Add Step'), array('controller' => 'form_field_steps', 'action' => 'add', 'type_id' => $this->request->data['ProjectType']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'js-no-pjax', 'escape' => false, 'title' => __l('Add Step'))); ?></div>
      <?php echo $this->Form->create('ProjectType', array('action' => 'edit')); ?> <?php echo $this->Form->hidden('id'); ?>
        <section class="show">
          <div>
            <?php $j = $k = $n = 0; ?>
            <div class="js-sortable-step">
              <?php foreach($FormFieldSteps as $FormFieldStep) { ?>
                <ol class="list-unstyled list-group-item no-pad">
                  <li class="active">
                    <div class="js">
                      <div class="hide">
                      <?php
                        echo $this->Form->hidden('FormFieldStep.'. $n .'.id', array('value' => $FormFieldStep['FormFieldStep']['id']));
                        $n++;
                      ?>
                      </div>
                    </div>
                    <section class="text-left cur containter-fluid accordion-toggle project-type-gropdown" data-toggle="collapse" data-target="<?php echo '.form-field-step-' .  $FormFieldStep['FormFieldStep']['id'];?>">
                      <div class="clearfix">
                        <div class="col-xs-1 text-left"><h4 class="top-mspace-xs"><i class="fa fa-arrows"></i></h4></div>
                        <div class="col-sm-9 col-xs-8 text-left">
                          <h5 class="top-mspace-xs"><?php echo $this->Html->cText($FormFieldStep['FormFieldStep']['name']);?><span class="sfont"><?php echo !empty($FormFieldStep['FormFieldStep']['info']) ? ' - ' . $this->Html->cText($FormFieldStep['FormFieldStep']['info']) : ''; ?></span></h5>
                        </div>
                        <div class="col-xs-2 text-right">
                          <div class="dropdown pull-right"> 
						  <a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Settings</span><i class="caret"></i></a>
                          <ul class="dropdown-menu right-mspace dropdown-menu-right">
                            <?php if (!empty($FormFieldStep['FormFieldStep']['is_deletable'])) { ?>
                              <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-times"></i> '.__l('Delete'), array('controller'=>'form_field_steps','action' => 'delete', 'type_id' => $this->request->data['ProjectType']['id'], $FormFieldStep['FormFieldStep']['id']), array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete'))) . '</span>'; ?></li>
                            <?php } ?>
							 <?php if (empty($FormFieldStep['FormFieldStep']['is_splash']) && (empty($FormFieldStep['FormFieldStep']['is_payment_step'])) && (empty($FormFieldStep['FormFieldStep']['is_payout_step']))) { ?>
                            <li><span class="show accordion-toggle ver-space ver-mspace btn" data-toggle="expand" data-target="<?php echo '.form-field-step-' . $FormFieldStep['FormFieldStep']['id'];?>"><i class="fa fa-arrows-v cur fa-fw"></i><?php echo __l('Expand/Collapse');?></span></li>
                            <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i> '.__l('Add New Group'), array('controller' => 'form_field_groups', 'action'=>'add', 'type_id' => $this->request->data['ProjectType']['id'], 'step_id' => $FormFieldStep['FormFieldStep']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => ' js-no-pjax', 'id' => 'addFieldLink', 'escape' => false, 'title' => __l('Add New Group'))) . '</span>';?></li>
							<?php } ?>
                            <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i> '.__l('Edit Step'), array('controller' => 'form_field_steps', 'action'=>'edit', $FormFieldStep['FormFieldStep']['id'],$this->request->data['ProjectType']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => ' js-no-pjax', 'id' => 'addFieldLink', 'escape' => false, 'title' => __l('Edit Step'))) . '</span>';?></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </section>
                  <section class="collapse img-thumbnail no-rad ver-space <?php echo 'form-field-step-' . $FormFieldStep['FormFieldStep']['id'];?> com-bg over-hide">
                    <div class="accordion-inner bot-space bot-mspace-xs">
					<?php if(empty($FormFieldStep['FormFieldStep']['is_splash'])) { ?>
                      <div class="clearfix">
                        <div class="text-right navbar-btn"><?php echo $this->Html->link('<i class="fa fa-plus-circle"></i>' . ' ' . __l('Add Group'), array('controller' => 'form_field_groups', 'action' => 'add', 'type_id' => $this->request->data['ProjectType']['id'], 'step_id' => $FormFieldStep['FormFieldStep']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'js-no-pjax', 'escape' => false, 'title' => __l('Add Group'))); ?></div>
                      </div>                     
                        <section>
                          <?php if(empty($FormFieldStep['FormFieldGroup'])) { ?>
                            <div class="alert alert-danger no-mar"><?php echo __l('No Groups Added.'); ?></div>
                          <?php } ?>                          
                            <div class="js-sortable-group">
                              <?php foreach($FormFieldStep['FormFieldGroup'] as $temp_FormFieldGroup) { ?>
                                <?php
                                  $FormFieldGroup['FormFieldGroup'] = $temp_FormFieldGroup;
                                  $FormFieldGroup['FormField'] = $temp_FormFieldGroup['FormField'];
                                ?>
                                <ol class="list-unstyled list-group-item no-pad">
                                  <li class="active">
                                    <div class="js">
                                      <div class="hide"><?php
                                        echo $this->Form->hidden('FormFieldGroup.'. $k .'.id', array('value' => $FormFieldGroup['FormFieldGroup']['id']));
                                        $k++;
                                      ?>
                                      </div>
                                    </div>
                                    <section class="text-left cur containter-fluid accordion-toggle project-type-gropdown" data-toggle="collapse" data-target="<?php echo '.form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?>">
                                      <div class="clearfix">
                                        <div class="col-xs-1 text-center"><h4 class="top-mspace-xs"><i class="fa fa-arrows"></i></h4></div>
                                          <div class="col-sm-9 col-xs-8 text-left">
                                            <h5 class="top-mspace-xs"><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['name']);?><span class="sfont grayc h6"><?php echo !empty($FormFieldGroup['FormFieldGroup']['info']) ? ' - ' . $this->Html->cText($FormFieldGroup['FormFieldGroup']['info']) : ''; ?></span></h5>
                                          </div>
                                          <div class="col-xs-2 text-right">
                                            <div class="dropdown pull-right">
                                              <a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Settings</span><i class="caret"></i></a>
                                              <ul class="dropdown-menu">
                                                <?php if (!empty($FormFieldGroup['FormFieldGroup']['is_deletable'])) { ?>
                                                  <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-times pull-left fa-fw"></i> '.__l('Delete'), array('controller'=>'form_field_groups','action' => 'delete', $FormFieldGroup['FormFieldGroup']['id']), array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete'))) . '</span>'; ?></li>
                                                <?php } ?>
                                                <li><span class="show accordion-toggle ver-space ver-mspace btn" data-toggle="expand" data-target="<?php echo '.form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?>"><i class="fa fa-arrows-v cur fa-fw"></i><?php echo __l('Expand/Collapse');?></span></li>
                                                <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-plus-circle fa-fw pull-left cur"></i> '.__l('Add New Field'), array('controller' => 'form_fields', 'action'=>'add', $this->request->data['ProjectType']['id'],'group_id' => $FormFieldGroup['FormFieldGroup']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => ' js-no-pjax', 'id' => 'addFieldLink', 'escape' => false, 'title' => __l('Add New Field'))) . '</span>';?></li>
                                                <li><?php echo '<span>' . $this->Html->link('<i class="fa fa-pencil-square-o fa-fw pull-left cur"></i> '.__l('Edit Group'), array('controller' => 'form_field_groups', 'action'=>'edit', $FormFieldGroup['FormFieldGroup']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => ' js-no-pjax', 'id' => 'addFieldLink', 'escape' => false, 'title' => __l('Edit Group'))) . '</span>';?></li>
                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </section>
                                      <section class="collapse <?php echo 'form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?> com-bg over-hide">
                                        <div class="accordion-inner js-sortable">
                                          <?php if (!empty($FormFieldGroup['FormField'])) { ?>
										  <div class="table-responsive mspace">
                                            <table class="table table-bordered table-striped table-condensed admin-form">
                                              <thead>
                                                <?php echo $this->Html->tableHeaders(array(__l('Label'), __l('Display Text'), __l('Type'), __l('Info'), __l('Required'), __l('Editable'), __l('Active'),''));?>
                                              </thead>
                                              <tbody>
                                                <?php
                                                  if (!empty($FormFieldGroup['FormField'])) {
                                                    $i = 1;
                                                    foreach($FormFieldGroup['FormField'] as $key => $field) {
                                                      echo $this->element('form_field_row', array('key' => $j, 'field' => $field, 'multiTypes' => $multiTypes, 'cache' => array('config' => 'sec')));
                                                      $j++;
                                                    }
                                                  } else {
                                                    echo sprintf(__l('No %s available'), __l('Fields'));
                                                  }
                                                ?>
                                              </tbody>
                                            </table>
										   </div>
                                          <?php } ?>
                                        </div>
                                      </section>
                                    </li>
                                  </ol>
                                <?php } ?>
                              </div>                            
                          </section>                        
         			<?php } else { ?>					
                        <section class="thumbnail top-mspace">
                          <?php if(!empty($FormFieldStep['FormFieldStep']['additional_info'])) { ?>
						  <div class="alert alert-success no-mar"><?php echo $this->Html->cText(__l($FormFieldStep['FormFieldStep']['additional_info'])); ?></div>
						  <?php } ?>
						</section>
					<?php } ?>					 
                    </section>
                  </li>
                </ol>
              <?php } ?>
            </div>
          </div>
        </section>
        <div class="form-actions hor-space pull-right <?php echo  $projectType['ProjectType']['slug']; ?>"> <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-info'));?> </div>
        <?php echo $this->Form->end();?>
        <div class="modal fade" id="js-ajax-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					  <div class="modal-body">
						<?php
							echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loading]'), 'title' => __l('Loading')));
							echo __l('Loading...');
						?>
					  </div>
					  <div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
				</div>
			</div>
		</div>
      </div>   
  </div>
</div>
<div class="modal fade" id="js-edit-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h2><?php echo __l('Depends On'); ?></h2>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
		</div>
	</div>
</div>