<div class="uploads view">
<h2><?php echo __('Upload'); ?></h2>
	<table>
        <tr>
		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($upload['Upload']['id']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($upload['Upload']['name']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Label'); ?></td>
		<td>
			<?php echo h($upload['Upload']['label']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Version'); ?></td>
		<td>
			<?php echo h($upload['Upload']['version']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Code'); ?></td>
		<td>
			<?php echo h($upload['Upload']['code']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Category'); ?></td>
		<td>
			<?php echo h($upload['Upload']['category']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Description'); ?></td>
		<td>
			<?php echo h($upload['Upload']['description']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Sdkversion'); ?></td>
		<td>
			<?php echo h($upload['Upload']['sdkversion']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Size'); ?></td>
		<td>
			<?php echo h($upload['Upload']['size']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Have Data'); ?></td>
		<td>
			<?php echo h($upload['Upload']['have_data']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Ip'); ?></td>
		<td>
			<?php echo h($upload['Upload']['ip']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Client'); ?></td>
		<td>
			<?php echo h($upload['Upload']['client']); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('User'); ?></td>
		<td>
			<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
			&nbsp;
		</td>
        </tr>
        <tr>
		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($upload['Upload']['created']); ?>
			&nbsp;
		</dd>
        </tr>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Upload'), array('action' => 'edit', $upload['Upload']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Upload'), array('action' => 'delete', $upload['Upload']['id']), array(), __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
