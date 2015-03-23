

<div class="box span10" ontablet="span0" ondesktop="span10">

	<div class="box-header">
		<h2><i class="halflings-icon comment"></i><span class="break"></span>Comentarios de Sasweb</strong></h2>
		
	</div>
	<div class="box-content">
		
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
			<button class="btn btn-info" onclick="addComment('<?php echo $_SERVER['CONTEXT_PREFIX'];?>/applications/addgeneralcomment/');">Enviar comentario</button>
		</div>	
		<?php //endif; ?>


	</div>


