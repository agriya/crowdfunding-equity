<div id="<?php echo $authorize_name;?>-authorizecontainer" class="container">
    <div class="message-content">
    <div class="authorize-head row">
    <div class="row">
	<?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'class' => 'js-loader', 'width' => 25, 'height' => 25)); ?>
    <span class="loading">Loading....</span></div>
    </div>
    <h4><?php echo sprintf(__l('Connecting %s. Please wait.'), $authorize_name); ?></h4>
    <p>
        <?php echo sprintf(__l('If your browser doesn\'t redirect you please %s to continue.'), $this->Html->link(__l('click here'), $redirect_url, array('escape' => false))); ?>
      </p>
    </div>
</div>
<meta http-equiv="refresh"  content="5;url=<?php echo $redirect_url; ?>" />