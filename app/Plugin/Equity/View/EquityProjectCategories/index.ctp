<div class="js-response">
  <?php if (!empty($projectCategories)) :?>
  <h4><?php echo __l('Filter by Category');?></h4>
  <ul class="clearfix">
  <?php foreach ($projectCategories as $project_category) :?>
  <?php $class = (!empty($this->request->params['named']['category']) && $this->request->params['named']['category'] == $project_category['EquityProjectCategory']['slug']) ? ' class="active"' : null; ?>
  <li <?php echo $class;?>><?php echo $this->Html->link($project_category['EquityProjectCategory']['name'], array('controller' => 'projects', 'action' => 'index', 'category' => $project_category['EquityProjectCategory']['slug']), array('title' => $project_category['EquityProjectCategory']['name']));?></li>
  <?php endforeach;?>
  </ul>
  <?php endif;?>
  <?php if (!empty($projectCategories)) : ?>
 <div class="clearfix"> <div class="pull-right js-pagination js-no-pjax"> <?php echo $this->element('paging_links'); ?> </div></div>
  <?php endif; ?>
</div>
</div>