<?php
include '../../cnx_data.php';
    if ($_POST['nombre'] != "") {
        $id = $_POST['nombre'];
        $sql = "SELECT slncodigo, slnnombre, slntelefonofijo, slntelefonomovil, slnextensiontelefonofijo, slnimagen FROM `btysalon` WHERE (slncodigo like '%$id%' or slnnombre like '%$id%') and slnestado = 1";
    } else {
        $sql = "SELECT slncodigo, slnnombre, slntelefonofijo, slntelefonomovil, slnextensiontelefonofijo, slnimagen FROM `btysalon` WHERE slnestado = 1 ORDER BY slnnombre";
    }
?>



            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                <span class="label label-success pull-right"> <?php  $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Lista de salones</h3>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Tel&eacute;fono fijo</th>
                        <th>Tel&eacute;fono m&oacute;vil</th>
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
                                echo '<td><a onclick="ver_datos('.$row['slncodigo'].');" >' . $row['slnnombre'] . '</a> </td>';
                                echo '<td>' . $row['slntelefonofijo'] .' - '.$row['slnextensiontelefonofijo']. '</td>';
                                echo '<td>' . $row['slntelefonomovil'] . '</td>';
                                echo '<td><button class="btn btn-default" onclick="img (\'' .$row['slnimagen'] .'?id?12'.date('ymdHi').'\', \''.$row['slnnombre'].'\')" title="imagen"><i class="fa fa-image text-info"></i> </button> <button class="btn btn-default" title="Editar salon" onclick="editar(' .$row['slncodigo'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Salon" onclick="eliminar('.$row['slncodigo'].', this)"><i class="pe-7s-trash text-info"></i></button><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_ver_bodegas" title="Bodegas" id="btn_list_bodeg" data-id="'.$row['slncodigo'].'" data-salon="'.$row['slnnombre'].'"><i class="fa fa-th text-info"></i></button></td>';
                                //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                                echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            }
                           
                                        
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

           