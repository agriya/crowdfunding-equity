  <div class="notify-email js-no-pjax">
  <span><?php echo __l("Notify me through Email"); ?></span>
  <?php echo $this->Form->create('User'); ?>
  <?php echo $this->Form->input('is_send_activities_mail', array('legend' => false, 'type' => 'radio', 'options' => array( __l('Yes'), __l('No')),'div'=>false, 'class'=>'js-notify-mail', 'label' => 'fhfh'));?>
  <?php echo $this->Form->end();?>
  </div>
