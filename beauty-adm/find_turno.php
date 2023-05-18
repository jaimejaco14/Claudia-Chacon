<?php
include '../cnx_data.php';
    if ($_POST['nombre'] != "") 
    {
        $name = $_POST['nombre'];
        $sql = "SELECT `trncodigo`, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno,`trncolor` from btyturno as t WHERE trnestado = 1  and trnnombre like '".$name."%' ORDER BY trnnombre";
    } 
    else 
    {
        $sql = "SELECT `trncodigo`, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno,`trncolor` from btyturno as t WHERE trnestado = 1 ORDER BY trnnombre";
    }
?>
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <h3 class="panel-title">Lista Turnos </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive"> 
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Nombre</th>
                        <th>Color</th>
                        <th>Acciones</th>                           
                    </thead>
                    <tbody>
                    <?php
                        
        
                        $query_num_col = $sql;

                        $result = $conn->query($query_num_col);
                        $num_total_registros = $result->num_rows;

                        $rowsPerPage = 8;
                         $pageNum = 1;

                        if(isset($_POST['page'])) 
                        {
                            $pageNum = $_POST['page'];
                        }
                        $offset = ($pageNum - 1) * $rowsPerPage;
                        $total_paginas = ceil($num_total_registros / $rowsPerPage);

                        $sql = $sql." limit $offset, $rowsPerPage";
                        if ($result = $conn->query($sql)) 
                        {

                        } 
                        else 
                        {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }

                        if ($result->num_rows > 0) 
                        {
                            while ($row = $result->fetch_assoc()) 
                            {      
                                $a = $row['hordesde'];
                                    echo "<tr>";
                                    echo '<td>' . $row['turno'] . '</td>';
                                    echo '<td> <div class="btn btn-lg" style="background-color: '.$row['trncolor'].';"></div></td>';
                                    echo '<td><button class="btn btn-default" title="Editar turno" onclick="editar('.$row['trncodigo'].')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar turno" onclick="eliminar('.$row['trncodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';                                
                                $con++;
                            }
                        }
                           
                            //$conn->close();
                    ?>
                    </tbody>                        
                </table>
                <?php include "paginate.php"; ?>

            </div>
        </div>
    </div>
</div>