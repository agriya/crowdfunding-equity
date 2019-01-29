<?php if (!empty($projects)) { ?>
<section>
	<div id="funding-carousel" class="carousel slide funding-carousel" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php $is_active = true;
				if (!empty($projects)) {
					foreach($projects as $index => $project) { ?>
						<li data-target="#funding-carousel" data-slide-to="<?php echo $index; ?>" class="<?php echo ($is_active)?'active':''; $is_active = false; ?>"></li>
			<?php	}
				}
			?>
		</ol>
		<div class="carousel-inner" role="listbox">
			<?php $is_item_active = true;
				if (!empty($projects)) {
					foreach($projects as $index => $project) { ?>
						<div class="item <?php echo ($is_item_active)?'active':''; $is_item_active = false; ?>">
							<?php echo $this->Html->showImage('Project',$project['Attachment'],array('dimension' => 'project_very_big_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($project['Project']['name'], false)), 'class' => 'img-responsive center-block', 'title' => $this->Html->cText($project['Project']['name'], false))); ?>
							<div class="carousel-caption">
                                <div class="bg-danger clearfix text-left h1">
                                    <div class="col-xs-12 h3 well-sm navbar-btn">
                                        <div class="col-sm-9">
                                            <h3 class="h2 list-group-item-heading list-group-item-text">
												<strong>
												<?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']),array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false, 'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words'])));?>	
												</strong>
											</h3>
                                            <p class="h3 list-group-item-heading">
												<?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'], false), $project['Project']['detected_suspicious_words']),array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false, 'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['short_description'], false), $project['Project']['detected_suspicious_words'])));?>	
                                            </p>
                                        </div>
                                        <div class="col-sm-3 h4 text-center">
											<?php echo $this->Html->link(__l('View Projects'),array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false, 'class' => 'h4 text-center btn btn-lg btn-default fa-inverse', 'title' => $this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words'])));?>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
			<?php	}
				}
			?>
		</div>
	</div>
</section>
<?php } ?>