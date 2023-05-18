<?php 

include("../../../cnx_data.php");

$grupo		   	= $_POST['grupo'];
$subgrupo  		= $_POST["subgrupo"];
$linea 			= $_POST['linea'];
$sublinea 		= $_POST['sublinea'];
$caract 		= $_POST['carac'];
$html="";

$sql="SELECT ser.sercodigo, ser.sernombre FROM btyservicio ser JOIN btycaracteristica car ON ser.crscodigo=car.crscodigo JOIN btysublinea subl 
ON subl.sblcodigo=car.sblcodigo JOIN btylinea lin ON lin.lincodigo=subl.lincodigo JOIN btysubgrupo sg ON sg.sbgcodigo=lin.sbgcodigo JOIN btygrupo gru ON gru.grucodigo=sg.grucodigo ";

//WHERE gru.grucodigo = $grupo AND sg.sbgcodigo = $subgrupo AND lin.lincodigo = $linea AND subl.sblcodigo = $sublinea AND car.crscodigo = $caract

if ($subgrupo == "") {
    $sql = $sql . " WHERE gru.grucodigo = $grupo";
	$query_num_col = $sql; 
    $result = $conn->query($query_num_col);
}else{
	if ($linea == "") {
		$sql = $sql . " WHERE sg.sbgcodigo = $subgrupo";
	    $query_num_col = $sql; 
        $result = $conn->query($query_num_col);
	}else{
		if ($sublinea == "") {
			$sql = $sql . " WHERE lin.lincodigo = $linea";
	    	$query_num_col = $sql; 
        	$result = $conn->query($query_num_col);
		}else{
			if ($caract == "") {
				$sql = $sql . " WHERE subl.sblcodigo = $sublinea";
	    		$query_num_col = $sql; 
        		$result = $conn->query($query_num_col);
			}else{
				$sql = $sql . " WHERE car.crscodigo = $caract";
	    		$query_num_col = $sql; 
        		$result = $conn->query($query_num_col);
			}
		}
	}
}


$num_total_registros = $result->num_rows;

$rowsPerPage = 2;
$pageNum = 1;

if(isset($_POST['page'])) {
   $pageNum = $_POST['page'];
}
  
$offset = ($pageNum - 1) * $rowsPerPage;
$total_paginas = ceil($num_total_registros / $rowsPerPage);
$sql = $sql." ORDER BY ser.sernombre DESC limit $offset, $rowsPerPage";
$result = $conn->query($sql);

  

if ($result->num_rows > 0) {
	$html.='
		<table class="table table-hover table-bordered" style="width: 100%;">
			<thead>
				<tr class="success">
					<th>Servicio</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
	';

    while ($row = $result->fetch_assoc()) {     
       $html.='
			
				<tr>
					<td>'.utf8_encode($row['sernombre']).'</td>
					<td><center><button type="button" id="btn_add_servicio" data-idcod="'.$row['sercodigo'].'" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button></center></td>
				</tr>
       ';      
    }
    $html.='
		</tbody>
		</table>
    ';

    echo $html;
}else{
  print ".";
}
include "paginate.php";
mysqli_close($conn);
?>
