<div id="contenedorIndexVisitante">
	<div id="tituloIndexVisitante">
		<p><h5 class="center-align">Tu m&uacute;sica siempre con vos</h5></p>
	</div>
	<div id="mensajeIndexVisitante">
		<p>
			Bienvenido a Negrify!. Unite a la comunidad m&aacute;s grande de intercambio de listas
			de reproducci&oacute;n. Negrify te permite escuchar entre miles de Playlist sin
			ning&uacute;n tipo de restricci&oacute;n, podes rankear, creas tus propias Playlist,
			ademas de importar y exportar listas.
		</p>
	</div>
	<div id="contenedorTopPlaylist">
	<p><h3 class="center-align">Top 3 - Playlist reproducidas</h3></p>
		<?php topReproducciones(); ?>
	</div>
</div>


<?php
	function topReproducciones(){
		require_once "./classes/Conexion.php";
		$db = new Conexion();

		$resultado = array();
		$query = "SELECT * FROM playlist WHERE estado='publica' ORDER BY reproducciones DESC LIMIT 3";
		$sql = $db->query($query);

	  	while($fila = $sql->fetch_assoc())
	    	$resultado[] = $fila;

	   foreach($resultado as $playlist){
	    $nombreDeImagen = $playlist["foto"];
	    $auxGenero = $playlist["genero_id"];
	    $queryGenero = "SELECT * FROM `genero` WHERE `id` = '$auxGenero'";
	    $sqlGenero = $db->query($queryGenero);
	    $genero = $sqlGenero->fetch_assoc()["nombre"];

	   	$playlistId = $db->getId("playlist", "nombre", $playlist["nombre"]);

	    echo "<div class=\"col l4 m6 s12\">";
	    echo "<div class=\"card\">";
	    echo "<div class=\"card-image\">";
	    echo "<img src=/archivos/playlist_fotos/".$nombreDeImagen.">";
	    echo "<span class=\"card-title\"><strong><a href=\"http://localhost/playlist.php?id=$playlistId\">".$playlist["nombre"]."</a></strong></span>";
	    echo "</div>";
	    echo "<div class=\"card-content\">";
	    echo "<p><strong>Genero:</strong> $genero</p>";
	    echo "<p><strong>Reproducciones: </strong>".$playlist["reproducciones"]."</p>";
	    echo "</div>";
	    echo "</div>";
	    echo "</div>";

	   }
	}

?>

<a id="btn_sin_verificar" class="waves-effect waves-light btn" href="#modalSinVerificar" style="display: none;">Modal</a>

<!-- Modal Structure -->
<div id="modalSinVerificar" class="modal">
	<div class="modal-content">
		<h4 class="red-text">ATENCIÓN</h4>
		<p>No has activado tu cuenta!
		</p>
		<p>
			Revista tu correo electrónico y sigue los pasos para poder activarla.
		</p>
		<p>
			De lo contrario no podras disfrutar de las funcionalidades de Negrify.
		</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Entendido</a>
	</div>
</div>
