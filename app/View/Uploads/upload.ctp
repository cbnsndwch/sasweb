<div class="row-fluid" >
        <div class="col-lg-10">
            <h2 class="page-header"><?php echo __('Subir Aplicaciones'); ?></h2>
        </div>

          
    </div>
     <hr/>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="typeahead">Categoría: </label>
            <div class="controls">
                <select name="category" id="category">
                    <?php
                        foreach($categories as $c):?>
                        <option value="<?php echo $c['Application']['category']; ?>" label="<?php echo $c['Application']['category']; ?>">
                            <?php echo $c['Application']['category']; ?>
                        </option>
                    <?php
                        endforeach;
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="typeahead">Descripción: </label>
            <div class="controls">
                <textarea class="cleditor" type="text" name="description" id="description" placeholder="descripcion"></textarea>
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
