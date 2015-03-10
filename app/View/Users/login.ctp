<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo $this->Html->charset(); ?>
    <title>
        Entrada SAS
    </title>
    <meta name="description" content="Bootstrap Metro Dashboard"/>
    <meta name="author" content="Carlos Henry Cespedes"/>
    <meta name="keyword" content="SAS, SASWEB, Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Mobile Specific -->
    <?php
            echo $this->Html->meta('icon');

        echo $this->fetch('meta');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-responsive.min');
        echo $this->Html->css('sas');
        echo $this->Html->css('style');
        echo $this->Html->css('style-responsive');
        
        echo $this->fetch('css');
        // echo $this->Html->script('jquery-1.11.0.min');
        // echo $this->Html->script('jquery-migrate-1.0.0.min');
        // echo $this->Html->script('jquery-ui-1.10.0.custom.min');
        // echo $this->Html->script('jquery.ui.touch-punch');
        // echo $this->Html->script('modernizr');
        // echo $this->Html->script('bootstrap.min');
        // echo $this->Html->script('jquery.cookie');
        // echo $this->Html->script('fullcalendar.min');
        // echo $this->Html->script('jquery.dataTables.min');
        // echo $this->Html->script('excanvas');
        // echo $this->Html->script('jquery.flot');
        // echo $this->Html->script('jquery.flot.pie');
        // echo $this->Html->script('jquery.flot.stack');
        // echo $this->Html->script('jquery.flot.resize.min');
        // echo $this->Html->script('jquery.chosen.min');
        // echo $this->Html->script('jquery.uniform.min');
        // echo $this->Html->script('jquery.cleditor.min');
        // echo $this->Html->script('jquery.noty');
        // echo $this->Html->script('jquery.elfinder.min');
        // echo $this->Html->script('jquery.raty.min');
        // echo $this->Html->script('jquery.iphone.toggle');
        // echo $this->Html->script('jquery.uploadify-3.1.min');
        // echo $this->Html->script('jquery.gritter.min');
        // echo $this->Html->script('jquery.gritter.min');
        // echo $this->Html->script('jquery.imagesloaded');
        // echo $this->Html->script('jquery.masonry.min');
        // echo $this->Html->script('jquery.knob.modified');
        // echo $this->Html->script('jquery.sparkline.min');
        // echo $this->Html->script('counter');
        // echo $this->Html->script('retina');
        // echo $this->Html->script('custom');



        // echo $this->fetch('script');
    ?>
<style type="text/css">
            body { background: url(<?php echo $_SERVER['CONTEXT_PREFIX'];?>/img/bg-login.jpg) !important; }
        </style>


</head>

<body>


<div class="container-fluid-full">
                    
            <div class="row-fluid">
                <div class="login-box">
                    <div class="icons">
                        <a href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>"><i class="halflings-icon home"></i></a>
                        <!-- <a href="#"><i class="halflings-icon cog"></i></a> -->
                    </div>
                    <h2>El acceso es solo para administrador y colaboradores</h2>
                    <h3><?php echo $this->Session->flash('auth'); ?></h3>
                    <form class="form-horizontal"  id="UserLoginForm" accept-charset="utf-8" action="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/users/login" method="post">
                        <div style="display:none;">
                        <input type="hidden" value="POST" name="_method">
                        </div>
                        <fieldset>                            
                            <div class="input-prepend" title="Username">
                                <span class="add-on"><i class="halflings-icon user"></i></span>
                                <input class="input-large span10" name="data[User][username]" id="UserUsername" type="text" placeholder="introduce el usuario"/>
                            </div>
                            <div class="clearfix"></div>

                            <div class="input-prepend" title="Password">
                                <span class="add-on"><i class="halflings-icon lock"></i></span>
                                <input class="input-large span10" name="data[User][password]" id="UserPassword" type="password" placeholder="introduce la clave"/>
                            </div>
                            <div class="clearfix"></div>
                            
                            <!-- <label class="remember" for="remember"><input type="checkbox" id="remember" />Recuerdame</label> -->

                            <div class="button-login">  
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                            <div class="clearfix"></div>
                    </form>
                    <!-- <hr> -->
                    <!-- <h3>Forgot Password?</h3>
                    <p>
                        No problem, <a href="#">click here</a> to get a new password.
                    </p>   -->  
                </div><!--/span-->
            </div><!--/row-->
            

    </div><!--/.fluid-container-->
    
        </div><!--/fluid-row-->







<?php
echo $this->Html->script('jquery-1.9.1.min');
        echo $this->Html->script('jquery-migrate-1.0.0.min');
        echo $this->Html->script('jquery-ui-1.10.0.custom.min');
        echo $this->Html->script('jquery.ui.touch-punch');
        echo $this->Html->script('modernizr');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('jquery.cookie');
        echo $this->Html->script('fullcalendar.min');
        echo $this->Html->script('jquery.dataTables.min');
        echo $this->Html->script('excanvas');
        echo $this->Html->script('jquery.flot');
        echo $this->Html->script('jquery.flot.pie');
        echo $this->Html->script('jquery.flot.stack');
        echo $this->Html->script('jquery.flot.resize.min');
        echo $this->Html->script('jquery.chosen.min');
        echo $this->Html->script('jquery.uniform.min');
        echo $this->Html->script('jquery.cleditor.min');
        echo $this->Html->script('jquery.noty');
        echo $this->Html->script('jquery.elfinder.min');
        echo $this->Html->script('jquery.raty.min');
        echo $this->Html->script('jquery.iphone.toggle');
        echo $this->Html->script('jquery.uploadify-3.1.min');
        echo $this->Html->script('jquery.gritter.min');
        echo $this->Html->script('jquery.gritter.min');
        echo $this->Html->script('jquery.imagesloaded');
        echo $this->Html->script('jquery.masonry.min');
        echo $this->Html->script('jquery.knob.modified');
        echo $this->Html->script('jquery.sparkline.min');
        echo $this->Html->script('counter');
        echo $this->Html->script('retina');
        echo $this->Html->script('custom');



        echo $this->fetch('script');
    ?>
</body>

</html>