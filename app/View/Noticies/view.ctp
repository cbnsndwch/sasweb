<div class="noticies view">
<h2><?php echo __('Noticy'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($noticy['Noticy']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($noticy['Noticy']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body'); ?></dt>
		<dd>
			<?php echo h($noticy['Noticy']['body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($noticy['User']['username'], array('controller' => 'users', 'action' => 'view', $noticy['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($noticy['Noticy']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Noticy'), array('action' => 'edit', $noticy['Noticy']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Noticy'), array('action' => 'delete', $noticy['Noticy']['id']), array(), __('Are you sure you want to delete # %s?', $noticy['Noticy']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Noticies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Noticy'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
