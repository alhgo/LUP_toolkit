<?php
require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

$user->destroyCookie();

url::go('user.php');

?>
