<?php
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query="SELECT COUNT(*) AS 'Total',
				(SELECT COUNT(*)
				 FROM playlist
				 WHERE (fecha_creacion >= NOW() - INTERVAL 1 MONTH
					 AND fecha_creacion <= NOW())
				) AS 'Ultimo mes'
			FROM playlist";

	$sql = $db->query($query);

 	$dataTable = array(array("Total","Ultimo mes"));

	if(!$sql->num_rows){
		$dataTable[]=array("-",0);
		die(json_encode($dataTable));
	}
 	
 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Total'],(int)$fila['Ultimo mes']);
 	}
	print(json_encode($dataTable));
?>
