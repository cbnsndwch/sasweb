<?php
    $this->start('css');
        echo $this->Html->css('frontend/apks.repo');
        echo $this->Html->css('frontend/apks.repo.360');
    $this->end();
    $this->start('script');
?>
<script type="text/javascript">

    $(function(){
        $('#search').on("keypress",function(e){
            //asignar a el input search un manejador para que al dar enter se busque tambien
            if(e.keyCode == 13){
                search();
            }
        });
    });

    function donwloadApp(id){
        window.open("<?php echo $this->HTML->url(array('controller'=>'application', 'action' => 'downloadApp'));?>/"+id, '_blank');
    }

    function search(){
//        var data = "<?php //echo $this->HTML->url(array('controller'=>'applications', 'action' => 'repo'));?>";
//        if(data == ""){
            document.location = "<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/repo/" + $('#search').val();
//        }else{
//            document.location = data + "/" + $('#search').val();
//        }

		//
    }



</script>
<?php
    $this->end();
?>

<div class="apks index">
	<h2><?php echo __('Aplicaciones'); ?></h2>
    <!--Aqui tengo que poner un buscador-->
    <div class="search">
          <input name="search" id="search" value="<?php echo $search;?>" placeholder="<?php echo __('Introduzca una palabra clave para buscar');?>" />
        <button class="btn btn-default" onclick="search();"><span class="glyphicon glyphicon-search"></span></button>
    </div>
    <div class="files" style="width: 100%; ">

        <?php foreach ($apks as $apk): ?>

        <div class="file-tile pull-left" >
            <div class="file-preview pull-left">
                <div class="file-image">
                    <a href="<?php echo $this->Html->url(array('controller' => 'Applications', 'action' => 'detail', $apk['Application']['id']))?>">
                        <img width="80px" height="80px" alt="<?php echo h($apk['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($apk['Application']['id']) . '/' . h($apk['Application']['version']) . '/' . h($apk['Application']['id']);?>.png" />
                    </a>
                </div>
            </div>

            <div class="file-data pull-left">
                <div class="file-title">
                    <?php echo h($apk['Application']['label']); ?>
                </div>
                <div class="file-type">
                    <span class="label-type">
                        Version: <?php echo h($apk['Application']['code']); ?>
                    </span>
                    <br/>
                    <span class="type">
                        Categoria: <?php
                            if(h($apk['Application']['category']) == ''){
                            echo 'No encontrada';
                            }
                            else
                                echo h($apk['Application']['category']);
                            ?>
                    </span>
                    <br/>
                    <span class="type">
                        Tamaño: <?php
                            $size = h($apk['Application']['size']);
                            $size /= (1024*1024);
                            echo  number_format($size,2) . ' mb';
                            ?>
                    </span>
                    <br/>
                    <span class="options">

                        <?php

                        $url = $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadApp',$apk['Application']['id']));
                        ?>
                        <form action='<?php echo $url; ?>' method='post'>
                            <input type="hidden" id="client" name="client" value="Web-Repo"/>
                            <button class="glyphicon glyphicon-download" />
                        </form>


                        <!-- este se mostrar si hay otras versiones>-->
                        <!--<i class="glyphicon glyphicon-exclamation-sign" onclick="donwloadApp(7)"></i>-->
                        <!-- este se mostrar si hay datos asociados> -->
                        <!--<i class="glyphicon glyphicon-share-alt" onclick="donwloadApp(7)"></i> -->

                    </span>
                </div>
             </div>
            <div class="clearfix"></div>


        </div>
        <?php endforeach; ?>

    </div>
    <div class="clearfix"></div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina {:page} de {:pages},
        mostrando {:current} apks de un total de {:count}   ,
        [ {:start}-{:end} ]')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

