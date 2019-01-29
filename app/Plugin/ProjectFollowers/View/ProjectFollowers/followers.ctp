<?php
  if (!empty($followers_id)):
    echo $this->Html->link("<i class='fa fa-check fa-fw'></i> ". __l('Following'), array('controller' => 'project_followers', 'action' => 'delete', $followers_id),array('class'=>"js-confirm js-add-remove-followers js-no-pjax js-unfollow",'escape' => false,'title'=>__l('Unfollow')));
  elseif (!empty($project_id)):
    echo $this->Html->link(__l('Follow'), array('controller' => 'project_followers', 'action' => 'add', $project_id),array('class' => "add_follower js-add-remove-followers", 'title'=>__l('Follow')));
  endif;
?>