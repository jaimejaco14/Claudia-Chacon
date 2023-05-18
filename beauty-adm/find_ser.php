<?php
   include "../cnx_data.php";
if ($id = $_POST['nombre']) {
    /*$sql = "SELECT servicio.sercodigo AS codigoServicio, servicio.sernombre AS nombreServicio, grupo.grunombre AS nombreGrupo FROM btyservicio servicio INNER JOIN btycaracteristica ON servicio.crscodigo = btycaracteristica.crscodigo INNER JOIN btysublinea ON btycaracteristica.sblcodigo = btysublinea.sblcodigo INNER JOIN btylinea ON btylinea.lincodigo = btysublinea.lincodigo INNER JOIN btysubgrupo ON btylinea.sbgcodigo = btysubgrupo.sbgcodigo INNER JOIN btygrupo grupo ON grupo.grucodigo = btysubgrupo.grucodigo WHERE servicio.serstado = 1 and (servicio.sernombre like '".$id."%' or servicio.sercodigo = '$id')";*/
    $sql = "SELECT s.sercodigo AS codigoServicio, s.sernombre AS nombreServicio, s.crsnombre AS nombreCaracteristica,se.serimagen AS img, se.sercreacion as fc, se.serultactualizacion as fa, se.serrequiereinsumos as insumo
            FROM bty_vw_servicios_categorias AS s 
            NATURAL JOIN btyservicio as se
            WHERE serstado = 1 AND (sernombre LIKE '%".$id."%' or sercodigo = '$id') ";
} else {
    /*$sql = "SELECT servicio.sercodigo AS codigoServicio, servicio.sernombre AS nombreServicio, grupo.grunombre AS nombreGrupo FROM btyservicio servicio INNER JOIN btycaracteristica ON servicio.crscodigo = btycaracteristica.crscodigo INNER JOIN btysublinea ON btycaracteristica.sblcodigo = btysublinea.sblcodigo INNER JOIN btylinea ON btylinea.lincodigo = btysublinea.lincodigo INNER JOIN btysubgrupo ON btylinea.sbgcodigo = btysubgrupo.sbgcodigo INNER JOIN btygrupo grupo ON grupo.grucodigo = btysubgrupo.grucodigo WHERE servicio.serstado = 1";*/
    $sql = "SELECT s.sercodigo AS codigoServicio, s.sernombre AS nombreServicio, s.crsnombre AS nombreCaracteristica,se.serimagen AS img, se.sercreacion as fc, se.serultactualizacion as fa, se.serrequiereinsumos as insumo
            FROM bty_vw_servicios_categorias AS s 
            NATURAL JOIN btyservicio as se
            WHERE serstado = 1 ORDER BY nombreServicio";

} 
?>
                        

        <div class="panel-heading">
         <span class="label label-success pull-left"> <?php  $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Total de Registros: ".$registros."</h6>";?></span>
     
            <br>
        </div>
        <div class="content">
                    <?php
                        //$id = $_POST['nombre'];
                        $query_num_col       = $sql;
                        $result              = $conn->query($query_num_col);
                        $num_total_registros = $result->num_rows;
                        
                        $rowsPerPage         = 8;
                        $pageNum             = 1;

                        if(isset($_POST['page'])) {
                            
                            $pageNum = $_POST['page'];
                        }

                        $offset        = ($pageNum - 1) * $rowsPerPage;
                        $total_paginas = ceil($num_total_registros / $rowsPerPage);
                        $sql           = $sql." limit $offset, $rowsPerPage";
                        $result        = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            
                            while ($row = $result->fetch_assoc()) {        

                                    if ($row['img'] != "default.jpg") 
                                      {
                                         $imagen = "../contenidos/imagenes/servicio/".$row['img']."" ;
                                      }
                                      else
                                      {
                                        $imagen =  "../contenidos/imagenes/default.jpg" ;
                                      } 

                                ?>
                                <a href="javascript:void(0)" type="button" class="detalleser" id="btn_detaser" data-id="<?php echo $row['codigoServicio'].'•'.$row['nombreServicio'].'•'.$row['insumo'];?>">
                                    <div class="col-lg-3">
                                        <div class="hpanel hgreen contact-panel" style="max-height:290px;min-height:290px;">
                                            <div class="panel-body" style="min-height:220px;overflow-x: auto;">
                                                <img alt="logo" class="img-thumbnail m-b" width="100" src="<?php echo $imagen;?>?<?php echo time() ?>" onerror="this.src='../contenidos/imagenes/default.jpg';">
                                                <h5 class="nombservicio"><?php echo utf8_encode($row['nombreServicio']);?></h5>
                                                <div class="text-muted font-bold m-b-xs"><?php echo utf8_encode($row['nombreCaracteristica']);?></div>
                                            </div>
                                </a>
                                            <div class="panel-footer contact-footer">
                                                <div class="row">
                                                   <div class="col-md-10">
                                                        <h6><b>Creado: </b><?php echo $row['fc'];?></h6>
                                                        <?php if($row['fc']!=$row['fa']){echo '<b>Actualizado: </b>'.$row['fa'];}?>
                                                   </div>
                                                   <div class="col-md-2">
                                                        <button class="btn btn-default pull-right" data-toggle="tooltip" data-placement="right" title="Eliminar servicio" onclick="eliminar(<?php echo $row['codigoServicio'];?>, this)"><i class="pe-7s-trash text-info"></i></button>
                                                   </div>
                                               </div>
                                                    
                                               
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                 $con++;
                            //onclick="eliminar('.$row['sercodigo'].', this)"
                            }
                        }
       
         
                        ?>
                </tbody> 
            </table>
            <script>
                $(".detalleser").click(function(e){
                    var ext=$(this).data('id');
                    var datos = ext.split('•');
                    var ser=datos[0];
                    var nomser=datos[1];
                    var sw=datos[2];
                    editarServicio(ser);
                    $("#selser").val(ser);
                    $(".titulo").text(nomser);
                    $(".deta").show();
                    if(sw==1){
                        $(".ins").show();
                    }
                    $(".lista").removeClass('active');
                    $("#tab-1").removeClass('active');
                    $(".deta").addClass('active');
                    $("#tab-2").addClass('active');
                });

                

            </script>       
            <?php include 'paginate.php'; ?>
        </div>

