<?php 
include '../head.php';
include '../librerias_js.php';
?>
<div class="content" style="background-color: white;">
	<h3 class="text-center"><b>Consulta de encuestas COVID colaboradores</b></h3>
	<div id="opciones">
		<div class="row">
			<div class="col-md-6 col-md-push-3">
				<div class="col-md-6">
					<button id="btnsln" class="btn btn-primary btn-lg btn-block"><i class="fa fa-university"></i><br>Buscar por salón</button>
				</div>
				<div class="col-md-6">
					<button id="btncol" class="btn btn-primary btn-lg btn-block"><i class="fa fa-user"></i><br>Buscar por Colaborador</button>
				</div>
			</div>
		</div>
	</div>
	<div id="xsalon" class="hidden opc2">
		<div class="row">
			<button class="btn btn-default volver"><i class="fa fa-arrow-left"></i> Volver</button>
		</div><br>
		<div class="row">
			<div class="col-md-6 col-md-push-3 text-center">
				<div class="form-group col-md-4">
		          <label for="fecha" class="col-md-12">Fecha</label>
		          <input type="text" class="form-control fecha text-center" id="fechas" name="fecha" placeholder="fecha" style="caret-color:white" >
		        </div>
				<div class="form-group col-md-8">
		          <label for="colaborador" class="col-md-12">Salón</label>
			        <div class="input-group">
			        	<select class="form-control gen" id="salon"></select>  
			        	<div class="input-group-addon">
			        		<button id="searchxs" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></button>
			        	</div>
			        </div>
		        </div>
			</div>
		</div>
		<div id="preloadxs" class="hidden">

			<h4 class="text-center"><i class="fa fa-spin fa-spinner"></i> Cargando...</h4>
		</div>
		<div id="tbxsalon" class="table-responsive hidden col-md-6 col-md-push-3">
			<i class="fa fa-check" style="color:green;"></i> = Encuesta realizada sin novedades <br>
			<i class="fa fa-warning text-danger"></i> = Encuesta realizada, resultado con alerta <br>
			<b>NR</b> = Encuesta NO realizada <br><br>
			<table id="tbxsln" class="table table-striped" style="width:100%;">
				<thead>
					<th>Colaborador</th>
					<th class="text-center">Entrada</th>
					<th class="text-center">Salida</th>
					<th class="text-center hidden">Entrada</th>
					<th class="text-center hidden">Salida</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<div id="xcolab" class="hidden opc2">
		<div class="row">
			<button class="btn btn-default volver"><i class="fa fa-arrow-left"></i> Volver</button>
		</div><br>
		<div class="row">
			<div class="text-center">
				<div class="form-group col-md-2">
		          <label for="fecha" class="col-md-12">Seleccione fecha</label>
		          <input type="text" class="form-control fecha text-center" id="fechac" name="fecha" placeholder="fecha" style="caret-color:white" >
		        </div>
				<div class="form-group col-md-4">
		          <label for="colaborador" class="col-md-12">Buscar Colaborador</label>
			        <div class="input-group">
			        	<select class="form-control gen" id="colaborador"></select>  
			        	<div class="input-group-addon">
			        		<button id="search" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></button>
			        	</div>
			        </div>
		        </div>
			</div>
		</div>
		<div id="preload" class="hidden">
			<h4 class="text-center"><i class="fa fa-spin fa-spinner"></i> Cargando...</h4>
		</div>
		<div id="encuestas" class="hidden">
			<div class="table-responsive">
				<table id="tbin" class="table table-bordered table-hover">
					<thead>
						<tr><th colspan="2" class="text-center">Encuesta de Entrada</th></tr>
						<tr>
							<th class="text-center">Pregunta</th>
							<th class="text-center">Respuesta</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<button id="delenc" class="btn btn-primary btn-lg pull-right hidden">Eliminar encuesta</button>
			</div>
			<br>
			<div class="table-responsive">
				<table id="tbout" class="table table-bordered table-hover">
					<thead>
						<tr><th colspan="2" class="text-center">Encuesta de Salida</th></tr>
						<tr>
							<th class="text-center">Pregunta</th>
							<th class="text-center">Respuesta</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#btncol").click(function(){
		$("#opciones").addClass('hidden');
		$("#xcolab").removeClass('hidden');
	});
	$("#btnsln").click(function(){
		loadsalon();
		$("#opciones").addClass('hidden');
		$("#xsalon").removeClass('hidden');
	});
	$(".volver").click(function(){
		$(".opc2").addClass('hidden');
		$("#opciones").removeClass('hidden');
	});
	var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $("#wrapper").css('background-color','white');
    $.fn.datepicker.dates['es'] = 
    {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Today",
        weekStart: 0
    };
    $('.fecha').datepicker({
        format: "yyyy-mm-dd",
        language:"es",
        today:"Today",
        option:"defaultDate"
    }).keydown(false); 
</script>
<script type="text/javascript">
    $('#colaborador').selectpicker({
        liveSearch: true,
        title:'Buscar y seleccionar colaborador...'
    });
    $('#colaborador').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });
    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        if(seek.length>3){
            $.ajax({
                url: 'covid/covidproccess.php',
                type: 'POST',
                data:{opc:'loadcol',txt:seek},
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                        }
                        $("#colaborador").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    $(document).on('click','#search',function(){
    	var fe = $("#fechac").val();
    	var co = $("#colaborador").val();
    	var ent, sal = '';
    	if(fe!=''){
    		if(co>0){
    			$("#preload").removeClass('hidden');
    			$("#encuestas").addClass('hidden');
    			$("#delenc").addClass('hidden');
    			$.ajax({
    				url:'covid/covidproccess.php',
	                type:'POST',
	                data:{opc:'search',co:co,fe:fe},
	                success: function(res){
	                	var dt=JSON.parse(res);
	                	if(dt.in[0].pre!=0){
	                		for(i in dt.in){
	                			ent+='<tr><td>'+dt.in[i].pre+'</td><td>'+dt.in[i].res+'</td></tr>';
	                		}
	                		$("#delenc").removeClass('hidden');
	                	}else{
	                		ent='<tr><td colspan="2">No hay registros</td></tr>';
	                	}
	                	if(dt.out[0].pre!=0){
	                		for(i in dt.out){
	                			sal+='<tr><td>'+dt.out[i].pre+'</td><td>'+dt.out[i].res+'</td></tr>';
	                		}
	                	}else{
	                		sal='<tr><td colspan="2">No hay registros</td></tr>';
	                	}
	                	$("#tbin tbody").html(ent);
	                	$("#tbout tbody").html(sal);
	                	$("#preload").addClass('hidden');
	                	$('#encuestas').removeClass('hidden');
	                },error:function(){

	                }
    			});
    		}else{

    			swal('Debe seleccionar un colaborador!','','warning');
    		}
    	}else{

			swal('Debe seleccionar una fecha!','','warning');
    	}
    });
    $('#colaborador').on('change',function(){

    	$("#encuestas").addClass('hidden');
    });
</script>
<script type="text/javascript">
	function loadsalon(){
		var sln='<option value="T">Todos los salones</option>';
		$.ajax({
			url: 'covid/covidproccess.php',
			type:'POST',
			data:{opc:'loadsln'},
			success:function(res){
				var dt=JSON.parse(res);
				for(i in dt){
					sln+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>'
				}
				$("#salon").html(sln);
			}
		})
	}
	$("#searchxs").click(function(){
		var sln=$("#salon").val();
		var feh=$("#fechas").val();
		var tb,ent,sal='';
		if(feh!=''){
			if(sln!=null){
				$("#preloadxs").removeClass('hidden');
				 $('#tbxsln').DataTable({
					"ajax": {
					"method": "POST",
					"url": "covid/covidproccess.php",
					"data": {opc:'sxsln', sln:sln, feh:feh},
					},
					"initComplete": function(settings, json) {
						$("#preloadxs").addClass('hidden');
						$("#tbxsalon").removeClass('hidden');
					},
					dom: 'Bfrtip',
					buttons: [ 
						{
						    extend:    'pdf',
						    text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
						    titleAttr: 'Exportar como PDF',
						    exportOptions: {
						        columns: [ 0,3,4 ]
						    },
						    title:'BeautySoft - Informe COVID colaboradores-'+feh,
						},
						{
						    extend:    'excel',
						    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
						    titleAttr: 'Exportar a Excel',
						    exportOptions: {
						        columns: [ 0,3,4]
						    },
						    title:'BeautySoft - Informe COVID colaboradores-'+feh,
						},
					],
					"columns":[
						{"data": "col"},
						{"render": function (data, type, JsonResultRow, meta) { 
							if(JsonResultRow.ent==0){
								ent='<i class="fa fa-check" style="color:green;"></i>';
							}else if(JsonResultRow.ent==1){
								ent='<i class="fa fa-warning text-danger"></i>';
							}else{
								ent='NR';
							}
						  return ent; 
						} 
						},  
						{"render": function (data, type, JsonResultRow, meta) { 
							if(JsonResultRow.sal==0){
								sal='<i class="fa fa-check" style="color:green;"></i>';
							}else if(JsonResultRow.sal==1){
								sal='<i class="fa fa-warning text-danger"></i>';
							}else{
								sal='NR';
							}
						  return sal; 
						} 
						}, 
						{"render": function (data, type, JsonResultRow, meta) { 
							if(JsonResultRow.ent==0){
								ent='Ok';
							}else if(JsonResultRow.ent==1){
								ent='Alerta';
							}else{
								ent='NR';
							}
						  return ent; 
						} 
						}, 
						{"render": function (data, type, JsonResultRow, meta) { 
							if(JsonResultRow.sal==0){
								sal='Ok';
							}else if(JsonResultRow.sal==1){
								sal='Alerta';
							}else{
								sal='NR';
							}
						  return sal; 
						} 
						},  
					],"language":{
						"lengthMenu": "Mostrar _MENU_ registros por página",
						"info": "Mostrando página _PAGE_ de _PAGES_",
						"infoEmpty": "",
						"infoFiltered": "(filtrada de _MAX_ registros)",
						"loadingRecords": "<h3><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere...</h3>",
						"processing":     "Procesando...",
						"search": "_INPUT_",
						"searchPlaceholder":"Buscar por nombre, cargo...",
						"zeroRecords":    "No se encontraron registros coincidentes",
						"paginate": {
						  "next":       "Siguiente",
						  "previous":   "Anterior"
						} 
					},  
					"columnDefs":[
						{className:"text-center","targets":[1]},
						{className:"text-center","targets":[2]},  
						{className:"hidden","targets":[3]},  
						{className:"hidden","targets":[4]},  
					],
					"order": [[0, "asc"]],
					"bDestroy": true,
					"pageLength":10,
			      });
			}else{
				swal('Debe seleccionar un salón!','','warning');
			}
		}else{
			swal('Debe seleccionar una fecha!','','warning');
		}
	});
	$("#salon").on('change',function(){
		$("#tbxsalon").addClass('hidden');
	});
	$("#fechas").on('change',function(){
		$("#tbxsalon").addClass('hidden');
	});
</script>
<script type="text/javascript">
	$("#delenc").click(function(){
		var col = $("#colaborador").val();
		var fe  = $("#fechac").val();
		swal({
		  title: "Borrar encuesta",
		  text: "Esta acción es irreversible. Proceda con cautela.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "SI, borrar",
		  cancelButtonText: "No, cancelar!",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  	if (isConfirm) {
			    $.ajax({
			    	url: 'covid/covidproccess.php',
					type:'POST',
					data:{opc:'delenc',col:col,fe:fe},
					success:function(res){
						if(res==1){
							swal("Borrada!", "La encuesta ha sido eliminada.", "success");
							$('#encuestas').addClass('hidden');
						}else if(res==2){
							swal("Alerta", "Solo pueden eliminarse encuestas de HOY", "warning");
						}else{
							swal("Ummm...", "Algo salió mal. Refresca la página e intentalo nuevamente.", "error");
						}
					}
			    })
		  	} 
		});
	});
</script>
