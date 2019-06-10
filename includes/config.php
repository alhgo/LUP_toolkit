<?php 
//Configuración básica de la página
c::set('site.title','LA ÚLTIMA PREGUNTA');
c::set('site.url','');
c::set('site.descr','Toolkit desarrollado por La Última Pregunta');
c::set('site.auth','Álvaro Holguera');

//Nombre de la cookie creada por el sitio
c::set('cookie.user','lupUser');

//Menú de navegación
c::set('site.nav',array(
    1 => array(
        'text' => 'Menú 1',
        'page' => 'page1.php',
        'action' => 'p1'
    ),
    2 => array(
        'text' => 'Menú 2',
        'page' => 'page1.php',
        'action' => 'p1'
    )
));

//MAIL
//La librería PHPMailer necesita un remitente con un dominio válido, o no funcionará
c::set('mail.from','noreply@laultimapregunta.com'); //Remitente de los correos enviados automáticamente
c::set('mail.fromName','Alhgo'); //Remitente de los correos enviados automáticamente
c::set('mail.contact','noreply@laultimapregunta.com');

/*
---------------------
MYSQL
--------------------
NOTA: Debe existir la base de datos con la estructura básica para gestionar usuarios
*/
c::set('use.database',true); //Poner TRUE si se quiere habilitar la gestión de usuarios
c::set('db.host','localhost');
c::set('db.database','database_name'); //Nombre de la Base de Datos
c::set('db.username','root');
c::set('db.password','');
c::set('db.port',3306);

//ADMIN SIDEBAR
//FA icons available: https://fontawesome.com/icons
c::set('admin.sidebar',array(
    1 => array(
        'text' => 'Admin',
        'page' => 'admin.php',
        'icon' => 'wrench',
        'action' => ''
    ),
    2 => array(
        'text' => 'Usuarios',
        'page' => 'admin.php',
        'icon' => 'users',
        'action' => 'users'
    ),
	3 => array(
		'text' => 'Newsletter',
		'icon' => 'envelope',
		'action' => 'newsletter',
		'submenu' => array(
			1 => array(
				'text' => 'Crear',
				'page' => 'admin.php',
				'action' => 'newsletter'
				),
			2 => array(
				'text' => 'Listado',
				'page' => 'admin.php',
				'action' => 'newsletter',
				'sub' => 'newsletter_list'
				)
			)
		)
		
	)
);

/*
---------------------
FIREBASE
--------------------
*/

c::set('use.firebase',false); //Cambiar a true si se quiere usar la BD Firebase
c::set('fb.url','https://your_firebase_database.firebaseio.com/'); //Cambiar por la URL de la BD

//Archivo de config en carpeta includes. 
//Panel de Control de FB -> Configuración del proyecto -> Cuentas de servicio -> SDK de Firebase -> generar nueva clave
c::set('fb.jsonFile','google-service-account.json'); 
//Secreto de la Base de Datos. Obsoleto.
//Panel de Control de Firebase -> Configuración del proyecto -> Cuentas de servicio -> Secretos de la Base de datos
c::set('fb.token','SecretKey'); 
//Datos para logeo por correo
c::set('fb.admin_email','');
c::set('fb.admin_pass','');
c::set('fb.admin_uid','');

//Datos para iniciar la APP (obtenidas de la consola de FB)
c::set('fb.apiKey','firebase_API');
c::set('fb.authDomain','firebase_authDomain');
c::set('fb.databaseURL','databaseURL');
c::set('fb.projectId','projectID');
c::set('fb.storageBucket','storageBucket');
c::set('fb.messagingSenderId','messagingSender');



?>