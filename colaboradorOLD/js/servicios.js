/*=================================
=            SERVICIOS            =
=================================*/

$(document).ready(function() {
    $("#buscarSer").select2();
    listadoServicios(); 
});


/**
 *
 * CARGAR LISTADO SERVICIOS
 *
 */

 var  listadoServicios = function() 
 { 
     var listado = $('#tblServicios').DataTable({
         	"ajax": 
         	{
           	"method": "POST",
           	"url": "php/servicios/process.php",
          	"data" : {opcion : "listado", codColaborador: $('#codColaborador').val()}
         	},
         	"columns":[
	        	{"data": "sercodigo"},
	        	{"data": "sernombre"},
	        	{"data": "serdescripcion"},
	        	{"data": "serduracion"},
	        	{"data": "crsnombre"},

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
            	{ className: "idservicio", "targets": [ 0 ] }
          ]
  });
};

$('#tbl_ventas tbody').on('click', '#btnVerFact', function() 
{
    var $row = $(this).closest("tr");    // Find the row
    var $id = $row.find(".idfactura").text(); // Find the text
    var cod = $id;

    $.ajax({
        url: 'php/ven/processData.php',
        method: 'POST',
        data: {opcion: "loadDetFact", idventa:cod},
        success: function (data) 
        {
            var jsonDetalles = JSON.parse(data);

            if (jsonDetalles.res == "full") 
            {
                $('#tblDetallesFac tbody').empty();
                for(var i in jsonDetalles.jsonDetalles)
                {
                    $('#tblDetallesFac').append('<tr><td>'+jsonDetalles.jsonDetalles[i].producto+'</td><td>'+jsonDetalles.jsonDetalles[i].precio+'</td><td>'+jsonDetalles.jsonDetalles[i].cantidad+'</td><td>'+jsonDetalles.jsonDetalles[i].subtotal+'</td></tr>');
                    $('.numFac').html(jsonDetalles.jsonDetalles[i].idventa);
                    $('.fechaFac').html(jsonDetalles.jsonDetalles[i].fecha);
                    $('.total').html(formatNumber.new(jsonDetalles.jsonDetalles[i].total, "$"));
                    $('#inpIdventa').val(jsonDetalles.jsonDetalles[i].idventa);
                    $('#txtProv').html(jsonDetalles.jsonDetalles[i].proveedor);
                }
            }      
        }
    });



});


/*=====  End of SERVICIOS  ======*/
