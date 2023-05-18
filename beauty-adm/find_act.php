<?php
    $id = $_POST['nombre'];
?>

<div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                <!--etiqueta para cuando se realiza un busqueda. En el archivo central se encuentra una etiqueta similar para cuando no se ha relizado ningun tipo de busqueda-->
                <span class="label label-success pull-right"> <?php //include 'conexion.php'; 
                                                               $query_num_colum = "SELECT actcodigo FROM btyactivo WHERE (actnombre LIKE '%".$id."%' OR actcodigo = '".$id."%' or actcodigoexterno like '%".$id."%' ) and actestado = 1"; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Lista de activos</h3>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Fecha compra</th>
                        <th>Modelo</th> 
                        <th>Acciones</th>          
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                            //include 'conexion.php';
                                            $query_num_col = "SELECT actcodigo FROM btyactivo WHERE (actnombre LIKE '%".$id."%' OR actcodigo = '".$id."%' or actcodigoexterno like '%".$id."%' ) and actestado = 1";

                                            $result = $conn->query($query_num_col);
                                            $num_total_registros = $result->num_rows;
            
                                            $rowsPerPage = 8;
                                             $pageNum = 1;

                                            if(isset($_POST['page'])) {
                                                $pageNum = $_POST['page'];
                                            }
                                            $offset = ($pageNum - 1) * $rowsPerPage;
                                            $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                            $sql = "SELECT actnombre, actfechacompra, actmodelo, actcodigo, actimagen FROM `btyactivo` WHERE (actnombre LIKE '%".$id."%' OR actcodigo = '".$id."%' or actcodigoexterno like '%".$id."%') and actestado = 1 limit $offset, $rowsPerPage";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {        
                                                    echo "<tr>";
                                echo '<td>' . $row['actnombre'] . '</td>';
                                echo '<td>' . $row['actfechacompra'] . '</td>';
                                echo '<td>' . $row['actmodelo'] . '</td>';
                                echo '<td><button class="btn btn-default" onclick="img (\'' .$row['actimagen'] .'\')" title="imagen"><i class="fa fa-image text-info"></i> </button><button class="btn btn-default" title="Editar servicio" onclick="editar(' .$row['actcodigo'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Salon" onclick="eliminar('.$row['actcodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                                //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                                echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            }
                           
                                            $conn->close();
                                            ?>
                        </tbody>
                        
                    </table>
                    <?php                  
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
                </div>
                </div>
                </div>