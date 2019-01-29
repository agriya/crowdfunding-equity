<h5><?php echo __l('Recent activity ');?><i class="fa fa-rss"></i></h5>
<ul class="list-unstyled clearfix">
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
		$pledgeordonate = Configure::read('project.alt_name_for_'.$message['Project']['ProjectType']['slug'].'_past_tense_small');
		$fundordonate = sprintf(__l('Opened for %s'), Configure::read('project.alt_name_for_'.$message['Project']['ProjectType']['slug'].'_present_continuous_small'));
  ?>
  <li>
    <?php if ($message['Message']['activity_id'] == ConstProjectActivities::Fund): ?>
      <?php echo  $pledgeordonate; ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdate): ?>
      <?php echo __l('update posted'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectUpdateComment): ?>
      <?php echo __l('commented on update');  ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectRating): ?>
      <?php echo __l('voted'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectComment): ?>
      <?php echo __l('commented on project'); ?>
    <?php elseif ($message['Message']['activity_id'] == ConstProjectActivities::ProjectFollower): ?>
      <?php echo __l('started following'); ?>
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
  </li>
  <?php
      endforeach;
    } else {
  ?>
  <li>
    <div class="img-thumbnail text-center">
		<p><?php echo __l('No notifications available');?></p>
     </div>
  </li>
  <?php }  ?>
</ul>