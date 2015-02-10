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
<div class="apks view">
    <div class="detail_box">
        <div class="image_box pull-left">
            <img width="80px" height="80px" alt="<?php echo h($apk['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($apk['Application']['id']) . '/' . h($apk['Application']['version']) . '/' . h($apk['Application']['id']);?>.png" />
        </div>

        <div class="principal_data_box pull-left">
            <div class="title_box pull-left">
                <span><?php echo h($apk['Application']['label']);?></span>
            </div>
            <div class="clearfix"></div>
            <div class="data_box pull-left">
                <span class="title">Versión:</span>
                <span ><?php echo h($apk['Application']['code']);?></span>
            </div>
            <div class="clearfix"></div>
            <div class="data_box pull-left">
                <span class="title">Tamaño: </span>
                <span><?php echo h($apk['Application']['size']);?> bytes</span>
            </div>
            <div class="clearfix"></div>
            <div class="category_box pull-left">
                    <span class="title">Categoría:</span>
                    <span>
                        <?php
                            if(h($apk['Application']['category']) == ''){
                            echo 'No encontrada';
                            }
                            else
                            echo h($apk['Application']['category']);
                            ?>
                    </span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div  class="icon_box">
            <!--<i class="glyphicon glyphicon-share-alt" onclick="donwloadApp(7)"></i>-->
            <!--<i class="glyphicon glyphicon-exclamation-sign" onclick="donwloadApp(7)"></i>-->
            <!-- <i class="glyphicon glyphicon-download" onclick='donwloadApp("<?php echo h($apk['Application']['id']); ?>");'></i> -->

            <?php

                $url = $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadApp',$apk['Application']['id']));
            ?>
            <form style="display:inline;" action='<?php echo $url; ?>' method='post'>
                <input type="hidden" id="client" name="client" value="Web-Detail"/>
                <button class="glyphicon glyphicon-download" />
            </form>

        </div>
        <div class="clearfix"></div>
        <div class="description_box">
            <?php
                if(h($apk['Application']['description']) == ''){
                echo 'Sin descripcion';
                }
                else
                echo $apk['Application']['description'];
            ?>
        </div>

        <div class="clearfix"></div>

    <div class="related">
        <?php if (!empty($apk['Version'])): ?>
        <h3><?php echo __('Versiones'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>

                <th><?php echo __('Nombre'); ?></th>
                <th><?php echo __('Código'); ?></th>
                <th><?php echo __('SDK'); ?></th>
                <th class="actions"><?php echo __('Acciones'); ?></th>
            </tr>
            <?php foreach ($apk['Version'] as $version): ?>
            <tr>
                <td><?php echo $version['label']; ?></td>
                <td><?php echo $version['code']; ?></td>
                <td><?php echo $version['sdkversion']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Descargar'), array('controller' => 'applications', 'action' => 'downloadVersion', $version['id'])); ?>
                    <!--<?php //echo $this->Html->link(__('Edit'), array('controller' => 'versions', 'action' => 'edit', $version['id'])); ?>-->
                    <!--<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'versions', 'action' => 'delete', $version['id']), array(), __('Are you sure you want to delete # %s?', $version['id'])); ?>-->

                   

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>


    </div>



</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<!-- <li><?php //echo $this->Html->link(__('Descargar'), array('controller'=>'application','action' => 'downloadApp', $apk['Application']['id'])); ?> </li> -->
        <!--<li><?php echo $this->Html->link(__('Versiones'), array('action' => 'edit', $apk['Application']['id'])); ?> </li>-->
        <!--<li><?php echo $this->Html->link(__('Datos de la apk'), array('action' => 'index')); ?> </li>-->

        <?php

            $url = $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadApp',$apk['Application']['id']));
        ?>
        <form style="display:inline;" action='<?php echo $url; ?>' method='post'>
            <input type="hidden" id="client" name="client" value="Web-Detail"/>
            <button class="btn glyphicon glyphicon-download" > Descargar</button>
        </form>

	</ul>
</div>


