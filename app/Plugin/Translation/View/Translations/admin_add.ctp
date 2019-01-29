<?php /* SVN: $Id: admin_add.ctp 68881 2011-10-13 09:47:54Z josephine_065at09 $ */ ?>
<div class="translations form">
<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal admin-form'));?>
  <?php
    echo $this->Form->input('from_language', array('label'=>__l('From Language')), array('value' => __l('English'), 'disabled' => true));
    echo $this->Form->input('language_id', array('label' => __l('To Language')));?>

    <?php
    if(Configure::read('google.translation_api_key')):
      $disabled = false;
    else:
      $disabled = true;
    endif; ?>
    <div class="clearfix">
      <div>
        <div>
          <?php
          echo $this->Form->submit(__l('Manual Translate'), array('name' => 'data[Translation][manualTranslate]', 'class' => 'btn btn-info'));
          ?>
        </div>
         <div class="alert alert-info pull-left marg-top-20"><?php echo __l('It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.');?>
          </div>

      </div>
      <div class="clearfix">
        <div>
        <?php echo $this->Form->submit(__l('Google Translate'), array('name' => 'data[Translation][googleTranslate]', 'class' => 'btn btn-info', 'disabled' => $disabled));  ?>
        </div>
		<div class="pull-left marg-top-20">
			<span class="info"><i class="fa fa-info-circle"></i> <?php echo __l('It will automatically translate site labels into selected language with Google. You may then edit necessary labels.');?> </span>
			<?php if(!Configure::read('google.translation_api_key')): ?>
			<div class="alert alert-info">
				<?php echo __l('Google Translate service is currently a paid service and you\'d need API key to use it.');?> <?php echo __l('Please enter Google Translate API key in ');echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', 'Translation'), array('title' => __l('Settings'))). __l(' page');?>
			</div>
			<?php endif; ?>
		</div>
      </div>
  </div>
<?php echo $this->Form->end();?>
</div>

