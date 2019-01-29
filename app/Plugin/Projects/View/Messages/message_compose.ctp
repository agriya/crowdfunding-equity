<div class="messages index">
  <?php if (empty($ajax_view)) { ?>
    <h3 class="title"><?php echo __l('Compose') ;?></h3>
  <?php } ?>
  <div class="js-colorbox-response main-section admin-form gray-bg">
    <?php
      $redirect = Router::url(array('controller' => 'users', 'action' => 'view', $this->request->data['Message']['to']), true);
      echo $this->Form->create('Message', array('class' => ' form-horizontal  {"redirect_url":"'.$redirect.'"}', 'enctype' => 'multipart/form-data', 'url' => array('controller' => 'messages', 'action' => 'compose', 'type' => 'contact', 'to' => $this->request->params['named']['to'], 'admin' => false)));
    ?>
    <div class="clearfix input">
      <label class="col-md-2"><?php echo __l('From');?></label>
      <p class="navbar-btn">
        <?php echo $this->Html->link($this->Html->cText($this->Auth->user('username')), array('controller'=> 'users', 'action' => 'view', $this->Auth->user('username')), array('title' => $this->Html->cText($this->Auth->user('username'),false),'escape' => false)); ?>
      </p>
    </div>
    <div class="clearfix input">
      <label class="col-md-2"><?php echo __l('To');?></label>
      <p class="navbar-btn">
        <?php echo !empty($this->request->data['Message']['to']) ? $this->Html->link($this->Html->cText($this->request->data['Message']['to']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to']), array('title' => $this->Html->cText($this->request->data['Message']['to'],false),'escape' => false)) : ''; ?>
      </p>
    </div>
    <?php
      echo $this->Form->input('to', array('type' => 'hidden'));
      echo $this->Form->input('message_type', array('type' => 'hidden', 'value' => 1));
      echo $this->Form->input('redirect_url', array('type' => 'hidden', 'value' => $redirect));
      echo $this->Form->input('subject', array('type' => 'text'));
      echo $this->Form->input('message', array('type' => 'textarea', 'class' => 'col-md-4 marg-btom-20'));
    ?>
    <div class="submit-block clearfix navbar-btn">
      <?php echo $this->Form->submit(__l('Send'), array('class' => 'btn btn-info pull-left js-without-subject js-no-pjax')); ?>
      <div class="cancel-block pull-left"><?php echo $this->Html->link(__l('Cancel'), $redirect, array('class' => 'btn', 'title' => __l('Cancel'), 'class' => 'btn')); ?></div>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
