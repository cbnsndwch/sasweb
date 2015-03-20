
<div class="row-fluid" >
        <div class="col-lg-10">
            <h2 class="page-header"><?php echo __('Subidas'); ?></h2>
        </div>        
    </div>
     <hr/>

<div class="row-fluid" >
	<table class="table table-condensed table-striped">
	<thead>
	<tr>
            <th><?php echo 'image'; ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
            <th><?php echo $this->Paginator->sort('version'); ?></th>
			<th><?php echo $this->Paginator->sort('category'); ?></th>
			<th><?php echo $this->Paginator->sort('client'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($uploads as $upload): ?>
	<tr>
        <td>
            <img width="40px" height="40px" alt="<?php echo h($upload['Upload']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/poolUpload/<?php echo h($upload['Upload']['name']) . '/' . h($upload['Upload']['version']) . '/' . h($upload['Upload']['name']);?>.png" />
        </td>
		<td><?php echo h($upload['Upload']['label']); ?>&nbsp;</td>
		<td><?php echo h($upload['Upload']['code']); ?>&nbsp;</td>
        <td><?php echo h($upload['Upload']['version']); ?>&nbsp;</td>
		<td><?php echo h($upload['Category']['name']); ?>&nbsp;</td>
		<td><?php echo h($upload['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($upload['User']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
		</td>
		<td class="actions">
            <?php echo $this->Html->link(__('Agregar'), array('action' => 'update', $upload['Upload']['id']), array('class' => 'btn')); ?>
            <?php echo $this->Html->link(__('Descargar'), array('action' => 'view', $upload['Upload']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $upload['Upload']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $upload['Upload']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $upload['Upload']['id']), array('class' => 'btn'), __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Upload'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
