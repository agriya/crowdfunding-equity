<div class="nodes admin-form new-admin-form">
	<?php echo $this->Form->create('Node', array('url' => array('controller' => 'nodes', 'action' => 'add','admin' => true, $typeAlias),'class' => 'form-horizontal form-maximize'));?>
	<fieldset>
		<ul class="breadcrumb">
			<li><?php echo $this->Html->link(__l('Content'), array('controller' => 'nodes', 'action' => 'index'),array('title' => __l('Content')));?><span class="divider">&raquo</span></li>
			<li class="active"><?php echo __l('Create Content - ').ucfirst($typeAlias);?></li>
		</ul>
		<ul class="nav nav-tabs navbar-btn">
			<li>
				<?php echo $this->Html->link('<i class="fa fa-th-list fa-fw"></i>'.__l('List'), array('controller' => 'nodes', 'action' => 'index'),array('title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
			</li>
			<li class="active"><a href="#add_form"><i class="fa fa-plus-circle fa-fw"></i><?php echo __l('Add'); ?></a></li>
		</ul>
		<div class="panel-container">
			<div id="add_form" class="tab-pane fade in active">
				<ul class="nav nav-tabs navbar-btn" id="
				myTab">
					<li class="active"><a data-toggle="tab" href="#node-main" class="js-no-pjax"><span><?php echo $this->Html->cText(__l($type['Type']['title']), false); ?></span></a></li>
					<?php if (count($taxonomy) > 0) { ?><li><a data-toggle="tab" href="#node-terms" class="js-no-pjax"><span><?php echo __l('Terms'); ?></span></a></li><?php } ?>
					<?php if ($type['Type']['comment_status'] != 0) { ?><li><a data-toggle="tab" href="#node-comments" class="js-no-pjax"><span><?php echo __l('Comments'); ?></span></a></li><?php } ?>
					<li><a data-toggle="tab" href="#node-meta" class="js-no-pjax"><span><?php echo __l('SEO'); ?></span></a></li>
					<li><a data-toggle="tab" href="#node-publishing" class="js-no-pjax"><span><?php echo __l('Publishing'); ?></span></a></li>
					<?php echo $this->Layout->adminTabs(); ?>
				</ul>
				<div class="tab-content gray-bg admin-checkbox" id="myTabContent">
					<div id="node-main" class="tab-pane fade in active">
						<?php
							echo $this->Form->input('parent_id', array('type' => 'select', 'label' => __l('Parent'),'options' => $nodes, 'empty' => __l('Please Select')));
							echo $this->Form->input('title',array('label' => __l('Title')));
							echo $this->Form->input('slug',array('label' => __l('Slug')));
							echo $this->Form->input('excerpt',array('label' => __l('Excerpt')));
						?>
						<div class="required clearfix">
							<label class="pull-left" for="NodeBody"><?php echo __l('Body');?></label>
							<div class="input textarea col-md-5 no-pad">
								<?php echo $this->Form->input('body', array('class' => 'js-editor pull-left', 'label' => false, 'div' => false)); ?>
							</div>
						</div>
						<div class="form-actions clearfix">
							<div class="pull-left">
								<?php echo $this->Form->submit(__l('Apply'), array('name' => 'apply','class'=>'btn btn-danger')); ?>
							</div>
							<div class="pull-left">
								<?php echo $this->Form->submit(__l('Save'), array('name' => 'save','class'=>'btn btn-info')); ?>
							</div>
							<div class = "pull-left" >
								<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'nodes', 'action' => 'index'), array('title' => __l('Cancel'), 'class' => 'btn', 'escape' => false)); ?>
							</div>
						</div>
					</div>
					<?php if (count($taxonomy) > 0) { ?>
					<div id="node-terms" class="tab-pane fade">
						<?php
							foreach ($taxonomy AS $vocabularyId => $taxonomyTree) {
								echo $this->Form->input('TaxonomyData.'.$vocabularyId, array(
									'label' => $vocabularies[$vocabularyId]['title'],
									'type' => 'select',
									'multiple' => true,
									'options' => $taxonomyTree,
								));
							}
						?>
					</div>
					<?php } ?>
					<?php if ($type['Type']['comment_status'] != 0) { ?>
					<div id="node-comments" class="tab-pane fade">
						<?php
							echo $this->Form->input('comment_status', array(
								'type' => 'radio',
								'div' => array('class' => 'radio'),
								'options' => array(
								'0' => __l('Disabled'),
								'1' => __l('Read only'),
								'2' => __l('Read/Write'),
								),
								'value' => $type['Type']['comment_status'],
							));
						?>
					</div>
					<?php } ?>
					<div id="node-meta" class="tab-pane fade">
						<?php echo $this->Form->input('meta_keywords', array('label' => __l('Meta Keywords'), 'type' => 'text')); ?>
						<?php echo $this->Form->input('meta_description', array('label' => __l('Meta Description'), 'type' => 'textarea')); ?>
					</div>
					<div id="node-publishing" class="tab-pane fade">
					<?php echo $this->Form->input('status', array('label' => __l('Published'), 'checked' => 'checked')); ?>
						<div class="input clearfix">
							<div class="js-datetime">
								<div class="js-cake-date">
									<?php echo $this->Form->input('created', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'), 'label' => __l('Created'))); ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo $this->Layout->adminTabs(); ?>					
				</div>
			</div>
		</div>
	</fieldset>
  <?php echo $this->Form->end(); ?>
</div>