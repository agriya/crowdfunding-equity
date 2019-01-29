<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-responses js-response">
  <?php
    if (!empty($this->request->params['named']['project_id'])) {
      $this->Html->meta('rss', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug, 'ext' => 'rss') , array('title' => 'RSS - ' . $this->pageTitle) , false);
    } else {
      $this->Html->meta('rss', array('controller' => 'blogs', 'action' => 'index', 'ext' => 'rss') , array('title' => 'RSS - ' . $this->pageTitle) , false);
    }
  ?>
  <div class="blogs index">
    <h3 class="h2 navbar-btn font-size-28 txt-center-mbl roboto-bold">
      <?php
        if (!empty($this->request->params['named']['username'])):
          echo ucfirst($this->request->params['named']['username']) .__l('\'s updates');
        else :
          echo __l('Updates');
        endif;
      ?>
    </h3>
  </div>
  <div class="clearfix page-header list-group-item-heading">
    <div class="pull-left">
      <?php if (!empty($blogs)):?>
        <?php echo $this->element('paging_counter'); ?>
      <?php endif;?>
    </div>
    <div class="pull-right">
      <?php
        if (!empty($this->request->params['named']['project_id'])):
          if ($project_owner == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) :
            echo '<span>' . $this->Html->link('<i class="fa fa-plus-circle fa-fw"></i> '.__l('Add Update'),array('controller' => 'blogs', 'action' => 'add', 'project_id' => $project_id),array('class' => 'btn btn-success btn-xs js-no-pjax add', 'data-target'=>"#js-ajax", 'data-toggle'=>"modal", 'escape'=>false,'title' => __l('Add Update'))) . '</span>';
          endif;
          echo  ' <span class="left-mspace">';
          if (isset($this->request->params['named']['username'])) :
            if (isset($this->request->params['named']['tag'])) :
              echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug,'username' => $this->request->params['named']['username'], 'tag' => $this->request->params['named']['tag'], 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => sprintf(__l('Subscribe to %s'), $this->pageTitle)));
            elseif (isset($this->request->params['named']['category'])) :
              echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug, 'username' => $this->request->params['named']['username'], 'category' => $this->request->params['named']['category'], 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => sprintf(__l('Subscribe to %s'), $this->pageTitle)));
            else :
              echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug, 'username' => $this->request->params['named']['username'], 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => sprintf(__l('Subscribe to %s'), $this->pageTitle)));
            endif;
          elseif (isset($this->request->params['named']['tag'])) :
            echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug, 'tag' => $this->request->params['named']['tag'], 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => sprintf(__l('Subscribe to %s'),  $this->pageTitle)));
          elseif (isset($this->request->params['named']['category'])) :
            echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index','project'=>$project_slug, 'category' => $this->request->params['named']['category'], 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => sprintf(__l('Subscribe to %s'), $this->pageTitle)));
          else :
            echo $this->Html->link('<i class="fa fa-rss"></i> '.'RSS', array('controller' => 'blogs', 'action' => 'index', 'project'=>$project_slug, 'ext' => 'rss') , array('target' => 'blank', 'class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' =>sprintf(__l('Subscribe to %s'), $this->pageTitle)));
          endif;
          echo  '</span>';
        endif;
      ?>
    </div>
  </div>
  <ol class="row list-unstyled clearfix">
    <?php
      if (!empty($blogs)):
        foreach($blogs as $blog):
    ?>
    <li class="col-xs-12 clearfix" id="blog-<?php echo $this->Html->cInt($blog['Blog']['id'], false);?>">
      <div class="clearfix marg-top-30">
      <div class="pull-left img-contain-110 img-circle img-thumbnail"><?php echo $this->Html->getUserAvatar($blog['User'],'medium_thumb');?></div>
      <div class="col-md-10 pull-right backer-tag">
		<div>
			<ul class="list-unstyled">
				<li>
					<p><strong><?php echo $this->Html->link($this->Html->cText($blog['Blog']['title'], false) , array('controller' => 'blogs', 'action' => 'view', $blog['Blog']['slug'])); ?></strong>
					  <span><?php echo ' - '; ?></span>
					  <?php
						$time_format = date('Y-m-d\TH:i:sP', strtotime($blog['Blog']['created']));
					  ?>
					  <span class="js-timestamp" title="<?php echo $time_format;?>">
						<?php echo $this->Html->cDateTimeHighlight($blog['Blog']['created'], false); ?>
					  </span>
					</p>
				</li>
				<li>
					<div title="<?php echo $this->Html->cText($blog['Blog']['content'], false); ?>"><?php echo $this->Html->cHtml($blog['Blog']['content'], false); ?></div>
				</li>
			</ul>
			<?php if (!empty($blog['BlogTag'])) :?>
			<div class="pull-left marg-top-30">
			  <b><?php echo __l('Tags:');?></b>
				<?php foreach($blog['BlogTag'] As $blog_tag) : ?>
				<label class="label clr-black bg-clor-lit-gray label-default panel bdr-rad-0"><?php echo $this->Html->cText($blog_tag['name']);?></label>
				<?php endforeach; ?>
			</div>
			<div class="col-md-6 pull-right marg-top-20 edit-del">
				<div class="row">
					<?php if ($blog['Project']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
					  <span class="pull-right  clearfix">
						<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action' => 'edit', $blog['Blog']['id']), array('class' => 'btn btn-info bdr-rad-0 no-border edit js-no-pjax marg-right-10','escape'=>false, 'title' => __l('Edit'), 'data-target'=>"#js-ajax", 'data-toggle'=>"modal"));?>
						<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('action' => 'delete', $blog['Blog']['id']), array('class' => 'btn btn-danger bdr-rad-0 no-border js-confirm js-no-pjax delete ', 'escape'=>false,'title' => __l('Delete')));?>
					  </span>
					<?php endif; ?>
				</div>
			</div>
		</div>
        <?php endif; ?>
      </div>
      </div>
      <?php if(isPluginEnabled('ProjectUpdates')):
      ?>
        <div class="marg-top-20 ver-space backer-update">
			<div>
			  <?php
				if (isset($this->request->params['named']['span_val'])) {
				  echo $this->element('blog_comments-index', array('blog_id' => $blog['Blog']['id'], 'cache' => array('config' => 'sec', 'key' => $blog['Blog']['id']), 'span_val' => $this->request->params['named']['span_val']),array('plugin'=>'ProjectUpdates'));
				} else {
				  echo $this->element('blog_comments-index', array('blog_id' => $blog['Blog']['id'], 'cache' => array('config' => 'sec', 'key' => $blog['Blog']['id'])),array('plugin'=>'ProjectUpdates'));
				}
				?>
			</div>
			<div>
			  <?php
				if($this->Auth->user('id')):
				  echo $this->element('blog_comments-add', array('blog_id' => $blog['Blog']['id'], 'display' => "update", 'cache' => array('config' => 'sec', 'key' => $blog['Blog']['id'])));
				else:
			  ?>
				  <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i><?php echo sprintf(__l('Please %s to post comment'), $this->Html->link(__l('login'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $blog['Project']['slug']), array('title' => 'login'))) ;?></p>
			  <?php endif; ?>
			</div>
        </div>
      <?php endif; ?>
    </li>
    <?php
        endforeach;
      else:
    ?>
    <li>
	<div class="text-center no-update">
		<p class="well-sm bdr-rad-0 text-warning marg-top-20"><?php echo sprintf(__l('No %s available'), __l('Updates')); ?></p>
	</div>
    </li>
    <?php endif; ?>
  </ol>
  <?php if (!empty($blogs)) { ?>
    <div class="js-pagination js-no-pjax pull-right">
      <?php echo $this->element('paging_links'); ?>
    </div>
  <?php } ?>
</div>