<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("CITAS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
	
	$querySalones            = "SELECT slncodigo, slnnombre, slndireccion FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
	$queryServicios          = "SELECT sercodigo, sernombre,	serduracion FROM btyservicio WHERE serstado = 1	ORDER BY sernombre";
	$queryEstados            = "SELECT esccodigo, escnombre FROM btyestado_cita WHERE escestado = 1 ORDER BY escnombre";
	$resultadoQuerySalones   = $conn->query($querySalones);
	$resultadoQueryServicios = $conn->query($queryServicios);
	$resultadoQueryEstados   = $conn->query($queryEstados);
	$salones                 = array();
	$estados                 = array();

	while($registrosSalones = $resultadoQuerySalones->fetch_array()){

		$salones[] = array(
						"codigo" => $registrosSalones["slncodigo"],
						"nombre" => $registrosSalones["slnnombre"],
						"direccion" => $registrosSalones["slndireccion"]);
	}

	while($registrosEstados = $resultadoQueryEstados->fetch_array()){

		$estados[] = array("codigo" => $registrosEstados["esccodigo"], "nombre" => $registrosEstados["escnombre"]);
	}
?>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap3.min.css"> -->
	<div class="row">
		<input type="number" name="txtUsuario" id="txtUsuario" value="<?php echo $_SESSION['codigoUsuario']?>" readonly style="display: none">
		<div class="col-lg-4">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
				            <div class="panel-tools">
				                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
				           </div>
				            CITAS
				        </div>
						<div class="panel-body">
							<form>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label" for="selectCliente"><b>Cliente</b></label>
											<select required name="selectCliente" id="selectCliente" class="js-example-basic-single form-control input-sm" placeholder="Nombre o documento del cliente">
												<option></option>
											</select>
											<!-- <div class="input-group input-group-sm">
												<div class="input-group-addon">
													<span class="fa fa-user"></span>
												</div>
											</div> -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label class="control-label" for="selectSalon"><b>Sal&oacute;n</b></label>
											<select required name="selectSalon" id="selectSalon" class="js-example-basic-single form-control input-sm" placeholder="Seleccione el sal&oacute;n">
												<option></option>
												<?php 
													foreach ($salones as $salon){
														
														echo "<option value='".$salon["codigo"]."'>".$salon["nombre"]." (".$salon["direccion"].")</option>";
													}
													/*while($registros = $resultadoQuerySalones->fetch_array()){

														echo "<option value='".$registros['slncodigo']."'>".$registros['slnnombre']." (".$registros['slndireccion'].")</option>";*/
													
												?>
											</select>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label class="control-label" for="selectServicio"><b>Servicio</b></label>
											<select required name="selectServicio" id="selectServicio" class="js-example-basic-single form-control input-sm" placeholder="Nombre del servicio">
												<option></option>
												<?php 
													while($registros = $resultadoQueryServicios->fetch_array()){

														echo "<option value='".$registros['sercodigo']."'><small>".$registros['sernombre']." (<b>Dur: ".$registros['serduracion']." min. aprox.</b>)</option>";
													}
												?>
											</select>
											<p class="help-block"><small><a id="linkBusquedaServicio"><u>Búsqueda avanzada de servicio</u></a></small></p>
											<div class="input-group">
												<!-- <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="B&uacute;squeda avanzada">
													<button type="button" data-toggle="modal" id="btnBusquedaServicio" data-target="#modalBusquedaServicio" class="btn btn-default">
														<span class="fa fa-search text-info"></span>
													</button>
												</div> -->
											</div>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="inpFecha"><b>Fecha de agendamiento</b></label>
											<input type="text" name="inpFecha" id="inpFecha" min="<?php echo date('Y-m-d\TH:i')?>" class="form-control input-sm">
											<!-- <div class="input-group input-group-sm">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div> -->
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="selectColaborador"><b>Colaborador</b></label>
											<select name="selectColaborador" id="selectColaborador" class="form-control input-sm" placeholder="Seleccione un colaborador">
												<option selected disabled>---Seleccione un colaborador---</option>
											</select>
											<!-- <div class="input-group input-group-sm">
												<div class="input-group-addon">
													<span class="fa fa-user"></span>
												</div>
											</div> -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label">Observaciones</label>
											<textarea name="txtObservaciones" placeholder="Observaci&oacute;n de la cita" id="txtObservaciones" rows="4" class="form-control input-sm"></textarea>
											<!-- <div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-edit"></span>
												</div>
											</div> -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="button" class="btn btn-success" id="btnAgendar">Agendar</button>
											<!-- <button type="button" class="btn btn-default" id="btnCancelar">Cancelar</button> -->
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
				            <div class="panel-tools">
				                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
				           </div>
				            CALENDARIO
				        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<select required name="selectSalonCalendario" id="selectSalonCalendario" class="form-control input-sm" placeholder="Seleccione el sal&oacute;n">
										<option value="0" disabled selected>--- Seleccione un sal&oacute;n ---</option>
										<?php 
											foreach ($salones as $salon){
												
												echo "<option value='".$salon["codigo"]."'>".$salon["nombre"]." (".$salon["direccion"].")</option>";
											}
											/*while($registros = $resultadoQuerySalones->fetch_array()){

												echo "<option value='".$registros['slncodigo']."'>".$registros['slnnombre']." (".$registros['slndireccion'].")</option>";*/
											
										?>
									</select>
								</div>
								<br><br><br>
								<div class="col-sm-12">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para busqueda avanzada de servicio -->
	<div class="modal fade" id="modalBusquedaServicio" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Búsqueda avanzada de servicio</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label class="control-label" for="selectGrupo"><b>Grupo</b></label>
								<select name="selectGrupo" id="selectGrupo" class="form-control input-sm" placeholder="Seleccione un grupo">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectSubgrupo">Sub-grupo</label>
								<select name="selectSubgrupo" id="selectSubgrupo" class="form-control input-sm" placeholder="Seleccione un sub-grupo" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectLinea">L&iacute;nea</label>
								<select name="selectLinea" id="selectLinea" class="form-control input-sm" placeholder="Seleccione una l&iacute;nea" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectSublinea">Sub-l&iacute;nea</label>
								<select name="selectSublinea" id="selectSublinea" class="form-control input-sm" placeholder="Seleccione una sub-l&iacute;nea" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectCaracteristica">Caracter&iacute;stica</label>
								<select name="selectCaracteristica" id="selectCaracteristica" class="form-control input-sm" placeholder="Seleccione una caracter&iacute;stica" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectServicio2">Servicio</label>
								<select name="selectServicio2" id="selectServicio2" class="form-control input-sm" placeholder="Seleccione un servicio" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-12">
							<button type="button" class="btn btn-success disabled" id="btnServicioModal" name="btnServicioModal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- Fin Modal busqueda avanzada de servicio -->
	<!-- Inicio Modal detalle cita -->
	<div class="modal fade" id="modalDetalleCita" data-backdrop="static" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" onclick="cerrarDetalleModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="tituloModalDetalle"></h4>
				</div>
				<div class="modal-body">
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Codigo salon</label>
								<input type="number" name="txtModalCita" id="txtModalCita" readonly class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Sal&oacute;n</label>
								<input type="text" id="txtModalSalon" placeholder="Nombre del sal&oacute;n" readonly class="form-control">
								<select class="form-control" id="selectSalon2" style="display: none"></select>
								<input type="number" min="1" id="txtModalSalon2" placeholder="Codigo del sal&oacute;n" readonly class="form-control" style="display: none">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Servicio</label>
								<input type="text" id="txtModalServicio" placeholder="Nombre del servicio" readonly class="form-control">
								<select class="form-control" id="selectServicio3" style="display: none"></select>
								<input type="number" id="txtModalServicio2" placeholder="Codigo del servicio" readonly class="form-control" style="display: none">
								<p class="help-block" id="txtModalDuracion"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Cliente</label>
								<input type="text" id="txtModalCliente" placeholder="Nombre del cliente" readonly class="form-control">
								<select class="form-control" id="selectCliente2" style="display: none"></select>
								<input type="number" min="1" id="txtModalCliente2" placeholder="Codigo del cliente" readonly class="form-control" style="display: none">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Colaborador asignado</label>
								<input type="text" id="txtModalColaborador" placeholder="Colaborador asignado" readonly class="form-control">
								<select class="form-control" id="selectColaborador2" style="display: none"></select>
								<input type="number" min="1" id="txtModalColaborador2" placeholder="Codigo del colaborador" readonly class="form-control" style="display: none">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Fecha</label>
								<input type="text" id="txtModalFecha" placeholder="Fecha de la cita" readonly class="form-control">
								<input type="text" id="txtModalFecha2" placeholder="Fecha de la cita" class="form-control" style="display: none">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Asignado por</label>
								<input type="text" id="txtModalUsuario" placeholder="Asignado por" readonly class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Estado</label>
								<input type="text" id="txtModalEstado" name="txtModalEstado" class="form-control" readonly>
								<select class="form-control" id="selectEstado2" style="display: none">
									<option selected disabled>--- Seleccione el nuevo estado ---</option>
									<?php 
										foreach($estados as $estado){

											echo "<option value='".$estado["codigo"]."'>".$estado["nombre"]."</option>";
										}
									?>
								</select>
								<input type="number" name="txtModalEstado2" id="txtModalEstado2" readonly placeholder="Estado nuevo de la cita" style="display: none">
								<input type="number" name="txtModalEstado3" id="txtModalEstado3" readonly placeholder="Estado antiguo de la cita" style="display: none">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label">Observaciones</label>
							<textarea class="form-control" id="txtModalObservaciones" rows="2" readonly></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive" id="tablaNovedades">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="btnCerrarModalDetalle" data-dismiss="modal" onclick="cerrarDetalleModal()">Cerrar</button>
					<button type="button" class="btn btn-success" id="btnActualizarModalDetalle" style="display: none" disabled>Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<!--Inicio Modal Citas por día -->
	<div class="modal fade" id="modalCitasDia" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="tituloModalCitasDia"></h4>
				</div>
				<div class="modal-body">
					<input type="text" name="txtFechaReporte" id="txtFechaReporte" style="display: none" readonly>
					<h4>Seleccione el formato del reporte a generar.</h4>
					<br>
					<div class="well center-block">
						<button type="button" class="btn btn-default btn-lg btn-block" id="btnReporteExcel"><span style="color: #2e7d32" class="fa fa-file-excel-o"></span> Excel</button>
						<button type="button" class="btn btn-default btn-lg btn-block" id="btnReportePdf"><span class="fa fa-file-pdf-o text-danger"></span> PDF</button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	include 'librerias_js.php';
?>
<script>  
  $("#side-menu").children(".active").removeClass("active");
  $("#SALONES").addClass("active");
  $("#CITAS").addClass("active");
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js" type="text/javascript" charset="utf-8"></script> -->
<style>
	.portlet.calendar .fc-event .fc-title {
    color: red!important;
}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		
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

		//Obtener las citas al abrir módulo
		/*$.ajax({
			url: 'obtenerCitasProgramadas.php',
			type: 'GET',
			data: {citasProgramadas: true},
			success : function(citasProgramadas){

				jsonCitasProgramadas = JSON.parse(citasProgramadas);

				if(jsonCitasProgramadas.result == "full"){

					for(i in jsonCitasProgramadas.citas){
							
							//Establecer fecha de finalización de cada cita
							var fechaFinAgendamiento = new Date(jsonCitasProgramadas.citas[i].fecha+"T"+jsonCitasProgramadas.citas[i].hora);
							fechaFinAgendamiento.setMinutes(jsonCitasProgramadas.citas[i].duracion);

							var cita            = new Object();
							cita.id             = jsonCitasProgramadas.citas[i].codigo;
							cita.title          = "Cita No." + jsonCitasProgramadas.citas[i].codigo;
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
							arrayCitas.push(cita);
					}

					//$("#calendar").fullCalendar("destroy");
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
			            events: arrayCitas,
			            timeFormat: "h:mm a",
			            eventClick: function(cita){

							$("#txtModalCita").val(cita.id);
			            	tituloCita.html("Cita No." + cita.id + " <small id='subtituloModalDetalle'><a onclick='habilitarEdicionCampos()'><span class='fa fa-edit'></span></a></small>");
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
			            	$("#txtModalFecha2").val(cita.fecha + " " + cita.hora);
			            	modalUsuario.val(cita.usuario);
			            	modalObservaciones.val(cita.description);
			            	$("#modalDetalleCita").modal("show");
			            },
			            eventRender: function(event, element){
			            	$(element).tooltip({title: event.title, container: "body"});
			            }
					});
				}
			}
		});*/

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
            timeFormat: "h:mm a",
		});
		
		//Algoritmo a ejecutar al hacer clic en Guardar
		btnAgendar.on("click", function(){

			if(((selectCliente.val() != null) && (selectCliente.val() != 0)) && ((selectSalon.val() != 0) || (selectSalon.val() != null)) && ((selectServicio.val() != 0) || (selectServicio.val() != null)) && (selectFecha.val() != 0) && (selectColaborador.val() != null)){

				$.ajax({
					url: 'registrarCita.php',
					type: 'POST',
					data: 
					{
						cliente: selectCliente.val(),
						salon: selectSalon.val(),
						servicio: selectServicio.val(),
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
							
							swal(
							{
								title: "Cita registrada",
								type: "success",
								confirmButtonText: "Aceptar"
							}, function(){

								location.reload();
							});
						}
						else if(jsonCitaCreada.result == "duplicada")
						{
							swal("No se registr\u00F3 la cita", "El colaborador ya cuenta con una cita programada para la hora escogida.\n\n Revise el calendario antes de agendar una cita.", "error");
						}
						else if (jsonCitaCreada.result == "enpermiso") 
						{
							swal("Este colaborador tiene un permiso asignado para esta hora", "", "warning");
						}
						else if (jsonCitaCreada.result == "almuerzo") 
						{
							swal("No se registr\u00F3 la cita", "Hora seleccionada coincide con la hora de descanso del colaborador.\n\n","error");
						}
						else
						{
							swal("Error", "No se registr\u00F3 la cita. Verifique los datos del formulario", "error");
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
				url: 'clientesAgendamiento.php',
				type: 'POST',
				data: "datoCliente="+cliente,

				success: function(data){

					var json = JSON.parse(data);

					if(json.result == "full"){

						var clientes = "";

						for(datos in json.data){

							clientes += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombreCliente+" ("+json.data[datos].documento+")</option>"
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
				url: "FindClbForCitas.php",
				data: {sln: salon, fecha: fechaHora, ser: servicio},
				success: function (res) {
					selectColaborador.html(res);
				}
			});
		}

		//Llenar selecColaboradores al selecionar servicio, ya sea por selecServicio o busqueda avanzada de servicios
		function obtenerColaborador(codServicio, codSalon){

			var servicio = codServicio;
			var salon    = codSalon;
			selectFecha.attr("disabled", false);
			
			$.ajax({
				url: 'colaboradorAgendamiento.php',
				type: 'POST',
				data: {
					servicio: servicio,
					salon: salon
				},

				success : function(data){

					var json = JSON.parse(data);

					if(json.result == "full"){

						selectColaborador.attr("disabled", false);
						var colaboradores = "<option selected disabled>---Seleccione un colaborador---</option>";

						for(datos in json.data){

							colaboradores += "<option value='"+json.data[datos].codigoColaborador+"'>"+json.data[datos].nombreColaborador+"</option>";
						}

						//$("#selectColaborador").attr("disabled", false);	
						selectColaborador.html(colaboradores);
					}
					else{
						
						//colaboradores += "<option selected disabled>Sin colaborador</option>";		
						selectColaborador.attr("disabled", true);
						selectColaborador.html("<option selected disabled>No hay colaboradores</option>");/*Select Colaborador*/
					}
				}
			});
		}

		//Al seleccionar un servicio
		selectServicio.on("change", function(){
			getColaboradores();
			// if((selectSalon.val() == 0) || (selectSalon.val() == "")){

			// 	swal({
			// 		title: "Atenci\u00F3n",
			// 		text: "Recuerde seleccionar el sal\u00F3n",
			// 		type: "warning",
			// 		confirmButtonText: "Aceptar"
			// 	},
			// 	function(){

			// 		selectServicio.select2("destroy");
			// 		selectServicio.val("");
			// 		selectServicio.select2();
			// 	});
			// }
			// else{
				
			// 	obtenerColaborador($(this).val(), selectSalon.val());
			// }
		});
		selectSalon.on("change", function () {
			getColaboradores();
		});

		//Al selecionar una fecha
		selectFecha.on("blur", function(){
			getColaboradores();
			// var fechaAgendamiento = $(this).val();
			// var servicio = selectServicio.val();
			// selectColaborador.attr("disabled", false);
			// var colaboradores = selectColaborador.val();

			// $.ajax({
			// 	url: 'fechaAgendamiento.php',
			// 	type: 'POST',
			// 	data: {
			// 		fechaAgendamiento: fechaAgendamiento,
			// 		servicio: servicio,
			// 		colaboradores: colaboradores},

			// 	success : function(data){
			// 		alert(data);
			// 		var json = JSON.parse(data);

			// 		if(json.result == "full"){

			// 			var colaboradores = "";
			// 			colaboradores += "<option selected disabled>Seleccione un colaborador</option>";

			// 			for(datos in json.data){

			// 				colaboradores += "<option value='"+json.data[datos].codigoColaborador+"'>"+json.data[datos].nombreColaborador+"</option>";
			// 			}
			// 			colaboradores += "</optgroup>";
			// 			selectColaborador.html(colaboradores);
			// 		}
			// 	}
			// });
		});

		//Click en busqueda avanzada de servicio
		linkBusquedaServicio.on('click', function(){

			if((selectSalon.val() == 0) || (selectSalon.val() == "")){

				swal({
					title: "Debe seleccionar el sal\u00F3n",
					confirmButtonText: "Aceptar",
					type: "warning"
				});
			}
			else{ 

				$.ajax({
					url: 'obtenerGruposModalsServicio.php',

					success : function(grupos){

						var gruposEncontrados = "";
						var jsonGrupos = JSON.parse(grupos);

						if(jsonGrupos.result == "full"){

							gruposEncontrados = "<option disabled selected>---Seleccione un grupo---</option>";

							for(i in jsonGrupos.grupos){

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
						btnServicioModal.attr("disabled", true);
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

		//Obtener subgrupos al seleccionar grupo
		selectGrupo.on("change", function(){
			
			$.ajax({
				url: 'obtenerSubgruposModalsServicio.php',
				data: {grupo: selectGrupo.val()},

				success : function(subgrupos){

					var subgruposEncontrados = "";
					var jsonSubgrupos = JSON.parse(subgrupos);

					if(jsonSubgrupos.result == "full"){

						subgruposEncontrados = "<option disabled selected>---Seleccione un sub-grupo---</option>";

						for(i in jsonSubgrupos.subgrupos){

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
					btnServicioModal.attr("disabled", true);
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

			$.ajax({
				url: 'obtenerLineasModalsServicio.php',
				data: {subgrupo: selectSubgrupo.val()},

				success : function(lineas){

					var lineasEncontradas = "";
					var jsonLineas = JSON.parse(lineas);

					if(jsonLineas.result == "full"){

						lineasEncontradas = "<option disabled selected>---Seleccione una l&iacute;nea---</option>";

						for(i in jsonLineas.lineas){

							lineasEncontradas += "<option value='" + jsonLineas.lineas[i].codigo + "'>" + jsonLineas.lineas[i].nombre + "</option>";
						}
					}
					else{

						lineasEncontradas = "<option disabled selected>---No hay l&iacute;neas registradas---</option>";
					}

					selectLinea.attr("disabled", false);
					selectSublinea.attr("disabled", true);
					selectCaracteristica.attr("disabled", true);
					selectServicio2.attr("disabled", true);
					btnServicioModal.attr("disabled", true);
					selectSublinea.val("");
					selectCaracteristica.val("");
					selectServicio2.val("");
					selectLinea.html(lineasEncontradas);
				}
			});
		});

		//Obtener sublineas al seleccionar linea
		selectLinea.on("change", function(){

			$.ajax({
				url: 'obtenerSublineasModalsServicio.php',
				data: {linea: selectLinea.val()},

				success : function(sublineas){

					var sublineasEncontradas = "";
					var jsonSublineas = JSON.parse(sublineas);

					if(jsonSublineas.result == "full"){

						sublineasEncontradas = "<option disabled selected>---Seleccione una sub-l&iacute;nea---</option>";

						for(i in jsonSublineas.sublineas){

							sublineasEncontradas += "<option value='" + jsonSublineas.sublineas[i].codigo + "'>" + jsonSublineas.sublineas[i].nombre + "</option>";
						}
					}
					else{

						sublineasEncontradas = "<option disabled selected>---No hay sub-l&iacute;neas registradas---</option>";
					}

					selectSublinea.attr("disabled", false);
					selectCaracteristica.attr("disabled", true);
					selectServicio2.attr("disabled", true);
					btnServicioModal.attr("disabled", true);
					selectCaracteristica.val("");
					selectServicio2.val("");
					selectSublinea.html(sublineasEncontradas);
				}
			});
		});

		//Obtener características al seleccionar sublinea
		selectSublinea.on("change", function(){

			$.ajax({
				url: 'obtenerCaracteristicasModalsServicio.php',
				data: {sublinea: selectSublinea.val()},

				success : function(caracteristicas){

					var caracteristicasEncontradas = "";
					var jsonCaracteristicas = JSON.parse(caracteristicas);

					if(jsonCaracteristicas.result == "full"){

						caracteristicasEncontradas = "<option disabled selected>---Seleccione una caracter&iacute;stica---</option>";

						for(i in jsonCaracteristicas.caracteristicas){

							caracteristicasEncontradas += "<option value='" + jsonCaracteristicas.caracteristicas[i].codigo + "'>" + jsonCaracteristicas.caracteristicas[i].nombre + "</option>";
						}
					}
					else{

						caracteristicasEncontradas = "<option disabled selected>---No hay caracter&iacute;sticas registradas---</option>";
					}

					selectCaracteristica.attr("disabled", false);
					selectServicio2.attr("disabled", true);
					btnServicioModal.attr("disabled", true);
					selectServicio2.val("");
					selectCaracteristica.html(caracteristicasEncontradas);
				}
			});
		});

		//Obtener servicios al seleccionar característica
		selectCaracteristica.on("change", function(){

			$.ajax({
				url: 'obtenerServiciosModalsServicio.php',
				data: {caracteristica: selectCaracteristica.val()},

				success : function(servicios){

					var serviciosEncontrados = "";
					var jsonServicios        = JSON.parse(servicios);

					if(jsonServicios.result == "full"){

						serviciosEncontrados = "<option disabled selected>---Seleccione un servicio---</option>";

						for(i in jsonServicios.servicios){

							serviciosEncontrados += "<option value='" + jsonServicios.servicios[i].codigo + "'>" + jsonServicios.servicios[i].nombre + " (Dur: " + jsonServicios.servicios[i].duracion + " min. aprox)</option>";
						}
					}
					else{

						serviciosEncontrados = "<option disabled selected>---No hay servicios registrados---</option>";
					}

					selectServicio2.attr("disabled", false);
					btnServicioModal.attr("disabled", true);
					selectServicio2.html(serviciosEncontrados);
				}
			});
		});

		//Habilitar botón para escoger servicio
		selectServicio2.on("change", function(){

			btnServicioModal.removeClass('disabled');
			btnServicioModal.attr("disabled", false);
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
		selectSalonCalendario.on("change", function(){

			actualizarCalendario();
		});
		
		//Al presionar la tecla Esc cuando esté abierto el modal Detalle cita
		$(document).bind('keydown',function(e){
			if ( e.which == 27 ) {
			   cerrarDetalleModal();
			};
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
					url: 'obtenerDatosDetalleCita.php',
					data: {salonDetalle: true},
				})
				.done(function(salones) {
					
					var jsonSalones   = JSON.parse(salones);
					var optionSalones = "<option></option>";

					switch(jsonSalones.result){

						case "full":

							for(i in jsonSalones.salones){

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
						placeholder: "Seleccione el nuevo sal\u00F3n",
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
					url: 'obtenerDatosDetalleCita.php',
					data: {servicioDetalle: true},
				})
				.done(function(servicios){
					
					var jsonServicios   = JSON.parse(servicios);
					var optionServicios = "<option></option>";
					switch(jsonServicios.result){

						case "full":

							for(i in jsonServicios.servicios){

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
					url: 'obtenerDatosDetalleCita.php',
					data: {clienteDetalle: true},
				})
				.done(function(clientes){
					
					var jsonClientes   = JSON.parse(clientes);
					var optionClientes = "<option></option>";
					
					switch(jsonClientes.result){

						case "full":

							for(i in jsonClientes.clientes){

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
					url: 'obtenerDatosDetalleCita.php',
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

							for(i in jsonColaboradores.colaboradores){

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
					url: 'actualizarCita.php',
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

				var errores      = new Array();
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

				for(i in errores){

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

			window.open("http://192.168.1.202/beauty/generarReporteCitas.php?tipoReporte=excel&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#selectSalonCalendario").val());
			//window.open("http://beautyerp.claudiachacon.com/dev/app_final/generarReporteCitas.php?tipoReporte=excel&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#selectSalonCalendario").val());
		});

		//Al hacer click en el botón Pdf para generar reporte
		btnReportePdf.on("click", function(){	

			window.open("http://192.168.1.202/beauty/generarReporteCitas.php?tipoReporte=pdf&diaSeleccionado=" + $("#txtFechaReporte").val() + "&codSalon=" + $("#selectSalonCalendario").val());
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
function habilitarEdicionCampos(){

	var modalServicio          = $("#txtModalServicio");
	var modalColaborador       = $("#txtModalColaborador");
	var modalDuracion          = $("#txtModalDuracion");
	var modalCliente           = $("#txtModalCliente");
	var modalSalon             = $("#txtModalSalon");
	var modalFecha             = $("#txtModalFecha");
	var modalUsuario           = $("#txtModalUsuario");
	var modalObservaciones     = $("#txtModalObservaciones");
	var btnActualizarModalDetalle = $("#btnActualizarModalDetalle");
	$("#btnCerrarModalDetalle").text("Cancelar");
	$("#subtituloModalDetalle").css("display", "none");
	btnActualizarModalDetalle.css("display", "inline");
	modalServicio.removeAttr("readonly");
	modalColaborador.removeAttr("readonly");
	modalCliente.removeAttr("readonly");
	modalSalon.removeAttr("readonly");
	modalFecha.removeAttr("readonly");
	modalObservaciones.removeAttr("readonly");
	$("#txtModalEstado").removeAttr("readonly");
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

function actualizarCalendario(){

	var salon = $("#selectSalonCalendario").val();

	$.ajax({
		url: 'obtenerCitasProgramadas.php',
		type: 'GET',
		data: {salon:salon},
	})
	.done(function(citasProgramadas) {
		
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

		switch (jsonCitasProgramadas.result) {
			
			case "full":

				arrayCitas = new Array();

				for(i in jsonCitasProgramadas.citas){
						
					//Establecer fecha de finalización de cada cita
					var fechaFinAgendamiento = new Date(jsonCitasProgramadas.citas[i].fecha+"T"+jsonCitasProgramadas.citas[i].hora);
					fechaFinAgendamiento.setMinutes(jsonCitasProgramadas.citas[i].duracion);

					var cita            = new Object();
					cita.id             = jsonCitasProgramadas.citas[i].codigo;
					cita.title          = "Cita No." + jsonCitasProgramadas.citas[i].codigo;
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
		            eventLimit: true,
		            droppable: false,
		            events: arrayCitas,
		            timeFormat: "h:mm a",
		            eventClick: function(cita){

		            	$("#txtModalCita").val(cita.id);
		            	tituloCita.html("Cita No." + cita.id + "<small id='subtituloModalDetalle'><a onclick='habilitarEdicionCampos()'> <span class='fa fa-edit'></span></a></small>");
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
		            	$("#txtModalFecha2").val(cita.fecha + " " + cita.hora);
		            	modalUsuario.val(cita.usuario);
		            	modalObservaciones.val(cita.description);
		            	$("#txtModalEstado2").val(cita.codEstado);
		            	$("#txtModalEstado3").val(cita.codEstado);
		            	$("#txtModalEstado").val(cita.nomEstado);

		            	$.ajax({
		            		url: 'obtenerNovedadesCita.php',
		            		data: {codCita: cita.id},
		            	})
		            	.done(function(novedades) {
		            		
		            		var jsonNovedades = JSON.parse(novedades);

		            		if(jsonNovedades.result == "full"){

		            			var tablaNovedades = "<table class=' table table-striped'><thead><tr><th>Novedad</th><th>Fecha</th><th>Hora</th><th>Realizada por</th><th>Observaciones</th></tr></thead><tbody>";

		            			for(i in jsonNovedades.novedades){

		            				tablaNovedades += "<tr><td>"+jsonNovedades.novedades[i].estado+"</td><td>"+jsonNovedades.novedades[i].fechaNovedad+"</td><td>"+jsonNovedades.novedades[i].horaNovedad+"</td><td>"+jsonNovedades.novedades[i].autorNovedad+"</td><td>"+jsonNovedades.novedades[i].observaciones+"</td></tr>";
		            			}

		            			tablaNovedades += "</tbody></table>";

		            			$("#tablaNovedades").html(tablaNovedades);
		            		}
		            	});
		            	

		            	$("#modalDetalleCita").modal("show");	
		            },
		            eventRender: function(event, element){
		            	$(element).tooltip({title: event.title, container: "body"});
		            },
		            dayClick: function(diaSeleccionado){
		            	
		            	$.ajax({
		            		url: 'obtenerCitasProgramadasPorDia.php',
		            		data: {diaActual: diaSeleccionado.format(), codSalon: salon},
		            	})
		            	.done(function(citas) {
		            		
		            		var jsonCitas = JSON.parse(citas);

		            		switch (jsonCitas.result){
		            			
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
				});

			break;

			case "vacio":
				
				swal({
					title: "Sin resultados",
					text: "No hay citas programadas para el sal\u00F3n \n" + $("#selectSalonCalendario option:selected").text(),
					type: "warning",
					confirmButtonText: "Aceptar"
				});

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
		}
	});
}

 $(document).ready(function() {
    conteoPermisos ();
});
</script>
</body>
</html>