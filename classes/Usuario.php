<?php
include_once 'Conexion.php';

class Usuario{
  private $id;
  private $username;
  private $password;
  private $nombre;
  private $apellido;
  private $email;
  private $ban;
  private $cod_activacion;
  private $pais;
  private $pais_latitud;
  private $pais_longitud;
  private $privilegio;

  public function __construct($nombre, $apellido, $username, $email, $password, $pais, $pais_lat, $pais_long){
    $this->username = $username;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->email = $email;
    $this->password = md5($password);
    $this->cod_activacion = md5(rand(0,1000));
    $this->pais = $pais;
    $this->pais_latitud = $pais_lat;
    $this->pais_longitud = $pais_long;
  }

  public function registrar(){
    $db = new Conexion();
    $query = "INSERT INTO `usuario`(`nombre`, `apellido`, `username`, `contrasenia`, `mail`, `cod_activacion`, `pais`, `pais_latitud`, `pais_longitud`)
              VALUES ('$this->nombre', '$this->apellido', '$this->username', '$this->password', '$this->email', '$this->cod_activacion', '$this->pais', '$this->pais_latitud', '$this->pais_longitud')";
    $sql = $db->query($query);
    return $sql;
  }

  public function getId(){
    $db = new Conexion();
    $this->id = $db->getId("usuario", "username", $this->username);
    $db->close();

    return $this->id;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function getMail(){
    return $this->mail;
  }

  public function getBan(){
    return $this->ban;
  }

  public function getPais(){
    return $this->pais;
  }

  public function getCodigoActivacion(){
    return $this->cod_activacion;
  }

  public function getCoordenadas(){
    $arr = ['lat' => $this->pais_latitud, 'long' => $this->pais_longitud];
    return json_encode($arr);
  }

  public function getPrivilegio(){
    return $this->privilegio_id;
  }

  public function getPassword($id){
    $db = new Conexion();
    $query = "SELECT `contrasenia` FROM `usuario` WHERE `id` = '$id'";
    $pass = $db->query($query)->fetch_assoc()["contrasenia"];
    $db->close();
    return $pass;
  }

  public function getCoor($username){
    $resultado = array();
    $db = new Conexion();
    $query = "SELECT * FROM `usuario` WHERE `username` = '$username'";
    $data = $db->query($query)->fetch_assoc();
    $resultado["lat"] = $data["pais_latitud"];
    $resultado["long"] = $data["pais_longitud"];
    return $resultado;
  }

  public function getCantidadPlaylist($username){
    $db = new Conexion();
    $query = "SELECT COUNT(*) as `cantidad` FROM `playlist` INNER JOIN `usuario`
              ON `playlist`.`creador_id` = `usuario`.`id`
              WHERE `usuario`.`username` = '$username'";
    $cantidad = $db->query($query)->fetch_assoc()["cantidad"];
    $db->close();
    return $cantidad;
  }

  public function getUsername($id){
    $db = new Conexion();
    $query = "SELECT `username` FROM `usuario` WHERE `id` = '$id'";
    $user = $db->query($query)->fetch_assoc()["username"];
    $db->close();
    return $user;
  }

  public function chequearSiguiendo($seguidor, $seguido){
    $db = new Conexion();
    $query = "SELECT * FROM `seguir` WHERE `seguidor_id` = $seguidor AND `seguido_id` = $seguido";
    $sql = $db->query($query);
    if($sql->fetch_assoc()){
      return true;
    }else{
      return false;
    }
  }

  public function seguir($seguidor, $seguido){
    $db = new Conexion();
    if(Usuario::chequearSiguiendo($seguidor, $seguido)){
      throw new Exception("Ya lo estás siguiendo");
    }else{
      $db = new Conexion();
      $query = "INSERT INTO `seguir`(`seguidor_id`, `seguido_id`)
                VALUES ('$seguidor', '$seguido')";
      return $db->query($query);
    }
  }

  public function dejarDeSeguir($seguidor, $seguido){
    $db = new Conexion();
    $query = "DELETE FROM `seguir` WHERE `seguidor_id` = '$seguidor'
              AND `seguido_id` = '$seguido'";
    return $db->query($query);
  }

  public function getSiguiendo($id){
    $db = new Conexion();
    $query = "SELECT COUNT(*) as `cant` FROM `seguir` WHERE `seguidor_id` = $id";
    $cantidad = $db->query($query)->fetch_assoc()["cant"];
    $db->close();
    return $cantidad;
  }

  public function getListaSiguiendo($id){
    $resultado = array();
    $db = new Conexion();
    $query = "SELECT * FROM `usuario`
              INNER JOIN `seguir` ON `usuario`.id = `seguir`.`seguido_id`
              WHERE `seguir`.`seguidor_id` = $id";
    $sql = $db->query($query);
    while($fila = $sql->fetch_assoc()){
      $resultado[] = $fila["username"];
    }

    return $resultado;
  }

  public function getListaSeguidores($id){
    $resultado = array();
    $db = new Conexion();
    $query = "SELECT * FROM `usuario`
              INNER JOIN `seguir` ON `usuario`.id = `seguir`.`seguidor_id`
              WHERE `seguir`.`seguido_id` = $id";
    $sql = $db->query($query);
    while($fila = $sql->fetch_assoc()){
      $resultado[] = $fila["username"];
    }

    return $resultado;
  }

  public function getSeguidores($id){
    $db = new Conexion();
    $query = "SELECT COUNT(*) as `cant` FROM `seguir` WHERE `seguido_id` = $id";
    $cantidad = $db->query($query)->fetch_assoc()["cant"];
    $db->close();
    return $cantidad;
  }

  public function chequearDenuncia($denunciado, $denunciante){
    $db = new Conexion();
    $query = "SELECT `id` FROM `reportes_usuario`
              WHERE `usuario_denunciado` = '$denunciado'
              AND `usuario_denunciante` = '$denunciante'";
    if($db->query($query)->fetch_assoc()["id"]){
      return true;
    }else{
      return false;
    }
  }

  public function denunciar($denunciado, $denunciante){
    if(Usuario::chequearDenuncia($denunciado, $denunciante)){
      return false;
    }else{
      $db = new Conexion();
      $query = "INSERT INTO `reportes_usuario`(`usuario_denunciado`, `usuario_denunciante`)
      VALUES ('$denunciado', '$denunciante')";
      $sql = $db->query($query);
      return $sql;
    }
  }

  public function checkDenuncia($denunciado, $denunciante){
    $db = new Conexion();
    $query = "SELECT `id` FROM `reportes_usuario`
              WHERE `usuario_denunciante` = '$denunciante'
              AND `usuario_denunciado` = '$denunciado'";
    if($db->query($query)->fetch_assoc()["id"]){
      return true;
    }else{
      return false;
    }
  }

  public function setDenuncia($denunciado, $denunciante){
    if(Usuario::checkDenuncia($denunciado, $denunciante)){
      return false;
    }else{
      $db = new Conexion();
      $query = "INSERT INTO `reportes_usuario`(`usuario_denunciante`, `usuario_denunciado`)
      VALUES ('$denunciante', '$denunciado')";
      $sql = $db->query($query);
      return $sql;
    }
  }

  public function actualizarDato($id, $columna, $valor){
    $db = new Conexion();
    $query = "UPDATE `usuario` SET `$columna` = '$valor' WHERE `id` = '$id'";
    if($db->query($query)){
      return true;
    }else{
      throw new Exception("ERROR");
    }
  }
}
?>
