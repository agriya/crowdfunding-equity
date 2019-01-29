<div class="container">
	<div class="clearfix">
		<h3 class="text-b"><?php echo __l('How it Works');?></h3>
	</div>
	<div class= "clearfix thumbnail">
		<?php Cms::dispatchEvent('View.Project.howitworks', $this); ?>
	</div>
</div>