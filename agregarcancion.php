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
        <h5 class="center-align">Agregar canciones a la playlist <?php echo $nombrePlaylist ?></h5>
      </div>
    </div>

    <div class="row">
      <div class="col l6 s10 push-l2">
        <input type="text" id="idplaylist" value="<?php echo $idPlaylist; ?>" hidden>
        <input type="search" placeholder="Ingrese cancion, artista o album" id="input">
      </div>
      <div class="col l2 s2 push-l2">
        <input type="button" class="btn blue white-text" value="buscar" id="buscar">
      </div>
    </div>

    <div class="row" id="resultado">
    </div>
    <div class="row" id="botonredireccion" style="text-align: center;">
      <a class="waves-effect waves-light btn blue white-text" href="http://localhost/playlist.php?id=<?php echo $idPlaylist;  ?>">Listo!</a>
    </div>
  </div>



<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/buscarcancion.js"></script>
</body>
</html>
