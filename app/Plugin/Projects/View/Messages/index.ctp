<div class="js-response message-index">
	<div class="container">
		<div class="col-xs-12 hor-space">
			<div class="pull-left hor-mspace"><h3 class="no-mar"><?php echo $this->pageTitle; ?></h3></div>		
			<div class="btn-group dropdown pull-right hor-mspace"><a href="#" class="btn btn-info dropdown-toggle text-16 js-no-pjax" data-toggle="dropdown"><?php echo sprintf(__l('Browse %s'), Configure::read('project.alt_name_for_project_plural_caps')); ?> <i class="fa fa-caret-down fa-lg"></i></a>
				<ul class="browse-project list-unstyled dropdown-menu text-left clearfix">
					<?php if (!empty($project_own)) { ?>
					<li class="clearfix"><span class ="pull-left "><?php echo $this->Html->link(__l('All') , array('controller' => 'messages', 'action' => 'index', 'type'=>'all'), array('class' => 'pull-left') ) .  ' | ' ?></span><span class ="pull-left "><?php echo  $this->Html->link(__l('Closed') , array('controller' => 'messages', 'action' => 'index', 'type'=>'closed'), array('class' => 'pull-right') );?></span></li>
					<?php foreach($project_own as $project_arr) {
						if (empty($projectStatus[$project_arr['Project']['id']]['name'])) {
							$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
							  'projectStatus' => $projectStatus,
							  'project' => $project_arr
							));
							$projectStatus = $response->data['projectStatus'];
						 }?>
					<li class="clearfix col-md-12 navbar-btn">
						<?php
						  $out='';
						  $out='<span class="col-xs-12 col-sm-8 clearfix">';
						  $out.='<span class="show">';
						  $out.=$this->Html->cText($project_arr['Project']['name']);
						  $out.='</span>';
						  $out.='<span class="show">';
						  $out.='<i class="fa fa-square fa-fw text-info project-status-';
						  $out.=$projectStatus[$project_arr['Project']['id']]['id'];
						  $out.='">';
						  $out.=' ';
						  $out.='</i>';
						  $out.=$projectStatus[$project_arr['Project']['id']]['name'];
						  $out.='</span>';
						  $out.='</span>';
						  $out.='<span class="col-xs-12 col-sm-4 pull-right media list-group-item-heading">';
						  if ($project_arr['Project']['user_id'] != $this->Auth->user('id')) {
							$out.='<span class="pull-left">';
							$out.=$this->Html->getUserAvatar($project_arr['User'], 'micro_thumb', false);
							$out.='</span>';
							$out.='<span class="pull-right">';
							$out.=$project_arr['User']['username'];
							$out.='</span>';
							}
							 $out.='</span>';
						  echo $this->Html->link($out , array('controller' => 'messages', 'action' => 'index', 'type' => 'project', 'project_id'=>$project_arr['Project']['id']),array('class' => 'show clearfix', 'escape'=>false));
						?>
					 </li>
						<?php } ?>
					<?php } else {?>
						<li class="clearfix text-center"><?php echo __l('No Records found'); ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>	
		<section class="col-xs-12 thumbnail message-header no-pad">	
			<div class="clearfix">
				<?php echo $this->element('message_message-left_sidebar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
			</div>
			<?php if (!empty($project_own)): ?>		
			<?php endif; ?>
			<div>
				<div class="clearfix message-content">
					<ul class="list-group list-unstyled no-mar <?php echo !empty($messages)?'':'' ?>">
						<?php if (!empty($messages)) {
						$i = 0;
						foreach($messages as $message) {
						  // if empty subject, showing with (no suject) as subject as like in gmail
						  if (!$message['MessageContent']['subject']) :
							$message['MessageContent']['subject'] = '(no subject)';
						  endif;
						  $row_three_class = '';
						  if ($i++ % 2 == 0) :
							$row_class = 'row';
						  else :
							$row_class = 'altrow';
						  endif;
						  $message_class = "checkbox-message ";
						  $is_read_class = "";
						  if ($message['Message']['is_read']) :
							$message_class .= " checkbox-read ";
							$is_read_class .= "com-bg";
						  else :
							$message_class .= " checkbox-unread ";
							$row_class=$row_class.' unread-row';
						  endif;
						  if ($message['Message']['is_starred']):
							$message_class .= " checkbox-starred ";
						  else:
							$message_class .= " checkbox-unstarred ";
						  endif;
						  $row_class_new='class=" cur js-show-message js-no-pjax col-xs-3 clearfix truncate text-capitalize js-unread-{\'message_id\':\''. $message['Message']['id'] .'\',\'is_read\':\''. $message['Message']['is_read'] .'\'}"';
						  $row_class='class=" clearfix mes-head no-bor cur '.$is_read_class. '"';

						   if (!empty($message['MessageContent']['Attachment'])):
							  $row_three_class.=' has-attachment';
						  endif;
						  if(empty($projectStatus[$message['Project']['id']]['name'])){
							$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
							$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
							  'projectStatus' => $projectStatus,
							  'project' => $message
							));
							$projectStatus = $response->data['projectStatus'];
						  } ?>
							<li class="list-group-item">
								<ul class="clearfix list-inline message-all active">
									<li class="col-xs-1">
										<?php
										  if ($message['Message']['is_starred']) {
											echo $this->Html->link('<i class="fa fa-star ass"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id']) , array('class' => 'cur js-star', 'escape' => false));
										  } else {
											echo $this->Html->link('<i class="fa fa-star-o"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id'],1) , array('class' => 'cur js-star js-no-pjax', 'escape' => false));
										  }
										  ?>
										<a href="#"><span class="hide">Star</span></a>
									</li>
									<li class="user-name-block c1 media list-group-item-heading col-xs-2">
										<?php if(!empty($message['OtherUser']['id'])) { ?>
											<div class="pull-left"><?php echo $this->Html->getUserAvatar($message['OtherUser'], 'micro_thumb'); ?></div>
											<div class="media-body"><span title="<?php echo $this->Html->cText($message['OtherUser']['username'], false); ?>"><?php echo $this->Html->cText($message['OtherUser']['username']); ?></span></div>
											<?php } else { ?>
											<span class="pull-left"><?php echo __l('All'); ?></span>
										<?php } ?>
									</li>
									<li <?php echo $row_class_new; ?>>	<i class="fa fa-square"></i>
										<?php   if (!empty($message['Project']['id'])) :?>
											<i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$message['Project']['id']]['id'], false);?>"></i> <span title="Open" class="hide"><?php echo $this->Html->cText($projectStatus[$message['Project']['id']]['name'], false);?></span><span><?php echo $this->Html->cText($this->Html->cText($message['Project']['name'], false));?></span>
											<?php else :
											echo $this->Html->cText($message['MessageContent']['subject'], false);
											endif 
										?>																	 
									</li>
									<li class="over-hide col-xs-4 truncate"><span><?php echo $this->Html->cText($message['MessageContent']['message'], false);?></span></li>
									<li class="over-hide col-xs-2 text-right">
										<?php
											$time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
										?>
										<span class="js-timestamp" title ="<?php echo $time_format;?>">
										<?php echo $this->Html->cDateTimeHighlight($message['Message']['created'], false) ;?></span>
									</li>
								</ul>
								<div class="hide js-message-view<?php echo $this->Html->cInt($message['Message']['id'], false); ?>">
									<div class="row com-bg marg-top-20">
										<?php if(!empty($message['Project']['id'])) {?>
										<div class="clearfix">
											<div class="col-md-12">
												<div class="pull-left marg-right-10"><?php echo $this->Html->link($this->Html->cText($message['Project']['name']), array('controller' => 'project', 'action' => 'view', $message['Project']['slug']), array('escape' => false));?></div>
												<div> <i class="open fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$message['Project']['id']]['id'], false);?>"></i><span class = "htruncate marg-left-10"><?php echo $this->Html->cText($projectStatus[$message['Project']['id']]['name'], false);?></span> </div>
											</div>
										</div>
										<?php } ?>
										<div class="col-md-12 navbar-btn"> <?php echo $this->Html->cText($message['MessageContent']['message'], false); ?></div>
										<div class="clearfix text-right col-xs-12"> <?php
										  if(empty($message['Message']['project_status_id']) && $this->Auth->user('id') != $message['Message']['other_user_id'] && empty($message['Message']['is_sender'])){
											echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'project_id' => $message['Project']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'inbox','m_path'=>$message['Message']['materialized_path']), array("class" => "btn btn-primary js-tooltip btn-sm reply-block js-link-reply js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-".$message['Message']['id']."'}".' reply-'.$message['Message']['id'],'title' => __l('Reply')));
											}
											?>
										</div>
									</div>
									<?php 
										$replay_class = "";
										if(empty($message['Message']['project_status_id']) && $this->Auth->user('id') != $message['Message']['other_user_id'] && empty($message['Message']['is_sender'])){
											$replay_class = "js-quickreplydiv-".$this->Html->cInt($message['Message']['id'], false);
										}
									?>
									<div class="<?php echo $replay_class;?>"></div>
								</div>
								<div class="com-bg">
									<div class="hide js-conversation-<?php echo $this->Html->cInt($message['Message']['id'], false);?>"></div>
								</div>
							</li>
						<?php
					}
				  } else { ?>
							<li>
								<div class="text-center">
									<p class="text-danger h3"><?php echo sprintf(__l('No %s available'), __l('Messages'));?></p>
									<p class="text-success h3"><?php echo sprintf(__l('Your %s will appear here'), __l('messages')); ?></p>
								</div>
							</li>
				  <?php
				  }?>
					</ul>
				</div>
			</div>
		</section>
		<section>
		<?php if (!empty($messages)) { ?>
			<!--<div class="pull-right mob-clr">
				<div class="paging clearfix js-pagination js-no-pjax">
					<?php echo $this->element('paging_links'); ?>
				</div>
			</div> -->
		<?php } ?>
		</section>
	</div>
</div>