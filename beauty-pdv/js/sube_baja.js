
/*====================================================
=            Boton enviar al primer lugar            =
====================================================*/

$(document).on('click', '#btn_primer', function() {
    var pos_actual = $(this).data("lugar");
    var clbcodigo  = $(this).data("id_col");
    var cargo      = $(this).data("cargo");
    var codsalon   = $('#cod_salon').val();
    $.ajax({
    	url: 'php/sube_baja/mover_al_inicio.php',
    	method: 'POST',
    	data: {pos_actual:pos_actual, clbcodigo:clbcodigo, codsalon: codsalon},
    	success: function (data) {
    		console.log(data);
    		ListarCola();
    	}
    });
});


/*=====  End of Boton enviar al primer lugar  ======*/




/*========================================
=            Buscar Servicios            =
========================================*/


var  load_service  = function(cod) { 
   var tbl_est = $('#tblLista').DataTable({
      "ajax": {
      "method": "POST",
      "url": "php/sube_baja/lista_servicios.php",
      "data": {"cod": cod},
      },
      "columns":[
        {"data": "sernombre"},
        {"data": "serduracion"},
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
             
        "order": [[0, "asc"]],
         "bDestroy": true,
         "pageLength": 5
  });
};




$(document).on('click', '#btn_ver_servicios', function() {
     var cod_col  = $(this).data("id_col");
     var img      = $(this).data("img");
     var cargo_   = $(this).data("cargo");
     var nom_col  = $(this).data("nombrecol");

     load_service (cod_col);
     $.ajax({
     	url: 'php/sube_baja/mostrar_servicios.php',
     	method: 'POST',
     	data: {cod_col:cod_col, buscar:"no"},
     	success: function (data) 
     	{


     		var jsonServicios = JSON.parse(data);

            	var imagen   = 	"";
     			var cod      = 	"";
     			var nombre   = 	"";
     			var cargo    = 	"";
     		    	var servicio = 	"";
     		    	var duracion =    "";
     		
	     		$('#tbl_servicios tbody').empty();
	     		$('#nombreColaboradorServicio').empty();
	            $('#cargoColaboradorServicio').empty(); 


	            	if (jsonServicios.res == "full") 
     				{

     					for(var i in jsonServicios.json)
			            {

			            	

			                  

     					$('#listaData').empty();

		            	if(jsonServicios.json[i].img_servici == "default.jpg" || jsonServicios.json[i].img_servici == null )
		            	{
						imagen = "contenidos/imagenes/default.jpg";
					}
					else
					{
						imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios.json[i].img_servici+"";
					}

					$('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
		     			$('#imagenColaboradorServicio').attr('title', jsonServicios.json[i].nom_colabor);
		     			$('#txtCodigoColaborador').val(jsonServicios.json[i].cod_colabor);
		     			$('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios.json[i].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios.json[i].nom_colabor+'</button><button type="button" title="'+jsonServicios.json[i].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios.json[i].cargo_colab+'</button><button type="button" title="'+jsonServicios.json[i].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios.json[i].salon_base+'</button><button type="button" title="'+jsonServicios.json[i].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios.json[i].categoria+'</button></div>');

			            }
		     		}
		     		else
		     		{

		     			var jsonServicios2 = JSON.parse(data);

		     			for(var j in jsonServicios2.json)
			            {

			            	

			                  

     					$('#listaData').empty();

		            	if(jsonServicios2.json[j].img_servici == "default.jpg" || jsonServicios2.json[j].img_servici == null )
		            	{
						imagen = "contenidos/imagenes/default.jpg";
					}
					else
					{
						imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios2.json[j].img_servici+"";
					}

					$('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
		     			$('#imagenColaboradorServicio').attr('title', jsonServicios2.json[j].nom_colabor);
		     			$('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios2.json[j].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios2.json[j].nom_colabor+'</button><button type="button" title="'+jsonServicios2.json[j].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios2.json[j].cargo_colab+'</button><button type="button" title="'+jsonServicios2.json[j].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios2.json[j].salon_base+'</button><button type="button" title="'+jsonServicios2.json[j].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios2.json[j].categoria+'</button></div>');

			            }

		     		}

	            
     		   			
     		

      }
     	
    });

});


/*=====  End of Buscar Servicios  ======*/






/*=======================================================
=            Boton Mover al final Disponible            =
=======================================================*/

$(document).on('click', '#btn_check', function(){
 		var codigo = $(this).data("cod");
		var salon  = $('#cod_salon').val();
		
		//console.log('Codigo colaborador '+codigo + " Salon "+ salon);		

		$.ajax({
			url: 'php/sube_baja/colaSubeBaja.php',
			method: 'POST',
			data: {clbcodigo: codigo, slncodigo: salon},
			beforeSend: function() 
			{
				$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' }); 
			},
			success: function (data) 
			{
			 	ListarCola();
			 	//$('#tbl_crear_subeybaja tbody .fila_col'+codigo+'').find('button').addClass('disabled').attr('disabled', true);

			 	//$(document).ajaxStop($.unblockUI);
			 	$.unblockUI();
			}
		});  	
});

/*===== Boton Mover al final Disponible  ======*/

/*=======================================================
=            Boton Mover al 1er Lugar                   =
=======================================================*/

$(document).on('click', '#btn_primero', function(){
 		var codigo = $(this).data("cod");
		var salon  = $('#cod_salon').val();
		
		console.log('Codigo colaborador '+codigo + " Salon "+ salon);		

		$.ajax({
			url: 'php/sube_baja/colaSubaBaja_moverprimerlugar.php',
			method: 'POST',
			data: {clbcodigo: codigo, slncodigo: salon},
			beforeSend: function() 
			{
				$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' }); 
			},
			success: function (data) {
			 ListarCola();
			 $.unblockUI();
			}
		});  	
 });

/*===== Boton Mover al 1er Lugar  ======*/



$(document).ready(function() {
    cargar_programacion_salon ();
    //cargar_comentarios ();
    change_color_bar ();
    validar_col();
    validar_colAusente ();

	//var salon = $('.sln').val();

	//$('.sln_nombre').html(salon);
});

/*=============================================
=            Section cargar_programacion_salon=
=============================================*/

$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});


function cargar_programacion_salon () 
{
    var cod_salon = $('#cod_salon').val();

    $.ajax({
    	url: 'php/sube_baja/cargar_programacion_salon.php',
    	method: 'POST',
    	data: {salon:cod_salon},
    	success: function (data) 
    	{
    		var array = eval(data);
    		$('#tbl_crear_subeybaja tbody').empty();
    		var btnRemove = "";
    		var btnAdd    = "";
    		for(var i in array)
    		{
    			$('[data-toggle="tooltip"]').tooltip();
    			if (array[i].hingreso == null) 
    			{

    				btnAddRemove = '<button title="Añadir al Sube y Baja" data-toggle="tooltip" data-placement="right" class="btn btn-info btn-xs mybutton" id="btn_add_sb" data-codigo='+array[i].cod_col+'><i class="fa fa-user-plus"></i></button>';
    			}
    			else
    			{
    				if (array[i].hingreso != "" && array[i].hsalida != null) 
    				{
    					btnAddRemove = '<button id="fin" title="Turno Finalizado" data-toggle="tooltip" data-placement="right" class="btn btn-warning btn-xs mybutton disabled" disabled><i class="fa fa-user-plus"></i></button>';
    				}
    				else
    				{
    					btnAddRemove = '<button title="En Cola" data-toggle="tooltip" data-placement="right" class="btn btn-danger btn-xs mybutton" id="btn_quitar_col" data-codigo='+array[i].cod_col+'><i class="fa fa-user-plus"></i></button>';
    				}

    				
    			}

    			$('#tbl_crear_subeybaja tbody').append('<tr class="fila_col'+array[i].cod_col+'"></td><td style="text-align: left">'+array[i].nombre+'</td><td style="text-align: left" id="cargoTbl">'+array[i].cargo+'</td><td style="text-align: left">'+array[i].turno+'</td><td><center>'+btnAddRemove+'</center></td></tr>');

    			/*$('#tbl_crear_subeybaja tbody').append('<tr class="fila_col'+array[i].cod_col+'"></td><td style="text-align: left">'+array[i].nombre+'</td><td style="text-align: left">'+array[i].cargo+'</td><td style="text-align: left">'+array[i].turno+'</td><td><button class="btn btn-info btn-xs mybutton" id="btn_add_sb" data-cargo='+array[i].cargo+' data-codigo='+array[i].cod_col+' title="Añadir al Sube y Baja"><i class="fa fa-user-plus"></i></button></td><td><button title="Finalizar Turno" class="btn btn-danger btn-xs mybutton" id="btn_quitar_col" data-codigo='+array[i].cod_col+'><i class="fa fa-user-times"></i></button></td></tr>');*/
    		}
    				//$('#tbl_crear_subeybaja').find('.fila_col'+cod_col+' ').removeClass('selected');

    	}
    });
}

/*=====  End of Section cargar_programacion_salon  ======*/



function validar_col () 
{
	$.ajax({
		url: 'php/sube_baja/validar_col.php',
		method: 'POST',
		data: {salon: $('#cod_salon').val()},
		success: function (data) 
		{
			var array = eval(data);
			for(var i in array)
			{
				
				$('#tbl_crear_subeybaja tbody').find('.fila_col'+array[i].cod_col+'').addClass('selected');
			}
		}
	});
}


/*====================================================
=            Añadir Colaborador a la Cola            =
====================================================*/


$(document).ready(function() 
{
	conteoNovHead ();
});


$(document).on('click', '#btn_add_sb', function() 
	{
		var id         = $(this).data("codigo");
		var cod_salon  = $('#cod_salon').val();
		var cargo      = $(this).data("cargo");
		var comentario = $('#comentario').val();
	    
	    $.ajax({
	    	url: 'php/sube_baja/cargarSubeyBaja.php',
	    	method: 'POST',
	    	data: {cod_col: id, cod_salon: cod_salon, comment: comentario},
	    	beforeSend: function() 
	    	{
	    		$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' });
        		
    		},
	    	success: function (data) 
	    	{
	    		var jsonRespuesta = JSON.parse(data);

	    		if (jsonRespuesta.res == 1) 
	    		{
			    	var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+id+'');
			    	u.find('#btn_add_sb').removeClass('btn-info');
			    	u.find('#btn_add_sb').addClass('btn-danger').attr('id', 'btn_quitar_col');
			    	u.find('#btn_quitar_col').attr('data-original-title','En Cola');

	    			$('[data-toggle="tooltip"]').tooltip();
	    			var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+id+'');
	    			u.find('#btn_add_sb').removeClass('btn-info');
	    			u.find('#btn_add_sb').addClass('btn-danger').attr('id', 'btn_quitar_col');
	    			u.find('#btn_quitar_col').attr('data-original-title','En Cola');
	    			$.unblockUI();    		 			
	    			validar_col ();	
	    			ListarCola();
	    			comentarioFinales ();
	    			
	    		}
	    		else
	    		{
	    			if (jsonRespuesta.res == 2) 
	    			{ 
		    			$.unblockUI();
		    			swal("El colaborador ya terminó su turno", "Advertencia", "warning");
	    			}
	    			else
	    			{
	    				if (jsonRespuesta.res == 3) 
	    				{
	    					$.unblockUI();
	    					swal("El colaborador ya encuentra en el sube y baja", "Advertencia", "warning");
	    				}
					/*else if(jsonRespuesta.res == 'E') {
	    						$.unblockUI();
	    						swal("El colaborador NO ha realizado la encuesta COVID", "No podrá ingresar a sube y baja hasta que la diligencie.", "warning");
	    					
	    				}else if(jsonRespuesta.res == 'F') {
	    						$.unblockUI();
	    						swal("¡Alerta COVID!", "El resultado de la encuesta le impide el ingreso a laborar.", "error");
	    					
	    				}*/
	    			}
	    			
	    		}	  
	    	}
	    });
	});

/*****************************************/


/**
 *
 * AGREGAR EN SUBE Y BAJA AUSENTES
 *
 */


$(document).on('click', '#btnAddSyB', function() 
{
	var id         = $(this).data("codigo");
	var cod_salon  = $('#cod_salon').val();
	var cargo      = $(this).data("cargo");
	var comentario = $('#comentario').val();
	var tpr 	   = $(this).data('tpr');

    	var u = $('#tblColNoLab tbody').find('.trAusente'+id+'').addClass('selected');
    	u.find('#btnAddSyB').removeClass('btn-info');
    	u.find('#btnAddSyB').addClass('btn-danger').attr('id', 'btnRemoveAus');
    	u.find('#btnRemoveAus').attr('data-original-title','En Cola');
    	
    
    $.ajax({
    	url: 'php/sube_baja/cargarSubeyBaja.php',
    	method: 'POST',
    	data: {cod_col: id, cod_salon: cod_salon, comment: comentario,tpr:tpr},
    	beforeSend: function() 
    	{
  		$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' });
	},
    	success: function (data) 
    	{
    		var jsonRespuesta = JSON.parse(data);

    		if (jsonRespuesta.res == 1) 
    		{
    			$('[data-toggle="tooltip"]').tooltip();
    			var u = $('#tblColNoLab tbody').find('.trAusente'+id+'');
    			u.find('#btnAddSyB').removeClass('btn-info');
    			u.find('#btnAddSyB').addClass('btn-danger').attr('id', 'btnRemoveAus');
    			u.find('#btnRemoveAus').attr('data-original-title','En Cola');
    			$.unblockUI();	 			
    			validar_col ();	
    			ListarCola();
    			comentarioFinales ();

    		}
    		else
    		{
    			if (jsonRespuesta.res == 2) 
    			{ 
	    			$.unblockUI();
	    			swal("El colaborador ya terminó su turno", "Advertencia", "warning");
    			}
    			else
    			{
    				if (jsonRespuesta.res == 3) 
    				{
    					$.unblockUI();
    					swal("El colaborador ya encuentra en el sube y baja", "Advertencia", "warning");
    				}
    			}
    			
    		}	  
    	}
    });
});

/*****************************************/




function fnAdd (trcdocumento) 
{

	    
	$.ajax({
	    	url: 'php/sube_baja/cargar_cola_turnos.php',
	    	method: 'POST',
	    	data: {trcdocumento: trcdocumento},
	    	beforeSend: function() 
	    	{
        		$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' }); 
    		},
	    	success: function (data) 
	    	{
	    		var jsonRespuesta = JSON.parse(data);


	    		if (jsonRespuesta.res == 1) 
	    		{
	    			$.unblockUI();  		 			
	    			validar_col ();	
	    			comentarioFinales ();
	    			swal("Ingreso Correcto", "", "success");
	    			$('#modalDocumento').modal("hide");


	    			var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+jsonRespuesta.codigocol+'');
	    			u.find('#btn_add_sb').removeClass('btn-info');
	    			u.find('#btn_add_sb').addClass('btn-danger').attr('id', 'btn_quitar_col');
				u.find('#btn_quitar_col').addClass('btn-warning');
				u.find('#btn_quitar_col').attr('data-original-title','En Cola');

	    			//var SlCargo = u.find('#cargoTbl').text();
	    			ListarCola();
	    			//$('#right-sidebar').addClass('sidebar-open');

	    		}
	    		else
	    		{
	    			if (jsonRespuesta.res == 2) 
	    			{ 
		    			$.unblockUI();
		    			$('#txtInfo').html("El colaborador ya terminó su turno");
		    			$('#spinL').hide();
    			
	    			}
	    			else
	    			{
	    				if (jsonRespuesta.res == 3) 
	    				{
	    					$.unblockUI();
	    					swal("El colaborador ya encuentra en el sube y baja", "Advertencia", "warning");
	    					$('#modalDocumento').modal("hide");
	    				}
	    				else
	    			 	{
						if (jsonRespuesta.res == 4) 
		    				{
		    					swal({
							title: "¿Seguro que desea finalizar turno? Esta acción es irreversible",
							text: "Verifique si aún está en turno",
							type: "warning",
							showCancelButton:  true,
							cancelButtonText:"No",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Sí"  
						},function () {
							    	$.ajax({
							    		type: "POST",
							    		url: 'php/sube_baja/turno_colab_finalizado.php',
							    		data: {trcdocumento:trcdocumento},
							    		success: function (data) 
							    		{
							    			var json = JSON.parse(data);

							    			if (json.res == 9) 
							    			{
							    				swal('El colaborador ya terminó su turno o no se ha ingresado al sube y baja', "Advertencia", 'warning');
							    				//alert('El colaborador ya terminó su turno o no se ha ingresado al sube y baja');
							    				$('#modalDocumento').modal("hide");
							    				$.unblockUI();
							    			}
							    			else
							    			{
							    				if (json.res == 8) 
							    				{
							    					$('[data-toggle="tooltip"]').tooltip();

							    					$('.sube_baja li#'+json.cod_colaborador+' ').remove();

												$('#tbl_crear_subeybaja tbody').find('.fila_col'+json.cod_colaborador+' ').removeClass('selected');

												var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+json.cod_colaborador+'');
	    											u.find('#btn_quitar_col').removeClass('btn-danger');
	    											u.find('#btn_quitar_col').addClass('btn-warning disabled');
	    											u.find('#btn_quitar_col').attr('disabled', true);
	    											u.find('#btn_quitar_col').attr('data-original-title','Turno Finalizado');
	    											$.unblockUI();

												validar_col();
												change_color_bar ();
												$('#modalDocumento').modal("hide");
							    				}
							    				
							    			}
	    	 						
		    	 							
	    								}
	  
	    							});
							});
		    				}
		    				else
		    				{
		    					if (jsonRespuesta.res == 5) 
		    					{
		    						swal("No tiene programación asignada en este salón", "", "error");
		    						$.unblockUI();
		    						$('#modalDocumento').modal("hide");
		    					}
		    					else
		    					{
		    						if (jsonRespuesta.res == 6) 
				    				{
				    					swal('El colaborador aún está en turno.', "Advertencia", 'warning');
				    					$.unblockUI();
				    					$('#modalDocumento').modal("hide");
				    				}
				    				
		    					}
		    				}

	    			 	}
	    			}
	    			
	    		}
	    		  
	    	}
	});
}


$('#modalDocumento').on('hidden.bs.modal', function (e) {
      $('#docColaborador').val('');
      $('#nombreColaborador').val('');
      $('#dataCaptureDoc').val('');
      $('#txtInfo').html('');
      $('#spinL').hide();
});


/*=====  End of Añadir Colaborador a la Cola  ======*/


/*===================================================================
=            Boton de Quitar Colaborador del Sube y Baja            =
===================================================================*/



	

$(document).on('click', '#btn_quitar_col', function(){
	var cod_colaborador = $(this).data("codigo");

    swal({
	title: "¿Seguro que desea finalizar turno? Esta acción es irreversible",
	text: "Verifique si aún está en turno",
	type: "warning",
	showCancelButton:  true,
	cancelButtonText:"No",
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Sí"  
	},function () {
	    $.ajax({
	    type: "POST",
	    url: 'php/sube_baja/turnoFinalizado.php',
	    data: {cod_colaborador:cod_colaborador},
	    success: function (data) 
	    {
	    	
	    	 if (data == 0 || data == "0") 
			{
				swal('El colaborador ya terminó su turno', "Advertencia", 'warning');
				//$(document).ajaxStop($.unblockUI); 
			}
			else
			{
				if (data == 1 || data == "1") 
				{
					alert('El colaborador aún está en turno.');	
					//$(document).ajaxStop($.unblockUI); 
					//alert("El colaborador aún está en turno");       				
				}
				else
				{
					if (data == 2 || data == "2") 
					{
						$('.sube_baja li#'+cod_colaborador+' ').remove();
						$('#tbl_crear_subeybaja tbody').find('.fila_col'+cod_colaborador+' ').removeClass('selected');


						var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+cod_colaborador+'');
	    					u.find('#btn_quitar_col').removeClass('btn-danger');
	    					u.find('#btn_quitar_col').addClass('btn-info');
	    					u.find('#btn_quitar_col').attr('disabled', true);



						validar_col();
						change_color_bar ();
						ListarCola();
						swal("Turno finalizado", "Exitoso", "success");
						//cargar_boton_cierresb ();
						
					}
					else
					{
						if (data == 8 || data == '8') 
						{
							$('[data-toggle="tooltip"]').tooltip();
							$('.sube_baja li#'+cod_colaborador+' ').remove();
							$('#tbl_crear_subeybaja tbody').find('.fila_col'+cod_colaborador+' ').removeClass('selected');
							validar_col();

							var u = $('#tbl_crear_subeybaja tbody').find('.fila_col'+cod_colaborador+'');
	    						u.find('#btn_quitar_col').removeClass('btn-danger');
	    						u.find('#btn_quitar_col').addClass('disabled');
	    						u.find('#btn_quitar_col').addClass('btn-warning').attr('id', 'id');
	    						u.find('#id').attr('data-original-title','Turno Finalizado');
	    						change_color_bar ();
						}
					}
				}
			}
	    }
	  
	    });
     });
});


/**
 *
 * QUITAR COL AUSENTES
 *
 */

$(document).on('click', '#btnRemoveAus', function(){
	var cod_colaborador = $(this).data("codigo");

    swal({
	title: "¿Seguro que desea finalizar turno? Esta acción es irreversible",
	text: "Verifique si aún está en turno",
	type: "warning",
	showCancelButton:  true,
	cancelButtonText:"No",
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Sí"  
	},function (d) {
	    $.ajax({
	    type: "POST",
	    url: 'php/sube_baja/turnoFinalizado.php',
	    data: {cod_colaborador:cod_colaborador},
	    success: function (data) 
	    {
	    	
	    	 	if (data == 0 || data == "0") 
			{
				swal('El colaborador ya terminó su turno', "Advertencia", 'warning');
				//$(document).ajaxStop($.unblockUI); 
				$('#spinL').hide();
			}
			else
			{
				if (data == 1 || data == "1") 
				{
					alert('El colaborador aún está en turno.');	
					//$(document).ajaxStop($.unblockUI); 
					//alert("El colaborador aún está en turno");       				
				}
				else
				{
					if (data == 2 || data == "2") 
					{
						$('.sube_baja li#'+cod_colaborador+' ').remove();
						$('#tblColNoLab tbody').find('.trAusente'+cod_colaborador+' ').removeClass('selected');


						var u = $('#tblColNoLab tbody').find('.trAusente'+cod_colaborador+'');
	    					u.find('#btnRemoveAus').removeClass('btn-danger');
	    					u.find('#btnRemoveAus').addClass('btn-info');
	    					u.find('#btnRemoveAus').attr('disabled', true);



						validar_col();
						change_color_bar ();
						swal("Turno finalizado", "Exitoso", "success");
						//cargar_boton_cierresb ();
						
					}
					else
					{
						if (data == 8 || data == '8') 
						{
							$('[data-toggle="tooltip"]').tooltip();
							$('.sube_baja li#'+cod_colaborador+' ').remove();
							$('#tblColNoLab tbody').find('.trAusente'+cod_colaborador+' ').removeClass('selected');
							validar_col();

							var u = $('#tblColNoLab tbody').find('.trAusente'+cod_colaborador+'');
	    						u.find('#btnRemoveAus').removeClass('btn-danger');
	    						u.find('#btnRemoveAus').addClass('disabled');
	    						u.find('#btnRemoveAus').addClass('btn-warning').attr('id', 'id');
	    						u.find('#id').attr('data-original-title','Turno Finalizado');
	    						change_color_bar ();
						}
					}
				}
			}
	      }
	  
	    });
     });
});

		
		
/*=====  End of Boton de Quitar Colaborador del Sube y Baja  ======*/


/*===========================================================
=            Cerrar Comentario Final Sube y Baja            =
===========================================================*/
		
$(document).on('click', '#btn_fin_subebaja', function()
{
	var comentario_final = $('#comentariof').val();
	$.ajax({
		url: 'php/sube_baja/cerrar_sube_baja.php',
		method: 'POST',
		data: {comentario_final: comentario_final},
		success: function (data) 
		{
			if (data == 0) 
			{
				swal("No se puede cerrar el Sube y Baja porque hay personas en turno.", "", "warning");	
				$('#modal_cerrar_sube_baja').modal('hide');
			}
			else
			{
				if (data == 1) 
				{
					swal("Se ha cerrado el sube y baja", "Exitoso", "success");		
					comentarioFinales ();					
				}
				else
				{
					if (data == 2) 
					{
						swal("El Sube y Baja ya se ha cerrado.", "Exitoso", "warning");
						$('#modal_cerrar_sube_baja').modal('hide');
					}
					else
					{
						if (data == 3) 
						{
							swal("Aún no se ha creado el Sube y Baja", "Advertencia", "warning");
							$('#modal_cerrar_sube_baja').modal('hide');
						}
					}
				}
			}
		}
	});
});



/*===========================================
=            Cambiar Color Barra            =
===========================================*/


function change_color_bar () 
{
	$.ajax({
		url: 'php/sube_baja/change_color_bar.php',
		method: 'POST',
		data: {cod_salon: $('#cod_salon').val()},
		success: function (data) 
		{
			if (data == 1) 
			{
				$('#sidebar').css("color", "red").html('<i class="pe-7s-menu"></i>');
			}else{
				$('#sidebar').css("color", "#9d9fa2").html('<i class="pe-7s-menu"></i>');
			}
		}
	});
}

/*=====  End of Cambiar Color Barra  ======*/


/*=====================================
=            Filtro Cargos            =
=====================================*/


$(document).on('change', '#filtro_cargos', function() 
{
	ListarCola();
});

/*=====  End of Filtro Cargos  ======*/


/*===================================================
=            Funcion Comentarios FInales            =
===================================================*/

function comentarioFinales () 
{ 
	$.ajax({
        url: 'php/sube_baja/comments.php',
        method: 'POST',
        data: {opcion: 'inhabilitar'},
        success: function (data) 
        {
        	var jsoncomentario = JSON.parse(data);

        	if (data == 3 || data == 2) 
        	{
        		$('#comentario').val("");
        	}
        	else
        	{
        		if (jsoncomentario.comentarioInicial) 
        		{
        			$('#comentario').val(jsoncomentario.comentarioInicial);
					$('#comentario').attr('disabled', true);

					if (jsoncomentario.comentarioFinal) 
        			{
        				$('#comentariof').val(jsoncomentario.comentarioFinal);
        			    $('#comentariof').attr('disabled', true);
        			}
        			else
        			{
        				$('#comentariof').val("");
        			}
        		}
        		
        	}
        	
    
        	
        }
	});
}

/*=====  End of Funcion Comentarios FInales  ======*/




/*=============================================
=            ListCola en Sube Baja            =
=============================================*/
var pubnub = new PubNub ({
    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
});
function ListarCola(SlCargo)
{

 	var cod_salon = $('#cod_salon').val();
  	var SlCargo   = $('#filtro_cargos').val();
  	
  
	$.ajax({
		url: 'php/sube_baja/colaboradoresCargosTurno.php',
		method: 'POST',
		data: {cod_salon: cod_salon, cargo:SlCargo},

	}).done(function(colaboradores) 
	{
		var jsonColaboradores = JSON.parse(colaboradores);

			if(jsonColaboradores.result == "full")
			{

				var listaColaboradores = "";
				var codigo             = "";
				var nombre             = "";
				var categoria          = "";
				var cargo              = "";
				var imagen             = "";
				var posicion           = "";
						

				for(i in jsonColaboradores.colaboradores)
				{

					codigo   = jsonColaboradores.colaboradores[i].codigo;
					nombre   = jsonColaboradores.colaboradores[i].nombre;
					posicion = jsonColaboradores.colaboradores[i].posicion;
					estado   = jsonColaboradores.colaboradores[i].estado;
					cargo    = jsonColaboradores.colaboradores[i].cargo;

					switch (jsonColaboradores.colaboradores[i].categoria) 
					{								

						case "JUNIOR":
							categoria = " <li class='list-group-item'><center><label class='label label-danger pull-right'>"+jsonColaboradores.colaboradores[i].categoria+"</label>"+jsonColaboradores.colaboradores[i].cargo+"</li>";
							break;

						case "SENIOR":
							categoria = " <li class='list-group-item'><label class='label label-primary pull-right'>"+jsonColaboradores.colaboradores[i].categoria+"</label>"+jsonColaboradores.colaboradores[i].cargo+"</li>";
							break;
						
						case "GOLD":
							categoria = " <li class='list-group-item'><label class='label label-warning pull-right'>"+jsonColaboradores.colaboradores[i].categoria+"</label>"+jsonColaboradores.colaboradores[i].cargo+"</li>";
							break;

						case "PLATINUM":
							categoria = " <li class='list-group-item'><label class='label label-default pull-right'>"+jsonColaboradores.colaboradores[i].categoria+"</label>"+jsonColaboradores.colaboradores[i].cargo+"</li>";
							break;

						case "N/D":
							categoria = " <li class='list-group-item'><label class='label label-info pull-right'>"+jsonColaboradores.colaboradores[i].categoria +"</label>"+jsonColaboradores.colaboradores[i].cargo+"</li>";
							break;

						default:
							categoria = "";
							break;
					}

					if(jsonColaboradores.colaboradores[i].imagen == "default.jpg"){

						imagen = "../contenidos/imagenes/default.jpg";
					}
					else{

						imagen = "../contenidos/imagenes/colaborador/beauty_erp/" + jsonColaboradores.colaboradores[i].imagen;
					}

					listaColaboradores += "<li id='"+codigo+"' data-posicion='"+posicion+"' class='listaColaboradores' style='margin: 3px'>";

					switch (jsonColaboradores.colaboradores[i].estado) 
					{

                       case "1":
						estado = "<div class='hpanel' style='border: 2px solid #62cb31' border-radius: 8px>";
						break;

						case "0":
						estado = "<div class='hpanel' style='border: 2px solid #e74c3c' border-radius: 8px>";
						break;

						default:
						estado = "";
						break;

					}


					
						listaColaboradores += ""+estado+"<div class='panel-heading hbuilt'><div class='panel-tools'><button type='button' class='btn btn-primary btn-xs' style='margin-right:8px' title='Click para ver los servicios.' data-toggle='modal' data-target='#modalServicios'  id='btn_ver_servicios' data-id_col='"+codigo+"' data-img='"+jsonColaboradores.colaboradores[i].imagen+"' data-cargo='"+jsonColaboradores.colaboradores[i].cargo+"' data-nombrecol='"+jsonColaboradores.colaboradores[i].nombre+"'><i class='fa fa-scissors'></i></button><button type='button' class='btn btn-info btn-xs' id='btn_check' data-cod='"+codigo+"' data-cargo='"+cargo+"'  style='margin-right:8px' title='Click para cambiar estado.'><i class='fa fa-check'></i></button><button type='button' class='btn btn-warning btn-xs' id='btn_primero' data-cod='"+codigo+"' data-cargo='"+cargo+"'  style='margin-right:8px' title='Click para colocar de Primero.'><i class='fa fa-sort-numeric-asc'></i></button></div><i class='fa fa-cog'></i> </div><div class='panel-body no-padding'><ul class='list-group'><li class='list-group-item' title='"+nombre+"'><center><img class='img-thumbnail img-rounded' src='"+imagen+"' style='width: 70px; height: 70px;'></center></li><li class='list-group-item' style='font-size: .8em'>"+nombre+"</li> "+categoria+"</ul></div></div>";
				}

						$(".sube_baja").html(listaColaboradores);
						$("#subeBaja").fadeIn("fast");
						//modalSelectSalon.modal("hide");
						change_color_bar ();
			}
				else if(jsonColaboradores.result == "vacio")
				{						
										
					$(".sube_baja").empty();
				}
				else
				{
				}
	});	
	var swscreen=$("#swscreen").val();
	if(swscreen==1){
		var linkserver ='//httprelay.io/link/bty-sln00'+cod_salon;
		pubnub.publish({
	        message: '1',
	        channel: 'bty00'+cod_salon
		    },
		    function (status, response) {
		        if (status.error) {
		            console.log(status)
		        } else {
		            //console.log("Enviado");
		        }
		    }
		);	
	}
}

 function conteoNovHead () 
 {
    $.ajax({
        url: 'php/biometrico/processFn.php',
        method: 'POST',
        data: {opcion: "conteoNovHead"},
        success: function (data) 
        {
            $('#conteoNoved').html(data);
            $('#novdect').html("NOVEDADES DETECTADAS " + data);
        }
    });
 }



 



/*==============================================
=            COLABORADORES AUSENTES            =
==============================================*/

$(document).on('click', '#btnModalAusentes', function() 
{
    $('#modalAusentes').modal("show");    

    $.ajax({
        url: 'php/sube_baja/incluir_aus.php',
       	method: 'POST',
       	success: function (data) 
       	{
       	    var jsonAusentes = JSON.parse(data);

       	    $('#tblColNoLab tbody').empty();
       	    var btnAddRemove = '';
       	    if (jsonAusentes.res == "full") 
       	    {
       	    	for(var i in jsonAusentes.json)
       	    	{

       	    		$('[data-toggle="tooltip"]').tooltip();
	    			if (jsonAusentes.json[i].hingreso == null) 
	    			{

	    				btnAddRemove = '<button title="Añadir al Sube y Baja" data-toggle="tooltip" data-placement="right" class="btn btn-info btn-xs mybutton" id="btnAddSyB" data-tpr="'+jsonAusentes.json[i].tprcodigo+'" data-codigo='+jsonAusentes.json[i].cod_col+'><i class="fa fa-user-plus"></i></button>';
	    			}
	    			else
	    			{
	    				if (jsonAusentes.json[i].hingreso != "" && jsonAusentes.json[i].hsalida != null) 
	    				{
	    					btnAddRemove = '<button id="fin" title="Turno Finalizado" data-toggle="tooltip" data-placement="right" class="btn btn-warning btn-xs mybutton disabled" disabled><i class="fa fa-user-plus"></i></button>';
	    				}
	    				else
	    				{
	    					btnAddRemove = '<button title="En Cola" data-toggle="tooltip" data-placement="right" class="btn btn-danger btn-xs mybutton" id="btnRemoveAus" data-codigo='+jsonAusentes.json[i].cod_col+'><i class="fa fa-user-plus"></i></button>';
	    				}

	    				
	    			}


       	    		validar_colAusente ();
       	    		$('#tblColNoLab tbody').append('<tr class="trAusente'+jsonAusentes.json[i].cod_col+'"><td>'+jsonAusentes.json[i].nombre+'</td><td>'+jsonAusentes.json[i].cargo+'</td><td>'+jsonAusentes.json[i].perfil+'</td><td>'+jsonAusentes.json[i].tipo+'</td><td>'+jsonAusentes.json[i].turno+'</td><td><center>'+btnAddRemove+'</center></td></tr>');
       	    	}
       	    }
       	}
    });
});

/*=====  End of COLABORADORES AUSENTES  ======*/


$(document).on('click', '#btnAddColAus', function() 
{
     var codcol = $(this).data("idcol");

     $.ajax({
	    	url: 'php/sube_baja/cargarSubeyBaja.php',
	    	method: 'POST',
	    	data: {cod_col: codcol},
	    	beforeSend: function() 
	    	{
        		$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Procesando...</p>' }); 
    		},
	    	success: function (data) 
	    	{
	    		var jsonRespuesta = JSON.parse(data);

	    		if (jsonRespuesta.res == 1) 
	    		{
	    			$.unblockUI();		 			
	    			validar_col ();	
	    			validar_colAusente ();
	    			ListarCola();
	    			comentarioFinales ();
	    			$('#tblColNoLab tbody').find('.trAusente'+jsonRespuesta.codigocol+'').addClass('selected');
	    		}
	    		else
	    		{
	    			if (jsonRespuesta.res == 2) 
	    			{ 
		    			$.unblockUI();
		    			swal("El colaborador ya terminó su turno", "Advertencia", "warning");
		    			$('#spinL').hide();
	    			}
	    			else
	    			{
	    				if (jsonRespuesta.res == 3) 
	    				{
	    					$.unblockUI();
	    					swal("El colaborador ya encuentra en el sube y baja", "Advertencia", "warning");
	    				}
	    			}
	    			
	    		}	  
	    	}
	    });


});


function validar_colAusente () 
{
	$.ajax({
		url: 'php/sube_baja/validar_col.php',
		method: 'POST',
		data: {salon: $('#cod_salon').val()},
		success: function (data) 
		{
			var array = eval(data);
			for(var i in array)
			{				
				$('#tblColNoLab tbody').find('.trAusente'+array[i].cod_col+'').addClass('selected');
			}
		}
	});
}


$(document).on('click', '#btnFinTurno', function(){
	var cod_colaborador = $(this).data("idcol");

    $.ajax({
    	url: 'php/sube_baja/turno_colab_finalizado.php',
    	method: 'POST',
    	data: {cod_colaborador:cod_colaborador},
    	/*beforeSend: function() 
		{
			$.blockUI({ message: '<h1>Espere un momento...</h1>' }); 
		},*/
    	success: function (data) 
    	{
			if (data == 0) 
			{
				swal('El colaborador ya terminó su turno', "Advertencia", 'warning');
				//$(document).ajaxStop($.unblockUI); 
				$('#spinL').hide();
			}
			else
			{
				if (data == 1) 
				{
					swal('El colaborador aún está en turno.', "Advertencia", 'warning');	
					//$(document).ajaxStop($.unblockUI);         				
				}
				else
				{
					if (data == 2) 
					{
						swal("Turno finalizado", "Exitoso", "success");
						//$('.sube_baja li#'+cod_colaborador+' ').remove();
						$('#tblColNoLab tbody').find('.trAusente'+cod_colaborador+' ').removeClass('selected');
						validar_col();
						change_color_bar ();
						//cargar_boton_cierresb ();
						
					}
				}
			}
    	}
    });
	
});


/***************************/


$('#modalDocumento').on('shown.bs.modal', function () 
{
    $('#dataCaptureDoc').focus();
    $('#spinL').show();
}); 

$(document).on('keydown','#dataCaptureDoc',function (e) {
	var code = (e.which);
    	if(code===13)
    	{

        	var str = $('#dataCaptureDoc').val();

        	var co=0;
        	var j=0;
        	var c=str.length;


        	for(i=0;i<c;i++)
        	{
	            j=i+1;
	            if(str.substring(i,j)=='@')
	            {
	                co++;
	            }
        	}

    

        	if (co != 8 || co != '8') 
        	{
           		alert("Error en la lectura. " + "\n" + "Intente desconectar/conectar el lector.");    
        	}
        	else
        	{
	            var rese = str.split("@");

	            var doc = parseInt(rese[1]);
	            

	            $('#docColaborador').val(doc);
	            $('#docColaborador').attr('readonly', true);

	            $('#nombreColaborador').val(rese[4].trim() + " " + rese[5].trim() + " " + rese[2].trim() + " " + rese[3].trim());
	            $('#nombreColaborador').attr('readonly', true);

	            fnAdd(doc);
	            //removeCol(doc);
            }
      }
});   



/*=====  End of ListCola en Sube Baja  ======*/





