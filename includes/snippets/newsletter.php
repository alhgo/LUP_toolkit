<?php

//Obtenemos el cuerpo del newsletter y lo mostramos
if(isset($id))
{
	//echo $id;
	
	$nl = new newsletter;
	//Obtenemos los datos del newsletter
	$nl_data = $nl->getNewsletters($id);
	
	//print_r($nl_data);
	if(count($nl_data) > 0)
	{
		$nl_data = $nl_data[0];
		//Construimos el cuerpo
		$body = new mailBody; 
		//Construimos el texto de previo para algunos clientes
		$body->bodyPreheader = "Previsualización del newsletter";
		$body->bodyTitle = $nl_data['title'];
		//Construimos el cuerpo, declarando antes el botón para que se muestre
		$body->buttonLink = $nl_data['button_link'];
		$body->buttonText = 'Pincha aquí';
		$body->bodyContent = $nl_data['body'];
		$body->bodyImage = $nl_data['image'];
		$body->getBodyHTML();
		
		echo $body->bodyHTML;
	}
	
}

?>