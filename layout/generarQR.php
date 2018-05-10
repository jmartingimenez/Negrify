<?php

	//Capturando la URL para luego ponerla en el QR
	$url 				= 			"http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	$escaped_url 		= 			htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

/* --------------- Generacion del QR ------------- */

	//Donde se aloja el QR
	$tempDir 			= 			'archivos/playlist_QR/';

	//Generando el QR
	QRcode::PNG($escaped_url,$tempDir.'ultimoQRGenerado.png',QR_ECLEVEL_H,5);

	//Mostrando el QR
	print('<img src="'.$tempDir.'ultimoQRGenerado.png"/>');

?>
