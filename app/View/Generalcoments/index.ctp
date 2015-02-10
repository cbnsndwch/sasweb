<div class="generalcoments index">
	<h2><?php echo __('Generalcoments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('coment'); ?></th>
			<th><?php echo $this->Paginator->sort('ip'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('client'); ?></th>
			<th><?php echo $this->Paginator->sort('usertag'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($generalcoments as $generalcoment): ?>
	<tr>
		<td><?php echo h($generalcoment['Generalcoment']['id']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['coment']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['ip']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['created']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['client']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['usertag']); ?>&nbsp;</td>
		<td><?php echo h($generalcoment['Generalcoment']['email']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $generalcoment['Generalcoment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $generalcoment['Generalcoment']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $generalcoment['Generalcoment']['id']), array(), __('Are you sure you want to delete # %s?', $generalcoment['Generalcoment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Generalcoment'), array('action' => 'add')); ?></li>
	</ul>
</div>
