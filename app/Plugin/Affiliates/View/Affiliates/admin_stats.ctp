<div class="main-admn-usr-lst js-response">
	<h2><?php echo __l('Stats'); ?></h2>		
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="h5">
				<tr>
					<th colspan="2" class="text-center">&nbsp;</th>
					<?php foreach($periods as $key => $period){ ?>
					<th class="text-center">
					<?php echo $period['display'].' ('.Configure::read('site.currency').')'; ?>
					</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody class="h5">
				<?php
				foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
				$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
				<?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>
				<?php if(!isset($fields['isSub'])) :?>
				<tr>
				<td <?php echo $this->Html->cText($element, false);?>>
				<?php echo $this->Html->cText($fields['display']); ?>
				</td>
				<?php endif;?>
				<?php if(isset($fields['isSub'])) :  ?>
				<td >
				<?php echo $this->Html->cText($fields['display']); ?>
				</td>
				<?php endif; ?>
				<?php if(!isset($fields['colspan'])) :?>
				<?php foreach($periods as $key => $period){ ?>
				<td class="text-center">
				<span>
				<?php
				if(empty($fields['type'])) {
				$fields['type'] = 'cInt';
				}
				if (!empty($fields['link'])):
				$fields['link']['stat'] = $key;
				echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
				else:
				echo $this->Html->{$fields['type']}(${$aliasName.$key});
				endif;
				?>
				</span>
				</td>
				<?php } ?>
				</tr>
				<?php endif; ?>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>	
</div>