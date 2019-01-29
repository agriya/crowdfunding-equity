<?php
  if (Configure::read('Writing.wysiwyg')) {
    $this->Html->scriptBlock($tinymce->fileBrowserCallBack(), array('inline' => false));
    $this->Html->scriptBlock($tinymce->init('NodeBody'), array('inline' => false));
  }
?>
<div class="nodes form">
  <h2><?php echo $this->Html->cText($title_for_layout, false); ?></h2>
  <?php
    echo $this->Form->create('Node', array('url' => array(
      'action' => 'translate',
      'locale' => $this->request->params['named']['locale'],
    )));
  ?>
  <fieldset>
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#node-main" class="js-no-pjax"><span><?php echo $this->Html->cText($type['Type']['title'], false); ?></span></a></li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div id="node-main" class="tab-pane fade in active">
      <?php
        foreach ($fields AS $field) {
          echo $this->Form->input('Node.'.$field);
        }
      ?>
      </div>
    </div>
  </fieldset>
  <?php echo $this->Form->end('Submit');?>
</div>