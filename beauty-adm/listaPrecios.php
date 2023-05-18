<?php 
	include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("LISTA DE PRECIOS (SALON)", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
?>
<div class="container-fluid">
	<div class="content animate-panel">
		<div class="row">
			<div class="hpanel">
				<div class="panel-heading">
					<div class="panel-tools">
						<a href="" class="showhide"><i class="fa fa-chevron-up"></i></a>
					</div>
					LISTA DE PRECIOS
				</div>
		        <input type="number" id="txtDocumentoUsuario" style="display: none" value="<?= $_SESSION['documento'];?>">
				<div class="panel-body">
					<ul class="nav nav-tabs">
		                <li class="active"><a data-toggle="tab" id="linkTabNuevaLista" href="#tabNuevaLista">Nueva lista</a></li>
		                <li class=""><a data-toggle="tab" id="linkTabAlimentarLista" href="#tabAlimentarLista">Alimentar lista</a></li>
		                <li class=""><a data-toggle="tab" id="linkTablListaSalon" href="#tabListaSalon">Lista de precios (salón)</a></li>
		            </ul>
		            <div class="tab-content">
		            	<!-- Tab Nueva Lista -->
		                <div id="tabNuevaLista" class="tab-pane active">
		                    <div class="panel-body">
		                    	<div class="row">
		                    		<div class="col-md-6">
		                    			<div class="form-group">
		                    				<label for="txtNombreNuevaLista" class="control-label">Nombre</label>
		                    				<input type="text" maxlength="50" id="txtNombreNuevaLista" required name="txtNombreNuevaLista" placeholder="Nombre de la nueva lista" class="form-control">
		                    			</div>

										<label for="txtTipoNuevaLista">Elija tipo</label>
										<select id="txtTipoServicios" name ="txtTipoNuevaLista" class="form-control input-sm">
										  <option value="" >--Escoja un tipo--</option>
										  <option value="PRODUCTOS">PRODUCTOS</option>
										  <option value="SERVICIOS">SERVICIOS</option>
										</select>


										<br>

		                    			<div class="form-group">
		                    				<label for="txtObservacionesNuevaLista" class="control-label">Observaciones</label>
		                    				<textarea name="txtObservacionesNuevaLista" id="txtObservacionesNuevaLista" placeholder="Observaciones de la nueva lista" rows="3" class="form-control"></textarea>
		                    			</div>

		                    			<div class="form-group">
		                    				<button type="button" id="btnNuevaLista" name="btnNuevaLista" class="btn btn-success">Guardar</button>
		                    			</div>
		                    		</div>
		                    		<div class="col-md-6">
		                    			<div class="form-group">
		                    				<label class="control-label">Listas creadas</label>
			                    			<div class="table-responsive" id="tablaListasPrecios">
			                    			</div>
		                    			</div>
		                    		</div>
		                    	</div>
		                    </div>
		                </div>
		                <!-- Tab Alimentar lista -->
		                <div id="tabAlimentarLista" class="tab-pane">
		                    <div class="panel-body">
		                    	<div class="row">
		                    		<div class="col-sm-12">
		                    			<div class="form-group">
		                    				<label class="control-label">Seleccione la lista de precios</label>
		                    				<div class="input-group">
		                    					<select name="selectListaPrecios" id="selectListaPrecios" class="form-control"></select>
		                    					<div class="input-group-btn" id="botonesReporte" style="visibility: hidden;">
		                    						<button type="button" data-toggle="tooltip" data-placement="top" title="Reporte en Excel" id="btnReporteExcel" name="btnReporteExcel" class="btn btn-default">
		                    							<span class="fa fa-file-excel-o text-info"></span>
		                    						</button>
		                    						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Reporte en PDF" id="btnReportePdf" name="btnReportePdf" class="btn btn-default">
		                    							<span class="fa fa-file-pdf-o text-info"></span>
		                    						</button>
		                    					</div>
		                    				</div>
		                    			</div>
		                    		</div>
		                    	</div>
		                    	<div class="row" id="filtrosServiciosLista"  style="display: none">
		                    		<div class="col-xs-12">
		                    			<h4>Filtros de b&uacute;squeda</h4>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label class="control-label">Grupo</label>
		                    				<select name="selectGrupoServiciosLista" id="selectGrupoServiciosLista" class="form-control input-sm">
		                    				</select>
		                    			</div>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label class="control-label">Subgrupo</label>
		                    				<select name="selectSubgrupoServiciosLista" id="selectSubgrupoServiciosLista" class="form-control input-sm">
		                    				</select>
		                    			</div>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label class="control-label">L&iacute;nea</label>
		                    				<select name="selectLineaServiciosLista" id="selectLineaServiciosLista" class="form-control input-sm">
		                    				</select>
		                    			</div>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label class="control-label">Subl&iacute;nea</label>
		                    				<select name="selectSublineaServiciosLista" id="selectSublineaServiciosLista" class="form-control input-sm">
		                    				</select>
		                    			</div>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label class="control-label">Caracter&iacute;stica</label>
		                    				<select name="selectCaracteristicaServiciosLista" id="selectCaracteristicaServiciosLista" class="form-control input-sm">
		                    				</select>
		                    			</div>
		                    		</div>
		                    		<div class="col-sm-6 col-md-4">
		                    			<div class="form-group">
		                    				<label style="visibility: hidden;">Precios 0</label>
		                    				<div class="checkbox">
		                    					<label>
		                    						<input type="checkbox" name="checkPrecios" id="checkPrecios" value="0">
		                    						Mostrar servicios con valor $0
		                    					</label>
		                    				</div>
		                    			</div>
		                    		</div>
		                    	</div>
		                    	<div class="row">
		                    		<div class="col-sm-12">
			                    		<div class="table-responsive" id="tablaServiciosLista">
			                    		</div>
		                    		</div>
		                    	</div>
		                    </div>
		                </div>
		                <!-- Tab lista salon -->
		                <div class="tab-pane" id="tabListaSalon">
		                	<div class="panel-body">
		                		<div class="row">
		                			<div class="col-md-6">
		                				<div class="form-group">
		                					<label class="control-label">Seleccione la lista de precios</label>
		                					<select class="form-control" id="selectListaSalon" name="selectListaSalon"></select>
		                				</div>
		                				<div class="form-group">
		                					<label class="control-label">Seleccione el sal&oacute;n</label>
		                					<select name="selectSalon" id="selectSalon" class="form-control"></select>
		                				</div>
			                			<div class="row">
			                				<div class="col-md-6">
			                					<div class="form-group">
			                						<label class="control-label">Desde</label>
			                						<input type="text" class="form-control" name="txtFechaDesdeSalon" id="txtFechaDesdeSalon">
			                					</div>
			                				</div>
			                				<div class="col-md-6">
			                					<div class="form-group">
			                						<label class="control-label">Hasta</label>
			                						<input type="text" class="form-control" name="txtFechaHastaSalon" id="txtFechaHastaSalon">
			                					</div>
			                				</div>
			                			</div>
			                			<div class="row">
			                				<div class="col-sm-12">
			                					<div class="form-group">
			                						<label class="control-label">Observaciones</label>
			                						<textarea name="txtObservacionesListaSalon" id="txtObservacionesListaSalon" rows="3" class="form-control" placeholder="Observaciones de la lista"></textarea>
			                					</div>
			                				</div>
			                			</div>
			                			<div class="row">
			                				<div class="col-sm-12">
			                					<button type="button" id="btnNuevaListaSalon" name="btnNuevaListaSalon" class="btn btn-success">Guardar</button>
			                				</div>
			                			</div>
		                			</div>
		                			<div class="col-md-6">
		                				<label class="control-label">Listas de precios (sal&oacute;n) creadas</label>
		                				<div class="table-responsive" id="tablaListasSalones">
		                					
		                				</div>
		                			</div>
		                		</div>
		                	</div>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</div>

		<div class="modal fade" id="editarregistro" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Editar registro</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<input type="hidden" id="x_nombre">

							<div class="form-group">
								<label>Nombre</label>
								<input type="text" id="nombre_editar" class="form-control" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="txtTipoNuevaLista">Elija tipo</label>
										<select id="txtTipoNuevaLista" name ="txtTipoNuevaLista" class="form-control input-sm">
										  <option value="PRODUCTOS">PRODUCTOS</option>
										  <option value="SERVICIOS">SERVICIOS</option>
										</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<textarea name="editarObservaciones" id="observaciones_editar" rows="3" class="form-control"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        			<button type="button" class="btn btn-success" data-id="" id="btnEditarServicio">Guardar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal editar lista salon -->
	<div class="modal fade" id="modalEditarListaSalon" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Editar lista de precio (salón)</h4>
				</div>
				<div class="modal-body">
					<div id="edit_precio"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        			<button type="button" class="btn btn-success" id="btn_editar_lista_salon">Guardar</button>
				</div>
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
  $("#LISTAPRECIOS").addClass("active");
</script>
<script type="text/javascript" charset="utf-8">

	$(document).ready(function(){

		$('[data-toggle="tooltip"]').tooltip();
		
		var nombreNuevaLista        = $("#txtNombreNuevaLista");
		var TipoNuevaLista			= $("#txtTipoNuevaLista");	
		var observacionesNuevaLista = $("#txtObservacionesNuevaLista");
		var guardarNuevaLista       = $("#btnNuevaLista");
		var guardarNuevaListaSalon  = $("#btnNuevaListaSalon");
		var selectListaPrecios      = $("#selectListaPrecios");
        

		//Al hacer clic en guardar
		guardarNuevaLista.on("click", function(){

            var tipo = ($("#txtTipoServicios option:selected").text());
			if(nombreNuevaLista.val() != ""){

				$.ajax({
					url: 'registrarLista.php',
					type: 'POST',
					data: {
						nombre: nombreNuevaLista.val(),
						tipo: tipo,
						observaciones: observacionesNuevaLista.val()
					}
				})
				.done(function(){
					
					//var jsonResultado = JSON.parse(resultado);

						swal({
							title: "Lista registrada",
							confirmButtonText: "Aceptar",
							type: "success"
						}, function(){

							nombreNuevaLista.val("");
							TipoNuevaLista.val("Escoja un nuevo tipo");
							observacionesNuevaLista.val("");
							obtenerListasCreadas();
						});
				});
				
			}
		});

		guardarNuevaListaSalon.on("click", function(){

			var listaPrecioSalon = $("#selectListaSalon").val();
			var salon            = $("#selectSalon").val();
			var fechaDesde       = $("#txtFechaDesdeSalon").val();
			var fechaHasta       = $("#txtFechaHastaSalon").val();
			var observaciones    = $("#txtObservacionesListaSalon").val();
			var errores          = new Array();

			if((listaPrecioSalon != null) && (salon != null) && (fechaDesde != "")){
				
				$.ajax({
					url: 'registrarListaPreciosSalon.php',
					type: 'POST',
					data: {
						lista: listaPrecioSalon,
						salon: salon,
						desde: fechaDesde,
						hasta: fechaHasta,
						observaciones: observaciones
					},
				}).done(function(nuevaListaSalon){
					if (nuevaListaSalon == 1) {
						swal("Nueva lista registrada","", "success");
						obtenerListaPreciosSalones();
					}else{
						if (nuevaListaSalon == "NO") {
							swal("No puede ingresar una nueva lista si existe una vigente en este salón.","", "error");
						}
					}
				});
				
			}
			else{

				if(listaPrecioSalon == null){

					errores.push("Seleccione una lista de precios");
				}

				if(salon == null){

					errores.push("Seleccione un sal\u00F3n");
				}

				if(fechaDesde == ""){

					errores.push("Digite la fecha \"Desde\"");
				}


				var i = 0;
				var mensajeError = "";

				for(i = 0; i < errores.length; i++){

					mensajeError += errores[i] + "\n";
				}

				swal("Error", mensajeError, "error");
			}
		});
		//Al seleccionar la pestaña Nueva lista
		$("#linkTabNuevaLista").on("click", function(){

			obtenerListasCreadas();
			$("#tablaServiciosLista").html("");
			$("#filtrosServiciosLista").hide();
			$("#botonesReporte").css("visibility", "hidden");
		});

		//Al seleccionar la pestaña Alimentar lista
		$("#linkTabAlimentarLista").on("click", function(){

			obtenerListasPrecios(selectListaPrecios);
		});

		$("#linkTablListaSalon").on("click", function(){

			var documentoUsuario = $("#txtDocumentoUsuario").val();

			accederListaSalon(documentoUsuario, 31);
			obtenerListaPreciosSalones();
			$("#txtFechaDesdeSalon").datetimepicker({
				format: "YYYY-MM-DD",
				minDate: moment().add(1, "days").format("YYYY-MM-DD"),
				locale: "es" 
			});
			$("#txtFechaHastaSalon").datetimepicker({
				format: "YYYY-MM-DD",
				locale: "es",
				//minDate: moment().add(1, "days").format("YYYY-MM-DD")
			});

			$("#txtFechaDesdeSalon").on("dp.change", function(e){

				//$("#txtFechaHastaSalon").data("DateTimePicker").minDate(e.date);
			});

			$("#txtFechaHastaSalon").on("dp.change", function(e){

				//$("#txtFechaDesdeSalon").data("DateTimePicker").maxDate(e.date);
			});
		});

		//Al seleccionar la lista a alimentar (Pestaña Alimentar lista)
		selectListaPrecios.on("change", function(){

			codLista = $(this).val();

			$("#filtrosServiciosLista").show();
			$("#selectGrupoServiciosLista").val("");
			$("#selectSubgrupoServiciosLista").val("");
			$("#selectLineaServiciosLista").val("");
			$("#selectSublineaServiciosLista").val("");
			$("#selectCaracteristicaServiciosLista").val("");
			$("#selectSubgrupoServiciosLista").attr("disabled", "disabled");
			$("#selectLineaServiciosLista").attr("disabled", "disabled");
			$("#selectSublineaServiciosLista").attr("disabled", "disabled");
			$("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
			obtenerServiciosLista(selectListaPrecios.val(), null, null, null, null, null, $("#checkPrecios"));
		});

		//Botón para generar reporte en Excel
		$("#btnReporteExcel").on("click", function(){

			var codLista       = selectListaPrecios.val();
			var nomLista       = $("#selectListaPrecios :selected").text();
			var grupo          = $("#selectGrupoServiciosLista").val();
			var subgrupo       = $("#selectSubgrupoServiciosLista").val();
			var linea          = $("#selectLineaServiciosLista").val();
			var sublinea       = $("#selectSublineaServiciosLista").val();
			var caracteristica = $("#selectCaracteristicaServiciosLista").val();
			var preciosNulos   = 0;

			if($("#checkPrecios").prop("checked")){

				preciosNulos = 1;
			}

			window.open("./generarReporteListaPrecios.php?tipoReporte=excel&codLista="+codLista+"&nomLista="+nomLista+"&grupo="+grupo+"&subgrupo="+subgrupo+"&linea="+linea+"&sublinea="+sublinea+"&caracteristica="+caracteristica+"&preciosNulos="+preciosNulos);
		});

		//Botón para generar reporte en PDF
		$("#btnReportePdf").on("click", function(){
			var codLista       = selectListaPrecios.val();
			var nomLista       = $("#selectListaPrecios :selected").text();
			var grupo          = $("#selectGrupoServiciosLista").val();
			var subgrupo       = $("#selectSubgrupoServiciosLista").val();
			var linea          = $("#selectLineaServiciosLista").val();
			var sublinea       = $("#selectSublineaServiciosLista").val();
			var caracteristica = $("#selectCaracteristicaServiciosLista").val();
			var preciosNulos   = 0;

			if($("#checkPrecios").prop("checked")){

				preciosNulos = 1;
			}

			window.open("./generarReporteListaPrecios.php?tipoReporte=pdf&codLista="+codLista+"&nomLista="+nomLista+"&grupo="+grupo+"&subgrupo="+subgrupo+"&linea="+linea+"&sublinea="+sublinea+"&caracteristica="+caracteristica+"&preciosNulos="+preciosNulos);
		});
		//Al seleccionar un grupo
		$("#selectGrupoServiciosLista").on("change", function(){

			obtenerSubgruposServicio($(this).val());
			obtenerServiciosLista(selectListaPrecios.val(), $(this).val(), null, null, null, null, $("#checkPrecios"));
		});

		//Al seleccionar un subgrupo
		$("#selectSubgrupoServiciosLista").on("change", function(){

			obtenerLineasServicio($(this).val());
			obtenerServiciosLista(selectListaPrecios.val(), $("#selectGrupoServiciosLista").val(), $(this).val(), null, null, null, $("#checkPrecios"));
		});

		//Al seleccionar una linea
		$("#selectLineaServiciosLista").on("change", function(){

			obtenerSublineasServicio($(this).val());
			obtenerServiciosLista(selectListaPrecios.val(), $("#selectGrupoServiciosLista").val(), $("#selectSubgrupoServiciosLista").val(), $(this).val(), null, null, $("#checkPrecios"));
		});

		//Al seleccionar una sublinea
		$("#selectSublineaServiciosLista").on("change", function(){

			obtenerCaracteristicasServicio($(this).val());
			obtenerServiciosLista(selectListaPrecios.val(), $("#selectGrupoServiciosLista").val(), $("#selectSubgrupoServiciosLista").val(), $("#selectLineaServiciosLista").val(), $(this).val(), null, $("#checkPrecios"));
		});

		//Al seleccionar una característica
		$("#selectCaracteristicaServiciosLista").on("change", function(){

			obtenerServiciosLista(selectListaPrecios.val(), $("#selectGrupoServiciosLista").val(), $("#selectSubgrupoServiciosLista").val(), $("#selectLineaServiciosLista").val(), $("#selectSublineaServiciosLista").val(), $(this).val(), $("#checkPrecios"));
		});

		//Al seleccionar el checkbox servicios valores $0
		$("#checkPrecios").on("change", function(){

			obtenerServiciosLista(selectListaPrecios.val(), $("#selectGrupoServiciosLista").val(), $("#selectSubgrupoServiciosLista").val(), $("#selectLineaServiciosLista").val(), $("#selectSublineaServiciosLista").val(), $("#selectCaracteristicaServiciosLista").val(), $(this));
		});

		//Al hacer clic en Editar servicio (modal)

		obtenerListasCreadas();
	});

	//Obtener las listas de precios creadas
	function obtenerListasCreadas(){

		$.ajax({
			url: 'obtenerListasPrecios.php',	
		})
		.done(function(listas){
			
			var jsonListas = JSON.parse(listas);

			if(jsonListas.result == "full"){

				var tablaListas = "<table id='edit' class='table table-hover table-bordered table-striped table-condensed'><thead><tr><th>Nombre</th><th>Tipo</th><th>Opciones</th></tr><tbody>";

				for(i in jsonListas.listas){

					tablaListas += "<tr style='margin: -5px 0'><td>"+jsonListas.listas[i].nombre+"</td><td>"+jsonListas.listas[i].tipo+"</td><td id='nombre_edit'><button class='btn btn-default btn-sm text-info' onclick='detalleLista(\""+jsonListas.listas[i].nombre+"\", \""+jsonListas.listas[i].observaciones+"\")' data-toggle='tooltip' data-placement='left' title='Observaciones'><span class='fa fa-info-circle'></span></button><button class='btn btn-default btn-sm text-info' data-id="+jsonListas.listas[i].codigo+" id='edit_name' data-toggle='tooltip' data-placement='left' title='Editar registro'><span class='fa fa-wrench'></span></button> <button class='btn btn-default btn-sm text-info' data-toggle='tooltip' data-placement='right' onclick='eliminarLista("+jsonListas.listas[i].codigo+")' title='Eliminar'><span class='fa fa-trash'></span></button></td></tr>";
				}

				tablaListas += "</tbody>";

				$("#tablaListasPrecios").html(tablaListas);
			}
			else{

				$("#tablaListasPrecios").html("");
			}
		});
	}



	//Modal con detalles de lista
	function detalleLista(nombre, observaciones){
		
		swal("Observaci\u00F3n", observaciones);
		
	}

	$(document).on('click', "#edit_name", function(event) {
		$("#editarregistro").modal("show");
		var id = $(this).data("id");

		$.ajax({
		  url: 'edit_reg_lista_precios.php',
		  method: 'POST',
		  data: {codigo: id},
		  success: function(data) {
		    var array = eval(data);
		      for(var i in array){
		      	$('#x_nombre').val(array[i].id)
		        $('#nombre_editar').val(array[i].nombre);
		        $('#observaciones_editar').val(array[i].observaciones);	
		        //$('#txtTipoNuevaLista option:selected').val(array[i].tipo);  

		      }
		    }
		});
	});

	$("#btnEditarServicio").on("click", function(){
		  var id = $(this).data("id");

		  $.ajax({
		  url: 'up_lista_reg.php',
		  method: 'POST',
		  data: {codigo: $("#x_nombre").val(), nombre: $("#nombre_editar").val(), tipo: $("#txtTipoNuevaLista").val(), observaciones: $("#observaciones_editar").val()},
		  success: function(data) {
		    	swal("Actualización exitosa");
		    	window.location = 'listaPrecios.php';
		    }
		});
	});

	

	//Eliminar lista
	function eliminarLista(codLista){

		swal({
			title: "Precauci\u00F3n",
			text: "¿Desea eliminar la lista de precios?",
			type: "warning",
			confirmButtonText: "Eliminar",
			confirmButtonColor: "#e0b469",
			cancelButtonText: "Cancelar",
			showCancelButton: true,
			closeOnConfirm: false
		}, function(isConfirm){
			
			if(isConfirm){

				$.ajax({
					url: 'eliminarListaPrecios.php',
					data: {codLista: codLista},
				})
				.done(function(resultado) {
					
					var jsonResultado = JSON.parse(resultado);

					if(jsonResultado.result == "eliminado"){

						swal("Precio eliminado", "", "success");
						obtenerListasCreadas();
					}
					else{

						swal("Error", "Problemas al eliminar precio", "error");
					}
				});;
			}
		});
	}

	//Al hacer doble clic en el precio a editar del servicio
	function editarPrecio(elemento){

		elemento = "#"+elemento.id;
		$(elemento).attr("readonly", false);
		$(elemento).val("");
	}

	//Al presionar Enter para guardar el precio
	function guardarPrecio(event, elemento){

		var tecla = (document.all) ? event.keyCode : event.which;
			
			if (tecla == 13){
				
				if(elemento.name != elemento.value){

 				$.ajax({
 					url: 'actualizarValorListaPrecios.php',
 					type: "POST",
 					data: {codServicio: elemento.id, nuevoPrecio: elemento.value}
 				})
 				.done(function(actualizado){
 					
 					var jsonActualizado = JSON.parse(actualizado);

 					if(jsonActualizado.result == "actualizado"){

 						elemento.name = elemento.value;
							restaurarPrecio(elemento);

 						/*swal({
 							title: "Precio actualizado",
 							type: "success",
 							confirmButtonText: "Aceptar"
 						}, function(){
 							
 							restaurarPrecio(elemento);
 						});*/
 					}
 					else{

 						swal({
 							title: "Error",
 							text: "Problemas al actualizar el precio del servicio",
 							type: "error",
 							confirmButtonText: "Aceptar"
 						}, function(){

 							restaurarPrecio(elemento);
 						});
 					}
 				});
				}
				
				$("#"+elemento.id).attr("readonly", "readonly");
			}
	}

	//Al desenfocar el precio activo
	function restaurarPrecio(elemento){

		$("#"+elemento.id).attr("readonly", "readonly");
		elemento.value = elemento.name;
	}

	//Llenar los filtros con grupos
	function obtenerGruposServicio(){

		$.ajax({
			url: 'obtenerCategoriasListaPrecios.php',
			data: {categoria: "grupo"},
		})
		.done(function(grupos){

			var jsonGrupos = JSON.parse(grupos);
			var grupos;

			if(jsonGrupos.result == "full"){

				grupos = "<option selected disabled>--- Seleccione un grupo ---</option>";

				for(i in jsonGrupos.grupos){

					grupos += "<option value='"+jsonGrupos.grupos[i].codigo+"'>"+jsonGrupos.grupos[i].nombre+"</option>";
				}
			}
			else{

				grupos = "<option selected disabled>--- No hay grupos ---</option>";
			}

			$("#selectGrupoServiciosLista").html(grupos);
		});

		$("#selectSubgrupoServiciosLista").attr("disabled", "disabled");
		$("#selectLineaServiciosLista").attr("disabled", "disabled");
		$("#selectSublineaServiciosLista").attr("disabled", "disabled");
		$("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
		$("#selectSubgrupoServiciosLista").val("");
		$("#selectLineaServiciosLista").val("");
		$("#selectSublineaServiciosLista").val("");
		$("#selectCaracteristicaServiciosLista").val("");
	}

	//Llenar los filtros con subgrupos
	function obtenerSubgruposServicio(codGrupo){

		$.ajax({
			url: 'obtenerCategoriasListaPrecios.php',
			data: {categoria: "subgrupo", codGrupo: codGrupo},
		})
		.done(function(subgrupos){

			var jsonSubgrupos = JSON.parse(subgrupos);
			var subgrupos;

			if(jsonSubgrupos.result == "full"){

				subgrupos = "<option selected disabled>--- Seleccione un subgrupo ---</option>";

				for(i in jsonSubgrupos.subgrupos){

					subgrupos += "<option value='"+jsonSubgrupos.subgrupos[i].codigo+"'>"+jsonSubgrupos.subgrupos[i].nombre+"</option>";
				}
			}
			else{

				subgrupos += "<option selected disabled>--- No hay subgrupos ---</option>";
			}

			$("#selectSubgrupoServiciosLista").html(subgrupos);

			$("#selectSubgrupoServiciosLista").attr("disabled", false);
			$("#selectLineaServiciosLista").attr("disabled", "disabled");
			$("#selectSublineaServiciosLista").attr("disabled", "disabled");
			$("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
			$("#selectSubgrupoServiciosLista").val("");
			$("#selectLineaServiciosLista").val("");
			$("#selectSublineaServiciosLista").val("");
			$("#selectCaracteristicaServiciosLista").val("");
		});
	}

	//Llenar los filtros con lineas
	function obtenerLineasServicio(codSubgrupo){

		$.ajax({
			url: 'obtenerCategoriasListaPrecios.php',
			data: {categoria: "linea", codSubgrupo: codSubgrupo},
		})
		.done(function(lineas){

			var jsonLineas = JSON.parse(lineas);
			var lineas;

			if(jsonLineas.result = "full"){

				lineas = "<option selected disabled>--- Seleccione una l&iacute;nea ---</option>";

				for(i in jsonLineas.lineas){

					lineas += "<option value='"+jsonLineas.lineas[i].codigo+"'>"+jsonLineas.lineas[i].nombre+"</option>";
				}
			}
			else{

				lineas = "<option selected disabled>--- No hay l&iacute;neas ---</option>";
			}

			$("#selectLineaServiciosLista").html(lineas);

			$("#selectLineaServiciosLista").attr("disabled", false);
			$("#selectSublineaServiciosLista").attr("disabled", "disabled");
			$("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
			$("#selectLineaServiciosLista").val("");
			$("#selectSublineaServiciosLista").val("");
			$("#selectCaracteristicaServiciosLista").val("");
		});
	}

	//Llenar los filtros con sublineas
	function obtenerSublineasServicio(codLinea){

		$.ajax({
			url: 'obtenerCategoriasListaPrecios.php',
			data: {categoria: "sublinea", codLinea: codLinea},
		})
		.done(function(sublineas){

			var jsonSublineas = JSON.parse(sublineas);
			var sublineas;

			if(jsonSublineas.result == "full"){

				sublineas = "<option selected disabled>--- Seleccione una subl&iacute;nea ---</option>";

				for(i in jsonSublineas.sublineas){

					sublineas += "<option value='"+jsonSublineas.sublineas[i].codigo+"'>"+jsonSublineas.sublineas[i].nombre+"</option>";
				}
			}
			else{

				sublineas = "<option selected disabled>--- No hay subl&iacute;neas ---</option>";
			}

			$("#selectSublineaServiciosLista").html(sublineas);

			$("#selectSublineaServiciosLista").attr("disabled", false);
			$("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
			$("#selectSublineaServiciosLista").val("");
			$("#selectCaracteristicaServiciosLista").val("");
		});
	}

	//Llenar los filtros con caracteristicas
	function obtenerCaracteristicasServicio(codSublinea){

		$.ajax({
			url: 'obtenerCategoriasListaPrecios.php',
			data: {categoria: "caracteristica", codSublinea: codSublinea},
		})
		.done(function(caracteristicas){

			var jsonCaracteristicas = JSON.parse(caracteristicas);
			var caracteristicas;

			if(jsonCaracteristicas.result == "full"){

				caracteristicas = "<option selected disabled>--- Seleccione una caracter&iacute;stica ---</option>";

				for(i in jsonCaracteristicas.caracteristicas){

					caracteristicas += "<option value='"+jsonCaracteristicas.caracteristicas[i].codigo+"'>"+jsonCaracteristicas.caracteristicas[i].nombre+"</option>";
				}
			}
			else{

				caracteristicas = "<option selected disabled>--- No hay caracter%iacute;sticas ---</option>";
			}

			$("#selectCaracteristicaServiciosLista").html(caracteristicas);

			$("#selectCaracteristicaServiciosLista").attr("disabled", false);
			$("#selectCaracteristicaServiciosLista").val("");
		});
	}

	//Funcion para filtrar los servicios a traer
	function obtenerServiciosLista(listaSeleccionada, grupo, subgrupo, linea, sublinea, caracteristica, precioNulo){

		var preciosNulos = 0;
		if(precioNulo.prop("checked")){

			preciosNulos = 1;
		}

		$.ajax({
			url: 'obtenerServiciosListaPrecios.php',
			type: "POST",
			data: {
				codLista: listaSeleccionada,
				codGrupo: grupo,
				codSubgrupo: subgrupo,
				codLinea: linea,
				codSublinea: sublinea,
				codCaracteristica: caracteristica,
				preciosNulos: preciosNulos
			},
		})
		.done(function(servicios){
			
			var jsonServicios = JSON.parse(servicios);

			switch (jsonServicios.result) {
					
				case "full":
					
					var serviciosLista = "<table class='table table-bordered table-hover table-striped table-condensed'><thead><tr><th>Servicio</th><th>Valor</th></tr></thead><tbody>";

					for(i in jsonServicios.servicios){

						serviciosLista += "<tr><td>"+jsonServicios.servicios[i].nombre+"</td><td><div class='input-group'><div class='input-group-addon'><span class='fa fa-dollar'></span></div><input type='number' min='0' class='form-control input-sm' id='"+jsonServicios.servicios[i].codigo+"' name='"+jsonServicios.servicios[i].precio+"' ondblclick='editarPrecio(this)' onkeypress='guardarPrecio(event, this)' onblur='restaurarPrecio(this)' readonly value='"+jsonServicios.servicios[i].precio+"'/></div></td></tr>";
					}

					serviciosLista += "</tbody>";
					$("#filtrosServiciosLista").show();
					$("#tablaServiciosLista").show();
					$("#tablaServiciosLista").html(serviciosLista);
					$("#botonesReporte").css("visibility", "visible");
					break;

				case "vacio":

					//$("#filtrosServiciosLista").hide();
					$("#tablaServiciosLista").hide();
					swal({
						title: "Precauci\u00F3n",
						text: "No hay servicios asociados seg\u00FAn los filtros usados",
						type: "warning",
						confirmButtonText: "Aceptar"
					});
					break;
				
				default:
					
					//$("#filtrosServiciosLista").hide();
					$("#tablaServiciosLista").show();
					swal({
						title: "Error",
						text: "Problemas al obtener los servicios",
						type: "error",
						confirmButtonText: "Aceptar"
					});
					break;
			}			
		});	
	}

	//Verificar acceso a la pestaña Lista de precios (salón)
	function accederListaSalon(documentoUsuario, codPrivilegio){

		$.ajax({
        type: "POST",
        url: "verificar_acceso.php",
        data: {usu: codPrivilegio, cod_peti: documentoUsuario}
	    }).done(function(html){
	       
	       if (html != "TRUE"){
	            
	        	swal({
	                title: "No tiene permiso de ingreso",
	                type: "warning",
	                confirmButtonText: "Aceptar"
	            });
	        }
	        else{

				obtenerListasPrecios($("#selectListaSalon"));
				obtenerSalones($("#selectSalon"));
	        }
	    });
	}

	function obtenerListasPrecios(select){

		$.ajax({
			url: 'obtenerListasPrecios.php'
		})
		.done(function(listas){
			
			var jsonListas = JSON.parse(listas);
			
			if(jsonListas.result == "full"){

				var listasPrecios = "<option selected disabled>--- Seleccione la lista de precios ---</option>";

				for(i in jsonListas.listas){

					listasPrecios += "<option value='"+jsonListas.listas[i].codigo+"'>"+jsonListas.listas[i].nombre+" ("+jsonListas.listas[i].tipo+") "+"</option>";
				}
				
				select.html(listasPrecios);
				obtenerGruposServicio();
			}
			else{

				swal({
					title: "Error",
					text: "No hay listas de precios creadas",
					type: "error",
					confirmButtonText: "Aceptar"
				});
				select.html("<option selected disabled>--- No existen listas de precios ---</option>");
			}
		});
	}

	function obtenerSalones(selectSalones){

		$.ajax({
			url: 'obtenerSalonesListasPrecios.php',
		})
		.done(function(salones){
			
			var jsonSalones = JSON.parse(salones);
			var salones = "";

			switch(jsonSalones.result){
				

				case "full":
					
					salones = "<option selected disabled>--- Seleccione un sal&oacute;n ---</option>";

					for(i in jsonSalones.salones){

						salones += "<option value='"+jsonSalones.salones[i].codigo+"'>"+jsonSalones.salones[i].nombre+"</option>";
					}

					break;

				case "vacio":
					
					salones = "<option selected disabled>--- No hay salones ---</option>";
					break;

				case "error":

					salones = "<option selected disabled>--- Problemas al obtener salones ---</option>";
					break;

			}
			selectSalones.html(salones);
		});
		
	}

	function obtenerListaPreciosSalones(){

		$.ajax({
			url: 'obtenerListaPreciosSalones.php',
		})
		.done(function(listaSalones){
			
			var jsonListaSalones = JSON.parse(listaSalones);
			var listaSalones = "";
			var hasta="";

			switch(jsonListaSalones.result){

				case "full":

					listaSalones = "<table class='table table-striped table-hover table-bordered table-condensed'><thead><tr><th>Nombre lista</th><th>Tipo de Lista</th><th>Sal&oacute;n</th><th>Desde</th><th>Hasta</th><th>Opciones</th></tr></thead><tbody>";

					for(i in jsonListaSalones.listasSalones){

						if (jsonListaSalones.listasSalones[i].fechaHasta == null) {
							hasta = '<td><span class="label label-info">Indefinido</span></td>';
						}else{
							hasta = '<td>'+jsonListaSalones.listasSalones[i].fechaHasta+'</td>';
						}

						listaSalones += "<tr><td>"+jsonListaSalones.listasSalones[i].nomLista+"</td><td>"+jsonListaSalones.listasSalones[i].tipo+"</td><td>"+jsonListaSalones.listasSalones[i].nomSalon+"</td><td>"+jsonListaSalones.listasSalones[i].fechaDesde+"</td>"+hasta+"<td><center><button id='btn_edit_lista' data-toggle='modal' data-target='#modalEditarListaSalon' type='button' data-salon='"+jsonListaSalones.listasSalones[i].codSalon+"' data-cod_precio='"+jsonListaSalones.listasSalones[i].codLista+"' class='btn btn-default btn-sm'><span class='fa fa-edit text-info'></span></button></center></td></tr>";
					}
					 /*onclick='editarListaSalon("+jsonListaSalones.listasSalones[i].codLista+", "+jsonListaSalones.listasSalones[i].codSalon+", \""+jsonListaSalones.listasSalones[i].observaciones+"\", \""+jsonListaSalones.listasSalones[i].fechaDesde+"\", \""+jsonListaSalones.listasSalones[i].fechaHasta+"\")'*/

					listaSalones += "</tbody></table>";

					break;

				case "vacio":

					listaSalones = "<div class='alert alert-warning'><span class='fa fa-exclamation-triangle'></span> No hay listas de precios de salones</div>";
					break;

				case "error":
					
					listaSalones = "<div class='alert alert-danger'><span class='fa fa-exclamation-triangle'></span> Error al obtener las listas de precios de salones</div>";
					break;
			}

			$("#tablaListasSalones").html(listaSalones);
		});	
	}

	/*function editarListaSalon(codLista, codSalon, observaciones, fechaDesde, fechaHasta){

		$("#editarObservaciones").val(observaciones);
		$("#editarFechaDesde").val(fechaDesde);
		$("#editarFechaHasta").val(fechaHasta);
		$("#modalEditarListaSalon").modal("show");

	}*/

	$(document).on('click', '#btn_edit_lista', function() {
		var cod_lista = $(this).data("cod_precio");
		var cod_salon = $(this).data("salon");

		$.ajax({
			url: 'editar_lista_precio.php',
			method: 'POST',
			data: {cod: cod_lista, cod_salon:cod_salon},
			success: function (data) {
				$('#edit_precio').html(data);
			}
		});

	});

	$(document).on('click', '#btn_editar_lista_salon', function() {
		 var precio 		= $('#sel_lista_precio').val();
		 var salon  		= $('#sel_lista_salon').val();
		 var fecha_desde	= $('#fecha_desde').val();	
		 var fecha_hasta    = $('#fecha_hasta').val();
		 var observaciones  = $('#observaciones').val();
		 //var tipo           = $('#sel_tipo').val();

		 $.ajax({
		 	url: 'editar_lista_precio_salones.php',
		 	method: 'POST',
		 	data: {precio:precio, salon:salon, fecha_desde:fecha_desde, fecha_hasta:fecha_hasta, observaciones:observaciones},
		 	success: function (data) {
		 		if (data == 1) {
		 			swal("Se ha modificado el precio para el salón.", "", "success");
		 			$('#modalEditarListaSalon').modal("hide");
		 			obtenerListaPreciosSalones();
		 		}
		 	}
		 });
	});

 $(document).ready(function() {
    conteoPermisos ();
});

</script>
</body>
</html>

<style>
	th,td{
		white-space: nowrap;
	}
</style>