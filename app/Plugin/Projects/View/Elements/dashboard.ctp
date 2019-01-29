<div class="shad-bg-lft clearfix">
  <div class="shad-bg-rgt">
  <div class="shad-bg">
    <div class="main-section"> <?php echo $this->element('projects_index-myprojects', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))), array('plugin'=>'Projects')); ?> </div>
  </div>
  </div>
</div>
<div class="l-curve-bot">
  <div class="r-curve-bot">
  <div class="bot-bg"></div>
  </div>
</div>
<div class="l-curve-top">
  <div class="r-curve-top">
  <div class="top-bg"></div>
  </div>
</div>
<div class="shad-bg-lft clearfix">
  <div class="shad-bg-rgt">
  <div class="shad-bg">
    <div class="main-section"> <?php echo $this->element('project_funds_index-mydonations', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))), array('plugin'=>'Projects')); ?> </div>
  </div>
  </div>
</div>
<div class="l-curve-bot">
  <div class="r-curve-bot">
  <div class="bot-bg"></div>
  </div>
</div>
