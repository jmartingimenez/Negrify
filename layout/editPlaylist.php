<?php
if(isset($_POST["btn_nombre"])){
  $db = new Conexion();
  $error = array();
  $nombre = $_POST["nombre"];
  if(strlen($nombre) < 3 || strlen($nombre) > 20){
    $error[] = "El campo nombre debe tener entre 3 y 20 caracteres.";
  }else{
    if($db->chequearCampo("playlist", "nombre", $nombre)){
      $error[] = "La playlist '$nombre' ya existe.";
    }
  }

  if(sizeof($error) == 0){
    try{
      Playlist::actualizarDato($idplaylist, "nombre", $nombre);
      echo "<h5>Nombre actualizado!</h5>";
    }catch(Exception $e){
      echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
    }
  }else{
    echo '<h4 class="red-text">ERROR!</h4>';
    echo "<strong>Ocurrieron los siguientes errores:</strong><br>";
    foreach($error as $er){
      echo "-".$er;
    }
  }
}

if(isset($_POST["btn_genero"])){
  if(isset($_POST["genero"])){
    $genero = $_POST["genero"];
    try{
      Playlist::actualizarDato($idplaylist, "genero_id", $genero);
      echo "<h5>Genero actualizado!</h5>";
    }catch(Exception $e){
      echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
    }

  }
  else{
    echo '<h4 class="red-text">ERROR!</h4>';
    echo "<strong>Ocurrieron los siguientes errores:</strong><br>";
    echo "-Debes seleccionar un género";
  }
}

if(isset($_POST["btn_foto"])){
  $error = array();
  if (empty($_FILES['foto']['name'])) {
    $error[] = "No seleccionaste ningún archivo";
  }else{
    $foto = $_FILES['foto'];
    $extension = pathinfo($foto['name'])['extension'];

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
    echo '<h4 class="red-text">ERROR!</h4>';
    echo "<strong>Ocurrieron los siguientes errores:</strong><br>";
    foreach($error as $er){
      echo "-".$er;
    }
  }else{
    $fotoVieja = Playlist::getFoto($idplaylist);
    $nombre = Playlist::getNombrePorId($idplaylist);
    $nuevoNombre = str_replace(" ", "_", $nombre.".$extension");

    try{
      $fotoABorrar = dirname(__DIR__)."/archivos/playlist_fotos/".$fotoVieja;
      $nuevaFoto = dirname(__DIR__)."/archivos/playlist_fotos/".$nuevoNombre;
      if(unlink($fotoABorrar)){
        move_uploaded_file($foto["tmp_name"], $nuevaFoto);
        echo "<h5>Foto actualizada!</h5>";
      }
    }catch(Exception $e){
      echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
    }
  }
}

if(isset($_POST["btn_estado"])){
  if(isset($_POST["estado"])){
    $estado = $_POST["estado"];
    try{
      Playlist::actualizarDato($idplaylist, "estado", $estado);
      echo "<h5>Estado actualizado!</h5>";
    }catch(Exception $e){
      echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
    }

  }
  else{
    echo '<h4 class="red-text">ERROR!</h4>';
    echo "<strong>Ocurrieron los siguientes errores:</strong><br>";
    echo "-Debes seleccionar un género";
  }
}

?>
