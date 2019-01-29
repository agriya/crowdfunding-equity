<?php
  $type=isset($type)?$type:'';
  echo $this->requestAction(array('controller' => 'project_categories', 'action' => 'index', 'type' => $type, 'admin' => false), array('return'));
?>