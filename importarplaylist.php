<?php
require_once "layout/validarpermisos.php";

?>
<!DOCTYPE>
<!DOCTYPE html>
<html>
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
	 	require_once 'layout/archivosJs.php';
	 ?>

   <div class="container">
     <form class="col l4 m6 s12 offset-l4 offset-m3" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="file-field input-field">
              <div class="btn">
                <input type="file" id="importe" name="importar">
                <span>Importar Playlist</span>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
          </div>
        </div>
          <div class="row">
            <div class="input-field">
              <button type="submit" class="btn waves-effect waves-light right submit" name="enviar">
                <span>Subir</span>
              </button>
            </div>
          </div>
     </form>
   </div>
</body>
</html>

<?php require_once 'layout/importarplaylist.php'; ?>
