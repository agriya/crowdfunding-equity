<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="blogComments index js-response">
  <h4><?php echo __l('Comments'); ?> (<?php echo $this->Html->cInt($blog['Blog']['blog_comment_count'], false);?>)</h4>
  <?php
    if (!empty($blogComments)):
      echo $this->element('paging_counter');
     endif;
  ?>
  <div class="row">
  <ol class="list-unstyled col-md-12 clearfix js-responses-<?php echo $this->Html->cInt($blog['Blog']['id'], false);?>">
    <?php
      if (!empty($blogComments)):
        $i = 0;
        foreach($blogComments as $blogComment):
    ?>
    <li class="clearfix" id="comment-<?php echo $this->Html->cInt($blogComment['BlogComment']['id'], false); ?>">
      <div class="pull-left">
        <?php echo $this->Html->getUserAvatar($blogComment['User']);?>
      </div>
	  <?php $class = (!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal')?'offset1':'';?>
      <div class="col-md-8  <?php echo $class; ?>">
	  <?php if(!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal'): ?>
	  <div>
	  <?php endif; ?>
        <div class="clearfix">
          <?php echo $this->Html->link('', '#comment-'.$blogComment['BlogComment']['id'], array('class' => 'js-scrollto pull-left')); ?>
          <?php echo $this->Html->link($blogComment['User']['username'], array('controller' => 'users', 'action' => 'view', $blogComment['User']['username']), array('title' => $blogComment['User']['username'], 'class'=>'pull-left text-info', 'escape' => false)); ?>
        <div>
          <?php
            $time_format = date('Y-m-d\TH:i:sP', strtotime($blogComment['BlogComment']['created']));
          ?>
          <span><?php echo ' - ';?></span>
          <span class="js-timestamp" title="<?php echo $time_format;?>">
            <?php echo $this->Html->cDateTimeHighlight($blogComment['BlogComment']['created'], false); ?>
          </span>
          </div>
        </div>
        <div class="clearfix">
          <?php echo $this->Html->cText($blogComment['BlogComment']['comment']);?>
        </div>
		<?php if(!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal'): ?>
	     </div>
    	 <?php endif; ?>
      </div>
      <div class="col-md-2">
        <div class="pull-right">
            <?php if ($blog['Project']['User']['id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
            <div class="show">
              <?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('controller' => 'blog_comments', 'action' => 'delete', $blogComment['BlogComment']['id']), array('class' => 'delete  js-ajax-delete', 'data-command_id' => "comment-" .$blogComment['BlogComment']['id'],  'escape' => false, 'title' => __l('Delete')));?>
            </div>
          <?php } ?>
        </div>
      </div>
    </li>
    <?php
        endforeach;
      endif;
    ?>
  </ol>
  </div>
  <?php if (!empty($blogComments)) { ?>
  <div class="clearfix">
    <div class="js-pagination js-no-pjax pull-right">
      <?php echo $this->element('paging_links'); ?>
    </div>
  </div>
  <?php } ?>
</div>