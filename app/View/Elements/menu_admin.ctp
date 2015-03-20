<div id="sidebar-left" class="span2">
    <div class="nav-collapse sidebar-nav">
        <ul class="nav nav-tabs nav-stacked main-menu"> 
            <li>
            	<a href="<?php echo $_SERVER['CONTEXT_PREFIX'] .'/applications/repo/'; ?>">
            		<i class="icon-bar-chart"></i>
            		<span class="hidden-tablet"> Repositorio</span>
            	</a>
            </li>

			<!-- <li>
            	<a href="mx">
            		<i class="icon-file-alt"></i>
            		<span class="hidden-tablet"> Noticias</span>
            	</a>
            </li> -->

            <li>
                <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Destacadas</span> </a>
                <ul>
                	<li><a class="submenu" href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/reponews"><i class="icon-file-alt"></i><span class="hidden-tablet"> Nuevas</span2an> <span class="label label-important"> <?php echo $cantnews;?> </span></a></li>
                    
                    <!-- <li><a class="submenu" href="submenu.html"><i class="icon-file-alt"></i><span class="hidden-tablet"> Top descarga</span> <span class="label label-important"> 3 </span></a></li> -->
                    
                    <li><a class="submenu" href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/reporecommended"><i class="icon-file-alt"></i><span class="hidden-tablet"> Recomendadas</span> <span class="label label-important"> <?php echo $recommended;?> </span></a></li>
                    
                    <li><a class="submenu" href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/repoverificate"><i class="icon-file-alt"></i><span class="hidden-tablet"> Verificadas</span> <span class="label label-important"> <?php echo $verificate;?> </span></a></li>
                </ul>
            </li>

            <li><a href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/uploads/index"><i class="icon-list-alt"></i><span class="hidden-tablet"> Verificar Subidos</span></a></li>

            <li><a href="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/uploads/upload"><i class="icon-list-alt"></i><span class="hidden-tablet"> Subir Apk</span></a></li>


     <!--       <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
            <li><a href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
            <li><a href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
            <li><a href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
            <li><a href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
            <li><a href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
            <li><a href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></i>
            <li><a href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
            <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li> -->
         </ul>
    </div>
</div>