<div class="versions index">
	<h2><?php echo __('Versions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('application_id'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('version'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('sdkversion'); ?></th>
			<th><?php echo $this->Paginator->sort('size'); ?></th>
			<th><?php echo $this->Paginator->sort('downloads'); ?></th>
			<th><?php echo $this->Paginator->sort('rating'); ?></th>
			<th><?php echo $this->Paginator->sort('have_data'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($versions as $version): ?>
	<tr>
		<td><?php echo h($version['Version']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($version['Application']['id'], array('controller' => 'applications', 'action' => 'view', $version['Application']['id'])); ?>
		</td>
		<td><?php echo h($version['Version']['label']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['version']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['code']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['category']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['description']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['sdkversion']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['size']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['downloads']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['rating']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['have_data']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['created']); ?>&nbsp;</td>
		<td><?php echo h($version['Version']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $version['Version']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $version['Version']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $version['Version']['id']), array(), __('Are you sure you want to delete # %s?', $version['Version']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Version'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
