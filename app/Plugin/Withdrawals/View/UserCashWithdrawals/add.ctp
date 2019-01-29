<?php /* SVN: $Id: add.ctp 71289 2011-11-14 12:28:02Z anandam_023ac09 $ */ ?>
<div class="userCashWithdrawals form js-ajax-form-container js-responses">
  <div class="main-section">
    <div class="alert alert-info">
      <?php echo __l('The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your payment account.'); ?>
    </div>
    <?php echo $this->Form->create('UserCashWithdrawal', array('action' => 'add','class' => "form-horizontal well normal js-ajax-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}")); ?>
      <div class="clearfix affiliatecashwithdrawal-block">
        <div class="grid_left">
          <?php
            if(Configure::read('site.currency_symbol_place') == 'left'):
              $currecncy_place = 'between';
              $class ='input-group';
            else:
              $currecncy_place = 'after';
              $class ='input-group';
            endif;
            $min = Configure::read('site.currency').Configure::read('user.minimum_withdraw_amount');
            $max = Configure::read('site.currency').Configure::read('user.maximum_withdraw_amount');
          ?>
          <div class = "input text required <?php echo $class;?>">
            <?php echo $this->Form->input('amount',array($currecncy_place => '<span class="currency input-group-addon">'.Configure::read('site.currency').'</span>','div' => false));?>
          </div>
          <span class="info"><i class="fa fa-info-circle"></i> <?php echo sprintf(__l('Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s'),$min, $max); ?></span>
          <?php
            echo $this->Form->input('user_id',array('type' => 'hidden'));
            echo $this->Form->input('role_id',array('type' => 'hidden','value'=>$this->Auth->user('role_id')));
          ?>
        </div>
        <?php echo $this->Form->submit(__l('Request Withdraw')); ?>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>