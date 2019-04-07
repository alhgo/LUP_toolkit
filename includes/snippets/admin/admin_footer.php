<!--MODAL legal notice-->	
<div class="modal fade" id="legalModal">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">

      
	  <?php
		echo file_get_contents('includes/templates/legal.html');
		
		?>
      
	
    </div>
  </div>
</div>
<!--LEGAL NOTICE-->

<!-- COOKIES -->
<div class="alert text-center cookiealert" role="alert">
    <div class="cookiealert-container">
        <p><b>En este sitio usamos cookies &#x1F36A; propias y de terceros (menuda sorpresa, ¿no?)</b>. 
		</p>
		<p>
        <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
            Acepto
        </button>
        </p>
		<p>Pincha <a href="#" data-toggle="modal" data-target="#legalModal">aquí</a> para saber más</p>
        
    </div>
</div>
<!-- /COOKIES -->


<footer class="footer">
  <div class="container">
	<p class="text-center"><span class="text-muted"><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a>
		LaUltimaPregunta.com</span></p>
  </div>
</footer>
	<script>
	//Global vars
	var siteUrl = '<?= c::get('site.url') ?>';
    </script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/admin/jquery.min.js"></script>
    <script src="js/admin/bootstrap.bundle.min.js"></script>
    <script src="js/admin/cookiealert-standalone.js"></script>
	<script src="js/admin/popper.min.js"></script>

	<!--Jquery Tables: https://datatables.net/  https://datatables.net/examples/styling/bootstrap4.html-->
	<script type="text/javascript" charset="utf8" src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
	
	
<script>
$(document).ready(function() {
    
	$('#users_table').DataTable();
	
	
} );
</script>

	<!--Notificaciones Noty https://ned.im/noty/#/-->
	<script src="plugins/noty/noty.js" type="text/javascript"></script>

	<?php if(c::get('use.firebase',false)) : ?>
	<script src="js/admin/firebase.js"></script>
	<?php endif ?>
	<!--Specific js files-->
	<?php
	if(isset($libs) && is_array($libs))
	{
		foreach($libs AS $lib)
		{
			echo '
	<script src="js/' . $lib . '"></script>';
		}
	}

	
	
	?>



  