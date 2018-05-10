<?php
	header('Content-type: application/json');
	if(!isset($_GET['modify'])){
		header("location: ../404.php");
	}

	$ingreso = $_GET['modify'];
	if(!ctype_alnum($ingreso))
		die("Buscas algo?");

	require_once "../classes/Conexion.php";
	$db = new Conexion();

	//Obteniendo el rango actual
	$rangoActual = "SELECT P.nombre AS 'Rango'
				    FROM privilegio AS P
						JOIN usuario AS U ON U.privilegio_id=P.id
				 	WHERE U.username='$ingreso'";

	$sqlRango 	= $db->query($rangoActual);

 	$fila = $sqlRango->fetch_assoc();
 	$rangoObtenido = $fila['Rango'];

	//Definiendo la query segun de que rango a que rango se este cambiando
	$nuevoRango="";
	switch($rangoObtenido){
		case 'Usuario':
			$query = 	"UPDATE usuario
						 SET privilegio_id=
							(
						    	SELECT NP.id
						        FROM privilegio NP
						        WHERE NP.nombre='Administrador'
						    )
						 WHERE privilegio_id=
							(
						    	SELECT OP.id
						        FROM privilegio OP
						        WHERE OP.nombre='Usuario'
						    )
							 AND usuario.username='$ingreso'";
			$nuevoRango="Administrador";				 
			break;
		case 'Administrador':
			$query = 	"UPDATE usuario
						 SET privilegio_id=
							(
						    	SELECT NP.id
						        FROM privilegio NP
						        WHERE NP.nombre='Usuario'
						    )
						 WHERE privilegio_id=
							(
						    	SELECT OP.id
						        FROM privilegio OP
						        WHERE OP.nombre='Administrador'
						    )
							 AND usuario.username='$ingreso'";
			$nuevoRango="Usuario";				 
			break;
		default: die("Buscas algo?");
	} 			  

	//Realizando la consulta
	$sql = $db->query($query);
 
 	print($nuevoRango);	
?>

