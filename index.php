<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

?>

<?php snippet('header.php', ['user'=> $user, 'site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => c::get('site.nav'), 'sidebar' => c::get('admin.sidebar'), 'site' => $site, 'user' => $user]); ?>

	<div class="container-fluid p-0 m-0">
		
		<?php snippet('breadcrumb.php',array('data' => ['Inicio' => 'index.php'])); ?>
	</div>
	<div class="container mt-3">
		
		<?php snippet('home.php'); ?>

		<?php if(c::get('use.database') && !$user->logged) snippet('user/login_form_modal.php'); ?>

	</div>
	
<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>

</body>
</html>