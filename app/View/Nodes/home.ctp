<div class="home-center">
  <h2>
    <?php echo __l('Plenty of creative minds, many solutions, Graphic design, Industrial design and many more ...');?>
  </h2>
  <div class="clearfix">
    <ul class="list-unstyled">
      <?php echo $this->Layout->blocks('nodehome'); ?>
    </ul>
    <?php echo $this->Html->link(__l('How it Works'), array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('class'=>'how-it-work','escape' => false));?>
  </div>
</div>
<div class="home-description-block">
  <ol class="list-unstyled">
    <li>
      <h3> <?php echo __l('Step1');?></h3>
      <p><?php echo __l('Client creates a contest for particular design and submits brief.');?></p>
      <p class="clearfix">
        <?php echo $this->Html->link(__l('Tell me more'), array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('class'=>'btn pull-right', 'escape' => false));?>
      </p>
    </li>
    <li>
      <h3> <?php echo __l('Step2');?></h3>
      <p><?php echo __l('Designers submit the designs to particular contest. Client gives feedback and rates the designs');?></p>
      <p class="clearfix">
        <?php echo $this->Html->link(__l('Tell me more'), array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('class'=>'btn pull-right', 'escape' => false));?>
      </p>
    </li>
    <li>
      <h3> <?php echo __l('Step3');?></h3>
      <p><?php echo __l('Submission closes. Client reviews highest rated designs. Designers can vote for one design per contest, other than their own design.');?></p>
      <p class="clearfix">
        <?php echo $this->Html->link(__l('Tell me more'), array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('class'=>'btn pull-right', 'escape' => false));?>
      </p>
    </li>
    <li>
      <h3> <?php echo __l('Step4');?></h3>
      <p><?php echo __l('Client chooses winning entry. Designer gets awarded.');?></p>
      <p class="clearfix">
        <?php echo $this->Html->link(__l('Tell me more'), array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('class'=>'btn pull-right', 'escape' => false));?>
      </p>
    </li>
  </ol>
</div>

