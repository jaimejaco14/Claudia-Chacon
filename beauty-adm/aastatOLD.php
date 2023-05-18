<?php  
include 'head.php';
include 'estadistica/librerias_css.php';
include 'estadistica/librerias_js.php';
?>
<style type="text/css">
	.dataTables_filter {
	   	float: left !important;
	}
	.dataTables_filter > label >input{
	   	border-color:#34495E!important;
	}
	.dt-buttons{
		float: left !important;
	}
	input[readonly]{
    	cursor:pointer;
    	background-color: white!important;
	}
	#tbrepadmi thead, tfoot{
		background-color: #34495E!important;
		color:white!important;
		font-size: 10px!important;
	}
	#tbrepadmi tbody, a{
		font-size: 9px!important;
	}
	#tbconsolcol thead, tfoot{
		background-color: #34495E!important;
		color:white!important;
		font-size: 10px!important;
	}
	#tbconsolcol tbody{
		font-size: 9px!important;
	}
	.pagination > li > a, 
	.pagination > li > span {
		color: #34495E!important;
		border-color:#34495E!important;
	}
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
		background-color: #34495E!important;
		border-color:#34495E!important;
		color:white!important;
	}
	.csstot{
		border-color: #34495E!important;
		border:0px!important;
	}
	.csstot2{
		border-left-color: #34495E!important;
	}
	.btnexp{
		border-color:#34495E!important;
	}
</style>
<div class="panel panel-default">
	<div class="panel-body">
		<h2 class="text-center">Reportes ADMI</h2>
		<div class="">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<legend>Parámetros</legend>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label>Salón(es)</label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button id="clrsln" class="btn-btn-default pull-right hidden" title="Borrar todos los salones"><i class="fa fa-trash"></i></button>
						</div>
					</div>
					<select id="slsln" multiple class="selsln form-control fcontrol"></select>
				</div>
				<div class="form-group">
					<label>Rango de Fechas</label>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<input id="fdes" type="text" class="fdes input-sm form-control fcontrol text-center" readonly placeholder="Desde">
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<input id="fhas" type="text" class="fhas input-sm form-control fcontrol text-center" readonly placeholder="Hasta">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Tipo de Documento</label>
					<select id="sltido" class="form-control fcontrol"></select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Línea</div>
					<select id="sllin" class="form-control fcontrol"></select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Grupo</div>
					<select id="slgru" class="form-control fcontrol"></select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Sub-Grupo</div>
					<select id="slsubg" class="form-control fcontrol"></select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Característica</div>
					<select id="slcara" class="form-control fcontrol"></select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Unidad</div>
					<select id="slund" class="form-control fcontrol">
						<option value="0">Seleccione und de medida</option>
						<option value="CM">Centímetro</option>
						<option value="GR">Gramo</option>
						<option value="ML">Mililitro</option>
						<option value="POR">Porción</option>
						<option value="UN">Unidad</option>
					</select>
				</div>
				<div class="input-group">
					<div class="input-group-addon">Reporte de: </div>
					<div class="radio">
						<label class="radio-inline">
						  <input type="radio" class="fcontrol" name="tirep" id="tirep1" value="c"> Cantidades
						</label>
						<label class="radio-inline">
						  <input type="radio" class="fcontrol" name="tirep" id="tirep2" value="v"> $ Valores
						</label>
					</div>
				</div>
				<div class="form-group">
					<button id="btngenerar" class="btn btn-primary btn-block">Generar</button>
				</div>
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<h3 id="loading1" class="hidden"><i class="fa fa-spin fa-spinner"></i> Cargando tabla...</h3>
				<div id="tbadmi" class="table-responsive">
					<table id="tbrepadmi" class="table table-bordered table-hover table-striped hidden">
						<thead class="info"></thead><tbody></tbody><tfoot><tr></tr></tfoot> 
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- MODAL cantidad por COLABORADORES/SALÓN -->
<div class="modal fade" id="modal-conscol">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header titleconscol">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="cctrp">
				<input type="hidden" id="ccdes">
				<input type="hidden" id="cchas">
				<input type="hidden" id="cctdc">
				<input type="hidden" id="cclin">
				<input type="hidden" id="ccgru">
				<input type="hidden" id="ccsgr">
				<input type="hidden" id="cccar">
				<input type="hidden" id="ccund">
				<table id="tbconsolcol" class="table table-bordered table-hover">
					<thead><tr><th>Colaborador</th><th>Cantidad</th></tr></thead>
					<tbody></tbody><tfoot class="hidden"><tr><th>TOTAL</th><th></th></tr></tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		loadsln();
		$(".fdes").datepicker({
	        format:'yyyy-mm-dd',
	        autoclose: true,
	        startView: 1
		});
		$(".fhas").datepicker({
	        format:'yyyy-mm-dd',
	        autoclose: true,
	        startView: 1
	    });
	    loadtido();
	    loadlinea();
	    loadgru();
	    loadsubgru();
	    loadcara();
	});
	$(".selsln").change(function(){
      var item=$(this).val();
      var cls=$(".selsln").find(':selected').data('sw');
      $("#clrsln").removeClass('hidden');
      if(cls=='sln'){
        $(".opttpo").addClass('hidden');
      }else{
        $(".optsln").addClass('hidden');
      }
      if(item==null){
        $(".optcls").removeClass('hidden');
        $("#clrsln").addClass('hidden');
      }
    });
    $("#clrsln").click(function(){
    	$('.selsln').val(null).trigger('change');
    });
    function loadtido(){
    	$.ajax({
    		url:'estadistica/process_admi.php',
	        type:'POST',
	        data:{opc:'loadtido'},
	        success:function(res){
          		var dt=JSON.parse(res);
          		var opcs = "<option value='0'>Seleccione Tipo documento</option>";
          		for(var i=0 in dt){
					opcs += "<option value='"+dt[i].cod+"'>"+dt[i].nom+"</option>";
          		}
          		$("#sltido").html(opcs);
          	}
    	});
    }
	function loadsln(){
      $.ajax({
        url:'estadistica/process_admi.php',
        type:'POST',
        data:{opc:'listsln'},
        success:function(res){
          var dt=JSON.parse(res);
          var i=0;
          var opc='<optgroup class="opttpo optcls" label="Por tipo de salón">';
          for(var i in dt.tipo){
            opc+='<option class="slntpo opttpo optcls" data-sw="tpo" data-admi="'+dt.tipo[i].cad+'" value="t-'+dt.tipo[i].cad+'">'+dt.tipo[i].nom+'</option>';
          }
          opc+='</optgroup><optgroup class="optsln optcls" label="Por Salón">';
          for(var i in dt.sln){
            opc+='<option class="slnnor optsln optcls" data-sw="sln" data-admi="'+dt.sln[i].cad+'" value="s-'+dt.sln[i].cad+'">'+dt.sln[i].nom+'</option>';
          }
          opc+='</optgroup>';
          $(".selsln").html(opc).select2({
            placeholder:"Seleccione salón (Omitir para todos)",
            closeOnSelect: false,
            allowClear: true
          });
        }
      })
    }
    function loadlinea(){
    	$.ajax({
    		url:'estadistica/process_admi.php',
	        type:'POST',
	        data:{opc:'loadlinea'},
	        success:function(res){
          		var dt=JSON.parse(res);
          		var opcs = "<option value='0'>Seleccione línea</option>";
          		for(var i=0 in dt){
					opcs += "<option value='"+dt[i].cod+"'>"+dt[i].nom+"</option>";
          		}
          		$("#sllin").html(opcs);
          	}
    	});
    }
    function loadgru(){
    	$.ajax({
    		url:'estadistica/process_admi.php',
	        type:'POST',
	        data:{opc:'loadgru'},
	        success:function(res){
          		var dt=JSON.parse(res);
          		var opcs = "<option value='0'>Seleccione Grupo...</option>";
          		for(var i=0 in dt){
					opcs += "<option value='"+dt[i].cod+"'>"+dt[i].nom+"</option>";
          		}
          		$("#slgru").html(opcs);
          	}
    	});
    }
    function loadsubgru(){
    	$.ajax({
    		url:'estadistica/process_admi.php',
	        type:'POST',
	        data:{opc:'loadsubgru'},
	        success:function(res){
          		var dt=JSON.parse(res);
          		var opcs = "<option value='0'>Seleccione Sub-Grupo...</option>";
          		for(var i=0 in dt){
					opcs += "<option value='"+dt[i].cod+"'>"+dt[i].nom+"</option>";
          		}
          		$("#slsubg").html(opcs);
          	}
    	});
    }
    function loadcara(){
    	$.ajax({
    		url:'estadistica/process_admi.php',
	        type:'POST',
	        data:{opc:'loadcara'},
	        success:function(res){
          		var dt=JSON.parse(res);
          		var opcs = "<option value='0'>Seleccione Característica...</option>";
          		for(var i=0 in dt){
					opcs += "<option value='"+dt[i].cod+"'>"+dt[i].nom+"</option>";
          		}
          		$("#slcara").html(opcs);
          	}
    	});
    }
</script>
<script type="text/javascript">
    $("#btngenerar").click(function(){
    	var btn 	= $(this);
    	var ctr 	= $(".fcontrol");
    	var sln		= $("#slsln").val();
    	var fdes	= $("#fdes").val();
    	var fhas	= $("#fhas").val();
    	//****************************//
    	var tdc		= $("#sltido").val();
    	var lin		= $("#sllin").val();
    	var gru		= $("#slgru").val();
    	var subg	= $("#slsubg").val();
    	var cara	= $("#slcara").val();
    	var ume 	= $("#slund").val();
    	//****************************//
    	var tlin	= $("#sllin :selected").text();
    	var tgru	= $("#slgru :selected").text();
    	var tsubg	= $("#slsubg :selected").text();
    	var tcara	= $("#slcara :selected").text();
    	//****************************//
    	var trp = $('input[name="tirep"]:checked').val();
    	if(tdc!=0){
	    	if((fhas!='') && (fdes!='')){
		    	if(fhas >= fdes){
		    		if((lin!=0)||(gru!=0)||(subg!=0)||(cara!=0)){
		    			if(trp!=null){
		    				$("#cctrp").val(trp);
							$("#ccdes").val(fdes);
							$("#cchas").val(fhas);
							$("#cctdc").val(tdc);
							$("#cclin").val(lin);
							$("#ccgru").val(gru);
							$("#ccsgr").val(subg);
							$("#cccar").val(cara);
							$("#ccund").val(ume);
			    			$("#tbadmi").empty();
			    			$('#tbrepadmi').remove();
			    			$("#tbadmi").append('<table id="tbrepadmi" class="table table-bordered table-hover hidden"><thead></thead><tbody></tbody><tfoot><tr></tr></tfoot></table>');

					    	$("#loading1").removeClass('hidden');
					    	btn.attr('disabled',true).html('Generando...');
					    	ctr.prop('disabled',true);
					    	var colusalon=[];
					    	var codsalon=[];
					    	colusalon.push({data:'ref',title:'REFERENCIA'});
					    	colusalon.push({data:'nom',title:'DESCRIPCIÓN'});
					    	colusalon.push({data:'und',title:'UND'});
					    	$("#tbrepadmi tfoot tr").append('<th class="csstot"></th><th class="csstot"></th><th class=" csstot2 text-right">TOTAL</th>');
					    	var sw='';
					    	var allsln='';
					    	if(sln==null){
								$("#slsln .slnnor").each(function(){
									var nom=$(this).val();
									var txt=$(this).text();
									var cod=$(this).val().split('-')[1];
									colusalon.push({data:'s'+cod, title:txt, render: function (data, type, JsonResultRow, meta) { 
																			var res=JsonResultRow['s'+cod];
																			var srv=JsonResultRow.nom;
																			var ref=JsonResultRow.ref;
              																return '<a class="btn btn-default btn-xs btn-block detail text-primary" data-codsln="'+cod+'" data-txtsln="'+txt+'" data-ref="'+ref+'" data-srv="'+srv+'" title="Ver detalles">'+
              																res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</a>'; 
             																}
             															});
									codsalon.push(cod);
									$("#tbrepadmi tfoot tr").append('<th></th>');
								});
								var csln=codsalon.toString();
								allsln=$('#slsln .slnnor').map(function() { return this.value; }).get().join().replace(/s|-/g, "");
					    	}else{
					    		$("#slsln :selected").each(function(){
									var nom=$(this).val();
									var txt=$(this).text();
									sw=$(this).val().split('-')[0];
									if(sw=='s'){
										var cod=$(this).val().split('-')[1];
										colusalon.push({data:'s'+cod,title:txt, render: function (data, type, JsonResultRow, meta) { 
																			var res=JsonResultRow['s'+cod];
																			var srv=JsonResultRow.nom;
																			var ref=JsonResultRow.ref;
              																return '<a class="btn btn-default btn-xs btn-block detail text-primary" data-codsln="'+cod+'" data-txtsln="'+txt+'" data-ref="'+ref+'" data-srv="'+srv+'" title="Ver detalles">'+
              																res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</a>'; 
             																}
             															});
										codsalon.push(cod);
									}else if(sw=='t'){
										var cod=$(this).val();
										colusalon.push({data:cod.replace(/,|-/g, ""), title:txt, render: function (data, type, JsonResultRow, meta) { 
																			var res=JsonResultRow[cod.replace(/,|-/g, "")];
																			var srv=JsonResultRow.nom;
																			var ref=JsonResultRow.ref;
              																return '<a class="btn btn-default btn-xs btn-block detail text-primary" data-codsln="'+cod.replace(/t|-/g, "")+'" data-txtsln="'+txt+'" data-ref="'+ref+'" data-srv="'+srv+'" title="Ver detalles">'+
              																res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</a>'; 
             																}
																		});
										codsalon.push({cod});
									}
									allsln=sln.toString().replace(/t|s|-/g, "");
									$("#tbrepadmi tfoot tr").append('<th></th>');
								});
								if(sw=='s'){
									var csln=codsalon.toString();
								}else if(sw=='t'){
									var csln=codsalon;
								}
					    	}
					    	colusalon.push({data:'total',title:'TOTAL',render: function (data, type, JsonResultRow, meta) { 
					    													var res=JsonResultRow['total'];
					    													var srv=JsonResultRow.nom;
					    													var ref=JsonResultRow.ref;
              																return '<a class="btn btn-default btn-xs btn-block detail text-primary" data-codsln="'+allsln+'" data-txtsln="Consolidado de estos salones" data-ref="'+ref+'" data-srv="'+srv+'" title="Ver detalles">'+
              																res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</a>'; 
             																}
             															});
					    	$("#tbrepadmi tfoot tr").append('<th></th>');
					    	var listado = $('#tbrepadmi').DataTable({
					    		colReorder: {
					    			fixedColumnsLeft: 3,
					    			fixedColumnsRight: 1
					    		},
						        "ajax": {
						        "method": "POST",
						        "url": "estadistica/process_admi.php",
						        "data":{opc:'generar',sln:csln,fdes:fdes,fhas:fhas,lin:lin,gru:gru,subg:subg,cara:cara,sw:sw,tdc:tdc,trp:trp,ume:ume},
						        },
						        dom: 'Bfrtip',
								buttons: [ 
								  {
								    extend:    'excel',
								    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
								    className: 'btn btn-default btn-sm btnexp',
								    titleAttr: 'Exportar a Excel',
								    title:'Reporte ADMI del '+fdes+' al '+fhas,
								    messageTop:''+tdc+(lin!=0?' - '+tlin:'')+(gru!=0?' - '+tgru:'')+(subg!=0?' - '+tsubg:'')+(cara!=0?' - '+tcara:'')+(trp=='c'?' - Cantidades':' - $ Valores'),
								    footer: true,
								    exportOptions: {
						                columns: ':visible',
						                format: {
						                    body: function(data, row, column, node) {
						                        if(data.substring(0,1)=='<'){
						                        	ret = parseFloat(data.split('>')[1].split('<')[0].replace(/,/g, ''));
						                        }else{
						                        	ret = data.replace(/,/g, '');
						                        }
						                        return ret;
						                    },
						                    footer:function(data, row, column, node){
						                    	if(column>=3){
						                        	ret = parseFloat(data.substring(0,1)=='<'?
						                        		data.match(/[0-9]+/g):
						                        		data.replace(/\$|,/g, ''));
						                        }else{
						                        	ret = data.replace(/\$|,/g, '');
						                        }
						                        return ret;
						                    }
						                }
						            }
								  }
								],
						        "columns":colusalon,
						        "language":{
						            "lengthMenu": "Mostrar _MENU_ registros por página",
						            "info": "Página _PAGE_ de _PAGES_",
						            "infoEmpty": "",
						            "infoFiltered": "(filtrada de _MAX_ registros)",
						            "loadingRecords": "<h4><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere.\n Esta operación puede tardar varios minutos, sea paciente...</h4>",
						            "processing":     "Procesando...",
						            "search": "_INPUT_",
						            "searchPlaceholder":"Buscar...",
						            "zeroRecords":    "La búsqueda no arrojó ningun resultado",
						            "paginate": {
						              "next":       "Siguiente",
						              "previous":   "Anterior"
						            } 
								},  
								"columnDefs":[
									{className:"text-left aaa","targets":[0,1]},
									{className:"text-center aaa","targets":[2]},
									{className:"text-center sum","targets":["_all"]},
								],  
								"order": [[1, "asc"]],
								"bDestroy": true,
								"pageLength":8,
								"initComplete": function(settings, json) {
								    btn.removeAttr('disabled').html('Generar');
								    ctr.removeAttr('disabled');
								    $(".aaa").removeClass('sum text-center');
								    this.api().columns('.sum').every(function () {
							            var column = this;
							            var sum = column.data().reduce(function (a, b) {
						                    var x = parseFloat(a) || 0;
									        var y = parseFloat(b) || 0;
									        return x + y;
						                });
							            $(column.footer()).html((trp=='v'?'$':'')+' '+sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
							        });
								},
						    });
						    $("#loading1").addClass('hidden');
						    $("#tbrepadmi").removeClass('hidden');
						}else{
							swal('Seleccione Tipo de Reporte','','warning');
						}
					}else{
						swal('Faltan datos','Debe elegir al menos una linea, grupo, subgrupo o característica a buscar.','warning');
					}
		    	}else{
		    		swal("Fechas erradas!","La fecha 'Hasta' debe ser mayor que la fecha 'Desde'","warning");
		    	}
		    }else{
		    	swal('Elija rango de fechas','','warning');
		    }
		}else{
			swal('Elija Tipo de Documento','','warning');
		}
    });
	$(document).on('click','.detail',function(e){
		e.preventDefault();
		var num=$(this).html();
		if(num!='0'){
			var txtsln	= $(this).data('txtsln');
			var srv		= $(this).data('srv');
			//***************************************/
			var ccref	= $(this).data('ref');
			var ccsln	= $(this).data('codsln');
			var ccdes	= $("#ccdes").val();
			var cchas	= $("#cchas").val();
			var cclin	= $("#cclin").val();
			var ccgru	= $("#ccgru").val();
			var ccsgr	= $("#ccsgr").val();
			var cccar	= $("#cccar").val();
			var cctdc	= $("#cctdc").val();
			var cctrp	= $("#cctrp").val();
			var ccund	= $("#ccund").val();
			$(".titleconscol").html('<b><i class="fa fa-info-circle text-info"></i> Consolidado por colaborador.<br>'+srv+'<br>Salón: '+txtsln+'</b>');
			if(cctrp=='c'){
			}else if(cctrp=='v'){
			}
			$("#modal-conscol").modal('show');
			$("#tbconsolcol").DataTable({
				"ajax": {
			        "method": "POST",
			        "url": "estadistica/process_admi.php",
			        "data":{opc:'consolcol',ccref:ccref,ccsln:ccsln,ccdes:ccdes,cchas:cchas,cclin:cclin,ccgru:ccgru,ccsgr:ccsgr,cccar:cccar,cctdc:cctdc,cctrp:cctrp,ccund:ccund},
		        },
		        dom: 'Bfrtip',
		        buttons: [ 
					{
					extend:    'excel',
					messageTop:'Consolidado: '+srv+'- Salon:'+txtsln+(cctrp=='c'?' - por Cantidades':' - por $ Valores'),
					text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
					className: 'btn btn-default btn-sm btnexp',
					titleAttr: 'Exportar a Excel',
					title:'Reporte ADMI (Consolidado por colaborador) del '+ccdes+' al '+cchas,
					footer: true,
						exportOptions: {
						    columns: ':visible',
						    format: {
						        body: function(data, row, column, node) {
						            return  data.replace(/\$|,/g, '');
						        },
						        footer:function(data, row, column, node){
						        	return  data.replace(/\$|,/g, '');
						        }
						    }
						}
					}
				],
		        "columns":[
		        	{"data": "clbnom"},
	        		{"data": "cant",render:$.fn.dataTable.render.number(',', '.', 0, cctrp=='v'?'$ ':'')},
		        ],
		        "language":{
		            "lengthMenu": "Mostrar _MENU_ registros por página",
		            "info": "Página _PAGE_ de _PAGES_",
		            "infoEmpty": "",
		            "infoFiltered": "(filtrada de _MAX_ registros)",
		            "loadingRecords": "<h4><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere.\n Esta operación puede tardar varios minutos, sea paciente...</h4>",
		            "processing":     "Procesando...",
		            "search": "_INPUT_",
		            "searchPlaceholder":"Buscar...",
		            "zeroRecords":    "La búsqueda no arrojó ningun resultado",
		            "paginate": {
		              "next":       "Siguiente",
		              "previous":   "Anterior"
		            } 
				},  
				"columnDefs":[
					{className:"text-left","targets":[0]},
					{className:"text-center sum2","targets":[1]},
				],  
				"order": [[1, "desc"]],
				"bDestroy": true,
				"pageLength":8,
				"initComplete": function(settings, json) {
				    $("#tbconsolcol tfoot").removeClass('hidden');
				    this.api().columns('.sum2').every(function () {
			            var column = this;
			            var sum = column.data().reduce(function (a, b) {
		                    var x = parseFloat(a) || 0;
					        var y = parseFloat(b) || 0;
					        return x + y;
		                });
			            $(column.footer()).html((cctrp=='v'?'$ ':'')+sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			        });
				},
			});
		}else{
			swal('No hay datos para mostrar','','warning');
		}
	});
	$('#modal-conscol').on('hide.bs.modal', function () {
		$("#tbconsolcol tfoot").addClass('hidden');
	});
</script>
