<?php 
include '../head.php';
include '../librerias_js.php';
?>
<style type="text/css" media="screen">
	.bold{
		font-weight: bold;
	}
</style>
<input type="hidden" id="tipouser" value="<?php echo  $_SESSION['tipo_u'];?>">
<input type="hidden" id="usucod" value="<?php echo  $_SESSION['codigoUsuario'];?>">
<div class="content">
	<h3 class="text-center"><b>SOLICITUDES COLABORADOR</b></h3>
	<div class="table-responsive">
		<table id="tbsol" class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center">TIPO</th>
					<th class="text-center">SOLICITANTE</th>
					<th class="text-center">RADICADO</th>
					<th class="text-center">ESTADO</th>
					<th class="text-center">ACCIONES</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<!-- MODAL DETALLE DE SOLICITUD -->
<div class="modal fade" id="modal-detsol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-file-text-o"></i> Detalle de Solicitud</h4>
			</div>
			<div class="modal-body">
				<div class="content">
					<table id="tbdetsol" class="table table-striped table-hover">
						<tbody>
							<tr><th><b>TIPO:</b></th><td id="cell1"></td></tr>
							<tr><th><b>RADICADO:</b></th><td id="cell2"></td></tr>
							<tr><th><b>ESTADO:</b></th><td id="cell3"></td></tr>
							<tr><th><b>SOLICITANTE:</b></th><td id="cell4"></td></tr>
							<tr><th colspan="2" class="text-center"><b>DETALLE DE LA SOLICITUD</b></th></tr>
							<tr><td colspan="2" id="cell5"></td></tr>
						</tbody>
					</table>
					<div class="form-group">
						<label for="solcomm">RESPUESTA A LA SOLICITUD:</label>
						<textarea id="solcomm" class="form-control" placeholder="Escriba la respuesta a esta solicitud..." style="resize: none;"></textarea>
					</div>
					<div class="form-group">
						<button id="btnanswer" class="btn btn-info pull-right">Responder</button>
						<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<!-- MODAL REASIGNAR SOLICITUD -->
<div class="modal fade" id="modal-reassignsol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-refresh"></i> Reasignar Solicitud</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="selreasign">Nuevo Destinatario</label>
					<select id="selreasign" class="form-control"></select>
				</div>
				Esta acción redireccionará la solicitud al departamento elegido de la lista. <br>Esta acción es <b>IRREVERSIBLE</b>, proceda con cautela.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button id="btnreass" class="btn btn-info" data-loading-text="Enviando...">Re-Asignar</button>
			</div>
		</div>
	</div>
</div>
<!-- ****************************************************************************************************** -->

<script type="text/javascript">
	$(document).ready(function() {
		listsolicitudes();
		loadreasign();
	});
	var  listsolicitudes  = function() { 
		var usucod=$("#usucod").val();
		var listado = $('#tbsol').DataTable({
			"ajax": {
			"method": "POST",
			"url": "process.php",
			"data": {opc: "loadsol",usucod:usucod},
			},
			dom: '<"toolbar">Bfrtip',
			buttons: [ 
			{
			    extend:    'excel',
			    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
			    titleAttr: 'Exportar a Excel',
			    exportOptions: {
			        columns: [ 0, 1, 2, 3, 4 ]
			    },
			    title:'BeautySoft - Listado de Solicitudes', 
			}
			],
			"columns":[
			{"data": "tipo"},
			{"data": "col"},
			{"data": "actu"},
			{"data": "est"},
			{"render": function (data, type, JsonResultRow, meta) { 
			  return '<button class="detalles btn btn-default btn-xs text-info" data-dessol="'+JsonResultRow.sdesc+'" data-codsol="'+JsonResultRow.scod+'" data-comm="'+JsonResultRow.comm+'" data-ressol="'+JsonResultRow.rsol+'" data-codest="'+JsonResultRow.cest+'" data-txtest="'+JsonResultRow.est+'" title="Ver detalles de solicitud"><i class="fa fa-caret-square-o-right text-primary"></i></button>'+
			  		'<button class="reasignar btn btn-danger btn-xs" title="Reasignar solicitud" data-codsol="'+JsonResultRow.scod+'" data-codest="'+JsonResultRow.cest+'"><i class="fa fa-refresh"></i></button>';  
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
			  {className:"tipo text-center bold","targets":[0]},
			  {className:"nomcol","targets":[1]},
			  {className:"ferad text-center","targets":[2]},
			  {className:"text-center bold","targets":[3]},
			  {className:"text-center","targets":[4]},			  
			],
			"order": [[2, "des"]],
			"bDestroy": true,
			"pageLength":5,
		});
		$("div.toolbar").html('<select class="form-control pull-right" id="selfiltro"></select><label for="selfiltro" class="pull-right"> Mostrando: </label>');
		$.ajax({
			url:'process.php',
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
	};
</script>
<script type="text/javascript">
	$(document).on('click','.detalles',function(e){
		var $btn=$(this);
		var codsol=$(this).data('codsol');
		$("#btnanswer").attr('data-codsol',codsol);
		var estsol=$(this).data('codest');
		var rsol=$(this).data('ressol');
		var dsol=$(this).data('dessol');
		if(estsol==1){
			var txtest='<b>EN TRAMITE</b>';
		}else{
			var txtest='<b>'+$(this).data('txtest')+'</b>';
		}
		var comm='';
		if(estsol==3){
			comm=$(this).data('comm');
			$("#solcomm").val(comm).attr('readonly',true);
			$("#btnanswer").addClass('hidden');
		}
		var tipo=$(this).parent().parent().find('.tipo').html();
		var nomcol=$(this).parent().parent().find('.nomcol').html();
		var ferad=$(this).parent().parent().find('.ferad').html();
		$("#cell1").html(tipo);
		$("#cell2").html(ferad);
		$("#cell3").html(txtest);
		$("#cell4").html(nomcol);
		$("#cell5").html(dsol);
		if(estsol==1){
			swal({
			  title: "Alerta de cambio de estado!",
			  text: "Al consultar los detalles, el estado de la solicitud cambiara a: 'En Tramite'. ¿Continuar?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn btn-danger",
			  confirmButtonText: "Si, Continuar!",
			  cancelButtonText: "No, cancelar!",
			  closeOnConfirm: true,
			  closeOnCancel: true
			},
			function(isConfirm) {
			  if (isConfirm) {
			  		Entramite(codsol,rsol);
			    	listsolicitudes();
					$("#modal-detsol").modal('toggle');
			  	}
			});
		}else{
			$("#modal-detsol").modal('toggle');
		}
	});
	function Entramite(codsol,rsol){
		$.ajax({
			url:'process.php',
			type:'POST',
			data:{opc:'entram',codsol:codsol,rsol:rsol},
			sucess:function(res){
				return res==1?true:false;
			}
		})
	}
	$("#modal-detsol").on("hidden.bs.modal", function () {
    	$("#solcomm").val('');
    	$("#btnanswer").attr('data-codsol',null);
    	$("#btnanswer").removeData( "codsol" );
    	$("#btnanswer").removeAttr('data');
    	$("#btnanswer").removeClass('hidden');
    	$("#solcomm").val('').removeAttr('readonly');
	});
</script>
<script type="text/javascript">
	function loadreasign(){
		var usu=$("#usucod").val();
		$.ajax({
			url:'process.php',
			type:'POST',
			data:{opc:'loadreasign',usu:usu},
			success:function(res){
				var dt=JSON.parse(res);
				var opc='<option value="" selected disabled>Seleccione nuevo destinatario...</option>';
				for(var i=0 in dt){
					opc+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
				}
				$("#selreasign").html(opc);
			}
		})
	}
	$(document).on('click','.reasignar',function(e){
		var est=$(this).data('codest');
		if(est!=3){
			var codsol=$(this).data('codsol');
			$("#btnreass").attr('data-codsol',codsol);
			$("#modal-reassignsol").modal('toggle');
		}else{
			swal('Opcion No Disponible','Esta solicitud ya ha sido respondida y cerrada. No es posible reasignarla en este estado.','warning');
		}
	});
	$("#btnreass").click(function(){
		var $this = $(this);
		var codsol=$(this).data('codsol');
		var usu=$("#selreasign").val();
		if(usu!=null){
			$this.button('loading');
			$.ajax({
				url:'process.php',
				type:'POST',
				data:{opc:'reassign',codsol:codsol,usu:usu},
				success:function(res){
					if(res==1){
						listsolicitudes();
						solpend();
						$("#modal-reassignsol").modal('toggle');
						$("#selreasign").val('');
						$("#btnreass").attr('data-codsol',null);
						swal('Re-Asignada!','La solicitud ha sido re-asignada correctamente','success');
					}else{
						swal('Error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente. Si el error persiste comuníquese al departamento de sistemas','error');
					}
					$this.button('reset');
				}
			})
		}else{
			swal('Seleccione Nuevo Destinatario','','warning');
		}
	})
</script>
<script type="text/javascript">
	$("#btnanswer").click(function(){
		var codsol=$(this).data('codsol');
		var ans=$("#solcomm").val();
		var usu=$("#usucod").val();
		if(ans.length>1){
			$.ajax({
				url:'process.php',
				type:'POST',
				data:{opc:'answer',codsol:codsol,usu:usu,ans:ans},
				success:function(res){
					if(res==1){
						listsolicitudes();
						solpend();
						$("#modal-detsol").modal('toggle');
						swal('Solicitud Respondida!','El tramite de la solicitud ha finalizado correctamente.','success');
					}else{
						swal('Error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente. Si el error persiste comuníquese al departamento de sistemas','error');
					}
				}
			})
		}else{
			swal('Escriba la Respuesta','','warning');
		}
	});
</script>