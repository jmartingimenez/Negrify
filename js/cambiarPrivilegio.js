$(document).ready(function(){

/*FUNCIONES PARA CAPTURAR LOS CLICKS*/

	$("#botonBusqueda").click(function(){
		ingreso = $("#buscarUser").val();
		var filter = /^[A-Za-z0-9]+$/;
		if(!filter.test(ingreso) || ingreso=="")
			alert("Escriba el nombre del usuario. Solo se admiten letras y n\u00FAmeros.");
		else ajaxObtenerDatosUsuario(ingreso);
	});

	$("#botonPrivilegio").click(function(){
		contenidoDiv = $.trim($("#respuestaBusqueda").html());
		if(contenidoDiv == "")
			alert("Busque un usuario primero.");
		else if(contenidoDiv == "Usuario no encontrado.")
			alert("No se encontro el usuario. Busque de nuevo.");
		else ajaxModificarPrivilegio(ingreso);		
	});	

/*FUNCION PARA BUSCAR LOS DATOS DEL USUARIO*/

	function ajaxObtenerDatosUsuario(ingreso){
		$.ajax({
			type: 'GET',
			url: '../datalayer/busquedaUsuarioAdmin.php',
			dataType: 'text',
			data: "search="+ingreso,
			success: function(response){
				if(response=="Usuario no encontrado."){
					document.getElementById("respuestaBusqueda").innerHTML="Usuario no encontrado.";
				}
				else{
					var arrayDevuelto = $.parseJSON(response);
					nombreUsuario = arrayDevuelto[1][0];
					rangoUsuario = arrayDevuelto[1][1];	
					document.getElementById("respuestaBusqueda").innerHTML="<strong>Usuario:</strong><br/>"+
																			nombreUsuario + "<br/>"+
																		"<strong>Rango:</strong><br/>"+
																			rangoUsuario + "<br/>" +
								'<a href="profile.php?id='+nombreUsuario+'"><strong>Ver perfil</strong></a>';
				}						 
			},
			error: msjError
		})
	}
});

/*FUNCION PARA CAMBIAR EL PRIVILEGIO DEL USUARIO SELECCIONADO*/

function ajaxModificarPrivilegio(ingreso){	
	var filter = /^[A-Za-z0-9]+$/;
	if(!filter.test(ingreso) || ingreso=="")
		alert("Escriba el nombre del usuario. Solo se admiten letras y n\u00FAmeros.");
	else{
		$.ajax({
			type: 'GET',
			url: "../datalayer/cambiarPrivilegio.php",
			dataType: "text",
			data: "modify="+ingreso,
			success: function(response){
				document.getElementById("respuestaBusqueda").innerHTML="";
				document.getElementById("mensaje").innerHTML="Nuevo nivel de '" + ingreso + "':<strong> " + 
																	response + "</strong>";
				$("#buscarUser").val("");
			},
			error: msjError
		});	
	}		
}

/*FUNCION PARA DAR CODIGOS DE ERROR EN LAS LLAMADAS A AJAX*/

function msjError(xhr, ajaxOptions, thrownError){
	console.log(xhr);
}