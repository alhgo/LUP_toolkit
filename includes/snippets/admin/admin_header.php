<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site->descr ?>">
    <meta name="author" content="<?= $site->auth ?>">

    <title><?= $site->title ?></title>
    
    <link rel="icon" href="images/web-icon.png" type="image/x-icon" >
	<link rel="shortcut icon" href="images/web-icon.png" type="image/x-icon" >

    <!-- Site Stylesheet -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	  
    <!-- Custom Fonts -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!--Cookie Alert https://github.com/Wruczek/Bootstrap-Cookie-Alert-->
    <link rel="stylesheet" href="css/cookiealert.css">
	  
	<!-- Scrollbar Custom CSS 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">-->
	  
	<!--Jquery Tables: https://datatables.net/  https://datatables.net/examples/styling/bootstrap4.html-->
	 <link rel="stylesheet" type="text/css" href="plugins/datatables/dataTables.bootstrap4.min.css">
	  
	<!--Notificaciones Noty https://ned.im/noty/#/-->
	<link href="plugins/noty/noty.css" rel="stylesheet">
	<link href="plugins/noty/themes/bootstrap-v4.css" rel="stylesheet">
	  
	
	  
	  
	<?php if(c::get('use.firebase',false)) : ?>
	<!--Firebase-->
	<script src="https://www.gstatic.com/firebasejs/5.4.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/5.4.0/firebase-auth.js"></script>
	<script src="https://www.gstatic.com/firebasejs/5.4.0/firebase-database.js"></script>
	  
	<script>
	  // Initialize Firebase
	  var config = {
		apiKey: "<?= c::get('fb.apiKey') ?>",
		authDomain: "<?= c::get('fb.authDomain') ?>",
		databaseURL: "<?= c::get('fb.databaseURL') ?>",
		projectId: "<?= c::get('fb.projectId') ?>",
		storageBucket: "<?= c::get('fb.storageBucket') ?>",
		messagingSenderId: "<?= c::get('fb.messagingSenderId') ?>"
	  };
	  firebase.initializeApp(config);
	  <?php if(isset($user) && $user->logged) : ?> 	
	
		//FB Auth. Si no está logeado, lo hacemos
		var user = firebase.auth().currentUser;
		firebase.auth().onAuthStateChanged(function(user) {
			if(user == null) {
			//Configuramos la persistencia para SESSION
			//https://firebase.google.com/docs/auth/web/auth-state-persistence?hl=es-419
			firebase.auth().setPersistence(firebase.auth.Auth.Persistence.SESSION)
		  .then(function() {
				console.log('Signed In FB');
				firebase.auth().signInWithCustomToken('<?= $user->user_data['custom_token'] ?>')
				.catch(function(error) {
				// Handle Errors here.
				var errorCode = error.code;
				var errorMessage = error.message;
				if(error)
				  {
					  alert("ERROR: " . errorCode);
					  window.location.href = '<?= c::get('site.url') ?>/error.php?error=FirebaseUserLogin&add=errorCode:' + errorCode;
				  }
					});
				});
			}
			else{
				//Añadimos el apunte de logeo
				uid = user.uid; 
				var now = Math.floor(Date.now() / 1000);
				firebase.database().ref('users/' + uid + '/lastLogin').set(now);
				console.log('FB Last Login:' + ' ' + now);
			}
		});

		<?php endif ?>
	</script>

	<?php endif ?>
  
</head>