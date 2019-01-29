<div class="extensions-plugins">
	<?php
		$pluginTree = Configure::read('pluginsTree');
		$j = 0;
		foreach($pluginTree as $key => $plugin){
	?>
			
			<div class="col-sm-12">
				<div class="clearfix navbar-btn">
					<div class="pull-left plug-img text-center">
						<?php 
							if (in_array($key, array_keys($image_title_icons))): 
								echo $this->Html->image($image_title_icons[$key]. '.png'); 
							endif; 
						?>
					</div>
					<div class="col-sm-11 media list-group-item-heading">
						<h4 class="list-group-item-heading roboto-bold lead"><?php echo __l($key); ?></h4>
						<?php if (in_array($key, array_keys($title_description))): ?>
							<p class="grayc">
								<?php echo $this->Html->cText($title_description[$key]); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>	
				
			</div>
			<?php 
				$icon_class = 'modules';
				if($j > 0){
					$icon_class = '';
				}
			?>
			<div class="col-xs-12 <?php echo $icon_class; ?>">
				<div class="row">
				<?php				
				$total_child = count($plugin['Children']);
				$left_side_count = round($total_child / 2);
				$right_side_count = floor($total_child / 2);
				$i =0;
				foreach($plugin['Children'] as $child_key => $children) {				
					if($i == 0 || $i == $left_side_count){	
				?>
						<div class="col-sm-6">
				<?php } ?>
										
						<div class="col-xs-12">
							<div class="panel panel-default">
							  <div class="panel-heading">
								<div class="pull-left">
									<div class="ver-space pull-left">
										<?php if (in_array($child_key, array_keys($image_title_icons))): ?>
										   <?php echo $this->Html->image($image_title_icons[$child_key]. '.png'); ?>
										<?php endif; ?>
									</div>
									<h3 class="panel-title"><?php echo __l($child_key); ?></h3>
								</div>
								<?php if(empty($children['Children'])) {?>
									<div class="pull-right">
										<div class="pull-right">
											<div class="clearfix dropdown">
												<span class="label label-success ver-mspace <?php echo (!empty($children['active'])) ? '' : 'disabled'; ?>"><?php echo (!empty($children['active'])) ? __l('Enabled') : __l('Disabled'); ?></span>
												<a href="#" data-toggle="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog fa-lg grayc"></i></a>
												<ul class="dropdown-menu  dropdown-menu-right right-mspace">
													<?php if(!empty($children['disable']) || empty($children['active'])) { ?>
														<li><?php echo $this->Html->link((!empty($children['active'])) ? '<i class="fa fa-minus-square fa-fw"></i>'.__l('Disable') : '<i class="fa fa-plus-circle fa-fw"></i>'.__l('Enable'), array('action' => 'toggle', $children['plugin_folder_name']), array('escape' => false, 'class' => 'js-confirm js-no-pjax', 'title' => !empty($children['active']) ? __l('Disable') : __l('Enable') )); ?></li>
													<?php } ?>
													<?php if (!empty($children['settings']) && $children['active']) { 
															?>
																<li><?php echo $this->Html->link('<i class="fa fa-cog fa-fw"></i>' . __l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', $children['plugin_folder_name']), array('escape'=>false,'title' => __l('Settings')));?></li>
															<?php  
														} ?>
													<?php if(!empty($children['delete'])) { ?>
														<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('action' => 'delete', $children['plugin_folder_name']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?></li>
													<?php } ?>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							  </div>
							  <div class="panel-body">
							  
								<?php
								if(!empty($children['Children'])){
									echo $this->Html->getPluginChildren($children, 2, $image_title_icons);
									} else {
								?>		
									<div class="row col-md-12">			
										<p class="grayc"><?php echo $this->Html->cHtml(__l($children['description'])); ?></p>
									</div>
								<?php } ?>
							  </div>
							</div>
						</div>		
				<?php 
					if($i == ($left_side_count-1) || $i == ($total_child-1)){	
				?>
						</div>
				<?php 
				} 
				$i++;
				?>						
				<?php } ?>
				</div>
			</div>
	<?php $j++; } ?>
</div>