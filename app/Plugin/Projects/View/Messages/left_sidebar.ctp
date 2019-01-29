<ul class="nav nav-pills">
    <?php
      $inbox_count = '';
      if (!empty($inbox)):
        $inbox_count =  $inbox ;
      endif;
      $star_count = '';
      if (!empty($stared)):
        $star_count = '('.$stared.')';
      endif;

    ?>
   <?php $class = (!empty($folder_type) && $folder_type == 'inbox') ? 'js-unread' : 'js-unread'; ?>
    <?php $active = (!empty($folder_type) && $folder_type == 'all') ? 'active' : ''; ?>
    <li class="all <?php echo $active; ?>" data-toggle="tab">		
		<?php echo $this->Html->link('<i class="fa fa-book fa-fw marg-right-5"></i>'.__l('All') , array('controller' => 'messages', 'action' => 'all'), array('title'=>__l('All'), 'escape'=>false)); ?>
    </li>
     
    <?php $active =  (!empty($folder_type) && $folder_type == 'inbox') ? 'active' : '';  ?>
    <li class="inbox <?php echo $active; ?>" data-toggle="tab">
		<!--<i class="fa fa-inbox fa-lg fa-fw"></i>-->
		<?php echo $this->Html->link('<i class="fa fa-inbox fa-lg fa-fw marg-right-5"></i>'.__l('Inbox') . '<span class="badge">'. $inbox_count.'</span>', array('controller' => 'messages', 'action' => 'inbox'),array('title'=>__l('Inbox'),'class' => $class,'escape'=>false)); ?>
    </li>
    <?php $class = (!empty($folder_type) && $folder_type == 'sent') ? 'linkc' : 'blackc'; ?>
    <?php $active =  (!empty($folder_type) && $folder_type == 'sent') ? 'active' : '';  ?>
    <li class="replied <?php echo $active; ?>" data-toggle="tab">
		<!--<i class="fa fa-reply-all fa-lg fa-fw"></i>-->
		<?php echo $this->Html->link('<i class="fa fa-reply-all fa-lg fa-fw marg-right-5"></i>'.__l('Replied') , array('controller' => 'messages', 'action' => 'sentmail'),array('title'=>__l('Replied'), 'class' => $class,'escape'=>false)); ?>
    </li>
    <?php $class = (!empty($folder_type) && $folder_type == 'starred' && !empty($is_starred)) ? 'linkc' : 'blackc'; ?>
    <?php $active =  (!empty($folder_type) && $folder_type == 'starred') ? 'active' : '';  ?>
    <li class="starred <?php echo $active; ?>" class="starred span" data-toggle="tab">
		<!--<i class="fa fa-star-o fa-lg fa-fw"></i>-->
		<?php echo $this->Html->link('<i class="fa fa-star-o fa-lg fa-fw marg-right-5"></i>'.__l('Starred'). '<span class="badge">'.$star_count . '</span>' , array('controller' => 'messages', 'action' => 'starred'),array('title'=>__l('Starred ' . $star_count), 'class' => $class,'escape'=>false)); ?><em class="starred"></em>
    </li>
    <?php $class = (!empty($folder_type) && $folder_type == 'all' && empty($is_starred)) ? 'linkc' : 'blackc'; ?>  
</ul>