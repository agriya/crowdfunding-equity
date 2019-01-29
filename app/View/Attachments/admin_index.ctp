<div class="main-admn-usr-lst js-response">
	<div class="attachments index">
		<div class="clearfix">
			<div class="navbar-btn">
				<h3>
					<?php echo $this->Html->link(sprintf(__l('Add %s'), __l('Attachment')), array('controller' => 'attachments', 'action' => 'add'), array('title' => __l('Add Attachment'))); ?>
				</h3>
				<ul class="list-unstyled clearfix">
					<li class="pull-left"> 
						<p>
							<?php echo $this->element('paging_counter');?>
						</p>
					</li>
				</ul>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo __l('Actions'); ?></th>
							<th><?php echo __l('Image'); ?></th>
							<th><div><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
							<th><div><?php echo $this->Paginator->sort('alias', __l('URL')); ?></div></th>
						</tr>
					</thead>
					<tbody class="h6">
						<?php if (!empty($attachments)):
						foreach ($attachments AS $attachment) { ?>
						<tr>
							<td  class="actions">
								<div>
									<span>
									<?php echo __l('Action');?>
									</span>
									<div>
										<ul>
											<li>
											<?php echo $this->Html->link(__l('Edit'), array('controller' => 'attachments', 'action' => 'edit', $attachment['Node']['id']), array('title' => __l('Edit')));?>
											</li>
											<li>
											<?php echo $this->Html->link(__l('Delete'), array('controller' => 'attachments', 'action' => 'delete', $attachment['Node']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?>
											</li>
										</ul>
									</div>
								</div>
							</td>
							<td>
								<?php
								$mimeType = explode('/', $attachment['Node']['mime_type']);
								$mimeType = $mimeType['0'];
								if ($mimeType == 'image') {
								$thumbnail = $this->Html->link($this->Image->resize($attachment['Node']['path'], 100, 200), '#', array('onclick' => "selectURL('".$attachment['Node']['slug']."',0);",'escape' => false,));
								} else {
								$thumbnail = $this->Html->image('/img/icons/page_white.png') . ' ' . $attachment['Node']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Node']['slug']) . ')';
								$thumbnail = $this->Html->link($thumbnail, '#', array('onclick' => "selectURL('".$attachment['Node']['slug']."');", 'escape' => false,));
								}
								echo $thumbnail;
								?>
							</td>
							<td>
								<?php echo $this->Html->cText($attachment['Node']['title']);?>
							</td>
							<td>
								<span>
								<?php echo $this->Html->link($this->Html->cText(Router::url($attachment['Node']['path'], true), false), $attachment['Node']['path']); ?>
								</span>
							</td>
						</tr>
						<?php }
						else:
						?>
						<tr>
							<td colspan="5">
							<i class="fa fa-exclamation-triangle"></i>
							<?php echo sprintf(__l('No %s available'), __l('Attachments'));?>
							</td>
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
</div>