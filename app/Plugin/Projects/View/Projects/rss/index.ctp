<?php /* SVN: $Id: index.ctp 12757 2010-07-09 15:01:40Z jayashree_028ac09 $ */ ?>
  <?php if(!empty($projects)): ?>
      <?php
        foreach($projects as $project):
          $project_image = '';
          if(!empty($project['Attachment'])):
		    $image_url = getImageUrl('Project',$project['Attachment'], array('full_url' => true, 'dimension' => 'big_thumb'));
			$project_image = '<img src="'.$image_url.'" alt="'. sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)) .'" title="'. $this->Html->cText($project['Project']['name'], false) .'">';
          endif;
          $project_image = (!empty($project_image)) ? '<p>'.$project_image.'</p>':'';

          echo $this->Rss->item(array() , array(
              'title' => $project['Project']['name'],
              'link' => array(
                'controller' => 'projects',
                'action' => 'view',
                $project['Project']['slug']
              ) ,
              'description' => array(
				'value' => $project_image.'<p>'.$this->Html->cText($project['Project']['short_description']).'</p>',
				'cdata' => true,
				'convertEntities' => false,
			   )
            ));
        endforeach;
      ?>
  <?php endif; ?>
