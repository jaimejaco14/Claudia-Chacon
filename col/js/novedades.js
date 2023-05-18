/*=================================
=            NOVEDADES            =
=================================*/

$(document).ready(function() {
	listadoNovedades();
	//conteoNovedades ();
});


/*function conteoNovedades () 
{
	$.ajax({
		url: 'php/novedades/process.php',
		method: 'POST',
		data: {opcion: "conteo"},
		success: function (data) 
		{
			$('#counNov').html('<b>NOVEDADES MES ACTUAL: '+data+'</b>');
		}
	});
}*/


var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = 
{
    days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    today: "Today",
    weekStart: 0
};

$('#fecha').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

/**
 *
 * CARGAR LISTADO NOVEDADES
 *
 */

 var  listadoNovedades = function() 
 { 
     var listado = $('#tblNovedades').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/novedades/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val()}
         	},
         	"columns":[
	        	{"data": "nvpcodigo"},
	        	{"data": "tnvnombre"},
	        	{"data": "nvpobservacion"},
	        	{"data": "nvpfecha"},
	        	{"data": "nvphoradesde"},
	        	{"data": "nvphorahasta"},
	        	{"data": "nvpestado"},

          	],"language":{
	        	"lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "No hay registros disponibles",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "Cargando...",
		        "processing":     "Procesando...",
		        "search": "Buscar: ",
		        "zeroRecords":    "No se encontraron registros coincidentes",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
	        	} 
        	},  
             
        	"order": [[2, "asc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};



 

$('#fecha').on('changeDate', function(ev)
{
    
    $(this).datepicker('hide');

        $.ajax({
            url: 'php/novedades/process.php',
            method: 'POST',
            data: {opcion: "searchApp", fecha: $('#fecha').val(), codColaborador: $('#codColaborador').val()},
            success: function (data) 
            {
            	var jsonNovedad = JSON.parse(data);
                $('#tblNovedades tbody').empty();
            	if (jsonNovedad.res == "full") 
            	{
            		for(var i in jsonNovedad.json)
            		{            			
                 		$('#tblNovedades tbody').append('<tr><td>'+jsonNovedad.json[i].id+'</td><td>'+jsonNovedad.json[i].tipo+'</td><td>'+jsonNovedad.json[i].obser+'</td><td style="text-transform: uppercase">'+jsonNovedad.json[i].fecha+'</td><td>'+jsonNovedad.json[i].desde+'</td><td>'+jsonNovedad.json[i].hasta+'</td><td>'+jsonNovedad.json[i].estado+'</td></tr>');
                 		$('#listCount').html("LA BÚSQUEDA ARROJÓ " + jsonNovedad.json[i].conteo + " RESULTADOS");
            		}
            	}
            	else
            	{
            		$('#tblNovedades tbody').append('<tr><td colspan="7"><center><b>NO HAY RESULTADOS PARA LA BÚSQUEDA</b></center></td></tr>');
                 		$('#listCount').html("LA BÚSQUEDA ARROJÓ 0 RESULTADOS");
            	}

            }
        });

});

$(document).on('click', '#btnUpdate', function() 
{
	listadoNovedades();
	//conteoNovedades ();
	$('#listCount').html("LISTADO");
	$('#fecha').val('');
});

/*=====  End of NOVEDADES  ======*/
