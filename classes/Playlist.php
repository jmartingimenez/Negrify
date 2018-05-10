<?php
require_once 'Conexion.php';
require_once 'Cancion.php';

class Playlist{
  private $nombre;
  private $creador;
  private $genero;
  private $estado;
  private $foto;
  private $canciones = array();

  public function __construct($nombre, $creador, $genero, $estado, $foto){
    $this->nombre = $nombre;
    $this->genero = $genero;
    $this->estado = $estado;
    $this->foto = $foto;

    $db = new Conexion();
    $this->creador = $db->getId("usuario", "username", $creador);
    $db->close();
    $this->updateCanciones();
  }


  public function registrar(){
    $db = new Conexion();
    $query = "INSERT INTO `playlist`(`nombre`, `creador_id`, `genero_id`, `estado`, `foto`) VALUES ('$this->nombre', '$this->creador', '$this->genero', '$this->estado', '$this->foto')";
    $sql = $db->query($query);
    $resultado = $sql;
    if(!$resultado){
      throw new Exception($db->error);
    }
    $db->close();
    return $resultado;
  }

  // INICIO GETTERS

  public function getId(){
    $db = new Conexion();
    $query = "SELECT `id` FROM `playlist` WHERE `nombre` = '$this->nombre'";
    $id = $db->query($query)->fetch_assoc()["id"];
    $db->close();

    return $id;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function getNombrePorId($id){
    $db = new Conexion();
    $query = "SELECT `nombre` FROM `playlist` WHERE `id` = '$id'";
    return $db->query($query)->fetch_assoc()["nombre"];
  }

  public function getCreador($playlistId){
    $db = new Conexion();
    $query = "SELECT * FROM `usuario` WHERE `id` = '$playlistId'";
    $creador = $db->query($query)->fetch_assoc()["username"];
    $db->close();
    return $creador;
  }

  public function getCreadorId($playlistid){
    $db = new Conexion();
    $query = "SELECT `creador_id` FROM `playlist` WHERE `id` = '$playlistid'";
    $creador = $db->query($query)->fetch_assoc()["creador_id"];
    $db->close();
    return $creador;
  }

  public function getGenero(){
    return $this->genero;
  }

  public function getEstado(){
    return $this->estado;
  }

  public function getCanciones(){
    return $this->canciones;
  }

  public function getEstadoPorId($id){
    $db = new Conexion();
    $query = "SELECT `estado` from `playlist` WHERE `id` = $id";
    $sql = $db->query($query);
    return $sql->fetch_assoc()["estado"];
  }

  public function getFechaCreacion($id){
    $db = new Conexion();
    $query = "SELECT `fecha_creacion` from `playlist` WHERE `creador_id` = $id";
    $sql = $db->query($query);
    return $sql->fetch_assoc()["fecha_creacion"];
  }

  public function getCancionesPorId($id){
    $canciones = array();
    $db = new Conexion();
    $query = "SELECT `nombre` FROM `cancion`
              INNER JOIN `playlist_cancion` ON `cancion`.`id` = `playlist_cancion`.`cancion_id`
              WHERE `playlist_cancion`.`playlist_id` = $id";
    $sql = $db->query($query);
    while($fila = $sql->fetch_assoc()){
      $fila["archivo"] = $fila["nombre"].".mp3";
      $fila["archivo"] = str_replace(" ", "_", $fila["archivo"]);
      $canciones[] = $fila;
    }
    $db->close();
    return $canciones;
  }

  public function getFoto($id){
    $db = new Conexion();
    $query = "SELECT `foto` FROM `playlist` WHERE `id` = $id";
    return $db->query($query)->fetch_assoc()["foto"];
  }

  public function getMeGusta($playlistId){
    $db = new Conexion();
    $query = "SELECT COUNT(*) AS `cantidad` FROM `me_gusta` WHERE `playlist_id` = '$playlistId'";
    $meGusta = $db->query($query)->fetch_assoc()["cantidad"];
    $db->close();
    return $meGusta;
  }

  public function getReproducciones($playlistId){
    $db = new Conexion();
    $query = "SELECT `reproducciones` FROM `playlist` WHERE `id` = '$playlistId'";
    $repro = $db->query($query)->fetch_assoc()["reproducciones"];
    $db->close();
    return $repro;
  }

  // FIN GETTERS

  public function chequearMeGusta($playlistId, $userId){
    $db = new Conexion();
    $query = "SELECT * FROM `me_gusta` WHERE `usuario_id` = '$userId' AND `playlist_id` = '$playlistId'";
    $db->query($query);
    return $db->affected_rows;
  }

  public function setMeGusta($playlistId, $userId){
    $db = new Conexion();
    if(!$db->getId("playlist", "id", $playlistId)){
      throw new Exception("Playlist inexistente");
    }
    if(!$db->getId("usuario", "id", $userId)){
      throw new Exception("Usuario inexistente");
    }
    $sql = $db->query("SELECT * FROM `me_gusta` WHERE `usuario_id` = '$userId' AND `playlist_id` = '$playlistId'");
    if($sql->num_rows){
      throw new Exception("Ya le has dado me gusta");
    }else{
      if($db->query("INSERT INTO `me_gusta`(`usuario_id`, `playlist_id`) VALUES ('$userId', '$playlistId')")){
        return true;
      }else {
        return false;
      }
    }
  }

  public function deleteMeGusta($playlistId, $userId){
    $db = new Conexion();
    if(!$db->getId("playlist", "id", $playlistId)){
      throw new Exception("Playlist inexistente");
    }
    if(!$db->getId("usuario", "id", $userId)){
      throw new Exception("Usuario inexistente");
    }

    $query = "DELETE FROM `me_gusta` WHERE `playlist_id` = $playlistId AND `usuario_id` = $userId";
    $sql = $db->query($query);
    if($db->affected_rows == 1){
      $estado = true;
    }else{
      $estado = false;
    }
    return $estado;
  }

  public function setReproduccion($playlistId){
    $db = new Conexion();
    $query = "UPDATE `playlist` SET `reproducciones` = `reproducciones` + 1 WHERE `id` = '$playlistId'";
    if($db->query($query)){
      return true;
    }else{
      return false;
    }
  }


  public function updateCanciones(){
    $db = new Conexion();
    $playlist_id = $this->getId();
    $query = "SELECT * FROM `playlist_cancion` WHERE `playlist_id` = '$playlist_id'";
    $sql = $db->query($query);
    if($sql->num_rows){
      while($fila = $sql->fetch_assoc()){
        $dbCancion = new Conexion();
        $cancion_id = $fila["cancion_id"];
        $queryCancion = "SELECT * FROM `cancion` WHERE `id` = '$cancion_id'";
        $sqlCancion = $dbCancion->query($queryCancion);
        if($sqlCancion->num_rows){
          while($filaCancion = $sqlCancion->fetch_assoc()){
            $cancion = new Cancion($filaCancion["nombre"], $filaCancion["artista"], $filaCancion["album"], $filaCancion["genero_id"]);
            $this->canciones[] = $cancion;
          }
        }
      }
      $dbCancion->close();
    }
    $db->close();
  }

  public function existeCancion($cancion_id){
    $resultado = false;
    $canciones = $this->getCanciones();
    foreach($canciones as $cancion){
      if($cancion->getId() == $cancion_id){
        $resultado = true;
      }
    }
    return $resultado;
  }

  public function existeCancionDB($playlist_id, $cancion_id){
    $resultado = false;
    $db = new Conexion();
    $query = "SELECT `id` FROM `playlist_cancion` WHERE `cancion_id` = '$cancion_id' AND `playlist_id` = '$playlist_id'";
    $sql = $db->query($query);
    if($sql->num_rows){
      $resultado = true;
    }
    return $resultado;
  }

  // '$ids' es un array con todos los ids de las canciones a ser agregadas en la playlist
  public function agregarCancion($id){
    $db = new Conexion();
    $resultado = false;

    //Solo agrego la canción si no fue subida previamente.
    if(!$this->existeCancion($id)){
      $query = "SELECT * FROM `cancion` WHERE `id` = '$id'";
      $sql = $db->query($query);
      $data = $sql->fetch_assoc();
      $cancion = new Cancion($data["nombre"], $data["artista"], $data["album"], $data["genero_id"]);
      $this->canciones[] = $cancion;
      $resultado = true;
    }
    $db->close();
    return $resultado;
  }


  public function actualizarCanciones(){
    $resultado = false;
    $db = new Conexion();
    $playlist_id = $this->getId();

    foreach($this->canciones as $cancion){
      $cancion_id = $cancion->getId();
      if(!$this->existeCancionDB($playlist_id, $cancion_id)){
        $query = "INSERT INTO `playlist_cancion`(`cancion_id`, `playlist_id`) VALUES ('$cancion_id', '$playlist_id')";
        if($db->query($query)){
          $resultado = true;
        }
        if($db->error){
          var_dump($db->error);
        }
      }
    }
    $db->close();
    return $resultado;
  }

  public function buscarPlaylistPorNombre($input, $seguidor){
    $db = new Conexion();
    /* BUSCO 3 TIPOS DE PLAYLIST DE 3 MANERAS DISTINTAS (NOMBRE, CREADOR O GENERO):
    1. PLAYLIST PUBLICAS
    2. PLAYLIST PRIVADAS DONDE EL SEGUIDOR ESTE SIGUIENDO AL CREADOR DE LA PLAYLIST
    3. PLAYLIST DEL MISMO USUARIO QUE ESTA BUSCANDO, SIN IMPORTAR SI LA PLAYLIST ES PRIVADA O "SOLO YO"
    */
    if($seguidor > 0){
      $query = "SELECT * FROM `playlist`
                WHERE (`nombre` LIKE '%$input%' OR
                `creador_id` IN (SELECT `id` FROM `usuario` WHERE `username` LIKE '%$input%') OR
                `genero_id` IN (SELECT `id` FROM `genero` WHERE `nombre` LIKE '%$input%')) AND
                (`estado` = 'publica' OR
                (`estado` = 'privada' AND
                `creador_id` IN (SELECT `seguido_id` FROM `seguir` WHERE `seguidor_id` = $seguidor )) OR
                `creador_id` = $seguidor)";
    }
    else{
      $query = "SELECT * FROM `playlist`
                WHERE (`nombre` LIKE '%$input%' OR
                `creador_id` IN (SELECT `id` FROM `usuario` WHERE `username` LIKE '%$input%') OR
                `genero_id` IN (SELECT `id` FROM `genero` WHERE `nombre` LIKE '%$input%')) AND
                (`estado` = 'publica')";
    }

    $sql = $db->query($query);

    if(!$sql->num_rows){
      return false;
    }else{
      $resultado = array();
      while($fila = $sql->fetch_assoc()){
        $resultado[] = $fila;
      }
      return json_encode($resultado);
    }
  }

  public function checkDenuncia($playlist, $denunciante){
    $db = new Conexion();
    $query = "SELECT `id` FROM `reportes_playlist`
              WHERE `usuario_id` = '$denunciante'
              AND `playlist_id` = '$playlist'";
    if($db->query($query)->fetch_assoc()["id"]){
      return true;
    }else{
      return false;
    }
  }

  public function setDenuncia($playlist, $denunciante){
    if(Playlist::checkDenuncia($playlist, $denunciante)){
      return false;
    }else{
      $db = new Conexion();
      $query = "INSERT INTO `reportes_playlist`(`usuario_id`, `playlist_id`)
      VALUES ('$denunciante', '$playlist')";
      $sql = $db->query($query);
      return $sql;
    }
  }

  public function actualizarDato($playlistId, $columna, $valor){
    $db = new Conexion();
    $query = "UPDATE `playlist` SET `$columna` = '$valor' WHERE `id` = '$playlistId'";
    if($db->query($query)){
      return true;
    }else{
      throw new Exception("ERROR");
    }
  }

}
?>
