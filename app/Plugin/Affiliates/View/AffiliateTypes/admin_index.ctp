<?php /* SVN: $Id: $ */ ?>
<div class="main-admn-usr-lst js-response">
	<div class="clearfix">
		<div class="navbar-btn">
			<h3><?php echo __l('Affiliate Types');?></h3>
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>          
						<th><?php echo __l('Actions');?></th>
						<th><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
						<th><?php echo $this->Paginator->sort('commission', __l('Commission'));?></th>
						<th><?php echo __l('Commission Type');?></th>
						<th><?php echo $this->Paginator->sort('is_active', __l('Active?'));?></th>
					</tr>
						<?php
						if (!empty($affiliateTypes)):
						$i = 0;
						foreach ($affiliateTypes as $affiliateType):
						  if ($i++ % 2 == 0) {
						  if($affiliateType['AffiliateType']['is_active']):
							$status_class = 'js-checkbox-active';
						  else:
							$status_class = 'js-checkbox-inactive';
						  endif;
						  }
						?>
				</thead>
				<tbody class="h6">
					<tr>
						<td class="text-left"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $affiliateType['AffiliateType']['id']), array('class' => 'js-edit', 'title' => __l('Edit')));?></span></td>
						<td><?php echo $this->Html->cText($affiliateType['AffiliateType']['name']);?></td>
						<td><?php echo $this->Html->siteCurrencyFormat($affiliateType['AffiliateType']['commission']);?></td>
						<td><?php echo $this->Html->cText( $affiliateType['AffiliateCommissionType']['description'] . ' ('.$affiliateType['AffiliateCommissionType']['name'].')');?></td>
						<td><?php echo $this->Html->cBool($affiliateType['AffiliateType']['is_active']);?></td>
					</tr>
					<?php
					  endforeach;
					else:
					?>
					<tr>
						<td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Affiliate Types'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>