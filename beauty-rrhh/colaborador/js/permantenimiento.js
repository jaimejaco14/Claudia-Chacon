/*================================================
=            PERSONA DE MANTENIMIENTO            =
================================================*/

$(document).ready(function() {
	tblPersonasMantenimiento();
});


var  tblPersonasMantenimiento  = function() { 
   var tbl = $('#tblPerMantenimiento').DataTable({
    "ajax": {
      "method": "POST",
      "url": "../php/mantenimiento/processMantenimiento.php",
      "data": {opcion: "permantenimiento"}
      },
      "columns":[
        {"data": "prmcodigo"},
        {"data": "trcdocumento"},
        {"data": "trcrazonsocial"},
        {"data": "trcdireccion"},
        {"data": "trctelefonofijo"},
        {"data": "trctelefonomovil"},
        {"data": "prm_email"},
        {"data": "prmfecha_nacimiento"},
        {"data": "prmestado",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                switch (sData) 
                {
                    case "1":
                        $(nTd).html('<center><span id="btnActivar" style="cursor: pointer;"><i class="fa fa-check" style="color:#30f925" title="Usuario Activo"></i></span></center>');
                        break;

                    case "0":
                        $(nTd).html('<center><span id="btnActivar" style="cursor: pointer;"><i class="fa fa-minus-circle" style="color: #f8312a" title="Usuario Inactivo"></i></span></center>');
                        break;
              
                    default:
                        
                        break;
                }
            }
                
        },
        {"defaultContent": "<button type='button' id='btnEditar' style='margin-left: 8px' title='Click para modificar' class='btn btn-link text-info'><i class='fa fa-edit'></i></button>"},
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
              {className:"idpermiso","targets":[0]}
            ], 
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};




 $('#tblPerMantenimiento tbody').on('click', '#btnEditar', function() 
 {
     $('#modalEditar').modal("show");
     var $row = $(this).closest("tr");    // Find the row
     var $id = $row.find(".sorting_1").text(); // Find the text
     var cod = $id;

      $.ajax({
          url: '../php/mantenimiento/processMantenimiento.php',
          method: 'POST',
          data: {prmcodigo: cod, opcion: "cargarUsuarioEdicion"},
          success: function (data) 
          {              
              var jsonUsuario = JSON.parse(data);

              if (jsonUsuario.res == 'full') 
              {
              	for(var i in jsonUsuario.json)
              	{
              		$('#nombres').val(jsonUsuario.json[i].trcnombres);
              		$('#direccion').val(jsonUsuario.json[i].trcdireccion);
              		$('#movil').val(jsonUsuario.json[i].trctelefonomovil);
              		$('#fecha').val(jsonUsuario.json[i].prmfecha_nacimiento);
              		$('#apellidos').val(jsonUsuario.json[i].trcapellidos);
              		$('#email').val(jsonUsuario.json[i].prm_email);
              		$('#fijo').val(jsonUsuario.json[i].trctelefonofijo);
              		$('#codigo').val(jsonUsuario.json[i].prmcodigo);
              	}
              }
          }
      });
});




/**
 *
 * ANULAR USUARIO
 *
 */


$('#tblPerMantenimiento tbody').on('click', '#btnDelete', function() 
{
           var $row = $(this).closest("tr");    // Find the row
           var $id = $row.find(".sorting_1").text(); // Find the text
           var cod = $id;

           swal({
          title: "¿Desea eliminar usuario?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
            $.ajax({
                url: '../php/mantenimiento/processMantenimiento.php',
                method: 'POST',
                data: {codigo:cod, opcion: "eliminar"},
                success: function (data) {
                    if (data == 1) {
                        swal("Eliminado!", "Se ha eliminado el usuario.", "success");
                        tblPersonasMantenimiento();
                    }
                }
            });
          }else{
            swal("Cancelado");
          } 
        });         

});



$('#tblPerMantenimiento tbody').on('click', '#btnActivar', function() 
{
           var $row = $(this).closest("tr");    // Find the row
           var $id = $row.find(".sorting_1").text(); // Find the text
           var cod = $id;  

           swal({
	          title: "¿Desea cambiar el estado al usuario?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Cambiar",
	          cancelButtonText: "Cancelar",
	          closeOnConfirm: false,
	          closeOnCancel: false
        },
        function(isConfirm)
        {
          	if (isConfirm) {
	            $.ajax({
	                	url: '../php/mantenimiento/processMantenimiento.php',
	                	method: 'POST',
	                	data: {codigo:cod, opcion: "activar_des"},
	                	success: function (data) 
	                	{	                    
	                    	if (data == 1) 
	                    	{
	                        	swal("Activado!", "Se ha activado el usuario.", "success");
	                        	tblPersonasMantenimiento();
	                    	}
	                    	else 
	                    	{
	                    		swal("Desactivado!", "Se ha desactivado el usuario.", "success");
	                        	tblPersonasMantenimiento();
	                    	}
	                }
	            });
          	}
          	else
          	{
            	swal("Cancelado");
          	} 
        });         

});







var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = {
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
    setDate: "today",
    language: 'es',
});

$('#fecha').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});



$(document).on('click', '#btnGuardarCambios', function() 
{
	var nombre  	= $('#nombres').val();
	var direccion  	= $('#direccion').val();
	var movil  		= $('#movil').val();
	var fecha  		= $('#fecha').val();
	var apellido  	= $('#apellidos').val();
	var email  		= $('#email').val();
	var fijo  		= $('#fijo').val();
	var codigo  	= $('#codigo').val();


	if (nombre == '') 
	{
		swal('Debe ingresar los nombres', 'Advertencia', 'error');
	}
	else if (direccion == '') 
	{
		swal('Debe ingresar la dirección', 'Advertencia', 'error');
	}
	else if (email == '') 
	{
		swal('Debe ingresar el e-mail', 'Advertencia', 'error');
	}
	else if (movil == '') 
	{
		swal('Debe ingresar el número de móvil', 'Advertencia', 'error');
	}
	else if (apellido == '') 
	{
		swal('Debe ingresar los apellidos', 'Advertencia', 'error');
	}
	else if (fecha == '') 
	{
		swal('Debe ingresar la fecha de nacimiento', 'Advertencia', 'error');
	}
	else
	{
		$.ajax({
			url: '../php/mantenimiento/processMantenimiento.php',
			method: 'POST',
			data: {opcion: "guardarCambios", nombre:nombre, apellido:apellido, direccion:direccion, fijo:fijo, movil:movil, email:email, codigo:codigo, fecha:fecha},
			success: function (data) 
			{
				if (data == 1) 
				{
					swal('Usuario modificado correctamente', '¡Exitoso!', 'success');
					tblPersonasMantenimiento();
					$('#modalEditar').modal("hide");
				}
			}
		});
	}
});

$(document).ready(function() 
{
	$('#modalNuevoUsuario').on('shown.bs.modal', function () 
	{
  		$('#newTipoDoc').focus();
	});
});


$(document).on('click', '#btnNuevoUsuario', function() 
{
	$('#modalNuevoUsuario').modal('show');

});


/***********************************/

/*    Nuevo Usuario                 */

/***********************************/


$(document).on('blur', '#newDocumento', function() 
{
	var doc = $('#newDocumento').val();

	$.ajax({
		url: '../php/mantenimiento/processMantenimiento.php',
		method: 'POST',
		data: {opcion: "validarDoc", documento: doc},
		success: function (data) 
		{
			var jsonMan = JSON.parse(data);

			if (jsonMan.res == 'full') 
			{
				for(var i in jsonMan.json)
				{
					$('#newNombres').val(jsonMan.json[i].trcnombres).attr('disabled', true);
					$('#trcdireccion').val(jsonMan.json[i].trcdireccion).attr('disabled', true);
					$('#newApellidos').val(jsonMan.json[i].trcapellidos).attr('disabled', true);
					$('#newTipoDoc').attr('disabled', true);
					$('#newDocumento').attr('disabled', true);
				}
			}
		}
	});
});



$(document).on('click', '#btnGuardarNewUsuario', function(event) 
{
    var tdicodigo = $('#newTipoDoc').val();
    var documento = $('#newDocumento').val();
    var nombres   = $('#newNombres').val();
    var apellidos = $('#newApellidos').val();
    var direccion = $('#newDireccion').val();
    var movil     = $('#newMovil').val();
    var fijo      = $('#newFijo').val();
    var email     = $('#newEmail').val();
    var fecha     = $('#newFecha').val();

    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (documento == '') 
    {
        swal("Ingrese el documento de identidad", "Advertencia", "warning");
    }
    else if (nombres == '') 
    {
        swal("Ingrese el nombre", "Advertencia", "warning");
    }
    else if (apellidos == '')
    {
        swal("Ingrese el apellido", "Advertencia", "warning");
    }
    else if (direccion == '')
    {
        swal("Ingrese la dirección", "Advertencia", "warning");
    }
    else if (movil == '')
    {
        swal("Ingrese el móvil", "Advertencia", "warning");
    }
    else if (email == '')
    {
        swal("Ingrese el e-mail", "Advertencia", "warning");
    }
    else if (!regex.test($('#newEmail').val().trim()))
    {
        swal("Ingrese un e-mail válido", "Advertencia", "warning");
    }
    else if (fecha == '')
    {
        swal("Ingrese la fecha de nacimiento", "Advertencia", "warning");
    }
    else
    {
        $.ajax({
            url: '../php/auth/loads2.php',
            method: 'POST',
            data: {opcion: "nuevaPersona", tdicodigo:tdicodigo, documento:documento, nombres:nombres, apellidos:apellidos, direccion:direccion, movil:movil, fijo:fijo, email:email, fecha:fecha},
            success: function (data) 
            {
                var jsonDoc = JSON.parse(data);

                if (jsonDoc.res == "fullname") 
                {
                	   tblPersonasMantenimiento();
                    for(var j in jsonDoc.json)
                    {
                        $('#modalNuevoUsuario').modal('hide');
                       // $('#modalNuevaAut').modal('show');                       
                    }                   
                }
               

            }
        });
    }



});

$('#newFecha').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#newFecha').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});



/*=====  End of PERSONA DE MANTENIMIENTO  ======*/
