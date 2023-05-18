<?php
	header("content-type: application/json");
	//include 'conexion.php';


	$sql = mysqli_query($conn, "SELECT DISTINCT CONCAT (s.slnnombre,' ', t.trnnombre) title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, IF(tpr.tprnombre = 'DESCANSO', '#ff1000', '#00ff80') as backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno t 
ON t.trncodigo = p.trncodigo INNER JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo INNER JOIN btysalon s on s.slncodigo = ts.slncodigo INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = 18 INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento
JOIN btytipo_programacion tpr ON p.tprcodigo=tpr.tprcodigo");

	$array = array();

	if (mysqli_num_rows($sql) > 0) {
		while ($row = mysqli_fetch_object($sql)) {
		
	      	$array[] = array(
	      		'title' 			=> $row->title,
	      		'start' 			=> $row->start,
	      		'end'   			=> $row->end,
	      		'backgroundColor'	=> $row->backgroundColor
	      	);
	    }


	}

	function utf8_converter($array){
		array_walk_recursive($array, function(&$item, $key){
			if(!mb_detect_encoding($item, 'utf-8', true)){
				$item = utf8_encode($item);
			}
		});

		return $array;
	}

	$array= utf8_converter($array);

	echo json_encode($array);

?>