<?php
include '../../cnx_data.php';
    if ($_POST['nombre'] != "") 
    {
        $name = $_POST['nombre'];
        $sql = "SELECT * from btytipo_puesto as t WHERE tptestado = 1  and tptnombre like '".$name."%' ORDER BY tptnombre";
    } 
    else 
    {
        $sql = "SELECT * from btytipo_puesto as t WHERE tptestado = 1 ORDER BY tptnombre";
    }
?>
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <h3 class="panel-title">Lista Tipos de puestos </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive"> 
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Nombre</th>
                        <th>Alias</th>
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
                            {  ?>    
                                
                                <tr>
                                    <td> <?php echo $row['tptnombre']?> </td>
                                    <td><?php echo $row['tptalias']?></td>
                                    <td>
                                        <button class="btn btn-default" title="Editar tipo de puesto" onclick="editar('<?php echo $row['tptcodigo']?>')"><i class="pe-7s-note text-info"></i> </button> 
                                        <button class="btn btn-default" title="Eliminar tipo de puesto" onclick="eliminar('<?php echo $row['tptcodigo']?>', this)"><i class="pe-7s-trash text-info"></i></button>
                                    </td>
                                </tr>
                                    <?php                             
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
