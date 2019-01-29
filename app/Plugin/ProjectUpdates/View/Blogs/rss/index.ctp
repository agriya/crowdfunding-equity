<?php
if (!empty($blogs)) {
  foreach($blogs as $blog) {
    echo $this->Rss->item(array() , array(
      'title' => $blog['Blog']['title'],
      'link' => array(
        'controller' => 'blogs',
        'action' => 'view',
        $blog['Blog']['slug']
      ) ,
      'description' => '<p>' . $this->Html->cHtml($this->Html->truncate($blog['Blog']['content'])) . '</p>',
      'createdDate' => $this->Html->cDateTime($blog['Blog']['created'], false) ,
    ));
  }
}
?>