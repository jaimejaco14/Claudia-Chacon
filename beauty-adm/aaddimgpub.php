<?php 
include 'head.php';
include "librerias_js.php";
?>
<style>
	.codimg{
		display:none;
	}
	.bold{
		font-weight: bold;
	}
	.toupload{
		max-width:50%;
	}
	.fondo{
		background-color: white;
	}
	.table{
		width:100%!important;
	}
</style>
<div class="content">
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#Imagenes" aria-controls="tab" role="tab" data-toggle="tab"><b>Catálogo de imágenes</b></a>
			</li>
			<li role="presentation">
				<a href="#Salones" aria-controls="tab" role="tab" data-toggle="tab"><b>Salones</b></a>
			</li>
			<li role="presentation">
				<a href="#videos" aria-controls="tab" role="tab" data-toggle="tab"><b>Video Eventos</b></a>
			</li>
			<li role="presentation">
				<a href="#opciones" aria-controls="tab" role="tab" data-toggle="tab"><b>Opciones</b></a>
			</li>
		</ul>
	
		<!-- Tab panes -->
		<div class="tab-content fondo">
			<div role="tabpanel" class="tab-pane active" id="Imagenes">
				<div class="content">
					<div class="row">
						<a class="btn btn-info pull-right" data-toggle="modal" href='#modal-addimg' id="addimg"><i class="fa fa-plus"></i> Subir imagen</a>
					</div>
					<div class="row">
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="tblimagenes">
								<thead>
									<tr class="info">
										<th class="codimg" style="display:none;">Codigo</th>
										<th>Nombre del archivo</th>
										<th>Descripción</th>
										<th class="text-center">Imagen</th>
										<th class="text-center">Estado</th>
										<th class="text-center">Opciones</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="Salones">
				<div class="content">
					<table id="tblsalon" class="table table-bordered table-hover" style="width:100%;">
						<thead>
							<tr class="info">
								<th>Nombre Salón</th>
								<th class="text-center">No. imágenes</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="videos">
				<div class="content">
					<a class="btn btn-info newevt" data-toggle="modal" href='#modal-newevt'><i class="fa fa-plus"></i> Crear nuevo evento</a><br><br>
					<div class="table-responsive">
						<table id="tbleventos" class="table table-bordered table-hover" style="width:100%;">
							<thead>
								<tr class="info">
									<th class="text-center">Nombre</th>
									<th class="text-center">Descripción</th>
									<th class="text-center">Link</th>
									<th class="text-center">Hora Inicio</th>
									<th class="text-center">Hora Fin</th>
									<th class="text-center">Default</th>
									<th class="text-center">Estado</th>
									<th class="text-center">Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="opciones">
				<div class="content">
					<div class="row">
						<div class="form-group">
							<button class="btn btn-warning btn-lg reloadscreen"><i class="fa fa-refresh"></i> Recargar imágenes</button>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<button class="btn btn-danger btn-lg fullyreloadscreen"><i class="fa fa-refresh"></i> Recargar navegador</button>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<button class="btn btn-danger btn-lg deleteold"><i class="fa fa-eraser"></i> Eliminar asignaciones caducadas</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal vista previa de imagen -->
<div class="modal fade" id="modal-vpimg">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div id="modalimg"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Asignar Imagen a Salon -->
<div class="modal fade" id="modal-asignar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-university"></i> Asignar imagen a Salón</h4>
			</div>
			<div class="modal-body">
				<div class='thumbnail'>
					<img class="img-responsive" style="max-width: 50%;" id="imgmodal">
				</div>
				<div class="row">
					<input type="hidden" id="codimgmd" class="formodalassign">
					<select id="slsalon" multiple class="slsalon form-control"></select>
				</div><br>
				<div class="row">
					<div class="col-md-4">
						<label>Vigencia Desde/Hasta</label>
					</div>
					<div class="col-md-4">
						<input id="asigndesde" class="form-control formodalassign" type="date" data-date-format="YYYY MM DD">
					</div>
					<div class="col-md-4">
						<input id="asignhasta" class="form-control formodalassign" type="date" data-date-format="YYYY MM DD">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default cancel" data-dismiss="modal">Cerrar</button>
				<button id="sbmtimgsln"  data-loading-text="Asignando imagen..." type="button" class="btn btn-primary">Asignar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Subir imagen -->
<div class="modal fade" id="modal-addimg">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Subir Nueva imagen</h4>
			</div>
			<form id="form-addimg" enctype="multipart/form-data">
				<input type="hidden" name="opc" value="uplimg">
				<div class="modal-body">
					<div class="row">
						<div id="image-holder" class="thumbnail col-md-4 col-md-push-4"></div>
					</div>
					<div class="row">
							<div class="form-group">
								<label for="fileUpload">Archivo de imagen</label>
								<div id="inputcontrol">
									<input id="fileUpload" name="fileUpload" class="btn btn-primary btn-block" type="file" title="Click para buscar imagen..." data-filename-placement="inside"/>
								</div><br />
							</div>
							<div class="form-group">
								<label for="descripimg">Descripción de la imagen</label>
								<textarea id="descripimg" name="descripimg" class="form-control" style="resize: none;" placeholder="Describa brevemente la imagen, si la imagen tiene un texto, escríbalo aquí."  oninvalid="this.setCustomValidity('Debe describir la imagen. Esto le ayudará a ubicarla mas facilmente.')" oninput="this.setCustomValidity('')"  required ></textarea>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancelar</button>
					<button id="uploadimg" data-loading-text="Subiendo imagen..." disabled type="submit" class="btn btn-primary">Subir imagen</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal imagen x salon -->
<div class="modal fade" id="modal-imgsalon">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> Opciones de imagen salón <b class="modalslnnom"></b></h4>
				<input type="hidden" id="codsalon-modalimgxsln">
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="imgactual">
						<br>
						<table id="tbimgsalon" class="table table-bordered table-hover" style="width: 100%;">
							<thead>
								<tr class="info">
									<th>Nombre de archivo</th>
									<th class="text-center">Descripción</th>
									<th class="text-center">Desde</th>
									<th class="text-center">Hasta</th>
									<th class="text-center">Estado</th>
									<th class="text-center">Opciones</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- modal asignacion de imagenes individual -->
<div class="modal fade" id="modal-fechaassign">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-calendar"></i> Vigencia de la imagen</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="md-imgcod">
				<input type="hidden" id="md-slncod">
				<div class="form-group">
					<label for="imgdesde">Desde</label>
					<input class="form-control" id="imgdesde" type="date">
				</div>
				<div class="form-group">
					<label for="imghasta">Hasta</label>
					<input class="form-control" id="imghasta" type="date">
					<small>Omitir si la vigencia es Indefinida</small>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button id="assign2" class="btn btn-primary" >Asignar</button>
			</div>
		</div>
	</div>
</div>

<!-- modal reset imagenes salon -->
<div class="modal fade" id="modal-resetimg">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-refresh"></i> Recargar imágenes de pantalla</h4>
			</div>
			<div class="modal-body">
				<div class="content">
					Esta acción recargará únicamente el contenido de imágenes presentes en la pantalla sin afectar el sube y baja, ni recargar completamente la página.
				</div>
				<div class="row">
					<select id="slsalon2" multiple class="slsalon form-control"></select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="rldimg btn btn-warning">Recargar Imágenes</button>
			</div>
		</div>
	</div>
</div>

<!-- modal reset navegador salon -->
<div class="modal fade" id="modal-resetnav">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-refresh"></i> Recargar Navegador de Pantallas</h4>
			</div>
			<div class="modal-body">
				<div class="content">
					Esta acción recargará completamente la pantalla, todo su contenido será cargado desde cero.
				</div>
				<div class="row">
					<select id="slsalon3" multiple class="slsalon form-control"></select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger rldbrowser">Recargar Navegador</button>
			</div>
		</div>
	</div>
</div>

<!-- modal eliminar asignaciones de imagenes no vigentes -->
<div class="modal fade" id="modal-deleteold">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-eraser"></i> Eliminar asignaciónes caducadas</h4>
			</div>
			<div class="modal-body">
				<div class="content">
					Esta acción eliminará la asignacion de imágenes a salones <b>si la fecha de vigencia ya ha caducado.</b> Esta acción NO borra ni inactiva ninguna imagen, solo elimina el vinculo entre imagen y salon. <b>Esta acción es irreversible!</b>
				</div>
				<div class="row">
					<select id="slsalon4" multiple class="slsalon form-control"></select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger deloldimg">Eliminar asignaciones caducadas</button>
			</div>
		</div>
	</div>
</div>

<!-- modal nuevo evento de video youtube -->
<div class="modal fade" id="modal-newevt">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Datos de evento</h4>
			</div>
			<form id="formnewevt" action="" autocomplete="off">
				<div class="modal-body">
						<div class="form-group">
							<label for="nameevt">Nombre</label>
							<input class="form-control frmevt" type="text" id="nameevt" name="nameevt" required>
						</div>
						<div class="form-group">
							<label for="desevt">Descripción</label>
							<input class="form-control frmevt" type="text" id="desevt" name="desevt" required>
						</div>
						<div class="form-group">
							<label for="tipoevt">Tipo</label>
							<select class="form-control" id="tipoevt" required>
								<option value="" selected disabled>Seleccione una opción</option>
								<option value="YT">YouTube</option>
								<option value="IF">Iframe</option>
							</select>
						</div>
						<div class="divlink form-group hidden">
							<label for="linkevt">Link</label>
							<input class="form-control" type="text" id="linkevt" name="linkevt" required>
						</div>
						
						<div class="form-group">
							<label for="hraevt">Hora</label>
							<div class="row">
								<div class="col-md-6">
									<input class="form-control frmevt text-center horapk" type="text" id="hini" name="hini" placeholder="Desde" required readonly>
								</div>
								<div class="col-md-6">
									<input class="form-control frmevt text-center horapk" type="text" id="hfin" name="hfin" placeholder="Hasta" required readonly>
								</div>						
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="dftevt">Set as Default</label>
							<input class="form-control pull-left" type="checkbox" id="dftevt">
						</div> -->
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" id="saveevt"class="btn btn-primary" data-evtcod="">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- <script type="text/javascript" src="http://gregpike.net/demos/bootstrap-file-input/bootstrap.file-input.js"></script> -->
<script type="text/javascript" src="https://cdn.bootcss.com/bootstrap-fileinput/5.0.4/js/fileinput.js"></script>

<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" > </script>
<script type="text/javascript">
	$(document).ready(function() {
		loadimages();
		loadsalon();
		loadsln();
		loadevt();
		document.getElementById('imgdesde').valueAsDate = new Date();
		document.getElementById('asigndesde').valueAsDate = new Date();
		//$("#fileUpload").bootstrapFileInput();
	});	
	//carga de DataTable
	var loadimages=function(){
	  	var listado = $('#tblimagenes').DataTable({
	      "ajax": {
	      "method": "POST",
	      "url": "php/pantalla/process.php",
	      "data": {opc: "listimg"},
	      },
	      "columns":[
	        {"data": "imgcodigo"},
	        {"data": "imgnomarchivo"},
	        {"data": "imgdescripcion"},
	        {"render": function (data, type, JsonResultRow, meta) { 
		          return '<center><img class="thumbnail" style="width:50px; cursor:pointer;" title="click para ver imagen" src="../externo/screen/contenidos/'+JsonResultRow.imgnomarchivo+'"></center>'; 
		         } 
		    },  
		    {"render": function (data, type, JsonResultRow, meta) { 
			    	if(JsonResultRow.imgestado==1){
			    			return "Activo";
				    	}else{
				    		return "Inactivo";
			    		}
			        } 
		    },        
		    {"render": function (data, type, JsonResultRow, meta) { 
				    	if(JsonResultRow.imgestado==1){
				    		return "<button class='btn btn-info asignar' title='Asignar a salón' data-cod='"+JsonResultRow.imgcodigo+"'><i class='fa fa-university'></i></button><button type='button' data-cod='"+JsonResultRow.imgcodigo+"' style='margin-left:0px; border-radius: 0px' class='btn btn-danger btnEliminar' title='Desactivar imagen'><i class='fa fa-trash'></i></button>";
				    	}else{
				    		return "<button class='btn btn-info asignar disabled' title='Asignar a salón' data-cod='"+JsonResultRow.imgcodigo+"'><i class='fa fa-university'></i></button><button type='button' data-cod='"+JsonResultRow.imgcodigo+"' style='margin-left:0px; border-radius: 0px' class='btn btn-warning btnActivar' title='Reactivar imagen'><i class='fa fa-refresh'></i></button>";
			    		}
		        	} 
		    },  
	      ],
	      "language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "No hay registros disponibles",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "Cargando...",
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
	              {className:"codimg","targets":0},
	              { "width": "10%", "targets": 0 },
	              { "width": "20%", "targets": 3 },
	              {className:"text-center bold estado","targets": 4 },
	              {className:"text-center","targets":5}
	         ],
	             
	         "order": [[4, "asc"]],
	         "bDestroy": true,
	         "pageLength": 5,
  		});
	}
	//vista Previa de la Imgagen
	$(document).on('click', '.thumbnail', function(){
		var src=$(this).attr('src');
		$("#modalimg").html('<img src="'+src+'" class="img-responsive">');
		$("#modal-vpimg").modal('show');
	})
	//inactivar imagen
	$(document).on('click','.btnEliminar', function() {
		var btn=$(this);
		var cod=$(this).data('cod');
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'delimg',cod:cod},
			success:function(res){
				if(res==1){
					btn.removeClass('btn-danger').addClass('btn-warning');
					btn.removeClass('btnEliminar').addClass('btnActivar');
					btn.children().removeClass('fa-trash').addClass('fa-refresh');
					btn.removeAttr('title').attr('title', 'Reactivar imagen');
					btn.parent().parent().find('.estado').html('Inactivo');
					btn.parent().find('.asignar').addClass('disabled');
					reloadallscreen();
				}else{
					swal('Boom!','Hubo un error, refresque la página e intentelo nuevamente.','error');
				}
			},
			error:function(e){
				swal({
				    title: "Oh oh!",
				    text: "Ha ocurrido un error inesperado al enviar sus datos, pulse ok para recargar la página e intentelo nuevamente.",
				    type: "error",
				    confirmButtonText: 'Ok',
				    closeOnConfirm: false
				 },
				 function(isConfirm){
				    if (isConfirm){
			     		location.reload();
				    } 
				});
			}
		});
	});
	//reactivar Imagen
	$(document).on('click','.btnActivar', function() {
		var btn=$(this);
		var cod=$(this).data('cod');
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'react',cod:cod},
			success:function(res){
				if(res==1){
					btn.removeClass('btn-warning').addClass('btn-danger');
					btn.removeClass('btnActivar').addClass('btnEliminar');
					btn.children().removeClass('fa-refresh').addClass('fa-trash');
					btn.removeAttr('title').attr('title', 'Desactivar imagen');
					btn.parent().parent().find('.estado').html('Activo');
					btn.parent().find('.asignar').removeClass('disabled');
				}else{
					swal('Boom!','Hubo un error, refresque la página e intentelo nuevamente.','error');
				}
			},
			error:function(e){
				swal({
				    title: "Oh oh!",
				    text: "Ha ocurrido un error inesperado al enviar sus datos, pulse ok para recargar la página e intentelo nuevamente.",
				    type: "error",
				    confirmButtonText: 'Ok',
				    closeOnConfirm: false
				 },
				 function(isConfirm){
				    if (isConfirm){
			     		location.reload();
				    } 
				});
			}
		});
	});
	//asignar imagen a salon
	$(document).on('click','.asignar',function(){
		var btn=$(this);
		var cod=btn.data('cod');
		$("#codimgmd").val(cod);
		var ruta=btn.parent().parent().find('.thumbnail').attr('src');
		$("#imgmodal").removeAttr('src').attr('src',ruta);
		$("#modal-asignar").modal('show');
	})
	//carga el select de salones de modal asignar imagen a salon
	function loadsalon(){
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'loadsalon'},
			success:function(res){
				var json=JSON.parse(res);
				var opcs = "";
				for(var i in json){
                    opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $(".slsalon").html(opcs).select2({
                	placeholder:'Elija salón(es) - omitir para todos',
                });
			}
		})
	}
	//submit de formulario asignar imagen a salones
	$("#sbmtimgsln").click(function(){
		var desde=$("#asigndesde").val();
		var hasta=$("#asignhasta").val();
		var sln=$("#slsalon").val();
		var img=$("#codimgmd").val();
		if(desde!=''){
			if(hasta==""){
				hasta='2099-12-31';
			}
			$.ajax({
				url:'php/pantalla/process.php',
				type:'POST',
				data:{opc:'assign',sln:sln,desde:desde,hasta:hasta,img:img},
				beforeSend: function(){
                $('#sbmtimgsln').button('loading');
                $('.cancel').attr("disabled","disabled");
            },
				success:function(res){
					if(res==1){
						loadsln();
						swal('Asignada!','La imagen ha sido asignada a los salones seleccionados','success');
					}else{
						swal('Oops!','Ha ocurrido un error inesperado al asignar la imagen. Refresque la página e intentelo nuevamente','error');
					}
					$("#modal-asignar").modal('toggle');
					$('.cancel').removeAttr('disabled');
		        	$('#sbmtimgsln').button('reset');
				}
			})
		}else{
			swal('Faltan datos!','','warning');
		}
	})
	//al cerrar modal asignar, se resetean los controles
	$("#modal-asignar").on("hidden.bs.modal", function () {
		$(".formodalassign").val('');
		$("#slsalon").select2("val", "");
	});
	//precarga de imagen y preview de archivo a subir
	$("#fileUpload").on('change', function () {

        if (typeof (FileReader) != "undefined") {

            var image_holder = $("#image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "img-responsive toupload"
                }).appendTo(image_holder);
                $("#uploadimg").removeAttr('disabled');
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });
    //catch evento inesperado al hacer click en la imagen (bug del plugin)
    $("#image-holder").click(function(e){
    	return false;
    })
    //limpia los controles al cerrar modal
    $("#modal-addimg").on("hidden.bs.modal", function (){
    	$("#image-holder").empty();
    	$("#descripimg").val('');
    	$("#uploadimg").attr('disabled','disabled');
    	$("#fileUpload").parent().find('span').html('Click para buscar imagen...');
    });
    //Upload imagen
    $("#form-addimg").submit(function(e){
    	e.preventDefault();
    	var form = new FormData(this);
    	$.ajax({
		    url:'php/pantalla/process.php',
		    type:'POST',
		    data: form,
		    contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#uploadimg').button('loading');
                $('.cancel').attr("disabled","disabled");
            },
		    success: function(res){
		        if(res==1){
		        	swal('Correcto!','La imagen fue subida al servidor exitosamente','success');
		        	loadimages();
		        	$("#modal-addimg").modal('toggle');
		        }else if(res==0){
		        	swal('Error!','No se pudo subir la imagen al servidor, comuníquese con sistemas','error');
		        }else if(res==2){
		        	swal('Oops!','Hubo errores al almacenar los datos de la imagen, refresque la pagina e intentelo nuevamente','warning');
		        }else if(res==3){
		        	swal('Duplicado!','El archivo que intenta subir ya existe. Si es otra imagen cambie su nombre antes de subirla','warning');
		        }
		        $('.cancel').removeAttr('disabled');
		        $('#uploadimg').button('reset');
		    },
		    error:function(){
		    	swal('Error!','No se pudo subir la imagen al servidor, comuníquese con sistemas','error');
		    }
		});
    })
</script>
<script type="text/javascript">
	//carga tabla de salones con cantidades de imagenes asignadas
	var loadsln=function(){
	  	var listsln = $('#tblsalon').DataTable({
	      "ajax": {
	      "method": "POST",
	      "url": "php/pantalla/process.php",
	      "data": {opc: "listsln"},
	      },
	      "columns":[
	        {"data": "slnnombre"},
	        {"data": "cant"},     
		    {"render": function (data, type, JsonResultRow, meta) { 	
				    return "<button class='btn btn-info imgsalon' title='Ver y asignar imagenes' data-cod='"+JsonResultRow.slncodigo+"'><i class='fa fa-edit'></i></button>";	    	
		        	} 
		    },  
	      ],
	      "language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "No hay registros disponibles",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "Cargando...",
		        "processing":     "Procesando...",
		        "search": "_INPUT_",
		        "searchPlaceholder":"Buscar...",
		        "zeroRecords":    "No se encontraron registros",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
		        } 
	       },  
	         "columnDefs":[
	         		{className:"nomsalon","targets":0},
	                {className:"text-center","targets":1},
	                {className:"text-center", "targets": 2 }
	         ],
	             
	         "order": [[0, "asc"]],
	         "bDestroy": true,
	         "pageLength": 5,
  		});
	}
	//carga las imagenes del salon seleccionado
	var loadimgsalon=function(sln){
	  	var listimgsln = $('#tbimgsalon').DataTable({
	      "ajax": {
	      "method": "POST",
	      "url": "php/pantalla/process.php",
	      "data": {opc: "imgsln",sln:sln},
	      },
	      "columns":[
	        {"data": "imgnomarchivo"},
	        {"data": "imgdescripcion"},
	        {"data": "ipsdesde"},
	        {"data": "ipshasta"},
	        {"render": function (data, type, JsonResultRow, meta) { 
	    			if(JsonResultRow.estado=='1'){
			    		return "ASIGNDA";	    		
	    			}else{
	    				return "NO ASIGNADA";
	    			}
	        	} 
		    },   
		    {"render": function (data, type, JsonResultRow, meta) { 
	    			if(JsonResultRow.estado=='1'){
			    		return "<button class='btn btn-danger delimgsln' title='Quitar imagen' data-slncod='"+sln+"' data-imgcod='"+JsonResultRow.imgcodigo+"'><i class='fa fa-minus'></i></button>";	    		
	    			}else{
	    				return "<button class='btn btn-info addimgsln' title='Asignar imagen' data-slncod='"+sln+"' data-imgcod='"+JsonResultRow.imgcodigo+"'><i class='fa fa-plus'></i></button>";
	    			}
	        	} 
		    },  
	      ],
	      "language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "<b class='text-danger'>No hay registros disponibles</b>",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "<i class='fa fa-spinner fa-spin'></i> Cargando, por favor espere...",
		        "processing":     "<i class='fa fa-spinner fa-spin'></i> Procesando...",
		        "search": "_INPUT_",
		        "searchPlaceholder":"Buscar...",
		        "zeroRecords":    "<b class='text-danger'>No se encontraron registros</b>",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
		        } 
	       },  
	         "columnDefs":[
	              {className:"text-center desde","targets":2},
	              {className:"text-center hasta","targets":3},
	              {className:"text-center bold estado","targets":4},
	              {className:"text-center","targets":5}
	         ],
	             
	         "order": [[0, "asc"]],
	         "bDestroy": true,
	         "pageLength": 5,
  		});
	}
	//evento que invoca la carga de la tabla de imagenes por salon seleccionado
	$(document).on('click','.imgsalon',function(){
		var btn=$(this);
		var slnnom=$(this).parent().parent().find('.nomsalon').html();
		var slncod=$(this).data('cod');
		$("#codsalon-modalimgxsln").val(slncod);
		$(".modalslnnom").html(slnnom);
		loadimgsalon(slncod);
		$("#modal-imgsalon").modal('show');
	});
	//quitar imagen de un salon
	$(document).on('click','.delimgsln',function(){
		var btn=$(this);
		var slncod=$(this).data('slncod');
		var imgcod=$(this).data('imgcod');
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'delimgsln',slncod:slncod,imgcod:imgcod},
			success:function(res){
				if(res==1){
					btn.removeClass('btn-danger').addClass('btn-info').removeClass('delimgsln').addClass('addimgsln');
					btn.children().removeClass('fa-minus').addClass('fa-plus');
					btn.parent().parent().find('.estado').html('NO ASIGNADA');
					btn.parent().parent().find('.desde').empty();
					btn.parent().parent().find('.hasta').empty();
				}
			},
			error:function(){
				swal('Boom!','Hubo un error, refresque la página e intentelo nuevamente.','error');
			}
		})
	});
	//modal asignar imagen individual  salón
	$(document).on('click','.addimgsln',function(){
		$(this).addClass('target');
		$("#md-imgcod").val($(this).data('imgcod'));
		$("#md-slncod").val($(this).data('slncod'));
		$("#modal-fechaassign").modal('show');
	});
	//boton asignar de modal: imagen individual x salón
	$("#assign2").click(function(){
		var btn=$(".target");
		var img=$("#md-imgcod").val();
		var sln=$("#md-slncod").val();
		var desde=$("#imgdesde").val();
		var hasta=$("#imghasta").val();
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'addimgsln', sln:sln, img:img, desde:desde, hasta:hasta},
			success:function(res){
				if(res==1){
					btn.removeClass('btn-info').addClass('btn-danger').removeClass('addimgsln').addClass('delimgsln').removeClass('target');
					btn.children().removeClass('fa-plus').addClass('fa-minus');
					btn.parent().parent().find('.estado').html('ASIGNADA');
					btn.parent().parent().find('.desde').html(desde);
					if(hasta==''){
						hasta='2099-12-31';
					}
					btn.parent().parent().find('.hasta').html(hasta);
					$("#modal-fechaassign").modal('toggle');
				}
			},
			error:function(){
				swal('Boom!','Hubo un error, refresque la página e intentelo nuevamente.','error');
			}
		})
	});
	$("#modal-imgsalon").on("hidden.bs.modal", function (){
		loadsln();
		var sln=$("#codsalon-modalimgxsln").val();
		reloadscreen(sln);
	});
	function reloadscreen(sln){
		var pubnub = new PubNub ({
		    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
		    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
		});
		pubnub.publish({
	        message: 'R',
	        channel: 'bty00'+sln
		    },
		    function (status, response) {
		        if (status.error) {
		            console.log(status)
		        } else {
		            console.log("Updated screen "+sln);
		        }
		    }
		);	
	}
	function reloadallscreen(){
		$("#slsalon option").each(function(){
			var sln=$(this).val();
    		reloadscreen(sln);
    		console.log('Reloaded: '+sln);
		});
	}
	function fullreloadallscreen(){
		var pubnub = new PubNub ({
		    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
		    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
		});
		$("#slsalon option").each(function(){
			var sln=$(this).val();
			//var sln=0;
    		pubnub.publish({
	        message: 'RLD',
	        channel: 'bty00'+sln
		    },
		    function (status, response) {
			        if (status.error) {
			            console.log(status)
			        } else {
			            console.log('FullyReloaded slncod: '+sln);
			        }
			    }
			);	
		});
	}
	function reloadbrowser(sln){
		var pubnub = new PubNub ({
		    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
		    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
		});
		for(var i in sln){
			pubnub.publish({
	        message: 'RLD',
	        channel: 'bty00'+sln[i]
		    },
		    function (status, response) {
			        if (status.error) {
			            console.log(status)
			        } else {
			            console.log('FullyReloaded slncod: '+sln);
			        }
			    }
			);	
		}
	}
</script>
<script type="text/javascript">
	$(".reloadscreen").click(function(e){
		$("#modal-resetimg").modal('show');
	})
	$(".rldimg").click(function(e){
		var sln=$("#slsalon2").val();
		if(sln!=null){
			for(var i in sln){
				reloadscreen(sln[i]);
			}
		}else{
			reloadallscreen();
		}
		swal('Acción exitosa!','Las imágenes de las pantallas seleccionadas han sido refrescadas','success');
		$("#modal-resetimg").modal('toggle');		
		$(".slsalon").select2("val", "");
	})
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(".fullyreloadscreen").click(function(e){
		$("#modal-resetnav").modal('show');
	})
	$(".rldbrowser").click(function(e){
		var sln=$("#slsalon3").val();
		if(sln!=null){
				reloadbrowser(sln);
		}else{
			fullreloadallscreen();
		}
		swal('Acción exitosa!','Las pantallas seleccionadas han sido refrescadas','success');
		$("#modal-resetnav").modal('toggle');
		$(".slsalon").select2("val", "");
	})
</script>
<script type="text/javascript">
	function purgarimgsalon(sln){
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'deleteold',sln:sln},
			success:function(res){
				if(res==1){
					console.log('Purgado asign de sln: '+sln);
				}
			}
		})
	}
	$(".deleteold").click(function(e){
		$("#modal-deleteold").modal('show');
	});
	$(".deloldimg").click(function(e){
		var sln=$("#slsalon4").val();
		if(sln!=null){
			for(var i in sln){
				purgarimgsalon(sln[i]);
			}
		}else{
			$("#slsalon4 option").each(function(){
				var sln=$(this).val();
	    		purgarimgsalon(sln);
			});
		}
		loadsln();
		swal('Acción exitosa!','Las imágenes caducadas han sido purgadas','success');
		$("#modal-deleteold").modal('toggle');		
		$(".slsalon").select2("val", "");
	})
</script>
<script type="text/javascript">
	var loadevt=function(){
	  	var listsln = $('#tbleventos').DataTable({
	      "ajax": {
	      "method": "POST",
	      "url": "php/pantalla/process.php",
	      "data": {opc: "eventosyt"},
	      },
	      "columns":[
	        {"data": "ipenombre"},
	        {"data": "ipedescrip"},
	        {"data": "ipeenlace"},
	        {"data": "hini"},
	        {"data": "hfin"},
		    {"render": function (data, type, JsonResultRow, meta) { 
	    			if(JsonResultRow.ipedefault=='1'){
			    		return "<b style='color:green;'>SI</b>";	    		
	    			}else{
	    				return "<b>NO</b>";
	    			}
	        	} 
		    },  
		    {"render": function (data, type, JsonResultRow, meta) { 
	    			if(JsonResultRow.ipeestado=='1'){
			    		return "<b style='color:green;'>ACTIVO</b>";	    		
	    			}else{
	    				return "<b>INACTIVO</b>";
	    			}
	        	} 
		    },  
		    {"render": function (data, type, JsonResultRow, meta) { 
	    			if(JsonResultRow.ipeestado=='1'){
	    				return "<button class='btn btn-warning offevt' title='Inactivar evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-times'></i></button>";
	    			}else{
	    				if(JsonResultRow.ipedefault=='1'){
	    					return "<button class='btn btn-info onevt' title='Activar evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-check'></i></button><button class='btn btn-default edtevt' title='Editar evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-edit'></i></button>";	    
	    				}else{
			    			return "<button class='btn btn-info onevt' title='Activar evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-check'></i></button></button><button class='btn btn-default edtevt' title='Editar evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-edit'></i></button><button class='btn btn-danger delevt' title='Eliminar Evento' data-evtcod='"+JsonResultRow.ipecodigo+"'><i class='fa fa-trash'></i></button>";	    		
	    				}
	    			}
	        	} 
		    },  
	      ],
	      "language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "No hay registros disponibles",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "Cargando...",
		        "processing":     "Procesando...",
		        "search": "_INPUT_",
		        "searchPlaceholder":"Buscar...",
		        "zeroRecords":    "No se encontraron registros",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
		        } 
	       },  
	         "columnDefs":[
	                {className:"text-center","targets":2},
	                {className:"text-center", "targets": 3 },
	                {className:"text-center", "targets": 4 },
	                {className:"text-center", "targets": 5 },
	                {className:"text-center", "targets": 6 },
	                {className:"text-center", "targets": 7 },
	         ],
	             
	         "order": [[6, "asc"]],
	         "bDestroy": true,
	         "pageLength": 5,
  		});
	}
    $(function () {
        $('.horapk').datetimepicker({
            format: 'HH:mm',
            ignoreReadonly: true,
    		allowInputToggle: true
        });
    });
	$(document).on('click','.offevt',function(){
		var evtcod=$(this).data('evtcod');
		swal({
			title: "Desea desactivar este evento?",
			text: "Esta acción reiniciará TODAS las pantallas",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Si, Desactivar!",
			showLoaderOnConfirm: true,
			cancelButtonText: "No, Cancelar!",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:'php/pantalla/process.php',
					type:'POST',
					data:{opc:'offevt',evtcod:evtcod},
					success:function(res){
						if(res==1){
							loadevt();
							swal("Desactivado", "El evento ha sido desactivado", "success");
							fullreloadallscreen();
						}else{
							swal("Oops!", "Ha ocurrido un error", "error");
						}
					}
				})
			} else {
				swal("Acción Cancelada", "No se ha desactivado el evento. No se hicieron cambios.", "error");
			} 
		});
	});
	$(document).on('click','.onevt',function(){
		var evtcod=$(this).data('evtcod');
		swal({
			title: "Activar evento?",
			text: "Esta acción reiniciará TODAS las pantallas y desactivará TODOS los eventos activos. Continuar?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Si, Activar!",
			showLoaderOnConfirm: true,
			cancelButtonText: "No, Cancelar!",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:'php/pantalla/process.php',
					type:'POST',
					data:{opc:'onevt',evtcod:evtcod},
					success:function(res){
						if(res==1){
							loadevt();
							swal("Activado", "El evento ha sido activado y cargado a todas las pantallas", "success");
							fullreloadallscreen();
						}else{
							swal("Oops!", "Ha ocurrido un error", "error");
						}
					}
				})
			} else {
				swal("Acción Cancelada", "No se ha activado el evento. No se hicieron cambios.", "error");
			} 
		});
	});
	$(document).on('click','.delevt',function(){
		var evtcod=$(this).data('evtcod');
		swal({
			title: "Borrar evento?",
			text: "Esta acción borrará el evento definitivamente. Esta acción es IRREVERSIBLE, proceda con precaución. Continuar?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Si, Borrar!",
			showLoaderOnConfirm: true,
			cancelButtonText: "No, Cancelar!",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:'php/pantalla/process.php',
					type:'POST',
					data:{opc:'delevt',evtcod:evtcod},
					success:function(res){
						if(res==1){
							loadevt();
							swal("Borrado", "", "success");
						}else{
							swal("Oops!", "Ha ocurrido un error", "error");
						}
					}
				})
			} else {
				swal("Acción Cancelada", "No se ha borrado el evento. No se hicieron cambios.", "error");
			} 
		});
	});
	function fnereset(){
		$("#formnewevt")[0].reset();
	}
	$("#modal-newevt").on("hidden.bs.modal", function () {
		$("#formnewevt")[0].reset();
		$("#saveevt").attr('data-evtcod',null);
		$(".divlink").addClass('hidden');
	});
	$("#tipoevt").change(function(e){
		var tpo=$(this).val();
		if(tpo=='YT'){
			$(".divlink").removeClass('hidden');
		}else{
			$(".divlink").addClass('hidden');
		}
	})
	$(".newevt").click(function(){
		$("#saveevt").attr('data-evtcod',null);
	})
	$("#saveevt").click(function(e){
		e.preventDefault();
		var evt=$(this).attr('data-evtcod');
		var hini=$("#hini").val().trim();
		var hfin=$("#hfin").val().trim();
		var nom=$("#nameevt").val().trim();
		var des=$("#desevt").val().trim();
		var tpo=$("#tipoevt").val();
		if(tpo=='YT'){
			var blink=$("#linkevt").val();
			var pos=0;
			for(var i=0;i<=blink.length;i++){
				if(blink.charAt(i)=='.'){
					pos++;
				}
			}
			if(pos==1){
				var link=$("#linkevt").val().trim().split('/')[3];
			}else{
				var link=$("#linkevt").val().trim().split('=')[1];
			}
		}else{
			var link='--NINGUNO--';
		}
		if(hfin>hini){
			if(link!=null){
				if(link.length==11){
					var sw=1;
					$(".frmevt").each(function(){
						if((this)!=null){
							var ctr=$(this).val().trim().length;
						}else{
							var ctr=0;
						}
						sw*=ctr;
					})
					//console.log(sw);
					if(sw>0){	
						$.ajax({
							url:'php/pantalla/process.php',
							type:'POST',
							data:{opc:'saveevt',evt:evt,nom:nom,des:des,tpo:tpo,link:link,hini:hini,hfin:hfin},
							success:function(res){
								if(res==1){
									loadevt();
									$("#modal-newevt").modal('toggle');
									swal("Datos de evento guardados", "", "success");
								}else{
									swal('Oops!','Ha ocurrido un error.','error');
								}
							}
						})
					}else{
						swal('Faltan datos!','Todos los campos son obligatorios. Verifique.','error');
					}
				}else{
					swal('Enlace invalido','','error')
				}
			}else{
				swal('Enlace invalido','Debe ingresar un enlace de YOUTUBE valido!','error')
			}
		}else{
			swal('Horas No validas','Verifique que el rango de horas del evento sea el correcto.','error');
		}
	});
	$(document).on('click','.edtevt',function(){
		var evtcod=$(this).data('evtcod');
		$.ajax({
			url:'php/pantalla/process.php',
			type:'POST',
			data:{opc:'loadedtevt',evtcod:evtcod},
			success:function(res){
				var dat=JSON.parse(res);
				$("#nameevt").val(dat.info[1]);
				$("#desevt").val(dat.info[2]);
				$("#tipoevt").val(dat.info[8]);
				if(dat.info[8]=='YT'){
					$(".divlink").removeClass('hidden');
				}else{
					$(".divlink").addClass('hidden');
				}
				$("#linkevt").val('https://www.youtube.com/watch?v='+dat.info[3]);
				$("#hini").val(dat.info[4]);
				$("#hfin").val(dat.info[5]);
				$("#saveevt").attr('data-evtcod',dat.info[0]);
				$("#modal-newevt").modal('show');
			}
		})
	});
</script>
