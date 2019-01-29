<?php
echo $this->requestAction(array('controller' => 'blog_comments', 'action' => 'add', 'blog_id' => $blog_id, 'display' => 'activity', 'message_type' => $message_type, 'redirect_username' => $redirect_username), array('return'));
?>
