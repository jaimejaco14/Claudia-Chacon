<?php 
    include("head.php");
    include("../cnx_data.php");
    include "librerias_js.php";
    VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();  

 
?>

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Activos</span>
                    </li>
                </ol>
            </div>
            
        </div>        
    </div>
    
    <div class="content animated-panel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active listact"><a data-toggle="tab" href="#tab-11" id="listact"> Listado de Activos</a></li>
                <li class="detact" style="display:none;"><a data-toggle="tab" id="detact" href="#tab-21">  Detalles</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-11" class="tab-pane active">
                    <div class="panel-body">
                       <a href="new_activo.php" class="pull-right"><button class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Nuevo activo"><i class="fa fa-plus"></i> Crear Activo</button></a>
                        <div id="listado">
                            <table id="tbactivos" class="table table-hover table-bordered" style="width: 100%;">
                            <thead>
                              <tr>
                                <th>Foto</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Ver</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                    </div>
                </div>
                <div id="tab-21" class="tab-pane">
                    <div class="panel-body">
                        <div id="detalles"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
   .TriSea-technologies-Switch > input[type="checkbox"] {
          display: none;   
      }

      .TriSea-technologies-Switch > label {
          cursor: pointer;
          height: 0px;
          position: relative; 
          width: 40px;  
      }

      .TriSea-technologies-Switch > label::before {
          background: rgb(0, 0, 0);
          box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
          border-radius: 8px;
          content: '';
          height: 16px;
          margin-top: -8px;
          position:absolute;
          opacity: 0.3;
          transition: all 0.4s ease-in-out;
          width: 40px;
      }
      .TriSea-technologies-Switch > label::after {
          background: rgb(255, 255, 255);
          border-radius: 16px;
          box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
          content: '';
          height: 24px;
          left: -4px;
          margin-top: -8px;
          position: absolute;
          top: -4px;
          transition: all 0.3s ease-in-out;
          width: 24px;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
          background: inherit;
          opacity: 0.5;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
          background: inherit;
          left: 20px;
      }
</style>

<script>
  $("side-menu").children(".active").removeClass("active");
  $("#ACTIVOS").addClass("active");
  $("#ACTIVO").addClass("active");
</script>
<script>
    $(document).ready(function () {
        loadactivos();
        $('[data-toggle="tooltip"]').tooltip();
        $(".dateform").datetimepicker({
            format: "YYYY-MM-DD",
            locale: "es",
        });
    });   

    function eliminar(id, este) {
        swal({
            title: "¿Seguro que desea eliminar este activo?",
            text: "",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"  
            },function () {
                $.ajax({
                type: "POST",
                url: "php/delete_act.php",
                data: {id_act: id, operacion: "delete"}
                }).done(function (res) {
                    if(res=='true'){
                        $('#listado').load('php/listactivo.php');
                    }else{
                        swal('error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente','error');
                    }
                
             }).fail(function () {
                    swal("Error enviando los datos. Intente nuevamente");
                });
        });
    }

    function paginar(id) {
        $.ajax({
            type: "POST",
            url: "php/listactivo.php",
            data: 'page='+id,
        }).done(function (a) {
            $('#listado').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }

    function img (a){
        if (a != "default.jpg") {
            $('#photo').attr("src", "imagenes/activo/"+a);
        } else {
            $('#photo').attr("src", "imagenes/default.jpg");
        }
        $('#modal_img').modal('show');

    };
</script>
<script type="text/javascript">
  var loadactivos=function(){
      var listado = $('#tbactivos').DataTable({
        "ajax": {
        "method": "POST",
        "url": "php/listactivo.php",
        "data": {opc: "loadactivo"},
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'PDF'
            }
        ],
        "columns":[
          {"render": function (data, type, JsonResultRow, meta) { 
            return '<img class="actimg" style="width:50px;" title="" src="../contenidos/imagenes/activo/'+JsonResultRow.actimagen+'" onerror=this.src="../contenidos/imagenes/default.jpg";>'; 
            } 
          },  
          {"data": "actcodigo"},
          {"data": "actnombre"},
          {"data": "lugnombre"},        
          {"render": function (data, type, JsonResultRow, meta) { 
              return "<button class='btn btn-info detalles' title='Ver detalles' data-actcod='"+JsonResultRow.actcodigo+"'><i class='fa fa-eye'></i></button>";
            } 
          },  
        ],
        "language":{
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "<b>Página _PAGE_ de _PAGES_</b> <br><label class='btn btn-success'><b>Total Activos: _MAX_</b></label>",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search": "_INPUT_",
            "searchPlaceholder":"Buscar...",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            } 
         },  
           "columnDefs":[
                {className:"text-center","targets":0},
                {className:"text-center","targets":4}
                
           ],
               
           "order": [[2, "asc"]],
           "bDestroy": true,
           "pageLength": 5,
      });
  }
  $(document).on('click','.detalles',function(){
    var actcod=$(this).data('actcod');
    detalleactivo(actcod);
    $(".listact").removeClass('active');
    $("#tab-11").removeClass('active');
    $(".detact").show().addClass('active');
    $("#tab-21").addClass('active');

  })
</script>
<script type="text/javascript">
   function loadrevmtto(idact){
        $(".revmttoact").html('');
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&idact='+idact,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    }
    function movimiento(id){
        $("#movimientos").html('');
        $.ajax({
            type: "POST",
            url: "php/loadmovactivo.php",
            data: 'idact='+id,
            success:function(res){
                $("#movimientos").html(res);
            }
        });
    }
    function paginarm(id) {
        $(".revmttoact").html('');
        var idact=$("#codigo").val();
        var fest=$("#filest").val();
        var ftpo=$("#filtipo").val();
        if($("#filhasta").val()!=''){    
            var filfe="'"+$("#fildesde").val()+"' and '"+$("#filhasta").val()+"'";
        }else{
            var filfe="";
        }
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&filestado='+fest+'&filtipo='+ftpo+'&idact='+idact+'&filfe='+filfe+'&page='+id,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
                $("#divreset").show();
            }
        })
    }
    function mostrarImagen(input) {

        var imagen = input.files[0];
        var stringImagen = imagen["type"].split("/");
        var tipoImagen = stringImagen[1];
        var tamanoImagen = imagen["size"];

        if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else{

            if (input.files && input.files[0]) {
              
                var reader = new FileReader();
              
                reader.onload = function (e) {
                    $('#imgact').attr('src', e.target.result);
                }
              
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    function detalleactivo(actcod){
      $("#detalles").empty();
      $("#detalles").html('<i class="fa fa-spinner fa-spin"></i> Cargando datos del activo...');
      $("#detalles").load('detalleact.php?id_act='+actcod);
    }
</script>

</body>
</html>