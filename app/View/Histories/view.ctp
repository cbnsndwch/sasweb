<div class="histories view">
<h2><?php echo __('History'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($history['History']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($history['History']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($history['History']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo h($history['History']['client']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($history['History']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit History'), array('action' => 'edit', $history['History']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete History'), array('action' => 'delete', $history['History']['id']), array(), __('Are you sure you want to delete # %s?', $history['History']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Histories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New History'), array('action' => 'add')); ?> </li>
	</ul>
</div>
