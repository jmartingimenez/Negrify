<?php
require_once 'Config.php';
class Conexion extends mysqli{

  public function __construct(){
    parent::__construct(Config::$host, Config::$user, Config::$pass, Config::$db);
    if($this->connect_errno){
      die ('Error en la conexion a la base de datos');
    }
  }

  public function chequearCampo($tabla, $columna, $valor){
    $query = "SELECT * FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $filas = $sql->num_rows;
    return $filas;
  }

  public function getId($tabla, $columna, $valor){
    $query = "SELECT `id` FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $id = $sql->fetch_assoc()["id"];
    return $id;
  }

}
?>
