<div class="bg-primary row">
	<ul class="list-inline sec-1 navbar-btn">
		<li><strong><?php echo __l('Type'); ?>:</strong></li>
		<li>
			<div class="well-sm">
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ste-usr">'.$this->Html->cInt($content_type,false).'</span><span>' .__l('Page'). '</span>', array('controller'=>'nodes','action'=>'index','content_filter_id' => constContentType::Page), array('escape' => false));?>
			</div>
		</li>
	</ul>
	<ul class="list-inline sec-1 navbar-btn">
		<li><strong><?php echo __l('Status'); ?>:</strong></li>
		<li>
			<div class="well-sm">
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block act-usr text-center">'.$this->Html->cInt($publish,false).'</span><span>' .__l('Publish'). '</span>', array('controller'=>'nodes','action'=>'index','content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Publish), array('escape' => false));?>
			</div>
		</li>
		<li>
			<div class="well-sm">
				<?php echo $this->Html->link('<span class="img-circle img-thumbnail bg-sucess img-wdt center-block text-center ina-usr">'.$this->Html->cInt($unpublish,false).'</span><span>' .__l('Unpublish'). '</span>', array('controller'=>'nodes','action'=>'index','content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Unpublish), array('escape' => false));?>
			</div>
		</li>
	</ul>
</div>
