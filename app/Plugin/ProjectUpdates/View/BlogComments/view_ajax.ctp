<?php if(!$blogComment['BlogComment']['is_admin_suspended']) { ?>
    <li class="row clearfix" id="comment-<?php echo $this->Html->cInt($blogComment['BlogComment']['id'], false); ?>">
      <div class="col-md-<?php echo $span_val; ?> text-center">
      <?php echo $this->Html->getUserAvatar($blogComment['User']);?>
      </div>
      <div class="col-md-8">
        <div class="clearfix">
          <?php echo $this->Html->link('', '#comment-'.$blogComment['BlogComment']['id'], array('class' => 'js-scrollto pull-left')); ?>
          <?php echo $this->Html->link($blogComment['User']['username'], array('controller' => 'users', 'action' => 'view', $blogComment['User']['username']), array('title' => $blogComment['User']['username'], 'class'=>'pull-left', 'escape' => false)); ?>
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
      </div>
      <div class="col-md-3">
        <div class="pull-right">
            <?php if ($blogComment['User']['id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
            <div>
              <?php echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete'), array('controller' => 'blog_comments', 'action' => 'delete', $blogComment['BlogComment']['id']), array('class' => 'delete  js-ajax-delete', 'data-command_id' => "comment-" .$blogComment['BlogComment']['id'], 'escape' => false, 'title' => __l('Delete')));?>
            </div>
          <?php } ?>
        </div>
      </div>
    </li>
<?php } ?>