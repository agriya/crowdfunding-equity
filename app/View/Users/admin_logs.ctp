<div>
  <fieldset>
  <legend><h3><?php echo __l('Disk Usage'); ?></h3></legend>
    <div class="well">
    <span ><?php echo $this->Html->link('<i class="fa fa-times"></i> &nbsp;'.__l('Clear Cache'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('Clear Cache'), 'class' => 'pull-right js-confirm', 'escape'=>false));  ?>.</span>
    <div id="disk-usage" class="show" class="active">
    <ul class="list-unstyled">
      <li><?php echo __l('Used Cache Memory');?>: <span><?php echo $this->Html->cInt($tmpCacheFileSize, false); ?></span> </li>
      <li><?php echo __l('Used Log Memory  ');?>  : <span><?php echo $this->Html->cInt($tmpLogsFileSize, false); ?> </span> </li>
    </ul>
    </div>
  </div>
  <legend><h3><?php echo __l('Recent Errors & Logs'); ?></h3></legend>
  <div class="well">
    <?php echo $this->Html->link('<i class="fa fa-times"></i> &nbsp;'.__l('Clear Error Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'error'), array('title' => __l('Clear Error Log'), 'class' => 'pull-right', 'escape'=>false)); ?>
    <div><textarea class ="col-md-12" rows="15" cols="80"><?php echo $error_log;?></textarea></div>
  </div>
  <legend><h3><?php echo __l('Debug Log')?></h3></legend>
  <div class="well">
    <?php echo $this->Html->link('<i class="fa fa-times"></i> &nbsp;'.__l('Clear Debug Log'), array('controller' => 'users', 'action' => 'clear_logs', 'type' => 'debug'), array('title' => __l('Clear Debug Log'), 'class' => 'pull-right', 'escape'=>false)); ?>
    <div><textarea class ="col-md-12" rows="15" cols="80"><?php echo $debug_log;?></textarea></div>
  </div>
  <legend><h3><?php echo __l('Email Log')?></h3></legend>
  <div class="well">
    <?php echo $this->Html->link('<i class="fa fa-times"></i> &nbsp;'.__l('Clear Email Log'), array('controller' => 'users', 'action' => 'clear_logs', 'type' => 'email'), array('title' => __l('Clear Email Log'), 'class' => 'pull-right', 'escape'=>false)); ?>
    <div><textarea class ="col-md-12" rows="15" cols="80"><?php echo $debug_log;?></textarea></div>
  </div>
  </fieldset>
</div>