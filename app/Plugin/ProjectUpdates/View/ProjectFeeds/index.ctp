<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-response">
  <div class="projectFeeds index">
  <div class="l-curve-top">
    <div class="r-curve-top">
    <div class="top-bg"></div>
    </div>
      </div>
      <div class="shad-bg-lft clearfix">
        <div class="shad-bg-rgt">
        <div class="shad-bg">
  <div class="main-section js-corner round-5">

<h2><?php   echo __l('Updates');  ?></h2>
<ol class="list comments-list list-unstyled" start="<?php echo $this->Paginator->counter(array(
  'format' => '%start%'
));?>">
<?php
if (!empty($projectFeeds)):

$i = 0;
foreach ($projectFeeds as $projectFeed):
  $class = null;
  if ($i++ % 2 == 0) {
  $class = ' class="altrow"';
  }
?>
  <li <?php echo $class;?>>
  <div class="rss-title"><span><?php echo $this->Html->link($projectFeed['ProjectFeed']['title'], $projectFeed['ProjectFeed']['link'], array('target' => '_blank', 'class'=>'js-tooltip js-no-pjax','title' => $projectFeed['ProjectFeed']['title'])); ?></span></div>
    <div class="clear"></div>
    <div class="rss-date">
    <p class="date-block-info">
        <em title="<?php echo __l('Posted On');?>"><?php echo __l('Posted On');?></em>
    <?php
    $str =$projectFeed['ProjectFeed']['date'];

    if(!empty($str)){
      $title = date('F j, Y h:i:s A (l) T (\G\M\TP)', strtotime($str));
      if (strtotime(date('Y-m-d', strtotime($str))) >= strtotime(date('Y-m-d'))) {
        echo '<span class="today" title="' . $title . '">' . date('g:i A', strtotime($str)) . '</span>';
      } else if (mktime(0, 0, 0, 0, 0, date('Y', strtotime($str))) < mktime(0, 0, 0, 0, 0, date('Y'))) {
        echo'<span class="prev-year" title="' . $title . '">' . date('M d, Y', strtotime($str)) . '</span>';
      } else {
        echo '<span class="current-year" title="' . $title . '">' . date('M d', strtotime($str)) . '</span>';
      }
      }
    ?>
    </p>
    </div>
  </li>
<?php
  endforeach;
else:
?>
  <li>
  	<div class="text-center">
		<p><?php echo sprintf(__l('No %s available'), sprintf(__l('%s Feeds'), Configure::read('project.alt_name_for_project_singular_caps')));?></p>
	</div>
  </li>
<?php
endif;
?>
</ol>

<?php
if (!empty($projectFeeds)) {
  ?>
    <div class="pull-right js-pagination js-no-pjax">
    <?php echo $this->element('paging_links'); ?>
    </div>
  <?php
}
?>
</div>
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

