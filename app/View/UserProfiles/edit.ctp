<?php if (!(isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {?>
<div class="container">
  <div class="page-header ver-space no-border no-mar"><h2 class="top-mspace"><?php echo sprintf(__l('Edit Profile - %s'), $this->request->data['User']['username']); ?></h2></div>
<?php } ?>
<div class="js-response">
	<div class="show new-admin-form admin-form ver-space ver-mspace user-block">
	<?php if ((isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {?>
	<?php
	  if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit'):
	  $active ='active';
	  else:
	  $active =' ';
	  endif;
	?>
	<ul class="breadcrumb">
		<li><?php echo $this->Html->link(__l('Users'), array('controller'=>'users', 'action' => 'index'), array('title' => __l('Users')));?><span class="divider">&raquo</span></li>
		<li class="active"><?php echo sprintf(__l('Edit %s'), __l('User Profile'));?></li>
	</ul>
	<ul class="nav nav-tabs">
		<li class="icon index_collection_link">
			<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller'=>'users','action' => 'index','admin'=>true),array('title' => __l('Users'),'escape'=>false));?>
		</li>
		<li class="icon new_collection_link <?php echo $active;?>">
			<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $this->request->data['User']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
		</li>
	</ul>
	<?php if(empty($this->request->params['admin'])) {?>
	<h2><?php echo sprintf(__l('Edit Profile - %s'), $this->request->data['User']['username']); ?></h2>
	<?php } ?>
	<?php } ?>
	<?php echo $this->Form->create(null, array('url' => array('controller' => 'user_profiles', 'action' => 'edit', $this->request->data['User']['id']) ,'class' => 'form-horizontal user-profile form-large-fields {"url":"UserAvatar/'.$this->request->data['User']['id'].'/"}', 'enctype' => 'multipart/form-data'));?>
    <fieldset>
        <legend class="hor-space"><?php echo __l('Personal Info');?></legend>
		<div class="gray-bg clearfix">
			<div class="col-md-2 col-sm-4 navbar-right change-img">
				<?php echo $this->Html->getUserAvatar($this->request->data['User'], 'user_thumb'); ?>
					<?php if (isPluginEnabled('SocialMarketing')): ?>
						<div class="text-center"><?php echo $this->Html->link(__l('Change Image'), array('controller' => 'user_profiles', 'action' => 'profile_image',$this->request->data['User']['id'], 'admin' => false)); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-md-9 col-sm-8 pull-left col-xs-12">
				<?php
					if($this->Auth->user('role_id') == ConstUserTypes::Admin):
								echo $this->Form->input('User.id');
					endif;
					if($this->request->data['User']['role_id'] == ConstUserTypes::Admin):				
					  echo $this->Form->input('User.username',array('label'=>__l('Username')));			  
					endif;			
					if($this->Auth->user('role_id') == ConstUserTypes::Admin):
					  echo $this->Form->input('User.email',array('label'=>__l('Email'), 'class' => 'form-control'));
					endif;
					echo $this->Form->input('first_name', array('label'=>__l('First Name'), 'class' => 'form-control'));
					echo $this->Form->input('last_name' , array('label'=>__l('Last Name'), 'class' => 'form-control'));
					echo $this->Form->input('middle_name', array('label'=>__l('Middle Name'), 'class' => 'form-control'));
					echo $this->Form->input('gender_id', array('empty' => __l('Please Select'), 'label'=>__l('Gender'), 'class' => 'form-control'));
				?>
				<div class="input select">
					<div class="js-datetime <?php if($this->Auth->user('role_id') != ConstUserTypes::Admin) { ?> required <?php } ?>">
						<div class="js-cake-date">
							<?php echo $this->Form->input('dob', array('label' => __l('DOB'),'empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->input('about_me', array('label'=>__l('About me'),'class' => 'form-control')); ?>
			</div>
		</div>
    </fieldset>
    <?php
		$response = Cms::dispatchEvent('View.User.additionalFields', $this, array(
			'data' => $this->request->data
		));
		echo !empty($response->data['content'])?$response->data['content']:'';
    ?>
    <?php
    $response = '';
        $response = Cms::dispatchEvent('View.UserProfile.additionalFields', $this, array(
           'data' => $this->request->data
           ));

        ?>
        <?php if(!empty($response->data['content_jobs_act'])):?>
    <fieldset>
        <div>
			<?php   echo $response->data['content_jobs_act'];?>
        </div>
    </fieldset>
	<?php endif;?>
	<?php if(!empty($response->data['content'])):?>
	<fieldset>
		<div>
			<?php   echo $response->data['content'];?>
		</div>
	</fieldset>
	<?php endif;?>
    <fieldset>
		<legend><?php echo __l('Address');?></legend>
		<div class="gray-bg clearfix">
			<div class="pull-left auto-comp col-md-9 col-sm-8 col-xs-12">
                <?php
					echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'UserAddressSearch', 'info' => __l('You must select address from autocomplete')));
                ?>
				<?php
					$class = '';
					if (empty($this->request->data['UserProfile']['address']) || ( !empty($this->request->data['UserProfile']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['UserProfile']['country_id']))) {
					  $class = 'hide';
					}
				?>
				<?php
					echo $this->Form->input('User.latitude', array('id' => 'latitude', 'type' => 'hidden'));
					echo $this->Form->input('User.longitude', array('id' => 'longitude', 'type' => 'hidden'));
					echo $this->Form->input('address1', array('id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
					echo $this->Form->input('City.name', array('type' => 'text', 'label' => __l('City')));
					echo $this->Form->input('State.name', array('type' => 'text', 'label' => __l('State')));
					echo $this->Form->input('country_id',array('id'=>'js-country_id', 'label' => __l('Country'), 'empty' => __l('Please Select'), 'selected' => ((!empty($this->request->data['UserProfile']['Country']['iso_alpha2']))? $this->request->data['UserProfile']['Country']['iso_alpha2'] : '')));
				?>
				<?php
					echo $this->Form->input('zip_code', array('label'=>__l('Zip Code'), 'type' => 'text'));
				?>
				<div id="mapblock">
					<div id="mapframe">
						<div id="mapwindow"></div>
					</div>
				</div>
			</div>
			<div class="navbar-right map-img col-md-3 col-sm-4">
				<div class="js-side-map-div js-side-map-profile">
					<h5><?php echo __l('Point Your Location');?></h5>
					<div class="js-side-map">
						<div id="js-map-container"></div>
						<span><?php echo __l('Point the exact location in map by dragging marker');?></span>
					</div>
				</div>
			</div>
		</div>
    </fieldset>
	<fieldset>
		<legend><?php echo __l('Websites');?></legend>
        <div class="gray-bg clearfix">
			<div class="js-clone">			
				<?php if(empty($this->request->data['UserWebsite'])): ?>
				<div class="website-block js-field-list col-xs-12">
					<div class="pull-left col-sm-9 col-xs-12"><?php echo $this->Form->input('UserWebsite.0.website', array('class'=>'home js-remove-error', 'label'=>__l('Website'))); ?></div>
					<span class ="js-add-more js-no-pjax btn mspace btn-info clone-add cur"><?php echo '<i class="fa fa-plus-circle fa-fw"></i>'.__l('Add More'); ?></span>
				</div>
				<?php else:  ?>
				<?php foreach( $this->request->data['UserWebsite'] as $key => $userWebsite): ?>
				<div class="phone-block js-field-list">
					<?php if($key):?>
					<span class="js-website-remove js-no-pjax btn clone-remove pull-right cur"><?php echo '<i class="fa fa-times"></i>'.__l('Remove'); ?></span>
					<?php endif;?>
					<?php echo $this->Form->input('UserWebsite.'.$key.'.website',  array('class'=>'home js-remove-error', 'label'=>__l('Website'))); ?>
				</div>
				<?php endforeach;?>
				<?php endif;?>
			</div>
		</div>
	</fieldset>
    <fieldset>
		<legend><?php echo __l('Other');?></legend>
		<div class="gray-bg clearfix">
			<div class="col-md-9 col-sm-8 admin-checkbox">
				<?php echo $this->Form->input('language_id', array('empty' => __l('Please Select'), 'label'=>__l('Language')));?>
				<?php
					echo $this->Form->input('UserAvatar.filename', array('type' => 'file', 'label' => __l('Upload Photo'), 'id' => 'js-trigger-normal-upload', 'class' => "browse-field {'Uallowedsize':'5'}", 'data-allowed-extensions' => 'jpg,jpeg,png,gif', 'data-allowed-maxfile' => '1'));
				?>
				<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
				<?php
					echo $this->Form->input('User.is_active', array('label' => __l('Active')));
					echo $this->Form->input('User.is_email_confirmed', array('label' => __l('Email Confirmed')));
				?>
				<?php endif; ?>
			</div>
		</div>
    </fieldset>
	<?php if(isPluginEnabled('SecurityQuestions') && $this->request->data['User']['security_question_id'] == 0 && $this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
	<?php if(empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && empty($this->request->data['User']['is_twitter_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_angellist_register']) && empty($this->request->data['User']['is_googleplus_register'])):?>
    <fieldset>
        <legend><?php echo __l('Security Question'); ?></legend>
        <div class="alert alert-info clearfix">
			<?php
				echo sprintf(__l('Setting a security question helps us to identify you as the owner of your %s account.'),Configure::read('site.name'));
			?>
        </div>
        <div class="clearfix">
			<?php
				echo $this->Form->input('User.security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
				echo $this->Form->input('User.security_answer', array('label' => __l('Answer')));
			?>
        </div>
    </fieldset>
	<?php endif; ?>
	<?php endif; ?>
		<table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
		<div class="form-actions gray-bg navbar-btn">
			<?php echo $this->Form->submit(__l('Update'), array('id'=>'js-upload-button', 'class'=>'btn btn-info')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
		<?php      if (!(isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
		?>
	<?php } ?>
	</div>
</div>
</div>