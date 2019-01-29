<?php if(!empty($message)){?>
  <tr class ="js-meesage-tr-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
           <td>
             <div class ="js-message-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
             <?php echo $this->Html->cText($message['OtherUser']['username'], false);?>
             </div>
               <div class ="hide js-message-details-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
                 <?php echo $this->Html->cText($message['OtherUser']['username'], false); ?>
               </div>
           </td>
           <td>
           <div class="msg-board">
          <?php
            $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
          ?>
           <p class="post"><?php echo __l('Posted').' <span class ="js-timestamp" title="' . $time_format  . '">'. $message['Message']['created'] . '</span>';?></p>
           <div class ="hide js-message-details-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
             <p class="do"><?php echo $this->Html->cText($message['MessageContent']['subject'], false);?></p>
           </div>
           </div>
           </td>
           <td class="last">
          <div class ="js-message-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
          <?php
           if($message['Message']['is_private'] and (!($this->Auth->user('id')) or (($this->Auth->user('id') != $message['OtherUser']['id']) and ($this->Auth->user('id') != $message['User']['id'])) and ($this->Auth->user('id') != $message['Project']['user_id']))){?>
           <p>[<?php echo __l("private message for ").$this->Html->link($message['User']['username'],array('controller'=>'users','action'=>'view',$message['User']['username']));
            if(!($this->Auth->user('id'))){
              echo ", ".$this->Html->link(__l('Login to view'),array('controller'=>'users','action'=>'login'));
            }
           ?>]</p>

          <?php }else{
          if($message['Message']['is_private'] ){?>
           <p>[<?php echo __l("private message for ").$this->Html->link($message['User']['username'],array('controller'=>'users','action'=>'view',$message['User']['username']));?>]</p>
          <?php }else{?>
            <p>[<?php echo __l("Public message for all");?>]</p>
          <?php }?>
             <span><?php echo $this->Html->cText($message['MessageContent']['message'],false);?></span>

             <ul class="msgboard-list msgboard-list1">
              <li><?php echo $this->Html->link(__l('View'),array('controller'=>'messages','action'=>'v', $message['Message']['id'], 'project_id'=>$message['Project']['id'],'type'=>'contact'),array('target'=>'blank','title'=>__l('view'),'class'=>'js-message-view {"message":"'.$message['Message']['id'].'"}'));?></li>
              </ul></div>
              <?php
               }
              ?>
            <div class ="hide js-message-details-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
             <?php if($message['Message']['is_private'] ){?>
           <p>[<?php echo __l("private message for ").$this->Html->link($message['User']['username'],array('controller'=>'users','action'=>'view',$message['User']['username']));?>]</p>
          <?php }else{?>
            <p>[<?php echo __l("Public message for all");?>]</p>
          <?php }?>
            <?php echo $this->Html->cText($message['MessageContent']['message']);?>
            <div class="clearfix">
             <ul class="msgboard-list">
              <li class="last"><?php echo $this->Html->link('Close',array('#'),array('class'=>'js-message-close {"message":"'.$message['Message']['id'].'"}'))?></li>
              </ul>
              </div>
             </div>

          </td>

        </tr>
        <?php }?>