<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="blogViews index">
		<div class="clearfix">
			<div class="navbar-btn">
				<h3><?php echo __l('Update Views');?></h3>
				<ul class="list-unstyled clearfix">	
					<li class="pull-left"> 
						<p><?php echo $this->element('paging_counter');?></p>
					</li>
					<li class="pull-right"> 
						<div class="form-group srch-adon">
							<?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
								<?php echo $this->Form->create('BlogView' , array('type' => 'get', 'action' => 'index')); ?>
								<span class="form-control-feedback" id="basic-addon1"  aria-hidden="true"><i class="fa fa-search text-default"></i></span>
								<?php echo $this->Form->input('q', array('label' => 'Keyword')); ?>
								<div class="hide">
								<?php echo $this->Form->submit(__l('Search'));?>
								</div>
							<?php echo $this->Form->end(); ?>
							<?php endif; ?>
						</div>
					</li>
				</ul>
			</div>
			<?php echo $this->Form->create('BlogView' , array('action' => 'update')); ?>
			<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
			
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo __l('Select'); ?></th>
							<th><?php echo __l('Actions');?></th>
							<th><div><?php echo $this->Paginator->sort('Blog.name', __l('Blog'));?></div></th>
							<th class="text-center"><div><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
							<th><div><?php echo $this->Paginator->sort('Ip.ip', __l('IP'));?></div></th>
							<th><div><?php echo $this->Paginator->sort('created', __l('Viewed On'));?></div></th>
						</tr>
					</thead>
					<tbody class="h6">
						<?php
						if (!empty($blogViews)):
						foreach ($blogViews as $blogView):
						?>
						<tr>
							<td><?php echo $this->Form->input('BlogView.'.$blogView['BlogView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$blogView['BlogView']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?></td>
							<td class="text-left"><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $blogView['BlogView']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?></span></td>
							<td><?php echo $this->Html->link($this->Html->cText($blogView['Blog']['title']), array('controller'=> 'blogs', 'action'=>'view', $blogView['Blog']['slug'], 'admin' => false), array('escape' => false));?></td>
							<td>
							<?php echo !empty($blogView['User']['username']) ? $this->Html->link($this->Html->cText($blogView['User']['username']), array('controller'=> 'users', 'action'=>'view', $blogView['User']['username'], 'admin' => false), array('escape' => false)) : __l('Guest');?>
							</td>
							<td class="text-left">
							<?php if(!empty($blogView['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($blogView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $blogView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$blogView['Ip']['ip'], 'escape' => false));
							?>
							<p>
							<?php
							if(!empty($blogView['Ip']['Country'])):
							?>
							<span class="flags flag-<?php echo strtolower($blogView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($blogView['Ip']['Country']['name'], false); ?>">
							<?php echo $this->Html->cText($blogView['Ip']['Country']['name'], false); ?>
							</span>
							<?php
							endif;
							if(!empty($blogView['Ip']['City'])):
							?>
							<span>   <?php echo $this->Html->cText($blogView['Ip']['City']['name'], false); ?>  </span>
							<?php endif; ?>
							</p>
							<?php else: ?>
							<?php echo __l('n/a'); ?>
							<?php endif; ?>
							</td>
							<td><?php echo $this->Html->cDateTimeHighlight($blogView['BlogView']['created']);?></td>
						</tr>
						<?php
						endforeach;
						else:
						?>
						<tr>
							<td colspan="6"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), sprintf(__l('%s Update Views'), Configure::read('project.alt_name_for_project_singular_caps')));?></td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
			<div class="page-sec navbar-btn">
			<?php
				if (!empty($blogViews)) :
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">
					<ul class="list-inline js-select-action clearfix">
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
						</li>
						<li>
							<div class="admin-checkbox-button">
								<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
								<div class="hide">
									<?php echo $this->Form->submit('Submit'); ?>
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
</div>