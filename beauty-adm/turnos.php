<?php 
	/*include 'head.php';
	include "../cnx_data.php";*/
	 VerificarPrivilegio("TURNOS", $_SESSION['tipo_u'], $conn);
?>
<meta charset="utf-8">

	<!-- Modal para selección de salón -->
	<div class="modal fade" id="modalSelectSalon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="myModalLabel">Seleccione un Salón</h4>
      </div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<select name="selectSalon" id="selectSalon" class="form-control input-sm">
											
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="content animate-panel">
				<div class="row">
				<input type="hidden" id="ipt_salon" value="">
					<div class="hpanel">
						<div class="panel-heading">
				            <div class="panel-tools">
				                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
				           </div>
				            <p>SUBE Y BAJA</p>

				            <div class="btn-group" role="group" aria-label="...">
							  <button type="button" data-toggle="modal" data-target="#modalIniciSubeBaja" class="btn btn-info btn_init_queue" id="btn_inicializar_cola" title="Colaboradores"><i class="fa fa-users" aria-hidden="true" ></i> </button>
							  <button type="button" data-toggle="modal" data-target="#modal_cerrar_sube_baja" id="btn_cerrar_syb" class="btn btn-danger pull-right" title="Cerrar Sube y Baja"><i class="fa fa-times"></i> </button>
							</div>
	
				            <!-- <div class="row"><button type="button" data-toggle="modal" data-target="#modalIniciSubeBaja" class="btn btn-info" id="btn_inicializar_cola"><i class="fa fa-users" aria-hidden="true"></i> Colaboradores </button><button type="button" data-toggle="modal" data-target="#modal_cerrar_sube_baja" id="btn_cerrar_syb" class="btn btn-danger pull-right"><i class="fa fa-times"></i> Cerrar Sube y Baja</button></div> -->
				        </div>
						<div class="panel-body panel_subebaja" style="display: none;" id="subeBaja">
							<ol class="listaColaboradores" id="listaSubeBaja" style="list-style: none">
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalServicios" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Servicios del colaborador</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-3">
							<img src="./imagenes/default.jpg" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="100" height="100">
						</div>
						<div class="col-xs-9">
							<div class="col-sm-12">
								<input type="text" id="txtCodigoColaborador" readonly style="display: none;">
							</div>
							<div class="col-sm-12">
								<p id="nombreColaboradorServicio"></p>
							</div>
							<div class="col-sm-12">
								<p id="cargoColaboradorServicio"></p>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
								<label class="control-label">Buscar servicio</label>
								<div class="input-group">
									<input type="search" placeholder="Nombre del servicio" id="txtBuscarServicio" class="form-control input-sm">
									<div class="input-group-addon">
										<span class="fa fa-search text-info"></span>	
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th>Servicio</th>
											<th>Caracter&iacute;stica</th>
											<th>Duraci&oacute;n</th>
										</tr>
									</thead>
									<tbody id="tablaServicios">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

<!-- Modal Inicializar Sube y Baja -->
<div class="modal fade" id="modalIniciSubeBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Colaboradores</h4>
      </div>
      <div class="modal-body">
        	<div class="table-responsive" id="tablaSubeyBaja">
				<table class="table table-hover table-bordered tabla_colaborador">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Turno</th>
							<th>Añadir a Cola</th>
							<th>Terminar Turno</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_reset" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_comentar" data-toggle="modal" data-target="#modalComentariosIniciales" class="btn btn-primary">Comentarios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Comentarios Iniciales -->
<div class="modal fade" id="modalComentariosIniciales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Comentarios Iniciales Sube y Baja</h4>
      </div>
      <div class="modal-body">
        	<textarea name="" id="txt_comentario_inicial" class="form-control" rows="3"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_guardar_comentario" class="btn btn-info"><i class="fa fa-paper-plane"></i> Guardar comentario</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cerrar Sube y Baja -->
<div class="modal fade" id="modal_cerrar_sube_baja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Finalizar Sube y Baja</h4>
      </div>
      <div class="modal-body">
      		<p>Observaciones al iniciar Sube y Baja</p>
        	<p><textarea name="" id="txt_comentario_subebaja_inicial" class="form-control" rows="2" disabled="disabled"></textarea></p>
        	<p>Escriba sus Observaciones para Finalizar Sube y Baja</p>
        	<p><textarea name="" id="txt_comentario_subebaja_final" class="form-control" rows="2"></textarea></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_finalizar" class="btn btn-primary">Finalizar Sube y Baja</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php 
	include 'librerias_js.php';
?>

<script type="text/javascript">

        $("#modalSelectSalon").modal({

            backdrop: 'static',

            keyboard: false

        });

$(document).ready(function() {
	    var modalSelectSalon = $("#modalSelectSalon");
		var selectSalon      = $("#selectSalon");
		load_salones ();
		modalSelectSalon.modal("show");

		$('#modalComentariosIniciales').on('shown.bs.modal', function () {
  			$('#txt_comentario_inicial').focus()
		});

		$('#modal_cerrar_sube_baja').on('shown.bs.modal', function () {
  			$('#txt_comentario_subebaja_final').focus()
		});

		$('[title]').tooltip();

		


		/*======================================
		=            Cargar Salones            =
		======================================*/
		
		function load_salones () {
			$.ajax({
	            url: 'cargar_Salones.php',
	            success: function(data){
	            $('#selectSalon').html(data);	
	           }
			});
		}
		
		/*=====  End of Cargar Salones  ======*/		


		
		

		/*================================================
		=            Cargar cola Programación            =
		================================================*/
		
		$(document).on('change', '#selectSalon', function(){
				var a = $('#selectSalon').val();
				$('#ipt_salon').val(a);
				restaurarCola();
				load_TurnosAtencion ();
				//$('#select_programacion').css("display","block");

		});		
		
		/*=====  End of Cargar cola Programación  ======*/

		/*=============================================
		=            CargarTurnos Atencion            =
		=============================================*/
		
		function load_TurnosAtencion () {
			var salon_turno = $('#ipt_salon').val();
			$.ajax({
				url: 'cargar_turnos_atencion.php',
				method:'POST',
				data: {salon_turno:salon_turno},
				success: function (data) {
					if (data == 1) {
						swal({
							title: "Error",
							text: "Ya se ha creado un Sube y Baja.",
							type: "error",
							confirmButtonText: "Aceptar"
						}, function(){	
							$.ajax({
								url: 'disabled_buttons.php',
								method: 'POST',
								data: {salon_turno:salon_turno},
								success: function (data) {
									//alert(data);
									if (data == 2) {
										$('#btn_inicializar_cola').prop("disabled", true);
									}
								}
							});						
							$('#modalIniciSubeBaja').modal("hide");
							//$('#btn_inicializar_cola').prop("disabled", true);
							//$('#btn_cerrar_syb').prop("disabled", true);
							
						});
					}else{
						if (data == 2) {
							swal({
							title: "Exitoso",
							text: "Se ha creado Sube y Baja.",
							type: "success",
							confirmButtonText: "Aceptar"
						});
						}
					}
					
				}
			});
		}
		
		/*=====  End of CargarTurnos Atencion  ======*/
		
		

		/*======================================
		=            Restaurar Cola            =
		======================================*/
		
		function restaurarCola(){
				
			$.ajax({
				url: 'colaboradoresSalonTurno.php',
				data: {codSalon: selectSalon.val()},

			}).done(function(colaboradores) {
					
					var jsonColaboradores = JSON.parse(colaboradores);

						if(jsonColaboradores.result == "full"){

							var listaColaboradores = "";
							var codigo             = "";
							var nombre             = "";
							var categoria          = "";
							var cargo              = "";
							var imagen             = "";
							var posicion           = "";

								for(i in jsonColaboradores.colaboradores){

									codigo   = jsonColaboradores.colaboradores[i].codigo;
									nombre   = jsonColaboradores.colaboradores[i].nombre;
									posicion = jsonColaboradores.colaboradores[i].posicion;
									estado   = jsonColaboradores.colaboradores[i].estado;
									cargo    = jsonColaboradores.colaboradores[i].cargo;

								switch (jsonColaboradores.colaboradores[i].categoria) {
								
								case "JUNIOR":
									categoria = "<label class='label label-danger'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								case "SENIOR":
									categoria = "<label class='label label-primary'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;
								
								case "GOLD":
									categoria = "<label class='label label-warning'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								case "PLATINUM":
									categoria = "<label class='label label-default'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								default:
									categoria = "";
									break;
							}

							if(jsonColaboradores.colaboradores[i].imagen == "default.jpg"){

								imagen = "./imagenes/default.jpg";
							}
							else{

								imagen = "./imagenes/colaborador/" + jsonColaboradores.colaboradores[i].imagen;
							}

							listaColaboradores += "<li id='"+codigo+"' data-posicion='"+posicion+"' class='listaColaboradores' style='margin: 3px'>";

							if(estado == 1){

								listaColaboradores += "<div class='row' style='background-color: #EFF0F1; margin: 0px 0; padding: 7px 0; border-radius: 6px'>";
							}
							else{

								listaColaboradores += "<div class='row' style='background-color: #ffdada; margin: 0px 0; padding: 7px 0; border-radius: 6px'>";
							}


							listaColaboradores += "<div class='col-xs-2 col-sm-1'><img width='120' height='120' src='" + imagen + "' class='img-thumbnail m-b'></div><div class='col-xs-10 col-sm-11'><div class='col-xs-12'><strong>" + nombre + " </strong>" + categoria + "</div><button class='btn btn-info btn-sm pull-right' type='button' id='btn_mover' data-cod='"+codigo+"' data-estado'"+estado+"' data-pos='"+posicion+"' title='Click para mover colaborador.'> <i class='fa fa-arrow-down' aria-hidden='true'></i></button><button class='btn btn-warning btn-sm pull-right' type='button' id='btn_mover_disponible' data-cod='"+codigo+"' style='margin-right:13px' title='Click para cambiar estado.'> <i class='fa fa-check' aria-hidden='true'></i></button><div class='col-xs-12'>" + cargo + "</div><div class='col-xs-12'><button type='button' onclick='mostrarServicios(" + codigo + ", \"" + nombre + "\", \"" + jsonColaboradores.colaboradores[i].categoria + "\", \"" + cargo + "\", \"" + imagen + "\")' class='btn btn-circle btn-default text-info'><i class='fa fa-scissors'></i></button></div></div></div></li>";
						}

						$("#listaSubeBaja").html(listaColaboradores);
						$("#subeBaja").fadeIn("fast");
						modalSelectSalon.modal("hide");
					}
					else if(jsonColaboradores.result == "vacio"){						
						modalSelectSalon.modal("hide");
						loadModal ();

					/*	swal({
							title: "Precaución",
							text: "No hay colaboradores en turno para el salón seleccionado.",
							type: "warning",
							confirmButtonText: "Aceptar"
						}, function(){
							loadModal ();
							//modalSelectSalon.modal("show");
						});	*/				
					}
					else{

						modalSelectSalon.modal("hide");
						swal({
							title: "Error",
							text: "Problemas al obtener colaboradores del sal\u00F3n seleccionado",
							type: "error",
							confirmButtonText: "Aceptar"
						}, function(){
							//$('#select_programacion').css("display","none");
							modalSelectSalon.modal("show");
						});
					}
				});			
			}


			/*===========================================
				=            Boton mover           =
				===========================================*/
				
				$(document).on('click', '#btn_mover', function(){
					var codigo = $(this).data("cod");
					var pos = $(this).data("pos");
					var salon = $('#ipt_salon').val();
					console.log(codigo + " y el cod de salon es " + salon +" y la pos actual "+pos);

						

					  	$("#" +codigo).appendTo('#listaSubeBaja');

					  	$.ajax({
							url: 'colaSubeBaja.php',
							data: {
							codColaborador: codigo,
							ultimaPosicion: pos,
							salon: salon
							}
						})
						.done(function() {				
							restaurarCola();
						});		  			  		

				});	
				
				/*=====  End of Boton mover ocupado  ======*/	


			/*=================================================
			=            Buscar en input servicios            =
			=================================================*/
			
			$("#txtBuscarServicio").on("keyup", function(){

					codColaborador = $("#txtCodigoColaborador");
					$.ajax({
						url: 'serviciosColaboradorTurnos.php',
						data: {
							buscar: 'si', 
							codColaborador: codColaborador.val(), 
							nombreServicio: $(this).val()},
					})
					.done(function(servicios){
						
						var jsonServicios= JSON.parse(servicios);
					
						if(jsonServicios.result == "full"){

							var nombreServicio;
							var caracteristica;
							var duracion;
							var alias;
							var precioFijo;
							var servicios = "";

							for(i in jsonServicios.servicios){
								
								nombreServicio = jsonServicios.servicios[i].nombre;
								caracteristica = jsonServicios.servicios[i].caracteristica;
								duracion       = jsonServicios.servicios[i].duracion + " min";
								precioFijo     = jsonServicios.servicios[i].precioFijo;

								if(precioFijo == 1){

									precioFijo = "<input type='checkbox' disabled checked>";
								}
								else{
									
									precioFijo = "<input type='checkbox' disabled>";
								}

								servicios      += "<tr><td>"+nombreServicio+"</td><td>"+caracteristica+"</td><td class='text-center'>"+duracion+"</td></tr>";
							}

							$("#tablaServicios").html(servicios);
						}
						else{

							swal({
								title: "Error",
								text: "Problemas al obtener los servicios del colaborador",
								type: "error",
								confirmButtonText: "Aceptar"
							});
						}
					});
			});
			
			/*=====  End of Buscar en input servicios  ======*/
			


			

		
		/*=====  End of Restaurar Cola  ======*/





		/*=======================================================
		=            Boton Mover al final Disponible            =
		=======================================================*/
		
		$(document).on('click', '#btn_mover_disponible', function(){
		 		var codigo = $(this).data("cod");
				var salon = $('#ipt_salon').val();
				console.log('Codigo colaborador '+codigo + " Salon "+ salon);

				$.ajax({
					url: 'colaSubeBajaDisponible.php',
					method: 'POST',
					data: {codigo: codigo, salon: salon},
					success: function (data) {
						if (data == 1) {
							restaurarCola();
						}else{
							restaurarCola();
						}
					}
				});
				  	
		 });
		
		/*===== Boton Mover al final Disponible  ======*/
		
});
	
</script>
<script type="text/javascript">
	/*=============================================
	=            Mostrar Servicios           =
	=============================================*/
		
		function mostrarServicios(codigo, nombre, categoria, cargo, imagen){

				switch (categoria) {
									
					case "JUNIOR":
						categoria = "<label class='label label-danger'>"+categoria+"</label>";
						break;

					case "SENIOR":
						categoria = "<label class='label label-primary'>"+categoria+"</label>";
						break;
					
					case "GOLD":
						categoria = "<label class='label label-warning'>"+categoria+"</label>";
						break;

					case "PLATINUM":
						categoria = "<label class='label label-default'>"+categoria+"</label>";
						break;

					default:
						categoria = "";
						break;
				}
				$("#txtCodigoColaborador").val(codigo);
				$("#nombreColaboradorServicio").html("<strong>"+nombre+" </strong>"+categoria);
				$("#cargoColaboradorServicio").text(cargo);
				$("#imagenColaboradorServicio").attr("src", imagen);

				$('#modalServicios').on('shown.bs.modal', function () {
					  $('#txtBuscarServicio').focus();
				});
				
				$.ajax({
					url: 'serviciosColaboradorTurnos.php',
					data: {codColaborador: codigo, buscar: "no"},
				})
				.done(function(servicios) {
					
					var jsonServicios= JSON.parse(servicios);
					
					if(jsonServicios.result == "full"){

						var nombreServicio;
						var caracteristica;
						var duracion;
						var alias;
						var precioFijo;
						var servicios = "";

						for(i in jsonServicios.servicios){
							
							nombreServicio = jsonServicios.servicios[i].nombre;
							caracteristica = jsonServicios.servicios[i].caracteristica;
							duracion       = jsonServicios.servicios[i].duracion + " min";
							precioFijo     = jsonServicios.servicios[i].precioFijo;

							if(precioFijo == 1){

								precioFijo = "<input type='checkbox' disabled checked>";
							}
							else{
								
								precioFijo = "<input type='checkbox' disabled>";
							}

							servicios      += "<tr><td>"+nombreServicio+"</td><td>"+caracteristica+"</td><td class='text-center'>"+duracion+"</td></tr>";
						}

						$("#tablaServicios").html(servicios);
						$("#modalServicios").modal("show");

						$('#modalServicios').on('shown.bs.modal', function () {
					  		$('#txtBuscarServicio').val("");
						});
						
					}
					else{

						swal({
							title: "Error",
							text: "Problemas al obtener los servicios del colaborador",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					}
				});
				
				$("#modalServicios").modal("show");
		}
		
		
		/*=====  End Mostrar Servicios  ======*/

		/*========================================
		=            Inicializar Cola            =
		========================================*/
		
		$(document).on('click', '#btn_inicializar_cola', function(e){
			var salon_turno = $('#ipt_salon').val();
				$.ajax({
					url: 'cargar_programacion.php',
					method:'POST',
					data: {salon_turno:salon_turno},
					success: function (data) {
						$('.tabla_colaborador tbody').html(data);
					}
				});
			
		});

		$(document).on('click', '#btn_reset', function() {
			var salon_turno = $('#ipt_salon').val();
			$.ajax({
               url: 'validar_queue.php',
               method: 'POST',
               data: {salon_turno:salon_turno},
               success: function (data) {
               	//alert(data);
               	   if (data == 1) {
         				//alert("ok");
               	   }else{
               	   		if (data == 0) {
               	   				$('.btn_init_queue').prop("disabled", true);
               	   			
               	   		}               	   	
               	   }
               }
			});
		});

		
		
		/*=====  End of Inicializar Cola  ======*/

		

		/*===============================================================
		=            Boton Añadir Colaborador al Sube y Baja            =
		===============================================================*/
		
		$(document).on('click', '#btn_add_col', function(e){
			var cod_colaborador = $(this).data("id");
	        var cod_salon = $('#ipt_salon').val();
	        //var pos = $(this).data("pos");
	        //alert(pos);
	        //$(this).prop("disabled", true);
	        $.ajax({
	        	url: 'cargar_cola_turnos.php',
	        	method: 'POST',
	        	data: {cod_colaborador:cod_colaborador, cod_salon:cod_salon},
	        	success: function (data) {	
	        		if (data == 0) {
	        			swal({
							title: "Error",
							text: "Ya se ha añadido este colaborador al Sube y Baja",
							type: "error",
							confirmButtonText: "Aceptar"
						}, function(){
;
						});
	        		}else{
	        			swal({
							title: "Exitoso",
							text: "Colaborador añadido",
							type: "success",
							confirmButtonText: "Aceptar"
						}, function(){
	        			 	restCola();	;
						});
						 //loadModal ();
	        		}    
					
	        	}
	        });
	        e.preventDefault();
		});

		/*$(document).on('click','#the_new_id', function(){

			alert("Turno finalizado");
		});
		*/
		/*=====  End of Boton Añadir Colaborador al Sube y Baja  ======*/


		/*===========================================================
		=            Eliminar colaborador de Sube y Baja            =
		===========================================================*/
		
		//Code
		//
		/*=====  End of Eliminar colaborador de Sube y Baja  ======*/
		


		/*=======================================
		=            ModalInicializar            =
		=======================================*/
		
		function loadModal (e) {
			$('#modalIniciSubeBaja').modal("show");
			var salon_turno = $('#ipt_salon').val();
				$.ajax({
					url: 'cargar_programacion.php',
					method:'POST',
					data: {salon_turno:salon_turno},
					success: function (data) {
						$('.tabla_colaborador tbody').html(data);
					}
				});
			

		}

	
		
		/*=====  End of ModalIicializar  ======*/


		/*============================
		=            Cola            =
		============================*/
		
		function restCola(){
			var salon_turno = $('#ipt_salon').val();
			$.ajax({
				url: 'colaboradoresSalonTurno.php',
				data: {codSalon: salon_turno},

			}).done(function(colaboradores) {
					
					var jsonColaboradores = JSON.parse(colaboradores);

						if(jsonColaboradores.result == "full"){

							var listaColaboradores = "";
							var codigo             = "";
							var nombre             = "";
							var categoria          = "";
							var cargo              = "";
							var imagen             = "";
							var posicion           = "";

								for(i in jsonColaboradores.colaboradores){

									codigo   = jsonColaboradores.colaboradores[i].codigo;
									nombre   = jsonColaboradores.colaboradores[i].nombre;
									posicion = jsonColaboradores.colaboradores[i].posicion;
									estado   = jsonColaboradores.colaboradores[i].estado;
									cargo    = jsonColaboradores.colaboradores[i].cargo;

								switch (jsonColaboradores.colaboradores[i].categoria) {
								
								case "JUNIOR":
									categoria = "<label class='label label-danger'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								case "SENIOR":
									categoria = "<label class='label label-primary'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;
								
								case "GOLD":
									categoria = "<label class='label label-warning'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								case "PLATINUM":
									categoria = "<label class='label label-default'>"+jsonColaboradores.colaboradores[i].categoria+"</label>";
									break;

								default:
									categoria = "";
									break;
							}

							if(jsonColaboradores.colaboradores[i].imagen == "default.jpg"){

								imagen = "./imagenes/default.jpg";
							}
							else{

								imagen = "./imagenes/colaborador/" + jsonColaboradores.colaboradores[i].imagen;
							}

							listaColaboradores += "<li id='"+codigo+"' data-posicion='"+posicion+"' class='listaColaboradores' style='margin: 3px'>";

							if(estado == 1){

								listaColaboradores += "<div class='row' style='background-color: #EFF0F1; margin: 0px 0; padding: 7px 0; border-radius: 6px'>";
							}
							else{

								listaColaboradores += "<div class='row' style='background-color: #ffdada; margin: 0px 0; padding: 7px 0; border-radius: 6px'>";
							}


							listaColaboradores += "<div class='col-xs-2 col-sm-1'><img width='120' height='120' src='" + imagen + "' class='img-thumbnail m-b'></div><div class='col-xs-10 col-sm-11'><div class='col-xs-12'><strong>" + nombre + " </strong>" + categoria + "</div><button class='btn btn-info btn-sm pull-right' type='button' id='btn_mover' data-cod='"+codigo+"' data-estado'"+estado+"' data-pos='"+posicion+"' title='Click para mover colaborador.'> <i class='fa fa-arrow-down' aria-hidden='true'></i></button><button class='btn btn-warning btn-sm pull-right' type='button' id='btn_mover_disponible' data-cod='"+codigo+"' style='margin-right:13px' title='Click para cambiar estado.'> <i class='fa fa-check' aria-hidden='true'></i></button><div class='col-xs-12'>" + cargo + "</div><div class='col-xs-12'><button type='button' onclick='mostrarServicios(" + codigo + ", \"" + nombre + "\", \"" + jsonColaboradores.colaboradores[i].categoria + "\", \"" + cargo + "\", \"" + imagen + "\")' class='btn btn-circle btn-default text-info'><i class='fa fa-scissors'></i></button></div></div></div></li>";
						}

						$("#listaSubeBaja").html(listaColaboradores);
						$("#subeBaja").fadeIn("fast");
						modalSelectSalon.modal("hide");

					}
					else if(jsonColaboradores.result == "vacio"){
						
						/*modalSelectSalon.modal("hide");
						swal({
							title: "Precaución",
							text: "No hay colaboradores en turno para el salón seleccionado.",
							type: "warning",
							confirmButtonText: "Aceptar"
						}, function(){
							loadModal ();
							//modalSelectSalon.modal("show");
						})*/;					
					}
					else{

						modalSelectSalon.modal("hide");
						swal({
							title: "Error",
							text: "Problemas al obtener colaboradores del sal\u00F3n seleccionado",
							type: "error",
							confirmButtonText: "Aceptar"
						}, function(){
							//$('#select_programacion').css("display","none");
							modalSelectSalon.modal("show");
						});
					}
				});			
			}
		
		/*=====  End of Cola  ======*/
		
		
		/*==========================================
		=            Cerrar Sube y Baja            =
		==========================================*/
		
		$(document).on('click', '#btn_cerrar_syb', function(){
			var salon_turno = $('#ipt_salon').val();

			$.ajax({
             	url: 'validar_comentarios_ini.php',
             	method: 'POST',
             	data: {salon_turno: salon_turno},
             	success: function (data) {
             		if (data) {          
             			$('#txt_comentario_subebaja_inicial').val(data);
             		}
             	}
             });

			
		});
		
		/*=====  End of Cerrar Sube y Baja  ======*/



		/*===================================================================
		=            Boton de Quitar Colaborador del Sube y Baja            =
		===================================================================*/
		

		$(document).on('click', '#btn_quitar_col', function(){
			var cod_colaborador = $(this).data("id");
	        var cod_salon = $('#ipt_salon').val();
	        cod_colaborador = parseInt(cod_colaborador);


	        $.ajax({
	        	url: 'turno_colab_finalizado.php',
	        	method: 'POST',
	        	data: {cod_colaborador: cod_colaborador, cod_salon: cod_salon},
	        	success: function (data) {
	        		if (data == 0) {
	        			swal({
						  title: 'Advertencia',
						  text: 'El colaborador no está en el sube y baja.',
						  type: 'warning',
						  showCloseButton: true,
						  confirmButtonText:
						    'Aceptar',

						});
	        		}else{
	        			if (data == 1) {
	        				swal({
							  title: 'Advertencia',
							  text: 'El colaborador aún está en turno.',
							  type: 'warning',
							  showCloseButton: true,
							  confirmButtonText:
							    'Aceptar',

							});
	        			}else{
	        				if (data == 2) {
	        					swal({
								  title: 'Exitoso',
								  text: 'Turno terminado.',
								  type: 'success',
								  showCloseButton: true,
								  confirmButtonText:
								    'Aceptar',

								}, function(){															
									$('.panel_subebaja li#'+cod_colaborador+' ').remove();					
								});
	        				}
	        			}
	        		}
	        	}
	        });
			
		});

		
		
		/*=====  End of Boton de Quitar Colaborador del Sube y Baja  ======*/


		/*=====================================================
		=            Funcion Colaborador terminado            =
		=====================================================*/
		
		function fn_CargarColaboradorTurnoFin () {

	        $.ajax({
	        	url: 'mostrar_col_fin_subebaja.php',
	        	method: 'POST',
	        	data: {cod_colaborador:cod_colaborador, cod_salon:cod_salon},
	        	success: function (data) {
	        		
	        	}
	        });
		}
		
		/*=====  End of Funcion Colaborador terminado  ======*/
		
		



		/*===========================================================
		=            Cerrar Comentario Final Sube y Baja            =
		===========================================================*/
		
		$(document).on('click', '#btn_finalizar', function(){
			var comentario_final = $('#txt_comentario_subebaja_final').val();
			var salon_turno = $('#ipt_salon').val();

			$.ajax({
				url: 'guardar_comentario_fin.php',
				method: 'POST',
				data: {comentario_final: comentario_final, salon_turno: salon_turno},
				success: function (data) {
					if (data == 1) {
						swal({
							title: "Exitoso",
							text: "Se ha cerrado el Sube y Baja.",
							type: "success",
							confirmButtonText: "Aceptar"
						}, function(){
							$('#modal_cerrar_sube_baja').modal("hide");
							$('.panel_subebaja').remove();
							$('#btn_cerrar_syb').prop("disabled", true);
							$('#btn_inicializar_cola').prop("disabled", true);
						});
					}
				}
			});
		});

		
		/*=====  End of Cerrar Comentario Final Sube y Baja  ======*/
		


		/*==================================================
		=            Guardar Comentario Inicial            =
		==================================================*/
		
		$(document).on('click', '#btn_guardar_comentario', function(){
             var salon_turno = $('#ipt_salon').val();
             var comentario_ini = $('#txt_comentario_inicial').val();

             $.ajax({
             	url: 'guardar_comentario_ini.php',
             	method: 'POST',
             	data: {salon_turno: salon_turno, comentario_ini:comentario_ini},
             	success: function (data) {
             		if (data == 1) {
             			swal({
							title: "Exitoso",
							text: "Comentario Ingresado",
							type: "success",
							confirmButtonText: "Aceptar"
						});
             			$('#txt_comentario_inicial').val("");
             			$('#modalComentariosIniciales').modal('hide');
             		}
             	}
             });

		});
		
		/*=====  End of Guardar Comentario Inicial  ======*/


		/*===================================
		=            Comentarios            =
		===================================*/
		
		$(document).on('click', '#btn_comentar', function(){
             var salon_turno = $('#ipt_salon').val();

             $.ajax({
                 url: 'validar_comentarios_ini.php',
                 method: 'POST',
                 data: {salon_turno:salon_turno},
                 success: function (data) {
                 	if (data) {
                 		$('#txt_comentario_inicial').val(data);
                 	}
                 }
             });
		});
		
		/*=====  End of Comentarios  ======*/
		
		
		
		
</script>
</body>
</html>

<style type="text/css">
	.cancel{
		background-color: #5cb85c!important;
	}

	.th_center{
		text-align: center;
	}

	td{
		font-size: 11px;
	}

	th, td{
		text-align: center;
	}


</style>

