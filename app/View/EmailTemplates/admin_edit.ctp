<div class="js-responses">
  <h2><?php echo $this->Html->cText($this->request->data['EmailTemplate']['name'], false); ?></h2>
  <?php
    echo $this->Form->create('EmailTemplate', array('id' => 'EmailTemplateAdminEditForm'.$this->request->data['EmailTemplate']['id'], 'class' => 'form-horizontal img-thumbnail show gray-bg js-shift-click js-no-pjax js-insert js-ajax-form', 'action' => 'edit'));
    echo $this->Form->input('id');
    echo $this->Form->input('from', array('id' => 'EmailTemplateFrom'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
    echo $this->Form->input('reply_to', array('id' => 'EmailTemplateReplyTo'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
    echo $this->Form->input('subject', array('class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->request->data['EmailTemplate']['id']));
	echo $this->Form->input('email_text_content');
  ?>
  <div class="required input textarea clearfix">
    <label for="EmailTemplateEmailHTMLContent"><?php echo __l('Email HTML Content');?></label>    
      <?php echo $this->Form->input('email_html_content', array('class' => 'col-md-7', 'label' => false, 'div' => false)); ?>    
  </div>
  <div class="form-actions navbar-btn"><?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info')); ?></div>
  <?php echo $this->Form->end(); ?>
</div>