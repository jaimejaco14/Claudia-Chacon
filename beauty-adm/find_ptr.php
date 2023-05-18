<?php
include '../cnx_data.php';

    if ($_POST['sln_cod'] != "") 
    {
    $sln = $_POST['sln_cod'];
    }
?>
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <span class="label label-success pull-right"> 
                <?php  
                    $query_num_colum = "SELECT p.ptrnombre, p.ptrubicacion FROM btypuesto_trabajo p INNER JOIN btytipo_puesto t ON t.tptcodigo = p.tptcodigo WHERE slncodigo = $sln and ptrestado = 1 order by p.ptrnombre asc";

                    $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                    echo " <h6>No. Registros: ".$registros."</h6>";
                ?>
            </span>
            <h3 class="panel-title">Lista puestos de trabajo</h3>
            <br>
        </div>
        <div class="panel-body">
            <div class="table-responsive"> 
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Nombre</th>
                        <th>Ubicacion</th>
                        <th>Tipo</th>
                        <th>Clase</th>
                        <th>Acciones</th>           
                    </thead>
                    <tbody>
                        <?php

                            $query_num_col = "SELECT p.`ptrnombre`, p.`ptrubicacion` FROM `btypuesto_trabajo` p INNER JOIN btytipo_puesto t ON t.tptcodigo = p.tptcodigo WHERE slncodigo = $sln and ptrestado = 1 order by p.ptrnombre asc";

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

                            $sql = "SELECT p.ptrnombre, p.ptrubicacion, t.tptnombre, p.ptrcodigo,p.ptrmultiple, p.ptrimagen FROM `btypuesto_trabajo` p INNER JOIN btytipo_puesto t ON t.tptcodigo = p.tptcodigo WHERE slncodigo = $sln and ptrestado = 1 order by p.ptrnombre asc, t.tptnombre asc limit $offset, $rowsPerPage ";

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
                                    echo "<tr>";
                                    echo '<td>' . $row['ptrnombre'] . '</td>';
                                    echo '<td>' . $row['ptrubicacion'] . '</td>';
                                    echo '<td>' . $row['tptnombre'] . '</td>';
                                    
                                    if ($row['ptrmultiple'] == 0) 
                                    {
                                        echo '<td style="text-align: center"> <i class="fa fa-user"></i></td>';
                                    }
                                    else
                                    {
                                        echo '<td style="text-align: center"><i class="fa fa-users"></i> </td>';
                                    }

                                    echo '<td>
                                    <button class="btn btn-default" onclick="img (\'' .$row['ptrimagen'] .'?id?12'.date('ymdHi').'\',\''.$row['ptrnombre'].'\')" title="imagen"><i class="fa fa-image text-info"></i> </button> 
                                    <button class="btn btn-default" title="Editar puesto" onclick="editar(' .$row['ptrcodigo'] .')"><i class="pe-7s-note text-info"></i> </button> 
                                    <button class="btn btn-default" title="Eliminar puesto" onclick="eliminar('.$row['ptrcodigo'].', this)"><i class="pe-7s-trash text-info"></i></button>
                                    </td>';

                                    echo '</tr>';
                                    $con++;
                                }
                            }

                            $conn->close();
                        ?>
                    </tbody>

                </table>
                <?php include 'paginate.php';?>
            </div>
        </div>
    </div>
</div>

<style type="text/css" media="screen">
th{
    text-align: center;
}
</style>

