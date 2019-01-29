<?php /* SVN: $Id: admin_index.ctp 1279 2011-05-26 05:07:26Z siva_063at09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
		<h3>
			<i class="fa fa-th-list fa-fw"></i>
			<?php echo __l('List'); ?>
		</h3>
		<ul class="list-unstyled clearfix">
			<li class="pull-left"> 
				<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
			</li>
			<li class="pull-right"> 
				<div class="form-group srch-adon">
					<?php echo $this->Form->create('UserView' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
					<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
					<?php echo $this->Form->autocomplete('User.username', array('label' => false, 'placeholder' => __l('Search'), 'acFieldKey' => 'User.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'form-control')); ?>
					<div class="hide">
					<?php echo $this->Form->submit(__l('Search'));?>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</li>
		</ul>
		<?php echo $this->Form->create('UserView' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center col-sm-1"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('created',__l('Viewed Time'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('User.username',__l('Username'));?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('ViewingUser.username',__l('Viewed User'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Ip.ip',__l('IP'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($userViews)):
					foreach ($userViews as $userView):
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Form->input('UserView.'.$userView['UserView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userView['UserView']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $userView['UserView']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($userView['UserView']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cDateTimeHighlight($userView['UserView']['created']);?>
						</td>
						<td class="text-left">
							<?php if(!empty($userView['User'])){ ?>
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($userView['User'], 'micro_thumb',true, '', 'admin');?>
									</div>
									<div class="media-body">
										<p>
											<?php echo $this->Html->getUserLink($userView['User']); ?>
										</p>
									</div>
								</div>									
							<?php } else{
								echo '<span class="pull-left">'.__l('Guest').'</span>';
							}
							?>
						</td>
						<td class="text-left">
							<?php if(!empty($userView['ViewingUser']['id'])){ ?>
								<div class="media">
									<div class="pull-left">
										<?php echo $this->Html->getUserAvatar($userView['ViewingUser'], 'micro_thumb',true, '', 'admin');?>
									</div>
									<div class="media-body">
										<p>
											<?php echo $this->Html->getUserLink($userView['ViewingUser']); ?>
										</p>
									</div>
								</div>
							<?php } else{
								echo '<span class="pull-left">'.__l('Guest').'</span>';
							}
							?>
						</td>
						<td class="text-center">
							<?php
							if(!empty($userView['Ip'])): ?>
							<?php
							echo  $this->Html->link($userView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userView['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userView['Ip']['ip'], 'escape' => false)); ?>
							<p>
							<?php
							if(!empty($userView['Ip']['Country'])):
							?>
							<span class="flags flag-<?php echo strtolower($userView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($userView['Ip']['Country']['name'], false); ?>">
							<?php echo $this->Html->cText($userView['Ip']['Country']['name'], false); ?>
							</span>
							<?php
							endif;
							if(!empty($userView['Ip']['City'])):
							?>
							<span>   <?php echo $this->Html->cText($userView['Ip']['City']['name'], false); ?>  </span>
							<?php endif; ?>
							</p>
							<?php else: ?>
							<?php echo __l('n/a'); ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="7"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('User Views'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
			<?php
			if (!empty($userViews)) :
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 pull-left">					
					<ul class="list-inline clearfix">
						<li class="navbar-btn">
							<?php echo __l('Select:'); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
						</li>
						<li class="navbar-btn">
							<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select  text-info js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
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