<div class="generalcoments form">
<?php echo $this->Form->create('Generalcoment'); ?>
	<fieldset>
		<legend><?php echo __('Edit Generalcoment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('coment');
		echo $this->Form->input('ip');
		echo $this->Form->input('client');
		echo $this->Form->input('usertag');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Generalcoment.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Generalcoment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Generalcoments'), array('action' => 'index')); ?></li>
	</ul>
</div>
