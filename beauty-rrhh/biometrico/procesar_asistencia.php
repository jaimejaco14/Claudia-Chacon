<?php
include '../head.php';
VerificarPrivilegio("REPORTE BIOMETRICO", $_SESSION['tipo_u'], $conn);
include "../librerias_js.php";
?>

<div id="">

    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="../inicio.php">Inicio</a></li>
                        <li class="active">
                            <span>Biométrico</span>
                        </li>
                        <li class="active">
                            <span>Procesar asistencia</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Procesar Asistencia
                </h2>
            </div>
        </div>
    </div>

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <button class="pull-right btn btn-default" id="btnlogs" data-toggle="tooltip" data-placement="left" title="Historial de procesamiento"><i class="fa fa-history text-info"></i></button>
                        <div class="text-center m-b-md" id="wizardControl">

                            <button class="btn btn-primary" onclick="location.reload();" id="p1" data-toggle="tooltip" data-placement="top" title="">Paso 1 - Parametros de proceso</button>
                            <a class="btn btn-default" id="p2">Paso 2 - Procesando datos</a>
                            <a class="btn btn-default" id="p3">Paso 3 - Resultado Proceso</a>
                            <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a Excel" style="display:none;" id="expexcel"><span class="fa fa-file-excel-o" style="color:green;"></span></button>
                            <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a PDF" style="display:none;" id="exppdf"><span class="fa fa-file-pdf-o" style="color:red;"></span></button>

                        </div>

                        <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">

                            <div class="m-b-md" id="paso1">
                                <h4 class="text-center">Seleccione mes y salón</h4>
                                <br>                          
                                    <div class="text-center m-b-md">
                                        <div class="form-group col-md-8 col-md-push-4">
                                            <label for="mes" class="col-md-1">Mes</label>
                                            <div class="col-md-4">
                                                <select name="mes" id="mes" class="form-control gen" required>
                                                    <option value="0">-Seleccione mes-</option>
                                                    <option value="1">ENERO</option>
                                                    <option value="2">FEBRERO</option>
                                                    <option value="3">MARZO</option>
                                                    <option value="4">ABRIL</option>
                                                    <option value="5">MAYO</option>
                                                    <option value="6">JUNIO</option>
                                                    <option value="7">JULIO</option>
                                                    <option value="8">AGOSTO</option>
                                                    <option value="9">SEPTIEMBRE</option>
                                                    <option value="10">OCTUBRE</option>
                                                    <option value="11">NOVIEMBRE</option>
                                                    <option value="12">DICIEMBRE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- </div>
                                        <div class="form-group col-md-3 col-md-push-3"> -->
                                        <div class="form-group col-md-8 col-md-push-4">
                                            <label for="salon" class="col-md-1">Salón</label>
                                            <div class="col-md-4">
                                                <select class="form-control gen" name="salon[]" id="salon" data-error="Escoja una opcion" multiple="multiple" required>
                                                    <?php
                                                    $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon ORDER BY slnnombre");
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {                
                                                            echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
                                                        }
                                                    }
                                                    $conn->close();
                                                    ?>
                                                </select>  
                                            </div>     
                                        </div> 
                                        
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <button class="btn pull-right" id="siguiente" disabled data-toggle="tooltip" data-placement="top" title="Siguiente"><span class="fa fa-chevron-circle-right" style=""></span></button>
                                    </div> 
                                
                            </div>
                            <div id="paso2" style="display:none;">
                                <div id="loading" style="display:none;">
                                    <center>
                                          <h1 id="insmsje">Generando reporte...</h1><br>
                                          <small>Si es la primera vez que lo genera, tomará mas tiempo mientras procesamos la informacion.</small><br>
                                          <style>
                                          /*style para la animacion del engranaje pequeño en reversa*/

                                              .fa-spin2 {
                                                transform: scaleX(-1);
                                                animation: spin-reverse 2s infinite linear;
                                              }
                                              @keyframes spin-reverse {
                                                0% {
                                                  transform: scaleX(-1) rotate(-360deg);
                                                }
                                                100% {
                                                  transform: scaleX(-1) rotate(0deg);
                                                }
                                              }
                                          </style>
                                          <i class="fa fa-cog fa-spin" style="font-size:100px;color:lightblue"></i><i class="fa fa-cog fa-spin2" style="font-size:50px;color:#FA9B3C"></i>
                                          <br><i class="fa fa-cog fa-spin2" style="font-size:50px;color:#FFFF99;margin-top: -10px !important;"></i>
                                          <br>
                                    </center>
                                </div>
                            </div>
                            <div id="paso3" style="display:none;">
                            <h4 class="text-center" id="encabezado">Resultado procesamiento de asistencia mes:</h4>
                                <div id="content" style="display:none;max-height: 350px;overflow-y: auto;">
                                </div>
                            </div>
    

                        </div>
                   
                </div>
            </div>
        </div>

    </div>
    </div>
</div>
<div id="modallogs" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content"> 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title">Historial Procesamiento de asistencia</h5> 
                
            </div> 
            <div class="modal-body">
            <h4>Filtrar por fecha</h4>
            <div class="row">
                <div class="form-group col-md-1">
                    <h5 class="text-center">De:</h5>
                </div>
                <div class="form-group col-md-4">
                  <input type="text" class="form-control fecha text-center" id="fecha1" name="fecha1" value="<?php echo date("Y-m-d");?>" style="caret-color:white" >
                </div>
                <div class="form-group col-md-1">
                    <h5 class="text-center">A:</h5>
                </div>
                <div class="form-group col-md-4">
                  <input type="text" class="form-control fecha text-center" id="fecha2" name="fecha2" value="<?php echo date("Y-m-d");?>" style="caret-color:white">
                </div>
                <div class="form-group col-md-2">
                  <button class="btn btn-primary" id="btnfilter" disabled=""><span class="fa fa-filter"></span></button>
                </div>
            </div>
            <div id="detallemodallogs"></div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<script>
$("side-menu").children(".active").removeClass("active");  
$("#BIOMETRICO").addClass("active");
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});


$("#salon").select2({
    placeholder: "Todos los salónes"
});

$(".gen").change(function(e){
    $("#content").hide();
    $("#content").html('');
    var mes=$("#mes option:selected").val();
    var salon=$("#salon").val();
    if(mes!=0){
        $("#siguiente").addClass('btn-lg')
        $("#siguiente").removeAttr('disabled');
        $("#siguiente").addClass('bg-primary');

    }
    else{
        $("#siguiente").attr('disabled', 'disabled');
        $("#siguiente").removeClass('btn-lg')
        $("#siguiente").removeClass('bg-primary');

    }
});

$("#siguiente").click(function(e){
    e.preventDefault();
    $("#p1").prop('onclick',null).off('click');
    $(this).attr('disabled', 'disabled');
    $("#paso1").hide();
    $("#paso2").show();
    $("#p1").removeClass('btn-primary');
    $("#p1").addClass('btn-default');
    $("#p2").removeClass('btn-default');
    $("#p2").addClass('btn-warning');
    $("#loading").show();
    var mes=$("#mes option:selected").val();
    var mestxt=$("#mes option:selected").text();
    var salon=$("#salon").val();
    var salontxt=$("#salon option:selected").text();
    var datos='mes='+mes+'&salon='+salon;
    console.log(datos);
    $("#mes").attr('disabled', 'disabled');
    $("#salon").attr('disabled', 'disabled');
    $.ajax({
        type:'POST',
        url:'procesar_biometrico.php',
        data:datos,
        beforeSend: function() 
            {
              $.blockUI({ message: null });
            },

        success:function(data){
            //console.log(res);
            $(document).ajaxStop($.unblockUI);
            $("#p1").attr('title','Click para regresar');
            $("#p1").attr('onclick','location.reload()');
            $("#paso2").hide();
            $("#loading").hide();
            $("#paso3").show();
            $("#p2").removeClass('btn-warning');
            $("#p2").addClass('btn-default');
            $("#p3").removeClass('btn-default');
            $("#p3").css('background-color','green');
            $("#p3").css('color','white');
            $("#encabezado").append(' '+mestxt);
            $("#content").append(data);
            $("#content").fadeIn(200);
            $("#mes").removeAttr('disabled');
            $("#salon").removeAttr('disabled');
            $(".exportbtn").show();//activa botones excel y PDF

        }

    }).fail( function( jqXHR, textStatus, errorThrown ) {
        $(document).ajaxStop($.unblockUI);
        $("#paso2").hide();
        $("#loading").hide();
        $("#paso3").show();
        $("#p2").removeClass('btn-warning');
        $("#p2").addClass('btn-default');
        $("#p3").removeClass('btn-default');
        $("#p3").css('background-color','green');
        $("#p3").css('color','white');
        $("#content").append('<h2 class="text-center">Ha ocurrido un error, recargue la página e intentelo nuevamente</h2>');
        $("#content").fadeIn(200);
    });
});
$("#exppdf").click(function(e){
    var mes=$("#mes option:selected").val();
    var mestxt=$("#mes option:selected").text();
    var salon=$("#salon").val();
    var salontxt=$("#salon option:selected").text();
    window.open('export_asistencia.php?opc=PDF&mes='+mes+'&salon='+salon+'&mestxt='+mestxt+'&salontxt='+salontxt);
});
$("#expexcel").click(function(e){
    var mes=$("#mes option:selected").val();
    var mestxt=$("#mes option:selected").text();
    var salon=$("#salon").val();
    var salontxt=$("#salon option:selected").text();
    window.open('export_asistencia.php?opc=EXCEL&mes='+mes+'&salon='+salon+'&mestxt='+mestxt+'&salontxt='+salontxt);
});


/**********************************************************LOGS**********************************************************************/
$("#btnlogs").click(function(e){
    $("#detallemodallogs").load('modallogspro.php');
    $("#modallogs").modal('show');
});

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

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

$(".fecha").css('cursor', 'pointer');

$("#fecha1").on('changeDate', function(e){
    $(this).datepicker('hide');
    $("#fecha2").val('');
});
    
$("#fecha2").on('changeDate', function(e){
    var fecha1=$("#fecha1").val();
    var fecha2=$("#fecha2").val();
    var a = Date.parse(fecha1);
    var b = Date.parse(fecha2);
    var c = b-a;
    if(c<0){
        swal('Error!','La fecha final debe ser posterior a la fecha inicial','error');
        $("#fecha2").val('');
        $("#btnfilter").attr('disabled', 'disabled');
    }else{
        $(this).datepicker('hide');
        $("#btnfilter").removeAttr('disabled');
    }
});

$("#btnfilter").click(function(e){
        var desde=$("#fecha1").val();
        var hasta=$("#fecha2").val();
        $.ajax({
            url:'filtroprocess.php',
            type:'POST',
            data:'desde='+desde+'&hasta='+hasta,
            success:function(res){
                $("#detallemodallogs").html('');
                $("#detallemodallogs").html(res);
            }
        });
    });


$(document).ready(function() {
    //conteoPermisos ();
});

</script>
</body>
</html>