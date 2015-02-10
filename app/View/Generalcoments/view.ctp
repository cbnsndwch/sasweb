<div class="generalcoments view">
<h2><?php echo __('Generalcoment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coment'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['coment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['client']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usertag'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['usertag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($generalcoment['Generalcoment']['email']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Generalcoment'), array('action' => 'edit', $generalcoment['Generalcoment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Generalcoment'), array('action' => 'delete', $generalcoment['Generalcoment']['id']), array(), __('Are you sure you want to delete # %s?', $generalcoment['Generalcoment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Generalcoments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Generalcoment'), array('action' => 'add')); ?> </li>
	</ul>
</div>
