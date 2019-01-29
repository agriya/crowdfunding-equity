<?php
$class = '';
if (strlen($project['Project']['name']) > 40) {
	$class .= ' title-double-line';
}
?>
<div>
<section data-offset-top="10" data-spy="" class=" row <?php echo $class; ?>">
  <div class="row">
  <div class="payment-img"> <?php echo $this->Html->link($this->Html->showImage('Project', $project['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($project['Project']['name'], false)), 'title' => $this->Html->cText($project['Project']['name'], false), 'class' => 'js-tooltip'),array('aspect_ratio'=>1)), array('controller' => 'projects', 'action' => 'view',  $project['Project']['slug'], 'admin' => false), array('escape' => false)); ?> </div>
  <div class="col-md-7 pull-left">
  <h3><?php echo $this->Html->link($this->Html->filterSuspiciousWords($this->Html->cText($project['Project']['name'], false), $project['Project']['detected_suspicious_words']), array('controller' => 'projects', 'action' => 'view', $project['Project']['slug']), array('escape' => false));?></h3>
  <p> <?php echo __l('A') . ' '; ?>
    <?php
    $response = Cms::dispatchEvent('View.Project.displaycategory', $this, array(
    'data' => $project
    ));
    if (!empty($response->data['content'])) {
    echo $response->data['content'];
    }
  ?>
    <?php echo sprintf(__l('%s in '), Configure::read('project.alt_name_for_project_singular_small')) . ' '; ?>
    <?php
    if (!empty($project['City']['name'])) {
    echo $this->Html->cText($project['City']['name'], false) . ', ';
    }
    if (!empty($project['Country']['name'])) {
    echo $this->Html->cText($project['Country']['name'], false);
    }
  ?>
    <?php echo __l(' by '); ?><?php echo $this->Html->link($this->Html->cText($project['User']['username']), array('controller' => 'users', 'action' => 'view', $project['User']['username']), array('escape' => false));?>

  </p>
  </div>
  </div>
  </section>
</div>
<div class="JobsAct form equity">
  <div class="img-thumbnail"><h4 class="text-center"><?php echo __l('Jumpstart Our Business Startups (JOBS) Compliance'); ?></h4>
	<p class="text-center"><?php echo __l('Before pledging project, check your compliance whether you are an accredited/non-accredited investor under US JOBS Act.'); ?></p>
  </div>
</div>
<div class="equity">
  <?php echo $this->Form->create('JobsActEntry', array('class' => 'form-horizontal')); ?>
  <div>
	<div class="img-thumbnail clearfix">
	  <div class="pull-left">
		<div class="alert alert-warning clearfix"><?php echo __l('Please enter with care, you can\'t update these details later. This is one-time-process.'); ?></div>
        <?php
	    echo $this->Form->input('net_worth', array('label' => __l('Net worth').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('annual_income_individual', array('info'=>__l('Annual income without including any income of the Investor`s spouse'), 'label' => __l('Annual Income Individual').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('annual_income_with_spouse', array('info'=>__l('Annual income including income of the Investor`s spouse'), 'label' => __l('Annual Income with Spouse').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('total_asset', array('label' => __l('Total Asset').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('household_income', array('info'=>__l('Total income from all people living in Investor\'s household'), 'label' => __l('Household Income ('.Configure::read('site.currency').')')));
	    echo $this->Form->input('annual_expenses', array('label' => __l('Annual Expenses').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('liquid_net_worth', array('label' => __l('Liquid Net Worth').' ('.Configure::read('site.currency').')'));
	    echo $this->Form->input('number_of_dependents',array('label' => __l('Number of Dependants')));
	    echo $this->Form->input('project_id', array('type' => 'hidden', 'value' => $this->request->params['named']['project_id']));
	    ?>
	  </div>
	  <div class="well pull-right col-md-3">
		<h5><?php echo __l('JOBS Act'); ?></h5>
		<p><?php echo __l('As an invetment platform, we are required to verify your accredition status. Provide information and confirm your accredition status to help us stay within US regulations'); ?></p>
		<p><a href="http://en.wikipedia.org/wiki/Jumpstart_Our_Business_Startups_Act" target="_blank"><?php echo __l('Read more....'); ?></a></p>
	   </div>
	   </div>
	   </div>
	       <div class="clearfix">
      <div class="well form-actions">
        <div class="offset3">
	  <?php  echo $this->Form->submit(__l('Submit'), array('class' => 'btn-primary')); ?>
    </div>
	</div>
    <?php echo $this->Form->end(); ?>
	</div>
  </div>