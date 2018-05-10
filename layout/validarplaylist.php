<?php
require_once "./classes/Conexion.php";
require_once "./classes/Playlist.php";
$db = new Conexion();

if(isset($_POST["enviar"])){

  $error = array();
  $nombre = $_POST["nombre"];
  if(strlen($nombre) < 3 || strlen($nombre) > 20){
    $error[] = "El campo nombre debe tener entre 3 y 20 caracteres.";
  }else{
    if($db->chequearCampo("playlist", "nombre", $nombre)){
      $error[] = "La playlist '$nombre' ya existe.";
    }
  }

  if(isset($_POST["genero"])){
    $genero = $_POST["genero"];
  }else{
    $error[] = "Por favor, seleccione un genero.";
  }

  if(isset($_POST["estado"])){
    $estado = $_POST["estado"];
  }else{
    $error[] = "Por favor, seleccione un estado.";
  }

  if (empty($_FILES['foto']['name'])) {
    $error[] = "No seleccionaste ningun archivo.";
  }else{
    $foto = $_FILES['foto'];
    $extension = pathinfo($foto['name'])['extension'];
    $nuevoNombre = str_replace(" ", "_", $nombre.".$extension");

    //Si el archivo no termina en .jpg o .png ... //
    if($extension != "jpg" && $extension != "png"){
      $error[] = "Solo se admiten archivos jpg o png";
    }else{
      if($foto['error'] != 0){
        $error[] = "Se produjo un error al subir el archivo";
      }
    }
  }

  if(sizeof($error) != 0){
    foreach ($error as $er){
      echo "</br> $er";
    }
  }else{
    try{
      $playlist = new Playlist($nombre, $_SESSION["user"], $genero, $estado, $nuevoNombre);
      if($playlist->registrar()){
        $path = dirname(__DIR__)."/archivos/playlist_fotos/".$nuevoNombre;
        move_uploaded_file($foto["tmp_name"], $path);
        $idplaylist = $db->getId("playlist", "nombre", $nombre);
        header("Location:http://localhost/playlist.php?id=$idplaylist");
      }
    }catch(Exception $e){
      echo $e;
    }
  }

}
?>
