<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="projectFollowers index">
	<h3 class="h2 navbar-btn roboto-bold font-size-28">
		<?php echo __l('Followers');?>
	</h3>
	<ul class="list-unstyled cf-backer">
		<?php
		if (!empty($projectFollowers)):
		$i = 0;
		foreach ($projectFollowers as $projectFollower):
		$class = null;
		if ($i++ % 2 == 0) {
		$class = 'altrow';
		}
		?>
		<li class="panel panel-header panel-default col-xs-12 <?php echo $class; ?>">
			<div class="pull-left display-tbl navbar-btn no-float">
				<div class="img-contain-110 img-circle center-block">
					<?php echo $this->Html->getUserAvatar($projectFollower['User'], 'user_thumb');?>
				</div>
			</div>
			<div class="text-left h3 no-float">
				<h3 class="panel-title txt-center-mbl h-center-blk roboto-bold">
					<?php echo $this->Html->link($this->Html->cText($projectFollower['User']['username']), array('controller' => 'users', 'action' => 'view', $projectFollower['User']['username']), array('title' => $projectFollower['User']['username'], 'escape' => false));?>
					<?php
						$time_format = date('Y-m-d\TH:i:sP', strtotime($projectFollower['ProjectFollower']['created']));
					?>					
					<div class="pull-right roboto-regular">
					<i class="fa fa-clock-o fa-fw"></i>
					<span class="h5 list-group-item-text list-group-item-heading js-timestamp" title="<?php echo $time_format;?>">
						<?php echo $this->Html->cDateTimeHighlight($projectFollower['ProjectFollower']['created'], false); ?>
					</span>
					</div>
				</h3>
			</div>
		</li>
		<?php
		endforeach;
		else:
		?>
		<li class="media panel panel-header panel-default col-xs-12">
			<div class="text-center">
				<p><?php echo sprintf(__l('No %s available'), __l('Followers'));?></p>
			</div>
		</li>
		<?php
		endif;
		?>
	</ul>
<?php if (!empty($projectFollowers)) { ?>
<div class="pull-right">
	<?php echo $this->element('paging_links'); ?>
</div>
<?php } ?>
</div>