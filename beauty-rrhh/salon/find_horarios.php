<?php
include '../../cnx_data.php';
if ($_POST['name'] != "") {
    $nombre = $_POST['name'];
    $sql = "SELECT `hordia`, DATE_FORMAT(hordesde, '%H:%i') as desde, DATE_FORMAT(horhasta, '%H:%i') as hasta, horcodigo FROM `btyhorario` WHERE horestado = 1 and(hordia like '".$nombre."%' OR horcodigo = '$nombre') ORDER BY FIELD(hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')";
} else {
    $sql = "SELECT `hordia`, DATE_FORMAT(hordesde, '%H:%i') as desde, DATE_FORMAT(horhasta, '%H:%i') as hasta, horcodigo FROM `btyhorario` WHERE horestado = 1 ORDER BY FIELD(hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')";
}
?>
<div class="animate-panel">
    <div class="">
        <div class="panel-heading">
        <span class="label label-success pull-right"> <?php 

           $query_num_colum = $sql;
           $resul = $conn->query($query_num_colum); 
           $registros = $resul->num_rows; 
           echo " <h6>No. Registros: ".$registros."</h6>";?></span>
            <h3 class="panel-title">HORARIOS </h3>
            <br>
        </div>
        <div class="-body">
            <div class="table-responsive"> 
            <table class="table table-hover table-bordered table-striped">
                <thead>
                <th>Horario</th>
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
                        if ($result = $conn->query($sql)) {

                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {      
                            $a = $row['hordesde'];
                                echo "<tr>";
                                echo '<td>' . $row['hordia'] ." DE: ". $row['desde'] ." A: ". $row['hasta'] .'</td>';
                                echo '<td>
                                <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="right" title="Editar horario" id="btn_edit_salon_" onclick="editar('.$row['horcodigo'].')"><i class="pe-7s-note text-info"></i>
                                </button><button class="btn btn-default" title="Eliminar turno" onclick="eliminar('.$row['horcodigo'].', this)"><i class="pe-7s-trash text-info"></i></button></td>';
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
                if ($total_paginas > 1) {
                echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
                echo '<ul class="pagination pull-right"></ul>';
                    if ($pageNum != 1)
                            echo '<li><a class="paginate" onclick="paginar('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                        for ($i=1;$i<=$total_paginas;$i++) {
                            if ($pageNum == $i)
                                    //si muestro el índice de la página actual, no coloco enlace
                                    echo '<li class="active"><a onclick="paginar('.$i.');">'.$i.'</a></li>';
                            else
                                    //si el índice no corresponde con la página mostrada actualmente,
                                    //coloco el enlace para ir a esa página
                                    echo '<li><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                    }
                    if ($pageNum != $total_paginas)
                            echo '<li><a class="paginate" onclick="paginar('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
               echo '</ul>';
               echo '</div> </div></center></td></tr> '; 
                }
            ?>

            </div>
        </div>
    </div>
</div>