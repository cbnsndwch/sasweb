<div class="data form">
<?php echo $this->Form->create('Data'); ?>
	<fieldset>
		<legend><?php echo __('Edit Data'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('application_id');
		echo $this->Form->input('verificate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Data.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Data.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Data'), array('action' => 'index')); ?></li>
	</ul>
</div>
