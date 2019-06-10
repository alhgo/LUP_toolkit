<?php

$user = new Users;

//Obtenemos los tipos de usuarios
$users_type = $user->getUsersType();
		

	
//Si se ha pasado un id de usuario
if(isset($_GET['id']))
{
	$u = $user->getUserDataById($_GET['id']);
	
	$tit = 'Editar usuario';
	$subtit = 'Modificar los datos de usuario (ID: ' . $_GET['id'] . ')';
	$btn = 'Actualizar';
	$btn_action = 'update_user';
}
else
{
	$u = '';
	$tit = 'Insertar usuario';
	$subtit = 'Crear un nuevo usuario';
	$btn = 'Insertar';
	$btn_action = 'insert_user';
}


?>


<h3><?= $tit ?></h3>
<hr>
<p><?= $subtit ?></p>



<form action="admin.php?action=users" method="post">
    <?php if(is_array($u)) : ?>  
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label text-right">Nombre de usuario</label>
    <div class="col-sm-8">
      <input type="text" required readonly class="form-control-plaintext" id="username" name="username" value="<?= $u['username'] ?>">
    </div>
  </div>
	
	
	  <?php if(c::get('use.firebase')) : ?>	
		  <div class="form-group row">
			<label for="staticEmail" class="col-sm-4 col-form-label text-right">Token de Firebase</label>
			<div class="col-sm-8">
			  <input type="text" required readonly class="form-control-plaintext" id="fb_token" name="fb_token" value="<?= $u['fb_token'] ?>">
			</div>
		  </div>	
	  <?php endif ?>	
	
  <?php else : ?>	
  <div class="form-group row">
    <label for="inputName" class="col-sm-4 col-form-label text-right">Nombre de usuario</label>
    <div class="col-sm-8">
      <input type="text" required class="form-control" id="username" name="username" placeholder="Nombre de usuario" value="<?php echo (is_array($u)) ? $u['username'] : '' ?>">
		<small id="usernameHelp" class="form-text text-muted">No puede estar repetido</small>
    </div>
  </div>
  <?php endif ?>
	
  <div class="form-group row">
    <label for="inputName" class="col-sm-4 col-form-label text-right">Nombre completo</label>
    <div class="col-sm-8">
      <input type="text" required class="form-control" id="name" name="name" placeholder="Nombre completo" value="<?php echo (is_array($u)) ? $u['name'] : '' ?>">
    </div>
  </div>
		
  <div class="form-group row">
    <label for="inputName" class="col-sm-4 col-form-label text-right">Correo</label>
    <div class="col-sm-8">
      <input type="email" required class="form-control" id="email" name="email" placeholder="Correo electrónico" value="<?php echo (is_array($u)) ? $u['email'] : '' ?>">
    </div>
  </div>
	
  <div class="form-group row">
    <label for="id_type" class="col-sm-4 col-form-label text-right">Categoría de usuario</label>
    <div class="col-sm-8">
      <select class="form-control" id="id_type" name="id_type">
		  <option value="">Categoría</option>
		<?php foreach($users_type AS $key => $value) : ?>
		  <option value="<?= $key ?>" <?php echo (is_array($u) && $u['id_type'] == $key) ? 'selected' : '' ?>><?= $value['name'] ?></option>
		<?php endforeach ?>
    </select>
    </div>
  </div>
	

	
  <div class="form-group row">
    <label for="inputName" class="col-sm-4 col-form-label text-right">Contraseña</label>
    <div class="col-sm-8">
      <input type="text" <?php echo (!is_array($u)) ? 'required' : '' ?> class="form-control" id="password" name="password" placeholder="" value="" autocomplete="off" >
	  <?php if(is_array($u)) : ?>	
      <small id="passwordHelp" class="form-text text-muted">Dejar en blanco para que no cambie</small>	<?php endif ?>	
    </div>
  </div>
	
  <div class="form-group row">
    <label for="birth" class="col-sm-4 col-form-label text-right">Año de nacimiento</label>
    <div class="col-sm-8">
      <select class="form-control" id="birth" name="birth">
      	<?php for($n=date('Y');$n>=1900;$n--) : ?>
		  <option value="<?= $n ?>" <?php echo (is_array($u) && $u['birth'] == $n) ? 'selected' : '' ?>>Año <?= $n ?></option>
		<?php endfor ?>
    </select>
    </div>
  </div>
	
  <div class="form-group row">
    <div class="col-sm-4 text-right">Administrador</div>
    <div class="col-sm-8">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="admin" name="admin" value="1" <?php echo (is_array($u) && $u['admin'] == 1) ? 'checked' : '' ?>>
        <label class="form-check-label" for="gridCheck1">
          (el usuario tendrá acceso al panel de control)
        </label>
      </div>
    </div>
  </div>
	
  <div class="form-group row">
    <div class="col-sm-10 text-center">
      	<input type="hidden" name="<?= $btn_action ?>">
		<?php if(is_array($u)) : ?>
      	<input type="hidden" name="id_user" value="<?= $_GET['id'] ?>">
		<?php endif ?>
		<button type="submit" class="btn btn-primary"><?= $btn ?></button>
		<a href="admin.php?action=users" class="btn btn-warning">Volver</a>
    </div>
  </div>	
</form>
