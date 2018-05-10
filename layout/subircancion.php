<?php
require_once './classes/Cancion.php';

if(isset($_POST['enviar'])){
  $error = array();
  $nombre = $_POST["nombre"];
  $artista = $_POST["artista"];
  $album = $_POST["album"];
  if(isset($_POST["genero"])){
    $genero = $_POST["genero"];
  }else{
    $error[] = "Por favor, seleccione un genero.";
  }

  if (empty($_FILES['cancion']['name'])) {
    $error[] = "No seleccionaste ningun archivo";
  }else{
    $cancion = $_FILES['cancion'];
    $nuevoNombre = str_replace(" ", "_", $nombre.".mp3");

    //Si el archivo no termina en .mp3 ... //
    if(pathinfo($cancion['name'])['extension'] != "mp3"){
      $error[] = "Solo se admiten archivos mp3";
    }else{
      //Si es un archivo mp3 verificamos que no exista en el servidor//
      if(file_exists("./archivos/canciones/".$nuevoNombre)){
        $error[] = "La canción ya se encuentra en el servidor";
      }

      if($cancion['error'] != 0){
        $error[] = "Se produjo un error al subir el archivo";
      }
    }

  }
  if(!(strlen($nombre) < 32 && strlen($nombre) > 2)){
    $error[] = "Por favor, ingrese un artista válido.";
  }

  if(!(strlen($artista) < 32 && strlen($artista) > 2)){
    $error[] = "Por favor, ingrese un artista válido.";
  }

  if(!(strlen($album) < 32 && strlen($album) > 2)){
    $error[] = "Por favor, ingrese un album válido.";
  }

  if(sizeof($error) != 0){
    foreach ($error as $er){
      echo "</br> $er";
    }
  }
  else{
    $path = dirname(__DIR__)."/archivos/canciones/".$nuevoNombre;
    move_uploaded_file($cancion["tmp_name"], $path);
    $cancion = new Cancion($nombre, $artista, $album, $genero);
    if($cancion->registrar()){
      echo "Canción subida exitosamente";
    }else{
      echo "Error al registrar la canción";
    }
  }
}
?>
