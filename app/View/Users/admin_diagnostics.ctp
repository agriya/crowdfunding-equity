<div>
	<div class="alert alert-info">
		<?php echo __l('Diagnostics are for developer purpose only.'); ?>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="well">
				<h3 class="list-group-item-heading text-b"><?php echo $this->Html->link(__l('ZazPay Transaction Log'), array('controller' => 'sudopay_transaction_logs', 'action' => 'index'),array('class'=>'text-danger','title' => __l('ZazPay Transaction Log'))); ?></h3>
				<?php echo __l('View the transaction logs done via ZazPay'); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="well">
				<h3 class="list-group-item-heading text-b"><?php echo $this->Html->link(__l('ZazPay IPN Log'), array('controller' => 'sudopay_ipn_logs', 'action' => 'index'),array('class'=>'text-danger','title' => __l('ZazPay IPN Log'))); ?></h3>
				<?php echo __l('View the ipn logs done via ZazPay'); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="well">
				<h3 class="list-group-item-heading text-b"><?php echo $this->Html->link(__l('Debug & Error Log'), array('controller' => 'devs', 'action' => 'logs'),array('class'=>'text-danger','title' => __l('Debug & Error Log'))); ?></h3>
				<?php echo __l('View debug, error log, used cache memory and used log memory'); ?> 
			</div>
		</div>
	</div>  
</div>
