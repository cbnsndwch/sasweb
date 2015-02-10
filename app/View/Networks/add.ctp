<div class="networks form">
<?php echo $this->Form->create('Network'); ?>
	<fieldset>
		<legend><?php echo __('Add Network'); ?></legend>
	<?php
		
		echo $this->Form->input('area', array('value' => '10.8.'));
		echo $this->Form->input('rango', array('value' => ''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Networks'), array('action' => 'index')); ?></li>
	</ul>
</div>
