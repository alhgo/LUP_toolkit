<?php
/**
 *
 * Conjunto de clases desarrolladas para el toolkit de La Última Pregunta
 *
 * Aplicación ideada para Izquierda Independiente Iniciativa por San Sebastián de los Reyes
 *
 * @author Álvaro Holguera <profesor@laultimapregunta.com>
 * @license https://github.com/alhgo/LUP_toolkit/blob/master/LICENSE
 */

//Clase que establece las variables y constantes del sitio
//Inspirado en http://getkirby.com

//Firebase
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class C {

  public static $data = array();

  public static function set($key, $value = null) {
    if(is_array($key)) {
      return static::$data = array_merge(static::$data, $key);
    } else {
      return static::$data[$key] = $value;
    }
  }

  public static function get($key = null, $default = null) {
    if(empty($key)) return static::$data;
    return isset(static::$data[$key]) ? static::$data[$key] : $default;
  }

  public static function remove($key = null) {
    // reset the entire array
    if(is_null($key)) return static::$data = array();
    // unset a single key
    unset(static::$data[$key]);
    // return the array without the removed key
    return static::$data;
  }

}

//Escribir entradas en archivos de registro 
class Log
{
	
	public function putErrorLog($txt)
	{
		$line = date("j.n.Y H:i:s") . ': ' . $txt . "\r\n";
		file_put_contents(dirname(__FILE__) . "/../error_log.txt", $line, FILE_APPEND);
		
	}
	
}
//Clase que devuelve los datos principales del sitio
class Site
{
	public $title;
	public $url;
	public $descr;
	public $auth;

	function __construct()
	{
		$this->title = c::get('site.title');
		$this->url = c::get('site.url');
		$this->descr = c::get('site.descr');
		$this->auth = c::get('site.auth');
        
	}
	
	//Ir a una página específica del sitio
	public function go($page)
	{
		header("Location:" . c::get('site.url') . '/' . $page);
  		exit();
	}
	
	
}

//Clase que permite insertar snippets
class Snippet
{
	public $file;
	public $data = array();
	public $return = false;
	private $file_path;
	
	public function __construct($file,$data,$return)
	{
		$this->file = $file;
		$this->data = $data;
		$this->return = $return;
		$this->file_path = 'includes/snippets/' . $this->file;
	}
	
	//Mostramos el array
	public function show()
	{
		//
		foreach($this->data AS $key => $value)
		{
			$$key = $value;
		}
		
		//Si no se ha especificado lo contrario, incrustamos la página
		if(is_file($this->file_path))
		{
			if(!$this->return)
			{
				include($this->file_path);
			}
			else
			{
				return file_get_contents($this->file_path);
			}
		}
		
	}
}

class URL
{
	
	public function getBaseUrl() 
	{
		$baseURL = array();
		// output: /myproject/index.php
		$currentPath = $_SERVER['PHP_SELF']; 

		// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
		$pathInfo = pathinfo($currentPath); 

		// output: localhost
		$hostName = $_SERVER['HTTP_HOST']; 

		// output: http://
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

		// return: http://localhost/myproject/
		return $protocol.'://'.$hostName.$pathInfo['dirname']."/";

	}
	
	public function go($target, $local = true)
	{
		$site = new Site;
		if($local)
		{
			$target = $site->url . '/' . $target;	
		}
		
		header("Location: $target");
		die();
	}
}

//Clase que permite gestionar los usuarios
class Users
{
	
	public $logged = false;
	public $id;
	public $is_admin = false;
	public $user_data = array();
	private $db;
	
	private $site;
	
	function __construct()
	{
		//Obtenemos los datos del sitio
		$site = new Site;
		
		//Conectamos con la base de datos
		$this->db = new MysqliDb (Array (
                'host' => c::get('db.host'),
                'username' => c::get('db.username'), 
                'password' => c::get('db.password'),
                'db'=> c::get('db.database'),
                'port' => 3306,
                'prefix' => '',
                'charset' => 'utf8'));
		
		
		
		//Si el usuario está logeado, lo indicamos y obtenemos sus datos
		if(isset($_COOKIE[c::get('cookie.user')])) {
			$this->logged = true;
			$this->id = $_COOKIE[c::get('cookie.user')];
			//Obtenemos los datos
			$this->user_data = $this->getUserData($this->id);
			$this->is_admin = ($this->user_data['admin'] == 1) ? true : false;
			
		} 
	}
	
	function __destruct(){
		$this->db->disconnect();
	}
	
	//Obtener un array con los tipos de usuario [id] = array(name => 'Nombre', descr => 'Descripción')
	public function getUsersType()
	{
		$users_type = array();
		$db = $this->db;
		$t = $db->get('users_type');
		foreach($t AS $type)
		{
			$users_type[$type['id_type']]['name'] = $type['name'];
			$users_type[$type['id_type']]['descr'] = $type['descr'];
		}
		
		return $users_type;
	}
	
	//Obtener lista de usuarios, con la posibilidad de pasar una condición SQL
	public function getUsers($cond="")
	{
		$db = $this->db;
		//Si hay condiciones
		if($cond != '')
		{
			$users = $db->rawQuery("SELECT * FROM users " . $cond);
		}
		else
		{
			$users = $db->get('users');
		}
		
		return $users;
	}
	
	private function getUserData($id)
	{
		
		$db = $this->db;
		$db->where ("id_user", $id);
		$user = $db->getOne ("users");
		
		//Si se está usando Firebase
		if(c::get('use.firebase'))
		{
			//Comprobamos que el archivo de configuración de Firebas existe
			if(!is_file(__DIR__.'/../' . c::get('fb.jsonFile')))
			{
				url::go('error.php?error=FirebaseFile');
				
			}
			//Añadimos la configuración de marcas de firebase
			$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../' . c::get('fb.jsonFile'));
			$firebase = (new Factory)
				->withServiceAccount($serviceAccount)
				->withDatabaseUri(c::get('fb.url'))
				->create();

			$uid = $user['fb_token'];

			//Obtenemos los datos de configuración para visualizar las marcas
			$database = $firebase->getDatabase();
			$reference = $database->getReference('users/' . $uid);
			$value = $reference->getValue();
			$user['marks_config'] = $value;
			
			//Añadimos el Custom Token para poder autenticarse en Firebase
			$user['custom_token'] = $firebase->getAuth()->createCustomToken($uid);
		}
	
		return $user;
	}
	
	public function getUserDataByUsername($username)
	{
		
		$db = $this->db;
		$db->where ("username", $username);
		$user = $db->getOne ("users");
		return $user;
	}
	
	public function getUserDataById($id)
	{
		
		$db = $this->db;
		$db->where ("id_user", $id);
		$user = $db->getOne ("users");
		return $user;
	}
	
	public function loginUser($username, $password, $remember = 'false')
	{
		$db = $this->db;
		$db->where ('username', $username);
		$db->where ('password', md5($password));
		$result = $db->getOne ('users');
		if($db->count != 0)
		{
			//Creamos las cookies
			$cookie_value = $result['id_user'];
			//Si no se ha marcado la casilla de recordar, la ponemos para un día
			if ($remember == 'true') {
				$time_duration = time() + (365 * 24 * 60 * 60);
			}
			else
			{
				$time_duration = time() + 86400;
			}
			setcookie(c::get('cookie.user'), $cookie_value, $time_duration, '/');
			//Devolvemos los datos del usuario
			$this->user_data = $this->getUserData($result['id_user']);
			$this->is_admin = ($this->user_data['admin'] == 1) ? true : false;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function usernameExists($username)
	{
		$db = $this->db;
		$db->where ('username', $username);
		$result = $db->getOne ('users');
		if($db->count != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function userEmailExists($email)
	{
		$db = $this->db;
		$db->where ('email', $email);
		$result = $db->getOne ('users');
		if($db->count != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Función que inserta un usuario temporal
	//Se pasa un array con las claves con los nombres de los campos
	//Por defecto manda un correo con el enlace
	
	public function userInsertTemp($data,$mail=true)
	{
		$db = $this->db;
		if($this->usernameExists($data['username']))
		{
			throw new Exception(0);
		}
		else if($this->userEmailExists($data['email']))
		{
			throw new Exception(1);
		}
		else
		{
			//Insertamos los datos
			$id = $db->insert ('users_temp', $data);
			if(!$id)
			{
				throw new Exception(2);
			}
			else if($mail == true && isset($data['token']))
			{
				//Enviamos el correo
				//Declaramos las clases	
				$mail = new PHPMailer(true);
				//Desactivamos el modo de debug para que no muestre errores
				$mail->SMTPDebug = false;
				$mail->do_debug = 0;
				
				//Construimos el cuerpo
				$body = new mailBody; 
				//Construimos el texto de previo para algunos clientes
				$body->bodyPreheader = "Solicitud de registro en " . $site->title;
				//Construimos el cuerpo, que incluye párrafos y un botón
				$url_confirm = c::get('site.url') . '/user.php?action=confirmUser&id=' . $id . '&token=' . $data['token'];
				//echo $url_confirm;
				$button = $body->bodyButton($url_confirm,"Confirmar correo");
				$body->bodyContent = "
									<p>Se ha recibido la solicitud para registrarse en " . $site->title . ". Visite el siguiente enlace para confirmar su cuenta de correo $url_confirm </p>
									" . $button . "
									<p>Deberá visitar el enlace en las siguientes 24 horas después del registro.</p>";
				$body->getBodyHTML();

				//Datos del correo
				$mail->setFrom(c::get('mail.from'), c::get('mail.fromName'));
				if(isset($data['name']))
				{
					$mail->addAddress($data['email'],$data['name']);
				}
				else
				{
					$mail->addAddress($data['email']);
				}
				$mail->Subject  = 'Solicitud de registro en ' . $site->title;
				$mail->isHTML(true); //Indicamos que es un correo HTML
				$mail->CharSet = 'UTF-8'; //Convertimos los caracteres a UTF8
				$mail->Body = $body->bodyHTML; //Insertamos el cuerpo construido previamente
				//Enviamos el correo y comprobamos que se ha mandado correctamente	
				
				try {
					//Desactivamos los errores de la clase PHP Mailer
					@$mail->send();
					return $id;
					
				} catch (Exception $e) {
				  	//Insertamos un mensaje de error en el LOG
					$error_msg = 'Se ha producido un error al enviar el correo al usuario temporal (ID: ' . $id . '). Código de error: ' . $mail->ErrorInfo;
					log::putErrorLog($error_msg);
					
					throw new Exception(3);

				} 
				
			}
			else
			{
				//Se han insertado los datos temporales, pero sin correo
				return $id;
			}
			
		}
	}
	
	public function userConfirmTemp($id,$token,$mail=true)
	{
		$db = $this->db;
		//Comprobamos que los datos pasados son correctos
		$db->where ('id', $id);
		$db->where ('token', $token);
		$results = $this->db->getOne ('users_temp');
		if ($db->count == 0)
		{
			throw new Exception(4);
		}
		else
		{
			//Datos a insertar
			$data = array(
				'username' => $results['username'],
				'name' => $results['name'],
				'email' => $results['email'],
				'password' => $results['password'],
				'birth' => $results['birth'],
				'admin' => 0,
				'time_confirmed' => time()
			);
			//Insertamos los datos
			$id_user = $db->insert ('users', $data);
			if(!$id_user)
			{
				
				throw new Exception(2);
			}
			else 
			{
				//Borramos el usuario temporal
				$db->where('id', $id);
				$db->delete('users_temp');
				if($mail == true)
				{
					//Enviamos el correo
					$mail = new PHPMailer(true);
					//Desactivamos el modo de debug para que no muestre errores
					$mail->SMTPDebug = false;
					$mail->do_debug = 0;
					//Construimos el cuerpo
					$body = new mailBody; 
					//Construimos el texto de previo para algunos clientes
					$body->bodyPreheader = "Confirmado registro de usuario en " . $site->title . "";
					$body->bodyContent = "
										<p>Se ha confirmado el registro de usuario en la aplicación <a href='" . c::get('site.url') . "'>" . $site->title . "</a>.</p>
										
										<p>Gracias por tu participación.</p>";
					$body->getBodyHTML();

					//Datos del correo
					$mail->setFrom(c::get('mail.from'), c::get('mail.fromName'));
					if(isset($data['name']))
					{
						$mail->addAddress($data['email'],$data['name']);
					}
					else
					{
						$mail->addAddress($data['email']);
					}
					$mail->Subject  = 'Registro de usuario confirmado en ' . $site->title;
					$mail->isHTML(true); //Indicamos que es un correo HTML
					$mail->CharSet = 'UTF-8'; //Convertimos los caracteres a UTF8
					$mail->Body = $body->bodyHTML; //Insertamos el cuerpo construido previamente
					//Enviamos el correo y comprobamos que se ha mandado correctamente	
					try {
						//Desactivamos los errores de la clase PHP Mailer
						@$mail->send();
						return $id;

					} catch (Exception $e) {
						//Insertamos un mensaje de error en el LOG
						$error_msg = 'Se ha producido un error al enviar el correo de confirmación de registro (ID: ' . $id_user . '). Código de error: ' . $mail->ErrorInfo;
						log::putErrorLog($error_msg);

					}
				}
				
				return $id_user;
			}
			
		}
		
	}
	
	public function insertUser($data)
	{
		//Comprobamos que no existe un isuario con ese correo o nombre de usuario
		$db = $this->db;
		$db->where ('username', $data['username']);
		$result = $this->db->getOne ('users');
		$c1 = $db->count;
		
		$db = $this->db;
		$db->where ('email', $data['email']);
		$result = $this->db->getOne ('users');
		$c2 = $db->count;
		
		if ($c1 != 0)
		{
			throw new Exception(0);
		}
		else if($c2 != 0)
		{
			throw new Exception(1);
		}
		else
		{
			//Datos a insertar
			$insert = array(
				'username' => $data['username'],
				'id_type' => $data['id_type'],
				'name' => $data['name'],
				'email' => $data['email'],
				'password' => md5($data['password']),
				'birth' => $data['birth'],
				'admin' => $data['admin'],
				'time_confirmed' => time()
			);
			//Insertamos los datos
			$id_user = $db->insert ('users', $insert);
			if(!$id_user)
			{
				throw new Exception(2);
			}
			else 
			{	
				//Si se está usando firebase
				if(c::get('use.firebase'))
				{
					
					//Si no se encuentra el archivo de configuración indicamos el error
					if(!is_file(__DIR__.'/../' . c::get('fb.jsonFile')))
					{
						url::go('error.php?error=FirebaseFile');

					}
					//Añadimos la configuración de marcas de firebase
					$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../' . c::get('fb.jsonFile'));
					$firebase = (new Factory)
						->withServiceAccount($serviceAccount)
						->withDatabaseUri(c::get('fb.url'))
						->create();
					$database = $firebase->getDatabase();
					$newPost = $database
						->getReference('users')
						->push([
							'id' => $id_user,
							'confirmed' => time(),
							'username' => $_POST['username']
						]);
					//Obtenemos la clave FB
					$fb_key = $newPost->getKey();
					//Lo insertamos en la base de datos
					$user = new Users;
					$user->userInsertFBtoken($id_user,$fb_key);
				}
				return $id_user;
			}
			
		}
		
	}
	
	//Update user data
	public function updateUserData($id_user,$data)
	{
		$db = $this->db;
		
		//Datos a actualizar
		$update = array(
			'username' => $data['username'],
			'id_type' => $data['id_type'],
			'name' => $data['name'],
			'email' => $data['email'],
			'birth' => $data['birth'],
			'admin' => $data['admin']
		);
		
		//Si se ha pasado una contraseña nueva
		if(trim($data['password']) != '')
		{
			$update['password'] = md5($data['password']);
		}
		
		$db->where ('id_user', $id_user);
		if ($db->update ('users', $update))
		{	
			return true;
		}
		else
		{
			//Insertamos el log
			log::putErrorLog("Error al actualizar los datos del usuario con ID $id_user (" . $db->getLastError() . ")");
			throw new Exception(2);
			return false;
			
		}
		
	}
	
	public function deleteUser($id_user)
	{
		//Comprobamos que el usuario existe y obtenemos sus datos
		$db = $this->db;
		$db->where('id_user',$id_user);
		if($user = $db->getOne('users'))
		{
			//Si tiene token de Firebase lo obtenemos
			if(isset($user['fb_token']) && $user['fb_token'] != '')
			{
				//Comprobamos que el archivo de configuración de Firebas existe
				if(!is_file(__DIR__.'/../' . c::get('fb.jsonFile')))
				{
					url::go('error.php?error=FirebaseFile');

				}
				//Añadimos la configuración de marcas de firebase
				$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../' . c::get('fb.jsonFile'));
				$firebase = (new Factory)
					->withServiceAccount($serviceAccount)
					->withDatabaseUri(c::get('fb.url'))
					->create();
				
				$database = $firebase->getDatabase();
				//Borramos al apunte del usuario
				$ref = 'users/' . $user['fb_token'];
				$database->getReference($ref)->remove();
			}
			//Borramos el usuario de la base de datos
			$db->where('id_user',$id_user);
			$db->delete('users',1);
		}
		else
		{
			throw new Exception(4);
		}
	}
	
	//Función que resetea la contraseña de un usuario
	public function resetPass($id, $email='')
	{
		//Creamos un token e insertamos la petición en la tabla
		$token = md5(uniqid(rand(), true));
		$db = $this->db;
		$data = array(
				'id_user' => $id,
				'token' => $token,
				'time_expire' => time() + 86400,
				'time_confirm' => 'NULL'
			);
			//Insertamos los datos
			$id_reset = $db->insert ('password_reset', $data);
			
			//Si se ha especjificado un usuario, le mandamos el correo
		
			return $id_reset;
		
	}
	
	//Función que inserta o borra la configuración del usuario para recibir notificaciones
	public function userCatNotice($id_user,$id_cat,$action)
	{
		$db = $this->db;
		//Action es un buleano: true -> activar / false -> desactivar
		if($action == 'true')
		{
			$data = array(
				'id_user' => $id_user,
				'id_cat' => $id_cat
			);
			$id = $db->insert ('users_cats_notice', $data);
			
		}
		else
		{
			$db->where('id_user', $id_user);
			$db->where('id_cat', $id_cat);
			$id = $db->delete('users_cats_notice');
		}
		
		//Si ha ido bien
		if($id)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	public function userInsertFBtoken($id_user,$token)
	{
		$db = $this->db;
		$data = Array (
			'fb_token' => $token
			);
		$db->where ('id_user', $id_user);
		$db->update ('users', $data);
		
	}
	
	public function destroyCookie()
	{
		$cookiename = c::get('cookie.user');
		setcookie($cookiename, null, time() - 3600, "/");
	}
	
	
	//Los errores de las funciones geters y seters están codificados
	//Cada código de error tiene un título "title" y un texto "text"
	/*
	--Códigos de error--
	[0] -> Ya existe un usuario registrado con ese nombre de usuario
	[1] -> Ya existe un usuario registrado con ese correo electrónico
	[2] -> Se ha producido un error al insertar los datos en la base de datos
	[3] -> Se ha producido un error al enviar el correo con la URL de confirmación
	[4] -> No existe un usuario registrado con los datos aportados
	
	*/
	public function getErrorCode($error)
	{
		
		$return = array();
		$return[0] = array(
			'title' => "Nombre de usuario ya registrado",
			'text' => 'El nombre de usuario ya está dado de alta en la base de datos.'
		);
		$return[1] = array(
			'title' => "Correo ya registrado",
			'text' => 'El correo ya está dado de alta en la base de datos.'
		);
		$return[2] = array(
			'title' => "No se han insertado los datos en la base de datos.",
			'text' => 'Se ha producido un error al insertar los datos del usuario en la base de datos.'
		);
		
		$return[3] = array(
			'title' => "No se ha podido enviar el correo de confirmación.",
			'text' => 'Se ha producido un error al enviar el correo con la URL de confirmación. Vuelva a intentarlo más tarde.'
		);
		
		$return[4] = array(
			'title' => "Error al obtener el usuario registrado",
			'text' => 'No existe ningún usuario registrado con los datos aportados.'
		);
		
		if(isset($return[$error]))
		{
			return $return[$error];
		}
		else
		{
			return null;
		}
		
		
	}

}



class newsletter
{
	public $type = 'text';
	public $subject;
	public $body;
	public $from;
	
	public function createNewsletter()
	{
		
		
	}
	
	public function sendNewsletter($id_newsletter,$id_user)
	{
		
		
	}
	
}

class mailBody extends PHPMailer\PHPMailer\PHPMailer
{
	
	public $bodyHTML;
	public $bodyPreheader; //Texto invlisible en el correo pero que algunos clientes muestran como previo
	public $bodyContent;

	public function getBodyHTML()
	{
		$site = new Site;
		$this->bodyHTML = file_get_contents(__DIR__ . '/../templates/mail_html_basic.html');
		
		//Sustituimos los contenidos
		$array_search = array('{{preheader}}','{{site.url}}','{{site.title}}','{{site.auth}}','{{content}}');
		$array_replace = array($this->bodyPreheader,c::get('site.url'),c::get('site.title'),c::get('site.auth'),$this->bodyContent);
		
		$this->bodyHTML = str_replace($array_search,$array_replace,$this->bodyHTML);
	}
	
	public function bodyButton($link,$text)
	{
		
		$return = '<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
				  <tbody>
					<tr>
					  <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
						<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
						  <tbody>
							<tr>
							  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #18742a; border-radius: 5px; text-align: center;"> <a href="' . $link . '" target="_blank" style="display: inline-block; color: #ffffff; background-color: #18742a; border: solid 1px #18742a; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">' . $text . '</a> </td>
							</tr>
						  </tbody>
						</table>
					  </td>
					</tr>
				  </tbody>
				</table>';
		
		return $return;
		
	}
	
}



?>