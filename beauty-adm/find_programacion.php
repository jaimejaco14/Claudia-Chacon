<?php
include '../cnx_data.php';
    if ($_POST['nombre'] != "") 
    {
        $name = $_POST['nombre'];
        $sql = "SELECT * from btytipo_programacion as t WHERE tprestado = 1  and tprnombre like '".$name."%' ORDER BY tprnombre";
    } 
    else 
    {
        $sql = "SELECT * from btytipo_programacion as t WHERE tprestado = 1 ORDER BY tprnombre";
    }
?>
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <h3 class="panel-title">Lista tipos de programacion </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive"> 
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Nombre</th>
                        <th>Alias</th>
                        <th>Labora</th> 
                        <th>Color</th>        
                        <th>Acciones</th>                          
                    </thead>
                    <tbody>
                    <?php
                        
                        //include 'conexion.php';
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
                                    <td> <?php echo $row['tprnombre']?> </td>
                                    <td><?php echo $row['tpralias']?></td>
                                    <td><?php if($row['tprlabora']==1){echo "SI";}else{echo "NO";} ?></td>
                                    <td><div class="btn btn-lg" style="background-color:<?php echo $row['tprcolor'];?>;"></div></td>
                                    <td>
                                        <button class="btn btn-default" title="Editar tipo de programacion" onclick="editar('<?php echo $row['tprcodigo']?>')"><i class="pe-7s-note text-info"></i> </button> 
                                        <button class="btn btn-default" title="Eliminar tipo de programacion" onclick="eliminar('<?php echo $row['tprcodigo']?>', this)"><i class="pe-7s-trash text-info"></i></button>
                                    </td>
                                </tr>
                                    <?php                             
                                $con++;
                            }
                        }
                           
                            $conn->close();
                    ?>
                    </tbody>                        
                </table>
                <?php include "paginate.php"; ?>

            </div>
        </div>
    </div>
</div>
