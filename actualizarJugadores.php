<?php
	
	//Hacemos la llamada al web service
	$client = new SoapClient('http://www.comunio.es/soapservice.php?wsdl');

	//Conectamos con la base de datos
	$link = mysqli_connect('localhost:8889', 'root', 'root');
	mysqli_select_db($link, 'comunioFec');

	//Para que se inserten las tildes correctamente
	$link->set_charset('utf8');

	//Selecionamos el id de los clubs de la tabla clubs
	$resultSelect = mysqli_query($link, "select id from club");

	$arrayClubIds = array();

	//Asignamos los ids al array $arrayClubIds
	while($row = mysqli_fetch_assoc($resultSelect)) 
	{
		$arrayClubIds[] = $row["id"];
	}

	//Actualizamos ciertos datos de los jugadores por el id del club
	for($x = 0; $x < count($arrayClubIds); $x++)
	{
		$result = $client->getplayersbyclubid($arrayClubIds[$x]);
		$result = (array) $result;

		for($i = 0;$i < count($result); $i++) 
		{
			
			mysqli_query($link,"update jugador set puntos = " . $result[$i]->points . ", valor = ". $result[$i]->quote . ", situacion = '" . $result[$i]->status . "', situacion_info = '" . $result[$i]->status_info . "', partidos_jugados = " . $result[$i]->rankedgamesnumber . " where nombre = '" . $result[$i]->name . "';");
					
		}
	}

	mysqli_close($link);
	
	echo "Datos actualizados";
	echo "<br>";
	echo "<a href='index.php'>Volver</a>";
?>