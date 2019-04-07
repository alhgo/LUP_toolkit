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


//Función para crear enlaces en los menús del panel de admin
function create_link($data) {
	$link = '';
	if(isset($data['page']) && $data['page'] != 'admin.php')
	{
		$link = $data['page'] . ' target="_blank"'; 
	}
	else
	{
		$action = (isset($data['action']) && $data['action'] != '') ? '?action=' . $data['action'] : '';
		$link = 'admin.php' . $action;
	}
	
	return $link;
}

function createSnack($text,$type='success',$layout='topRight',$timeout=4000,$progressBar='false') {
	/*
	type: 'success', //alert (default), success, error, warning, info - ClassName generator uses this value → noty_type__${type}
    layout: 'topRight', //top, topLeft, topCenter, topRight (default), center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight - ClassName generator uses this value → noty_layout__${layout}
    theme: 'bootstrap-v4', //relax, mint (default), metroui - ClassName generator uses this value → noty_theme__${theme}
    text: 'My beautiful snackbar', //This string can contain HTML too. But be careful and don't pass user inputs to this parameter.
    //timeout: 5000, // false (default), 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms). Set 'false' for sticky notifications.
    progressBar: true, //Default, progress before fade out is displayed
    //closeWith: 'click' //default; alternative: button
	
	*/
	if($text != '')
	{
		echo "
	<script>
	window.onload = function() {
		new Noty({
		type: '$type', 
		layout: '$layout',
		theme: 'bootstrap-v4', 
		text: '$text', 
		timeout: $timeout, 
		progressBar: $progressBar,
		//closeWith: 'click' 
	  }).show();
	};
	</script>";
	}
	
}


?>