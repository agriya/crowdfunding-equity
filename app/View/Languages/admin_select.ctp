<div class="languages">
  <h2><?php echo $this->Html->cText($title_for_layout, false); ?></h2>
  <div>
    <ul>
      <li><?php echo $this->Html->link(sprintf(__l('Add %s'), __l('Language')), array('action'=>'add')); ?></li>
    </ul>
  </div>
  <?php
    foreach ($languages AS $language) {
      $title = $language['Language']['title'] . ' (' . $language['Language']['native'] . ')';
      $link = $this->Html->link($title, array(
        'controller' => 'translate',
        'action' => 'edit',
        $id,
        $modelAlias,
        'locale' => $language['Language']['alias'],
      ));
      echo '<h3>' . $link . '</h3>';
    }
  ?>
</div>