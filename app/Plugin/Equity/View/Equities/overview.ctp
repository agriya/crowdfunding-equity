<div class="accordion-group">
  <div class="accordion-heading clearfix">
  <h3> <?php echo __l("Overview");?> </h3>
  </div>
  <div class="accordion-inner">
  <table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
    <th >&nbsp;</th>
    <?php foreach($periods as $key => $period){ ?>
    <th> <?php echo $period['display'].' ('.Configure::read('site.currency').')'; ?> </th>
    <?php } ?>
    </tr>
    <?php
      foreach($models as $unique_model){ ?>
    <?php foreach($unique_model as $model => $fields){
          $aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
        ?>
    <tr>
    <td><?php echo $fields['display']; ?> </td>
    <?php foreach($periods as $key => $period){ ?>
    <td><span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
      <?php
                        if(empty($fields['type'])) {
                          $fields['type'] = 'cCurrency';
                        }

                          echo $this->Html->{$fields['type']}(${$aliasName.$key});
                      ?>
      </span> </td>
    <?php } ?>
    </tr>
    <?php } ?>
    <?php } ?>
  </table>
  </div>
</div>
