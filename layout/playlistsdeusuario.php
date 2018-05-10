<?php
require_once "./classes/Conexion.php";
require_once "./classes/Playlist.php";

$db = new Conexion();
$userid = $db->getId("usuario", "username", $profileid);

if($db->chequearCampo("playlist", "creador_id", $userid)){
  $resultado = array();
  $query = "SELECT * FROM `playlist` WHERE `creador_id` = $userid";
  $sql = $db->query($query);
  while($fila = $sql->fetch_assoc()){
    $resultado[] = $fila;
  }
  foreach($resultado as $playlist){

    $nombreDeImagen = $playlist["foto"];
    $auxGenero = $playlist["genero_id"];
    $queryGenero = "SELECT * FROM `genero` WHERE `id` = '$auxGenero'";
    $sqlGenero = $db->query($queryGenero);
    $genero = $sqlGenero->fetch_assoc()["nombre"];
    $estado = $playlist["estado"];

    $playlistId = $db->getId("playlist", "nombre", $playlist["nombre"]);

    $agregado = "";
    if($userid == $idcliente){
      $agregado = '<a href="http://localhost/editplaylist.php?pid='.$playlistId.'">
      <i id="editarPlaylist" class="white-text material-icons">edit</i></a>';
    }

    if($estado == "publica" ||
      ($estado == "privada" && ($userid == $idcliente)) ||
      ($estado == "privada" && (Usuario::chequearSiguiendo($idcliente, $userid))) ||
      ($estado == "solo yo" && ($userid == $idcliente))){
      echo "<div class=\"col l4 m6 s12\">";
      echo "<div class=\"card\">";
      echo "<div class=\"card-image\">";
      echo "<img src=/archivos/playlist_fotos/".$nombreDeImagen.">";
      echo '<span class="card-title"><strong id="nombreDeLaPlaylist">
            <a href="http://localhost/playlist.php?id='.$playlistId.'">'.$playlist["nombre"].'
            </a></strong>'.$agregado.'</span>';
      echo "</div>";
      echo "<div class=\"card-content\">";
      echo "<p><strong>Genero:</strong> $genero</p>";
      echo "<p><strong>Estado:</strong>" .$playlist["estado"]."</p>";
      echo "<p><strong>Reproducciones: </strong>".$playlist["reproducciones"]."</p>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }
}
?>
