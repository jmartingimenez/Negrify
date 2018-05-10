<?php

if(isset($_POST["btn_personal"])){
  $error = array();
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];

  if(!(ctype_alpha($nombre) && strlen($nombre) >= 3 && strlen($nombre) <= 25)){
    $error[] = "Nombre solamente debe tener caracteres alfabeticos";
  }

  if(!(ctype_alpha($apellido) && strlen($apellido) >= 3 && strlen($apellido) <= 25)){
    $error[] = "Apellido solamente debe tener caracteres alfabeticos";
  }

  if(sizeof($error) == 0){
    try{
      Usuario::actualizarDato($idCliente, "nombre", $nombre);
      Usuario::actualizarDato($idCliente, "apellido", $apellido);
      echo "<h5>Datos actualizados!</h5>";
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

if(isset($_POST["btn_email"])){
  $email = $_POST["email"];
  if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
    $error = "Email incorrecto";
  }else{
    $db = new Conexion();
    if($db->chequearCampo("usuario", "mail", $email)){
      $error = "El email '$email' se encuentra en uso";
    }
  }
  if(isset($error)){
    echo '<h4 class="red-text">ERROR!</h4>';
    echo "-".$error;
  }else{
    try{
      Usuario::actualizarDato($idCliente, "mail", $email);
      echo "<h5>Email actualizado!</h5>";
    }catch(Exception $e){
      echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
    }
  }
}

if(isset($_POST["btn_password"])){
  $error = array();
  $verdadera = Usuario::getPassword($idCliente);
  $actual = $_POST["originalPassword"];
  $nueva = $_POST["newPassword1"];
  $nuevaCheck = $_POST["newPassword2"];

  if($verdadera != md5($actual)){
    $error[] = "Contraseña incorrecta.";
  }else{
    if(strlen($nueva) < 6){
      $error[] = "La contraseña debe tener al menos 6 caracteres";
    }
    if($nueva != $nuevaCheck){
      $error[] = "Las contraseñas no coinciden";
    }
  }

  if(sizeof($error) == 0){
    try{
      $newpass = md5($nueva);
      Usuario::actualizarDato($idCliente, "contrasenia", $newpass);
      echo "<h5>Contraseña actualizada!</h5>";
    }
    catch(Exception $e){
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

if(isset($_POST["btn_map"])){
  $latitud = $_POST["pais_latitud"];
  $longitud = $_POST["pais_longitud"];
  $paisNombre = $_POST["pais_nombre"];
  try{
    Usuario::actualizarDato($idCliente, "pais_latitud", $latitud);
    Usuario::actualizarDato($idCliente, "pais_longitud", $longitud);
    Usuario::actualizarDato($idCliente, "pais", $paisNombre);
    echo "<h5>Localización actualizada!</h5>";
  }catch(Exception $e){
    echo '<strong class="red-text"> OCURRIO UN ERROR:</strong><br>'.$e;
  }

}
?>
