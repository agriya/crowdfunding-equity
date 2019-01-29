<script src="<?php echo Router::url('/',true). 'js/libs/svg/svg.js';?>"  type="text/javascript"></script>
<div class="col-md-9 text-center svg-projects-width">	
	<?php $url = Router::url(array('controller' => "equities", 'action' => 'equity_svg', 'ext' => 'svg', 'admin' => true), true); ?>
	<object data="<?php echo $url; ?>" type="image/svg+xml" height="180" id="svgObject"></object>
</div>