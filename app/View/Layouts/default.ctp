<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
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
        echo $this->Html->css('style');
        echo $this->Html->css('style-responsive');
        echo $this->Html->css('sas');
        echo $this->fetch('css');
        echo $this->Html->script('jquery-1.11.0.min');
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



</head>

<body>
<!-- start: Header -->
<div class="navbar">
<div class="navbar-inner">
<div class="container-fluid">
<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<a class="brand" href="index.html"><span>SAS</span></a>

<!-- start: Header Menu -->
<div class="nav-no-collapse header-nav">
<ul class="nav pull-right">

<!-- start: User Dropdown -->
<?php 
    if($logged_in):
?>
<li class="dropdown">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="halflings-icon white user"></i> <?php echo $userAutenticated['username']; ?>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-menu-title">
            <span>Configuracion</span>
        </li>
        <li>
            <a href="<?php echo $_SERVER['CONTEXT_PREFIX'] .'/users/edit/'. $userAutenticated['id'];?>"><i class="halflings-icon off"></i> Perfil</a>
        </li>
        <li>
            <a href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/users/logout"><i class="halflings-icon off"></i> Salir</a>
        </li>
    </ul>
</li>

<?php 
    else:
?>
<li class="dropdown">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="halflings-icon white user"></i> Acceso Libre
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-menu-title">
            <span>Configuracion</span>
        </li>
        <li>
            <a href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/users/login"><i class="halflings-icon off"></i> Autenticarse</a>
        </li>
    </ul>
</li>
<?php 
    endif;
?>
<!-- end: User Dropdown -->
</ul>
</div>
<!-- end: Header Menu -->

</div>
</div>
</div>
<!-- start: Header -->

<div class="container-fluid-full">
    <div class="row-fluid">

    <!-- start: Main Menu -->
    <!-- <div id="sidebar-left" class="span2">
        <div class="nav-collapse sidebar-nav">
            <ul class="nav nav-tabs nav-stacked main-menu"> -->
                <!-- <li><a href="index.html"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>
                <li><a href="messages.html"><i class="icon-envelope"></i><span class="hidden-tablet"> Messages</span></a></li>
                <li><a href="tasks.html"><i class="icon-tasks"></i><span class="hidden-tablet"> Tasks</span></a></li>
                <li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
                <li><a href="widgets.html"><i class="icon-dashboard"></i><span class="hidden-tablet"> Widgets</span></a></li>
                <li>
                    <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Dropdown</span><span class="label label-important"> 3 </span></a>
                    <ul>
                        <li><a class="submenu" href="submenu.html"><i class="icon-file-alt"></i><span class="hidden-tablet"> Sub Menu 1</span></a></li>
                        <li><a class="submenu" href="submenu2.html"><i class="icon-file-alt"></i><span class="hidden-tablet"> Sub Menu 2</span></a></li>
                        <li><a class="submenu" href="submenu3.html"><i class="icon-file-alt"></i><span class="hidden-tablet"> Sub Menu 3</span></a></li>
                    </ul>
                </li>
                <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
                <li><a href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
                <li><a href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
                <li><a href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
                <li><a href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
                <li><a href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
                <li><a href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
                <li><a href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
                <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li> -->
           <!--  </ul>
        </div>
    </div> -->
    <!-- end: Main Menu -->

    <noscript>
        <div class="alert alert-block span10">
            <h4 class="alert-heading">Warning!</h4>
            <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
    </noscript>

    <!-- start: Content -->
    <div id="content" class="span10">


    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Inicio</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#"><?php echo $title_for_layout; ?></a></li>
    </ul>
    <div class="row-fluid">
        <?php echo $this->Session->flash();
              echo $this->Session->flash('auth');
        ?>
    </div>

    <?php echo $this->fetch('content'); ?>


    </div><!--/.fluid-container-->

    <!-- end: Content -->
    </div><!--/#content.span10-->   
</div><!--/fluid-row-->

<div class="modal hide fade" id="myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Settings</h3>
    </div>
    <div class="modal-body">
        <p>Here settings can be configured...</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a>
    </div>
</div>

<div class="clearfix"></div>

<footer>

    <p>
        <span style="text-align:left;float:left">&copy; 2014 <a href="http://android.cujae.edu.cu/" alt="Bootstrap_Metro_Dashboard">Simple Android Store</a></span>

    </p>

</footer>



</body>
</html>
