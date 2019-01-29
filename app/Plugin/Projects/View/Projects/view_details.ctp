<h4 class="about"><?php echo sprintf(__l('About this %s'), Configure::read('project.alt_name_for_project_singular_small')); ?> </h4>
<?php if(!empty($project['Project']['short_description'])): ?>
   <p><?php echo $this->Html->cHtml($project['Project']['short_description']);?></p>
<?php endif; ?>
<?php if(!empty($project['Project']['description'])): ?>
<p><?php echo $this->Html->cHtml($project['Project']['description']);?></p>
<?php endif; ?>
<?php if(!empty($project['Project']['video_embed_code'])):
  echo $this->Html->cText($project['Project']['video_embed_code'], false);
endif;?>
<p class="location">
  <?php
  $location = array();
  $place = '';
  if (!empty($project['User']['UserProfile']['City']['name'])) :
  $location[] = $project['User']['UserProfile']['City']['name'];
  endif;
  if (!empty($project['User']['UserProfile']['Country']['name'])) :
  $location[] = $project['User']['UserProfile']['Country']['name'];
  endif;
  $place = implode(', ', $location);
  if ($place) :
  echo sprintf(__l('%s location:'), Configure::read('project.alt_name_for_project_singular_caps')) . ' '.$place;
  endif;
  ?>
</p>