<?php 
    include("./head.php");
include "../cnx_data.php";

    VerificarPrivilegio("SESIONES", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
    include "librerias_js.php";
    
    $_SESSION['fch']="";
    $_SESSION['fc']="";
    $_SESSION['nave']="";
    $_SESSION['dispo']="";
    $_SESSION['nnom']="";
    $_SESSION['sesip']="";
    $_SESSION['actvv']="false";
    $_SESSION['fall']="false";

?>
 <div class="normalheader transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <!--barra lateral de ubicacion de los modulos, asignacion de la funcio active para ubicar el modulo sobre el cual se hizo click y al que pertenece la pagina-->
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>Módulo Usuarios</span>
                    </li>
                    <li class="active">
                        <span>Sesiones</span>
                    </li>
                </ol>
                
            </div>
              <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                <!-- grupo de formularios date picker para obtener las fechas -->
                    <div class="input-group">
                    <div class="col-lg-5">
			              Fecha Inicio:<input class ="form-control datepicker-input" type="text" id="fechin" name="fechin" > 
                    </div>
                    <div class="col-lg-5">
			              Fecha Fin: <input class ="form-control " type="text" id= "fechfin" name="fechfin">
                            
                    </div>  
                    <!-- grupo de botones para obtener los reporetes de excel y para generar las busquedas -->
                        <div class="input-group-btn"> 
                        <br>

                        <button id="buscar" name="buscar" class="btn btn-default" onclick="buscar_fecha($('#fechin').val(),$('#fechfin').val() ); "><i class="fa fa-search text-info"></i></button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnReporteExcel" data-placement="top" title="Reporte en Excel">
                                <span class="fa fa-file-excel-o text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnReportePdf" data-placement="bottom" title="Reporte en PDF">
                                <span class="fa fa-file-pdf-o text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnEnvioreporte" data-placement="bottom" title="Enviar reporte" onclick="$('#modalenviocorreo').modal('show')">
                                <span class=" text-success glyphicon glyphicon-envelope fa-1x"></span>
                            </button>

                        </div> 
                        <div class="input-group">

                        </div>
                    </div>
                </div>
                <!-- div de las busquedas avanzadas puesto sobre un link que ocupa todo el espacio al ser un help block -->

                <div class="col-lg-10 " > <br>&nbsp; &nbsp;<a onclick="$('#modalFiltrosAvanzados').modal('show')" > Busqueda avanzada</a>&nbsp; &nbsp;
                <a style="display:none" data-toggle="tooltip" title="Limpiar Filtros" id='sacar' class='  text-danger glyphicon glyphicon-remove-sign fa-1x' onclick='quitar()'></a>

					
                    
            </div>
          
                        
           
            
        </div>

    </div>
        
</div>
 <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modalenviocorreo">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Enviar al Correo</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                    <div class="form-group col-lg-6 ">
                    <div class="hpanel stats">
                    <br>
                    <div class="panel-heading hbuilt">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        Correos
                    </div>
                    <div class="panel-body list" style="display: none;">
                    <b>E-mails</b>
                        <div class="stats-icon pull-right">
                             <i class="pe-7s-mail fa-2x"></i>
                        </div>
                        <div class="m-t-xl">
                            <small>
                               <div class=" table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tbcorreo">
                            <tr>
                            </tr>
                            </table>
                            <br>
                            </div>
                            </small>
                        </div>
                    </div>
                    <div class="panel-footer" style="display: none;">
                    <button style="display:none" type="button" onclick="delet()" class="btn btn-default pe-7s-close" id="qtcr"></button>
                    </div>
                </div>
                    
                            
                        </div>
                         Direccion de Correo:

                        <div class="input-group col-lg-5">
                       
                         <input type="email" name="emailr" id="emailr" class="form-control" placeholder="Adicionar...">

                           <span class="input-group-btn">

                                <button onclick="adcc()" class="btn btn-default" type="button"><i class="glyphicon glyphicon-plus small"></i> </button>
                           </span>
                    </div>
                    <br>
                    <label class="checkbox-inline"><input  type="checkbox" id="rptf"  name="rptf" value="" disabled="">PDF</label>&nbsp;&nbsp;
                            <label class="checkbox-inline"><input  type="checkbox" id="rptx" name="rptx" value="" disabled="">Excel</label>  
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" onclick="env()" class="btn btn-default " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Enviar</span></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal de filtros avanzados que contiene toda la informacion que se va a recolectar sobre la consulta avanzasada de usuarios -->
 <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modalFiltrosAvanzados">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Busqueda avanzada</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label data-toggle='tooltip' title='Presione CTRL para seleccionar o quitar'>Navegador</label>
                            <select id="Filtronav" class="form-control" multiple>
                                <?php
                                include 'conexion.php';
                                //se obtinene los valores presentees en las tablas de los navegadores con los cuales se ha ingresado alguna vez al sistema
                                $sql = "SELECT DISTINCT `sesnavegador` FROM `btysesiones`";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option  value='".$row['sesnavegador']."'>".$row['sesnavegador']."</option>";
                                    }
                                }

                                 ?>
                            </select>
                        </div>
                          <div class="form-group col-lg-3">
                            <label data-toggle='tooltip' title='Presione CTRL para seleccionar o quitar'>Dispositivo</label>
                            <select  id="Filtrodisp" class="form-control" multiple>
                                <?php
                                //se obtienen los dispositivos con los cuales alguna vez se ha inciado sesion 
                                $sql = "SELECT DISTINCT `sestipodispotivo` FROM `btysesiones`";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option  value='".$row['sestipodispotivo']."'>".$row['sestipodispotivo']."</option>";
                                    }
                                }

                                 ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label>Usuario</label>
                            <input type="text" id="busqnom" name="busqnom" class="form-control">
                            
                        </div>
                        <div class="form-group col-lg-3">
                            <label>IP</label>
                            <input type="text" id="busqip" name="busqip" class="form-control">
                            
							
                        </div>

                        
                    </div>
                    <div class="center-block">
                            <label class="checkbox-inline"><input onclick="cheking()" type="checkbox" id="dsct"  name="dsct" value="">Desconectado</label>
                            <label class="checkbox-inline"><input onclick="cheking()" type="checkbox" id="actv" name="actv" value="">Activo</label> 
                            <label class="checkbox-inline"><input onclick="cheking()" type="checkbox" id="fall"  name="fall" value="">Fallido</label>
                            <label class="checkbox-inline"><input onclick="cheking()" type="checkbox" id="ctainv"  name="ctainv" value="">Contraseña invalida</label>
                         </div> 
                    
 
                </div>


                <div class="modal-footer">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
   <!-- form here..-->  
   <!--  la division que contiene la tabla que muestra los datos.-->
<div style="display:none" id="contenido" class="content animated-panel">
            <?php include"find_sesion.php" ?>
        </div>
</div>
    <!-- Right sidebar -->
    

    <!-- Footer-->

<!-- inclusion de los scripts -->

 
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script>

  $("side-menu").children(".active").removeClass("active");
  $("#USUARIOS").addClass("active");
  $("#SESIONES").addClass("active");
  </script>

 <script>
 var i=0;
   var arr1 = [];
$( window ).unload(function() {
  return "Bye now!";
});
$(document).ready(function () {

    //el toogle es la animacion para los comentarios flotantes
    $('[data-toggle="tooltip"]').tooltip();
    //Fin agregado

    $('#btn_usuarios').click(function () {
        $.ajax({
            url: "usuarios.php"
        }).done(function (html) {
            $('#contenido').html(html);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    });
});
//funcion de paginar que se comunica con el archivo find_sesion mediante ajax
function paginar(id) {
    $.ajax({
        type: "POST",
        url: "find_sesion.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}

//funcion para obtener las letras que se van pulsando en un input e ir buscando en find sesion, esta funcion esta descontinuado por la vista
 $(document).ready(function() {
   $('#inputbuscar').keyup(function(){
        var username = $(this).val();        
        var dataString = 'busque='+username;

        $.ajax({
            type: "POST",
            url: "find_sesion.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });   
});
 //exclusion de la casilla activos con la casilla fallos de las busquedas avanzadas
 /*
 $("#actv").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $('#fall').removeAttr('checked')
    }
});
  $("#fall").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $('#actv').removeAttr('checked')
    }
});
*/
  //funcion que transpasa las fechas y los datos de las busquedas avanzadas al archivo find para empezar a hacer la consulta de la busqueda 
function buscar_fecha(f1, f2) {

    var fechahoy= new Date();
    if(f1=="" || f2=="" ){
        swal("¡Las Fechas Estan Vacias! ");
    }else if(f1 > f2){
        sweetAlert("Error", "¡La fecha de incio no debe ser mayor que la final!", "error");
    //}else if (f1> ('0'+fechahoy.toLocaleDateString("en-US")) || f2>('0'+fechahoy.toLocaleDateString("en-US")) ) {
        swal("¡No digite fechas futuras o invalidas!");
    } else{
         b='si';
         $('#sacar').show();
         $('#contenido').show();
         $('#rptx').removeAttr('disabled');
            $('#rptf').removeAttr('disabled');
    $.ajax({
        type: "POST",
        url: "find_sesion.php",
        //modo de envio de datos por medio de ajax
        data: 'fchi='+f1 + '&fchf='+f2 + '&nav='+$('#Filtronav').val()+ '&disp='+$('#Filtrodisp').val()+ '&nom='+$('#busqnom').val()+ '&ip='+$('#busqip').val()+ '&fall='+$('#fall').is(':checked') + '&act='+$('#actv').is(':checked')+'&busq='+b +'&desc='+$('#dsct').is(':checked') +'&cont='+$('#ctainv').is(':checked')
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        swal('Error al cargar modulo');
    });
}
}
//funcion para vaciar las variables de sesion que contienen las busquedas para que la paginacion no reinicie las variables .
function quitar(){
    var q= 'si';

    b="";
    $('#fechin').val('');
    $('#fechfin').val('');
    $('#busqnom').val('');
    $('#busqip').val("");
    $('#Filtronav').val("");
    $('#Filtrodisp').val("");
    $('#actv').removeAttr('checked');
    $('#fall').removeAttr('checked');
    $('#dsct').removeAttr('checked');
    $('#ctainv').removeAttr('checked');
    $('#sacar').hide();
    $('#contenido').hide();
    $.ajax({
        type: "POST",
        url: "find_sesion.php",
        data:'vaciar='+q
        }).done(function (a) {
            $('#contenido').html(a);
    }).false(function () {
        swal('Error al cargar modulo');
    });
}

$("#btnReporteExcel").on("click", function(){
        if (b=='si') {
        window.open("./ReporteSesiones.php?dato=" +  "&tipoReporte=excel");
        }else{
       sweetAlert("Error", "No hay datos para exportar. Ningun archivo se ha generado!", "error");
        }
        
});

    $("#btnReportePdf").on("click", function(){
        if (b=='si') {
        window.open("./ReporteSesiones.php?dato=" + "&tipoReporte=pdf");
        }else{
         sweetAlert("Error", "No hay datos para exportar. Ningun archivo se ha generado!", "error");
        }
    }); 
    $('#rptf').on("click", function(){
            if (b=='si') {
             $.ajax({
                 async: false,
                 type: "POST",
                 url: "ReporteSesiones.php",
                 data: {
                     envio: 1
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
            }else{
            sweetAlert("Error", "No hay datos para exportar. Ningun archivo se ha generado!", "error");
            }
        }); 
      $('#rptx').on("click", function(){
            if (b=='si') {
           $.ajax({
                 async: false,
                 type: "POST",
                 url: "ReporteSesiones.php",
                 data: {
                     enviox: 1
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });

            }else{
            sweetAlert("Error", "No hay datos para exportar. Ningun archivo se ha generado!", "error");
            }
        }); 

$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#fechin").datepicker({
maxDate: "0D",
dateFormat: 'yy-mm-dd'
});
$("#fechfin").datepicker({
maxDate: "0D",
dateFormat: 'yy-mm-dd'
});
});
$("#Filtronav").datepicker();
 
 function adcc () {
  
    if (i<=4) {

        arr1[i]=($('#emailr').val());
       var table = document.getElementById("tbcorreo");
            {
              var row = table.insertRow(0);
              var cell1 = row.insertCell(0);
              cell1.innerHTML = arr1[i];

  }
  $('#qtcr').show();
  $('#emailr').val('');
     i++;
 }else{

    swal("¡Los sentimos solo son adminitidos 5 Correos!")
 }
 
 }
 function env () {
    i=0;
    var tipey
    var tipex
    $('#qtcr').hide();
    $('#tbcorreo').empty();
    $('#emailr').val('');
    $('#rptx').removeAttr('checked');
    $('#rptf').removeAttr('checked');
 $.ajax({
 async: false,
 type: "POST",
 url: "enviar_por_correo.php",
 data: {
     correos: arr1
 },
 success: function(data) {
  swal("Mensaje", data+"!")
 }
});
 arr1=[];
 } 
 function delet() {
   
            swal({
      title: "Estas seguro?",
      text: "Desea remover el ultimo correo adicionado ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, Borrar!",
      closeOnConfirm: false
  
    },

    function(){
        var quit=arr1.pop();
        if (quit!=null) {  
      swal("Deleted!", "El Correo "+quit+" fue removido", "success");
      document.getElementById("tbcorreo").deleteRow(0);
      i--;
        }else{
            $('#qtcr').hide();
            ver=0;
            swal("Error", "No hay correos por Remover");
            showCancelButton: false;
              }
    });
 }
/*$(window).on('mouseover', (function () {
    alert("encima de ?");
    window.onbeforeunload = null;
}));
$(window).on('mouseout', (function () {
    window.onbeforeunload = ConfirmLeave;
     alert("fuera de ?");
}));*/
function ConfirmLeave() {
    return "";
}
var prevKey="";
$(document).keydown(function (e) {            
    if (e.key=="F5") {
        alert('recarga con f5');
        window.onbeforeunload = ConfirmLeave;
    }
    else if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") { 
        alert('postback');              
        window.onbeforeunload = ConfirmLeave;   
    }
    else if (e.key.toUpperCase() == "R" && prevKey == "CONTROL") {
        alert('no se que es esto');
        window.onbeforeunload = ConfirmLeave;
    }
    else if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
        alert('salida por f4');
        window.onbeforeunload = ConfirmLeave;
    }
    prevKey = e.key.toUpperCase();
});

/*function cheking () {
    $("#dsct").on( 'change', function() {
    if( $(this).is(':checked') ) {
        // Hacer algo si el checkbox ha sido seleccionado
        alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
    }
});
   
}*/

 $(document).ready(function() {
    conteoPermisos ();
});
</script>
 </body>
 </html>