    <?php
    include '../cnx_data.php';
        if ($_POST['nombre'] != "") {
            $id = $_POST['nombre'];
            $sql = "SELECT bodcodigo, bodnombre, bodalias, if(bodestado = 1, 'Activo', 'Inactivo') as estado FROM btybodega WHERE (bodalias LIKE '%$id%' OR bodnombre LIKE '%$id%') AND bodestado = 1";
        } else {
            $sql = "SELECT bodcodigo, bodnombre, bodalias, if(bodestado = 1, 'Activo', 'Inactivo') as estado FROM btybodega where bodestado = 1";
        }
    ?>

    <div class="animate-panel">
        <div class="hpanel">
            <div class="panel-heading">
                <span class="label label-success pull-right"> 
                <?php  
                $query_num_colum = $sql; 
                $resul = $conn->query($query_num_colum); 
                $registros = $resul->num_rows; 
                echo " <h6>No. Registros: ".$registros."</h6>";
                ?>
                </span>
                <h3 class="panel-title">Lista de Bodegas</h3>
                <br>
            </div>
            <div class="panel-body">
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered">
                        <tr class="active">
                            <thead>
                                <th>Nombre</th>
                                <th>Acciones</th>           
                            </thead>
                        </tr>
              
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
                                                echo '<td>' . $row['bodnombre'] . '</td>';
                                                echo '<td><button class="btn btn-default" type="button" id="btn_edit_bodega" data-toggle="modal" data-target="#modal_editar_bodega" title="Editar Bodega" data-id="'.$row['bodcodigo'].'"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" type="button" id="btn_elim_bodega" title="Eliminar Bodega" data-id="'.$row['bodcodigo'].'"><i class="pe-7s-trash text-info"></i></button></td>';
                                            echo '</tr>';
                                            $con++;
                                        }
                                    }

                                        $conn->close();
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

    <style>
        th,td{
            text-align: center;
        }
    </style>