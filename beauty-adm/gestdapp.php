<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
//setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

include 'head2.php';
include "librerias_js.php";
$ced=$_GET['ced'];
$tpo=$_GET['tp'];
$id=$_GET['id'];
function SpanishDate($FechaStamp){
   $ano = date('Y',$FechaStamp);
   $mes = date('n',$FechaStamp);
   $dia = date('d',$FechaStamp);
   $hora= date('h:i A',$FechaStamp);
   $diasemana = date('w',$FechaStamp);
   $diassemanaN= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
   $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
   return $diassemanaN[$diasemana].", $dia - ". $mesesN[$mes] ."/$ano $hora";
}  
if($id!=0){
	$conid="AND a.dacodigo=$id";
}else{
	$conid="";
}

if($tpo=='d'){
	$sql="SELECT a.dcclinom, a.dccliape, a.dcclicel, a.dcfhdom ,a.dcfhreg, a.dcservicio, if(a.dcobser='','Ninguna',a.dcobser) AS dcobser, a.dcsalon, s.slnnombre, c.cacorreo, a.dcclidir, a.dacodigo, a.dccovid AS covid, a.dctpago as tpgo, r.amount AS valor
			FROM btydomicitaApp a
			JOIN btysalon s ON s.slncodigo=a.dcsalon
			JOIN btyclienteApp c ON c.cacedula=a.dccliced
			LEFT JOIN app_rbmtransaccion r ON r.dev_reference=CONCAT('Cchacon_',a.dacodigo)
			WHERE a.dccliced=$ced AND a.daestado=0 and a.dctipo='DOMICILIO' ".$conid." ORDER BY a.dacodigo DESC LIMIT 1";
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
	$dir=$row['dcclidir'];

	$fso=$row['dcfhreg'];
	$fnm=$nom.' '.$ape;
	$cel=$row['dcclicel'];

	$srv=$row['dcservicio'];
	$arrsrv = explode(',' , $srv);

	$fsr=$row['dcfhdom'];

	$date=explode(' ',$fsr)[0];
	$time=explode(' ',$fsr)[1];

	$slc=$row['dcsalon'];
	$sln=$row['slnnombre'];
	$obs=$row['dcobser'];
	if($row['covid']==1){
		$cov='SI';
	}else{
		$cov='NO';
	}
	//FORMA DE PAGO
	if($row['tpgo']=='OLN'){
		$tpgo='PAGO EN LINEA';
		$swcosto='';
	}else{
		$tpgo='EFECTIVO/CONTRAENTREGA';
		$swcosto='readonly';
	}

	if($row['valor']!=null){
		$valor = $row['valor'];
	}else{
		$valor = 0;
	}
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

	<input type="hidden" id="valor" value="<?php echo $valor;?>">

	<div class="col-md-6"><br>
		<h2 class="text-center"><b>SOLICITUD DE DOMICILIO</b></h2>
		<table class="table table-hover table-bordered">
			<tbody>
				<tr><th>Fecha/Hora Solicitud</th>	<td id="tdfso"><?php echo $fso;?></td></tr>
				<tr><th>Cedula</th>					<td id="tdced"><?php echo $ced;?></td></tr>
				<tr><th>Nombre Cliente</th>			<td id="tdrso"><?php echo $fnm;?></td></tr>
				<tr><th>Dirección</th>				<td id="tddir"><?php echo $dir;?></td></tr>
				<tr>
					<th>Teléfono</th>				<td>
														<a class="btn btn-info btn-block" href="tel:<?php echo $cel;?>"><i class="fa fa-phone"></i> <?php echo $cel;?></a>
														<a class="btn btn-block pull-right" style="color:white;background-color: green;" onclick="window.open('https://api.whatsapp.com/send?phone=57<?php echo $cel;?>&text=Hola%20<?php echo $nom;?>.%20Ud%20ha%20solicitado%20una%20cita%20via%20App.%20Me%20gustaría%20confirmar%20algunos%20detalles.', '_system')";><i class="fa fa-whatsapp"></i></a>
													</td>
				</tr>
				<tr><th>Servicios</th>				<td id="tdsrv"><?php echo $srv;?></td></tr>
				<tr><th>Fecha/Hora Domicilio</th>	<td><?php echo SpanishDate(strtotime($fsr));?></td></tr>
				<tr class="hidden"><th>Fecha/Hora Domicilio</th>	<td id="feho"><?php echo $fsr;?></td></tr>
				<tr><th>Forma de Pago</th>			<td id="tpgo" class="text-danger"><b><?php echo $tpgo;?></b></td></tr>
				<tr id="valort" class="hidden"><th>Valor total</th><td>$<?php echo $valor;?></td></tr>
				<tr><th>Observaciones</th>			<td id="tdobs"><?php echo $obs;?></td></tr>
				<tr class="danger"><th>COVID PRO</th><td id="tdcov" class="text-center"><b><?php echo $cov;?></b></td></tr>
				<tr><th>Salón</th>					<td id="tbsln">No Asignado</td></tr>
				<!-- <tr><th>Costos</th>					<td id="tbtdom">No Definidos</td></tr> -->
				<tr>
					<td colspan="2">
						<a id="btnsalon" class="btn btn-info btn-block" data-toggle="modal" href='#modal-salon'>Asignar Salón y Costos</a>
						<a id="btndispo" class="btn btn-success btn-lg btn-block hidden" data-toggle="modal" href='#modal-salon'>Consultar Disponibilidad</a>
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
<div class="modal fade" id="modal-salon">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modaltitle text-center"><b>Asignar Salón y Costos</b></h4>
				<h5 id="slntitle" class="hidden">Salón: <b id="slnnom2"></b> <br> <?php echo SpanishDate(strtotime($fsr));?></h5>
			</div>
			<div class="modal-body">
				<div id="saco">
					<div class="form-group">
						<select id="slsalon" class="ctrl form-control"></select>
					</div>
					<div class="input-group hidden">
						<div class="input-group-addon">Servicios</div>
						<p><?php echo $srv;?></p>
					</div>
					<?php 
						foreach($arrsrv as $svc){
							$svc=trim($svc,' ');
							$sql="SELECT sp.serprecio FROM appservicio s JOIN appservicio_precio sp ON sp.sercodigo=s.sercodigo WHERE sp.slntipo='DOM' AND s.sernombre='$svc'";
							$res=$conn->query($sql);
							$row=$res->fetch_array();
							$val=$row[0];
							$divsrv.='<div class="input-group">
										<div class="input-group-addon">'.$svc.'</div>
										<input type="tel" class="form-control text-right vlrsvc" readonly value="'.$val.'">
									</div>';
						}
						echo $divsrv;
					?>
					<div class="input-group">
						<div class="input-group-addon"><b>Total Servicios</b></div>
						<input type="tel" class="ctrl money number form-control text-right" readonly id="vsrv">
					</div>
					<div class="input-group">
						<div class="input-group-addon">COVID PRO</div>
						<input type="tel" class="ctrl money number form-control text-right" id="vcov" placeholder="$" readonly>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Recargo</div>
						<input type="tel" class="ctrl money number form-control text-right" id="vrec" value='0' placeholder="$">
					</div>
					<!-- <div class="input-group">
						<div class="input-group-addon">Transporte ida</div>
						<input type="tel" class="ctrl money number form-control text-right" id="vtri" placeholder="$" value='0'>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Transporte vuelta</div>
						<input type="tel" class="ctrl money number form-control text-right" id="vtrv" placeholder="$" value='0'>
					</div> -->
					<div class="input-group">
						<div class="input-group-addon"><b>Total Domicilio</b></div>
						<input type="tel" class="form-control text-right" id="totaldom" placeholder="$" readonly>
					</div>
				</div>
				<h2 id="ldvalcli" class="text-center hidden"><i class="fa fa-spin fa-spinner"></i><br>Validando información del cliente...</h2>
				<h2 id="ldcoldis" class="text-center hidden"><i class="fa fa-spin fa-spinner"></i><br>Buscando colaboradores disponibles...</h2>
				<div id="dvdispo" class="hidden"></div>
			</div>
			<div class="modal-footer">
				<button id="btncancel" class="btn btn-default pull-left btn-lg" data-dismiss="modal">Cerrar</button>
				<button id="asignsalon" class="btn btn-primary btn-lg">Guardar</button>
				<button id="btassign" class="btn btn-success btn-lg pull-right hidden" >Asignar</button>
			</div>
		</div>
	</div>
</div>



<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" ></script>
<script type="text/javascript">
	var pubnub = new PubNub ({
	    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
	    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
	});
	$(document).ready(function(){
		slsalon();
		if($("#tdcov").html()=='<b>SI</b>'){
			$("#vcov").val(10000);
			//sumador();
		}else{
			$("#vcov").val(0);
		}
		if($("#valor").val()>0){
			var val = $("#valor").val();
			$("#vsrv").val(val);
			$(".ctrl").attr('readonly',true);
			$("#valort").removeClass('hidden');
		}
		sumsrv();
		sumador();
	});
	$(document).on('click','#btndispo',function(){
		$("#saco").addClass('hidden');
		valcli();
	});
	function slsalon(){
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'slsalon'},
			success:function(res){
				var dt=JSON.parse(res);
				var sl='<option value="" selected disabled>Seleccione salón...</option>';
				for(i in dt){
					sl+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
				}
				$("#slsalon").html(sl);
			},error:function(){
				swal('Error!','Refresque la página e intentelo nuevamente','error');
			}
		});
	}
	function valcli(){
		var ced=$("#tdced").text();
		var nom=$("#clinom").val();
		var ape=$("#cliape").val();
		var cel=$("#tdcel").val();
		var ema=$("#cliema").val();
		var dir=$("#tddir").text();
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'valcli',ced:ced,nom:nom,ape:ape,cel:cel,ema:ema,dir:dir},
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
						var dura=$("#serdu").val();
						var eki=$(this).data('sercod');
						if(loadcol(ide,codi,dura,eki)){
							sw2++;
						};
					});
					if(sw==sw2){
						console.log('ok');
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
				if(dt!=null){
					var cont='';
					for(i in dt){
						cont+=dt[i].nom+'<input class="pull-right chkcol" name="'+cid+'[]" type="checkbox" value="'+dt[i].cod+'"/><br><br>';
					}
				}else{
					cont='<small>No hay colaboradores disponibles</small>';
				}
				$("#"+cid).html(cont);
			},error:function(){
				return false;
				swal('Error','Ha ocurrido un error generando la lista de colaboradores disponibles.','error');
			}
		});
		return true;
	}
	$("#asignsalon").click(function(){
		var sw=1;
		$(".ctrl").each(function(){
			var n=$(this).val();
			var n2=1;
			if(n==''){
				n2=0;
			}else if(n==0){
				n2=1;
			}else{
				n2=n;
			}
			sw*=n2;
		});
		if(sw!=0){
			var sln=$("#slsalon").val();
			$("#slncod").val(sln);
			var tsln=$("#slsalon option:selected").text();
			$("#tbsln").html(tsln+'<a class="edtsln btn btn-default btn-xs pull-right"><i class="fa fa-trash text-danger"></i></a>');
			$("#slnnom2").html(tsln);
			var tdom=$("#totaldom").val();
			$("#tbtdom").html(tdom);
			swal({
				title: "Correcto!",
				text: "Se han asignado salón y costos. \r\n A continuación consulte la disponibilidad en el salón y asigne los colaboradores.",
				type: "success",
				confirmButtonClass: "btn-info",
				closeOnConfirm: true
			},function(isConfirm){
				//$("#modal-salon").modal('toggle');
				$("#btnsalon").addClass('hidden');
				$("#asignsalon").addClass('hidden');
				$("#saco").addClass('hidden');
				$("#btndispo").removeClass('hidden');
				$(".modaltitle").html('<b>COLABORADORES DISPONIBLES</b>');
				$("#slntitle").removeClass('hidden');
				$("#ldvalcli").removeClass('hidden');
				valcli();
				$("#btassign").removeClass('hidden');
				//$("#btndispo").trigger('click');
				
			});
		}else{
			swal('Faltan datos!','Todos los valores son obligatorios','warning');
		}
	});
	$(document).on('click','.edtsln',function(){
		$("#dvdispo").addClass('hidden');
		$("#slntitle").addClass('hidden');
		$("#asignsalon").removeClass('hidden');
		$("#btassign").addClass('hidden');
		$("#saco").removeClass('hidden');
		$(".modaltitle").html('<b>Asignar Salón y Costos</b>');
		$("#modal-salon").modal('toggle');
	});
	$("#btassign").click(function(){
		var feho=$("#feho").text().split(' ');
		var date=feho[0];
		var time=feho[1];
		var sln=$("#slncod").val();
		var dac=$("#dac").val();
		var cli=$("#codcli").val();
		var tel=$("#tdcel").val();
		var dv=$(".dvdircrg").length;
		var ser=[];
		var dur=[];
		var col=[];
		var vsrv=$("#vsrv").val();
		var vrec=$("#vrec").val();
		var vtri=$("#vtri").val();
		var vtrv=$("#vtrv").val();
		var cov =$("#vcov").val();
		var tdom=$("#totaldom").val().replace(/\D/g,'');
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
			$("#dvdispo").html('Enviando...');
			$.ajax({
				url:'app/proccess.php',
				type:'POST',
				data:{opc:'insdom',col:acol,sln:sln,ser:aser,dur:adur,cli:cli,tel:tel,cfe:date,cho:time,vsrv:vsrv,vrec:vrec,vtri:vtri,vtrv:vtrv,tdom:tdom,dac:dac,cov:cov},
				success:function(res){
					var dt=JSON.parse(res);
					if(dt.res=="OK"){
						//reload tb cita en salon via pubnub**********************/
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
						$('#modal-salon').modal('toggle');
						swal('Domicilio Confirmado','Los datos fueron enviados exitosamente al salón correspondiente y al cliente.','success');
						$('.mcont').html('<h2 class="text-center">Servicio gestionado exitosamente</h2>');
					}else if(dt.res=="ERR"){
						swal('Error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.','error');
					}else if(dt.res=="ERP"){
						swal('Error','Ha ocurrido un error inesperado. Comuniquese con Dpto de Sistemas.','error');
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
	$('#modal-salon').on('hide.bs.modal', function () {
		$("#dvdispo").html('');
		$("#serdu").val('0');
	});
	/*Control numerico form valores*/
	$(document).on('change click keyup input paste','.number',(function (event) {
	    $(this).val(function (index, value){
	        return value.replace(/\D/g, "");
	    });
	}));
	$('.money').keyup(function(){
		sumador();
	});
	function sumador(){
		var total = 0
	  	$(".money").each(
		    function(index, value) {
		      if($.isNumeric( $(this).val().replace(/\D/g,''))){
		      	var num=eval($(this).val().replace(/\D/g,''));
		      	total = total + num;
		      }
		    }
	  	);
	  	var tot=total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	    $("#totaldom").val(tot);
	}
	function sumsrv(){
		var total = 0
	  	$(".vlrsvc").each(
		    function(index, value) {
		      if($.isNumeric( $(this).val().replace(/\D/g,''))){
		      	var num=eval($(this).val().replace(/\D/g,''));
		      	total = total + num;
		      }
		    }
	  	);
	  	var tot=total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	    $("#vsrv").val(tot);
	}
</script>