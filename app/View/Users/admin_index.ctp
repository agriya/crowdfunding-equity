<?php /* SVN: $Id: admin_index.ctp 2883 2010-08-27 12:29:31Z sakthivel_135at10 $ */ ?>
<div class="main-admn-usr-lst js-response users-page">
	<div class="bg-primary row">
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($approved,false).'</span><span>' .__l('Active Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Inactive Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($site_users,false).'</span><span>' .__l('Site Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Site), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($openid,false).'</span><span>' .__l('OpenID Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::OpenID), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($facebook,false).'</span><span>' .__l('Facebook Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Facebook), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center twtr-usr">'.$this->Html->cInt($twitter,false).'</span><span>' .__l('Twitter Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Twitter), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center gml-usr">'.$this->Html->cInt($gmail,false).'</span><span>' .__l('Gmail Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Gmail), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center lkdn-usr">'.$this->Html->cInt($linkedin,false).'</span><span>' .__l('LinkedIn Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::LinkedIn), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center yho-usr">'.$this->Html->cInt($yahoo,false).'</span><span>' .__l('Yahoo! Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Yahoo), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center gol-usr">'.$this->Html->cInt($googleplus,false).'</span><span>' .__l('Google+ Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::GooglePlus), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center agl-usr">'.$this->Html->cInt($angellist,false).'</span><span>' .__l('AngelList Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::AngelList), array('escape' => false));?>
				</div>
			</li>
			<?php if(isPluginEnabled('Affiliates')) : ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center aff">'.$this->Html->cInt($affiliate_user_count,false).'</span><span>' .__l('Affiliate Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::AffiliateUser), array('escape' => false));?>
				</div>
			</li>
			<?php endif; ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center adm-usr">'.$this->Html->cInt($admin_count,false).'</span><span>' .__l('Admin Users'). '</span>', array('controller'=>'users','action'=>'index','main_filter_id' => ConstUserTypes::Admin), array('escape' => false));?>
				</div>
			</li>
			<?php if(isPluginEnabled('LaunchModes')) : ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center pr-lnc-usr">'.$this->Html->cInt($prelaunch_users,false).'</span><span>' .__l('Pre-launch Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Prelaunch), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center pri-bt-usr">'.$this->Html->cInt($privatebeta_users,false).'</span><span>' .__l('Private Beta Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::PrivateBeta), array('escape' => false));?>
				</div>
			</li>
			<?php endif; ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center tol-usr">'.$this->Html->cInt($total_users_count,false).'</span><span>' .__l('Total Users'). '</span>', array('controller'=>'users','action'=>'index'), array('escape' => false));?>
				</div>
			</li>
			<?php if(isPluginEnabled('LaunchModes')) : ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center sub-p-lnc">'.$this->Html->cInt($prelaunch_subscribed,false).'</span><span>' .__l('Subscribed for Pre-launch'). '</span>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center sub-p-b">'.$this->Html->cInt($privatebeta_subscribed,false).'</span><span>' .__l('Subscribed for Private Beta'). '</span>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false));?>
				</div>
			 </li>
			<?php endif; ?>
		</ul>
		<div class="clearfix marg-top-20 user-insights">
		<?php if(isPluginEnabled('Insights')) : ?>
			<div class="col-md-7">
				<h3 class="col-xs-12 no-mar">
					<?php echo  __l('User Insights'); ?> 
					<i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo __l('Filter and identify your users based on valuable data.'); ?>"></i>
				</h3>
				<?php
					echo $this->element('filter_options', array('filters' => $userinsight_filters));
				?>
			</div>
			<?php endif; ?>
			<div class="col-md-5">
				<div class="col-xs-12 top-space">
					<h4 class="h3 no-mar">
						<span class="h4 text-18"><?php echo  __l('Engagement Metrics'); ?> <i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo __l('Quick overview of how the users got engaged with the site.'); ?>"></i></span>
					</h4>
					<p class="h5 text-info"> 
						<?php echo  __l('Idle Users'). ' ('.$idle_users.'), '; ?>
						<?php echo  __l('Funded Users'). ' ('.$funded_users.'), '; ?>
						<?php echo  __l('Posted Users'). ' ('.$posted_users.'), '; ?>
						<?php echo  __l('Engaged Users'). ' ('.$engaged_users.'), '; ?>
						<?php echo  __l('Total Users'). ' ('.$total_users.')'; ?>
					</p>
				</div>
			</div>
		</div>	
	</div>	
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('User List');?> &nbsp;
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp;<span class="badge"><i class="fa fa-plus"></i></span></button>', array('controller' => 'users', 'action' => 'add'),array('title' =>  __l('Add'), 'class' => 'js-no-pjax', 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left top-space top-mspace grayc"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="navbar-right no-mar"> 
					<div class="col-sm-4 col-xs-12 input-group pull-left navbar-btn">
						<?php if (!empty($users)): ?>
							<?php echo $this->Html->link('<button class="btn btn-info text-center col-xs-12 col-sm-11 col-md-10 csv  btn-efcts"> <i class="fa fa-share-square-o"></i> '.__l('CSV').'</button>', array_merge(array('controller' => 'users', 'action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('title' => __l('CSV'),'escape'=>false, 'class' => 'js-no-pjax')); ?>
						<?php endif; ?>
					</div>
					<div class="col-sm-8 col-xs-12 form-group srch-adon navbar-btn">
						<?php
							$username = '';
							$user_placeholder = __l('User');
							if (!empty($this->request->query['username'])) {
							$username = $this->request->query['username'];
							$user_placeholder = $this->request->query['username'];
							}
						?>
						<?php echo $this->Form->create('User', array('type' => 'get', 'class' => 'form-search clearfix', 'url' => array_merge(array('controller'=>'users','action'=>'index', 'admin' =>true), $this->request->params['named']))); ?>
						<span class="form-control-feedback" id="basic-addon1"  aria-hidden="true"><i class="fa fa-search text-default"></i></span>
						<?php echo $this->Form->autocomplete('q', array('label' => false, 'placeholder' => $user_placeholder, 'acFieldKey' => 'User.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'form-control')); ?>
						<div class="hide">
							<?php echo $this->Form->submit(__l('Search'));?>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</li>
			</ul>
		</div>
		<?php echo $this->Form->create('User' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead class="h5">
					<tr>
						<th rowspan="2" class="text-center"><?php echo __l('Select'); ?></th>
						<th rowspan="2" class="text-center"><?php echo __l('Actions'); ?></th>
						<th rowspan="2" class="text-left"><?php echo $this->Paginator->sort('User.username', __l('User')); ?></th>
						<th colspan="2" class="text-center"><?php echo $this->Paginator->sort('project_count', sprintf(__l('%s posted'), Configure::read('project.alt_name_for_project_plural_caps'))); ?></th>
						<th colspan="2" class="text-center"><?php echo $this->Paginator->sort('project_fund_count', sprintf(__l('%s funded'), Configure::read('project.alt_name_for_project_plural_caps'))); ?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('User.site_revenue', __l('Site Revenue') . ' (' . Configure::read('site.currency') . ')'); ?></th>
						<?php if(Configure::read('User.signup_fee')): ?>
						<th rowspan="2" class="text-center"><?php echo __l('Sign Up Fee') . ' (' . Configure::read('site.currency') . ')'; ?></th
						><?php endif; ?>
						<?php if(!empty($is_wallet_enabled)): ?>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('available_wallet_amount', __l('Available Balance') . ' (' . Configure::read('site.currency') . ')'); ?></th>
						<?php endif; ?>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('referred_by_user_count', __l('Referred User Count')); ?></th>
						<th colspan="3" class="text-center"><?php echo $this->Paginator->sort('user_login_count', __l('Logins')); ?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('created', __l('Registered On')); ?></th>
						<th rowspan="2"><?php echo $this->Paginator->sort('ip', __l('Registered IP')); ?></th>
					</tr>
					<tr>
						<th class="text-center"><?php echo $this->Paginator->sort('project_count', __l('Count')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('total_needed_amount', sprintf(__l('Total %s Amount'), Configure::read('project.alt_name_for_project_singular_caps')). ' (' . Configure::read('site.currency') . ')'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('unique_project_fund_count', __l('Count')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('total_funded_amount', __l('Total Funded Amount'). ' (' . Configure::read('site.currency') . ')'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('user_login_count', __l('Count')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('last_logged_in_time', __l('Time')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('last_login_ip_id', __l('IP')); ?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($users)): ?>
					<?php foreach ($users as $user):
					if($user['User']['is_active']):
					$status_class = 'js-checkbox-active';
					$disabled = '';
					else:
					$status_class = 'js-checkbox-inactive';
					$disabled = ' class = disabled';
					endif;
					?>
						<tr <?php echo $disabled; ?>>
							<td class="text-center">
								<?php echo $this->Form->input('User.'.$user['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$user['User']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
							</td>
							<td class="text-center">
								<div class="dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog fa-lg grayc text-22"></i><span class="hide"><?php echo __('Action');?></span></a>
									<ul class="dropdown-menu">
										<?php if (Configure::read('user.is_email_verification_for_register') && !$user['User']['is_email_confirmed'] && $user['User']['is_active'] == 0 ): ?>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> ' . __l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $user['User']['id'], 'admin' => false),array('title' => __l('Resend Activation'), 'escape' => false)); ?>
										</li>
										<?php endif; ?>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-user fa-fw"></i> ' . __l('View Details'), array('controller' => 'users', 'action' => 'view_details', 'id' => $user['User']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax','id'=>'', 'escape' => false, 'title' => __l('View Details')));?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
										</li>
										<?php if($user['User']['role_id'] != ConstUserTypes::Admin){ ?>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $user['User']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
										</li>
										<?php } ?>
										<?php if (empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_openid_register'])): ?>
										<li>
											<?php echo $this->Html->link('<i class="fa fa-lock fa-fw"></i>'.__l('Change password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('escape'=>false,'title' => __l('Change password')));?>
										</li>
										<?php endif; ?>
										<?php echo $this->Layout->adminRowActions($user['User']['id']);  ?>
									</ul>
								</div>
							</td>
							<?php
							$reg_type_class='';
							$title = '';
							$icon_class = '';
							$icon_img = '';
							if(!empty($user['User']['is_facebook_register'])):
							$icon_class = 'fa fa-facebook-square facebookc';
							elseif(!empty($user['User']['is_twitter_register'])):
							$icon_class = 'fa fa-twitter-square twitterc fa-fw';
							elseif(!empty($user['User']['is_linkedin_register'])):
							$icon_class = 'icon-linkedin-sign linkedc';
							elseif(!empty($user['User']['is_google_register'])):
							$icon_class = 'icon-google-sign googlec';
							elseif(!empty($user['User']['is_googleplus_register'])):
							$icon_class = 'icon-google-plus-sign googlec';
							elseif(!empty($user['User']['is_yahoo_register'])):
							$icon_class = 'icon-yahoo yahooc';
							elseif(!empty($user['User']['is_openid_register'])):
							$icon_img = $this->Html->image('open-id.png', array('alt' => __l('[Image: OpenID]') ,'width' => 14, 'height' => 14, 'class' => 'text-12'));
							elseif(!empty($user['User']['is_angellist_register'])):
							$icon_img = $this->Html->image('angellist-icon.png', array('alt' => __l('[Image: AngeList]') ,'width' => 14, 'height' => 14, 'class' => 'text-12'));
							endif;
							?>
							<td class="text-left col-sm-3">
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($user['User'], 'micro_thumb',true, '', 'admin');?>
										<?php if(isPluginEnabled('Affiliates') && $user['User']['is_affiliate_user']):?>
											<span class="label label-info"><?php echo __l('Affiliate'); ?></span>
										<?php endif; ?>
										<?php if($user['User']['role_id'] == ConstUserTypes::Admin):?>
											<span class="label label-success"><?php echo __l('Admin'); ?></span>
										<?php endif; ?>
							     	</div>
								   <div class="media-body">
										<?php echo $this->Html->getUserLink($user['User']); ?>
										<?php if (empty($icon_img) && !empty($icon_class)) : ?>
											<i class="<?php echo $icon_class;?>"></i>
										<?php else:
											echo $icon_img;
										endif;
										?>
										<?php if(!empty($user['UserProfile']['Country'])): ?>
											<span class="pull-left flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['UserProfile']['Country']['name'], false); ?>"><?php echo $this->Html->cText($user['UserProfile']['Country']['name'], false); ?></span>
										<?php endif; ?>
										<p class="" title="">
											<?php if(!empty($user['User']['email'])):?>
													<?php
													/*if (strlen($user['User']['email']) > 20):
														echo '..' . substr($user['User']['email'], strlen($user['User']['email'])-15, strlen($user['User']['email']));
													else:*/
														echo $this->Html->cText($user['User']['email'], false);
													//endif;
													?>
											<?php endif; ?>
										</p>
									</div>
								</div>
							</td>
							<td class="text-center">
								<?php echo $this->Html->cInt($user['User']['project_count'],false);?>
							</td>
							<td class="text-center">
								<?php if(isset($user['User']['total_needed_amount'])) { echo $this->Html->cCurrency($user['User']['total_needed_amount']); } else { echo '-';}?>
							</td>
							<td class="text-center">
								<?php echo $this->Html->cInt($user['User']['unique_project_fund_count'],false);?>
							</td>
							<td class="text-center">
								<?php if(isset($user['User']['total_funded_amount'])) { echo $this->Html->cCurrency($user['User']['total_funded_amount']); } else { echo '-';}?>
							</td>
							<td class="text-center">
								<span class="label label-warning"><?php echo $this->Html->cCurrency($user['User']['site_revenue']);?></span>
							</td>
							<?php if(Configure::read('User.signup_fee')): ?>
							<td class="text-center">
								<?php if(isset($user['Transaction']['0']['amount'])) { echo $this->Html->cInt($user['Transaction']['0']['amount']); } else { echo '-';}?>
							</td>
							<?php endif; ?>
							<?php if(!empty($is_wallet_enabled)) :?>
							<td class="text-center">
								<?php if(isset($user['User']['available_wallet_amount'])) { echo $this->Html->cCurrency($user['User']['available_wallet_amount']); } else { echo '-';}?>
							</td>
							<?php endif; ?>
							<td class="text-center">
								<?php echo $this->Html->cInt($user['User']['referred_by_user_count'],false);?>
							</td>
							<td class="text-center">
								<?php echo $this->Html->link($this->Html->cInt($user['User']['user_login_count']), array('controller' => 'user_logins', 'action' => 'index', 'user_id' => $user['User']['id']), array('escape' => false));?>
							</td>
							<td class="text-center">
								<?php if($user['User']['last_logged_in_time'] == '0000-00-00 00:00:00' || empty($user['User']['last_logged_in_time'])){
									echo '-';
								}else{
									echo $this->Html->cDateTimeHighlight($user['User']['last_logged_in_time']);
								}?>
							</td>
							<td class="text-center">
								<?php if(!empty($user['LastLoginIp']['ip'])): ?>
									<?php echo  $this->Html->link($user['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $user['LastLoginIp']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$user['Ip']['ip'], 'escape' => false));
									?>
									<p>
										<?php
										if(!empty($user['LastLoginIp']['Country'])):
										?>
										<span class="flags flag-<?php echo strtolower($user['LastLoginIp']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['LastLoginIp']['Country']['name'], false); ?>">
										<?php echo $this->Html->cText($user['LastLoginIp']['Country']['name'], false); ?>
										</span>
										<?php
										endif;
										if(!empty($user['LastLoginIp']['City'])):
										?>
										<span>   <?php echo $this->Html->cText($user['LastLoginIp']['City']['name'], false); ?>  </span>
										<?php endif; ?>
									</p>
								<?php else: ?>
									<?php echo __l('n/a'); ?>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?>
							</td>
							<td class="text-center">
								<?php if(!empty($user['Ip']['ip'])): ?>
									<?php echo  $this->Html->link($user['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $user['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$user['Ip']['ip'], 'escape' => false));
								?>
								<p>
									<?php
									if(!empty($user['Ip']['Country'])):
									?>
										<span class="flags flag-<?php echo strtolower($user['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['Ip']['Country']['name'], false); ?>">
										<?php echo $this->Html->cText($user['Ip']['Country']['name'], false); ?>
										</span>
									<?php
									endif;
									if(!empty($user['Ip']['City'])):
									?>
										<span>   <?php echo $this->Html->cText($user['Ip']['City']['name'], false); ?>  </span>
									<?php endif; ?>
								</p>
								<?php else: ?>
								<?php echo __l('n/a'); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php
					endforeach; ?>
					<?php else:
					?>
						<tr>
							<td colspan="23" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Users'));?></td>
						</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
			<?php
			if (!empty($users)):
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">					
					<ul class="list-inline clearfix">
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Inactive'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Active'))); ?>
						</li>
						<li>
							<div class="admin-checkbox-button">
								<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('More actions'))); ?>
								<div class="hide">
									<?php echo $this->Form->submit('Submit'); ?>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 pull-right">
					<?php echo $this->element('paging_links'); ?>
				</div>	
			</div>
			<?php
			endif;
			echo $this->Form->end();
			?>
		</div>
	</div>
	
</section>
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			
		</div>
	</div>
</div>