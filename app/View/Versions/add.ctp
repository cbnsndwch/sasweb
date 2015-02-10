<div class="versions form">
<?php echo $this->Form->create('Version'); ?>
	<fieldset>
		<legend><?php echo __('Add Version'); ?></legend>
	<?php
		echo $this->Form->input('application_id');
		echo $this->Form->input('label');
		echo $this->Form->input('version');
		echo $this->Form->input('code');
		echo $this->Form->input('category');
		echo $this->Form->input('description');
		echo $this->Form->input('sdkversion');
		echo $this->Form->input('size');
		echo $this->Form->input('downloads');
		echo $this->Form->input('rating');
		echo $this->Form->input('have_data');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Versions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
