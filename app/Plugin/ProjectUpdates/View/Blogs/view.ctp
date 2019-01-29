<?php /* SVN: $Id: $ */ ?>
<div class="blogs view">
	<div class="main-section js-corner round-5 space"> 
	<h2><?php echo $this->Html->cText($blog['Blog']['title']);?></h2>  
	<div class="ver-space">
        <div class="clearfix">
			<div class="media">	
				<div class="pull-left">
					<?php echo $this->Html->getUserAvatar($blog['User'],'medium_thumb', true, '', '', '', (isset($this->request->params['named']['modal']) && $this->request->params['named']['modal'] == "modal")?$this->request->params['named']['modal']:''); ?>
				</div>
				<div class="media-body">
					<div class="col-md-6">
						<span>
						  <?php echo $this->Html->link($this->Html->cText($blog['User']['username']), array('controller' => 'users', 'action' => 'view', $blog['User']['username']), array('title' => $blog['User']['username'], 'escape' => false));?>
						</span>
						<span>
						  <?php
							$time_format = date('Y-m-d\TH:i:sP', strtotime($blog['Blog']['created']));
						  ?>
						  <span><?php echo ' - '; ?></span>
						  <span class="js-timestamp" title="<?php echo $time_format;?>">
							<?php echo $this->Html->cDateTimeHighlight($blog['Blog']['created'], false); ?>
						  </span>
						</span>
						<div>
						<?php echo $this->Html->cHtml($blog['Blog']['content']);?></div>
						<?php if (!empty($blog['BlogTag'])){?>
						<div class="clearfix">
							<b><?php echo __l('Tags');?></b>
							<?php foreach($blog['BlogTag'] As $blogtag) { ?>
							<label class="label label-default"><?php echo $this->Html->cText($blogtag['name']);?></label>
							<?php } ?>
						</div>
					  <?php } ?>
					</div>			
					<?php if(!isset($this->request->params['named']['from'])): ?>
					<?php if ($blog['Project']['User']['id'] == $this->Auth->user('id')): ?>
					<div class="pull-right">			  
						<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller' => 'blogs', 'action' => 'edit', $blog['Blog']['id']), array('class' => 'btn btn-info edit  js-no-pjax ','escape'=>false, 'title' => __l('Edit'), 'data-target'=>"#js-ajax", 'data-toggle'=>"modal"));?>			 
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>	
	</div>
    <?php if(isPluginEnabled('ProjectUpdates')): ?>
    <div class="well hor-mspace ver-space">
        <div class="js-responses blogComments-section">
          <?php echo $this->element('blog_comments-index', array('blog_id' => $blog['Blog']['id'], 'span_val' => '2', 'cache' => array('config' => 'sec', 'key' => $blog['Blog']['id']), 'load_type' => !empty($this->request->params['named']['from'])?'modal':'normal')); ?>
        </div>
      <br/><br/>
      <div>
          <?php  if($this->Auth->user('id')):
                   echo $this->element('blog_comments-add', array('blog_id' => $blog['Blog']['id'], 'cache' => array('config' => 'sec', 'key' => $blog['Blog']['id']), 'display' => "view"));
                 else:?>
                     <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i><?php echo sprintf(__l('Please %s to post comment'), $this->Html->link(__l('login'), array('controller' => 'users', 'action' => 'login', '?' => 'f=project/' . $blog['Project']['slug']), array('title' => 'login'))) ;?></p>
              <?php endif; ?>
       </div>
    </div>
    <?php endif; ?>
  </div>
	<div class="modal fade" id="js-ajax">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"></div>
				<div class="modal-body"></div>
				<div class="modal-footer"> 
					<a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
			</div>
		</div>
	</div>
 </div>