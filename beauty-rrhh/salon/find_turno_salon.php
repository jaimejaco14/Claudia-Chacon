<?php
include '../../cnx_data.php';
if ($_POST['sln_cod'] != "") {
    $sln = $_POST['sln_cod'];
    
}
?>
<div class="animate-panel">
    <div class="hpanel">
    <div class="panel-heading">
        <h3 class="panel-title">Lista Turnos salon </h3>
    </div>
    <div class="panel-body">
        <?php
            /*se seleccionan los dias de la semana contenidos en la tabla btyhorario*/
            $diasem="SELECT distinct(h.hordia) as dia, CONCAT(' DE: ', DATE_FORMAT(h.hordesde, '%H:%i'), ' A: ', DATE_FORMAT( h.horhasta , '%H:%i')) AS hor
                     from btyhorario AS h, btyhorario_salon AS hs 
                     where hs.slncodigo='$sln' and hs.horcodigo=h.horcodigo and h.horestado='1'
                     ORDER BY FIELD(dia, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO', 'FESTIVO')";

            $res=$conn->query($diasem);
            $numdia=0;
            while ($data = $res->fetch_assoc()) { 
                $numdia+=1;
                $day=$data['dia'];/*variable que almacena los dias encontrados en la consulta anterior*/
                $hor=$data['hor'];
            ?>
            <button type="button" class="btn btn-default btn-block" style="text-align: left;" data-toggle="collapse" data-target="#<?php echo $day.$numdia;?>"><?php echo $day." ".$hor;?></button>
            <div id="<?php echo $day.$numdia;?>" class="collapse">
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <th>Turno</th>
                            <th>Acciones</th>       
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                //$id = $_POST['nombre'];
                                
                               // $query_num_col = "SELECT ts.`trncodigo`, t.trnnombre, ts.`horcodigo`, ts.`slncodigo`, h.hordia, h.hordesde, h.horhasta FROM `btyturno_salon` ts INNER JOIN btyturno t ON t.trncodigo = ts.trncodigo INNER JOIN btyhorario h ON ts.horcodigo = h.horcodigo WHERE ts.slncodigo = $sln AND t.`trnestado` = 1";


                            /*para cada dia encontrado en la consulta anterior, se realiza la nueva consulta incluyendo la variable $day (que contiene el dia)*/

                                $query_num_col = "SELECT s.slncodigo, h.horcodigo, t.trncodigo, 
                                CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno
                                
                                FROM btyturno AS t, btyhorario_salon AS hs, btyhorario as h, btyturno_salon as ts, btysalon as s 
                                WHERE h.hordia='$day' and h.horestado='1' and t.trnestado='1' and h.horcodigo=hs.horcodigo and s.slncodigo=hs.slncodigo and t.trnestado = 1 and ts.trncodigo=t.trncodigo and ts.horcodigo=h.horcodigo and s.slncodigo=ts.slncodigo and s.slncodigo='".$sln."' ORDER BY h.hordia, turno";

                                $result = $conn->query($query_num_col);
                                $num_total_registros = $result->num_rows;

                                $rowsPerPage = 8;
                                 $pageNum = 1;

                                if(isset($_POST['page'])) {
                                    $pageNum = $_POST['page'];
                                }
                                $offset = ($pageNum - 1) * $rowsPerPage;
                                $total_paginas = ceil($num_total_registros / $rowsPerPage);

                                $sql = $query_num_col." limit $offset, $rowsPerPage";
                                if ($result = $conn->query($sql)) {

                                } else {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {      
                                        echo "<tr>";
                                        echo '<td>' .$row['turno'] .'</td>';                                  
                                        echo '<td>
                                            <button class="btn btn-default" title="Editar turno" onclick="editar2('.$row['trncodigo'].', '.$row['horcodigo'].', '.$row['slncodigo'].' )"><i class="pe-7s-note text-info"></i> </button>
                                            <button class="btn btn-default" title="Eliminar turno" onclick="eliminar2('.$row['trncodigo'].', this, '.$row['horcodigo'].', '.$row['slncodigo'].')"><i class="pe-7s-trash text-info"></i></button>
                                             </td>';
                                        echo '</tr>';
                                    $con++;
                                    }
                                }
                                ?>
                        </tbody>      
                    </table>
                    <?php
                     if ($total_paginas > 1) {
                        echo '<br><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1) {
                                echo '<li><a class="paginate" onclick="paginar_turnoSalon('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                            }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i) {
                                        //si muestro el índice de la página actual, no coloco enlace
                                        echo '<li class="active"><a onclick="paginar_turnoSalon('.$i.');">'.$i.'</a></li>';
                                    } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                                        //echo '<li hiddenn><a class="paginate" onclick="paginar_turnoSalon('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                                    } else {
                                        //si el índice no corresponde con la página mostrada actualmente,
                                        //coloco el enlace para ir a esa página
                                        echo '<li><a class="paginate" onclick="paginar_turnoSalon('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                                    }
                                }
                            if ($pageNum != $total_paginas) {
                                echo '<li><a class="paginate" onclick="paginar_turnoSalon('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';    
                            }
                        echo '</ul>';
                        echo '</div> </div></center> <br>';
                    }
                    ?>
                </div>
            </div>
            <?php
            }
        ?>     
    </div>
    </div>
</div>              