<?php

	session_start();
	if(!isset($_SESSION['admin'])						OR
		!isset($_SESSION['usuariosBaneadosURI']) 		OR
		!isset($_SESSION['usuariosPorPaisURI']) 		OR
		!isset($_SESSION['playlistCreadasURI']) 		OR
		!isset($_SESSION['rankingReproduccionesURI']) 	OR
		!isset($_SESSION['rankingVotosURI']))
	  		header('Location: http://localhost');




	$usuariosBaneadosIMG			=			$_SESSION['usuariosBaneadosURI'];
	$usuariosPorPaisIMG				=			$_SESSION['usuariosPorPaisURI'];
	$playlistCreadasIMG				=			$_SESSION['playlistCreadasURI'];
	$rankingReproduccionesIMG		=			$_SESSION['rankingReproduccionesURI'];
	$rankingVotosIMG				=			$_SESSION['rankingVotosURI'];

	require_once 'lib/fpdf/fpdf.php';

	$pdf = new FPDF('P','mm','A4');

	$pdf->AddPage();

	$pdf->SetFont('Arial','U','16');

	$pdf->Cell(70);
	$pdf->Cell(20,10,'Negrify - Estadisticas',0,'C');

	$pdf->image($usuariosBaneadosIMG					.'.png',0,20,120);
	$pdf->image($usuariosPorPaisIMG						.'.png',100,20,120);
	$pdf->image($playlistCreadasIMG						.'.png',40,100,120);
	$pdf->image($rankingReproduccionesIMG				.'.png',0,180,100);
	$pdf->image($rankingVotosIMG						.'.png',100,180,100);


	$pdf->Output();

?>
