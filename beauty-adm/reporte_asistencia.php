<?php
//include '../cnx_data.php';
//include 'head.php';
VerificarPrivilegio("REPORTE BIOMETRICO", $_SESSION['tipo_u'], $conn);
//include "librerias_js.php";
?>

<div id="">

    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li class="active">
                            <span>Herramientas</span>
                        </li>
                        <li class="active">
                            <span>Reporte de asistencia</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Generar Reporte de Asistencia
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
                                                <select class="form-control gen" name="salon" id="salon" data-error="Escoja una opcion" required>
                                                    <option value="0">-Seleccione salón-</option>
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
                            <h4 class="text-center" id="encabezado">Reporte de asistencia </h4>
                                <div id="content" style="display:none;">
                                </div>
                            </div>
    

                        </div>
                   
                </div>
            </div>
        </div>

    </div>
    </div>
</div>
<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(".gen").change(function(e){
    $("#content").hide();
    $("#content").html('');
    var mes=$("#mes option:selected").val();
    var salon=$("#salon option:selected").val();
    if(mes!=0 && salon!=0){
        $("#siguiente").addClass('btn-lg')
        $("#siguiente").removeAttr('disabled');
        $("#siguiente").addClass('bg-primary');
        //$( "#siguiente" ).effect( "bounce" ); 
    }
    else{
        $("#siguiente").attr('disabled', 'disabled');

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
    var salon=$("#salon option:selected").val();
    var salontxt=$("#salon option:selected").text();
    var datos='mes='+mes+'&salon='+salon;
    $("#mes").attr('disabled', 'disabled');
    $("#salon").attr('disabled', 'disabled');
    $.ajax({
        type:'POST',
        url:'generar_reporte.php',
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
            $("#encabezado").append(' '+mestxt+' - '+salontxt);
            $("#content").append(data);
            $("#content").fadeIn(200);
            $("#mes").removeAttr('disabled');
            $("#salon").removeAttr('disabled');
            $(".exportbtn").show();//activa botones excel y PDF

        }

    });
});
$("#exppdf").click(function(e){
    var mes=$("#mes option:selected").val();
    var mestxt=$("#mes option:selected").text();
    var salon=$("#salon option:selected").val();
    var salontxt=$("#salon option:selected").text();
    window.open('export_asistencia.php?opc=PDF&mes='+mes+'&salon='+salon+'&mestxt='+mestxt+'&salontxt='+salontxt);
});
$("#expexcel").click(function(e){
    var mes=$("#mes option:selected").val();
    var mestxt=$("#mes option:selected").text();
    var salon=$("#salon option:selected").val();
    var salontxt=$("#salon option:selected").text();
    window.open('export_asistencia.php?opc=EXCEL&mes='+mes+'&salon='+salon+'&mestxt='+mestxt+'&salontxt='+salontxt);
});



</script>
</body>
</html>