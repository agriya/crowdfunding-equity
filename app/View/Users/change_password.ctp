<?php if (empty($this->request->params['prefix'])){ ?>
<div class="container social-myconnect setting-drop-menu">
	<div class="clearfix user-heading">
		<h3 class="col-xs-8 col-sm-6 h2 text-uppercase navbar-btn"><?php echo __l('Change Password'); ?></h3>
		<div class="col-xs-4 col-sm-6 h2 navbar-btn">
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
	</div>
	<?php } ?>
	<div class="clearfix gray-bg admin-form">
		<?php if (empty($this->request->params['prefix'])): ?>
		<div class="main-section">
		<?php endif; ?>
		<?php echo $this->Form->create('User', array('action' => 'change_password' ,'class' => 'form-horizontal')); ?>
		<fieldset class="clearfix">
			<div>
				<?php
					if($this->Auth->user('role_id') == ConstUserTypes::Admin) :
					echo $this->Form->input('user_id', array('empty' => __l('Select'), 'label' => __l('User')));
					endif;
					if($this->Auth->user('role_id') != ConstUserTypes::Admin) :
					echo $this->Form->input('user_id', array('type' => 'hidden'));
					echo $this->Form->input('old_password', array('type' => 'password','label' => __l('Old password') ,'id' => 'old-password'));
					endif;
					echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') , 'id' => 'new-password'));
					echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password')));
				?>
			</div>
		</fieldset>
		<div class="form-actions"><?php echo $this->Form->submit(__l('Change Password'), array('class'=>'btn btn-info'));?></div>
			<?php echo $this->Form->end();?>
			<?php if (empty($this->request->params['prefix'])): ?>
		</div>
		<?php endif; ?>
	</div>
</div>	