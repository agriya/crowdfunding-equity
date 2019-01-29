<?php
  if(!empty($project_fund_id)){
    echo $this->requestAction(array('controller' => 'messages', 'action' => 'index'), array('named' =>array('project_id'=>$project_id,'project_fund_id'=>$project_fund_id),'return'));
  }else{
    echo $this->requestAction(array('controller' => 'messages', 'action' => 'index'), array('named' =>array('project_id'=>$project_id),'return'));
  }
?>
