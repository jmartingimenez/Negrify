<?php
session_start();
if(!isset($_SESSION["admin"])){
  header("Location:http://localhost");
}  

	$tabla = $_SESSION['denuncia'];
	$tablaSQL = "reportes_".strtolower($tabla);

	header('Content-type: application/json');
	if(!isset($_GET['delete'])){
		header("location: ../404.php");
	}

	$ingreso = $_GET['delete'];

	switch($tablaSQL){
		case 'reportes_usuario':		$query="UPDATE reportes_usuario
												SET confirmacion=0
												WHERE usuario_denunciado=$ingreso
													AND confirmacion=1";
										$query2="UPDATE usuario
												SET ban=0
												WHERE id=$ingreso
													AND ban=1";			
										break;
		case 'reportes_playlist':		$query="UPDATE reportes_playlist
												SET confirmacion=0
												WHERE playlist_id=$ingreso
													AND confirmacion=1";
										$query2="UPDATE playlist
												SET ban=0
												WHERE id=$ingreso
													AND ban=1";			
										break;
		default: die("Buscas algo?");								
	}

	if(!is_numeric($ingreso))
		die("Buscas algo?");

	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$sql = $db->query($query);
	$sql2 = $db->query($query2);


?>