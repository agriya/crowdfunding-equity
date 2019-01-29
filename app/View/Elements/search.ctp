<?php
  $b = $block['Block'];
  $class = 'block block-' . $b['alias'];
  if ($block['Block']['class'] != null) {
    $class .= ' ' . $b['class'];
  }
?>
<div id="block-<?php echo $this->Html->cInt($b['id'], false); ?>" class="<?php echo $class; ?>">
    <?php if ($b['show_title'] == 1) { ?>
        <h3><?php echo $this->Html->cText($b['title'], false); ?></h3>
    <?php } ?>
  <div class="well">
    <form id="searchform" method="post" action="javascript: document.location.href=''+Cms.basePath+'search/q:'+encodeURI($('#searchform #q').val());">
      <?php
        $qValue = null;
        if (isset($this->request->params['named']['q'])) {
          $qValue = $this->request->params['named']['q'];
        }
        echo $this->Form->input('q', array(
          'label' => false,
          'name' => 'q',
          'value' => $qValue,
        ));
        echo $this->Form->submit(__l('Search'));
      ?>
    </form>
  </div>
</div>