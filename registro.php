<?php
session_start();
if(isset($_SESSION['user'])){
  header('Location: http://localhost');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Negrify</title>
  <?php require_once 'layout/archivosCss.php'; ?>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  <?php
  require_once 'layout/navbar.php';
  require_once 'classes/Usuario.php';
  require_once 'classes/Conexion.php';

  if(isset($_POST['enviar'])){
    $error = array();
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['confirmpass'];
    $pais = $_POST['pais_nombre'];
    $pais_lat = $_POST['pais_latitud'];
    $pais_long = $_POST['pais_longitud'];


    if(!(ctype_alpha($nombre) && strlen($nombre) >= 3 && strlen($nombre) <= 20)){
      $error[] = "Nombre solamente debe tener caracteres alfabeticos";
    }

    if(!(ctype_alpha($apellido) && strlen($apellido) >= 3 && strlen($apellido) <= 20)){
      $error[] = "Apellido solamente debe tener caracteres alfabeticos";
    }

    if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
      $error[] = "Email incorrecto";
    }else{
      $db = new Conexion();
      if($db->chequearCampo("usuario", "mail", $email)){
        $error[] = "El email de '$email' se encuentra en uso";
      }
    }

    if(!(strlen($pass) >= 6 && strlen($pass) <= 32 && $pass == $cpass)){
      $error[] = "Password debe tener al menos 6 caracteres";
    }

    if($usuario && strlen($usuario) >= 4 && strlen($usuario) <= 20){
      $db = new Conexion();
      if($db->chequearCampo("usuario", "username", $usuario)){
        $error[] = "El nombre de usuario '$usuario' se encuentra en uso";
      }
    }else{
      $error[] = "El campo usuario debe tener al menos 4 caracteres";
    }

    if(!strlen($pais)){
      $error[] = "Por favor, seleccione su pais";
    }

    if(isset($_POST['g-recaptcha-response'])){
      $captcha = $_POST['g-recaptcha-response'];
      $secret = "6Lck8ggUAAAAAO-onCfzXtGT4YvGTE4lT59evANX";
      $public = "6Lck8ggUAAAAAJuD4yByi0H5t7n9vsPlhm3-9LkL";
      $remoteip = $_SERVER['REMOTE_ADDR'];
      $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$remoteip"), true);
      if($response["success"] == false){
        $error[] = "Captcha incorrecto";
      }
    }else{
      $error[] = "Debes validar el captcha";
    }

    if(sizeof($error) == 0){
      $user = new Usuario($nombre, $apellido, $usuario, $email, $pass, $pais, $pais_lat, $pais_long);
      if($user->registrar()){
        echo "Usuario creado con exito, por favor, verifica tu email para activar la cuenta.";

        $id = $user->getId();
        $hash = $user->getCodigoActivacion();

        $para = $email;
        $titulo = "Activación de la cuenta $usuario";
        $mensaje = "Para completar tu registro, por favor haz click en el siguiente enlace
                    http://localhost/validarcuenta.php?id=$id&hash=$hash";

        mail($para, $titulo, $mensaje);
      }
      else{
        echo "Ocurrio un error con la base de datos";
      }
    }else{
      echo "Ocurrio un error en los siguientes campos: ";
      foreach($error as $er){
        echo "</br><strong>$er</strong>";
      }
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <form class="col l4 m6 s12 offset-l4 offset-m3" action="" method="POST">
        <div class="row">
          <div class="input-field">
            <input id="nombre" type="text" class="validate" name="nombre" maxlength="15">
            <label class="active" for="nombre">Nombre</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="apellido" type="text" class="validate" name="apellido" maxlength="15">
            <label class="active" for="apellido">Apellido</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="usuario" type="text" class="validate" name="usuario" maxlength="20">
            <label class="active" for="usuario">Nombre de usuario</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="email" type="email" class="validate" name="email" maxlength="40">
            <label class="active" for="email">E-Mail</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="pass" type="password" class="validate" name="password" maxlength="32">
            <label class="active" for="pass">Contraseña</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="confirmpass" type="password" class="validate" name="confirmpass" maxlength="32">
            <label class="active" for="confirmpass">Repita la contraseña</label>
          </div>
        </div>

        <div class="row">
          <input type="text" id="pais_latitud" name="pais_latitud" hidden >
          <input type="text" id="pais_longitud" name="pais_longitud" hidden >
          <input type="text" id="pais_nombre" name="pais_nombre" hidden >
          <div id="map">

          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <div class="g-recaptcha" data-sitekey="6Lck8ggUAAAAAJuD4yByi0H5t7n9vsPlhm3-9LkL"></div>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <button type="submit" class="btn waves-effect waves-light right submit" name="enviar">
              <span>Registrarse</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDx-ThAVlQ4ynqL2IaxM-mvmMRUpPf_hLg&callback=initMap"></script>
<script type="text/javascript" src="js/map.js"></script>
</body>
</html>
