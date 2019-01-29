<div class="col-md-12 offset2">
<div class="row">
	  <?php if ($transaction_percentage > 0) {
              $transaction_color = '#459D1C';
            } elseif ($transaction_percentage == 0) {
              $transaction_color = '#757575';
            } elseif ($transaction_percentage < 0) {
              $transaction_color = '#BA1E20';
            }
            if ($transactionRevenue_percentage > 0) {
              $transactionRevenue_color = '#459D1C';
            } elseif ($transactionRevenue_percentage == 0) {
              $transactionRevenue_color = '#757575';
            } elseif ($transactionRevenue_percentage < 0) {
              $transactionRevenue_color = '#BA1E20';
            }
		?>
			 <div class="col-md-4 text-center">
                <div class="btn text-center show col-md-4">
                  <div class="hide invisible"><div class="js-line-chart {'colour':'<?php echo $transaction_color; ?>'}"><?php echo $transaction; ?></div></div>
                  <div style="color:<?php echo $transaction_color; ?>"><strong><?php echo $transaction_percentage . '%'; ?></strong></div>
                </div>
                <div class="text-center show col-md-8">
                  <h2><?php echo $total_transaction; ?></h2>
                  <h5><?php echo __l('Transactions'); ?></h5>
                </div>
              </div>
              <div class="col-md-4 text-center">
                <div class="btn text-center show col-md-4">
                  <div class="hide invisible"><div class="js-line-chart {'colour':'<?php echo $transactionRevenue_color; ?>'}"><?php echo $transactionRevenue; ?></div></div>
                  <div style="color:<?php echo $transactionRevenue_color; ?>"><strong><?php echo $transactionRevenue_percentage . '%'; ?></strong></div>
                </div>
                <div class="text-center show col-md-8">
                  <h2><?php echo $total_transactionRevenue .' ('.Configure::read('site.currency').')'; ?></h2>
                  <h5><?php echo __l('Transaction Revenue'); ?></h5>
                </div>
              </div>
			   <span class="alert alert-info col-md-4 text-left"> <?php echo __l('Transactions is the total number of completed purchases on your site. The total revenue from ecommerce transactions. Depending on your implementation, this can include tax and shipping.');?></span>
        </div>
		</div>