<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-responses js-response">
  <div class="blogs index">
  <div class="l-curve-top">
  <div class="r-curve-top">
    <div class="top-bg"></div>
  </div>
      </div>
      <div class="shad-bg-lft clearfix">
        <div class="shad-bg-rgt">
        <div class="shad-bg">
  <div class="main-section js-corner round-5">
    <h2>
    <?php
      echo __l('Updates');
    ?>
    </h2>

  <ol class="list comments-list">
    <?php
    if (!empty($projectFeeds)):
      $i = 0;
      foreach($projectFeeds->get_items() as $projectFeed):
      $class = null;
      if ($i++ % 2 == 0) {
        $class = 'altrow';
      }
    ?>
    <li class="list-row clearfix round-5" >
    <div class="rss-source-site">[<?php echo $this->Html->link($this->Html->cHtml($projectFeed->get_base()), $projectFeed->get_base(), array('target' => '_blank', 'class' => 'js-no-pjax feed-source-site')); ?>]</div>
      <div class="rss-title"><?php echo $this->Html->link($this->Html->cHtml($projectFeed->get_title()), $projectFeed->get_permalink(), array('target' => '_blank', 'class' => 'feed js-no-pjax')); ?></div>
      <div class="rss-date">
        <?php
        if(!empty($str)){
          if (strtotime(date('Y-m-d', strtotime($str))) >= strtotime(date('Y-m-d'))) {
          echo '<span class="today"' . $title . '>' . date('g:i A', strtotime($str)) . '</span>';
          } else if (mktime(0, 0, 0, 0, 0, date('Y', strtotime($str))) < mktime(0, 0, 0, 0, 0, date('Y'))) {
          echo'<span class="prev-year"' . $title . '>' . date('M d, Y', strtotime($str)) . '</span>';
          } else {
          echo '<span class="current-year"' . $title . '>' . date('M d', strtotime($str)) . '</span>';
          }
        }
        ?>
      </div>
      <div class="clear"></div>
      </li>
    <?php endforeach; ?>
    <?php else: ?>
    <li>
<div class="img-thumbnail text-center">
		<p><?php echo sprintf(__l('No %s available'), sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps'))); ?></p>
    </div>
    </li>
    <?php endif; ?>
    </ol>

  </div>
    </div>
        </div>
      </div>
      <div class="l-curve-bot">
        <div class="r-curve-bot">
        <div class="bot-bg"></div>
        </div>
      </div>
  </div>
</div>