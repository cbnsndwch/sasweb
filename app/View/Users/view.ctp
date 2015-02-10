<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo h($user['User']['role']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hash'); ?></dt>
		<dd>
			<?php echo h($user['User']['hash']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Noticies'), array('controller' => 'noticies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Noticy'), array('controller' => 'noticies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Noticies'); ?></h3>
	<?php if (!empty($user['Noticy'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Body'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Noticy'] as $noticy): ?>
		<tr>
			<td><?php echo $noticy['id']; ?></td>
			<td><?php echo $noticy['title']; ?></td>
			<td><?php echo $noticy['body']; ?></td>
			<td><?php echo $noticy['user_id']; ?></td>
			<td><?php echo $noticy['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'noticies', 'action' => 'view', $noticy['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'noticies', 'action' => 'edit', $noticy['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'noticies', 'action' => 'delete', $noticy['id']), array(), __('Are you sure you want to delete # %s?', $noticy['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Noticy'), array('controller' => 'noticies', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Uploads'); ?></h3>
	<?php if (!empty($user['Upload'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Version'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Category'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Sdkversion'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Have Data'); ?></th>
		<th><?php echo __('Ip'); ?></th>
		<th><?php echo __('Client'); ?></th>
		<th><?php echo __('Icon'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Upload'] as $upload): ?>
		<tr>
			<td><?php echo $upload['id']; ?></td>
			<td><?php echo $upload['name']; ?></td>
			<td><?php echo $upload['label']; ?></td>
			<td><?php echo $upload['version']; ?></td>
			<td><?php echo $upload['code']; ?></td>
			<td><?php echo $upload['category']; ?></td>
			<td><?php echo $upload['description']; ?></td>
			<td><?php echo $upload['sdkversion']; ?></td>
			<td><?php echo $upload['size']; ?></td>
			<td><?php echo $upload['have_data']; ?></td>
			<td><?php echo $upload['ip']; ?></td>
			<td><?php echo $upload['client']; ?></td>
			<td><?php echo $upload['icon']; ?></td>
			<td><?php echo $upload['user_id']; ?></td>
			<td><?php echo $upload['created']; ?></td>
			<td><?php echo $upload['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'uploads', 'action' => 'view', $upload['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'uploads', 'action' => 'edit', $upload['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'uploads', 'action' => 'delete', $upload['id']), array(), __('Are you sure you want to delete # %s?', $upload['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
