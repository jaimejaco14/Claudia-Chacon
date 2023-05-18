<?php $codigoColaborador = $_POST['codigo']; ?>
<br>    
<table id="example2" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><center><i class="fa fa-plus" style="color: #62cb31;"></i></center></th>
            <th>NOMBRE</th>
            <th>CARACTERISTICA</th>
            <th>SUBLINEA</th>
            <th>LINEA</th>
            <th>SUBGRUPO</th>
            <th>GRUPO</th>
            
        </tr>
    </thead>
<tbody>
<?php
include "../../cnx_data.php";

if ($_POST['grupo'] != "" and $_POST['grupo'] != 0){
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo AND g.grucodigo = ".$_POST['grupo']." WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";    
} else if ($_POST['subgrupo'] != "" and $_POST['subgrupo'] != 0 ) {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo AND sbg.sbgcodigo = ".$_POST['subgrupo']." INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";
} else if ($_POST['linea'] != "" and $_POST['linea'] != 0 ) {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo AND l.lincodigo = ".$_POST['linea']." INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";
} else if ($_POST['sublinea'] != "" and $_POST['sublinea'] != 0 ) {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo AND sbl.sblcodigo = ".$_POST['sublinea']." INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";
} else if ($_POST['caracteristica'] != "" and $_POST['caracteristica'] != 0 ) {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo AND c.crscodigo = ".$_POST['caracteristica']." INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";
} else if ($_POST['nombre'] != "") {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) AND s.sernombre LIKE '".$_POST['nombre']."%' ORDER BY s.sernombre";
} else {
     $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $codigoColaborador AND sec.secstado = 1) ORDER BY s.sernombre";
}
$query_num_col = $sql;
$result = $conn->query($query_num_col);
  $num_total_registros = $result->num_rows;
  $rowsPerPage = 4;
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
        echo "<tr>
            <td><button class='btn btn-sm btn-default' title='Agregar Servicio' type='button' onclick='agregar_servicio(".$row['sercodigo'].", ".$codigoColaborador.", this)'><i class='fa fa-plus-square-o text-info'></i></button></td>
            <td>".utf8_encode($row['sernombre'])."</td>
            <td>".utf8_encode($row['crsnombre'])."</td>
            <td>".utf8_encode($row['sblnombre'])."</td>
            <td>".utf8_encode($row['linnombre'])."</td>
            <td>".utf8_encode($row['sbgnombre'])."</td>
            <td>".utf8_encode($row['grunombre'])."</td>
        </tr>";
    }
} else {
    echo "<tr><td style='border: 0'><center></center></td><td style='border: 0'>No tiene</td><td style='border: 0'>servicios autorizados</td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td></tr>";
}
?>
</tbody>
</table>
<?php
  if ($total_paginas > 1) {
                        echo '<br><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1) {
                                echo '<li><a class="paginate" onclick="paginar_serviciosAdd('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                            }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i) {
                                        //si muestro el índice de la página actual, no coloco enlace
                                        echo '<li class="active"><a onclick="paginar_serviciosAdd('.$i.');">'.$i.'</a></li>';
                                    } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                                        //echo '<li hiddenn><a class="paginate" onclick="paginar_serviciosAdd('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                                    } else {
                                        //si el índice no corresponde con la página mostrada actualmente,
                                        //coloco el enlace para ir a esa página
                                        echo '<li><a class="paginate" onclick="paginar_serviciosAdd('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                                    }
                                }
                            if ($pageNum != $total_paginas) {
                                echo '<li><a class="paginate" onclick="paginar_serviciosAdd('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';    
                            }
                       echo '</ul>';
                       echo '</div> </div></center> <br>';
                    }
?>

