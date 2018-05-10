<?php
session_start();

require_once "classes/Conexion.php";

if(!isset($_GET["id"]) || !isset($_GET["hash"]) ){
  die("error");
}else{
  $user = $_GET["id"];
  $hash = $_GET["hash"];
  $db = new Conexion();
  $query = "UPDATE `usuario` SET `activado` = '1' WHERE `id` = '$user' AND `cod_activacion` = '$hash'";
  $db->query($query);
  $filasAfectadas = $db->affected_rows;
  if($filasAfectadas == 1){
    $activado = true;
  }else{
    $activado = false;
  }
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
  ?>
  <div class="container">
    <div class="row">
      <div class="col l6 s12 offset-l3" style="text-align: center;">
          <?php
          if(!$activado){
            echo '<h5 class="red-text">ERROR!</h5>';
            echo '<strong>Datos incorrectos</strong>';
          }else{
            echo '<h5 class="blue-text">GENIAL!</h5>';
            echo '<strong>Cuenta activada correctamente, por favor, vuelve a loguearte</strong>';
            session_destroy();
          }
         ?>
      </div>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
</body>
</html>
