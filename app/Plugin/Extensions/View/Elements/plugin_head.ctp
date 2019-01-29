<div class="<?php echo 'offset' . ($depth+1); ?>">
	<div class="clearfix navbar-btn">
		<div class="ver-space pull-left">
			<?php if (in_array($key, array_keys($image_title_icons))): ?>
			   <?php echo $this->Html->image($image_title_icons[$key]. '.png'); ?>
			<?php endif; ?>
		</div>
		<div class="pull-left">
		   <h3 class="list-group-item-heading"><?php echo __l($key); ?></h3>
			<?php if (in_array($key, array_keys($title_description))): ?>
				<p>
					<?php echo $this->Html->cText($title_description[$key]); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>