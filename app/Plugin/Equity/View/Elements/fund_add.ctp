<?php
if(!empty($response_data['equity'])){
	$equity = $response_data['equity'];
	$class = '';
	if (strlen($project['Project']['name']) > 40) {
		$class .= ' title-double-line';
	}
}
$strAdditionalInfo = '';
?>

<section data-offset-top="10" data-spy="" class=" row <?php echo $class; ?>">
	<div class="row">
		<div class="payment-img col-sm-1"> <?php echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false), 'class' => 'js-tooltip'),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false)); ?> </div>
		<div class="col-md-7 pull-left">
			<h3><?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), array('escape' => false));?></h3>
			<p> <?php echo __l('A') . ' '; ?>
				<?php
					$response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
					'data' => $project
					));
					if (!empty($response->data['content'])) {
					echo $this->Html->cHtml($response->data['content']);
					}
					?>
					<?php echo sprintf(__l('%s in '), Configure::read('project.alt_name_for_project_singular_small')) . ' '; ?>
					<?php
					if (!empty($project['City']['name'])) {
					echo $this->Html->cText($project['City']['name'], false) . ', ';
					}
					if (!empty($project['Country']['name'])) {
					echo $this->Html->cText($project['Country']['name']);
					}
				?>
				<?php echo __l(' by '); ?><?php echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users', 'action' => 'view', $project['User']['username']), array('escape' => false));?>
			</p>
		</div>
	</div>
</section>
<div class="projectFunds form clearfix row">  
	<div class="alert alert-info">
	<?php
		if($project['Project']['payment_method_id'] == ConstPaymentMethod::AoN) {
		if ($project['Project']['collected_amount'] < $project['Project']['needed_amount']):
		  echo sprintf(__l("We will capture the %s amount. If the %s didn't reached the goal, we will refund this amount to your wallet."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
		else:
		  echo sprintf(__l("We will capture the %s amount. If the %s didn't reached the goal, we will refund this amount to your wallet."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
		endif;
		} elseif($project['Project']['payment_method_id'] == ConstPaymentMethod::KiA) {
		echo sprintf(__l("We will capture the %s amount. If the %s didn't reached the goal, we will refund this amount to your wallet."), Configure::read('project.alt_name_for_equity_singular_small'), Configure::read('project.alt_name_for_project_singular_small'));
		}
	?>
	</div>
	<div class="alert alert-info">
		<?php
			$userShareDetail = $this->Html->getUserShareDetails($equity['Equity']['project_id']);
			$project_remaining_shares = $equity['Equity']['total_shares'] - $equity['Equity']['shares_allocated'];
			$user_remaining_shares = 0;
			if($project_remaining_shares >= $userShareDetail['remaining_shares']) {
				$user_remaining_shares = $userShareDetail['remaining_shares'];
			}
			if($project_remaining_shares < $userShareDetail['remaining_shares']) {
							$remaining= $userShareDetail['remaining_shares'] - $project_remaining_shares;
							$user_remaining_shares = $userShareDetail['remaining_shares'] - $remaining;
			}
			echo sprintf(__l('Amount per share: %s%s, You can purchase %s more shares for this %s.'), Configure::read('site.currency'), Configure::read('equity.amount_per_share'), $user_remaining_shares, Configure::read('project.alt_name_for_project_singular_small'));
		?>
	</div> 
	<div class="clearfix">
		<div class="col-md-12">
			<div class="clearfix">
				<fieldset>
					<legend><?php echo sprintf(__l('%s Amount'),Configure::read('project.alt_name_for_equity_singular_caps')); ?></legend>
					<div>
						<?php
							echo $this->Form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
							echo $this->Form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
							echo $this->Form->input('project_id',array('type'=>'hidden'));
							echo $this->Form->input('amount',array('label' => sprintf(__l('%s amount'),Configure::read('project.alt_name_for_equity_singular_caps')) .' ('.Configure::read('site.currency').')', 'info' => sprintf(__l('Amount should be multiples of %s. For example: %s, %s etc.,'), Configure::read('project.alt_name_for_equity_singular_caps'), Configure::read('equity.amount_per_share'),  Configure::read('equity.amount_per_share') * 2 )));
						?>
					</div>
				</fieldset>
				<div class="clearfix">					
					<fieldset>
						<legend><?php echo sprintf(__l('Personalize your  %s'),Configure::read('project.alt_name_for_equity_singular_caps')); ?></legend>
						<div class="group-block personal-radio"> <?php echo $this->Form->input('is_anonymous',array('type' =>'radio','options'=>$radio_options,'default'=>ConstAnonymous::None,'legend'=>false));?> </div>
					</fieldset>					  
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="clearfix">
				<div class="well">
					<h3 class="clearfix"><?php echo __l('JOBS Act Implications'); ?></h3>
					<div class=" clearfix">
						<p><?php echo __l('1. Individuals with a net worth (excluding primary residence) or annual income less than $100,000 can equity up to $2,000 or 5% of their annual income or net worth (whichever is greater).'); ?></p>
						<p><?php echo __l('2. Individuals with an annual income or net worth of more than $100,000 can equity up to 10% of their annual income or net worth, up to a maximum of $100,000. '); ?></p>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<?php echo $this->element('equity-faq', array('cache' => array('config' => 'sec')),array('plugin' => 'Equity')); ?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix">
    <legend><?php echo __l('Select Payment Type'); ?></legend>
    <?php
    echo $this->element('payment-get_gateways', array('model'=>'ProjectFund','type'=>'is_enable_for_equity','is_enable_wallet'=>1,'project_type'=>$project['ProjectType']['name'], 'cache' => array('config' => 'sec')));?>    
</div>