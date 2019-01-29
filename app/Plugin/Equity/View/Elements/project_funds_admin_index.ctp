<?  
    $q = !empty($this->request->data['ProjectFund']['q']) ? $this->request->data['ProjectFund']['q'] : '';
    $type = !empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '';
    if(!empty($this->request->params['named']['project_id']))
    {
    $project_id = $this->request->params['named']['project_id'];
    echo $this->requestAction(array('controller' => 'equities', 'action' => 'fund_index', 'admin' => true, 'type' => $type, 'project_id' => $project_id, 'q' => $q), array('return'));
    }
    else
    {
    echo $this->requestAction(array('controller' => 'equities', 'action' => 'fund_index', 'admin' => true, 'type' => $type, 'q' => $q, 'page'=> 2), array('return'));
    }
?>