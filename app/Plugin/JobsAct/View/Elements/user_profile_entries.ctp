<fieldset  class="form-block">
	<legend><?php echo __l('JOBS Act'); ?></legend>
	<div class="clearfix">
        <?php echo $this->Form->input('JobsActEntry.net_worth', array('label' => __l('Net Worth').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['net_worth']));
        echo $this->Form->input('JobsActEntry.annual_income_individual', array('label' => __l('Individual Annual Income').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['annual_income_individual']));
        echo $this->Form->input('JobsActEntry.annual_income_with_spouse', array('label' => __l('Annual Income with Spouse').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['annual_income_with_spouse']));
        echo $this->Form->input('JobsActEntry.total_asset', array('label' => __l('Total Asset').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['total_asset']));
		echo $this->Form->input('JobsActEntry.household_income', array('label' => __l('Household Income').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['household_income']));
        echo $this->Form->input('JobsActEntry.annual_expenses', array('label' => __l('Annual Expenses').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['annual_expenses']));
        echo $this->Form->input('JobsActEntry.liquid_net_worth', array('label' => __l('Liquid Networth').' ('.Configure::read('site.currency').')', 'value' => $jobs['JobsActEntry']['liquid_net_worth']));
		echo $this->Form->input('JobsActEntry.number_of_dependents', array('label' => __l('Number of Dependencies'), 'value' => $jobs['JobsActEntry']['number_of_dependents'])); ?>
    </div>
</fieldset>