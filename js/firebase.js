// JavaScript Document
$(document).ready( function() {
	//Comprobamos que el usuario está logeado
	firebase.auth().onAuthStateChanged(function(user) {
	  if (user) {
		// User is signed in.
		
		//Añadimos el apunte a su base de datos
		var user = firebase.auth().currentUser;
		if (user != null) {
			uid = user.uid; 
			var now = Math.floor(Date.now() / 1000);
			firebase.database().ref('users/' + uid + '/lastLogin').set(now);
			console.log('logeado en firebase: ' + uid + ' - ' + now);
		}  
		
	  } else {
		alert('Se ha producido un error al logear el usuario en la base de datos.')
		
	  }
	  // ...
	});
});