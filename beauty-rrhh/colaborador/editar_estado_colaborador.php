<?php 
	include '../../cnx_data.php';

	$id = $_POST['cod'];
	$fecha = $_POST['fecha'];
	$codigo = $_POST['cod_oculto'];

	$sql = mysqli_query($conn, "SELECT c.clecodigo, c.clbcodigo, b.trcrazonsocial, c.clefecha, c.cleobservaciones, c.cletipo, if(c.cleestado = 1, 'Activo', 'Inctivo') as estado FROM  btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento JOIN btyestado_colaborador c ON a.clbcodigo=c.clbcodigo WHERE c.clecodigo = $codigo ORDER BY c.clefecha DESC ");

	$array = array();

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'cod' 		=> $row->clbcodigo,
			'nom' 		=> $row->trcrazonsocial,
			'obs' 		=> $row->cleobservaciones,
			'fec' 		=> $row->clefecha,
			'tip' 		=> $row->cletipo,
			'est' 		=> $row->estado,
			'codigo'    => $row->clecodigo
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