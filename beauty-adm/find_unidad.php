<?php
include '../cnx_data.php';
    if ($_POST['nombre'] != "") {
        $id = $_POST['nombre'];
        $sql = "SELECT `umecodigo`, `umenombre`, `umealias`, `umeestado` FROM `btyunidad_medida` WHERE  (umealias like '%$id%' or umenombre like '%$id%') and `umeestado` = 1";
    } else {
        $sql = "SELECT `umecodigo`, `umenombre`, `umealias`, `umeestado` FROM `btyunidad_medida` WHERE  `umeestado`= 1";
    }
?>

            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                <span class="label label-success pull-right"> <?php 
                 $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Lista Unidad</h3>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Alias</th>
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

                                            $sql = $sql." limit $offset, $rowsPerPage";
                                        
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {        
                                                    echo "<tr>";
                                echo '<td>' . $row['umenombre'] . '</td>';
                                echo '<td>' . $row['umealias'] . '</td>';
                                echo '<td><button class="btn btn-default" title="Editar salon" onclick="editar(' .$row['umecodigo'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Salon" onclick="eliminar('.$row['umecodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                                //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                                echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            }
                           
                                            //$conn->close();
                                            ?>
                        </tbody>
                        
                    </table>
                    <?php                  
             include "paginate.php";
                    ?>

                </div>
                </div>
                </div>
                </div>