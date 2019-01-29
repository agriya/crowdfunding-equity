<?php  
	$plugin_count = 0;
	$col_offset = '';
	if(isPluginEnabled('Pledge')) {
		$plugin_count++;
	}
	if(isPluginEnabled('Donate')) {
		$plugin_count++;
	}
	if(isPluginEnabled('Equity')) {
		$plugin_count++;
	}
	if(isPluginEnabled('Lend')) {
		$plugin_count++;
	}
	if($plugin_count == 2) {
		$col_offset = 4;
	}
	if($plugin_count == 3) {
		$col_offset = 2;
	}
?>  
<section class="clearfix container text-center <?php echo $this->Html->getUniquePageId();?>" id="main">
  <h2 class="text-center project-status-7 start-title text-info text-b"><span><?php echo __l('Start Project'); ?></span></h2>
  <section class="row">
  <div class="well-sm">
   <div class="bot-space"><p class="text-center start-view"><?php echo __l('Have idea? No money? Need someone to help? Start a project and use crowd power to raise funds.'); ?> </p></div>
  </div>
   <div class="row col-md-offset-<?php echo $col_offset;?> text-center">
	<?php 
	foreach($projectTypes as $projectType):
		if(isPluginEnabled($projectType['ProjectType']['name'])){
			echo $this->element($projectType['ProjectType']['name'].'.start'); 
		}
	endforeach;
	?>
   </div>
  </section>
</section>


