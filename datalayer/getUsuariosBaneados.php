<?php
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query="SELECT (CASE  WHEN ban=0 THEN 'Regular' ELSE 'Baneado' END) AS 'Usuarios',
				COUNT(*) AS 'Cantidad'
			FROM usuario
			GROUP BY ban";

	$sql = $db->query($query);

 	$dataTable = array(array("Usuarios","Cantidad"));

	if(!$sql->num_rows){
		$dataTable[]=array("-",0);
		die(json_encode($dataTable));
	}
 	
 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Usuarios'],(int)$fila['Cantidad']);
 	}
	print(json_encode($dataTable));
?>
