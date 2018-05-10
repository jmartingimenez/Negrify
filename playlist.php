<?php
session_start();
if(isset($_SESSION['ban'])){
  header('location:baneado.php');
}

if(isset($_SESSION["user"])){
  $logueado = true;
}else{
  $logueado = false;
}
require_once "classes/Conexion.php";
require_once "classes/Playlist.php";
require_once "classes/Usuario.php";

$db = new Conexion();

if(isset($_GET['id'])){
  $id = $_GET['id'];
  if(!($db->chequearCampo("playlist", "id", $id))){
    header("Location:http://localhost/404.php");
  }
}else{
  header("Location:http://localhost/404.php");
}

$estado = Playlist::getEstadoPorId($id);


if($estado == "solo yo"){
  if(!isset($_SESSION["user"])){
    header("Location:http://localhost");
  }
  else{
    $usuarioId = $db->getId("usuario", "username", $_SESSION["user"]);
    if($usuarioId != $_GET["id"]){
      header("Location:http://localhost");
    }
  }
}

if($estado == "privada"){
  if(!isset($_SESSION["user"])){
    header("Location:http://localhost");
  }
  else{
    $usuarioId = $db->getId("usuario", "username", $_SESSION["user"]);
    $creadorId = Playlist::getCreadorId($_GET["id"]);
    if($usuarioId != $creadorId){
      if(!Usuario::chequearSiguiendo($usuarioId, $creadorId)){
        header("Location:http://localhost");
      }
    }
  }
}

$query = "SELECT * FROM `playlist` WHERE `id` = '$id'";
$sql = $db->query($query);
$data = $sql->fetch_assoc();
$nombrePlaylist = $data["nombre"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $nombrePlaylist;?></title>
  <?php require_once 'layout/archivosCss.php'; ?>
  <link rel="stylesheet" href="css/playlist.css">
</head>
<body>
  <?php
  require_once 'layout/navbar.php';
  require_once 'lib/phpqrcode/qrlib.php';
  require_once 'layout/exportarPlaylist.php';
  $playlistId = $_GET["id"];
  @
  $clientUsername = $_SESSION["user"];
  $creadorPlaylistId = Playlist::getCreadorId($playlistId);
  $creadorPlaylistUsername = Usuario::getUsername($creadorPlaylistId);

  $db = new Conexion();
  $query = "SELECT"
  ?>

  <div class="container">
    <div class="row" id="full_container">

      <div class="col l4 s12 offset-l1 no-padding" id="userdata_container">
        <div class="col s12">
          <div id="user_titulo">
            <a href="http://localhost/profile.php?id=<?php echo $creadorPlaylistUsername?>">
              <i class="material-icons">person</i>
              <span><h5><?php echo $creadorPlaylistUsername ?></h5></span>
            </a>
          </div>
        </div>

        <div id="userinfoHolder">
          <div id="userData">
            <ul>
              <li>
                <span class="infotitle">Playlists</span>
                <span class="infodata"><?php echo Usuario::getCantidadPlaylist($creadorPlaylistUsername) ?></span>
              </li>
              <li>
                <span class="infotitle">Siguiendo</span>
                <span class="infodata"><?php echo Usuario::getSiguiendo($creadorPlaylistId) ?></span>
              </li>
              <li>
                <span class="infotitle">Seguidores</span>
                <span class="infodata"><?php echo Usuario::getSeguidores($creadorPlaylistId) ?></span>
              </li>
            </ul>
          </div>
        </div>

        <div class="col s12">
          <ul class="tabs">
            <li class="tab col s3"><a class="active" href="#pais"><i class="material-icons">location_on</i></a></li>
            <li class="tab col s3"><a href="#shareQR"><i class="material-icons">share</i></a></li>
            <li class="tab col s3"><a href="#playInfo"><i class="material-icons">info_outline</i></a></li>
            <li id="tab_reportar" class="tab col s3"><a href="#playReport"><i class="material-icons">report</i></a></li>
          </ul>
        </div>
        <div id="pais" class="col s12">
          <div id="map">
            <?php $coordenadas = Usuario::getCoor($creadorPlaylistUsername); ?>
            <input type="text" id="pais_lat" value="<?php echo $coordenadas["lat"] ?>" hidden>
            <input type="text" id="pais_long" value="<?php echo $coordenadas["long"] ?>" hidden>
          </div>
        </div>
        <div id="shareQR" class="col s12">
          <h5>Escaneá el código con tu celular!</h5>
          <?php
          require_once 'layout/generarQR.php';
          ?>
        </div>
        <div id="playInfo" class="col s12">
          <ul>
          <li>
            <i class="material-icons">play_arrow</i>
            <span><?php echo Playlist::getReproducciones($playlistId); ?></span>
          </li>
            <li>
              <i class="material-icons">thumb_up</i>
              <span><?php echo Playlist::getMegusta($playlistId); ?></span>
            </li>
            <li>
              <i class="material-icons">date_range</i>
              <span><?php echo Playlist::getFechaCreacion($creadorPlaylistId) ?></span>
            </li>
            <li>
              <i class="material-icons">lock</i>
              <span><?php echo Playlist::getEstadoPorId($playlistId); ?></span>
            </li>
          </ul>
        </div>
        <div id="playReport" class="col s12">
          <?php
          if($logueado == true){
            echo '<a id="btn_reportar" class="waves-effect waves-light btn red"><i class="material-icons left">report</i>REPORTAR</a>';
          }
          ?>
          <!-- Modal Trigger -->
          <a id="modal_report" class="waves-effect waves-light btn" href="#<?php echo ($logueado == true) ? "modalReportar" : "modalSinloguear";?>" style="display: none;">Modal</a>
          <a id="modal_yareportado" class="waves-effect waves-light btn" href="#modalYaDenunciado" style="display: none;">Modal</a>

          <!-- Modal Structure -->
          <div id="modalReportar" class="modal">
            <div class="modal-content">
              <h4 class="red-text">ATENCIÓN</h4>
              <p>Las playlist solamente deben ser reportadas cuando contengan material
                o nombre inapropiado.
              </p>
              <p>
                El uso indevido de esta función será sancionado.
              </p>
            </div>
            <div class="modal-footer">
              <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Entendido</a>
            </div>
          </div>

          <div id="modalSinloguear" class="modal">
            <div class="modal-content">
              <h4 class="red-text">ERROR</h4>
              <p>Solamente los usuarios registrados pueden utilizar esta función.
              </p>
            </div>
            <div class="modal-footer">
              <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Entendido</a>
            </div>
          </div>

          <!-- Modal Trigger -->


          <!-- Modal Structure -->
          <div id="modalYaDenunciado" class="modal bottom-sheet">
            <div class="modal-content">
              <h4 class="red-text">ERROR!</h4>
              <p>Ya has denunciado esta playlist</p>
              <p>
                En instantes los administradores tomarán una decisión al respecto.
              </p>
            </div>
            <div class="modal-footer">
              <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
          </div>

        </div>
    </div>

    <?php
    $canciones = Playlist::getCancionesPorId($_GET["id"]);
    $ordenCancion = 0;
    $foto = "http://localhost/archivos/playlist_fotos/".Playlist::getFoto($_GET["id"]);
    ?>
      <div class="col l6 s12" id="player_container">
        <div class="col s12 blue lighten-2" id="player_header" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.25) 0%,rgba(0,0,0,0.25) 100%),
        url(<?php echo $foto ?>);">
          <div id="playlist_titulo">
            <h5 class="white-text"><?php echo $nombrePlaylist ?></h5>
          </div>

          <div id="progressbar" class="white-text">
            <input type="range" id="duracion" min value="0">
            <span id="tiempo"></span>
            <span id="tiempoTotal"></span>
          </div>

          <?php
            $clienteId = $db->getId("usuario", "username", $clientUsername);
            if(Playlist::chequearMeGusta($playlistId, $clienteId)){
              $estadomegusta = "conmegusta";
            }else{
              $estadomegusta = "sinmegusta";
            }
           ?>
           <div class="col s1">
             <i id="xspf" class="material-icons">file_download</i>
           </div>
          <div class="col s11 white-text" id="controller">
            <i id="mute" class="material-icons">volume_up</i>
  			    <i id="prev" class="material-icons">skip_previous</i>
            <i id="play" class="material-icons">play_circle_outline</i>
            <i id="next" class="material-icons">skip_next</i>
            <i id="like" class="material-icons <?php echo $estadomegusta ?>">thumb_up</i>
          </div>
        </div>

        <div class="col s12 no-padding" id="canciones_container">
          <ul id="canciones">
          <?php
            foreach($canciones as $cancion){
              $nombre = $cancion["nombre"];
              $archivo = $cancion["archivo"];
              echo "<li class=\"cancion\" data-orden=\"$ordenCancion\" data-cancion=\"$archivo\">$nombre</li>";
              $ordenCancion++;
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php
    require_once 'layout/exportarPlaylist.php';
  ?>
  <form class="" action="" method="post" hidden>
    <input id="btn_exportar" type="submit" name="exportar">
  </form>
  <input type="text" id="idplaylist" value="<?php echo $playlistId ?>" hidden>
  <input type="text" id="idusuario" value="<?php echo $clienteId ?>" hidden>



<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/playlist.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDx-ThAVlQ4ynqL2IaxM-mvmMRUpPf_hLg&callback=initMap"></script>
<script type="text/javascript" src="js/profileMap.js"></script>
<script type="text/javascript" src="js/meGustaHandler.js"></script>
</body>
</html>
