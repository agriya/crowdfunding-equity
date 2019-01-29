<?php	
		echo $this->requestAction(array('controller' => 'projects', 'action' => 'project_pay_now', $this->request->data['Project']['id'], $this->request->data['Project']['form_field_step'], 'admin' => false), array('named' => array('step_id' => $this->request->data['Project']['form_field_step'], 'page' => $page, 'project_type' => $project_type), 'return'));
?>