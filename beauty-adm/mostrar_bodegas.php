<?php
	header("content-type: application/json"); 
	include '../cnx_data.php';

	$codigo_bodega = $_POST['cod'];
	$array = array();
	$sql = mysqli_query($conn, "SELECT * FROM btybodega WHERE bodcodigo = $codigo_bodega");

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'cod_bodega' => $row->bodcodigo,
			'nom_bodega' => $row->bodnombre,
			'ali_bodega' => $row->bodalias,
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