<?php
header('Content-type: application/json');
require_once "../classes/Playlist.php";

if(!isset($_POST["playlistId"]) || !isset($_POST["denunciante"])){
  die("error");
}else{
  $playlistId = $_POST["playlistId"];
  $denunciante = $_POST["denunciante"];
  echo json_encode(Playlist::setDenuncia($playlistId, $denunciante));
}
?>
