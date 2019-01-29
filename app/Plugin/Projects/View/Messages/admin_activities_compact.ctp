<?php
  if(!empty($this->request->params['named']['type'])) {
    $type = $this->request->params['named']['type'];
  } else {
    $type = 'user_messages';
  }
?>
<div class="messages index js-response js-responses">
<div class="row">
<?php echo $this->Form->create('Message' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section>
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
		$pledgeordonate = !empty($message['Project']['ProjectType'])?Configure::read('project.alt_name_for_'.$message['Project']['ProjectType']['slug'].'_past_tense_small'):'';
		$fundordonate = !empty($message['Project']['ProjectType'])?sprintf(__l('Opened for %s'), Configure::read('project.alt_name_for_'.$message['Project']['ProjectType']['slug'].'_present_continuous_small')):'';
  ?>
  <?php
				if (!isPluginEnabled('Idea') && $message['Message']['activity_id'] == ConstProjectActivities::ProjectRating) {
					continue;
				} elseif (!isPluginEnabled('ProjectUpdates') && $message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdate) {
					continue;
				} elseif (!isPluginEnabled('ProjectUpdates') && $message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdateComment) {
					continue;
				} elseif (!isPluginEnabled('ProjectFollowers') && $message['Message']['activity_id'] == ConstProjectActivities::ProjectFollower) {
					continue;
				}
            ?>
  <div>
    <?php
      if ($message['Message']['activity_id'] != ConstProjectActivities::StatusChange) {
        if ($message['Message']['activity_id'] != ConstProjectActivities::Fund || ($message['Message']['activity_id'] == ConstProjectActivities::Fund && (in_array($message['ProjectFund']['is_anonymous'], array(ConstAnonymous::None, ConstAnonymous::FundedAmount)) || $message['ActivityUser']['id'] == $this->Auth->user('id')))) {
          if (!empty($message['ActivityUser']['id'])) {
            echo $this->Html->link($this->Html->cText($message['ActivityUser']['username']), array('controller' => 'users', 'action' => 'view', $message['ActivityUser']['username'], 'admin' => false), array('title' => $message['ActivityUser']['username'], 'class' => 'js-tooltip', 'escape' => false));
          } else {
            echo __l('Anonymous');
          }
        } else {
          echo __l('Anonymous');
        }
      }
    ?>
    <?php if ($message['Message']['activity_id'] == ConstProjectActivities::Fund): ?>
      <?php echo $pledgeordonate; ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdate): ?>
      <?php echo __l('update posted'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdateComment): ?>
      <?php echo __l('commented on update');  ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectRating): ?>
      <?php echo __l('voted'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectComment): ?>
      <?php echo __l('commented on project'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectFollower): ?>
      <?php echo __l('following'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::FundCancel): ?>
      <?php echo sprintf(__l('%s canceled'), Configure::read('project.alt_name_for_pledge_singular_small')); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::StatusChange): ?>
      <?php
        $status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
		  'status_id' => $message['Message']['project_status_id'],
		  'project_type_id' => $message['Project']['project_type_id']
		));
        echo $reason =  $status_response->data['response'];
      ?>
    <?php endif; ?>
	<?php
		  echo $this->Html->link($this->Html->cText($message['Project']['name'],false), array('controller'=> 'projects', 'action' => 'view', $message['Project']['slug'], 'admin' => false), array('class' => 'js-tooltip', 'escape' => false, 'title' => $this->Html->cText($message['Project']['name'],false)));
		  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
	?>
	<span class="js-timestamp" title="<?php echo $time_format;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created'], false); ?></span>
</div>
  <?php
      endforeach;
    } else {
  ?>


      <div><i class="fa fa-exclamation-triangle"></i> <?php echo __l('No activities found');?></p>


  <?php }  ?>

</section>

<?php
echo $this->Form->end();
?>
</div>
</div>
