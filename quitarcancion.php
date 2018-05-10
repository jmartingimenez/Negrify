<?php
require_once "layout/validarpermisos.php";
require_once "classes/Conexion.php";
$db = new Conexion();

if(isset($_GET['playlistid'])){
  $playlistid = $_GET['playlistid'];
  if(!($db->chequearCampo("playlist", "id", $playlistid))){
    header("Location:http://localhost/404.php");
  }
  $query = "SELECT * FROM `playlist` WHERE `id` = '$playlistid'";
  $sql = $db->query($query);
  $data = $sql->fetch_assoc();
  $idPlaylist = $data["id"];
  $nombrePlaylist = $data["nombre"];
  $playlistCreador = $data["creador_id"];
  $userId = $db->getId("usuario", "username", $_SESSION["user"]);

}else{
  header("Location:http://localhost/404.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agregar canciones</title>
  <?php require_once 'layout/archivosCss.php'; ?>
</head>
<body>
  <?php
  require_once 'layout/navbar.php';
  ?>

  <div class="container">
    <div class="row">
      <div class="col s12">
        <?php
        if($playlistCreador != $userId){
          echo "<h5 class=\"center-align\">No tienes acceso a esta página</h5>";
          exit();
        }
         ?>
        <h5 class="center-align">Quitar canciones de la playlist <?php echo $nombrePlaylist ?></h5>
      </div>

      <div id="cancionesAQuitar" class="col s12">
        <?php
        $canciones = array();
        $db = new Conexion();
        $query = "SELECT `c`.`id`, `c`.`artista`, `c`.`album`, `c`.`nombre` FROM `cancion` `c`
                  INNER JOIN `playlist_cancion` `pc`
                  ON `c`.`id` = `pc`.`cancion_id`
                  WHERE `pc`.`playlist_id` = '$idPlaylist'";
        $sql = $db->query($query);
        while($fila = $sql->fetch_assoc()){
          $canciones[] = $fila;
        }
        foreach($canciones as $cancion){
          echo '<div class="col s6 l4">';
          echo '<div class="card-panel">';
          echo '<span class="black-text text-darken-2"><strong>Nombre: </strong>'.$cancion["nombre"].'</span>';
          echo '<div class="divider"></div>';
          echo '<span class="black-text text-darken-2"><strong>Artista: </strong>'.$cancion["artista"].'</span>';
          echo '<div class="divider"></div>';
          echo '<span class="black-text text-darken-2"><strong>Album: </strong>'.$cancion["album"].'</span>';
          echo '<div class="row">';
          echo '<div class="waves-effect waves-light btn col s12 blue accent-4 quitar" style="margin-top:20px;">';
          echo '<input type="text" class="path" value="'.$cancion["id"].'" hidden>';
          echo '<i class="material-icons left">add</i><span>quitar</span></div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
         ?>
      </div>
    </div>
  </div>

  <input id="id_playlist" type="text" value="<?php echo $idPlaylist; ?>" hidden>



<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/quitarcancion.js"></script>
</body>
</html>
