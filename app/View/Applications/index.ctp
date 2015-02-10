<div class="applications index">
	<h2><?php echo __('Applications'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
             <th><?php echo 'image'; ?></th>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('version'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
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
	<?php foreach ($applications as $application): ?>
	<tr>
        <td>
            <img width="40px" height="40px" alt="<?php echo h($application['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($application['Application']['id']) . '/' . h($application['Application']['version']) . '/' . h($application['Application']['id']);?>.png" />
        </td>
		<td><?php echo h($application['Application']['id']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['label']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['version']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['code']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['category']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['sdkversion']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['size']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['downloads']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['rating']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['have_data']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['created']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $application['Application']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $application['Application']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $application['Application']['id']), array(), __('Are you sure you want to delete # %s?', $application['Application']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Application'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Versions'), array('controller' => 'versions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Version'), array('controller' => 'versions', 'action' => 'add')); ?> </li>
	</ul>
</div>
