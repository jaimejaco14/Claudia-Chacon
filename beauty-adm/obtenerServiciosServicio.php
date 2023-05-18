<?php 
	
include '../cnx_data.php';

$queryServicios = "SELECT sercodigo,
						sernombre,
						serduracion
					FROM btyservicio
					WHERE serstado = 1
					ORDER BY sernombre";

$resultadoQueryServicios = $conn->query($queryServicios);

if(mysqli_num_rows($resultadoQueryServicios) > 0){

	if($resultadoQueryServicios != false){

		$servicios = array();

		while($registros = $resultadoQueryServicios->fetch_array()){

			$servicios[] = array(
				"codigo"   => $registros["sercodigo"],
				"nombre"   => $registros["sernombre"],
				"duracion" => $registros["serduracion"]);
		}

		echo json_encode(array("result" => "error", "servicios" => $servicios));
	}

	echo json_encode(array("result" => "error"));
}
else{

	echo json_encode(array("result" => "error"));
}
	
mysqli_close($conn);
?>