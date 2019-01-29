<?php
  $status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
  'status_id' => $projectStatus[$project['Project']['id']]['id'],
  'project_type_id' => $project['Project']['project_type_id']
	));
  $reason =  $status_response->data['response'];?> 
<?php  if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  {?>
<div class="col-xs-12 equity">
	<?php
	if ($project['Project']['user_id'] != $this->Auth->user('id') || Configure::read('Project.is_allow_owner_fund_own_project')) { 
		$fund_class = 'alf-'.$this->Html->cInt($project['Project']['id'], false);
		if(Configure::read('Project.is_allow_owner_fund_own_project') && $project['Project']['user_id'] == $this->Auth->user('id')){
			$fund_class = 'alof-'.$this->Html->cInt($project['Project']['id'], false);
		}
	?>
	<div class='<?php echo $fund_class;?> hide'> <?php //after login project fund?>
		<a href="<?php echo Router::url(array('controller' => 'project_funds', 'action' => 'add', $project['Project']['id']), true); ?>" class="btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?>"><?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?></a>
	</div>
	<?php } else { ?>
		<div class='alof-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'>  <?php //after login project owner fund?>
			<span class="disabled btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: You can\'t %s your own %s.'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span>
		</div>
	<?php } ?>
	<div class='blf-<?php echo $this->Html->cInt($project['Project']['id'], false);?> hide'> <?php //before login project fund?>
		<a href="<?php echo Router::url(array('controller' => 'project_funds', 'action' => 'add', $project['Project']['id']), true); ?>" class="btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?>"><?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?></a>
	</div>
	<div class='ablfc-<?php echo $this->Html->cInt($project['Project']['id'], false); ?> hide'> <?php //after or before login project fund closed?>
	<span class="disabled btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: %s.'),  $reason); ?>"><?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps'));?></span>
	</div>

</div>
<?php } else { ?>
<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting): ?>
<div class="col-xs-12 equity">
<?php if($this->Auth->user('id') != $project['Project']['user_id']):?>
<a href="<?php echo Router::url(array('controller' => 'project_funds', 'action' => 'add', $project['Project']['id']), true); ?>" class="btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?>"><?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps')); ?></a>
<?php else : ?>
  <span class="disabled btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: You can\'t %s your own %s.'), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small')); ?>"><?php echo Configure::read('project.alt_name_for_equity_singular_caps');?></span>
<?php endif; ?>
</div>
<?php else :
  $status_response = Cms::dispatchEvent('View.Project.projectStatusValue', $this, array(
  'status_id' => $projectStatus[$project['Project']['id']]['id'],
  'project_type_id' => $project['Project']['project_type_id']
	));
  $reason =  $status_response->data['response'];
?>
<div class="col-xs-12 equity"><span class="disabled btn btn-info btn-lg text-uppercase navbar-btn fa-inverse js-tooltip" title="<?php echo sprintf(__l('Disabled. Reason: %s.'),  $reason); ?>"><?php echo sprintf(__l('%s'), Configure::read('project.alt_name_for_equity_singular_caps'));?></span></div>
<?php endif; ?>
<?php }?>