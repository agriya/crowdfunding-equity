<?php if(empty($this->request->params['named']['project_type'])) { ?>
<?php 
	$main_class = 'prdct-pge';
} else {
	$main_class = 'cf-lst-main';
} 
?>
<section class="<?php echo $main_class;?>">
<?php 
	  foreach($projectTypes as $projectType){
		if(isPluginEnabled($projectType['ProjectType']['name'])){
			if((!empty($this->request->params['named']['project_type']) && $this->request->params['named']['project_type'] ==  $projectType['ProjectType']['slug']) || empty($this->request->params['named']['project_type'])){
				echo $this->element($projectType['ProjectType']['name'].'.discover_project_listing');
			}
	   }
	  }
	?>
</section>
<?php if (Configure::read('widget.home_script')) { ?>
  <div class="text-center clearfix">
  <?php echo Configure::read('widget.home_script'); ?>
  </div>
<?php } ?>