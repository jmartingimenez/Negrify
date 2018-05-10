<?php
	if(isset($_POST['enviar'])){

		//Definiendo el directorio donde se subira el archivo
		$target_dir = "archivos/";
		$target_file = $target_dir . basename($_FILES["importar"]["name"]);
		$uploadOk = 1;
		$extension = pathinfo($target_file,PATHINFO_EXTENSION);

		//Comprobando que el archivo subido sea .xspf
		if($extension!="xspf")
			die("Solo se admiten archivos .xspf");

		//Comprobando si el archivo existe
		if (file_exists($target_file)) {
		    echo "El archivo ya existe.";
		    $uploadOk = 0;
		}

		//Comprobando que no exista error en la subida
		if ($uploadOk == 0)
		    echo "El archivo no pudo subirse";

		//Si no hubo problema, se intenta subir el archivo
		else {
		    if (move_uploaded_file($_FILES["importar"]["tmp_name"], "archivoSubido.xspf")) {
		        echo "<p>La playlist ". basename( $_FILES["importar"]["name"]). " se subio exitosamente.<p/>\n";

				$xml=simplexml_load_file("archivoSubido.xspf") or die("Error: Cannot create object");

				print(	'<div class="container">
							<div class="row">
								<table class="bordered striped centered center-align col s12">
									<thead class="blue white-text">
										<th data-field="Cancion">Canci&oacute;n</th>
										<th data-field="Artista">Artista</th>
									</thead>
									<tbody>'."\n");

				foreach($xml->trackList->track as $cancion){
					print(				'<tr>'."\n"											.
											'<td>'.$cancion->title.'</td>'."\n"				.
											'<td>'.$cancion->creator.'</td>'."\n"			.
										'</tr>'."\n");
				}

				print(				'</tbody>
								</table>
							</div>
						 </div>');

				//Se elimina el archivo temporal
				unlink("archivoSubido.xspf");
			}
		}
	}
?>
