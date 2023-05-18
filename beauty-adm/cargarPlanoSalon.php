<?php 
	header("Content-Type/Application-Json");
	include '../cnx_data.php';


	$QueryPlano = mysqli_query($conn, "SELECT a.slnnombre, a.slnimagen FROM btysalon a WHERE a.slncodigo = '".$_POST['codSalon']."' ");

	$fetchRow = mysqli_fetch_object($QueryPlano);

	$RowsImg = array();

	$RowsImg[] = array('nombre' => $fetchRow->slnnombre, 'imagen' => $fetchRow->slnimagen);


	function utf8_converter($array){
		array_walk_recursive($array, function(&$item, $key){
			if(!mb_detect_encoding($item, 'utf-8', true)){
				$item = utf8_encode($item);
			}
		});

		return $array;
	}

	$RowsImg= utf8_converter($RowsImg);

	echo json_encode($RowsImg);

	mysqli_close($conn);
 ?>