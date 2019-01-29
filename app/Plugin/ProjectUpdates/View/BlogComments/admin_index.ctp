<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">
		<div class="clearfix">
			<ul class="list-inline sec-1 navbar-btn">
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($suspended,false).'</span><span>' .__l('Suspended'). '</span>', array('controller'=>'blog_comments','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($system_flagged,false).'</span><span>' .__l('Flagged'). '</span>', array('controller'=>'blog_comments','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($total,false).'</span><span>' .__l('Total'). '</span>', array('controller'=>'blog_comments','action'=>'index'), array('escape' => false));?>
					</div>
				</li>
			</ul>
		</div>
	</div>
    <div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right">
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('BlogComment' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
						<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
						<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control', 'aria-describedby' => 'basic-addon1')); ?>
						<div class="hide"><?php echo $this->Form->submit(__l('Search'));?></div>
						<?php echo $this->Form->end(); ?>
					</div>
				</li>
			</ul>
		</div>
		<?php echo $this->Form->create('BlogComment' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="select text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center"><?php echo __l('Actions');?></th>
						<th class="text-left"><?php echo __l(Configure::read('project.alt_name_for_project_plural_caps'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('comment', __l('Comment'));?></th>
						<th class="text-left"><div><?php echo $this->Paginator->sort('Blog.title', __l('Updates'));?></div></th>
						<th><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
						<th><?php echo $this->Paginator->sort('Ip.ip', __l('IP'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					  $projectStatus = array();
					  if (!empty($blogComments)):
						foreach ($blogComments as $blogComment):
						$response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
						  'projectStatus' => $projectStatus,
						  'project' => $blogComment['Blog'],
						));
						$projectStatus = $response->data['projectStatus'];
						$status_class='';
						if($blogComment['BlogComment']['is_admin_suspended']):
						  $status_class = ' js-checkbox-suspended';
						else:
						  $status_class = ' js-checkbox-unsuspended';
						endif;
						if($blogComment['BlogComment']['is_system_flagged']):
						  $status_class.= ' js-checkbox-flagged';
						else:
						  $status_class.= ' js-checkbox-unflagged';
						endif;
					?>
					<?php if(!empty($blogComment['Blog']['Project']['id'])){ ?>
					<tr>
						<td class="select text-center">
							<?php echo $this->Form->input('BlogComment.'.$blogComment['BlogComment']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$blogComment['BlogComment']['id'], 'label' => '', 'class' =>$status_class.' js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
										<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $blogComment['BlogComment']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<li>
										<?php
											if($blogComment['BlogComment']['is_admin_suspended']):
											  echo $this->Html->link('<i class="fa fa-repeat"></i><span>'.__l('Unsuspend').'</span>', array('action' => 'admin_update_status', $blogComment['BlogComment']['id'], 'status' => 'unsuspend'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Unsuspend')));
											else:
											  echo $this->Html->link('<i class="fa fa-power-off"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $blogComment['BlogComment']['id'], 'status' => 'suspend'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Suspend')));
											endif;
										 ?>
									</li>
									<li>
										 <?php
											if($blogComment['BlogComment']['is_system_flagged']):
											  echo $this->Html->link('<i class="fa fa-times-circle-o"></i>'.__l('Clear Flag'), array('action' => 'admin_update_status', $blogComment['BlogComment']['id'], 'status' => 'unflag'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Clear Flag')));
											else:
											  echo $this->Html->link('<i class="fa fa-flag"></i>'.__l('Flag'), array('action' => 'admin_update_status', $blogComment['BlogComment']['id'], 'status' => 'flag'), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Flag')));
											endif;
										  ?>
									</li>
									<?php echo $this->Layout->adminRowActions($blogComment['BlogComment']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-left">
							<i class="fa fa-square project-status-<?php echo $this->Html->cInt($projectStatus[$blogComment['Blog']['Project']['id']]['id'], false); ?>" title="<?php echo $this->Html->cText($projectStatus[$blogComment['Blog']['Project']['id']]['name'], false); ?>"></i>
							<span><?php echo $this->Html->link($this->Html->cText($blogComment['Blog']['Project']['name'],false), array('controller'=> 'projects', 'action'=>'view', $blogComment['Blog']['Project']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($blogComment['Blog']['Project']['name'],false)));?></span>
						</td>
						<td class="text-left">
							<span class="js-tooltip" title="<?php echo $this->Html->cText($blogComment['BlogComment']['comment'], false);?>">
								<?php echo $this->Html->cText($blogComment['BlogComment']['comment'], false);?>
							</span>
							<?php
							  if($blogComment['BlogComment']['is_admin_suspended']):
								echo '<span class="label label-danger pro-status-6">'.__l('Admin Suspended').'</span>';
							  endif;
							  if($blogComment['BlogComment']['is_system_flagged']):
								echo '<span class="label label-warning">'.__l('System Flagged').'</span>';
							  endif;
							  if(!empty($blogComment['BlogComment']['project_flag_count'])) :
								echo '<span class="label label-info">'.__l('User Flagged').'</span>';
							  endif;
							?>
						</td>
						<td class="text-left">
							<?php echo $this->Html->link($this->Html->cText($blogComment['Blog']['title']), array('controller'=> 'blogs', 'action'=>'view', $blogComment['Blog']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($blogComment['Blog']['title'],false)));?>
						</td>
						<td>
							<ul class="list-inline tbl">
								<li class="tbl-img">
									<?php echo $this->Html->getUserAvatar($blogComment['User'], 'micro_thumb',true, '', 'admin');?>
								</li>
								<li class="tbl-cnt">
									<?php echo $this->Html->getUserLink($blogComment['User']); ?>
								</li>
							</ul>
						</td>
						<td class="text-left">
							<?php if(!empty($blogComment['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($blogComment['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $blogComment['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$this->Html->cText($blogComment['Ip']['ip'],false), 'escape' => false)); ?>
							<p>
								<?php if(!empty($blogComment['Ip']['Country'])): ?>
								<span class="flags flag-<?php echo strtolower($blogComment['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($blogComment['Ip']['Country']['name'], false); ?>"><?php echo $this->Html->cText($blogComment['Ip']['Country']['name'], false); ?></span>
								<?php endif; ?>
								<?php if(!empty($blogComment['Ip']['City'])): ?>
								<span><?php echo $this->Html->cText($blogComment['Ip']['City']['name'], false); ?></span>
								<?php endif; ?>
							</p>
							<?php else: ?>
							<?php echo __l('n/a'); ?>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cDateTimeHighlight($blogComment['BlogComment']['created']);?>
						</td>
					</tr>
					<?php } ?>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="9" class="text-center text-danger text-12"><i class="fa fa-exclamation-triangle fa-fw"></i><?php echo sprintf(__l('No %s available'), sprintf(__l('%s Update Comments'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
					</tr>
					<?php
					  endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
			<?php if (!empty($blogComments)) : ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">					
					<ul class="list-inline clearfix">
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
							<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"}', 'title' => __l('Suspended'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select text-info js-no-pjax js-admin-select-flagged {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"}', 'title' => __l('Flagged'))); ?>
						</li>
						<li>
							<div class="admin-checkbox-button">
								<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
								<div class="hide"><?php echo $this->Form->submit('Submit'); ?></div>
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
