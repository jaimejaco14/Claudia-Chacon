<?php
  include("./head.php");
    include("../cnx_data.php");

    VerificarPrivilegio("UNIDAD DE MEDIDA", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
?>
<div class="">

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
                    
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>Inventario</span>
                    </li>
                    <li class="active">
                        <span>Unidad</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Unidad de Medida o Alias">
                                <div class="input-group-btn">           
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <button data-toggle="tooltip" data-placement="bottom" class="btn btn-default" title="Nueva Unidad" onclick="$('#modaladicion').modal('show')"><i class="fa fa-plus-square-o text-info"></i>
                                        </button></a>
                             
                                </div>
                                <div class="input-group">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- MODAL INFORMACION COMPLETA -->
<!-- MODAL envio de correo -->



<!-- fin MODAL envio de correo -->


<!-- Modal de adicion -->
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modaladicion">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Adicionar unidad de medida</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-1">
                            

                            <input style="display:none" type="text" id="consec" name="consec" class="form-control" disabled="" value=' <?php   $sqll= "SELECT * FROM `btyunidad_medida`";
                                  if ($conn->query($sqll)){
                                  $sqlmax = "SELECT MAX(`umecodigo`) as m FROM `btyunidad_medida`";
                                  $max = $conn->query($sqlmax);
                                  if ($max->num_rows > 0) {
                                    while ($row = $max->fetch_assoc()) {
                                      $cod = $row['m']+1;
                                    } 
                                  } else {
                                    $cod = 0;
                                    
                                  }
                                }
                                 echo $cod; ?> '>
                        </div>
                          <div class="form-group col-lg-12">
                            <label data-toggle='tooltip'>Nombre Unidad</label>
                                <input maxlength="15" type="text" id="nmunidad" name="numunidad" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Alias</label>
                            <input maxlength="3"  type="text" id="aliass" name="aliass" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                            
                        </div>
                    </div>
 
                </div>


                <div class="modal-footer">
                 <button class="btn btn-success"  id="btnenv" data-dismiss="modal" onclick="addcion($('#consec').val(),$('#nmunidad').val(), $('#aliass').val() )" >
                                        Guardar
                                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal de adicion -->
<div id="contenido" class="content animated-panel">
<?php include 'find_unidad.php'; //Lista salones ?>            
            
</div>
</div>
    <!-- Right sidebar -->
    

    <!-- Footer-->



<!-- Vendor scripts -->
<?php include "librerias_js.php";
 if ($_SESSION['encontrado']=='si') {
    echo "<script>
                var encontrado=1;
    </script>"  ;
 }else if ($_SESSION['encontrado']=='no') {
     echo "<script>
                var encontrado=0;
    </script>"  ;
 }else{
     echo "<script>
                var encontrado=3;
    </script>"  ;
 }
 ?>

<script>
  $("#side-menu").children('.active').removeClass('active');  
  $("#INVENTARIO").addClass("active");
  $("#UNIDAD").addClass("active");

  $('#modaladicion').removeClass('modal-open');

</script>

  <script>
  var inable=0;
   var arr1 = [];
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
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
function editar(id) {
    $.ajax({
        type: "POST",
        url: "update_medida.php",
        data: {id_mede: id}
    }).done(function (html) {
        $('#contenido').html(html);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function eliminar(id, este) {
    swal({
        title: "¿Seguro que desea eliminar esta medida?",
        text: "",
        type: "warning",
        showCancelButton:  true,
        cancelButtonText:"No",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí"

        
    },
    function () {   
       $.ajax({
             async: false,
             type: "POST",
             url: "update_medida.php",
             data: {
                id_med: id
             },
             success: function(data) {
              console.log(data);
              location.reload();
             }
            });
                        
   });

}

function paginar(id) {
    $.ajax({
        type: "POST",
        url: "find_unidad.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}

$(document).ready(function () {
    $('#alerta').hide();
    $('#guardar').click(function (event) {
        event.preventDefault();

        var ope = 'insert';
        var id_u = '';
        if ($('#id_usuario').length > 0) {
            if ($('#id_usuario').val() !== '') {
                ope = 'update';
                id_u = $('#id_usuario').val();
            }
        }
        $.ajax({
            type: "POST",
            url: "Cud_usuario.php",
            data: {nombre: $('#nombre').val(), descripcion: $('#descripcion').val(),
                alias: $('#alias').val(), imagen: $('#imagen').val(), nivel:$('#nivel').val(), operacion: ope, id_usuario: id_u}
        }).done(function (msg) {
            if (msg == 'Usuario Actualizado') {
                $.ajax({
                    url: "usuarios.php"
                }).done(function (html) {
                    $('#contenido').html(html);
                }).fail(function () {
                    alert('Error al cargar modulo');
                });
            } else {
                $('#alerta').hide();
                $('#nombre').val('');
                $('#direccion').val('');
                $('#telefono').val('');
                $('#email').val('');
                $('#pwd').val('');
                $('#pwd2').val('');
            }
        }).fail(function () {
            alert("Error enviando los datos. Intente nuevamente");
        });
    });
});

 $(document).ready(function() {
   $('#inputbuscar').keyup(function(){
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "find_unidad.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });

    $("#btnReporteExcel").on("click", function(){

        window.open("./generarReporteSalones.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=excel");
    });

    $("#btnReportePdf").on("click", function(){

        window.open("./generarReporteSalones.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=pdf");
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
 url: "enviar_por_correo_salon.php",
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
                 url: "generarReporteSalones.php",
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
                 url: "generarReporteSalones.php",
                 data: {
                     enviox: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
        }); 
 
function addcion(cod,nom,aliass) {
   if (cod=="" || nom=="" || aliass=="") {
        swal("¡Campos vacios!");
   }else{
        $.ajax({
                 async: false,
                 type: "POST",
                 url: "adicion_unidad.php",
                 data: {
                     codigo: cod, nombre: nom, alias:aliass
                 },
                 success: function(data) {
                                swal({
                                  title: "Mensaje",
                                  text: data,
                                  type: "info",
                                  showCancelButton: true,
                                  confirmButtonClass: "btn-success",
                                  confirmButtonText: "OK",
                                  confirmButtonColor: "#c9ad7d",
                                  closeOnConfirm: false
                              
                                },

                                function(){
                                 $.ajax({
                                     async: false,
                                     type: "POST",
                                     url: "update_medida.php",
                                     data: {
                                         id_mede: 'si', nomb: nom, ali: aliass
                                     },
                                     success: function(data) {
                                      console.log(data);
                                     location.reload();
                                     }
                                    });
                                  
                                });
                    
                    
                 }
                });
    }    
}

$('#nmunidad').blur(function(){
        this.value=this.value.toUpperCase();
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "verificar_eliminados.php",
            data: dataString,
            success: function(data) {
                console.log(data);
            }
        });
    });

$('#aliass').blur(function(){
        this.value=this.value.toUpperCase();
        var username = $(this).val();        
        var dataString = 'nomb='+username;

        $.ajax({
            type: "POST",
            url: "verificar_eliminados.php",
            data: dataString,
            success: function(data) {
                console.log(data);
            }
        });
    });
$('#btnenv').click(function  () {
   $.ajax({
    url:"verificar_eliminados.php",
    dataType: 'jsonp',
    success:function(datos){
        inable=1;
        swal("Success");
        $.each(datos, function(indice, valor){
            swal(indice+" : "+valor);
        });
    },
    error:function(){
        inable=0;
    }
});
    // body... 
});


 $(document).ready(function() {
    conteoPermisos ();
});
</script>


</body>
</html>