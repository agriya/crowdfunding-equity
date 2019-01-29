<div class="container gray-bg">
<h2><?php echo __l('Cities'); ?></h2>
<div>
    <?php if (!empty($cities)) :?>
    <ul class="list-unstyled clearfix">
      <?php
      foreach ($cities as $city):
      ?>
        <li class="col-xs-12 col-sm-3 col-md-2 navbar-btn">
          <?php echo $this->Html->link('<span class="pull-left text-warning">'.$this->Html->cText($city['City']['name'], false).'</span><span class="badge badge-info left-mspace">'.$this->Html->cInt($city['City']['project_count'],false). '</span>', array('controller' => 'projects', 'action' => 'index', 'admin' => false, 'city' => $city['City']['slug'], 'type' => 'home'), array('title' => $this->Html->cText($city['City']['name'], false),'escape' => false));?>
        </li>
      <?php
      endforeach;
      ?>
    </ul>
    <?php else: ?>
    <div class="clearfix">
	<div class="text-center">
		<p>
			<?php echo __l('No cities available'); ?>
		</p>
	</div>
    </div>
    <?php endif; ?>
</div>
</div>