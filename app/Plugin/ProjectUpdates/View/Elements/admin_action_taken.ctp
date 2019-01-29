<li>
	<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
	<?php echo $this->Html->link(__l('Blog') . ' (' . $system_flagged_blog_count. ')', array('controller'=> 'blogs', 'action' => 'index', 'type' => 'user_messages' , 'filter_id' =>ConstMoreAction::Flagged), array('class' => 'h5 rgt-move'));?>
</li>
<li>
	<span class="text-muted"><i class="fa-fw fa fa-chevron-right small"></i></span>
	<?php echo $this->Html->link(__l('Blog Comment') . ' (' . $system_flagged_blog_comment_count. ')', array('controller'=> 'blog_comments', 'action' => 'index', 'type' => 'user_messages' , 'filter_id' =>ConstMoreAction::Flagged), array('class' => 'h5 rgt-move'));?>
</li>