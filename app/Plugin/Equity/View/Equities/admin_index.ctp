<?php /* SVN: $Id: admin_index.ctp 2897 2010-09-02 11:26:34Z beautlin_108ac10 $ */ ?>
<?php
  //for small pie chart
      $project_percentage = $project_stat = '';
      $all = $total_projects;
      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|'.__l("Pending") : __l("Pending");
      $project_percentage .= round((empty($pending_project_count)) ? 0 : ( ($pending_project_count / $all) * 100 ));

      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|'.__l('Open for Idea') : __l('Open for Idea');
      $project_percentage .= round((empty($open_for_idea)) ? 0 : ( ($open_for_idea / $all) * 100 ));

      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|'.__l('Open for Investing') : __l('Open for Investing');
      $project_percentage .= round((empty($opened_project_count)) ? 0 : ( ($opened_project_count / $all) * 100 ));

      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|' . __l('Canceled') : __l('Canceled');
      $project_percentage .= round((empty($canceled_project_count)) ? 0 : ( ($canceled_project_count / $all) * 100 ));

      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|'.__l("Expired") : __l("Expired");
      $project_percentage .= round((empty($expired_project_count)) ? 0 : ( ($expired_project_count / $all) * 100 ));

      $project_percentage .= ($project_percentage != '') ? ',' : '';
      $project_stat .= (!empty($project_stat)) ? '|'.__l("Closed") : __l("Closed");
      $project_percentage .= round((empty($closed_project_count)) ? 0 : ( ($closed_project_count / $all) * 100 ));
?>
<div class="main-admn-usr-lst js-response">	
	<div class="thumbnail navbar-btn row clearfix no-border">			
		<?php echo $this->element('svg_chart');?>
		<div class="col-md-3 col-sm-4 col-xs-12 col-lg-offset-0 col-sm-offset-4 img-thumbnail marg-top-30 clearfix">
			<h3 class="text-left"><?php echo __l('Project Status'); ?></h3>
			<div class="pull-left">
				<?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$project_percentage.'&amp;chs=120x120&amp;chco=E49F18|78A595|8D92D6|FD66B5|49C8F5|557D36&amp;chf=bg,s,FF000000'); ?>
			</div>
			<div class="pull-left text-info">
			<span class="show offset3"><?php echo sprintf(__l('%s Status'), Configure::read('project.alt_name_for_project_singular_caps')); ?></span>			
			<?php
			$total_pie_chart = $expired_project_count;
			?>			
			<span>
			<?php echo __l('Private Info'); ?> <i title="<?php echo sprintf(__l('This is private info. You can able to set Genuine/Not Genuine for Funding Closed %s'), Configure::read('project.alt_name_for_project_plural_caps')); ?>"  data-placement="left" class="js-tooltip fa fa-question-circle"></i>
			</span>
			<div><?php echo __l('Genuine') . ': '.$successful_projects; ?></div>
			<div><?php echo __l('Not Genuine') . ': '.$failed_projects; ?> <i title="<?php echo __l('Funding closed, but project owner did fraudulent'); ?>"  data-placement="left" class="fa fa-question-circlejs-tooltip"></i></div>
			</div>					
		</div>			
	</div>
	<div class="row bg-primary">		
		<ul class="list-inline sec-1 navbar-btn">
			<?php if (Configure::read('Project.is_project_owner_select_funding_method')) : ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center gol-usr">'.$this->Html->cInt($total_flexible_projects,false).'</span><span>' .__l('Flexible'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Flexible), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center adm-usr">'.$this->Html->cInt($total_fixed_projects,false).'</span><span>' .__l('Fixed'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Fixed), array('escape' => false));?>
				</div>
			</li>
				<?php endif; ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($active_projects,false).'</span><span>' .__l('Active'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($inactive_projects,false).'</span><span>' .__l('Inactive'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($featured_projects,false).'</span><span>' .__l('Featured'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Featured), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center twtr-usr">'.$this->Html->cInt($suspended,false).'</span><span>' .__l('Suspended'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false, 'title' => __l('Suspended')));?>
				</div>
			</li>
				<?php if(isPluginEnabled('ProjectFlags')): ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center lkdn-usr">'.$this->Html->cInt($system_flagged,false).'</span><span>' .__l('System Flagged'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center yho-usr">'.$this->Html->cInt($user_flagged,false).'</span><span>' .__l('User Flagged'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::UserFlagged), array('escape' => false));?>
				</div>
			</li>
			<?php endif; ?>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($system_drafted,false).'</span><span>' .__l('Drafted'). '</span>', array('controller'=>'equities','action'=>'index','filter_id' => ConstMoreAction::Drafted), array('escape' => false));?>
				</div>
			</li>
			<li>
				<div class="well-sm">
					<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($total_projects,false).'</span><span>' .__l('All'). '</span>', array('controller'=>'equities','action'=>'index'), array('class' => 'text-center','escape' => false));?>
				</div>
			</li>
		</ul>		
	</div>
	<div class="clearfix equity">	
		<h3>
			<i class="fa fa-th-list fa-fw"></i> <?php echo __l('List');?>&nbsp;
			<?php echo $this->Html->link('<button type="button" class="btn btn-success">'.__l('Add').' &nbsp;<span class="badge"><i class="fa fa-plus"></i></span></button>', array('controller' => 'projects', 'action' => 'add', 'project_type' => 'equity'),array('title' =>  __l('Add'), 'escape' => false));?>
		</h3>
		<ul class="list-unstyled clearfix">
			<li class="pull-left"> 
				<p class="navbar-btn"><?php echo $this->element('paging_counter');?></p>
			</li>
			<li class="pull-right"> 
				<div class="form-group srch-adon">
				  <?php echo $this->Form->create('Project' ,array('url' => array('controller' => 'equities','action' => 'index')),array('type' => 'get', 'class' => 'form-search','action' => 'index')); ?>
				  <span class="form-control-feedback" id="basic-addon1"><i class="fa fa-search text-default"></i></span>
				  <?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control')); ?>
				  <div class="hide">
				   <?php echo $this->Form->submit(__l('Search'));?>
				  </div>
				  <?php echo $this->Form->end(); ?>
				</div>
			</li>
		</ul>			
		<?php echo $this->Form->create('Project' , array('class' => 'clearfix js-shift-click js-no-pjax','action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>		
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="js-expand-table">
				<thead class="h5">
					<tr class="js-even">       
						<th rowspan="2" class="text-center"><?php echo __l('Select'); ?></th>
						<th rowspan="2" class="text-left"><div><?php echo $this->Paginator->sort('name', __l('Name'));?></div></th>
						<th rowspan="2" class="text-left"><div><?php echo $this->Paginator->sort('User.username', __l('Posted By'));?></div></th>
						<th colspan="2" class="text-center">
						<?php echo __l('Amount') ;?></th>
						<th colspan="2" class="text-center"><?php echo __l('Site Fee') ;?></th>
						<th rowspan="2" class="text-center">
						<div><?php echo sprintf(__l('%s Date'), Configure::read('project.alt_name_for_equity_present_continuous_caps')); ?><div><?php echo $this->Paginator->sort('project_start_date', __l('Start'));?></div>/<div><?php echo $this->Paginator->sort('project_end_date', __l('End'));?></div></div>
						</th>
						<?php if (Configure::read('Project.is_project_owner_select_funding_method')) : ?>
						<th rowspan="2" class="text-center">
						<div><span class="clearfix"><?php echo sprintf(__l('Fixed %s'),Configure::read('project.alt_name_for_equity_present_continuous_caps')); ?></span><i class="fa fa-info-circle js-tooltip" data-placement="top" title="<?php echo sprintf(__l('Fixed %s:  %s fund will be captured only if it reached the needed amount.When %s has been reached the ending date, then funds can start to be released.'), Configure::read('project.alt_name_for_equity_present_continuous_caps'), Configure::read('project.alt_name_for_project_singular_caps'), Configure::read('project.alt_name_for_project_singular_small')); echo "\n";echo sprintf(__l('Flexible %s:  %s fund will be captured even if it does not reached the needed amount.'), Configure::read('project.alt_name_for_equity_present_continuous_caps'),Configure::read('project.alt_name_for_project_singular_caps')); ?>"></i></div>
						</th>
						<?php endif; ?>
						<?php if (isPluginEnabled('Idea')) : ?>
						<th colspan="3" class="text-center"><?php echo __l('Votings') ;?></th>
						<?php endif; ?>
						<?php if (isPluginEnabled('SocialMarketing')) : ?>
						<th colspan="4" class="text-center"><span class="clearfix"><?php echo __l('Analytic Count') ;?></span><i class="fa fa-info-circle js-tooltip" data-placement="left" title="<?php echo __l('Counts showing here were shared the project on Facebook, Twitter, LinkedIn, Google.'); ?>"></i></th>
						<?php endif; ?>
					</tr>
					<tr class="js-even">
						<th class="text-center"><div><?php echo $this->Paginator->sort('needed_amount', __l('Needed')).' ('.Configure::read('site.currency').')';?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('collected_amount', __l('Collected')).' ('.Configure::read('site.currency').')';?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('fee_amount', __l('Listing Fee')).' ('.Configure::read('site.currency').')';?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('commission_amount', __l('Commission')).' ('.Configure::read('site.currency').')';?></div></th>
						<?php if (isPluginEnabled('Idea')) : ?>
						<th class="text-center"><div><?php echo $this->Paginator->sort('total_ratings', __l('Total votings'));?></div></th>
						<th class="text-center"><div><?php echo $this->Paginator->sort('project_rating_count', __l('Voting count'));?></div></th>
						<th class="text-center"><div> <?php echo __l('Average');?> </div></th>
						<?php endif; ?>
						<?php if (isPluginEnabled('SocialMarketing')) : ?>
						<th class="text-center"><div class="js-tooltip"  data-placement="left" title="<?php echo __l('Facebook'); ?>"><?php echo $this->Paginator->sort('facebook_share_count', __l('F'));?></div></th>
						<th class="text-center"><div class="js-tooltip"  data-placement="left" title="<?php echo __l('Twitter'); ?>"><?php echo $this->Paginator->sort('twitter_share_count', __l('T'));?></div></th>
						<th class="text-center"><div class="js-tooltip"  data-placement="left" title="<?php echo __l('Google'); ?>"><?php echo $this->Paginator->sort('gmail_share_count', __l('G'));?></div></th>
						<th class="text-center linkedin"><div class="js-tooltip"  data-placement="left" title="<?php echo __l('LinkedIn'); ?>"><?php echo $this->Paginator->sort('linkedin_share_count', __l('L'));?></div></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody class="h5">
					<?php
					$i = 0;
					if (!empty($projects)):
					foreach ($projects as $project):
					$class = null;
					$altrow_class = '';
					if ($i % 2 == 0):
					$altrow_class = ' altrow';
					endif;
					$class = 'js-odd js-no-pjax';
					$disabled = '';
					if ($project['Project']['is_active']):
					$status_class = 'js-checkbox-active';
					$class = 'js-odd js-no-pjax';
					else:
					$status_class = 'js-checkbox-inactive';
					$disabled = ' disabled';
					endif;
					if($project['Project']['is_admin_suspended']):
					$status_class.= ' js-checkbox-suspended';
					else:
					$status_class.= ' js-checkbox-unsuspended';
					endif;
					if($project['Project']['is_system_flagged']):
					$status_class.= ' js-checkbox-flagged';
					else:
					$status_class.= ' js-checkbox-unflagged';
					endif;
					if($project['Project']['is_user_flagged']):
					$status_class.= ' js-checkbox-flagged';
					else:
					$status_class.= ' js-checkbox-unflagged';
					endif;
					?>
					<tr class="<?php echo $class .$disabled. $altrow_class;?> cur">
						<td class="select text-center">
						<i class="fa fa-caret-down"></i>						
						<?php echo $this->Form->input('Project.'.$project['Project']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$project['Project']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
						</td>
						<td class="text-left">
						<div class="clearfix htruncate" title="<?php echo $this->Html->cText($project['Project']['name'], false);?>">						
						<i title="<?php echo !empty($project['Equity']['EquityProjectStatus'])?$this->Html->cText($project['Equity']['EquityProjectStatus']['name'], false):'Drafted';?>" class="fa fa-square project-status-<?php echo $this->Html->cInt($project['Equity']['equity_project_status_id'], false);?>"></i>
						<?php echo $this->Html->cText($project['Project']['name'], false);?>						
						<?php
						if ($project['Project']['payment_method_id'] == ConstPaymentMethod::KiA && Configure::read('Project.is_project_owner_select_funding_method')):
						echo '<div class="clearfix"><span class="label label-success pro-status-11">'.__l('Flexible').'</span></div>';
						endif;
						if(!empty($project['Project']['is_featured'])):
						echo '<div class="clearfix"><span class="label label-info pro-status-7">'.__l('Featured').'</span></div>';
						endif;
						if(!empty($project['Project']['is_admin_suspended'])):
						echo '<div class="clearfix"><span class="label label-danger pro-status-6">'.__l('Suspended').'</span></div>';
						endif;
						if($project['Project']['is_system_flagged']):
						echo '<div class="clearfix"><span class="label label-warning">'.__l('System Flagged').'</span></div>';
						endif;
						if(!empty($project['Project']['is_user_flagged'])) :
						echo '<div class="clearfix"><span class="label label-primary">'.__l('User Flagged').'</span></div>';
						endif;
						?>
						</div>
						</td>
						<td class="text-left">
							<div class="media">
								<div class="pull-left">
									<?php echo $this->Html->getUserAvatar($project['User'], 'micro_thumb',true, '', 'admin');?>
								</div>
								<div class="media-body">
									<p>
										<?php echo $this->Html->cText($project['User']['username']); ?>
									</p>
								</div>
							</div>
						</td>
						<td class="text-center"><?php echo $this->Html->cCurrency($project['Project']['needed_amount']);?></td>
						<td class="text-center equity">
						<?php $collected_percentage = ($project['Project']['collected_percentage']) ? $project['Project']['collected_percentage'] : 0; ?>
						<div class="progress">
						<div style="width:<?php echo ($collected_percentage > 100) ? '100%' : $collected_percentage.'%'; ?>;" title = "<?php echo $this->Html->cFloat($collected_percentage, false).'%'; ?>" class="progress-bar progress-bar-primary"></div>
						</div>
						<p class="text-left"><?php echo $this->Html->cCurrency($project['Project']['collected_amount']); ?> / <?php echo $this->Html->cCurrency($project['Project']['needed_amount']); ?></p>
						</td>
						<td class="text-center equity"><span class="label label-primary"><?php echo $this->Html->cCurrency($project['Project']['fee_amount']);?></span></td>
						<td class="text-right equity"><span class="label label-primary"><?php echo $this->Html->cCurrency($project['Project']['commission_amount']);?></span></td>
						<td class="text-center equity">
						<?php
						if(empty($project['Project']['project_start_date']) || $project['Project']['project_start_date'] == '0000-00-00')   {
						echo '-';
						}  else { ?>
						<div class="clearfix">						
						<?php
						$project_progress_precentage = 0;
						if(strtotime($project['Project']['project_start_date']) < strtotime(date('Y-m-d H:i:s'))) {
						if($project['Project']['project_end_date'] !==   NULL) {
						$days_till_now = (strtotime(date("Y-m-d")) - strtotime(date($project['Project']['project_start_date']))) / (60 * 60 * 24);
						$total_days = (strtotime(date($project['Project']['project_end_date'])) - strtotime(date($project['Project']['project_start_date']))) / (60 * 60 * 24);
						if($total_days)
						{
						$project_progress_precentage = round((($days_till_now/$total_days) * 100));
						}
						else{
						$project_progress_precentage = round((($days_till_now) * 100));
						}

						if($project_progress_precentage > 100)
						{
						$project_progress_precentage = 100;
						}
						} else {
						$project_progress_precentage = 100;
						}
						}
						?>
						<?php if($project['Project']['project_end_date']): ?>
						<div class="progress">
						<div style="width:<?php echo ($project_progress_precentage > 100) ? '100%' : $project_progress_precentage.'%'; ?>;" title = "<?php echo $this->Html->cFloat($project_progress_precentage, false).'%'; ?>" class="progress-bar progress-bar-primary"></div>
						</div>
						<?php endif; ?>
						<p class="clearfix"><span><?php echo $this->Html->cDateTimeHighlight($project['Project']['project_start_date']);?></span>&nbsp;/&nbsp;<span><?php echo (!is_null($project['Project']['project_end_date']))? $this->Html->cDateTimeHighlight($project['Project']['project_end_date']): ' - ';?></span></p>			
						</div>
						<?php } ?>
						</td>
						<?php if (Configure::read('Project.is_project_owner_select_funding_method')) : ?>
						<td class="text-center"><?php if($project['Project']['payment_method_id']==ConstPaymentMethod::AoN){ echo 'Yes'; } else { echo 'No'; }?></td>
						<?php endif; ?>
						<?php if (isPluginEnabled('Idea')) : ?>
						<td class="text-center"><?php echo $this->Html->cFloat($project['Project']['total_ratings']);?></td>
						<td class="text-center"><?php echo $this->Html->link($this->Html->cInt($project['Project']['project_rating_count']), array('controller'=> 'project_ratings', 'action'=>'index', 'project_id'=> $project['Project']['id']), array('escape' => false)); ?></td>
						<td class="text-center"><?php $rating = $project['Project']['project_rating_count'] ? $project['Project']['total_ratings'] / $project['Project']['project_rating_count'] : $project['Project']['project_rating_count'];echo $this->Html->cFloat($rating);?></td>
						<?php endif; ?>
						<?php if (isPluginEnabled('SocialMarketing')) : ?>
						<td class="text-center"><?php echo $this->Html->cInt($project['Project']['facebook_share_count']);?></td>
						<td class="text-center"><?php echo $this->Html->cInt($project['Project']['twitter_share_count']);?></td>
						<td class="text-center"><?php echo $this->Html->cInt($project['Project']['gmail_share_count']);?></td>
						<td class="text-center"><?php echo $this->Html->cInt($project['Project']['linkedin_share_count']);?></td>
						<?php endif; ?>
					</tr>
					<!-- hide-->
					<tr class="hide table-bordered">
						<td class="text-left" colspan="16">
							<div class="clearfix row">
								<div class="col-xs-2">
									<h4 class="roboto-bold text-info"><?php echo __l('Action'); ?> </h4>
									<ul class="list-unstyled clearfix line-height-25">
										<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea):?>
										<li><?php echo $this->Html->link('<i class="fa fa-hdd-o fa-fw"></i>'.sprintf(__l('Change status to %s'),Configure::read('project.alt_name_for_equity_singular_small')), array('controller'=>'projects','action'=>'admin_open_funding', $project['Project']['id'], 'type' => 'open'), array('class' => 'js-confirm',  'escape'=>false,'title' =>sprintf( __l('Change status to %s'),Configure::read('project.alt_name_for_equity_singular_small'))));?></li>
										<?php endif; ?>
										<li><?php echo $this->Html->link('<i class="fa fa-pencil-square-o fa-fw"></i>'.__l('Edit'), array('controller'=>'projects','action' => 'edit', $project['Project']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?></li>
										<?php
										$label_approve = __l("Approve");
										if(empty($project['Project']['is_pending_action_to_admin'])):
										$label_approve = __l("View Details");
										endif;
										?>
										<li>
										<?php
										$redirect_url = Router::url(array(
										'controller' => 'projects',
										'action' => 'pending_approval_steps',
										$project['Project']['id']
										), true);
										?>
										<div>
										<a class="js-approve-link js-no-pjax" data-href="dropdown-<?php echo $i; ?>" data-target="#js-ajax" data-toggle="modal" title="<?php echo $this->Html->cText($label_approve, false);?>" href="<?php echo $redirect_url; ?>"><i class="fa fa-cog fa-fw"></i><?php echo $this->Html->cText($label_approve); ?></a>
										<div class="dropdown-menu js-pending-list clearfix js-approve" id="dropdown-<?php echo $this->Html->cInt($i, false); ?>">
										<div class="text-center"><?php echo $this->Html->image('ajax-follow-loader.gif', array('class'=>'js-loader')); ?></div></div></div>
										</li>
										<?php if(isPluginEnabled('Insights')):?>
										<li><?php echo $this->Html->link('<i class="fa fa-tasks fa-fw"></i>'.__l('Stats'), array('controller'=>'insights','action' => 'project_detailed_stats', $project['Project']['id']), array('class' => '','escape'=>false, 'title' => __l('Stats')));?></li>
										<?php endif;?>                    
										<li><?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('controller'=>'projects','action' => 'delete', $project['Project']['id']),true).'?redirect_to='.$this->request->url,array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?></li>
										<?php if($project['Project']['is_system_flagged']):?>
										<li><?php echo $this->Html->link('<i class="fa fa-times-circle-o fa-fw"></i>'.__l('Clear System Flag'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'unflag', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Clear System Flag')));?></li>
										<?php else: ?>
										<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::ProjectCanceled || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea):?>
										<li><?php echo $this->Html->link('<i class="fa fa-flag fa-fw"></i>'.__l('System Flag'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'flag', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('System Flag')));?></li>
										<?php endif; ?>
										<?php endif;?>
										<?php if($project['Project']['is_user_flagged'] && isPluginEnabled('ProjectFlags')):?>
										<li><?php echo $this->Html->link('<i class="fa fa-times-circle-o"></i>'.__l('Clear User Flag'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'userflag-deactivate', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Clear User Flag')));?></li>
										<?php endif;?>
										<?php if($project['Project']['is_admin_suspended']):?>
										<li> <?php echo $this->Html->link('<i class="fa fa-repeat fa-fw"></i>'.__l('Unsuspend'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'unsuspend', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Unsuspend')));?></li>
										<?php else: ?>
										<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::ProjectCanceled || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea):?>
										<li> <?php  echo $this->Html->link('<i class="fa fa-power-off fa-fw"></i>'.__l('Suspend'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'suspend', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Suspend')));?></li>
										<?php endif;?>
										<?php endif; ?>
										<?php if($project['Project']['is_featured']):?>
										<li><?php echo $this->Html->link('<i class="fa fa-crosshairs fa-fw"></i>'.__l('Not Featured'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'notfeatured', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Not Featured')));?></li>
										<?php else: ?>
										<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::ProjectCanceled || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForIdea):?>
										<li><?php echo $this->Html->link('<i class="fa fa-map-marker fa-fw"></i>'.__l('Featured'), array('controller'=>'projects','action' => 'admin_update_status', $project['Project']['id'], 'status' => 'featured', 'project_type' => $project['ProjectType']['slug']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Featured')));?></li>
										<?php endif;?>
										<?php endif; ?>
										<?php if($project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::OpenForInvesting || $project['Equity']['equity_project_status_id'] == ConstEquityProjectStatus::Pending):?>
										<li><?php echo $this->Html->link('<i class="fa fa-times-circle fa-fw"></i>'.__l('Cancel'), array('controller'=>'projects','action'=>'admin_cancel', $project['Project']['id']), array('class' => 'js-confirm','escape'=>false, 'title' => __l('Cancel')));?></li>
										<?php endif; ?>
									</ul>
								</div>
								<div class="col-xs-3">
									<h4 class="roboto-bold text-info"><?php echo __l('Stats'); ?></h4>
									<dl class="clearfix project-action">
										<dt class="col-xs-7"><?php echo sprintf(__l('%s Updates'), Configure::read('project.alt_name_for_project_singular_caps')); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['blog_count']), array('controller'=> 'blogs', 'action'=>'index', 'project_id'=> $project['Project']['id']), array('escape' => false)); ?></dd>
										<?php if(isPluginEnabled('ProjectFlags')): ?>
										<dt class="col-xs-7"><?php echo sprintf(__l('%s Flags'), Configure::read('project.alt_name_for_project_singular_caps')); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['project_flag_count']), array('controller'=> 'project_flags', 'action'=>'index', 'project_id'=> $project['Project']['id']), array('escape' => false)); ?></dd>
										<?php endif; ?>
										<dt class="col-xs-7"><?php echo __l('Normal view count'); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['project_view_count']), array('controller'=> 'project_views', 'action'=>'index', 'project_id'=> $project['Project']['id'],'type'=>'normal'), array('escape' => false)); ?></dd>
										<dt class="col-xs-7"><?php echo __l('Embed view count'); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['embed_view_count']), array('controller'=> 'project_views', 'action'=>'index', 'project_id'=> $project['Project']['id'],'type'=>'embed'), array('escape' => false)); ?></dd>
										<dt class="text-left col-xs-7 no-pad"><?php echo Configure::read('project.alt_name_for_investor_plural_caps'); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['project_fund_count']), array('controller' => Inflector::Pluralize($project['ProjectType']['slug']), 'action' => 'funds', 'project_id' => $project['Project']['id'], 'admin' => true), array('escape' => false)); ?></dd>
										<?php  if(isPluginEnabled('ProjectFollowers')): ?>
										<dt class="col-xs-7"><?php echo __l('Followers'); ?></dt>
										<dd class="col-xs-3"><?php echo $this->Html->link($this->Html->cInt($project['Project']['project_follower_count']), array('controller'=> 'project_followers', 'action'=>'index', 'project_id'=> $project['Project']['id']), array('escape' => false)); ?></dd>
										<?php endif; ?>
									</dl>
								</div>
								<div class="col-xs-3">
									<h4 class="roboto-bold text-info"> <?php echo __l('Image'); ?> </h4>
									<?php echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false)),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false)); ?>
									<div>
										<?php if(!empty($project['Ip']['ip'])): ?>
										<?php echo  $this->Html->link($project['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $project['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$this->Html->cText($project['Ip']['ip'],false), 'escape' => false)); ?>
										<p>
										<?php if(!empty($project['Ip']['Country'])): ?>
										<span class="flags flag-<?php echo strtolower($project['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($project['Ip']['Country']['name'], false); ?>"><?php echo $this->Html->cText($project['Ip']['Country']['name']); ?></span>
										<?php endif; ?>
										<?php if(!empty($project['Ip']['City'])): ?>
										<span><?php echo $this->Html->cText($project['Ip']['City']['name']); ?></span>
										<?php endif; ?>
										</p>
										<?php else: ?>
										<?php echo __l('n/a'); ?>
										<?php endif; ?>
									</div>									
								</div>
								<div class="col-xs-4 top-space top-mspace">
									<dl class="clearfix top-space top-mspace h4">
										<?php if (!empty($project['Equity']['project_fund_goal_reached_date'])) : ?>
										<dt class="text-left col-xs-7 no-pad text-warning"><?php echo __l('Funding GoalReached Date'); ?></dt>
										<dd class="col-xs-4"><?php echo $this->Html->cDateTimeHighlight($project['Equity']['project_fund_goal_reached_date']); ?></dd>
										<?php endif; ?>
										<dt class="text-left col-xs-7 no-pad text-warning"><?php echo __l('Posted On'); ?></dt>
										<dd class="col-xs-4"><?php echo $this->Html->cDateTimeHighlight($project['Project']['created']); ?></dd>
										<dt class="text-left col-xs-7 no-pad text-warning"><?php echo __l('Listing Fee Paid'); ?></dt>
										<dd class="col-xs-4"><?php echo $this->Html->cBool($project['Project']['is_paid']); ?></dd>
									</dl>
								</div>	
							</div>
						</td>
					</tr>
					<?php
					$i++;
					endforeach;
					else:
					?>
					<tr class="js-even">
						<td colspan="22" class="text-center"><i class="fa fa-exclamation-triangle"></i><?php echo sprintf(__l('No %s available'), Configure::read('project.alt_name_for_equity_singular_caps') . ' ' . Configure::read('project.alt_name_for_project_plural_caps'));?></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
		</div>
		<div class="page-sec navbar-btn">
		<?php if (!empty($projects)) {?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 pull-left">
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
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Active'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Inactive'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"}', 'title' => __l('Suspended'))); ?>
					</li>
					<li class="navbar-btn">
						<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select text-info js-no-pjax {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"}', 'title' => __l('Flagged'))); ?>
					</li>
					<li>
						<div class="admin-checkbox-button">
							<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
							<div class="hide">
							  <?php echo $this->Form->submit('Submit');  ?>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6 pull-right clearfix">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		<?php
		}
		echo $this->Form->end();
		?>
	</div>	
	</div>
</div>
<div class="modal fade" id="js-ajax">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header"></div>
		  <div class="modal-body"></div>
		  <div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
		</div>
	</div>
  </div>
<span id="tooltip_text" class="invisible"></span>
