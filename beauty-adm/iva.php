<?php 
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("IVA", $_SESSION['tipo_u'], $conn);
    RevisarLogin();

?>
<script src="js/iva.js"></script>

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
                        <span>Contabilidad</span>
                    </li>
                    <li class="active">
                        <span>Iva</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Digite Impuesto">
                                <div class="input-group-btn">           
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <button data-toggle="tooltip" data-placement="bottom" id="btn_adicionar" class="btn btn-default" title="Nuevo Impuesto" onclick="$('#modaladicion').modal('show')"><i class="fa fa-plus-square-o text-info"></i>
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
                <h4 id="TituloSalonBase" class="modal-title">Adicionar Impuesto</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-1">
                            

                            <input style="display:none" type="text" id="consec" name="consec" class="form-control" disabled="" value=' <?php   $sqll= "SELECT * FROM btyimpuesto_ventas";
                                  if ($conn->query($sqll)){
                                  $sqlmax = "SELECT MAX(imvcodigo) as m FROM `btyimpuesto_ventas`";
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
                            <label data-toggle='tooltip'>Nombre Impuesto</label>
                                <input maxlength="50" type="text" id="nmunidad" name="numunidad" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                          </div>

                        <div class="form-group col-lg-12">
                            <label>Alias</label>
                            <input maxlength="10"  type="text" id="aliass" name="aliass" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">                            
                        </div>

                         <div class="form-group col-lg-12">
                            <label>Tipo</label>
                            <select name="tipo_imp" id="tipo_imp" class="form-control">
                                <!-- <option value="x" selected>Seleccione </option> -->
                                <option value="1">Porcentaje </option>
                                <option value="0">Fijo </option>
                            </select>                            
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Valor</label>
                            <input type="number" id="val_imp" name="val_imp" class="form-control">              
                        </div>
                    </div>
 
                </div>


                <div class="modal-footer">
                  <script>
                     
                  </script>
                 <button class="btn btn-success" type="button" id="btnenv" data-dismiss="modal" >Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal de adicion -->
<div id="contenido" style="width: 70%; margin: auto" class="content animated-panel">
<?php include 'imp_buscar.php'; //Lista salones ?>            
<?php include 'librerias_js.php'; ?>            
</div>
</div>
    <!-- Right sidebar -->
    

    <!-- Footer-->



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


 $(document).on('click', '#btn_adicionar', function() {
        $('body').removeClass("modal-open").removeAttr('style');
 });

 $(document).ready(function() {
    conteoPermisos ();
});
 </script>

</body>
</html>