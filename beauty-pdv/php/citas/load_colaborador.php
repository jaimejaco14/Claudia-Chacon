<?php 
	header( 'Content-Type: application/json');
	include("../../../cnx_data.php");

$QueryCol = mysqli_query($conn, "SELECT col.clbcodigo, ter.trcrazonsocial, col.trcdocumento FROM btycolaborador col JOIN btytercero ter ON col.trcdocumento=ter.trcdocumento WHERE col.clbestado = 1 AND ter.trcrazonsocial LIKE '%".$_GET['q']."%' OR ter.trcdocumento LIKE '%".$_GET['q']."%' LIMIT 10 ");


	$data = array();
		while ( $row = $QueryCol->fetch_assoc()){
			$data[] = $row;
		}



	function utf8_converter($array){
		array_walk_recursive($array, function(&$item, $key){
			if(!mb_detect_encoding($item, 'utf-8', true)){
				$item = utf8_encode($item);
			}
		});

		return $array;
	}

	$array= utf8_converter($data);

	echo json_encode($array);
 ?>