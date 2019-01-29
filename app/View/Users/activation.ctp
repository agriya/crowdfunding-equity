<div class="page-header">
  <h2><?php echo __l('Activate your account'); ?></h2>
</div>
  <?php if(!empty($show_resend)): ?>
  <div class="alert alert-info">
    <?php echo sprintf(__l('You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.'), $this->Html->link(__l('click here'), $resend_url)); ?>
  </div>
  <?php endif; ?>
