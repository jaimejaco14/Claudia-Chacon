<?php
include '../head.php';
VerificarPrivilegio("PARAMETROS ASISTENCIA", $_SESSION['tipo_u'], $conn);

?>
<div class="modal fade" tabindex="-1" role="dialog" id="definir_param">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 id="title2" class="modal-title"><span class='fa fa-pencil-square-o'></span>  Nuevo parámetro de asistencia</h4>
			</div>
			<form id="form_newparam" name="form_newparam" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-gruop">
						<table class="table table-bordered">
							<tr>
								<th colspan="2" class="text-center">ENTRADA</th>
								<th colspan="2" class="text-center">SALIDA</th>
							</tr>
							<tr>
								<th class="text-center">Antes de:</th>
								<th class="text-center">Después de:</th>
								<th class="text-center">Antes de:</th>
								<th class="text-center">Después de:</th>
							</tr>
							<tr>
								<td class="text-center"><input name="enttemp" id="enttemp" type="number" min="0" max="999" maxlength="3" class="form-control numero" required title="Ingrese cuantos minutos antes de su hora de entrada puede registrar su llegada el colaborador"> Minutos </td>
								<td class="text-center"><input name="enttar" id="enttar" type="number" min="0" max="999" maxlength="3" class="form-control numero" required title="Ingrese cuantos minutos después de la hora de entrada puede registrar su llegada el colaborador"> Minutos </td>
								<td class="text-center"><input name="saltem" id="saltem" type="number" min="0" max="999" maxlength="3" class="form-control numero" required title="Ingrese cuantos minutos antes de la hora de finalizacion del turno, puede el colaborador registrar su salida"> Minutos </td>
								<td class="text-center"><input name="saltar" id="saltar" type="number" min="0" max="999" maxlength="3" class="form-control numero" required title="Ingrese cuantos minutos después de su hora normal de salida puede el colabrador registrar su salida"> Minutos </td>
							</tr>
						</table>
						
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
<div class="modal fade" tabindex="-1" role="dialog" id="editar_param">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 id="title2" class="modal-title"><span class='fa fa-edit'></span>  Editar parámetros de asistencia</h4>
			</div>
			<form id="form_edtparam" name="form_edtparam" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-gruop">
						<table class="table table-bordered">
							<tr>
								<th colspan="2" class="text-center">ENTRADA</th>
								<th colspan="2" class="text-center">SALIDA</th>
							</tr>
							<tr>
								<th class="text-center">Antes de:</th>
								<th class="text-center">Después de:</th>
								<th class="text-center">Antes de:</th>
								<th class="text-center">Después de:</th>
							</tr>
							<tr>
								<td class="text-center"><input name="enttemp2" id="enttemp2" type="number" min="0" max="999" maxlength="3" class="form-control numero" required> Minutos </td>
								<td class="text-center"><input name="enttar2" id="enttar2" type="number" min="0" max="999" maxlength="3" class="form-control numero" required> Minutos </td>
								<td class="text-center"><input name="saltem2" id="saltem2" type="number" min="0" max="999" maxlength="3" class="form-control numero" required> Minutos </td>
								<td class="text-center"><input name="saltar2" id="saltar2" type="number" min="0" max="999" maxlength="3" class="form-control numero" required> Minutos </td>
							</tr>
						</table>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-success">Guardar cambios</button>

				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<div class="">
	<div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="../inicio.php">Inicio</a></li>
                        <li class="active">
                            <span>Herramientas</span>
                        </li>
                        <li class="active">
                            <span>Parametros de asistencia</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					
					<div class="panel-body">
						<div>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-clock-o" style="font-size:20px"></i> Parámetros de asistencia</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="clase2" id="">
									<br>
									<div class="content small-header">
										<br>
										<div class="hpanel">
											<div class="panel-body">
												<div class="col-md-9">
													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
															
															</div>
														</div>
													</div>
												</div>
											</div>          
										</div> 
										<div id="contenido" class="content animated-panel">
											<table class="table table-bordered text-center">
												<tr>
													<th colspan="2" class="text-center">ENTRADA</th>
													<th colspan="2" class="text-center">SALIDA</th>
												</tr>
												<tr>
													<th class="text-center">Antes de:</th>
													<th class="text-center">Después de:</th>
													<th class="text-center">Antes de:</th>
													<th class="text-center">Después de:</th>
												</tr>
												<tr>
												<?php
													$sql="SELECT * FROM btyasistencia_parametros";
													$res=$conn->query($sql);
													$data=$res->fetch_assoc();
													if($res->num_rows>0){
														echo "<td>".$data['abmingresoantes']." Minutos</td><td>".$data['abmingresodespues']." Minutos</td><td>".$data['abmsalidaantes']." Minutos</td><td>".$data['abmsalidadespues']." Minutos</td></tr></table>";
														echo "<br><button class='btn btn-info' id='edtparam'><span class='fa fa-edit'></span>  Editar Parámetros</button>";
													}else{
														echo "<td colspan='4'>No se han definido los parámetros de asistencia.</td></tr></table>";
														echo "<br><button class='btn btn-info' id='defparam'><span class='fa fa-pencil-square-o'></span>  Definir Parámetros</button>";
													}
													
												?>
												
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
<?php
include '../librerias_js.php';
?>
<script>
		$("side-menu").children(".active").removeClass("active");  
$("#BIOMETRICO").addClass("active");
</script>
<script>
/*ABRIR MODAL NUEVO PARAMETRO DE ASISTENCIA*/
$("#defparam").click(function(e){
	$("#definir_param").modal('show');
	$('#body').removeClass("modal-open");
});
/********************************************************/
/*ABRIR MODAL EDITAR PARAMETRO DE ASISTENCIA */
$("#edtparam").click(function(e){
	var datastring='opc=BUS';
	//console.log(datastring);
	$.ajax({
		url:'oper_parametro_asist.php',
		type:'POST',
		data:datastring,
		success:function(res){
			//console.log(res);
			var datos=JSON.parse(res);
			$("#enttemp2").val(datos.enttemp);
			$("#enttar2").val(datos.enttar);
			$("#saltem2").val(datos.saltem);
			$("#saltar2").val(datos.saltar);
			$("#editar_param").modal('show');
			$('#body').removeClass("modal-open");
		}
	});
});

/********************************************************/
/*VALIDA SOLO NUMEROS Y MAXIMO 3 CIFRAS EN LOS CAMPOS NUMERICOS*/
$(".numero").keyup(function(e) {
	e.preventDefault();
	this.value = this.value.replace(/[^0-9]/g,'');
	if (this.value.length > 3) {
     this.value = this.value.slice(0,3); 
	}
});
/********************************************************/
/*GUARDAR NUEVO PARAMETRO DE ASISTENCIA*/
$("#form_newparam").submit(function(e){
	e.preventDefault();
	var datastring=$("#form_newparam").serialize();
	datastring+="&opc=NEW";
	//console.log(datastring);
	$.ajax({
		url:'oper_parametro_asist.php',
		type:'POST',
		data:datastring,
		success:function(res){
			$("#definir_param").modal('toggle');
			//console.log(res);
			if(res=="TRUE"){
				swal({
					title: "Correcto!",
					text: "Parametros de asistencia definidos correctamente.",
					type: "success",
					},function(isConfirm){
						location.reload();
				});
			}else{
				swal("ERROR","Hubo un error, recargue la página e intentelo nuevamente.","error");
			}

		}
	});

});
/***********************************************************/
/*GUARDAR EDICION DE PARAMETROS DE ASISTENCIA*/
$("#form_edtparam").submit(function(e){
	e.preventDefault();
	var datastring=$("#form_edtparam").serialize();
	datastring+="&opc=EDIT";
	//console.log(datastring);
	$.ajax({
		url:'oper_parametro_asist.php',
		type:'POST',
		data:datastring,
		success:function(res){
			$("#editar_param").modal('toggle');
			//console.log(res);
			if(res=="TRUE"){
				swal({
					title: "Correcto!",
					text: "Parametros de asistencia actualizados correctamente.",
					type: "success",
					},function(isConfirm){
						location.reload();
				});
			}else{
				swal("ERROR","Hubo un error, recargue la página e intentelo nuevamente.","error");
			}
		}
	});
});



</script>