<?php
	$is_home = empty($this->request->url) ? 1 : 0;
	echo $this->requestAction(array('controller' => 'pages', 'action' => 'view', 'home-banner', 'is_home' => $is_home, 'admin' => false), array('return'));
?>