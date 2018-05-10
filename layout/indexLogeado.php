<div id="contenedorIndexLogeado">
	<div id="tituloIndexLogeado">
		<p><h5 class="center-align">Tu m&uacute;sica siempre con vos</h5></p>
	</div>
	<div id="mensajeIndexLogeado">
		<p>
			<?php saludo(); ?>
		</p>
		<p>
			En el men&uacute; superior derecho podras acceder a las funcionalidades
			de tu cuenta. Disfruta Negrify!.
		</p>
	</div>
	<div id="contenedorTopPlaylist">
	<p><h3 class="center-align">Últimas playlist de tus amigos</h3></p>
		<?php topReproducciones(); ?>
	</div>
</div>


<?php

	function saludo(){
		$user = $_SESSION['user'];
		//Para setear la zona desde la cual tomar la hora (GMT -3)
		date_default_timezone_set("America/Argentina/Mendoza");

		//Formato extendido ("j/m/y H:i")	<--'h' toma hora de 01 a 12/'H' de 00 a 23.
		$horaActual=date("H:i");							//Obtiene la hora actual.
		switch($horaActual)
			{
				case ($horaActual > "05:00" AND $horaActual < "13:00"):
					print("Buenos D&iacute;as ".$user."!!<br/>\n");
					break;
				case ($horaActual > "13:00" AND $horaActual < "20:00"):
					print("Buenas Tardes ".$user."!!<br/>\n");
					break;
				default: print("Buenas Noches ".$user."!!<br/>\n");
			}
	}

	function topReproducciones(){
		require_once "./classes/Conexion.php";
		$db = new Conexion();
		$userid = $db->getId("usuario", "username", $_SESSION["user"]);

		$resultado = array();
		$query = "SELECT `p`.`creador_id`, `p`.`foto`, `g`.`nombre` as `generonombre`, `p`.`reproducciones`,
							`p`.`nombre`, `p`.`estado`, `u`.`username`
							FROM `playlist` `p`
							INNER JOIN `usuario` `u`
							ON `p`.`creador_id` = `u`.`id`
							INNER JOIN `seguir` `s`
							ON `s`.`seguido_id` = `u`.`id`
							INNER JOIN `genero` `g`
							ON `g`.`id` = `p`.`genero_id`
							WHERE `p`.`estado` <> 'privada' AND `s`.`seguidor_id` = '$userid' AND `p`.`creador_id` <> '$userid'
							ORDER BY `p`.`fecha_creacion` DESC
							LIMIT 5";
		$sql = $db->query($query);

	  	while($fila = $sql->fetch_assoc())
	    	$resultado[] = $fila;

	   foreach($resultado as $playlist){
	    $nombreDeImagen = $playlist["foto"];
			$genero = $playlist["generonombre"];

	   	$playlistId = $db->getId("playlist", "nombre", $playlist["nombre"]);

			if( !($playlist["estado"] == "solo yo" && $userid != $playlist["creador_id"]) ){
				echo "<div class=\"col l4 m6 s12\">";
		    echo "<div class=\"card\">";
		    echo "<div class=\"card-image\">";
		    echo "<img src=/archivos/playlist_fotos/".$nombreDeImagen.">";
		    echo "<span class=\"card-title\"><strong><a href=\"http://localhost/playlist.php?id=$playlistId\">".$playlist["nombre"]."</a></strong></span>";
		    echo "</div>";
		    echo "<div class=\"card-content\">";
				echo "<p><strong>Usuario: </strong>".$playlist["username"]."</p>";
		    echo "<p><strong>Genero:</strong> $genero</p>";
		    echo "<p><strong>Reproducciones: </strong>".$playlist["reproducciones"]."</p>";
				echo "<p><strong>Estado: </strong>".$playlist["estado"]."</p>";
		    echo "</div>";
		    echo "</div>";
		    echo "</div>";
			}
	   }
	}

?>
