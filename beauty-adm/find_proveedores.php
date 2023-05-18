<?php
include '../cnx_data.php';
    if ($_POST['nombre'] != "") {
        $id = $_POST['nombre'];
        $sql = "SELECT u.trcdocumento, t.tdialias, p.prvemail, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo, b.brrnombre, c.loccodigo, c.locnombre, d.depcodigo, d.depombre FROM btytercero u INNER JOIN  btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btyproveedor p on p.trcdocumento=u.trcdocumento INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo WHERE (u.trcdocumento like '%$id%' or u.trcrazonsocial like '%$id%') and p.prvestado = 1";
    } else {
         $sql="SELECT u.trcdocumento, t.tdialias, p.prvemail, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo, b.brrnombre, c.loccodigo, c.locnombre, d.depcodigo, d.depombre FROM btytercero u INNER JOIN  btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btyproveedor p on p.trcdocumento=u.trcdocumento INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo where p.prvestado = 1";
    }
?>

            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                <span class="label label-success pull-right"> <?php 
                 $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Lista de proveedores</h3>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Email</th>
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

                                            $_SESSION['sqlprv']=$sql;

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {        
                                                    echo "<tr>";
                                echo '<td><a onclick="ver_datos('.$row['trcdocumento'].');" >' . $row['trcrazonsocial'] . '</a> </td>';
                                echo '<td>' . $row['prvemail'] . '</td>';
                                echo '<td>' . $row['trctelefonomovil'] . '</td>';
                                echo '<td>' . $row['trctelefonofijo'] . '</td>';
                                 echo '<td><button class="btn btn-default" title="Editar salon" onclick="editar(' .$row['trcdocumento'] .')"><i class="pe-7s-note text-info"></i> </button> <button class="btn btn-default" title="Eliminar Salon" onclick="eliminar('.$row['trcdocumento'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                               
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