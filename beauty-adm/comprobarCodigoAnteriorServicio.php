<?php 
	include '../cnx_data.php';
	
	$codigoAnterior = $_REQUEST["codigoAnterior"];
	$queryCogidoAnterior = "SELECT * FROM btyservicio WHERE sercodigoanterior = $codigoAnterior";
	$resultQuery = $conn->query($queryCogidoAnterior);

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) == 0){

			echo json_encode(array("result" => "vacio"));
		}
		else{

			echo json_encode(array("result" => "full"));	
		}
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>