<div class="terms form">
<ul class="breadcrumb">
  <li><?php echo $this->Html->link(__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
  <li><?php echo $this->Html->link(__l('Terms'), array('action' => 'index',$vocabularyId),array('title' => __l('Terms')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Term'));?></li>
  </ul>
  <ul class="nav nav-tabs">
  <li>
  <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Vocabularies'), array('controller' => 'vocabularies', 'action' => 'index'),array('title' =>  __l('Vocabularies'), 'escape' => false));?>
  </li>
  <li>
  <?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('Vocabulary'), array('action' => 'index', $vocabularyId),array('title' =>  __l('Vocabulary'),'data-target'=>'#list_form', 'escape' => false));?>
  </li>
  <li class="active"><a href="#add_form"><i class="fa fa-pencil-square-o fa-fw"></i><?php echo __l('Edit');?></a></li>
  </ul>
  <?php echo $this->Form->create('Term', array('url' => array('controller' => 'terms', 'action' => 'edit', $this->request->data['Term']['id'], $vocabularyId))); ?>
  <fieldset>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('Taxonomy.parent_id', array('options' => $parentTree, 'empty' =>  __l("Please Select")));
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    ?>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Update')); ?>
    <div class="cancel-block">
    <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $vocabularyId), array('class'=>'btn')); ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>