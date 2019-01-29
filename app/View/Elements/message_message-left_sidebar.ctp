 <?php
    $is_starred =!empty($is_starred) ? $is_starred : '';
    $foldertype = !empty($folder_type) ? $folder_type : '';
	$compose = ($this->request->params['action'] == 'compose') ? 'compose' : '';
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'left_sidebar'), array('return', 'folder_type'  => $foldertype, 'compose' => $compose,'is_starred'=>$is_starred));
?>