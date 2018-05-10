<?php
if(isset($_SESSION['user'])){
  include_once 'indexLogeado.php';
}
else{
  include_once 'indexVisitante.php';
}
 ?>
