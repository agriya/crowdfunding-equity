<?php
echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' =>array('user'=>$user, 'project_id'=>$project['id'],'projecttype_slug'=>$projecttype_slug, 'funded_id' => !empty($this->request->params['named']['funded_id'])?$this->request->params['named']['funded_id']:''),'return'));
?>
