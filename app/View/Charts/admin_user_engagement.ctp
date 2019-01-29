<div class="js-response">
	<h3 class="lead"><?php echo __l('Users Engagement'); ?></h3>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="well well-sm">
				<div class="text-center">	
					<div class="progress-one position" data-color="#ccc,#37a1f2" data-percent="<?php echo $this->Html->cFloat(($idle_users/$total_users) * 100, false); ?>" data-size="40" data-duration="1000">
					</div>
					<div class="h3">
						<p class="lead navbar-btn text-capitalize"><strong><?php echo __l('Idle'); ?></strong></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="well well-sm">
				<div class="text-center">	
					<div class="progress-one position" data-color="#ccc,#83d662" data-percent="<?php echo $this->Html->cFloat(($funded_users/$total_users) * 100, false); ?>" data-size="40" data-duration="1000">
					</div>
					<!--<span class="percent"><?php //echo $this->Html->cInt($funded_users, false); ?></span>-->
					<div class="h3">
					<p class="lead navbar-btn text-capitalize"><strong><?php echo __l('Funded '); ?></strong></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="well well-sm">
				<div class="text-center">	
					<div class="progress-one position" data-color="#ccc,#faac06" data-percent="<?php echo $this->Html->cFloat(($posted_users/$total_users) * 100, false); ?>" data-size="40" data-duration="1000">
					</div>
					<!--<span class="percent"><?php //echo $this->Html->cInt($posted_users, false); ?></span>-->
					<div class="h3">	
						<p class="lead navbar-btn text-capitalize"><strong><?php echo __l('Posted '); ?></strong></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="well well-sm">
				<div class="text-center">	
					<div class="progress-one position" data-color="#ccc,#fe7000" data-percent="<?php echo $this->Html->cFloat(($engaged_users/$total_users) * 100, false); ?>" data-size="40" data-duration="1000">
					</div>
					<!--<span class="percent"><?php //echo $this->Html->cInt($engaged_users, false); ?></span>-->
					<div class="h3">	
						<p class="lead navbar-btn text-capitalize"><strong><?php echo __l('Engaged '); ?></strong></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
