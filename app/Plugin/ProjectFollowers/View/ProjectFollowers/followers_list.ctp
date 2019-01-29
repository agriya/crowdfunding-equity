<h5><?php echo __l('Followers') . ' (' . $this->Html->cInt(!empty($projectFollowers[0]['Project']['project_follower_count']) ? $projectFollowers[0]['Project']['project_follower_count'] : '0') . ')'; ?></h5>
<ul class="list-unstyled row">
  <?php
      $following_user = 0;
    $current_user_follow = 0;
    $friends_count = 0;
    $bake_ids = array();
    $total_count = count($projectFollowerFriends) + count($projectFollowers);
    if (!empty($projectFollowerFriends)) {
      $friends_count = count($projectFollowerFriends);
      foreach($projectFollowerFriends as $projectFollowerFriend) {
  ?>
  <li class="text-center pull-left">
  <?php
      if (!empty($projectFollowerFriend['User']['id'])) {
        echo $this->Html->getUserAvatar($projectFollowerFriend['User'],'micro_thumb');
      } else {
        echo $this->Html->getUserAvatar(array(), 'micro_thumb', false, 'anonymous');
      }
      if($projectFollowerFriend['User']['id'] == $this->Auth->user('id')) {
        $following_user = 1;
      }
    ?>
  </li>
  <?php
      }
    }
    if ($friends_count < 5) {
      $remaining_count = 5 - $friends_count;
      $i = 1;
      if (!empty($projectFollowers)) {
        foreach($projectFollowers as $projectFund) {
          if(empty($following_user) && $projectFund['User']['id'] == $this->Auth->user('id')) {
            $following_user = 1;
          }
          if($i > $remaining_count){
            break;
          }
  ?>
  <li class="pull-left">
  <?php
          if (!empty($projectFund['User']['id'])) {
            echo $this->Html->getUserAvatar($projectFund['User'],'micro_thumb');
          } else {
            echo $this->Html->getUserAvatar(array(), 'micro_thumb', false, 'anonymous');
          }
          if(empty($current_user_follow) && $projectFund['User']['id'] == $this->Auth->user('id')) {
            $current_user_follow = 1;
          }
  ?>
  </li>
  <?php
          $i++;
        }
      }
    }
    if ($total_count < $total_follow) {
      $extra = $total_follow - $total_count;
  ?>
  <li class="img-thumbnail text-center pull-left "><?php echo $this->Html->link( $this->Html->cText('+' . $extra . ' ' . __l('More') . ' &#187;', false), array('controller' => 'projects', 'action' => 'view', $projectFollowers[0]['Project']['slug'], '#followers'), array('title' => __l('Show all Followers')));  ?></li>
  <?php
    }
    if (empty($projectFollowers) && empty($projectFollowerFriends) || (empty($following_user) && (count($projectFollowers) + count($projectFollowerFriends)) < 6 && empty($extra))) {
  ?>
   <li class="col-md-1 img-thumbnail text-center pull-left"><span class="show">
	<?php
		if($project['Project']['user_id'] == $this->Auth->user('id')){
			echo __l('X');
		} else {
			echo __l('You');
		}
	?>	
   </span><?php echo __l('Here');?></li>
  <?php } ?>
</ul>