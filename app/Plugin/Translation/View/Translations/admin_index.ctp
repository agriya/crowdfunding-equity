<?php /* SVN: $Id: admin_index.ctp 71528 2011-11-15 16:48:55Z anandam_023ac09 $ */ ?>
<div class="main-admn-usr-lst js-response">
	<?php
	if (empty($translations)): ?>
	<div>
		<i class="fa fa-exclamation-triangle"></i>
		<?php echo __l('Sorry, in order to translate, default English strings should be extracted and available. Please contact support.');?>
	</div>
	<?php endif; ?>
	<div class="navbar-btn h5 text-info text-right">
		<ul class="list-inline"> 
			<li><i class="fa fa-plus-circle fa-fw"></i> <a title="Make New Translation" href="<?php echo Router::url('/', true); ?>admin/translations/add"><?php echo __l(' Make New Translation'); ?></a> </li>
			<li><i class="fa fa-plus-circle fa-fw"></i> <a title="Add New Text" href="<?php echo Router::url('/', false); ?>admin/translations/add_text"><?php echo __l(' Add New Text'); ?></a> </li>
		</ul>
	</div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="h5">
				<tr>
					<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
					<th class="text-center"><?php echo __l('Language');?></th>
					<th class="text-center"><?php echo __l('Verified');?></th>
					<th class="text-center"><?php echo __l('Not Verified');?></th>
				</tr>
			</thead>
			<tbody class="h5">
				<?php
				if (!empty($translations)):
				foreach ($translations as $language_id => $translation):
				?>
				<tr>
					<td class="text-center">
						<div class="dropdown">
							<a href="#" title="Actions" data-toggle="dropdown" class="dropdown-toggle js-no-pjax">
								<i class="fa fa-cog"></i><span class="hide">Action</span>
							</a>
							<ul class="dropdown-menu dl pull-left">
								<li>
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('action' => 'manage', 'language_id' => $language_id), array('class' => 'js-edit', 'title' => __l('Edit'), 'escape' => false));?>
								</li>
								<?php if($language_id != '42'):?>
								<li>
									<?php echo $this->Html->link('<i class="fa fa-times"></i>'.__l('Delete Translation'), array('action' => 'index', 'remove_language_id' => $language_id), array('class' => 'js-confirm', 'title' => __l('Delete Translation'), 'escape' => false));?>
								</li>
								<?php endif;?>
								<?php echo $this->Layout->adminRowActions($language_id);  ?>
							</ul>
						</div>
					</td>
					<td class="text-center"><?php echo $this->Html->cText($translation['name']);?></td>
					<td class="text-center"><?php
					if($translation['verified']){
					echo $this->Html->link($translation['verified'], array('action' => 'manage', 'filter' => 'verified', 'language_id' => $language_id));
					} else {
					echo $this->Html->cText($translation['verified']);
					}
					?>
					</td>
					<td class="text-center"><?php
					if($translation['not_verified']){
					echo $this->Html->link($translation['not_verified'], array('action' => 'manage', 'filter' => 'unverified', 'language_id' => $language_id));
					} else {
					echo $this->Html->cText($translation['not_verified']);
					}
					;?></td>
				</tr>
				<?php
				endforeach;
				else:
				?>
				<tr>
					<td colspan="7" class="text-center text-danger"><i class="fa fa-warning fa-fw"></i> <?php echo sprintf(__l('No %s available'), __l('Translations'));?></td>
				</tr>
				<?php
				endif;
				?>
			</tbody>
		</table>
	</div>
</div>
