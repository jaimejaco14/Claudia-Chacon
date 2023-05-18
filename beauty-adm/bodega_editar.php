<?php 
	header("Content-type: application/json");
	include '../cnx_data.php';

	$id 	= $_POST['id'];
	$array 	= array();
	$sql = mysqli_query($conn, "SELECT * FROM btybodega WHERE bodcodigo = $id");

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'id' 		=>$row->bodcodigo,
			'nom' 		=>$row->bodnombre,
			'ali' 		=>$row->bodalias,
			'est' 		=>$row->bodestado   
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


 ?>