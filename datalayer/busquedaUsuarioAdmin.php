<?php
	header('Content-type: application/json');
	if(!isset($_GET['search'])){
		header("location: ../404.php");
	}

	$ingreso = $_GET['search'];
	if(!ctype_alnum($ingreso))
		die("Buscas algo?");
	
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$query = "SELECT U.username AS 'Usuario',P.nombre AS 'Rango' 
			  FROM usuario AS U JOIN privilegio AS P ON U.privilegio_id=P.id
			  WHERE U.username='$ingreso'";

	$sql = $db->query($query);

 	$dataTable = array(array("Usuario","Rango"));

	if(!$sql->num_rows){
		die("Usuario no encontrado.");
	}
 	
 	while($fila=$sql->fetch_assoc()){
 		$dataTable[]=array($fila['Usuario'],$fila['Rango']);
 	}
	print(json_encode($dataTable));			  
?>