<div class="nodes form admin-form new-admin-form">
  <?php echo $this->Form->create('Node', array('url' => array('controller' => 'nodes', 'action' => 'edit', $this->request->data['Node']['id'], 'admin' => true),'class' => 'form-horizontal form-maximize'));?>
  <fieldset>
    <ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contents'), array('action' => 'index'), array('title' => __l('Contents')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo __l('Edit Content');?></li>
    </ul>
  <ul class="nav nav-tabs">
    <li>
      <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'nodes', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit'); ?></a></li>
  </ul>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
      <ul class="nav nav-tabs top-space" id="myTab">
        <li class="active"><a data-toggle="tab" href="#node-main" class="js-no-pjax"><span><?php echo $this->Html->cText($type['Type']['title'], false); ?></span></a></li>
          <?php if (count($taxonomy) > 0) { ?><li><a data-toggle="tab" href="#node-terms" class="js-no-pjax"><span><?php echo __l('Terms'); ?></span></a></li><?php } ?>
          <?php if ($type['Type']['comment_status'] != 0) { ?><li><a data-toggle="tab" href="#node-comments" class="js-no-pjax"><span><?php echo __l('Comments'); ?></span></a></li><?php } ?>
        <li><a data-toggle="tab" href="#node-meta" class="js-no-pjax"><span><?php echo __l('SEO'); ?></span></a></li>
        <li><a data-toggle="tab" href="#node-publishing" class="js-no-pjax"><span><?php echo __l('Publishing'); ?></span></a></li>
        <?php echo $this->Layout->adminTabs(); ?>
      </ul>
      <div class="tab-content gray-bg clearfix admin-checkbox" id="myTabContent">
        <div id="node-main" class="tab-pane fade in active">
          <?php
            echo $this->Form->input('id');
            echo $this->Form->input('parent_id', array('type' => 'select', 'options' => $nodes, 'empty' => __l('Please Select')));
            echo $this->Form->input('title');
            echo $this->Form->input('excerpt');
          ?>
          <div class="required clearfix">
                <label class="pull-left" for="NodeBody"><?php echo __l('Body');?></label>
                <div class="input textarea col-md-5">
					<?php
						$editor_class = '';
						if (!in_array($this->request->data['Node']['id'], array(4, 16, 17, 18, 19))) {
							$editor_class = 'js-editor ';
						}
					?>
                  <?php echo $this->Form->input('body', array('class' => $editor_class . 'pull-left', 'label' => false, 'div' => false)); ?>
                </div>
              </div>
        </div>
        <?php if (count($taxonomy) > 0) { ?>
          <div id="node-terms" class="tab-pane fade">
            <?php
            $taxonomyIds = Set::extract('/Taxonomy/id', $this->data);
            foreach ($taxonomy AS $vocabularyId => $taxonomyTree) {
              echo $this->Form->input('TaxonomyData.'.$vocabularyId, array(
                'label' => $vocabularies[$vocabularyId]['title'],
                'type' => 'select',
                'multiple' => true,
                'options' => $taxonomyTree,
                'value' => $taxonomyIds,
              ));
            }
            ?>
          </div>
        <?php } ?>
        <div id="node-meta" class="tab-pane fade">
          <?php echo $this->Form->input('meta_keywords', array('label' => __l('Meta Keywords'), 'type' => 'text')); ?>
          <?php echo $this->Form->input('meta_description', array('label' => __l('Meta Description'), 'type' => 'textarea')); ?>
        </div>
        <div id="node-publishing" class="tab-pane fade">
          <?php echo $this->Form->input('status', array('label' => __l('Published'))); ?>
          <div class="input clearfix">
            <div class="js-datetime">
              <div class="js-cake-date">
                <?php echo $this->Form->input('created', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
              </div>
            </div>
          </div>
        </div>
        <?php echo $this->Layout->adminTabs(); ?>
        <div class="form-actions">
          <div class="pull-left">
            <?php
            echo $this->Form->submit(__l('Apply'), array('name' => 'apply', 'class'=>'btn btn-info')); ?>
          </div>
          <div class="pull-left">
            <?php
            echo $this->Form->submit(__l('Update'), array('name' => 'save', 'class'=>'btn btn-success'));
            ?>
          </div>
          <div class="pull-left">
            <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'nodes', 'action' => 'index'), array('title' => __l('Cancel'), 'class' => 'btn btn-default', 'escape' => false)); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>