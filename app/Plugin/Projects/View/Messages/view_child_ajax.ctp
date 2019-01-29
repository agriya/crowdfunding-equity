<?php if (!empty($messages)): ?>
  <ol class="list-unstyled">
    <?php
      $i = 0;
      foreach($messages as $message):
         // if empty subject, showing with (no suject) as subject as like in gmail
        if (!$message['MessageContent']['subject']) :
          $message['MessageContent']['subject'] = '(no subject)';
        endif;
        if ($i++ % 2 == 0) :
          $row_class = 'row';
        else :
          $row_class = 'altrow';
        endif;
        $message_class = "checkbox-message ";
        $is_read_class = "";
        $is_starred_class = "star";
        if ($message['Message']['is_read']) :
          $message_class .= " checkbox-read ";
        else :
          $message_class .= " checkbox-unread ";
          $is_read_class .= "unread-message-bold";
          $row_class=$row_class.' unread-row';
        endif;
        if ($message['Message']['is_starred']):
          $message_class .= " checkbox-starred ";
          $is_starred_class = "star-select";
        else:
          $message_class .= " checkbox-unstarred ";
        endif;
        $path_class='';
        if(!empty($message['Message']['path'])){
          $path_count=explode('.',$message['Message']['path']);
          $path_class='offset' . $message['Message']['depth'];
        }
        $row_class='class=" message-list-block clearfix js-show-message js-no-pjax clearfix {\'message_id\':\''. $message['Message']['id'] .'\',\'is_read\':\''. $message['Message']['is_read'] .'\'}"';
        $row_three_class='w-three';
         if (!empty($message['MessageContent']['Attachment'])):
            $row_three_class.=' has-attachment';
        endif;
        $view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
    ?>
    <li class="<?php echo $path_class;?>">
      <div <?php echo $row_class;?> >      
        <ul class="list-inline message-from-block crop col-xs-12 navbar-btn<?php  echo $is_read_class;?> ">
			<li class="clearfix">
				<?php
				  if ($message['Message']['is_starred']) {
					echo $this->Html->link('<i class="fa fa-star ass pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id']) , array('class' => 'cur js-star js-no-pjax', 'escape' => false));
				  } else {
					echo $this->Html->link('<i class="fa fa-star-o pull-left"></i>', array('controller' => 'messages', 'action' => 'star', $message['Message']['id'],1) , array('class' => 'cur js-star js-no-pjax', 'escape' => false));
				  }
				  ?>
			</li>
			<li class="user-name-block c1">
				<?php
				  if ($message['Message']['is_sender'] == 1) :
					echo __l('To') . '<span class="ver-space">'.$this->Html->cText($message['OtherUser']['username'], false).'</span>';
				  elseif ($message['Message']['is_sender'] == 2) :
					echo $this->Html->link(__l('Me') , $view_url);
				  else:
					echo  '<span>'.$this->Html->cText($message['OtherUser']['username'], false).'</span>';
				  endif;
				?>
			</li>
			<li class="<?php echo $row_three_class;?>">
				<div class="replied-message-block clearfix <?php if(!empty($message['Message']['parent_message_id'])): ?>replied-message	<?php endif; ?>">
				<?php if(!empty($message['Project']['ProjectStatus']['name'])):?>
				  <div class="status-block grid_left">
					<span title ="<?php echo $this->Html->cText($message['Project']['ProjectStatus']['name'], false); ?>" class="project-status <?php echo  $message['Project']['ProjectStatus']['slug'];?>"> &nbsp;</span>
				  </div>
				<?php endif;?>
				<?php echo $this->Html->cText($message['Project']['name']);?>
				</div>
			</li>
			<li class="clearfix ">
				<span><?php echo $this->Html->cText($message['MessageContent']['message']);?></span>
			</li>
			<?php
				$time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
			?>
			<li class="pull-right js-timestamp <?php echo $is_read_class;?>" title ="<?php echo $time_format;?>">
				<?php echo $this->Html->cDateTimeHighlight($message['Message']['created'], false);?>
			</li>
        </ul>      
      </div>
      <div class="hide js-message-view<?php echo $this->Html->cInt($message['Message']['id'], false); ?>">
      <div class="clearfix message-list-block current-content <?php echo $path_class;?>">
        <?php if(!empty($message['Project']['ProjectStatus'])){?>
        <div class="message-project-name grid_left clearfix">
          <div class="grid_left">
            <?php echo $this->Html->link($message['Project']['name'], array('controller' => 'projects', 'action' => 'view', $message['Project']['slug']),array('title' =>$message['Project']['name']));?>
          </div>
          <?php if(!empty($message['Project']['ProjectStatus']['slug'])){ ?>
            <div class="status-block grid_left">
              <span class="<?php echo $message['Project']['ProjectStatus']['slug'];?>">&nbsp;</span>
            </div>
            <span class="project-status grid_left"><?php echo $this->Html->cText($message['Project']['ProjectStatus']['name'], false);?></span>
          <?php } ?>
        </div>
        <div class="grid_right">
          <?php if (isset($message['Message']['is_activity']) && $message['Message']['is_activity'] != 1): ?>
            <?php echo $this->Html->link(__l('Message Board'), array('controller' => 'messages', 'action' => 'index', 'project_id'=>$message['Project']['id']),array('title' => __l('Message Board')));?>
          <?php endif; ?>
        </div>
        <?php } ?>
      </div>
      <div class="current-content current-content-inner">
        <div class="reply-info-block clearfix">
            <?php echo $this->Html->CText($message['MessageContent']['message']);?>
        </div>
		<?php
		 $depth_allowed = Configure::read('messages.thread_max_depth');
          if (empty($depth_allowed) || $message['Message']['depth'] < Configure::read('messages.thread_max_depth')) {
        ?>
        <div class="clearfix text-right js-reply-hide<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
            <?php
              if(empty($message['Message']['project_status_id']) && $this->Auth->user('id') != $message['Message']['other_user_id']){
                echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'project_id' => $message['Project']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'inbox','m_path'=>$message['Message']['materialized_path']), array("class" => "btn btn-primary js-tooltip btn-sm reply-block js-link-reply js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-".$message['Message']['id']."'}", 'title' => __l('Reply')));
              }
            ?>
        </div>
		<?php
		}
		?>
      </div>
    </div>
    <div class="multisupporteds hide js-quickrepy js-quickreply-<?php echo $this->Html->cInt($message['Message']['id'], false);?>">
      <div class="quick-replay1 clearfix">
        <div class="js-quickreplydiv-<?php echo $this->Html->cInt($message['Message']['id'], false);?>"></div>
      </div>
    </div>
    </li>
  <?php
    endforeach;
  ?>
  </ol>
<?php endif; ?>