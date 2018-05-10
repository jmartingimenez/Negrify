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
  require_once 'classes/Genero.php';

  if(isset($_POST['enviar'])){
    $error = array();
    $nombre = strtolower($_POST['nombre']);

    if(!(strlen($nombre) > 2 && strlen($nombre) < 20)){
      echo "Debe ingresar al menos 3 caracteres.";
    }else{
      $genero = new Genero("$nombre");
      try{
        if($genero->registrar()){
          echo "Genero creado correctamente.";
        }
        else{
          echo "Error al crear el genero.";
        }
      } catch(Exception $e){
        echo $e->getMessage();
      }
    }
  }
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
            <button type="submit" class="btn waves-effect waves-light right submit" name="enviar">
              <span>Crear</span>
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php'; ?>
</body>
</html>
