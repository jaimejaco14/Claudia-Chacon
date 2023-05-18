<?php 
include 'head.php';
include 'librerias_js.php';
VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
RevisarLogin();
?>
<style>
	td {
	    white-space: -o-pre-wrap; 
	    word-wrap: break-word;
	}
	table { 
	  table-layout: fixed;
	  width: 100%;
	}
</style>
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Clasificación</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div class="content animated-panel">
        <div class="hpanel">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div id="tbtipo" class="col-md-3">
                            	<input type="hidden" id="vartipo" name="vartipo">
                            	<table class="table table-hover">
                            	<tr>
                            		<th class="text-center">TIPO
										<button id="newtipo" class="btn btn-default text-info pull-right" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Tipo"><i class="fa fa-plus"></i></button>
                            		</th>
                            	</tr>
	                            	<tbody id="bdtipo">
	                            	</tbody>
                            	</table>
                            </div>
                            <div id="tbsubtipo" class="col-md-3" style="display:none;">
                            	<input type="hidden" id="varsubtipo" name="varsubtipo">
                            	<table class="table table-hover">
                            	<tr>
                            		<th class="text-center">SUBTIPO
										<button id="newsubtia" class="btn btn-default text-info pull-right" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Subtipo"><i class="fa fa-plus"></i></button>
                            		</th>
                            	</tr>
	                            	<tbody id="bdsbtipo">
	                            	</tbody>
                            	</table>
                            </div>
                            <div id="tbgrupo" class="col-md-3" style="display:none;">
                            	<input type="hidden" id="vargrupo" name="vargrupo">
                            	<table class="table table-hover">
                            	<tr>
                            		<th class="text-center">GRUPO
										<button id="newgru" class="btn btn-default text-info pull-right" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Grupo"><i class="fa fa-plus"></i></button>
                            		</th>
                            	</tr>
	                            	<tbody id="bdgrupo">
	                            	</tbody>
                            	</table>
                            </div>
                            <div id="tbsubgrupo" class="col-md-3" style="display:none;">
                            	<input type="hidden" id="varsubgrupo" name="varsubgrupo">
                            	<table class="table table-hover">
                            	<tr>
                            		<th class="text-center">SUBGRUPO
										<button id="newsubgru" class="btn btn-default text-info pull-right" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Subgrupo"><i class="fa fa-plus"></i></button>
                            		</th>
                            	</tr>
	                            	<tbody id="bdsgrupo">
	                            	</tbody>
                            	</table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_tipo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo tipo activos</h4>
          </div>
            <form id="form_tia" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="tianame" name="tianame" maxlength="50" type="text" required autocomplete="off">
                  <div id="infotia" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal tipo activo -->

<!-- Modal sub-tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subtipo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo subtipo activos</h4>
          </div>
            <form id="form_subtia" method="post" class="formul" autocomplete="off">
          <div class="modal-body">
              <input type="hidden" name="tiacodigo" id="tiacodigo">
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="subtianame" name="subtianame" maxlength="50" type="text" required>
                  <div id="infosubtia" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal sub-tipo activo -->

<!-- Modal Grupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_grupo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo grupo activos</h4>
          </div>
            <form id="form_gra" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="graname" name="graname" maxlength="50" type="text" required>
                      <div id="infogra" class="help-block with-errors err"></div>
                    </div>
                   <input type="hidden" name="subtiacodigo" id="subtiacodigo">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal Grupo activo -->

<!-- Modal SubGrupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subgrupo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo Subgrupo activos</h4>
          </div>
            <form id="form_subgra" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="sbgname" name="sbgname" maxlength="50" type="text" required>
                      <div id="infosubgra" class="help-block with-errors err"></div>
                    </div>
                    <div class="form-group">
                      <label for="prioact">
                          Prioridad
                      </label>
                     <select name="prioact" id="prioact" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label>
                          Ubicacion del Codigo QR
                      </label>
                      <textarea class="form-control text-uppercase" id="labelubic" name="labelubic" maxlength="50" style="resize: none;" required></textarea>
                      <div id="infogra" class="help-block with-errors err"></div>
                    </div>
                   <input type="hidden" name="grucodigo" id="grucodigo">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal SubGrupo activo -->

<!-- Modal editar tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_tipo2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar tipo activos</h4>
          </div>
            <form id="form_tia2" method="post" class="formul">
	          <div class="modal-body">
	              	<input type="hidden" id="codtipo" name="codtipo">
	                <div class="form-gruop">
	                  <label>
	                      Nombre
	                  </label>
	                  <input class="form-control text-uppercase" id="tianame2" name="tianame2" maxlength="50" type="text" required autocomplete="off">
	                  <div id="infotia2" class="help-block with-errors err"></div>
	                </div>

	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-success">Guardar</button>
	           
	          </div>
            </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal editar tipo activo -->

<!-- Modal editar sub-tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subtipo2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar subtipo activos</h4>
          </div>
            <form id="form_subtia2" method="post" class="formul" autocomplete="off">
          <div class="modal-body">
              <input type="hidden" name="codsubtipo" id="codsubtipo">
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="subtianame2" name="subtianame2" maxlength="50" type="text" required>
                  <div id="infosubtia2" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal editar sub-tipo activo -->

<!-- Modal editar Grupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_grupo2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar grupo activos</h4>
          </div>
            <form id="form_gra2" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  <input type="hidden" id="codgru" name="codgru">
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="graname2" name="graname2" maxlength="50" type="text" required>
                      <div id="infogra2" class="help-block with-errors err"></div>
                    </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal editar Grupo activo -->

<!-- Modal SubGrupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subgrupo2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Subgrupo activos</h4>
          </div>
            <form id="form_subgra2" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="sbgname2" name="sbgname2" maxlength="50" type="text" required>
                      <div id="infosubgra2" class="help-block with-errors err"></div>
                    </div>
                    <div class="form-group">
                      <label for="prioact">
                          Prioridad
                      </label><br>
                      <small class="text-danger"><b>Prioridad actual:</b></small><small class="text-danger" id="oldprio"></small>
                     <select name="prioact2" id="prioact2" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label>
                          Ubicacion del Codigo QR
                      </label>
                      <textarea class="form-control text-uppercase" id="labelubic2" name="labelubic2" maxlength="50" style="resize: none;" required></textarea>
                    </div>
                   <input type="hidden" name="grucodigo2" id="grucodigo2">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal SubGrupo activo -->


<script>	//funciones que llenan las tablas
	$(document).ready(function() {
		loadtipo();
		loadprio();
	});
	function loadtipo(){
		$("#bdtipo").html('');
		$("#tbsubtipo").hide();
		$("#tbgrupo").hide();
		$("#tbsubgrupo").hide();
		$.ajax({
			url:'php/operclasificacion.php',
			type:'POST',
			data:'opc=tipo',
			success:function(datos){
				$("#bdtipo").html(datos);
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		})
	}

	function loadsbtipo(tp){
		$("#bdsbtipo").html('');
		$("#tbgrupo").hide();
		$("#tbsubgrupo").hide();
		$.ajax({
			url:'php/operclasificacion.php',
			type:'POST',
			data:'opc=sbtipo&tipo='+tp,
			success:function(datos){
				$("#bdsbtipo").html(datos);
				$("#tbsubtipo").show();
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		})
	}

	function loadgrupo(sbt){
		$("#bdgrupo").html('');
		$("#tbsubgrupo").hide();
		$.ajax({
			url:'php/operclasificacion.php',
			type:'POST',
			data:'opc=grupo&sbtipo='+sbt,
			success:function(datos){
				$("#bdgrupo").html(datos);
				$("#tbgrupo").show();
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		})
	}

	function loadsubgrupo(gru){
		$.ajax({
			url:'php/operclasificacion.php',
			type:'POST',
			data:'opc=sbgrupo&grupo='+gru,
			success:function(datos){
				$("#bdsgrupo").html(datos);
				$("#tbsubgrupo").show();
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		})
	}

	function loadprio(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=prio',
          success:function(res){
            $("#prioact").html(res); 
            $("#prioact2").html(res); 
          }
        });
    }
</script>
<script>	//cascada de tablas
	$(document).on('click' , '.tipo' , function(e){
		$('[data-toggle="tooltip"]').tooltip('hide'); 
        e.preventDefault();
        var tipo=$(this).data('tipo');
        $("#vartipo").val(tipo);
        $("#bdtipo").find('tr').css('background-color','white');
        $(this).closest('tr').css('background-color','lightblue');
        loadsbtipo(tipo);
    });
    $(document).on('click' , '.sbtipo' , function(e){
    	$('[data-toggle="tooltip"]').tooltip('hide'); 
        e.preventDefault();
        var sbtipo=$(this).data('sbtipo');
        $("#varsubtipo").val(sbtipo);
        $("#bdsbtipo").find('tr').css('background-color','white');
        $(this).closest('tr').css('background-color','lightblue');
        loadgrupo(sbtipo);
    });
    $(document).on('click' , '.grupo' , function(e){
    	$('[data-toggle="tooltip"]').tooltip('hide'); 
        e.preventDefault();
        var grupo=$(this).data('grupo');
        $("#vargrupo").val(grupo);
        $("#bdgrupo").find('tr').css('background-color','white');
        $(this).closest('tr').css('background-color','lightblue');
        loadsubgrupo(grupo);
    });
</script>
<script>	//oper modales add

	$("#newtipo").click(function(e){
		$("#modal_tipo").modal('show');
	});

	$("#newsubtia").click(function(e){
        e.preventDefault();
        var idti=$("#vartipo").val();
        if(idti!=0){
          $("#tiacodigo").val(idti);
          console.log(idti);
          $("#modal_subtipo").modal('show');
        }else{
          swal('Para agregar un nuevo subtipo debe seleccionar un tipo de activo','','warning')
        }
    });

    $("#newgru").click(function(e){
        e.preventDefault();
        var idsbt=$("#varsubtipo").val();
        if(idsbt!=0){
          $("#subtiacodigo").val(idsbt);
          $("#modal_grupo").modal('show');
        }else{
          swal('Para agregar un nuevo grupo debe seleccionar un tipo y subtipo de activo','','warning')
        }
    });  
      
    $("#newsubgru").click(function(e){
        e.preventDefault();
        var idti=$("#vargrupo").val();
        if(idti!=0){
          $("#grucodigo").val(idti);
          $("#modal_subgrupo").modal('show');
        }else{
          swal('Para agregar un nuevo subgrupo debe seleccionar un Grupo de activos','','warning');
        }
    });

    $("#form_tia").on("submit", function(event) {
          event.preventDefault();
          var long = $.trim($('#tianame').val()).length;
          if(long  > 0){
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addtia',
                success: function(data) {
                    if (data == "TRUE"){
                      loadtipo();
                      $(".modal").modal('hide');
                      $("#form_tia")[0].reset();
                      loadtipo();
                    }else{
                      swal('Oops!','Ha ocurrido un error inesperado; refresque la pagina e intentelo nuevamente','error');
                    }  
               }
            });
          }else{
            swal('Nombre de Tipo NO permitido','','warning');
          }
    });

    $("#form_subtia").on("submit", function(e) {
          e.preventDefault();
          var long = $.trim($('#subtianame').val()).length;
          var tipo=$("#vartipo").val();
          if(long  > 0){
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addsubtia',
                success: function(data) {
                    if (data == "true"){
                      loadsbtipo(tipo);
                      $("#form_subtia")[0].reset();
                      $(".modal").modal('hide');
                    }  else{
                      swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
                    }
                },
            });
          }else{
            swal('Nombre de Subtipo NO permitido','','warning');
          }
    });

	$("#form_gra").on("submit", function(e) {
		e.preventDefault();
		var long = $.trim($('#graname').val()).length;
		var sbtipo=$("#varsubtipo").val();
		if(long  > 0){
			$.ajax({
			    type: "POST",
			    url: "php/loadselact.php",
			    data: $(this).serialize()+'&opc=addgru',
			    success: function(data) {
			        if (data == "TRUE"){
			          $("#form_gra")[0].reset();
			          $(".modal").modal('hide');
			          loadgrupo(sbtipo);
			        }  else{
			          swal('','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
			        }
			    }
			});
		}else{
		swal('Nombre de grupo NO permitido','','warning');
		}
	});

	$("#form_subgra").on("submit", function(e) {
		e.preventDefault();
		var long = $.trim($('#sbgname').val()).length;
		var gru=$("#vargrupo").val();
		if(long  > 0){
		if($("#prioact").val()!=0){
		  $.ajax({
		      type: "POST",
		      url: "php/loadselact.php",
		      data: $(this).serialize()+'&opc=addsubgru',
		      success: function(data) {
		          if (data == "TRUE"){
		            loadsubgrupo(gru);
		            $("#form_subgra")[0].reset();
		            $(".modal").modal('hide');
		          }  else{
		            swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
		          }
		      }
		  });
		}else{
		  swal('Seleccione una prioridad!','','warning');
		}
		}else{
		swal('Nombre de subgrupo NO permitido','','warning');
		}
	});
	$('#graname').keyup(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();     
	  var idtia=$("#varsubtipo").val();
	  var dataString = 'opc=seekgra&key='+name+'&sbt='+idtia;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infogra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
	          }else{
	            $("#infogra").html('');
	          }
	      }
	  });
	});
	$('#sbgname').keyup(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();     
	  var gru=$("#vargrupo").val();
	  var dataString = 'opc=seeksubgra&key='+name+'&gra='+gru;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infosubgra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
	          }else{
	            $("#infosubgra").html('');
	          }
	      }
	  });
	});
	$('#tianame').keyup(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();        
	  var dataString = 'opc=seektia&key='+name;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infotia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activo</font></div>');
	          }else{
	            $("#infotia").html('');
	          }
	      }
	  });
	});
	$('#subtianame').keyup(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();  
	  var tia=$("#vartipo").val();
	  var dataString = 'opc=seeksubtia&key='+name+'&tia='+tia;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infosubtia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este subtipo de activo</font></div>');
	          }else{
	            $("#infosubtia").html('');
	          }
	      }
	  });
	});
	$('#graname').blur(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();     
	  var idtia=$("#varsubtipo").val();
	  var dataString = 'opc=seekgra&key='+name+'&sbt='+idtia;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infogra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
	          }else{
	            $("#infogra").html('');
	          }
	      }
	  });
	});
	$('#sbgname').blur(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();     
	  var gru=$("#vargrupo").val();
	  var dataString = 'opc=seeksubgra&key='+name+'&gra='+gru;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infosubgra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este Subgrupo de activos</font></div>');
	          }else{
	            $("#infosubgra").html('');
	          }
	      }
	  });
	});
	$('#tianame').blur(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();        
	  var dataString = 'opc=seektia&key='+name;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infotia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activo</font></div>');
	          }else{
	            $("#infotia").html('');
	          }
	      }
	  });
	});
	$('#subtianame').blur(function(){
	  this.value=this.value.toUpperCase();
	  var name = $(this).val();  
	  var tia=$("#vartipo").val();
	  var dataString = 'opc=seeksubtia&key='+name+'&tia='+tia;
	  $.ajax({
	      type: "POST",
	      url: "php/loadselact.php",
	      data: dataString,
	      success: function(data) {
	          if(data=='false'){
	            $("#infosubtia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este subtipo de activo</font></div>');
	          }else{
	            $("#infosubtia").html('');
	          }
	      }
	  });
	});
</script>
<script>    //editar y eliminar
	/////////////////////ELIMINAR/////////////////////////
	   	$(document).on('click' , '.delete' , function(e){
	   		var tipo=$(this).data('tipo');
	   		$("#tbsubtipo").hide();
			$("#tbgrupo").hide();
    		$("#tbsubgrupo").hide();
	   		$("#bdtipo").find('tr').css('background-color','white');
        	$(this).closest('tr').css('background-color','lightblue');
	   		 swal({
	            title: "¿Seguro que desea eliminar este Tipo de activo?",
	            text: "Todos los subtipos, grupos y subgrupos que dependan de este tipo, tambien serán eliminados. ESTA ACCION NO ES REVERSIBLE",
	            type: "warning",
	            showCancelButton:  true,
	            cancelButtonText:"No",
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Sí"  
	            },function () {
	                $.ajax({
	                    url:'php/operclasificacion.php',
	                    type:'POST',
	                    data:'opc=deltipo&tipo='+tipo,
	                    success:function(res){
	                        if(res=='true'){
	                            loadtipo();
	                        }else{
	                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
	                        }
	                    }
	                })
	        });  
	   	});

	   	$(document).on('click' , '.sbtdelete' , function(e){
	   		$("#tbgrupo").hide();
    		$("#tbsubgrupo").hide();
	   		var tipo=$("#vartipo").val();
	   		var stipo=$(this).data('sbtipo');
	   		$("#bdsbtipo").find('tr').css('background-color','white');
        	$(this).closest('tr').css('background-color','lightblue');
	   		 swal({
	            title: "¿Seguro que desea eliminar este SubTipo de activo?",
	            text: "Todos los grupos y subgrupos que dependan de este subtipo, tambien serán eliminados. ESTA ACCION NO ES REVERSIBLE",
	            type: "warning",
	            showCancelButton:  true,
	            cancelButtonText:"No",
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Sí"  
	            },function () {
	                $.ajax({
	                    url:'php/operclasificacion.php',
	                    type:'POST',
	                    data:'opc=delsubtipo&subtipo='+stipo,
	                    success:function(res){
	                        if(res=='true'){
	                            loadsbtipo(tipo);
	                        }else{
	                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
	                        }
	                    }
	                })
	        });  
	   	});

	   	$(document).on('click' , '.grdelete' , function(e){
	   		$("#tbsubgrupo").hide();
	   		var stipo=$("#varsubtipo").val();
	   		var grupo=$(this).data('grupo');
	   		 swal({
	            title: "¿Seguro que desea eliminar este Grupo de activos?",
	            text: "Todos los subgrupos que dependan de este grupo, tambien serán eliminados. ESTA ACCION NO ES REVERSIBLE",
	            type: "warning",
	            showCancelButton:  true,
	            cancelButtonText:"No",
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Sí"  
	            },function () {
	                $.ajax({
	                    url:'php/operclasificacion.php',
	                    type:'POST',
	                    data:'opc=delgrupo&grupo='+grupo,
	                    success:function(res){
	                        if(res=='true'){
	                            loadgrupo(stipo);
	                        }else{
	                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
	                        }
	                    }
	                })
	        });  
	   	});

	   	$(document).on('click' , '.sgdelete' , function(e){
	   		var grupo=$("#vargrupo").val();
	   		var sbg=$(this).data('sbgrupo');
	   		$("#bdsgrupo").find('tr').css('background-color','white');
        	$(this).closest('tr').css('background-color','lightblue');
	   		 swal({
	            title: "¿Seguro que desea eliminar este Subgrupo de activos?",
	            text: "ESTA ACCION NO ES REVERSIBLE",
	            type: "warning",
	            showCancelButton:  true,
	            cancelButtonText:"No",
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Sí"  
	            },function () {
	                $.ajax({
	                    url:'php/operclasificacion.php',
	                    type:'POST',
	                    data:'opc=delsubgrupo&sbg='+sbg,
	                    success:function(res){
	                        if(res=='true'){
	                            loadsubgrupo(grupo);
	                        }else{
	                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
	                        }
	                    }
	                })
	        });  
	   	});
   	////////////////////EDITAR////////////////////////////
   		//EDITAR TIPO////////////////////////////////////
	   		$(document).on('click' , '.edit' , function(e){
	   			var old=$(this).parents("tr").find(".nomti").html();
	   			var tipo=$(this).data('tipo');
	   			$("#tianame2").val(old);
	   			$("#codtipo").val(tipo);
	   			$("#bdtipo").find('tr').css('background-color','white');
	        	$(this).closest('tr').css('background-color','lightblue');
	   			$("#infotia2").html('');
	   			$("#modal_tipo2").modal('show');
	   		});
	   		$("#tianame2").on('keyup blur', function(e){
	   			this.value=this.value.toUpperCase();
				var name = $(this).val();        
				var dataString = 'opc=seektia&key='+name;
				$.ajax({
				  type: "POST",
				  url: "php/loadselact.php",
				  data: dataString,
				  success: function(data) {
				      if(data=='false'){
				        $("#infotia2").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activo</font></div>');
				      }else{
				        $("#infotia2").html('');
				      }
				  }
				});
	   		})
	   		$("#form_tia2").on("submit", function(event) {
		          event.preventDefault();
		          var long = $.trim($('#tianame2').val()).length;
		          if(long  > 0){
		            $.ajax({
		                type: "POST",
		                url: "php/operclasificacion.php",
		                data: $(this).serialize()+'&opc=edtipo',
		                success: function(data) {
		                    if (data == "TRUE"){
		                      loadtipo();
		                      $(".modal").modal('hide');
		                      $("#form_tia2")[0].reset();
		                      loadtipo();
		                    }else{
		                      swal('Oops!','Ha ocurrido un error inesperado; refresque la pagina e intentelo nuevamente','error');
		                    }  
		               }
		            });
		          }else{
		            swal('Nombre de Tipo NO permitido','','warning');
		          }
		    });
   		//EDITAR SUBTIPO////////////////////////////////////
		    $(document).on('click' , '.sbtedit' , function(e){
	   			var old=$(this).parents("tr").find(".nomst").html();
	   			var stipo=$(this).data('sbtipo');
	   			$("#subtianame2").val(old);
	   			$("#codsubtipo").val(stipo);
	   			$("#bdsbtipo").find('tr').css('background-color','white');
	        	$(this).closest('tr').css('background-color','lightblue');
	   			$("#infosubtia2").html('');
	   			$("#modal_subtipo2").modal('show');
	   		});
	   		$("#subtianame2").on('keyup blur', function(e){
	   			this.value=this.value.toUpperCase();
	   			var idti=$("#vartipo").val();
				var name = $(this).val();        
				var dataString = 'opc=seeksubtia&key='+name+'&tia='+idti;
				$.ajax({
				  type: "POST",
				  url: "php/loadselact.php",
				  data: dataString,
				  success: function(data) {
				      if(data=='false'){
				        $("#infosubtia2").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este subtipo de activo</font></div>');
				      }else{
				        $("#infosubtia2").html('');
				      }
				  }
				});
	   		})
	   		$("#form_subtia2").on("submit", function(e) {
				e.preventDefault();
				var long = $.trim($('#subtianame2').val()).length;
				var tipo=$("#vartipo").val();
				if(long  > 0){
				$.ajax({
				    type: "POST",
				    url: "php/operclasificacion.php",
				    data: $(this).serialize()+'&opc=edsubtipo',
				    success: function(data) {
				        if (data == "TRUE"){
				          loadsbtipo(tipo);
				          $("#form_subtia")[0].reset();
				          $(".modal").modal('hide');
				        }  else{
				          swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
				        }
				    },
				});
				}else{
				swal('Nombre de Subtipo NO permitido','','warning');
				}
		    });
	    //EDITAR GRUPO////////////////////////////////////
		    $(document).on('click' , '.gredit' , function(e){
	   			var old=$(this).parents("tr").find(".nomgru").html();
	   			var grupo=$(this).data('grupo');
	   			$("#graname2").val(old);
	   			$("#codgru").val(grupo);
	   			$("#bdgrupo").find('tr').css('background-color','white');
	        	$(this).closest('tr').css('background-color','lightblue');
	   			$("#infogra2").html('');
	   			$("#modal_grupo2").modal('show');
	   		});
	   		$("#graname2").on('keyup blur', function(e){
	   			this.value=this.value.toUpperCase();
	   			var sbt=$("#varsubtipo").val();
				var name = $(this).val();        
				var dataString = 'opc=seekgra&key='+name+'&sbt='+sbt;
				$.ajax({
				  type: "POST",
				  url: "php/loadselact.php",
				  data: dataString,
				  success: function(data) {
				      if(data=='false'){
				        $("#infogra2").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este grupo de activos</font></div>');
				      }else{
				        $("#infogra2").html('');
				      }
				  }
				});
	   		})
	   		$("#form_gra2").on("submit", function(e) {
				e.preventDefault();
				var long = $.trim($('#graname2').val()).length;
				var sbt=$("#varsubtipo").val();
				if(long  > 0){
				$.ajax({
				    type: "POST",
				    url: "php/operclasificacion.php",
				    data: $(this).serialize()+'&opc=edgrupo',
				    success: function(data) {
				        if (data == "TRUE"){
				          loadgrupo(sbt);
				          $("#form_gra2")[0].reset();
				          $(".modal").modal('hide');
				        }  else{
				          swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
				        }
				    },
				});
				}else{
				swal('Nombre de Subtipo NO permitido','','warning');
				}
		    });
	    ////////////////////EDITAR SUBGRUPO///////////////
	    $(document).on('click' , '.sgedit' , function(e){
   			var old=$(this).parents("tr").find(".nomsg").html();
   			var sgr=$(this).data('sbgrupo');
   			var prio=$(this).data('prio');
   			var etq=$(this).data('etiqueta');
   			$("#grucodigo2").val(sgr);
   			$("#sbgname2").val(old);
   			$("#oldprio").html(prio);
   			$("#labelubic2").val(etq);
   			$("#bdsgrupo").find('tr').css('background-color','white');
        	$(this).closest('tr').css('background-color','lightblue');
        	$("#infosubgra2").html('');
   			$("#modal_subgrupo2").modal('show');
   		});
   		$("#sbgname2").on('keyup blur', function(e){
   			this.value=this.value.toUpperCase();
   			var gru=$("#vargrupo").val();
			var name = $(this).val();        
			var dataString = 'opc=seeksubgra&key='+name+'&gra='+gru;
			$.ajax({
			  type: "POST",
			  url: "php/loadselact.php",
			  data: dataString,
			  success: function(data) {
			      if(data=='false'){
			        $("#infosubgra2").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este Subgrupo de activos</font></div>');
			      }else{
			        $("#infosubgra2").html('');
			      }
			  }
			});
   		})
   		$("#form_subgra2").on("submit", function(e) {
			e.preventDefault();
			var long = $.trim($('#sbgname2').val()).length;
			var gru=$("#vargrupo").val();
			if(long  > 0){
			if($("#prioact2").val()!=0){
			  $.ajax({
			      type: "POST",
			      url: "php/operclasificacion.php",
			      data: $(this).serialize()+'&opc=edsubgru',
			      success: function(data) {
			          if (data == "TRUE"){
			            loadsubgrupo(gru);
			            $("#form_subgra2")[0].reset();
			            $(".modal").modal('hide');
			          }  else{
			            swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
			          }
			      }
			  });
			}else{
			  swal('Seleccione una prioridad!','','warning');
			}
			}else{
			swal('Nombre de subgrupo NO permitido','','warning');
			}
	    });
</script>