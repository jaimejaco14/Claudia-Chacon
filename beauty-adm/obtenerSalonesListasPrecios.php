<?php 
	
	include '../cnx_data.php';

	$query       = "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
	$resultQuery = $conn->query($query);

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) > 0){

			$salones = array();

			while($registros = $resultQuery->fetch_array()){

				$salones[] = array("codigo" => $registros["slncodigo"], "nombre" => $registros["slnnombre"]);
			}

			echo json_encode(array("result" => "full", "salones" => $salones));
		}
		else{

			echo json_encode(array("result" => "vacio"));
		}
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>