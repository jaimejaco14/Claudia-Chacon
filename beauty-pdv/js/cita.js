
$(document).ready(function() {
	actualizarCalendario();
	conteoNovHead ();
	
});

function actualizarCalendario() {

	$.ajax({
		url: './php/citas/obtenerCitasProgramadas.php',
		success: function (citasProgramadas) 
		{

			var jsonCitasProgramadas      = JSON.parse(citasProgramadas);
			var tituloCita                = $("#tituloModalDetalle");
			var modalServicio             = $("#txtModalServicio");
			var modalColaborador          = $("#txtModalColaborador");
			var modalDuracion             = $("#txtModalDuracion");
			var modalCliente              = $("#txtModalCliente");
			var modalSalon                = $("#txtModalSalon");
			var modalFecha                = $("#txtModalFecha");
			var modalUsuario              = $("#txtModalUsuario");
			var modalObservaciones        = $("#txtModalObservaciones");
			var btnActualizarModalDetalle = $("#btnActualizarModalDetalle");

			switch (jsonCitasProgramadas.result) 
			{
			
				case "full":


				//arrayCitas = new Array();
				var arrayCitas = [];

				for(var i in jsonCitasProgramadas.citas)
				{
						
					//Establecer fecha de finalización de cada cita
					var fechaFinAgendamiento = new Date(jsonCitasProgramadas.citas[i].fecha+"T"+jsonCitasProgramadas.citas[i].hora);
					fechaFinAgendamiento.setMinutes(jsonCitasProgramadas.citas[i].duracion);

					var cita            = new Object();
					cita.id             = jsonCitasProgramadas.citas[i].codigo;
					cita.title          = "Cita No." + jsonCitasProgramadas.citas[i].codigo;
					cita.backgroundColor = jsonCitasProgramadas.citas[i].backgroundColor;
					cita.description    = jsonCitasProgramadas.citas[i].observaciones;
					cita.start          = jsonCitasProgramadas.citas[i].fecha+"T"+jsonCitasProgramadas.citas[i].hora;
					cita.end            = fechaFinAgendamiento;
					cita.fecha          = jsonCitasProgramadas.citas[i].fecha;
					cita.hora           = jsonCitasProgramadas.citas[i].hora;
					cita.codServicio    = jsonCitasProgramadas.citas[i].codServicio;
					cita.servicio       = jsonCitasProgramadas.citas[i].servicio;
					cita.duracion       = jsonCitasProgramadas.citas[i].duracion;
					cita.codSalon       = jsonCitasProgramadas.citas[i].codSalon;
					cita.salon          = jsonCitasProgramadas.citas[i].salon;
					cita.direccionSalon = jsonCitasProgramadas.citas[i].direccionSalon;
					cita.codCliente     = jsonCitasProgramadas.citas[i].codCliente;
					cita.cliente        = jsonCitasProgramadas.citas[i].cliente;
					cita.codColaborador = jsonCitasProgramadas.citas[i].codColaborador;
					cita.colaborador    = jsonCitasProgramadas.citas[i].colaborador;
					cita.usuario        = jsonCitasProgramadas.citas[i].usuario;
					cita.fechaRegistro  = jsonCitasProgramadas.citas[i].fechaRegistro + " " + jsonCitasProgramadas.citas[i].horaRegistro;
					cita.codEstado      = jsonCitasProgramadas.citas[i].codEstado;
					cita.nomEstado      = jsonCitasProgramadas.citas[i].nomEstado;
					cita.estado         = jsonCitasProgramadas.citas[i].estado;
					arrayCitas.push(cita);
				}

				$("#calendar").fullCalendar("destroy");
				$("#calendar").fullCalendar({

					lang: 'es',
		            header: {
		                left: 'prev,next today',
		                center: 'title',
		                right: 'month,agendaWeek,agendaDay'
		            },
		            editable: false,		            
		            eventLimit: false,
		            eventLimitText: "Something",
		            droppable: false,
		            events: arrayCitas,
		            timeFormat: "h:mm a",
		            eventClick: function(cita)
		            {

		            	//if (cita.codEstado == 3) 
		            	//{
		            		// $('#modalDetalleCita').modal("hide");
		            		 //swal("La cita con código " + cita.id + " se ha cancelado", "Aviso", "warning");
		            	//}
		            	//else
		            	//{
		            	$("#txtModalCita").val(cita.id);
		            	tituloCita.html("Cita No." + cita.id + "<small id='subtituloModalDetalle'><a id='btnhabil' onclick='habilitarEdicionCampos("+cita.codServicio+")'> <span class='fa fa-edit'></span></a></small>");
		            	modalServicio.val(cita.servicio);
		            	$("#txtModalServicio2").val(cita.codServicio);
		            	modalColaborador.val(cita.colaborador);
		            	$("#txtModalColaborador2").val(cita.codColaborador);
		            	modalDuracion.text("Duraci\u00F3n: " + cita.duracion+ "min. aprox.");
		            	modalCliente.val(cita.cliente);
		            	$("#txtModalCliente2").val(cita.codCliente);
		            	modalSalon.val(cita.salon);
		            	$("#txtModalSalon2").val(cita.codSalon);
		            	modalFecha.val(cita.fecha + " (" + cita.hora.substring(0, cita.hora.length-3) + ")");
		            	$('#pfechavigente').html("Fecha Actual: " + cita.fecha + " (" + cita.hora.substring(0, cita.hora.length-3) + ")");
		            	$("#txtModalFecha2").val(cita.fecha + " " + cita.hora);
		            	modalUsuario.val(cita.usuario);
		            	modalObservaciones.val(cita.description);
		            	$("#txtModalEstado2").val(cita.codEstado);
		            	$("#txtModalEstado3").val(cita.codEstado);
		            	$("#txtModalEstado").val(cita.estado);
		            	$('#pestadovigente').html("Estado Cita Actual: " + cita.estado);
		            	//validarCol (cita.codColaborador);
		            	//validarCitater (cita.id);

		            	$.ajax({
		            		url: 'php/citas/obtenerNovedadesCita.php',
		            		data: {codCita: cita.id},
		            	})
		            	.done(function(novedades) 
		            	{
		            		
		            		var jsonNovedades = JSON.parse(novedades);

		            		if(jsonNovedades.result == "full")
		            		{

		            			var tablaNovedades = "<table class=' table table-striped'><thead><tr><th>Novedad</th><th>Fecha</th><th>Hora</th><th>Realizada por</th><th>Observaciones</th></tr></thead><tbody>";

		            			for(i in jsonNovedades.novedades)
		            			{

		            				tablaNovedades += "<tr><td>"+jsonNovedades.novedades[i].estado+"</td><td>"+jsonNovedades.novedades[i].fechaNovedad+"</td><td>"+jsonNovedades.novedades[i].horaNovedad+"</td><td>"+jsonNovedades.novedades[i].autorNovedad+"</td><td>"+jsonNovedades.novedades[i].observaciones+"</td></tr>";
		            			}

		            			tablaNovedades += "</tbody></table>";

		            			$("#tablaNovedades").html(tablaNovedades);
		            		}
		            	});
		            	

		            	$("#modalDetalleCita").modal("show");
		            	//}

		            		
		            },
		            eventRender: function(event, element)
		            {
		            	$(element).tooltip({title: event.title + " " + event.estado, container: "body"});
		            			            			            		
		            	
		            },
		            dayClick: function(diaSeleccionado)
		            {
		            	
		            	$.ajax({
		            		url: 'php/citas/obtenerCitasProgramadasPorDia.php',
		            		data: {diaActual: diaSeleccionado.format(), codSalon: salon},
		            	})
		            	.done(function(citas) 
		            	{
		            		
		            		var jsonCitas = JSON.parse(citas);

		            		switch (jsonCitas.result)
		            		{
		            			
		            			case "full":
		            			
		            				$("#tituloModalCitasDia").text("Citas para el d\u00EDa " + diaSeleccionado.format("ll"));
		            				$("#txtFechaReporte").val(diaSeleccionado.format());
		            				$("#modalCitasDia").modal("show");
		            				break;

		            			case "vacio":

		            				$("#modalCitasDia").modal("hide");
		            				swal({
		            					title: "No hay citas agendadas para este d\u00EDa",
		            					confirmButtonText: "Aceptar",
		            					type: "warning"
		            				});
		            				break;

		            			//Error	
		            			default:

		            				$("#modalCitasDia").modal("hide");
		            				swal({
		            					title: "Problemas para obtener las citas agendadas",
		            					confirmButtonText: "Aceptar",
		            					type: "error"
		            				});
		            				break;
		            		}
		            	});
		            }
				});//fincalendario

				break;

				case "vacio":
					
					/*swal({
						title: "Sin resultados",
						text: "No hay citas programadas para el sal\u00F3n \n" + $(".sln").val(),
						type: "warning",
						confirmButtonText: "Aceptar"
					});*/
					console.log("No apoinment");

					//$("#calendar").fullCalendar("destroy");
					restablecerCalendario();
				break;

				default:
					
					swal({
						title: "Error",
						text: "Problemas al consultar citas programadas",
						type: "error",
						confirmButtonText: "Aceptar"
					});
					restablecerCalendario();
				break;
		    }//fin switch
		}//fin success
	});//fin ajax
	
}//fn

function crear_calendario () {
    
	var col = $('#selColSearch').val();

   
    $('#calendario').fullCalendar({        

        eventRender: function(event, element){
             $(element).tooltip({title: event.turno, container: "body"});
        },
        dayRender: function(event, cell, date) {
                          
                    //cell.prepend("<i class='fa fa-print'></i>");
                 
        },
        eventLimit: true, 
        eventLimitText: "Ver",     
        textColor : "#0c0c0c",
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar     
        events: "php/citas/find_progra_col.php?col="+col //carga las programaciones existentes

    });
}

$("#selColSearch").on("change", function () {
	$('#calendario').fullCalendar('destroy');
	crear_calendario ();
});


$(document).ready(function(){

	$(document).prop('title', 'Citas | Beauty SOFT - ERP');


 	$(document).on('click', '.sln_nombre', function() {
        var id = $('#cod_salon').val();
        $('#modalVerSalon').modal("show");
        $('body').removeClass("modal-open");
        $('body').removeAttr("style");

      $.ajax({
            url: 'php/sube_baja/cargar_imagen_sln.php',
            method: 'POST',
            data: {id:id},
            success: function (data) {
                var array = eval(data);
                for(var i in array)
                {
                    $('#title_imagen').html("Salón "+array[i].nombre);
                    $("#imagen_salon").removeAttr("src");        
                    $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
                }
            }
      });
});
  

$(document).on('click', '#btn_paginar', function() {
      var data = $(this).data("id");
      $.ajax({
      type: "POST",
      url: "php/sube_baja/lista_servicios.php",
      data: {page: data, cod: $('#txtCodigoColaborador').val()},
      success: function (data) {
         $('#list').html(data);
      }
  });
});


$(document).ready(function() {
     

    $(document).on('click', '#btn_paginar_citas', function() {
          var data = $(this).data("id");

		  var grupo 			= selectGrupo.val();
		  var subgrupo  		= selectSubgrupo.val();
		  var linea     		= selectLinea.val();
		  var sublinea  		= selectSublinea.val();
		  var caracteristica 	= selectCaracteristica.val();
          $.ajax({
          type: "POST",
          url: "php/citas/mostrar_tabla_servicios.php",
          data: {page: data,grupo: grupo, subgrupo:subgrupo, linea:linea, sublinea:sublinea, carac: caracteristica},
          success: function (data) {
              $('#tabla_ser').html(data);
          }
      });
    });


});
		
		var tituloCita                = $("#tituloModalDetalle");
		var selectCliente             = $("#selectCliente");
		var selectSalon               = $("#selectSalon");
		var selectServicio            = $("#selectServicio");
		var selectFecha               = $("#inpFecha");
		var selectColaborador         = $("#selectColaborador");
		var linkBusquedaServicio      = $("#linkBusquedaServicio");
		var btnAgendar                = $("#btnAgendar");
		var btnCancelar               = $("#btnCancelar");
		var txtObservaciones          = $("#txtObservaciones");
		var txtUsuario                = $("#txtUsuario");
		var selectGrupo               = $("#selectGrupo");
		var selectSubgrupo            = $("#selectSubgrupo");
		var selectLinea               = $("#selectLinea");
		var selectSublinea            = $("#selectSublinea");
		var selectCaracteristica      = $("#selectCaracteristica");
		var selectServicio2           = $("#selectServicio2");
		var selectSalonCalendario     = $("#selectSalonCalendario");
		
		//Elemenos del modal Detalle servicio
		var modalServicio             = $("#txtModalServicio");
		var modalColaborador          = $("#txtModalColaborador");
		var modalDuracion             = $("#txtModalDuracion");
		var modalCliente              = $("#txtModalCliente");
		var modalSalon                = $("#txtModalSalon");
		var modalFecha                = $("#txtModalFecha");
		var modalUsuario              = $("#txtModalUsuario");
		var modalObservaciones        = $("#txtModalObservaciones");
		var btnActualizarModalDetalle = $("#btnActualizarModalDetalle");
		
		var btnServicioModal          = $("#btnServicioModal");
		var btnReporteExcel           = $("#btnReporteExcel");
		var btnReportePdf             = $("#btnReportePdf");
		
		var colaboradores             = new Array();
		var arrayCitas                = new Array();

		$("#calendar").fullCalendar({

			lang: 'es',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            eventLimit: true,
            eventLimitText: "Ver",
            droppable: false,
            timeFormat: "h:mm a",
		});
		
		//Algoritmo a ejecutar al hacer clic en Guardar
		btnAgendar.on("click", function(){

			if(((selectCliente.val() != null) && (selectCliente.val() != 0)) && ((selectSalon.val() != 0) || (selectSalon.val() != null)) && ((selectServicio.val() != 0) || (selectServicio.val() != null)) && (selectFecha.val() != 0) && (selectColaborador.val() != null)){

				$.ajax({
					url: 'php/citas/registrarCita.php',
					type: 'POST',
					data: 
					{
						cliente: selectCliente.val(),
						salon: $('#cod_salon').val(),
						servicio: selectServicio.val(),
						servicio2 : $('#ser_busqueda').val(),
						fechaAgendamiento: selectFecha.val(),
						colaborador: selectColaborador.val(),
						observaciones: txtObservaciones.val(),
						usuario: txtUsuario.val()
					},

					success: function(citaCreada)
					{

						var jsonCitaCreada = JSON.parse(citaCreada);

						if(jsonCitaCreada.result == "creada")
						{
							
							swal("Cita registrada", "Exitoso", "success");
							//location.reload();
							console.log(jsonCitaCreada.sql);
							actualizarCalendario();
							
						}
						else if(jsonCitaCreada.result == "duplicada")
						{
							swal("No se registró la cita", "El colaborador ya cuenta con una cita programada para la hora escogida.\n\n Revise el calendario antes de agendar una cita.", "error");

						} 
						else if (jsonCitaCreada.result == "almuerzo") 
						{
							swal("No se registró la cita", "Hora seleccionada coincide con la hora de descanso del colaborador.\n\n ","error");

							console.log(jsonCitaCreada.alm);
						}
						else if(jsonCitaCreada.result == "enpermiso"){

							swal("Error", "No se registró la cita porque el colaborador está en permiso.", "error");
						}
						else
						{
							swal("Error", "No se registró la cita hubo un error al ingresar.", "error");
						}
					}
				});
				
			}
			else{

				var errores = new Array();

				if((selectCliente.val() == null) || (selectCliente.val() == 0)){

					errores.push("Seleccione un cliente");
				}
				if((selectSalon.val() == 0) || (selectSalon.val() == null)){

					errores.push("Seleccione un sal\u00F3n");
				}
				if((selectServicio.val() == 0) || (selectServicio.val() == 0)){

					errores.push("Seleccione un servicio");
				}
				
				if((selectColaborador.val() == null) || (selectColaborador.val() == null)){

					errores.push("Seleccione un colaborador");
				}

				var i            = 0;
				var mensajeError = "";

				for(i = 0; i < errores.length; i++){

					mensajeError += errores[i]+"\n";
				}

				swal("Error", mensajeError, "error");
			}
		});

		$('[data-toggle="tooltip"]').tooltip();

		$("#inpFecha").datetimepicker({
			format: "YYYY-MM-DD HH:mm ",
			minDate: moment().format("YYYY-MM-DDTHH"),
			locale: "es",
		});

		$(".js-example-basic-single").select2();

		$("#s2id_autogen1_search").on("keyup", function(){

			//$(".select2-no-results").html("No se encontraron resultados");
			var cliente = $(this).val();

			$.ajax({
				url: 'php/citas/clientesAgendamiento.php',
				type: 'POST',
				data: "datoCliente="+cliente,

				success: function(data){

					var json = JSON.parse(data);

					if(json.result == "full")
					{

						var clientes = "";

						for(var datos in json.data){

							clientes += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombreCliente+" ("+json.data[datos].documento+")</option>";
						}

						selectCliente.html(clientes);
					}
					else{

						selectCliente.val("");
					}
				}
			});	
		});
		function getColaboradores() {
			var salon = selectSalon.val();
			var fechaHora = selectFecha.val();
			var servicio = selectServicio.val();
			$.ajax({
				type: "POST",
				url: "php/citas/FindClbForCitas.php",
				data: {sln: $('#cod_salon').val(), fecha: fechaHora, ser: servicio},
				success: function (res) {
					selectColaborador.html(res);
				}
			});
		}

$(document).ready(function() 
{
	load_colaboradores ();
});

		function load_colaboradores () 
		{
			$.ajax({
				url: 'php/citas/load_col.php',
				success: function (data) {
					$('#selectColaborador').html(data);
				}
			});
		}


		//Al seleccionar un servicio
		selectServicio.on("change", function(){
			getColaboradores();
			
		});
		selectSalon.on("change", function () {
			getColaboradores();
		});



		//Al selecionar una fecha
		selectFecha.on("blur", function(){
			getColaboradores();
			//$("#selectColaborador").val(null).trigger("change");
			//selectFecha.empty();
			$('#select2-chosen-3').html('SELECCIONE UN COLABORADOR');
			var fechaAgendamiento = $(this).val();
			var servicio = selectServicio.val();
			selectColaborador.attr("disabled", false);
			var colaboradores = selectColaborador.val();

			$.ajax({
				url: 'php/citas/fechaAgendamiento.php',
				type: 'POST',
				data: {
					fechaAgendamiento: fechaAgendamiento,
					servicio: servicio,
					colaboradores: colaboradores},

				success : function(data){
					//alert(data);
					var json = JSON.parse(data);

					if(json.result == "full"){

						var colaboradores = "";
						colaboradores += "<option selected disabled>Seleccione un colaborador</option>";

						for(var datos in json.data){

							colaboradores += "<option value='"+json.data[datos].codigoColaborador+"'>"+json.data[datos].nombreColaborador+"</option>";
			 			}
					colaboradores += "</optgroup>";
						selectColaborador.html(colaboradores);
					}
			}
			});
		});

		//Click en busqueda avanzada de servicio
		linkBusquedaServicio.on('click', function(){
			$('#modalBusquedaServicio').on('shown.bs.modal', function () {
  				
				selectSubgrupo.css("display", "none");
				$('#lbl_subgrupo').css("display", "none");

				selectLinea.css("display", "none");
				$('#lbl_linea').css("display", "none");

				selectSublinea.css("display", "none");
				$('#lbl_sublinea').css("display", "none");

				selectCaracteristica.css("display", "none");
				$('#lbl_car').css("display", "none");

				selectServicio2.css("display", "none");
				$('#lbl_ser').css("display", "none");

				$('#tabla_ser').css("display", "none");
			});

			if((selectSalon.val() == 0) || (selectSalon.val() == "")){

				swal({
					title: "Debe seleccionar el sal\u00F3n",
					confirmButtonText: "Aceptar",
					type: "warning"
				});
			}
			else{ 

				$.ajax({
					url: 'php/citas/obtenerGruposModalsServicio.php',

					success : function(grupos){

						var gruposEncontrados = "";
						var jsonGrupos = JSON.parse(grupos);

						if(jsonGrupos.result == "full"){

							gruposEncontrados = "<option disabled selected value'0'> Seleccione un grupo </option>";

							for(var i in jsonGrupos.grupos){

								gruposEncontrados += "<option value='" + jsonGrupos.grupos[i].codigo + "'>" + jsonGrupos.grupos[i].nombre + "</option>";
							}
						}
						else{

							gruposEncontrados = "<option disabled selected>---No hay grupos registrados---</option>";
						}

						selectSubgrupo.attr("disabled", true);
						selectLinea.attr("disabled", true);
						selectSublinea.attr("disabled", true);
						selectCaracteristica.attr("disabled", true);
						selectServicio2.attr("disabled", true);
						//btnServicioModal.attr("disabled", true);
						selectSubgrupo.val("");
						selectLinea.val("");
						selectSublinea.val("");
						selectCaracteristica.val("");
						selectServicio2.val("");
						selectGrupo.html(gruposEncontrados);
					}
				});
				$("#modalBusquedaServicio").modal("show");
			}
			
		});

		$(document).ready(function() {
			selectSubgrupo.css("display", "none");
			$('#lbl_subgrupo').css("display", "none");

			selectLinea.css("display", "none");
			$('#lbl_linea').css("display", "none");

			selectSublinea.css("display", "none");
			$('#lbl_sublinea').css("display", "none");

			selectCaracteristica.css("display", "none");
			$('#lbl_car').css("display", "none");

			selectServicio2.css("display", "none");
			$('#lbl_ser').css("display", "none");

			
		});

		//Obtener subgrupos al seleccionar grupo
		selectGrupo.on("change", function(){

			selectSubgrupo.css("display", "block");
            $('#lbl_subgrupo').css("display", "block");
			
			$.ajax({
				url: 'php/citas/obtenerSubgruposModalsServicio.php',
				data: {grupo: selectGrupo.val()},

				success : function(subgrupos){

					var subgruposEncontrados = "";
					var jsonSubgrupos = JSON.parse(subgrupos);

					if(jsonSubgrupos.result == "full"){

						subgruposEncontrados = "<option disabled selected>---Seleccione un sub-grupo---</option>";

						for(var i in jsonSubgrupos.subgrupos){

							subgruposEncontrados += "<option value='" + jsonSubgrupos.subgrupos[i].codigo + "'>" + jsonSubgrupos.subgrupos[i].nombre + "</option>";
						}
					}
					else{

						subgruposEncontrados = "<option disabled selected>---No hay sub-grupos registrados---</option>";
					}

					selectSubgrupo.attr("disabled", false);
					selectLinea.attr("disabled", true);
					selectSublinea.attr("disabled", true);
					selectCaracteristica.attr("disabled", true);
					selectServicio2.attr("disabled", true);
					//btnServicioModal.attr("disabled", true);
					selectLinea.val("");
					selectSublinea.val("");
					selectCaracteristica.val("");
					selectServicio2.val("");
					selectSubgrupo.html(subgruposEncontrados);
				}
			});
		});

		//Obtener lineas al seleccionar subgrupo
		selectSubgrupo.on("change", function(){	

			selectLinea.css("display", "block");
			$('#lbl_linea').css("display", "block");	

			$.ajax({
				url: 'php/citas/obtenerLineasModalsServicio.php',
				data: {subgrupo: selectSubgrupo.val()},

				success : function(lineas){

					var lineasEncontradas = "";
					var jsonLineas = JSON.parse(lineas);
					console.log(jsonLineas);

					if(jsonLineas.result == "full"){

						lineasEncontradas = "<option disabled selected>---Seleccione una líneas ---</option>";

						for(var i in jsonLineas.lineas){

							lineasEncontradas += "<option value='" + jsonLineas.lineas[i].codigo + "'>" + jsonLineas.lineas[i].nombre + "</option>";
						}
					}
					else{

						lineasEncontradas = "<option disabled selected>---No hay líneas registradas---</option>";
					}

					selectLinea.attr("disabled", false);
					selectCaracteristica.attr("disabled", true);
					selectServicio2.attr("disabled", true);
					//btnServicioModal.attr("disabled", true);
					selectCaracteristica.val("");
					selectServicio2.val("");
					selectLinea.html(lineasEncontradas);
				}
			});

		/*var gr = $("#selectSubgrupo option:selected").text();
		var cod_grupo = selectGrupo.val();


			$.ajax({
				url: 'php/citas/obtenerLineasModalsServicio.php',
				data: {subgrupo: selectSubgrupo.val(), gr:gr, cod_grupo:cod_grupo},
				success : function(data){

					$('#tabla_ser').html(data)

				}
			});*/
		});

		//Obtener sublineas al seleccionar linea
		selectLinea.on("change", function(){

			selectSublinea.css("display", "block");
			$('#lbl_sublinea').css("display", "block");

			$.ajax({
				url: 'php/citas/obtenerSublineasModalsServicio.php',
				data: {linea: selectLinea.val()},

				success : function(sublineas){

					var sublineasEncontradas = "";
					var jsonSublineas = JSON.parse(sublineas);

					if(jsonSublineas.result == "full"){

						sublineasEncontradas = "<option disabled selected>---Seleccione una sub-l&iacute;nea---</option>";

						for(var i in jsonSublineas.sublineas){

							sublineasEncontradas += "<option value='" + jsonSublineas.sublineas[i].codigo + "'>" + jsonSublineas.sublineas[i].nombre + "</option>";
						}
					}
					else{

						sublineasEncontradas = "<option disabled selected>---No hay sub-l&iacute;neas registradas---</option>";
					}

					selectSublinea.attr("disabled", false);
					selectCaracteristica.attr("disabled", true);
					selectServicio2.attr("disabled", true);
					//btnServicioModal.attr("disabled", true);
					selectCaracteristica.val("");
					selectServicio2.val("");
					selectSublinea.html(sublineasEncontradas);
				}
			});
		});

		//Obtener características al seleccionar sublinea
		selectSublinea.on("change", function(){

			selectCaracteristica.css("display", "block");
			$('#lbl_car').css("display", "block");

			$.ajax({
				url: 'php/citas/obtenerCaracteristicasModalsServicio.php',
				data: {sublinea: selectSublinea.val()},

				success : function(caracteristicas){

					var caracteristicasEncontradas = "";
					var jsonCaracteristicas = JSON.parse(caracteristicas);

					if(jsonCaracteristicas.result == "full"){

						caracteristicasEncontradas = "<option disabled selected>---Seleccione una caracter&iacute;stica---</option>";

						for(var i in jsonCaracteristicas.caracteristicas){

							caracteristicasEncontradas += "<option value='" + jsonCaracteristicas.caracteristicas[i].codigo + "'>" + jsonCaracteristicas.caracteristicas[i].nombre + "</option>";
						}
					}
					else{

						caracteristicasEncontradas = "<option disabled selected>---No hay caracter&iacute;sticas registradas---</option>";
					}

					selectCaracteristica.attr("disabled", false);
					selectServicio2.attr("disabled", true);
					//btnServicioModal.attr("disabled", true);
					selectServicio2.val("");
					selectCaracteristica.html(caracteristicasEncontradas);
				}
			});
		});

		//Obtener servicios al seleccionar característica
		selectCaracteristica.on("change", function(){

			selectServicio2.css("display", "block");
			$('#lbl_ser').css("display", "block");

			$.ajax({
				url: 'php/citas/obtenerServiciosModalsServicio.php',
				data: {caracteristica: selectCaracteristica.val()},

				success : function(servicios){

					var serviciosEncontrados = "";
					var jsonServicios        = JSON.parse(servicios);

					if(jsonServicios.result == "full"){

						serviciosEncontrados = "<option disabled selected>---Seleccione un servicio---</option>";

						for(var i in jsonServicios.servicios){

							serviciosEncontrados += "<option value='" + jsonServicios.servicios[i].codigo + "'>" + jsonServicios.servicios[i].nombre + " (Dur: " + jsonServicios.servicios[i].duracion + " min. aprox)</option>";
						}
					}
					else{

						serviciosEncontrados = "<option disabled selected>---No hay servicios registrados---</option>";
					}

					selectServicio2.attr("disabled", false);
					//btnServicioModal.attr("disabled", true);
					selectServicio2.html(serviciosEncontrados);
				}
			});
		});

		//Habilitar botón para escoger servicio
		selectServicio2.on("change", function(){
			//$('#btn_buscar_ser_mod').css("display", "none");

			//btnServicioModal.removeClass('disabled');
			//btnServicioModal.attr("disabled", false);
		});

		$(document).on('click', '#btn_buscar_ser_mod', function() {
			var grupo    = $('#selectGrupo').val();
			var subgrupo = $('#selectSubgrupo').val();
			var linea    = $('#selectLinea').val();
			var sublinea = $('#selectSublinea').val();
			var carac    = $('#selectCaracteristica').val();

			$.ajax({
				url: 'php/citas/mostrar_tabla_servicios.php',
				method: 'POST',
				data: {grupo: grupo, subgrupo: subgrupo, linea: linea, sublinea: sublinea, carac: carac},
				success: function (data) {
					$('#tabla_ser').css("display", "block");
					$('#tabla_ser').html(data);
				}
			});
		});

		//Indicar valor del servicioModal escogido al selectServicio
		btnServicioModal.on("click", function(){

			/*$("#s2id_selectServicio").text($("#selectServicio2 option:selected").text());
			$("#s2id_selectServicio").val(selectServicio2.val());*/

			$("#modalBusquedaServicio").modal("hide");
			$("#s2id_selectServicio").select2("destroy");
			selectServicio.html("<option selected value='"+$("#selectServicio2 option:selected").val()+"'>"+$("#selectServicio2 option:selected").text()+"</option>");
			$("#selectServicio").select2();
			obtenerColaborador($("#selectServicio2 option:selected").val(), selectSalon.val());
		});

		//Al seleccionar salón del panel Calendario
		/*selectSalonCalendario.on("change", function(){

			
		});*/

		$(document).ready(function() {
			actualizarCalendario();
		});
		
		//Al presionar la tecla Esc cuando esté abierto el modal Detalle cita
		$(document).bind('keydown',function(e){
			if ( e.which == 27 ) {
			   cerrarDetalleModal();
			}
		});

		//Editar servicio
		modalServicio.on("focus", limpiarServicio);

		//Editar salon
		modalSalon.on("focus", limpiarSalon);

		//Editar cliente
		modalCliente.on("focus", limpiarCliente);

		//Editar colaborador
		modalColaborador.on("focus", limpiarColaborador);

		//Editar fecha
		modalFecha.on("focus", limpiarFecha);

		//Editar observacion
		modalObservaciones.on("keypress", function(){

			if(modalSalon.attr("readonly") != "readonly"){

				btnActualizarModalDetalle.attr("disabled", false);
			}
		});

		$("#txtModalEstado").on("focus", limpiarEstado);

		/*Funciones para el reinicio de inputs del modal Detalle Cita*/		
		function limpiarSalon(){

			if(modalSalon.attr('readonly') != "readonly"){

				$("#txtModalSalon2").val(0);
				btnActualizarModalDetalle.attr("disabled", false);
				modalSalon.hide();
				$("#selectSalon2").css("display", "block");

				$.ajax({
					url: 'php/citas/obtenerDatosDetalleCita.php',
					data: {salonDetalle: true},
				})
				.done(function(salones) {
					
					var jsonSalones   = JSON.parse(salones);
					var optionSalones = "<option></option>";

					switch(jsonSalones.result){

						case "full":

							for(var i in jsonSalones.salones){

								optionSalones += "<option value='" + jsonSalones.salones[i].codigo + "'>" + jsonSalones.salones[i].nombre + " (" + jsonSalones.salones[i].direccion + ")</option>";
							}
						break;

						case "vacio":

							optionSalones = "<option selected disabled>No hay salones registrados en el sistema</option>";
						break;

						default:

							optionSalones = "<option selected disabled>Problemas al obtener los salones</option>";
						break;
					}
					$("#selectSalon2").html(optionSalones);
					$("#selectSalon2").select2({
						placeholder: "Seleccione el nuevo salón",
						allowClear: true
					});
				});

			}
		}

		function limpiarServicio(){

			if(modalServicio.attr('readonly') != "readonly"){

				$("#txtModalServicio2").val(0);
				btnActualizarModalDetalle.attr("disabled", false);
				modalServicio.hide();
				$("#selectServicio3").css("display", "block");

				$.ajax({
					url: 'php/citas/obtenerDatosDetalleCita.php',
					data: {servicioDetalle: true},
				})
				.done(function(servicios){
					
					var jsonServicios   = JSON.parse(servicios);
					var optionServicios = "<option></option>";
					switch(jsonServicios.result){

						case "full":

							for(var i in jsonServicios.servicios){

								optionServicios += "<option value='" + jsonServicios.servicios[i].codigo +"'>" + jsonServicios.servicios[i].nombre + " (Dur. " + jsonServicios.servicios[i].duracion + " min.)</option>";
			
							}
						break;

						case "vacio":

							optionServicios = "<option selected disabled>No hay servicios registrados en el sistema</option>";
						break;

						default:

							optionServicios = "<option selected disabled>Problemas al obtener los servicios</option>";
						break;
					}
					$("#selectServicio3").html(optionServicios);
					$("#selectServicio3").select2({
						placeholder: "Seleccione el nuevo servicio",
						allowClear: true
					});
				});
			}
		}

		function limpiarCliente(){

			if(modalCliente.attr('readonly') != "readonly"){

				$("#txtModalCliente2").val(0);
				btnActualizarModalDetalle.attr("disabled", false);
				modalCliente.hide();
				$("#selectCliente2").css("display", "block");

				$.ajax({
					url: 'php/citas/obtenerDatosDetalleCita.php',
					data: {clienteDetalle: true},
				})
				.done(function(clientes){
					
					var jsonClientes   = JSON.parse(clientes);
					var optionClientes = "<option></option>";
					
					switch(jsonClientes.result){

						case "full":

							for(var i in jsonClientes.clientes){

								optionClientes += "<option value='" + jsonClientes.clientes[i].codigo +"'>" + jsonClientes.clientes[i].nombre + " (" + jsonClientes.clientes[i].documento + ")</option>";
							}
						break;

						case "vacio":

							optionClientes = "<option selected disabled>No hay clientes registrados en el sistema</option>";
						break;

						default:

							optionClientes = "<option selected disabled>Problemas al obtener los clientes</option>";
						break;
					}
					$("#selectCliente2").html(optionClientes);
					$("#selectCliente2").select2({
						placeholder: "Seleccione el nuevo cliente",
						allowClear: true
					});
				});
			}
		}

		function limpiarColaborador(){

			if(modalColaborador.attr('readonly') != "readonly"){

				$("#txtModalColaborador2").val(0);
				btnActualizarModalDetalle.attr("disabled", false);
				modalColaborador.hide();
				$("#selectColaborador2").css("display", "block");

				$.ajax({
					url: 'php/citas/obtenerDatosDetalleCita.php',
					data: {
							colaboradorDetalle: true,
							salon: $("#txtModalSalon2").val(),
							servicio: $("#txtModalServicio2").val()
						},
				})
				.done(function(colaboradores){
					
					var jsonColaboradores   = JSON.parse(colaboradores);
					var optionColaboradores = "<option></option>";
					
					switch(jsonColaboradores.result){

						case "full":

							for(var i in jsonColaboradores.colaboradores){

								optionColaboradores += "<option value='" + jsonColaboradores.colaboradores[i].codigo +"'>" + jsonColaboradores.colaboradores[i].nombre + "</option>";
							}
						break;

						case "vacio":

							optionColaboradores = "<option selected disabled>No hay colaboradores disponibles</option>";
						break;

						default:

							optionColaboradores = "<option selected disabled>Problemas al obtener los colaboradores</option>";
						break;
					}
					$("#selectColaborador2").html(optionColaboradores);
					$("#selectColaborador2").select2({
						placeholder: "Seleccione el nuevo colaborador",
						allowClear: true
					});
				});
			}
		}

		function limpiarFecha(){

			if(modalFecha.attr('readonly') != "readonly"){

				btnActualizarModalDetalle.attr("disabled", false);
				modalFecha.hide();
				$("#txtModalFecha2").datetimepicker({
					format: "YYYY-MM-DD HH:mm ",
					minDate: moment().format("YYYY-MM-DDTHH"),
					locale: "es",
				});
				$("#txtModalFecha2").val("");
				$("#txtModalFecha2").attr("placeholder", "Seleccione la nueva fecha");
				$("#txtModalFecha2").show();
			}
		}

		function limpiarEstado(){

			if($("#txtModalEstado").attr("readonly") != "readonly"){

				btnActualizarModalDetalle.attr("disabled", false);
				$("#txtModalEstado").hide();
				$("#txtModalEstado2").val(0);
				$("#selectEstado2").show();
			}
		}
		/*Fin funciones para el reinicio de inputs*/


		//Al seleccionar nuevo salon de modal Detalle cita
		$("#selectSalon2").on("change", function(){			
			$("#txtModalSalon2").val($(this).val());
		});

		//Al seleccionar nuevo servicio de modal Detalle cita
		$("#selectServicio3").on("change", function(){

			var duracion = $("#selectServicio3 option:selected").text().split("(Dur. ");
			$("#txtModalServicio2").val($(this).val());
			duracion = duracion[1].substring(0, duracion[1].length - 1);
			$("#txtModalDuracion").text("Duraci\u00F3n: " + duracion + " aprox.");
		});

		//Al seleccionar nuevo cliente de modal Detalle cita
		$("#selectCliente2").on("change", function(){

			$("#txtModalCliente2").val($(this).val());
		});

		//Al seleccionar nuevo colaborador de modal Detalle cita
		$("#selectColaborador2").on("change", function(){

			$("#txtModalColaborador2").val($(this).val());
		});

		//Al seleccionar nuevo estado de modal Detalle cita
		$("#selectEstado2").on("change", function(){

			$("#txtModalEstado2").val($(this).val());
		});

		//Al hacer click en Actualizar
		btnActualizarModalDetalle.on("click", function(){

			var nuevoSalon       = $("#txtModalSalon2");
			var nuevoServicio    = $("#txtModalServicio2");
			var nuevoCliente     = $("#txtModalCliente2");
			var nuevoColaborador = $("#txtModalColaborador2");
			var nuevaFecha       = $("#txtModalFecha2");
			var nuevaObservacion = $("#txtModalObservaciones");
			var nuevoEstado      = $("#txtModalEstado2");
			var antiguoEstado    = $("#txtModalEstado3");
			var usuario          = $("#txtUsuario");
			
			if((nuevoSalon.val() != 0) && (nuevoServicio.val() != 0) && (nuevoCliente.val() != 0) && (nuevoColaborador.val() != 0) && (nuevaFecha.val() != "") && (nuevoEstado.val() != 0)){

				$.ajax({
					url: 'php/citas/actualizarCita.php',
					type: 'POST',
					data: {
						codCitaActual: $("#txtModalCita").val(),
						nuevoSalon: nuevoSalon.val(),
						nuevoServicio: nuevoServicio.val(),
						nuevoCliente: nuevoCliente.val(),
						nuevoColaborador: nuevoColaborador.val(),
						nuevaFecha: nuevaFecha.val(),
						nuevaObservacion: nuevaObservacion.val(),
						antiguoEstado: antiguoEstado.val(),
						nuevoEstado: nuevoEstado.val(),
						usuario: usuario.val()
					},
				})
				.done(function(nuevaCita) {
			
					var jsonNuevaCita = JSON.parse(nuevaCita);

					if(jsonNuevaCita.result == "actualizada"){

						$("#modalDetalleCita").modal("hide");
						cerrarDetalleModal();
						swal({
							title: "La cita ha sido actualizada",
							type: "success",
							confirmButtonText: "Aceptar"
						}, function(){

							$("#selectEstado2").prop("selectedIndex", 0);
							actualizarCalendario();
						});
					}
					else if(jsonNuevaCita.result == "duplicada"){
						
						$("#modalDetalleCita").modal("hide");
						cerrarDetalleModal();
						swal({
							title: "No se actualiz\u00F3 la cita",
							text: "Debido a que no realiz\u00F3 nin\u00FAn cambio en los datos",
							type: "warning",
							confirmButtonText: "Aceptar"
						});						
					}
					else{

						$("#modalDetalleCita").modal("hide");
						swal({
							title: "Error",
							text: "Problemas al actualizar la cita",
							type: "error",
							confirmButtonText: "Aceptar"
						}, function(){

							$("#modalDetalleCita").modal("show");
						});
					}
				});
			}
			else{

				//var errores      = new Array();
				var errores = [];
				var mensajeError = "";

				if(nuevoSalon.val() == 0){

					errores.push("Seleccione el nuevo sal\u00F3n");
				}

				if(nuevoServicio.val() == 0){

					errores.push("Seleccione el nuevo servicio");
				}

				if(nuevoCliente.val() == 0){

					errores.push("Seleccione el nuevo cliente");
				}

				if(nuevoColaborador.val() == 0){

					errores.push("Seleccione el nuevo colaborador");
				}

				if($("#txtModalFecha2").val() == ""){

					errores.push("Seleccione la nueva fecha");
				}

				if(nuevoEstado.val() == 0){

					errores.push("Seleccione el nuevo estado");
				}

				for(var i in errores){

					mensajeError += errores[i] + "\n";
				}

				$("#modalDetalleCita").modal("hide");
				swal({
					title: "Error",
					text: mensajeError,
					type: "error",
					confirmButtonText: "Aceptar"
				}, function(){

					$("#selectEstado2").prop("selectedIndex", 0);
					$("#modalDetalleCita").modal("show");
				});
			}
			//cerrarDetalleModal();
		});

		//Al hacer click en el botón Excel para generar reporte
		btnReporteExcel.on("click", function(){

			window.open("http://192.168.1.202/beauty-pdv/php/citas/generarReporteCitas.php?tipoReporte=excel&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#cod_salon").val());
			//window.open("http://beautyerp.claudiachacon.com/dev/app_final/generarReporteCitas.php?tipoReporte=excel&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#selectSalonCalendario").val());
		});

		//Al hacer click en el botón Pdf para generar reporte
		btnReportePdf.on("click", function(){	

			window.open("http://192.168.1.202/beauty-pdv/php/citas/generarReporteCitas.php?tipoReporte=pdf&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#cod_salon").val());
			//window.open("http://beautyerp.claudiachacon.com/dev/app_final/generarReporteCitas.php?tipoReporte=pdf&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#selectSalonCalendario").val());
		});
	});

//Colocar el Calendario de citas en blanco
function restablecerCalendario(){

	$("#calendar").fullCalendar("destroy");
	$("#calendar").fullCalendar({

		lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        eventLimit: true,
        droppable: false,
        timeFormat: "h:mm a"
	});
}

//Habilitar la edición de campos de cita
function habilitarEdicionCampos(codServicio){

	var modalServicio          = $("#txtModalServicio");
	var modalColaborador       = $("#txtModalColaborador");
	var modalDuracion          = $("#txtModalDuracion");
	var modalCliente           = $("#txtModalCliente");
	var modalSalon             = $("#txtModalSalon");
	var modalFecha             = $("#txtModalFecha");
	var modalUsuario           = $("#txtModalUsuario");
	var modalObservaciones     = $("#txtModalObservaciones");
	var btnActualizarModalDetalle = $("#btnActualizarModalDetalle");
	$('#codiservicio').val(codServicio);
	//alert(codServicio);
	$("#btnCerrarModalDetalle").text("Cancelar");
	$("#subtituloModalDetalle").css("display", "none");
	btnActualizarModalDetalle.css("display", "inline");
	modalServicio.removeAttr("readonly");
	modalColaborador.removeAttr("readonly");
	//modalCliente.removeAttr("readonly");
	//modalSalon.removeAttr("readonly");
	modalFecha.removeAttr("readonly");
	modalObservaciones.removeAttr("readonly");
	$("#txtModalEstado").removeAttr("readonly");
	$('#pfechavigente').css("display","block");
	$('#pestadovigente').css("display", "block");
}





function cerrarDetalleModal(){
	
	var modalServicio          = $("#txtModalServicio");
	var modalColaborador       = $("#txtModalColaborador");
	var modalDuracion          = $("#txtModalDuracion");
	var modalCliente           = $("#txtModalCliente");
	var modalSalon             = $("#txtModalSalon");
	var modalFecha             = $("#txtModalFecha");
	var modalUsuario           = $("#txtModalUsuario");
	var modalObservaciones     = $("#txtModalObservaciones");
	var btnActualizarModalDetalle = $("#btnActualizarModalDetalle");
	$("#btnCerrarModalDetalle").text("Cerrar");
	btnActualizarModalDetalle.css("display", "none");
	btnActualizarModalDetalle.attr("disabled", true);
	$("#subtituloModalDetalle").css("display", "inline");
	modalServicio.attr('readonly', true);
	modalColaborador.attr('readonly', true);
	modalCliente.attr('readonly', true);
	modalSalon.attr('readonly', true);
	modalFecha.attr('readonly', true);
	$("#txtModalEstado").attr("readonly", true);
	modalObservaciones.attr('readonly', true);
	$("#s2id_selectSalon2").hide();
	$("#s2id_selectServicio3").hide();
	$("#s2id_selectCliente2").hide();
	$("#s2id_selectColaborador2").hide();
	$("#txtModalFecha2").hide();
	$("#selectEstado2").hide();
	$("#selectColaborador2").hide();
	modalSalon.show();
	modalServicio.show();
	modalCliente.show();
	modalColaborador.show();
	modalFecha.show();
	$("#txtModalEstado").show();
}






$(document).on('click', '#btn_add_servicio', function () {
	var id = $(this).data("idcod");

	$.ajax({
		url: 'php/citas/servicio_busqueda.php',
		method: 'POST',
		data: {id:id},
		success: function (data) {
			$('#selectServicio').select2('destroy').remove();
			$('#ser_busqueda').css("display", "block").html(data);
			$('#modalBusquedaServicio').modal("hide");

			//$('#modalBusquedaServicio').on('shown.bs.modal', function () {
  				
				selectSubgrupo.css("display", "none");
				$('#lbl_subgrupo').css("display", "none");

				selectLinea.css("display", "none");
				$('#lbl_linea').css("display", "none");

				selectSublinea.css("display", "none");
				$('#lbl_sublinea').css("display", "none");

				selectCaracteristica.css("display", "none");
				$('#lbl_car').css("display", "none");

				selectServicio2.css("display", "none");
				$('#lbl_ser').css("display", "none");

				$('#tabla_ser').css("display", "none");
			//});


	
		}
	});
});

$(document).on('click', '#btn_modal_buscar_col', function() {
	$(".colbuscar").select2();
	$('#modalColaborador_busqueda').on('shown.bs.modal', function () {



	
	var codigo_colaborador =  $('#selectColaborador').val();
        $('#calendario').fullCalendar({
        eventClick: function(calEvent, jsEvent, view) {
            var trn = calEvent.id;
            var fecha = new Date(calEvent.start);
            y = fecha.getFullYear();
            m = fecha.getMonth();
            m++;
            d = fecha.getDate();
            var fecha_turno = y+"-"+m+"-"+d;
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            $.ajax({
                type: "POST",
                url: "php/citas/find_col_on_turn.php",
                data: {id_turno: trn, fch: fecha_turno},
                success: function(data) {
                    console.log(data);
                }
            });
            $('#my_modal').modal('show'); 
            // change the border color just for fun
            $(this).css('border-color', 'red');
        },
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: "php/citas/find_progra.php?sln="+$('#cod_salon').val()+"&p=clb&codigo="+codigo_colaborador //carga las programaciones existentes

        
    });
});
});

/*$(document).on('change', '#selColSearch', function() 
{
	alert("K");
});
*/



	
$(document).on('click', '#bn_clean_cal', function() {
  	$('#tabla_prog_col').fullCalendar('destroy');
  	$('#tabla_prog_col').empty();
});



    $(document).ready(function() {
        $(document).on('click', '.selector', function(event) {
            var url = $(this).data("url");
            var res = url.substr(19); 
            
            $.ajax({
                url: 'bloquear_pantalla.php',
                method: 'POST',
                data: {url:url},
                success: function (data) 
                {
          
                    window.location="bloquear_pantalla.php?url="+res+"";
                }
            });
        });
    });


$(document).on('blur', '#txtModalFecha2', function() 
{
	 var oldservice	   	= $('#codiservicio').val();
	 var newservice    	= $('#txtModalServicio2').val();
	 var olddate        = $('#txtModalFecha').val();
	 olddate 			= olddate.replace(/["'()]/g,"");
	 var newdate        = $('#txtModalFecha2').val();
	 newdate 			= newdate.replace(/["'()]/g,"");

	 $.ajax({
	 	url: 'php/citas/FindColDisponible.php',
	 	method: 'POST',
	 	data: {fecha:olddate, newdate:newdate, oldservice:oldservice, newservice:newservice},
	 	success: function (data) 
	 	{
	 		$('#txtModalColaborador').css("display", "none"); 
	 		$('#selectColaborador2').html('');		
	 		$('#selectColaborador2').css("display", "block").html(data);
	 	}
	 });

});



$("#selectServicio3").on("change", function () 
{ 
	var olddate         = $('#txtModalFecha').val();
	olddate 			= olddate.replace(/["'()]/g,"");
	var oldservice	    = $(this).val();

	$.ajax({
		url: 'php/citas/FindColDiponibleFecha.php',
		method: 'POST',
	 	data: {fecha:olddate, oldservice:oldservice},
	 	success: function (data)
	 	{
	 		$('#txtModalColaborador').css("display", "none"); 
	 		$('#selectColaborador2').html('');		
	 		$('#selectColaborador2').css("display", "block").html(data);
	 	}

	});
});

$(document).on('click', '#txtModalColaborador', function() 
{
    alert("OK");
});

/*==============================================
=            INICIAR SERVICIO BOTON            =
==============================================*/

/*$(document).ready(function() 
{

	$(document).on('change', '#selectEstado2', function() 
	{
		var clbcodigo = $('#txtModalColaborador2').val();
		var salon  = $('#cod_salon').val();
		$.ajax({
			url: 'php/sube_baja/colaSubeBaja.php',
			method: 'POST',
			data: {clbcodigo: clbcodigo, slncodigo: salon},
			beforeSend: function() 
			{
				$.blockUI({ message: '<h1>Espere un momento...</h1>' });
			},
			success: function (data) 
			{
			 	ListarCola();
			 	$(document).ajaxStop($.unblockUI);
			}
		}); 
	});
});*/

/*=====  End of INICIAR SERVICIO BOTON  ======*/


function validarCol (clbcodigo) 
{

	$.ajax({
		url: 'php/citas/validarCita.php',
		method: 'POST',
		data: {clbcodigo:clbcodigo, opcion: "validarCol"},
		success: function (data) 
		{
			if (data == 1) 
			{
				$('#btniniciarser').attr("disabled", false);
			}
			else
			{
				$('#btniniciarser').attr("id", "btnterminarser").html("Terminar Servicio");	
				$('#btnhabil').css("display","none");			
			}
		}
	});
}


$(document).ready(function() 
{

	$(document).on('click', '#btniniciarser', function() 
	{
		var clbcodigo = $('#txtModalColaborador2').val();
		var salon     = $('#cod_salon').val();
		$.ajax({
			url: 'php/sube_baja/colaSubeBaja.php',
			method: 'POST',
			data: {clbcodigo: clbcodigo, slncodigo: salon},
			beforeSend: function() 
			{
				$.blockUI({ message: '<h1>Espere un momento...</h1>' });
			},
			success: function (data) 
			{
			 	ListarCola();
			 	actualizarCalendario();
			 	$(document).ajaxStop($.unblockUI);
			 	validarCol(clbcodigo);
			 	$('#btnActualizarModalDetalle').attr("disabled", false);
			 	$('#btnActualizarModalDetalle').css("display", "inline");
			 	$('#txtModalEstado').val('EN CURSO');
			 	$('#txtModalEstado2').val('8');
			 	$('#btnhabil').css("display","none");
			}
		}); 
	});
});


$(document).on('click', '#btnterminarser', function() 
{
		var clbcodigo = $('#txtModalColaborador2').val();
		var salon     = $('#cod_salon').val();
		$.ajax({
			url: 'php/sube_baja/colaSubeBaja.php',
			method: 'POST',
			data: {clbcodigo: clbcodigo, slncodigo: salon},
			beforeSend: function() 
			{
				$.blockUI({ message: '<h1>Espere un momento...</h1>' });
			},
			success: function (data) 
			{
			 	ListarCola();
			 	$(document).ajaxStop($.unblockUI);
			 	validarCol(clbcodigo);
			 	actualizarCalendario();
			 	$('#btnActualizarModalDetalle').attr("disabled", false);
			 	$('#btnActualizarModalDetalle').css("display", "inline");
			 	$('#txtModalEstado').val('TERMINADA');
			 	$('#txtModalEstado2').val('9');
			 	$('#btnhabil').css("display","none");
			 	$('#btnterminarser').html("Cita Terminada").addClass('btn-info').attr("disabled", true);
			}
		}); 
});

function validarCitater (cita) 
{
	$.ajax({
		url: 'php/citas/validarCita.php',
		method: 'POST',
		data: {cita:cita, opcion: "citaTerminada"},
		success: function (data) 
		{
			if (data == 1) 
			{
				$('#btniniciarser').html('');
				$('#btniniciarser').html("Cita Terminada").addClass('btn-info').attr("disabled", true);
			}
			else
			{
				$('#btniniciarser').html('');
				$('#btniniciarser').html("Iniciar servicio").removeClass('btn-info').addClass('btn-success');
				//$('#btniniciarser').attr("id", "btnterminarser").html("Terminar Servicio");
			}
		}
	});
}


/*function validarTiempo () 
{
	$.ajax({
		url: 'php/citas/validarCita.php',
		method: 'POST',
		data: {opcion: "encurso"},
		success: function (data) 
		{
			
		}
	});
}*/



/*=============================================
=            ListCola en Sube Baja            =
=============================================*/

function ListarCola()
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
						

				for(var i in jsonColaboradores.colaboradores)
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
/*=====  End of ListCola en Sube Baja  ======*/
