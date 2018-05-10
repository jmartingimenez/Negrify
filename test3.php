<?php
//header('Content-type: application/json');
require_once "classes/Conexion.php";
require_once "classes/Playlist.php";
$db = new Conexion();
$query = "SELECT `p`.`nombre`, `u`.`username`, `p`.`genero_id`, `p`.`estado`, `p`.`foto`
          FROM `playlist` as `p` INNER JOIN `usuario` as `u` ON `p`.`creador_id` = `u`.`id`
          WHERE `p`.`id` = 2";
$sql = $db->query($query);
if($sql->num_rows){
  $data = $sql->fetch_assoc();
  $playlist = new Playlist($data["nombre"], $data["username"], $data["genero_id"], $data["estado"], $data["foto"]);
  var_dump($playlist->agregarCancion(10));
}
?>
