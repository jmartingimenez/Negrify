<?php
require_once "layout/validarpermisos.php";
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
  require_once 'layout/subircancion.php';
  ?>

  <div class="container">
    <div class="row">
      <form class="col l4 m6 s12 offset-l4 offset-m3" action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="input-field">
            <input id="nombre" type="text" class="validate" name="nombre" maxlength="20">
            <label class="active" for="nombre">Nombre</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="artista" type="text" class="validate" name="artista" maxlength="20">
            <label class="active" for="nombre">Artista</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <input id="album" type="text" class="validate" name="album" maxlength="20">
            <label class="active" for="nombre">Album</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field">
            <select name="genero">
              <option value="" disabled selected>Selecciona el genero</option>
              <?php
              require_once 'classes/Conexion.php';
              $db = new Conexion();
              $query = "SELECT `id`, `nombre` FROM `genero` ORDER BY `nombre` ASC";
              $sql = $db->query($query);
              while($fila = $sql->fetch_assoc()){
                $valor = $fila["id"];
                $nombre = $fila["nombre"];
                echo "<option value=$valor>$nombre</option>";
              }
              ?>
            </select>
            <label>Genero</label>
            <span class="subInput">Si no encuentras el genero, haz click <a href="/creargenero.php">aquí</a> para crearlo!</span>
          </div>
        </div>

        <div class="row">
          <div class="file-field input-field">
            <div class="btn">
              <input type="file" class="blue" id="cancion" name="cancion">
              <span>Archivo</span>
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
        </div>
      </div>

        <div class="row">
          <div class="input-field">
            <button type="submit" class="btn waves-effect waves-light right submit blue" name="enviar">
              <span>Subir</span>
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
</body>
</html>
