<?php
	require_once "./classes/Conexion.php";
	$db = new Conexion();

	$tabla = $_SESSION['denuncia'];
	$tablaSQL = "reportes_".strtolower($tabla);

	if(!ctype_alpha($tabla))
		die("Buscas algo?");

  switch($tablaSQL){
              case 'reportes_usuario':  $query="SELECT U.id AS 'ID', U.username AS 'Nombre',
                                                  RU.confirmacion AS 'Confirmacion'
                                                FROM reportes_usuario AS RU
                                                  JOIN usuario AS U ON U.id=RU.usuario_denunciado
                                                GROUP BY RU.usuario_denunciado DESC
                                                ORDER BY RU.id DESC";
                                            $link="/profile.php?id=";
                                            break;
              case 'reportes_playlist': $query="SELECT P.id AS 'ID',P.nombre AS 'Nombre',
                                                  RP.confirmacion AS 'Confirmacion'
                                                FROM reportes_playlist AS RP
                                                  JOIN playlist AS P ON P.id=RP.playlist_id
                                                GROUP BY RP.playlist_id
                                                ORDER BY RP.id DESC";
                                        $link='/playlist.php?id=';
                                        break;
              default: die("Buscas algo?");
            }



  $sql = $db->query($query);

  $dataTable = array("ID","Nombre","Confirmacion");

  if(!$sql->num_rows){
    header("location: /index.php");
  }


?>


<div class="container">
<h5 class="center-align">Denuncias</h5>
<div id="contenedorAcordeon">
<ul class="collapsible" data-collapsible="accordion">


<!-- ==================TODO ESTO ESTA DENTRO DE LAS DENUNCIAS PENDIENTES=================== -->


<li>
<div class="collapsible-header right-align blue darken-2 white-text">
<i class="material-icons">keyboard_arrow_down</i>Denuncias pendientes de revisi&oacute;n
<i class="material-icons right">content_cut</i>
</div>
<div class="collapsible-body">
  <span class="center-align">Haga click en una denuncia para realizar una acci&oacute;n</span>
    <div>
      <button id="eliminarDenunciaPendiente" class="blue darken-2 waves-effect waves-light btn">Confirmar</button>
      <button id="deshecharDenunciaPendiente" class="red lighten-2 waves-effect waves-light btn">Desechar</button>
      <table id="denunciasPendientes" class="striped centered">
        <thead class="blue lighten-3 white-text">
          <tr>
              <th data-field="colID">ID <?php  print($tabla); ?></th>
              <th id="tablaSQL" data-field="colNombre"><?php  print($tabla); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
            while($fila=$sql->fetch_assoc()){
              $id = $fila['ID'];
              $nombre = $fila['Nombre'];
              if($fila['Confirmacion']==0)  mostrarDenuncias($id,$nombre,$link,$tablaSQL);
            }
          ?>
        </tbody>
      </table>
    </div>
</li>

<?php $sql->data_seek(0);   //Para mostrar los resultados abajo ?>


<!--===================TODO LO DE ABAJO ESTA DENTRO DEL HISTORIAL DE DENUNCIAS=============== -->
<li>
<div class="collapsible-header right-align blue darken-2 white-text">
<i class="material-icons">keyboard_arrow_down</i>Historial de denuncias
<i class="material-icons right">autorenew</i>
</div>
<div class="collapsible-body">
  <span class="center-align">Haga click en una denuncia para reveerla</span>
    <div>
      <button id="eliminarDenunciaHistorial" class="blue darken-2 waves-effect waves-light btn">Reveer</button>
      <table id="denunciasHistorial" class="striped centered">
        <thead class="blue lighten-3 white-text">
          <tr>
              <th data-field="colID">ID <?php  print($tabla); ?></th>
              <th id="tablaSQL" data-field="colNombre"><?php  print($tabla); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
            while($fila=$sql->fetch_assoc()){
              $id = $fila['ID'];
              $nombre = $fila['Nombre'];
              if($fila['Confirmacion']==1)  mostrarDenuncias($id,$nombre,$link,$tablaSQL);
            }
          ?>
        </tbody>
      </table>
    </div>
</li>
<!--===================TODO LO DE ARRIBA ESTA DENTRO DEL HISTORIAL DE DENUNCIAS=============== -->
</ul>
</div>




<!-- =========================Funcion para ir mostrando las denuncias========================== -->
<?php

function mostrarDenuncias($id,$nombre,$link,$tablaSQL){
  print('<tr>');
  if($tablaSQL=='reportes_usuario')
  print('<td>' . '<a href="'.$link.$nombre.'"><b>'.$id.'</b></a>' . '</td>');
  else print('<td>' . '<a href="'.$link.$id.'"><b>'.$id.'</b></a>' . '</td>');
  print('<td>' . $nombre . '</td>');
  print("</tr>");
}

?>


<div class="center-align">
  <button id="actualizarDenuncias" class="blue darken-2 waves-effect waves-light btn"
    onclick=window.location.reload();>Actualizar</button>
</div>
