<?php
  if(!empty($this->request->params['named']['type'])) {
    $type = $this->request->params['named']['type'];
  } else {
    $type = 'user_messages';
  }
?>
<div class="main-admn-usr-lst">
	<div class="bg-primary row">		
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($suspended,false).'</span><span>' .__l('Suspended'). '</span>', array('controller'=>'messages','action'=>'index', 'type' => $type, 'filter_id' => ConstMoreAction::Suspend), array('escape' => false, 'title' => __l('Suspended')));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($system_flagged,false).'</span><span>' .__l('Flagged'). '</span>', array('controller'=>'messages','action'=>'index', 'type' => $type, 'filter_id' => ConstMoreAction::Flagged), array('escape' => false, 'title' => __l('Flagged')));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($all,false).'</span><span class="text-center">' .__l('All'). '</span>', array('controller'=>'messages','action'=>'index', 'type' => $type), array('escape' => false, 'title' => __l('All')));?>
				</div>
			</li>
		</ul>		
	</div>		
	<div class="clearfix pledge">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p class="navbar-btn"><?php echo $this->element('paging_counter'); ?></p>
				</li>
				<li class="pull-right"> 
					<div class="srch-adon">
						<?php
						$url = (!empty($this->request->params['named']['type']))?'/type:'.$this->request->params['named']['type']:'';
						echo $this->Form->create('Message' , array('action' => 'admin_index'.$url, 'type' => 'post', 'class' => 'form-search clearfix'));
						echo $this->Form->input('filter_id', array('type' =>'hidden'));
						?>
						<?php if($type!='user_messages') { ?>
							<div class="clearfix">
								<div class="col-xs-12 col-sm-4 form-group">
									<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
									<?php echo $this->Form->autocomplete('Message.username', array('label' => false, 'placeholder' => __l('From'), 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'form-control row')); ?>
								</div>
								<div class="col-xs-12 col-sm-4 form-group">
									<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
									<?php echo $this->Form->autocomplete('Message.other_username', array('label' => false, 'placeholder' => __l('To'),  'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'form-control row')); ?>
								</div>
								<div class="col-xs-12 col-sm-4 form-group">
									<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
									<?php echo $this->Form->autocomplete('Project.name', array('label' => false, 'placeholder' => Configure::read('project.alt_name_for_project_singular_caps'), 'type' => 'text', 'id' => 'ProjectName', 'acFieldKey' => 'Project.id', 'acFields' => array('Project.name'), 'acSearchFieldNames' => array('Project.name'), 'maxlength' => '255', 'class' => 'form-control row')); ?>
								</div>
							</div>
						<?php } ?>
						<div class="submit hide">
							<?php echo $this->Form->submit(__l('Filter')); ?>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</li>
			</ul>
		</div>		
		<?php echo $this->Form->create('Message' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped project-comment">
				<thead class="h5">
					<tr>
						<th class="select text-center"><?php echo __l('Select');?></th>
						<th class="text-center table-action-width"><?php echo __l('Action');?></th>
						<th class="text-center"><?php echo __l('Subject'); ?></th>
						<?php if($type!='user_messages') { ?>
						<th class="text-left"><?php echo __l(Configure::read('project.alt_name_for_project_singular_caps')); ?></th>
						<?php } ?>
						<th class="text-left"><?php echo __l('From'); ?></th>
						<th class="text-center"><?php echo __l('To'); ?></th>
						<th class="text-center"><?php echo __l('Date'); ?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					$projectStatus = array();
					if (!empty($messages)) :   
					foreach($messages as $message):
					$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
					'projectStatus' => $projectStatus,
					'project' => $message,
					));
					$message_class = "";
					$projectStatus = $response->data['projectStatus'];
					// if empty subject, showing with (no suject) as subject as like in gmail
					if ($message['Message']['is_read']) :
					$message_class .= "js-checkbox-active";
					else :
					$message_class .= "js-checkbox-inactive";
					endif;
					if($message['MessageContent']['is_admin_suspended']):
					$message_class.= ' js-checkbox-suspended';
					else:
					$message_class.= ' js-checkbox-unsuspended';
					endif;
					if($message['MessageContent']['is_system_flagged']):
					$message_class.= ' js-checkbox-flagged';
					else:
					$message_class.= ' js-checkbox-unflagged';
					endif;

					$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
					?>
					<?php if(!empty($messages)) {?>
						<tr>
							<td class="text-center">
							<?php echo $this->Form->input('Message.'.$message['MessageContent']['id'].'.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => '', 'class' => $message_class.' js-checkbox-list'));?>
							</td> 
							<td class="text-center">
								<?php if($message['Message']['is_activity'] != 1) : ?>
								<div class="dropdown">
									<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
									<ul class="dropdown-menu">
										<li>
											<?php if($message['MessageContent']['is_admin_suspended']): ?>
											<?php echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Unsuspend'), Router::url(array('action' => 'admin_update_status', $message['MessageContent']['id'], 'status' => 'unsuspend'),true).'?r='.$this->request->url, array('class' => '','escape'=>false, 'title' => __l('Unsuspend')));
											else:
											echo $this->Html->link('<i class="fa fa-power-off fa-fw"></i>'.__l('Suspend'), Router::url(array('action' => 'admin_update_status', $message['MessageContent']['id'], 'status' => 'suspend'),true).'?r='.$this->request->url, array('class' => '','escape'=>false, 'title' => __l('Suspend')));
											endif;?>
										</li>
										<li>
											<?php
											if($message['MessageContent']['is_system_flagged']):
											echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Clear Flag'), Router::url(array('action' => 'admin_update_status', $message['MessageContent']['id'], 'status' => 'unflag'),true).'?r='.$this->request->url, array('class' => '','escape'=>false, 'title' => __l('Clear Flag')));
											else:
											echo $this->Html->link('<i class="fa fa-flag fa-fw"></i>'.__l('Flag'), Router::url(array('action' => 'admin_update_status', $message['MessageContent']['id'], 'status' => 'flag'),true).'?r='.$this->request->url, array('class' => '','escape'=>false, 'title' => __l('Flag')));
											endif;
											?>
										</li>
										<?php echo $this->Layout->adminRowActions($message['Message']['id']);  ?>
									</ul>
								</div>
								<?php endif; ?>
							</td>
							<td  class="text-center">
								<?php
								if (!empty($message['Label'])):
								?>
								<ul>
								<?php foreach($message['Label'] as $label): ?>
								<li>
								<span><?php echo $this->Html->cText($label['name']);?></span>
								</li>
								<?php
								endforeach;
								?>
								</ul>
								<?php
								endif;
								?>
								<?php
								if($message['MessageContent']['is_admin_suspended']):
								echo '<span class="label label-danger pro-status-6" title="' . __l('Admin Suspended') . '">' . __l('Suspended') . '</span>';
								endif;
								if($message['MessageContent']['is_system_flagged']):
								echo '<span class="label label-warning" title="' . __l('System Flagged') . '">' . __l('Flagged') . '</span>';
								endif;

								?>
								<span>
								<?php
								$subject = !empty($message['MessageContent']['subject']) ? $this->Html->cText($message['MessageContent']['subject'], false) . ' - ' : '';
								echo $this->Html->link($subject . substr($this->Html->cText($message['MessageContent']['message'], false), 0, Configure::read('messages.content_length')) , $view_url, array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal'));?></span>
							</td>
							<?php if($type!='user_messages') { ?>
							<td class="text-left">
								<div class="clearfix htruncate">
								<i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$message['Project']['id']]['id'], false); ?>" title="<?php echo $this->Html->cText($projectStatus[$message['Project']['id']]['name'], false); ?>"></i>
								<?php  
								if(!empty($message['Project']['name'])):
								echo $this->Html->link($this->Html->cText($message['Project']['name'], false), array('controller' => 'projects', 'action' => 'view', $message['Project']['slug'], 'admin' => false), array('title' => $this->Html->cText($message['Project']['name'], false), 'escape' => false));
								else:
								echo '-';
								endif;  
								?>  
								</div>	
							</td> 
							<?php } ?>        
							<td class="text-left">   
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($message['User'], 'micro_thumb',true, '', 'admin');?>
									</div>
									<div class="media-body">
										<p>
										<?php echo $this->Html->getUserLink($message['User']); ?>
										</p>
									</div>
								</div>
							</td>
							<td class="text-center">
								<?php if (!empty($message['OtherUser']['id'])): ?> 
								<ul class="list-inline tbl list-group-item-text">
									<li class="tbl-img">
										<?php echo $this->Html->getUserAvatar($message['OtherUser'], 'micro_thumb',true, '', 'admin');?>
									</li>
									<li class="tbl-cnt">
										<?php echo $this->Html->getUserLink($message['OtherUser']); ?>
									</li>
								</ul>
								<?php else: ?>
								<?php echo __l('All Users'); ?>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?>
							</td>
						</tr>
					<?php } ?>
					<?php endforeach; ?>
					<?php else : ?>
						<tr>
						<td colspan="8" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i>
						<?php
						if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'project_comments') {
						echo sprintf(__l('No %s %s available'), Configure::read('project.alt_name_for_project_singular_caps'), __l('Comments'));
						} else {
						echo sprintf(__l('No %s available'), __l('Messages'));
						}
						?>
						</td>
						</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>							
		</div>
		<div class="page-sec navbar-btn">
		<?php
			if (!empty($messages)):
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"}', 'title' => __l('Flagged'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-unflagged","unchecked":"js-checkbox-flagged"}', 'title' => __l('Unflagged'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"}', 'title' => __l('Suspended'))); ?>
					</li>
					<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
							<div class="hide">
							<?php echo $this->Form->submit('Submit');  ?>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		<?php
		endif;
		echo $this->Form->end();
		?>
	</div>
	</div>	
	
</div>	
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h2><?php echo __l('Message'); ?></h2>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
			<a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
			</div>
		</div>
	</div>
</div>