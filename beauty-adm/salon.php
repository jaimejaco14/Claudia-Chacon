<?php
include 'head.php';
include '../cnx_data.php';
 VerificarPrivilegio("SALONES", $_SESSION['tipo_u'], $conn);
?>

<div class="">

  <div class="normalheader transition animated fadeIn small-header">
    <div class="hpanel">
      <div class="panel-body">
        <div id="hbreadcrumb" class="pull-right m-t-lg">
          <ol class="hbreadcrumb breadcrumb">

            <li><a href="index.php">Inicio</a></li>
            <li>
              <span>Salones</span>
            </li>
            <li class="active">
              <span>Salones</span>
            </li>
          </ol>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-lg-12">
              <div class="input-group">
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
            <h4 id="titulo" class="modal-title">Informaci&oacute;n del salon</h4>
          </div>
          <div class="modal-body">
           <div class="row">
             <div class="form-group col-lg-8">
              <label>Nombre</label>
              <input type="text" name="ver_name" id="ver_name" value="" class="form-control" readonly>
            </div>
            <div class="form-group col-lg-4">
              <label>Nombre corto</label>
              <input type="text" name="ver_alias" id="ver_alias" value="" class="form-control" readonly>
            </div>
            <div class="form-group col-lg-3">
             <label>Indicativo</label>
             <input type="text" id="ver_indicativo" name="ver_indicativo" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-6">
             <label>Tel&oacute;fono fijo</label>
             <input type="text" id="ver_fijo" name="ver_fijo" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-3">
             <label>Extencion</label>
             <input type="text" id="ver_ext" name="ver_ext" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-12">
             <label>Tel&eacute;fono m&oacute;vil</label>
             <input type="text" id="ver_movil" name="ver_movil" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-12">
             <label>Email</label>
             <input type="text" id="ver_email" name="ver_email" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-6">
             <label>Direccion</label>
             <input type="text" id="ver_dir" name="ver_dir" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-6">
             <label>Ciudad</label>
             <input type="text" id="ver_loc" name="ver_loc" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-6">
             <label>Tamaño</label>
             <input type="text" id="ver_tam" name="ver_tam" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-6">
             <label>Plantas</label>
             <input type="text" id="ver_planta" name="ver_planta" class="form-control" readonly>
           </div>
           <div class="form-group col-lg-12">
             <label>Fecha de apertura</label>
             <input type="text" id="ver_fecha" name="ver_fecha" class="form-control" readonly>
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
       <center><img id="photo" class="img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';" src="../contenidos/imagenes/default.jpg"></center>
       </div>
     </div>          
   </div>
 </div>
</div>
<div id="contenido" class="content table-responsive" style="background-color: white;">
  <?php //include 'find_sln.php'; //Lista salones ?>            
  <table id="tbsalones" class="table table-bordered table-hover" style="width:100%;">
    <thead>
      <tr>
        <th class="text-center">Nombre Salón</th>
        <th class="text-center">Teléfono fijo</th>
        <th class="text-center">Teléfono Movil</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
  </table>
</div>
</div>
<!-- Right sidebar -->


<!-- Footer-->


<!-- Modal -->
<div class="modal fade" id="modal_ver_bodegas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="titulo_modal_bod">Bodegas</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="cod_salon" class="form-control">
        <div class="form-group">
          <select name="" id="sel_bodegas" class="form-control">
            <option value="0" selected>Seleccione Tipo</option>
          </select>
        </div>
        <div class="form-group">
          <select name="" id="sel_tipos" class="form-control">
            <option value="0" selected>Seleccione Tipo</option>
            <option value="1">PDV</option>
            <option value="2">Externa</option>
          </select>
        </div>
        <div class="form-group">
          <label>Bodegas Actuales</label>
          <table class="table table-hover table-bordered" id="tbl_bodegas_actuales">
            <thead>
              <tr>
                <th style="text-align: center;">Bodega</th>
                <th style="text-align: center;">Tipo</th>
                <th style="text-align: center;">Opciones</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" type="button" id="btn_guardar_bodega_salon" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Editar Bodega-->
<div class="modal fade" id="modal_editar_bodega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="titulo_modal_bod">Bodegas</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="cod_salon_bod" class="form-control">
        <input type="hidden" name="" id="codigo_salon" class="form-control">
        <div class="form-group">
          <select name="" id="sel_tipos_bod" class="form-control">
            <option value="1">PDV</option>
            <option value="2">Externa</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" type="button" id="btn_editar_bodega_salon" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>





<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>

<script>
  $("#side-menu").children('.active').removeClass('active');  
  $("#SALONES").addClass("active");
  $("#SALON").addClass("active");
</script>

<script>
  var i=0;
  var arr1 = [];
  $(document).ready(function () {
    listadoSalones();
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
      url: "get_salon.php",
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
        $('#ver_loc').val(res.split(",")[8]);
        $('#ver_tam').val(res.split(",")[9]);
        $('#ver_planta').val(res.split(",")[10]);
        $('#ver_fecha').val(res.split(",")[11]);
        $('#modal_ver_datos').modal("show");
      }
    });
  }
  function editar(id) {
    $.ajax({
      type: "POST",
      url: "update_salon.php",
      data: {operacion: 'update', id_usuario: id}
    }).done(function (html) {
      $('#contenido').html(html);
    }).fail(function () {
      alert('Error al cargar modulo');
    });
  }
  function eliminar(id, este) {
    swal({
      title: "¿Seguro que desea eliminar este salon?",
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
        url: "delete_sln.php",
        data: {id_sln: id, operacion: "delete"}
      }).done(function (msg) {
        $(este).parent().parent().remove();
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
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
    }).fail(function () {
      alert('Error al cargar modulo');
    });
  }
  function img (a, nombre){
    // var hor = new date();
    $('#title').html(nombre);
    if (a != "default.jpg") {
      $('#photo').attr("src", "../contenidos/imagenes/salon/"+a+"?nocache=");
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
      url: "find_sln.php",
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

</script>
<script type="text/javascript">
  $.fn.dataTable.ext.buttons.alert = {
    className: 'buttons-alert',
    action: function ( e, dt, node, config ) {
        window.location='new_salon.php';
    }
};
  var  listadoSalones  = function() { 
   var listado = $('#tbsalones').DataTable({
      "ajax": {
      "method": "POST",
      "url": "find_sln.php",
      "data": {opc: "loadsln"},
      },
      dom: 'Bfrtip',
        buttons: [
            {
                extend:    'alert',
                text:      '<i class="fa fa-plus text-info newsalon"></i>',
                titleAttr: 'Nuevo Salón',
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'Exportar como PDF'
            },
            {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Excel'
            }
        ],
      "columns":[
        {"data": "slnnombre"},
        {"data": "slntelefonoext"},
        {"data": "slntelefonomovil"},
        {"render": function (data, type, JsonResultRow, meta) { 
              return '<button class="btn btn-default" onclick="img (\'' +JsonResultRow.slnimagen+'?id?12\', \''+JsonResultRow.slnnombre+'\')" title="imagen"><i class="fa fa-image text-info"></i> </button><button class="btn btn-default" title="Editar salon" onclick="editar('+JsonResultRow.slncodigo+')"><i class="pe-7s-note text-info"></i> </button><button class="btn btn-default" title="Eliminar Salon" onclick="eliminar('+JsonResultRow.slncodigo+', this)"><i class="pe-7s-trash text-info"></i></button><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_ver_bodegas" title="Bodegas" id="btn_list_bodeg" data-id="'+JsonResultRow.slncodigo+'" data-salon="'+JsonResultRow.slnnombre+'"><i class="fa fa-th text-info"></i></button>'; 
             } 
        },  
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "_INPUT_",
        "searchPlaceholder":"Buscar Salón...",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"text-center","targets":[1]},
              {className:"text-center","targets":[2]},
         ],
             
         "order": [[0, "asc"]],
         "bDestroy": true,
         "pageLength": 5,
      });
    };
    $(document).find('.newsalon').parent().parent().click(function(){
      console.log('ok');
    });
</script>
<script type="text/javascript">

    $(document).ready(function() {
      load_bodegas ();
    });

    $(document).on('change', '#sel_bodegas', function() {
      var bod = $('#sel_bodegas').val();
      $.ajax({
        url: 'validar_bodega_salon.php',
        method: 'POST',
        data: {bod:bod},
        success: function (data) {
          if (data == 1) {
           swal("Esta bodega ya se ha asignado a un salón");
         }
       }
     });
    });

    function load_tabla_bdegas () {
      var id = $('#cod_salon').val();
      $.ajax({
        url: 'cargar_tabla_bodega_salon.php',
        method: 'POST',
        data: {id:id},
        success: function (data) {
          var array  = eval(data);
          $('#tbl_bodegas_actuales tbody').empty();
          for(var i in array){
            if (array[i].nom_bod != null) {
             $('#tbl_bodegas_actuales tbody').append('<tr><td>'+array[i].nom_bod+'</td><td>'+array[i].tipo+'</td><td><button type="button" class="btn btn-link" id="btn_edit_bodega" data-id="'+array[i].cod_bod+'" data-sln="'+array[i].cod_sal+'" title="Editar Bodega" data-toggle="modal" data-target="#modal_editar_bodega"><i class="fa fa-edit text-info" ></i></button><button type="button" id="btn_eliminar_bod" class="btn btn-link" data-id="'+array[i].cod_bod+'" title="Eliminar bodega para salón"><i class="fa fa-times text-info"></i></button></td></tr>');

           }else{
             $('#tbl_bodegas_actuales tbody').append('<tr><td colspan="3">'+array[i].info+'</td></tr>');
           }
         }                    

       }
     });
    }

    $(document).on('click', '#btn_list_bodeg', function() {
      $('#body').removeClass("modal-open").removeAttr('style');   


      var id = $(this).data("id");
      var sln = $(this).data("salon");
      $('#cod_salon').val(id);
      $('#titulo_modal_bod').html("Bodega Salón " + sln);

      $.ajax({
        url: 'cargar_tabla_bodega_salon.php',
        method: 'POST',
        data: {id:id},
        success: function (data) {
          var array  = eval(data);
          $('#tbl_bodegas_actuales tbody').empty();
          for(var i in array){
            if (array[i].nom_bod != null) {
             $('#tbl_bodegas_actuales tbody').append('<tr><td>'+array[i].nom_bod+'</td><td>'+array[i].tipo+'</td><td><button type="button" class="btn btn-link" id="btn_edit_bodega" data-id="'+array[i].cod_bod+'" data-sln="'+array[i].cod_sal+'" title="Editar Bodega" data-toggle="modal" data-target="#modal_editar_bodega"><i class="fa fa-edit text-info"></i></button><button type="button" id="btn_eliminar_bod" class="btn btn-link" data-id="'+array[i].cod_bod+'" title="Eliminar bodega para salón"><i class="fa fa-times text-info"></i></button></td></tr>');

           }else{
             $('#tbl_bodegas_actuales tbody').append('<tr><td colspan="3">'+array[i].info+'</td></tr>');
           }
         }                    

       }
     });
    });

    function load_bodegas () {
       $.ajax({
        url: 'cargar_bodegas_select.php',
        success: function (data) {
          $('#sel_bodegas').html(data);
        }
      });
     }

  $(document).on('click', '#btn_guardar_bodega_salon', function() {
      var cod         = $('#cod_salon').val();
      var bodega      = $('#sel_bodegas').val(); 
      var bodega_txt  = $('#sel_bodegas option:selected').text(); 
      var tipos       = $('#sel_tipos option:selected').text(); 

    if (bodega == 0) {
      swal("Seleccione la bodega.");
    }else{
      if (tipos == "Seleccione Tipo") {
        swal("Seleccione el tipo.");
      }else{
        $.ajax({
          url: 'guardar_bodega_salon.php',
          method: 'POST',
          data: {cod: cod, bodega:bodega, tipos:tipos},
          success: function (data) {
            if (data == 1) {
              swal("Ya se ha asignado una bodega para este salón.");
            }else{                      
             if (data == 2) {
              swal("Ingreso correcto.");
              load_tabla_bdegas ();
              $("#sel_tipos").prop('selectedIndex', -1);
              $("#sel_bodegas").prop('selectedIndex', -1);
            }else{

              if (data == 3) {
                swal("Esta bodega ya se ha asignado a un salón");
              }
            }
          }
        }
      });
      }
    }
  });


  $(document).on('click', '#btn_eliminar_bod', function() {
    var id = $(this).data("id");
    $.ajax({
      url: 'eliminar_bodega.php',
      method: 'POST',
      data: {id:id},
      success: function (data) {
       if (data == 1) {
         swal({
          title: "¿Desea eliminar esta bodega para este salón?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar",
          closeOnConfirm: false,
          cancelButtonText: 'Cancelar'
        },
        function(){
          swal("Eliminado", "La bodega se ha eliminado", "success");
          load_tabla_bdegas ();
        });
       }
     }
   });
  });


  $(document).on('click', '#btn_edit_bodega', function() {
    var id = $(this).data("id");
    var sln = $(this).data("sln");
    $('#cod_salon_bod').val(id);
    $('#codigo_salon').val(sln);

  });

  $(document).on('click', '#btn_editar_bodega_salon', function() {
    var tipo      = $('#sel_tipos_bod option:selected').text();
    var bodega    =  $('#cod_salon_bod').val();
    var cod_sln   =  $('#codigo_salon').val();

    $.ajax({
      url: 'editar_salon_bod.php',
      method: 'POST',
      data: {bodega:bodega, tipo:tipo, cod_sln:cod_sln},
      success: function (data) {
       if (data == 1) {
        swal("Bodega modificada");
        $('#modal_editar_bodega').modal("hide");
        load_tabla_bdegas ();

      }
    }
  });

  });
</script>

</body>
</html>
<style>
  td{
    text-align: center;
  }
</style>
