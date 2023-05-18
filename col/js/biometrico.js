/*==================================
=            BIOMETRICO            =
==================================*/


 toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-center",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};


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

$('#fechaIni').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});


$('#fechaFin').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#fechaIni').on('changeDate', function(ev)
{
    
    $(this).datepicker('hide');  
    $('#fechaFin').focus();     

});

$('#fechaFin').on('changeDate', function(ev)
{
    
    $(this).datepicker('hide');  	     

});


$(document).on('change', '#selTipo', function() 
{
	var fechaIni = $('#fechaIni').val();
	var fechaFin = $('#fechaFin').val();
	var selTipo  = $('#selTipo').val();

	if (selTipo == 1 || selTipo == 2 || selTipo == 3) 
	{
		listadoBiometrico();
	}
	else
	{
		if (selTipo == 4) 
		{
			listadoBiometricoAus();
		}
		else
		{
			if (selTipo == 5) 
			{
				listadoBiometricoPnp();
			}
			else
			{
				if (selTipo == 6) 
				{
					listadoBiometricoInc();
				}
				else
				{
					if (selTipo == "X") 
					{
						listadoBiometricoAll();
					}
				}
			}
		}
	}


		
	
});


var  listadoBiometrico = function() 
{ 
    var listado = $('#tblBiometrico').DataTable({
    	"searching": false,
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/biometrico/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val(), desde: $('#fechaIni').val(), hasta: $('#fechaFin').val(), tipo: $('#selTipo').val()}
         	},
         	"columns":[
	        	{"data": "aptnombre"},
	        	{"data": "desde"},
	        	{"data": "prgfecha"},
	        	{"data": "abmhora"},
	        	{"data": "dif"},
	        	{"data": "apcvalorizacion"},

          	],"language":{
	        	"lengthMenu": "",
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
             
        	"order": [[2, "desc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};


var  listadoBiometricoAus = function() 
{ 
    var listado = $('#tblBiometrico').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/biometrico/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val(), desde: $('#fechaIni').val(), hasta: $('#fechaFin').val(), tipo: $('#selTipo').val()}
         	},
         	"columns":[
	        	{"data": "aptnombre"},
	        	{"data": "desde"},
	        	{"data": "prgfecha"},
	        	{"defaultContent": ""},
	        	{"defaultContent": ""},
	        	{"data": "apcvalorizacion"},

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
             
        	"order": [[2, "desc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};

var  listadoBiometricoPnp = function() 
{ 
    var listado = $('#tblBiometrico').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/biometrico/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val(), desde: $('#fechaIni').val(), hasta: $('#fechaFin').val(), tipo: $('#selTipo').val()}
         	},
         	"columns":[
	        	{"data": "aptnombre"},
	        	{"data": "desde"},
	        	{"data": "prgfecha"},
	        	{"data": "abmhora"},
	        	{"data": "dif"},
	        	{"data": "apcvalorizacion"},

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
             
        	"order": [[2, "desc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};


var  listadoBiometricoInc = function() 
{ 
    var listado = $('#tblBiometrico').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/biometrico/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val(), desde: $('#fechaIni').val(), hasta: $('#fechaFin').val(), tipo: $('#selTipo').val()}
         	},
         	"columns":[
	        	{"data": "aptnombre"},
	        	{"data": "desde"},
	        	{"data": "prgfecha"},
	        	{"defaultContent": ""},
	        	{"defaultContent": ""},
	        	{"data": "apcvalorizacion"},

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
             
        	"order": [[2, "desc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};


var listadoBiometricoAll = function() 
{ 
    var listado = $('#tblBiometrico').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/biometrico/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val(), desde: $('#fechaIni').val(), hasta: $('#fechaFin').val(), tipo: $('#selTipo').val()}
         	},
         	"columns":[
	        	{"data": "aptnombre"},
	        	{"data": "desde"},
	        	{"data": "prgfecha"},
	        	{"data": "abmhora"},
	        	{"data": "dif"},
	        	{"data": "apcvalorizacion"},

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
             
        	"order": [[2, "desc"]],
         	"bDestroy": true,
         	"columnDefs": [
            	{ className: "idnovedad", "targets": [ 0 ] },
            	{ className: "fecha", "targets": [ 3 ] }
          ]
  });
};

/*=====  End of BIOMETRICO  ======*/
