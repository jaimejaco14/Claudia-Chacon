<?php
include 'conexion.php';
include 'head.php';
VerificarPrivilegio("CARGAR CSV", $_SESSION['tipo_u'], $conn);
include "librerias_js.php";
?>

<!-- Main Wrapper -->

<div id="">

      <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li class="active">
                            <span>Biométrico</span>
                        </li>
                        <li class="active">
                            <span>Cargar CSV</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Cargar Archivo CSV
                </h2>
            </div>
        </div>
    </div>

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body"><br>
                <button class="pull-right btn btn-default" id="btnlogs" data-toggle="tooltip" data-placement="left" title="Historial de carga"><i class="fa fa-history text-info"></i></button>

                        <div class="text-center m-b-md" id="wizardControl">

                            <a class="btn btn-primary btnpasos" href="#step1" data-toggle="tab" id="p1">Paso 1 - Cargar archivo</a>
                            <a class="btn btn-default btnpasos" href="#step2" data-toggle="tab" id="p2">Paso 2 - Detalles del archivo</a>
                            <a class="btn btn-default btnpasos" href="#step3" data-toggle="tab" id="p3">Paso 3 - Resultado</a>
                        </div>

                        <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">
                            <form action="importar.php" method="POST" enctype="multipart/form-data" role="form" id="formul">     
                                <div class="col-xs-12">
                                    <div class="hpanel" style="display:none;" id="iconoexcel">
                                        <div class="panel-body file-body">
                                            <i class="fa fa-file-excel-o" style="color:green;"></i>
                                        </div>
                                        <div class="panel-footer">
                                            <h4 id="nomarchivo" class="text-center"></h4>
                                        </div>
                                        <div style="display:none;" id="loading"><center><span class="fa fa-gear fa-spin" style="font-size: 50px; color:#3399FF;"></span><br>Cargando archivo...</center></div>
                                    </div>
                                    <!-- <div id="mensaje">
                                        <h3 class="text-center"><span class="fa fa-arrow-down"></span> Arrastrar archivo CSV aquí <span class="fa fa-arrow-down"></span></h3>
                                        <center><small class="text-center">O haga click sobre el area para buscar el archivo</small></center>
                                    <div> -->
                                    <div id="area" class="area" style="align-items: center;border: 3px dashed #aaa;border-radius: 5px;color: #555;display: flex;flex-flow: column nowrap;font-size: 15px;height: 40vh;justify-content: center;max-height: 400px;margin: 30px auto;overflow: auto;text-align: center;white-space: pre-line;width: 80%;max-width: 600px;">

                                        <i class="fa fa-cloud-upload" style="font-size:40px;"></i>
                                        <small id="msj1">Arrastre archivo CSV aquí</small>
                                        <small id="msj2" class="text-center">O haga click para buscar el archivo</small>
                                          
                                        <input type="file" id="files" name="archivoCSV" class="form-control uploader" required />
                                    </div>
                                    <style>
                                        .dragging {
                                          background-color: rgba(255, 255, 0, .3);
                                          background-color:lightblue;
                                        } 
                                        .uploader{
                                            opacity: 0;
                                            height:100%;
                                            width:100%;
                                            padding:0%;

                                            z-index:0;
                                            position:absolute;
                                        }
                                    </style>
                                </div>
                            </form>


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
                <h5 class="modal-title">Historial de carga de archivos CSV</h5> 
                
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
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$("side-menu").children(".active").removeClass("active");  
$("#BIOMETRICO").addClass("active");
    /*******************************************************************************************/
    $(".btnpasos").bind('click', false);
    $(".prevnext").bind('click', false);


/******************************************************************************************************/

    $("#nextp1").click(function(e){
        if(!$(this)[0].hasAttribute("disabled")){
            $('#p1').removeClass('btn-primary');
            $('#p1').addClass('btn-default');
            $('#p2').removeClass('btn-default');
            $('#p2').addClass('btn-primary');
         }
    });
    
    $("#files").change(function(e){
        var ext = $("#files").val();
        var aux = ext.split('.');
        $("#nomarchivo").text(this.files[0].name);
        if(aux[aux .length-1] == 'csv') {
           //console.log('ok');
           $("#mensaje").hide();
           $("#loading").show();
           $("#area").hide();
           $("#iconoexcel").show();
            //$("#prevp1").removeAttr('disabled');
            //$("#submit").removeAttr('disabled');
            $("#formul").submit();
        }else{
            $("#area").removeClass('dragging');
            swal("ERROR","Tipo de archivo NO admitido","error");
            $("#formul")[0].reset();
            $("#msj1").html('Arrastre archivo CSV aquí');
            $("#msj2").show();
        }
        
    });



  
/**************************************************************/
var dropzone = document.getElementById('area');
var  fileInput = document.getElementById("files");
var  body = document.getElementById("body");

dropzone.ondragover = function(e){e.preventDefault(); 
  dropzone.classList.add('dragging');
  $("#msj1").html('Suelte el archivo aquí!');
  $("#msj2").hide();
 }
dropzone.ondrop = function(e){ onDragOver(e); } 

function onDragOver(e) {
    fileInput.files = e.dataTransfer.files;
} 
dropzone.addEventListener('dragleave', () => {
  dropzone.classList.remove('dragging');
  $("#msj1").html('Arrastre archivo CSV aquí');
  $("#msj2").show();
});  
/***************************************************************/

$("#btnlogs").click(function(e){
    $("#detallemodallogs").load('biometrico/modallogs.php');
    $("#modallogs").modal('show');
});

$("#btnfilter").click(function(e){
        var desde=$("#fecha1").val();
        var hasta=$("#fecha2").val();
        $.ajax({
            url:'biometrico/filtrocsv.php',
            type:'POST',
            data:'desde='+desde+'&hasta='+hasta,
            success:function(res){
                $("#detallemodallogs").html('');
                $("#detallemodallogs").html(res);
            }
        });
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

$(document).ready(function() {
    conteoPermisos ();
});
    
</script>

</body>
</html>