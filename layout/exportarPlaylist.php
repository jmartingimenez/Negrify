<?php

	if(isset($_POST['exportar'])){

		//Creando un objeto Playlist y guardando las canciones en un array
		$miPlaylist = new playlist($nombrePlaylist,$id,$data['genero_id'],$data['estado'],$data['foto']);
		$arrayCanciones = $miPlaylist->getCanciones();

		//Creando  y escribiendo el XSPF (Se guarda temporalmente en la carpeta raiz -ver esto luego-)
		$archivoCreado = "archivos/".$nombrePlaylist.".xspf";
		$fp = fopen($archivoCreado, "w");

		$headerXSPF = 	'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
						'<playlist version="1" xmlns="http://xspf.org/ns/0/">'.PHP_EOL.
						'<trackList>'.PHP_EOL;

		fwrite($fp, $headerXSPF);

		foreach($arrayCanciones as $cancion){
		fwrite($fp,		'<track>'.PHP_EOL.
					 		'<title>'. $cancion->getNombre() .'</title>'.PHP_EOL.
							'<creator>'. $cancion->getArtista() .'</creator>'.PHP_EOL.
						'</track>'.PHP_EOL);
		}

		$footerXSPF = '</trackList>'.PHP_EOL.'</playlist>';
		fwrite($fp, $footerXSPF);	
		fclose($fp);

		//Generando el prompt para guardar y eliminando el archivo al final
		if(file_exists($archivoCreado)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.$nombrePlaylist.'.xspf"');
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($archivoCreado));
		    ob_clean();
		    flush();
		    readfile($archivoCreado);
		    unlink($archivoCreado);								//Se borra el archivo del server	
		}
	}	

?>