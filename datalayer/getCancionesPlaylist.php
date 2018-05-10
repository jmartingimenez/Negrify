<?php
header('Content-type: application/json');
require_once "../classes/Playlist.php";

if(!isset($_GET["playlistid"])){
  //echo "Error";
  die("debug");
}else{
  $playlistid = $_GET["playlistid"];
  $canciones = Playlist::getCanciones($playlistid);
  echo $canciones;
}
?>
