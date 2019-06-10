<?php
$u = new Users;
$users = $u->getUsers();

//Obtenemos los tipos de usuarios
$users_type = $u->getUsersType();
//print_r($users);
?>

<h3>Usuarios registrados</h3>
<hr>
<p>Listado de usuarios registrados</p>
<div style="padding-bottom: 70px">
<table id="users_table" class="table table-striped table-bordered table-sm " style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Correo</th>
				<th></th>
				<th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($users AS $user) : ?>
			
			<?php
			//https://getbootstrap.com/docs/4.0/content/tables/
			$style = '';
			if($user['admin'] == 1)
			{
				$style = 'class="table-danger"';
			}
			
			?>
			<tr <?= $style ?>>
				<td><?= $user['id_user'] ?></td>
				<td><?= $users_type[$user['id_type']]['name']  ?></td>
				<td><?= $user['name'] ?></td>
				<td><?= $user['email'] ?></td>
				<td align="center"><a href="admin.php?action=users&sub=edit_user&id=<?= $user['id_user'] ?>" class="no-underline"><i class="fa fa-edit"></i></td>
				<td align="center"><a onclick="return confirm('¿Seguro que desea borrar al usuario con ID <?= $user['id_user'] ?>? Todos los datos del usuario se perderán.')" href="admin.php?action=users&sub=delete_user&id=<?= $user['id_user'] ?>" class="no-underline"><i class="fa fa-trash"></i></a></td>
			</tr>
		<?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
				<th></th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>
<p align="center"><a href="admin.php?action=users&sub=edit_user" type="button" class="btn btn-primary">Insertar usuario</a></p>
<p></p>
<p></p>
