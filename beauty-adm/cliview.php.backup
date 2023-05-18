<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    include 'head.php';
include '../cnx_data.php';
?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>Módulo Clientes</span>
                    </li>
                    <li class="active">
                        <a href="cliview.php"><span>Clientes</span></a>
                    </li>
                </ol>
            </div>
           
        </div>

        <div id="find" class="content table-responsive" style="background-color: white;">
           <style>.dataTables_filter input { width: 400px!important; }</style>
            <table id="tbclientes" class="table table-bordered table-hover">
              <thead>
                <tr class="info">
                  <th class="text-center">T.ID</th>
                  <th class="text-center">No Identificación</th>
                  <th class="text-center">Nombre Cliente</th>
                  <th class="text-center">Sexo</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">Registrado</th>
                  <th class="text-center">Tipo Reg</th>
                  <th class="text-center">Salón</th>
                  <th class="text-center">Ver</th>
                </tr>
              </thead>
            </table>
        </div>
        <div id="find2" class="content" style="display:none;"></div>
    </div>
</div>


<div class="modal fade" id="modal-detcli">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-info"></i> Información de cliente</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="">Tipo y Número de Identificación</label>
              <input id="nced" name="nced" class="form-control clr" readonly autocomplete="off">
              <input type="hidden" id="ndocu">
            </div>
            <div class="col-md-6">
              <h5 class="loadgui"><i class="fa fa-spin fa-spinner"></i> Cargando datos, espere...</h5>
              <button class="btn btn-default pull-right btneditcli hidden"><i class="fa fa-edit"></i> Editar datos</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="">Nombres</label>
              <input id="clinom" name="clinom" class="form-control edtb clr" readonly autocomplete="off">
            </div>
            <div class="col-md-6">
              <label for="">Apellidos</label>
              <input id="cliape" name="cliape" class="form-control edtb clr" readonly autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <label for="">Sexo</label>
              <input id="clisex" name="clisex" class="form-control text-uppercase clr" readonly autocomplete="off">
              <select id="newsex" name="newsex" class="form-control newsex hidden">
                <option value="N/D">N/D</option>
                <option value="M">M</option>
                <option value="F">F</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="">Fecha Nacimiento</label>
              <input id="clifna" name="clifna" class="form-control edtb clr text-center" style="color: transparent;text-shadow: 0 0 0 #6a6c6f;" readonly autocomplete="off">
            </div>
            <div class="col-md-4">
              <label for="">Celular</label>
              <input id="clitel" name="clitel" class="form-control edtb clr" readonly autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="">E-Mail</label>
          <input id="climail" name="climail edtb clr" class="form-control edtb clr" readonly autocomplete="off">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="savecli" class="btn btn-info hidden">Guardar cambios</button>
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
<script>

$(document).ready(function(){

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
    listcliente();
});
</script>
<script type="text/javascript">
  $.fn.dataTable.ext.buttons.alert = {
    className: 'buttons-alert',
    action: function ( e, dt, node, config ) {
        window.location='nuevo_cliente.php';
    }
};
  var  listcliente  = function() { 
   var listado = $('#tbclientes').DataTable({
      "ajax": {
      "method": "POST",
      "url": "loadclientes.php",
      "data": {opc: "loadcli"},
      },
      dom: 'Bfrtip',
        buttons: [ 
            {
                extend:    'alert',
                text:      '<i class="fa fa-plus text-info newsalon"></i>',
                titleAttr: 'Crear cliente',
            },
            /*{
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'Exportar como PDF',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },
                title:'BeautySoft - Listado de clientes',
            },*/
            {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Exportar a Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                },
                title:'BeautySoft - Listado de clientes',
            }
        ],
      "columns":[
        {"data": "tdialias"},
        {"data": "trcdocumento"},
        {"data": "trcrazonsocial"},
        {"data": "clisexo"},
        {"data": "trctelefonomovil"},
        {"data": "clifecharegistro"},
        {"data": "tiporeg"},
        {"data": "slnnombre"},
        {"render": function (data, type, JsonResultRow, meta) { 
              return '<button class="detalles btn btn-default text-info" data-numdoc="'+JsonResultRow.trcdocumento+'" title="Ver mas datos"><i class="fa fa-eye"></i></button>'; 
             } 
        },  
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "<label class='btn btn-info'> _MAX_ Clientes registrados</label><br>Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "<h3><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere...</h3>",
        "processing":     "Procesando...",
        "search": "_INPUT_",
        "searchPlaceholder":"Buscar Cliente por nombre, documento, teléfono, fecha o salón...",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"text-center","targets":[0]},
              {className:"text-center cedcli","targets":[1]},
              {className:"nomcli","targets":[2]},
              {className:"text-center sexcli","targets":[3]},
              {className:"text-center telcli","targets":[4]},
              {className:"text-center","targets":[5]},
              {className:"text-center","targets":[6]},
         ],
             
         "order": [[2, "asc"]],
         "bDestroy": true,
         "pageLength":7,
      });
  };
  $(document).on('click','.detalles',function(){
    var nd=$(this).data('numdoc');
    detcli(nd);
  });
  $(document).on('click','.regresar',function(){
    $("#find2").hide();
    $('#find').show();
  });
</script>
<script>
    
function detalles(id) {
    $('#find2').empty();
    $.ajax({
        type: "POST",
        url: "cli_detalles.php",
        data: {operacion: 'update', id_cliente: id}
    }).done(function (a) {
        $("#find").hide();
        $('#find2').html(a).show();
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}

function detcli(id){
  $('#modal-detcli').modal('show');
  $.ajax({
    url:'loadclientes.php',
    type:'POST',
    data:{opc:'detcli', id:id},
    success:function(res){
      var dt=JSON.parse(res);
      $(".loadgui").addClass('hidden');
      $(".btneditcli").removeClass('hidden');
      $("#ndocu").val(dt.numdoc);
      $("#nced").val(dt.td+' - '+dt.numdoc);
      $("#clinom").val(dt.nom);
      $("#cliape").val(dt.ape);
      $("#clisex").val(dt.sex);
      $("#newsex").val(dt.sex);
      $("#clifna").val(dt.fnac);
      $("#clitel").val(dt.celu);
      $("#climail").val(dt.mail);
    }
  })
}

$("#savecli").click(function(e){
  $(this).html('<i class="fa fa-spin fa-spinner"></i> Guardando..');
  var cliced=$("#ndocu").val();
  var clinom=$("#clinom").val().trim();
  var cliape=$("#cliape").val().trim();
  var clisex=$("#newsex").val();
  var clifna=$("#clifna").val();
  var clitel=$("#clitel").val().trim();
  var climail=$("#climail").val().trim();
  $.ajax({
    url:'loadclientes.php',
    type:'POST',
    data:{opc:'savecli',
          cliced:cliced,
          clinom:clinom,
          cliape:cliape,
          clisex:clisex,
          clifna:clifna,
          clitel:clitel,
          climail:climail},
    success:function(res){
      if(res==1){
        $("#tbclientes tr:contains("+cliced+") .nomcli").html(clinom+' '+cliape);
        $("#tbclientes tr:contains("+cliced+") .sexcli").html(clisex);
        $("#tbclientes tr:contains("+cliced+") .telcli").html(clitel);
        $('#modal-detcli').modal('toggle');
      }else{
        swal('Oops!','Algo pasó, comunique al departamento de sistemas de este error.','error');
      }
    }
  });
})

$(".btneditcli").click(function(e){
  $(this).addClass('hidden');
  $(".edtb").removeAttr('readonly');
  $("#savecli").removeClass('hidden');
  $("#clisex").addClass('hidden');
  $("#newsex").removeClass('hidden');
  $("#clifna").datepicker({
      format:'yyyy-mm-dd',
      autoclose:true,
      startView: 2,
      orientation: "top",
  });
  $("#savecli").html('Guardar cambios');
});

$('#modal-detcli').on("hidden.bs.modal", function () {
  $(".loadgui").removeClass('hidden');
  $(".btneditcli").addClass('hidden');
  $(".edtb").attr('readonly',true);
  $("#savecli").addClass('hidden');
  $("#clisex").removeClass('hidden');
  $("#newsex").addClass('hidden');
  $("#clifna").datepicker('remove');
  $(".clr").val('');
});


function editar(id) {
  window.location.href = "actualizar_cliente.php?operacion=update&id_cliente="+id;
    /*$.ajax({
        type: "POST",
        url: "actualizar_cliente.php",
        data: {operacion: 'update', id_cliente: id}
    }).done(function (a) {
        $('#find').html(a);
    }).fail(function () {
        alert('Error al cargar modulo');
    });*/
}


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

 

  

});  

 
 
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


</script>
</script>
</body>
</html>