<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $this->Html->cText($title_for_layout, false); ?> - <?php echo Configure::read('site.name'); ?></title>
  <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
  <link href="<?php echo $this->Html->assetUrl('install/favicon.ico', array('pathPrefix' => IMAGES_URL)); ?>" type="image/x-icon" rel="icon" />
  <link href="<?php echo $this->Html->assetUrl('install/favicon.ico', array('pathPrefix' => IMAGES_URL)); ?>" type="image/x-icon" rel="shortcut icon" />
  <?php
	echo $this->Html->css(array(
      'install/reset',
      'install/960_24_col',
      'install/install',
    ));
  ?>
</head>
<body>
<div class="installer-content">
  <div class="container_24">
    <div class="header">
      <div class="h-left">
        <div class="h-right">
          <div class="h-center">
            <h1 class="grid_left"><a href="#" title="<?php echo Configure::read('site.name'); ?>"><?php echo Configure::read('site.name'); ?></a></h1>
            <p class="header-installer grid_left"><?php echo __l('Installer'); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="main clearfix">
      <div class="side-content grid_7">
        <div class="agriya">Agriya</div>
        <ol class="list round-4 grid_6">
          <li class="round-4<?php if ($this->request->params['action'] == 'index') { ?> active<?php } ?>">1. <?php echo __l('Welcome'); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'requirements') { ?> active<?php } ?>">2. <?php echo __l('Server Requirments'); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'permissions') { ?> active<?php } ?>">3. <?php echo __l('File Permissions'); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'license') { ?> active<?php } ?>">4. <?php echo __l('License Configuration'); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'database') { ?> active<?php } ?>">5. <?php echo __l('Database'); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'configuration') { ?> active<?php } ?>">6.<?php echo sprintf(__l('%s Configuration'), Configure::read('site.name')); ?></li>
          <li class="round-4<?php if ($this->request->params['action'] == 'finish') { ?> active<?php } ?>">7. <?php echo __l('Installation is Complete!'); ?></li>
        </ol>
      </div>
      <div class="main-content grid_16">
        <?php
          echo $this->Layout->sessionFlash();
          echo $content_for_layout;
        ?>
      </div>
    </div>
    <div class="footer">
      <div class="footer-inner clearfix">
        <p>&copy;<?php echo date('Y'); ?> <a title="<?php echo Configure::read('site.name'); ?>" href="/"><?php echo Configure::read('site.name'); ?></a>. <?php echo __l('All rights reserved.'); ?></p>
        <p class="powered clearfix"><span><?php echo $this->Html->link($this->Html->cText(sprintf(__l('Powered by %s'), Configure::read('site.name'))), '/', array('title' => sprintf(__l('Powered by %s'), Configure::read('site.name')), 'escape' => false));?>,</span>
        <span><?php echo __l('made in'); ?></span><a class="company" title="<?php echo sprintf(__l('%s Web Development'), 'Agriya');?>" target="_blank" href="http://www.agriya.com/"><?php echo sprintf(__l('%s Web Development'), 'Agriya');?></a></p>
        <p><a class="cssilize" title="CSSilized by CSSilize, PSD to XHTML Conversion" target="_blank" href="http://www.cssilize.com/">CSSilized by CSSilize, PSD to XHTML Conversion</a></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>