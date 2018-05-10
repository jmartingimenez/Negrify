<?php
include_once './classes/Conexion.php';

if(isset($_POST['enviar'])){
  $user = $_POST['userid'];
  $pass = md5($_POST['password']);
  $db = new Conexion();
  $query = "SELECT * FROM usuario WHERE `username` = '$user' AND `contrasenia` = '$pass' ";
  $sql = $db->query($query);
  if($sql->num_rows){
    $data = $sql->fetch_assoc();
    if($data["ban"] != 0){
      $_SESSION["ban"] = 1;
    }
    if($data["privilegio_id"] == 1){
      $_SESSION["admin"] = 1;
    }
    if($data["activado"] == 1){
      $_SESSION["user"] = $user;
    }else{
      $_SESSION['usernoverificado'] = $user;
      setcookie('sinverificar', 'true');
    }

    Header('Location: http://localhost');
  }
  else{
    echo "Usuario y/o contraseña incorrectos";
  }
}
?>
