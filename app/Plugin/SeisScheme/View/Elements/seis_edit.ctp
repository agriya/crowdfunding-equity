<?php
	echo $this->requestAction(array('controller' => 'seis_entries', 'action' => 'edit', $this->request->data['Project']['id']),array('return'));
?>