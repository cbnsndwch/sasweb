<div class="users form">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Por favor introduzca sus credenciales'); ?>
        </legend>
        <?php echo $this->Form->input('username', array('label' => 'Usuario'));
                echo $this->Form->input('password', array('label' => 'Clave'));
                ?>
    </fieldset>
    <?php echo $this->Form->end(__('Entrar')); ?>
</div>