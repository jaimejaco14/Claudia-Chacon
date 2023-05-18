<?php
  include("./head.php");
  include("../cnx_data.php");

  VerificarPrivilegio("CLIENTES (PDV)", $_SESSION['PDVtipo_u'], $conn);
  RevisarLogin();
    
  $cod_salon = $_SESSION['PDVslncodigo'];
  $salon     = $_SESSION['PDVslnNombre'];
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
                    
                    <li><a href="inicio.php  ">Inicio</a></li>
                    <li>
                        <span>Módulo Clientes</span>
                    </li>
                    <li class="active">
                        <a href="cliview.php"><span>Clientes</span></a>
                    </li>
                </ol>
            </div>
            
            <div class="col-md-9">
              <div class="row">
                  <div class="col-lg-12">
                    <div class="input-group">
                        <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre o documento del cliente">
                        <div class="input-group-btn">
                            

                            <button id="busca" name="busca" class="btn btn-default" onclick="$('#modalFiltrosAvanzados').modal('show')"><i class="fa fa-search text-info"></i></button>
                            <!-- <a href="nuevo_cliente.php"><button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nuevo cliente"><i class="fa fa-plus-square-o text-info"></i>
                                </button></a> -->
                            <button id="btnReporteExcel" type="button" data-toggle="tooltip" data-placement="top" title="Reporte en Excel" class="btn btn-default">
                              <span class="fa fa-file-excel-o text-info"></span>
                            </button>
                            <button type="button" id="btnReportePdf" data-toggle="tooltip" data-placement="bottom" title="Reporte en PDF" class="btn btn-default">
                              <span class="fa fa-file-pdf-o text-info"></span>
                            </button>
                            <button type="button" id="btnCompartirWhatsapp" data-toggle="tooltip" data-placement="bottom" title="Compartir Whatsapp" class="btn btn-default">
                              <span class="fa fa-whatsapp text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnEnvioreporte" data-placement="bottom" title="Enviar reporte" onclick="$('#modalenviocorreo').modal('show')">
                                  <span class=" text-success glyphicon glyphicon-envelope fa-1x"></span>
                              </button>

                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>

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
                          <div class="form-group col-lg-4">
                              <label>G&eacute;nero</label>
                              <select id="FiltroSexo" name="FiltroSexo" class="form-control">
                                  <?php
                          
                                  $sql = "SELECT DISTINCT `clisexo` FROM `btycliente`";
                                  $result = $conn->query($sql);
                                  if ($result->num_rows > 0) {
                                      echo "<option value='0'>--Todos--</option>";
                                      while ($row = $result->fetch_assoc()) {
                                          echo "<option value='".$row['clisexo']."'>".utf8_encode($row['clisexo'])."</option>";
                                      }
                                  }

                                   ?>
                              </select>
                          </div>
                            <div class="form-group col-lg-4">
                              <label>Cargo</label>
                              <select id="FiltroOcupacion" name="FiltroOcupacion" class="form-control">
                                  <?php
                                  $sql = "SELECT `ocucodigo`, `ocunombre` FROM btyocupacion";
                                  $result = $conn->query($sql);
                                  if ($result->num_rows > 0) {
                                      echo "<option value='0'>--Todos--</option>";
                                      while ($row = $result->fetch_assoc()) {
                                          echo "<option value='".$row['ocucodigo']."'>".utf8_encode($row['ocunombre'])."</option>";
                                      }
                                  }

                                   ?>
                              </select>
                          </div>

                          <div class="form-group col-lg-4">
                              <label>Tipo de registro</label>
                              <select id="FiltroCliente" name="FiltroCliente" class="form-control">
                              <?php
                                  $sql = "SELECT DISTINCT clitiporegistro FROM btycliente ORDER BY clitiporegistro";
                                  $result = $conn->query($sql);
                                  if ($result->num_rows > 0) {
                                      echo "<option value='0'>--Todos--</option>";
                                      while ($row = $result->fetch_assoc()) {
                                          echo "<option value='".$row['clitiporegistro']."'>".utf8_encode($row['clitiporegistro'])."</option>";
                                      }
                                  }
                              ?>
                              </select>
                          </div>
                      </div>
                      <div class="row" hidden>
                          <div class="form-group col-lg-8">
                              <label>Filtro antiguedad  <a onclick="$('#start').val(''); $('#end').val('');"><i class="fa fa-close text-danger"></i></a></label>
                              <div class="input-daterange input-group" id="datepicker">
                                  <input type="text" class="input-sm form-control fecha" id="start" name="start"/>
                                  <span class="input-group-addon">a</span>
                                  <input type="text" class="input-sm form-control fecha" id="end" name="end"/>
                              </div>    
                          </div>
                      </div>

                      
                  </div>
                  <div class="modal-footer">
                      <button type="button" onclick="rango();" class="btn btn-default" data-dismiss="modal">Listo</button> 
                  </div>
              </form>
            </div>
          </div>
        </div>
<!--- Modal para envios por correo-->

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
                    <label class="checkbox-inline"><input  type="checkbox" id="rptf"  name="rptf" value="" >PDF</label>&nbsp;&nbsp;
                            <label class="checkbox-inline"><input  type="checkbox" id="rptx" name="rptx" value="" >Excel</label>  
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" onclick="env()" class="btn btn-default " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Enviar</span></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>





<!--- Modal para envios por correo-->

<div id="find" class="content animate-panel">
  
   <?php include "filtro_colaborador.php"; ?> 

</div>

   
    </div>

    <!-- Footer-->
    <?php
  //include 'footer.php';
 ?> 


<div class="modal fade" id="modalServicios" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Servicios del colaborador</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Servicios Autorizados</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                <div class="col-xs-3">
                  <img src="" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="180" height="180">
                </div>
                <div class="col-xs-9">
                    <div class="form-group">
                    <div class="col-sm-12">
                      <input type="hidden" id="txtCodigoColaborador">
                    </div>
                  </div>
                  <div class="form-group">                  
                    <!-- <label class="label label-success" id="nombreColaboradorServicio"></label> -->         
                  </div>
                  <div class="form-group">                  
                      <div id="listaData"></div>         
                  </div>
                <!--   <div class="form-group">
                  <label class="label label-warning" id="cargoColaboradorServicio"></label>
                
                </div> -->
                  
                </div>
              </div> 
              </div>
          </div>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive" id="">                             
                    <table class="table table-hover table-bordered table-striped" id="tblLista" style="width: 100%">
                        <thead>
                          <tr class="info">
                            <th>Servicio</th>
                            <th>Duración</th> 
                          </tr>         
                        </thead>

                        <tbody>

                        </tbody>                        
                    </table>                    
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" title="Cerrar ventana">Cerrar</button>
        </div>
      </div>
    </div>
  </div>



</div>
<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>
<script type="text/javascript">
  $('#side-menu').children('.active').removeClass('active');  
  $("#CLIENTES").addClass("active");
</script>
<script src="js/sube_baja.js"></script>
<script>

$(document).ready(function(){

conteoNovHead ();

  $(document).on('click', '.sln_nombre', function() {
           var id = $('#cod_salon').val();
            $('#modalVerSalon').modal("show");
            $('body').removeClass("modal-open");
            $('body').removeAttr("style");

           $.ajax({
                url: 'php/sube_baja/cargar_imagen_sln.php',
                method: 'POST',
                data: {id:id},
                success: function (data) {
                    var array = eval(data);
                    for(var i in array){
                        $('#title_imagen').html("Salón "+array[i].nombre);
                        $("#imagen_salon").removeAttr("src");        
                        $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
                    }
                }
           });
        });

    //Código agregado por Jaime
    $('[data-toggle="tooltip"]').tooltip();
    //Fin codigo agregado

    $("#tipo_nombre1").click(function(){
        
        $("#divnombre").hide();
        $("#divapellido").hide();
        $("#divrazon").show();
        $("#divsexo").hide();
        $("#divocu").hide();
        document.getElementById("sexo").required = false;
        document.getElementById("razon_social").required = true;
        document.getElementById("nombres").required = false;
        document.getElementById("apellidos").required = false;
       document.getElementById("nombres").value="";
       document.getElementById("apellidos").value="";
       document.getElementById("dv").required = true;
       document.getElementById("ocu").required = false;
    });
    $("#tipo_nombre2").click(function(){
       $("#divnombre").show();
        $("#divapellido").show();
        $("#divrazon").hide();
        $("#divsexo").show();
        $("#divocu").show();
        document.getElementById("sexo").required = true;
        document.getElementById("razon_social").required = false;
        document.getElementById("nombres").required = true;
        document.getElementById("apellidos").required = true;
        document.getElementById("razon_social").value="";
        document.getElementById("dv").required = true;
        document.getElementById("ocu").required = true;
        
    });
});


 function conteoNovHead () 
 {
  $.ajax({
    url: 'php/biometrico/processFn.php',
    method: 'POST',
    data: {opcion: "conteoNovHead"},
    success: function (data) 
    {
      $('#conteoNoved').html(data);
      $('#novdect').html("NOVEDADES DETECTADAS " + data);
    }
  });
 }

/*===========================================
=            MODAL VER SERVICIOS            =
===========================================*/

$(document).on('click', '#btn_ver_servicios', function() {
     var cod_col  = $(this).data("id_col");
     var img      = $(this).data("img");
     var cargo_   = $(this).data("cargo");
     var nom_col  = $(this).data("nombrecol");

     load_service (cod_col);
     $.ajax({
      url: 'php/sube_baja/mostrar_servicios.php',
      method: 'POST',
      data: {cod_col:cod_col, buscar:"no"},
      success: function (data) 
      {


        var jsonServicios = JSON.parse(data);

              var imagen   =  "";
          var cod      =  "";
          var nombre   =  "";
          var cargo    =  "";
              var servicio =  "";
              var duracion =    "";
        
          $('#tbl_servicios tbody').empty();
          $('#nombreColaboradorServicio').empty();
              $('#cargoColaboradorServicio').empty(); 


                if (jsonServicios.res == "full") 
                {

                    for(var i in jsonServicios.json)
                    {

                            $('#listaData').empty();

                                if(jsonServicios.json[i].img_servici == "default.jpg" || jsonServicios.json[i].img_servici == null )
                                {
                                    imagen = "contenidos/imagenes/default.jpg";
                                }
                                else
                                {
                                    imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios.json[i].img_servici+"";
                                }

                                        $('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
                                        $('#imagenColaboradorServicio').attr('title', jsonServicios.json[i].nom_colabor);
                                        $('#txtCodigoColaborador').val(jsonServicios.json[i].cod_colabor);
                                        $('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios.json[i].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios.json[i].nom_colabor+'</button><button type="button" title="'+jsonServicios.json[i].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios.json[i].cargo_colab+'</button><button type="button" title="'+jsonServicios.json[i].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios.json[i].salon_base+'</button><button type="button" title="'+jsonServicios.json[i].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios.json[i].categoria+'</button></div>');

                    }
            }
            else
            {

                var jsonServicios2 = JSON.parse(data);

                for(var j in jsonServicios2.json)
                {

                    
                    $('#listaData').empty();

                        if(jsonServicios2.json[j].img_servici == "default.jpg" || jsonServicios2.json[j].img_servici == null )
                        {
                            imagen = "contenidos/imagenes/default.jpg";
                        }
                        else
                        {
                            imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios2.json[j].img_servici+"";
                        }

                            $('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
                            $('#imagenColaboradorServicio').attr('title', jsonServicios2.json[j].nom_colabor);
                            $('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios2.json[j].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios2.json[j].nom_colabor+'</button><button type="button" title="'+jsonServicios2.json[j].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios2.json[j].cargo_colab+'</button><button type="button" title="'+jsonServicios2.json[j].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios2.json[j].salon_base+'</button><button type="button" title="'+jsonServicios2.json[j].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios2.json[j].categoria+'</button></div>');

                }

            }
    

    }
      
    });

});

/*=====  End of MODAL VER SERVICIOS  ======*/
</script>

<script>

function filtrar () {
            $.ajax({
                type: "POST",
                url: "filtro_colaborador.php",
                data: {genero: $('#FiltroSexo').val(), cargo: $('#FiltroOcupacion').val(), tipo: $('#FiltroCliente').val()},
                success: function (res) {
                    $('#find').html(res);
                }
            });
        }
       
$('#FiltroSexo').change(function() {
    filtrar();
});
$('#FiltroOcupacion').change(function() {
    filtrar();
});
$('#FiltroCliente').change(function() {
    filtrar();
});
    
function detalles(id) 
{
    $.ajax({
        type: "POST",
        url: "cli_detalles.php",
        data: {operacion: 'update', id_cliente: id}
    }).done(function (a) {
        $('#find').html(a);
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}


function editar(id) {
window.location.href = "actualizar_cliente.php?operacion=update&id_cliente="+id;
    $.ajax({
        type: "POST",
        url: "actualizar_cliente.php",
        data: {operacion: 'update', id_cliente: id}
    }).done(function (a) {
        $('#find').html(a);
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}
function paginar(id) {
    $.ajax({
        type: "POST",
        url: "filtro_colaborador.php",
        data: {genero: $('#FiltroSexo').val(), cargo: $('#FiltroOcupacion').val(), tipo: $('#FiltroCliente').val(),page: id}
    })
    .done(function (a) {
        $('#find').html(a);
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}
$(document).ready(function() {
   $('#inputbuscar').keyup(function(){
        var username = $(this).val();        
        var dataString = 'nombre='+username;
        var tpcl = $('#ex-basic').val();
        $.ajax({
            type: "POST",
            url: "buscar_cliente.php",
            data: dataString, tpcl,
            success: function(data) {
                $('#find').fadeIn(1000).html(data);
            }
        });
    });   
});

</script>

<script type="text/javascript">
var i=0;
   var arr1 = [];
$(document).ready(function() {    
  $('#no_documento').blur(function(){

    $('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);

      var username = $(this).val();        
      var dataString = 'no_documento='+username;

      $.ajax({
          type: "POST",
          url: "check_colaborador.php",
          data: dataString,
          success: function(data) {
              $('#Info').fadeIn(1000).html(data);
          }
      });
  });

  $('#selectCaracteristicaAutorizados').change(function () {
        $.ajax({
            type: "POST",
            url: "serviciosPorColaborador.php",
            data: {codigo: $('#txtcodigocolaborador').val(), caracteristica: $(this).val()},
            success: function (res) {
                $('#').html(res);
        }
        });
    });

  $("#btnReporteExcel").on("click", function(){

    window.open("./generarReporteClientes.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=excel");
    
  });

  $("#btnReportePdf").on("click", function(){
    
    window.open("./generarReporteClientes.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=pdf");
  });

    $("#btnCompartirWhatsapp").on("click", function(){

    window.open("whatsapp://send?text=https://goo.gl/wxBwqG");
    
  });

});  
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
 url: "enviar_por_correo_clientes.php",
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
 $('#rptf').on("click", function(){
             $.ajax({
                 async: false,
                 type: "POST",
                 url: "generarReporteClientes.php",
                 data: {
                     envio: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
           
        }); 
      $('#rptx').on("click", function(){
          
           $.ajax({
                 async: false,
                 type: "POST",
                 url: "generarReporteClientes.php",
                 data: {
                     enviox: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
        }); 

$(document).on('click', '#btn_paginar', function() 
{
        var data = $(this).data("id");
        $.ajax({
        type: "POST",
        url: "php/sube_baja/lista_servicios.php",
        data: {page: data, cod: $('#txtCodigoColaborador').val()},
        success: function (data) {
           $('#list').html(data);
        }
    });
});

</script>

</body>
</html>