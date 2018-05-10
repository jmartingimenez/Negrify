<?php
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query="SELECT P.nombre AS 'Nombre',COUNT(*) AS 'Votos'
			FROM playlist P
				JOIN voto AS V ON P.id=V.playlist_id
			GROUP BY P.id,P.nombre
			LIMIT 10";

	$sql = $db->query($query);

 	$dataTable = array(array("Nombre","Votos"));

	if(!$sql->num_rows){
		$dataTable[]=array("-",0);
		die(json_encode($dataTable));
	}

 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Nombre'],(int)$fila['Votos']);
 	}

	print(json_encode($dataTable));
?>
