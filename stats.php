<?php
session_start();
if(!isset($_SESSION['admin'])){
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
    require_once 'layout/stats.php';
  ?>

  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="js/stats.js"></script>
</body>
</html>

<?php
  if(isset($_POST['generarPDF'])
    AND !empty($_POST['usuariosBaneadosURI'])
    AND !empty($_POST['usuariosPorPaisURI'])
    AND !empty($_POST['playlistCreadasURI'])
    AND !empty($_POST['rankingReproduccionesURI'])
    ANd !empty($_POST['rankingVotosURI'])){
      $_SESSION['usuariosBaneadosURI']        =   $_POST['usuariosBaneadosURI'];
      $_SESSION['usuariosPorPaisURI']         =   $_POST['usuariosPorPaisURI'];
      $_SESSION['playlistCreadasURI']         =   $_POST['playlistCreadasURI'];
      $_SESSION['rankingReproduccionesURI']   =   $_POST['rankingReproduccionesURI'];
      $_SESSION['rankingVotosURI']            =   $_POST['rankingVotosURI'];
      header('location:../getPDF.php');
  }
?>
