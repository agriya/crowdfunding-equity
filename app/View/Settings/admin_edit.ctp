<div class="js-response js-clone new-admin-form admin-form settings-edit col-xs-12">
	<?php if (!empty($setting_categories['SettingCategory']['description']) && empty($plugin_name)):?>
		<?php if(stristr($setting_categories['SettingCategory']['description'], '##PAYMENT_SETTINGS_URL##') === false) { ?>
			<div class="alert alert-info">
				<?php echo $this->Html->cHtml(__l($setting_categories['SettingCategory']['description']), false);?>
			</div>
		<?php } else { ?>
			<div class="alert alert-info">
				<?php echo $category_description = str_replace('##PAYMENT_SETTINGS_URL##',Router::url('/', true).'admin/payment_gateways',$setting_categories['SettingCategory']['description']); ?>
			</div>
		<?php } ?>
	<?php endif;?>
	<?php
		if (!empty($settings)):
			echo $this->Form->create('Setting', array('action' => 'edit', 'class' => 'form-horizontal','enctype' => 'multipart/form-data'));
			echo $this->Form->input('setting_category_id', array('label' => __l('Setting Category'),'type' => 'hidden', 'value'=>$category_id));
			if (!empty($plugin_name)) {
				echo $this->Form->input('plugin_name', array('label' => __l('Plugin Name'),'type' => 'hidden', 'value'=>$plugin_name));
			}
			// hack to delete the thumb folder in img directory
			$inputDisplay = 0;
			$is_changed = $prev_cat_id = 0;
			$i = 0;
			foreach ($settings as $setting):
				$categorySettingPluginName = '';
				if (!empty ($setting['SettingCategory']['plugin_name'])) {
					$categorySettingPluginName = $setting['SettingCategory']['plugin_name'];
				}
				$settingPluginName = '';
				if (!empty ($setting['Setting']['plugin_name'])) {
					$settingPluginName = $setting['Setting']['plugin_name'];
				}
				if ($setting['Setting']['id'] == 641) {
					$find_Replace = array(
						'##TEST_CONNECTION##' => $this->Html->link(__l('Test Connection'), array('controller' => 'high_performances', 'action' => 'check_s3_connection', '?f=' . $this->request->url))
					);
					$setting['Setting']['description'] = strtr($setting['Setting']['description'], $find_Replace);
				}
				if ($setting['Setting']['id'] == 443 and !empty($attachment)) {
	?>
	<div class="user-img marg-btom-5 clearfix">
		<div class="pull-left offset2"><?php echo  $this->Html->showImage('Setting', $attachment['Attachment'], array('dimension' => 'medium_thumb')); ?></div>
		<div class="pull-left">
			<div class="input checkbox">
				<?php echo $this->Form->input($setting['Setting']['id'].'.is_delete_attachemnt', array('label' => __l('Delete?'),'type' => 'checkbox','div'=>'false'));?></div></div>
			</div>
			<?php
				}
				if ($setting['Setting']['id'] != 413 || isPluginEnabled('LaunchModes')):
					if ($setting['Setting']['name'] == 'site.language'):
						$empty_language = 0;
						$get_language_options = $this->Html->getLanguage();
						if(!empty($get_language_options)):
							$options['options'] = $get_language_options;
						else:
							$empty_language = 1;
						endif;
					endif;
					$field_name = explode('.', $setting['Setting']['name']);
					if (isset($field_name[2]) && ($field_name[2] == 'is_not_allow_resize_beyond_original_size' || $field_name[2] == 'is_handle_aspect')) {
						continue;
					}
					$options['type'] = $setting['Setting']['type'];
					$options['value'] = $setting['Setting']['value'];
					$options['div'] = array('id' => "setting-{$setting['Setting']['name']}");
					if($options['type'] == 'checkbox' && $options['value']):
						$options['checked'] = 'checked';
					endif;
					if ($options['type'] == 'select'):
						$selectOptions = explode(',', $setting['Setting']['options']);
						$setting['Setting']['options'] = array();
						if(!empty($selectOptions)):
							foreach($selectOptions as $key => $value):
								if(!empty($value)):
									$setting['Setting']['options'][trim($value)] = trim($value);
								endif;
							endforeach;
						endif;
						$options['options'] = $setting['Setting']['options'];
					elseif ($options['type'] == 'radio'):
						$selectOptions = explode(',', $setting['Setting']['options']);
						$setting['Setting']['options'] = array();
						$options['legend'] = false;
						if (!empty($selectOptions)):
							foreach ($selectOptions as $key => $value):
								if (!empty($value)):
									$setting['Setting']['options'][trim($value)] = trim($value);
								endif;
							endforeach;
						endif;
						$options['options'] = $setting['Setting']['options'];
					endif;
					$tmp_prev_cat_id = $prev_cat_id;
					if (empty($prev_cat_id)) {
						$prev_cat_id = $setting['SettingCategory']['id'];
						$is_changed = 1;
					} else {
						$is_changed = 0;
						if ($setting_categories['SettingCategory']['id'] != 1146 && $setting['SettingCategory']['id'] != $prev_cat_id ) {
							$is_changed = 1;
							$prev_cat_id  = $setting['SettingCategory']['id'];
						}
					}
					if ($is_changed) {
						$isGroup = false;
					}
					if (!empty($is_changed)) {
						if ($setting['SettingCategory']['id'] != $tmp_prev_cat_id && in_array($tmp_prev_cat_id, array(140, 138, 139, 137))) {
				?>
                <?php if ($tmp_prev_cat_id != 138) { ?>
				</div>
				<div class="col-md-5 well">
                <?php } ?>
					<?php if ($tmp_prev_cat_id == 138) { ?>
                        <div class="clearfix">
                            <div class="col-md-7">&nbsp;</div>
                            <div class="col-md-5 well">
                                <h4><?php echo __l('Configuration steps:');?></h4> <br>
                                <?php echo __l('1. Sign in using your google account in. '); ?><a target="blank" href="https://developers.google.com/speed/pagespeed/service">https://developers.google.com/speed/pagespeed/service</a><br/>
                                <?php echo __l('2. Click sign up now button and answer simple questions. Google will enable PageSpeed service within 2 hours.'); ?><br/>
                                <?php echo __l('3. You have to configure this service in this link '); ?><a target="blank" href="https://code.google.com/apis/console">https://code.google.com/apis/console</a>,<?php echo __l(' please follow the steps mentioned in this link '); ?><a target="blank" href="https://developers.google.com/speed/pagespeed/service/setup">https://developers.google.com/speed/pagespeed/service/setup</a>
                            </div>
                        </div>
					<?php } elseif ($tmp_prev_cat_id == 137) { ?>
						<h4><?php echo __l('Configuration steps:'); ?></h4><br>
						<?php echo __l('1. Create a CloudFlare account, configure the domain and change DNS.'); ?><br>
						<?php echo __l('2. To create token please refer '); ?> <a target="blank" href="http://blog.cloudflare.com/2-factor-authentication-now-available">http://blog.cloudflare.com/2-factor-authentication-now-available</a><br>
						<?php echo __l('3. Create three page rules like /, /project/*, /user/* in this link'); ?> <a target="blank" href="https://www.cloudflare.com/page-rules?z=<?php echo $this->Html->cText($_SERVER["SERVER_NAME"], false); ?>">https://www.cloudflare.com/page-rules?z=<?php echo $this->Html->cText($_SERVER["SERVER_NAME"], false); ?></a>. <?php echo __l('Note: Please select \'Cache Everything\' option for \'Custom Caching\' setting.'); ?><br>
						<?php echo __l('4. Update your CloudFlare Email and Token and enable CloudFlare option here.'); ?><br>
						<?php echo __l('5. Minimum cache timing for free users will be 30 minutes. Only enterprise users can reduce upto 30 seconds.'); ?>
					<?php } elseif ($tmp_prev_cat_id == 140) { ?>
						<h4><?php echo __l('Configuration steps:');?></h4> <br>
						<?php echo __l('You can configure SMTP server by any one of the followings Amazon SES, Sendgrid, Mandrill, Gmail and your own host SMTP settings'); ?><br>
						<?php echo __l('1. Amazon SES: To get your security credentials, login with amazon and go to '); ?> <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a> .<?php echo __l('To create your smtp username password go to '); ?><a target="blank" href="https://console.aws.amazon.com/ses/home#smtp-settings">https://console.aws.amazon.com/ses/home#smtp-settings</a><br>
						<?php echo __l('2. Sendgrid: To get your security credentials, refer '); ?><a target="blank" href="http://sendgrid.com/docs/Integrate/index.html">http://sendgrid.com/docs/Integrate/index.html</a><br>
						<?php echo __l('3. Mandrill:  To get your security credentials, login with Mandrill and go to '); ?><a target="blank" href="https://mandrillapp.com/settings">https://mandrillapp.com/settings</a><br>
						<?php echo __l('4. Gmail: To use gmail please refer '); ?><a target="blank" href="http://gmailsmtpsettings.com/gmail-smtp-settings">http://gmailsmtpsettings.com/gmail-smtp-settings</a>
					<?php } elseif ($tmp_prev_cat_id == 139) { ?>
						<h4><?php echo __l('Configuration steps:');?></h4> <br>
						<?php echo __l('1. Amazon CloudFront: To setup Amazon CloudFront CDN please follow the step mentioned in this '); ?><a target="blank" href="http://aws.amazon.com/console/#cf">http://aws.amazon.com/console/#cf</a> <?php echo __l(' and watch this screencast '); ?><a href="http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html" target="blank">http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html</a><br>
						<?php echo __l('2. CloudFlare: To setup CloudFlare please follow the step mentioned in this link '); ?><a href="https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-" target="blank">https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-</a><br>
					<?php } ?>
				</div>
				<?php
						}
					}
					if (!empty($i) && !empty($is_changed)):
			?>
			</fieldset>
			<?php
					endif;
					if (!empty($is_changed)):
						if($setting_categories['SettingCategory']['id'] != 1112) : //module manager
			?>
			<fieldset class="admin-checkbox border-bottom">
				<?php if ($setting['Setting']['id'] == 656) { ?>
					<legend><h3><?php echo __l('Instant Scaling'); ?></h3></legend>
					<div class="alert alert-info"><?php echo __l('By enabling these easy options, site can achieve instant scaling.');;?></div>
				<?php } ?>
				<?php if (in_array( $setting['SettingCategory']['id'], array(137, 138, 139, 140))) : ?>
					<legend class="offset1">
				<?php else : ?>
					<div class="top-space clearfix">
					<legend class="pull-left">
					<?php endif;?>
						<h3 class="text-b no-mar" id="<?php echo str_replace(' ','',$setting['SettingCategory']['name']); ?>">
							<?php
								if (empty($plugin_name) && !empty($categorySettingPluginName) && in_array($categorySettingPluginName, array_keys($plugins))) {
									$isGroup = true;
									if (!empty($plugins[$categorySettingPluginName]['icon'])):
										if (in_array($plugins[$categorySettingPluginName]['icon'], $image_plugin_icons)):
											echo $this->Html->image($plugins[$categorySettingPluginName]['icon'] . '-icon.png', array('width'=>20, 'height'=>20, 'alt' => '[Image :'.__l($categorySettingPluginName).']'));
										else:
											echo '<i class="fa fa-magic js-tooltip" title="'.__l($categorySettingPluginName).'"></i>';
										endif;
									endif;
								}
							?>
							<?php echo $this->Html->cText(__l($setting['SettingCategory']['name']), false); ?>
						</h3>
					</legend>
				<?php if($setting['SettingCategory']['name'] == 'Commission'): ?>
					<div class="pull-right">
						<?php echo $this->Html->link('<i class="fa fa-cog"></i> <span>'.__l('Commission Settings').'</span>', array('controller' =>'affiliate_types', 'action' => 'edit'), array('title' => __l('Here you can update and modify affiliate types'),'escape'=>false)); ?>
					</div>
				</div>	<br/>
				<?php endif; ?>
				<?php if (!empty($setting['SettingCategory']['description']) && $setting['SettingCategory']['id'] !=136 ): ?>
				<?php if (in_array( $setting['SettingCategory']['id'], array(137, 138, 139, 140))) : ?>
					<div class="alert alert-info offset1">
				<?php else : ?>
					<div class="alert alert-info col-xs-12">
				<?php endif;?>

						<?php
							$findReplace = array(
								'##TRANSLATIONADD##' => $this->Html->link(Router::url('/', true).'admin/translations/add', Router::url('/', true).'/admin/translations/add', array('title' => __l('Translations add'))),
								'##SUSPICIOUS_WORDS_URL##' => Router::url('/', true).'/admin/settings/edit/14/dbcbc7239a27f216ddb9a70a7ca51959',
								'##APPLICATION_KEY##' => $this->Html->link($appliation_key_link . '#SolveMedia',$appliation_key_link . '#SolveMedia'),
								'##CATPCHA_CONF##' => $this->Html->link($captcha_conf_link . '#CAPTCHA',$captcha_conf_link . '#CAPTCHA'),
								'##DEMO_URL##' => $this->Html->link('http://dev1products.dev.agriya.com/doku.php?id=crowdfunding-install#how_to','http://dev1products.dev.agriya.com/doku.php?id=crowdfunding-install#how_to', array('target' => '_blank')),
							);
							$setting['SettingCategory']['description'] = strtr($setting['SettingCategory']['description'], $findReplace);
							echo $this->Html->cHtml(__l($setting['SettingCategory']['description']), false);
						?>
					</div>
				<?php endif;?>
				<?php
						endif;
					endif;
				?>
				<?php
					if (!empty($is_changed)) {
						if (in_array( $setting['SettingCategory']['id'], array(144, 138, 139, 35, 136, 137, 140))) {
							if (in_array( $setting['SettingCategory']['id'], array(140, 139, 137))) {
								echo '<div class="clearfix offset1"><div class="col-md-7">';
							} elseif($setting['SettingCategory']['id'] == 138) {
								echo '<div class="clearfix offset1">';
							} else {
								echo '<div class="clearfix"><div>';
							}
						}
					}
				?>
				<?php
					if ($setting['SettingCategory']['id'] == 107):
						if (in_array( $setting['Setting']['id'], array(544, 548, 558, 550, 565, 569, 571, 580, 587, 589, 597, 604, 606, 614))):
							if (!$is_changed && $isGroup) {
								$isGroup = false;
							}
				?>
				<h3 class="text-b">
					<?php
						if (!$isGroup && empty($plugin_name) && !empty($settingPluginName) && in_array($settingPluginName, array_keys($plugins))) {
							$isGroup = true;
							if (in_array($plugins[$settingPluginName]['icon'], $image_plugin_icons)):
								echo $this->Html->image($plugins[$settingPluginName]['icon'] . '-icon.png', array('width'=>20, 'height'=>20));
							else:
								echo '<i class="icon-'.$plugins[$settingPluginName]['icon'].' js-tooltip" title="'.$settingPluginName.'"></i>';
							endif;
						}
					?>
					<?php echo ($setting['Setting']['id'] == '544') ? __l('Project') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '548') ? __l('Project Owner') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '558') ? __l('Backer') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '550') ? __l('Pledge') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '565') ? __l('Reward') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '569') ? __l('Project Owner') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '571') ? __l('Donate') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '580') ? __l('Donor') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '587') ? __l('Borrower') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '589') ? __l('Lend') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '597') ? __l('Lender') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '604') ? __l('Entrepreneur') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '606') ? __l('Equity') : ''; ?>
					<?php echo ($setting['Setting']['id'] == '614') ? __l('Investor') : ''; ?>
				</h3>
				<?php
						endif;
					endif;
				?>
				<?php
					if (in_array( $setting['Setting']['id'], array(210, 226, 208, 228, 349, 224, 468))):
						if (!$is_changed && $isGroup) {
							$isGroup = false;
						}
				?>
				<h3 class="clearfix" >
					<?php
						if (!$isGroup && empty($plugin_name) && !empty($settingPluginName) && in_array($settingPluginName, array_keys($plugins))) {
							$isGroup = true;
							if (!empty($plugins[$settingPluginName]['icon'])):
								if (in_array($plugins[$settingPluginName]['icon'], $image_plugin_icons)):
									echo $this->Html->image($plugins[$settingPluginName]['icon'] . '-icon.png', array('width'=>20, 'height'=>20));
								else:
									echo '<i class="icon-'.$plugins[$settingPluginName]['icon'].' js-tooltip" title="'.$settingPluginName.'"></i>';
								endif;
							endif;
						}
					?>
					<?php echo (in_array($setting['Setting']['id'], array('210', '226') ) )? __l('Application Info') : ''; ?>
					<?php echo (in_array($setting['Setting']['id'], array('208', '228', '468') ) )? __l('Credentials') : ''; ?>
					<?php echo (in_array($setting['Setting']['id'], array('224', '349') ) )? __l('Other Info') : ''; ?>
				</h3>
				<?php if(in_array( $setting['Setting']['id'], array(208, 228, 468)) && empty($plugin_name)):?>
					<div class="alert alert-info">
						<?php
							if($setting['Setting']['id'] == 208) :
								echo __l('Here you can update Facebook credentials . Click \'Update Facebook Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
							elseif($setting['Setting']['id'] == 228) :
								echo __l('Here you can update Twitter credentials like Access key and Accss Token. Click \'Update Twitter Credentials\' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.');
							elseif($setting['Setting']['id'] == 468) :
								echo __l('Here you can update Google Analytics credentials . Click  \'Update Google Analytics Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
							endif;
						?>
					</div>
				<?php endif;?>
				<?php if($setting['Setting']['id'] == 208) : ?>
					<div class="clearfix">
						<?php echo $this->Html->link(__l('<span><i class="fa fa-facebook-square facebookc fa-fw"></i>Update Facebook Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'facebook'), array('class' => 'js-connect js-no-pjax btn btn-info tp-credential js-tooltip', 'escape' => false, 'title' => __l('Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.'))); ?>
					</div>
				<?php elseif($setting['Setting']['id'] == 228): ?>
					<div class="clearfix">
						<?php echo $this->Html->link(__l('<span><i class="fa fa-twitter-square twitterc fa-fw"></i>Update Twitter Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'twitter'), array('class' => 'js-connect js-no-pjax btn btn-info tp-credential js-tooltip', 'escape' => false, 'title' => __l('Here you can update Twitter credentials like Access key and Access Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and Consumer secret before you click this link.'))); ?>
					</div>
				<?php elseif($setting['Setting']['id'] == 468): ?>
					<div class="clearfix">
						<?php echo $this->Html->link(__l('<span><i class="icon-google-sign googlec"></i>Update Google Analytics Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'google'), array('class' => 'btn btn-info tp-credential js-tooltip', 'escape' => false, 'title' => __l('Here you can update Google Analytics credentials like Access Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and Consumer secret before you click this link.'))); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($setting['Setting']['id'] == 644) { ?>
				<div class="clearfix">
					<?php echo $this->Html->link(__l('<span>Copy static contents to S3</span>'), array('controller' => 'high_performances', 'action' => 'copy_static_contents', '?f=' . $this->request->url), array('class' => 'js-connect js-confirm js-tooltip js-no-pjax btn', 'escape' => false, 'title' => __l('Clicking this button will copy static contents such as CSS, JavaScript, images files in <code>webroot</code> folder of this server to Amazon S3 and will enable them to be delivered from there.'))); ?>
				</div>
			<?php } ?>
			<?php
				if ($setting['Setting']['name'] == 'site.is_ssl_enabled' && !($ssl_enable)) {
					$options['disabled'] = 'disabled';
				}
				if (!$isGroup && empty($plugin_name) && !empty($settingPluginName) && in_array($settingPluginName, array_keys($plugins))) {
					if (in_array($plugins[$settingPluginName]['icon'], $image_plugin_icons)):
						echo '<div class="pull-left payment-img">';
						echo $this->Html->image($plugins[$settingPluginName]['icon'] . '-icon.png', array('width'=>16, 'height'=>16));
						echo '</div>';
					else:
						echo '<i class="fa fa-group pull-left js-tooltip" title="'.$settingPluginName.'"></i>';
					endif;
				}
				$findReplace = array(
					'##ANALYTICS_IMAGE##' => Router::url('/', true).'img/google_analytics_example.gif',
				);
				$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
				$options['class'] = '';
				if (in_array($setting['Setting']['name'], array('twitter.site_user_access_key', 'twitter.site_user_access_token', 'facebook.fb_access_token', 'google_analytics.access_token'))):
					$options['readonly'] = TRUE;
					$options['class'] = 'disabled';
				endif;
				if($setting['Setting']['name'] == 'site.language'):
					$options['options'] = $this->Html->getLanguage();
				endif;
				if($setting['Setting']['name'] == 'site.timezone_offset'):
					$options['options'] = $timezoneOptions;
				endif;
				if($setting['Setting']['name'] == 'site.city'):
					$options['options'] = $cityOptions;
				endif;
				if($setting['Setting']['name'] == 'site.currency_id'):
					$options['options'] = $this->Html->getCurrencies();
				endif;
				$options['label'] = $setting['Setting']['label'];
				if(in_array($setting['Setting']['name'], array('user.referral_deal_buy_time', 'user.referral_cookie_expire_time', 'affiliate.referral_cookie_expire_time'))):
					$options['after'] = ' ' . __l('hrs') . '<span class="info"><i class="fa fa-info-circle"></i> ' . __l($setting['Setting']['description']) . '</span>';
				endif;
				if (in_array( $setting['Setting']['name'], array('wallet.min_wallet_amount', 'wallet.max_wallet_amount', 'user.minimum_withdraw_amount', 'user.maximum_withdraw_amount', 'Project.maximum_amount','User.signup_fee', 'affiliate.site_commission_amount', 'affiliate.payment_threshold_for_threshold_limit_reach', 'Project.private_project_fee', 'Project.minimum_amount'))):
					$options['after'] = ' ' . Configure::read('site.currency'). '<span class="info"><i class="fa fa-info-circle"></i> ' . __l($setting['Setting']['description']) . '</span>';
				endif;
				if($setting['Setting']['name'] == 'Project.listing_fee'):
					$options['after'] = ' ' . '<span id="span_'.$setting["Setting"]["id"].'display">%</span>'.'<span class="info"><i class="fa fa-info-circle"></i> ' . __l($setting['Setting']['description']) . '</span>';
				endif;
				$findReplace = array(
					'##SITE_NAME##' => Configure::read('site.name'),
					'##MASTER_CURRENCY##' => $this->Html->link(Router::url('/', true).'admin/currencies', Router::url('/', true).'/admin/currencies', array('title' => __l('Currencies'))),
					'##USER_LOGIN##' => $this->Html->link(Router::url('/', true).'admin/user_logins', Router::url('/', true).'/admin/user_logins', array('title' => __l('User Logins'))),
					'##REGISTER##' => $this->Html->link('registration', '#', array('title' => __l('registration'))),
				);
				$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
				if (!empty($setting['Setting']['description']) && empty($options['after'])):
					$options['help'] = "{$setting['Setting']['description']}";
				endif;
				//default account
				if ($is_module) {
					if (!in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Affiliate, ConstModuleEnableFields::Friends))) {
						$options['class'] = 'js-disabled-inputs';
					} else {
						$options['class'] = 'js-disabled-inputs-active';
					}
				}
				if (!empty($is_submodule)) {
					if (in_array($setting['Setting']['setting_category_id'], array(ConstSettingsSubCategory::Commission))) {
						if (!in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Commission))) {
							$options['class'] = 'js-disabled-inputs';
						} else {
							$options['class'] = 'js-disabled-inputs-active';
						}
						if (!$active_submodule && !in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Commission))) {
							$options['disabled'] = 'disabled';
						}
					}
				}
				if($setting['Setting']['name'] == 'affiliate.payment_threshold_for_threshold_limit_reach') {
					$affliate_validation_id = $setting['Setting']['id'];
				}
				if ($setting['Setting']['name'] == 'Project.listing_fee') {
					$symbol_dispaly_id = $setting['Setting']['id'];
				}
				if ($setting['Setting']['name'] == 'Project.project_listing_fee_type') {
					$options['class']  = $options['class'] . ' js-fee-display {"currency":"' . Configure::read('site.currency') . '"}';
				}
				$options['class'] = $options['class'];
			?>
			<?php if ($options['type'] == 'radio') { ?>

			<?php $options['before'] = '<span>'.$setting['Setting']['label'].'</span>'; ?>				
				<div class="group-block">				
			<?php } ?>
			<?php
				if ($setting['SettingCategory']['id'] != 138) {
					if (in_array($setting['Setting']['id'], array(623,626))) {
						$options['label'].= " (" . Configure::read('site.currency') .")";
					}
					echo $this->Form->input("Setting.{$setting['Setting']['id']}.name", $options);

				}
			?>
			<?php if ($options['type'] == 'radio') { ?>
				</div>
			<?php } ?>
			<?php
				$inputDisplay = ($inputDisplay == 2) ? 0 : $inputDisplay;
				unset($options);
			endif;
			$i++;
			endforeach;
			if ($setting['SettingCategory']['id'] == 144) {
		?>
            </div>
			<div class="col-md-5 well">
                <h4 class="text-b"><?php echo __l('Configuration steps:'); ?></h4><br>
                <?php echo __l('1. To get your security credentials, login with amazon and go to '); ?><a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a><br><?php echo __l('2. To create bucket name go to '); ?><a target="blank" href="https://console.aws.amazon.com/s3/home">https://console.aws.amazon.com/s3/home</a><?php echo __l(' and click s3 link.'); ?>
            </div>
		<?php
			}
			if ($setting['SettingCategory']['id'] == 35) {
		?>
			</div>
			<div class="col-md-4 col-sm-8 text-center help well">				
				<h4 class="text-b blackc"><?php echo __l('Configuration steps:');?></h4>
				<?php echo __l('This is the site tracker script used for tracking and analyzing the data on how the people are getting into your website. e.g., <a target="blank" href="http://www.google.com/analytics">Google Analytics</a>, <a target="blank" href="https://kissmetrics.com">KISSmetrics</a>, <a target="blank" href="https://mixpanel.com">Mixpanel</a>, <a target="blank" href="https://quantcast.com">Quantcast</a>'); ?>				
			</div>
		<?php
			}
		?>
		</fieldset>
		<?php
			if (!empty($beyondOriginals)) {
				echo $this->Form->input('not_allow_beyond_original', array('label' => __l('Not Allow Beyond Original'),'type' => 'select', 'multiple' => 'multiple', 'options' => $beyondOriginals));
			}
			if (!empty($aspects)) {
				echo $this->Form->input('allow_handle_aspect', array('label' => __l('Allow Handle Aspect'),'type' => 'select', 'multiple' => 'multiple', 'options' => $aspects));
			}
		?>
		<div class="clearfix navbar-btn">
			<?php echo $this->Form->submit(__l('Update'),array ('class'=>'btn btn-info')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
	<?php else: ?>
		<div><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Settings')); ?></div>
	<?php endif; ?>
</div>