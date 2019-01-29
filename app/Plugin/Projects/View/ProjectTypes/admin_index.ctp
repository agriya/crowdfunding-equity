<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">
		<div class="navbar-btn">
			<h3>
				<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>
			</h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<div class="alert alert-info">
			<?php echo sprintf(__l('Customize form fields and pricing for Modules/%s Types'), Configure::read('project.alt_name_for_project_singular_caps'));?>
		</div>
		<?php echo $this->Form->create('ProjectType' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax'));?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th rowspan ="2" class="text-center table-action-width"><?php echo __l('Actions'); ?></th>
						<th rowspan ="2" class="text-left" ><?php echo $this->Paginator->sort('name', __l('Name')); ?></th>
						<th rowspan ="2" class="text-center" ><?php echo $this->Paginator->sort('form_field_count', __l('Form Fields')); ?></th>
						<th colspan="2" class="text-center" ><?php echo  __l('Pricing/Fee'); ?></th>
						<th rowspan ="2" class="text-center" ><?php echo $this->Paginator->sort('project_count', sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps'))); ?></th>
						</tr>
						<tr>
						<th class="text-center"><?php echo $this->Paginator->sort('commission_percentage', __l('Fund Commission %')); ?></th>
						<th class="text-center"><?php echo $this->Paginator->sort('listing_fee', __l('Listing Fee')); ?></th>
					</tr>
				</thead>
				<tbody class="h6">
					<?php
					if (!empty($ProjectTypes)):
					foreach ($ProjectTypes as $ProjectType):
					if($ProjectType['ProjectType']['is_active'])  :
					$disabled = '';
					else:
					$disabled = 'class="disabled"';
					endif;
					?>
					<tr <?php echo $disabled; ?>>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li> 
										<?php echo $this->Html->link('<i class="fa fa-columns fa-fw"></i>'.__l('Form Fields'), array('controller'=>'project_types','action'=>'edit', $ProjectType['ProjectType']['id']), array('class' => 'js-edit', 'escape'=>false,'title' => __l('Form Fields')));?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-briefcase fa-fw"></i>'.__l('Pricing'), array('controller'=>'project_types','action'=>'admin_pricing', $ProjectType['ProjectType']['id']), array('class' => '', 'escape'=>false,'title' => __l('Pricing')));?> 
									</li>
									<li> 
										<?php echo $this->Html->link('<i class="fa fa-eye fa-fw"></i>'.__l('Preview'), array('controller' => 'project_types', 'action' => 'admin_preview', $ProjectType['ProjectType']['id']),array('title' =>  __l('Preview'), 'escape' => false));?> 
									</li>
									<li>
										<?php echo $this->Html->link((isPluginEnabled($ProjectType['ProjectType']['name']))? '<i class="fa fa-remove fa-fw"></i>'.__l('Disable') : '<i class="fa fa-ok"></i>'.__l('Enable'), array('controller'=>'extensions_plugins','action' => 'toggle', $ProjectType['ProjectType']['name'],'type'=>$ProjectType['ProjectType']['slug']), array('escape' => false, 'class' => 'js-confirm js-no-pjax')); ?>
									</li>
									<?php echo $this->Layout->adminRowActions($ProjectType['ProjectType']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-left">
							<?php echo $this->Html->cText($ProjectType['ProjectType']['name']);?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cInt($ProjectType['ProjectType']['form_field_count']);?>
						</td>
						<td class="text-center">
							<?php echo (!is_null($ProjectType['ProjectType']['commission_percentage']))?$this->Html->cFloat($ProjectType['ProjectType']['commission_percentage']):'-';?>
						</td>
						<td class="text-center">
							<?php echo (!is_null($ProjectType['ProjectType']['listing_fee']))?$this->Html->cFloat($ProjectType['ProjectType']['listing_fee']):'-';?>
							<?php
							if(!is_null($ProjectType['ProjectType']['listing_fee_type']) && !is_null($ProjectType['ProjectType']['listing_fee'])):
							echo (($ProjectType['ProjectType']['listing_fee_type']==ConstListingFeeType::percentage))?'%': Configure::read('site.currency');
							endif;
							?>
						</td>
						<td class="text-center">
							<?php echo $this->Html->cInt($ProjectType['ProjectType']['project_count']) ;?>
						</td>
					</tr>
					<?php
					endforeach;
					else:
					$title = 'Project types';
					if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'templates'){
					$title = 'Project templates';
					}
					?>
					<tr>
						<td colspan ="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i><?php echo sprintf(__l('No %s available'), $title);?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="page-sec navbar-btn">
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
	</div>
</div>

