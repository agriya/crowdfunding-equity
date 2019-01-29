<div class="page-header"><h2><?php echo $this->pageTitle; ?></h2></div>
<div class="clearfix">
  <div class="img-thumbnail main-section">
  <?php echo $this->Form->create('Subscription', array('action' => 'invite_friends', $this->request->data['User']['id'], 'class' => "form-horizontal text-left clearfix"));?>
<?php
  if(!empty($this->request->data['User']['remining_invite']) || empty($is_limited)) {
?>
  <fieldset class="clearfix">
    <?php if(!empty($is_limited)): ?>
    <div class="alert alert-warning">
      <?php echo sprintf(__l('You have %s remaining invites'), $this->request->data['User']['remining_invite']);?>
    </div>
    <?php endif; ?>
    <div>
    <?php
      echo $this->Form->input('invite_emails',array('type' => 'textarea', 'label'=>__l('Enter your friends email'), 'id' => 'invite_emails', 'info' => __l('Enter friends email with comma seperated.')));
    ?>
    </div>
  </fieldset>
  <div class="form-actions"><?php echo $this->Form->submit(__l('Invite Friends'));?></div>
  <?php echo $this->Form->end(); ?>
  </div>
<?php
  } else {
?>
  <div class="alert alert-error"><?php echo __l('You have no remaining invites'); ?></div>
<?php
  }
?>
</div>