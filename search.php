<?php
session_start();
require_once "classes/Genero.php";
require_once "classes/Playlist.php";
require_once "classes/Conexion.php";
if(isset($_GET['q'])){
  $userQuery = $_GET['q'];
  $db = new Conexion();
  if(isset($_SESSION['user'])){
    $aux = $db->getId("usuario", "username", $_SESSION['user']);
    $userId = $aux;
  }
  $db->close();
}else{
  header("Location:http://localhost");
}

if(isset($_SESSION["usernoverificado"])){
  $userId = "-1";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Resultados de la búsqueda</title>
  <?php require_once 'layout/archivosCss.php'; ?>
</head>
<body>
  <?php
  require_once 'layout/navbar.php';
  ?>

  <div class="container">
    <div class="row">
      <div class="col s6 push-s2">
        <?php
        $buscarPlaylist = Playlist::buscarPlaylistPorNombre($userQuery, $userId);
        if(!$buscarPlaylist){
          echo "<h5 class=\"center-align\">No se encontraron resultados</h5>";
        }else{
          echo "<h5 class=\"center-align\">Resultados para '$userQuery':</h5>";
        ?>
      </div>
    </div>
    <div class="row">
      <?php
      $listaDePlaylists = json_decode($buscarPlaylist, true);
        foreach($listaDePlaylists as $playlist){
          $nombreDeImagen = $playlist["foto"];
          $playlistId = $playlist["id"];

          echo "<div class=\"col l4 m6 s12\">";
          echo "<div class=\"card\">";
          echo "<div class=\"card-image\">";
          echo "<img src=\".\archivos\playlist_fotos\\$nombreDeImagen\">";
          echo "<span class=\"card-title\"><strong><a href=\"http://localhost/playlist.php?id=$playlistId\">".$playlist["nombre"]."</a></strong></span>";
          echo "</div>";
          echo "<div class=\"card-content\">";
          echo "<p><strong>Autor: </strong>".Playlist::getCreador($playlist["creador_id"])."</p>";
          echo "<p><strong>Genero: </strong>".Genero::getGenero($playlist["genero_id"])."</p>";
          echo "<p><strong>Reproducciones: </strong>".$playlist["reproducciones"]."</p>";
          echo "<p><strong>Me Gusta: </strong>".Playlist::getMeGusta($playlistId)."</p>";
          echo "<p><strong>Estado: </strong>".$playlist["estado"]."</p>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }
      }
      ?>
    </div>
  </div>


<?php require_once 'layout/archivosJs.php'; ?>
</body>
</html>
