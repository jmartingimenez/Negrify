<?php
header('Content-type: application/json');
require_once "../classes/Playlist.php";

if(!isset($_POST["playlistId"]) || !isset($_POST["userid"])){
  die("error");
}else{
  $playlistId = $_POST["playlistId"];
  $userId =$_POST["userid"];
  echo json_encode(Playlist::deleteMeGusta($playlistId, $userId));
}
?>
