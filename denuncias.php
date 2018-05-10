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
  <link rel="stylesheet" type="text/css" href="lib/dataTables/css/jquery.dataTables.min.css">
</head>
<body>

  <?php
  require_once 'layout/navbar.php';
  require_once 'layout/denuncias.php';
  ?>


<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/denuncia.js"></script>
<script type="text/javascript" src="lib/dataTables/js/jquery.dataTables.min.js"></script>




</body>
</html>
