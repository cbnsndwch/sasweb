<form  method="post" enctype="multipart/form-data">

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


    <input type="text" name="description" id="description" placeholder="descripcion"/>
    <input type="file" name="uploaded" id="uploaded"/>
    <input type="submit" value="Subir"/>
</form>
