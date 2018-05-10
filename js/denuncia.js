//Variable para guardar la fila que se clickeo (la ID)
denunciaClickeada = "";

$(document).ready(function() {

    /*Seteando la fila clickeada*/
    $('#denunciasPendientes tbody tr').click( function () {
    denunciaClickeada = $(this).find('td:first').text();
	} );

    /*Efectos para usar con dataTables*/
    var table = $('#denunciasPendientes').DataTable({"sPaginationType": "full_numbers"}); 
 
    $('#denunciasPendientes tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    
    /*Funciones para eliminar la fila en el Front-End*/
    $('#eliminarDenunciaPendiente').click( function () {
        table.row('.selected').remove().draw( false );
        var tabla 	= 	$("#tablaSQL").text().toLowerCase();
        ajaxEliminarDenuncia(tabla,denunciaClickeada);       
    } ); 

    $('#deshecharDenunciaPendiente').click( function () {
        table.row('.selected').remove().draw( false );
        var tabla 	= 	$("#tablaSQL").text().toLowerCase();
        ajaxDeshecharDenuncia(tabla,denunciaClickeada);       
    } ); 

	/*Funciones para eliminar las denuncias en la base de datos*/
	function ajaxEliminarDenuncia(tabla,denunciaClickeada){
		$.ajax({
			type: 'GET',
			url: '../datalayer/confirmarDenuncia.php',
			datatype: 'text',
			data: 'delete='+denunciaClickeada,
			error:msjError
		});
	}

	function ajaxDeshecharDenuncia(tabla,denunciaClickeada){
		$.ajax({
			type: 'GET',
			url: '../datalayer/deshecharDenuncia.php',
			datatype: 'text',
			data: 'discard='+denunciaClickeada,
			error:msjError
		});
	}

/*=======================================================================
FUNCIONES DEL HISTORIAL DE DENUNCIAS
=======================================================================*/

    $('#denunciasHistorial tbody tr').click( function () {
        denunciaClickeada = $(this).find('td:first').text();
    } );

    /*Efectos para usar con dataTables*/
    var table2 = $('#denunciasHistorial').DataTable({"sPaginationType": "full_numbers"}); 
 
    $('#denunciasHistorial tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    /*Funcion para eliminar la fila en el Front-End*/
    $('#eliminarDenunciaHistorial').click( function () {
        table2.row('.selected').remove().draw( false );
        var tabla   =   $("#tablaSQL").text().toLowerCase();
        ajaxReveerDenuncia(tabla,denunciaClickeada);       
    } ); 

    /*Funcion para dejar la denuncia sin confirmacion*/
    function ajaxReveerDenuncia(tabla,denunciaClickeada){
        $.ajax({
            type: 'GET',
            url: '../datalayer/reveerDenuncia.php',
            datatype: 'text',
            data: 'delete='+denunciaClickeada,
            error:msjError
        });
    }

} );

/*FUNCION PARA DAR CODIGOS DE ERROR EN LAS LLAMADAS A AJAX*/

function msjError(xhr, ajaxOptions, thrownError){
	console.log(xhr);
}