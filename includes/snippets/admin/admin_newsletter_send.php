<?php
if(!$id || !is_numeric($id)) die('No se ha especificado un newsletter para enviar');

$nl = new Newsletter;

$nl_data = $nl->getNewsletters($id);
$sent = $nl->getNewsletterSent($id);
$dest = $nl->getNewsletterDest($id);

$user = new Users;



?>

<h3>Enviar newsletter</h3>
<hr>
<h4>Título: "<?= $nl_data[0]['title'] ?>"</h4>
<p>Enviados <?= $sent['sent'] . " de " . $sent['dest'] . " - (" . $sent['error'] . ") errores" ?></p>
<p align="center" id="p_enviar"><input type="button" class="btn btn-primary" onClick="sendNewsletter()" value="Enviar newsletter"></p>
<p align="center" id="p_detener" style="display: none"><input type="button" id="btn_detener" class="btn btn-danger" value="Detener envío"></p>
<p align="center" id="p_volver"><a href="admin.php?action=newsletter&sub=newsletter_list"  class="btn btn-warning">Volver al listado</a></p>
<p>Listado de usuarios para enviar</p>

<div style="padding: 0px 50px 70px 50px">
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Username</th>
		  <th scope="col">Correo</th>
		  <th scope="col">Status</th>
		  <th scope="col"></th>
		</tr>
	  </thead>
	  <tbody>
		  <?php $n = 1 ?>
		  <?php foreach($dest AS $d) : ?>
		  <?php 
		  //Obtenemos los datos del usuario
		  $u = $user->getUserDataById($d['id_user']);
		  //Dependiendo del estado ponemos un icono u otro
		  /*
		  0 -> Pendiente
		  1 -> Enviado
		  2 -> Error
		  3 -> Recibido y leído
		  */
		  switch ($d['status'])
		  {
			  case 0:
				  $icon = 'clock-o';
				  $class = 'text-secondary';
				  break;
			  case 1:
				  $icon = 'check';
				  $class = 'text-success';
				  break;
			  case 2:
				  $icon = 'exclamation-triangle';
				  $class = 'text-warning';
				  break;
			  case 3:
				  $icon = 'thumbs-up';
				  $class = 'text-success';
				  break;
		  }
		  ?>
		<tr>
		  <th scope="row"><?= $n ?></th>
		  <td><?= $u['username'] ?> </td>
		  <td><?= $u['email'] ?></td>
		  <td align="center"><i id="icon-<?=$d['id'] ?>" class="fa fa-<?= $icon ?> <?= $class ?>" data-toggle="tooltip" data-placement="top" title="<?= $d['log'] ?>"></i></td>
		  <td><button type="button" class="btn btn-secondary btn-sm" onClick="sendMail(<?=$d['id'] ?>,'<?= $d['token'] ?>')">Enviar</button></td>
		</tr>
		  <?php $n++ ?>
		  <?php endforeach ?>
	  </tbody>
	</table>
</div>

<p></p>
<p></p>

<script>

	//Construimos un array con las personas a enviar
	var arraySend = {
<?php foreach($dest AS $d) : ?>
<?php if($d['status'] == 0) : ?>
"id<?= $d['id'] ?>": [<?= $d['id'] ?>,'<?= $d['token'] ?>'],
<?php endif ?>
<?php endforeach ?>
	};

	//Función que manda el correo pasando los datos al widget PHP por AJAX
	//Necesita también la posición dentro del array para eliminarlo
	
	function spinIcon(id)
	{
		$("#icon-" + id).attr('class','fa fa-spinner text-secondary rotate');
		$("#icon-" + id).attr('data-original-title','Enviando');
	}
	function checkIcon(id)
	{
		$("#icon-" + id).attr('class','fa fa-check text-success');
		$("#icon-" + id).attr('data-original-title','Newsletter enviado');			
	}
	function warningIcon(id,error)
	{
		$("#icon-" + id).attr('class','fa fa-exclamation-triangle text-warning');
		$("#icon-" + id).attr('data-original-title',error);
					
	}
		
	function sendNewsletter()
	{
		/*
		function callbackFactory(i){
			return function(data, textStatus, jqXHR){
				console.log('We are calling with index ' + i + ' and the data is...')
				console.log(data);
			}
		}
		*/
		
		//Ponemos el enviando en true
		var enviando = true;
		
		
		//Quitamos el botón de envío y lo sustituimos por el de detener
		$("#p_enviar").slideUp( "fast", function() {
				$("#p_detener").slideDown("fast",)
		});
		
		//Si se detiene el envío
		$("#btn_detener").click(function()
		{
			enviando = false;
			$("#p_detener").slideUp( "fast", function() {
				$("#p_enviar").slideDown("fast",)
			});
			
		});
		
		var sendMails = function(){
			//Obtenemos el primer correo pendiente
			for (var key in arraySend) {
		  		var id = arraySend[key][0];
				var token = arraySend[key][1];
				break;
			}
			$.ajax({
				url: "includes/widgets/send_newsletter.php",
				beforeSend: function()
				{
					//Cambiamos el icono y el tooltip
					spinIcon(id);
				},
				method:'get',
				data: {
					i: id,
					t: token
				},
				success: function(data){
					var obj = JSON.parse(data);
					if(obj.error == '')
					{
						console.log('enviado ' + id);
						checkIcon(id);
					}
					else
					{
						warningIcon(id,obj.error);
					}
					
					//Le quitamos del array de envío
					delete arraySend['id' + id];
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}

			}).always(function(){
				
				//Comprobamos que todavían queda correos para enviar y que se sigue enviando
				var k = Object.keys(arraySend);
				if(k.length > 0 && enviando === true) 
				{
					sendMails();
				}
				else{
					console.log('Finalizado el envío');
					enviando = false;
					$("#p_detener").slideUp( "fast", function() {
						//$("#p_enviar").slideDown("fast",)
					});
				}

			});
		}
		
		if(enviando === true) {
			sendMails();
		}
	}

	
	function sendMail(id,token)
	{
		$.ajax({
			url: "includes/widgets/send_newsletter.php",
			beforeSend: function()
			{
				//Cambiamos el icono y el tooltip
				spinIcon(id);
			},
			method:'get',
			data: {
				i: id,
				t: token
			},
			success: function(data){
				var obj = JSON.parse(data);
				if(obj.error == '')
				{
					console.log('enviado ' + id);
					checkIcon(id);
				}
				else
				{
					warningIcon(id,obj.error);
				}

				//Le quitamos del array de envío
				delete arraySend['id' + id];
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}

		})
	}
</script>
