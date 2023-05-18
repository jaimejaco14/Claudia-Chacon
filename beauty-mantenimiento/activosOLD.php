<?php 
    include("head.php");
    include("../cnx_data.php");
    include "librerias_js.php";
    VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();  

 
?>

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Activos</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="input-group">
                          <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre o código del activo">
                          <div class="input-group-btn">
                              <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                              <a href="new_activo.php"><button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nuevo activo"><i class="fa fa-plus-square-o text-info"></i></button></a>
                              <button id="btnexcel" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Exportar activos a Excel"><i class="fa fa-file-excel-o text-info"></i></button>
                              <!-- <button id="btnpdf" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Exportar activos a PDF"><i class="fa fa-file-pdf-o text-info"></i></button> -->
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
                            <?php include 'php/listactivo.php'; ?>
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


        $('[data-toggle="tooltip"]').tooltip();


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
                url: "php/delete_act.php",
                data: {id_act: id, operacion: "delete"}
                }).done(function (res) {
                    if(res=='true'){
                        $('#listado').load('php/listactivo.php');
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
            url: "php/listactivo.php",
            data: 'page='+id,
        }).done(function (a) {
            $('#listado').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
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
                url: "php/listactivo.php",
                data: dataString,
                success: function(data) {
                    $('#listado').html(data);
                    $("#listact").click();
                }
            });
        });   
    });   

    $("#btnexcel").click(function(e){
      var opc='XLS';
      window.open("php/reporteactivos.php?opc="+opc);
    })
    $("#btnpdf").click(function(e){
      //var opc='PDF';
     // window.open("php/reporteactivos.php?opc="+opc);
    })
</script>



</body>
</html>