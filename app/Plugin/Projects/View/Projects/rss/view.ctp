<?php
if (!empty($project)) :
    echo $this->Rss->item(array() , array(
      'title' => $project['Project']['name'],
      'link' => array(
        'controller' => 'projects',
        'action' => 'view',
        $project['Project']['slug']
      ) ,
      'description' => '<img alt = "'.sprintf(__l('[Image: %s]'),  $project['Project']['name']).'" src="'.Router::url('/') . getImageUrl('Project',$project['Attachment'], array('full_url' => true, 'dimension' => 'big_thumb')).'" /><p>' . $this->Html->cHtml($this->Html->truncate($project['Project']['short_description'])) . '</p>',
    ));
endif;
?>