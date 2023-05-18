<?php 
include '../../cnx_data.php'; 
if($_POST['nombre']){
    $id=$_POST['nombre'];
    $sql= "SELECT ac.actnombre, ac.actfechacompra, ac.actmodelo, ac.actcodigo, ac.actimagen, ma.marnombre
            FROM btyactivo ac 
            natural join btyactivo_marca ma 
            WHERE (ac.actnombre LIKE '%".$id."%' OR ac.actcodigo = '".$id."%' or ac.actcodigoexterno like '%".$id."%') and ac.actestado = 1 order by ac.actnombre";
}else{
    $sql = "SELECT ac.actnombre, ac.actfechacompra, ac.actmodelo, ac.actcodigo, ac.actimagen, ma.marnombre
            FROM btyactivo ac 
            natural join btyactivo_marca ma 
            WHERE ac.actestado = 1 order by ac.actnombre";
}
?>
<div class="panel-heading">
     <span class="label label-success pull-right"> 
        <?php 

            $query_num_colum = $sql; 
            $resul = $conn->query($query_num_colum); 
            $registros = $resul->num_rows; 
            echo " <h6>No. Registros: ".$registros."</h6>";
        ?>
    </span>
    <br>
</div>
<div class="content">
    
            <?php

            $rowsPerPage = 8;
            $pageNum = 1;

            if(isset($_POST['page'])) {
                $pageNum = $_POST['page'];
            }
            $offset = ($pageNum - 1) * $rowsPerPage;
            $total_paginas = ceil($registros / $rowsPerPage);

            $sql2=$sql." limit $offset, $rowsPerPage";
            $result = $conn->query($sql2);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {        
                if ($row['actimagen'] != "default.jpg") 
                  {
                     $imagen = "../contenidos/imagenes/activo/".$row['actimagen']."" ;
                  }
                  else
                  {
                    $imagen =  "../contenidos/imagenes/default.jpg" ;
                  } 
                ?>

                <!-- <a href="javascript:void(0)" type="button" class="btn_detactivo" id="btn_detactivo" data-id="<?php echo $row['actcodigo'];?>"> -->
                <a href="detalleact.php?id_act=<?php echo $row['actcodigo'];?>" type="button">
                    <div class="col-lg-3">
                        <div class="hpanel hgreen contact-panel" style="max-height:290px;min-height:290px;">
                            <div class="panel-body" style="min-height:200px;overflow-x: auto;">
                                <img alt="imagen activo" class="img-thumbnail m-b" width="100" src="<?php echo $imagen;?>?<?php echo time(); ?>" onerror="this.src='../contenidos/imagenes/default.jpg';">
                                <h5 class="nomactivo"><?php echo utf8_encode($row['actnombre']);?></h5>
                                <div class="text-muted font-bold m-b-xs">Codigo: <?php echo $row['actcodigo'];?></div>
                                <div class="text-muted font-bold m-b-xs">Marca:<?php echo utf8_encode($row['marnombre']);?></div>
                                <div class="text-muted font-bold m-b-xs">Mod: <?php echo utf8_encode($row['actmodelo']);?></div>
                            </div>
                </a>
                            <div class="panel-footer contact-footer">
                                <div class="row">
                                   <div class="col-md-10">
                                        <h6><b>Comprado: </b><?php echo $row['actfechacompra'];?></h6>
                                   </div>
                                   <div class="col-md-2">
                                        <button class="btn btn-default pull-right" data-toggle="tooltip" data-placement="right" title="Eliminar activo" onclick="eliminar(<?php echo $row['actcodigo'];?>, this)"><i class="pe-7s-trash text-info"></i></button>
                                   </div>
                               </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                <?php

                }
            }
            else{
                echo 'No hay datos para mostrar';
            }

            ?>

        <?php  
        //paginacion                
        if ($total_paginas > 1) {
            echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
            echo '<ul class="pagination pull-right"></ul>';
                if ($pageNum != 1)
                        echo '<li><a class="paginate" onclick="paginar('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                    for ($i=1;$i<=$total_paginas;$i++) {
                        if ($pageNum == $i)
                                //si muestro el índice de la página actual, no coloco enlace
                                echo '<li class="active"><a onclick="paginar('.$i.');">'.$i.'</a></li>';
                        else
                                //si el índice no corresponde con la página mostrada actualmente,
                                //coloco el enlace para ir a esa página
                                echo '<li><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                }
                if ($pageNum != $total_paginas)
                        echo '<li><a class="paginate" onclick="paginar('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
           echo '</ul>';
           echo '</div> </div></center></td></tr> '; 
        }
        ?>


</div>
