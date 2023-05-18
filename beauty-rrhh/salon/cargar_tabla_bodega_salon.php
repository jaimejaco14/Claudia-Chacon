<?php 
	header("Content-type: application/json");
	include '../../cnx_data.php';

	$id 	= $_POST['id'];
	$array 	= array();
	$sql = mysqli_query($conn, "SELECT a.bodcodigo, c.slnnombre, a.slncodigo, a.bostipo, b.bodnombre FROM btybodega b JOIN btybodega_salon a
ON a.bodcodigo=b.bodcodigo JOIN btysalon c ON a.slncodigo=c.slncodigo WHERE a.slncodigo = $id AND b.bodestado = 1");

	if (mysqli_num_rows($sql) > 0) {
		

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'cod_bod' => $row->bodcodigo,
			'salon'   => $row->slnnombre,
			'cod_sal' => $row->slncodigo,
			'tipo'    => $row->bostipo,
			'nom_bod' => $row->bodnombre
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

  	}else{
  		$array[] = array('info' => 'No hay bodegas asignadas a este salón');
  		echo json_encode($array);
  	}

	mysqli_close($conn);
 ?>