<?php
  if (empty($is_idea)) {
    $is_idea = '';
  }
  if (empty($filter)) {
    $filter = '';
  }
  echo $this->requestAction(array('controller' => 'projects', 'action' => 'index', 'filter' => $filter, 'view' => 'discover', 'project_type' => $project_type, 'limit' => $limit, 'is_idea' => $is_idea), array('return'));
?>
