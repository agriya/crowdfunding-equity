<?php
    echo $this->requestAction(array('controller' => 'messages', 'action' => 'activities', 'type' => 'user', 'info' => $this->Auth->user('id'), 'admin' => false), array('return'));
?>