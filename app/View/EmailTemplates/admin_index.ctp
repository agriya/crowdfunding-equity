  <?php
    if(!empty($this->request->params['isAjax'])):
      echo $this->element('flash_message');
    endif;
  ?>
  <?php if (!empty($emailTemplates)): ?>
    <div class="email-template-block navbar-btn" id="accordion-admin-email-template">
      <?php foreach ($emailTemplates as $emailTemplate): ?>
        <?php $url= Router::url(array('controller' => 'email_templates', 'action' => 'edit', $emailTemplate['EmailTemplate']['id']),true);?>
        <div class="thumbnail list-group-item-text navbar-btn clearfix">
           <div class="col-xs-12">
          <h6 class="navbar-btn"><a class="accordion-toggle js-accordion-link js-toggle-icon js-no-pjax {'url':'<?php echo $url;?>','data_id':'<?php echo $emailTemplate['EmailTemplate']['id'];?>'}" href="#email-content-<?php echo $emailTemplate['EmailTemplate']['id'];?>" data-parent="#accordion-admin-email-template" data-toggle="collapse"> <strong> <?php echo $this->Html->cText($emailTemplate['EmailTemplate']['name'], false).' - '. '</strong> <span class="sfont"><span>'.$this->Html->cText($emailTemplate['EmailTemplate']['description'], false).'</span></span>'; ?><i class="fa fa-plus-circle fa-lg pull-right"></i></a></h6>
          </div>
          <div id="email-content-<?php echo $this->Html->cInt($emailTemplate['EmailTemplate']['id'], false);?>"  class="col-xs-12 accordion-body collapse">
          <div class="admin-form accordion-inner js-content-<?php echo $this->Html->cInt($emailTemplate['EmailTemplate']['id'], false);?>"> </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p><?php echo __l('No e-mail templates added yet.'); ?></p>
  <?php endif; ?>