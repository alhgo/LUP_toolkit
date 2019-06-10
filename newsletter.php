<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

?>

		<?php if(isset($_GET['id'])) : ?>
		<?php snippet('newsletter.php', ['id' => $_GET['id']]); ?>
		<?php else : ?>
		<h2>No se ha especificado un Newsletter para ver</h2>
		<?php endif ?>
