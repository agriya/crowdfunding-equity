<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
    <th >&nbsp;</th>
    <?php foreach($periods as $key => $period){ ?>
    <th>
      <?php echo $this->Html->cText($period['display'], false).' ('.Configure::read('site.currency').')'; ?>
    </th>
    <?php } ?>
    </tr>
    <?php
    foreach($models as $unique_model){ ?>
    <?php foreach($unique_model as $model => $fields){
      $aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
      if($fields['alias'] != 'PipelineReverse'):
    ?>
      <tr>
        <td>
        <?php echo $this->Html->cText($fields['display'], false); ?>
        </td>

        <?php foreach($periods as $key => $period){ ?>
          <td>
          <span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
            <?php
            if(empty($fields['type'])) {
              $fields['type'] = 'cCurrency';
            }
if($fields['alias'] == 'Pipeline')
{
  echo $total_val = ${"Pipeline".$key} - ${"PipelineReverse".$key};
}
else
{
              echo $this->Html->{$fields['type']}(${$aliasName.$key});
}
            ?>
          </span>
          </td>
        <?php } ?>
        </tr>

     <?php endif; } ?>
    <?php } ?>


    </table>
