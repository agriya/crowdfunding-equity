<?php /* SVN: $Id: admin_index.ctp 1916 2010-05-18 13:35:04Z jayashree_028ac09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">		
		<ul class="list-inline sec-1 navbar-btn">
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($approved,false).'</span><span>' .__l('Approved'). '</span>', array('controller'=>'cities','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($pending,false).'</span><span>' .__l('Disapproved'). '</span>', array('controller'=>'cities','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($pending + $approved,false).'</span><span class="text-center">' .__l('All'). '</span>', array('controller'=>'cities','action'=>'index'), array('escape' => false));?>
				</div>
			</li>
		</ul>		
	</div>
	<div class="clearfix">		
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List'); ?>
				<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp; <span class="badge"><i class="fa fa-plus fa-fw"></i> </span></button>', array('action' => 'add'),array('title' =>  __l('Add'), 'class' => 'js-no-pjax', 'escape' => false));?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
				<li class="pull-right"> 
					<div class="form-group srch-adon">
						<?php echo $this->Form->create('City' , array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
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
		<?php echo $this->Form->create('City', array('action' => 'update','class'=>'clearfix js-shift-click js-no-pjax')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center"><?php echo __l('Select'); ?></th>
						<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('Country.name', __l('Country') , array('url'=>array('controller'=>'cities', 'action'=>'index')));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('State.name', __l('State') , array('url'=>array('controller'=>'cities', 'action'=>'index')));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('latitude', __l('Latitude'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('longitude', __l('Longitude'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('timezone', __l('Timezone'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('county', __l('County'));?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('code', __l('Code'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php if (!empty($cities)):
					foreach ($cities as $city):
					if($city['City']['is_approved'] == '1')  :
					$status_class = 'js-checkbox-active';
					$disabled = '';
					else:
					$status_class = 'js-checkbox-inactive';
					$disabled = 'class="disabled"';
					endif;
					?>
					<tr <?php echo $disabled; ?>>
						<td class="text-center">
							<?php echo $this->Form->input('City.'.$city['City']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$city['City']['id'],'label' => '' , 'class' => $status_class.' js-checkbox-list'));?>
						</td>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
										<?php if($city['City']['is_approved']):
											echo $this->Html->link('<i class="fa fa-thumbs-down fa-fw"></i>'.__l('Disapprove'), Router::url(array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'disapprove'),true).'?r='.$this->request->url, array('class' => 'js-confirm','escape'=>false, 'title' => __l('Disapprove')));
										else:
											echo $this->Html->link('<i class="fa fa-thumbs-up fa-fw"></i>'.__l('Approve'), Router::url(array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'approve'),true).'?r='.$this->request->url, array('class' => 'js-confirm','escape'=>false, 'title' => __l('Approve')));
										endif; ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action'=>'edit', $city['City']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
										<?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$city['City']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($city['City']['id']); ?>
								</ul>
							</div>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cText($city['Country']['name'], false);?>
						</td>
						<td class="text-center"><?php echo $this->Html->cText($city['State']['name'], false);?></td>
						<td class="text-center"><?php echo $this->Html->cText($city['City']['name'], false);?></td>
						<td class="text-center"><?php echo $this->Html->cFloat($city['City']['latitude']);?></td>
						<td class="text-center"><?php echo $this->Html->cFloat($city['City']['longitude']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($city['City']['timezone']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($city['City']['county']);?></td>
						<td class="text-center"><?php echo $this->Html->cText($city['City']['code']);?></td>
					</tr>
					<?php
					endforeach;
					else: ?>
					<tr>
						<td colspan="10" class="text-center text-danger">
						<i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Cities'));?>
						</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($cities)) : ?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
				<ul class="list-inline clearfix">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}','title'=>__l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}','title'=>__l('None'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}','title'=>__l('Disapproved'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}','title'=>__l('Approved'))); ?>
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
		<?php endif;?>
		<?php echo $this->Form->end();?>
		</div>
	</div>		
</div>