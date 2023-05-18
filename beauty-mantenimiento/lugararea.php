<?php 
    include("head.php");
    include '../cnx_data.php';
    include "librerias_js.php";

    VerificarPrivilegio("LUGAR (ACTIVOS)", $_SESSION['tipo_u'], $conn);
    RevisarLogin();     
     
?>

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Lugares y áreas</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                
            </div>
        </div>        
    </div>
    <div class="content animated-panel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1"> Lugares</a></li>
                <li ><a data-toggle="tab" href="#tab-2">  Áreas</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="input-group col-md-8 col-md-push-2">
                            <input class="form-control" type="text" id="seeklugar" name="seeklugar" placeholder="Buscar lugar por nombre...">
                            <div class="input-group-btn">
                               <button id="btnnewlug" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo lugar"><i class="fa fa-plus-square-o text-info"></i></button>
                            </div>
                        </div><br><br>
                        <div id="lugares" class="col-md-8 col-md-push-2"></div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <div class="input-group col-md-12 col-md-push-2">
                            <select name="sellugar" id="sellugar"></select>
                            <div class="input-group-btn">
                               <button id="btnnewarea" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Agregar área a este lugar"><i class="fa fa-plus-square-o text-info"></i></button>
                            </div>
                        </div><br><br>
                        <div id="areas" class=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal nuevo lugar -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_newlugar">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus text-info"></i> Agregar nuevo Lugar</h4>
          </div>
            <form id="form_newlug" method="post">
              <div class="modal-body">
                <div class="form-gruop">
                  <label>
                      Nombre del lugar
                  </label>
                  <input class="form-control text-uppercase nomlugar" id="lugname" name="lugname" maxlength="50" type="text" required>
                  <div id="Infolug" class="help-block with-errors infolug"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="submitformgru" class="btn btn-success">Guardar</button>
              </div>
             </form>
        </div>
      </div>
    </div>
<!-- /.modal nuevo lugar -->

<!-- Modal editar lugar -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_editlugar">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit text-info"></i> Editar Lugar</h4>
          </div>
            <form id="form_editlug" method="post">
              <div class="modal-body">
                <div class="form-group">
                <input type="hidden" name="idlugar" id="idlugar">
                  <label>
                      Nombre del lugar
                  </label>
                  <input class="form-control text-uppercase nomlugar" id="editlugname" name="editlugname" maxlength="50" type="text" required>
                  <div id="infolug" class="help-block with-errors infolug"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="submitformgru" class="btn btn-success">Guardar</button>
              </div>
             </form>
        </div>
      </div>
    </div>
<!-- /.modal editar lugar -->

<!-- Modal nueva area -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_newarealug">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus text-info"></i> Agregar area a:</h4><div class="col-md-4"><h4 id="titmodluar"></h4></div>
          </div>
            <form id="form_newarea">
              <div class="modal-body">
                <input type="hidden" name="idlug" id="idlug">
                <div class="form-group">
                  <label>
                      Nombre del área
                  </label>
                  <input class="form-control text-uppercase nomarea" id="arname" name="arname" maxlength="50" type="text" required>
                  <div class="help-block with-errors infoar"></div>
                </div>
                <div class="form-group">
                  <label>
                      Descripción
                  </label>
                  <input class="form-control text-uppercase" id="ardesc" name="ardesc" maxlength="50" type="text" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="" class="btn btn-success">Guardar</button>
              </div>
            </form>
        </div>
      </div>
    </div>
<!-- /.modal nuevo area -->

<!-- Modal editar area -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_edtarealug">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class=""><i class="fa fa-edit text-info"></i> Editar área de:</h3><div class="col-md-4"><h4 id="titedtmodluar"></h4></div>
          </div>
            <form id="form_editarea">
                <div class="modal-body">
                    <input type="hidden" name="editarcod" id="editarcod">
                    <div class="form-group">
                      <label>
                          Nombre del área
                      </label>
                      <input class="form-control text-uppercase nomarea" id="editarname" name="editarname" maxlength="50" type="text" required>
                      <div class="help-block with-errors infoar"></div>
                    </div>
                    <div class="form-group">
                      <label>
                          Descripción
                      </label>
                      <input class="form-control text-uppercase" id="editardesc" name="editardesc" maxlength="50" type="text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
<!-- /.modal editar area -->
<script>
  $("side-menu").children(".active").removeClass("active");
  $("#LUGAR").addClass("active");
</script>
<script>
    /* OPREACIONES Y OPCIONES DE LUGAR */
    $("#lugares").load('php/operlugararea.php?opc=loadlug');


    $("#btnnewlug").click(function(e){
        $("#modal_newlugar").modal('show');
    });

    $("#form_newlug").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $("#lugares").empty();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=addlug&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#modal_newlugar").modal('hide');
                    $("#lugares").load('php/operlugararea.php?opc=loadlug');
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                }
            }
        });
    });

    $("#form_editlug").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=editlug&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#modal_editlugar").modal('hide');
                    $("#lugares").load('php/operlugararea.php?opc=loadlug');
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                }
            }
        });
    });

    $(document).on("click", ".editar", function() {
        var id = $(this).data('id');
        var currentRow=$(this).closest("tr"); 
        var name=currentRow.find("td:eq(0)").text();
        $("#editlugname").val(name);
        $("#idlugar").val(id);
        $("#modal_editlugar").modal('show');
    });

    $(document).on("click", ".delete", function() {
        var id=$(this).data('id');
        swal({
            title: "¿Seguro que desea eliminar este Lugar?",
            text: "Esta acción NO puede deshacerse. si está seguro, pulse 'si' para continuar.",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"
        },
        function(){
            $.ajax({
                url:'php/operlugararea.php',
                type:'GET',
                data:'opc=dellug&id='+id,
                success:function(res){
                    if(res=='true'){
                        $("#modal_newlugar").modal('hide');
                        $("#lugares").load('php/operlugararea.php?opc=loadlug');
                    }else{
                        swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                    }
                }
            });
        });
    });

    $(".nomlugar").keyup(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=buslug&str='+str,
            success:function(res){
                if(res=='false'){
                    $(".infolug").html('<h4><font color="red"> Ya existe este nombre</font><input tipo="text" hidden required /></h4>');
                }else{
                    $(".infolug").html('');
                }
            }   
        })
    });

    $(".modal").on("hidden.bs.modal", function () {
        $(".infolug").html('');
        $(".infoar").html('');
    });

    $("#seeklugar").keyup(function(){
        var str=$(this).val();
        $("#lugares").html('');
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=loadlug&str='+str,
            success:function(res){
                $("#lugares").html(res);
            }
        });
    });

    function paginar(id) {
        var str=$("#seeklugar").val();
        $.ajax({
            type: "GET",
            url: "php/operlugararea.php",
            data: 'opc=loadlug&page='+id+'&str='+str,
            success:function(res){
                $("#lugares").html(res);
            }
        });
    }
</script>
<script>
    /*OPERACIONES Y OPCIONES DE AREA*/

        $('#sellugar').selectpicker({
            liveSearch: true,
            title:'Seleccione o busque un lugar para crear o ver sus areas...'
        });
 

    $('#sellugar').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });

    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/operlugararea.php',
            type: 'GET',
            data:'opc=loadsellug&key='+seek,
            success: function(data){
                var json = JSON.parse(data);
                var lugs = "";
                for(var i in json){
                    lugs += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#sellugar").html(lugs);
                $("#sellugar").selectpicker('refresh');
            }
        }); 
    });

    $("#sellugar").change(function(e){
        var idlug=$(this).val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=loadarea&id='+idlug,
            success:function(res){
                $("#areas").html(res);
            }
        });
    });

    $("#btnnewarea").click(function(e){
        var idlug=$("#sellugar").val();
        var nomlug=$("#sellugar option:selected").text();
        $("#titmodluar").html(nomlug);
        $("#idlug").val(idlug);
        $("#modal_newarealug").modal('show');
    });

    $("#form_newarea").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=addarea&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#areas").load('php/operlugararea.php?opc=loadarea&id='+idlug);
                    $("#modal_newarealug").modal('hide');
                    $("#form_newarea")[0].reset();
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, recargue la página e intentelo nuevamente','error');
                }
            }
        })
    });

    $(".nomarea").keyup(function(e) {
       var str=$(this).val();
       var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=valnomarea&str='+str+'&idlug='+idlug,
            success:function(res){
                if(res=='false'){
                    $(".infoar").html('<h4><font color="red"> Ya existe esta area en este lugar</font><input tipo="text" hidden required /></h4>');
                }else{
                    $(".infoar").html('');
                }
            }   
        })
    });

    $(document).on('click' , '.delarea', function(e){
        var idar=$(this).data('id');
        var idlug=$("#sellugar").val();
        swal({
            title: "¿Seguro que desea eliminar el area de este Lugar?",
            text: "Esta acción NO puede deshacerse. Si está seguro, pulse 'si' para continuar.",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"
        },
        function(){
            $.ajax({
                url:'php/operlugararea.php',
                type:'GET',
                data:'opc=delarea&id='+idar,
                success:function(res){
                    if(res=='true'){
                        $("#areas").load('php/operlugararea.php?opc=loadarea&id='+idlug);
                    }else{
                        swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                    }
                }
            });
        });
    });

    $(document).on('click' , '.editarea', function(e){
        var id = $(this).data('id');
        var lug =$("#sellugar option:selected").text();
        var currentRow=$(this).closest("tr"); 
        var name=currentRow.find("td:eq(0)").text();
        var desc=currentRow.find("td:eq(1)").text();
        $("#titedtmodluar").html(lug);
        $("#editarname").val(name);
        $("#editardesc").val(desc);
        $("#editarcod").val(id);
        $("#modal_edtarealug").modal('show');
    });

    $("#form_editarea").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=editarea&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#areas").load('php/operlugararea.php?opc=loadarea&id='+idlug);
                    $("#modal_edtarealug").modal('hide');
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, recargue la página e intentelo nuevamente','error');
                }
            }
        })
    });

    function paginar2(id) {
        var idlug=$("#sellugar").val();
        $.ajax({
            type: "GET",
            url: "php/operlugararea.php",
            data: 'opc=loadarea&page='+id+'&id='+idlug,
            success:function(res){
                $("#areas").html(res);
            }
        });
    }

</script>


