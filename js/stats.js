$(function(){
	google.charts.load('current',{'packages':['corechart','table']});
	google.charts.setOnLoadCallback(loadData);
});

//Esta funcion envia el nombre del grafico basado en el nombre del archivo (sin el get y sin la extension)
function loadData(){
	ajaxCall("UsuariosBaneados");
	ajaxCall("UsuariosPorPais");
	ajaxCall("PlaylistCreadas");
	ajaxCall("RankingReproducciones");
	ajaxCall("RankingVotos");
}

/*------------------------------------------------------------------------------------------\
/Esta funcion llama a un archivo diferente segun el paramentro que recibe de arriba.      	\
/En el success se llama a la funcion de dibujo dandole cuatro parametros: 					\
/-El primero es el JSON 																  	\
/-El segundo es el nombre del grafico (para el nombre del archivo) que viene de 'ajaxCall' 	\
/-El tercero es el tipo de grafico (pieChart=Torta, LineChart=Linea, ColumnChart=Columna)   \
/-El cuarto es el titulo que estara por encima del grafico 									\ 				
-------------------------------------------------------------------------------------------*/
function ajaxCall(nombreGrafico){
	var dirArchivo 		= 		'../datalayer/get'+nombreGrafico+'.php';
	$.ajax({
		url: dirArchivo,
		dataType: "JSON",
		success: function(response){
			switch(nombreGrafico){
				case 'UsuariosBaneados'		: 	tituloGrafico = "Estado de usuarios";
												dibujarGrafico(response,nombreGrafico,'PieChart',tituloGrafico);
												break;
				case 'UsuariosPorPais'		: 	tituloGrafico = "Usuarios por pa\u00eds";
												dibujarGrafico(response,nombreGrafico,'PieChart',tituloGrafico);
												break;
				case 'PlaylistCreadas'		: 	tituloGrafico = "Playlist Creadas";
												dibujarGrafico(response,nombreGrafico,'LineChart',tituloGrafico);
												break;
				case 'RankingReproducciones':	tituloGrafico = "Top 10 - Playlist reproducidas";
												dibujarGrafico(response,nombreGrafico,'ColumnChart',tituloGrafico);
												break;
				case 'RankingVotos'			: 	tituloGrafico = "Top 10 - Canciones votadas";
												dibujarGrafico(response,nombreGrafico,'ColumnChart',tituloGrafico);
												break;
				//Cambiar este default luego por algo que no sea un alert											
				default 					:	alert("Error: Revisar stats.js -VAR nombreGrafico-");				
			}
		},		
		error: msjError
	});
}


function dibujarGrafico(jsonData,nombreGrafico,tipoGrafico,tituloGrafico){
	
	/*----------------------------------------------------------------------------------------------\
	/Aclaracion sobre la linea siguiente: 															\
	/Suelo escribir en camelCase, si notan arriba, en la funcion 'ajaxCall', estoy pasando los 		\
	/parametros ya con la primer letra en mayuscula. Esto es por que cuando concatene, esa 			\
	/string sera la segunda palabra (ej: paso 'UsuariosBaneados', al concatenar con todo quedara 	\
	/'getUsuariosBaneados.php') 																	\
	/Como en los divs ocultos del form de stats.php que sirven para generar el PDF, mantengo el 	\
	/camelCase, el div correspondiente se llama 'usuariosBaneados'. Estoy haciendo minuscula la 	\
	/primer letra, para que pueda hallar ese div y escribir la URI 									\	
	/																								\
	/Linea: 'grafico_div.innerHTML = '<img src="'+grafico_chart.getImageURI()+'">';' 				\
	-----------------------------------------------------------------------------------------------*/
	nombreGrafico			=		nombreGrafico.charAt(0).toLowerCase() + nombreGrafico.slice(1);


	var grafico 			= 		new google.visualization.arrayToDataTable(jsonData);
	var grafico_div 		= 		document.getElementById(nombreGrafico);
	
	//Intente primero concatenar 'tipoGrafico', pero me daba un error, por que buscaba un atributo
	//Asi que termine haciendo otro switch
	switch(tipoGrafico){
		case 'PieChart': 	grafico_chart = new google.visualization.PieChart(document.getElementById(nombreGrafico)); 
							break;
		case 'LineChart': 	grafico_chart = new google.visualization.LineChart(document.getElementById(nombreGrafico)); 
							break;
		case 'ColumnChart': grafico_chart = new google.visualization.ColumnChart(document.getElementById(nombreGrafico)); 
							break;														

	}

	google.visualization.events.addListener(grafico_div,'ready',function(){
		grafico_div.innerHTML = '<img src="'+grafico_chart.getImageURI()+'">';
	});

	grafico_chart.draw(grafico,{title: tituloGrafico,width:600,height:400});

	var tablaGrafico = new google.visualization.Table(document.getElementById(nombreGrafico+'Tabla'));
	tablaGrafico.draw(grafico,{showRowNumber:false,width:200});

	$('#'+nombreGrafico+'URI').val($('#'+nombreGrafico+'URI').val() + grafico_chart.getImageURI());
}


/*===========================Funcion que muestra un codigo de error en la llamada a ajax=======================*/

function msjError(xhr, ajaxOptions, thrownError){
	console.log(xhr);
}