<div class="main-admn-usr-lst js-response">
	<div class="bg-primary row">
		<div class="clearfix">
			<ul class="list-inline sec-1 navbar-btn">
				<li>
					<div class="well-sm">
						<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) ? 'active-filter' : null; ?>
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($publish, false). '</span><span>' . __l('Publish') . '</span>', array('controller' => 'comments', 'action' => 'index', 'filter_id' => ConstMoreAction::Publish), array('title' => __l('Publish'),'escape' => false)); ?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) ? 'active-filter' : null; ?>
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($unpublish, false). '</span><span>' . __l('Unpublish') . '</span>', array('controller' => 'comments', 'action' => 'index', 'filter_id' => ConstMoreAction::Unpublish), array('title' => __l('Unpublish'),'escape' => false)); ?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php $class = (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['main_filter_id'])) ? 'active-filter' : null; ?>
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($publish + $unpublish, false). '</span><span>' . __l('All') . '</span>', array('controller' => 'comments', 'action' => 'index'), array('title' => __l('Total'),'escape' => false)); ?>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="clearfix">
		<div class="navbar-btn">
			<ul class="list-unstyled clearfix">
				<li class="pull-left"> 
					<p><?php echo $this->element('paging_counter');?></p>
				</li>
			</ul>
		</div>
		<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'update'))); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th><?php echo __l('Select'); ?></th>
						<th><?php echo __l('Actions'); ?></th>
						<th><div><?php echo $this->Paginator->sort('name', __l('Name')); ?></div></th>
						<th><div><?php echo $this->Paginator->sort('email', __l('Email')); ?></div></th>
						<th><div><?php echo $this->Paginator->sort('Node.title', __l('Node')); ?></div></th>
						<th><div><?php echo $this->Paginator->sort('comment', __l('Comment')); ?></div></th>
						<th><div><?php echo $this->Paginator->sort('created', __l('Posted On')); ?></div></th>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					if (!empty($comments)):
					foreach ($comments AS $comment) {
					?>
					<tr>
						<td>
						<?php echo $this->Form->input('Comment.' . $comment['Comment']['id'] . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $comment['Comment']['id'], 'label' => '', 'class' => 'js-checkbox-list')); ?>
						</td>
						<td  class="text-left">
						<?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i><span class="hide">'.__l('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id']), array('title' => __l('Edit')));?>
						<?php echo $this->Html->link('<i class="fa fa-times"></i><span class="hide">'.__l('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?>
						</td>
						<td><?php echo $this->Html->cText($comment['Comment']['name']);?></td>
						<td><?php echo $this->Html->cText($comment['Comment']['email']);?></td>
						<td><?php echo $this->Html->link($comment['Node']['title'], array('admin' => false, 'controller' => 'nodes', 'action' => 'view', 'type' => $comment['Node']['type'], 'slug' => $comment['Node']['slug']));?></td>
						<td><?php echo $this->Html->cText($comment['Comment']['body']);?></td>
						<td><?php echo $this->Html->cDateTimeHighlight($comment['Comment']['created']);?></td>
					</tr>
					<?php
					}
					else:
					?>
					<tr>
						<td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Comments'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($comments)) { ?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 js-select js-no-pjax-action pull-left">
				<ul class="list-inline clearfix">
					<li class="navbar-btn">
						<?php echo __l('Select:'); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select text-info js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
					</li>
					<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
							<div class="hide">
							<?php echo $this->Form->submit('Submit'); ?>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6 pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		<?php } ?>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>