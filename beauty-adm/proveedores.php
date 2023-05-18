<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("PROVEEDORES", $_SESSION['tipo_u'], $conn);
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
                        <span>inventario</span>
                    </li>
                    <li class="active">
                        <span>proveedores</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre o documento del proveedor">
                                <div class="input-group-btn">           
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <a href="nuevo_proveedor.php"><button data-toggle="tooltip" data-placement="bottom" class="btn btn-default" title="proveedor"><i class="fa fa-plus-square-o text-info"></i>
                                        </button></a>
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
                    </div>
                </div>
            </div>
        </div>
<!-- MODAL INFORMACION COMPLETA -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_ver_datos" >
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 id="titulo" class="modal-title">Informaci&oacute;n del proveedor</h4>
                    </div>
                     <div class="modal-body">
                     <div class="row">
                         <div class="form-group col-lg-9">
                            <label>Nombre</label>
                            <input type="text" name="ver_name" id="ver_name" value="" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-3">
                            <label>Tipo Doc.</label>
                            <input type="text" name="ver_alias" id="ver_alias" value="" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-6">
                             <label>Documento</label>
                             <input type="text" id="ver_indicativo" name="ver_indicativo" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-6">
                             <label>Correo</label>
                             <input type="text" id="ver_fijo" name="ver_fijo" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-12">
                             <label>Direccion</label>
                             <input type="text" id="ver_ext" name="ver_ext" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-12">
                             <label>Departamento</label>
                             <input type="text" id="ver_movil" name="ver_movil" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-12">
                             <label>Ciudad</label>
                             <input type="text" id="ver_email" name="ver_email" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-12">
                             <label>Barrio</label>
                             <input type="text" id="ver_dir" name="ver_dir" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-6">
                             <label>Telefono fijo</label>
                             <input type="text" id="ver_tam" name="ver_tam" class="form-control" readonly>
                         </div>
                         <div class="form-group col-lg-6">
                             <label>Telefono movil</label>
                             <input type="text" id="ver_planta" name="ver_planta" class="form-control" readonly>
                         </div>
                    </div>
                    </div>          
            </div>
    </div>
</div>
<!-- MODAL envio de correo -->

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

<!-- MODAL envio de correo -->
<!-- MODAL IMANGEN DE SALON -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_img">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header" style="resize: -20px" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 id="title" class="modal-title">Imagen del salon</h4>
                    </div>
                     <div class="modal-body">
                         <div>
                             <center><img id="photo" class="img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';" src="imagenes/default.jpg"></center>
                         </div>
                     </div>          
            </div>
    </div>
</div>
<div id="contenido" class="content animated-panel">
<?php include 'find_proveedores.php'; //Lista salones ?>            
            
</div>
</div>
    <!-- Right sidebar -->
    

    <!-- Footer-->



<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>

<script>
  $("#side-menu").children('.active').removeClass('active');  
  $("#INVENTARIO").addClass("active");
   $("#PROVEEDORES").addClass("active");
</script>

  <script>
  var i=0;
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
function ver_datos (codigo) {
    var dataString = "codigo="+codigo;
    $.ajax({
        type: "POST",
        url: "get_proveedores.php",
        data: dataString,
        success: function (res){
            $('#ver_name').val(res.split(",")[0]);
            $('#ver_alias').val(res.split(",")[1]);
            $('#ver_indicativo').val(res.split(",")[2]);
            $('#ver_fijo').val(res.split(",")[3]);
            $('#ver_ext').val(res.split(",")[4]);
            $('#ver_movil').val(res.split(",")[5]);
            $('#ver_email').val(res.split(",")[6]);
            $('#ver_dir').val(res.split(",")[7]);
            $('#ver_tam').val(res.split(",")[8]);
            $('#ver_planta').val(res.split(",")[9]);
            $('#modal_ver_datos').modal("show");
        }
    });
}
function editar(id) {
    $.ajax({
        type: "POST",
        url: "update_provee.php",
        data: {operacion: 'update', id_usuario: id}
    }).done(function (html) {
        $('#contenido').html(html);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function eliminar(id, este) {
    swal({
                        title: "¿Seguro que desea eliminar este proveedor?",
                        text: "",
                        type: "warning",
                        showCancelButton:  true,
                        cancelButtonText:"No",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sí"

                        
                    },
                    function () {
                            $.ajax({
                            type: "POST",
        url: "delete_provee.php",
        data: {id_prv: id, operacion: "delete"}
    }).done(function (msg) {
        $(este).parent().parent().remove();
    }).fail(function () {
        alert("Error enviando los datos. Intente nuevamente");
    });

                    });

}

function paginar(id) {
    $.ajax({
        type: "POST",
        url: "find_sln.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function img (a, nombre){
    // var hor = new date();
    $('#title').html(nombre);
    if (a != "default.jpg") {
        $('#photo').attr("src", "imagenes/salon/"+a+"?nocache=");
    } else {
        $('#photo').attr("src", "imagenes/default.jpg");
    }
    $('#modal_img').modal('show');

};
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
            url: "find_proveedores.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });

    $("#btnReporteExcel").on("click", function(){

        window.open("./ReporteProveedores.php?dato=" +  "&tipoReporte=excel");
    });

    $("#btnReportePdf").on("click", function(){

        window.open("./ReporteProveedores.php?dato=" +  "&tipoReporte=pdf");
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
 url: "enviar_por_correo_proveedor.php",
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
                 url: "ReporteProveedores.php",
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
                 url: "ReporteProveedores.php",
                 data: {
                     enviox: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
        });


 $(document).ready(function() {
    conteoPermisos ();
}); 
 
</script>


</body>
</html>