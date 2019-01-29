<?php if(isset($this->request->params['named']['slug']) && ($this->request->params['named']['slug'] == 'pledge_info' || $this->request->params['named']['slug'] == 'donate_info' || $this->request->params['named']['slug'] == 'lend_info'|| $this->request->params['named']['slug'] == 'equity_info') && isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'page'){
  $bgcolorClass = 'well';
  $thumbnailClass = '';
  $spaceClass = '';
  $topSpaceClass = '';
} else {
  $bgcolorClass = '';
  $spaceClass = '';
  $topSpaceClass = '';
} ?>
<?php $this->Layout->setNode($node); ?>
<?php
$hide_class = '';
if($this->Layout->node('slug') != 'home-banner'):
	$hide_class = 'show';
endif;
if (isset($this->request->params['named']['is_home'])):
	if (!empty($this->request->params['named']['is_home'])):
		$hide_class = 'show';
	else:
		$hide_class = 'hide';
	endif;
endif;
?>
<div class="gray-bg">
	<div class="container">
		<div id="node-<?php echo $this->Layout->node('id'); ?>" class="terms-policy-sec text-left <?php echo $hide_class; ?> node node-type-<?php echo $this->Layout->node('type').' '.$bgcolorClass; ?>">
				<?php $node_arr = array('home-banner')?>
					<?php if (!in_array($this->Layout->node('slug'),$node_arr)) { ?>
					<?php if($this->Layout->node('slug') != 'lend-terms') { ?>		
					<h3 class="text-22 roboto-bold list-group-item-heading"><?php echo __l($this->Layout->node('title')); ?></h3>
					<?php } ?>
					<?php if( $this->Layout->node('slug') != "private_beta" and  $this->Layout->node('slug') != "pre_launch") { ?>
					<div class="<?php echo $spaceClass.' '.$topSpaceClass; ?>">
						<?php } ?>
						<?php if( $this->Layout->node('slug') == 'project_guidelines' || $this->Layout->node('slug') == 'lend-terms') { ?>
						<div class="scroll guideline-block">
							<?php } ?>
							<?php } ?>
							<?php
								echo $this->Layout->nodeInfo();
								$url = $this->Html->onProjectAddFormLoad();
								$display_code = $this->Layout->nodeBody();
								if (!empty($this->theme)) {
									$banner_image_url = Router::url('/') . 'theme/' . $this->theme . '/img/banner-image.png';
								} else {
									$banner_image_url = Router::url(array('controller' => 'img', 'action' => 'banner-image.png'), false);
								}
								echo strtr($display_code,array(
								  '##BROWSE_URL##' => Router::url(array('controller' => 'projects', 'action' => 'discover', 'admin' => false), false),
								  '##ADD_URL##' => Router::url($url, false),
								  '##BANNER_IMAGE_URL##' => $banner_image_url,
								));
							?>
							<?php if (!in_array($this->Layout->node('slug'),$node_arr)) { ?>
							<?php if ( $this->Layout->node('slug') != "private_beta" and $this->Layout->node('slug') != "pre_launch") {?>
						</div>
						<?php } ?>
						<?php if( $this->Layout->node('slug') == 'project_guidelines' || $this->Layout->node('slug') == 'lend-terms') { ?>
					</div>
					<?php } ?>
				<?php } ?>
		</div>
	</div>
</div>
<?php if (!empty($types_for_layout[$this->Layout->node('type')])): ?>
<div id="comments" class="node-comments">
	<?php
		$type = $types_for_layout[$this->Layout->node('type')];
		if ($type['Type']['comment_status'] > 0 && $this->Layout->node('comment_status') > 0) {
		  echo $this->element('comments', array('cache' => array('config' => 'sec')));
		}
		if ($type['Type']['comment_status'] == 2 && $this->Layout->node('comment_status') == 2) {
		  echo $this->element('comments_form', array('cache' => array('config' => 'sec')));
		}
	?>
</div>

<?php endif; ?>