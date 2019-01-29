<?php /* SVN: $Id: admin_index.ctp 71289 2011-11-14 12:28:02Z anandam_023ac09 $ */ ?>
<div class="main-admn-usr-lst js-response">
<?php if(!empty($this->request->params['isAjax'])):
echo $this->element('flash_message');
endif; ?>
	<div class="clearfix">		
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('User List');?>
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp; <span class="badge"><i class="fa fa-plus fa-fw"></i> </span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>		
		<?php echo $this->Form->create('BannedIp' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>          
						<th class="text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('BannedIp.address', __l('Victims'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('BannedIp.reason', __l('Reason'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('BannedIp.redirect', __l('Redirect to'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('BannedIp.thetime', __l('Date Set'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('BannedIp.timespan', __l('Expiry Date'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($bannedIps)):
					foreach ($bannedIps as $bannedIp):
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Form->input('BannedIp.'.$bannedIp['BannedIp']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$bannedIp['BannedIp']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), array('action'=>'delete',$bannedIp['BannedIp']['id']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($bannedIp['BannedIp']['id']); ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php
							if ($bannedIp['BannedIp']['referer_url']) :
							echo $this->Html->cText($bannedIp['BannedIp']['referer_url'], false);
							else:
							echo long2ip($bannedIp['BannedIp']['address']);
							if ($bannedIp['BannedIp']['range']) :
							echo ' - '.long2ip($bannedIp['BannedIp']['range']);
							endif;
							endif;
							?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($bannedIp['BannedIp']['reason']);?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($bannedIp['BannedIp']['redirect']);?>
						</td>
						<td class="text-center">
							<?php echo date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']); ?>
						</td>
						<td class="text-center">
							<?php echo ($bannedIp['BannedIp']['timespan'] > 0) ? date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']) : __l('Never');?>
						</td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="7" class="text-center text-danger">
							<i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Banned IPs'));?>
						</td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($bannedIps)): ?>
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