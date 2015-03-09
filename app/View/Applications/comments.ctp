

<div class="box span10" ontablet="span0" ondesktop="span10">

	<div class="box-header">
		<h2><i class="halflings-icon comment"></i><span class="break"></span>Commentarios sobre <strong><?= $apk['Application']['label']?></strong></h2>
		
	</div>
	<div class="box-content">
		<ul class="chat">

			<?php $count = 0; foreach ($apk['Coment'] as $com): //var_dump($com);?>

				<li class="<?php echo ($count % 2 == 0)?"left":"right";?>">
				<!-- Aqui poner la imagen del user que lo escribio si es que estaba registrado sino no poner la de la app -->
					<img class="avatar" width="40px" height="40px" alt="<?php echo h($apk['Application']['label']);?>" src="<?php echo $_SERVER['CONTEXT_PREFIX'];?>/pool/<?php echo h($apk['Application']['id']) . '/' . h($apk['Application']['version']) . '/' . h($apk['Application']['id']);?>.png" />
					<span class="message"><span class="arrow"></span>
						<span class="from"><strong>
						<?php
							if(isset($com['User']['username'])){
								echo $com['User']['username'];
							}else{
								echo 'anonimo';
							}
						?>
						</strong>
						</span>
						<span class="time"><?= $com['created']?></span>
						<span class="text">
							<?= $com['coment']?>
						</span>
					</span>	       
				</li>
			<?php $count++; endforeach; ?>
		</ul>
		<?php 
		//if ($logged_in): 
		?>
		<script type="text/javascript">
			function addComment($data){
				var e = $('#messagearea').val();
				if(e == ""){
					alert("Debe escribir un comentario.");
				}else{
					 $form = $("<form></form>");
			        $('body').append($form);
			        $form.attr('action', $data);
			        //$form.attr('target', '_blank');
			        $form.attr('method','POST');
			        $form.append("<input type='hidden' name='coment' value='" + e + "' />");
			        $form.submit();
				}				
			}
		</script>
		<div class="chat-form">
			<!-- <input type="text" value="wqwer" /> -->
			<textarea id="messagearea"></textarea>			
			<button class="btn btn-info" onclick="addComment('<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/addcomment/<?=$apk['Application']['id']?>');">Enviar comentario</button>
		</div>	
		<?php //endif; ?>


	</div>


