<div class="applications view">
<h2><?php echo __('Application'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($application['Application']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($application['Application']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Version'); ?></dt>
		<dd>
			<?php echo h($application['Application']['version']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($application['Application']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo h($application['Application']['category']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($application['Application']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sdkversion'); ?></dt>
		<dd>
			<?php echo h($application['Application']['sdkversion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($application['Application']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Downloads'); ?></dt>
		<dd>
			<?php echo h($application['Application']['downloads']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rating'); ?></dt>
		<dd>
			<?php echo h($application['Application']['rating']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Have Data'); ?></dt>
		<dd>
			<?php echo h($application['Application']['have_data']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($application['Application']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($application['Application']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Application'), array('action' => 'edit', $application['Application']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Application'), array('action' => 'delete', $application['Application']['id']), array(), __('Are you sure you want to delete # %s?', $application['Application']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Versions'), array('controller' => 'versions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Version'), array('controller' => 'versions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Versions'); ?></h3>
	<?php if (!empty($application['Version'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Application Id'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Version'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Category'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Sdkversion'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Downloads'); ?></th>
		<th><?php echo __('Rating'); ?></th>
		<th><?php echo __('Have Data'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($application['Version'] as $version): ?>
		<tr>
			<td><?php echo $version['id']; ?></td>
			<td><?php echo $version['application_id']; ?></td>
			<td><?php echo $version['label']; ?></td>
			<td><?php echo $version['version']; ?></td>
			<td><?php echo $version['code']; ?></td>
			<td><?php echo $version['category']; ?></td>
			<td><?php echo $version['description']; ?></td>
			<td><?php echo $version['sdkversion']; ?></td>
			<td><?php echo $version['size']; ?></td>
			<td><?php echo $version['downloads']; ?></td>
			<td><?php echo $version['rating']; ?></td>
			<td><?php echo $version['have_data']; ?></td>
			<td><?php echo $version['created']; ?></td>
			<td><?php echo $version['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'versions', 'action' => 'view', $version['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'versions', 'action' => 'edit', $version['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'versions', 'action' => 'delete', $version['id']), array(), __('Are you sure you want to delete # %s?', $version['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Version'), array('controller' => 'versions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
