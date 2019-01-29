<?php /* SVN: $Id: $ */ ?>
<?php
  if(!empty($this->request->params['isAjax'])):
    echo $this->element('flash_message');
  endif;
?>

<div class="payments order user-profile-form payment-block js-responses js-main-order-block">
  <div class="shad-bg">
  <div class="pay-pledge">
    <h3 class="pledge-now"><?php echo sprintf(__l('%s Now'), Configure::read('project.alt_name_for_pledge_singular_caps'));?></h3>
    <div class="shad-bg-lft clearfix">
    <div class="shad-bg-rgt">
      <div class="clearfix pledge-pay">
      <div class="pledge-img pull-left">
        <p>
        <?php
            echo $this->Html->link($this->Html->showImage('Project', $itemDetail['Project']['Attachment'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Project']['name'], false)), 'title' => $this->Html->cText($itemDetail['Project']['name'], false)),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $itemDetail['Project']['slug'], 'admin' => false), array('escape' => false));
          ?>
        </p>
      </div>
      <div class="pledge-amount project-left col-md-9">
        <div class="side1-info-r ">
        <h3> <?php echo $this->Html->link($this->Html->cText($itemDetail['Project']['name'],false),array('controller' => 'projects', 'action' => 'view',  $itemDetail['Project']['slug'], 'admin' => false), array('escape' => false));?> </h3>
        <p> <?php echo __l('by') . ' '; ?><?php echo $this->Html->link($this->Html->cText($itemDetail['Project']['User']['username']), array('controller' => 'users', 'action' => 'view', $itemDetail['Project']['User']['username']), array('escape' => false));?></p>
        <p class="funding-ends"><?php echo __l('Funding ends') . ' ' . $this->Time->cDate($itemDetail['Project']['project_end_date']); ?></p>
        </div>
        <?php  $collected_percentage = ($itemDetail['Project']['collected_percentage']) ? $itemDetail['Project']['collected_percentage'] : 0; ?>
        <div class="progress-block round-5  project-left">
        <p class="progress-bar" title = '<?php echo $this->Html->cFloat($collected_percentage,false).'%'; ?>'> <span style="width:<?php echo ($collected_percentage > 100) ? '100%' : $collected_percentage.'%'; ?>;" title = "<?php echo $this->Html->cFloat($collected_percentage,false).'%'; ?>"><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($itemDetail['Project']['collected_amount'], false));?> </span> </p>
        <p><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($itemDetail['Project']['collected_amount'],false)); ?> / <?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($itemDetail['Project']['needed_amount'], false)); ?></p>
        <div class="pledge-list-block clearfix">
          <dl class="deal-discount col-md-2">
          <?php $i = 0; $class = ' class="altrow"';?>
          <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Fund Amount');?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->siteCurrencyFormat($this->Html->cCurrency($itemDetail['ProjectFund']['amount'],false));?></dd>
          </dl>
          <dl class="deal-discount col-md-1">
          <dt><?php echo Configure::read('project.alt_name_for_backer_plural_caps'); ?></dt>
          <dd><?php echo $this->Html->cInt($itemDetail['Project']['project_fund_count']); ?></dd>
          </dl>
        </div>
        </div>
      </div>
      </div>
      <?php if (!empty($itemDetail['ProjectReward']['id']) && isPluginEnabled('ProjectRewards')): ?>
      <dl class="select-reward">
      <dt><?php echo sprintf(__l('Selected %s'), Configure::read('project.alt_name_for_reward_singular_small')); ?> </dt>
      <dd>
        <?php $reward = $itemDetail['ProjectReward']['reward'] ? $itemDetail['ProjectReward']['reward'] : sprintf(__l('No %s'), Configure::read('project.alt_name_for_reward_singular_small')); echo $this->Html->cText($reward); ?>
      </dd>
      </dl>
      <?php endif; ?>
    </div>
    </div>
    <?php
      echo $this->Form->create('ProjectFund', array('action' => 'process_order', 'id' => 'PaymentOrderForm', 'class' => 'normal'));
      echo $this->Form->input('item_id', array('type' => 'hidden'));
      echo $this->Form->input('amount', array('type' => 'hidden','value'=>$total_amount));
    ?>
    <div class="clearfix paypal-block round-3">
    <fieldset class="fields-block grid_left suffix_2">
    <legend><?php echo __l('Select Payment Type'); ?></legend>
    <?php  echo $this->element('payment-get_gateways', array('model'=>'ProjectFund','type'=>'is_enable_for_pledge','is_enable_wallet'=>1, 'cache' => array('cache' => array('config' => 'sec'))));?>
    </fieldset>
    </div>
    <?php echo $this->Form->end(); ?> </div>
  </div>
</div>
