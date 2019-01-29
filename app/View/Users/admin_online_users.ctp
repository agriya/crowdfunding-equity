<div class="accordion-heading clearfix">
  <h4 class="accordion-toggle"><?php echo __l('Online Users') . ' (' . $this->Html->cInt(count($onlineUsers), false) . ')'?></h4>
</div>
<div id="timings" class="accordion-body">
<div class="accordion-inner">
<ul class="list-unstyled">
<?php
  if (!empty($onlineUsers)):
    $users = '';
    $i=0;
    foreach ($onlineUsers as $user):
      $users .= sprintf('%s, ',$this->Html->link($this->Html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false)));
    if($i > 10){
      break;
    }
    $i++;
    endforeach;
    ?>
    <li>
    <?php echo substr($users, 0, -2);?>
    </li>
    <?php
  else:
?>
    <li><?php echo __l('No users online');?></li>
<?php
  endif;
?>
</ul>
</div>

</div>
