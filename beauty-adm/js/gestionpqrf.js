/*=======================================
=            GESTION DE PQRF            =
=======================================*/

$(document).ready(function() 
{
    tblPqrf();
});


var  tblPqrf  = function() { 
   var tbl_est = $('#tblPQRF').DataTable({
      "ajax": 
      {
      	"method": "POST",
      	"url": "pqrf/process.php",
      	"data" : {opcion : "listado"}
      },
      "columns":[
        {"data": "pgrfcodigo"},
        {"data": "pqrftipo"},
        {"data": "pqrffecha"},
        {"data": "pqrfhora"},
        {"data": "slnnombre"},
        {"data": "pgrfnombre_contacto"},
        {"data": "pgrfestado",
        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
        	{
                  switch (oData.pgrfestado) 
                  {
                  	case 'RADICADO':
                  		$(nTd).html('<center><i class="fa fa-minus-circle" style="color:red" title="'+oData.pgrfestado+'"></i></center>');
                  		break;

                  	case 'ATENDIDO':
                  		$(nTd).html('<center><i class="fa fa-check" style="color:lime" title="'+oData.pgrfestado+'"></i></center>');
                  		break;
                  	default:
                  		// statements_def
                  		break;
                  }                                    
        	}
        },
        {"defaultContent": "<center><button type='button' id='btnVerDescr' data-toggle='modal' data-target='#modalDetalles' title='Click para ver los detalles' class='btn btn-link text-primary'><i class='fa fa-search'></i></button></center>"},
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
         "columnDefs":[
              {className:"idpqrf","targets":[0]}
            ], 
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};


 $('#tblPQRF tbody').on('click', '#btnVerDescr', function() 
 {
      var $row = $(this).closest("tr");    // Find the row
      var $id = $row.find(".idpqrf").text(); // Find the text
      var cod = $id;
      $.ajax({
        	url: 'pqrf/process.php',
        	method: 'POST',
        	data: {cod: cod, opcion: "detalles"},
        	success: function (data) 
        	{
        		var jsonDetalle = JSON.parse(data);
        		var estado = '';
        		if (jsonDetalle.res == "full") 
        		{
        			$('#listGroup').empty();
        			$('#listGroupRes').empty();

        			for(var i in jsonDetalle.json)
        			{
        				switch (jsonDetalle.json[i].estado) 
        				{
        					case 'RADICADO':

        						$('#txtRespuesta').css("display", "none");
        						$('#txtRespuestaUsu').css('display', 'block');
        						$('#codPqrf').val(jsonDetalle.json[i].id);
        						$('#listGroup').append('<button type="button" class="list-group-item active">Tipo <span class="pull-right">'+jsonDetalle.json[i].tipo+'</span></button><button type="button" class="list-group-item">Cliente <span class="pull-right">'+jsonDetalle.json[i].nombre+'</span></button><button type="button" class="list-group-item">Salón <span class="pull-right">'+jsonDetalle.json[i].salon+'</span></button><button type="button" class="list-group-item">Móvil <span class="pull-right">'+jsonDetalle.json[i].movil+'</span></button><button type="button" class="list-group-item">E-mail <span class="pull-right">'+jsonDetalle.json[i].email+' </span></button>');
        						$('#txtPqrf').val(jsonDetalle.json[i].desc);
        						$('#fechaPQRF').html("PQRF N° " + jsonDetalle.json[i].id + " <span class='pull-right'>Fecha: " + jsonDetalle.json[i].fecha + " | Hora: "+ jsonDetalle.json[i].hora + "</span>");
        						$('#btnResponder').attr("disabled",false);
        						$('#listGroupRes').css("display", "none");

        						break;

        					case 'ATENDIDO':

        						$('#listGroupRes').css('display', 'block');
        						$('#txtRespuesta').css("display", "block");

        						$('#codPqrf').val(jsonDetalle.json[i].id);

        						$('#listGroup').append('<button type="button" class="list-group-item active">Tipo <span class="pull-right">'+jsonDetalle.json[i].tipo+'</span></button><button type="button" class="list-group-item">Cliente <span class="pull-right">'+jsonDetalle.json[i].nombre+'</span></button><button type="button" class="list-group-item">Salón <span class="pull-right">'+jsonDetalle.json[i].salon+'</span></button><button type="button" class="list-group-item">Móvil <span class="pull-right">'+jsonDetalle.json[i].movil+'</span></button><button type="button" class="list-group-item">E-mail <span class="pull-right">'+jsonDetalle.json[i].email+' </span></button>');

        						$('#listGroupRes').append('<button type="button" class="list-group-item active">Usuario Respuesta <span class="pull-right">'+jsonDetalle.json[i].usuario+'</span></button><button type="button" class="list-group-item">Fecha Respuesta <span class="pull-right">'+jsonDetalle.json[i].fechares+'</span></button><button type="button" class="list-group-item">Hora Respuesta <span class="pull-right">'+jsonDetalle.json[i].horares+'</span></button>');


        						$('#txtPqrf').val(jsonDetalle.json[i].desc);

        						$('#fechaPQRF').html("PQRF N° " + jsonDetalle.json[i].id + " <span class='pull-right'>Fecha: " + jsonDetalle.json[i].fecha + " | Hora: "+ jsonDetalle.json[i].hora + "</span>");

        						$('#txtRespuesta').val(jsonDetalle.json[i].respuesta).attr("disabled", true);
        						$('#txtRespuestaUsu').css("display", "none");
        						$('#btnResponder').attr("disabled",true);

        						break;
        					default:
        						// statements_def
        						break;
        				}
        				
        			}
        		}
        	}
      });
 });


$(document).on('click', '#btnResponder', function() 
{
	var cod = $('#codPqrf').val();
	var res = $('#txtRespuestaUsu').val();

	if (res == "") 
	{
		swal("Debe ingresar una respuesta.", "", "warning");
	}
	else
	{
		$.ajax({
			url: 'pqrf/process.php',
			method: 'POST',
			data: {opcion: "guardarRes", cod:cod, res:res},
			success: function (data) 
			{
				if (data == 1) 
				{
					swal("Se ha dado respuesta al PQRF \n N° " + cod, "", "success");
					$('#txtRespuestaUsu').val('');
					$('#modalDetalles').modal("hide");
					tblPqrf();
				}
			}
		});
	}
});

/*=====  End of GESTION DE PQRF  ======*/
