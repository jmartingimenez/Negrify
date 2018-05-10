<?php
//header('Content-type: application/json');
require_once "classes/Playlist.php";
$data = Playlist::getEstadoPorId(2);
var_dump($data);
?>
