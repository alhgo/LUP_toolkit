# LUP_toolkit
Toolkit desarrollado por La Última Pregunta

## La explicación
Realmente esta serie de herramientas propias y de terceros pretende ahorrar trabajo a la hora de crear una aplicación web desde cero: carga de librerías, snippets, conexiones con bases de datos, etc. 

Está basado en parte en un CMS que he utilizado bastante (Kirby), pero que a menudo me daba más de lo que necesitaba. Aparte, se base en:


- Bootstrap
- Framework Kirby (https://getkirby.com/): lo he usado para otros proyectos con mucho gusto, pero para este proyecto quería algo más simple y he optado por crear mis propias clases, muchas de ellas están inspiradas (cuando no copiadas pero acreditadas) de dicho Framework.
- MysqliDb.php (https://github.com/ThingEngineer/PHP-MySQLi-Database-Class): he querido probar esta librería para conexión con Base de datos, a ver qué tal.
- Google Maps
- Librería PHPMailer para el envío de correos (de momento usando las funciones básicas,sin utilizar la funcionalidad de servidores SMTP): https://github.com/PHPMailer/PHPMailer
- Como añadido, para enviar correos con formato HTML se ha usado el ejemplo aportado por https://github.com/leemunroe/responsive-html-email-template
- Alerta para cookies: https://github.com/Wruczek/Bootstrap-Cookie-Alert
- Jquery Overlay: https://gasparesganga.com/labs/jquery-loading-overlay/
- Base de datos en tiempo real firebase: https://firebase.google.com/
- Librería PHP para poder conectarse con Firebase https://firebase-php.readthedocs.io/en/latest/


## Requsitos
- Servidor PHP versión 7 o superior con extensión mbstring instalada.
- Servidor MYSQL
- Firebase
- Clave de desarrollador de Google para usar las APIS de Google Maps


