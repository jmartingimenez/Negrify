<?php
header('Content-type: application/json');
require_once "../classes/Conexion.php";
require_once "../classes/Playlist.php";
$db = new Conexion();

if(!isset($_POST["playlistid"]) || !isset($_POST["cancionid"])){
  die("error");
}else{
  $playlistId = $_POST["playlistid"];
  $cancionId = $_POST["cancionid"];
  if(!($db->chequearCampo("playlist", "id", $playlistId)) || !($db->chequearCampo("cancion", "id", $cancionId))){
    die("error");
  }else{
    $query = "SELECT `p`.`nombre`, `u`.`username`, `p`.`genero_id`, `p`.`estado`, `p`.`foto`
              FROM `playlist` as `p` INNER JOIN `usuario` as `u` ON `p`.`creador_id` = `u`.`id`
              WHERE `p`.`id` = '$playlistId'";
    $sql = $db->query($query);
    if($sql->num_rows){
      $data = $sql->fetch_assoc();
      $playlist = new Playlist($data["nombre"], $data["username"], $data["genero_id"], $data["estado"], $data["foto"]);
      if($playlist->agregarCancion($cancionId)){
        if($playlist->actualizarCanciones()){
          echo json_encode("ok");
        }else{
          echo json_encode("error");
        }
      }else{
        echo json_encode("existe");
      }
    }
  }
}
?>
