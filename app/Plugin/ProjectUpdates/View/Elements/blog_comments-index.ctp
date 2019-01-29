<?php
	$load_type = !empty($load_type) ? $load_type : '';
	echo $this->requestAction(array('controller' => 'blog_comments', 'action' => 'index', $blog_id, 'load_type' => $load_type), array('return'));
?>