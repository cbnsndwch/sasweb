<div class="apks index">
	<h2><?php echo __('Apks'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('version'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
			<th><?php echo $this->Paginator->sort('sdkversion'); ?></th>
			<th><?php echo $this->Paginator->sort('size'); ?></th>
			<th><?php echo $this->Paginator->sort('downloads'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($apks as $apk): ?>
	<tr>
		<td><?php echo h($apk['Apk']['id']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['label']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['version']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['code']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['description']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['category']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['sdkversion']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['size']); ?>&nbsp;</td>
		<td><?php echo h($apk['Apk']['downloads']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $apk['Apk']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $apk['Apk']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $apk['Apk']['id']), array(), __('Are you sure you want to delete # %s?', $apk['Apk']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Apk'), array('action' => 'add')); ?></li>
	</ul>
</div>
