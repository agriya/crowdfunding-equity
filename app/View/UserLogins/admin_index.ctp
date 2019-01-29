<?php /* SVN: $Id: admin_index.ctp 1279 2011-05-26 05:07:26Z siva_063at09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
		<?php if(empty($this->request->params['named']['view_type'])) : ?>
		<h3>
			<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
		</h3>
		<?php endif; ?>
		<ul class="list-unstyled clearfix">
			<li class="pull-left marg-top-20"> 
				<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
			</li>
			<li class="pull-right"> 
				<div class="form-group srch-adon navbar-btn marg-top-20">
					<?php echo $this->Form->create('UserLogin' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
					<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
					<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control')); ?>
					<div class="hide">
					<?php echo $this->Form->submit(__l('Search'));?>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</li>
		</ul>
			
		<?php echo $this->Form->create('UserLogin' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('created', __l('Login Time'), array('class' => 'js-filter js-no-pjax'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('User.username', __l('Username'), array('class' => 'js-filter js-no-pjax'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Ip.ip', __l('Login IP'), array('class' => 'js-filter js-no-pjax'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('user_agent', __l('User Agent'), array('class' => 'js-filter js-no-pjax'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($userLogins)): ?>
					<?php foreach ($userLogins as $userLogin):
					?>
					<tr>
						<td class="text-center"><?php echo $this->Form->input('UserLogin.'.$userLogin['UserLogin']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userLogin['UserLogin']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?></td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $userLogin['UserLogin']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($userLogin['UserLogin']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cDateTimeHighlight($userLogin['UserLogin']['created']);?>
						</td>
						<td class="text-left">
							<div class="media">
								<div class="pull-left">
									<?php echo $this->Html->getUserAvatar($userLogin['User'], 'micro_thumb',true, '', 'admin');?>
								</div>
								<div class="media-body">
									<p>
										<?php echo $this->Html->getUserLink($userLogin['User']); ?>
									</p>
								</div>
							</div>
						</td>
						<td class="text-center">
							<?php if(!empty($userLogin['Ip']['ip'])): ?>
							<?php echo  $this->Html->link($userLogin['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userLogin['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userLogin['Ip']['ip'], 'escape' => false));
							?>
							<p>
							<?php
							if(!empty($userLogin['Ip']['Country'])):
							?>
							<span class="flags flag-<?php echo strtolower($userLogin['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($userLogin['Ip']['Country']['name'], false); ?>">
							<?php echo $this->Html->cText($userLogin['Ip']['Country']['name'], false); ?>
							</span>
							<?php
							endif;
							if(!empty($userLogin['Ip']['City'])):
							?>
							<span>   <?php echo $this->Html->cText($userLogin['Ip']['City']['name'], false); ?>  </span>
							<?php endif; ?>
							</p>
							<?php else: ?>
							<?php echo __l('n/a'); ?>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($userLogin['UserLogin']['user_agent']);?>
						</td>
					</tr>
					<?php
					endforeach; ?>
					<?php else:
					?>
					<tr>
						<td colspan="6" class="text-center text-danger">
							<i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('User Logins'));?>
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
			if (!empty($userLogins)) :
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-md-6 pull-left">				
					<ul class="list-inline text-left">
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
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
				<div class="col-xs-12 col-sm-7 col-md-6 pull-right">
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

