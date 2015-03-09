<div class="coments index">
	<h2><?php echo __('Coments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('users_id'); ?></th>
			<th><?php echo $this->Paginator->sort('applications_id'); ?></th>
			<th><?php echo $this->Paginator->sort('coment'); ?></th>
			<th><?php echo $this->Paginator->sort('ip'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('visible'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($coments as $coment): ?>
	<tr>
		<td><?php echo h($coment['Coment']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($coment['User']['username'], array('controller' => 'users', 'action' => 'view', $coment['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($coment['Application']['id'], array('controller' => 'applications', 'action' => 'view', $coment['Application']['id'])); ?>
		</td>
		<td><?php echo h($coment['Coment']['coment']); ?>&nbsp;</td>
		<td><?php echo h($coment['Coment']['ip']); ?>&nbsp;</td>
		<td><?php echo h($coment['Coment']['created']); ?>&nbsp;</td>
		<td><?php echo h($coment['Coment']['visible']); ?>&nbsp;</td>
		<td><?php echo h($coment['Coment']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $coment['Coment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coment['Coment']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coment['Coment']['id']), array(), __('Are you sure you want to delete # %s?', $coment['Coment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Coment'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
