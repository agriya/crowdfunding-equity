<?php
  $project_type = !empty($project_type)? strtolower($project_type) : $this->request->params['named']['project_type'];
  $btn_color_class = "btn-primary label-info";
  $btn_default_class = "btn-primary label-default";
  $spanClass = '';
  if (empty($target)) {
    $target = '';
  }
?>
<?php if($this->request->params['action'] != 'activities'): ?>
  <?php if($is_view): ?>
    <h3 class="h4 txt-center-mbl roboto-bold text-center"><?php echo __l('Vote Now');?> </h3>
    <div>
  <?php else: ?>
    <?php $spanClass = ''; ?>
    <h4 class="clearfix text-center text-muted"> <?php echo __l('Vote Now');?> </h4>
  <?php endif; ?>
<?php endif; ?>
<?php $current_rating_percentage = $current_rating*20;
if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>

<div class='alpv-<?php echo $project_id;?> hide'> <?php //after login project vote?>
	<ul class="<?php if ($canRate): ?> starnew-rating <?php endif; ?> list-inline text-center clearfix <?php echo  $project_type; ?>">
      <?php $rating = !empty($rating)?$rating:'0'; ?>
      <?php
        if ($this->request->params['plugin'] == 'projects' && $this->request->params['action'] == 'view') {
          $ratingclass = '';
        } else {
          //$ratingclass = 'js-no-pjax js-rating'; // Todo: The flash message displayed inside the project layout, so removed the class 'js-rating'
          $ratingclass = 'js-no-pjax';
        }
      ?>
      <?php $btn_class = ($current_rating >= 1) ? $btn_default_class : $btn_color_class; ?>
      <li class ="text-center <?php echo $spanClass; ?> "><?php echo $this->Html->link('1', array('controller' => 'project_ratings', 'action' => 'add', $project_id, 1, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-no-pjax js-tooltip '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+1 votes')))?></li>
      <?php $btn_class = ($current_rating >=2)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('2', array('controller' => 'project_ratings', 'action' => 'add', $project_id,2, 'project_type' => $project_type), array('class' => 'btn btn-sm    js-no-pjax js-tooltip '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+2 votes')))?></li>
      <?php $btn_class = ($current_rating >=3)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('3', array('controller' => 'project_ratings', 'action' => 'add', $project_id,3, 'project_type' => $project_type), array('class' => 'btn btn-sm    js-no-pjax js-tooltip '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+3 votes')))?></li>
      <?php $btn_class = ($current_rating >=4)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('4', array('controller' => 'project_ratings', 'action' => 'add', $project_id,4, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-no-pjax js-tooltip '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+4 votes')))?></li>
      <?php $btn_class = ($current_rating >=5)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('5', array('controller' => 'project_ratings', 'action' => 'add', $project_id,5, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-no-pjax js-tooltip '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+5 votes')))?></li>
    </ul>
</div>
<div class='alpuv-<?php echo $project_id;?> hide'> <?php //after login project already voted?>
	<ul class="<?php if ($canRate): ?> starnew-rating <?php endif; ?> list-inline text-center clearfix <?php echo  $project_type; ?>">
      <?php $rating = !empty($rating) ? $rating : '0'; ?>
      <?php $btn_class = ($current_rating >=1)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center <?php echo $spanClass; ?> "><?php echo $this->Html->link('1', array('controller' => 'project_ratings', 'action' => 'add', $project_id, 1, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-no-pjax js-tooltip '.$btn_class, 'target' => $target, 'title' => __l('+1 votes')))?></li>
      <?php $btn_class = ($current_rating >=2)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('2', array('controller' => 'project_ratings', 'action' => 'add', $project_id,2, 'project_type' => $project_type), array('class' => 'btn btn-sm    js-no-pjax js-tooltip '.$btn_class, 'target' => $target, 'title' => __l('+2 votes')))?></li>
      <?php $btn_class = ($current_rating >=3)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('3', array('controller' => 'project_ratings', 'action' => 'add', $project_id,3, 'project_type' => $project_type), array('class' => 'btn btn-sm    js-no-pjax js-tooltip '.$btn_class, 'target' => $target, 'title' => __l('+3 votes')))?></li>
      <?php $btn_class = ($current_rating >=4)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('4', array('controller' => 'project_ratings', 'action' => 'add', $project_id,4, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-no-pjax js-tooltip '.$btn_class, 'target' => $target, 'title' => __l('+4 votes')))?></li>
      <?php $btn_class = ($current_rating >=5)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('5', array('controller' => 'project_ratings', 'action' => 'add', $project_id,5, 'project_type' => $project_type), array('class' => 'btn btn-sm  js-no-pjax js-tooltip '.$btn_class, 'target' => $target, 'title' => __l('+5 votes')))?></li>
    </ul>
</div>
<div class='blpv-<?php echo $project_id;?> hide'> <?php //BEFORE login project vote?>
<ul class=" <?php if ($canRate): ?> starnew-rating <?php endif; ?> list-inline text-center no-link-vote clearfix <?php echo  $project_type; ?>">
      <?php $rating = !empty($rating)?$rating:'0'; ?>
      <?php $btn_class = ($current_rating >=1)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center btn btn-sm   js-tooltip <?php echo $spanClass.' '.$btn_class ;?>" title ="<?php echo (!empty($rate_msg))? $rate_msg :__l('+1 votes');?>">1</li>
        <?php $btn_class = ($current_rating >=2)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center btn btn-sm    js-no-pjax js-tooltip <?php echo $btn_class ;?>" title ="<?php echo (!empty($rate_msg))? $rate_msg :__l('+2 votes');?>">2</li>
        <?php $btn_class = ($current_rating >=3)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center btn btn-sm    js-no-pjax js-tooltip <?php echo $btn_class ;?>" title ="<?php echo (!empty($rate_msg))? $rate_msg :__l('+3 votes');?>">3</li>
        <?php $btn_class = ($current_rating >=4)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center btn btn-sm   js-no-pjax js-tooltip <?php echo $btn_class ;?>" title ="<?php echo (!empty($rate_msg))? $rate_msg :__l('+4 votes');?>">4</li>
        <?php $btn_class = ($current_rating >=5)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center btn btn-sm   js-no-pjax js-tooltip <?php echo $btn_class ;?>" title ="<?php echo (!empty($rate_msg))? $rate_msg :__l('+5 votes');?>">5</li>
    </ul>
</div>
<?php } else {
 if ($this->Auth->sessionValid() && $canRate): ?>
    <ul class="<?php if ($canRate): ?> starnew-rating <?php endif; ?> list-inline text-center clearfix <?php echo  $project_type; ?>">
      <?php $rating = !empty($rating)?$rating:'0'; ?>
      <?php	
        if ($this->request->params['plugin'] == 'projects' && $this->request->params['action'] == 'view') {
          $ratingclass = '';
        } else {
          //$ratingclass = 'js-rating'; // Todo: The flash message displayed inside the project layout, so removed the class 'js-rating'
	  $ratingclass = '';
        }
      ?>
      <?php $btn_class = ($current_rating >= 1) ? $btn_default_class : $btn_color_class; ?>
      <li class ="text-center <?php echo $spanClass; ?>"><?php echo $this->Html->link('1', array('controller' => 'project_ratings', 'action' => 'add', $project_id, 1, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+1 votes')))?></li>
      <?php $btn_class = ($current_rating >=2)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('2', array('controller' => 'project_ratings', 'action' => 'add', $project_id,2, 'project_type' => $project_type), array('class' => 'btn btn-sm    js-tooltip js-no-pjax '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+2 votes')))?></li>
      <?php $btn_class = ($current_rating >=3)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('3', array('controller' => 'project_ratings', 'action' => 'add', $project_id,3, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+3 votes')))?></li>
      <?php $btn_class = ($current_rating >=4)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('4', array('controller' => 'project_ratings', 'action' => 'add', $project_id,4, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+4 votes')))?></li>
      <?php $btn_class = ($current_rating >=5)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('5', array('controller' => 'project_ratings', 'action' => 'add', $project_id,5, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class. ' '.$ratingclass, 'target' => $target, 'title' => __l('+5 votes')))?></li>
    </ul>
  <?php else: ?>
    <ul class="<?php if ($canRate): ?> starnew-rating <?php endif; ?> list-inline text-center clearfix <?php echo  $project_type; ?>">
      <?php $rating = !empty($rating) ? $rating : '0'; ?>
      <?php $btn_class = ($current_rating >=1)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center <?php echo $spanClass; ?>"><?php echo $this->Html->link('1', array('controller' => 'project_ratings', 'action' => 'add', $project_id, 1, 'project_type' => $project_type), array('class' => 'btn btn-sm  js-tooltip js-no-pjax '.$btn_class, 'target' => $target, 'title' => __l('+1 votes')))?></li>
      <?php $btn_class = ($current_rating >=2)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('2', array('controller' => 'project_ratings', 'action' => 'add', $project_id,2, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class, 'target' => $target, 'title' => __l('+2 votes')))?></li>
      <?php $btn_class = ($current_rating >=3)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('3', array('controller' => 'project_ratings', 'action' => 'add', $project_id,3, 'project_type' => $project_type), array('class' => 'btn btn-sm   js-tooltip js-no-pjax '.$btn_class, 'target' => $target, 'title' => __l('+3 votes')))?></li>
      <?php $btn_class = ($current_rating >=4)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('4', array('controller' => 'project_ratings', 'action' => 'add', $project_id,4, 'project_type' => $project_type), array('class' => 'btn btn-sm  js-tooltip js-no-pjax '.$btn_class, 'target' => $target, 'title' => __l('+4 votes')))?></li>
      <?php $btn_class = ($current_rating >=5)?$btn_default_class:$btn_color_class;?>
      <li class ="text-center"><?php echo $this->Html->link('5', array('controller' => 'project_ratings', 'action' => 'add', $project_id,5, 'project_type' => $project_type), array('class' => 'btn btn-sm  js-tooltip js-no-pjax '.$btn_class, 'target' => $target, 'title' => __l('+5 votes')))?></li>
    </ul>
<?php endif;
}?>
<?php if($is_view): ?>
  </div>
<?php endif;?>