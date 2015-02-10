<div class="applications form">
<?php echo $this->Form->create('Application'); ?>
	<fieldset>
		<legend><?php echo __('Add Application'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Applications'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Versions'), array('controller' => 'versions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Version'), array('controller' => 'versions', 'action' => 'add')); ?> </li>
	</ul>
</div>
