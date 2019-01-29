<?php
  if (empty($is_idea)) {
    $is_idea = '';
  }
  $city = !empty($this->request->params['named']['city']) ? $this->request->params['named']['city'] : '';
  echo $this->requestAction(array('controller' => 'projects', 'action' => 'index', 'type' => 'funding', 'project_type' => $project_type, 'view' => 'home', 'city' => $city, 'limit' => $limit, 'is_idea' => $is_idea), array('return'));
?>