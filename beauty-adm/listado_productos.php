<?php 

include '../cnx_data.php';

$sql="SELECT a.procodigo, a.crscodigo, a.imvcodigo, a.umecodigo, a.pronombre, a.prodescripcion, a.proimagen, a.proalias, a.proestado, a.procreacion, a.proultactualizacion, f.grunombre, a.procodigoanterior FROM btyproducto a JOIN btycaracteristica b ON a.crscodigo=b.crscodigo JOIN btysublinea c ON b.sblcodigo=c.sblcodigo JOIN btylinea d ON c.lincodigo=d.lincodigo JOIN btysubgrupo e ON d.sbgcodigo=e.sbgcodigo JOIN btygrupo f ON e.grucodigo=f.grucodigo WHERE a.proestado = 1";

$query_num_col = $sql;
 
$result = $conn->query($query_num_col);
$num_total_registros = $result->num_rows;

$rowsPerPage = 9;
$pageNum = 1;

if(isset($_POST['page'])) 
{
   $pageNum = $_POST['page'];
}
  
$offset = ($pageNum - 1) * $rowsPerPage;
$total_paginas = ceil($num_total_registros / $rowsPerPage);
$sql = $sql." ORDER BY a.procodigo DESC limit $offset, $rowsPerPage";
$result = $conn->query($sql);

  

if ($result->num_rows > 0) {
  $cont = 0;
  echo '  <div class="row">
              <div class="col-lg-12"> 
                <input type="hidden" id="no_reg" value='.$num_total_registros.'>
                <span class="label label-success pull-right"><h6>No. Registros: '.$num_total_registros.'</h6></span>    
              </div>        
          </div><br>';
      while ($row = $result->fetch_assoc()) { 

      if ($row['proimagen'] != "default.jpg") 
      {
         $imagen = "../contenidos/imagenes/producto/".$row['proimagen']."" ;
      }
      else
      {
        $imagen =  "../contenidos/imagenes/default.jpg" ;
      } 

      if ($row['proultactualizacion'] == null) {
            echo '<div class="col-md-4">
                <div class="hpanel">
                <a href="javascript:void(0)" type="button" class="btn_edit_pr" id="btn_edit_prod" data-id=" '.$row['procodigo'].' ">
                  <div class="panel-heading hbuilt">
                    '.$row['pronombre'].' 
                  </div>
                  <div class="panel-body no-padding">
                    <center>
                      <img class="img-responsive img-thumbnail img-rounded" style="width: 250px; height: 250px" id="img_edit" src="'.$imagen.'"></center></a>
                        <ul class="list-group">
                          <li class="list-group-item">
                            <span class="pull-right">'.$row['proalias'].'</span>
                            <b>ALIAS</b>
                          </li>
                          <li class="list-group-item ">
                            <span class="pull-right">'.$row['grunombre'].'</span>
                            <b>GRUPO</b>
                          </li>
                          <li class="list-group-item">
                            <span class="pull-right">
                              '.$row['procodigo'].'
                            </span>
                            <b>CÓDIGO</b>
                          </li>
                           <li class="list-group-item">
                            <span class="pull-right">
                              '.$row['procodigoanterior'].'
                            </span>
                            <b>CÓDIGO ANTERIOR</b>
                          </li>
                          <li class="list-group-item">
                            <a href="#" class="pull-right barcode" data-id="'.$row['procodigo'].','.$row['pronombre'].'"><span class="fa fa-barcode" style="font-size:large;"></span></a>
                            <b>CÓDIGO DE BARRAS</b>
                          </li>
                        </ul>
                  </div>
                  <div class="panel-footer">
                    Creación: '.$row['procreacion'].'
                  </div>
                </div>
              </div>';
           }else{
               echo '<div class="col-md-4">
                <div class="hpanel">
                <a href="javascript:void(0)" type="button" class="btn_edit_pr" id="btn_edit_prod" data-id=" '.$row['procodigo'].' ">
                  <div class="panel-heading hbuilt">
                    '.$row['pronombre'].' 
                  </div>
                  <div class="panel-body no-padding">
                    <center>
                      <img class="img-responsive img-thumbnail img-rounded" style="width: 250px; height: 250px" id="img_edit" src="'.$imagen.'"></center></a>
                        <ul class="list-group">
                          <li class="list-group-item">
                            <span class="pull-right">'.$row['proalias'].'</span>
                            <b>ALIAS</b>
                          </li>
                          <li class="list-group-item ">
                            <span class="pull-right">'.$row['grunombre'].'</span>
                            <b>GRUPO</b>
                          </li>
                          <li class="list-group-item">
                            <span class="pull-right">
                              '.$row['procodigo'].'
                            </span>
                            <b>CÓDIGO</b>
                          </li>
                          <li class="list-group-item">
                            <span class="pull-right">
                              '.$row['procodigoanterior'].'
                            </span>
                            <b>CÓDIGO ANTERIOR</b>
                          </li>
                          <li class="list-group-item">
                            <a href="#" class="pull-right barcode" data-id="'.$row['procodigo'].','.$row['pronombre'].'"><span class="fa fa-barcode" style="font-size:large;"></span></a>
                            <b>CÓDIGO DE BARRAS</b>
                          </li>
                        </ul>
                  </div>
                  <div class="panel-footer">
                    Creación: '.$row['procreacion'].'
                    <span class="pull-right">Últ. Actualización '.$row['proultactualizacion'].'</span>
                  </div>
                </div>
              </div>';
           }    

        
      }
}else{
  print ".";
}
include "paginar_productos.php";
?>
<div id="modalbarcode" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog"> 
        <div class="modal-content"> 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title">Consultar/Registrar codigo de barras</h5> 
            </div> 
            <div class="modal-body">
                <button id="addbarcode" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Agregar</button>
                <button id="" class="btn btn-primary btn-sm goback" style="display:none;"><span class="fa fa-arrow-left"></span> Regresar</button>
                <div id="nuevobarcode" style="display:none;">
                    <form>
                      <h5>Digite nuevo codigo de barras</h5>
                      <input class="form-control" type="text" id="newbarcode"><br>
                      <button id="savebarcode" class="btn btn-primary">Guardar</button>
                      <button type="reset" class="btn btn-danger goback">Cancelar</button>
                    </form>
                </div>
                <div id="detallebarcode"></div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<script>
  $(".barcode").click(function(e){
      e.preventDefault();
      var datos=$(this).data('id');
      var exploded=datos.split(',');
      var id=exploded[0];
      var nompru=exploded[1];
      //console.log(nompru);
      $.ajax({
          url:'detbarcode.php',
          type:'POST',
          data:'id='+id+'&nompru='+nompru+'&opc=cons',
          dataType:'html',
          success:function(data){
            $("#detallebarcode").html('');
            $("#detallebarcode").html(data);
            $("#modalbarcode").modal('show');
          }
      });
  });

  $("#addbarcode").click(function(e){
    $(this).hide();
    $(".goback").fadeIn();
    $("#detallebarcode").hide();
    $("#nuevobarcode").fadeIn();
  });

  $(".goback").click(function(e){
    $(".goback").hide();
    $("#addbarcode").fadeIn();
    $("#nuevobarcode").hide();
    $("#detallebarcode").fadeIn();
  });

  $("#savebarcode").click(function(e){
    e.preventDefault();
    var id=$("#idprod").val();
    var nompru=$("#nomproducto").val();
    var barcode=$("#newbarcode").val();
    $.ajax({
        url:'detbarcode.php',
        type:'POST',
        data:'id='+id+'&barcode='+barcode+'&opc=ins',
        dataType:'html',
        success:function(res){
            var det=JSON.parse(res);
            $("#newbarcode").val('');
            if(det.res=='true'){
              $.ajax({
                  url:'detbarcode.php',
                  type:'POST',
                  data:'id='+id+'&nompru='+nompru+'&opc=cons',
                  dataType:'html',
                  success:function(data){
                    $("#detallebarcode").html('');
                    $("#detallebarcode").html(data);
                    $(".goback").click();
                  }
              });
            }else if(det.res=='dup'){
              swal('Duplicado!','Este codigo ya se encuentra registrado.','warning');
            }else if(det.res=='des'){
              swal({
                  title: "Codigo inactivo!",
                  text: "Este código ya se encuentra registrado con este producto, pero el codigo está inactivo. desea reactivarlo?",
                  type: "warning",
                  confirmButtonText: "Aceptar",
                  showCancelButton: true,
                  confirmButtonText: "Reactivar!",
                  cancelButtonText: "Cancelar"
                },function(){  
                  $.ajax({
                    url: 'detbarcode.php',
                    method: 'POST',
                    data:'id='+det.id+'&cobar='+det.cobar+'&opc=rea',
                    success: function (data) {
                        if(data=='true'){
                            $.ajax({
                                url:'detbarcode.php',
                                type:'POST',
                                data:'id='+id+'&nompru='+nompru+'&opc=cons',
                                dataType:'html',
                                success:function(data2){
                                  $("#detallebarcode").html('');
                                  $("#detallebarcode").html(data2);
                                  $(".goback").click();
                                }
                            });
                        }else{
                            console.log('boom!');
                        }
                      }
                    
                  });                        
                });
            }
            else if(det.res=='des2'){
              swal('Codigo inactivo!','Este código ya se encuentra registrado con el producto:'+det.prod+', pero el codigo está inactivo.','warning');
            }else{
              swal('Error','Ha ocurrido un error, recargue la página e intentelo nuevamente.','error');
            }
        }
    });  
  });

  $('#modalbarcode').on('hidden.bs.modal', function () {
    $("#newbarcode").val('');
    $(".goback").hide();
    $("#addbarcode").fadeIn();
    $("#nuevobarcode").hide();
    $("#detallebarcode").fadeIn();
  });
</script>