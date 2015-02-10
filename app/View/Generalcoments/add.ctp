<div class="generalcoments form">
<?php echo $this->Form->create('Generalcoment'); ?>
	<fieldset>
		<legend><?php echo __('Add Generalcoment'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Generalcoments'), array('action' => 'index')); ?></li>
	</ul>
</div>
