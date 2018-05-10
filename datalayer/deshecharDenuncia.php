<?php
session_start();
if(!isset($_SESSION["admin"])){
  header("Location:http://localhost");
}  

	$tabla = $_SESSION['denuncia'];
	$tablaSQL = "reportes_".strtolower($tabla);

	header('Content-type: application/json');
	if(!isset($_GET['discard'])){
		header("location: ../404.php");
	}

	$ingreso = $_GET['discard'];

	switch($tablaSQL){
		case 'reportes_usuario':		$query="DELETE FROM reportes_usuario
												WHERE usuario_denunciado=$ingreso";
										break;
		case 'reportes_playlist':		$query="DELETE FROM reportes_playlist
												WHERE playlist_id=$ingreso";
										break;
		default: die("Buscas algo?");								
	}


	if(!is_numeric($ingreso))
		die("Buscas algo?");
	
	require_once "../classes/Conexion.php";
	$db = new Conexion();

	$sql = $db->query($query);


?>