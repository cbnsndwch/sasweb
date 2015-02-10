<div class="apks form">
<?php echo $this->Form->create('Apk'); ?>
	<fieldset>
		<legend><?php echo __('Add Apk'); ?></legend>
	<?php
		echo $this->Form->input('label');
		echo $this->Form->input('version');
		echo $this->Form->input('code');
		echo $this->Form->input('description');
		echo $this->Form->input('category');
		echo $this->Form->input('sdkversion');
		echo $this->Form->input('size');
		echo $this->Form->input('downloads');
		echo $this->Form->input('has_extra_data');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Apks'), array('action' => 'index')); ?></li>
	</ul>
</div>
