<?php
include '../cnx_data.php';
include 'head.php';
VerificarPrivilegio("REPORTE BIOMETRICO", $_SESSION['tipo_u'], $conn);
include "librerias_js.php";
$today = date("Y-m-d");
?>

<div id="">

    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="inicio.php">Inicio</a></li>
                        <li class="active">
                            <span>Biometrico</span>
                        </li>
                        <li class="active">
                            <span>Reporte Individual</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Generar Reporte de Asistencia Individual
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

                        <div class="text-center m-b-md" id="wizardControl">

                            <button class="btn btn-primary" onclick="location.reload();" id="p1" data-toggle="tooltip" data-placement="top" title="">Paso 1 - Parametros del reporte</button>
                            <a class="btn btn-default" id="p2">Paso 2 - Procesando datos</a>
                            <a class="btn btn-default" id="p3">Paso 3 - Resultado Reporte</a>
                           <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a Excel" style="display:none;" id="expexcel"><span class="fa fa-file-excel-o" style="color:green;"></span></button>
                            <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a PDF" style="display:none;" id="exppdf"><span class="fa fa-file-pdf-o" style="color:red;"></span></button>

                        </div>

                        <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">

                            <div class="m-b-md" id="paso1">
                                <br>                          
                                    <div class="text-center m-b-md">
                                        <div class="form-group col-md-6 col-md-push-3">
                                            <div class="form-group col-md-6">
                                              <label for="fecha1">Desde: </label>
                                              <input type="text" class="form-control fecha text-center" id="fecha1" name="fecha1" value="Elija fecha" style="caret-color:white" >
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label for="fecha2">Hasta: </label>
                                              <input type="text" class="form-control fecha text-center" id="fecha2" name="fecha2" value="Elija fecha" style="caret-color:white" disabled>

                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <div class="form-group col-md-4 col-md-push-4">
                                              <label for="colaborador" class="col-md-12">Colaborador</label>
                                              <style>
                                                  .bigdrop .select2-results {max-height: 50px;}
                                                  
                                              </style>
                                              <select class="form-control gen bigdrop" name="colaborador" id="colaborador" data-error="Escoja un colaborador"  disabled>
                                                    <option value="0">-Seleccione colaborador-</option>
                                                    <?php
                                                    $result = $conn->query("SELECT distinct(pc.clbcodigo),t.trcrazonsocial from btyprogramacion_colaboradores pc
                                                                            join btycolaborador c on c.clbcodigo=pc.clbcodigo
                                                                            join btytercero t on t.trcdocumento=c.trcdocumento
                                                                            order by trcrazonsocial");
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {                
                                                            echo '<option value="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
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
                            <h4 class="text-center" id="encabezado">Reporte de asistencia </h4>
                                <div id="content" style="display:none;max-height: 300px;overflow-y: auto;">
                                </div>
                            </div>
    

                        </div>
                   
                </div>
            </div>
        </div>

    </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script>

    $("side-menu").children(".active").removeClass("active");  
    $("#BIOMETRICO").addClass("active");
    $(document).ready(function(){
         $("#colaborador").select2();
         $(".bigdrop .select2-results").css("max-height","60px")
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$("#fecha1").on('changeDate', function(e){
    $("#fecha2").removeAttr('disabled');
    $("#fecha2").val('');
    $("#fecha2").datepicker('show');
    $(this).datepicker('hide');
    $("#colaborador").val(0);
    $("#colaborador").attr('disabled', 'disabled');
    $("#siguiente").attr('disabled', 'disabled');
    $("#siguiente").removeClass('btn-lg');
    $("#siguiente").removeClass('bg-primary');
});
    
$("#fecha2").on('changeDate', function(e){
    var fecha1=$("#fecha1").val();
    var fecha2=$("#fecha2").val();
    var a = Date.parse(fecha1);
    var b = Date.parse(fecha2);
    var c=b-a;
    if(c<0){
        swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
        $("#fecha2").val('');
        $("#colaborador").attr('disabled', 'disabled');
    }else{
        $(this).datepicker('hide');
        $("#colaborador").removeAttr('disabled');
    }

});


$(".gen").change(function(e){
    $("#content").hide();
    $("#content").html('');
    var col=$("#colaborador option:selected").val();
    if(col!=0) {
        $("#siguiente").addClass('btn-lg');
        $("#siguiente").removeAttr('disabled');
        $("#siguiente").addClass('bg-primary');
    }
    else{
        $("#siguiente").attr('disabled', 'disabled');
        $("#siguiente").removeClass('btn-lg');
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
    var f1=$("#fecha1").val();
    var f2=$("#fecha2").val();
    var col=$("#colaborador option:selected").val();
    var coltxt=$("#colaborador option:selected").text();
    var datos='f1='+f1+'&f2='+f2+'&col='+col;
    $(".fecha").attr('disabled', 'disabled');
    $("#colaborador").attr('disabled', 'disabled');
    $.ajax({
        type:'POST',
        url:'biometrico/generar_reporte_individual.php',
        data:datos,
        beforeSend: function() 
            {
              $.blockUI({ message: null });
            },
        success:function(data){
            //console.log(res);
            $(document).ajaxStop($.unblockUI);
            $("#p1").attr('title','Click para regresar');
            //$('[data-toggle="tooltip"]').tooltip()
            $("#p1").attr('onclick','location.reload()');
            $("#paso2").hide();
            $("#loading").hide();
            $("#paso3").show();
            $("#p2").removeClass('btn-warning');
            $("#p2").addClass('btn-default');
            $("#p3").removeClass('btn-default');
            $("#p3").css('background-color','green');
            $("#p3").css('color','white');
            $("#encabezado").append(' '+coltxt+' del '+f1+' a '+f2);
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
        $("#content").append('<h2 class="text-center"><i class="fa fa-frown-o"></i><br>Ha ocurrido un error, recargue la página e intentelo nuevamente</h2>');
        $("#content").fadeIn(200);
    });
});
$("#exppdf").click(function(e){
    var opc='PDF';
    var f1=$("#fecha1").val();
    var f2=$("#fecha2").val();
    var col=$("#colaborador option:selected").val();
    var coltxt=$("#colaborador option:selected").text();
    var datos="opc="+opc+"&f1="+f1+"&f2="+f2+"&col="+col+"&coltxt="+coltxt;
    window.open('biometrico/asistencia_individualPDF.php?'+datos);
});
$("#expexcel").click(function(e){
    var opc='XLS';
    var f1=$("#fecha1").val();
    var f2=$("#fecha2").val();
    var col=$("#colaborador option:selected").val();
    var coltxt=$("#colaborador option:selected").text();
    var datos="opc="+opc+"&f1="+f1+"&f2="+f2+"&col="+col+"&coltxt="+coltxt;
    window.open('biometrico/asistencia_individualPDF.php?'+datos);
});

$(document).ready(function() {
    conteoPermisos ();
});

</script>
</body>
</html>