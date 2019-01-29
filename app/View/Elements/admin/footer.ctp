<footer id="footer">
	<div class="container-fluid bg-primary">
		<div class="row">
			<p class="text-center well-lg">
				&copy;<?php echo date('Y');?> <strong><?php echo $this->Html->link($this->Html->cText(Configure::read('site.name'), false), '/', array('title' => Configure::read('site.name'), 'escape' => false));?></strong>. <?php echo __l('All rights reserved.');?>
				<span><a href="/" title="<?php echo sprintf(__l('Powered by %s'), Configure::read('site.name'));?>" target="_blank"><?php echo sprintf(__l('Powered by %s'), Configure::read('site.name'));?></a></span> 
				<span><?php echo ', '. __l('made in'); ?></span> 
				<?php echo $this->Html->link(sprintf(__l('%s Web Development'), 'Agriya'), 'http://www.agriya.com/', array('target' => '_blank', 'title' => sprintf(__l('%s Web Development'), 'Agriya'), 'class' => 'js-no-pjax'));?>  
				<span><?php echo Configure::read('site.version').'.';?></span>
			</p>
		</div>
	</div>
</footer>

