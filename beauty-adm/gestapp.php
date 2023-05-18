<?php 
include 'head2.php';
include "librerias_js.php";
$ced=$_GET['ced'];
$tpo=$_GET['tp'];
$id=$_GET['id'];

if($tpo=='c'){
	$sql="SELECT a.dcclinom, a.dccliape, a.dcclicel, a.dcfhdom ,a.dcfhreg, a.dcservicio, if(a.dcobser='','Ninguna',a.dcobser) AS dcobser, a.dcsalon, s.slnnombre, c.cacorreo, a.dacodigo
			FROM btydomicitaApp a
			JOIN btysalon s ON s.slncodigo=a.dcsalon
			JOIN btyclienteApp c ON c.cacedula=a.dccliced
			WHERE a.dccliced=$ced AND a.daestado=0 AND a.dctipo='CITA' AND a.dacodigo=$id
			ORDER BY a.dacodigo DESC LIMIT 1";
}else{
	$sql='';
}

mysqli_set_charset($conn,'UTF8');
$res=$conn->query($sql);
if($res->num_rows>0){
	$row=$res->fetch_array();
	$dac=$row['dacodigo'];
	$nom=$row['dcclinom'];
	$ape=$row['dccliape'];
	$ema=$row['cacorreo'];

	$fso=$row['dcfhreg'];
	$fnm=$nom.' '.$ape;
	$cel=$row['dcclicel'];
	$srv=$row['dcservicio'];
	$fsr=$row['dcfhdom'];

	$date=explode(' ',$fsr)[0];
	$time=explode(' ',$fsr)[1];

	$slc=$row['dcsalon'];
	$sln=$row['slnnombre'];
	$obs=$row['dcobser'];
?>
<style type="text/css">
	input[type="checkbox"] {
	  transform:scale(1.5, 1.5);
	}
</style>
<div class="mcont container-fluid">
	<input type="hidden" id="dac" value="<?php echo $dac;?>">
	<input type="hidden" id="clinom" value="<?php echo $nom;?>">
	<input type="hidden" id="cliape" value="<?php echo $ape;?>">
	<input type="hidden" id="cliema" value="<?php echo $ema;?>">
	<input type="hidden" id="slncod" value="<?php echo $slc;?>">
	<input type="hidden" id="tdcel" value="<?php echo $cel;?>">
	<input type="hidden" id="codcli">
	<input type="hidden" id="serdu" value='0'>
	<input type="hidden" id="sw" value='0'>
	<div class="col-md-6"><br><br>
		<h2 class="text-center"><b>SOLICITUD DE CITA</b></h2>
		<table class="table table-hover table-bordered">
			<tbody>
				<tr><th>Fecha/Hora solicitud</th>	<td id="tdfso"><?php echo $fso;?></td></tr>
				<tr><th>Cedula</th>					<td id="tdced"><?php echo $ced;?></td></tr>
				<tr><th>Nombre</th>					<td id="tdrso"><?php echo $fnm;?></td></tr>
				<tr>
					<th>Teléfono</th>				<td>
														<a class="btn btn-info btn-block" href="tel:<?php echo $cel;?>"><i class="fa fa-phone"></i> <?php echo $cel;?></a>
														<a class="btn btn-block pull-right" style="color:white;background-color: green;" onclick="window.open('https://api.whatsapp.com/send?phone=57<?php echo $cel;?>&text=Hola%20<?php echo $nom;?>.%20Ud%20ha%20solicitado%20una%20cita%20via%20App.%20Me%20gustaría%20confirmar%20algunos%20detalles.', '_system')";><i class="fa fa-whatsapp"></i></a>
													</td>
				</tr>
				<tr>
					<th>Servicios</th>				<td id="tdsrv"><?php echo $srv;?></td></tr>
				<tr>
					<th>Fecha/Hora Cita
						<a class="btn btn-default pull-right" data-toggle="modal" href='#md-feho'><i class="fa fa-clock-o text-info"></i></a>
					</th>		
					<td id="feho"><?php echo $fsr;?></td>
				</tr>
				<tr>
					<th>Salón
						<a class="btn btn-default pull-right" data-toggle="modal" href='#md-sln'><i class="fa fa-refresh text-info"></i></a>
					</th>					
					<td>
						<b id="nomsln"><?php echo $sln;?></b>
					</td>
				</tr>
				<tr><th>Observaciones</th>			<td id="tdobs"><?php echo $obs;?></td></tr>
				<tr>
					<td colspan="2">
						<a id="btndispo" class="btn btn-success btn-lg btn-block" data-fecha="<?php echo $date;?>" data-hora="<?php echo $time;?>" data-sln="<?php echo $slc;?>" data-toggle="modal" href='#modal-dispo'>Consultar Disponibilidad</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}else{
	?>
	<h2 class="text-center">Este servicio ya fue gestionado</h2>
	<?php
}
?>
<div class="modal fade" id="modal-dispo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class=""><b>COLABORADORES DISPONIBLES</b></h5>
				<h5><?php echo $sln;?> <br> <?php echo $fsr;?></h5>		
			</div>
			<div class="modal-body">
				<h2 id="ldvalcli" class="text-center"><i class="fa fa-spin fa-spinner"></i><br>Validando información del cliente...</h2>
				<h2 id="ldcoldis" class="text-center hidden"><i class="fa fa-spin fa-spinner"></i><br>Buscando colaboradores disponibles...</h2>
				<div id="dvdispo" class="hidden"></div>
			</div>
			<div class="modal-footer">
				<button id="btassign" class="btn btn-success btn-lg pull-right" >Asignar</button>
				<button id="btcancel" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="md-sln">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class=""><i class="fa fa-refresh text-info"></i> Cambiar salón</h4>
			</div>
			<div class="modal-body">
				<select id="slsalon" class="form-control"><option value="" selected disabled>Cargando...</option></select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="camsln" class="btn btn-primary disabled">Cambiar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="md-feho">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class=""><i class="fa fa-clock-o text-info"></i> Cambiar Fecha/Hora</h4>
			</div>
			<div class="modal-body">
				<div style="overflow:hidden;">
				    <div class="form-group">
				        <div class="row">
				            <div class="col-md-8">
				                <div id="nfeho" class="text-center"></div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="camfeho" class="btn btn-primary">Cambiar</button>
			</div>
		</div>
	</div>
</div>

<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		loadsln();
		$('#nfeho').datetimepicker({
            inline: true,
            sideBySide: true,
            stepping:30,
            format : 'YYYY-MM-DD hh:mm A',
            enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            minDate:moment().format('YYYY-MM-DD hh:30 A'),
            locale:'es'
        });
	});

	//get date/time from datetimepicker = $("#nfeho").data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:00')

	var pubnub = new PubNub ({
	    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
	    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
	});
	$(document).on('click','#btndispo',function(){
		valcli();
	});
	
	function loadsln(){
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'lsln'},
			success:function(res){
				var dt=JSON.parse(res);
				var opc='<option value="" selected disabled>Seleccione salon...</option>';
				for(i in dt){
					opc+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
				}
				$("#slsalon").html(opc);
			}
		})
	}
	function valcli(){
		var ced=$("#tdced").text();
		var nom=$("#clinom").val();
		var ape=$("#cliape").val();
		var cel=$("#tdcel").val();
		var ema=$("#cliema").val();
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'valcli',ced:ced,nom:nom,ape:ape,cel:cel,ema:ema},
			success:function(res){
				var dt=JSON.parse(res);
				if(dt.ERR=='NO'){
					$("#codcli").val(dt.clicod);
					$("#ldvalcli").addClass('hidden');
					$("#ldcoldis").removeClass('hidden');
					valsercargo();
				}else{
					swal('Error','Ha ocurrido un error al procesar los datos del cliente - SQL','error');
				}
			},
			error:function(){
				swal('Error','Ha ocurrido un error inesperado al procesar los datos del cliente - AJAX','error');
			}
		});
	}
	function valsercargo(){
		$("#dvdispo").empty();
		var ser=$("#tdsrv").text();
		var arrsrv=ser.split(',');
		$("#sw").val(arrsrv.length);
		arrsrv.forEach(sercar);
	}
	function sercar(item,index){
		var con='';
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'sercar',ser:item},
			async:true,
			success:function(res){
				var dt=JSON.parse(res);
				var id=dt.nom+index;
				var cod=dt.cod;
				var dur=dt.dur;
				var eki=dt.eki;
				con+='<legend>'+item+' <small>('+dt.nom+'S)</small></legend><div class="dvdircrg" id="'+id+'" data-crgcod="'+cod+'" data-dur="'+dur+'" data-sercod="'+eki+'"><i class="fa fa-spin fa-spinner"></i></div>';
				$("#dvdispo").append(con);
				$("#ldcoldis").addClass('hidden');
				//$("#dvdispo").removeClass('hidden');
				var serdu = parseInt($("#serdu").val())+parseInt(dur);
				$("#serdu").val(serdu);
				var sw=$("#sw").val();
				var sw2=0;
				if(sw==(index+1)){
					$(".dvdircrg").each(function(){
						var ide=$(this).attr('id');
						var codi=$(this).data('crgcod');
						var eki=$(this).data('sercod');
						var dura=$("#serdu").val();
						if(loadcol(ide,codi,dura,eki)){
							sw2++;
						};
					});
					if(sw==sw2){
						//console.log('ok');
						$("#dvdispo").removeClass('hidden');
					}else{
						console.log('boom');
						valcli();
					}
				}
			},
			error:function(){
				swal('Error!','Ha ocurrido un error al buscar los cargos asignados a los servicios solicitados','error');
			}
		});
	}
	function loadcol(cid,crg,dur,eki){
		var sln=$("#slncod").val();
		var feho=$("#feho").text().split(' ');
		var date=feho[0];
		var time=feho[1];
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'loadcol',crg:crg,sln:sln,date:date,time:time,dur:dur,eki:eki},
			success:function(res){
				var dt=JSON.parse(res);
				var cont='';
				if(dt!=null){
					for(i in dt){
						cont+=dt[i].nom+' ['+dt[i].ctg+']<input class="pull-right chkcol" name="'+cid+'[]" type="checkbox" value="'+dt[i].cod+'"/><br><br>';
					}
				}else{
					cont='No hay colaboradores disponibles.';
				}
				$("#"+cid).html(cont);
			},error:function(){
				swal('Error','Ha ocurrido un error generando la lista de colaboradores disponibles.','error');
			}
		});
		return true;
	}
	$("#btassign").click(function(){
		var feho=$("#feho").text().split(' ');
		var date=feho[0];
		var time=feho[1];
		var dac=$("#dac").val();
		var sln=$("#slncod").val();
		var cli=$("#codcli").val();
		var tel=$("#tdcel").val();
		var dv=$(".dvdircrg").length;
		var ser=[];
		var dur=[];
		var col=[];
		var cont = $('input:checkbox:checked').length;
		if(dv==cont){
			$(".dvdircrg").each(function(){
				ser.push($(this).data('sercod'));
				dur.push($(this).data('dur'));
				col.push($(this).children("input:checked").val());
			});
			var acol=col.join();
			var aser=ser.join();
			var adur=dur.join();
			$("#btassign").html('<i class="fa fa-spin fa-spinner"></i> Asignando').attr('disabled',true);
			$("#btcancel").hide();
			$.ajax({
				url:'app/proccess.php',
				type:'POST',
				data:{opc:'incita',col:acol,sln:sln,ser:aser,dur:adur,cli:cli,cfe:date,cho:time,tel:tel,dac:dac},
				success:function(res){
					var dt=JSON.parse(res);
					if(dt.res=="OK"){
						//reload tb cita en salon**********************/
						pubnub.publish({
					        message: date,
					        channel: 'cita'+sln
						    },
						    function (status, response) {
						        if (status.error) {
						            console.log(status)
						        } else {
						            console.log("MSJ sent");
						        }
						    }
						);
						$('#modal-dispo').modal('toggle');
						swal('Cita Confirmada','Los datos fueron enviados exitosamente al cliente y al salón correspondiente.','success');
						$('.mcont').html('<h2 class="text-center">Servicio gestionado exitosamente</h2>');
					}else if(dt.res=="ERR"){
						swal('Error INS','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.','error');
					}else if(dt.res=="ERP"){
						swal('Error ERP','Ha ocurrido un error inesperado. Comuniquese con Dpto de Sistemas.','error');
					}
				},error:function(){
					swal('Error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.','error');
				}
			});
		}else{
			swal('Incompleto!','Asegúrese que cada servicio esté asignado a un colaborador.','warning');
		}
	});
	$(document).on('change','input[type="checkbox"]', function() {
	    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
	});
	$('#modal-dispo').on('hide.bs.modal', function () {
		$("#dvdispo").html('');
		$("#ldvalcli").removeClass('hidden');
		$("#serdu").val('0');
	});
	/**************OPC CAMBIO DE SALON**********************************************************/
	$("#slsalon").change(function(){
		$("#camsln").removeClass('disabled');
	});
	$("#camsln").click(function(){
		csln=$("#slsalon").val();
		nsln=$("#slsalon option:selected").text();
		$("#slncod").val(csln);
		$("#nomsln").html(nsln);
		$("#md-sln").modal('toggle');
		$("#slsalon").val('');
	});
	/*************OPC CAMBIO FECHA/HORA*********************************************************/
	$("#camfeho").click(function(){
		var feho=$("#nfeho").data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:00');
		$("#feho").html(feho);
		$("#md-feho").modal('toggle');
	});
</script>