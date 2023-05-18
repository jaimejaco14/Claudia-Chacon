<?php 
    include("../head.php");

    VerificarPrivilegio("FECHAS ESPECIALES", $_SESSION['tipo_u'], $conn);
    //RevisarLogin(); 
    $today = date("Y-m-d");

?>
<!-- <script src="js/iva.js"></script> -->


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
                    
                    <li><a href="../inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Fechas Especiales</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <input class="form-control" type="text" id="buscar_fecha" name="inputbuscar" placeholder="Buscar Fecha">
                                <div class="input-group-btn">           
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <button data-placement="bottom" id="btn_adicionar" class="btn btn-default" title="Nueva Fecha" data-toggle="modal" data-target="#modal_nueva_fecha"><i class="fa fa-plus-square-o text-info"></i>
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



<!-- Modal Nueva Fecha -->
<div class="modal fade" id="modal_nueva_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Fecha</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">          
            <div class="form-group">
              <label for="">Tipo de Fecha</label>
              <select name="" id="sel_tipo_fecha" class="form-control">
                <option value="0">Seleccione Tipo de Fecha</option>
                <option value="FESTIVO">FESTIVO</option>
                <option value="ESPECIAL">ESPECIAL</option>
              </select>
            </div>


            <div class="form-group">
              <label for="">Fecha</label>
              <input type="text" class="form-control fecha" id="fecha_" name="" value="<?php echo $today ?>">
            </div>

             <div class="form-group">
              <label for="">Observaciones</label>
              <textarea name="" id="observaciones_" class="form-control" rows="3"></textarea>
            </div>
         
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_nueva_fec" class="btn btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Editar -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar Fecha</h4>
      </div>
      <div class="modal-body">

        <div id="content">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_modificar" class="btn btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de adicion -->
<div id="contenido" style="width: 100%; margin: auto" class="content animated-panel">
<?php include 'fecha_buscar.php'; //Lista salones ?>  

<?php include("../librerias_js.php"); ?>       
            
</div>
</div>
    <!-- Right sidebar -->
    

    <!-- Footer-->

 <script>

  $('.fecha_').datetimepicker({
    format: "YYYY-MM-DD",
    locale: "es",
  });

  $('.fecha').datetimepicker({
    format: "YYYY-MM-DD",
    locale: "es",
  });
     


 $('#modaladicion').on('shown.bs.modal', function () {
      $('#nmunidad').val("");
      $('#aliass').val("");
      $('#tipo_imp').val("Seleccione");
      $('#val_imp').val("");

});


 $(document).on('click', '#btn_adicionar', function() {
        $('body').removeClass("modal-open").removeAttr('style');
 });

 $(document).on('click', '#btn_editar_fecha', function() {
        $('body').removeClass("modal-open").removeAttr('style');
 });


 $(document).ready(function() {
   $('#buscar_fecha').keyup(function(){
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "fecha_buscar.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });
  });
 


 function paginar(id) {
    $.ajax({
        type: "POST",
        url: "fecha_buscar.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}

$(document).on('blur', '.fecha', function() {
    var fecha_validar = $('.fecha').val();

    $.ajax({
        url: 'validar_fecha_especial.php',
        method: 'POST',
        data: {fecha: fecha_validar},
        success: function (data) {
            if (data == 1) {
               swal("Esta fecha ya se encuentra registrada. Intente con otra.", "", "warning");
              // $('.fecha_').focus();
            }
        }
    });
});

$(document).on('click', '#btn_nueva_fec', function() {
    var tipo  = $('#sel_tipo_fecha').val();
    var fecha = $('#fecha_').val();
    var obser = $('#observaciones_').val();

    if (tipo == "0") {
       swal("Seleccione un tipo de fecha", "", "warning");
    }else{
        if (fecha == "") {
             swal("Ingrese la fecha", "", "warning");
        }else{
            $.ajax({
                url: 'nueva_fecha_especial.php',
                method: 'POST',
                data: {tipo:tipo, fecha: fecha, obser:obser},
                success: function (data) {
                   if (data == 1) {
                      location.reload();
                   }
                }
            });
        }
    }
});

$(document).on('click', '#btn_editar_fecha', function() {
     var id = $(this).data("id");

     $.ajax({
         url: 'update_fecha_especial.php',
         method: 'POST',
         data: {id: id, opcion: "editar"},
         success: function (data) {
             $('#content').html(data);
         }
     });
});


$(document).on('click', '#btn_modificar', function() {
    var cod   = $('#codigo').val();
    var tipo  = $('#sel_tipo').val();
    var fecha = $('#fecha').val();
    var obse  = $('#observaciones').val();

    $.ajax({
        url: 'update_fecha.php',
        method: 'POST',
        data: {cod:cod, tipo:tipo, fecha:fecha, obse:obse},
        success: function (data) {
            if (data == 1) {
               swal("Fecha actualizada", "", "success");
               $('#modal_edit').modal("hide");
               location.reload();

            }
        }
    });
});


$(document).on('click', '#btn_eliminar', function() {
      var id = $(this).data("id");

      swal({
        title: "¿Seguro que desea eliminar esta fecha?",
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
             url: "update_fecha_especial.php",
             data: {id: id, opcion: "eliminar"},
             success: function(data) {
              console.log(data);
              location.reload();
             }
            });
                        
   });

      
});






function eliminar(id, este) {
    swal({
        title: "¿Seguro que desea eliminar este impuesto?",
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
             url: "update_fecha_especial.php",
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

$(document).ready(function() {
        conteoPermisos ();
});

 </script>

</body>
</html>