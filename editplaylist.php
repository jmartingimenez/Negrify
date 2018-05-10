<?php
require_once "layout/validarpermisos.php";

if(!isset($_GET['pid'])){
  header('Location: http://localhost');
}
require_once 'layout/navbar.php';
require_once 'classes/Usuario.php';
require_once 'classes/Conexion.php';
require_once 'classes/Playlist.php';

$db = new Conexion();

$idplaylist = $_GET['pid'];
$iduser = $db->getId("usuario", "username", $_SESSION["user"]);
$idCreadorPlaylist = Playlist::getCreadorId($idplaylist);
$nombrePlaylist = Playlist::getNombrePorId($idplaylist);
$estadoPlaylist = Playlist::getEstadoPorId($idplaylist);

$query = "SELECT * FROM `playlist` WHERE `id` = '$idplaylist'";
$playlistData = $db->query($query)->fetch_assoc();

if($iduser != $idCreadorPlaylist){
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
  <link rel="stylesheet" href="css/editprofile.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col l6 s12 offset-l3">
        <h5>Editar playlist <?php echo $nombrePlaylist; ?></h5>
      </div>
      <div class="col l6 s12 offset-l3">
        <?php
        require_once "layout/editPlaylist.php";
         ?>
      </div>

      <div class="col l6 s12 offset-l3">

        <div class="row">
          <form action="" method="post">
          <div class="input-field col s9">
            <input id="nombre" type="text" class="validate" name="nombre" maxlength="25" value="<?php echo $playlistData['nombre']; ?>">
            <label class="active" for="nombre">Nombre</label>
          </div>

          <div class="input-field col s2 offset-s1 botonenviar">
            <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_nombre">
              <span>Ok</span>
            </button>
          </div>
        </form>
        </div>

        <div class="row">
          <form action="" method="post">
          <div class="input-field col s9">
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
            <span class="subInput" style="bottom: 0;">
              Si no encuentras el genero, haz click
              <a href="/creargenero.php"><span style="color: #2196f3">aquí</span>
              </a> para crearlo!</span>
          </div>

          <div class="input-field col s2 offset-s1 botonenviar">
            <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_genero">
              <span>Ok</span>
            </button>
          </div>
          </form>
        </div>

        <div class="row">
          <form action="" method="post" enctype="multipart/form-data">

            <div class="file-field input-field col s9">
              <div class="btn blue">
                <input type="file" id="foto" name="foto">
                <span>Foto</span>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
          </div>

          <div class="input-field col s2 offset-s1 botonenviar">
            <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_foto">
              <span>Ok</span>
            </button>
          </div>
        </form>
      </div>

      <div class="row">
        <form action="" method="post">
          <div class="input-field col s9">
              <input type="radio" name="estado" id="e_publica" value="publica" <?php echo ($estadoPlaylist == "publica") ? "checked" : "" ?> />
              <label for="e_publica">Pública</label>
              <input type="radio" name="estado" id="e_privadae_soloyo" value="privada"  <?php echo ($estadoPlaylist == "privada") ? "checked" : "" ?>/>
              <label for="e_privadae_soloyo">Privada</label>
              <input type="radio" name="estado" id="e_soloyo" value="solo yo"  <?php echo ($estadoPlaylist == "solo yo") ? "checked" : "" ?>/>
              <label for="e_soloyo">Solo yo</label>
          </div>

          <div class="input-field col s2 offset-s1 botonenviar">
            <button type="submit" class="btn waves-effect waves-light submit blue" name="btn_estado">
              <span>Ok</span>
            </button>
          </div>
      </form>
    </div>

    <div class="row">
      <div class="col s12" style="text-align: center; margin-top: 20px;">
        <div class="col s6">
          <a class="waves-effect waves-light btn blue white-text" href="http://localhost/agregarcancion.php?playlistid=<?php echo $idplaylist; ?>"><i class="material-icons left">add</i>CANCIONES</a>
        </div>
        <div class="col s6">
          <a class="waves-effect waves-light btn blue white-text" href="http://localhost/quitarcancion.php?playlistid=<?php echo $idplaylist; ?>"><i class="material-icons left">remove</i>CANCIONES</a>
        </div>

      </div>
    </div>

      </div>
    </div>
  </div>

<?php require_once 'layout/archivosJs.php';?>
</body>
</html>
