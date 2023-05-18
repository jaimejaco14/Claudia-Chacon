<?php
include '../cnx_data.php';
if ($_POST['sln'] != "") {
    $salon = $_POST['sln'];
}
    $sql = "SELECT h.horcodigo, hs.slncodigo, h.hordia, DATE_FORMAT(h.hordesde, '%H:%i') AS desde, DATE_FORMAT(h.horhasta, '%H:%i') AS hasta FROM btyhorario AS h INNER JOIN btyhorario_salon AS hs ON hs.horcodigo = h.horcodigo AND hs.slncodigo = '$salon' ORDER BY FIELD(h.hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')";
?>
<div class="animate-panel">
                <div class="">
                <div class="panel-heading">
                <span class="label label-success pull-right">
                <?php include 'conexion.php'; 

                   $query_num_colum = $sql;
                   $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                   echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">HORARIOS-SALON </h3>
                    <br>
                </div>
                <div class="-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Día</th>
                        
                        <th>Acciones</th>          
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                $query_num_col = $sql;

                                $result = $conn->query($query_num_col);
                                $num_total_registros = $result->num_rows;

                                $rowsPerPage = 8;
                                 $pageNum = 1;

                                if(isset($_POST['page'])) {
                                    $pageNum = $_POST['page'];
                                }
                                $offset = ($pageNum - 1) * $rowsPerPage;
                                $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                $sql = $query_num_col." limit $offset, $rowsPerPage";
                                //echo $sql;
                                if ($result = $conn->query($sql)) {

                                } else {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {      
                                    $a = $row['hordesde'];
                                        echo "<tr>";
                                        echo '<td>' . $row['hordia'] ." DE: ". $row['desde'] ." A: ". $row['hasta'] .'</td>';
                                        echo '<td><button class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Editar horario" id="btn_edit_hor_sln" onclick="editar_hor_sln('.$row['horcodigo'].')"><i class="pe-7s-note text-info"></i> </button></button><button class="btn btn-default" title="Eliminar turno" onclick="eliminar_hor_salon('.$row['horcodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                                        echo '</tr>';
                                        $con++;
                                    }
                                } 
                                else {
                                    echo "<td>No hay resultados</td><td></td>";
                                }
               
                                //$conn->close();
                            ?>
                        </tbody>
                        
                    </table>
                    <?php                 
                     /*if ($total_paginas > 1) {
                        echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1)
                                    echo '<li><a class="paginate" onclick="paginar2('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i)
                                            //si muestro el índice de la página actual, no coloco enlace
                                            echo '<li class="active"><a onclick="paginar2('.$i.');">'.$i.'</a></li>';
                                    else
                                            //si el índice no corresponde con la página mostrada actualmente,
                                            //coloco el enlace para ir a esa página
                                            echo '<li><a class="paginate" onclick="paginar2('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                            }
                            if ($pageNum != $total_paginas)
                                    echo '<li><a class="paginate" onclick="paginar2('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
                       echo '</ul>';
                       echo '</div> </div></center></td></tr> '; 
                         }*/
                         if ($total_paginas > 1) {
                        echo '<br><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1) {
                                echo '<li><a class="paginate" onclick="paginar2('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                            }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i) {
                                        //si muestro el índice de la página actual, no coloco enlace
                                        echo '<li class="active"><a onclick="paginar2('.$i.');">'.$i.'</a></li>';
                                    } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                                        //echo '<li hiddenn><a class="paginate" onclick="paginar_turnoSalon('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                                    } else {
                                        //si el índice no corresponde con la página mostrada actualmente,
                                        //coloco el enlace para ir a esa página
                                        echo '<li><a class="paginate" onclick="paginar2('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                                    }
                                }
                            if ($pageNum != $total_paginas) {
                                echo '<li><a class="paginate" onclick="paginar2('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';    
                            }
                        echo '</ul>';
                        echo '</div> </div></center> <br>';
                    }
                         ?>

                </div>
                </div>
                </div>
                </div>