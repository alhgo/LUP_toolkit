<?php

/**
 * Incrusta un snippet de la carpeta de snippets
 *
 * @param string $file
 * @param mixed $data array or object
 * @param boolean $return
 * @return string
 */

function snippet($file, $data = array(), $return = false) {
  	//Invocamos la clase
	$s = new snippet($file,$data,$return);
	$result = $s->show();
	return $result;
}


?>