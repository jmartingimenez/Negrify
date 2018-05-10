<?php
header('Content-type: application/json');
require_once "../classes/Conexion.php";
$db = new Conexion();

if(!isset($_POST["playlistid"]) || !isset($_POST["cancionid"])){
  die("error");
}else{
  $playlistId = $_POST["playlistid"];
  $cancionId = $_POST["cancionid"];
  if(!($db->chequearCampo("playlist", "id", $playlistId)) || !($db->chequearCampo("cancion", "id", $cancionId))){
    die("error");
  }else{
    $query = "SELECT * FROM `playlist_cancion` WHERE `cancion_id` = '$cancionId' AND `playlist_id` = '$playlistId'";
    $sql = $db->query($query);
    if($sql->num_rows){
      $queryDelete = "DELETE FROM `playlist_cancion` WHERE `cancion_id` = '$cancionId' AND `playlist_id` = '$playlistId'";
      if($db->query($queryDelete)){
        echo json_encode("ok");
      }else{
        echo json_encode("error");
      }
    }else{
      echo json_encode("existe");
    }
  }
}
?>
