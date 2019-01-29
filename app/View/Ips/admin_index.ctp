<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
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
						<?php echo $this->Form->create('Ip' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
						<span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
						<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control')); ?>
						<div class="hide">
							<?php echo $this->Form->submit(__l('Search'));?>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</li>
			</ul>
		</div>		
		<?php echo $this->Form->create('Ip', array('class' => 'clearfix js-shift-click js-no-pjax', 'action'=>'update'));?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th rowspan="2" class="text-center"><?php echo __l('Select');?></th>
						<th rowspan="2" class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('created',__l('Created'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('ip',__l('IP'));?></th>
						<th colspan="5" class="text-center"><?php echo __l('Auto detected'); ?></th>
					</tr>
					<tr>
						<th class="text-center"><?php echo $this->Paginator->sort('City.name',__l('City'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('State.name',__l('State'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Country.name',__l('Country'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('latitude',__l('Latitude'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('longitude',__l('Longitude'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($ips)):
					foreach ($ips as $ip):
					$status_class = 'js-checkbox-deactiveusers';
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Form->input('Ip.'.$ip['Ip']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$ip['Ip']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$ip['Ip']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($ip['Ip']['id']); ?>
								</ul>
							</div>
						</td>
						<td class="text-center"><?php echo $this->Html->cDateTime($ip['Ip']['created']);?></td>
						<td class="text-center">
							<?php echo  $this->Html->link($ip['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $ip['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$ip['Ip']['ip'], 'escape' => false));?>
							<?php if (!empty($ip['Ip']['user_agent'])) { ?>
							<span class="cur js-tooltip pull-right" title="<?php echo $this->Html->cText($ip['Ip']['user_agent'], false);?>"><i class="fa fa-info-circle"></i></span>
							<?php } ?>
						</td>
						<td class="text-center"><?php echo $this->Html->cText($ip['City']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($ip['State']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($ip['Country']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->cFloat($ip['Ip']['latitude']);?></td>
						<td class="text-center"><?php echo $this->Html->cFloat($ip['Ip']['longitude']);?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="11" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('IPs'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php
			if (!empty($ips)) :
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
			<div class="col-xs-12 col-sm-6 pull-right clearfix">
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