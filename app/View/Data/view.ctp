<div class="data view">
<h2><?php echo __('Data'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($data['Data']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($data['Data']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($data['Data']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Application Id'); ?></dt>
		<dd>
			<?php echo h($data['Data']['application_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Verificate'); ?></dt>
		<dd>
			<?php echo h($data['Data']['verificate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($data['Data']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($data['Data']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Data'), array('action' => 'edit', $data['Data']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Data'), array('action' => 'delete', $data['Data']['id']), array(), __('Are you sure you want to delete # %s?', $data['Data']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Data'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Data'), array('action' => 'add')); ?> </li>
	</ul>
</div>
