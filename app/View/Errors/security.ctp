<?php $title_for_layout = __l('Page not found'); ?>
<h2><?php echo __l('Security Error'); ?></h2>
<div class="alert alert-error">
  <?php echo __l('The requested address was not found on this server.'); ?>
</div>
<?php if (Configure::read('debug') > 0): ?>
<div class="alert alert-info">
  Request blackholed due to "<?php echo $type; ?>" violation.
</div>
<?php endif; ?>
<?php Configure::write('debug', 0); ?>