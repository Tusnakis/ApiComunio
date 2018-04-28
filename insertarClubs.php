<?php 
	
	//Hacemos la llamada al web service
	$client = new SoapClient('http://www.comunio.es/soapservice.php?wsdl');
	$result = $client->getclubs();
	$result = (array) $result;

	//Conectamos con la base de datos
	$link = mysqli_connect('localhost:8889', 'root', 'root');
	mysqli_select_db($link, 'comunioFec');

	//Para que se inserten las tildes correctamente
	$link->set_charset('utf8');

	//Insertamos los datos de los clubs
	for($i = 0;$i < count($result); $i++) 
	{
		mysqli_query($link,"insert into club (id, nombre, url) values (" . $result[$i]->id . ",'" . $result[$i]->name . "','" . $result[$i]->url . "');");
	}

	//Desconectamos de la base de datos
	mysqli_close($link);
	
	echo "Datos insertados";
	echo "<br>";
	echo "<a href='index.php'>Volver</a>";
?>