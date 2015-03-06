<?php
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
   
    function search(){
//        var data = "<?php //echo $this->HTML->url(array('controller'=>'applications', 'action' => 'repo'));?>";
//        if(data == ""){
            document.location = "<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/repo/" + $('#search').val();
//        }else{
//            document.location = data + "/" + $('#search').val();
//        }

		//
    }

    function down($url){
        //aqui realizar la peticion con un form
        $form = $("<form></form>");
        $('body').append($form);
        $form.attr('action', $url);
        $form.attr('target', '_blank');
        $form.attr('method','POST');
        $form.append("<input type='hidden' name='client' value='Repo-List' />");
        $form.submit();
    }

</script>
<?php
    $this->end();
?>

    <div class="row-fluid">
        <div class="col-lg-10">
            <h2 class="page-header"><?php echo __('Aplicaciones'); ?></h2>
        </div>
   
        <!--Aqui tengo que poner un buscador-->
        <div class="col-lg-10">
              <input name="search" class="input-xlarge focused" id="search" value="<?php echo $search;?>" placeholder="<?php echo __('Introduzca una palabra clave para buscar');?>" />
            <button class="btn btn-default" onclick="search();"><span class="glyphicon glyphicon-search"></span></button>
        </div>
     </div>
    <div class="clearfix"></div>


    <div class="row-fluid">

        <?php $count = 0; foreach ($apks as $apk): ?>

        <div class="span3 statboxsas blue " <?php echo ($count==0)?"style='margin-left: 2.5641%;'":"";?> ondesktop="span3" ontablet="span6">
            <div class="title"> <?php echo h($apk['Application']['label']);?></div>
            <div class="avatar">
                <a href="<?php echo $this->Html->url(array('controller' => 'Applications', 'action' => 'detail', $apk['Application']['id']))?>">
                        <img width="70px" height="70px" style="width:70px;height:70px;" alt="<?php echo h($apk['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($apk['Application']['id']) . '/' . h($apk['Application']['version']) . '/' . h($apk['Application']['id']);?>.png" />
                    </a>
            </div>
            <div class="number">
                <?php echo h($apk['Application']['downloads']);?>
                <a href="javascript:void(null);" onclick='down("<?php echo $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadsloadApp',$apk['Application']['id']));?>");'' ><i class="icon-arrow-down"></i></a>
            </div>
            <div class="title2">descargas</div>
            <div class="footer">
                <a href="<?php echo $this->Html->url(array('controller' => 'Applications', 'action' => 'detail', $apk['Application']['id']))?>">    Detalles
                </a>
            </div>
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


