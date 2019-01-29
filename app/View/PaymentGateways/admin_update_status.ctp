<?php /* SVN: $Id: admin_index.ctp 2741 2010-08-13 15:30:58Z boopathi_026ac09 $ */ ?>
<?php
  echo $this->Html->link(!empty($toggle) ? '<i class="fa fa-check"></i><span class="hide">Yes</span>' : '<i class="fa fa-times"></i><span class="hide">No</span>', array('controller' => 'payment_gateways', 'action' => 'update_status', $id, $actionId, 'toggle' => empty($toggle) ? 1 : 0), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));
?>