<?php
        /**
        * @link          http://cakephp.org CakePHP(tm) Project
        * @package       app.View.Layouts
        * @since         CakePHP(tm) v 0.10.0.1076
        */

        $cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
        ?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
            echo $this->Html->meta('icon');

            echo $this->fetch('meta');
            echo $this->Html->css('cake.generic');
            echo $this->Html->css('bootstrap');
            echo $this->Html->css('bootstrap-responsive');
            echo $this->Html->css('iconos_glyphicons.css');

            echo $this->Html->css('frontend');
            //echo $this->Html->css('frontend.media.320');
            echo $this->fetch('css');
            echo $this->Html->script('jquery-1.11.0.min');
            echo $this->Html->script('bootstrap.min');
            echo $this->fetch('script');
            ?>
</head>
<body>
<div id="container">
    <header>
        <a href="<?php echo $this->HTML->url(array('controller'=>'applications', 'action' => 'repo'));?>">
            <?php echo $this->Html->image('layout/frontend/logoBanner.png', array('class' => 'logo','alt' => 'SasWeb', 'border' => '0'));?>
        </a>
        <label>Simple Android's Store Beta</label>
    </header>
    <nav>
        <div>
        <?php if($logged_in):?>
            Bienvenido <?php echo $userAutenticated['username']; ?>.
        <?php
                echo $this->Html->link(
                $this->Html->image('layout/setting.png', array('alt' => 'Edit', 'border' => '0')),
                '/users/edit/' . $userAutenticated['id'],  //$this->HTML->url(array('controller'=>'users', 'action' => 'edit', $userAutenticated['id'])),
                array('class' => 'logout','target' => '_parent', 'escape' => false, 'id' => 'logout')
                );
        ?>
        <?php if(isset($userAutenticated['username']))
                echo $this->Html->link(
                $this->Html->image('layout/logout.png', array('alt' => 'logout', 'border' => '0')),
                '/users/logout',  //$this->HTML->url(array('controller'=>'users', 'action' => 'logout')),
                array('class' => 'logout','target' => '_parent', 'escape' => false, 'id' => 'logout')
                );
                ?>

        <?php else:?>
        <?php
                echo $this->Html->link(
                    'Acceso publico',
                    '/users/login',  //$this->HTML->url(array('controller'=>'users', 'action' => 'login')),
                    array()
                );
        ?>
        <?php endif;?>
        </div>
    </nav>
    <div id="content">

        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer">
       <label> Todos los derechos reservados DSI</label>
    </div>
</div>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
