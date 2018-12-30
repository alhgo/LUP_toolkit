<?php

require_once('includes/toolkit.php');

$site = new Site;

//Errores obtenidos
$error = (isset($_GET['error'])) ? $_GET['error'] : 'default';
$errorAdd = (isset($_GET['add'])) ? $_GET['add'] : '';


?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>
	

<?php snippet('nav.php',['menu' => array('Menú 1' => 'menu1.html', 'Menú 2' => 'menu2.html'), 'site' => $site]); ?>

	<div class="container-fluid p-0 m-0">
		
		<?php //snippet('breadcrumb.php',array('data' => ['Inicio' => 'index.php'])); ?>
		
		<?php snippet('error.php',['error' => $error, 'add' => $errorAdd]); ?>

	</div>
<?php snippet('footer.php'); ?>

</body>
</html>