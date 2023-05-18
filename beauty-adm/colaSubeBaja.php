<?php 
	
	include '../cnx_data.php';

		$salon              = $_REQUEST["salon"];
		$codColaborador     = $_REQUEST["codColaborador"];
		$ultimaPosicion     = $_REQUEST["ultimaPosicion"];
		$arrayColaboradores = array();
		$resultQuery        = $conn->query("SELECT clbcodigo, colposicion, colhorasalida FROM btycola_atencion WHERE (slncodigo = $salon) AND (clbcodigo <> $codColaborador) AND colposicion > $ultimaPosicion AND tuafechai = CURDATE() AND colhorasalida IS NULL ORDER BY colposicion");

		while($registros = $resultQuery->fetch_array()){

			$arrayColaboradores[] = array(
										"codigo"   => $registros["clbcodigo"],
										"posicion" => $registros["colposicion"] - 1);
		}

		$conteo = $conn->query("SELECT count(*) AS maximo_val FROM btycola_atencion WHERE tuafechai = CURDATE()");

		while ($max = $conteo->fetch_assoc()) {
			$res = $max['maximo_val'];
		}

		$conn->query("UPDATE btycola_atencion SET colposicion = $res WHERE clbcodigo = $codColaborador AND tuafechai = CURDATE() AND colhorasalida IS NULL");

		if(mysqli_affected_rows($conn) > 0){

			foreach($arrayColaboradores as $colaborador){

				$conn->query("UPDATE btycola_atencion SET colposicion = ".$colaborador["posicion"]." WHERE clbcodigo = ".$colaborador["codigo"]." AND tuafechai = CURDATE() AND colhorasalida IS NULL");
			}
		}
		else{

			echo json_encode(array("result" => "error"));
		}

	mysqli_close($conn);
?>