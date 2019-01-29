<ul class="list-unstyled clearfix row">
  <?php
  $replaceArray = array(
    '##PAYMENT_SETTINGS_URL##' => Router::url(array('controller' => 'payment_gateways', 'action' => 'index', 'admin'=>true))
  );
  foreach ($setting_categories as $setting_category):
  ?>
  <li class="col-sm-6">
    <div class="well">
      <h4><?php echo $this->Html->link($this->Html->cText(__l($setting_category['SettingCategory']['name']), false), array('controller' => 'settings', 'action' => 'edit', $setting_category['SettingCategory']['id']), array('class'=>'text-info','title' => __l($setting_category['SettingCategory']['name']), 'escape' => false)); ?></h5>
      <div class="sfont js-tooltip htruncate" title="<?php echo $this->Html->cText(strtr(__l($setting_category['SettingCategory']['description']), $replaceArray), false); ?>"><?php echo strtr(__l($setting_category['SettingCategory']['description']), $replaceArray); ?></div>
    </div>
  </li>
  <?php
  endforeach;
  ?>
</ul>