<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">		
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp; <span class="badge"><i class="fa fa-plus"></i> </span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'class' => 'js-no-pjax', 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right">
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('Country' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
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
		<?php echo $this->Form->create('Country' , array('action' => 'update','class'=>'js-shift-click js-no-pjax'));?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th rowspan="2" class="text-center"><?php echo __l('Select');?></th>
						<th rowspan="2" class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th rowspan="2" class="text-left"><?php echo $this->Paginator->sort('name',__l('Name'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('fips_code',__l('Fips Code'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('iso_alpha2',__l('Iso Alpha2'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('iso_alpha3',__l('Iso Alpha3'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('iso_numeric',__l('Iso Numeric'));?></th>
						<th rowspan="2" class="text-center"><?php echo $this->Paginator->sort('capital',__l('Capital'));?></th>
						<th colspan="2" class="text-center"><?php echo __l('Currency');?></th>
					</tr>
					<tr>
						<th class="text-center"><?php echo $this->Paginator->sort('currency',__l('Name'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('currency_code',__l('Code'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($countries)):
					foreach ($countries as $country):
					?>
					<tr>
						<td class="text-center">
							<?php echo $this->Form->input('Country.'.$country['Country']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$country['Country']['id'],'label' => '' , 'class' => 'js-checkbox-list')); ?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array( 'action'=>'edit', $country['Country']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$country['Country']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
									<?php echo $this->Layout->adminRowActions($country['Country']['id']);?>
									</li>
									<?php echo $this->Layout->adminRowActions($country['Country']['id']); ?>
								</ul>
							</div>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($country['Country']['name']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['fips_code']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['iso_alpha2']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['iso_alpha3']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['iso_numeric']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['capital']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['currencyname']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($country['Country']['currency']);?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="19" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Countries'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($countries)): ?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline clearfix">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'text-info js-select {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'text-info js-select {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
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