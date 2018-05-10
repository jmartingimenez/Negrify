<?php
header('Content-type: application/json');
require_once "../classes/Conexion.php";

if(!isset($_GET["buscar"])){
  //echo "Error";
  die("error");
}else{
  $buscar = $_GET["buscar"];
  $db = new Conexion();
  $query = "SELECT `id`, `nombre`, `artista`, `album` FROM `cancion` WHERE `nombre` LIKE '%$buscar%' OR `artista` LIKE '%$buscar%' OR `album` LIKE '%$buscar%'";
  $sql = $db->query($query);
  $resultado = array();
  while($fila = $sql->fetch_assoc()){
    $aux = $fila;
    $nombre = str_replace(" ", "_", $fila["nombre"]);
    $aux["file"] = "\\archivos\\canciones\\$nombre.mp3";
    $resultado[] = $aux;
  }
  if(sizeof($resultado)){
    echo json_encode($resultado);
  }else{
    echo json_encode("error");
  }
}
?>
