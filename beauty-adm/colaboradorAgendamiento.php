<?php 
	include '../cnx_data.php';

	$salon    = $_REQUEST["salon"];
	$servicio = $_REQUEST["servicio"];

	//Query para la obtención de colaboradores que pueden realizar el servicio seleccionado previamente
	//filtrando por salon al que pertenezca el colaborador, y servicios que pueden realizar
	/*$query    = "SELECT CONCAT(Tercero.trcnombres,' ',Tercero.trcapellidos) AS nombreColaborador,
						Colaborador.clbcodigo AS codigoColaborador
				 FROM btyservicio_colaborador ServicioColaborador 
				 INNER JOIN btycolaborador Colaborador 
				 	ON ServicioColaborador.clbcodigo = Colaborador.clbcodigo 
				 INNER JOIN btytercero Tercero 
				 	ON Tercero.trcdocumento = Colaborador.trcdocumento 
				 INNER JOIN btyservicio Servicio 
				 	ON Servicio.sercodigo = ServicioColaborador.sercodigo
				 WHERE (Servicio.sercodigo = $servicio) AND (Colaborador.clbestado = 1)";*/
	$query = "SELECT DISTINCT(colaborador.clbcodigo) AS codigoColaborador, 
				CONCAT(tercero.trcnombres,' ',tercero.trcapellidos) AS nombreColaborador 
				FROM btycolaborador colaborador INNER JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento 
				INNER JOIN btyprogramacion_colaboradores progcolaborador ON progcolaborador.clbcodigo = colaborador.clbcodigo 
				INNER JOIN btyturno_salon tursalon ON tursalon.trncodigo = progcolaborador.trncodigo 
				LEFT JOIN btyservicio_colaborador sercolaborador ON sercolaborador.clbcodigo = colaborador.clbcodigo 
				WHERE tursalon.slncodigo = '$salon' AND sercolaborador.sercodigo = '$servicio'";

	$resultadoQuery = $conn->query($query);

	if($resultadoQuery != false){

		if(mysqli_num_rows($resultadoQuery) > 0){
			
			$colaboradores = array();

			while($registros = $resultadoQuery->fetch_array()){

				$colaboradores[] = array(
									"codigoColaborador" => $registros["codigoColaborador"],
									"nombreColaborador" => $registros["nombreColaborador"]
									);
			}

			echo json_encode(array("result" => "full", "data" => $colaboradores));
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	$conn->close();
?>