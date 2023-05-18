    <?php
    include '../cnx_data.php';
        if ($_POST['nombre'] != "") {
            $id = $_POST['nombre'];
            $sql = "SELECT imvcodigo, imvnombre, imvalias, if(imvporcentaje = 1, 'Porcentaje', 'Fijo') as tipo, imvalor, imvestado FROM btyimpuesto_ventas WHERE (imvalias LIKE '%$id%' OR imvnombre LIKE '%$id%') AND imvestado = 1";
        } else {
            $sql = "SELECT imvcodigo, imvnombre, imvalias, imvporcentaje as tipo, imvalor, imvestado FROM btyimpuesto_ventas WHERE imvestado = 1";
        }
    ?>

    <div class="animate-panel">
        <div class="hpanel">
            <div class="panel-heading">
                <span class="label label-success pull-right"> <?php 
                 $query_num_colum = $sql; 
                $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                <h3 class="panel-title">Lista de Impuestos</h3>
                <br>
            </div>
            <div class="panel-body">
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered">
                        <tr class="active">
                            <thead>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Valor</th>
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
                                                echo '<td>' . $row['imvnombre'] . '</td>';
                                            if ($row['tipo'] == 1) {
                                                echo '<td><i class="fa fa-percent"></i></td>';
                                            }else{
                                                echo '<td><i class="fa fa-usd"></i></td>';
                                            }
                                                echo '<td>' . $row['imvalor'] . '</td>';
                                                echo '<td><button class="btn btn-default" title="Editar Impuesto" onclick="editar(' .$row['imvcodigo'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Impuesto" onclick="eliminar('.$row['imvcodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                                            echo '</tr>';
                                            $con++;
                                        }
                                    }

                                       // $conn->close();
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