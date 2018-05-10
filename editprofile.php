<?php
require_once "layout/validarpermisos.php";

if(!isset($_GET['user'])){
  header('Location: http://localhost');
}
require_once 'layout/navbar.php';
require_once 'classes/Usuario.php';
require_once 'classes/Conexion.php';

$db = new Conexion();

$idPagina = $_GET['user'];
$idCliente = $db->getId("usuario", "username", $_SESSION["user"]);

if($idPagina != $idCliente){
  header('Location: http://localhost');
}

$query = "SELECT * FROM `usuario` WHERE `id` = '$idCliente'";
$userData = $db->query($query)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Negrify</title>
  <?php require_once 'layout/archivosCss.php'; ?>
  <link rel="stylesheet" href="css/editprofile.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col l6 s12 offset-l3">
          <?php
          require_once 'layout/editProfile.php';
          ?>
      </div>
    </div>
    <div class="row">
      <div class="col l6 s12 offset-l3">
        <ul class="collapsible" data-collapsible="accordion">
          <li>
            <div class="collapsible-header"><i class="material-icons">person</i>Personal</div>
            <div class="collapsible-body">

              <form action="" method="post">

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="nombre" type="text" class="validate" name="nombre" maxlength="25" value="<?php echo $userData['nombre']; ?>">
                    <label class="active" for="nombre">Nombre</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="apellido" type="text" class="validate" name="apellido" maxlength="25" value="<?php echo $userData['apellido']; ?>">
                    <label class="active" for="apellido">Apellido</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 l4 offset-s1 offset-l4 botonenviar">
                    <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_personal">
                      <span>Ok</span>
                    </button>
                  </div>
                </div>

              </form>

            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Contacto</div>
            <div class="collapsible-body">
              <form action="" method="post">

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="email" type="email" class="validate" name="email" maxlength="25">
                    <label class="active" for="email">E-Mail</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 l4 offset-s1 offset-l4 botonenviar">
                    <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_email">
                      <span>Ok</span>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">lock</i>Seguridad</div>
            <div class="collapsible-body">
              <form action="" method="post">

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="originalPassword" type="password" class="validate" name="originalPassword" maxlength="25">
                    <label class="active" for="originalPassword">Contraseña actual</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="newPassword1" type="password" class="validate" name="newPassword1" maxlength="25">
                    <label class="active" for="newPassword1">Nueva contraseña</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 offset-s1">
                    <input id="newPassword2" type="password" class="validate" name="newPassword2" maxlength="25">
                    <label class="active" for="newPassword2">Confirmar contraseña</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 l4 offset-s1 offset-l4 botonenviar">
                    <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_password">
                      <span>Ok</span>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </li>
          <li>
            <div id="map_container" class="collapsible-header"><i class="material-icons">place</i>Localizacion</div>
            <div class="collapsible-body">
              <form action="" method="post">

                <div class="row">
                  <input type="text" id="pais_latitud" name="pais_latitud" value="<?php echo $userData['pais_latitud']; ?>" hidden >
                  <input type="text" id="pais_longitud" name="pais_longitud" value="<?php echo $userData['pais_longitud']; ?>" hidden >
                  <input type="text" id="pais_nombre" name="pais_nombre" value="<?php echo $userData['pais']; ?>" hidden >
                  <div class="col s12">
                    <div id="map">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s10 l4 offset-s1 offset-l4 botonenviar">
                    <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_map">
                      <span>Ok</span>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDx-ThAVlQ4ynqL2IaxM-mvmMRUpPf_hLg&callback=initMap"></script>
<script type="text/javascript" src="js/editmap.js"></script>
</body>
</html>
