<?php
require_once('../toolkit.php');

$response = [];
$response['error'] = '';

//Comprobamos que se ha pasado el ID y el token
if(!isset($_GET['i']) || !isset($_GET['t']))
{
	$response['error'] = 'No se han especificado correctamente los datos';
}
else
{
	//Cargamos la clase de user
	$nl = new Newsletter;
	
	//Establecemos los datos del envío
	if($nl->setNewsletterData($_GET['i'],$_GET['t']))
	{
		
		//Enviamos el correo
		try{
			$nl->sendNewsletter($nl->id_user,$nl->id_newsletter);
		}
		catch(Exception $e) {
			
			$response['error'] = 'Se ha producido un error enviar el newsletter: ' . $e->getMessage();
		}
	}
	else
	{
		$response['error'] = 'Se ha producido un error al obtener los datos de envío.';
	}
	
		
}

echo json_encode($response);
?>
