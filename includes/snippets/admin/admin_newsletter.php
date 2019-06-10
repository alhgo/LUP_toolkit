<?php
$nl = new newsletter;

//Acción a realizar
$sub = (isset($_GET['sub'])) ? $_GET['sub'] : '';
$error = '';
$success = '';

//-- CREAR NEWSLETTER -- //
if($sub=='insert')
{
	//print_r($_POST);
	//Creamos el array para insertar
	$data = array();
	$data['title'] = $_POST['nl_title'];
	$data['body'] = $_POST['nl_body'];
	$data['image'] = $_POST['nl_image'];
	$data['button_link'] = $_POST['nl_button_link'];
	$data['format'] = $_POST['nl_format'];
	$data['test_email'] = $_POST['nl_test_email'];
	//Construimos las categorías
	if(isset($_POST['nl_users_cats']) && count($_POST['nl_users_cats']) != 0)
	{
		$data['id_cats'] = implode(',',$_POST['nl_users_cats']);
	}
	else
	{
		$data['id_cats'] = NULL;
	}
	
	//Insertamos el nl
	try {
		$id_nl = $nl->insertNewsletter($data);

		//Enviamos el newsletter de prueba
		$nl->sendNewsletter('',$id_nl,$data['test_email']);
		
		$success = 'Newsletter creado y correo de prueba enviado a: ' . $data['test_email'];
		
		
	}
	catch(Exception $e) {
		
		$error = "Se ha producido un problema. " . $e;
	}
	
}

//-- BORRAR NEWSLETTER -- //
if($sub=='delete' && isset($_GET['id']) && is_numeric($_GET['id']))
{
	try{
		
		$nl->deleteNewsletter($_GET['id']);
		$success = "newsletter borrado";
	}
	catch(Exception $e) {
		
		$error = "Se ha producido un problema. " . $e;
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
if($sub == 'newsletter_list')
{
	snippet('admin/admin_newsletter_table.php'); 
}
else if($sub == 'insert' && $error == '' && is_numeric($id_nl))
{
	snippet('admin/admin_newsletter_send.php', array('id' => $id_nl)); 
}
else if($sub == 'send' && isset($_GET['id']))
{
	snippet('admin/admin_newsletter_send.php', array('id' => $_GET['id'])); 
}
else 
{
	snippet('admin/admin_newsletter_table.php'); 
}


?>