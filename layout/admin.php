<?php
	require_once "./classes/Conexion.php";
	$db = new Conexion();
?>

<!--  Redirigiendo a la pagina de denuncias -->
<?php
if(isset($_POST['usuarioRep']) AND !empty($_POST['verUsuario']))    $opcionClickeada = "Usuario";
if(isset($_POST['playlistRep']) AND !empty($_POST['verPlaylist']))  $opcionClickeada = "Playlist";

  if(isset($opcionClickeada)){
    $_SESSION['denuncia'] = $opcionClickeada;
    header("location: /denuncias.php");
  }
?>

  <div class="container">
    <div class="row">
    <h5 class="center-align">Panel de administraci&oacute;n</h5>
      <div id="contenedorAcordeon" class="col s12">
        <ul class="collapsible" data-collapsible="accordion">

<!-- DENUNCIAS DE PLAYLIST -->
          <li>
            <div class="collapsible-header right-align blue white-text">
              <i class="material-icons">keyboard_arrow_down</i>Denuncias de playlist
              <i class="material-icons right">delete</i>
            </div>
            <div class="collapsible-body">
              <p id="resumenDenunciasPlaylist">
                <?php
                  $getPlaylistDenunciadas = 'SELECT COUNT(*) AS "Cantidad"
                                             FROM reportes_playlist
                                             WHERE confirmacion=0';
                  $sql = $db->query($getPlaylistDenunciadas);
                  if($sql->num_rows)
                    $fila=$sql->fetch_assoc();
                    print("<strong>Playlist pendientes de revisi&oacute;n:</strong> " .$fila['Cantidad']);
                    print('<form method="post" class="col-s12">' .
                      '<input type="hidden" name="verPlaylist" value="verPlaylist"></input>'.
                      '<button type="submit" class="btn right submit blue" name="playlistRep">'.
                      '<span>Ver</span></button>'.
                          '</form>');
                ?>
              </p>
            </div>
          </li>
<!-- DENUNCIAS DE USUARIOS -->
          <li>
            <div class="collapsible-header right-align blue white-text">
              <i class="material-icons">keyboard_arrow_down</i>Denuncias de usuarios
              <i class="material-icons right">mood_bad</i>
            </div>
            <div class="collapsible-body">
              <p id="resumenDenunciasUsuarios">
                <?php
                  $getUsuariosDenunciados = 'SELECT COUNT(*) AS "Cantidad"
                                              FROM reportes_usuario
                                              WHERE confirmacion=0';
                  $sql = $db->query($getUsuariosDenunciados);
                  if($sql->num_rows)
                    $fila=$sql->fetch_assoc();
                    print("<strong>Usuarios pendientes de revisi&oacute;n:</strong> " .$fila['Cantidad']);
                    print('<form method="post" class="col-s12">' .
                      '<input type="hidden" name="verUsuario" value="verUsuario"></input>'.
                      '<button type="submit" class="btn right submit blue" name="usuarioRep">'.
                      '<span>Ver</span></button>'.
                          '</form>');
                ?>
              </p>
            </div>
          </li>
 <!-- AGREGAR/QUITAR ADMIN -->
          <li>
            <div class="collapsible-header right-align blue white-text">
              <i class="material-icons">keyboard_arrow_down</i>Agregar/Quitar Admin
              <i class="material-icons right">supervisor_account</i>
            </div>
            <div class="collapsible-body">
              <div id="contenedorIzquierdo" class="col-s6 left">
                <div id="inputIzquierdo" class="input-field">
                  <input placeholder="Escribe el id de usuario" id="buscarUser" type="text" name="buscarUser"></input>
                </div>
                <div id="respuestaBusqueda"></div>
              </div>
              <div id="contenedorDerecho" class="col-s6 right"><br/>
                <div id="divBotonBusqueda" class="right">
                 <button id="botonBusqueda" class="btn waves-effect waves-light blue"
                    type="submit" name="buscar">
                       Buscar usuario
                 </button>
                </div><br/>
                <div id="divBotonPrivilegio" class="right"><br/>
                  <button id="botonPrivilegio" class="btn waves-effect waves-light blue"
                     type="submit" name="modificar">
                        Modificar privilegio
                  </button>
                </div>
              </div><br/><br/><br/><br/><br/><br/><br/><br/><br/>
              <div id="mensaje" class="center-align"></div>
            </div>
          </li>
  <!-- ESTADISTICAS -->
          <li>
            <div class="collapsible-header right-align blue white-text">
              <i class="material-icons">keyboard_arrow_down</i>Estad&iacute;sticas
              <i class="material-icons right">assessment</i>
            </div>
            <div class="collapsible-body">
              <p id="resumenEstadisticas">
              	<?php
              		//Cantidad de usuarios
              		$getCantidadUsuarios = 'SELECT COUNT(*) AS "Cantidad" FROM usuario';
              		$sql = $db->query($getCantidadUsuarios);
              		if($sql->num_rows)
              			while($fila=$sql->fetch_assoc())
              				print("<strong>Usuarios registrados:</strong> " . $fila['Cantidad'] . "\n<br/>");
              		//Cantidad de canciones subidas
              		$getCantidadCanciones = 'SELECT COUNT(*) AS "Cantidad" FROM cancion';
              		$sql = $db->query($getCantidadCanciones);
              		if($sql->num_rows)
              			while($fila=$sql->fetch_assoc())
              				print("<strong>Canciones subidas:</strong> " . $fila['Cantidad'] . "\n<br/>");
              		//Cantidad de playlist subidas
              		$getCantidadPlaylist = 'SELECT COUNT(*) AS "Cantidad" FROM playlist';
              		$sql = $db->query($getCantidadPlaylist);
              		if($sql->num_rows)
              			while($fila=$sql->fetch_assoc())
              				print("<strong>Playlist creadas:</strong> " . $fila['Cantidad'] . "\n<br/>");
              	?>
              	<a href="stats.php" class="right">
              		<strong>Click para ver gr&aacute;ficos estad&iacute;sticos</strong>
              	</a>
              </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
