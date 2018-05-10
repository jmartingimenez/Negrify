<?php
require_once 'Conexion.php';

class Genero{
  private $nombre;

  public function __construct($nombre){
    $this->nombre = $nombre;
  }

  public function registrar(){
    $db = new Conexion();
    if($db->chequearCampo("genero", "nombre", $this->nombre)){
      $db->close();
      throw new Exception("El genero ya existe.");
    }else{
      $query = "INSERT INTO `genero` (`nombre`) VALUES ('$this->nombre')";
      $sql = $db->query($query);
      $db->close();
      return $sql;
    }
  }

  public function getGenero($generoId){
    $db = new Conexion();
    $query = "SELECT * FROM `genero` WHERE `id` = '$generoId'";
    if(!$db->query($query)->num_rows){
      throw new Exception("Genero inexistente");
    }else{
      return $db->query($query)->fetch_assoc()["nombre"];
    }
  }
}
?>
