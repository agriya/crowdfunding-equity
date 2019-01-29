<div class="container-fluid user-dashboard">
  <?php if (!$this->request->params['isAjax']) { ?>
  <div class="clearfix">
	<div class="clearfix user-heading">
		<h3 class="col-xs-8 col-sm-6 h2 text-uppercase list-group-item-text"><?php echo sprintf(__l('%s Posted'), Configure::read('project.alt_name_for_project_plural_caps'));?></h3>
		<div class="col-xs-4 col-sm-6 h2 list-group-item-text">
			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
		</div>
    </div>
    <?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
  <?php } ?>
  <?php
	  foreach($projectTypes as $projectType):
		  if(isPluginEnabled($projectType['ProjectType']['name'])){
			$data = array(
				'project_type' => Inflector::Pluralize($projectType['ProjectType']['slug']),
				'cache' => array(
					'config' => 'sec',
					'key' => $this->Auth->user('id')
				)
			);
			echo $this->element('myprojects', $data);
		}
	endforeach;
  ?> 
</div>
<div class="modal fade" id="js-ajax-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
			<div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
		</div>
	</div>
</div>