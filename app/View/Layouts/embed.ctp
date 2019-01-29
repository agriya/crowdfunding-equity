<?php
/* SVN FILE: $Id: default.ctp 2893 2010-09-02 09:42:54Z sakthivel_135at10 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright   Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link      http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package     cake
 * @subpackage  cake.cake.console.libs.templates.skel.views.layouts
 * @since     CakePHP(tm) v 0.10.0.1076
 * @version     $Revision: 7805 $
 * @modifiedby  $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(), "\n";?>
    <?php if($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'view'): ?>
      <title><?php echo $this->Html->cText($title_for_layout, false);?> | <?php echo $this->Html->cText(Configure::read('site.name'), false);?></title>
    <?php else:?>
      <title><?php echo $this->Html->cText(Configure::read('site.name'), false);?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
    <?php endif; ?>
    <link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
    <?php
      echo $this->Html->meta('icon'), "\n";
      echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
      echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
      echo $this->Html->css('default.cache.'.Configure::read('site.version'), null, array('inline' => true)); 
    ?>
    <!--[if IE 7]>
      <?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>
    <![endif]-->
    <?php
      // For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
      if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
        echo '<!--', "\n";
      endif;
    ?>
    <meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
    <meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
    <?php if(!empty($meta_for_layout['project_name'])):?>
      <meta property="og:site_name" content="<?php echo $this->Html->cText(Configure::read('site.name'), false); ?>"/>
      <meta property="og:title" content="<?php echo $this->Html->cText($meta_for_layout['project_name'], false);?>"/>
    <?php endif;?>
    <?php if(!empty($meta_for_layout['project_image'])):?>
      <meta property="og:image" content="<?php echo $this->Html->cText($meta_for_layout['project_image'], false);?>"/>
    <?php else:?>
      <meta property="og:image" content="<?php echo Router::url(array(
        'controller' => 'img',
        'action' => 'crowdfunding.png',
        'admin' => false
        ) , true);?>"/>
    <?php endif;?>
    <?php
      if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
        echo '-->', "\n";
      endif;
    ?>
	<?php echo $scripts_for_layout; ?>
  </head>
  <body>
    <div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
	<section id="pjax-body">
      <div id="main" class="clearfix <?php echo $this->Html->getUniquePageId();?>">
        <div class="main-inner embed-page clearfix">
          <?php
            if ($this->Session->check('Message.error')):
              echo $this->Session->flash('error');
            endif;
            if ($this->Session->check('Message.success')):
              echo $this->Session->flash('success');
            endif;
            if ($this->Session->check('Message.flash')):
              echo $this->Session->flash();
            endif;
          ?>
          <?php echo $content_for_layout;?>
        </div>
      </div>
	  </section>
    </div>
  </body>
</html>