<?php 
include "../cnx_data.php";
?>
<div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                <!--duplicacion e la etiqueta ya que el archivo de busqueda del modulo tiene otra estructura similar pero separada-->
                 <span class="label label-success pull-right"> <?php 
                 
                                                               $query_num_colum = "SELECT sescodigo FROM btysesiones"; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Total de Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Listado de Sesiones</h3>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                  <thead>
                        <th>Usuario</th>
                        <th>Direccion IP</th>
                        <th>Dispositivo</th> 
                        <th>Navegador</th> 
                        <th>Inicio de Sesion</th>     
                        <th>Fin de sesion</th>
                        <th>Estado Sesion</th>
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                            
                                            $query_num_col = "SELECT sescodigo FROM btysesiones ";

                                            $result = $conn->query($query_num_col);
                                            $num_total_registros = $result->num_rows;
            
                                            $rowsPerPage = 8;
                                             $pageNum = 1;

                                            if(isset($_POST['page'])) {
                                                $pageNum = $_POST['page'];
                                            }
                                            $offset = ($pageNum - 1) * $rowsPerPage;
                                            $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                            $sql = "SELECT sescodigo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado FROM btysesiones  limit $offset, $rowsPerPage";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {        
                                                    echo "<tr>";
                                echo '<td>' .  strtoupper($row['seslogin']) . '</td>';
                                echo '<td>' . $row['sesdireccionipv4wan'] . '</td>';
                                echo '<td>' . $row['sestipodispotivo'] . '</td>';
                                echo '<td>' . $row['sesnavegador'] . '</td>';
                                echo '<td>' .  $row['sesfechainicio'].' / '.$row['seshorainicio'] . '</td>';
                                echo '<td>' . $row['sesfechafin']. ' / '. $row['seshorafin']. '</td>';
                              
                              if ($row['sesfallida'] == 1 && $row['sesestado'] == 0) {
                                    echo '<td class="text-center"  > <span data-toggle="tooltip" title="¡Intento Fallido!" class=" text-danger glyphicon glyphicon-ban-circle fa-2x"></span> </td>';
                                }else if ($row['sesfallida'] == 0 && $row['sesestado'] == 1) {
                                    echo '<td class="text-center"  > <span data-toggle="tooltip" title="Usuario Activo"  class=" text-info glyphicon glyphicon-ok-circle fa-2x"></span> </td>';
                                }else{
                                    echo '<td class="text-center" > <span  data-toggle="tooltip" title="Desconcectado" class=" text-warning glyphicon glyphicon-remove-circle fa-2x"></span> </td>';
                                }
                          
                          
                                echo '</tr>';
                                $con++;
 
                                                }
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
                <script type="text/javascript">
                    $('[data-toggle="tooltip"]').tooltip();
                </script>