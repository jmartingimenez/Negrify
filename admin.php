<?php
session_start();
if(!isset($_SESSION["admin"])){
  header("Location:http://localhost");
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
  require_once 'layout/admin.php';
  ?>


<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/cambiarPrivilegio.js"></script>
</body>
</html>
