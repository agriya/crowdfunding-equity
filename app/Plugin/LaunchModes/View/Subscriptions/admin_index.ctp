<div class="projectRatings index js-response">
	<section class="main-admn-usr-lst">
		<div class="bg-primary row">
			<ul class="filter-list-block list-inline sec-1 navbar-btn">
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($approved,false).'</span>
					<span>' .__l('Active Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?>
					</div>					
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($pending,false).'</span>
					<span>' .__l('Inactive Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($site_users,false).'</span><span>' .__l('Site Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Site), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center opn-i-usr">'.$this->Html->cInt($openid,false).'</span><span>' .__l('OpenID Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::OpenID), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center fb-usr">'.$this->Html->cInt($facebook,false).'</span><span>' .__l('Facebook Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Facebook), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center twtr-usr">'.$this->Html->cInt($twitter,false).'</span><span>' .__l('Twitter Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Twitter), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center gml-usr">'.$this->Html->cInt($gmail,false).'</span><span>' .__l('Gmail Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Gmail), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center lkdn-usr">'.$this->Html->cInt($linkedin,false).'</span><span>' .__l('LinkedIn Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::LinkedIn), array( 'escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center yho-usr">'.$this->Html->cInt($yahoo,false).'</span><span>' .__l('Yahoo! Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Yahoo), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center gol-usr">'.$this->Html->cInt($affiliate_user_count,false).'</span><span>' .__l('Affiliate Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::AffiliateUser), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center agl-usr">'.$this->Html->cInt($admin_count,false).'</span><span>' .__l('Admin Users'). '</span>', array('controller'=>'users','action'=>'index','main_filter_id' => ConstUserTypes::Admin), array('escape' => false));?>
					</div>
				</li>
				<?php if(isPluginEnabled('LaunchModes')) : ?>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center aff">'.$this->Html->cInt($prelaunch_users,false).'</span><span>' .__l('Pre-launch Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Prelaunch), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center adm-usr">'.$this->Html->cInt($privatebeta_users,false).'</span><span>' .__l('Private Beta Users'). '</span>', array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::PrivateBeta), array('escape' => false));?>
					</div>
				</li>
				<?php endif; ?>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center pr-lnc-usr">'.$this->Html->cInt($total_users_count,false).'</span><span>' .__l('Total Users'). '</span>', array('controller'=>'users','action'=>'index'), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center sub-p-lnc">'.$this->Html->cInt($prelaunch_subscribed,false).'</span><span>' .__l('Subscribed for Pre-launch'). '</span>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false));?>
					</div>
				</li>
				<li>
					<div class="well-sm">
						<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center sub-p-b">'.$this->Html->cInt($privatebeta_subscribed,false).'</span><span>' .__l('Subscribed for Private Beta'). '</span>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false));?>
					</div>
				</li>
			</ul>
		</div>
		<h3>			
			<a href="#"><i class="fa fa-th-list fa-fw"></i><?php echo __l('List'); ?></a>			
			<?php echo $this->Html->link('<span class="badge left-mspace-xs pull-right"><i class="fa fa-plus"></i></span>'.__l('Add'), array('controller' => 'users', 'action' => 'add'),array('class'=>'btn btn-success','title' =>  __l('Add'), 'escape' => false));?>			
		</h3>
	</section>
	<section class="clearfix h3 text-16">
		<div class="add-block pull-left">  
			<div class="pull-left"><?php echo $this->element('paging_counter');?></div>
		</div>
		<div class="pull-right">
			<span class="pull-left">
			<?php echo $this->Html->link('<i class="fa fa-share-square-o fa-fw"></i>'.__l('CSV'), array_merge(array('controller' => 'subscriptions', 'action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('title' => __l('CSV'),'escape'=>false, 'class' => 'btn btn-info js-no-pjax')); ?>
			</span>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
			<?php echo $this->Form->create('Subscription',array('type' => 'get', 'class' => 'form-search pull-left ver-space', 'url' => array_merge(array('controller'=>'subscriptions','action'=>'index', 'admin' => true), $this->request->params['named'])));  ?>
			<?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'form-control search-query mob-clr')); ?>
			<div class="hide">
			<?php echo $this->Form->submit(__l('Search'));?>
			</div>
			<?php echo $this->Form->end(); ?>
			<?php endif; ?>
		</div>
	</section>
	<?php echo $this->Form->create('Subscription' , array('class' => 'clearfix','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<section>
		<table class="table table-striped table-bordered table-condensed table-hover">
		<tr>
			<th class="select text-center"><?php echo __l('Select'); ?></th>
			<th class="text-center table-action-width"><?php echo __l('Actions');?></th>
			<th><div><?php echo $this->Paginator->sort('email', __l('Email'));?></div></th>
			<th class="text-center"><?php echo $this->Paginator->sort('is_sent_private_beta_mail', __l('Invitation Sent')); ?></th>
			<th class="text-center"><?php echo __l('Registered');?></th>
			<th class="text-center"><?php echo __l('From Friends Invite');?></th>
			<th class="text-center"><span class="clearfix"><?php echo __l('Invitation to Friends');?></span><br /><span class="clearfix"><?php echo __l('Registered');?>&nbsp;/&nbsp;<?php echo __l('Invited');?>&nbsp;/&nbsp;<?php echo __l('Allowed invitation');?></span></th>
			<th class="text-center"><?php echo __l('Subscribed On');?></th>
			<th><?php echo $this->Paginator->sort('ip_id', __l('IP')); ?></th>
		</tr>
		<?php
        if (!empty($subscriptions)):
          foreach ($subscriptions as $subscription):
            if(!empty($subscription['User']['id']))  :
              $status_class = 'js-checkbox-active';
              $disabled = '';
            else:
              $status_class = 'js-checkbox-inactive';
              $disabled = 'class="disabled"';
            endif;
      ?>
      <tr <?php echo $disabled; ?>>
      <td class="select text-center">
      <?php echo $this->Form->input('Subscription.'.$subscription['Subscription']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$subscription['Subscription']['id'], 'label' => '', 'class' => $status_class.' js-checkbox-list')); ?>
      </td>
      <td class="text-center">
        <div class="dropdown">
          <a href="#" title="Actions" data-toggle="dropdown" class="fa fa-cog dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
          <ul class="list-unstyled dropdown-menu text-left clearfix">
            <li>
              <?php echo $this->Html->link('<i class="fa fa-times fa-fw"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
            </li>
          <?php if(Configure::read('site.launch_mode') == 'Private Beta' && empty($subscription['Subscription']['is_sent_private_beta_mail']))   { ?>
            <li>
              <?php echo $this->Html->link('<i class="fa fa-envelope fa-fw"></i>'.__l('Send Invitation Code'), Router::url(array('action'=>'send_invitation', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('escape'=>false, 'title' => __l('Send Invitation Code')));?>
            </li>
          <?php }  ?>
          </ul>
          <?php echo $this->Layout->adminRowActions($subscription['Subscription']['id']); ?>
      </td>
      <td><?php echo $this->Html->cText($subscription['Subscription']['email'],false);?></td>
      <td class="text-center"><?php echo $this->Html->cBool($subscription['Subscription']['is_sent_private_beta_mail'],false);?></td>
      <?php if(!empty($subscription['User']['id'])) { ?>
      <td class="col-md-2 text-left">
        <div class="row">
          <div class="col-md-3"><?php echo $this->Html->getUserAvatar($subscription['User'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="col-md-6 vtop"><?php echo $this->Html->getUserLink($subscription['User']); ?></div>
        </div>
      </td>
      <?php } else { ?>
      <td class="text-center"><?php echo $this->Html->cBool(($subscription['User']['id'])?'1':'0',false);?></td>
      <?php } ?>
      <?php if(!empty($subscription['Subscription']['invite_user_id'])) { ?>
      <td class="col-md-2 text-left">
        <div class="row">
          <div class="col-md-3"><?php echo $this->Html->getUserAvatar($subscription['InviteUser'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="col-md-6 vtop"><?php echo $this->Html->getUserLink($subscription['InviteUser']); ?></div>
        </div>
      </td>
      <?php } else { ?>
         <td class="text-center"><?php echo __l('No');?></td>
      <?php } ?>
      <td class="text-center">
      <?php
        $no_of_users_to_invite = Configure::read('site.no_of_users_to_invite');
        $no_of_users_to_invite = (!empty($no_of_users_to_invite))?$no_of_users_to_invite:'-';
        $invite_count = ($subscription['User']['invite_count'] == null)?'0':$subscription['User']['invite_count'];
        echo $this->Html->cText($this->App->getUserInvitedFriendsRegisteredCount($subscription['User']['id']). ' / ' . $invite_count . ' / ' .  $no_of_users_to_invite, false);
      ?>
      </td>
      <td class="text-center"><?php echo $this->Html->cDateTimeHighlight($subscription['Subscription']['created']);?></td>
      <td class="text-left">
        <?php if(!empty($subscription['Ip']['ip'])): ?>
        <?php echo  $this->Html->link($subscription['Ip']['ip'], array('controller' => 'subscriptions', 'action' => 'whois', $subscription['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$subscription['Ip']['ip'], 'escape' => false));
        ?>
        <p>
        <?php
        if(!empty($subscription['Ip']['Country'])):
        ?>
        <span class="flags flag-<?php echo strtolower($subscription['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($subscription['Ip']['Country']['name'], false); ?>">
        <?php echo $this->Html->cText($subscription['Ip']['Country']['name'], false); ?>
        </span>
        <?php
        endif;
        if(!empty($subscription['Ip']['City'])):
        ?>
        <span>   <?php echo $this->Html->cText($subscription['Ip']['City']['name'], false); ?>  </span>
        <?php endif; ?>
        </p>
        <?php else: ?>
        <?php echo __l('n/a'); ?>
        <?php endif; ?>
      </td>
    </tr>
      <?php
      endforeach;
      else:
      ?>
    <tr>
      <td colspan="5" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('Users'));?></td>
    </tr>
      <?php
      endif;
      ?>
  </table>
</section>
<section class="clearfix">
    <?php if (!empty($subscriptions)): ?>
          <div class="admin-select-block pull-left navbar-btn">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'text-info js-select js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'text-info js-select js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
          </div>
          <div class="admin-checkbox-button pull-left ver-space">
            <div class="input select">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit form-control', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
          </div>
          <div class="pull-right">
            <?php echo $this->element('paging_links'); ?>
          </div>
      <div class="hide"><?php echo $this->Form->submit('Submit');  ?></div>
	<?php endif; ?>
	<?php echo $this->Form->end(); ?>
</section>
</div>