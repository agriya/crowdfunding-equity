<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="center-block clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner accordion-heading admin-panel-menu">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn btn-primary btm-sm js-show-panel accordion-toggle js-toggle-icon js-no-pjax clearfix"><i class="fa fa-user fa-fw"></i> <?php echo __l('Admin Panel'); ?><i class="fa fa-sort-desc fa-fw"></i></a>
			</div>
			<div class="accordion-body no-bor collapse navbar-btn" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block">
					<ul class="nav nav-tabs tabs tabs-span clearfix">
						<li class="tab"><?php echo $this->Html->link(__l('Actions'), '#admin-actions',array('class' => 'js-no-pjax', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('User Logins (%s)'), $this->Html->cInt($user['User']['user_login_count'])), array('controller' => 'user_logins', 'action' => 'index', 'user_id' => $user['User']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target'=>'#admin-user-logins','escape' => false)); ?></li>
					</ul>
					<article class="panel-container clearfix">
						<div class="col-md-12 tab-pane fade in active clearfix" id="admin-actions" class="show">
							<ul class="list-unstyled clearfix">
								<?php if (Configure::read('user.is_email_verification_for_register') and !$user['User']['is_email_confirmed']): ?>
								<li class="pull-left text-center">
								<?php echo $this->Html->link(__l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $user['User']['id'], 'admin' => true),array('class' => 'btn js-no-pjax', 'title' => __l('Resend Activation'))); ?>
								</li>
							  <?php endif; ?>
								<li class="pull-left text-center">
								  <?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i> '.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id'],'admin' => true), array('class' => 'btn js-edit js-no-pjax','escape'=>false, 'title' => __l('Edit')));?>
								</li>
								  <?php if($user['User']['role_id'] != ConstUserTypes::Admin){ ?>
								<li class="pull-left text-center">
								  <?php echo $this->Html->link('<i class="fa fa-times"></i> '.__l('Delete'), Router::url(array('action'=>'delete', $user['User']['id'],'admin'=> true),true).'?r='.$this->request->url, array('class' => 'btn js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?>
								</li>
								  <?php } ?>
								  <?php if (empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_openid_register'])): ?>
								<li class="pull-left text-center">
								  <?php echo $this->Html->link('<i class="fa fa-lock"></i> '.__l('Change password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('class' => 'btn js-no-pjax', 'escape'=>false,'title' => __l('Change password')));?>
								</li>
							  <?php endif; ?>
							</ul>
						</div>
						<div class="tab-pane fade in active" id="admin-user-logins" class="show"></div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>