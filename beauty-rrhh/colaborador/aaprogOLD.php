<?php 
include '../head.php';

?>
<style>

</style>
<div class="content" style="background-color: white;">
	<h3 class="text-center">PROGRAMACIÓN DE COLABORADORES</h3>
	<div class="row">
		<div class="col-md-2">
			<div class="input-group">
				<span class="input-group-addon fa fa-university"></span>
				<select id="slsalon" class="form-control">
					<option value="" selected disabled>Elija Salón...</option>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
				<span class="input-group-addon fa fa-calendar"></span>
				<input id="periodo" class="form-control" placeholder="Elija periodo..." disabled>
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon fa fa-users"></span>
				<select id="slcargo" class="form-control" disabled><option value="" selected disabled>Seleccione cargo</option></select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon fa fa-user"></span>
				<select id="slcolab" class="form-control" disabled></select>
			</div>
		</div>
		<div class="col-md-2">
			<a href="" class="btn btn-default"><span class="fa fa-refresh text-info"></span></a>
			<button id="insert" class="btn btn-default" data-toggle="tooltip" title="Guardar la programación"><span class="fa fa-upload text-info"></span> Insertar</button>
		</div>
	</div>
	<div class="row">
		<div class="table-responsive">
			<table id="tbprog" class="table table-bordered table-striped">
				<tbody>
				</tbody>
				<tfoot>
	         		<tr class="colxdia hidden">
	         			<th colspan="2">Colaboradores laborando cada dia</th>
	         		</tr>
         	</tfoot>
			</table>
		</div>
	</div>
	<input type="hidden" id="festivos">
	<input type="hidden" id="especiales">
</div>

<div class="modal fade" id="modal-turno">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Asignación de turnos para <b id="datehead"></b></h4>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<span class="input-group-addon fa fa-clock-o"></span>
					<select class="form-control" id="slturno"></select>
				</div>
				<div class="input-group">
					<span class="input-group-addon fa fa-calendar-check-o"></span>
					<select class="form-control" id="sltipolab"></select>
				</div>
				<div class="input-group">
				    <span class="input-group-addon"><input class="hidden" id="chkcopy" type="checkbox" checked><i class="fa fa-copy"></i> Asignar a:</span>
				    <input id="copyto" class="form-control" placeholder="Asignar a dias...">
				</div>
				<input type="hidden" id="row">
				<input type="hidden" id="cell">
				<input type="hidden" id="tdia">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" id="assign" class="btn btn-primary">Asignar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalErrores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-times text-danger"></i> Programación en conflicto</h4>
      </div>
      <div class="modal-body">
         <table class="table table-bordered table-hover" id="tblErrores">
         	<thead>
         		<tr>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Colaborador</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Salón</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Fecha</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Turno</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Tipo</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Puesto</th>
         		</tr>
         	</thead>
         	<tbody></tbody>
         </table>
      </div>
      <div class="modal-footer">
        <a class="btn btn default" data-dismiss="modal">Cerrar</a>
        <p class="pull-left"><b><i class="fa fa-info-circle"></i> Estos colaboradores ya tienen programación en los dias mostrados. No se hicieron cambios en los dias mostrados.</b></p>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-prevmonth">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-calendar"></i> Programación del mes anterior</h4>
				<h3 id="prevmonth-nomcol"></h3>
			</div>
			<div class="modal-body">
				<h3 id="loading" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Cargando programacion...</h3>
				<div id='calendar'></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="../../lib/vendor/select2-3.5.2/select2.min.js"></script>
<script src="../../lib/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../js/selectpicker/selectpicker.js"></script>
<script src="../../lib/vendor/multiselect/bootstrap-multiselect.js"></script>
<script src="../../lib/vendor/moment/min/moment.min.js"></script>
<script src="../../lib/vendor/blockui/blockui.js"></script>
<script src="../../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="../../lib/vendor/moment/min/moment.min.js"></script>
<script src="../../lib/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../../lib/vendor/fullcalendar/dist/lang-all.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).bind('contextmenu', function(e) { return false; });
		$("#periodo").datepicker({
		    format: "mm-yyyy",
		    startView: "months", 
		    minViewMode: "months",
		    autoclose: true
		});
		$("#copyto").datepicker({
			format: 'yyyy-mm-dd',
		    startDate: 0,
		    multidate: true,
		});
	
		loadsln();
		loadcrg();
		loadtilab()
		var codsalon;
		var periodo;
		var cargo;
		var mes;
		var yr;
		
		///////////////////////////////////////////////////////
		
		$(function() {
			$('#calendar').fullCalendar({
				lang: 'es',
				header:{
					left:'title',
					center:'',
					right:''
				},
				eventRender: function(event, element){           
					$(element).tooltip({title: event.salon + " - " + event.turno, container: "body"});                                                                                             
		        },
		        loading: function(bool) {
				  if (bool) 
				    $('#loading').show();
				  else 
				    $('#loading').hide();
				},
			})
			$("#calendar").fullCalendar('render');
		});
	});

	////////////////////////////////////////////////////////
	
    $("#slsalon").change(function(){
    	codsalon=$("#slsalon").val();
    	$(this).attr('disabled', 'true');
    	$("#periodo").removeAttr('disabled');
    });
    $("#periodo").change(function(e){
    	if(e.handled !== true)
        {
	    	periodo=$("#periodo").val();
	    	var per=periodo.split('-');
	    	mes=parseInt(per[0]);
	    	yr=parseInt(per[1]);
	    	$(this).attr('disabled', 'true');
	    	$("#slcargo").removeAttr('disabled');
	    	$("#copyto").datepicker('setStartDate', yr+'-'+mes+'-01');
	    	festivos(mes,yr);
	    	especiales(mes,yr);
	    }
    });

    var sw = 0;
    var dom = [];
    var fest = [];
    var esp = [];
    var saba = [];
    var grilla = [];
    var JSONDS ;
    var JSONDOM ;
    var JSONFES ;
    var JSONSAB ;
    var JSONESP ;
    $("#slcargo").click(function(){
    	cargo=$("#slcargo").val();
		$("#slcolab").removeAttr('disabled');
		$('#slcolab').selectpicker({
		    liveSearch: true,
		    title:'Buscar y seleccionar colaborador(es)...'
		});
    	if(sw==0){
	    	var lastday = function(y,m){
				return  new Date(y, m , 0).getDate();
			}
			var cdia=lastday(yr,mes);
			var festivos=$("#festivos").val().split(',');
			var especiales =$("#especiales").val().split(',');
	    	$("#tbprog tbody").append('<tr id="th"><th class="text-center">Colaborador</th><th>Puesto</th>');
	     	for(var i=1;i<=cdia;i++){
	     		var dia=diaSemana(i,mes,yr);
	     		$(".colxdia").append('<th class="text-center text-danger cxd'+i+'">0</th>');
	     		if((dia=='Dom') || (festivos.includes(i.toString())) || (especiales.includes(i.toString())) ){
	     			$("#th").append('<th class="text-center text-danger">'+dia+'<br>'+i+'</th>');
	     			if(dia=='Dom'){
	     				dom.push(i);
	     			}else if(festivos.includes(i.toString())){
	     				fest.push(i);
	     			}else if(especiales.includes(i.toString())){
	     				esp.push(i);
	     			}
	     		}else{
	     			$("#th").append('<th class="text-center">'+dia+'<br>'+i+'</th>');
	     		}
	     		if( (dia=='Sab') && (!festivos.includes(i.toString())) && (!especiales.includes(i.toString())) ){
	     			saba.push(i);
	     		}
	     	}

	     	$("#th").append('<th class="text-center"><span class="fa fa-times text-danger"></span></th>');
	     	$("#th").append('</tr>');
	     	sw=1;
    	}
    });
    $("#slcargo").change(function(e){
    	var crg=$(this).val();
    	horarios(crg);
    })

	////////////////////////////////////////////////////////

    $('#slcolab').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
        if($("#slcargo").val().length>0){
    		$("#slcargo").attr('disabled','true');
        }
    });
    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        var crg=$("#slcargo").val();
        $.ajax({
            url: 'zprog/fillcont.php',
            type: 'POST',
            data:'opc=clb&txt='+seek+'&crg='+crg,
            success: function(data){
            	if(data){
	                var json = JSON.parse(data);
	                var opcs = "";
	                for(var i in json){
	                    opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
	                }
	                $("#slcolab").html(opcs).selectpicker('refresh');
            	}
            }
        }); 
    });
    var lastday = function(y,m){
		return  new Date(y, m , 0).getDate();
	}
    $('#slcolab').change(function(e){
    	if(e.handled !== true){
    		$(".colxdia").removeClass('hidden');
	     	var clbcod=$(this).val();
	     	if(!grilla.includes(clbcod)){
	     		grilla.push(clbcod);
		     	var fullname=$('#slcolab option:selected').text().split(' ');
		     	clbnom=fullname[0]+' '+fullname[2];
		     	$(this).empty();
		     	
				var cdia=lastday(yr,mes);

		     	$("#tbprog tbody").append('<tr id="tr'+clbcod+'" class="rows" data-clb="'+clbcod+'"><td style="cursor:pointer;" class="prevmonth">'+clbnom+'</td><td><select class="pto" id="pto'+clbcod+'"></select></td>');
		     	puestos($("#pto"+clbcod));
		     	for(var i=1;i<=cdia;i++){
		     		if(dom.includes(i)){
		     			$("#tr"+clbcod).append('<td data-toggle="tooltip" class="do text-center td-col td-dia'+i+'" data-tdia="do" data-fecha="'+yr+'-'+mes+'-'+i+'"></td>');
		     		}else if(saba.includes(i)){
		     			$("#tr"+clbcod).append('<td data-toggle="tooltip" class="sb text-center td-col td-dia'+i+'" data-tdia="sb" data-fecha="'+yr+'-'+mes+'-'+i+'"></td>');
		     		}else if(fest.includes(i)){
		     			$("#tr"+clbcod).append('<td data-toggle="tooltip" class="fs text-center td-col td-dia'+i+'" data-tdia="fs" data-fecha="'+yr+'-'+mes+'-'+i+'"></td>');
		     		}else if(esp.includes(i)){
		     			$("#tr"+clbcod).append('<td data-toggle="tooltip" class="sp text-center td-col td-dia'+i+'" data-tdia="sp" data-fecha="'+yr+'-'+mes+'-'+i+'"></td>');
		     		}else{
		     			$("#tr"+clbcod).append('<td data-toggle="tooltip" class="ds text-center td-col td-dia'+i+'" data-tdia="ds" data-fecha="'+yr+'-'+mes+'-'+i+'"></td>');
		     		}
		     	}
		     	$("#tr"+clbcod).append('<td data-toggle="tooltip" title="Quitar esta fila"><button class="btn btn-default delrow"><span class="fa fa-times text-danger"></span></button></td>');
		     	$("#tr"+clbcod).append('</tr>');
		     	$("#slcolab").val('default');
				$("#slcolab").selectpicker("refresh");
	     	}else{
	     		swal('Alerta!','Este colaborador ya ha sido agregado, verifique.','warning')
	     	}
        }
    })
    /////////////////////////////////////////////////////////
    $(document).on('click', '.delrow', function(e) {
    	e.preventDefault();
    	var clb=$(this).parent().parent().data('clb');
    	var index = grilla.indexOf(clb.toString());
    	if(index!=-1){
			grilla.splice(index, 1);
		}
    	$(this).parent().parent().remove();
    	sumalab();
    });

    $("#copyto").change(function(e){
    	$('#chkcopy').attr('checked',true);
    })

    function diaSemana(dia,mes,anio){
	    var dias=["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
	    var dt = new Date(mes+' '+dia+', '+anio+' 12:00:00');
	    return dias[dt.getUTCDay()];    
	}
	function festivos(m,a){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'fes',mes:m,yr:a},
			success:function(res){
				$("#festivos").val(res);
			}
		});
	}
	function especiales(m,a){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'esp',mes:m,yr:a},
			success:function(res){
				$("#especiales").val(res);
			}
		});
	}
	function puestos(ctrl){
		var crg=$("#slcargo option:selected").text();
		var sln=$("#slsalon").val();
		$.ajax({
			url: 'zprog/fillcont.php',
			type: 'POST',
			data: {opc:'pto',crg:crg,sln:sln},
			success: function(data){
				var json = JSON.parse(data);
				var opcs = "<option value='0' selected disabled>Puesto</option>";
				for(var i in json){
					opcs += "<option value='"+json[i].codigo+"'>"+json[i].nombre+"</option>";
				}
				ctrl.html(opcs);
			}
		});	
	}
	function loadsln(){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'sln'},
			success:function(data){
				var json = JSON.parse(data);
				var opcs = "";
				for(var i in json){
                    opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#slsalon").append(opcs);
			}
		})
	}
	function loadcrg(){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'crg'},
			success:function(data){
				var json = JSON.parse(data);
				var opcs = "<option value='adm'>Administradoras y auxiliares</option>";
				for(var i in json){
                    opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#slcargo").append(opcs);
			}
		})
	}
	function loadtilab(){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'tilab'},
			success:function(data){
				var json = JSON.parse(data);
				var opcs = "<option value='' selected disabled>Elija Tipo de actividad</option>";
				for(var i in json){
					if(json[i].cod==1){
						opcs += "<option value='"+json[i].cod+"' selected>"+json[i].nom+"</option>";
					}else{
						opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
					}
                }
                $("#sltipolab").html(opcs);
			}
		})
	}
	function validarcopyto(desde,hasta){
		var date = new Date(desde);
		var date2= new Date(hasta);
		var limit = new Date(date.getFullYear(), date.getMonth() + 1, 0);
		if(date2>limit){
			return false;
		}else if(date2<date){
			return false;
		}else{
			return true;
		}
	}
	function horarios(crg){
		var sw=0;
		var sln=$("#slsalon").val();
		if(crg=='adm'){
			sw=1;
		}
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'trn', diasem:'LUN', sln:sln, sw:sw, tdia:'ds'},
			success:function(res){
				JSONDS=JSON.parse(res);
			}
		})
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'trn', diasem:'SAB', sln:sln, sw:sw, tdia:'sb'},
			success:function(res){
				JSONSAB=JSON.parse(res);
			}
		})
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'trn', diasem:'DOM', sln:sln, sw:sw, tdia:'do'},
			success:function(res){
				JSONDOM=JSON.parse(res);
			}
		})
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'trn', diasem:'FES', sln:sln, sw:sw, tdia:'fs'},
			success:function(res){
				JSONFES=JSON.parse(res);
			}
		})
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'trn', diasem:'ESP', sln:sln, sw:sw, tdia:'sp'},
			success:function(res){
				JSONESP=JSON.parse(res);
			}
		})
	}
	function sumalab(){
		var cdia=lastday(yr,mes);
		for(i=1;i<=cdia;i++){
			var acum=0;
			$(".td-dia"+i).each(function(e){
				if($(this).data('tilab') == 1){
					acum++;
				}
			})
			$(".cxd"+i).empty();
			$(".cxd"+i).html(acum);
		}
	}

	$(document).on('click', '.td-col', function(e) {
		var sln=$("#slsalon").val();
		var datecell=$(this).data("fecha");
		$('#chkcopy').prop('checked', true);
	
		$("#copyto").datepicker("update", datecell);
		

		var fecha = $(this).data("fecha").split('-');
		var anio=parseInt(fecha[0]);
		var mes=parseInt(fecha[1]);
		var dia=parseInt(fecha[2]);
		//var sw=0;
		var tdia = $(this).data("tdia");
		var diasem=diaSemana(dia,mes,anio);
		var row=$(this).parent().attr('id');
		var cell=dia;
		
		
		$("#slturno").empty();

		if(tdia=='ds'){
			var json=JSONDS;
		}else if(tdia=='do'){
			var json=JSONDOM;
		}else if(tdia=='sb'){
			var json=JSONSAB;
		}else if(tdia=='fs'){
			var json=JSONFES;
		}else if(tdia=='sp'){
			var json=JSONESP;
		}

		var opcs = "<option value='' selected disabled>Elija Turno</option>";
		for(var i in json){
			opcs += "<option value='"+json[i].codigo+"' data-orden='"+json[i].orden+"' data-color='"+json[i].color+"' data-horario='"+json[i].horario+"' style='background-color:"+json[i].color+";'>"+json[i].nombre+"</option>";
		}
		$("#slturno").html(opcs);
		$("#row").val(row); 
		$("#cell").val(cell);
		$("#tdia").val(tdia);

		if(!$(this).hasClass('asd')){
			$(this).css('background-color','red');
		}
		$("#datehead").html(datecell);
		//$("#").val(datecell);
		$("#modal-turno").modal('show');
	})
	$(document).on('mousedown', '.td-col', function(e) {
		var cell=$(this);
		if(e.which==3){	
			e.preventDefault();
			cell.removeClass('asd');
			cell.css('background-color','');
			cell.attr('data-trn',null);
			cell.attr('data-hor',null);
			cell.attr('data-tilab',null);
			cell.removeAttr('title');
			cell.removeAttr('style');
			cell.empty();
			cell.removeData('tilab');
			cell.removeData('hor');
			cell.removeData('tilab');
			sumalab();
		}
	});
	$("#assign").click(function(e){
		var turno=$("#slturno").val();
		var turnotxt=$("#slturno option:selected").text();
		var trnod=$("#slturno").find(':selected').data('orden');
		var tilab=$("#sltipolab").val();
		var cell=$("#cell").val();
		var desde=yr+'-'+mes+'-'+cell;
		var hasta=$("#copyto").val();
		if((turno>0) && (tilab>0)){
			var row=$("#row").val();
			var horario=$("#slturno").find(':selected').data('horario');
			var tilafulltext=$("#sltipolab option:selected").text();
			var tilabtxt=$("#sltipolab option:selected").text().substring(0,1).toUpperCase(); 
			if(tilabtxt!='L'){
				var color='gray';
			}else{
				var color=$("#slturno").find(':selected').data('color');
			}
			var tdia=$("#tdia").val();
			if ($('#chkcopy').is(':checked')) {
				var temp = new Array();
				temp = hasta.split(",");
				for (var i = 0; i < temp.length; ++i) {
					var ddd = temp[i].split('-');
					if(ddd[1]==mes){
					    
						/*var JSONDS ;
					    var JSONDOM ;
					    var JSONFES ;
					    var JSONSAB ;
					    var JSONESP ;*/
						var tipo=$('#'+row).find('.td-dia'+parseInt(ddd[2])).data('tdia');
						var trntmp=[];
						if(tipo=='sb'){
							//trntmp=JSONSAB.filter(x => x.orden === trnod);
							trntmp=JSONSAB.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod));
							if(trntmp.length==0){
								trntmp=JSONSAB.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod-1));
							} 
							if(trntmp.length==0){
								trntmp=JSONSAB.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod+1));
							}
							if(trntmp.length==0){
								trntmp=JSONSAB.filter(x => (x.orden===0));
							}
						}else if(tipo=='do'){
							trntmp=JSONDOM.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod));
							if(trntmp.length==0){
								trntmp=JSONDOM.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod-1));
							} 
							if(trntmp.length==0){
								trntmp=JSONDOM.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod+1));
							}
							if(trntmp.length==0){
								trntmp=JSONDOM.filter(x => (x.orden===0));
							}
						}else if(tipo=='ds'){
							trntmp=JSONDS.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod));
							if(trntmp.length==0){
								trntmp=JSONDS.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod-1));
							} 
							if(trntmp.length==0){
								trntmp=JSONDS.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod+1));
							}
						}else if(tipo=='fs'){
							trntmp=JSONFES.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod));
							if(trntmp.length==0){
								trntmp=JSONFES.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod-1));
							} 
							if(trntmp.length==0){
								trntmp=JSONFES.filter(x => (x.nombre.substr(0, 2) === turnotxt.substr(0, 2)) && (x.orden===trnod+1));
							}
							if(trntmp.length==0){
								trntmp=JSONFES.filter(x => (x.orden===0));
							}
						}
						if(tilabtxt!='L'){
							var color='gray';
						}else{
							var color=trntmp[0].color;
						}
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).attr('data-trn',trntmp[0].codigo);
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).attr('data-hor',trntmp[0].horario);
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).css('background-color',color);
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).removeData('tilab');
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).attr('data-tilab',null).attr('data-tilab',tilab);
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).html('<b>'+tilabtxt+'</b>');
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).addClass('asd');
						$('#'+row).find('.td-dia'+parseInt(ddd[2])).attr('title',trntmp[0].nombre+'\r\n'+tilafulltext);
						//console.log(trntmp[0].horario)
					}
				}
			}else{
				$('#'+row).find('.td-dia'+cell).css('background-color',color);
				$('#'+row).find('.td-dia'+cell).attr('data-trn',turno);
				$('#'+row).find('.td-dia'+cell).attr('data-hor',horario);
				$('#'+row).find('.td-dia'+cell).attr('data-tilab',tilab);
				$('#'+row).find('.td-dia'+cell).html('<b>'+tilabtxt+'</b>');
				$('#'+row).find('.td-dia'+cell).addClass('asd');
				$('#'+row).find('.td-dia'+cell).attr('title',turnotxt+'\r\n'+tilafulltext);
			}
			$('#modal-turno').modal('toggle');
			//$('#chkcopy').prop('checked', false);
			$("#sltipolab").val('1');
			$("#copyto").val('').datepicker("update");
		}else{
			swal('Advertencia!','Faltan opciones por elegir','warning');
		}
		sumalab();
	})
	$("#insert").click(function(e){
		var swpto=1;
		var fec=$("#periodo").val().split('-');
		var fecha=fec[1]+'-'+fec[0]+'-01';
		$(".pto").each(function(e){
			var pto=$(this).val();
			swpto*=pto;
		})
		if(swpto!=0){
			var filas=[];
			var sln=$("#slsalon").val();
			$(".rows").each(function(e){
				clbcod = $(this).data('clb');
				pto=$(this).find('.pto').val();
				$(this).find(".asd").each(function(e){
					filas.push({
						'colab':clbcod,
						'turno':$(this).data('trn'),
						'horario':$(this).data('hor'),
						'salon':sln,
						'puesto':pto,
						'fecha':$(this).data('fecha'),
						'tipo':$(this).data('tilab')
					})
				})
			})
			$.ajax({
				url:'zprog/insprog.php',
				type:'POST',
				data:{filas:filas},
				beforeSend: function(){
					$.blockUI({ css: { backgroundColor: '#333', color: '#fff'}, message: '<p> Insertando programacion.<br>Por favor espere...</p>' }); 
				},
				success:function(res){
					var jsondata = JSON.parse(res);
					$.unblockUI();
					if(jsondata.resp.length>0){
						$('#tblErrores tbody').empty();
		            	for(var i in jsondata.resp){
		            		$('#tblErrores tbody').append('<tr><td>'+jsondata.resp[i].colaborador+'</td><td>'+jsondata.resp[i].salon+'</td><td>'+jsondata.resp[i].fecha+'</td><td>'+jsondata.resp[i].turno+'</td><td>'+jsondata.resp[i].tipolab+'</td><td>'+jsondata.resp[i].puesto+'</td></tr>');
		            	}
						$('#modalErrores').modal("show");
						$('#modalErrores').on('hidden.bs.modal', function () {
						   window.location.href = "vistaProgramacion.php?slncodigo="+sln+"&fecha="+fecha;
						})
					}else{
						swal({
							title: "Correcto!",
							text: "La programación ha sido ingresada exitosamente",
							type: "success",
							confirmButtonClass: "btn-info",
							closeOnConfirm: false
						},function(isConfirm){
							window.location.href = "vistaProgramacion.php?slncodigo="+sln+"&fecha="+fecha;
						})
					}
				}
			})
		}else{
			swal('Defina puesto de trabajo','Por favor verifique que todos los puestos de trabajo estén asignados','error')
		}
		//console.log(filas);
	})

	/*MODAL MES ANTERIOR*/
	$(document).on('click','.prevmonth',function(){
		var clb=$(this).parent().data('clb');
		var nom=$(this).html();
		var events='zprog/prevmonth.php?clb='+clb;
		$("#prevmonth-nomcol").html(nom);
		$("#modal-prevmonth").modal('show');
		var fec=$("#periodo").val().split('-');
		var fecha=fec[1]+'-'+fec[0]+'-01';
		var mydate = new Date(fecha);
		mydate.setMonth(mydate.getMonth()-1);
		var mydate2 = mydate.toISOString().split('T')[0]
		$('#calendar').fullCalendar('gotoDate', mydate2);
      	$('#calendar').fullCalendar('addEventSource', events);         		
	})
	//carga la vista de calendario al abrir modal
	$('#modal-prevmonth').on('shown.bs.modal', function () {
	   $("#calendar").fullCalendar('render');
	   $('#calendar').fullCalendar('rerenderEvents' );
	});
	$('#modal-prevmonth').on('hide.bs.modal', function () {
	   $('#calendar').fullCalendar('removeEvents');
	});
</script>