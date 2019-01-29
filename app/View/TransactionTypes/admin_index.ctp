<?php /* SVN: $Id: admin_index.ctp 5198 2010-12-15 13:11:02Z suresh_006ac09 $ */ ?>
<?php
if(!empty($this->request->params['isAjax'])):
echo $this->element('flash_message');
endif;
?>
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
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="h5">
					<tr>
						<th class="text-center table-action-width"><?php echo __l('Action'); ?></th>
						<th class="text-left"><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($transactionTypes)):
					foreach ($transactionTypes as $transactionType):
					?>
					<tr>
						<td class="text-center">
							<div class="dropdown">
								<a href="#" title="Actions" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle js-no-pjax"><i class="fa fa-cog"></i><span class="hide">Action</span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action'=>'edit', $transactionType['TransactionType']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
									</li>
									<?php echo $this->Layout->adminRowActions($transactionType['TransactionType']['id']);  ?>
								</ul>
							</div>
						</td>
						<td class="text-left"><?php echo $this->Html->cText($transactionType['TransactionType']['name']);?></td>
					</tr>
					<?php
					endforeach;
					else:
					?>
					<tr>
						<td colspan="2"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Transaction Types'));?></td>
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
				<?php echo $this->element('paging_links');  ?>
			</div>
		</div>
	</div>
</div>
