<div class="versions view">
<h2><?php echo __('Version'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($version['Version']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Application'); ?></dt>
		<dd>
			<?php echo $this->Html->link($version['Application']['id'], array('controller' => 'applications', 'action' => 'view', $version['Application']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($version['Version']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Version'); ?></dt>
		<dd>
			<?php echo h($version['Version']['version']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($version['Version']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo h($version['Version']['category']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($version['Version']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sdkversion'); ?></dt>
		<dd>
			<?php echo h($version['Version']['sdkversion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($version['Version']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Downloads'); ?></dt>
		<dd>
			<?php echo h($version['Version']['downloads']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rating'); ?></dt>
		<dd>
			<?php echo h($version['Version']['rating']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Have Data'); ?></dt>
		<dd>
			<?php echo h($version['Version']['have_data']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($version['Version']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($version['Version']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Version'), array('action' => 'edit', $version['Version']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Version'), array('action' => 'delete', $version['Version']['id']), array(), __('Are you sure you want to delete # %s?', $version['Version']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Versions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Version'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
