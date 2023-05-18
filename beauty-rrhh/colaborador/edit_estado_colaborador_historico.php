<?php 
	header("Content-type: application/json");
	include '../../cnx_data.php';

	$id = $_POST['id'];
	$array = array();

	$sql = mysqli_query($conn, "SELECT c.clbcodigo, b.trcrazonsocial, c.clefecha, c.cleobservaciones, c.cletipo FROM  btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento JOIN btyestado_colaborador c ON a.clbcodigo=c.clbcodigo WHERE c.clbcodigo = $id ORDER BY c.clefecha DESC");

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'cod' => $row->clbcodigo,
			'fec' => $row->clefecha,
			'obs' => $row->cleobservaciones,
			'tip' => $row->cletipo
		);
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

	mysqli_close($conn);
 ?>