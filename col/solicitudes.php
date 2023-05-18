<?php 
include("head.php");
include("librerias_js.php");
?>
<div class="small-header">
  <div class="hpanel">
    <div class="panel-body">
      <!-- <div id="hbreadcrumb" class="pull-right m-t-lg">
        <ol class="hbreadcrumb breadcrumb">
      
          <li><a href="inicio.php">Inicio</a></li>
          <li class="active">
          <span>Solicitudes</span>
          </li>
        </ol>
      </div> -->
      <div class="row">
        <h4>MIS SOLICITUDES</h4>
        <a data-toggle="modal" href='#modal-addsol' id="btnnewsol" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-plus"></span> Nueva Solicitud</a>
      </div>
    </div>
  </div>
</div>
<br>
<div id="listsolicitudes" class="content"></div>

<!-- MODAL NUEVA SOLICITUD -->
<div class="modal fade" id="modal-addsol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><span class="fa fa-plus"></span> Nueva Solicitud</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="tisol">Tipo de solicitud:</label>
					<select id="tisol" class="form-control"></select>
				</div>
				<div class="selrs form-group hidden">
					<label for="ressol">Dirigida a:</label>
					<select id="ressol" class="form-control"></select>
				</div>
				<div class="form-group">
					<label for="dessol">Descripción de la solicitud:</label>
					<textarea class="form-control" id="dessol" rows="4" style="resize: none;" placeholder="Indique los detalles de su solicitud..."></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button id="sendsol" type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Enviando...">Enviar Solicitud</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL MOSTRAR DETALLE DE SOLICITUD -->
<div class="modal fade" id="modal-detsol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-file-text"></i> Detalles de su Solicitud</h4>
			</div>
			<div class="modal-body">
				<table id="tbdetsol" class="table table-striped table-hover"><tbody></tbody></table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
</div>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$(".page-small").addClass('fixed-small-header');
		loadsol();
		loadtisol();
		loadressol();
	});
	function loadsol(){
		$("#listsolicitudes").html('<i class="fa fa-spin fa-spinner"></i> Cargando, por favor espere...');
		var clb=$("#codColaborador").val();
		$.ajax({
			url:'php/solicitudes/process.php',
			type:'POST',
			data:{opc:'loadsol',clb:clb},
			success:function(res){
				var dt=JSON.parse(res);
				var cont='';
				var hd='';
				var rd='';
				for(var i=0 in dt){
					dt[i].secd==3?(rd='text-danger',hd=''):(rd='text-info',hd='hidden');
					cont+='<div class="col-lg-4">'+
		                    '<div class="hpanel hblue contact-panel">'+
		                        '<div class="panel-body">'+
		                            '<div class="list-group">'+
		                              '<button type="button" class="list-group-item active"><b>'+dt[i].stpo+'</b></button>'+
		                              '<button type="button" class="list-group-item"><b>Radicado:</b> <span class="pull-right">'+dt[i].sdte.substring(0,16)+'</span></button>'+
		                              '<button type="button" class="list-group-item"><b>Responsable:</b> <span class="pull-right">'+dt[i].srep+'</span></button>'+
		                              '<button type="button" class="list-group-item"><b>Estado:</b> <span class="pull-right '+rd+'"><b>'+dt[i].sest+'</b></span></button>'+
		            				  '<button type="button" class="btn btn-default btn-block btnanswer '+hd+'"><b class="text-danger">Ver Respuesta</b></button>'+
		            				  '<input class="answer" type="hidden" value="'+dt[i].scom+'" data-tisol="'+dt[i].stpo+'" data-solres="'+dt[i].srep+'" data-soldes="'+dt[i].sdes+'" data-ferad="'+dt[i].sdte.substring(0,16)+'" data-fres="'+dt[i].sfres.substring(0,16)+'">'+
		            				'</div>'+
		                      	'</div>'+
		                    '</div>'+
		               '</div>';
				}
				$("#listsolicitudes").html(cont);
			}
		})
	}
	function loadtisol(){
		$.ajax({
			url:'php/solicitudes/process.php',
			type:'POST',
			data:{opc:'loadtisol'},
			success:function(res){
				var json = JSON.parse(res);
                var opcs = "<option value='' selected disabled>Seleccione tipo...</option>";
                for(var i in json){
                    opcs += "<option data-res='"+json[i].res+"' value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#tisol").html(opcs);
			}
		})
	}
	function loadressol(){
		$.ajax({
			url:'php/solicitudes/process.php',
			type:'POST',
			data:{opc:'loadressol'},
			success:function(res){
				var json = JSON.parse(res);
                var opcs = "<option value='' selected disabled>Seleccione destinatario...</option>";
                for(var i in json){
                    opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#ressol").html(opcs);
			}
		})
	}
	$("#btnnewsol").click(function(){
		loadtisol();
	})
	$("#tisol").change(function(){
		var sw = $(this).find(':selected').data('res');
		if(sw==0){
			$(".selrs").removeClass('hidden');
		}else{
			$(".selrs").addClass('hidden');
		}
	});
</script>
<script type="text/javascript">
	$("#sendsol").click(function(e){
		var clb=$("#codColaborador").val();
		var tisol=$("#tisol").val();
		var rsol=$("#tisol").find(':selected').data('res');
		if(rsol==0){
			rsol=$("#ressol").val();
		}
		var detsol=$("#dessol").val();
		if(tisol!=null){
			if(rsol!=null){
				if(detsol.length>0){
					var $this = $(this);
			  		$this.button('loading');
					$.ajax({
						url:'php/solicitudes/process.php',
						type:'POST',
						data:{opc:'savesol',tisol:tisol,rsol:rsol,detsol:detsol,clb:clb},
						success:function(res){
							if(res==1){
								loadsol();
								resetformsol();
								swal('Solicitud enviada!','','success');
							}else{
								swal('Oops!','Ha ocurrido un error inesperado al enviar su solicitud, refresque la pagina e intentelo nuevamente.','error');
							}
						},
						error:function(){
							swal('Oops!','Ha ocurrido un error inesperado al intentar enviar su solicitud, refresque la pagina e intentelo nuevamente.','error');
						}
					});
				}else{
					swal('Detalle su solicitud','','warning');
				}
			}else{
				swal('Seleccione destinatario de su solicitud','','warning');
			}
		}else{
			swal('Seleccione tipo de solicitud','','warning');
		}
	});
	function resetformsol(){
		$("#modal-addsol").modal('toggle');
		$("#sendsol").button('reset');
		$("#tisol").val('');
		$("#ressol").val('');
		$(".selrs").addClass('hidden');
		$("#dessol").val('');
	}
	$(document).on('click','.btnanswer',function(e){
		var dt=$(this).parent().find('.answer');
		var cont='<tr><th><b>TIPO:</b></th><td>'+dt.data('tisol')+'</td></tr>';
		cont+='<tr><th><b>RESPONSABLE:</b></th><td>'+dt.data('solres')+'</td></tr>';
		cont+='<tr><th><b>RADICADO:</b></th><td>'+dt.data('ferad')+'</td></tr>';
		cont+='<tr><th><b>RESPONDIDO:</b></th><td>'+dt.data('fres')+'</td></tr>';
		cont+='<tr><th><b>Descripción solicitud:</b></th><td>'+dt.data('soldes')+'</td></tr>';
		cont+='<tr><th><b>RESPUESTA:</b></th><td>'+dt.val()+'</td></tr>';
		$("#tbdetsol tbody").html(cont);
		$("#modal-detsol").modal('toggle');
	})
</script>