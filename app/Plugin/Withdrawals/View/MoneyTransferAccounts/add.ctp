<div class="moneyTransferAccounts form disk-usage js-responses">
<div class="alert alert-info">
		<?php echo __l('Admin will send the amount to any one of the below account'); ?>
</div>
  <?php echo $this->Form->create('MoneyTransferAccount', array('action' => 'add', 'class' => 'form-horizontal js-ajax-form'));?>
    <fieldset class="form-block gray-bg marg-btom-20">
      <?php echo $this->Form->input('account',array('type' => 'textarea', 'label' => __l('Account'), 'info' => __l('Enter any bank detail, paypal account detail etc.,'))); ?>
    <div>
    <?php
      echo $this->Form->submit(__l('Add'),array('class' => 'btn btn-info'));
    ?>
    </div>
    </fieldset>
  <?php
    echo $this->Form->end();
  ?>
</div>