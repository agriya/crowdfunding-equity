<?php
  if (!empty($users)):
  $i = 1;
  $count = count($users);
?>
<p><i class="fa fa-facebook-square facebookc"></i><?php echo ' ' . sprintf(__l('%s users have connected using Facebook'), $totalUserCount); ?></p>
<?php foreach($users as $user) { ?>
  <?php if ($i == 1 || $i == 7) { ?>
  <div>
    <ul class="col-md-3 list-unstyled social-avatar">
  <?php } ?>
    <li><?php echo $this->Html->getUserAvatar($user['User'], 'micro_thumb', true, '', 'facebook'); ?></li>
  <?php if ($i == 6 || $i == $count) { ?>
    </ul>
  </div>
  <?php } ?>
  <?php $i++; ?>
<?php } ?>
<?php
  endif;
?>