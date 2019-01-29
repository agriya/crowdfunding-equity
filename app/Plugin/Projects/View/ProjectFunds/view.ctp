<?php /* SVN: $Id: index.ctp 2879 2010-08-27 11:08:48Z sakthivel_135at10 $ */ ?>
<?php if (!empty($projectFund)): ?>
  <div style="padding: 10px; width: 800px; margin: auto;font-size:12px;">
    <div style="width:750px; margin:0px auto;margin:0px;padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#000;">
      <div style="color:#999;  border:2px solid #000; padding:20px; background:#fff;">
        <table width="100%" style="background-color:#fff;border-bottom:2px solid #ddd;padding:0px;margin:0px;">
          <tr>
            <td width="70%" style="padding:10px 0px;"><?php echo $this->Html->image(Router::url(array('controller' => 'img', 'action' =>'crowdfunding.png', 'admin' => false),true), array('alt'=> __l('[Image: Logo]'), 'title' => Configure::read('site.name'))); ?> </td>
            <td width="30%" style="padding:10px 0px;"><strong style="width:120px;margin:0px;padding:0px 0px 0px 10px;font-size:20px;color:#000;"><?php echo '#'.$projectFund['ProjectFund']['coupon_code'];?></strong> </td>
          </tr>
        </table>
        <p><strong style="color:#000; font-size:20px;display:block;margin:15px 0px 10px 0px; "><?php echo $this->Html->cText($projectFund['Project']['name']);?></strong></p>
        <div style=" margin:0px,padding:10px;">
          <table style="" style="background-color:#fff;border-bottom:2px solid #ddd;padding:0px;margin:0px;width: 100%; font-size:12px;color:#000;">
            <tbody>
              <tr>
                <td style="width: 49%;line-height:22px;vertical-align:top;color:#000;">
                  <strong style="color:#000; font-size4:16px;display:block;margin:5px 0px 0px 0px;"><?php echo __l('Recipient:');?></strong>
                  <p style="font-family:arial;font-size:13px;margin:0px;padding:0px;"> <?php echo $this->Html->cText($projectFund['User']['username']);?></p>
                  <strong style="color:#000; font-size4:16px;display:block;margin:5px 0px 0px 0px;"><?php echo Configure::read('project.alt_name_for_reward_singular_caps') . ': ';?></strong>
                  <p style="font-family:arial;font-size:13px;margin:0px;padding:0px;"> <?php echo $this->Html->cText($projectFund['ProjectReward']['reward']);?></p>
                  <strong style="color:#000; font-size4:16px;display:block;margin:5px 0px 0px 0px;"><?php echo __l('Estimated Delivery Date: '); ?></strong>
                  <p style="font-family:arial;font-size:13px;margin:0px;padding:0px;"> <?php echo $this->Html->cDate($projectFund['ProjectReward']['estimated_delivery_date']);?></p>
                </td>
                <td style="width: 49%;line-height:22px; color:#000;" valign="top">
                  <dl style="margin:0px;padding:0px;">
                    <dt style="width:120px; float:left; margin:0px; padding:0px; text-align:right; font-weight:bold; color:#000;"><?php echo __l('Redeem At: ')?></dt>
                      <dd style="width:157px;float:left;margin:0px;padding:0px 0px 0px 10px; font-family:arial;font-size:13px;"><?php echo $this->Html->cText($projectFund['Project']['User']['username']);?><br /></dd>
                    <dt style="width:120px; float:left; margin:0px; padding:0px; text-align:right; font-weight:bold; color:#000;"><?php echo Configure::read("project.alt_name_for_".$projectFund['Project']['ProjectType']['slug']."_past_tense_caps").' '.__l('On') . ': '; ?> </dt>
                      <dd style="width:157px;float:left;margin:0px;padding:0px 0px 0px 10px;font-family:arial;font-size:13px;"><?php echo $this->Html->cDate($projectFund['ProjectFund']['created']);?></dd>
                  </dl>
                  <div style="clear:both"></div>
                  <div style="margin:0px 0px 0px 20px;padding:0px 0px 0px 10px;font-family:arial;font-size:13px;">
                    <?php
                      if (Configure::read('barcode.is_barcode_enabled')) {
                        $barcode_width = Configure::read('barcode.width');
                        $barcode_height = Configure::read('barcode.height');
                        $parsed_url = parse_url($this->Html->url('/', true));
                        $qr_mobile_site_url = str_ireplace($parsed_url['host'],  $parsed_url['host'], Router::url(array(
                          'controller' => 'project_funds',
                          'action' => 'check_qr',
                          $projectFund['ProjectFund']['id'],
                          $projectFund['ProjectFund']['unique_coupon_code'],
                          'admin' => false
                        ) , true));
                    ?>
                    <?php echo $this->Html->image('http://chart.apis.google.com/chart?cht=qr&chs='.$barcode_width.'x'.$barcode_height.'&chl='.$qr_mobile_site_url, array('alt' => __l('[Image: Project qr code]') ,'width' => $barcode_width, 'height' => $barcode_height)); ?>
                    <p style="margin:0px 0px 0px 28px;padding:0px;font-weight:bold;"><?php echo $this->Html->cInt($projectFund['ProjectFund']['unique_coupon_code'], false);?></p>
                    <?php
                      }
                    ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <table style="margin:10px 0px 0px 0px;padding:10px;">
        <tr>
          <td width="60%" style="vertical-align:top;">
            <strong style="color:#000;padding:10px 0px 0px 0px;font-size: 16px; "><?php echo __l('How to use this:');?></strong><br/>
            <ol style="list-style-type:decimal;list-style-position:inside;margin:10px 0px; font-family:arial;font-size:14px;">
              <li style="margin:3px 0px;padding:0px;"><?php echo __l('Print voucher') ?></li>
              <li style="margin:3px 0px;padding:0px;"><?php echo __l('Present voucher upon arrival.');?></li>
              <li style="margin:3px 0px;padding:0px;"><?php echo __l('Enjoy!');?></li>
            </ol>
          </td>
          <td width="40%" style="vertical-align:top;">
            <strong style="color:#000; font-size:16px;padding:10px 0px 0px 0px;"><?php echo __l('Map:');?></strong>
            <div  style="margin:5px 0px 0px 0px;">
              <?php $map_zoom_level = '7';?>
              <?php echo $this->Html->image($this->Html->formGooglemap($projectFund['Project'],'320x250')); ?>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print'): ?>
    <script>
      window.print();
    </script>
  <?php endif; ?>
<?php endif; ?>