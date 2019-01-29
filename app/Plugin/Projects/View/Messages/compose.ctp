<?php
  $bg_class = '';
  $text_class = "js-show-submit-block col-md-6";
  if (!empty($this->request->params['named']['message_type']) && $this->request->params['named']['message_type'] == 'inbox') {
    $bg_class = 'com-bg clearfix';
    $text_class = "js-show-submit-block col-md-6";
  }
  if (!empty($this->request->params['named']['is_activity'])) {
    $text_class = "js-show-submit-block col-md-5";
  }
?>
<div class="messages com-bg clearfix index <?php echo $bg_class;?>">
  <?php
    $avatar_flag = 0;
    $message_class = 'js-add-block hide';
    if (!empty($this->request->params['named']['message_type']) && $this->request->params['named']['message_type'] == 'inbox') {
      $redirect = Router::url(array('controller' => 'messages', 'action' => 'index'), true);
    } elseif (!empty($this->request->params['named']['message_type']) && $this->request->params['named']['message_type'] == 'dashboard') {
      $redirect = Router::url(array('controller' => 'users', 'action' => 'dashboard'), true);
    } elseif (!empty($this->request->params['named']['message_type']) && $this->request->params['named']['message_type'] == 'userview') {
      $redirect = Router::url(array('controller' => 'users', 'action' => 'view', $this->request->params['named']['redirect_username']), true);
    } else {
      $redirect = Router::url(array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), true);
    }
  ?>
  <?php if (empty($this->request->params['named']['reply_type'])) { ?>
    <h5><?php echo __l('Post Comment') ;?></h5>
  <?php } ?>
  <?php
    if (!empty($this->request->params['named']['reply_type']) and $this->request->params['named']['reply_type'] == 'quickreply') {
      echo $this->Form->create('Message', array('action' => 'compose'));
      echo $this->Form->input('quickreply', array('type' => 'hidden', 'value' => 'quickreply'));
    } else {
      echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'admin-form message-compose {"redirect_url":"'.$redirect.'"}'));
  ?>
  <div class="form-checkbox">
   <div class="media clearfix"> 
	   <div class="pull-left marg-top-20">
		<div class="img-contain-110 img-circle center-block">
			<?php echo $this->Html->getUserAvatar($logged_in_user['User'], 'normal_thumb'); ?>
	    </div>
	   </div>
   </div>
  <?php
    }
    if(!empty($this->request['data']['Message']['parent_message_id'])) {
		$parent_msg_id = $this->request['data']['Message']['parent_message_id'];
    } else {
		$parent_msg_id = 0;
    }
  ?>
  
	   <div class="col-md-9 navbar-btn js-msg-form-<?php echo $parent_msg_id ?>">
			<?php
			  echo $this->Form->input('project_id', array('type' => 'hidden'));
			  echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
			  if (!empty($this->request['data']['Message']['parent_message_id'])) {
				echo $this->Form->input('subject', array('type' => 'hidden'));
			  }
			  if (!empty($this->request['data']['Message']['parent_message_id'])) {
				$button_text = __l('Reply');
			  } else {
				$button_text = __l('Post Comment');
			  }
			  echo $this->Form->input('type', array('type' => 'hidden'));
			  if (!empty($this->request->params['named']['message_type']) && in_array($this->request->params['named']['message_type'], array('dashboard', 'userview'))) {
				echo $this->Form->input('redirect_url', array('type' => 'hidden', 'value' => $redirect));
			  }
			  if (!empty($project['Project']['user_id']) && $project['Project']['user_id'] == $this->Auth->user('id') && empty($this->request->params['named']['reply_type'])) {
				echo $this->Form->input('to', array('options' => $select_array, 'label' => false));
				echo $this->Form->input('message', array('type' => 'textarea', 'class'=> 'js-show-submit-block', 'label'=>false, 'placeholder' =>__l("Write a comment")));
				echo $this->Form->input('redirect_url', array('type' => 'hidden', 'value' => $redirect));
			  } else {
				if (!empty($this->request->params['named']['user'])):
				  echo $this->Form->input('to', array('type' => 'hidden', 'value' => $this->request->params['named']['user']));
				endif;
				echo $this->Form->input('message', array('type' => 'textarea', 'class'=> 'js-show-submit-block col-xs-12 navbar-btn', 'label'=>false, 'placeholder' => $button_text));
			  }
			  echo $this->Form->input('message_type', array('type' => 'hidden'));
			  echo $this->Form->input('root', array('type' => 'hidden'));
			  echo $this->Form->input('m_path', array('type' => 'hidden'));
			?>
			<div class="<?php echo $message_class;?>">
			  <?php
				if (empty($this->request->params['named']['reply_type'])):
				  if (!empty($project['Project']['user_id']) && $project['Project']['user_id'] == $this->Auth->user('id')) {
					echo $this->Form->input('is_private', array('type' => 'hidden'));
				  } else {
					echo $this->Form->input('is_private', array('label' => __l('Private')));
				  }
				endif;
				$message_class = 'btn';
				if (!empty($this->request->params['isAjax'])) {
				  $parent_message_id = !empty($this->request->data['Message']['parent_message_id']) ? $this->request->data['Message']['parent_message_id'] : '';
				  $message_class = "btn js-no-pjax js-toggle-show {'container':'js-quickreplydiv-" . $parent_message_id . "'}";
				}
			  ?>
			  <div class="submit-block clearfix <?php if(!empty($this->request->params['named']['projecttype_slug'])) { echo $this->request->params['named']['projecttype_slug']; } ?>">
				<div class="pull-left">
				<?php echo $this->Form->submit($button_text, array('class' => 'js-no-pjax btn btn-info','div'=>'submit span pull-left')); ?>
				<?php $parent_message_id = !empty($parent_message_id) ? $parent_message_id : ''; ?>
				<?php if (empty($this->request->params['named']['is_activity']) && (!empty($this->request->params['named']['user']) && !empty($this->request->params['named']['reply_type']))) { ?>
					<a class="btn btn-danger js-no-pjax js-toggle-reply-show {'container':'js-quickreplydiv-<?php echo $this->Html->cInt($parent_message_id, false); ?>','pid':'<?php echo $this->Html->cInt($parent_message_id, false); ?>'}" title="<?php echo __l('Cancel'); ?>" href="#"><?php echo __l('Cancel'); ?></a>
				<?php } ?>
				</div>
			  </div>
			</div>
		</div>
  <?php if (empty($this->request->params['named']['reply_type'])) { ?>
    </div>
  <?php } ?>
  <?php echo $this->Form->end(); ?>
</div>