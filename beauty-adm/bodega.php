<?php 
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("BODEGA", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
    include "librerias_js.php";
?>
<script src="js/bodega.js"></script>


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
                        <span>Bodegas</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <!-- <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Digite Bodega"> -->
                                <div class="input-group-btn">           
                                    <!-- <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button> -->
                                    <button type="button" data-toggle="tooltip" data-placement="bottom" id="btn_modal_bod" class="btn btn-default" title="Nueva Bodega" onclick="$('#modaladicion_bodega').modal('show')"><i class="fa fa-plus-square-o text-info"></i> Nueva Bodega
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
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modaladicion_bodega">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Adicionar Bodega</h4>
                <h4 id="actual"></h4>
            </div>
            <form id="formulario">     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-1">
                            

                            <input style="display:none" type="text" id="consec" name="consec" class="form-control" disabled="" value=' <?php   $sqll= "SELECT * FROM btybodega";
                                  if ($conn->query($sqll)){
                                  $sqlmax = "SELECT MAX(bodcodigo) as m FROM `btybodega`";
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
                            <label data-toggle='tooltip'>Nombre Bodega</label>
                                <input maxlength="50" type="text" id="nombre_bodega" name="" class="form-control" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                          </div>

                        <div class="form-group col-lg-12">
                            <label>Alias</label>
                            <input maxlength="10"  type="text" id="alias" name="" class="form-control" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">                            
                        </div>

                    </div>
 
                </div>


                <div class="modal-footer">
                  <script>
                     
                  </script>
                 <button class="btn btn-success" type="button" id="btn_guardar_bodega">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php
        if ($_POST['nombre'] != "") {
            $id = $_POST['nombre'];
            $sql = "SELECT bodcodigo, bodnombre, bodalias, if(bodestado = 1, 'Activo', 'Inactivo') as estado FROM btybodega WHERE (bodalias LIKE '%$id%' OR bodnombre LIKE '%$id%') AND bodestado = 1";
        } else {
            $sql = "SELECT bodcodigo, bodnombre, bodalias, if(bodestado = 1, 'Activo', 'Inactivo') as estado FROM btybodega where bodestado = 1";
        }
    ?>

<!-- Modal de adicion -->
    <div id="contenido" style="width: 100%; margin: auto" class="content animated-panel">
          <div class="animate-panel">
        <div class="hpanel">
            <div class="panel-heading">
                <span class="label label-success pull-right"> 
                  <?php 
                  $query_num_colum = $sql; 
                  $resul = $conn->query($query_num_colum); 
                  $registros = $resul->num_rows; 
                  echo " <h6>No. Registros: ".$registros."</h6>";
                  ?>
                </span>
                <h3 class="panel-title">Lista de Bodegas</h3>
                <br>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="table-responsive"> 
                      <table class="table table-hover table-bordered" id="tbl_bodegas">
                          <tr class="active">
                              <thead>
                                  <th style="display:none">Codigo</th>
                                  <th>Bodegas</th> 
                                  <th>Acciones</th>           
                              </thead>
                          </tr>
                
                          <tbody>
                         
                          </tbody>
                      </table>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
            
    </div>

    <!-- Right sidebar -->
    

    <!-- Footer-->

    <!-- Modal -->
<div class="modal fade" id="modal_editar_bodega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Bodega</h4>
      </div>
      <div class="modal-body">
         <form>
            <input type="hidden" id="cod_bod">
            <div class="form-group">
              <label for="exampleInputEmail1">Bodega</label>
              <input type="text" class="form-control" id="nom_bodega">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Alias</label>
              <input maxlength="5" type="text" class="form-control" id="nom_alias">
            </div>
           </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_guardar_mod_bod" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>



<!-- Vendor scripts -->
<?php 
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
 $('#modaladicion').on('shown.bs.modal', function () {
      $('#nmunidad').val("");
      $('#aliass').val("");
      $('#tipo_imp').val("Seleccione");
      $('#val_imp').val("");

});

 $(document).ready(function() {
   tbl_bodegas();
   $('body').removeClass("modal-open").removeAttr('style');
 });


      

 var  tbl_bodegas  = function() { 
   var tbl_est = $('#tbl_bodegas').DataTable({
    "ajax": {
      "method": "POST",
      "url": "listado_bodegas.php",
      },
      "columns":[
        {"data": "bodcodigo"},
        {"data": "bodnombre"},
        {"defaultContent": "<button type='button' data-toggle='modal' data-target='#modal_editar_bodega' id='btn_edit_bodega' class='btn btn-link text-info'><i class='fa fa-edit'></i></button><button type='button' id='btn_elim_bodega' class='btn btn-link text-info'><i class='fa fa-times'></i></button>"},
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};


$('#tbl_bodegas tbody').on('click', '#btn_edit_bodega', function() {
       var $row = $(this).closest("tr");    // Find the row
       var $id = $row.find(".sorting_1").text(); // Find the text
       var cod = $id;

      $.ajax({
        url: 'mostrar_bodegas.php',
        method: 'POST',
        data: {cod: cod},
        success: function (data) {
          var array = eval(data);
                for(var i in array){
                  $('#cod_bod').val(array[i].cod_bodega);
                  $('#nom_bodega').val(array[i].nom_bodega);
                  $('#nom_alias').val(array[i].ali_bodega);
                }
        }
      });
 }); 

 $(document).ready(function() {
        conteoPermisos ();
    });
 </script>


<style>
  th,td{
    text-align: center;
  }
  .sorting_1{
    display: none;
  }
</style>



</body>
</html>