<div class="categories view">
<h2><?php echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), array(), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Applications'); ?></h3>
	<?php if (!empty($category['Application'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Version'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Category'); ?></th>
		<th><?php echo __('Categories Id'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Sdkversion'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Downloads'); ?></th>
		<th><?php echo __('Rating'); ?></th>
		<th><?php echo __('Have Data'); ?></th>
		<th><?php echo __('Verificate'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Only Logged'); ?></th>
		<th><?php echo __('Recommended'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['Application'] as $application): ?>
		<tr>
			<td><?php echo $application['id']; ?></td>
			<td><?php echo $application['label']; ?></td>
			<td><?php echo $application['version']; ?></td>
			<td><?php echo $application['code']; ?></td>
			<td><?php echo $application['category']; ?></td>
			<td><?php echo $application['categories_id']; ?></td>
			<td><?php echo $application['description']; ?></td>
			<td><?php echo $application['sdkversion']; ?></td>
			<td><?php echo $application['size']; ?></td>
			<td><?php echo $application['downloads']; ?></td>
			<td><?php echo $application['rating']; ?></td>
			<td><?php echo $application['have_data']; ?></td>
			<td><?php echo $application['verificate']; ?></td>
			<td><?php echo $application['created']; ?></td>
			<td><?php echo $application['modified']; ?></td>
			<td><?php echo $application['only_logged']; ?></td>
			<td><?php echo $application['recommended']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'applications', 'action' => 'view', $application['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'applications', 'action' => 'edit', $application['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'applications', 'action' => 'delete', $application['id']), array(), __('Are you sure you want to delete # %s?', $application['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
