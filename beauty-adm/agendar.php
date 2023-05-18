<?php 
include 'head.php';
include 'librerias_js.php';
?>
<div class="content">
	<h2 class="text-center">Agendamiento de citas y domicilios</h2>
	<div class="row">
		<div class="col-md-6 col-md-push-3">
			<label>Cliente</label><br>
			<small>Buscar cliente. Si no existe pulse + para crearlo.</small>
			<div class="input-group">
				<select class="form-control frm selectp" id="cliente"></select>
				<div class="input-group-addon">
					<a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal-newcliente'><i class="fa fa-plus"></i></a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tipo de agendamiento</label>
						<select class="form-control frm select" id="tipoage">
							<option value="" selected disabled>Tipo de agenda</option>
							<option value="C">Cita en Salón</option>
							<!-- <option value="D">Domicilio</option> -->
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Salón asignado</label>
						<select class="form-control frm select" id="selsalon" disabled>
							<option value="" selected disabled>Seleccione salón</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row datadom hidden">
				<div class="col-md-6">
					<div class="form-group">
						<label>Dirección</label>
						<input id="clidir" type="text" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Barrio</label>
						<select class="form-control select" id="selbarrio">
							<option value="" selected disabled>Seleccione barrio</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label>Fecha y hora</label>
					<input id="feho" placeholder="Seleccione fecha y hora" class="form-control text-center frm" readonly style="cursor: pointer;">
				</div>
			</div>
			<div class="row">
				<label>Servicio y Colaborador</label><br>
				<small>Seleccione servicio, colaborador y pulse + para agregarlo</small>
				<div class="input-group">
					<select class="form-control sercol select" id="selserv" disabled>
						<option value="">Buscar y seleccionar servicio</option>
					</select>
					<select class="form-control sercol select" id="selcolab" disabled>
						<option value="">Buscar y seleccionar colaborador</option>
					</select>
					<div class="input-group-addon">
						<button class="btn btn-primary" id="addsercol" disabled><i class="fa fa-plus"></i></button>
					</div>
				</div>
			</div>
			<div class="table-responsive" style="width: 100%;padding:0px; margin:0px;">
				<table id="tbsercol" class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th id="tbsercolhead" class="text-center headfoot">Servicios a agendar</th>
						</tr>
					</thead>
					<tbody>
						<tr id="tbsercolempty">
							<td>No hay servicios agregados</td>
						</tr>
					</tbody>
					<tfoot>
						<tr class="fdomi hidden">
							<td colspan="2">Transporte</td>
							<td><input type="tel" id="valtsp" class="costo num form-control text-right" value="0"></td>
						</tr>
						<tr class="fdomi hidden">
							<td>Kit COVID-Pro</td>
							<td class="text-center"><input id="chkkcovid" type="checkbox"></td>
							<td><input type="tel" id="valkit" class="costo num form-control text-right" value="0" readonly></td>
							<input type="hidden" id="prekitcovid">
						</tr>
						<tr class="fdomi hidden">
							<th colspan="2">TOTAL</th>
							<th id="valtotal" class="text-right">0</th>
						</tr>
						<tr>
							<td class="fagenda headfoot text-center hidden">
								<button id="btnagendar" class="btn btn-primary">Agendar</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-newcliente">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus text-primary"></i> Nuevo Cliente</h4>
			</div>
			<div class="modal-body">
				<h5 class="text-center"><b>Identificación del cliente</b></h5>
				<div class="row">
					<div class="col-md-2">
						<label>Tipo</label>
						<select class="form-control">
							<option value="2">CC</option>
						</select>
					</div>
					<div class="col-md-6">
						<label>Número de Identificación</label>
						<div class="input-group">
							<input type="text" class="form-control numc" maxlength="10" id="ncidnum">
							<div class="input-group-addon hidden resetnc"><i class="fa fa-trash reset"></i></div>
						</div>
					</div>
				</div>
				<hr/>
				<h5 class="text-center"><b>Datos personales</b></h5>
				<div class="row">
					<div class="col-md-6">
						<label>Nombres</label>
						<input type="text" class="form-control dtcli" id="ncnom" readonly>
					</div>
					<div class="col-md-6">
						<label>Apellidos</label>
						<input type="text" class="form-control dtcli" id="ncape" readonly>
					</div>
				</div>
				<hr/>
				<h5 class="text-center"><b>Datos de contacto</b></h5>
				<div class="row">
					<div class="col-md-7">
						<label>Correo</label>
						<input type="text" class="form-control dtcli" id="ncmail" readonly>
					</div>
					<div class="col-md-5">
						<label>Celular</label>
						<input type="tel" maxlength="10" class="form-control dtcli numc" id="nccel" readonly>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button id="ncguardar" class="btn btn-primary savenc hidden">Guardar</button>
				<button id="nceditar" class="btn btn-primary edtc hidden">Editar</button>
				<button id="nccontinuar" class="btn btn-primary edtc hidden">Agendar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		loadsalon();
		loadbarrio();
		loadsrv();
		$('#cliente').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar cliente...'
        });
		$('#cliente').on('show.bs.select', function (e) {
	        $('.bs-searchbox').addClass('algo');
	        $('.algo .form-control').attr('id', 'fucker');
	    });
	    $(document).on('keyup', '#fucker', function(event) {
	        var seek = $(this).val();
	        if(seek.length>=3){
	            $.ajax({
	                url: 'app/proccess.php',
	                type: 'POST',
	                data:'opc=loadcli&txt='+seek,
	                success: function(data){
	                    if(data){
	                        var json = JSON.parse(data);
	                        var opcs = "";
	                        for(var i in json){
	                            opcs += "<option data-phone='"+json[i].phone+"' data-address='"+json[i].address+"' data-brr='"+json[i].brr+"' value='"+json[i].cod+"'>"+json[i].nom+" ("+json[i].ced+")</option>";
	                        }
	                        $("#cliente").html(opcs).selectpicker('refresh');
	                    }
	                }
	            }); 
	        }
	    });
		$("#tipoage").change(function(){
			changes();
			var tp=$(this).val();
			$("#selsalon").removeAttr('disabled').val('');
			try{$('#feho').val('').data("DateTimePicker").destroy().val();}catch(error){}
			if(tp=='C'){
				$(".datadom").addClass('hidden');
			}else if(tp=='D'){
				kitcovid();
				$(".datadom").removeClass('hidden');
			}
		});
		$(document).on('dp.change','#feho',function(e){
			$('#selserv').val(null).trigger('change');
			$("#selcolab").attr('disabled',true);
			$(".scrow").remove();
			rows();
			var opc=$("#tipoage").val();
			var d=e.date.day();
			var horas=[];
			var hclose=[];
			var disDates=[0];
			if(opc=='C'){
				horas=horario(d).horas;
				hclose=horario(d).hclose;
			}else{
				disDates=[0];
				horas=[8,9,10,11,12,13,14,15,16,17];
				hclose=[[moment({ h: 17, m: 30 }), moment({ h: 24 })]];
			}
			try{
				$('#feho').data('datetimepicker').enabledHours(horas);
				$('#feho').data('datetimepicker').disabledTimeIntervals(hclose);
				$('#feho').data('datetimepicker').daysOfWeekDisabled(disDates);
			}catch{
				//al generar por primera vez el calendario al estar vacio genera excepcion, 
				//pero esto ya se controla en la creacion del calendario mismo
			}
		});
		$("#selsalon").change(function(){
			changes();
			calendario();
			$("#selserv").removeAttr('disabled');
		});
		$("#selserv").change(function(){
			var srv = $(this).val();
			var sln = $("#selsalon").val();
			var tp  = $("#tipoage").val();
			$("#addsercol").attr('disabled',true);
			if(srv){
				loadcol(srv,sln,tp);
			}
		});
		$("#selcolab").change(function(){
			var srv = $("#selserv").val();
			var col = $("#selcolab").val();
			if((srv!='') && (col!='')){
				$("#addsercol").removeAttr('disabled');
			}else{
				$("#addsercol").attr('disabled',true);
			}
		});
		$("#addsercol").click(function(){
			var tpo = $("#tipoage").val();
			var srv = $("#selserv").val();
			var col = $("#selcolab").val();
			var tsrv = $("#selserv option:selected").text();
			var tcol = $("#selcolab option:selected").text();
			if((srv!='') && (col!='')){
				$("#tbsercolempty").addClass('hidden');
				$('#selserv').val(null).trigger('change');
				$('#selcolab').val(null).trigger('change').attr('disabled',true);
				if(tpo=='C'){
					$(".headfoot").attr('colspan','3');
					var row = '<tr class="scrow" data-srv="'+srv+'" data-col="'+col+'"><td>'+tsrv+'</td><td>'+tcol+'</td><td class="text-center"><button class="btn btn-default delrow"><i class="fa fa-trash text-danger"></i></button></td></tr>';
				}else{
					$(".headfoot").attr('colspan','4');
					$(".fdomi").removeClass('hidden');
					var row = '<tr class="scrow" data-srv="'+srv+'" data-col="'+col+'">'+
					'<td>'+tsrv+'</td>'+
					'<td>'+tcol+'</td>'+
					'<td class="price"><input type="tel" class="form-control precio costo num text-right" placeholder="Precio..." value="0"/></td>'+
					'<td class="text-center"><button class="btn btn-default delrow"><i class="fa fa-trash text-danger"></i></button></td></tr>';
				}
				$("#tbsercol tbody").append(row);
				$(".fagenda").removeClass('hidden');
				if($("#chkkcovid").is(':checked')){
					chkcovid();
				}
			}else{
				swal('Faltan datos','Asegúrese de seleccionar Servicio y Colaborador','warning');
			}
		});
		$(document).on('click','.delrow',function(){
			$(this).parent().parent().remove();
			if($("#chkkcovid").is(':checked')){
				chkcovid();
			}
			totalizar();
			rows();
		});
		$("#chkkcovid").change(function(){
			var sw = $(this);
			if(sw.is(':checked')){
				chkcovid();
			}else{
				$("#valkit").val('0');
			}
			totalizar();
		})
		$("#btnagendar").click(function(){
			var btn = $(this);
			var seco  = [];
			var gdata;
			var cli = $('#cliente').val();
			var sw = 0;
			if(cli){
				var tpo = $("#tipoage").val();
				var sln = $('#selsalon').val();
				var feho = $("#feho").data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:00');
				if(tpo=='C'){
					$(".scrow").each(function(){
						var srv = $(this).data('srv');
						var col = $(this).data('col');
						seco.push({srv:srv,col:col});
					});
					gdata={opc:'agenda_c',cli:cli,tpo:tpo,sln:sln,feho:feho,seco:seco};
					sw=1;
				}else{
					var dir = $("#clidir").val();
					var brr = $("#selbarrio").val();
					if((dir!='') && (brr!=null)){
						var swp=1;
						$(".precio").each(function(){
							var pre=$(this).val();
							swp*=pre;
						});
						if(swp!=0){
							$(".scrow").each(function(){
								var srv = $(this).data('srv');
								var col = $(this).data('col');
								var pre = parseInt($(this).find('input').val().replace(/\,/g, "")); 
								seco.push({srv:srv,col:col,pre:pre});
							});
							if($("#chkkcovid").is(':checked')){
					 			var kcov = 1;
							}else{
								var kcov = 0;
							}
							gdata={opc:'agenda_d',cli:cli,dir:dir,brr:brr,tpo:tpo,sln:sln,feho:feho,kcov:kcov,seco:seco};
							sw=1;
						}
					}
				}
				if(sw==1){
					$('.select').attr('disabled',true);
					btn.html('<i class="fa fa-spin fa-spinner"></i> Enviando...').attr('disabled',true);
					$.ajax({
						url:'app/proccess.php',
						type:'POST',
						data:gdata,
						success:function(res){
							btn.html('Agendar').removeAttr('disabled');
							if(res>0){
								swal('Agendado!','','success');
								clear();
							}else{
								swal('Error no especificado','Comuníquese con sistemas para validar el error.','error')
							}
						},
						error:function(){
							btn.html('Agendar').removeAttr('disabled');
							swal('Error no especificado','Comuníquese con sistemas para validar el error.','error')
						}
					})
				}else{
					swal('Faltan datos','Asegúrese de que todos los campos estén completamente diligenciados','warning');
				}
			}else{
				swal('Seleccione Cliente!','','warning');
			}
		});
	});
</script>
<script type="text/javascript">
	function changes(){
		$('.sercol').val(null).trigger('change').attr('disabled',true);
		$(".scrow").remove();
		$("#feho").removeAttr('disabled');
		rows();
	}
	function clear(){
		$('select').val(null).trigger('change');
		$('.selectp').removeAttr('disabled');
		var cliente = $('#cliente');
	    cliente.selectpicker('deselectAll');
	    cliente.find('option').remove();
	    cliente.find('li').remove();
	    cliente.selectpicker('refresh');
		$("#feho").val('').attr('disabled',true);
		$("#selsalon").attr('disabled',true);
		$("#tipoage").removeAttr('disabled');
		changes();
	}
	function rows(){
		var cr=$("#tbsercol tbody tr").length;
		if(cr==1){
			$(".fdomi").addClass('hidden');
			$("#tbsercolempty").removeClass('hidden');
			$(".fagenda").addClass('hidden');
		}else{
			$(".fdomi").removeClass('hidden');
			$(".fagenda").removeClass('hidden');
		}
	}
	function loadsalon(){
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'slnfull'},
			success:function(res){
				var dat=JSON.parse(res);
				var opc='<option value="" selected disabled>Selecciona sal&oacute;n...</option>';
				for(var i=0 in dat){
					opc+='<option data-hlv="'+dat[i].hlv+'" data-hsb="'+dat[i].hsb+'" data-hdm="'+dat[i].hdm+'" value="'+dat[i].cod+'">'+dat[i].nom+'</option>'
				}
				$("#selsalon").html(opc);
			},error:function(){
				swal('Error!','Refresque la página e intentelo nuevamente','error');
			}
		});
	}
	function calendario(){
		try{
			var opc=$("#tipoage").val();
			var sw=0;
			var dt = new Date();
			var mdt = new Date();
			var disDates=[];
			var hclose=[];
			var horas=[];
			if(opc=='C'){
				var place=$("#selsalon option:selected").val();
				if((place!='') || (!isNaN(place))){
					sw=1
					var d=dt.getDay();
					horas=horario(d).horas;
					hclose=horario(d).hclose;
					if((dt.getMinutes()>0) && (dt.getMinutes()<=30)){
						dt.setHours(dt.getHours() + 1);
						dt.setMinutes(30);
						dt.setSeconds(0);
					}else if(dt.getMinutes()>30){
						dt.setHours(dt.getHours() + 2);
						dt.setMinutes(0);
						dt.setSeconds(0);
					}else if(dt.getMinutes()==0){
						dt.setHours(dt.getHours() + 1);
						dt.setMinutes(0);
						dt.setSeconds(0);
					}
					if((dt.getHours()>=19)){
						dt.setDate(dt.getDate() + 1);
						dt.setHours(horas[0]);
						dt.setMinutes(0);
						dt.setSeconds(0);
					}
				}else{
					sw=0;
				}
			}else{
				disDates=[0];
				var sw=1;
				if((dt.getMinutes()>0) && (dt.getMinutes()<=30)){
					dt.setHours(dt.getHours() + 5);
					dt.setMinutes(30);
					dt.setSeconds(0);
				}else if(dt.getMinutes()>30){
					dt.setHours(dt.getHours() + 6);
					dt.setMinutes(0);
					dt.setSeconds(0);
				}else if(dt.getMinutes()==0){
					dt.setHours(dt.getHours() + 5);
					dt.setMinutes(0);
					dt.setSeconds(0);
				}
				if((dt.getHours()>=17)){
					dt.setDate(dt.getDate() + 1);
					dt.setHours(9);
					dt.setMinutes(0);
					dt.setSeconds(0);
				}
				horas=[8,9,10,11,12,13,14,15,16,17];
				hclose=[[moment({ h: 17, m: 30 }), moment({ h: 24 })]];
			}
			if(sw==1){
				mdt.setDate(mdt.getDate() + 16);
				$('#feho').datetimepicker({
					locale:'es',
					format:'dddd, MMMM D, YYYY hh:mm A',
	            	sideBySide: true,
	            	ignoreReadonly:true,
	            	stepping:30,
				    disabledTimeIntervals:hclose,
				    enabledHours: horas,
				    minDate: dt,
				    maxDate: mdt,
				    daysOfWeekDisabled: disDates,
				});
			}else{
				console.log('bom!');
			}
		}catch(error){}
	}
	function horario(d){
		var hlv=$("#selsalon").find(':selected').data('hlv').split(' a ');
		var hsb=$("#selsalon").find(':selected').data('hsb').split(' a ');
		var hdm=$("#selsalon").find(':selected').data('hdm').split(' a ');
		var horas=[];
		var mc='';
		var hclose=[];
		var ini='';
		var fin='';
		var fn='';
		try{
			switch(d){
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
					ini=parseInt(hlv[0].substring(0, 1))+1;
					fin=parseInt(hlv[1].substring(0, 1))+11;
					fn=hlv[1];
				break;
				case 6:
					ini=parseInt(hsb[0].substring(0, 1))+1;
					fin=parseInt(hsb[1].substring(0, 1))+11;
					fn=hsb[1];
				break;
				case 0:
					ini=parseInt(hdm[0].substring(0, 1))+1;
					fin=parseInt(hdm[1].substring(0, 1))+11;
					fn=hdm[1];
				break;
			}
			for(i=ini;i<=fin;i++){
				horas.push(i);
			}
			i--;
			mc=fn.split(':')[1].substring(0,2);
			if(mc=='00'){
				hclose=[[moment({ h: i, m: 30 }), moment({ h: 24 })]];
			}else{
				hclose=[[moment({ h: (i+1), m: 0 }), moment({ h: 24 })]];
			}
		}catch(error){
			console.log(error);
		}
		var hr={horas:horas,hclose:hclose};
		return hr;
	}
	function loadbarrio(){
		$.ajax({
            url:'app/proccess.php',
            type:'POST',
            data:{opc:'loadbarrio'},
            success:function(res){
                var resp=JSON.parse(res);
                var opc='<option value="" selected disabled>Seleccione barrio</option>';
                for(var i=0 in resp){
                    opc+='<option value="'+resp[i].cod+'">'+resp[i].nom+'</option>';
                }
                $("#selbarrio").html(opc).select2();
            }
        })
	}
	function loadsrv(){
		$.ajax({
            url:'app/proccess.php',
            type:'POST',
            data:{opc:'loadser'},
            success:function(res){
                var resp=JSON.parse(res);
                var opc='<option></option>';
                for(var i=0 in resp){
                    opc+='<option data-dur="'+resp[i].dur+'" value="'+resp[i].cod+'">'+resp[i].nom+' ['+resp[i].dur+' minutos]</option>';
                }
                $("#selserv").html(opc).select2({placeholder:"Seleccione servicio",allowClear:true});
            }
        })	
	}
	function loadcol(srv,sln,tp){
		try{
			$("#selcolab").select2('destroy').html('<option>Cargando colaboradores...</option>').attr('disabled',true);
			var feho = $("#feho").data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:00');
			$.ajax({
	            url:'app/proccess.php',
	            type:'POST',
	            data:{opc:'loadcolage',srv:srv,sln:sln,tp:tp,feho:feho},
	            success:function(res){
	                var resp=JSON.parse(res);
	                var opc='<option></option>';
	                for(var i=0 in resp){
	                    opc+='<option value="'+resp[i].cod+'">'+resp[i].nom+'</option>';
	                }
	                $("#selcolab").removeAttr('disabled').html(opc).select2({placeholder:"Buscar y seleccionar colaborador",allowClear:true});
	            }
	        })	
		}catch(error){}
	}
	$(document).on('change click keyup input paste','.num',(function (event) {
        $(this).val(function (index, value){
        	totalizar();
            return formatNum(value.replace(/\D/g, ""));
        });
    }));
    $(document).on('change click keyup input paste','.numc',(function (event) {
        $(this).val(function (index, value){
            return value.replace(/\D/g, "");
        });
    }));
    function totalizar(){
		var sum=0;
		$(".costo").each(function(){
			var val=parseInt($(this).val().replace(/\,/g, ""));
			sum+=val;
		})
		$("#valtotal").html('$'+formatNum(sum));
	}
	function formatNum(num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
	}
	function kitcovid(){
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'kcovid'},
			success:function(res){
				$("#prekitcovid").val(res);
			}
		})
	}
	function chkcovid(){
		var ctd = 0;
		var arr = [];
		var pkc = $("#prekitcovid").val();
		$(".scrow").each(function(){
			var col = $(this).data('col');
			arr.push(col);
		});
		var unico = Array.from(new Set(arr));
		var cnt = unico.length
		$("#valkit").val(formatNum(pkc*cnt));
		totalizar();
	}
</script>
<script type="text/javascript">//modal nuevo cliente
	$(document).on('blur','#ncidnum',function(){
		var inp = $(this);
		var ced = inp.val();
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'valced',ced:ced},
			success:function(res){
				var dt = JSON.parse(res);
				if(dt.sw==1){
					inp.attr('readonly',true);
					$("#ncnom").val(dt.data['nom']);
					$("#ncape").val(dt.data['ape']);
					$("#ncmail").val(dt.data['mail']);
					$("#nccel").val(dt.data['cel']);
					$(".resetnc").removeClass('hidden');
					$(".edtc").removeClass('hidden');
				}else{
					$(".dtcli").removeAttr('readonly');
					$(".savenc").removeClass('hidden');
				}
			}
		})
	});
	$('#modal-newcliente').on('hidden.bs.modal', function () {
		$("#ncidnum").val('').removeAttr('readonly');
	 	$(".dtcli").val('').attr('readonly',true);
	 	$(".resetnc").addClass('hidden');
		$(".edtc").addClass('hidden');
		$(".savenc").addClass('hidden');
	});
	$("#nceditar").click(function(){
		$(".dtcli").removeAttr('readonly');
		$(".savenc").removeClass('hidden');
		$(".edtc").addClass('hidden');
	});
	$(".reset").click(function(){
		$("#ncidnum").val('').removeAttr('readonly');
	 	$(".dtcli").val('').attr('readonly',true);
	 	$(".resetnc").addClass('hidden');
		$(".edtc").addClass('hidden');
		$(".savenc").addClass('hidden');
	});
	$("#ncguardar").click(function(){
		var ced = $("#ncidnum").val();
		var nom = $("#ncnom").val();
		var ape = $("#ncape").val();
		var mail= $("#ncmail").val();
		var cel = $("#nccel").val();
		$.ajax({
			url:'app/proccess.php',
			type:'POST',
			data:{opc:'savecli', ced:ced, nom:nom, ape:ape, mail:mail, cel:cel},
			success:function(res){
				if(res==1){
					cedToAgenda();
				}else{
					swal('Error!','Refresque la página e intentelo nuevamente.','error');
				}
			}
		})
	});
	$("#nccontinuar").click(function(){
		cedToAgenda();
	});
	function cedToAgenda(){
		var ced = $("#ncidnum").val();
		$.ajax({
            url: 'app/proccess.php',
            type: 'POST',
            data:'opc=loadcli&txt='+ced,
            success: function(data){
                if(data){
                    var json = JSON.parse(data);
                    var opcs = "";
                    for(var i in json){
                        opcs += "<option data-phone='"+json[i].phone+"' data-address='"+json[i].address+"' data-brr='"+json[i].brr+"' value='"+json[i].cod+"'>"+json[i].nom+" ("+json[i].ced+")</option>";
                    }
                    $("#cliente").html(opcs).selectpicker('refresh');
                    var cli = $('#cliente option:eq(1)').val();
                    $("#cliente").val(cli).change();
                    $('#modal-newcliente').modal('toggle');
                }
            }
        }); 
	}
</script>