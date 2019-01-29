<?php
	echo $this->element('Projects.index-slide');
?>
<section class="h1  sec-1">
	<div class="container">
		<div class="text-center col-xs-12 h1">
			<p class="h3 col-xs-12"><?php echo sprintf(__l('Personalize, mold and replicate the entire business model of Kickstarter for your nation, language,currency and preferred niches with Agriya’s fundraising software – %s Pledge. Just install it on your server to easily create, launch, manage and maintain a Next Generation %s platform in days.'), Configure::read('site.name'), Configure::read('site.name'));?></p>
			<div class="col-xs-12 h1 well-sm  cf-strt-prjt">
			<?php 
				$plugin_count = 0;
				foreach($projectTypes as $projectType) {
					if(isPluginEnabled($projectType['ProjectType']['name'])){	
						$plugin_count ++;
					}
				}
				$offset_class = '';			
				if($plugin_count == 1){
					$offset_class = 'col-sm-offset-4';
				} else if($plugin_count == 2){
					$offset_class = 'col-sm-offset-3';
				} else if($plugin_count == 3){
					$offset_class = 'col-sm-offset-1';
				}
				$all_projects = "";
				$i = 0; 
				foreach($projectTypes as $projectType) {
					if(isPluginEnabled($projectType['ProjectType']['name'])){ 
						if($i == 0){
							$offset = $offset_class;
						} else {
							$offset = '';
						}
					?>
					<div class="col-sm-3 h4 <?php echo $offset; ?>">
						<?php echo $this->element($projectType['ProjectType']['name'].'.home_project_listing'); ?>
					</div>
					<?php $i++; } 
					} ?>
			</div>
		</div>
	</div>
</section>
<section class="well well-sm tabpanel-block no-pad">
	<div class="container">
		<div class="row">
			<div class="col-sm-10">
				<div id="ajax-tab-container-feature-project" class='tab-container'>
					<div class="col-xs-12 clearfix">
						<div class="pull-left">
							<ul class="nav nav-pills" role="tablist" id="feature-project"> 
								<?php $is_type_active = true;
									foreach($projectTypes as $key => $projectType) {
									if(isPluginEnabled($projectType['ProjectType']['name'])){ if($is_type_active) { $all_projects = $projectType['ProjectType']['slug']; } 
								?>
								<li role="feature-project" id="js-feature-project" data-text="<?php echo $projectType['ProjectType']['name']; ?>" class="<?php echo strtolower($projectType['ProjectType']['name']); echo ($is_type_active)?' active':''; $is_type_active = false;  ?> text-capitalize">
									<?php echo $this->Html->link('<strong>' .sprintf(__l('%s'), $projectType['ProjectType']['name']) . '</strong>', '#'.$projectType['ProjectType']['name'].'-feature', array('class'=>'js-no-pjax h3 list-group-item-text clr-black', 'aria-controls'=>$projectType['ProjectType']['name'].'-feature', 'data-active-tab'=>$projectType['ProjectType']['name'].'-categories', 'data-action-url'=>$this->Html->url(array('controller' => 'projects', 'action' => 'discover', 'project_type'=>$projectType['ProjectType']['slug'])), 'role'=>'tab', 'data-toggle'=>'tab', 'escape' => false)); ?>
								</li>
								<?php } } ?>
							</ul>
						</div>
						<div class="pull-right h1 well-lg list-group-item-heading list-group-item-text">
							<h3 class="h5 text-danger list-group-item-text">
								<?php echo $this->Html->link(__l('See All Pledge Projects'), array('controller' => 'projects', 'action' => 'discover', 'project_type'=>$all_projects , 'admin' => false), array('class'=>'js-tooltip see-a-tech js-no-pjax', 'id'=>'js-see-a-tech','title' => __l('See All Pledge Projects')));?>
							</h3>
						</div>
					</div>
					<div class="tab-content col-xs-12 top-space">
						<?php $is_active = true; 
							foreach($projectTypes as $key => $projectType) { 
							if(isPluginEnabled($projectType['ProjectType']['name'])){ ?>
								<div role="feature-project" class="tab-pane <?php echo ($is_active)?'active':''; $is_active = false; ?> tab-contain" id="<?php echo $projectType['ProjectType']['name'].'-feature'; ?>">
										<?php echo $this->requestAction(array('controller' => 'projects', 'action' => 'feature_list'), array('named' => array('project_type' => $projectType['ProjectType']['name'], 'category' => 'All', 'type' => 'feature-projects'), 'return')); ?>
								</div>
						<?php	} }	?>
					</div>
				</div>
			</div>
			<!--category list start-->
			<div class="col-xs-12 col-sm-2 h4">
				<div class="some-content-related-div" id="inner-content-div">
					<?php  $is_show = "show";
					foreach($projectCategories as $index => $projectCategory) { ?>
						<div class="<?php echo $is_show; ?> js-catlist-show" id="<?php echo $index.'-categories'; ?>">
							<ul class="list-unstyled h3  rght-nav-scrl" role="tablist">
								<li class="text-capitalize active">
									<?php echo $this->Html->link(sprintf(__l('All')), array('controller'=>'projects','action'=>'feature_list','project_type' => $index,'category' => 'All'), array('class'=>'js-no-pjax panel-link js-cateogory-projects h5', 'title'=>sprintf(__l('All')), 'data-target'=>'#'.$index.'-feature')); ?>
								</li>
								<?php foreach($projectCategory as $slug => $categoryName) { ?>
								<li class="text-capitalize">
									<?php echo $this->Html->link(sprintf(__l('%s'), $categoryName), array('controller'=>'projects','action'=>'feature_list','project_type' => $index,'category' => $slug), array('class'=>'js-no-pjax panel-link js-cateogory-projects h5', 'title'=>sprintf(__l('%s'), $categoryName), 'data-target'=>'#'.$index.'-feature', 'data-action-url'=>$this->Html->url(array('controller' => 'projects', 'action' => 'index', 'category' => $slug, 'project_type' => strtolower($index), 'idea' => 'idea')))); ?>
								</li>
								<?php } ?>
							<ul>
						</div>
						<?php $is_show = "hide";
					} ?>
				</div>
			</div>
			<!--category list end-->
		</div>	
	</div>
</section>
