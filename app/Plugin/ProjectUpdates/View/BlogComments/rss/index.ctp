<?php
if (!empty($blogComments)) {
  foreach($blogComments as $blogComment) {
    echo $this->Rss->item(array() , array(
      'user' => $blogComment['User']['username'],
      'link' => array(
        'controller' => 'users',
        'action' => 'view',
        $blogComment['User']['username']
      ) ,
      'comment' => '<p>' . $this->Html->cText($blogComment['BlogComment']['comment']) . '</p>',
      'createdDate' => $this->Html->cDateTime($blogComment['BlogComment']['created'], false) ,
    ));
  }
}
?>

