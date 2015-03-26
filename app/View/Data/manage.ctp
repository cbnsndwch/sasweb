<div class="row-fluid" >
        <div class="col-lg-10">
            <h2 class="page-header"><?php echo __('Subir Datos'); ?></h2>
        </div>

          
    </div>
     <hr/>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="typeahead">Tipo: </label>
            <div class="controls">
                <select name="type" id="type">                    
                    <option value="other" label="Otro">Otro</option>
                    <option value="data" >Data</option>
                    <option value="obb-main" >Obb principal</option>
                    <option value="obb-path" >Obb secundario</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="typeahead">Nombre: </label>
            <div class="controls">
                <input type="text" name="name" id="name" placeholder="nombre"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="typeahead">Fichero: </label>
            <div class="controls">
                <input type="file" name="uploaded" id="uploaded"/>
            </div> 
        </div>    

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Subir</button>
            <button class="btn" type="reset">Reiniciar</button>
        </div>
    </fieldset>
</form>

 <?php if (!empty($app['Data'])): ?>
                <hr/>
            <div class="row-fluid" >
                <div class="box-header">
                    <h2>
                        <i class="halflings-icon th"></i>
                        <span class="break"></span>
                        Actuales
                    </h2>
                    <div class="box-icon">
                        <a class="btn-minimize" href="#">
                            <i class="halflings-icon chevron-down"></i>
                        </a>
                    </div>
                </div>               
                <div class="box-content" >
                    <table class="table table-condensed">
                        <thead>
                            <tr>

                                <th><?php echo __('Nombre'); ?></th>
                                <th><?php echo __('Tipo'); ?></th>
                                <th class="actions"><?php echo __('Acciones'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($app['Data'] as $data): ?>
                            <tr>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['type']; ?></td>
                                <td class="actions">
                                    <a class="btn btn-info" href="<?php echo $_SERVER['CONTEXT_PREFIX'] . '/data/downloadData' . '/' . $data['id'];?>/">
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


