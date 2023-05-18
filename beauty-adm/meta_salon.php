<?php
include '../cnx_data.php';
include 'head.php';
VerificarPrivilegio("META", $_SESSION['tipo_u'], $conn);
?>
<div class="content animated-panel">
	<!-- Modal set nueva meta -->
	<div class="modal fade" tabindex="-1" role="dialog" id="set_meta">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Nueva Meta Salón - Cargo</h4>
				</div>
				<form id="form_newmeta" name="form_newmeta" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-gruop">
							<label>Mes</label>
							<select name="metames" id="metames" class="form-control" required>
								<option value="">-Seleccione una opción-</option>
								<option value="1">ENERO</option>
								<option value="2">FEBRERO</option>
								<option value="3">MARZO</option>
								<option value="4">ABRIL</option>
								<option value="5">MAYO</option>
								<option value="6">JUNIO</option>
								<option value="7">JULIO</option>
								<option value="8">AGOSTO</option>
								<option value="9">SEPTIEMBRE</option>
								<option value="10">OCTUBRE</option>
								<option value="11">NOVIEMBRE</option>
								<option value="12">DICIEMBRE</option>
							</select>
						</div>
						<div class="form-gruop">
							<label>Salón</label>
							<select class="form-control" name="metasalon" id="metasalon" data-error="Escoja una opcion" required>
							<option value="">-Seleccione una opción-</option>
                                <?php
                     
                                $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
                                    }
                                }
                
                                ?>
                            </select>		
						</div>  
						<div class="form-group">
                            <label>Cargo</label>
                            <select class="form-control" name="metacargo" id="metacargo" data-error="Escoja una opcion" required>
                            <option value="">-Seleccione una opción-</option>
                                <?php
                              
                                $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo ORDER BY crgnombre");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                    }
                                }
                              
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tipo de meta</label>
                            <select class="form-control" name="metatipo" id="metatipo" data-error="Escoja una opcion" required>
                            <option value="">-Seleccione una opción-</option>
                                <option value="PORCENTAJE">PORCENTAJE</option>
                                <option value="VALOR">VALOR</option>
                            </select>
                        </div>
						<div class="form-group" id="form-check">
			                <div class="input-group input-group-sm">
	                            <span class="input-group">
	                                <label class="btn btn-default">
	                                    <input type="checkbox" name="metaref" id="metaref"> <b>  Punto de referencia</b>
	                                </label>
	                            </span>
			                </div>
			            </div>
						<div class="form-group">
                            <label>Valor</label>
                            <input type="text" name="metaval" id="metaval" class="form-control" required>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success">Guardar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- Modal editar meta -->
	<div class="modal fade" tabindex="-1" role="dialog" id="edit_meta">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-edit"></i> Editar Meta Salón - Cargo</h4>
				</div>
				<form id="form_editmeta" name="form_editmeta" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-gruop">
							<label>Mes</label>
							<select name="editmetames" id="editmetames" class="form-control" required>
								<option value="">-Seleccione una opción-</option>
								<option value="1">ENERO</option>
								<option value="2">FEBRERO</option>
								<option value="3">MARZO</option>
								<option value="4">ABRIL</option>
								<option value="5">MAYO</option>
								<option value="6">JUNIO</option>
								<option value="7">JULIO</option>
								<option value="8">AGOSTO</option>
								<option value="9">SEPTIEMBRE</option>
								<option value="10">OCTUBRE</option>
								<option value="11">NOVIEMBRE</option>
								<option value="12">DICIEMBRE</option>
							</select>
							<input type="hidden" id="mesh" name="mesh">
						</div>
						<div class="form-gruop">
							<label>Salón</label>
							<select class="form-control" name="editmetasalon" id="editmetasalon" data-error="Escoja una opcion" required>
							<option value="">-Seleccione una opción-</option>
                                <?php
                               
                                $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
                                    }
                                }
                            
                                ?>
                            </select>	
                            <input type="hidden" id="slnh" name="slnh">	
						</div>  
						<div class="form-group">
                            <label>Cargo</label>
                            <select class="form-control" name="editmetacargo" id="editmetacargo" data-error="Escoja una opcion" required>
                            <option value="">-Seleccione una opción-</option>
                                <?php
                  
                                $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo ORDER BY crgnombre");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                    }
                                }
                          
                                ?>
                            </select>
                            <input type="hidden" id="crgh" name="crgh">
                        </div>
                        <div class="form-group">
                            <label>Tipo de meta</label>
                            <select class="form-control" name="editmetatipo" id="editmetatipo" data-error="Escoja una opcion" required>
                            <option value="">-Seleccione una opción-</option>
                                <option value="PORCENTAJE">PORCENTAJE</option>
                                <option value="VALOR">VALOR</option>
                            </select>
                            <input type="hidden" id="tpoh" name="tpoh">
                        </div>
						<div class="form-group" id="form-editcheck" style="display:none;">
			                <div class="input-group input-group-sm">
	                            <span class="input-group">
	                                <label class="btn btn-default">
	                                    <input type="checkbox" name="editmetaref" id="editmetaref"> <b>  Punto de referencia</b>
	                                </label>
	                            </span>
			                </div>
			            </div>
						<div class="form-group">
                            <label>Valor</label>
                            <input type="text" name="editmetaval" id="editmetaval" class="form-control" required>
                            <input type="hidden" id="valh" name="valh">
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success">Guardar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal copiar meta -->
	<div class="modal fade" tabindex="-1" role="dialog" id="copy_meta">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">COPIAR META</h4>
				</div>
				<form id="form_copymeta" name="form_copymeta" method="post" enctype="multipart/form-data">
				
					<div class="modal-body">
						
						<div class="row">
							<center><b>Seleccione los datos que desea copiar</b></center>
							<br>	
							<div class="form-group col-md-2">
								<label>Mes</label>
							</div>
							<div class="form-group col-md-9">
								<select name="copymetames" id="copymetames" class="form-control" required>
									<option value="">-Seleccione una opción-</option>
									<option value="1">ENERO</option>
									<option value="2">FEBRERO</option>
									<option value="3">MARZO</option>
									<option value="4">ABRIL</option>
									<option value="5">MAYO</option>
									<option value="6">JUNIO</option>
									<option value="7">JULIO</option>
									<option value="8">AGOSTO</option>
									<option value="9">SEPTIEMBRE</option>
									<option value="10">OCTUBRE</option>
									<option value="11">NOVIEMBRE</option>
									<option value="12">DICIEMBRE</option>
								</select>
							</div>
							<div class="form-group col-md-2"><label>Salón</label></div>	
							<div class="form-group col-md-9">
								<select class="form-control" name="copymetasalon" id="copymetasalon" data-error="Escoja una opcion" disabled required>
									<option value="">-Seleccione una opción-</option>
	                                <?php
	                               
	                                $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
	                                if ($result->num_rows > 0) {
	                                    while ($row = $result->fetch_assoc()) {                
	                                        echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
	                                    }
	                                }
	                                
	                                ?>
                            	</select>		
							</div>
						</div>
						<div class="col-md-12" style="background-color:gray;"></div>
						<br>
						<div class="row">
							<center><b>Seleccione el destino de los datos a copiar</b></center>
							<br>	
							<div class="form-group col-md-2">
								<label>Mes</label>
							</div>
							<div class="form-group col-md-9">
								<select name="destmetames" id="destmetames" class="form-control" disabled required>
									<option value="">-Seleccione una opción-</option>
									<option value="1">ENERO</option>
									<option value="2">FEBRERO</option>
									<option value="3">MARZO</option>
									<option value="4">ABRIL</option>
									<option value="5">MAYO</option>
									<option value="6">JUNIO</option>
									<option value="7">JULIO</option>
									<option value="8">AGOSTO</option>
									<option value="9">SEPTIEMBRE</option>
									<option value="10">OCTUBRE</option>
									<option value="11">NOVIEMBRE</option>
									<option value="12">DICIEMBRE</option>
								</select>
							</div>
							<div class="form-group col-md-2"><label>Salón</label></div>	
							<div class="form-group col-md-9">
								<select class="form-control" name="destmetasalon" id="destmetasalon" data-error="Escoja una opcion" disabled required>
									<option value="">-Seleccione una opción-</option>
	                                <?php
	                               
	                                $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
	                                if ($result->num_rows > 0) {
	                                    while ($row = $result->fetch_assoc()) {                
	                                        echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
	                                    }
	                                }
	                              
	                                ?>
                            	</select>		
							</div>
						</div>
						<div class="col-md-12" style="background-color:gray;"></div>
						<br>
						<center><b id="mnsj" style="display:none;">Los datos se copiarán en:</b></center>
						<div id="destinos" style="display:none;">
						
						</div>
							
					</div>
					<div class="modal-footer">
						<button class="btn btn-default pull-left" disabled id="masdest" disabled><span class="fa fa-plus"></span>  Agregar otro destino</button>
						<button type="button" id="cerrar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" id="copiar" name="copiar" class="btn btn-success" >Copiar</button>
						<button type="button" id="multicopiar" name="multicopiar" class="btn btn-success" style="display:none;" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Copiando...">Copiar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<div class="">
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					<div class="panel-heading">
						
						META POR MES, SALÓN Y CARGO
					</div>
					<div class="panel-body">
						<div>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#divHorario" aria-controls="divHorario" role="tab" data-toggle="tab">Metas</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="clase2" id="divHorario">
									<br>
									<div class="content small-header">
										<br>
										<div class="hpanel">
											<div class="panel-body">
												<div class="col-md-9">
													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
															<table class="table">
																<thead>
																	<tr>
																		<th>
																			<select name="filtromes" id="filtromes" class="form-control">
																				<option value="0">Filtrar por mes</option>
																				<option value="1">ENERO</option>
																				<option value="2">FEBRERO</option>
																				<option value="3">MARZO</option>
																				<option value="4">ABRIL</option>
																				<option value="5">MAYO</option>
																				<option value="6">JUNIO</option>
																				<option value="7">JULIO</option>
																				<option value="8">AGOSTO</option>
																				<option value="9">SEPTIEMBRE</option>
																				<option value="10">OCTUBRE</option>
																				<option value="11">NOVIEMBRE</option>
																				<option value="12">DICIEMBRE</option>
																				
																			</select>
																		</th>	
																		<th>
																			<select name="filtrosln" id="filtrosln" class="form-control">
																				<option value="0">Filtrar por salon</option>
																				<?php
													                            
													                                $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
													                                if ($result->num_rows > 0) {
													                                    while ($row = $result->fetch_assoc()) {                
													                                        echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
													                                    }
													                                }
													                           
													                                ?>
																			</select>
																		</th>
																		<th>
																			<select name="filtrocrg" id="filtrocrg" class="form-control">
																				<option value="0">Filtrar por cargo</option>
																				<?php
												                               
												                                $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo ORDER BY crgnombre");
												                                if ($result->num_rows > 0) {
												                                    while ($row = $result->fetch_assoc()) {                
												                                        echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
												                                    }
												                                }
												                            
												                                ?>
																			</select>
																		</th>
																		<th>
																			<a><button id="btn" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nueva meta"><i class="fa fa-plus-square-o text-info"></i></button></a>
																		</th>
																		<th>
																			<a><button id="copy" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Copiar meta"><i class="fa fa-copy text-info"></i></button></a>
																		</th>
																		<th>
																			<a><button id="PDF" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Export PDF"><i class="fa fa-file-pdf-o text-info"></i></button></a>
																		</th>
																		<th>
																			<a><button id="EXCEL" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Export Excel"><i class="fa fa-file-excel-o text-info"></i></button></a>
																		</th>
																	</tr>
																</thead>
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>          
										</div> 
										<div id="contenido" class="content animated-panel">
											<?php include "find_metasalon.php"; ?>   
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



	<!-- Vendor scripts -->
	<?php include "librerias_js.php"; ?>
	<script>
		$("side-menu").children(".active").removeClass("active");  
		$("#SALONES").addClass("active");
		$("#METAS").addClass("active");


		$(document).ready(function() {
			$('#body').removeClass("modal-open").removeAttr('style');
		});  
	</script>
	<script type="text/javascript">
		$('.modal').modal({backdrop: "static", keyboard: false, show: false});

		


/********************************************************************************************************************/
/********************************FUNCIONES SELECT OPTION MODAL COPIAR META*******************************************/
/********************************************************************************************************************/

/*************select origen**********************/

$("#copymetames").change(function(e){
	e.preventDefault();
	$("#copymetasalon").removeAttr("disabled");
});
$("#copymetasalon").change(function(e){
	e.preventDefault();
	$("#destmetames").removeAttr("disabled");
});
/*************select destino********************/

$("#destmetames").change(function(e){
	e.preventDefault();
	if(($("#copymetames").val()!=0)&&($("#copymetasalon").val()!=0)){
		$("#destmetasalon").removeAttr("disabled");
		$("#copymetames").attr('disabled','disabled')
		$("#copymetasalon").attr('disabled','disabled')
	}
	
});
$("#destmetasalon").change(function(e){
	e.preventDefault();
	$("#destmetames").attr('disabled','disabled')
	$("#destmetasalon").attr('disabled','disabled')
	$("#masdest").removeAttr("disabled");	




	$("#destinos").show();
	$("#copiar").hide();
	$("#multicopiar").show();
	var dmes=$("#destmetames").val();
	var nommes=$("#destmetames option:selected").text();
	var dsln=$("#destmetasalon").val();
	var nomsln=$("#destmetasalon option:selected").text();
	if($("#destinos div").length==0){
		$("#mnsj").show();
	}

	if(($("#destmetames").val()!=0)&&($("#destmetasalon").val()!=0))
	{
		$("#destinos").append('<div><button class="btn btn-sm" title="Quitar" onclick="$(this).parent().remove();"> <span class="fa fa-trash"></span></button><label>'+nomsln+' - '+nommes+'</label><input id="mtamesh" name="mtamesh" class="mtamesh" type="hidden" value='+dmes+'><input id="mtaslnh" name="mtaslnh" class="mtaslnh" type="hidden" value='+dsln+'></div>');
	}
	
});
/**************btn agregar destino***************/

$("#masdest").click(function(e){
	e.preventDefault();
	$("#destmetames").removeAttr("disabled");
	$("#destmetames").prop('selectedIndex', 0);
	$("#destmetasalon").removeAttr("disabled");
	$("#destmetasalon").prop('selectedIndex', 0);
	$("#destmetasalon").attr('disabled','disabled');
});
/***************************************************************/

$("#multicopiar").click(function(e){

	if($("#destinos div").length>0){
		var $this = $(this);
		$this.button('loading');//deshabilita el boton "copiar" y le pone animacion de cargando...
		$("#cerrar").attr('disabled','disabled');//deshabilita el boton cerrar modal
		$("#masdest").attr('disabled','disabled');//deshabilita el boton "agregar otro destino"

		var slnref=$("#copymetasalon").val();//valor de referencia del salon elegido para copiar
		var mesref=$("#copymetames").val();//valor de referencia del mes elegido para copiar
		var mes="";
		//se contruye un "array" con los datos de los datos de los input hidden que tiene la clase mtamesh
		$(".mtamesh").each(
			function(index,value){
				mes+=$(this).val()+"•";//se usa "•" como separador de datos
		});
		//se construye un "array" con los datos de los datos de los input hidden que tiene la clase mtaslnh
		var sln="";
		$(".mtaslnh").each(
			function(index,value){
				sln+=$(this).val()+"•";//se usa "•" como separador de datos 
		});
		//se envia el case(MULTI), los 2 "arrays" y los datos de referencia a la url definida
		var dataString = "oper=MULTI&mes="+mes+"&sln="+sln+"&mesr="+mesref+"&slnr="+slnref; 
		console.log(dataString);
		$.ajax({
			type: "POST",
			url: "oper_metasalon.php",
			data: dataString,
			success: function (res) 
			{
				//console.log(res);
				if(res=="TRUE"){
					$("#copy_meta").modal('toggle');
					swal({
						title: "Correcto!",
						text: "Los registros se copiaron exitosamente.",
						type: "success",
					},function(isConfirm){
						reload_div();
						resetcopy();
					});
				}else if(res=="FALSE"){
					swal("ERROR","Oops! Algo pasó... refresque la página e intentelo nuevamente.","error");
				}
				else if(res=="NOREG")
				{
					swal("ERROR","Los datos que intenta copiar no existen.","error");
					swal({
						title: "ERROR!",
						text: "Los datos que intenta copiar no existen.",
						type: "error",
					},function(isConfirm){
						$("#copy_meta").modal('toggle');//cierra el modal
						resetcopy();//resetea el formulario y deshabilita los campos correspondientes
					});
				}	
			}
		});     
		
	}else{
		swal("ERROR","No hay elementos de destino","error");
	}
});


/*******************************************************************************************************************/
		function paginar(id) 
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			var dataString="filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg+"&page="+id;
			$.ajax({
				type: "POST",
				url: "find_metasalon.php",
				data: dataString
			}).done(function (a) {
				$('#contenido').html(a);
			}).fail(function () {
				alert('Error al cargar modulo');
			});
		}

		/******************************************************************************************************/
		$('#form_newmeta').on("submit", function(event)
		{
			event.preventDefault();
			var num=$("#metaval").val();
			num=num.replace(".","");
			num=num.replace(".","");
			num=num.replace(".","");
			$("#metaval").val(num);
			var formData = "oper=NEW&"+$("#form_newmeta").serialize();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url:  "oper_metasalon.php",
				data: formData,
				success: function (res) 
				{
					//console.log(res);
					$("#set_meta").modal('toggle');
					if(res=="TRUE"){
						swal({
							title: "Correcto!",
							text: "La nueva meta ha sido creada.",
							type: "success",
						},function(isConfirm){
							reload_div();
						});
					}
					else if(res == "DUPLI"){
						swal({
							title: "Alerta Duplicado!",
							text: "La meta que intenta agregar ya está registrada. Por favor verifique.",
							type: "error",
						},
						function(isConfirm){
							$("#set_meta").modal('show');
						});
						
					}
					else if(res=="FALSE"){
						swal("ERROR", "Oops! Ha ocurrido un error inesperado, recargue la pagina e intentelo nuevamente.", "error");
					}
					else if(res=="REF"){
						//swal("ERROR", "Ya existe un punto de referencia este mes en este salon.", "error");
						swal({
							title: "ERROR!",
							text: "Ya existe un punto de referencia este mes en este salon.",
							type: "error",
						},
						function(isConfirm){
							$("#set_meta").modal('show');
						});
					}
	        	}
	    	});
		});


		function reload_div(){
			$("#contenido").html('');
			$("#contenido").load('find_metasalon.php');
			$("#form_newmeta")[0].reset();
			$("#form_editmeta")[0].reset();
		}

		function resetcopy(){
			$("#destinos").html('');
			$("#copymetames").removeAttr("disabled");
			$("#copymetasalon").attr('disabled','disabled');
			$("#destmetames").attr('disabled','disabled');
			$("#destmetasalon").attr('disabled','disabled');
			$("#form_copymeta")[0].reset();
			$("#masdest").attr('disabled','disabled');
			$("#mnsj").hide();
			$("#multicopiar").text('copiar');
			$("#multicopiar").removeAttr("disabled");
			$("#multicopiar").removeClass("disabled");
			$("#cerrar").removeAttr("disabled");
		}

		function eliminar(mes,sln,crg) 
		{

			swal({
				title: "¿Seguro que desea eliminar esta meta?",
				text: "Esta acción NO se puede deshacer.",
				type: "warning",
				showCancelButton:  true,
				cancelButtonText:"No",
				confirmButtonText: "Sí"
				
			},
			function(){

				var dataString = "oper=DEL&mes="+mes+"&sln="+sln+"&crg="+crg; 
				//console.log(dataString);
				$.ajax({
					type: "POST",
					url: "oper_metasalon.php",
					data: dataString,
					success: function (res) 
					{
						if(res=="TRUE"){
							setTimeout(function () {
								swal("Eliminado!","","success");
								
							}, 200);    	
							reload_div();
						}else{
							swal("ERROR","Oops! Algo pasó... refresque la página e intentelo nuevamente.","error");
						}
						
					}
				});        	
			});
		}
		function editar(mes,sln,crg) 
		{
			$("#form_editmeta")[0].reset();
			var dataString = "oper=BUS&mes="+mes+"&sln="+sln+"&crg="+crg; 
			$.ajax({
				type: "POST",
				url: "oper_metasalon.php",
				data: dataString,
				success: function (ans) 
				{
					var jsonres = JSON.parse(ans);
					if(jsonres.RES=="FALSE"){
						swal("ERROR", "Oops! Ha ocurrido un error inesperado, recargue la pagina e intentelo nuevamente.", "error");
					}else{
						$("#edit_meta").modal('show');
						$('#body').removeClass("modal-open");
						//$("#form-editcheck").css('display','none');
						$("#editmetames").val(jsonres.mes);
						$("#editmetasalon").val(jsonres.sln);
						$("#editmetacargo").val(jsonres.crg);
						$("#editmetatipo").val(jsonres.tpo);
						//console.log('*'+jsonres.tpo+'*');
						if(jsonres.tpo=='VALOR'){
							$("#form-editcheck").show();
						}else{
							$("#form-editcheck").hide();
						}
						if(jsonres.ref==1){
							$("#editmetaref").prop('checked', true);
						}
						$("#editmetaval").val(jsonres.val);
						//campos ocultos valores antes de editar
						$("#mesh").val(jsonres.mes);
						$("#slnh").val(jsonres.sln);
						$("#crgh").val(jsonres.crg);
						$("#tpoh").val(jsonres.tpo);
						$("#refh").val(jsonres.ref);
						$("#valh").val(jsonres.val);
					}
				}
			});     
		}

		$("#form_editmeta").submit(function(e){
			e.preventDefault();
			var num=$("#editmetaval").val();
			num=num.replace(".","");
			num=num.replace(".","");
			num=num.replace(".","");
			$("#editmetaval").val(num);
			var formData = "oper=UPD&"+$("#form_editmeta").serialize();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url:  "oper_metasalon.php",
				data: formData,
				success: function (res) 
				{
					$("#edit_meta").modal('toggle');
					if(res=="DUPLI"){
						swal("Alerta Duplicado","El nombre/alias que intenta agregar ya está registrado. Por favor verifique.","error");
					}
					else if(res=="OK"){
						swal("Correcto","Los cambios han sido guardados.","success");
					}
					else if(res=="REF"){
						swal("ERROR","Ya existe un punto de referencia este mes en este salon.","error");
					}else if(res=="FALSE"){
						swal("ERROR","Oops! Algo pasó... refresque la página e intentelo nuevamente.","error");
					}

					reload_div();
				}
			});
		});


		$('#btn').click(function()
		{
			$("#form_newmeta")[0].reset();
			$("#form_editmeta")[0].reset();
			$('#set_meta').modal('show');
			$('#body').removeClass("modal-open");

		}); 

		$('#copy').click(function()
		{
			resetcopy();
			$('#copy_meta').modal('show');
		});

		$('#filtromes').change(function()
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			var dataString="filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg;
			//console.log(dataString);
			$.ajax({
				type: "POST",
				url: "find_metasalon.php",
				data: dataString,
				success: function(data) 
				{
					$("#contenido").html('');
					$("#contenido").html(data);
				}
			});
		});
		$('#filtrosln').change(function()
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			var dataString="filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg;
			//console.log(dataString);
			$.ajax({
				type: "POST",
				url: "find_metasalon.php",
				data: dataString,
				success: function(data) 
				{
					$("#contenido").html('');
					$("#contenido").html(data);
				}
			});
		});
		$('#filtrocrg').change(function()
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			var dataString="filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg;
			//console.log(dataString);
			$.ajax({
				type: "POST",
				url: "find_metasalon.php",
				data: dataString,
				success: function(data) 
				{
					$("#contenido").html('');
					$("#contenido").html(data);
				}
			});
		});

		$("#metaval").on({
		    "focus": function (event) {
		        $(event.target).select();
		    },
		    "keyup": function (event) {
		        $(event.target).val(function (index, value ) {
		            return value.replace(/\D/g, "")
		                        .replace(/([0-9])([0-9]{3})$/, '$1.$2')
		                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		        });
		    }
		});
		$("#editmetaval").on({
		    "focus": function (event) {
		        $(event.target).select();
		        $("#editmetaval").val();
		    },
		    "keyup": function (event) {
		        $(event.target).val(function (index, value ) {
		            return value.replace(/\D/g, "")
		                        .replace(/([0-9])([0-9]{3})$/, '$1.$2')
		                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		        });
		    }
		});

		$("#metatipo").change(function(e){
			var selectval=$("#metatipo option:selected").val();
			if(selectval=='PORCENTAJE'){
				$("#form-check").hide();
				$("#metaref").prop('checked',false);
			}else{
				$("#form-check").show();
			}
		});

		$("#editmetatipo").change(function(e){
			var selectval=$("#editmetatipo option:selected").val();
			if(selectval=='PORCENTAJE'){
				$("#form-editcheck").hide();
				$("#editmetaref").prop('checked',false);
			}else{
				$("#form-editcheck").show();
			}
		});




		$(document).on('click', '#PDF', function() 
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			window.open("export_metasalon.php?mode=PDF&filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg+"");
		});

		$(document).on('click', '#EXCEL', function() 
		{
			var mes = $("#filtromes").val();
			var sln = $("#filtrosln").val();
			var crg = $("#filtrocrg").val();
			window.open("export_metasalon.php?mode=EXC&filtromes="+mes+"&filtrosln="+sln+"&filtrocrg="+crg+"");
		});

 $(document).ready(function() {
    conteoPermisos ();
});
	</script>
</body>
</html>