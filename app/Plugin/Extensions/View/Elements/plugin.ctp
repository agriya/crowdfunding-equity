<div class="clearfix col-md-12">
	<div class="row navbar-btn">
		<div class="col-md-1 col-sm-2 pull-left plug-img text-center">
			<?php 
				$image_plugin_icons = array(
				'donate-s',
				'pledge-s',
				'lend-s',
				'equity-s',
				'iphone',
				'jobs',
				'seis',
				'high-performance',
				'sudopay',
				);
				if (in_array($pluginData['icon'], $image_plugin_icons)):
					echo $this->Html->image($pluginData['icon'].'-icon' . '.png');
				else :
					echo '<i class="fa fa-'.$pluginData['icon'].' fa-2x"></i>';
				endif; 
			?>
		</div>
		<div class="col-lg-7 col-md-6 col-sm-5 media list-group-item-heading">
			<h4 class="list-group-item-heading"><?php echo $this->Html->cText(__l($pluginData['name'])); ?></h4>
		</div>
		<div class="col-lg-4 col-md-5 col-sm-6 pull-right">
			<div class="pull-right">
				<div class="clearfix dropdown">
					<span class="label label-success ver-mspace <?php echo (!empty($pluginData['active'])) ? '' : 'disabled'; ?>"><?php echo (!empty($pluginData['active'])) ? __l('Enabled') : __l('Disabled'); ?></span>
					<a href="#" data-toggle="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog fa-lg grayc"></i></a>
					<ul class="dropdown-menu  dropdown-menu-right right-mspace">
						<?php if(!empty($pluginData['disable']) || empty($pluginData['active'])) { ?>
							<li><?php echo $this->Html->link((!empty($pluginData['active'])) ? '<i class="fa fa-minus-square fa-fw"></i>'.__l('Disable') : '<i class="fa fa-plus-circle fa-fw"></i>'.__l('Enable'), array('action' => 'toggle', $pluginData['plugin_folder_name']), array('escape' => false, 'class' => 'js-confirm js-no-pjax', 'title' => !empty($pluginData['active']) ? __l('Disable') : __l('Enable') )); ?></li>
						<?php } ?>
						<?php if (!empty($pluginData['settings']) && $pluginData['active']) { 
								if($pluginData['name'] == ConstPaymentGatewaysName::SudoPay) { ?>
									<li><?php echo $this->Html->link('<i class="fa fa-cog fa-fw"></i>' . __l('Settings'), array('controller' => 'payment_gateways', 'action' => 'edit', ConstPaymentGateways::SudoPay), array('escape'=>false,'title' => __l('Settings')));?></li>
								<?php } else { ?>
									<li><?php echo $this->Html->link('<i class="fa fa-cog fa-fw"></i>' . __l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', $pluginData['plugin_folder_name']), array('escape'=>false,'title' => __l('Settings')));?></li>
								<?php } 
							} ?>
						<?php if(!empty($pluginData['delete'])) { ?>
							<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('action' => 'delete', $pluginData['plugin_folder_name']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row col-md-12">
		<p class="grayc"><?php echo $this->Html->cHtml(__l($pluginData['description'])); ?></p>
	</div>
</div>
<hr class="col-xs-12">