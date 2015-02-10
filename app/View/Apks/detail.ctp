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
        window.open("<?php echo $this->HTML->url(array('controller'=>'apks', 'action' => 'downloadApp'));?>/"+id, '_blank');
    }


</script>
<?php
    $this->end();
?>
<div class="apks view">
    <div class="detail_box">
        <div class="image_box pull-left">
            <img width="80px" height="80px" alt="<?php echo h($apk['Apk']['label']);?>" src="/pool/<?php echo h($apk['Apk']['id']) . '/' . h($apk['Apk']['code']) . '/' . h($apk['Apk']['id']);?>.png" />
        </div>

        <div class="principal_data_box pull-left">
            <div class="title_box pull-left">
                <span><?php echo h($apk['Apk']['label']);?></span>
            </div>
            <div class="data_box">
                <span>Version: <?php echo h($apk['Apk']['code']);?></span>
            </div>
            <div class="data_box">
                <span>Tamano: <?php echo h($apk['Apk']['size']);?></span>
            </div>
            <div class="category_box">
                    <span>Categoria:
                        <?php
                            if(h($apk['Apk']['category']) == ''){
                            echo 'No encontrada';
                            }
                            else
                            echo h($apk['Apk']['category']);
                        ?>
                    </span>
            </div>
        </div>
        <div class="clearfix"></div>
        <div  class="icon_box">
            <!--<i class="glyphicon glyphicon-share-alt" onclick="donwloadApp(7)"></i>-->
            <!--<i class="glyphicon glyphicon-exclamation-sign" onclick="donwloadApp(7)"></i>-->
            <i class="glyphicon glyphicon-download" onclick='donwloadApp("<?php echo h($apk['Apk']['id']); ?>");'></i>
        </div>
        <div class="clearfix"></div>
        <div class="description_box">
            <?php
                if(h($apk['Apk']['description']) == ''){
                echo 'Sin descripcion';
                }
                else
                echo $apk['Apk']['description'];
            ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Descargar'), array('action' => 'downloadApp', $apk['Apk']['id'])); ?> </li>
        <!--<li><?php echo $this->Html->link(__('Versiones'), array('action' => 'edit', $apk['Apk']['id'])); ?> </li>-->
        <!--<li><?php echo $this->Html->link(__('Datos de la apk'), array('action' => 'index')); ?> </li>-->

	</ul>
</div>
