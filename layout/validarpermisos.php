<?php
session_start();
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
if(isset($_SESSION['ban'])){
  header('location:baneado.php');
  //exit();
}

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
	header("Location:http://localhost");
}
?>
