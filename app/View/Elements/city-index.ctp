<?php
	$type=!empty($type)?$type:'';
	echo $this->requestAction(array('controller' => 'cities', 'action' => 'index', 'type' => $type, 'admin' => false), array('return'));
?>