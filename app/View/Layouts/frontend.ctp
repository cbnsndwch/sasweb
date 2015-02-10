<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->fetch('meta');
echo $this->Html->css('cake.generic');
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('iconos_glyphicons.css');
        echo $this->Html->css('frontend');
        echo $this->fetch('css');

        echo $this->Html->script('jquery-1.11.0.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->css('frontend');
        echo $this->fetch('script');
        ?>
</head>
<body>
<div id="container">
    <div id="header">
        <h3>Beta del repositorio web de aplicaciones android</h3>
        <?php echo 'Usuario autenticado: ' . $userAutenticated['username']; ?>
        <?php echo $this->Html->link(
                $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
                $this->HTML->url(array('controller'=>'users', 'action' => 'logout')),
                array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                );
                ?>
    </div>
    <div class="cleared"></div>
    <div>
        <?php echo $this->Session->flash();
                echo 'sssss';
                echo $this->Session->flash('auth');?>
    </div>
    <div class="cleared"></div>
    <div id="content">
            <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer" class="navbar-fixed-bottom">
        <?php echo 'Sasweb todos los derechos reservados 2014' ?>
    </div>
</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>