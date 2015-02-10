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
            echo $this->Html->css('bootstrap-responsive');
            echo $this->Html->css('iconos_glyphicons.css');

            echo $this->Html->css('frontend');
            echo $this->Html->css('frontend.media.320');

            echo $this->fetch('css');

            echo $this->Html->script('jquery-1.11.0.min');
            echo $this->Html->script('bootstrap.min');

            echo $this->fetch('script');
            ?>
</head>
<body>
<div id="container">
    <header class="large" style="display: none;">
        <a href="<?php echo $this->HTML->url(array('controller'=>'apks', 'action' => 'repo'));?>">
            <?php echo $this->Html->image('layout/frontend/logoBanner.png', array('class' => 'logo','alt' => 'SasWeb', 'border' => '0'));?>
        </a>
        <div class="user_space">
            <?php echo $this->Html->image('layout/User.png', array('class' => 'user_avatar', 'alt' => 'avatar', 'border' => '1'));?>

            <span class="user">
                <?php
                        if(isset($userAutenticated['username']))
                            echo $userAutenticated['username'];
                        else{
                        echo $this->Html->link(
                        'Acceso publico',
                        $this->HTML->url(array('controller'=>'users', 'action' => 'login')),
                        array()
                        );

                        }

                 ?>

            </span>
            <div class="cleared"></div>

            <?php
                    if(isset($userAutenticated['username']))
                    echo $this->Html->link(
                    $this->Html->image('layout/setting.png', array('alt' => 'Edit', 'border' => '0')),
                    $this->HTML->url(array('controller'=>'users', 'action' => 'edit', $userAutenticated['id'])),
                    array('class' => 'logout','target' => '_parent', 'escape' => false, 'id' => 'logout')
                    );
                    ?>
            <?php if(isset($userAutenticated['username']))
                    echo $this->Html->link(
                    $this->Html->image('layout/logout.png', array('alt' => 'logout', 'border' => '0')),
                    $this->HTML->url(array('controller'=>'users', 'action' => 'logout')),
                    array('class' => 'logout','target' => '_parent', 'escape' => false, 'id' => 'logout')
                    );
                    ?>
        </div>
        <label>Simple Android's Store Beta</label>

    </header>

    <div class="clearfix"></div>
    <div id="content">
        <div>
            <?php
                    echo $this->Session->flash();
                    echo $this->Session->flash('auth');?>
        </div>
        <div class="cleared"></div>
        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer" class="navbar-fixed-bottom">
        <?php echo 'Sasweb todos los derechos reservados 2014' ?>
    </div>
</div>
<?php //echo $this->element('sql_dump'); ?>

<script type="text/javascript">
    $(document).on("scroll",function(){
        //if($(document).scrollTop()>=100){
        //    $("header").removeClass("large").addClass("small");
        //} else{
        //    $("header").removeClass("small").addClass("large");
        //}
        //$(document).scrollTop(100);
    });
</script>
</body>
</html>
