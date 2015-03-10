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
            document.location = "<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/reponews/" + $('#selectCategory').val() + '/' + $('#search').val();
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

    <div class="row-fluid" >
        <div class="col-lg-10">
            <h2 class="page-header"><?php echo __('Aplicaciones'); ?></h2>
        </div>

        <div class="control-group" style="margin-left:2.5641%;" >
            <div class="controls">
                <select id="selectCategory" class="chzn-done" data-rel="chosen" >
                <option value="-1" <?php echo ( ($catsel == -1)?"selected=true":""  )  ?> >Todas</option>
                <?php foreach ($category as $cat): ?>
                    <!-- Aqui tengo que poner la ques esta seleccionada cuando el metodo la reciva -->
                    <option <?php echo ( ($catsel == $cat['Category']['id'])?"selected=true":""  )  ?> value="<?php echo $cat['Category']['id']?>"><?php echo $cat['Category']['name']?></option>
                <?php endforeach; ?>
                </select>             
                 <input name="search" size="29" id="search" type="text" value="<?php echo $search;?>" placeholder="<?php echo __('palabra clave');?>" />
                    <button class="btn btn-primary" onclick="search();" type="button">
                        <i class="halflings-icon white search"></i>
                    </button>   

        </div>    
    </div>
     <hr/>
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

                <?php $var =  $this->HTML->url(array('controller'=>'applications', 'action' => 'downloadsloadApp',$apk['Application']['id']));?>

                <a class="arrow" href="javascript:void(null);" onclick="down('<?php echo $var;?>');" ><i class="icon-arrow-down"></i></a>
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
	<div class="row-fluid">
        <div class="span12">
            <div class="dataTables_info ">
            	<small><?php
            	echo $this->Paginator->counter(array(
            	'format' => __('Pagina {:page} de {:pages},
                    mostrando {:current} aplicaciones de un total de {:count}   ,
                    [ {:start}-{:end} ]')
            	));
            	?>	</small>
            </div>
        </div>
    </div>
	
    
        <?php
        $params = $this->Paginator->params();
        if ($params['pageCount'] > 1) {
            ?>
            <div class="pagination pagination-centered">
            <ul class="pagination">
                <?php
                echo $this->Paginator->prev('&larr; Atras', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Atras</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));

                echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));

                echo $this->Paginator->next('Siguiente &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Siguiente &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
                ?>
            </ul>
            </div> 
        <?php } ?>
        <!-- <p>
            <small><?php echo $this->Paginator->counter(array('format' => __('Registros del {:start} al {:end} de {:count}')));?></small>
        </p>-->
    


