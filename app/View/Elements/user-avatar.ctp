<section class="clearfix dashboard-view">
  <div class="media col-sm-12 col-md-5 col-lg-4">
      <div class="pull-left">
        <?php echo $this->Html->getUserAvatar(!empty($logged_in_user['User']) ? $logged_in_user['User'] : '', 'user_thumb'); ?>
      </div>
      <div class="media-body roboto-light">
        <?php if(!empty($logged_in_user['User']['username'])):?>
          <h4 class="roboto-regular"><?php echo $this->Html->link($this->Html->cText($logged_in_user['User']['username']), array('controller' => 'users', 'action' => 'view',  $logged_in_user['User']['username'], 'admin' => false), array('escape' => false, 'title'=>$this->Html->cText($logged_in_user['User']['username'], false))); ?></h4>
        <?php endif;?>
        <?php if(!empty($logged_in_user['User']['created'])):?>
          <p><?php echo __l('Joined:'); ?> <span><strong><?php  echo $this->Html->cDateTimeHighlight($logged_in_user['User']['created']); ?></strong></span></p>
        <?php endif; ?>
		  <?php
    if (empty($this->request->params['named']['user_id'])) { ?>
		<div class="js-response clearfix">
			<?php  echo $this->element('update_email_notification'); ?>
		</div>
  <?php } ?>
        <?php
          $location = array();
          $place = '';
          if (!empty($logged_in_user['UserProfile']['City']['name'])) :
            $location[] = $this->Html->cText($logged_in_user['UserProfile']['City']['name'],false);
          endif;
          if (!empty($logged_in_user['UserProfile']['Country']['name'])):
            $location[] = $this->Html->cText($logged_in_user['UserProfile']['Country']['name'],false);
          endif;
          $place = implode(', ', $location);
        ?>
        <?php if ($place): ?>
          <?php if(!empty($logged_in_user['UserProfile']['Country']['iso_alpha2'])): ?>
            <p>
              <span class="flags flag-<?php echo strtolower($logged_in_user['UserProfile']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($logged_in_user['UserProfile']['Country']['name'], false); ?>"><?php echo $this->Html->cText($logged_in_user['UserProfile']['Country']['name'],false); ?></span>
              <?php echo  ' ' . $place; ?>
            </p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
  </div>
  <div class="col-xs-12 col-md-7 col-lg-8">
	  <section class="user-view-projects row">
		  <?php
			$border_class = ($this->request->params['controller'] == 'messages' || ($this->request->params['controller'] == 'users' && $this->request->params['action'] != 'dashboard'))? ' nav-tabs':'';
		  ?>
		  <ul class="col-xs-12 list-inline clearfix tab-buttons text-center <?php echo $border_class; ?>">
			<?php
			  $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard') ? ' active' : '';
			  $a_class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard') ? '' : '';
			?>
			  <li class="active <?php echo $class;?>"><?php echo $this->Html->link('<span class="show"><i class="fa fa-check-square-o fa-fw"> </i></span>'.__l('Activities'), array('controller' => 'users', 'action' => 'dashboard'), array('class' => $a_class . 'js-tooltip', 'escape' => false, 'title' => __l('Activities'))); ?></li>
			<?php if (isPluginEnabled('Pledge') || isPluginEnabled('Donate') || isPluginEnabled('Lend')|| isPluginEnabled('Equity')): ?>
			  <?php
				$class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'myprojects') ? ' active' : '';
				$a_class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'myprojects') ? '' : '';
			  ?>
			  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<span class="show"><i class="fa fa-credit-card fa-fw"> </i></span>' . __l(Configure::read('project.alt_name_for_project_plural_caps')) . ' ' . __l('Posted') , array('controller' => 'projects', 'action' => 'myprojects'), array('title' => __l(Configure::read('project.alt_name_for_project_plural_caps')) . ' ' . __l('Posted'), 'class' => $a_class . 'js-tooltip', 'escape' => false)); ?></li>
			  <?php
				$class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'myfunds') ? ' active' : '';
				$a_class = ($this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'myfunds') ? '' : '';
			  ?>
			  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<span class="show"><i class="fa fa-usd fa-fw"> </i></span>' . __l(Configure::read('project.alt_name_for_project_plural_caps')) . ' ' . __l('Funded'), array('controller' => 'projects', 'action' => 'myfunds'), array('class' => $a_class . 'js-tooltip', 'escape' => false, 'title' => __l(Configure::read('project.alt_name_for_project_plural_caps')) . ' ' . __l('Funded'))); ?></li>
			<?php endif; ?>
			<?php
			  $class = ($this->request->params['controller'] == 'transactions' && $this->request->params['action'] == 'index') ? ' active' : '';
			  $a_class = ($this->request->params['controller'] == 'transactions' && $this->request->params['action'] == 'index') ? '' : '';
			?>
			<li class="<?php echo $class;?>"><?php echo $this->Html->link('<span class="show"><i class="fa fa-arrows-h"> </i></span>'.__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'), array('class' => $a_class . 'js-tooltip', 'escape' => false, 'title' => __l('Transactions'))); ?></li>
			<?php if (isPluginEnabled('Affiliates')): ?>
			  <?php
				$class = ($this->request->params['controller'] == 'affiliates' && $this->request->params['action'] == 'index') ? ' active' : '';
				$a_class = ($this->request->params['controller'] == 'affiliates' && $this->request->params['action'] == 'index') ? '' : '';
			  ?>
			  <li class="<?php echo $class;?>"><?php echo $this->Html->link('<span class="show"><i class="fa fa-check-circle-o fa-fw"> </i></span>'.__l('Affiliate'), array('controller' => 'affiliates', 'action' => 'index'), array('class' => $a_class . 'js-tooltip', 'escape' => false, 'title' => __l('Affiliate'))); ?></li>
			<?php endif; ?>
		  </ul>
		</section>
  </div>
</section>
<ul class="col-xs-12 list-inline gray-bg users-dashboard-ul text-center">
  <?php if (isPluginEnabled('Wallet')): ?>
	<li>
		<div><strong class="text-info"><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($logged_in_user['User']['available_wallet_amount'],false)); ?></strong></div>
		<div class="show"><?php echo sprintf(__l('Available Balance')); ?></div>
	</li>
  <?php endif; ?>
  <li>
	  <div><strong class="text-success">
		  <?php 
			if($this->request->params['controller'] == 'user' && $this->request->action == 'view') { 
			  echo $this->Html->cInt($project_count, false);  
			} else { 
			  echo $this->Html->cInt($all_project_count, false); 
			} 
		  ?>
	  </strong></div>
	  <div><?php echo sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
  </li>
  <?php if (isPluginEnabled('Idea')): ?>
	<li>
		<div><strong class="text-warning"><?php echo $this->Html->cInt($idea_count, false); ?></strong></div>
		<div><?php echo __l('Ideas Posted'); ?></div>
	</li>
  <?php endif; ?>
	<li>
		<div><strong class="text-warning"><?php echo !empty($logged_in_user['User']['unique_project_fund_count'])? $this->Html->cInt($logged_in_user['User']['unique_project_fund_count'], false):'0'; ?></strong></div>
		<div><?php echo sprintf(__l('%s Funded'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
	</li>
	<li>
		<div><strong class="text-danger"><?php echo !empty($project_following_count) ? $this->Html->cInt($project_following_count, false) : '0'; ?></strong></div>
		<div><?php echo sprintf(__l('Following %s'), Configure::read('project.alt_name_for_project_plural_caps')); ?></div>
	</li>
</ul>

