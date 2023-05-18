<?php
include '../head.php';
?>
<div class="content animated-panel">
	<!-- Modal nuevo tipo de puesto de trabajo -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_ptr">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Nuevo tipo de puesto</h4>
				</div>
				<form id="form_newtipu" name="form_hora" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-gruop">
							<label>Nombre</label>
							<input type="text" name="tipu_nombre" id="tipu_nombre" value="" placeholder="Nombre del tipo de puesto" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" required>
						</div>
						<div class="form-gruop">
							<label>Alias</label>
							<input type="text" name="tipu_alias" id="tipu_alias" value="" placeholder="Alias o abreviatura del tipo de puesto" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" maxlength="4" required>
						</div> 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="button" id="validar" class="btn btn-success">Guardar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- Modal editar puesto de trabajo -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_up">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Actualizar tipo de puesto </h4>
				</div>
				<form id="form_edit_tipu" name="form_edit_tipu" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-gruop">
							<label>Nombre</label>
							<input type="text" name="edit_nombre" id="edit_nombre" value="" placeholder="Nombre del tipo de puesto" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" required>
							<input type="hidden" id="hiddennom">
						</div>
						<div class="form-gruop">
							<label>Alias</label>
							<input type="text" name="edit_alias" id="edit_alias" value="" placeholder="Alias o abreviatura del tipo de puesto" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" maxlength="4" required>
							<input type="hidden" id="hiddenali">
							<input type="hidden" id="hiddencod">
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


	<div class="">
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					<div class="panel-heading">
						
						TIPO DE PUESTOS DE TRABAJO
					</div>
					<div class="panel-body">
						<div>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#divHorario" aria-controls="divHorario" role="tab" data-toggle="tab">Tipo de puesto</a></li>
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
																<input type="text" name="input_buscar" id="input_buscar" class="form-control" value="" placeholder="Buscar por nombre del tipo de puesto">
																<div class="input-group-btn">

																	<a><button id="btn" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo tipo de puesto"><i class="fa fa-plus-square-o text-info"></i></button></a>

																</div>
																<div class="input-group">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>          
										</div> 
										<div id="contenido" class="content animated-panel">
											<?php include "find_tipopuesto.php"; ?>   
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
	<?php include "../librerias_js.php"; ?>
	<script>
		$("side-menu").children(".active").removeClass("active");  
		$("#SALONES").addClass("active");
		$("#TIPO_PUESTO").addClass("active");


		$(document).ready(function() {
			$('#body').removeClass("modal-open").removeAttr('style');
		});  
	</script>
	<script type="text/javascript">
		$('.modal').modal({backdrop: "static", keyboard: false, show: false});

		

		function paginar(id) 
		{
			$.ajax({
				type: "POST",
				url: "find_tipopuesto.php",
				data: {operacion: 'update', page: id}
			}).done(function (a) {
				$('#contenido').html(a);
			}).fail(function () {
				alert('Error al cargar modulo');
			});
		}

		function paginar_tipopuesto (id) 
		{
			var salon = $('#salon').val();
			$.ajax({
				type: "POST",
				url: "find_turno_salon.php",
				data: {sln_cod: salon, page: id}
			}).done(function (a) {
				$('#contenido1').html(a);
			}).fail(function () {
				alert('Error al cargar modulo');
			});
		}




		/******************************************************************************************************/
		$('#validar').on("click", function(event)
		{
			event.preventDefault();
			var nombre=$("#tipu_nombre").val();
			var alias=$("#tipu_alias").val();
			var formData="oper=NEW&nombre="+nombre+"&alias="+alias;
			$.ajax({
				type: "POST",
				url:  "oper_tipo_puesto.php",
				data: formData,
				
				success: function (res) 
				{
					$("#modal_ptr").modal('toggle');

					var jsonres = JSON.parse(res);

					if(jsonres.RES=="TRUE"){
						swal({
							title: "Correcto!",
							text: "El nuevo tipo de puesto ha sido creado.",
							type: "success",
						},
						function(isConfirm){

						});
					}
					else if(jsonres.RES == "DUPLI"){
						swal({
							title: "Alerta Duplicado!",
							text: "El nombre/alias que intenta agregar ya está registrado. Por favor verifique.",
							type: "error",
						},
						function(isConfirm){
							$("#modal_ptr").modal('show');
						});
						
					}
					else if(jsonres.RES == "INACT")
					{
						
						swal({
							title: "Aviso!",
							text: "Éste nombre/alias ya se encuentra registrado, pero inactivo. ¿Desea activarlo nuevamente?",
							type: "warning",
							showCancelButton:  true,
							cancelButtonText:"No",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Sí"
							
						},
						function(){

							var cod = jsonres.codigo;
							var dataString = "oper=RAC&codigo="+cod;
							console.log(dataString);
							$.ajax({
								type: "POST",
								url: "oper_tipo_puesto.php",
								data: dataString,
								success: function () 
								{
									setTimeout(function () {
										swal("Reactivado!");
									}, 100);
									reload_div();
								}
							});
							
						});
					}else if(jsonres.RES=="FALSE"){
						swal("ERROR", "Oops! Ha ocurrido un error inesperado, recargue la pagina e intentelo nuevamente.", "error");
					}
	        	//reload_div();
	        }
	    });
		});


		function reload_div(){
			$("#contenido").html('');
			$("#contenido").load('find_tipopuesto.php');
			$("#form_newtipu")[0].reset();
			$("#form_edit_tipu")[0].reset();
		}

		function eliminar(id) 
		{

			swal({
				title: "¿Seguro que desea eliminar este tipo de puesto?",
				text: "",
				type: "warning",
				showCancelButton:  true,
				cancelButtonText:"No",
				confirmButtonText: "Sí"
				
			},
			function(){

				var dataString = "oper=DEL&codigo="+id; 
				console.log(dataString);
				$.ajax({
					type: "POST",
					url: "oper_tipo_puesto.php",
					data: dataString,
					success: function () 
					{
						
						setTimeout(function () {
							swal("Eliminado!");
							
						}, 200);    	
						reload_div();
					}
				});        	
			});
		}
		function editar(id) 
		{

			var dataString = "oper=BUS&codigo="+id; 
			$.ajax({
				type: "POST",
				url: "oper_tipo_puesto.php",
				data: dataString,
				success: function (ans) 
				{
					var jsonres = JSON.parse(ans);
					if(jsonres.RES=="FALSE"){
						swal("ERROR", "Oops! Ha ocurrido un error inesperado, recargue la pagina e intentelo nuevamente.", "error");
					}else{
						$("#modal_up").modal('show');
						$("#edit_nombre").val(jsonres.NOM);
						$("#hiddennom").val(jsonres.NOM);
						$("#edit_alias").val(jsonres.ALI);
						$("#hiddenali").val(jsonres.ALI);
						$("#hiddencod").val(jsonres.COD);
					}
				}
			});     
		}

		$("#form_edit_tipu").submit(function(e){
			e.preventDefault();
			var nombre=$("#edit_nombre").val();
			var alias=$("#edit_alias").val();
			var nomold=$("#hiddennom").val();
			var aliold=$("#hiddenali").val();
			var cod=$("#hiddencod").val();
			if((nombre==nomold)&&(alias==aliold)){
				$("#modal_up").modal('toggle');
			}else{
				var formData="oper=UPD&codigo="+cod+"&nombre="+nombre+"&alias="+alias;
				$.ajax({
					type: "POST",
					url:  "oper_tipo_puesto.php",
					data: formData,
					success: function (res) 
					{
						$("#modal_up").modal('toggle');
						if(res=="DUPLI"){
							swal("Alerta Duplicado","El nombre/alias que intenta agregar ya está registrado. Por favor verifique.","error");
						}else{
							swal("Correcto","Los cambios han sido guardados.","success");
						}
						reload_div();
					}
				});
			}
		});


		$('#btn').click(function()
		{
			$('#modal_ptr').modal('show');
		}); 


		$('#input_buscar').keyup(function() 
		{
			var dataString = "nombre="+$(this).val();
			$.ajax({
				type: "POST",
				url: "find_tipopuesto.php",
				data: dataString,
				success: function(data) 
				{
					$("#contenido").html(data);
				}
			});
		});




		


 $(document).ready(function() {
    //conteoPermisos ();
});
	</script>
</body>
</html>