<?php
$user = new Users;

//Acción a realizar
$sub = (isset($_GET['sub'])) ? $_GET['sub'] : '';
$error = '';
$success = '';

//-- INSERTAR USUARIO -- //
if(isset($_POST['insert_user']))
{
	//print_r($_POST);
	//Si no se ha marcado la casilla de administrador
	if(!isset($_POST['admin']))
	{
		$_POST['admin'] = 0;
	}
	try {
		$id_user = $user->insertUser($_POST);
		$success = 'Usuario insertado';
		//Si se usa firebase Insertamos el usuario en FIREBASE
		
	}
	catch(Exception $e) {
		$error_code = $e->getMessage();
		$error = $user->getErrorCode($error_code);
	}
}
//-- ACTUALIZAR USUARIO -- //
elseif(isset($_POST['update_user']))
{
	//Si no se ha marcado la casilla de admin
	if(!isset($_POST['admin']))
	{
		$_POST['admin'] = 0;
	}
	
	//Insertamos los datos
	try {
		$user->updateUserData($_POST['id_user'],$_POST);
		$success = "Datos actualizados";
	}
	catch(Exception $e) {
		$error_code = $e->getMessage();
		$error = $user->getErrorCode($error_code);
	}
}
elseif($sub == 'delete_user' && isset($_GET['id']))
{
	//echo "USUARIO BORRADO";
	//Borramos el usuario
	try {
		$user->deleteUser($_GET['id']);
		$success = "Usuario borrado";
	}
	catch(Exception $e) {
		$error_code = $e->getMessage();
		$ec = $user->getErrorCode($error_code);
		$error = "Problema: " . $ec['title'];
	}
}
?>


<?php 

if($error != '') 
{
	createSnack($error,'error');
}
elseif($success != '')
{
	createSnack($success,'success');
}


?>



<?php
//Página a mostrar
if($sub == 'edit_user')
{
	snippet('admin/admin_users_form.php'); 
}
else 
{
	snippet('admin/admin_users_table.php'); 
}


?>


