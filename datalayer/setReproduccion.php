<?php
header('Content-type: application/json');
require_once "../classes/Playlist.php";

if(!isset($_POST["playlistId"])){
  die("error");
}else{
  $playlistId = $_POST["playlistId"];
  echo json_encode(Playlist::setReproduccion($playlistId));
}
?>
