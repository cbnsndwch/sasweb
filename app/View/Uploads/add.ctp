<div class="uploads form">
<?php echo $this->Form->create('Upload'); ?>
	<fieldset>
		<legend><?php echo __('Add Upload'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('label');
		echo $this->Form->input('version');
		echo $this->Form->input('code');
		echo $this->Form->input('category');
		echo $this->Form->input('description');
		echo $this->Form->input('sdkversion');
		echo $this->Form->input('size');
		echo $this->Form->input('have_data');
		echo $this->Form->input('ip');
		echo $this->Form->input('client');
		echo $this->Form->input('icon');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Uploads'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
