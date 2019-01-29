<?php
  if (empty($reward_id) || !isPluginEnabled('ProjectRewards')) {
    $reward_id = '';
  }
  echo $this->requestAction(array('controller' => 'project_funds', 'action' => 'index', 'project_id' => $project_id, 'reward_id' => $reward_id, 'project_type'=>$project_type,'type' => 'backers', 'admin' => false), array('return'));
?>