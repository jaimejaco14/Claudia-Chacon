<?php 

include("../../../cnx_data.php");

$idcol = $_POST['id'];
$html="";
$id_salon = $_POST['id_salon'];
$sql = "SELECT t.trcdocumento, t.trcrazonsocial, car.crgnombre, tp.tprnombre, c.clbcodigo, p.tprcodigo, p.slncodigo, pt.ptrnombre, p.prgfecha, sal.slnnombre FROM  btyprogramacion_colaboradores p INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btycargo car ON c.crgcodigo = car.crgcodigo INNER JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo INNER JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btysalon sal ON sal.slncodigo=p.slncodigo WHERE c.clbcodigo = $idcol AND p.slncodigo = $id_salon ";

$query_num_col = $sql;
 
$result = $conn->query($query_num_col);
$num_total_registros = $result->num_rows;

$rowsPerPage = 3;
$pageNum = 1;

if(isset($_POST['page'])) {
   $pageNum = $_POST['page'];
}
  
$offset = ($pageNum - 1) * $rowsPerPage;
$total_paginas = ceil($num_total_registros / $rowsPerPage);
$sql = $sql." ORDER BY p.prgfecha DESC limit $offset, $rowsPerPage";
$result = $conn->query($sql);

  

if ($result->num_rows > 0) {
	$html.='
		<table class="table table-hover table-bordered" style="width: 100%;">
			<thead>
				<tr class="success">
					<th>Colaborador</th>
					<th>Cargo</th>
					<th>Tipo</th>
					<th>Puesto</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
	';

    while ($row = $result->fetch_assoc()) {     
       $html.='
			<input type="hidden" id="codigo_col" value="'.$row['clbcodigo'].'">
			<input type="hidden" id="codigo_sal" value="'.$row['slncodigo'].'">
				<tr>
					<td>'.utf8_encode($row['trcrazonsocial']).'</td>
					<td>'.utf8_encode($row['crgnombre']).'</td>';
					if ($row['tprnombre'] == 'LABORA') {
						$html.='
							<td><span class="label label-info">LABORA</span></td>
						';
					}else{
						if ($row['tprnombre'] == 'PERMISO') {
							$html.='
							   <td><span class="label label-success">'.$row['tprnombre'].'</span></td>
						    ';
						}else{
							if ($row['tprnombre'] == 'CITA MEDICA') {
									$html.='
							   			<td><span class="label label-warning">'.$row['tprnombre'].'</span></td>
						    		';
							}else{

								if ($row['tprnombre'] == 'DESCANSO') {
									$html.='
							   			<td><span class="label label-danger">'.$row['tprnombre'].'</span></td>
						    		';
								}else{
									if ($row['tprnombre'] == 'INCAPACIDAD') {
									$html.='
							   			<td><span class="label label-red">'.$row['tprnombre'].'</span></td>
						    		';
								}else{
									$html.='
							   			<td><span class="label label-info">'.$row['tprnombre'].'</span></td>
						    		';
									
								}
									
								}

							}
						}
					}

					/*$html.='
							<td><span class="label label-primary">'.$row['tprnombre'].'</span></td>
						';*/

					$html.='
					<td>'.utf8_encode($row['ptrnombre']).'</td>
					<td>'.$row['prgfecha'].'</td>
				</tr>
       ';      
    }
    $html.='
		</tbody>
		</table>
    ';

}else{
  $html.='
		<table class="table table-hover table-bordered" style="width: 100%;">
			<thead>
				<tr class="success">
					<th>Colaborador</th>
					<th>Cargo</th>
					<th>Tipo</th>
					<th>Puesto</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5"><center><b>No tiene programación asignada.</b></center></td>
				</tr>
			</tbody>
		</table>
	';
}
    echo $html;
include "paginate_prog.php";
mysqli_close($conn);
?>
