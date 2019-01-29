<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<section class="main-admn-usr-lst js-response">
	<div class="aclLinks index js-response">
		<div class="container-fluid">
			<div class="row usr-lst">
				<div class="col-sm-12">
					<ul class="list-unstyled">
						<li class="col-xs-12 col-sm-7 col-md-7 pull-left"> 
							<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
						</li>
						<li class="col-xs-12 col-sm-4 col-md-3 pull-right mgn-tp-18"> 
							<?php
							echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add New Acl Link')));
							echo $this->Html->link(__l('Generate Actions'), array('action' => 'generate'), array('title' => __l('It will generate actions from file structure'), 'class' => 'js-generate'));
							?>
						</li>
					</ul>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="h5">
						<tr>
							<th><?php echo __l('Actions'); ?></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('name'); ?></div></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('controller'); ?></div></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('action'); ?></div></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('named_key'); ?></div></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('named_value'); ?></div></th>
							<th class="text-left"><div><?php echo $this->Paginator->sort('pass_value'); ?></div></th>
						</tr>
					</thead>
					<tbody class="h5">
						<?php
						if (!empty($aclLinks)):
						foreach ($aclLinks as $aclLink):
						?>
						<tr>
							<td>
								<div>
								<span>
								<span>&nbsp;
								</span>
								<span>
								<span>
								<?php echo __l('Action');?>
								</span>
								</span>
								</span>
								<div>
								<div>
								<ul class="clearfix">
								<li><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $aclLink['AclLink']['id']), array('class' => 'js-edit', 'title' => __l('Edit')));?></li>
								<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $aclLink['AclLink']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?></li>
								</ul>
								</div>
								<div></div>
								</div>
								</div>
							</td>
							<td class="text-left"><?php echo $this->Html->cText($aclLink['AclLink']['name']);?></td>
							<td class="text-left"><?php echo $this->Html->cText($aclLink['AclLink']['controller']);?></td>
							<td class="text-left"><?php echo $this->Html->cText($aclLink['AclLink']['action']);?></td>
							<td class="text-left"><?php echo $this->Html->cBool($aclLink['AclLink']['named_key']);?></td>
							<td class="text-left"><?php echo $this->Html->cBool($aclLink['AclLink']['named_value']);?></td>
							<td class="text-left"><?php echo $this->Html->cBool($aclLink['AclLink']['pass_value']);?></td>
						</tr>
						<?php
						endforeach;
						else:
						?>
						<tr>
							<td colspan="7"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Acl Links'));?></td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row page-sec navbar-btn">
				<?php
				if (!empty($aclLinks)) : ?>
					<div class="col-xs-12 col-sm-6 pull-right clearfix">
						<?php echo $this->element('paging_links'); ?>
					</div>	
				<?php
				endif; ?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</section>