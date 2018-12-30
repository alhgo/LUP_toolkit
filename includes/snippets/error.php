<?php
//Errores
$errorArray = array(
	'default' => array(
		'title' => 'Se ha producido un error',
		'text' => 'La página no está funcionando. Por favor, póngase en contacto con el administrador si el sistema persiste.'),
	'FirebaseUserAuth' => array(
		'title' => 'Error en la Base de Datos',
		'text' => 'Se ha producido un error al autenticarse en la Base de Datos Firebase.'),
	'FirebaseFile' => array(
			'title' => 'Error en la Base de Datos',
			'text' => 'Se ha producido un error al cargar el archivo de configuración de la Base de Datos Firebase.'),
);

if(!isset($errorArray[$error]))
{
	$error = 'default';
}

?>
<h1><?= $errorArray[$error]['title'] ?></h1>
<p><?= $errorArray[$error]['text'] ?></p>
<p>Código de error: <?= $error ?></p>
<?php if(isset($errorAdd)) : ?>
<p><?= $errorAdd ?></p>
<?php endif ?>