<?php 
    /*include("./head.php");
    include("./conexion.php");
    include "./librerias_js.php";*/

    VerificarPrivilegio("deshabilitado", $_SESSION['tipo_u'], $conn);
    RevisarLogin();     
     
?>

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>Módulo Activos</span>
                    </li>
                    <li class="active">
                        <span>Activos</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                    <!-- divison correspondiente a la barra de busqueda, la cual consta de un form  el form ejecuta la accion en la -->
                        <div class="input-group">
                            <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre o código del activo">
                            <div class="input-group-btn">
                                <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                <a href="new_activo.php"><button class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo activo"><i class="fa fa-plus-square-o text-info"></i>
                                    </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    
    <div class="content animated-panel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active listact"><a data-toggle="tab" href="#tab-1" id="listact"> Activos</a></li>
                <li class="detact" style="display:none;"><a data-toggle="tab" id="detact" href="#tab-2">  Detalles</a></li>
                <li class="movact" style="display:none;"><a data-toggle="tab" id="movact" href="#tab-3">  Ubicación</a></li>
                <li class="revmtto" style="display:none;"><a data-toggle="tab" id="revmtto" href="#tab-4">  Programación</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div id="listado">
                            <?php include 'listactivo.php'; ?>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane" style="display:none;">
                    <div class="panel-body">
                        <div id="detalles"></div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                    <h4><b>Ubicación actual:</b></h4><h4 id="ubicact"></h4>
                        <div id="movimientos"></div>
                    </div>
                </div>
                <div id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        <form id="form_filtro">
                            <div class="row"> 
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="filtipo" name="filtipo">
                                        <option value=""> -Filtrar por tipo- </option>
                                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                        <option value="REVISION">REVISIÓN</option>
                                        <option value="SERVICIO">SERVICIO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="filest" name="filest">
                                        <option value=""> -Filtrar por estado- </option>
                                        <option value="CANCELADO">CANCELADO</option>
                                        <option value="EJECUTADO">EJECUTADO</option>
                                        <option value="PROGRAMADO">PROGRAMADO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <h5><b>Filtrar por fecha</b></h5>
                                </div>
                                 <div class="form-group col-md-2">
                                    <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="fildesde" id="fildesde" placeholder="Desde">
                                </div>
                                <div class="form-group col-md-1">
                                    <center><h5><b>a:</b></h5></center>
                                </div>
                                 <div class="form-group col-md-2">
                                    <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="filhasta" id="filhasta" placeholder="Hasta" disabled>
                                </div>
                                <div class="form-group col-md-2" style="display:none;" id="divreset">
                                    <button id="resetfil" type="reset" class="btn btn-info pull-left" data-toggle="tooltip" data-placement="right" title="Reiniciar filtro"><span class="fa fa-filter"></span></button>
                                </div>
                            </div>
                            <div class="row">    
                                <div id="revmttoact" class="revmttoact"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal programacion actividades-->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_prog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <center> <h3><span class="fa fa-edit"></span><b> Este activo NO tiene programación de actividades vigente</b></h3></center>
                </div>
                <form id="form_prog" method="post" class="formul">
                    <div class="modal-body">
                        <input type="hidden" name="idact" id="idactivo">
                        <center><h4><b>¿Desea programar mantenimiento y revisión?</b></h4></center><br>
                        <div class="row">
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="ultfechamtto">Fecha último Mantenimiento</label>  
                              <div class="col-md-5">
                              <input id="ultfechamtto" name="ultfechamtto" type="text" class="form-control input-md dateform" required value="<?php echo date('Y-m-d');?>" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" max="<?php echo date('Y-m-d');?>">
                              </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="ultfecharev">Fecha última Revisión</label>  
                              <div class="col-md-5">
                              <input id="ultfecharev" name="ultfecharev" type="text" class="form-control input-md dateform" required value="<?php echo date('Y-m-d');?>" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" max="<?php echo date('Y-m-d');?>">
                              </div>
                            </div>
                        </div>
                        <br>
                        <center>La revisión y mantenimiento serán programadas a partir de las fechas anteriores y con la frecuencia de éstas asignadas al activo</center>
                        <br><br>
                        <center><h4><b>Programación Automática del resto del año</b></h4> </center>
                        <div class="row">
                            <div class="form-group col-md-4 col-md-push-3" data-toggle="tooltip" data-placement="bottom" title="Seleccione si desea programar automaticamente las proximas revisiones del año a partir de la ultima fecha">
                                <label class="control-label">Revisiones</label><br>
                                <div class="pull-left">
                                  <div class="TriSea-technologies-Switch col-md-2">
                                      <input id="autorev" name="autorev" class="autorev" type="checkbox"/>
                                      <label for="autorev" class="label-primary"></label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-md-push-2" data-toggle="tooltip" data-placement="bottom" title="Seleccione si desea programar automaticamente los proximos mantenimientos del año a partir de la ultima fecha">
                                <label class="control-label">Mantenimientos</label><br>
                                <div class="pull-left">
                                  <div class="TriSea-technologies-Switch col-md-2">
                                      <input id="automtto" name="automtto" class="automtto" type="checkbox"/>
                                      <label for="automtto" class="label-primary"></label>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="genprog" type="submit" class="btn btn-success" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Generando...">Programar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal programacion -->

</div>

<style>
   .TriSea-technologies-Switch > input[type="checkbox"] {
          display: none;   
      }

      .TriSea-technologies-Switch > label {
          cursor: pointer;
          height: 0px;
          position: relative; 
          width: 40px;  
      }

      .TriSea-technologies-Switch > label::before {
          background: rgb(0, 0, 0);
          box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
          border-radius: 8px;
          content: '';
          height: 16px;
          margin-top: -8px;
          position:absolute;
          opacity: 0.3;
          transition: all 0.4s ease-in-out;
          width: 40px;
      }
      .TriSea-technologies-Switch > label::after {
          background: rgb(255, 255, 255);
          border-radius: 16px;
          box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
          content: '';
          height: 24px;
          left: -4px;
          margin-top: -8px;
          position: absolute;
          top: -4px;
          transition: all 0.3s ease-in-out;
          width: 24px;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
          background: inherit;
          opacity: 0.5;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
          background: inherit;
          left: 20px;
      }
</style>

<script>
  $("side-menu").children(".active").removeClass("active");
  $("#ACTIVOS").addClass("active");
  $("#ACTIVO").addClass("active");
</script>
<script>
    $(document).ready(function () {

        //Codigo agregado por Jaime
        $('[data-toggle="tooltip"]').tooltip();
        //Fin agregado

        $('#btn_usuarios').click(function () {
            $.ajax({
                url: "usuarios.php"
            }).done(function (html) {
                $('#contenido').html(html);
            }).fail(function () {
                swal('Error al cargar modulo');
            });
        });

        $(".dateform").datetimepicker({
            format: "YYYY-MM-DD",
            locale: "es",
        });
    });

    $("#listact").click(function(e){
        $(".detact").hide();
        $(".movact").hide();
        $(".revmtto").hide();
        $("#form_filtro")[0].reset();
    });

   

    function editar(id) {
        $('#detalles').html('');
        $.ajax({
            type: "POST",
            url: "update_activo.php",
            data: {operacion: 'update', id_act: id}
        }).done(function (html) {
            $('#detalles').html(html);
        }).fail(function () {
            swal('Error al cargar modulo');
        });
    }

    function movimiento(id){
        $("#movimientos").html('');
        $.ajax({
            type: "POST",
            url: "loadmovactivo.php",
            data: 'idact='+id,
            success:function(res){
                $("#movimientos").html(res);
            }
        });
    }

    function eliminar(id, este) {
        swal({
            title: "¿Seguro que desea eliminar este activo?",
            text: "",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"  
            },function () {
                $.ajax({
                type: "POST",
                url: "delete_act.php",
                data: {id_act: id, operacion: "delete"}
                }).done(function (res) {
                    if(res=='true'){
                        $('#listado').load('listactivo.php');
                    }else{
                        swal('error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente','error');
                    }
                
             }).fail(function () {
                    swal("Error enviando los datos. Intente nuevamente");
                });
        });
    }

    function paginar(id) {
        $.ajax({
            type: "POST",
            url: "paginate_act.php",
            data: {operacion: 'update', page: id}
        }).done(function (a) {
            $('#contenido').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }

    function paginarm(id) {
        $(".revmttoact").html('');
        var idact=$("#codigo").val();
        var fest=$("#filest").val();
        var ftpo=$("#filtipo").val();
        if($("#filhasta").val()!=''){    
            var filfe="'"+$("#fildesde").val()+"' and '"+$("#filhasta").val()+"'";
        }else{
            var filfe="";
        }
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&filestado='+fest+'&filtipo='+ftpo+'&idact='+idact+'&filfe='+filfe+'&page='+id,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
                $("#divreset").show();
            }
        })
    }

    function img (a){
        if (a != "default.jpg") {
            $('#photo').attr("src", "imagenes/activo/"+a);
        } else {
            $('#photo').attr("src", "imagenes/default.jpg");
        }
        $('#modal_img').modal('show');

    };

    $(document).ready(function() {
       $('#inputbuscar').keyup(function(){
            var name = $(this).val();        
            var dataString = 'nombre='+name;
            $('#listado').html('');
            $.ajax({
                type: "POST",
                url: "listactivo.php",
                data: dataString,
                success: function(data) {
                    $('#listado').html(data);
                    $("#listact").click();
                }
            });
        });   
    });

    function mostrarImagen(input) {

        var imagen = input.files[0];
        var stringImagen = imagen["type"].split("/");
        var tipoImagen = stringImagen[1];
        var tamanoImagen = imagen["size"];

        if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else{

            if (input.files && input.files[0]) {
              
                var reader = new FileReader();
              
                reader.onload = function (e) {
                    $('#imgact').attr('src', e.target.result);
                }
              
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    function loadrevmtto(idact){
        $(".revmttoact").html('');
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&idact='+idact,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    }
</script>
<script>
    $(document).on('click' , '.btnejecutarmv' , function(e){
        e.preventDefault();
        var idmov=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'opermovimiento.php',
            type:'POST',
            data:'opc=exemov&idmov='+idmov+'&idact='+idact,
            success:function(res){
                if(res=='true'){
                    movimiento(idact);
                    ubicacion(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                }
            }
        })
    });

    $(document).on('click' , '.btncancelarmv' , function(e){
        e.preventDefault();
        var idmov=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'opermovimiento.php',
            type:'POST',
            data:'opc=canmov&idmov='+idmov,
            success:function(res){
                if(res=='true'){
                    movimiento(idact);
                    ubicacion(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });

    $(document).on('click' , '.btncancelaract' , function(e){
        e.preventDefault();
        var idpgm=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=canact&idpgm='+idpgm,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });

    $(document).on('click' , '.btnejecutaract' , function(e){
        e.preventDefault();
        var idpgm=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=exeact&idpgm='+idpgm,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });



    function ubicacion(id) {
        $("#ubicact").html('');
        $.ajax({
            url: 'opermovimiento.php',
            type: 'POST',
            data:'opc=loadlugarea&id='+id,
            success: function(data){
                var datos = JSON.parse(data);
                $("#ubicact").html(datos.lugar);
                $("#ubicact").append(' - '+datos.area);
            }
        })
    }

    $("#form_prog").submit(function(e){
        e.preventDefault();
        var idact=$("#codigo").val();
        $("#idactivo").val(idact);
        var formdata=$(this).serialize();
        //console.log(formdata);
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=addrevmtto&'+formdata,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                    $("#modal_prog").modal('hide');
                    $("#automtto").prop('checked', false).change();
                    $("#autorev").prop('checked', false).change();
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','error');
                }
            }
        })
    });
</script>
<script>
    $('#revmtto').click(function(e){
        var idact=$("#codigo").val();
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=chkprog&idact='+idact,
            success:function(res){
                if(res=='false'){
                    $("#modal_prog").modal('show');
                }
            }
        }); 
    });
    $("#passmttosi").click(function(e){
        $("#ultfechamtto").removeAttr('readonly');
    });
    $("#passmttono").click(function(e){
        $("#ultfechamtto").attr('readonly','true');
        $("#ultfechamtto").val('<?php echo date('Y-m-d');?>');
    });

    $("#passrevsi").click(function(e){
        $("#ultfecharev").removeAttr('readonly');
    });
    $("#passrevno").click(function(e){
        $("#ultfecharev").attr('readonly','true');
        $("#ultfecharev").val('<?php echo date('Y-m-d');?>');
    });

    $("#modal_prog").on("hidden.bs.modal", function () {
        $("#autorev").prop('checked', false).change();
        $("#automtto").prop('checked', false).change();
        $("#genprog").button('reset');
    });
    
    $("#genprog").click(function(e){
        var $this = $(this);
        $this.button('loading');
    });
</script>
<script>//oper filtro mtto


    $("#filtipo").change(function(e){
        filtro();
    })

    $("#filest").change(function(e){
        filtro();
    })

    $("#fildesde").on('dp.change', function(e){
        $("#filhasta").removeAttr('disabled').focus().val('');
    });
    $("#filhasta").on('dp.change', function(e){
        var a = Date.parse($("#fildesde").val());
        var b = Date.parse($("#filhasta").val());
        var c = b-a;
        if(c<0){
            swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
            $("#filhasta").val('');
        }else{
            filtro();
        }
    });

    function filtro(){
        $(".revmttoact").html('');
        var idact=$("#codigo").val();
        var fest=$("#filest").val();
        var ftpo=$("#filtipo").val();
        if($("#filhasta").val()!=''){    
            var filfe="'"+$("#fildesde").val()+"' and '"+$("#filhasta").val()+"'";
        }else{
            var filfe="";
        }
        $.ajax({
            url:'revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&filestado='+fest+'&filtipo='+ftpo+'&idact='+idact+'&filfe='+filfe,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
                $("#divreset").show();
            }
        })
    }

    $("#resetfil").click(function(e){
        var idact=$("#codigo").val();
        loadrevmtto(idact);
        $("#divreset").hide();
    })
</script>
<script>//oper insumos
    $(document).on('click' , '.btndelins' , function(e){
        e.preventDefault();
        var idins=$(this).data('ins-id');
        var idact=$(this).data('act-id');

        swal({
            title: "¿Seguro que desea eliminar este insumo?",
            text: "Esta acción NO puede deshacerse, ni reversarse",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"  
            },function () {
                $.ajax({
                    url:'loadselact.php',
                    type:'POST',
                    data:'opc=delinsumo&idins='+idins+'&idact='+idact,
                    success:function(res){
                        if(res=='true'){
                            loadinsumos();
                        }else{
                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                        }
                    }
                })
        });        
    });

 $(document).ready(function() {
        conteoPermisos ();
});
</script>
</body>
</html>