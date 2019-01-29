<?php if(empty($this->request->params['isAjax']) && empty($this->request->params['named']['contet_user_id'])): ?>
<h3 class="h2 navbar-btn roboto-bold h4">
	<?php echo __l('Comments');?>
</h3>
<?php endif; ?>
<div class="js-response-message">
	<?php
		$project_fund_id=0;
		if(!empty($this->request->params['named']['project_fund_id'])){
		$project_fund_id=$this->request->params['named']['project_fund_id'];
	}?>
	<?php if (!empty($messages)) { ?>
	<div class ="clearfix">
		<div class ="pull-right">
			<div class ="pull-left"><strong><?php echo __l('Sort:'); ?></strong></div>
			<ul class ="list-unstyled pull-right">
				<?php $stat_class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'freshness') ? 'blackc' : null; ?>
				<li class = "pull-left"><?php echo $this->Html->link(__l('Freshness'), array('controller' => 'messages', 'action' => 'index', 'project_id' => $project['Project']['id'],'project_fund_id'=>$project_fund_id, 'filter' => 'freshness', 'admin' => false, 'plugin' => 'projects'), array('class' => 'js-message-link js-no-pjax ' . $stat_class, 'title' => __l('Freshness')));?></li>
				<?php $stat_class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'descending') ? 'blackc' : null; ?> 
				<li class = "pull-left"><?php echo $this->Html->link(__l('Descending'), array('controller' => 'messages', 'action' => 'index', 'project_id' => $project['Project']['id'],'project_fund_id'=>$project_fund_id, 'filter' => 'descending', 'admin' => false, 'plugin' => 'projects'), array('class' => 'js-message-link js-no-pjax ' . $stat_class, 'title' => __l('Descending')));?></li>  
				<?php $stat_class = ((!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'ascending')) ? 'blackc' : null; ?>   
				<li class = "pull-left"><?php echo $this->Html->link(__l('Ascending'), array('controller' => 'messages', 'action' => 'index', 'project_id' => $project['Project']['id'],'project_fund_id'=>$project_fund_id, 'filter' => 'ascending', 'admin' => false, 'plugin' => 'projects'), array('class' => 'js-message-link js-no-pjax ' . $stat_class, 'title' => __l('Ascending')));?></li> 
			</ul> 
		</div>      
	</div>
	<?php } ?>
	<div class="nav nav-pills well-sm alert alert-info nav-tabs no-bor clearfix">
		<?php if (!empty($messages)) { ?>
		<h5 class="active pull-left"> <?php echo count($messages) . ' ' . __l('Comments');?></h5>
	</div>
	<?php } else { ?>
	<h5 class="active pull-left"><?php echo '0' . ' ' . __l('Comments');?></h5>
</div>
<?php } ?>
	<div>
	  <?php if (!empty($messages)) {
		  $i = 0;   
		  foreach($messages as $message){
		  if ($i++ % 2 == 0) :
		  $row_class = 'row';
		  else :
		  $row_class = 'altrow';
		  endif;
		  $is_read_class="";
		  $is_starred_class = "star";
		  if (!$message['Message']['is_read']) :
		  $row_class=$row_class.' unread-row';
		  $is_read_class .= "unread-message-bold";
		  endif;
		  if ($message['Message']['is_starred']):
		  $is_starred_class = "star-select";
		  endif;
		  $path_class='';
		  $reply_path = 'row';
		  $path_count = 0;
		  $span_class = 'col-md-7';
		  if ($message['Project']['user_id'] == $message['Message']['other_user_id']) {
		  $reply_path = 'cmt-user-reply';
		  } else {
		  $reply_path = 'row';
		  }
		  if (!empty($message['Message']['materialized_path'])) {
		  $path_arr=explode('-',$message['Message']['materialized_path']);
		  $path_count=count($path_arr) - 1;
		  if($path_count > 0) {
			$span_count = 13 - $path_count;
			$span_class = 'span' . $span_count;
			$path_class='offset' . $path_count;
		  }
		  }
		  $sep_class = '';
		  if($path_count == 0) {
		  $sep_class = '';
		  }?>
		<ul class="list-unstyled">
			<li class="<?php echo $path_class;?>">
				<div class="<?php echo $sep_class; ?> ">
					<div>
						<?php if($path_count != 0) {?>
						<div <?php } ?>
							<div class = "clearfix">
								<div class="pull-left float-none"><?php echo $this->Html->getUserAvatar($message['OtherUser'], 'micro_thumb'); ?></div>
								<div class="<?php echo $span_class; ?> pull-left">
									<p class="clearfix"><?php echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller'=> 'users', 'action' => 'view', $message['OtherUser']['username'], 'admin' => false), array('escape' => false, 'title'=>$this->Html->cText($message['OtherUser']['username'],false)));?> <span> <?php echo '-'; ?> </span>
									<?php
									  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
									?>
									<span class="js-timestamp" title="<?php echo $time_format;?>"> <?php echo $this->Html->cDateTimeHighlight($message['Message']['created'], false);?></span></p>
									<p>
									  <?php if($this->Auth->user('id') && $this->Auth->user('role_id') == ConstUserTypes::Admin){
										echo $this->Html->CText($message['MessageContent']['message']);
										}else{ ?>
										<?php if ($message['Message']['is_private'] && (!$this->Auth->user('id') || ($this->Auth->user('id') != $message['Message']['user_id'] && $this->Auth->user('id') != $message['Message']['other_user_id']))) { ?>
										<?php echo '['.__l('Private Message').']'; ?>
										<?php } else { ?>
										<?php echo $this->Html->CText($message['MessageContent']['message']);?>
										<?php } ?>
										<?php } ?>
									</p>
								</div>
							</div>
							<div class="clearfix ">
								<?php if($this->Auth->sessionValid() && ((empty($message['Message']['is_private']) && ($this->Auth->user('id') != $message['Message']['other_user_id'])) || (!empty($message['Message']['is_private']) && (($this->Auth->user('id') == $message['Message']['user_id']))))) { ?>
								<p class="clearfix">
									<?php
										$depth_allowed = Configure::read('messages.thread_max_depth');
										if (empty($depth_allowed) || $message['Message']['depth'] < Configure::read('messages.thread_max_depth')) {
									?>
									<?php echo $this->Html->link(__l('Reply'),array('controller'=>'messages','action'=>'compose',$message['Message']['id'],'reply','user'=>$message['OtherUser']['username'], 'project_id' => $message['Project']['id'], 'reply_type' => 'quickreply', 'root' => $message['Message']['root'], 'm_path' => $message['Message']['materialized_path']), array("class" =>"btn btn-primary btn-sm pull-right reply-".$message['Message']['id']." js-link-reply js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-" . $message['Message']['id']."'}", 'title' => __l('Reply'))); ?>
								</p>
									<?php }?> 
									<?php }?>
								<div class="js-quickreplydiv-<?php echo $this->Html->cInt($message['Message']['id'], false);?> clearfix"></div>
							</div>
							<?php if($path_count != 0) {?>
						</div>
						<?php } ?>
					</div>
				</div>
			</li>
		</ul>
		<?php } } else { ?>
		<?php } ?>
	</div>
</div>
