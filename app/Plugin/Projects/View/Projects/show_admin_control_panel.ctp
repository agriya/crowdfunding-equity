<?php
	echo $this->element('admin_panel_project_view', array('controller' => 'projects', 'action' => 'index', 'project' =>$project), array('plugin' => 'Projects'));
?>