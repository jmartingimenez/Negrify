<?php
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query="SELECT pais AS 'Pais',COUNT(*) AS 'Cantidad' FROM usuario GROUP BY pais LIMIT 10";

	$sql = $db->query($query);

 	$dataTable = array(array("Pais","Cantidad"));

	if(!$sql->num_rows){
		$dataTable[]=array("-",0);
		die(json_encode($dataTable));
	}
 	
 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Pais'],(int)$fila['Cantidad']);
 	}
	print(json_encode($dataTable));
?>
