<div class="coments view">
<h2><?php echo __('Coment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($coment['User']['username'], array('controller' => 'users', 'action' => 'view', $coment['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Application'); ?></dt>
		<dd>
			<?php echo $this->Html->link($coment['Application']['id'], array('controller' => 'applications', 'action' => 'view', $coment['Application']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coment'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['coment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visible'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['visible']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($coment['Coment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Coment'), array('action' => 'edit', $coment['Coment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Coment'), array('action' => 'delete', $coment['Coment']['id']), array(), __('Are you sure you want to delete # %s?', $coment['Coment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Coments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Coment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
