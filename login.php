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
</head>
<body>

  <?php
  require_once 'layout/navbar.php';
  require_once 'layout/login.php';
  ?>

  <div class="container">
    <div class="row">
      <form class="col l4 m6 s12 offset-l4 offset-m3" action="#" method="POST">
        <div class="row">
          <div class="input-field">
            <input id="userid" type="text" class="validate" name="userid" maxlength="20">
            <label class="active" for="userid">Usuario</label>
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
            <button type="submit" class="btn waves-effect waves-light right submit darken" name="enviar">
              <span>Iniciar sesión</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
</body>
</html>
