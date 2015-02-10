<div class="apks view">
<h2><?php echo __('Apk'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Version'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['version']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['category']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sdkversion'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['sdkversion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Downloads'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['downloads']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Has Extra Data'); ?></dt>
		<dd>
			<?php echo h($apk['Apk']['has_extra_data']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Apk'), array('action' => 'edit', $apk['Apk']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Apk'), array('action' => 'delete', $apk['Apk']['id']), array(), __('Are you sure you want to delete # %s?', $apk['Apk']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Apks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Apk'), array('action' => 'add')); ?> </li>
	</ul>
</div>
