<?php
header('Content-type: application/json');
require_once "../classes/Usuario.php";

if(!isset($_POST["denunciado"]) || !isset($_POST["denunciante"])){
  die("error");
}else{
  $denunciado = $_POST["denunciado"];
  $denunciante = $_POST["denunciante"];
  echo json_encode(Usuario::setDenuncia($denunciado, $denunciante));
}
?>
