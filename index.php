<?php
session_start();
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
      <div class="col s12">
          <?php
          require_once 'layout/index.php';
          ?>
      </div>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
