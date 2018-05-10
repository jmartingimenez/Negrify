<?php
header('Content-type: application/json');
require_once "../classes/Usuario.php";

if(!isset($_POST["seguidor"]) || !isset($_POST["seguido"])){
  die("error");
}else{
  $seguidor = $_POST["seguidor"];
  $seguido =$_POST["seguido"];
  echo json_encode(Usuario::seguir($seguidor, $seguido));
}
?>
