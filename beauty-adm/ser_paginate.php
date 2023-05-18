            <?php 
            include "../cnx_data.php";
            ?>
            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de servicios</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Linea</th>
                        <th>Acciones</th>           
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                        
                                            /*$query_num_col = "SELECT s.sernombre, s.sercodigo, l.linnombre FROM btyservicio s INNER JOIN btysubgrupo sbg ON s.sbgcodigo = sbg.sbgcodigo INNER JOIN btygrupo g ON sbg.grucodigo = g.grucodigo INNER JOIN btysublinea sbl ON sbl.sblcodigo = g.sblcodigo INNER JOIN btylinea l ON l.lincodigo = sbl.lincodigo WHERE serstado = 1";*/
                                            $query_num_col = "SELECT servicio.sercodigo AS codigoServicio, servicio.sernombre AS nombreServicio, grupo.grunombre AS nombreGrupo FROM btyservicio servicio INNER JOIN btycaracteristica ON servicio.crscodigo = btycaracteristica.crscodigo INNER JOIN btysublinea ON btycaracteristica.sblcodigo = btysublinea.sblcodigo INNER JOIN btylinea ON btylinea.lincodigo = btysublinea.lincodigo INNER JOIN btysubgrupo ON btylinea.sbgcodigo = btysubgrupo.sbgcodigo INNER JOIN btygrupo grupo ON grupo.grucodigo = btysubgrupo.grucodigo WHERE servicio.serstado = 1";

                                            $result = $conn->query($query_num_col);
                                            $num_total_registros = $result->num_rows;
            
                                            $rowsPerPage = 8;
                                             $pageNum = 1;

                                            if(isset($_POST['page'])) {
                                                $pageNum = $_POST['page'];
                                            }
                                            $offset = ($pageNum - 1) * $rowsPerPage;
                                            $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                            /*$sql = "SELECT s.sernombre, s.sercodigo, l.linnombre FROM btyservicio s INNER JOIN btysubgrupo sbg ON s.sbgcodigo = sbg.sbgcodigo INNER JOIN btygrupo g ON sbg.grucodigo = g.grucodigo INNER JOIN btysublinea sbl ON sbl.sblcodigo = g.sblcodigo INNER JOIN btylinea l ON l.lincodigo = sbl.lincodigo WHERE serstado = 1 limit $offset, $rowsPerPage";*/
                                            $sql = "SELECT servicio.sercodigo AS codigoServicio, servicio.sernombre AS nombreServicio, grupo.grunombre AS nombreGrupo FROM btyservicio servicio INNER JOIN btycaracteristica ON servicio.crscodigo = btycaracteristica.crscodigo INNER JOIN btysublinea ON btycaracteristica.sblcodigo = btysublinea.sblcodigo INNER JOIN btylinea ON btylinea.lincodigo = btysublinea.lincodigo INNER JOIN btysubgrupo ON btylinea.sbgcodigo = btysubgrupo.sbgcodigo INNER JOIN btygrupo grupo ON grupo.grucodigo = btysubgrupo.grucodigo WHERE servicio.serstado = 1 limit $offset, $rowsPerPage limit $offset, $rowsPerPage";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {        
                                                    echo "<tr>";
                                /*echo '<td>' . $row['sernombre'] . '</td>';
                                echo '<td>' . $row['linnombre'] . '</td>';
                                echo '<td><button class="btn btn-default" title="Editar servicio" onclick="editar(' .$row['sercodigo'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar servicio" onclick="eliminar('.$row['sercodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';*/
                                echo '<td>' . $row['nombreServicio'] . '</td>';
                                echo '<td>' . $row['nombreGrupo'] . '</td>';
                                echo '<td><button class="btn btn-default" title="Editar servicio" onclick="editar(' .$row['codigoServicio'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar servicio" onclick="eliminar('.$row['codigoServicio'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
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
                    <?php                  if ($total_paginas > 1) {
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