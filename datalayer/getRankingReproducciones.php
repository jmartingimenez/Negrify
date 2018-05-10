<?php
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query="SELECT nombre AS 'Nombre',reproducciones AS 'Cantidad'
			FROM playlist
			GROUP BY id,nombre
			LIMIT 10";

	$sql = $db->query($query);

 	$dataTable = array(array("Nombre","Cantidad"));

	if(!$sql->num_rows){
		$dataTable[]=array("-",0);
		die(json_encode($dataTable));
	}
 	
 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Nombre'],(int)$fila['Cantidad']);
 	}
	print(json_encode($dataTable));
?>
