<?php /* SVN: $Id: $ */ ?>
<div class="userOpenids index js-response">
  <h2><?php echo __l('User Openids');?></h2>
   <div><?php echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add')));?></div>
  <?php echo $this->Form->create('UserOpenid' , array('type' => 'get', 'action' => 'index')); ?>
  <div class="filter-section">
  <div>
    <?php echo $this->Form->input('q', array('label' => 'Keyword')); ?>
  </div>
  <div>
    <?php echo $this->Form->submit(__l('Search'));?>
  </div>
  </div>
  <?php echo $this->Form->end(); ?>
  <?php echo $this->Form->create('UserOpenid' , array('action' => 'update')); ?>
  <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <?php echo $this->element('paging_counter');?>
<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
      <th><?php echo __l('Select'); ?></th>
      <th><?php echo __l('Actions');?></th>
      <th class="text-center"><div><?php echo $this->Paginator->sort('User.username', __l('Username'));?></div></th>
      <th class="text-left"><div><?php echo $this->Paginator->sort('openid');?></div></th>
    </tr>
    <?php
    if (!empty($userOpenids)):
      foreach ($userOpenids as $userOpenid):
        ?>
        <tr>
          <td><?php echo $this->Form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
          <td><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?></span></td>
          <td class="text-left"><?php echo $this->Html->link($this->Html->cText($userOpenid['User']['username']), array('controller'=> 'users', 'action'=>'view', $userOpenid['User']['username'], 'admin' => false), array('escape' => false));?></td>
          <td class="text-left"><?php echo $this->Html->cText($userOpenid['UserOpenid']['openid']);?></td>
        </tr>
        <?php
      endforeach;
    else:
      ?>
      <tr>
        <td colspan="4"><i class="fa fa-exclamation-triangle"></i> <?php echo sprintf(__l('No %s available'), __l('OpenIDs'));?></td>
      </tr>
      <?php
    endif;
    ?>
  </table>
  <?php
  if (!empty($userOpenids)) :
    ?>
    <div class="js-select-action">
      <?php echo __l('Select:'); ?>
      <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select {"checked":"js-checkbox-list"}')); ?>
      <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select {"unchecked":"js-checkbox-list"}')); ?>
    </div>
    <div>
      <?php echo $this->element('paging_links'); ?>
    </div>
    <div>
      <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
    </div>
    <div class="hide">
      <?php echo $this->Form->submit('Submit');  ?>
    </div>
    <?php
  endif;
  echo $this->Form->end();
  ?>
</div>