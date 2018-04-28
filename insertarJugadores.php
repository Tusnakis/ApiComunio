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

	//Insertamos los datos de los jugadores por el id del club
	for($x = 0; $x < count($arrayClubIds); $x++)
	{
		$result = $client->getplayersbyclubid($arrayClubIds[$x]);
		$result = (array) $result;

		for($i = 0;$i < count($result); $i++) 
		{
			
			mysqli_query($link,"insert into jugador (id, nombre, puntos, valor, situacion, situacion_info, posicion, partidos_jugados, club_id) values 
				(
					" . $result[$i]->id . ",'" . $result[$i]->name . "'," . $result[$i]->points . ","
					  . $result[$i]->quote . ",'" . $result[$i]->status . "','" . $result[$i]->status_info . "','" . 
						$result[$i]->position . "'," . $result[$i]->rankedgamesnumber . "," . $result[$i]->clubid . ");"
			);
		}
	}

	//Desconectamos de la base de datos
	mysqli_close($link);
	
	echo "Datos insertados";
	echo "<br>";
	echo "<a href='index.php'>Volver</a>";
?>

