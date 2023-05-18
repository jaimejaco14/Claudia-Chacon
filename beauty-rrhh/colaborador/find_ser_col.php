
<table id="example2" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>CARACTERISTICA</th>
            <th>SUBLINEA</th>
            <th>LINEA</th>
            <th>SUBGRUPO</th>
            <th>GRUPO</th>
            <th><center><i class="fa fa-check-square-o"></i></center></th>
        </tr>
    </thead>
<tbody>
<?php
$codigo = $_POST['codi'];
$col = $_POST['col'];
if ($_POST['table']== "lin") {
    # code...
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo and l.lincodigo = $codigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo and g.tpocodigo = 2 WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";
} else if ($_POST['table'] == "sbl") {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo and sbl.sblcodigo = $codigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo and g.tpocodigo = 2 WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";
} else if ($_POST['table']== "gru") {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo and g.grucodigo = $codigo and g.tpocodigo = 2 WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";
} else if ($_POST['table']== "sbg") {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo and sbg.sbgcodigo = $codigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo and g.tpocodigo = 2 WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";
} else if ($_POST['table']== "crs") {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo and c.crscodigo = $codigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo and g.tpocodigo = 2 WHERE s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";

} else {
    $sql = "SELECT s.sercodigo, s.sernombre, g.grunombre, sbl.sblnombre, sbg.sbgnombre, l.linnombre, c.crsnombre FROM btyservicio s INNER JOIN btycaracteristica c ON c.crscodigo = s.crscodigo INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON sbl.lincodigo = l.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON  g.grucodigo = sbg.grucodigo WHERE s.sernombre like '".$codigo."%' and s.sercodigo NOT IN (SELECT sercodigo FROM btyservicio_colaborador sec WHERE sec.clbcodigo = $col) ORDER BY s.sernombre";
   
}

include "../../cnx_data.php";
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
		echo "<tr>
				<td>".utf8_encode($row['sernombre'])."</td>
                <td>".utf8_encode($row['crsnombre'])."</td>
                <td>".utf8_encode($row['sblnombre'])."</td>
                <td>".utf8_encode($row['linnombre'])."</td>
				<td>".utf8_encode($row['sbgnombre'])."</td>
				<td>".utf8_encode($row['grunombre'])."</td>
				<td><input type='checkbox' name='ser[]' value='".$row['sercodigo']."'> </td>
			</tr>";
		
	}
} else {
    echo "<tr><td style='border: 0'><center> No hay resultados </center></td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td><td style='border: 0'></td></tr>";
}

?>
                </tbody>
                <tfoot>

                </tfoot>

                </table>

                               <?php  if ($total_paginas > 1) {
                        echo '<br><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1) {
                                echo '<li><a class="paginate" onclick="paginar_ser('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                            }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i) {
                                        //si muestro el índice de la página actual, no coloco enlace
                                        echo '<li class="active"><a onclick="paginar_ser('.$i.');">'.$i.'</a></li>';
                                    } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                                        //echo '<li hiddenn><a class="paginate" onclick="paginar_ser('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                                    } else {
                                        //si el índice no corresponde con la página mostrada actualmente,
                                        //coloco el enlace para ir a esa página
                                        echo '<li><a class="paginate" onclick="paginar_ser('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                                    }
                                }
                            if ($pageNum != $total_paginas) {
                                echo '<li><a class="paginate" onclick="paginar_ser('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';    
                            }
                       echo '</ul>';
                       echo '</div> </div></center> <br>';
                    }
$conn->close();





/*SELECT
  s.sercodigo,
  s.sernombre,
  g.grunombre,
  sbl.sblnombre,
  sbg.sbgnombre,
  l.linnombre,
  c.crsnombre
FROM
  btyservicio s
INNER JOIN
  btycaracteristica c ON c.crscodigo = s.crscodigo
INNER JOIN
  btysublinea sbl ON c.sblcodigo = sbl.sblcodigo
INNER JOIN
  btylinea l ON sbl.lincodigo = l.lincodigo
INNER JOIN
  btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo
INNER JOIN
  btygrupo g ON g.grucodigo = sbg.grucodigo
WHERE
  s.sernombre LIKE '%' AND s.sercodigo NOT IN(
  SELECT
    sercodigo
  FROM
    btyservicio_colaborador sec
  WHERE
    sec.clbcodigo = 1
)
UNION
SELECT
  s1.sercodigo,
  s1.sernombre,
  g1.grunombre,
  sbl1.sblnombre,
  sbg1.sbgnombre,
  l1.linnombre,
  c1.crsnombre
FROM
  btyservicio s1
INNER JOIN
  btycaracteristica c1 ON c1.crscodigo = s1.crscodigo
INNER JOIN
  btysublinea sbl1 ON c1.sblcodigo = sbl1.sblcodigo
INNER JOIN
  btylinea l1 ON sbl1.lincodigo = l1.lincodigo
INNER JOIN
  btysubgrupo sbg1 ON sbg1.sbgcodigo = l1.sbgcodigo
INNER JOIN
  btygrupo g1 ON g1.grucodigo = sbg1.grucodigo
WHERE
  s1.sernombre LIKE '%' AND s1.sercodigo IN(
  SELECT
    sercodigo
  FROM
    btyservicio_colaborador sec1
  WHERE
    sec1.clbcodigo = 1
)  
ORDER BY `sernombre` ASC*/