<?php 
include 'head.php';
include 'librerias_js.php';
?>
<style type="text/css">
	.hpanel{
		cursor:pointer;
	}
	.bold{
		font-weight: bold;
	}
</style>
<div class="content">
	<div class="opciones">
		<div class="col-md-6">
	        <div class="hpanel hbggreen opcsolicitudes">
	            <div class="panel-body">
	                <div class="text-center">
	                    <h3>SOLICITUDES</h3>
	                    <p class="text-big font-light"><i class="fa fa-file"></i></p>
	                    <small>Ver solicitudes clasificadas por tipo</small>
	                </div>
	            </div>
	        </div>
	    </div>
		<div class="col-md-6">
	        <div class="hpanel hbgblue opcconfig">
	            <div class="panel-body">
	                <div class="text-center">
	                    <h3>CONFIGURACIONES</h3>
	                    <p class="text-big font-light"><i class="fa fa-gear"></i></p>
	                    <small>Opciones de configuración</small>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="divsolicitudes opc hidden">
		<button class="btngoback btn btn-default">Regresar</button><br>
		<h4 class="text-center">HISTORIAL GENERAL DE SOLICITUDES</h4>
		<div class="table-responsive">
			<table id="tbsolgen" class="table table-hover" style="width:90%">
				<thead>
					<tr>
						<th class="text-center">TIPO</th>
						<th>SOLICITANTE</th>
						<th class="text-center">RADICADO</th>
						<th class="text-center">DPTO RESPONSABLE</th>
						<th class="text-center">ESTADO</th>
						<th class="text-center">TIEMPO</th>
						<th class="text-center">OPCIONES</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<div class="divconfig opc hidden">
		<button class="btngoback btn btn-default">Regresar</button><br>
		<h4>CONFIGURACIÓN DE SOLICITUDES</h4>
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#solperson" aria-controls="tab" role="tab" data-toggle="tab">DEPARTAMENTOS</a>
				</li>
				<li role="presentation">
					<a href="#soltipo" aria-controls="soltipo" role="tab" data-toggle="tab">TIPOS DE SOLICITUDES</a>
				</li>
			</ul>
		
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="solperson"><br>
					<a id="btnnewdpto" data-toggle="modal" href='#modal-newdpto' class="btn btn-info"><i class="fa fa-plus"></i> Nuevo Departamento</a><br>
					<h4 id="loading1"><i class="fa fa-spin fa-spinner"></i> Cargando departamentos, por favor espere...</h4>
					<table id="tbdpto" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre Departamento</th>
								<th>Usuario vinculado</th>
								<th>Correo notificaciones</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane" id="soltipo"><br>
					<a data-toggle="modal" href='#modal-newts' class="btn btn-info"><i class="fa fa-plus"></i> Nuevo Tipo de Solicitud</a>
					<h4 id="loading2"><i class="fa fa-spin fa-spinner"></i> Cargando tipos de solicitudes, por favor espere...</h4>
					<table id="tbtisol" class="table table-hover">
						<thead>
							<tr>
								<th>NOMBRE</th>
								<th>DPTO RESPONSABLE</th>
								<th>ATENDIDO POR</th>
								<th class="text-center">OPCIONES</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ***************************************************************************** -->
<!-- MODAL SOLICITUD-->
<div class="modal fade" id="modal-detsol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-file-text-o"></i> Detalles de solicitud</h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-condensed">
					<thead>
						<tr><th>SOLICITANTE</th>	<td id="td-col"></td></tr>
						<tr><th>TIPO SOLICITUD</th>	<td id="td-tipo"></td></tr>
						<tr><th>DIRIGIDA A</th>	<td id="td-destino"></td></tr>
						<tr><th>RADICADO</th>		<td id="td-ferad"></td></tr>
						<tr><th class="text-center" colspan="2">DETALLE DE LA SOLICITUD</th></tr>
						<tr><td id="td-detalle"></td></tr>
						<tr><th>ESTADO</th>			<td><b id="td-esta"></b></td></tr>
						<tr class="tr-resp hidden"><th>FECHA RESPUESTA</th><td id="td-feres"></td></tr>
						<tr class="tr-resp hidden"><th>TIEMPO DE RESPUESTA</th><td id="td-tiesp"></td></tr>
						<tr class="tr-resp hidden"><th>RESPUESTA</th><td id="td-resp"></td></tr>
					</thead>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL DPTO-->
<div class="modal fade" id="modal-newdpto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> NUEVO DEPARTAMENTO</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="dptonom">Nombre Departamento</label><br>
					<small>Este nombre será visible para los colaboradores</small>
					<input type="text" id="dptonom" class="ctrlnd form-control">
				</div>
				<div class="form-group">
					<label for="dptousr">Usuario Responsable</label><br>
					<small>Usuario que atenderá las solicitudes</small>
					<select id="dptousr" class="dptousr ctrlnd form-control"></select>
				</div>
				<div class="form-group">
					<label for="dptomail">Correo Notificaciones</label><br>
					<small>Correo al que llegarán las notificaciones de las solicitudes asignadas</small>
					<input type="text" id="dptomail" class="ctrlnd form-control" readonly>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="savedpto"  class="btn btn-primary" data-loading-text="Guardando...">Guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL EDIT DPTO-->
<div class="modal fade" id="modal-editdpto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> Editar Departamento</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="srcodedt">
				<div class="form-group">
					<label for="dptonom2">Nombre Departamento</label><br>
					<small>Este nombre será visible para los colaboradores</small>
					<input type="text" id="dptonom2" class="ctrlnd form-control">
				</div>
				<div class="form-group">
					<label for="dptousr2">Usuario Responsable</label><br>
					<small>Usuario que atenderá las solicitudes</small>
					<select id="dptousr2" class="dptousr ctrlnd form-control"></select>
					<small id="noeditable" class="text-danger"></small>
				</div>
				<div class="form-group">
					<label for="dptomail2">Correo Notificaciones</label><br>
					<small>Correo al que llegarán las notificaciones de las solicitudes asignadas</small>
					<input type="text" id="dptomail2" class="ctrlnd form-control" readonly>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="saveedtdpto" data-loading-text="Guardando..." class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL NEW TIPO SOLICITUD-->
<div class="modal fade" id="modal-newts">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo tipo de solicitud</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="nomts">Nombre Solicitud</label>
							<input id="nomts" class="form-control">
							<small>Use nombres cortos fáciles de identificar para el colaborador. Ej: Queja, Prestamo, etc.</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dptots">Departamento Encargado</label>
							<select id="dptots" class="dptots form-control"></select>
							<small>Este departamento será el responsable de este tipo de solicitud</small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="userts">Usuario Vinculado al Departamento</label>
						<input id="userts" class="form-control" readonly value="NO DEFINIDO" style='font-size: 12px;'>
						<small>Este usuario será quien tramite las solicitudes</small>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="savenewts" data-loading-text="Guardando..." class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL EDIT TIPO SOLICITUD-->
<div class="modal fade" id="modal-tsedit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> EDITAR TIPO DE SOLICITUD</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="hidden" id="tscod2">
							<label for="nomts2">Nombre Solicitud</label>
							<input id="nomts2" class="form-control">
							<small>Use nombres cortos fáciles de identificar para el colaborador. Ej: Queja, Prestamo, etc.</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dptots2">Departamento Encargado</label>
							<select id="dptots2" class="dptots form-control"></select>
							<small>Este departamento será el responsable de este tipo de solicitud</small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="userts2">Usuario Vinculado al Departamento</label>
						<input id="userts2" class="form-control" readonly value="NO DEFINIDO" style='font-size: 12px;'>
						<small>Este usuario será quien tramite las solicitudes</small>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="tssaveedt" data-loading-text="Guardando..." class="btn btn-primary">Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- ***************************************************************************** -->
<script type="text/javascript">
	$(document).ready(function() {
		listsolicitudes();
		loaddpto();
		loaddptousr();
		loadtisol();
		loadseldpto();
	});
</script>
<script type="text/javascript">//BTN NAVEGACION
	$(".opcsolicitudes").click(function(){
		//listsolicitudes();
		$(".opciones").hide(100);
		$(".divsolicitudes").removeClass('hidden');
	});
	$(".opcconfig").click(function(){
		/*loaddpto();
		loaddptousr();
		loadtisol();
		loadseldpto();*/
		$(".opciones").hide(100);
		$(".divconfig").removeClass('hidden');
	});
	$(".btngoback").click(function(){
		listsolicitudes();
		$(".opc").addClass('hidden');
		$(".opciones").show();
	})
</script>
<script type="text/javascript">//HISTORIAL SOLICITUDES
	var  listsolicitudes  = function() { 
		var listado = $('#tbsolgen').DataTable({
			"ajax": {
			"method": "POST",
			"url": "solicitudes/process.php",
			"data": {opc: "loadsol"},
			},
			dom: '<"toolbar">Bfrtip',
			buttons: [ 
			{
			    extend:    'excel',
			    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
			    titleAttr: 'Exportar a Excel',
			    exportOptions: {
			        columns: [ 0, 1, 2, 3, 4, 5 ]
			    },
			    title:'BeautySoft - Listado General de Solicitudes', 
			}
			],
			"columns":[
			{"data": "tipo"},
			{"data": "col"},
			{"data": "ferad"},
			{"data": "solres"},
			{"data": "est"},
			{"data": "tac"},
			{"render": function (data, type, JsonResultRow, meta) { 
			  return '<button class="detalles btn btn-default btn-xs text-info" data-dessol="'+JsonResultRow.sdesc+'" data-codsol="'+JsonResultRow.scod+'" data-comm="'+JsonResultRow.comm+'" data-ressol="'+JsonResultRow.rsol+'" data-codest="'+JsonResultRow.cest+'" data-txtest="'+JsonResultRow.est+'" data-feres="'+JsonResultRow.feres+'" title="Ver detalles de solicitud"><i class="fa fa-eye text-primary"></i></button>';  
			 } 
			},  
			],"language":{
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"info": "<label class='btn btn-info'> _MAX_ Solicitudes registradas</label><br>Mostrando página _PAGE_ de _PAGES_",
				"infoEmpty": "",
				"infoFiltered": "(filtrada de _MAX_ registros)",
				"loadingRecords": "<h3><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere...</h3>",
				"processing":     "Procesando...",
				"search": "_INPUT_",
				"searchPlaceholder":"Buscar...",
				"zeroRecords":    "No se encontraron solicitudes",
				"paginate": {
				"next":       "Siguiente",
				"previous":   "Anterior"
				} 
			},  
			"columnDefs":[
			  {className:"tipo bold","targets":[0]},
			  {className:"nomcol","targets":[1]},
			  {className:"ferad text-center","targets":[2]},
			  {className:"text-center","targets":[3]},
			  {className:"text-center bold","targets":[4]},			  
			  {className:"text-center","targets":[5]},			  
			  {className:"text-center","targets":[6]},			  
			],
			"order": [],
			"bDestroy": true,
			"pageLength":5,
		});
		$("div.toolbar").html('<select class="form-control pull-right" id="selfiltro"></select><label for="selfiltro" class="pull-right"> Mostrando: </label>');
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'selfiltro'},
			success:function(res){
				var dt=JSON.parse(res);
				var opc='<option value="">TODAS</option>';
				for(var i=0 in dt){
					opc+='<option value="'+dt[i].nom+'">'+dt[i].nom+'</option>';
				}
				$("#selfiltro").html(opc);
			}
		});
		$("#selfiltro").on('change',function(){
			listado.search(this.value).draw();
		})
	}
	$(document).on('click','.detalles',function(){
		var comm=$(this).data('comm');
		var codestado=$(this).data('codest');
		var detalle=$(this).data('dessol');
		var feres=$(this).data('feres');
		var data=$(this).closest('tr').find('td');

		var tipo=data.eq(0).text();
		var col=data.eq(1).text();
		var ferad=data.eq(2).text();
		var destino=data.eq(3).text();
		var estado=data.eq(4).text();

		var f1=moment(ferad.split(' ')[0],'YYYY-MM-DD');
		var f2=moment(feres.split(' ')[0],'YYYY-MM-DD)');
		var dias=f2.diff(f1, 'days');

		$("#td-col").html(col);
		$("#td-tipo").html(tipo);
		$("#td-destino").html(destino);
		$("#td-ferad").html(ferad);
		$("#td-detalle").html(detalle);
		$("#td-esta").html(estado);
		$("#td-resp").html(comm);
		$("#td-tiesp").html(dias+' dia(s).');
		$("#td-feres").html(feres);
		if(codestado==3){
			$(".tr-resp").removeClass('hidden');
		}else{
			$(".tr-resp").addClass('hidden');
		}
		$("#modal-detsol").modal('toggle');
	})
</script>
<script type="text/javascript">//OPER DPTO
	function loaddpto(){
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'loaddpto'},
			success:function(res){
				var dt=JSON.parse(res);
				var tb='';
				for(var i=0 in dt){
					tb+='<tr><td>'+dt[i].nomdp+'</td><td>'+dt[i].user+'</td><td>'+dt[i].mail+'</td><td class="text-center"><button class="edtdpto btn btn-info btn-xs" data-cod="'+dt[i].cod+'" title="Editar Departamento"><i class="fa fa-edit"></i></button><button class="deldpto btn btn-danger btn-xs" data-cod="'+dt[i].cod+'" title="Eliminar Departamento"><i class="fa fa-times"></i></button></td></tr>';
				}
				$("#loading1").addClass('hidden');
				$("#tbdpto tbody").html(tb);
			},
			error:function(){
				$("#tbdpto tbody").html('<tr><td colspan="4">Ha ocurrido un error. Intentelo nuevamente.</td></tr>');
			} 
		});
	}
	function loaddptousr(){
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'loaddptousr'},
			success:function(res){
				var dt=JSON.parse(res);
				var opc='<option value="" selected disabled>Elija Usuario</option>';
				for(var i=0 in dt){
					opc+='<option data-mail="'+dt[i].mail+'" value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
				}
				$(".dptousr").html(opc);
			}
		})
	}
	$("#btnnewdpto").click(function(){
		loaddptousr();
	})
	$("#dptousr").change(function(){
		var mail=$(this).find(':selected').data('mail');
		$("#dptomail").val(mail);
	});
	$("#savedpto").click(function(){
		var dptonom=$("#dptonom").val().trim().toUpperCase();
		var dptousr=$("#dptousr").val();
		if(dptonom!=''){
			if(dptousr!=null){
				$("#savedpto").button('loading');
				$.ajax({
					url:'solicitudes/process.php',
					type:'POST',
					data:{opc:'newdpto',dptonom:dptonom,dptousr:dptousr},
					success:function(res){
						if(res==1){
							loaddpto();
							loadseldpto()
							swal('Guardado','El nuevo departamento ha sido creado correctamente','success');
							$("#modal-newdpto").modal('toggle');
							$(".ctrlnd").val('');//limpia formulario NUEVO DEPARTAMENTO
						}else if(res=='D'){
							swal('DUPLICADO!','Ya existe un departamento activo con este mismo nombre, o el usuario elegido ya está asignado a otro departamento.\n Por favor verifique el nombre y usuario seleccionados.','warning');
						}else{
							swal('oops!','Ha ocurrido un error al crear el nuevo departamento. Por favor, refresque la página e intentelo nuevamente.','error');
						}
					}
				})
				$("#savedpto").button('reset');
			}else{
				swal('Elija Usuario','El departamento a crear debe tener un usuario vinculado al que le llegarán los correos notificando las solicitudes.','warning');
			}
		}else{
			swal('Falta nombre del departamento','','warning');
		}
	});
	$(document).on('click','.deldpto',function(e){
		var srcod=$(this).data('cod');
		swal({
			title: "Está a punto de eliminar este departamento",
			text: "Esta acción es irreversible, ¿Continuar?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Si, Eliminar",
			closeOnConfirm: false
		},
		function(){
			$.ajax({
				url:'solicitudes/process.php',
				type:'POST',
				data:{opc:'deldpto',srcod:srcod},
				success:function(res){
					switch(res){
						case '0':
							swal('oops!','Ha ocurrido un error al eliminar el departamento. Por favor, refresque la página e intentelo nuevamente.','error');
						break;
						case '1':
							loaddpto();
							loadseldpto();
							swal('Eliminado','El departamento ha sido eliminado correctamente','success');
						break;
						case '2':
							swal('NO SE PUEDE ELIMINAR','Este departamento tiene solicitudes pendientes por responder. Las solicitudes deben reasignarse a otro departamento para poder eliminarlo.','warning');
						break;
					}
				}
			})
		});
	});
	$(document).on('click','.edtdpto', function(e){
		var srcod=$(this).data('cod');
		$("#srcodedt").val(srcod);
		var data=$(this).closest('tr').find('td');
		var nom=data.eq(0).text();
		var usr=data.eq(1).text();
		var mail=data.eq(2).text();
		$("#dptonom2").val(nom);
		$("#dptomail2").val(mail);
		$("#dptousr2").removeAttr('disabled'); 
		$("#dptousr2 option").removeAttr('selected');
		$("#dptousr2 option").filter(function() {
		    return $(this).text() == usr; 
		}).prop('selected', true);
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'preedt',srcod:srcod},
			success:function(res){
				if(res>0){
					$("#dptousr2").attr("disabled", true); 
					$("#noeditable").html('Este usuario ya tiene solicitudes asociadas, NO PUEDE EDITARSE. Para editarlo, reasigne las solicitudes existentes a otro usuario.');
				}else{
					$("#dptousr2").removeAttr('disabled'); 
					$("#noeditable").html('');
				}
			}
		})
		$("#modal-editdpto").modal('toggle');
	});
	$("#dptousr2").change(function(){
		var mail=$(this).find(':selected').data('mail');
		$("#dptomail2").val(mail);
	});
	$("#saveedtdpto").click(function(){
		var dptonom=$("#dptonom2").val().trim().toUpperCase();
		var dptousr=$("#dptousr2").val();
		var srcod=$("#srcodedt").val();
		if(dptonom!=''){
			if(dptousr!=null){
				$("#saveedtdpto").button('loading');
				$.ajax({
					url:'solicitudes/process.php',
					type:'POST',
					data:{opc:'edtdpto',dptonom:dptonom,dptousr:dptousr,srcod:srcod},
					success:function(res){
						if(res==1){
							loaddpto();
							loadseldpto();
							swal('Guardado','El departamento ha sido actualizado correctamente','success');
							$("#modal-editdpto").modal('toggle');
						}else if(res=='D'){
							swal('DUPLICADO!','Ya existe un departamento activo con este mismo nombre, o el usuario elegido ya está asignado a otro departamento.\n Por favor verifique el nombre y usuario seleccionados.','warning');
						}else{
							swal('oops!','Ha ocurrido un error al editar el departamento. Por favor, refresque la página e intentelo nuevamente.','error');
						}
					}
				});
				$("#saveedtdpto").button('reset');
			}else{
				swal('Elija Usuario','El departamento editado debe tener un usuario vinculado al que le llegarán los correos notificando las solicitudes.','warning');
			}
		}else{
			swal('Falta nombre del departamento','','warning');
		}
	});
</script>
<script type="text/javascript">//OPER TIPO SOL
	function loadtisol(){
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'loadtisol'},
			success:function(res){
				var dt=JSON.parse(res);
				var tb='';
				for(var i=0 in dt){
					tb+='<tr><td>'+dt[i].nomtisol+'</td><td>'+dt[i].dptonom+'</td><td>'+dt[i].restisol+'</td><td class="text-center"><button data-cod="'+dt[i].codtisol+'" class="tisoledt btn btn-info btn-xs" title="Editar tipo de solicitud"><i class="fa fa-edit"></i></button><button data-cod="'+dt[i].codtisol+'" class="tisoldel btn btn-danger btn-xs" title="Eliminar tipo de solicitud"><i class="fa fa-times"></i></button></td></tr>';
				}
				$("#loading2").addClass('hidden');
				$("#tbtisol tbody").html(tb);
			}
		})
	}
	function loadseldpto(){
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'loaddpto'},
			success:function(res){
				var dt=JSON.parse(res);
				var opc='<option value="0" data-usr="NO DEFINIDO" selected>LO DEFINE EL SOLICITANTE</option>';
				for(var i=0 in dt){
					opc+='<option value="'+dt[i].cod+'" data-usr="'+dt[i].user+'">'+dt[i].nomdp+'</option>';
				}
				$(".dptots").html(opc);
			}
		});
	}
	$("#dptots").change(function(e){
		var usr=$(this).find(':selected').data('usr');	
		$("#userts").val(usr);
	});
	$("#savenewts").click(function(){
		var nomts=$("#nomts").val().trim().toUpperCase();
		var dpto=$("#dptots").val();
		if(nomts!=''){
			$("#savenewts").button('loading');
			$.ajax({
				url:'solicitudes/process.php',
				type:'POST',
				data:{opc:'savenewts',nomts:nomts,dpto:dpto},
				success:function(res){
					if(res==1){
						loadtisol();
						swal('Correcto!','El nuevo tipo de solicitud ha sido creado correctamente.','success');
						$("#modal-newts").modal('toggle');
						$("#nomts").val('');
						$("#dptots").val('0').change();
					}else if(res=='D'){
						swal('Duplicado!','Ya existe un tipo de solicitud con este nombre. \n Por favor verifique.','warning');
					}else{
						swal('Oops!','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.','error');
					}
				}
			});
			$("#savenewts").button('reset');
		}else{
			swal('Debe escribir un nombre','Defina un nombre sencillo para la solicitud.\n Ej: Queja, prestamo, etc...','warning');
		}
	});
	$(document).on('click','.tisoldel',function(){
		var tscod=$(this).data('cod');
		swal({
			title: "Eliminar Tipo de Solicitud",
			text: "Está a punto de eliminar este tipo de solicitud, esta acción es IRREVERSIBLE. \n ¿Desea continuar?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Si, Eliminar!",
			cancelButtonText: "Cancelar",
			closeOnConfirm: false
		},
		function(){
			$.ajax({
				url:'solicitudes/process.php',
				type:'POST',
				data:{opc:'deltisol',tscod:tscod},
				success:function(res){
					if(res==1){
						loadtisol();
						swal('Eliminado!','','success');
					}else{
						swal('Oops!','Ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','error');
					}
				}
			})
		});
	});
	$(document).on('click','.tisoledt',function(){
		var tscod=$(this).data('cod');
		$("#tscod2").val(tscod);
		var data=$(this).closest('tr').find('td');
		var nom=data.eq(0).text();
		var dpto=data.eq(1).text();
		var usr=data.eq(2).text();
		$("#nomts2").val(nom);
		$("#dptots2 option").removeAttr('selected');
		$("#dptots2 option").filter(function() {
		    return $(this).text() == dpto; 
		}).prop('selected', true);
		$("#userts2").val(usr);
		$("#modal-tsedit").modal('toggle');
	});
	$("#dptots2").change(function(){
		var usr=$(this).find(':selected').data('usr');
		$("#userts2").val(usr);
	});
	$("#tssaveedt").click(function(e){
		var tscod=$("#tscod2").val();
		var dpto=$("#dptots2").val();
		var nomts=$("#nomts2").val();
		$("#tssaveedt").button('loading');
		$.ajax({
			url:'solicitudes/process.php',
			type:'POST',
			data:{opc:'saveedtts',nomts:nomts,tscod:tscod,dpto:dpto},
			success:function(res){
				if(res==1){
					loadtisol();
					swal('Actualizado!','','success');
					$("#modal-tsedit").modal('toggle');
				}else if(res=='D'){
					swal('Duplicado!','Ya existe un tipo de solicitud con este nombre. \n Por favor verifique.','warning');
				}else{
					swal('Oops!','Ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','error');
				}
			}
		});
		$("#tssaveedt").button('reset');
	})
</script>
