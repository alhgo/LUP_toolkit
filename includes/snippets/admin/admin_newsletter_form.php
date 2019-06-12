<?php

$user = new Users;

//Obtenemos los tipos de usuarios
$users_type = $user->getUsersType();


?>


<h2>Crear un nuevo newsletter</h2>

<form action="admin.php?action=newsletter&sub=insert" method="post">
  <div class="form-group">
    <label for="nl_title">Título</label>
    <input type="text" class="form-control" id="nl_title" name="nl_title" placeholder="Título del mensaje">
  </div>

  <div class="form-group">
    <label for="nl_users_cats">Seleccionar los destinatarios</label>
    <select multiple class="form-control" id="nl_users_cats" name="nl_users_cats[]">
	  <?php foreach($users_type AS $key => $value) : ?>
	  <option value="<?= $key ?>"><?= $value['name'] ?></option>
      <?php endforeach ?>
    </select>
	  <small class="form-text text-muted"><a href="#" id="select_all_cats">Seleccionar todos - Alt+click oara deseleccionar</a><br>(si no se selecciona ninguno, solo se enviará a los administradores)</small>
  </div>
  <hr>	
  <div class="form-group">	
	  
	<div class="form-check form-check-inline" >
	  <input class="form-check-input" type="radio" name="nl_format" id="format1" value="html" checked onchange="toggleArea1();">
	  <label class="form-check-label" for="format1">HTML</label>
	</div>
	<div class="form-check form-check-inline">
	  <input class="form-check-input" type="radio" name="nl_format" id="format2" value="text" onchange="toggleArea1();">
	  <label class="form-check-label" for="format2">Texto</label>
	</div>
  </div>

	
	
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Cuerpo</label>
    <textarea class="form-control" id="body" name="nl_body" rows="3"></textarea>
  </div>
  <hr>	
  <div class="form-group">
    <!-- Button trigger modal -->
	<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal">
	  Insertar imagen
	</button>
		</p>
	  <p>
		<img src="" id="image" style="display: none" class="img-fluid">  
	  	<input type="hidden" name="nl_image" id="nl_image" value="" >
	</p>
  </div>
	<hr>	
  <div class="form-group">
    <label for="button_link">Botón con enlace</label>
    <input type="text" class="form-control" id="button_link" name="nl_button_link" placeholder="Escribe el enlace" value="">
	  <small class="form-text text-muted">(Opcional) Si escribes un link, aparecerá como botón al final del correo.</small>
  </div>
	
  <div class="form-group">
    <label for="nl_tit">Correo para mandar prueba</label>
    <input type="text" class="form-control" id="test_email" name="nl_test_email" placeholder="e-mail" value="<?= c::get('mail.contact') ?>">
  </div>
	
  <div class="form-group row">
    <div class="col-sm-10 text-center">
		<button type="submit" class="btn btn-primary">Crear newsletter</button>
    </div>
  </div>
</form>

<?php
	
	$images_thumb = getImages('images/newsletter/thumb');
	//print_r($images_thumb);
	?>

<!-- Images Modal -->
<div class="modal fade bd-example-modal-xl" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-xl">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccionar una imagen de las disponibles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
			
			<?php foreach($images_thumb AS $i) : ?>
			
		  	<div class="col-3 mb-3">
				<img src="<?= $i['url'] ?>" class="img-fluid rounded " alt="<?= $i['file'] ?>" onClick="selectImage('<?= $i['file'] ?>')">
			
			</div>
			
			<?php endforeach ?>
		  
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        
      </div>
    </div>
  </div>
</div>

<script>
	
	function selectImage(archivo){
		console.log(archivo);
		$('#imageModal').modal('hide');
		$("#image").attr("src","images/newsletter/" + archivo);
		//Ponemos en el input oculto la URL del archivo 
		$("#nl_image").attr("value","<?= c::get('site.url') ?>images/newsletter/" + archivo);
		$("#image").slideDown();
	}
</script>


<!--Editor HTML WYSYWIG http://nicedit.com/ -->
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	var area1, area2;
	function toggleArea1() {
        if(!area1) {
                area1 = new nicEditor({fullPanel : true}).panelInstance('body',{hasPanel : true});
        } 
		else if(document.getElementById('format2').checked) {
                area1.removeInstance('body');
                area1 = null;
        }
  	}
 
  bkLib.onDomLoaded(function() { toggleArea1(); });
	
  //document.getElementById('format1').addEventListener('click',toggleArea1);
  
  
  //bkLib.onDomLoaded(nicEditors.allTextAreas);

</script>
	
	