
<div class="animate-panel">
                <div class="">
                <div class="panel-heading">
                 <span class="label label-success pull-right"> <?php include '../cnx_data.php';

                                                               $query_num_colum = "SELECT `horcodigo` FROM `btyhorario` ";
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Total de Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">HORARIOS-SALON </h3>
                    <br>
                </div>
                <div class="-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Día</th>
                        <th>Hora de apertura</th>
                        <th>Hora de cierre</th>
                        <th>Acciones</th>           
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                            //$id = $_POST['nombre'];
                                            
                                            
                                            $query_num_col = "SELECT h.`horcodigo`, h.`hordia`, h.`hordesde`, h.`horhasta` FROM `btyhorario` h ";

                                            $result = $conn->query($query_num_col);
                                            $num_total_registros = $result->num_rows;
            
                                            $rowsPerPage = 8;
                                             $pageNum = 1;

                                            if(isset($_POST['page'])) {
                                                $pageNum = $_POST['page'];
                                            }
                                            $offset = ($pageNum - 1) * $rowsPerPage;
                                            $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                            $sql ="SELECT h.`horcodigo`, h.`hordia`, h.`hordesde`, h.`horhasta` FROM `btyhorario` h  limit $offset, $rowsPerPage";
                                            if ($result = $conn->query($sql)) {

                                            } else {
                                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                            }
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {      
                                                $a = $row['hordesde'];
                                                    echo "<tr>";
                                echo '<td>' . $row['hordia'] . '</td>';
                                echo '<td>' .substr($row['hordesde'], 0, -3). '</td>';                                      //"\''+comment+'\'"
                                echo '<td>' . substr($row['horhasta'], 0, -3) . '</td>';
                                echo '<td><button class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Editar horario" onclick="editar('.$row['horcodigo'].')"><i class="pe-7s-note text-info"></i> </button> </td>';
                                //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                                echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            } else {
                                                echo "<td>No hay resultados</td><td></td><td></td><td></td>";
                                            }
                           
                                            
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