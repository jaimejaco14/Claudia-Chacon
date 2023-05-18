<?php 
include 'head.php';
include 'librerias_js.php';
?>
<div class="container">
	<h2 class="text-center">Agenda App</h2>
	<div class="table-responsive">
		<table id="tbapp" class="table table-hover">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Servicios</th>
					<th>Tipo Agenda</th>
					<th>Salón</th>
					<th>Fecha Solicitud</th>
					<th>Fecha Reserva</th>
					<th>Fecha Gestión</th>
					<th>Forma de Pago</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="modal-cido">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="text-center"><b id="mdtit"></b></h3>
			</div>
			<div class="modal-body">
				<input type="hidden" id="codcitas">
				<input type="hidden" id="idapp">
				<input type="hidden" id="cliced">
				<input type="hidden" id="ctpo">
				<table class="table table-hover">
					<tr><th>Cliente</th><td id="tbnomcli"></td></tr>
					<tr><th>Teléfono</th><td id="tbtelcli"></td></tr>
					<tr><th>Salón</th><td id="tbnomsln"></td></tr>
					<tr><th>Fecha/hora</th><td id="tbagen"></td></tr>
					<tr><th>Observaciones cliente</th><td id="tbobs"></td></tr>
				</table>
				<table id="tbmodal" class="table table-hover">
					<thead>
						<tr><th>Servicio</th><th>Colaborador Asignado</th></tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="delct" class="btn btn-primary">Eliminar y gestionar nuevamente</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-iframe">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="height:90vh;">
				<div id="frame" class="text-center"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-cancelar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-times text-danger"></i> Cancelar Cita/Domicilio</h4>
			</div>
			<div class="modal-body">
				<p class="text-justify">Esta acción cancelará el servicio(s). Esta acción es IRREVERSIBLE, proceda con cautela.</p>
				<input type="hidden" id="tbcanid">
				<table class="table table-hover">
					<tbody>
						<tr>
							<th>Cliente</th><td id="tbcli"></td>
						</tr>
						<tr>
							<th>Salón/Lugar</th><td id="tbplace"></td>
						</tr>
						<tr>
							<th>Fecha/Hora</th><td id="tbdatetime"></td>
						</tr>
						<tr>
							<th>Servicios</th><td id="tbsrv"></td>
						</tr>
					</tbody>
				</table>
				<select class="form-control" id="tbmotca">
					<option value="" selected disabled>Seleccione motivo de cancelación...</option>
					<option value="2">Disponibilidad del colaborador</option>
					<option value="3">Disponibilidad del servicio</option>
					<option value="4">No se gestionó a tiempo</option>
					<option value="1">Solicitud del cliente</option>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="btncan" class="btn btn-danger">Cancelar Servicio</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		agendaApp();
	});
	var  agendaApp  = function() { 
	   	var tabla = $('#tbapp').DataTable({
	      	"ajax": {
	      	"method": "POST",
	      	"url": "reportes/appproccess.php",
	      	"data": {opc: "gentb"},
	      	},
	      	dom: 'Bfrtip',
	        buttons: [ 
	            {
	                extend:    'excel',
	                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
	                titleAttr: 'Exportar a Excel',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
	                },
	                title:'BeautySoft - Agenda App',
	            }
	        ],
	      "columns":[
	        {"data": "nomcli"},
	        {"data": "dcservicio"},
	        {"data": "dctipo"},
	        {"data": "salon"},
	        {"data": "fehoagen"},
	        {"data": "reserv"},
	        {"data": "fehoges"},
	        {"data": "tpgo"},
	        {"render": function (data, type, JsonResultRow, meta) { 
	            	var est=JsonResultRow.daestado;
	            	if(est==0){
	            		return '<b style="color:red;">NO GESTIONADO</b>';
	            	}else if(est==1){
	            		return '<b style="color:green;">GESTIONADO</b>';
	            	}else if(est==3){
	            		return '<b style="color:red;">CANCELADA</b>';
	            	}
	            } 
	        },
	        {"render": function (data, type, JsonResultRow, meta) { 
	            	var est=JsonResultRow.daestado;
	            	var ced=JsonResultRow.dccliced;
	            	var tpo=JsonResultRow.tipo;
	            	var id=JsonResultRow.id;
	            	var feho=JsonResultRow.fehocd;

	            	if(est==0){
	            		return '<button class="btnges btn btn-info btn-xs btn-block" data-id="'+id+'" data-ced="'+ced+'" data-tpo="'+tpo+'">Gestionar</button><button class="btncan btn btn-danger btn-xs btn-block" data-feho="'+feho+'" data-id="'+id+'" data-ced="'+ced+'" data-tpo="'+tpo+'">Cancelar</button>';
	            	}else if(est==1){
	            		return '<button class="btnver btn btn-default btn-xs btn-block" data-id="'+id+'" data-tpo="'+tpo+'">Ver/Editar</button>';
	            	}else if(est==3){
	            		return '';
	            	}
	            } 
	        },    
	      	],"language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "<br>Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "<h3><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere...</h3>",
		        "processing":     "Procesando...",
		        "search": "_INPUT_",
		        "searchPlaceholder":"Buscar...",
		        "zeroRecords":    "No se encontraron registros coincidentes",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
	        	} 
	        },  
	         "columnDefs":[
	              {className:"text-center","targets":[2,3,4,5,6,7,8]},
	        ],
	             
	        "order": [[4, "desc"]],
	        "bDestroy": true,
	        "pageLength":5,

	            
	    });
	};
	$(document).on('click', '.btnges', function(){
		var tpo=$(this).data('tpo');
		var ced=$(this).data('ced');
		var id=$(this).data('id');
		if(tpo=='c'){
			pg='gestapp';
		}else{
			pg='gestdapp';
		}
		$("#frame").html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
		$("#modal-iframe").modal('toggle');
		$("#frame").html('<iframe id="IframeId" src="http://beauty.claudiachacon.com/beauty/beauty-adm/'+pg+'.php?tp='+tpo+'&id='+id+'&ced='+ced+'" frameborder="0" style="zoom:0.7;width:100%;height:115vh"></iframe>');
	});
	$(document).on('click', '.btnver', function(){
		var id=$(this).data('id');
		$("#idapp").val(id);
		var tpo=$(this).data('tpo');
		$("#ctpo").val(tpo);
		var tit=tpo='c'?'Detalle de Cita':'Detalle de servicio en casa';
		$("#mdtit").html(tit);
		var nomcli=$(this).parent().parent().find('td:eq(0)').html();
		var nomsln=$(this).parent().parent().find('td:eq(3)').html();
		$("#tbnomcli").html(nomcli);
		$("#tbnomsln").html(nomsln);
		$.ajax({
			url:'reportes/appproccess.php',
			type:'POST',
			data:{opc:'detacido',id:id},
			success:function(res){
				var dt=JSON.parse(res);
				var cnt='';
				var cct=[];
				$("#tbtelcli").html(dt.dtcc.cel);
				$("#tbagen").html(dt.dtcc.fhcd);
				$("#tbobs").html(dt.dtcc.obs);
				$("#cliced").val(dt.dtcc.ced);
				for(i in dt.dtsc){
					cnt+='<tr><td>'+dt.dtsc[i].ser+'</td><td>'+dt.dtsc[i].col+' ['+dt.dtsc[i].crg+']</td></tr>';
					cct.push(dt.dtsc[i].cita);
				}
				cct.toString();
				$("#codcitas").val(cct);
				$("#tbmodal tbody").html(cnt);
				$("#modal-cido").modal('toggle');
			},error:function(){
				swal('Boom!','¿Algún herido? \r\n Ha ocurrido un error inesperado. \r\n Refresque la página e intentelo nuevamente.','error');
			}
		})
	});
	$("#delct").click(function(){
		swal({
			title: "¡Advertencia!",
			text: "Esta acción eliminará la(s) cita(s) del salón. \r\n Esta acción le permitirá cambiar los colaboradores asignados actualmente.",
			type: "warning",
			showCancelButton:true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: true
		},function(isConfirm){			
			var cct  = $("#codcitas").val();
			var capp = $("#idapp").val();
			var ced  = $("#cliced").val();
			var tpo  = $("#ctpo").val();
			if(tpo=='c'){
				pg='gestapp';
			}else{
				pg='gestdapp';
			}
			$.ajax({
				url:'reportes/appproccess.php',
				type:'POST',
				data:{opc:'delct',cct:cct,capp:capp},
				success:function(res){
					if(res=='1'){
						agendaApp();
						$("#modal-cido").modal('toggle');
						$("#frame").html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
						$("#modal-iframe").modal('toggle');
						$("#frame").html('<iframe id="IframeId" src="http://beauty.claudiachacon.com/beauty/beauty-adm/'+pg+'.php?tp='+tpo+'&id='+capp+'&ced='+ced+'" frameborder="0" style="height: 115vh;zoom:0.7;width:100%"></iframe>');
					}else{
						swal('Boom!','¿Algún herido? \r\n Ha ocurrido un error inesperado. \r\n Refresque la página e intentelo nuevamente.','error');
					}
				},error:function(){
					swal('Boom!','¿Algún herido? \r\n Ha ocurrido un error inesperado. \r\n Refresque la página e intentelo nuevamente.','error');
				}
			});
		});
	});
	$("#modal-iframe").on('hide.bs.modal',function(){
		agendaApp();
	});
	//cancelacion de citas*********************************************************
	$(document).on('click','.btncan',function(){
		/*var btn=$(this);
		$("#tbcanid").val(btn.data('id'));
		$("#tbcli").html(btn.parent().parent().find('td:eq(0)').html());
		$("#tbplace").html(btn.parent().parent().find('td:eq(3)').html());
		$("#tbdatetime").html(btn.data('feho'));
		$("#tbsrv").html(btn.parent().parent().find('td:eq(1)').html());
		$("#modal-cancelar").modal('toggle');*/
	});
	$(document).on('click','#btncan',function(){
		var id=$("#tbcanid").val();
		var mc=$("#tbmotca").val();
		if(mc>0){
			$.ajax({
				url:'reportes/appproccess.php',
				type:'POST',
				data:{opc:'cancelcd',id:id,mc:mc},
				success:function(res){
					if(res==1){
						$("#modal-cancelar").modal('hide');
						agendaApp();
					}else if(res==0){
						swal('Error!','Error SQL UPD','error');
					}else if(res==2){
						swal('Error!','Error SQL INS','error');
					}
				}
			});
		}else{
			swal('Faltan datos!','Seleccione el motivo de la cancelación','warning');
		}
	})
</script>