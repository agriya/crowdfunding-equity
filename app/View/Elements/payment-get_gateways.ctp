<?php
	$project_type = !empty($project_type) ? $project_type : '';
	$transaction_type = !empty($transaction_type) ? $transaction_type : '';
	$foreign_id = !empty($foreign_id) ? $foreign_id : '';
	$user_id = !empty($user_id) ? $user_id : '';
	echo $this->requestAction(array('controller' => 'payments','action' => 'get_gateways'), array('named' =>array('model' => $model, 'type' => $type, 'foreign_id' => $foreign_id, 'transaction_type' => $transaction_type, 'is_enable_wallet' => $is_enable_wallet, 'project_type' => $project_type,'user_id'=>$user_id, 'return_data'=>$this->request->data), 'return'));
?>