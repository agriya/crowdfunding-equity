<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes admin-form">
  <?php echo $this->Form->create('AffiliateType', array('action' => 'edit'));?>
<div class="table-responsive">  
	<table class="table table-striped table-bordered table-condensed table-hover">
      <tr>
        <th class="text-center"><?php echo __l('Name');?></th>
        <th class="text-center"><?php echo __l('Commission');?></th>
        <th class="text-center"><?php echo __l('Commission Type');?></th>
        <th class="text-center"><?php echo __l('Active?');?></th>
      </tr>
      <?php
        $types = count($this->request->data['AffiliateType']);
        for($i=0; $i<$types; $i++) {
      ?>
      <tr>
        <td class="text-center"><?php echo $this->Form->input('AffiliateType.'.$i.'.id', array('label' => false)); ?><?php echo $this->Form->input('AffiliateType.'.$i.'.name', array('label' => false)); ?></td>
        <td class="text-center">
          <?php
            echo $this->Form->input('AffiliateType.'.$i.'.commission', array('label' => false));
            $options = $affiliateCommissionTypes;
            if ($this->request->data['AffiliateType'][$i]['id'] == 1)
              unset($options[1]);
          ?>
        </td>
        <td class="text-center"><?php echo $this->Form->input('AffiliateType.'.$i.'.affiliate_commission_type_id', array('options' => $options, 'label' => false)); ?></td>
        <td class="text-center"><?php echo $this->Form->input('AffiliateType.'.$i.'.is_active', array('label' =>'')); ?></td>
      </tr>
      <?php
        }
      ?>
      <tr>
        <td colspan="4" class="text-center">
         <div class="form-actions"><?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-info'));?></div>
        </td>
      </tr>
    </table>
</div>	
  <?php echo $this->Form->end(); ?>
</div>