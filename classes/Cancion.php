<?php
require_once 'Conexion.php';

class Cancion{
  private $nombre;
  private $artista;
  private $album;
  private $genero;

  public function __construct($nombre, $artista, $album, $genero){
    $this->nombre = $nombre;
    $this->artista = $artista;
    $this->album = $album;
    $this->genero = $genero;
  }

  public function registrar(){
    $db = new Conexion();
    $query = "INSERT INTO `cancion` (`nombre`, `artista`, `album`, `genero_id`) VALUES ('$this->nombre', '$this->artista', '$this->album', '$this->genero')";
    $sql = $db->query($query);
    $res = $sql;
    $db->close();
    return $res;
  }

  public function getId(){
    $db = new Conexion();
    $query = "SELECT * FROM `cancion` WHERE `nombre` = '$this->nombre'";
    $id = $db->query($query)->fetch_assoc()["id"];
    $db->close();
    return $id;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function getArtista(){
    return $this->artista;
  }

  public function getAlbum(){
    return $this->album;
  }

  public function getFile(){
    $nombre = $this->nombre;
    $nombre = "/archivos/canciones/".str_replace(" ", "_", $nombre);
    $nombre .= ".mp3";
    return $nombre;
  }
}
?>
