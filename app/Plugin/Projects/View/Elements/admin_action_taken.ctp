<li>
	<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
	<?php echo $this->Html->link(__l('User Message') . ' (' . $system_flagged_message_count. ')', array('controller'=> 'messages', 'action' => 'index', 'type' => 'user_messages' , 'filter_id' =>ConstMoreAction::Flagged), array('class' => 'h5 rgt-move'));?>
</li>
<li>
	<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
	<?php echo $this->Html->link(__l('Project Comment') . ' (' . $system_flagged_project_comment_count. ')', array('controller'=> 'messages', 'action' => 'index', 'type' => 'project_comments' , 'filter_id' =>ConstMoreAction::Flagged), array('class' => 'h5 rgt-move'));?>
</li>