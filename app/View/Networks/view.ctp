<div class="networks view">
<h2><?php echo __('Network'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($network['Network']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Area'); ?></dt>
		<dd>
			<?php echo h($network['Network']['area']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rango'); ?></dt>
		<dd>
			<?php echo h($network['Network']['rango']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Network'), array('action' => 'edit', $network['Network']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Network'), array('action' => 'delete', $network['Network']['id']), array(), __('Are you sure you want to delete # %s?', $network['Network']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Networks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Network'), array('action' => 'add')); ?> </li>
	</ul>
</div>
