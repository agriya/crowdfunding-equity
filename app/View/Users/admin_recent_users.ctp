<h5 class="text-capitalize list-group-item-text"><strong><?php echo __l('Recently Registered Users'); ?></strong></h5>
<ul class="list-unstyled navbar-btn list-group-item-heading right-side-block">
	<?php
		if (!empty($recentUsers)):
		$users = '';
		foreach ($recentUsers as $user):
			$users .= $this->Html->link($this->Html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false), array('class' => 'h5 rgt-move')) . ', ';
		endforeach;
	?>
	<p><?php echo substr($users, 0, -2);?></p>
	<?php else: ?>
		<p class="h5 rgt-move"><?php echo __l('Recently no users registered');?></p>
	<?php endif; ?>
</ul>