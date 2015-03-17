
<div>
<?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo __('Cambiar password'); ?></legend>

		<?php echo $this->Form->input('password', array(
			'div' => 'control-group',
			'label' => array(
				'class' => 'control-label',
				'text' => 'Clave: '
				),
			'between' => '<div class="controls">',
			'after' => '</div>',

		)); ?>
		<?php echo $this->Form->input('password_confirmation', array(
			'type' =>  'password',
			'div' => 'control-group',
			'label' => array(
				'class' => 'control-label',
				'text' => 'Confirmar: '
				),
			'between' => '<div class="controls">',
			'after' => '</div>',
		)); ?>

		 <div class="form-actions">
            <button class="btn btn-primary" type="submit">Cambiar</button>
            <button class="btn" type="reset">Reiniciar</button>
        </div>
	</fieldset>
<?php echo $this->Form->end(); ?>

