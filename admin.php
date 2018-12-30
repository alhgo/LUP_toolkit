<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

//Si el usuario no es administrador, lo sacamos de la página
if(!$user->logged || !$user->is_admin) {
	url::go('logout.php?error=no_admin');
}

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => c::get('site.nav'), 'sidebar' => c::get('admin.sidebar'), 'site' => $site, 'user' => $user]); ?>
	
	
	<div class="container p-0 m-0">
		
		<!-- Bootstrap row -->
		<div class="row" id="body-row">
			
			<?php snippet('admin/sidebar.php',['sidebar' => c::get('admin.sidebar'), 'user' => $user]) ?>
			<!-- MAIN -->
			<div class="col ">
				<?php 
                //Diferentes páginas de administración
				if($action == 'users')
				{
					snippet('admin/admin_users.php');
				}
				else
				{
					snippet('admin/admin_home.php'); 
				}
				?>

			</div><!-- Main Col END -->

		</div><!-- body-row END -->
		

	</div>
	
	
<?php snippet('footer.php', ['libs' => array('admin.js')]); ?>

</body>
</html>