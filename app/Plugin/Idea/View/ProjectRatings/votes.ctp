<h5><?php echo __l('Voters').' ('.$this->Html->cInt(!empty($projectRatings[0]['Project']['project_rating_count']) ? $projectRatings[0]['Project']['project_rating_count'] : '0').')';  ?></h5>
<ul class="list-unstyled row">
  <?php if (!empty($projectRatings)) :?>
    <?php foreach($projectRatings as $projectRating) :?>
      <li><span class="round-block"><?php echo $this->Html->getUserAvatar($projectRating['User'], 'micro_thumb'); ?></span></li>
    <?php endforeach; ?>
    <?php if(count($projectRatings) > 12):?>
      <?php echo $this->Html->link(__l(' Show all voters'), array('controller' => 'project_funds', 'action' => 'index', 'project_id' => $project['Project']['id']), array('title' =>  __l('Show all voters'), 'rel' => 'address:/votes')); ?>
    <?php endif; ?>
  <?php else:?>
    <li>
	<div class="img-thumbnail text-center">
		<p><?php echo sprintf(__l('No %s available'), __l('Voters'));?></p>
     </div>
  <?php endif; ?>
</ul>