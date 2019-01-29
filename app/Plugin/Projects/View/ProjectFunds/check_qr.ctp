<div class="js-response">
  <h2><?php echo __l('Voucher'); ?></h2>
  <?php if(!empty($projectFund['ProjectFund']['is_given'])): ?>
  <p class="alert alert-info"><?php echo __l('This voucher has been used'); ?></p>
  <?php endif; ?>
  <?php
    $projectStatus = array();
    $response = Cms::dispatchEvent('View.ProjectType.GetProjectStatus', $this, array(
      'projectStatus' => $projectStatus,
      'project' => $projectFund,
      'type' => 'status'
    ));
  ?>
  <div class="clearfix">
  <table width='100%' cellpadding="5" cellspacing="3" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <tr>
    <th><?php echo sprintf(__l('%s name'), Configure::read('project.alt_name_for_project_singular_caps')); ?></th>
    <td><?php echo $this->Html->cText($projectFund['Project']['name']);?></td>
    </tr>
    <tr>
    <th><?php echo __l('Coupon code:'); ?></th>
    <td><?php
            if (!empty($response->data['is_allow_to_change_given'])) {
              echo $this->Html->cText($projectFund['ProjectFund']['coupon_code']);
            }
          ?>
    </td>
    </tr>
    <tr>
    <th><?php echo __l('Recipient:'); ?></th>
    <td><?php echo $this->Html->cText($projectFund['User']['username']);?></td>
    </tr>
    <tr>
    <th><?php echo Configure::read('project.alt_name_for_pledge_singular_caps') . ': '; ?></th>
    <td><?php echo $this->Html->cDate($projectFund['ProjectFund']['created']);?></td>
    </tr>
    <?php if(!empty($projectFund['ProjectFund']['is_given'])): ?>
    <tr>
    <th><?php echo __l('Used on:')?></th>
    <td><?php echo $this->Html->cDate($projectFund['ProjectFund']['modified']);?></td>
    </tr>
    <?php endif; ?>
  </table>
  <div>
    <?php
        $barcode_width = Configure::read('barcode.width');
        $barcode_height = Configure::read('barcode.height');
        $parsed_url = parse_url($this->Html->url('/', true));
        $qr_mobile_site_url = str_ireplace($parsed_url['host'], $parsed_url['host'], Router::url(array(
          'controller' => 'deal_user_coupons',
          'action' => 'check_qr',
          $projectFund['ProjectFund']['id'],
          $projectFund['ProjectFund']['unique_coupon_code'],
          'admin' => false
        ) , true));
      ?>
    <?php echo $this->Html->image('http://chart.apis.google.com/chart?cht=qr&chs='.$barcode_width.'x'.$barcode_height.'&chl='.$qr_mobile_site_url, array('alt' => __l('[Image: Project qr code]') ,'width' => $barcode_width, 'height' => $barcode_height)); ?>
    <p><?php echo $this->Html->cInt($projectFund['ProjectFund']['unique_coupon_code'], false); ?></p>
  </div>
  <?php if (!empty($response->data['is_allow_to_change_given']) && $projectFund['Project']['user_id'] == $this->Auth->user('id')) { ?>
  <div class="clearfix">
    <?php
          if(empty($projectFund['ProjectFund']['is_given'])):
            echo $this->Form->create('ProjectFund', array( 'action'=> 'check_qr', 'class' => 'normal clearfix'));
            echo $this->Form->input('coupon_code', array('type'=>'hidden'));
            echo $this->Form->input('unique_coupon_code', array('type'=>'hidden'));
            echo $this->Form->submit(__l('Mark as Given'));
            echo $this->Form->end();
          endif;
        ?>
  </div>
  <?php } ?>
  </div>
</div>
