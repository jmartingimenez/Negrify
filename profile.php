<?php
session_start();
require_once "classes/Conexion.php";
require_once "classes/Usuario.php";

if(!isset($_SESSION['user'])){
  header("Location:http://localhost");
}

if(isset($_GET['id'])){
  $profileid = $_GET['id'];
  $db = new Conexion();
  if(!($db->chequearCampo("usuario", "username", $profileid))){
    header("Location:http://localhost/404.php");
  }
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
  <title>Perfil de <?php echo $profileid;?></title>
  <?php require_once 'layout/archivosCss.php'; ?>
</head>
<body>
  <?php
  require_once 'layout/navbar.php';
  $db = new Conexion();
  $userid = $db->getId("usuario", "username", $_GET["id"]);
  $idcliente = $db->getId("usuario", "username", $_SESSION["user"]);
  $db->close();

  $classBtnSeguir = "";
  $db = new Conexion();
  $sql = $db->query("SELECT * FROM `seguir` WHERE `seguido_id` = '$userid' AND `seguidor_id` = '$idcliente'");
  if($sql->num_rows){
    $classBtnSeguir = "siguiendo";
  }
  ?>

  <div class="container">
    <div class="row">
      <div id="profile_header" class="col s12">
        <h3 style="color: #3e4a54;"><?php echo $profileid;?></h3>

         <div class="fixed-action-btn horizontal click-to-toggle">
           <a class="btn-floating btn-large blue">
             <i class="material-icons">menu</i>
           </a>
           <ul>
             <li id="btn_menu_reportar">
               <a class="btn-floating red"><i class="material-icons">report</i>
               </a>
             </li>
               <?php
               if($userid == $idcliente){
                 ?>
                 <li>
                   <a href="http://localhost/editprofile.php?user=<?php echo $idcliente; ?>" class="btn-floating blue">
                     <i class="material-icons">edit</i>
                   </a>
                 </li>
                 <?php
               }
               if($classBtnSeguir != "siguiendo"){ ?>
                 <li id="btn_seguir">
                 <a class="btn-floating blue">
                   <i id="icon_seguir" class="material-icons">person_add</i>
                 </a>
              <?php
               }
               else{
                 ?>
                 <li id="btn_seguir" class="siguiendo">
                 <a class="btn-floating blue">
                   <i id="icon_seguir" class="material-icons">remove_circle_outline</i>
                 </a>
                 <?php
               }
               ?></li>
           </ul>
         </div>
      </div>
      <div class="row">
        <div class="col s12">
          <ul class="tabs tabsusuario">
            <li class="tab col s4"><a class="active" href="#playlist">Playlists</a></li>
            <li class="tab col s4"><a href="#siguiendo">Siguiendo</a></li>
            <li class="tab col s4"><a href="#seguidores">Seguidores</a></li>
          </ul>
        </div>
        <div id="playlist" class="col s12">
          <?php
          require_once "layout/playlistsdeusuario.php";
           ?>
        </div>
        <div id="siguiendo" class="col s12">
          <?php
            $listaSiguiendo = Usuario::getListaSiguiendo($userid);
            foreach($listaSiguiendo as $user){
              include 'layout/listaUsuarios.php';
            }
           ?>
        </div>
        <div id="seguidores" class="col s12">
          <?php
            $listaSeguidores = Usuario::getListaSeguidores($userid);
            foreach($listaSeguidores as $user){
              include 'layout/listaUsuarios.php';
            }
           ?>
        </div>
      </div>
    </div>
  </div>

  <a id="modal_report" class="waves-effect waves-light btn" href="#modalReportar" style="display: none;">Modal</a>
  <a id="modal_yareportado" class="waves-effect waves-light btn" href="#modalYaDenunciado" style="display: none;">Modal</a>

  <div id="modalReportar" class="modal">
    <div class="modal-content">
      <h4 class="red-text">ATENCIÓN</h4>
      <p>Los usuarios solamente deben ser reportados por subir canciones
        inapropiadas.
      </p>
      <p>
        El uso indevido de esta función será sancionado.
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves btn-flat">Cancelar</a>
      <a id="btn_reportar" href="#!" class="white-text waves-effect waves btn-flat red">Reportar</a>
    </div>
  </div>

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

  <input type="text" id="idProfileCreator" value="<?php echo $userid; ?>" hidden>
  <input type="text" id="idcliente" value="<?php echo $idcliente; ?>" hidden>



<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/seguir.js"></script>
</body>
</html>
