<?php
header('Content-type: application/json');
require_once "../classes/Conexion.php";
require_once "../classes/Playlist.php";
$db = new Conexion();

if(!isset($_POST["playlistid"]) || !isset($_POST["cancionid"])){
  die("error");
}else{
  $cancion = $_POST["cancionid"];
  $playlist = $_POST["playlistid"];
  $db = new Conexion();
  $query = "DELETE FROM `playlist_cancion` WHERE `cancion_id` = '$cancion' AND `playlist_id` = '$playlist'";
  if($db->query($query)){
    return true;
  }else{
    return false;
  }
}
?>
