<?php
    $this->start('css');
    echo $this->Html->css('frontend/public.view.css');
    $this->end();
?>
<?php
        $this->start('script');
        ?>
<script type="text/javascript">

    function donwloadApp(id){
        window.open("<?php echo $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadApp'));?>/"+id, '_blank');
    }

    function donwloadAppVersion(id, version){
        window.open("<?php echo $this->HTML->url(array('controller'=>'devices', 'action' => 'downloadApp'));?>/"+id + "/" + version, '_blank');
    }


</script>
<?php
    $this->end();
?>

<div class="row-fluid">
    <div class="box span8">
        <div class="box-header">
            <h2>
                <i class="halflings-icon th"></i>
                <span class="break"></span>
                <?php echo h($apk['Application']['label']);?>
            </h2>
        </div>

        <div class="box-content">

        <div class="row-fluid">
            <!-- Primero devbe ir la imagen de alguna forma -->
            <div class="box span2">
                <div class="center">
                    <img width="80px" height="80px" alt="<?php echo h($apk['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($apk['Application']['id']) . '/' . h($apk['Application']['version']) . '/' . h($apk['Application']['id']);?>.png" />
                </div>

            </div>
                <div class="box span6">
                
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>
                                    Versión:
                                </td>
                                <td>
                                    <?php echo h($apk['Application']['code']);?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tamaño:
                                </td>
                                <td>
                                    <?php 
                                        $tot = $apk['Application']['size'];
                                        if($tot < 1024){
                                            echo sprintf("%01.2f", $tot) . " b";
                                        }else{
                                            $tot /= 1024;
                                            if($tot < 1024){
                                                echo sprintf("%01.2f", $tot) . " kb";
                                            }else{
                                                $tot /= 1024;
                                                if($tot < 1024){
                                                    echo sprintf("%01.2f", $tot) . " mb";
                                                }else{
                                                   $tot /= 1024;
                                                    if($tot < 1024){
                                                        echo sprintf("%01.2f", $tot) . " gb";
                                                    }else{
                                                        $tot /= 1024;
                                                        echo sprintf("%01.2f", $tot) . " tb";
                                                    } 
                                                }
                                            }
                                        }                                        
                                    ?> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Categoría:
                                </td>
                                <td>
                                    <?php
                                        echo h($apk['Category']['name']);
                                    ?>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Verificada:
                                </td>
                                <td>
                                    <?php
                                    if(!$apk['Application']['verificate']){
                                        echo "Sin verificar <i class='halflings-icon thumbs-down'></i>";
                                    }else{
                                        echo "Verificada <i class='halflings-icon thumbs-up'></i>";
                                    }
                                    ?>
                                </td>
                            </tr> 
                            <!-- <tr>
                                <td>
                                    Ranking
                                </td>
                                <td>
                                    <span class="rating">
                                    <span class="star"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                </span>
                                </td>
                            </tr> -->

                            <!-- Zona de Manager y admins por ahora solo admins-->
                             <?php if ($isadmin): ?>
                            <tr>
                                <td>Verificar</td>
                                <td class="actions">
                                    <a class="btn btn-info small" href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/applications/downloadApp' . '/' . $apk['Application']['id'];?>/">
                                        <i class="halflings-icon white download-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Recomendar</td>
                                <td class="actions">
                                    <a class="btn btn-info small" href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/applications/downloadApp' . '/' . $apk['Application']['id'];?>/">
                                        <i class="halflings-icon white download-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <!-- Zona de Manager y admins -->
                            <tr>
                                <td>Descargar</td>
                                <td class="actions">
                                    <a class="btn btn-info small" href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/applications/downloadApp' . '/' . $apk['Application']['id'];?>/">
                                        <i class="halflings-icon white download-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- Aqui acaba la table de propiedades -->
            <!-- Aqui comienza las propiedades -->
            <div class="row-fluid sortable ui-sortable" >
                <div class="box-header">
                    <h2>
                        <i class="halflings-icon th"></i>
                        <span class="break"></span>Descripción
                    </h2>
                    
                    <div class="box-icon">
                        <a class="btn-minimize" href="#">
                            <i class="halflings-icon chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="box-content" style="display:none;">
                    <div style=" width: 100%; overflow-x: hidden; overflow-y: auto; height: 175px;">
                        <p>
                             <?php
                                if(h($apk['Application']['description']) == ''){
                                echo 'Sin descripcion';
                                }
                                else
                                echo $apk['Application']['description'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Aqui terminan las propiedades -->
            <hr/>
            <!-- Aqui comienza las versiones -->
             <?php if (!empty($apk['Version'])): ?>
            <div class="row-fluid" >
                <div class="box-header">
                    <h2>
                        <i class="halflings-icon th"></i>
                        <span class="break"></span>
                        Versiones
                    </h2>
                    <div class="box-icon">
                        <a class="btn-minimize" href="#">
                            <i class="halflings-icon chevron-down"></i>
                        </a>
                    </div>
                </div>               
                <div class="box-content" style="display:none;">
                    <table class="table table-condensed">
                        <thead>
                            <tr>

                                <th><?php echo __('Nombre'); ?></th>
                                <th><?php echo __('Código'); ?></th>
                                <th><?php echo __('SDK'); ?></th>
                                <th class="actions"><?php echo __('Acciones'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($apk['Version'] as $version): ?>
                            <tr>
                                <td><?php echo $version['label']; ?></td>
                                <td><?php echo $version['code']; ?></td>
                                <td><?php echo $version['sdkversion']; ?></td>
                                <td class="actions">

                                    <a class="btn btn-info" href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/applications/downloadVersion' . '/' . $version['id'];?>/">
                                        <i class="halflings-icon white download-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <!-- Aqui terminan las versiones -->

            <!-- Aqui comienza las versiones -->
             <?php if (isset($related)): ?>
            <div class="row-fluid" >
                <div class="box-header">
                    <h2>
                        <i class="halflings-icon th"></i>
                        <span class="break"></span>
                        Similares
                    </h2>
                    <div class="box-icon">
                        <a class="btn-minimize" href="#">
                            <i class="halflings-icon chevron-down"></i>
                        </a>
                    </div>
                </div>               
                <div class="box-content" style="display:none;">
                    <?php foreach ($related as $app): ?>

                        <a href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/applications/detail' . '/' . $app['Application']['id'];?>" class="quick-button metro blue span4" style="padding-top:10px;">
                            <i class="icon-download-alt"></i>
                            <p><?php echo $app['Application']['label']; ?></p>
                            <span class="notification green">
                                <?php 

                                    echo (strlen($app['Application']['code'])>6)?substr($app['Application']['code'], 0,6):$app['Application']['code'];
                                    ?>
                            </span>
                            <span class="badge">
                                 <?php 
                                    echo sprintf("SDK: %11s", $app['Application']['sdkversion']);
                                    ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <!-- Aqui terminan las versiones -->

        </div>

    </div>
</div>




