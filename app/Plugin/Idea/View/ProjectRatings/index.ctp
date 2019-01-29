<?php /* SVN: $Id: index.ctp 2740 2010-08-13 15:28:29Z aravindan_111act10 $ */ ?>
<div class="projectRatings index js-response">
  <h3 class="h2 navbar-btn roboto-bold font-size-28"><?php echo __l('Voters');?></h3>
  <?php $this->element('paging_counter');?>
  <ul class="list-unstyled cf-backer">
    <?php
      if (!empty($projectRatings)):
        $i = 0;
        foreach ($projectRatings as $projectRating):
          $class = null;
          if ($i++ % 2 == 0) :
            $class = 'altrow';
          endif;
    ?>
    <li class="panel panel-header panel-default col-xs-12 <?php echo $class;?>">
      <div class="pull-left display-tbl navbar-btn no-float">
		<div class="img-contain-110 img-circle img-thumbnail center-block">
			<?php echo $this->Html->getUserAvatar($projectRating['User'],'user_thumb');?>
		</div>
      </div>
      <div class="col-xs-5 col-md-5 h3 no-float">
        <h3 class="panel-title txt-center-mbl h-center-blk roboto-bold">
			<?php echo $this->Html->link($this->Html->cText($projectRating['User']['username']), array('controller'=> 'users', 'action'=>'view', $projectRating['User']['username']), array('escape' => false,'title' => $this->Html->cText($projectRating['User']['username'], false)));?>
          <?php
            $time_format = date('Y-m-d\TH:i:sP', strtotime($projectRating['ProjectRating']['created']));
          ?>
          <i class="fa fa-clock-o"></i>
          <span class="h5 list-group-item-text list-group-item-heading js-timestamp" title="<?php echo $time_format;?>">
            <?php echo $this->Html->cDateTime($projectRating['ProjectRating']['created']); ?>
          </span>
        </h3>
		</div>
		<div class="navbar-btn pull-right no-float btn-vert-alfn">
          <span><?php echo $this->Html->cInt($projectRating['ProjectRating']['rating'],false).__l(' Vote(s)'); ?></span>
        </div>
    </li>
    <?php
        endforeach;
      else:
    ?>
    <li class="media panel panel-header panel-default col-xs-12">
		<div class="text-center">
		<p class="navbar-btn"><?php echo sprintf(__l('No %s available'), __l('Voters'));?></p>
     </div>
    </li>
    <?php
      endif;
    ?>
  </ul>
  <?php if (!empty($projectRatings)): ?>
    <div class="pull-right">
      <?php echo $this->element('paging_links'); ?>
    </div>
  <?php endif; ?>
</div>