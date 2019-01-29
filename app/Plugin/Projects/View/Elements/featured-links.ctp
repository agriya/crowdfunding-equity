<?php $almost="Almost " . Configure::read('project.alt_name_for_'.$project_type.'_past_tense_caps');?>
<h4><?php echo sprintf(__l('%s %s'), Configure::read('project.alt_name_for_'.$project_type.'_past_tense_caps'), Configure::read('project.alt_name_for_project_plural_caps'));?></h4>

<ul class="nav nav-tabs nav-stacked">
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'recommended') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link(__l('Recommended'), array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'recommended'), array('title' => __l('Recommended')));?></li>
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'popular') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link(__l('Popular'), array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'popular'), array('title' => __l('Popular')));?></li>
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'almost_funded') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link($almost, array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'almost_funded'), array('title' => $almost));?></li>
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'ending_soon') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link(__l('Ending Soon'), array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'ending_soon'), array('title' => __l('Ending Soon')));?></li>
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'small_projects') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link(sprintf(__l('Small %s'), Configure::read('project.alt_name_for_project_plural_caps')), array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'small_projects'), array('title' => sprintf(__l('Small %s'), Configure::read('project.alt_name_for_project_plural_caps'))));?></li>
  <?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'hall_of_fame') ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link(__l('Hall of Fame'), array('controller' => 'projects', 'action' => 'index', 'project_type'=>$project_type, 'filter' => 'hall_of_fame'), array('title' => __l('Hall of Fame')));?></li>
</ul>
