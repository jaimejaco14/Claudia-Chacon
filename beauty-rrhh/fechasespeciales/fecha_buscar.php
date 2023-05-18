    <?php
    include '../../cnx_data.php';
        if ($_POST['nombre'] != "") {
            $id = $_POST['nombre'];
            $sql = "SELECT fescodigo, festipo, fesfecha, UPPER(DATE_FORMAT(fesfecha, '%W %d DE %M  DE %Y')) as fecha, fesobservacion, fesestado FROM btyfechas_especiales WHERE YEAR(fesfecha)=YEAR(CURDATE()) and festipo LIKE '%$id%' AND fesestado = 1";
        } else {
            $sql = "SELECT fescodigo, festipo, fesfecha, UPPER(DATE_FORMAT(fesfecha, '%W %d DE %M  DE %Y')) as fecha, fesobservacion, fesestado FROM btyfechas_especiales WHERE YEAR(fesfecha)=YEAR(CURDATE()) and fesestado = 1";
        }
    ?>

    <div class="animate-panel">
        <div class="hpanel">
            <div class="panel-heading">
                <span class="label label-success pull-right"> <?php 
                 $query_num_colum = $sql; 
                $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                <h3 class="panel-title">Lista de Fechas Especiales</h3>
                <br>
            </div>
            <div class="panel-body">
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered">
                        <tr class="active">
                            <thead>
                                <th>Tipo de Fecha</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>           
                            </thead>
                        </tr>
              
                        <tbody>
                        <?php
                            
                            $query_num_col = $sql;

                             mysqli_query( $conn, "SET lc_time_names = 'es_CO'" ); 


                            $result = $conn->query($query_num_col);
                            $num_total_registros = $result->num_rows;

                            $rowsPerPage = 8;
                            $pageNum = 1;

                            if(isset($_POST['page'])) {
                                $pageNum = $_POST['page'];
                            }
                                $offset = ($pageNum - 1) * $rowsPerPage;
                                $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                $sql = $sql." ORDER BY fesfecha ASC limit $offset, $rowsPerPage";

                                $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {        
                                            echo "<tr>";
                                                echo '<td>' . $row['festipo'] . '</td>';
                                                echo '<td>' . utf8_encode($row['fecha']) . '</td>';
                                                echo '<td>' . utf8_encode($row['fesobservacion']) . '</td>';
                                                echo '<td><button class="btn btn-default" id="btn_editar_fecha" data-toggle="modal" data-target="#modal_edit" title="Editar Fecha" data-id="'.$row['fescodigo'].'" ><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Fecha" data-id="'.$row['fescodigo'].'" id="btn_eliminar"><i class="pe-7s-trash text-info"></i></button></td>';
                                            echo '</tr>';
                                            $con++;
                                        }
                                    }else{
                                        echo'<tr><td colspan="4">No hay resultados</td></tr>';
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

    <style>
        th,td{
            text-align: center;
        }
    </style>