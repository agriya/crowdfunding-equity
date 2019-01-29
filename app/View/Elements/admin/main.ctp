<div class="clearfix navbar-btn">
	<?php 
		$diagnostics_menu = array('devs', 'search_logs');
		if(!empty($this->pageTitle)){ 
	?> 
		<h3 class="pull-left top-mspace-xs">
			<?php
				if (!empty($pluginImage) && !empty($plugin_name)) {
				echo $pluginImage;
				} else { 
			?>				
			<?php } ?>
			<?php
				if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index' || $this->request->params['controller'] == 'entry_flag_categories' && $this->request->params['action'] == 'index') {
					echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));
				} elseif ($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit' ) {
						if(!empty($setting_categories['SettingCategory'])) {
							echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> &raquo; <?php echo  $this->Html->cText(__l($setting_categories['SettingCategory']['name']), false);
						}
				} elseif(in_array( $this->request->params['controller'], $diagnostics_menu) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') {
					echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics'))); ?> &raquo; <?php echo $this->Html->cText(__l($this->pageTitle),false); ?>
			<?php
				} else {
					echo $this->Html->cText(__l($this->pageTitle),false);
				}
			?>
		</h3>
	<?php } ?>
	<?php if ($this->request->params['controller'] == 'settings' || $this->request->params['controller'] == 'payment_gateways' || $this->request->params['controller'] == 'extensions_plugins') { ?>
		<span class="pull-right navbar-btn"><?php echo sprintf(__l('To reflect changes, you need to %s.'), $this->Html->link(__l('clear cache'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('clear cache'), 'class' => 'js-confirm text-danger')));?></span>
	<?php } ?>
</div>
<div class="dashboard-second-block clearfix">
	<?php if(!empty($this->request->params['plugin']) && $this->request->params['plugin'] != 'extensions') { ?>
		<div class="alert alert-warning navbar-btn">
			<?php echo " ".$this->Html->cText(__l(Inflector::humanize(ucfirst($this->request->params['plugin'])))).' '.__l(' plugin is currently enabled. You can disable it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin text-info'));  ?>.
		</div>
	<?php } ?>
	<?php if ($this->request->params['controller'] == 'affiliate_types' && $this->request->params['action'] == 'admin_edit' && isPluginEnabled('Affiliates')) : ?>
		<div class="alert alert-info">
			<?php echo __l('Commission percentage will be calculated from admin commission'); ?>
		</div>
	<?php endif; ?>
	<?php
		if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && ((!empty($this->request->data['Setting']['setting_category_id'])) && ($this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Projects || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals))) {
			$enable_text = 'enabled';
			$disable_text = 'disable';
			if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet) {
				// wallet
				if (!isPluginEnabled('Wallet')) {
					$enable_text = 'disabled';
					$disable_text = 'enable';
				}
				$plugin_name = 'Wallet';
			}
			if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Projects) {
				// Contests
				if(!isPluginEnabled('Projects')) {
					$enable_text = 'disabled';
					$disable_text = 'enable';
				}
				$plugin_name = 'Projects';
			}
			if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals) {
				// withdrawals
				if(!isPluginEnabled('Withdrawals')) {
					$enable_text = 'disabled';
					$disable_text = 'enable';
				}
				$plugin_name = 'Withdrawals';
			}
	?>
	<div class="alert alert-warning">
		<i class="fa fa-exclamation-triangle"></i>
		<?php echo $this->Html->cText(Inflector::humanize(ucfirst($plugin_name))).__l(' plugin is currently '.$enable_text.'. You can '.$disable_text.' it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin'));  ?>.
	</div>
	<?php }  ?>
	<?php
		if ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_stats') {
			echo $content_for_layout;
		} else { ?>
				<?php
					$diagnostics_menu = array('devs', 'search_logs');
					$links_menu = array('links');
					if(isset($plugin_name) && !empty($plugin_name)){
						if (in_array($plugins[$plugin_name]['icon'], $image_plugin_icons)):
							$pluginImage = $this->Html->image($plugins[$plugin_name]['icon'] . '-icon.png', array('width'=>20, 'height'=>20));
						else:
							$pluginImage = '<i class="fa fa-'.$plugins[$plugin_name]['icon'].'"></i>';
						endif;
					} elseif ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
						$class = "diagnostics-title";
					} elseif ($this->request->params['controller'] == 'user_profiles' || $this->request->params['controller'] == 'user_add_wallet_amounts') {
						$class = "users-title";
					} elseif (in_array($this->request->params['controller'], $diagnostics_menu)) {
						$class = "diagnostics-title";
					} elseif (in_array($this->request->params['controller'], $links_menu)) {
						$class = "cms-title";
					} elseif ($this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && $this->request->params['pass'][0] == '85') {
						$class = "fa fa-bullhorn";
					} elseif ($this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && $this->request->params['pass'][0] == '60') {
						$class = "fa fa-trophy";
					}elseif ($this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && $this->request->params['pass'][0] == '21') {
						$class = "fa fa-users";
					} elseif ($this->request->params['controller'] == 'settings') {
						$class = "fa fa-cogs";
					} else {
						$class = Configure::read('admin_heading_class');
					}
				?>
				<?php echo $content_for_layout;  ?>
	<?php } ?>
</div>